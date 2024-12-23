# Website Lomba 17 Agustus

Website untuk pendaftaran dan manajemen lomba perayaan kemerdekaan Indonesia. Aplikasi ini dibangun menggunakan PHP, JavaScript, dan MySQL dengan pendekatan berorientasi objek.

Website: [https://daftarlomba17.wuaze.com/](https://daftarlomba17.wuaze.com/)

## Pengembang

Nama : William Chan

NIM : 122140123

Kelas : RA

## Deskripsi Project

Website ini dibuat untuk memudahkan pendaftaran peserta lomba 17 Agustus. Aplikasi ini memungkinkan pengguna untuk:

- Mendaftar sebagai peserta lomba
- Memilih jenis lomba yang diikuti
- Melihat daftar peserta yang sudah mendaftar
- Menampilkan informasi lomba yang tersedia

## Struktur File

```
📦 122140123_Sakti_RA
 ├── connection.php       # Konfigurasi database
 ├── daftar.php           # Halaman pendaftaran
 ├── index.php            # Halaman utama
 ├── Logo.png             # Logo Website
 ├── peserta.php          # Halaman daftar peserta
 ├── script.js            # File JavaScript
 ├── style.css            # File CSS
 └── lomba_17agustus.sql  # File database
```

## Bagian 1: Client-side Programming (30%)

### 1.1 Manipulasi DOM dengan JavaScript (15%)

**Form Input dengan 4+ Elemen:**

```html
<form
  id="registrationForm"
  method="POST"
  action="daftar.php"
  onsubmit="return validateForm()"
>
  <div class="form-group">
    <label for="nama">Nama Lengkap</label>
    <input type="text" id="nama" name="nama" required />
  </div>
  <div class="form-group">
    <label for="umur">Umur</label>
    <input type="number" id="umur" name="umur" required />
  </div>
  <div class="form-group">
    <label>Jenis Kelamin</label>
    <div class="radio-group">
      <input
        type="radio"
        id="laki"
        name="jenis_kelamin"
        value="Laki-laki"
        required
      />
      <label for="laki">Laki-laki</label>
      <input
        type="radio"
        id="perempuan"
        name="jenis_kelamin"
        value="Perempuan"
      />
      <label for="perempuan">Perempuan</label>
    </div>
  </div>
  <div class="form-group">
    <label for="nomor_telepon">Nomor Telepon</label>
    <input type="tel" id="nomor_telepon" name="nomor_telepon" required />
  </div>
  <div class="form-group">
    <label for="pilihan_lomba">Pilihan Lomba</label>
    <select id="pilihan_lomba" name="pilihan_lomba" required>
      <option value="">Pilih Lomba</option>
      <option value="Balap Karung">Balap Karung</option>
      <option value="Panjat Pinang">Panjat Pinang</option>
      <option value="Lomba Makan Kerupuk">Lomba Makan Kerupuk</option>
    </select>
  </div>
  <button type="submit" class="btn-submit">Daftar</button>
</form>
```

- Input text untuk nama lengkap (`nama`)
- Input number untuk umur (`umur`)
- Radio button untuk jenis kelamin (`jenis_kelamin`)
- Input tel untuk nomor telepon (`nomor_telepon`)
- Select dropdown untuk pilihan lomba (`pilihan_lomba`)

**Tampilan Data dalam Tabel:**

```php
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Lengkap</th>
            <th>Umur</th>
            <th>Jenis Kelamin</th>
            <th>Pilihan Lomba</th>
            <th>Waktu Daftar</th>
            <th>Browser</th>
            <th>IP Address</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (isset($result) && $result->num_rows > 0) {
            $no = 1;
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $no++ . "</td>";
                echo "<td>" . htmlspecialchars($row['nama_lengkap']) . "</td>";
                echo "<td>" . htmlspecialchars($row['umur']) . "</td>";
                echo "<td>" . htmlspecialchars($row['jenis_kelamin']) . "</td>";
                echo "<td>" . htmlspecialchars($row['pilihan_lomba']) . "</td>";
                echo "<td>" . date('d/m/Y H:i', strtotime($row['created_at'])) . "</td>";
                echo "<td>" . htmlspecialchars($row['browser']) . "</td>";
                echo "<td>" . htmlspecialchars($row['ip_address']) . "</td>";
                echo "</tr>";
            }
        }
        ?>
    </tbody>
</table>
```

- Implementasi tabel responsif di `peserta.php`
- Menampilkan data peserta dengan kolom: No, Nama, Umur, Jenis Kelamin, Pilihan Lomba, Waktu Daftar, Browser, IP Address

### 1.2 Event Handling (15%)

```javascript
// Form validation
function validateForm() {
  const nama = document.getElementById("nama").value;
  const umur = document.getElementById("umur").value;
  const nomorTelepon = document.getElementById("nomor_telepon").value;
  const pilihanLomba = document.getElementById("pilihan_lomba").value;

  // Validate each field
  if (!FormValidator.validateName(nama)) {
    showAlert("Nama harus minimal 3 karakter!", "error");
    return false;
  }

  if (!FormValidator.validateAge(umur)) {
    showAlert("Umur harus antara 5-60 tahun!", "error");
    return false;
  }

  if (!FormValidator.validatePhone(nomorTelepon)) {
    showAlert("Nomor telepon harus 10-13 digit angka!", "error");
    return false;
  }

  return true;
}

// Event Listeners
document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("registrationForm");

  // Add input event listeners
  const inputs = form.getElementsByTagName("input");
  for (let input of inputs) {
    input.addEventListener("input", function () {
      StateManager.saveToStorage(input.id, input.value);
    });
  }

  // Form submission
  form.addEventListener("submit", function (e) {
    if (!validateForm()) {
      e.preventDefault();
    }
  });
});
```

- **Event yang Diimplementasikan:**
  - `submit` event pada form untuk validasi sebelum pengiriman
  - `input` event pada semua input fields untuk menyimpan data sementara
  - `DOMContentLoaded` event untuk inisialisasi form dan animasi
  - `mouseenter/mouseleave` events untuk animasi kartu lomba
- **Validasi JavaScript:**
  - Validasi nama (minimal 3 karakter)
  - Validasi umur (5-60 tahun)
  - Validasi nomor telepon (10-13 digit)
  - Validasi pilihan lomba (harus dipilih)

## Bagian 2: Server-side Programming (30%)

### 2.1 Pengelolaan Data dengan PHP (20%)

```php
// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Server-side validation
    $nama = filter_input(INPUT_POST, 'nama', FILTER_SANITIZE_STRING);
    $umur = filter_input(INPUT_POST, 'umur', FILTER_VALIDATE_INT);
    $jenis_kelamin = filter_input(INPUT_POST, 'jenis_kelamin', FILTER_SANITIZE_STRING);
    $nomor_telepon = filter_input(INPUT_POST, 'nomor_telepon', FILTER_SANITIZE_STRING);
    $pilihan_lomba = filter_input(INPUT_POST, 'pilihan_lomba', FILTER_SANITIZE_STRING);

    // Get browser and IP information
    $browser = filter_var($_SERVER['HTTP_USER_AGENT'], FILTER_SANITIZE_STRING);
    $ip_address = filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP);

    if ($nama && $umur && $jenis_kelamin && $nomor_telepon && $pilihan_lomba) {
        try {
            $stmt = $conn->prepare("INSERT INTO peserta (nama_lengkap, umur, jenis_kelamin, nomor_telepon, pilihan_lomba, browser, ip_address) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sisssss", $nama, $umur, $jenis_kelamin, $nomor_telepon, $pilihan_lomba, $browser, $ip_address);

            if ($stmt->execute()) {
                $_SESSION['success_message'] = "Pendaftaran berhasil!";
                header("Location: peserta.php");
                exit();
            }
        } catch (Exception $e) {
            $_SESSION['error_message'] = "Terjadi kesalahan: " . $e->getMessage();
        }
    }
}
```

- **Metode Form:**
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
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "lomba_17agustus";
    private $conn;
    private static $instance = null;

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
    nama_lengkap VARCHAR(100) NOT NULL,
    umur INT NOT NULL CHECK (umur >= 5 AND umur <= 60),
    jenis_kelamin ENUM('Laki-laki', 'Perempuan') NOT NULL,
    nomor_telepon VARCHAR(15) NOT NULL,
    pilihan_lomba ENUM('Balap Karung', 'Panjat Pinang', 'Lomba Makan Kerupuk') NOT NULL,
    browser VARCHAR(100),
    ip_address VARCHAR(45),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_nama (nama_lengkap),
    INDEX idx_lomba (pilihan_lomba)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

### 3.2 Konfigurasi Database (5%)

```php
// Dalam class Database
private $host = "localhost";
private $username = "root";
private $password = "";
private $database = "lomba_17agustus";

try {
    $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);
    if ($this->conn->connect_error) {
        throw new Exception("Connection failed: " . $this->conn->connect_error);
    }
    $this->conn->set_charset("utf8");
} catch (Exception $e) {
    die("Connection error: " . $e->getMessage());
}
```

- Implementasi di class Database:
  - Host: localhost
  - Username: root
  - Database: lomba_17agustus
  - Charset: utf8mb4
  - Error handling dengan try-catch

### 3.3 Manipulasi Data (10%)

```php
session_start();

// Menyimpan pesan sukses/error dalam session
$_SESSION['success_message'] = "Pendaftaran berhasil!";
$_SESSION['error_message'] = "Terjadi kesalahan: " . $e->getMessage();

// Menampilkan pesan dari session
if (isset($_SESSION['success_message'])) {
    echo "<div class='alert success'>" . htmlspecialchars($_SESSION['success_message']) . "</div>";
    unset($_SESSION['success_message']);
}
```

- **Operasi CRUD:**
  - Create: Insert data peserta baru
  - Read: Menampilkan data peserta
  - Prepared statements untuk keamanan
  - Error handling komprehensif

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
// Cookie Management
const StateManager = {
  setCookie: (name, value, days) => {
    const d = new Date();
    d.setTime(d.getTime() + days * 24 * 60 * 60 * 1000);
    document.cookie = `${name}=${value};expires=${d.toUTCString()};path=/`;
  },
  getCookie: (name) => {
    const cookies = document.cookie.split(";");
    for (let cookie of cookies) {
      const [cookieName, cookieValue] = cookie.split("=");
      if (cookieName.trim() === name) {
        return cookieValue;
      }
    }
    return "";
  },
  deleteCookie: (name) => {
    document.cookie = `${name}=;expires=Thu, 01 Jan 1970 00:00:00 UTC;path=/;`;
  },

  // Local Storage functions
  saveToStorage: (key, value) => {
    localStorage.setItem(key, JSON.stringify(value));
  },
  getFromStorage: (key) => {
    const item = localStorage.getItem(key);
    return item ? JSON.parse(item) : null;
  },
};
```

- **Cookie Management:**
  - Fungsi `setCookie()`: Menyimpan cookie
  - Fungsi `getCookie()`: Membaca cookie
  - Fungsi `deleteCookie()`: Menghapus cookie
- **Local Storage:**
  - Menyimpan data form sementara
  - Restore data form dari storage
  - Pengelolaan state form

## Bonus: Hosting Aplikasi (20%)

### Langkah-langkah Hosting (5%)

1. Registrasi di Infinity Free
2. Verifikasi akun email
3. Membuat subdomain
4. Upload file via FTP
5. Konfigurasi database MySQL

### Pemilihan Hosting (5%)

Infinity Free dipilih karena:

- SSL gratis (HTTPS)
- PHP 8+ support
- MySQL database
- Unlimited bandwidth
- Zero cost hosting

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

- Implementasi HTTPS
- Prepared Statements
- Input validation & sanitization
- Password hashing (jika ada)
- XSS prevention
- CSRF protection

### Konfigurasi Server (5%)

```apache
# .htaccess
php_value upload_max_filesize 32M
php_value post_max_size 32M
php_value max_execution_time 300
php_value max_input_time 300

# Security headers
Header set X-Content-Type-Options "nosniff"
Header set X-Frame-Options "SAMEORIGIN"
Header set X-XSS-Protection "1; mode=block"
```

Sesuaikan konfigurasi database di `connection.php`

```php
class Database {
    private $host = "Sesuaikan dengan host di InfinityFree";          //Contoh : sql123.infinityfree.com
    private $username = "Sesuaikan dengan username di InfinityFree";  //Contoh : if0_37966636
    private $password = "Sesuaikan dengan password di InfinityFree";  //Contoh : AnakTampan123
    private $database = "Sesuaikan dengan database di InfinityFree";  //Contoh : if0_37966636_lomba_17agustus
    private $conn;
```

- PHP 8.0+
- MySQL 5.7+
- Apache/2.4
- mod_rewrite enabled
- Memory limit: 256MB
- Upload max filesize: 32MB

## Penggunaan Website

1. Clone repository ini
2. Import `lomba_17agustus.sql`
3. Sesuaikan konfigurasi database di `connection.php`
4. Akses melalui web server
