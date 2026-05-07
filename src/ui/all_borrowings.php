<?php
session_start();
require_once '../services/BorrowService.php';

// GÜVENLİK: Admin olmayan giremez!
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

require_once 'header.php';
$borrowService = new BorrowService();
$allBorrowings = $borrowService->getAllBorrowings();
?>

<div class="card shadow mb-4 border-0">
    <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
        <h5 class="m-0 font-weight-bold text-primary">
            <i class="bi bi-list-check me-2"></i>Tüm Ödünç Verilen Kitaplar
        </h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="borrowTable" width="100%" cellspacing="0">
                <thead class="table-light">
                    <tr>
                        <th>Öğrenci</th>
                        <th>Kitap Adı</th>
                        <th>Veriliş Tarihi</th>
                        <th>Teslim Tarihi</th>
                        <th>Durum</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($allBorrowings as $row): ?>
                    <tr>
                        <td><span class="badge bg-info text-dark"><?php echo htmlspecialchars($row['username']); ?></span></td>
                        <td><strong><?php echo htmlspecialchars($row['book_title']); ?></strong></td>
                        <td><?php echo date('d.m.Y', strtotime($row['borrow_date'])); ?></td>
                        <td><?php echo date('d.m.Y', strtotime($row['due_date'])); ?></td>
                        <td>
                            <?php if ($row['status'] === 'borrowed'): ?>
                                <span class="badge bg-warning text-dark">Ödünçte</span>
                            <?php else: ?>
                                <span class="badge bg-success">Teslim Edildi</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>