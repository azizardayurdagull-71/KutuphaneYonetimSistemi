<?php
/**
 * src/ui/return_action.php
 * Kitap iade işlemini tetikleyen dosya
 */
session_start();
require_once '../services/BorrowService.php';

// Güvenlik: Giriş yapılmadıysa veya borrow_id gelmediyse geri gönder
if (!isset($_SESSION['user_id']) || !isset($_POST['borrow_id'])) {
    header("Location: my_books.php");
    exit();
}

$userId = $_SESSION['user_id'];
$borrowId = $_POST['borrow_id'];

$borrowService = new BorrowService();

try {
    // Servis içindeki returnBook fonksiyonunu çağırıyoruz
    $result = $borrowService->returnBook($borrowId, $userId);
    
    if ($result) {
        // İade başarılıysa yeşil mesajla geri dön
        header("Location: my_books.php?success=" . urlencode("Kitap başarıyla iade edildi. Teşekkürler!"));
    }
} catch (Exception $e) {
    // Bir hata oluşursa hata mesajıyla geri gönder
    header("Location: my_books.php?error=" . urlencode($e->getMessage()));
}
exit();