<?php
require_once 'cek_login.php';
require_once '../config/database.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    mysqli_query($koneksi, "DELETE FROM kategori WHERE id_kategori = $id");
    $_SESSION['pesan'] = "Kategori berhasil dihapus.";
}
header('Location: kategori.php');
exit();
?>