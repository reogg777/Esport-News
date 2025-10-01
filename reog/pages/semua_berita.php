<h2>Semua Berita</h2>
<p style="text-align: center; color: var(--secondary-text); margin-top:-10px; margin-bottom: 2rem;">Jelajahi semua berita terbaru dari dunia eSports.</p>

<div class="berita-grid">
    <?php
    // Ambil semua berita (misalnya, batasi 20 berita terbaru untuk performa)
    $query = "SELECT id, judul, LEFT(konten, 100) AS cuplikan, gambar FROM berita ORDER BY tanggal_publikasi DESC LIMIT 20";
    $result = mysqli_query($koneksi, $query);

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
                    <p><?php echo htmlspecialchars($row['cuplikan']); ?>...</p>
                    <a href="index.php?page=artikel&id=<?php echo $row['id']; ?>" class="baca-selengkapnya">Baca Selengkapnya</a>
                </div>
            </div>
    <?php
        }
    } else {
        echo "<p>Belum ada berita yang dipublikasikan.</p>";
    }
    ?>
</div>