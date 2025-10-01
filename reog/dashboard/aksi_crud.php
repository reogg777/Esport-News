<?php
require_once 'cek_login.php';
require_once '../config/database.php';

// Fungsi upload gambar yang disempurnakan
function uploadGambar() {
    // Jika tidak ada file yang dipilih sama sekali, kembalikan NULL (sukses, tidak ada gambar)
    if ($_FILES['gambar']['error'] === UPLOAD_ERR_NO_FILE) {
        return null;
    }

    // Jika ada error lain saat upload
    if ($_FILES['gambar']['error'] !== UPLOAD_ERR_OK) {
        $_SESSION['pesan'] = "Terjadi error saat upload gambar.";
        return false;
    }

    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $tmpName = $_FILES['gambar']['tmp_name'];
    
    // Cek ekstensi
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png', 'gif'];
    $ekstensiGambar = strtolower(end(explode('.', $namaFile)));
    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        $_SESSION['pesan'] = "Upload gagal! File harus berupa gambar (jpg, jpeg, png, gif).";
        return false;
    }

    // Cek ukuran
    if ($ukuranFile > 2000000) { // 2MB
        $_SESSION['pesan'] = "Upload gagal! Ukuran gambar maksimal adalah 2MB.";
        return false;
    }

    // Generate nama baru dan pindahkan file
    $namaFileBaru = uniqid() . '.' . $ekstensiGambar;
    if (move_uploaded_file($tmpName, '../uploads/' . $namaFileBaru)) {
        return $namaFileBaru;
    } else {
        $_SESSION['pesan'] = "Gagal memindahkan file yang diupload.";
        return false;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['aksi'])) {
    $aksi = $_POST['aksi'];

    if ($aksi == 'tambah') {
        $gambar = uploadGambar();
        
        // Jika uploadGambar() mengembalikan false, berarti ada error validasi
        if ($gambar === false) {
            header('Location: tambah.php');
            exit();
        }
        
        $stmt = mysqli_prepare($koneksi, "INSERT INTO berita (judul, konten, gambar, id_kategori) VALUES (?, ?, ?, ?)");
        // 's' untuk string, 'i' untuk integer. 'gambar' bisa jadi NULL, tetap 's'.
        mysqli_stmt_bind_param($stmt, "sssi", $_POST['judul'], $_POST['konten'], $gambar, $_POST['id_kategori']);
        
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['pesan'] = "Berita baru berhasil ditambahkan.";
        } else {
            $_SESSION['pesan'] = "Gagal menambahkan berita ke database.";
        }
        mysqli_stmt_close($stmt);

    } elseif ($aksi == 'edit') {
        // Logika edit sama seperti sebelumnya dan sudah bisa menangani gambar opsional
        $gambar_lama = $_POST['gambar_lama'];
        $gambar_baru = uploadGambar();
        
        if ($gambar_baru === false) {
            header('Location: edit.php?id=' . $_POST['id']);
            exit();
        }

        $gambar_final = $gambar_baru ?? $gambar_lama;

        $stmt = mysqli_prepare($koneksi, "UPDATE berita SET judul=?, konten=?, gambar=?, id_kategori=? WHERE id=?");
        mysqli_stmt_bind_param($stmt, "sssii", $_POST['judul'], $_POST['konten'], $gambar_final, $_POST['id_kategori'], $_POST['id']);
        
        if (mysqli_stmt_execute($stmt)) {
            if ($gambar_baru !== null && !empty($gambar_lama) && file_exists('../uploads/' . $gambar_lama)) {
                unlink('../uploads/' . $gambar_lama);
            }
            $_SESSION['pesan'] = "Berita berhasil diperbarui.";
        } else {
            $_SESSION['pesan'] = "Gagal memperbarui berita.";
        }
        mysqli_stmt_close($stmt);
    }
}

header('Location: index.php');
exit();