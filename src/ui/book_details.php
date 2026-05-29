<?php
/**
 * src/ui/book_details.php
 * Kitap Detayları, Gelişmiş Yorum Sistemi ve Kullanıcı/Admin Moderasyonu
 */
session_start();
require_once 'header.php';
require_once '../services/BookService.php';
require_once '../services/ReviewService.php';

// Oturum ve Parametre Kontrolü
if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    header("Location: list_books.php");
    exit();
}

$bookId = $_GET['id'];
$bookService = new BookService();
$reviewService = new ReviewService();

// Kitap Bilgilerini Çek
$book = $bookService->getBookById($bookId);
if (!$book) {
    die("<div class='container mt-5'><div class='alert alert-warning shadow-sm'>Kitap bulunamadı!</div></div>");
}

$message = "";

// Bildirim Mesajlarını Yakala (Silme sonrası geri dönüş için)
if (isset($_GET['msg']) && $_GET['msg'] === 'deleted') {
    $message = "<div class='alert alert-success border-left-success shadow-sm animated fadeIn'><i class='bi bi-trash-fill me-2'></i>Yorum başarıyla kaldırıldı.</div>";
}

// Yeni Yorum ve Puan İşleme
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_review'])) {
    try {
        $reviewService->addReview($bookId, $_SESSION['user_id'], $_POST['rating'], $_POST['comment']);
        $message = "<div class='alert alert-success border-left-success shadow-sm animated fadeIn'><i class='bi bi-check-circle-fill me-2'></i>Değerlendirmeniz başarıyla eklendi.</div>";
    } catch (Exception $e) {
        $message = "<div class='alert alert-danger border-left-danger shadow-sm'>" . $e->getMessage() . "</div>";
    }
}

// İstatistikleri ve Yorum Listesini Güncel Halini Çek
$reviews = $reviewService->getBookReviews($bookId);
$ratingStats = $reviewService->getBookAverageRating($bookId);
?>

<div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
    <h3 class="mb-0 text-gray-800"><i class="bi bi-info-circle-fill text-primary me-2"></i>Kitap Detayları</h3>
    <a href="list_books.php" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i> Listeye Dön</a>
</div>

<?php echo $message; ?>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm text-center p-4 h-100">
            <?php $imagePath = !empty($book['cover_image']) ? $book['cover_image'] : 'default.png'; ?>
            <img src="../../assets/images/<?php echo $imagePath; ?>" alt="Kapak" class="img-fluid rounded mb-3 shadow-sm mx-auto" style="max-height: 320px; object-fit: contain;">
            
            <h4 class="fw-bold text-dark mb-1"><?php echo htmlspecialchars($book['title']); ?></h4>
            <p class="text-muted small"><?php echo htmlspecialchars($book['author']); ?></p>
            
            <div class="my-3">
                <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2">
                    <i class="bi bi-tag-fill me-1"></i><?php echo htmlspecialchars($book['genre']); ?>
                </span>
            </div>
            
            <hr class="my-4">
            
            <div class="rating-box bg-light p-3 rounded">
                <div class="display-4 fw-bold text-warning mb-0"><?php echo $ratingStats['average']; ?></div>
                <div class="text-warning fs-5">
                    <?php
                    for($i=1; $i<=5; $i++) {
                        echo $i <= round($ratingStats['average']) ? '<i class="bi bi-star-fill"></i> ' : '<i class="bi bi-star"></i> ';
                    }
                    ?>
                </div>
                <small class="text-muted fw-bold"><?php echo $ratingStats['total']; ?> Toplam Değerlendirme</small>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-3 text-dark"><i class="bi bi-chat-left-dots-fill text-primary me-2"></i>Düşüncelerini Paylaş</h5>
                <form method="POST">
                    <div class="row g-3">
                        <div class="col-md-5">
                            <label class="form-label small fw-bold text-muted">Puan Ver</label>
                            <select name="rating" class="form-select border-0 bg-light" required>
                                <option value="5">⭐⭐⭐⭐⭐ (5 - Harika)</option>
                                <option value="4">⭐⭐⭐⭐ (4 - Çok İyi)</option>
                                <option value="3">⭐⭐⭐ (3 - Ortalama)</option>
                                <option value="2">⭐⭐ (2 - Kötü)</option>
                                <option value="1">⭐ (1 - Berbat)</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold text-muted">Yorumunuz</label>
                            <textarea name="comment" class="form-control border-0 bg-light" rows="3" placeholder="Kitap hakkında bir şeyler yazın..." required></textarea>
                        </div>
                    </div>
                    <button type="submit" name="submit_review" class="btn btn-primary px-4 fw-bold mt-3">
                        <i class="bi bi-send-fill me-2"></i>Gönder
                    </button>
                </form>
            </div>
        </div>

        <h5 class="fw-bold mb-3 text-gray-800">Üye Değerlendirmeleri</h5>
        
        <?php if(empty($reviews)): ?>
            <div class="card border-0 shadow-sm text-center py-5">
                <i class="bi bi-chat-dots fs-1 text-gray-300"></i>
                <p class="text-muted mt-2">Bu kitaba henüz kimse yorum yapmamış.</p>
            </div>
        <?php else: ?>
            <?php foreach($reviews as $rev): ?>
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3 shadow-sm" style="width: 40px; height: 40px; font-weight: 800;">
                                    <?php echo strtoupper(substr($rev['username'], 0, 1)); ?>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark small">
                                        <?php echo htmlspecialchars($rev['username']); ?>
                                        <?php if($_SESSION['user_id'] == $rev['user_id']): ?>
                                            <span class="badge bg-secondary-subtle text-secondary ms-1" style="font-size: 0.6rem;">Siz</span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="text-warning" style="font-size: 0.7rem;">
                                        <?php
                                        for($i=1; $i<=5; $i++) {
                                            echo $i <= $rev['rating'] ? '<i class="bi bi-star-fill"></i>' : '<i class="bi bi-star"></i>';
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="text-end">
                                <div class="text-muted" style="font-size: 0.65rem;"><?php echo date('d.m.Y H:i', strtotime($rev['created_at'])); ?></div>
                                
                                <?php if($_SESSION['role'] === 'admin' || $_SESSION['user_id'] == $rev['user_id']): ?>
                                    <a href="delete_review.php?id=<?php echo $rev['id']; ?>&book_id=<?php echo $bookId; ?>" 
                                       class="btn btn-sm text-danger p-0 mt-1 d-block" 
                                       onclick="return confirm('Bu değerlendirmeyi tamamen kaldırmak istediğinize emin misiniz?')"
                                       title="Yorumu Kaldır"
                                       style="font-size: 0.75rem; text-decoration: none;">
                                        <i class="bi bi-trash3-fill"></i> 
                                        <?php echo ($_SESSION['user_id'] == $rev['user_id'] && $_SESSION['role'] !== 'admin') ? 'Sil' : 'Kaldır'; ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <p class="text-muted mb-0 ps-5 ms-1" style="font-size: 0.88rem; line-height: 1.6;">
                            <?php echo nl2br(htmlspecialchars($rev['comment'])); ?>
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

    </div>
</div>

<?php require_once 'footer.php'; ?>