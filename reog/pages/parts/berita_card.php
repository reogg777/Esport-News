<?php
// File: pages/parts/berita_card.php
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
        <p><?php echo substr(strip_tags($row['konten']), 0, 80); ?>...</p>
        <a href="index.php?page=artikel&id=<?php echo $row['id']; ?>" class="baca-selengkapnya">Baca Selengkapnya</a>
    </div>
</div>