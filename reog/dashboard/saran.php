<?php
require_once 'cek_login.php'; // Keamanan: pastikan hanya admin yang bisa akses
require_once '../config/database.php'; // Koneksi ke database
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Lihat Saran</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <div class="container">
        <h1>Dashboard Admin</h1>

        <div class="dashboard-nav">
            <a href="index.php">Manajemen Berita</a>
            <a href="kategori.php">Manajemen Kategori</a>
            <a href="saran.php" class="nav-active">Lihat Saran</a>
        </div>

        <h2>Daftar Saran Masuk</h2>
        <table class="crud-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Pengirim</th>
                    <th>Isi Saran</th>
                    <th>Tanggal Kirim</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT * FROM saran ORDER BY tanggal_kirim DESC";
                $result = mysqli_query($koneksi, $query);

                if(mysqli_num_rows($result) > 0):
                    while($row = mysqli_fetch_assoc($result)):
                ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['nama']); ?></td>
                    <td><?php echo htmlspecialchars($row['saran_teks']); ?></td>
                    <td><?php echo $row['tanggal_kirim']; ?></td>
                </tr>
                <?php
                    endwhile;
                else:
                ?>
                <tr>
                    <td colspan="4">Belum ada saran yang masuk.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div style="margin-top: 20px;">
             <a href="../index.php" class="btn" style="background-color: #555;">Kembali ke Situs</a>
             <a href="logout.php" class="btn" style="background-color: #c94040;">Logout</a>
        </div>
    </div>
</body>
</html>