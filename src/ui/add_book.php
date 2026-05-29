<?php
// src/ui/add_book.php
session_start();
require_once 'header.php';
require_once '../services/BookService.php';

// Güvenlik Kontrolü
if (!isset($_SESSION['role']) || $_SESSION['role'] === 'student') {
    die("<div class='container mt-5'><div class='alert alert-danger'>Yetkisiz erişim!</div></div>");
}

$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bookService = new BookService();
    try {
        // Kapak fotoğrafı yükleme mantığı (Basitçe default atanıyor, geliştirilebilir)
        $image = "default.png"; 
        
        $bookService->addBook(
            $_POST['title'], $_POST['author'], $_POST['isbn'], 
            $_POST['publish_year'], $_POST['genre'], $_POST['shelf_location'], 
            $_POST['stock'], $image
        );
        $message = "<div class='alert alert-success'><i class='bi bi-check-circle-fill'></i> Kitap başarıyla eklendi!</div>";
    } catch (Exception $e) {
        $message = "<div class='alert alert-danger'><i class='bi bi-exclamation-triangle-fill'></i> Hata: " . $e->getMessage() . "</div>";
    }
}
?>

<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

<div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
    <h3 class="mb-0 text-gray-800"><i class="bi bi-journal-plus text-primary"></i> Yeni Kitap Ekle</h3>
    <a href="list_books.php" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i> Listeye Dön</a>
</div>

<?php echo $message; ?>

<div class="row">
    <div class="col-xl-8 col-lg-10 mx-auto">
        <div class="card shadow-sm border-0 mb-5">
            <div class="card-body p-4">
                <form method="POST" enctype="multipart/form-data">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small">Kitap Adı</label>
                            <input type="text" name="title" class="form-control" required placeholder="Örn: 1984">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small">Yazar</label>
                            <input type="text" name="author" class="form-control" required placeholder="Örn: George Orwell">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small">ISBN / Barkod</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="bi bi-upc-scan"></i></span>
                                <input type="text" name="isbn" id="isbn_input" class="form-control border-start-0" required placeholder="Barkod numarası">
                                <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#barcodeModal">
                                    <i class="bi bi-camera-video"></i> Tara
                                </button>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small">Yayın Yılı</label>
                            <input type="number" name="publish_year" class="form-control" required placeholder="Örn: 1949">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-muted small">Kategori / Tür</label>
                            <input type="text" name="genre" class="form-control" required placeholder="Örn: Distopya">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-muted small">Raf Konumu</label>
                            <input type="text" name="shelf_location" class="form-control" required placeholder="Örn: A-01">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-muted small">Stok Adedi</label>
                            <input type="number" name="stock" class="form-control" required value="1" min="1">
                        </div>
                    </div>
                    
                    <hr class="my-4">
                    <button type="submit" class="btn btn-success w-100 fw-bold py-2"><i class="bi bi-save"></i> Kitabı Kaydet</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="barcodeModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow">
      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title"><i class="bi bi-camera-fill"></i> Kitap Barkodunu Okut</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Kapat" id="closeModalBtn"></button>
      </div>
      <div class="modal-body p-0">
        <div id="reader" width="100%"></div>
      </div>
      <div class="modal-footer bg-light">
        <small class="text-muted w-100 text-center">Kamerayı kitabın arkasındaki barkoda (ISBN) hizalayın.</small>
      </div>
    </div>
  </div>
</div>

<script>
    let html5QrcodeScanner;

    // Modal açıldığında kamerayı başlat
    document.getElementById('barcodeModal').addEventListener('shown.bs.modal', function () {
        html5QrcodeScanner = new Html5QrcodeScanner(
            "reader", { fps: 10, qrbox: {width: 250, height: 100} }, /* verbose= */ false);
        
        html5QrcodeScanner.render(onScanSuccess, onScanFailure);
    });

    // Modal kapandığında kamerayı durdur (Şarj ve performans için önemli)
    document.getElementById('barcodeModal').addEventListener('hidden.bs.modal', function () {
        if (html5QrcodeScanner) {
            html5QrcodeScanner.clear().catch(error => {
                console.error("Kamera durdurulamadı.", error);
            });
        }
    });

    // Barkod başarıyla okunduğunda çalışacak fonksiyon
    function onScanSuccess(decodedText, decodedResult) {
        // Okunan veriyi inputa yazdır
        document.getElementById('isbn_input').value = decodedText;
        
        // Modal'ı kapat
        document.getElementById('closeModalBtn').click();
        
        // Kullanıcıya başarılı olduğuna dair ufak bir yeşil çerçeve efekti ver
        document.getElementById('isbn_input').style.borderColor = "#1cc88a";
        document.getElementById('isbn_input').style.boxShadow = "0 0 0 0.25rem rgba(28, 200, 138, 0.25)";
    }

    function onScanFailure(error) {
        // Tarama devam ederken arka planda çalışır, hataları basmaya gerek yok
    }
</script>

<?php require_once 'footer.php'; ?>