# Website Jadwal Pertandingan Sepak Bola

### **Nama : William Chan** 
### **NIM : 122140130** 
### **Kelas : Pemrograman Web RA** 
 	
Website untuk menampilkan jadwal pertandingan sepak bola dari liga-liga top Eropa (seperti Premier League, La Liga, dan Serie A). Aplikasi ini dibangun  dengan tujuan untuk memberikan informasi pertandingan kepada pengguna berdasarkan tim favorit yang mereka pilih.

Website: [https://uas-pemwebwilliam.infinityfreeapp.com/](https://uas-pemwebwilliam.infinityfreeapp.com/)


## Struktur File

```
📦 122140130_William Chan_RA
 ├── connection.php       # Konfigurasi database
 ├── daftar.php           # Halaman pendaftaran
 ├── index.php            # Halaman utama
 ├── images               # assets yang dipakai 
 ├── peserta.php          # Halaman daftar peserta
 ├── jadwal.php           # Halaman jadwal pertandingan
 ├── script.js            # File JavaScript
 ├── style.css            # File CSS
 └── sepakbola.sql  # File database
```
### **Bagian 1: Client-side Programming (30%)**

### 1.1 Manipulasi DOM dengan JavaScript (15%)

Skrip ini mencakup sebuah formulir dengan minimal 4 elemen input, seperti berikut:

Input teks: Nama
Input numerik: Umur
Input radio: Tim favorit
Checkbox: Konfirmasi persetujuan

```html
<form id="registrationForm">
  <label for="nama">Nama:</label>
  <input type="text" id="nama" name="nama" required>

  <label for="umur">Umur:</label>
  <input type="number" id="umur" name="umur" required>

  <label for="tim_favorit">Tim Favorit:</label>
  <input type="text" id="tim_favorit" name="tim_favorit" required>

  <label>
    <input type="checkbox" id="persetujuan" name="persetujuan" required>
    Saya setuju dengan syarat dan ketentuan
  </label>

  <button type="submit">Kirim</button>
</form>
```
Menampilkan Data dari Server
Data dari server dapat diambil menggunakan fetch() dan ditampilkan dalam tabel HTML.

Contoh pengisian tabel:
```
fetch('daftar.php')
  .then(response => response.json())
  .then(data => {
    const table = document.getElementById("dataTable");
    data.forEach(item => {
      const row = table.insertRow();
      row.insertCell(0).textContent = item.nama;
      row.insertCell(1).textContent = item.umur;
      row.insertCell(2).textContent = item.timFavorit;
    });
  });
```
### 2. Event Handling (15%)
Event yang Ditambahkan:
 Event input untuk menyimpan data secara lokal saat pengguna mengetik.
 Event submit untuk validasi data sebelum dikirim ke server.
 Event mouseenter dan mouseleave pada elemen interaktif untuk memberikan efek visual.
 Validasi Input Sebelum Diproses
 Validasi dilakukan dengan JavaScript sebelum data dikirim ke server PHP. Fungsi validasi terdapat pada validateForm().

Contoh logika validasi:
```
if (!FormValidator.validateName(nama)) {
  showAlert("Nama harus minimal 3 karakter!", "error");
  return false;
}

if (!FormValidator.validateAge(umur)) {
  showAlert("Umur harus antara 5-60 tahun!", "error");
  return false;
}

if (!document.getElementById("persetujuan").checked) {
  showAlert("Anda harus menyetujui syarat dan ketentuan!", "error");
  return false;
}
```

### **Bagian 2: Server-side Programming (30%)**

### **2.1 Pengelolaan Data dengan PHP (20%)**

```php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get database instance
    $db = Database::getInstance();
    $conn = $db->getConnection();
    
    // Server-side validation
    $nama = filter_input(INPUT_POST, 'nama', FILTER_SANITIZE_STRING);
    $umur = filter_input(INPUT_POST, 'umur', FILTER_VALIDATE_INT);
    $tim_favorit = filter_input(INPUT_POST, 'tim_favorit', FILTER_SANITIZE_STRING);
    $nomor_telepon = filter_input(INPUT_POST, 'nomor_telepon', FILTER_SANITIZE_STRING);

    // Get browser and IP information
    $browser = filter_var($_SERVER['HTTP_USER_AGENT'], FILTER_SANITIZE_STRING);
    $ip_address = filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP);
```
**Metode Form:**
  - Menggunakan metode POST untuk keamanan data
  - Implementasi di `daftar.php`
- **Validasi Server:**
  - Filter input menggunakan `filter_input()`
  - Validasi tipe data dan rentang nilai
  - Sanitasi string untuk mencegah XSS
- **Penyimpanan Data Browser & IP:**
  - Menyimpan User-Agent (`$_SERVER['HTTP_USER_AGENT']`)
  - Menyimpan IP Address (`$_SERVER['REMOTE_ADDR']`)

### 2.2 Objek PHP Berbasis OOP (10%)
```php
class Database {
    private static $instance = null;
    private $conn;
    private $host = "localhost"; // Nama host database
    private $username = "root"; // Username database
    private $password = ""; // Password database (kosong untuk XAMPP default)
    private $database = "sepakbola"; // Nama database yang digunakan

    private function __construct() {
        try {
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);
            if ($this->conn->connect_error) {
                throw new Exception("Connection failed: " . $this->conn->connect_error);
            }
            $this->conn->set_charset("utf8");
        } catch (Exception $e) {
            die("Connection error: " . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->conn;
    }

    public function closeConnection() {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}
```

- **Class Database (`connection.php`):**
  - Implementasi Singleton Pattern
  - Method `getInstance()` untuk single instance
  - Method `getConnection()` untuk koneksi database
  - Method `closeConnection()` untuk menutup koneksi


## Bagian 3: Database Management (20%)

### 3.1 Pembuatan Tabel (5%)
```sql
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
```
### 3.2 Konfigurasi Database (5%)

```php
class Database {
    private static $instance = null;
    private $conn;
    private $host = "localhost"; // Nama host database
    private $username = "root"; // Username database
    private $password = ""; // Password database (kosong untuk XAMPP default)
    private $database = "sepakbola"; // Nama database yang digunakan

    private function __construct() {
        try {
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);
            if ($this->conn->connect_error) {
                throw new Exception("Connection failed: " . $this->conn->connect_error);
            }
            $this->conn->set_charset("utf8");
        } catch (Exception $e) {
            die("Connection error: " . $e->getMessage());
        }
    }
```
Pada implementasi kelas Database:
Host diatur menjadi localhost.
Username yang digunakan adalah root.
Nama database yang akan diakses adalah sepakbola.
Pengaturan charset adalah utf8mb4.
Menyertakan mekanisme penanganan kesalahan menggunakan try-catch.

### 3.3 Manipulasi Data (10%)
```php
<?php 
  if (isset($result) && $result->num_rows > 0) {
  $no = 1;
  while($row = $result->fetch_assoc()) {
  echo "<tr>";
  echo "<td>" . $no++ . "</td>";
  echo "<td>" . htmlspecialchars($row['nama']) . "</td>";
  echo "<td>" . htmlspecialchars($row['umur']) . "</td>";
  echo "<td>" . htmlspecialchars($row['tim_favorit']) . "</td>";
  echo "<td>" . date('d/m/Y H:i', strtotime($row['created_at'])) . "</td>";
  echo "<td>" . htmlspecialchars($row['browser']) . "</td>";
  echo "<td>" . htmlspecialchars($row['ip_address']) . "</td>";
  echo "</tr>";
```
Pemeriksaan Data: Kode memverifikasi keberadaan data dengan isset($result) dan memastikan hasil query memiliki baris sebelum diproses lebih lanjut.
Pengolahan Data: Data diambil dari database menggunakan fetch_assoc() dalam perulangan while, memungkinkan pengolahan setiap baris secara individu.
Keamanan Data: Fungsi htmlspecialchars() digunakan untuk mencegah serangan XSS, memastikan karakter spesial dalam data tidak dieksekusi sebagai kode.
Format dan Presentasi: Data tanggal diformat menggunakan date() agar lebih mudah dibaca, dan nomor urut dihasilkan secara otomatis dengan variabel $no.
Penyajian Rapi: Informasi seperti browser dan ip_address ditampilkan dalam tabel HTML, menggambarkan proses manipulasi data untuk presentasi yang aman dan terstruktur.


## Bagian 4: State Management (20%)

### 4.1 Session Management (10%)
```php
session_start();
$_SESSION['success_message'] = "Pendaftaran berhasil!";
```

- **Implementasi Session:**
  - `session_start()` di setiap halaman
  - Menyimpan pesan sukses/error
  - Pengelolaan state registrasi
  - Session handling untuk navigasi

### 4.2 Cookie & Storage Management (10%)
```javascript
<script>
        // Fungsi untuk Cookie
        function setCookie() {
            const key = document.getElementById('cookie-key').value;
            const value = document.getElementById('cookie-value').value;
            const days = document.getElementById('cookie-days').value;

            if (key && value && days) {
                const date = new Date();
                date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
                document.cookie = `${key}=${value};expires=${date.toUTCString()};path=/`;
                document.getElementById('output').textContent = `Cookie ${key} telah disimpan.`;
            } else {
                document.getElementById('output').textContent = 'Mohon isi semua field untuk Cookie.';
            }
        }

        function getCookie() {
            const key = document.getElementById('cookie-key').value;
            const cookies = document.cookie.split(';');
            for (let cookie of cookies) {
                const [cookieKey, cookieValue] = cookie.split('=');
                if (cookieKey.trim() === key) {
                    document.getElementById('output').textContent = `Cookie ${key}: ${cookieValue}`;
                    return;
                }
            }
            document.getElementById('output').textContent = `Cookie ${key} tidak ditemukan.`;
        }

        function deleteCookie() {
            const key = document.getElementById('cookie-key').value;
            if (key) {
                document.cookie = `${key}=;expires=Thu, 01 Jan 1970 00:00:00 UTC;path=/`;
                document.getElementById('output').textContent = `Cookie ${key} telah dihapus.`;
            } else {
                document.getElementById('output').textContent = 'Mohon masukkan key untuk menghapus Cookie.';
            }
        }

        // Fungsi untuk Local Storage
        function setLocalStorage() {
            const key = document.getElementById('local-key').value;
            const value = document.getElementById('local-value').value;
            if (key && value) {
                localStorage.setItem(key, value);
                document.getElementById('output').textContent = `Local Storage ${key} telah disimpan.`;
            } else {
                document.getElementById('output').textContent = 'Mohon isi key dan value untuk Local Storage.';
            }
        }

        function getLocalStorage() {
            const key = document.getElementById('local-key').value;
            const value = localStorage.getItem(key);
            if (value) {
                document.getElementById('output').textContent = `Local Storage ${key}: ${value}`;
            } else {
                document.getElementById('output').textContent = `Local Storage ${key} tidak ditemukan.`;
            }
        }

        function deleteLocalStorage() {
            const key = document.getElementById('local-key').value;
            if (key) {
                localStorage.removeItem(key);
                document.getElementById('output').textContent = `Local Storage ${key} telah dihapus.`;
            } else {
                document.getElementById('output').textContent = 'Mohon masukkan key untuk menghapus Local Storage.';
            }
        }
    </script>
```
Penjelasan:

Cookie Management:
Fungsi setCookie(): Menetapkan cookie dengan nama, nilai, dan waktu kadaluarsa.
Fungsi getCookie(): Membaca nilai cookie berdasarkan nama.
Fungsi deleteCookie(): Menghapus cookie yang ditentukan.
Local Storage:

Fungsi setLocalStorage(): Menyimpan data lokal dengan key dan value.
Fungsi getLocalStorage(): Membaca data dari localStorage.
Fungsi deleteLocalStorage(): Menghapus data dari localStorage.


### Bagian Bonus: Hosting Aplikasi Web Menggunakan **InfinityFree**

### Langkah-langkah Hosting (5%)

1. Registrasi di Infinity Free
2. Verifikasi akun email
3. Membuat subdomain
4. Upload file via FTP
5. Konfigurasi database MySQL

### Pemilihan Hosting (5%)
Infinity Free dipilih karena:
- Gratis: Tidak ada biaya untuk hosting, dengan batasan yang cukup memadai untuk proyek kecil atau menengah.
- Mendukung PHP dan MySQL: Cocok untuk aplikasi berbasis PHP seperti proyek ini.
- Unlimited Bandwidth: Membantu memastikan aplikasi tetap dapat diakses oleh pengguna tanpa batasan lalu lintas.

### Keamanan Aplikasi (5%)
SSL/HTTPS

```apache
# .htaccess
RewriteEngine On
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

XSS Prevention

```php
// Selalu gunakan htmlspecialchars untuk output
echo htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
```

SQL Injection Prevention

```php
// Gunakan prepared statements
$stmt = $conn->prepare("INSERT INTO peserta (nama_lengkap) VALUES (?)");
$stmt->bind_param("s", $nama);
```

### Konfigurasi Server (5%)
1. **Pengaturan Database Connection**
   Saat menggunakan **InfinityFree**, informasi koneksi database disesuaikan dengan detail yang diberikan oleh InfinityFree, seperti:

   ```php
   $servername = "sesuaikan di InfinityFree"; // Contoh: sql123.infinityfree.com
   $username = "sesuaikan di InfinityFree";  // Contoh: epiz_12345678
   $password = "sesuaikan di InfinityFree";  // Sesuai dengan password akun Anda
   $dbname = "sesuaikan di InfinityFree";    // Contoh: epiz_12345678_uas_web
   ```

   Contoh kode lengkap:
   ```php
   <?php
   $servername = "sesuaikan di InfinityFree"; // Ganti dengan host database dari InfinityFree
   $username = "sesuaikan di InfinityFree";  // Ganti dengan username database Anda
   $password = "sesuaikan di InfinityFree";  // Ganti dengan password database Anda
   $dbname = "sesuaikan di InfinityFree";    // Ganti dengan nama database Anda

   $conn = new mysqli($servername, $username, $password, $dbname);

   // Periksa koneksi
   if ($conn->connect_error) {
       die("Koneksi gagal: " . $conn->connect_error);
   }
   ?>
   ```









