<?php
require_once 'cek_login.php';
require_once '../config/database.php';

// Pastikan ada ID yang dikirim
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // 1. Ambil nama file gambar dari database SEBELUM menghapus datanya
    // Menggunakan prepared statement agar lebih aman
    $stmt_select = mysqli_prepare($koneksi, "SELECT gambar FROM berita WHERE id = ?");
    mysqli_stmt_bind_param($stmt_select, "i", $id);
    mysqli_stmt_execute($stmt_select);
    $result = mysqli_stmt_get_result($stmt_select);
    
    if ($row = mysqli_fetch_assoc($result)) {
        $nama_file_gambar = $row['gambar'];

        // 2. Hapus data berita dari database
        $stmt_delete = mysqli_prepare($koneksi, "DELETE FROM berita WHERE id = ?");
        mysqli_stmt_bind_param($stmt_delete, "i", $id);
        
        if (mysqli_stmt_execute($stmt_delete)) {
            // 3. Jika data di database berhasil dihapus, hapus file gambarnya dari folder
            $path_gambar = '../uploads/' . $nama_file_gambar;
            if (file_exists($path_gambar)) {
                unlink($path_gambar); // Fungsi untuk menghapus file
            }
            $_SESSION['pesan'] = "Berita dan file gambar berhasil dihapus.";
        } else {
            $_SESSION['pesan'] = "Gagal menghapus berita dari database.";
        }
        mysqli_stmt_close($stmt_delete);

    } else {
        $_SESSION['pesan'] = "Data berita tidak ditemukan.";
    }
    mysqli_stmt_close($stmt_select);

} else {
    $_SESSION['pesan'] = "Permintaan tidak valid, ID tidak ditemukan.";
}

// Redirect kembali ke halaman utama dashboard
header('Location: index.php');
exit();
?>