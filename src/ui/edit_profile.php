<?php
// src/ui/edit_profile.php
session_start();
require_once 'header.php';
require_once '../services/AuthService.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$authService = new AuthService();
$user = $authService->getUserById($_SESSION['user_id']);
$message = "";

// Form İşlemleri
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        if (isset($_POST['update_profile'])) {
            $authService->updateProfile($_SESSION['user_id'], $_POST['username'], $_POST['email']);
            $_SESSION['username'] = $_POST['username']; // Session'ı güncelle
            $message = "<div class='alert alert-success'>Profil başarıyla güncellendi.</div>";
        } elseif (isset($_POST['change_password'])) {
            if ($_POST['new_pass'] === $_POST['confirm_pass']) {
                $authService->changePassword($_SESSION['user_id'], $_POST['new_pass']);
                $message = "<div class='alert alert-success'>Şifre başarıyla değiştirildi.</div>";
            } else {
                $message = "<div class='alert alert-danger'>Şifreler uyuşmuyor!</div>";
            }
        }
        // Güncel veriyi tekrar çek
        $user = $authService->getUserById($_SESSION['user_id']);
    } catch (Exception $e) {
        $message = "<div class='alert alert-danger'>" . $e->getMessage() . "</div>";
    }
}
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <!-- Bilgi Güncelleme Kartı -->
        <div class="card shadow-sm mb-4 border-0">
            <div class="card-header bg-primary text-white fw-bold">Profil Bilgilerini Düzenle</div>
            <div class="card-body">
                <?php echo $message; ?>
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Kullanıcı Adı</label>
                        <input type="text" name="username" class="form-control" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">E-posta</label>
                        <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                    </div>
                    <button type="submit" name="update_profile" class="btn btn-primary w-100">Bilgileri Güncelle</button>
                </form>
            </div>
        </div>

        <!-- Şifre Değiştirme Kartı -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-dark text-white fw-bold">Şifre Değiştir</div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Yeni Şifre</label>
                        <input type="password" name="new_pass" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Yeni Şifre (Tekrar)</label>
                        <input type="password" name="confirm_pass" class="form-control" required>
                    </div>
                    <button type="submit" name="change_password" class="btn btn-dark w-100">Şifreyi Güncelle</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>