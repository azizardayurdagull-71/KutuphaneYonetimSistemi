<?php
// src/ui/borrow_action.php
session_start();
require_once '../services/BorrowService.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['book_id'])) {
    header("Location: list_books.php");
    exit();
}

$borrowService = new BorrowService();

try {
    // Oturumdaki kullanıcı ID'si ve URL'den gelen kitap ID'si ile ödünç al
    $borrowService->borrowBook($_SESSION['user_id'], $_GET['book_id']);
    // İşlem başarılıysa listeye dön
    header("Location: list_books.php?msg=borrow_success");
} catch (Exception $e) {
    // Hata varsa ekrana yazdır[cite: 1]
    die("<div style='color:red; font-family:sans-serif; padding:20px; text-align:center;'>
            <h3>Hata!</h3>
            <p>" . $e->getMessage() . "</p>
            <a href='list_books.php'>Listeye Dön</a>
         </div>");
}
?>