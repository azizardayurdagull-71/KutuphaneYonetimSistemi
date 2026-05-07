<?php
// src/services/AuthService.php
require_once __DIR__ . '/../core/Database.php';

class AuthService {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    /**
     * Kullanıcı Kayıt Metodu
     */
    public function register($username, $email, $password, $role = 'student') {
        try {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $query = "INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, :role)";
            $stmt = $this->db->prepare($query);

            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashed_password);
            $stmt->bindParam(':role', $role);

            return $stmt->execute();
        } catch (PDOException $e) {
            // Hata yönetimi (Try-catch kullanımı zorunludur)
            throw new Exception("Kayıt sırasında bir hata oluştu: " . $e->getMessage());
        }
    }

    /**
     * Kullanıcı Giriş Metodu
     */
    public function login($username, $password) {
        try {
            $query = "SELECT id, username, password, role FROM users WHERE username = :username";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                return true;
            }
            return false;
        } catch (PDOException $e) {
            throw new Exception("Giriş yapılırken bir hata oluştu: " . $e->getMessage());
        }
    }

    /**
     * ID'ye göre Kullanıcı Bilgilerini Getirme
     */
    public function getUserById($id) {
        try {
            $query = "SELECT id, username, email, role FROM users WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Kullanıcı bilgileri alınamadı: " . $e->getMessage());
        }
    }

    /**
     * Profil Bilgilerini Güncelleme (Encapsulation örneği)
     */
    public function updateProfile($id, $username, $email) {
        try {
            $query = "UPDATE users SET username = :username, email = :email WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Profil güncellenirken hata oluştu: " . $e->getMessage());
        }
    }

    /**
     * Şifre Değiştirme Metodu (Güvenli Hashleme)[cite: 1]
     */
    public function changePassword($id, $newPassword) {
        try {
            $hashed_password = password_hash($newPassword, PASSWORD_DEFAULT);
            $query = "UPDATE users SET password = :password WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':password', $hashed_password);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Şifre güncellenirken sistem hatası oluştu.");
        }
    }
}
?>