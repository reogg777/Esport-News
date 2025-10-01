<?php
require_once 'cek_login.php';
require_once '../config/database.php';

// Proses tambah kategori jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tambah_kategori'])) {
    $nama_kategori = mysqli_real_escape_string($koneksi, $_POST['nama_kategori']);
    if (!empty($nama_kategori)) {
        mysqli_query($koneksi, "INSERT INTO kategori (nama_kategori) VALUES ('$nama_kategori')");
        $_SESSION['pesan'] = "Kategori baru berhasil ditambahkan.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Dashboard - Manajemen Kategori</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <div class="container">
        <h1>Dashboard Admin</h1>
        <div class="dashboard-nav">
            <a href="index.php">Manajemen Berita</a>
            <a href="kategori.php" class="nav-active">Manajemen Kategori</a>
            <a href="saran.php">Lihat Saran</a>
        </div>

        <h2>Manajemen Kategori Game</h2>

        <div class="form-container" style="max-width: 500px; margin-bottom: 2rem;">
            <form method="POST" action="">
                <div class="form-grup">
                    <label for="nama_kategori">Nama Kategori Baru</label>
                    <input type="text" id="nama_kategori" name="nama_kategori" required>
                </div>
                <button type="submit" name="tambah_kategori" class="btn">Tambah Kategori</button>
            </form>
        </div>

        <table class="crud-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Kategori</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY nama_kategori ASC");
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                                <td>{$row['id_kategori']}</td>
                                <td>".htmlspecialchars($row['nama_kategori'])."</td>
                                <td class='action-links'>
                                    <a href='kategori_hapus.php?id={$row['id_kategori']}' onclick=\"return confirm('Yakin ingin menghapus kategori ini?')\" class='hapus'>Hapus</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>Belum ada kategori.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>