<?php
// src/core/Database.php

class Database {
    private $host = "localhost";
    private $db_name = "kutuphane_sistemi";
    private $username = "root";
    private $password = "";
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            // PDO kullanarak veritabanı bağlantısı (Hata yönetimi zorunluluğu)
           // Database.php içindeki PDO satırını tam olarak buna benzet (charset ekledik):
        $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8mb4", $this->username, $this->password);
            $this->conn->exec("set names utf8");
            $this->conn->setAttribute(PDO::ATTR_ERRMODE,
            
             PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            echo "Bağlantı hatası: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>