<?php
/**
 * Halaman jadwal liga top Eropa dengan fitur prediksi hasil pertandingan
 * Menampilkan data jadwal pertandingan dan pengelolaan prediksi user
 */
session_start();

class Prediction {
    private $predictions = [];

    public function addPrediction($match, $prediction) {
        $this->predictions[$match] = $prediction;
    }

    public function removePrediction($match) {
        unset($this->predictions[$match]);
    }

    public function getPredictions() {
        return $this->predictions;
    }
}

$predictionObj = new Prediction();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $match = filter_input(INPUT_POST, 'match', FILTER_SANITIZE_STRING);
    $prediction = filter_input(INPUT_POST, 'prediction', FILTER_SANITIZE_STRING);

    if ($action === 'add' && $match && $prediction) {
        $predictionObj->addPrediction($match, $prediction);
        $_SESSION['predictions'][$match] = $prediction;
    } elseif ($action === 'delete' && $match) {
        $predictionObj->removePrediction($match);
        unset($_SESSION['predictions'][$match]);
    }
}

$predictions = $_SESSION['predictions'] ?? [];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Jadwal liga top Eropa">
    <title>Jadwal Liga</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="shortcut icon" href="assets/images/Logo.png" type="image/x-icon">
</head>
<body>
    <nav>
        <div class="nav-container">
            <h1>Sepak Bola</h1>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="daftar.php">Daftar</a></li>
                <li><a href="peserta.php">Data Peserta</a></li>
                <li><a href="jadwal.php" class="active">Jadwal Liga</a></li>
                <li><a href="klasemen.html">Klasemen Liga</a></li>
                <li><a href="state_management.php">State Management</a></li>
            </ul>
        </div>
    </nav>

    <main>
        <div class="table-container">
            <h2>Jadwal Liga Top Eropa</h2>
            <table>
                <thead>
                    <tr>
                        <th>Pertandingan</th>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Lokasi</th>
                        <th>Prediksi Anda</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $matches = [
                        "Manchester United vs Liverpool" => "25 Desember 2024",
                        "Real Madrid vs Barcelona" => "26 Desember 2024",
                        "Bayern Munich vs Borussia Dortmund" => "27 Desember 2024",
                        "Paris Saint-Germain vs Olympique Lyonnais" => "28 Desember 2024",
                    ];
                    foreach ($matches as $match => $date):
                        $time = "20:00 WIB"; // Default time
                        $location = "Stadion Utama"; // Default location
                        $userPrediction = $predictions[$match] ?? "Belum ada prediksi";
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($match); ?></td>
                        <td><?php echo htmlspecialchars($date); ?></td>
                        <td><?php echo htmlspecialchars($time); ?></td>
                        <td><?php echo htmlspecialchars($location); ?></td>
                        <td><?php echo htmlspecialchars($userPrediction); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="form-container">
            <h2>Kelola Prediksi Anda</h2>
            <form method="POST" action="jadwal.php">
                <div class="form-group">
                    <label for="match">Pilih Pertandingan</label>
                    <select id="match" name="match" required>
                        <option value="">Pilih pertandingan</option>
                        <?php foreach (array_keys($matches) as $match): ?>
                            <option value="<?php echo htmlspecialchars($match); ?>">
                                <?php echo htmlspecialchars($match); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="prediction">Prediksi Anda</label>
                    <input type="text" id="prediction" name="prediction" placeholder="Masukkan prediksi" required>
                </div>

                <button type="submit" name="action" value="add" class="btn-submit">Tambahkan Prediksi</button>
                <button type="submit" name="action" value="delete" class="btn-submit">Hapus Prediksi</button>
            </form>
        </div>

        <div class="table-container">
            <h2>Daftar Prediksi Anda</h2>
            <table>
                <thead>
                    <tr>
                        <th>Pertandingan</th>
                        <th>Prediksi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($predictions)): ?>
                        <?php foreach ($predictions as $match => $prediction): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($match); ?></td>
                            <td><?php echo htmlspecialchars($prediction); ?></td>
                            <td>
                                <form method="POST" action="jadwal.php">
                                    <input type="hidden" name="match" value="<?php echo htmlspecialchars($match); ?>">
                                    <button type="submit" name="action" value="delete" class="btn-submit">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3">Belum ada prediksi yang ditambahkan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>

    <footer>
        <p>&copy; William Chan_122140130_RA. All rights reserved.</p>
    </footer>
</body>
</html>
