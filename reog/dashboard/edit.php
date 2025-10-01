<?php
require_once 'cek_login.php';
require_once '../config/database.php';
// Pastikan ID ada
if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit();
}
$id = $_GET['id'];
// Ambil data berita dari DB
$query = "SELECT * FROM berita WHERE id = $id"; // <-- TIDAK AMAN
$result = mysqli_query($koneksi, $query);
$berita = mysqli_fetch_assoc($result);
if (!$berita) {
    echo "Berita tidak ditemukan!";
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Edit Berita</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <div class="container">
        <h1>Edit Berita</h1>
        <div class="form-container">
            <form action="aksi_crud.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="aksi" value="edit">
                <input type="hidden" name="id" value="<?php echo $berita['id']; ?>">
                <input type="hidden" name="gambar_lama" value="<?php echo htmlspecialchars($berita['gambar']); ?>">
                
                <div class="form-grup">
                    <label for="judul">Judul Berita</label>
                    <input type="text" id="judul" name="judul" value="<?php echo htmlspecialchars($berita['judul']); ?>" required>
                </div>
                <div class="form-grup">
                    <label for="konten">Konten</label>
                    <textarea id="konten" name="konten" rows="10" required><?php echo htmlspecialchars($berita['konten']); ?></textarea>
                </div>
				<div class="form-grup">
            <label for="id_kategori">Kategori</label>
     <select id="id_kategori" name="id_kategori" required>
        <option value="">-- Pilih Kategori --</option>
        <?php
        $kategori_result = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY nama_kategori");
        while ($kategori = mysqli_fetch_assoc($kategori_result)) {
            $selected = ($berita['id_kategori'] == $kategori['id_kategori']) ? 'selected' : '';
            echo "<option value='{$kategori['id_kategori']}' $selected>" . htmlspecialchars($kategori['nama_kategori']) . "</option>";
        }
        ?>
    </select>
</div>
                <div class="form-grup">
                    <label>Gambar Saat Ini</label>
                    <img src="../uploads/<?php echo htmlspecialchars($berita['gambar']); ?>" width="150" alt="Gambar saat ini">
                </div>
                <div class="form-grup">
                    <label for="gambar">Upload Gambar Baru (kosongkan jika tidak ingin ganti)</label>
                    <input type="file" id="gambar" name="gambar">
                </div>
                <button type="submit" class="btn">Update Berita</button>
                <a href="index.php" style="margin-left: 10px; color: var(--secondary-text);">Batal</a>
            </form>
        </div>
    </div>
</body>
</html>