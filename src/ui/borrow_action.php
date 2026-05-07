<?php
/**
 * src/ui/borrow_action.php
 * Kitap ödünç alma işlemini tetikleyen dosya
 */
session_start();
require_once '../services/BorrowService.php';

// Güvenlik kontrolleri
if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    header("Location: list_books.php");
    exit();
}

$userId = $_SESSION['user_id'];
$bookId = $_GET['id'];

$borrowService = new BorrowService();

try {
    // Servis içindeki admin engelli fonksiyonu çağırıyoruz
    $result = $borrowService->borrowBook($userId, $bookId);
    
    if ($result) {
        // Başarılıysa listeye geri dön
        header("Location: list_books.php?success=" . urlencode("Kitap başarıyla ödünç alındı."));
    }
} catch (Exception $e) {
    // Bir hata varsa (Örn: Adminse) hatayı ekrana basmak üzere geri gönder
    header("Location: list_books.php?error=" . urlencode($e->getMessage()));
}
exit();