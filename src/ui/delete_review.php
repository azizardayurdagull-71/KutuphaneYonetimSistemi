<?php
session_start();
require_once '../services/ReviewService.php';

// Giriş yapılmamışsa direkt engelle
if (!isset($_SESSION['user_id'])) {
    die("Yetkisiz erişim!");
}

if (isset($_GET['id']) && isset($_GET['book_id'])) {
    $reviewId = $_GET['id'];
    $bookId = $_GET['book_id'];
    
    $reviewService = new ReviewService();
    $review = $reviewService->getReviewById($reviewId);

    if (!$review) {
        die("Yorum bulunamadı!");
    }

    // GÜVENLİK KONTROLÜ: 
    // Silme yetkisi: Giriş yapan kişi admin ise VEYA yorumun user_id'si ile giriş yapanın id'si aynıysa
    if ($_SESSION['role'] === 'admin' || $_SESSION['user_id'] == $review['user_id']) {
        try {
            $reviewService->deleteReview($reviewId);
            header("Location: book_details.php?id=" . $bookId . "&msg=deleted");
            exit();
        } catch (Exception $e) {
            die("Hata: " . $e->getMessage());
        }
    } else {
        die("Bu yorumu silme yetkiniz yok!");
    }
}