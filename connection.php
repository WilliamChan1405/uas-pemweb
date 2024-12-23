<?php
/**
 * Class Database untuk mengelola koneksi database
 * Menggunakan pattern Singleton untuk memastikan hanya ada satu koneksi
 */
class Database {
    private static $instance = null;
    private $conn;
    private $host = "localhost"; // Nama host database
    private $username = "root"; // Username database
    private $password = ""; // Password database (kosong untuk XAMPP default)
    private $database = "sepakbola"; // Nama database yang digunakan

    /**
     * Constructor - Membuat koneksi database
     */
    private function __construct() {
        try {
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);
            if ($this->conn->connect_error) {
                throw new Exception("Connection failed: " . $this->conn->connect_error);
            }
            $this->conn->set_charset("utf8mb4"); // Mengatur karakter encoding
        } catch (Exception $e) {
            die("Connection error: " . $e->getMessage());
        }
    }

    /**
     * Mendapatkan instance database (Singleton pattern)
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Mendapatkan koneksi database
     */
    public function getConnection() {
        return $this->conn;
    }

    /**
     * Menutup koneksi database
     */
    public function closeConnection() {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}
?>
