<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tim Sepak Bola Favorit</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="shortcut icon" href="assets/images/Logo.png" type="image/x-icon">
</head>   

<body>
    <nav>
        <div class="nav-container">
            <h1>Sepak Bola</h1>
            <ul>
                <li><a href="index.php" class="active">Home</a></li>
                <li><a href="daftar.php">Daftar</a></li>
                <li><a href="tim_favorit.php">Data Peserta</a></li>
                <li><a href="jadwal.php">Jadwal Liga</a></li>
                <li><a href="klasemen.html">Klasemen Liga</a></li>
                <li><a href="state_management.php">State Management</a></li>
            </ul>
        </div>
    </nav>

    <main>
        <div class="hero">
            <h1>Selamat Datang di Fans Club Sepak Bola</h1>
            <p>Temukan tim favorit Anda, daftarkan diri, dan nikmati jadwal pertandingan liga top Eropa!</p>
            <div class="cta-button">
                <a href="daftar.php" class="btn-daftar">Daftar Sekarang</a>
            </div>
        </div>

        <section class="team-info">
            <h2>Tim Favorit</h2>
            <div class="team-grid">
            <div class="team-card">
            <img src="assets/images/mu.png" alt="Manchester United" class="team-logo">
            <h3>Manchester United</h3>
            <p>Tim legendaris dengan sejarah gemilang di Premier League.</p>
        </div>
            <div class="team-card">
            <img src="assets/images/realmadrid.png" alt="Real Madrid" class="team-logo">
            <h3>Real Madrid</h3>
            <p>Raja Eropa dengan koleksi gelar Liga Champions terbanyak.</p>
        </div>
        <div class="team-card">
            <img src="assets/images/badut.png" alt="Barcelona" class="team-logo">
            <h3>Barcelona</h3>
            <p>Tim penuh gaya dengan permainan tiki-taka yang memukau.</p>
    </div>
            </div>
        </section>

        <section class="league-info">
            <h2>Jadwal Liga Top Eropa</h2>
            <p>Klik pada menu "Jadwal Liga" untuk melihat pertandingan terbaru dan detailnya.</p>
        </section>
    </main>

    <footer>
        <p>&copy; William Chan_122140130_RA. All rights reserved.</p>
    </footer>

    <script src="script.js"></script>
</body>
</html>
