# Kütüphane Yönetim Sistemi

Bu proje, temel PHP ve MySQL kullanılarak hazırlanmış bir kütüphane otomasyonudur. Sistemin temel amacı kitap takibini dijital ortamda kolayca yapabilmektir.

## Proje Amacı
Bu proje, okullardaki veya yerel kütüphanelerdeki kitap ödünç alma/iade süreçlerini dijitalleştirmek, stok takibini otomatize etmek ve yetkisiz erişimleri (Öğrenci/Admin ayrımı) engellemek amacıyla geliştirilmiş modern bir web otomasyonudur.

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

1. **Gereksinimler:** Bilgisayarınızda XAMPP (veya WAMP) kurulu olmalıdır.
2. **Klasörleme:** Bu projeyi indirin ve XAMPP içindeki `htdocs` klasörünün içine çıkartın.
3. **Veritabanı Kurulumu:** - XAMPP kontrol panelinden Apache ve MySQL'i başlatın.
   - Tarayıcıda `http://localhost/phpmyadmin` adresine gidin.
   - `kutuphane` adında boş bir veritabanı oluşturun.
   - Proje içindeki `data/kutuphane_sistemi.sql` dosyasını İçe Aktar (Import) seçeneği ile bu veritabanına yükleyin.
4. **Çalıştırma:** Tarayıcınızda `http://localhost/proje_klasor_adi` adresine giderek sistemi kullanmaya başlayabilirsiniz.

---
**Aziz Arda Yurdagül**