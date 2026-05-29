<?php
// src/ui/reports.php
session_start();
require_once 'header.php';
require_once '../services/ReportService.php';

// Güvenlik
if (!isset($_SESSION['role']) || $_SESSION['role'] === 'student') {
    die("<div class='container mt-5'><div class='alert alert-danger'>Bu sayfayı görüntüleme yetkiniz yok.</div></div>");
}

$reportService = new ReportService();

try {
    $stats = $reportService->getGeneralStats();
    $mostRead = $reportService->getMostReadBooks();
    $mostActive = $reportService->getMostActiveUsers();
    
    // PHP Dizilerini JavaScript'in (Chart.js) anlayacağı JSON formatına çeviriyoruz
    $mostReadTitles = json_encode(array_column($mostRead, 'title'));
    $mostReadCounts = json_encode(array_column($mostRead, 'read_count'));
    
    $activeUserNames = json_encode(array_column($mostActive, 'username'));
    $activeUserCounts = json_encode(array_column($mostActive, 'borrow_count'));

} catch (Exception $e) {
    die("<div class='container mt-5'><div class='alert alert-danger'>" . $e->getMessage() . "</div></div>");
}
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
    <h3 class="mb-0 text-gray-800"><i class="bi bi-pie-chart-fill text-primary"></i> Gelişmiş İstatistikler & Dashboard</h3>
</div>

<div class="row g-4 mb-5">
    <div class="col-xl-3 col-md-6">
        <div class="card border-left-primary h-100 py-2">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col me-2">
                        <div class="text-xs fw-bold text-primary text-uppercase mb-1">Koleksiyon Büyüklüğü</div>
                        <div class="h5 mb-0 fw-bold text-gray-800"><?php echo $stats['total_books']; ?> Kitap</div>
                    </div>
                    <div class="col-auto"><i class="bi bi-book fa-2x text-gray-300" style="font-size: 2rem; color: #dddfeb;"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card border-left-success h-100 py-2">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col me-2">
                        <div class="text-xs fw-bold text-success text-uppercase mb-1">Toplam Kullanıcı</div>
                        <div class="h5 mb-0 fw-bold text-gray-800"><?php echo $stats['total_students']; ?> Üye</div>
                    </div>
                    <div class="col-auto"><i class="bi bi-people fa-2x" style="font-size: 2rem; color: #dddfeb;"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card border-left-info h-100 py-2">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col me-2">
                        <div class="text-xs fw-bold text-info text-uppercase mb-1">Toplam İşlem Hacmi</div>
                        <div class="h5 mb-0 fw-bold text-gray-800"><?php echo $stats['total_borrowings']; ?> Ödünç</div>
                    </div>
                    <div class="col-auto"><i class="bi bi-arrow-left-right fa-2x" style="font-size: 2rem; color: #dddfeb;"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card border-left-danger h-100 py-2">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col me-2">
                        <div class="text-xs fw-bold text-danger text-uppercase mb-1">Gecikme Oranı</div>
                        <div class="h5 mb-0 fw-bold text-gray-800">%<?php echo $stats['overdue_rate']; ?></div>
                    </div>
                    <div class="col-auto"><i class="bi bi-exclamation-triangle fa-2x" style="font-size: 2rem; color: #dddfeb;"></i></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0 mb-4 h-100">
            <div class="card-header bg-white py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 fw-bold text-primary">En Çok İlgi Gören Kitaplar</h6>
            </div>
            <div class="card-body">
                <div style="position: relative; height: 300px; width: 100%;">
                    <canvas id="booksChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow-sm border-0 mb-4 h-100">
            <div class="card-header bg-white py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 fw-bold text-success">En Aktif Kullanıcılar</h6>
            </div>
            <div class="card-body">
                <div style="position: relative; height: 300px; width: 100%;">
                    <canvas id="usersChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // En Çok Okunan Kitaplar (Bar Chart)
    const ctxBooks = document.getElementById('booksChart').getContext('2d');
    new Chart(ctxBooks, {
        type: 'bar',
        data: {
            labels: <?php echo $mostReadTitles; ?>,
            datasets: [{
                label: 'Okunma Sayısı',
                data: <?php echo $mostReadCounts; ?>,
                backgroundColor: 'rgba(78, 115, 223, 0.8)',
                borderColor: 'rgba(78, 115, 223, 1)',
                borderWidth: 1,
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
        }
    });

    // En Aktif Kullanıcılar (Doughnut/Pasta Grafiği)
    const ctxUsers = document.getElementById('usersChart').getContext('2d');
    new Chart(ctxUsers, {
        type: 'doughnut',
        data: {
            labels: <?php echo $activeUserNames; ?>,
            datasets: [{
                data: <?php echo $activeUserCounts; ?>,
                backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b'],
                hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf', '#dda20a', '#be2617'],
                hoverBorderColor: "rgba(234, 236, 244, 1)"
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom' } },
            cutout: '70%'
        }
    });
</script>

<?php require_once 'footer.php'; ?>