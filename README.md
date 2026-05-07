# Kütüphane Yönetim Sistemi

Bu proje, temel PHP ve MySQL kullanılarak hazırlanmış bir kütüphane otomasyonudur. Sistemin temel amacı kitap takibini dijital ortamda kolayca yapabilmektir.

##  Temel Özellikler

- **Giriş Sistemi:** Admin ve kullanıcı girişleri mevcuttur. Yetkiye göre menüler değişir.
- **Kitap Yönetimi:** Kitap ekleme, listeleme ve güncelleme işlemleri yapılabilir.
- **Barkod Arama:** Bilgisayar veya telefon kamerasıyla kitap barkodu okutularak hızlı arama yapılabilir.
- **Ödünç Takibi:** Kitapların kimde olduğu ve stok durumu takip edilebilir.
- **Yorum ve Puan:** Kitaplara yorum yazılabilir ve 5 üzerinden puan verilebilir. Admin uygunsuz yorumları silebilir.
- **İstatistikler:** Ana sayfadaki grafikler sayesinde kütüphanedeki genel durum (toplam kitap, ödünç sayıları vb.) görülebilir.

##  Kullanılan Teknolojiler

- **Backend:** PHP (PDO bağlantısı ile)
- **Frontend:** Bootstrap 5 ve CSS (Görsel düzenleme için)
- **Veritabanı:** MySQL
- **Ek araçlar:** Barkod okuma için JavaScript kütüphanesi ve grafikler için Chart.js kullanılmıştır.

##  Kurulum Notları

1. Proje dosyalarını yerel sunucunuza (XAMPP/WAMP vb.) kopyalayın.
2. `src/core/Database.php` dosyasından veritabanı ayarlarını yapın.
3. Veritabanını (SQL dosyası) içeri aktardıktan sonra sistemi kullanmaya başlayabilirsiniz.

---
**Aziz Arda Yurdagül**