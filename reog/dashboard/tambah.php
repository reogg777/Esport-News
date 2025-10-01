<?php require_once 'cek_login.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Tambah Berita</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <div class="container">
        <h1>Tambah Berita Baru</h1>
        <div class="form-container">
            <form action="aksi_crud.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="aksi" value="tambah">
                <div class="form-grup">
                    <label for="judul">Judul Berita</label>
                    <input type="text" id="judul" name="judul" required>
                </div>
                <div class="form-grup">
    <label for="konten">Konten</label>
    <textarea id="konten" name="konten" rows="10" required></textarea>
</div>

<div class="form-grup">
    <label for="id_kategori">Kategori</label>
    <select id="id_kategori" name="id_kategori" required>
        <option value="">-- Pilih Kategori --</option>
        <?php
        require '../config/database.php';
        $kategori_result = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY nama_kategori");
        while ($kategori = mysqli_fetch_assoc($kategori_result)) {
            echo "<option value='{$kategori['id_kategori']}'>" . htmlspecialchars($kategori['nama_kategori']) . "</option>";
        }
        ?>
    </select>
</div>

<div class="form-grup">
    <label for="gambar">Upload Gambar</label>
    <input type="file" id="gambar" name="gambar">
</div>
                <button type="submit" class="btn">Simpan Berita</button>
                <a href="index.php" style="margin-left: 10px; color: var(--secondary-text);">Batal</a>
            </form>
        </div>
    </div>
</body>
</html>