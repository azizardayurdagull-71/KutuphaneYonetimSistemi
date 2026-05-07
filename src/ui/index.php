<?php
// src/ui/index.php
session_start();
require_once '../services/BorrowService.php';

if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }
require_once 'header.php';

$borrowService = new BorrowService();
$notifications = $borrowService->getUserNotifications($_SESSION['user_id']);
?>

<div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
    <h3 class="mb-0 text-gray-800">
        <i class="bi bi-house-door-fill text-primary me-2"></i>Anasayfa
    </h3>
    <span class="text-muted small">
        <i class="bi bi-person-circle me-1"></i> 
        Oturum: <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>
    </span>
</div>

<?php if (!empty($notifications)): ?>
    <div class="mb-4">
        <?php foreach ($notifications as $note): ?>
            <div class="alert alert-<?php echo $note['type']; ?> shadow-sm border-0 d-flex align-items-center bg-white border-left-<?php echo $note['type']; ?>">
                <span class="fs-4 me-3"><?php echo $note['icon']; ?></span>
                <div class="text-dark small"><?php echo $note['message']; ?></div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<div class="row g-4">
    <div class="col-xl-4 col-md-6">
        <div class="card border-left-primary h-100 py-2 shadow-sm border-0">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col me-2">
                        <div class="text-xs fw-bold text-primary text-uppercase mb-1">Koleksiyon</div>
                        <div class="h5 mb-2 fw-bold text-gray-800">Kitapları İncele</div>
                        <a href="list_books.php" class="text-decoration-none small fw-bold text-primary">Listeye Git <i class="bi bi-chevron-right"></i></a>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-journals fs-1 text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6">
        <div class="card border-left-success h-100 py-2 shadow-sm border-0">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col me-2">
                        <div class="text-xs fw-bold text-success text-uppercase mb-1">İşlemlerim</div>
                        <div class="h5 mb-2 fw-bold text-gray-800">Ödünç Takibi</div>
                        <a href="my_books.php" class="text-decoration-none small fw-bold text-success">Kitaplarıma Bak <i class="bi bi-chevron-right"></i></a>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-bookmark-check-fill fs-1 text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if($_SESSION['role'] === 'admin'): ?>
    <div class="col-xl-4 col-md-6">
        <div class="card border-left-danger h-100 py-2 shadow-sm border-0">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col me-2">
                        <div class="text-xs fw-bold text-danger text-uppercase mb-1">Admin Paneli</div>
                        <div class="h5 mb-2 fw-bold text-gray-800">Sistem Yönetimi</div>
                        <a href="add_book.php" class="text-decoration-none small fw-bold text-danger">Yeni Kitap Ekle <i class="bi bi-chevron-right"></i></a>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-shield-lock-fill fs-1 text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php require_once 'footer.php'; ?>