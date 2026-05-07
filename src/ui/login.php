<?php
// src/ui/login.php
session_start();
require_once '../services/AuthService.php';

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $authService = new AuthService();
    try {
        if ($authService->login($_POST['username'], $_POST['password'])) {
            header("Location: index.php");
            exit();
        } else {
            $error = "Hatalı kullanıcı adı veya şifre!";
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giriş Yap - Kütüphane Sistemi</title>
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
        .login-card {
            width: 100%;
            max-width: 420px;
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
        .login-icon {
            font-size: 3rem;
            color: #4e73df;
        }
    </style>
</head>
<body>

<div class="card login-card">
    <div class="card-body p-5">
        <div class="text-center mb-4">
            <i class="bi bi-person-circle login-icon"></i>
            <h3 class="fw-bold mt-2 text-gray-900" style="color: #3a3b45;">Hoş Geldiniz</h3>
            <p class="text-muted small">Sisteme devam etmek için giriş yapın</p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger text-center small py-2 rounded">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label fw-bold small text-muted">Kullanıcı Adı</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-person"></i></span>
                    <input type="text" name="username" class="form-control border-start-0 ps-0" required>
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label fw-bold small text-muted">Şifre</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-lock"></i></span>
                    <input type="password" name="password" class="form-control border-start-0 ps-0" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary w-100">Giriş Yap</button>
        </form>
        
        <div class="text-center mt-4">
            <p class="small text-muted mb-0">Hesabınız yok mu? <a href="register.php" class="text-primary fw-bold text-decoration-none">Kayıt Ol</a></p>
        </div>
    </div>
</div>

</body>
</html>