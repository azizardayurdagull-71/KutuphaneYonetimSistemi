<?php
/**
 * src/ui/edit_book.php
 * Kitap Düzenleme ve Akıllı Güncelleme Ekranı
 */
session_start();
require_once 'header.php';
require_once '../services/BookService.php';

// Güvenlik: Sadece Admin ve Kütüphaneci girebilir
if (!isset($_SESSION['role']) || $_SESSION['role'] === 'student') {
    die("<div class='container mt-5'><div class='alert alert-danger shadow'>Bu işlemi yapmaya yetkiniz yok!</div></div>");
}

$bookService = new BookService();
$message = "";

// 1. ADIM: Düzenlenecek kitabı URL'deki ID üzerinden çek
if (!isset($_GET['id'])) {
    header("Location: list_books.php");
    exit();
}

$bookId = $_GET['id'];
$book = $bookService->getBookById($bookId);

if (!$book) {
    die("<div class='container mt-5'><div class='alert alert-warning shadow'>Kitap bulunamadı!</div></div>");
}

// 2. ADIM: Form gönderildiğinde güncelleme işlemini yap
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Kapak fotoğrafı güncellemesi şimdilik eski resmi korur (Geliştirilebilir)
        $image = $book['cover_image']; 

        $result = $bookService->updateBook(
            $bookId,
            $_POST['title'], 
            $_POST['author'], 
            $_POST['isbn'], 
            $_POST['publish_year'], 
            $_POST['genre'], 
            $_POST['shelf_location'], 
            $_POST['stock'], 
            $image
        );

        if ($result) {
            $message = "<div class='alert alert-success border-left-success shadow-sm'><i class='bi bi-check-circle-fill me-2'></i>Bilgiler başarıyla güncellendi!</div>";
            // Bilgileri ekranda tazelemek için tekrar çekelim
            $book = $bookService->getBookById($bookId);
        }
    } catch (Exception $e) {
        $message = "<div class='alert alert-danger border-left-danger shadow-sm'><i class='bi bi-exclamation-triangle-fill me-2'></i>Hata: " . $e->getMessage() . "</div>";
    }
}
?>

<script src="https://unpkg.com/html5-qrcode"></script>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <h3 class="mb-0 text-gray-800"><i class="bi bi-pencil-square text-primary me-2"></i>Kitap Düzenle</h3>
        <a href="list_books.php" class="btn btn-sm btn-outline-secondary shadow-sm"><i class="bi bi-arrow-left"></i> Vazgeç</a>
    </div>

    <?php echo $message; ?>

    <div class="row">
        <div class="col-xl-9 col-lg-11 mx-auto">
            <div class="card shadow-sm border-0 mb-5">
                <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 fw-bold text-primary">Mevcut Bilgileri Güncelleyin</h6>
                    <span class="badge bg-light text-muted border px-3">ID: #<?php echo $book['id']; ?></span>
                </div>
                <div class="card-body p-4">
                    <form method="POST">
                        <div class="row g-4">
                            
                            <div class="col-md-12">
                                <label class="form-label fw-bold text-muted small text-uppercase">ISBN / Barkod (Güncellemek için Tarayabilirsin)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-upc-scan"></i></span>
                                    <input type="text" name="isbn" id="isbn_input" class="form-control" required value="<?php echo htmlspecialchars($book['isbn']); ?>">
                                    <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#barcodeModal">
                                        <i class="bi bi-camera-fill me-1"></i> Tara
                                    </button>
                                </div>
                                <div id="api_status" class="form-text mt-2 small"></div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold text-muted small text-uppercase">Kitap Adı</label>
                                <input type="text" name="title" id="title_input" class="form-control" required value="<?php echo htmlspecialchars($book['title']); ?>">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold text-muted small text-uppercase">Yazar</label>
                                <input type="text" name="author" id="author_input" class="form-control" required value="<?php echo htmlspecialchars($book['author']); ?>">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label fw-bold text-muted small text-uppercase">Yayın Yılı</label>
                                <input type="number" name="publish_year" id="year_input" class="form-control" required value="<?php echo htmlspecialchars($book['publish_year']); ?>">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label fw-bold text-muted small text-uppercase">Kategori</label>
                                <input type="text" name="genre" id="genre_input" class="form-control" required value="<?php echo htmlspecialchars($book['genre']); ?>">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label fw-bold text-muted small text-uppercase">Raf Konumu</label>
                                <input type="text" name="shelf_location" class="form-control" required value="<?php echo htmlspecialchars($book['shelf_location']); ?>">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label fw-bold text-muted small text-uppercase">Stok Adedi</label>
                                <input type="number" name="stock" class="form-control" required value="<?php echo htmlspecialchars($book['stock']); ?>">
                            </div>
                        </div>
                        
                        <div class="mt-5">
                            <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold shadow-sm py-3">
                                <i class="bi bi-cloud-upload-fill me-2"></i> DEĞİŞİKLİKLERİ KAYDET
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="barcodeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title"><i class="bi bi-camera me-2"></i>Yeni Barkod Okut</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" id="closeModalBtn"></button>
            </div>
            <div class="modal-body p-0">
                <div id="reader" style="width: 100%;"></div>
            </div>
        </div>
    </div>
</div>

<script>
    async function fetchBookInfo(isbn) {
        const statusDiv = document.getElementById('api_status');
        const isbnClean = isbn.replace(/-/g, "").trim();
        statusDiv.innerHTML = `<span class="text-primary small"><i class="bi bi-hourglass-split"></i> [${isbnClean}] Veritabanı sorgulanıyor...</span>`;
        
        try {
            const response = await fetch(`https://www.googleapis.com/books/v1/volumes?q=isbn:${isbnClean}`);
            const data = await response.json();

            if (data.totalItems > 0) {
                const info = data.items[0].volumeInfo;
                document.getElementById('title_input').value = info.title || "";
                document.getElementById('author_input').value = info.authors ? info.authors.join(', ') : "";
                document.getElementById('year_input').value = info.publishedDate ? info.publishedDate.substring(0, 4) : "";
                if (info.categories) document.getElementById('genre_input').value = info.categories[0];
                statusDiv.innerHTML = '<span class="text-success fw-bold small"><i class="bi bi-check-all"></i> Bilgiler güncellendi!</span>';
            } else {
                statusDiv.innerHTML = '<span class="text-warning small">API verisi bulunamadı, manuel devam edin.</span>';
            }
        } catch (error) {
            statusDiv.innerHTML = '<span class="text-danger small">Bağlantı hatası!</span>';
        }
    }

    let scanner;
    document.getElementById('barcodeModal').addEventListener('shown.bs.modal', function () {
        scanner = new Html5QrcodeScanner("reader", { fps: 20, qrbox: {width: 250, height: 120} });
        scanner.render((text) => {
            document.getElementById('isbn_input').value = text;
            document.getElementById('closeModalBtn').click();
            fetchBookInfo(text);
        });
    });
    document.getElementById('barcodeModal').addEventListener('hidden.bs.modal', function () {
        if (scanner) scanner.clear().catch(e => console.error(e));
    });
</script>

<?php require_once 'footer.php'; ?>