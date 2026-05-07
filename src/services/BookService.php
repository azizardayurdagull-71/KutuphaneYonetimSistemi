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
     * Tüm kitapları getirir (Kategori filtresi eklendi)
     */
    public function getAllBooks($category = null) {
        try {
            if ($category && $category !== '') {
                $query = "SELECT * FROM books WHERE category = :category ORDER BY id DESC";
                $stmt = $this->db->prepare($query);
                $stmt->execute([':category' => $category]);
            } else {
                $query = "SELECT * FROM books ORDER BY id DESC";
                $stmt = $this->db->prepare($query);
                $stmt->execute();
            }
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Kitap listesi yüklenemedi: " . $e->getMessage());
        }
    }

    /**
     * GELİŞMİŞ ARAMA: ISBN, Kategori ve ALFABETİK SIRALAMA dahil tüm filtreleri kapsar
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
            if (!empty($filters['category'])) {
                $query .= " AND category = :category";
                $params[':category'] = $filters['category'];
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

            // --- ALFABETİK SIRALAMA MANTIĞI ---
            if (!empty($filters['sort'])) {
                if ($filters['sort'] === 'title_asc') {
                    $query .= " ORDER BY title ASC";
                } elseif ($filters['sort'] === 'title_desc') {
                    $query .= " ORDER BY title DESC";
                } elseif ($filters['sort'] === 'author_asc') {
                    $query .= " ORDER BY author ASC";
                } else {
                    $query .= " ORDER BY id DESC";
                }
            } else {
                $query .= " ORDER BY id DESC"; // Varsayılan olarak en yeniler
            }

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
     * Kitap Ekleme (Kategori Desteğiyle)
     */
    public function addBook($title, $author, $isbn, $year, $genre, $shelf, $stock, $image, $category = 'Genel') {
        try {
            $query = "INSERT INTO books (title, author, isbn, publish_year, genre, shelf_location, stock, cover_image, category) 
                      VALUES (:title, :author, :isbn, :publish_year, :genre, :shelf_location, :stock, :cover_image, :category)";
            $stmt = $this->db->prepare($query);
            return $stmt->execute([
                ':title' => $title, 
                ':author' => $author, 
                ':isbn' => $isbn,
                ':publish_year' => $year, 
                ':genre' => $genre, 
                ':shelf_location' => $shelf, 
                ':stock' => $stock, 
                ':cover_image' => $image,
                ':category' => $category
            ]);
        } catch (PDOException $e) {
            throw new Exception("Kitap eklenirken hata: " . $e->getMessage());
        }
    }

    /**
     * Kitap Güncelleme (Kategori Desteğiyle)
     */
    public function updateBook($id, $title, $author, $isbn, $year, $genre, $shelf, $stock, $image = null, $category = 'Genel') {
        try {
            $query = "UPDATE books SET title=:title, author=:author, isbn=:isbn, publish_year=:publish_year, 
                      genre=:genre, category=:category, shelf_location=:shelf_location, stock=:stock";
            
            if($image) { $query .= ", cover_image=:cover_image"; }
            $query .= " WHERE id=:id";

            $stmt = $this->db->prepare($query);
            $params = [
                ':id' => $id, 
                ':title' => $title, 
                ':author' => $author, 
                ':isbn' => $isbn,
                ':publish_year' => $year, 
                ':genre' => $genre, 
                ':category' => $category,
                ':shelf_location' => $shelf, 
                ':stock' => $stock
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
     * Hızlı Stok Güncelleme
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