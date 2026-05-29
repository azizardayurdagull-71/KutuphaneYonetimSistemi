<?php
// src/data/User.php

// Kapsülleme (Encapsulation) için private özellikler kullanıldı[cite: 1]
abstract class User {
    protected $id;
    protected $username;
    protected $email;
    protected $role;

    public function __construct($username, $email, $role) {
        $this->username = $username;
        $this->email = $email;
        $this->role = $role;
    }

    // Polimorfizm örneği: Her rolün yetki seviyesi farklı gösterilebilir[cite: 1]
    abstract public function getPermissions();

    // Getter metotları (Encapsulation gereği)[cite: 1]
    public function getUsername() { return $this->username; }
    public function getRole() { return $this->role; }
}

// Kalıtım (Inheritance) Uygulaması[cite: 1]
class Admin extends User {
    public function getPermissions() {
        return "Tüm sistem yetkileri (Kullanıcı Silme, Kitap Ekleme vb.)";
    }
}

class Librarian extends User {
    public function getPermissions() {
        return "Kısıtlı yetki (Kitap Ödünç Verme, İade Alma)";
    }
}

class Student extends User {
    public function getPermissions() {
        return "Sadece Kitap Arama ve Profil Görüntüleme";
    }
}
?>