<?php
/**
 * src/ui/my_books.php
 * Kullanıcının kendi ödünç aldığı kitapları takip ettiği sayfa
 */
session_start();
require_once '../services/BorrowService.php';

// 1. GÜVENLİK: Giriş yapılmadıysa login'e at
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// 2. GÜVENLİK: Admin bu sayfaya ulaşmasın (Admin'in kendi ödünç sayfası olmaz)
if ($_SESSION['role'] === 'admin') {
    header("Location: index.php");
    exit();
}

require_once 'header.php'; // Tasarımın (Sidebar/CSS) gelmesi için kritik

$borrowService = new BorrowService();
// Sadece bu öğrenciye ait kitapları getiriyoruz
$myBooks = $borrowService->getBorrowingsByUser($_SESSION['user_id']);
?>

<div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
    <h3 class="mb-0 text-gray-800">
        <i class="bi bi-bookmark-check-fill text-success me-2"></i>Ödünç Aldığım Kitaplar
    </h3>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Kapak</th>
                        <th>Kitap Adı</th>
                        <th>Alış Tarihi</th>
                        <th>Son Teslim Tarihi</th>
                        <th>Durum / İşlem</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($myBooks)): ?>
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                Henüz ödünç aldığınız bir kitap bulunmuyor.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($myBooks as $row): ?>
                        <tr>
                            <td class="ps-4">
                                <?php $img = !empty($row['cover_image']) ? $row['cover_image'] : 'default.png'; ?>
                                <img src="../../assets/images/<?php echo $img; ?>" class="rounded shadow-sm" style="width: 45px; height: 60px; object-fit: cover;">
                            </td>
                            <td>
                                <div class="fw-bold text-dark"><?php echo htmlspecialchars($row['title']); ?></div>
                                <div class="text-muted small"><?php echo htmlspecialchars($row['author']); ?></div>
                            </td>
                            <td><?php echo date('d.m.Y', strtotime($row['borrow_date'])); ?></td>
                            <td>
                                <span class="<?php echo ($row['delay_days'] > 0 && $row['status'] === 'borrowed') ? 'text-danger fw-bold' : ''; ?>">
                                    <?php echo date('d.m.Y', strtotime($row['due_date'])); ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($row['status'] === 'borrowed'): ?>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge bg-warning text-dark px-3">Ödünçte</span>
                                        <form action="return_action.php" method="POST" class="d-inline">
                                            <input type="hidden" name="borrow_id" value="<?php echo $row['borrow_id']; ?>">
                                            <button type="submit" class="btn btn-sm btn-outline-success">İade Et</button>
                                        </form>
                                    </div>
                                <?php else: ?>
                                    <span class="badge bg-success px-3">Teslim Edildi</span>
                                    <div class="text-muted small mt-1">İade: <?php echo date('d.m.Y', strtotime($row['return_date'])); ?></div>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>