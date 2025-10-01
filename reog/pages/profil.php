<?php
// Variabel untuk pesan notifikasi
$pesan = '';

// Proses form jika ada data yang dikirim (method POST)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama']; // <-- TIDAK AMAN
    $saran_teks = $_POST['saran_teks']; // <-- TIDAK AMAN

    // --- CARA TIDAK AMAN ---
    $query_insert_saran = "INSERT INTO saran (nama, saran_teks) VALUES ('$nama', '$saran_teks')";

    if (mysqli_query($koneksi, $query_insert_saran)) {
        $pesan = "Terima kasih atas saran Anda!";
    } else {
        $pesan = "Gagal mengirim saran: " . mysqli_error($koneksi);
    }

    // --- CARA AMAN ---
    /*
    $nama_aman = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $saran_aman = mysqli_real_escape_string($koneksi, $_POST['saran_teks']);
    $stmt = mysqli_prepare($koneksi, "INSERT INTO saran (nama, saran_teks) VALUES (?, ?)");
    mysqli_stmt_bind_param($stmt, "ss", $nama_aman, $saran_aman);
    if (mysqli_stmt_execute($stmt)) {
        $pesan = "Terima kasih atas saran Anda!";
    } else {
        $pesan = "Gagal mengirim saran.";
    }
    */
}
?>

<div class="profil-container">
    <h2>Profil Kami</h2>
    <p>Selamat datang di Portal Berita eSports. Kami berdedikasi untuk menyajikan berita terbaru, analisis mendalam, dan update turnamen dari dunia eSports global dan lokal. Misi kami adalah menjadi sumber informasi terpercaya bagi para gamer dan penggemar eSports di seluruh Indonesia.</p>
    
    <hr style="border-color: var(--border-color); margin: 2rem 0;">

    <h2>Kirim Saran</h2>
    <p>Punya masukan atau saran untuk kami? Jangan ragu untuk mengirimkannya melalui form di bawah ini.</p>
    
    <?php if ($pesan): ?>
        <p style="color: var(--accent-color); background-color: var(--secondary-surface); padding: 10px; border-radius: 5px; margin-top: 15px;"><?php echo $pesan; ?></p>
    <?php endif; ?>

    <div class="form-container" style="margin-top: 20px;">
        <form action="index.php?page=profil" method="POST">
            <div class="form-grup">
                <label for="nama">Nama Anda</label>
                <input type="text" id="nama" name="nama" required>
            </div>
            <div class="form-grup">
                <label for="saran_teks">Saran Anda</label>
                <textarea id="saran_teks" name="saran_teks" rows="5" required></textarea>
            </div>
            <button type="submit" class="btn">Kirim Saran</button>
        </form>
    </div>
</div>