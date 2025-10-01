<?php
session_start();
require_once 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Gunakan prepared statement untuk mencegah SQL Injection
    $stmt = mysqli_prepare($koneksi, "SELECT id, username, password FROM admin WHERE username = ?");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) === 1) {
        $admin = mysqli_fetch_assoc($result);

        // Verifikasi password yang di-hash
        if (password_verify($password, $admin['password'])) {
            // Login sukses, buat session
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];

            // Redirect ke dashboard
            header('Location: dashboard/index.php');
            exit();
        }
    }

    // Jika username tidak ditemukan atau password salah
    $_SESSION['error_message'] = 'Username atau password salah.';
    header('Location: login.php');
    exit();
}
?>