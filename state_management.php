<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengelolaan State dengan Cookie dan Local Storage</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <nav>
        <div class="nav-container">
            <h1>Pengelolaan State</h1>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="daftar.php">Daftar</a></li>
                <li><a href="peserta.php">Data Peserta</a></li>
                <li><a href="jadwal.php" class="active">Jadwal Liga</a></li>
                <li><a href="klasemen.html">Klasemen Liga</a></li>
                <li><a href="state_management.php" class="active">State Management</a></li>
            </ul>
        </div>
    </nav>

    <main>
        <div class="form-container">
            <h2>Kelola Cookie dan Local Storage</h2>

            <!-- Form untuk Cookie -->
            <h3>Pengelolaan Cookie</h3>
            <div class="form-group">
                <label for="cookie-key">Key</label>
                <input type="text" id="cookie-key" placeholder="Masukkan key">
            </div>
            <div class="form-group">
                <label for="cookie-value">Value</label>
                <input type="text" id="cookie-value" placeholder="Masukkan value">
            </div>
            <div class="form-group">
                <label for="cookie-days">Durasi (Hari)</label>
                <input type="number" id="cookie-days" placeholder="Masukkan durasi dalam hari">
            </div>
            <button onclick="setCookie()" class="btn-submit">Set Cookie</button>
            <button onclick="getCookie()" class="btn-submit">Get Cookie</button>
            <button onclick="deleteCookie()" class="btn-submit">Delete Cookie</button>

            <!-- Form untuk Local Storage -->
            <h3>Pengelolaan Local Storage</h3>
            <div class="form-group">
                <label for="local-key">Key</label>
                <input type="text" id="local-key" placeholder="Masukkan key">
            </div>
            <div class="form-group">
                <label for="local-value">Value</label>
                <input type="text" id="local-value" placeholder="Masukkan value">
            </div>
            <button onclick="setLocalStorage()" class="btn-submit">Set Local Storage</button>
            <button onclick="getLocalStorage()" class="btn-submit">Get Local Storage</button>
            <button onclick="deleteLocalStorage()" class="btn-submit">Delete Local Storage</button>

            <div class="output" id="output"></div>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 State Management Demo</p>
    </footer>

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
</body>
</html>
