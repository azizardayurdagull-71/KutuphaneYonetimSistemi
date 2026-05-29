<?php
// src/services/ReportService.php
require_once __DIR__ . '/../core/Database.php';

class ReportService {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    /**
     * Genel Sistem İstatistiklerini Getirir
     */
    public function getGeneralStats() {
        try {
            $stats = [];
            
            // Toplam Kitap Sayısı
            $stmt = $this->db->query("SELECT COUNT(*) as total FROM books");
            $stats['total_books'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

            // Toplam Öğrenci/Kullanıcı Sayısı
            $stmt = $this->db->query("SELECT COUNT(*) as total FROM users WHERE role = 'student'");
            $stats['total_students'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

            // Tüm Zamanların Toplam Ödünç İşlemi
            $stmt = $this->db->query("SELECT COUNT(*) as total FROM borrowings");
            $stats['total_borrowings'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

            // Gecikme Oranı Hesaplama (Aktif ödünçlerdeki gecikme yüzdesi)
            $stmt = $this->db->query("SELECT COUNT(*) as total FROM borrowings WHERE status = 'borrowed'");
            $active_borrowings = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
            
            $stmt = $this->db->query("SELECT COUNT(*) as total FROM borrowings WHERE status = 'borrowed' AND due_date < NOW()");
            $overdue_borrowings = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

            $stats['active_borrowings'] = $active_borrowings;
            $stats['overdue_borrowings'] = $overdue_borrowings;
            
            // Yüzde hesaplama (Sıfıra bölünme hatasını engellemek için kontrol)
            $stats['overdue_rate'] = $active_borrowings > 0 ? round(($overdue_borrowings / $active_borrowings) * 100, 1) : 0;

            return $stats;
        } catch (PDOException $e) {
            throw new Exception("İstatistikler alınırken hata oluştu: " . $e->getMessage());
        }
    }

    /**
     * En Çok Okunan Kitapları Getirir
     */
    public function getMostReadBooks() {
        try {
            $query = "SELECT bk.title, COUNT(b.id) as read_count 
                      FROM borrowings b 
                      JOIN books bk ON b.book_id = bk.id 
                      GROUP BY bk.title 
                      ORDER BY read_count DESC LIMIT 5";
            return $this->db->query($query)->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("En çok okunanlar alınamadı: " . $e->getMessage());
        }
    }

    /**
     * En Aktif Kullanıcıları Getirir
     */
    public function getMostActiveUsers() {
        try {
            $query = "SELECT u.username, COUNT(b.id) as borrow_count 
                      FROM borrowings b 
                      JOIN users u ON b.user_id = u.id 
                      GROUP BY u.username 
                      ORDER BY borrow_count DESC LIMIT 5";
            return $this->db->query($query)->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Aktif kullanıcılar alınamadı: " . $e->getMessage());
        }
    }
}
?>