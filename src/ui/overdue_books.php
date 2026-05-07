<?php
// src/ui/overdue_books.php
session_start();
require_once 'header.php';
require_once '../services/BorrowService.php';

// Güvenlik: Sadece admin ve librarian (görevli) görebilir
if (!isset($_SESSION['role']) || $_SESSION['role'] === 'student') {
    die("<div class='container mt-5'><div class='alert alert-danger'>Yetkisiz erişim!</div></div>");
}

$borrowService = new BorrowService();
$overdueBooks = $borrowService->getAllOverdueBooks();
?>

<div class="card shadow border-0 mb-5">
    <div class="card-header bg-danger text-white">
        <h4 class="mb-0">⚠️ Sistemdeki Gecikmiş Kitaplar (Yönetici Paneli)</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Öğrenci (Kullanıcı Adı)</th>
                        <th>E-posta</th>
                        <th>Kitap Adı</th>
                        <th>Teslim Edilmesi Gereken Tarih</th>
                        <th>Gecikme Süresi</th>
                        <th>Tahakkuk Eden Ceza (Gün x 5 TL)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($overdueBooks as $book): ?>
                    <tr>
                        <td class="fw-bold"><?php echo htmlspecialchars($book['username']); ?></td>
                        <td><?php echo htmlspecialchars($book['email']); ?></td>
                        <td><?php echo htmlspecialchars($book['title']); ?></td>
                        <td><?php echo date('d.m.Y H:i', strtotime($book['due_date'])); ?></td>
                        <td class="text-danger fw-bold"><?php echo $book['delay_days']; ?> Gün</td>
                        <td class="text-danger fw-bold">
                            <?php echo ($book['delay_days'] * 5); ?> TL
                        </td>
                    </tr>
                    <?php endforeach; ?>

                    <?php if(empty($overdueBooks)): ?>
                        <tr><td colspan="6" class="text-center py-4 text-success fw-bold">Sistemde şu an gecikmiş kitap bulunmuyor. Harika!</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>