<?php
// src/ui/my_books.php
session_start();
require_once 'header.php';
require_once '../services/BorrowService.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$borrowService = new BorrowService();
$borrowedBooks = $borrowService->getBorrowingsByUser($_SESSION['user_id']);

// Gecikmiş kitap var mı kontrolü (Uyarı mesajı için)
$hasOverdue = false;
foreach ($borrowedBooks as $item) {
    if ($item['status'] === 'borrowed' && $item['delay_days'] > 0) {
        $hasOverdue = true;
        break;
    }
}
?>

<div class="card shadow border-0 mb-5">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0">Ödünç Aldığım Kitaplar</h4>
    </div>
    <div class="card-body">
        
        <?php if(isset($_GET['msg']) && $_GET['msg'] == 'returned') echo "<div class='alert alert-success'>Kitap başarıyla iade edildi. Teşekkür ederiz!</div>"; ?>
        
        <?php if($hasOverdue): ?>
            <div class="alert alert-danger shadow-sm border-danger border-2 d-flex align-items-center">
                <span class="fs-4 me-3">⚠️</span>
                <div>
                    <strong>Dikkat!</strong> Teslim tarihi geçmiş kitaplarınız bulunmaktadır. Lütfen en kısa sürede iade ediniz, aksi takdirde gecikme bedeli işlemeye devam edecektir.
                </div>
            </div>
        <?php endif; ?>

        <div class="table-responsive mt-3">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Kapak</th>
                        <th>Kitap Adı</th>
                        <th>Alış Tarihi</th>
                        <th>Son Teslim Tarihi</th>
                        <th>Durum / Ceza</th>
                        <th>İşlem</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($borrowedBooks as $item): ?>
                    <tr>
                        <td>
                            <?php $imagePath = !empty($item['cover_image']) ? $item['cover_image'] : 'default.png'; ?>
                            <img src="../../assets/images/<?php echo $imagePath; ?>" alt="Kapak" style="width: 40px; height: 60px; object-fit: cover;" class="rounded">
                        </td>
                        <td class="fw-bold"><?php echo htmlspecialchars($item['title']); ?></td>
                        <td><?php echo date('d.m.Y', strtotime($item['borrow_date'])); ?></td>
                        <td><?php echo date('d.m.Y', strtotime($item['due_date'])); ?></td>
                        <td>
                            <?php 
                            if ($item['status'] === 'returned') {
                                echo "<span class='badge bg-success'>İade Edildi</span>";
                            } else {
                                if ($item['delay_days'] > 0) {
                                    // Günlük 5 TL Ceza Hesaplama
                                    $penalty = $item['delay_days'] * 5; 
                                    echo "<span class='badge bg-danger'>Gecikti (" . $item['delay_days'] . " Gün)</span><br>";
                                    echo "<small class='text-danger fw-bold mt-1 d-block'>Ceza: " . $penalty . " TL</small>";
                                } else {
                                    echo "<span class='badge bg-warning text-dark'>Süresi Var</span>";
                                }
                            }
                            ?>
                        </td>
                        <td>
                            <?php if ($item['status'] === 'borrowed'): ?>
                                <a href="return_action.php?borrow_id=<?php echo $item['borrow_id']; ?>" 
                                   class="btn btn-sm btn-outline-primary"
                                   onclick="return confirm('Bu kitabı iade etmek istediğinize emin misiniz?')">İade Et</a>
                            <?php else: ?>
                                <button class="btn btn-sm btn-secondary" disabled>Tamamlandı</button>
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