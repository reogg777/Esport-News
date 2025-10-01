<?php
// Mulai session di setiap halaman yang diamankan
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cek apakah session login ada dan bernilai true
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    // Jika tidak, simpan pesan error dan redirect ke halaman login
    $_SESSION['error_message'] = "Anda harus login untuk mengakses halaman ini.";
    header('Location: ../login.php');
    exit();
}
?>