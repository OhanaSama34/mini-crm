<?php
require_once '../env.php';

// Jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $activity_id = $_POST['activity_id'];
    $deskripsi = $_POST['deskripsi'];
    $tanggal = $_POST['tanggal'];
    $user_interest_id = $_POST['user_interest_id'];

    // Validasi input
    if (empty($activity_id) || empty($deskripsi) || empty($tanggal)) {
        $error_message = "Semua kolom wajib diisi!";
    } else {
        // Masukkan data ke database
        $query_insert = "INSERT INTO tb_marketing_activity (user_interest_id, activity_id, deskripsi, tanggal, admin_id) 
                         VALUES ('$user_interest_id', '$activity_id', '$deskripsi', '$tanggal', '1')";
        if (mysqli_query($connection, $query_insert)) {
            $success_message = "Aktivitas berhasil ditambahkan!";
        } else {
            $error_message = "Terjadi kesalahan, coba lagi.";
        }
    }
}
?>