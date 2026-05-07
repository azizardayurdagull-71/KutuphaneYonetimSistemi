<?php
/**
 * src/ui/list_books.php
 * Kütüphane Sistemi - Gelişmiş Kitap Listeleme ve Barkodlu Arama Ekranı
 */
session_start();
require_once 'header.php';
require_once '../services/BookService.php';

// Oturum kontrolü: Giriş yapmayan kullanıcıyı login sayfasına at
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$bookService = new BookService();


$filters = [
    'title' => $_GET['title'] ?? '',
    'author' => $_GET['author'] ?? '',
    'isbn' => $_GET['isbn'] ?? '',
    'status' => $_GET['status'] ?? '',
    'category' => $_GET['category'] ?? '',
    'sort' => $_GET['sort'] ?? '' 
];

$books = $bookService->searchBooks($filters);

// Eğer herhangi bir filtre doluysa searchBooks() fonksiyonunu çağır, değilse hepsini getir
$books = array_filter($filters) ? $bookService->searchBooks($filters) : $bookService->getAllBooks();
?>

<script src="https://unpkg.com/html5-qrcode"></script>

<div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
    <h3 class="mb-0 text-gray-800">
        <i class="bi bi-journals text-primary me-2"></i>Kitap Koleksiyonu
    </h3>
    <?php if($_SESSION['role'] !== 'student'): ?>
        <a href="add_book.php" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-lg me-1"></i> Yeni Kitap Ekle
        </a>
    <?php endif; ?>
</div>

<div class="card shadow-sm border-0 mb-4 bg-white">
    <div class="card-body p-4">
        <form method="GET" id="searchForm" class="row g-3">
            <div class="col-md-3">
                <label class="form-label small fw-bold text-muted">Kitap Adı</label>
                <input type="text" name="title" class="form-control" placeholder="Ara..." value="<?php echo htmlspecialchars($filters['title']); ?>">
            </div>
            
            <div class="col-md-2">
                <label class="form-label small fw-bold text-muted">Yazar</label>
                <input type="text" name="author" class="form-control" placeholder="Yazar adı..." value="<?php echo htmlspecialchars($filters['author']); ?>">
            </div>

            <div class="col-md-3">
                <label class="form-label small fw-bold text-muted">Barkod / ISBN</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted"><i class="bi bi-upc-scan"></i></span>
                    <input type="text" name="isbn" id="isbn_search" class="form-control border-start-0" placeholder="Okut veya yaz" value="<?php echo htmlspecialchars($filters['isbn']); ?>">
                    <button class="btn btn-outline-primary" type="button" data-bs-toggle="modal" data-bs-target="#scanModal" title="Kamera ile Tara">
                        <i class="bi bi-camera"></i>
                    </button>
                </div>
            </div>

            <div class="col-md-2">
                <label class="form-label small fw-bold text-muted">Stok Durumu</label>
                <select name="status" class="form-select">
                    <option value="">Tümü</option>
                    <option value="available" <?php echo $filters['status'] == 'available' ? 'selected' : ''; ?>>Mevcutlar</option>
                    <option value="borrowed" <?php echo $filters['status'] == 'borrowed' ? 'selected' : ''; ?>>Tükenenler</option>
                </select>
            </div>
            <div class="col-md-2">
    <label class="form-label fw-bold text-muted small">Kategori</label>
    <select name="category" class="form-select">
        <option value="">Tümü</option>
        <option value="Roman">Roman</option>
        <option value="Bilim">Bilim</option>
        <option value="Dergi">Dergi</option>
        <option value="Tarih">Tarih</option>
        <option value="Gezi">Gezi</option>
        <option value="Genel">Genel</option>
    </select>
</div>

<div class="col-md-2">
    <label class="form-label text-muted small fw-bold">Sıralama</label>
    <select name="sort" class="form-select">
        <option value="">En Yeniler</option>
        <option value="title_asc" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'title_asc') ? 'selected' : ''; ?>>A-Z (Kitap Adı)</option>
        <option value="title_desc" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'title_desc') ? 'selected' : ''; ?>>Z-A (Kitap Adı)</option>
        <option value="author_asc" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'author_asc') ? 'selected' : ''; ?>>A-Z (Yazar Adı)</option>
        <option value="author_desc" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'author_asc') ? 'selected' : ''; ?>>Z-A (Yazar Adı)</option>
    </select>
</div>

            <div class="col-md-auto ms-auto d-flex align-items-end gap-2">
    <button type="submit" class="btn btn-primary px-4 fw-bold">Listele</button>
    <a href="list_books.php" class="btn btn-outline-secondary" title="Filtreleri Sıfırla"><i class="bi bi-arrow-counterclockwise"></i></a>
</div>
        </form>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4" style="width: 80px;">Kapak</th>
                        <th>Kitap Bilgileri</th>
                        <th>Tür / Kategori</th>
                        <th>Durum & Raf</th>
                        <th class="text-end pe-4">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($books)): ?>
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-search fs-1 d-block mb-2"></i>
                                Aradığınız kriterlere uygun kitap bulunamadı.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($books as $book): ?>
                        <tr>
                            <td class="ps-4">
                                <?php $img = !empty($book['cover_image']) ? $book['cover_image'] : 'default.png'; ?>
                                <img src="../../assets/images/<?php echo $img; ?>" class="rounded shadow-sm border" style="width: 50px; height: 70px; object-fit: cover;">
                            </td>
                            <td>
                                <div class="fw-bold text-dark fs-6"><?php echo htmlspecialchars($book['title']); ?></div>
                                <div class="text-muted small">Yazar: <?php echo htmlspecialchars($book['author']); ?></div>
                                <div class="text-muted style='font-size: 0.7rem;'">ISBN: <?php echo htmlspecialchars($book['isbn']); ?></div>
                            </td>
                            <td>
                                <span class="badge rounded-pill bg-info-subtle text-info border border-info-subtle px-3">
                                    <?php echo htmlspecialchars($book['genre']); ?>
                                </span>
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <?php if($book['stock'] > 0): ?>
                                        <span class="text-success small fw-bold"><i class="bi bi-check2-circle"></i> <?php echo $book['stock']; ?> Adet Mevcut</span>
                                    <?php else: ?>
                                        <span class="text-danger small fw-bold"><i class="bi bi-x-circle"></i> Tükendi</span>
                                    <?php endif; ?>
                                    <code class="small text-secondary mt-1">Konum: <?php echo htmlspecialchars($book['shelf_location']); ?></code>
                                </div>
                            </td>
                            <td class="text-end pe-4">
                                <div class="btn-group shadow-sm">
                                    <a href="book_details.php?id=<?php echo $book['id']; ?>" class="btn btn-sm btn-white border" title="Detaylar ve Yorumlar">
                                        <i class="bi bi-eye-fill text-info"></i>
                                    </a>
                                    <?php if($book['stock'] > 0): ?>
                                        <a href="borrow_action.php?book_id=<?php echo $book['id']; ?>" class="btn btn-sm btn-white border" title="Ödünç Al">
                                            <i class="bi bi-handbag-fill text-success"></i>
                                        </a>
                                    <?php endif; ?>
                                    <?php if($_SESSION['role'] !== 'student'): ?>
                                        <a href="edit_book.php?id=<?php echo $book['id']; ?>" class="btn btn-sm btn-white border" title="Düzenle">
                                            <i class="bi bi-pencil-square text-primary"></i>
                                        </a>
                                        <a href="delete_book.php?id=<?php echo $book['id']; ?>" class="btn btn-sm btn-white border" onclick="return confirm('Bu kitabı silmek istediğinize emin misiniz?')" title="Sil">
                                            <i class="bi bi-trash3-fill text-danger"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="scanModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title"><i class="bi bi-camera me-2"></i>Barkod Okutarak Kitap Bul</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" id="closeScanBtn"></button>
            </div>
            <div class="modal-body p-0 bg-light">
                <div id="search_reader" style="width: 100%;"></div>
            </div>
            <div class="modal-footer justify-content-center border-0 bg-light">
                <p class="small text-muted mb-0">Barkodu kameraya ortalayın, sistem otomatik arayacaktır.</p>
            </div>
        </div>
    </div>
</div>

<script>
    /**
     * Kamera ile Barkod Okuma İşlemleri
     */
    let scanner;

    // Modal açıldığında kamerayı tetikle
    document.getElementById('scanModal').addEventListener('shown.bs.modal', function () {
        scanner = new Html5QrcodeScanner("search_reader", { 
            fps: 15, 
            qrbox: {width: 250, height: 150},
            aspectRatio: 1.0
        });
        
        scanner.render((decodedText) => {
            // Barkod okunduğunda inputa yaz, modalı kapat ve formu gönder
            document.getElementById('isbn_search').value = decodedText;
            document.getElementById('closeScanBtn').click();
            document.getElementById('searchForm').submit(); 
        });
    });

    // Modal kapandığında kamerayı serbest bırak (Donanım tasarrufu)
    document.getElementById('scanModal').addEventListener('hidden.bs.modal', function () {
        if (scanner) {
            scanner.clear().catch(error => console.error("Kamera kapatma hatası:", error));
        }
    });

    // list_books.php içindeki render kısmını bununla güncelle
 scanner = new Html5QrcodeScanner("search_reader", { 
    fps: 20, // Daha hızlı kare yakalama
    qrbox: {width: 250, height: 150},
    // Sadece kitap barkodlarına (EAN_13) odaklanmasını söyleyelim
    formatsToSupport: [ Html5QrcodeSupportedFormats.EAN_13, Html5QrcodeSupportedFormats.ISBN_10 ]
});
</script>


<?php require_once 'footer.php'; ?>