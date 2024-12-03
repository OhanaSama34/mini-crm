<?php
require_once '../env.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $nama_product = $_POST['nama_product'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $image = $_FILES['image'];

    // Validasi data input
    if (empty($nama_product) || empty($deskripsi) || empty($harga)) {
        echo "Semua kolom wajib diisi!";
        exit;
    }

    // Proses upload gambar
    $imageName = null;
    if (!empty($image['name'])) {
        $targetDir = "../uploads/";
        $imageName = time() . '-' . basename($image['name']);
        $targetFile = $targetDir . $imageName;
        $allowedExtensions = ['jpg', 'jpeg', 'png'];

        // Validasi file gambar
        $fileExtension = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        if (!in_array($fileExtension, $allowedExtensions)) {
            echo "Format file gambar harus JPG, JPEG, atau PNG!";
            exit;
        }

        if ($image['size'] > 2 * 1024 * 1024) {
            echo "Ukuran file gambar maksimal 2MB.";
            exit;
        }

        // Pindahkan file gambar ke folder tujuan
        if (!move_uploaded_file($image['tmp_name'], $targetFile)) {
            echo "Gagal mengunggah gambar.";
            exit;
        }
    }

    // Query untuk menyimpan data produk
    $query = "INSERT INTO tb_product (nama_product, harga, deskripsi, image) 
              VALUES ('$nama_product', '$harga', '$deskripsi', '$imageName')";

    // Eksekusi query
    if ($connection->query($query)) {
        // Redirect ke halaman produk setelah berhasil menyimpan
        header("Location: view.php");
        exit;
    } else {
        echo "Data gagal disimpan! " . $connection->error;
    }
}
?>
