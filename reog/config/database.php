<?php
// Konfigurasi Database
$db_host = 'db4free.net';
$db_user = 'reog777'; // Ganti dengan username database Anda
$db_pass = 'reog777+';     // Ganti dengan password database Anda
$db_name = 'reog777'; // Ganti dengan nama database Anda

// Membuat koneksi
$koneksi = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// Cek koneksi
if (!$koneksi) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}
?>