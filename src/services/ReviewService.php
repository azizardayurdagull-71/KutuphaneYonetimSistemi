<?php
/**
 * src/services/ReviewService.php
 * Yorum ve Değerlendirme Sistemi - Gelişmiş Servis Katmanı
 */
require_once __DIR__ . '/../core/Database.php';

class ReviewService {
    private $db;

    /**
     * Veritabanı bağlantısını başlatır
     */
    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    /**
     * Sisteme yeni bir yorum ve puan ekler
     */
    public function addReview($bookId, $userId, $rating, $comment) {
        try {
            $query = "INSERT INTO reviews (book_id, user_id, rating, comment) VALUES (:bid, :uid, :rate, :com)";
            $stmt = $this->db->prepare($query);
            return $stmt->execute([
                ':bid'  => $bookId,
                ':uid'  => $userId,
                ':rate' => $rating,
                ':com'  => $comment
            ]);
        } catch (PDOException $e) {
            throw new Exception("Yorum ekleme sırasında veritabanı hatası oluştu: " . $e->getMessage());
        }
    }

    /**
     * Belirli bir kitaba ait tüm yorumları kullanıcı adlarıyla birlikte getirir
     */
    public function getBookReviews($bookId) {
        try {
            $query = "SELECT r.*, u.username FROM reviews r 
                      JOIN users u ON r.user_id = u.id 
                      WHERE r.book_id = :bid 
                      ORDER BY r.created_at DESC";
            $stmt = $this->db->prepare($query);
            $stmt->execute([':bid' => $bookId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Yorumlar getirilirken hata oluştu.");
        }
    }

    /**
     * Kitabın ortalama yıldız puanını ve toplam yorum sayısını hesaplar
     */
    public function getBookAverageRating($bookId) {
        try {
            $query = "SELECT AVG(rating) as avg_rating, COUNT(*) as total_reviews FROM reviews WHERE book_id = :bid";
            $stmt = $this->db->prepare($query);
            $stmt->execute([':bid' => $bookId]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return [
                'average' => $result['avg_rating'] ? number_format($result['avg_rating'], 1) : "0.0",
                'total' => $result['total_reviews']
            ];
        } catch (PDOException $e) {
            return ['average' => "0.0", 'total' => 0];
        }
    }

    /**
     * KRİTİK: Tek bir yorumun tüm detaylarını getirir (Güvenlik kontrolleri için)
     * Az önce aldığın hatanın çözümü bu fonksiyondur.
     */
    public function getReviewById($reviewId) {
        try {
            $query = "SELECT * FROM reviews WHERE id = :rid";
            $stmt = $this->db->prepare($query);
            $stmt->execute([':rid' => $reviewId]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Belirtilen yorumu veritabanından tamamen siler
     */
    public function deleteReview($reviewId) {
        try {
            $query = "DELETE FROM reviews WHERE id = :rid";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':rid', $reviewId, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Yorum silinemedi, teknik bir sorun oluştu.");
        }
    }
}
?>