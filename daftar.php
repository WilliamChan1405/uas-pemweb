<?php
/**
 * Halaman pendaftaran tim sepak bola favorit
 * Menangani input form dan validasi data peserta
 */
session_start();
require_once 'connection.php';

// Handle form submission
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

    // Validate all required fields
    if ($nama && $umur && $tim_favorit && $nomor_telepon) {
        try {
            // Prepare statement to prevent SQL injection
            $stmt = $conn->prepare("INSERT INTO peserta (nama, umur, tim_favorit, nomor_telepon, browser, ip_address) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sissss", $nama, $umur, $tim_favorit, $nomor_telepon, $browser, $ip_address);
            
            if ($stmt->execute()) {
                $_SESSION['success_message'] = "Pendaftaran berhasil!";
                setcookie("last_registration", $nama, time() + (86400 * 30), "/");
                header("Location: peserta.php");
                exit();
            } else {
                throw new Exception("Gagal menyimpan data");
            }
        } catch (Exception $e) {
            $_SESSION['error_message'] = "Terjadi kesalahan: " . $e->getMessage();
        } finally {
            if (isset($stmt)) {
                $stmt->close();
            }
        }
    } else {
        $_SESSION['error_message'] = "Semua field harus diisi dengan benar!";
    }
    $db->closeConnection();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Formulir pendaftaran tim sepak bola favorit">
    <title>Daftar Tim Sepak Bola Favorit</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="shortcut icon" href="assets/images/Logo.png" type="image/x-icon">
</head>
<body>
    <nav>
        <div class="nav-container">
            <h1>Sepak Bola</h1>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="daftar.php" class="active">Daftar</a></li>
                <li><a href="peserta.php">Data Peserta</a></li>
                <li><a href="jadwal.php">Jadwal Liga</a></li>
                <li><a href="klasemen.html">Klasemen Liga</a></li>
                <li><a href="state_management.php">State Management</a></li>
            </ul>
        </div>
    </nav>

    <main>
        <div class="form-container">
            <h2>Formulir Pendaftaran</h2>
            <?php if (isset($_SESSION['error_message'])): ?>
                <div class="alert error">
                    <?php 
                        echo htmlspecialchars($_SESSION['error_message']);
                        unset($_SESSION['error_message']);
                    ?>
                </div>
            <?php endif; ?>
            
            <form id="registrationForm" method="POST" action="daftar.php" onsubmit="return validateForm()">
                <div class="form-group">
                    <label for="nama">Nama Lengkap</label>
                    <input type="text" id="nama" name="nama" required 
                           placeholder="Nama minimal 3 karakter"
                           pattern=".{3,}"
                           title="Minimal 3 karakter">
                </div>

                <div class="form-group">
                    <label for="umur">Umur</label>
                    <input type="number" id="umur" name="umur" required 
                           min="5" max="60"
                           placeholder="Umur minimal 5 tahun dan maksimal 60 tahun">
                </div>

                <div class="form-group">
                    <label for="tim_favorit">Tim Sepak Bola Favorit</label>
                    <select id="tim_favorit" name="tim_favorit" required>
                        <option value="">Pilih tim favorit</option>
                        <option value="Manchester United">Manchester United</option>
                        <option value="Real Madrid">Real Madrid</option>
                        <option value="Barcelona">Barcelona</option>
                        <option value="Liverpool">Liverpool</option>
                        <option value="Bayern Munich">Bayern Munich</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="nomor_telepon">Nomor Telepon</label>
                    <input type="tel" id="nomor_telepon" name="nomor_telepon" required 
                           pattern="[0-9]{10,13}"
                           placeholder="Nomor telepon harus 10-13 digit angka"
                           title="Nomor telepon harus 10-13 digit angka">
                </div>

                <button type="submit" class="btn-submit">Daftar</button>
            </form>
        </div>
    </main>

    <footer>
        <p>&copy; William Chan_122140130_RA</p>
    </footer>

    <script src="script.js"></script>
</body>
</html>
