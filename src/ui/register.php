<?php
// src/ui/register.php
session_start();
require_once '../services/AuthService.php';

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$message = "";
$messageType = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $authService = new AuthService();
    try {
        if ($_POST['password'] !== $_POST['confirm_password']) {
            throw new Exception("Şifreler birbiriyle eşleşmiyor!");
        }

        if ($authService->register($_POST['username'], $_POST['email'], $_POST['password'])) {
            $message = "Hesabınız başarıyla oluşturuldu! Giriş yapabilirsiniz.";
            $messageType = "success";
        }
    } catch (Exception $e) {
        $message = $e->getMessage();
        $messageType = "danger";
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kayıt Ol - Kütüphane Sistemi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body {
            background-color: #f8f9fc;
            font-family: 'Nunito', sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }
        .register-card {
            width: 100%;
            max-width: 480px;
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }
        .btn-primary {
            background-color: #4e73df;
            border-color: #4e73df;
            padding: 12px;
            font-weight: 700;
            border-radius: 8px;
            transition: all 0.2s ease;
        }
        .btn-primary:hover {
            background-color: #2e59d9;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(78, 115, 223, 0.4);
        }
        .form-control {
            border-radius: 8px;
            padding: 10px 15px;
            border: 1px solid #d1d3e2;
            background-color: #f8f9fc;
        }
        .form-control:focus {
            background-color: #fff;
            border-color: #bac8f3;
            box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.25);
        }
        .register-icon {
            font-size: 3rem;
            color: #1cc88a;
        }
    </style>
</head>
<body>

<div class="card register-card">
    <div class="card-body p-5">
        <div class="text-center mb-4">
            <i class="bi bi-person-plus-fill register-icon"></i>
            <h3 class="fw-bold mt-2 text-gray-900" style="color: #3a3b45;">Yeni Hesap Oluştur</h3>
            <p class="text-muted small">Kütüphane sistemine katılmak için bilgilerinizi girin</p>
        </div>

        <?php if (!empty($message)): ?>
            <div class="alert alert-<?php echo $messageType; ?> text-center small py-2 rounded">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label class="form-label fw-bold small text-muted">Kullanıcı Adı</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-person"></i></span>
                        <input type="text" name="username" class="form-control border-start-0 ps-0" required>
                    </div>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label fw-bold small text-muted">E-posta Adresi</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-envelope"></i></span>
                        <input type="email" name="email" class="form-control border-start-0 ps-0" required>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold small text-muted">Şifre</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-lock"></i></span>
                        <input type="password" name="password" class="form-control border-start-0 ps-0" required>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <label class="form-label fw-bold small text-muted">Şifre Tekrar</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-shield-lock"></i></span>
                        <input type="password" name="confirm_password" class="form-control border-start-0 ps-0" required>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary w-100">Hesabı Oluştur</button>
        </form>
        
        <div class="text-center mt-4">
            <p class="small text-muted mb-0">Zaten hesabınız var mı? <a href="login.php" class="text-primary fw-bold text-decoration-none">Giriş Yap</a></p>
        </div>
    </div>
</div>

</body>
</html>