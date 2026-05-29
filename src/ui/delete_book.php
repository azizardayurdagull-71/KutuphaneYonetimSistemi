<?php
session_start();
require_once '../services/BookService.php';

// Güvenlik: Sadece admin silebilir[cite: 1]
if ($_SESSION['role'] !== 'admin' || !isset($_GET['id'])) {
    header("Location: list_books.php");
    exit();
}

$bookService = new BookService();
try {
    $bookService->deleteBook($_GET['id']);
    header("Location: list_books.php?msg=deleted");
} catch (Exception $e) {
    die("Hata: " . $e->getMessage());
}
?>