<?php
require_once '../env.php';

 // Ambil ID dari URL untuk update produk

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $id = $_POST['id'];
    $nama_product = $_POST['nama_product'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $image = $_FILES['image'];

    // Set gambar default dari database jika tidak ada gambar baru
    $imageName = $product['image'];

    if (!empty($image['name'])) {
        // Handle upload file baru
        $targetDir = "../uploads/";
        $imageName = time() . '-' . basename($image['name']);
        $targetFile = $targetDir . $imageName;
        
        // Pindahkan file ke direktori tujuan
        if (move_uploaded_file($image['tmp_name'], $targetFile)) {
            // File berhasil diupload
        } else {
            echo "Gagal mengunggah gambar.";
            exit;
        }
    }

    // Query untuk update data produk
    $query = "UPDATE tb_product SET nama_product = '$nama_product', deskripsi = '$deskripsi', harga = '$harga', image = '$imageName' WHERE id = '$id'";

    // Cek apakah query berhasil dieksekusi
    if ($connection->query($query)) {
        // Redirect ke halaman index.php setelah berhasil update produk
        header("Location: view.php");
        exit;
    } else {
        // Jika gagal, tampilkan pesan error
        echo "Data Gagal Diperbarui!";
    }
}
?>
