<?php
require_once 'cek_login.php';
require_once '../config/database.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Manajemen Berita</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <div class="container">
        <h1>Dashboard Admin</h1>
        <div class="dashboard-nav">
            <a href="index.php" class="nav-active">Manajemen Berita</a>
            <a href="kategori.php">Manajemen Kategori</a>
            <a href="saran.php">Lihat Saran</a> 
        </div>

        <h2>Manajemen Berita</h2>
        <a href="tambah.php" class="btn">Tambah Berita Baru</a>
        <a href="../index.php" class="btn" style="background-color: #555;">Kembali ke Situs</a>
        <a href="logout.php" class="btn" style="background-color: #c94040;">Logout</a>

        <?php if(isset($_SESSION['pesan'])): ?>
            <p style="background: #2c2c2c; padding: 10px; margin-top: 15px; border-radius: 5px; color: var(--accent-color);"><?php echo $_SESSION['pesan']; unset($_SESSION['pesan']); ?></p>
        <?php endif; ?>

        <table class="crud-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Judul</th>
                    <th>Kategori</th> <th>Tanggal Publikasi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // ## QUERY DIUBAH UNTUK MENGAMBIL NAMA KATEGORI ##
                $query = "SELECT b.id, b.judul, b.tanggal_publikasi, k.nama_kategori 
                          FROM berita b 
                          LEFT JOIN kategori k ON b.id_kategori = k.id_kategori 
                          ORDER BY b.id DESC";
                $result = mysqli_query($koneksi, $query);
                if(mysqli_num_rows($result) > 0):
                    while($row = mysqli_fetch_assoc($result)):
                ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['judul']); ?></td>
                    <td><?php echo htmlspecialchars($row['nama_kategori'] ?? 'Tanpa Kategori'); ?></td>
                    <td><?php echo $row['tanggal_publikasi']; ?></td>
                    <td class="action-links">
                        <a href="edit.php?id=<?php echo $row['id']; ?>">Edit</a>
                        <a href="hapus.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Apakah Anda yakin?');" class="hapus">Hapus</a>
                    </td>
                </tr>
                <?php
                    endwhile;
                else:
                ?>
                <tr>
                    <td colspan="5">Belum ada berita.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>