<?php
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<h1>Kategori tidak valid.</h1>";
    return;
}

$id_kategori = (int)$_GET['id'];

// --- Query yang aman menggunakan Prepared Statement ---
$stmt = mysqli_prepare($koneksi, 
    "SELECT b.*, k.nama_kategori 
     FROM berita b 
     JOIN kategori k ON b.id_kategori = k.id_kategori 
     WHERE b.id_kategori = ? 
     ORDER BY b.tanggal_publikasi DESC"
);

mysqli_stmt_bind_param($stmt, "i", $id_kategori);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Ambil nama kategori untuk judul halaman
$nama_kategori = "Tidak Ditemukan";
$first_row_check = mysqli_fetch_assoc($result);
if ($first_row_check) {
    $nama_kategori = $first_row_check['nama_kategori'];
    mysqli_data_seek($result, 0); // Kembalikan pointer hasil query ke awal
}
?>

<h2>Berita Kategori: <?php echo htmlspecialchars($nama_kategori); ?></h2>
<hr style="border-color: var(--border-color); margin-bottom: 2rem;">

<div class="berita-grid">
    <?php
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
    ?>
            <div class="berita-card">
                <?php
                $gambar_path = 'uploads/' . $row['gambar'];
                if (!file_exists($gambar_path) || empty($row['gambar'])) {
                    $gambar_path = 'assets/placeholder.jpg';
                }
                ?>
                <img src="<?php echo htmlspecialchars($gambar_path); ?>" alt="<?php echo htmlspecialchars($row['judul']); ?>">
                <div class="berita-card-content">
                    <h3><?php echo htmlspecialchars($row['judul']); ?></h3>
                    <a href="index.php?page=artikel&id=<?php echo $row['id']; ?>" class="baca-selengkapnya">Baca Selengkapnya</a>
                </div>
            </div>
    <?php
        }
    } else {
        echo "<p>Belum ada berita dalam kategori ini.</p>";
    }
    mysqli_stmt_close($stmt);
    ?>
</div>