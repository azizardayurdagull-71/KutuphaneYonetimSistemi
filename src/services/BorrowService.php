<?php
// src/services/BorrowService.php
require_once __DIR__ . '/../core/Database.php';

class BorrowService {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function borrowBook($userId, $bookId) {
        try {
            $this->db->beginTransaction();

            // --- ADMİN KONTROLÜ (YENİ) ---
            // İşleme başlamadan önce kullanıcının rolünü kontrol ediyoruz
            $userStmt = $this->db->prepare("SELECT role FROM users WHERE id = :user_id");
            $userStmt->execute([':user_id' => $userId]);
            $user = $userStmt->fetch(PDO::FETCH_ASSOC);

            if ($user && $user['role'] === 'admin') {
                throw new Exception("Sistem yöneticileri kitap ödünç alamaz!");
            }
            // ----------------------------

            $checkQuery = "SELECT id FROM borrowings WHERE user_id = :user_id AND book_id = :book_id AND status = 'borrowed'";
            $checkStmt = $this->db->prepare($checkQuery);
            $checkStmt->execute([':user_id' => $userId, ':book_id' => $bookId]);
            
            if ($checkStmt->rowCount() > 0) {
                throw new Exception("Bu kitabı zaten ödünç aldınız ve henüz iade etmediniz.");
            }

            $stmt = $this->db->prepare("SELECT stock FROM books WHERE id = :book_id");
            $stmt->execute([':book_id' => $bookId]);
            $book = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$book || $book['stock'] <= 0) {
                throw new Exception("Bu kitap şu an stokta yok!");
            }

            $insertQuery = "INSERT INTO borrowings (user_id, book_id, borrow_date, due_date, status) 
                            VALUES (:user_id, :book_id, NOW(), DATE_ADD(NOW(), INTERVAL 14 DAY), 'borrowed')";
            $insertStmt = $this->db->prepare($insertQuery);
            $insertStmt->execute([':user_id' => $userId, ':book_id' => $bookId]);

            $updateQuery = "UPDATE books SET stock = stock - 1 WHERE id = :book_id";
            $updateStmt = $this->db->prepare($updateQuery);
            $updateStmt->execute([':book_id' => $bookId]);

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw new Exception("Ödünç alma işlemi başarısız: " . $e->getMessage());
        }
    }

    public function returnBook($borrowId, $userId) {
        try {
            $this->db->beginTransaction();

            $stmt = $this->db->prepare("SELECT book_id FROM borrowings WHERE id = :id AND user_id = :user_id AND status = 'borrowed'");
            $stmt->execute([':id' => $borrowId, ':user_id' => $userId]);
            $borrow = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$borrow) {
                throw new Exception("Geçerli bir ödünç kaydı bulunamadı.");
            }

            $bookId = $borrow['book_id'];

            $updateBorrow = "UPDATE borrowings SET status = 'returned', return_date = NOW() WHERE id = :id";
            $stmt1 = $this->db->prepare($updateBorrow);
            $stmt1->execute([':id' => $borrowId]);

            $updateBook = "UPDATE books SET stock = stock + 1 WHERE id = :book_id";
            $stmt2 = $this->db->prepare($updateBook);
            $stmt2->execute([':book_id' => $bookId]);

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw new Exception("İade işlemi başarısız: " . $e->getMessage());
        }
    }

    public function getBorrowingsByUser($userId) {
        $query = "SELECT b.id as borrow_id, b.borrow_date, b.due_date, b.return_date, b.status, 
                         bk.title, bk.author, bk.cover_image,
                         DATEDIFF(NOW(), b.due_date) as delay_days
                  FROM borrowings b
                  JOIN books bk ON b.book_id = bk.id
                  WHERE b.user_id = :user_id
                  ORDER BY b.status ASC, b.borrow_date DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllOverdueBooks() {
        $query = "SELECT b.id as borrow_id, b.borrow_date, b.due_date, u.username, u.email, bk.title,
                         DATEDIFF(NOW(), b.due_date) as delay_days
                  FROM borrowings b
                  JOIN users u ON b.user_id = u.id
                  JOIN books bk ON b.book_id = bk.id
                  WHERE b.status = 'borrowed' AND b.due_date < NOW()
                  ORDER BY delay_days DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Kullanıcı için uygulama içi bildirimleri (Yaklaşan/Geciken) hesaplayan metot (YENİ)
     */
    public function getUserNotifications($userId) {
        $query = "SELECT bk.title, 
                         DATEDIFF(b.due_date, NOW()) as days_left, 
                         DATEDIFF(NOW(), b.due_date) as delay_days
                  FROM borrowings b
                  JOIN books bk ON b.book_id = bk.id
                  WHERE b.user_id = :user_id AND b.status = 'borrowed'";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':user_id' => $userId]);
        $borrowings = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $notifications = [];
        foreach ($borrowings as $b) {
            if ($b['delay_days'] > 0) {
                // Gecikmiş kitap bildirimi (Kırmızı)
                $notifications[] = [
                    'type' => 'danger',
                    'icon' => '🚨',
                    'message' => "<strong>Gecikme:</strong> '{$b['title']}' adlı kitabın teslim tarihi {$b['delay_days']} gün geçti! Lütfen hemen iade edin."
                ];
            } elseif ($b['days_left'] >= 0 && $b['days_left'] <= 2) {
                // Teslime 2 gün veya daha az kalmış kitap bildirimi (Sarı)
                $notifications[] = [
                    'type' => 'warning',
                    'icon' => '⏰',
                    'message' => "<strong>Yaklaşan Teslimat:</strong> '{$b['title']}' adlı kitabın teslimine son {$b['days_left']} gün kaldı."
                ];
            }
        }
        return $notifications;
    }
    
    public function getAllBorrowings() {
        try {
            // WHERE u.role != 'admin' ekleyerek adminleri listeden çıkardık
            $query = "SELECT b.*, u.username, bk.title as book_title 
                      FROM borrowings b 
                      JOIN users u ON b.user_id = u.id 
                      JOIN books bk ON b.book_id = bk.id 
                      WHERE u.role != 'admin'
                      ORDER BY b.borrow_date DESC";
                      
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Ödünç kayıtları alınamadı: " . $e->getMessage());
        }
    }
}
?>