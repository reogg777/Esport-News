<?php
// Skrip untuk menambah view count. Diletakkan di paling atas.
if (isset($_GET['id'])) {
    $id_berita_view = (int)$_GET['id'];
    // Query update ini sangat cepat dan efisien
    $update_view_query = "UPDATE berita SET view_count = view_count + 1 WHERE id = ?";
    $stmt_view = mysqli_prepare($koneksi, $update_view_query);
    mysqli_stmt_bind_param($stmt_view, "i", $id_berita_view);
    mysqli_stmt_execute($stmt_view);
    mysqli_stmt_close($stmt_view);
}
?>
<div class="artikel-container">
    <?php
    if (isset($_GET['id'])) {
        $id_berita = (int)$_GET['id'];
        
        // --- Query diubah menggunakan LEFT JOIN untuk mengambil nama kategori ---
        $stmt = mysqli_prepare($koneksi, 
            "SELECT b.*, k.nama_kategori, k.id_kategori
             FROM berita b 
             LEFT JOIN kategori k ON b.id_kategori = k.id_kategori 
             WHERE b.id = ?"
        );
        
        mysqli_stmt_bind_param($stmt, "i", $id_berita);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            $berita = mysqli_fetch_assoc($result);
    ?>
            <h1><?php echo htmlspecialchars($berita['judul']); ?></h1>
            <div class="info">
                <span>Dipublikasikan pada: <?php echo date('d F Y', strtotime($berita['tanggal_publikasi'])); ?></span>
                
                <?php if (!empty($berita['nama_kategori'])): ?>
                    <span style="margin-left: 15px;">| Kategori: 
                        <a href="index.php?page=kategori&id=<?php echo $berita['id_kategori']; ?>" style="color: var(--accent-color);">
                            <?php echo htmlspecialchars($berita['nama_kategori']); ?>
                        </a>
                    </span>
                <?php endif; ?>
            </div>
               <div class="img">
            <?php
                 $gambar_path = 'uploads/' . $berita['gambar'];
                 if (!file_exists($gambar_path) || empty($berita['gambar'])) {
                    $gambar_path = 'assets/placeholder.jpg';
                }
            ?>
            <img src="<?php echo htmlspecialchars($gambar_path); ?>" alt="<?php echo htmlspecialchars($berita['judul']); ?>">
			  </div>
            <div class="konten">
                <p><?php echo nl2br(htmlspecialchars($berita['konten'])); ?></p>
            </div>
    <?php
        } else {
            echo "<h1>Artikel tidak ditemukan.</h1>";
        }
        mysqli_stmt_close($stmt);
        
    } else {
        echo "<h1>ID Artikel tidak valid.</h1>";
    }
    ?>
</div>