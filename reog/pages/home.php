<div class="hero-section" style="background-image: url('https://images.unsplash.com/photo-1542751371-adc38448a05e?q=80&w=1740&auto=format&fit=crop');">
    <div class="hero-overlay">
        <h1>Portal Berita eSports</h1>
        <p>Sumber Informasi Terkini dari Dunia Kompetitif Gaming</p>
    </div>
</div>

<div class="home-section">
    <h2>Berita Terbaru</h2>
    <div class="berita-grid">
        <?php
        $query_terbaru = "SELECT * FROM berita ORDER BY tanggal_publikasi DESC LIMIT 3";
        $result_terbaru = mysqli_query($koneksi, $query_terbaru);
        if (mysqli_num_rows($result_terbaru) > 0) {
            while ($row = mysqli_fetch_assoc($result_terbaru)) {
                include 'parts/berita_card.php'; // Menggunakan template card
            }
        } else {
            echo "<p>Belum ada berita.</p>";
        }
        ?>
    </div>
</div>

<div class="home-section">
    <h2>Berita Terpopuler</h2>
    <div class="berita-grid">
        <?php
        $query_populer = "SELECT * FROM berita ORDER BY view_count DESC LIMIT 3";
        $result_populer = mysqli_query($koneksi, $query_populer);
        if (mysqli_num_rows($result_populer) > 0) {
            while ($row = mysqli_fetch_assoc($result_populer)) {
                include 'parts/berita_card.php'; // Menggunakan template card yang sama
            }
        } else {
            echo "<p>Belum ada berita yang populer.</p>";
        }
        ?>
    </div>
</div>