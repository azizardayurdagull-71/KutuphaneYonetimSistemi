<?php
// src/ui/logout.php
session_start();
session_unset(); // Tüm oturum değişkenlerini temizle
session_destroy(); // Oturumu tamamen sonlandır

// Giriş sayfasına yönlendir
header("Location: login.php");
exit();
?>