<?php
// src/ui/return_action.php
session_start();
require_once '../services/BorrowService.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['borrow_id'])) {
    header("Location: my_books.php");
    exit();
}

$borrowService = new BorrowService();

try {
    $borrowService->returnBook($_GET['borrow_id'], $_SESSION['user_id']);
    header("Location: my_books.php?msg=returned");
} catch (Exception $e) {
    die("<div style='color:red; padding:20px; text-align:center;'><h3>Hata!</h3><p>" . $e->getMessage() . "</p><a href='my_books.php'>Geri Dön</a></div>");
}
?>
