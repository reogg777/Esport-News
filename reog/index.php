<?php
ini_set('display_errors', 1); // <-- TAMBAHKAN INI
error_reporting(E_ALL);  
// Memulai sesi jika diperlukan (berguna untuk notifikasi)
session_start();
// Memanggil file koneksi database
require_once 'config/database.php';

// Menentukan halaman default
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
?>
<!DOCTYPE html>
<html lang="id">
<meta http-equiv="refresh" content="0; url=berita/reog/">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Berita eSports</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <header>
       <nav>
    <a href="index.php?page=home" class="logo">ESPORTS NEWS</a>
    <ul>
        <li>
            <a href="index.php?page=home" class="<?php echo ($page == 'home' ? 'nav-active' : ''); ?>">Home</a>
        </li>
        <li>
            <a href="index.php?page=semua_berita" class="<?php echo ($page == 'semua_berita' ? 'nav-active' : ''); ?>">Artikel</a>
        </li>
        
        <li class="dropdown">
            <a href="index.php?page=semua_kategori" id="kategori-btn" class="<?php echo ($page == 'kategori' || $page == 'semua_kategori' ? 'nav-active' : ''); ?>">Kategori Game ▼</a>
            <div class="dropdown-content" id="kategori-content">
                <?php
                $kategori_nav_result = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY nama_kategori ASC");
                if ($kategori_nav_result) {
                    while ($kategori_nav = mysqli_fetch_assoc($kategori_nav_result)) {
                        echo "<a href='index.php?page=kategori&id={$kategori_nav['id_kategori']}'>" . htmlspecialchars($kategori_nav['nama_kategori']) . "</a>";
                    }
                }
                ?>
            </div>
        </li>
        
        <li>
            <a href="index.php?page=profil" class="<?php echo ($page == 'profil' ? 'nav-active' : ''); ?>">Profil</a>
        </li>
        <li>
            <a href="dashboard/index.php">Dashboard</a>
        </li>
    </ul>
</nav>
    </header>

    <main class="container">
        <?php
        // Mengarahkan ke file halaman yang sesuai
        $page_file = "pages/{$page}.php";
        if (file_exists($page_file)) {
            include $page_file;
        } else {
            // Jika file tidak ditemukan, tampilkan halaman 404 sederhana
            echo "<h1>404 - Halaman Tidak Ditemukan</h1>";
            echo "<p>Maaf, halaman yang Anda cari tidak ada.</p>";
        }
        ?>
    </main>

    <footer>
        <p>&copy; <?php echo date('Y'); ?> Portal Berita eSports. All Rights Reserved.</p>
    </footer>
<script>
        document.addEventListener('DOMContentLoaded', function() {
            var kategoriBtn = document.getElementById('kategori-btn');
            var kategoriContent = document.getElementById('kategori-content');

            kategoriBtn.onclick = function(event) {
                // Mencegah event klik menyebar ke window
                event.stopPropagation();
                // Toggle class 'show' untuk menampilkan/menyembunyikan dropdown
                kategoriContent.classList.toggle('show');
            }

            // Menutup dropdown jika user mengklik di luar area dropdown
            window.onclick = function(event) {
                if (!event.target.matches('#kategori-btn')) {
                    if (kategoriContent.classList.contains('show')) {
                        kategoriContent.classList.remove('show');
                    }
                }
            }
        });
    </script>
</body>
</html>