<?php
if (session_status() == PHP_SESSION_NONE) { session_start(); }
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kütüphane Yönetim Sistemi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../assets/style.css">
</head>
<body>

<div class="wrapper">
    <nav class="sidebar">
        <div class="sidebar-brand">
            <i class="bi bi-book-half"></i>
            <span>Kütüphane</span>
        </div>
        
        <ul class="nav flex-column mt-2">
            <?php if(isset($_SESSION['user_id'])): ?>
                <li class="nav-item">
                    <a class="nav-link" href="index.php"><i class="bi bi-house-door"></i> Anasayfa</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="list_books.php"><i class="bi bi-journals"></i> Kitaplar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="my_books.php"><i class="bi bi-bookmark-check"></i> Ödünç İşlemleri</a>
                </li>
                
                <?php if($_SESSION['role'] !== 'student'): ?>
                <li class="nav-item mt-3 mb-1 ms-4 text-muted small fw-bold text-uppercase">Yönetim</li>
                <li class="nav-item">
                    <a class="nav-link text-primary" href="reports.php"><i class="bi bi-bar-chart-fill"></i> İstatistikler</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-danger" href="overdue_books.php"><i class="bi bi-exclamation-octagon"></i> Ceza Takibi</a>
                </li>
                <?php endif; ?>

                <li class="nav-item mt-3 mb-1 ms-4 text-muted small fw-bold text-uppercase">Hesap</li>
                <li class="nav-item">
                    <a class="nav-link" href="edit_profile.php"><i class="bi bi-gear"></i> Ayarlar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-danger" href="logout.php"><i class="bi bi-box-arrow-left"></i> Çıkış Yap</a>
                </li>
            <?php else: ?>
                <li class="nav-item">
                    <a class="nav-link" href="login.php"><i class="bi bi-person"></i> Giriş Yap</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="register.php"><i class="bi bi-person-plus"></i> Kayıt Ol</a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>

    <div class="main-content">