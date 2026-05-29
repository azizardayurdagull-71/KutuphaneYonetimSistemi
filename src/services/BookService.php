<?php
// src/services/BookService.php
require_once __DIR__ . '/../core/Database.php';

class BookService {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    /**
     * Tüm kitapları getirir
     */
    public function getAllBooks() {
        try {
            $query = "SELECT * FROM books ORDER BY id DESC";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Kitap listesi yüklenemedi: " . $e->getMessage());
        }
    }

    /**
     * GELİŞMİŞ ARAMA: ISBN (Barkod) dahil tüm filtreleri kapsar
     */
    public function searchBooks($filters = []) {
        try {
            $query = "SELECT * FROM books WHERE 1=1";
            $params = [];

            if (!empty($filters['title'])) {
                $query .= " AND title LIKE :title";
                $params[':title'] = '%' . $filters['title'] . '%';
            }
            if (!empty($filters['author'])) {
                $query .= " AND author LIKE :author";
                $params[':author'] = '%' . $filters['author'] . '%';
            }
            if (!empty($filters['genre'])) {
                $query .= " AND genre LIKE :genre";
                $params[':genre'] = '%' . $filters['genre'] . '%';
            }
            if (!empty($filters['isbn'])) {
                $query .= " AND isbn = :isbn";
                $params[':isbn'] = $filters['isbn'];
            }
            if (!empty($filters['status'])) {
                if ($filters['status'] === 'available') {
                    $query .= " AND stock > 0";
                } elseif ($filters['status'] === 'borrowed') {
                    $query .= " AND stock <= 0";
                }
            }

            $query .= " ORDER BY id DESC";
            $stmt = $this->db->prepare($query);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Arama işlemi başarısız: " . $e->getMessage());
        }
    }

    /**
     * Kitap Detaylarını Getirir
     */
    public function getBookById($id) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM books WHERE id = :id");
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Kitap bilgisi alınamadı: " . $e->getMessage());
        }
    }

    /**
     * Kitap Ekleme (ISBN/Barkod Desteğiyle)
     */
    public function addBook($title, $author, $isbn, $year, $genre, $shelf, $stock, $image) {
        try {
            $query = "INSERT INTO books (title, author, isbn, publish_year, genre, shelf_location, stock, cover_image) 
                      VALUES (:title, :author, :isbn, :publish_year, :genre, :shelf_location, :stock, :cover_image)";
            $stmt = $this->db->prepare($query);
            return $stmt->execute([
                ':title' => $title, ':author' => $author, ':isbn' => $isbn,
                ':publish_year' => $year, ':genre' => $genre, 
                ':shelf_location' => $shelf, ':stock' => $stock, ':cover_image' => $image
            ]);
        } catch (PDOException $e) {
            throw new Exception("Kitap eklenirken hata: " . $e->getMessage());
        }
    }

    /**
     * Kitap Güncelleme
     */
    public function updateBook($id, $title, $author, $isbn, $year, $genre, $shelf, $stock, $image = null) {
        try {
            $query = "UPDATE books SET title=:title, author=:author, isbn=:isbn, publish_year=:publish_year, 
                      genre=:genre, shelf_location=:shelf_location, stock=:stock";
            
            if($image) { $query .= ", cover_image=:cover_image"; }
            $query .= " WHERE id=:id";

            $stmt = $this->db->prepare($query);
            $params = [
                ':id' => $id, ':title' => $title, ':author' => $author, ':isbn' => $isbn,
                ':publish_year' => $year, ':genre' => $genre, 
                ':shelf_location' => $shelf, ':stock' => $stock
            ];
            if($image) { $params[':cover_image'] = $image; }

            return $stmt->execute($params);
        } catch (PDOException $e) {
            throw new Exception("Güncelleme hatası: " . $e->getMessage());
        }
    }

    /**
     * Kitap Silme
     */
    public function deleteBook($id) {
        try {
            $query = "DELETE FROM books WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Silme hatası: " . $e->getMessage());
        }
    }

    /**
     * Hızlı Stok Güncelleme (Ödünç Alma/İade için yardımcı)
     */
    public function updateStock($bookId, $amount) {
        try {
            $query = "UPDATE books SET stock = stock + :amount WHERE id = :id";
            $stmt = $this->db->prepare($query);
            return $stmt->execute([':amount' => $amount, ':id' => $bookId]);
        } catch (PDOException $e) {
            throw new Exception("Stok güncellenemedi: " . $e->getMessage());
        }
    }
}
?>