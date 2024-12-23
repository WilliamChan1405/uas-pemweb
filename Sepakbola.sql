-- Buat database
CREATE DATABASE IF NOT EXISTS sepakbola;
USE sepakbola;

-- Buat tabel peserta dengan validasi dan indeks
CREATE TABLE IF NOT EXISTS peserta (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    umur INT NOT NULL CHECK (umur >= 5 AND umur <= 60),
    tim_favorit VARCHAR(100) NOT NULL,
    nomor_telepon VARCHAR(15) NOT NULL,
    browser VARCHAR(100),
    ip_address VARCHAR(45),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_nama (nama),
    INDEX idx_tim (tim_favorit)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
