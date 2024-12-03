<?php
session_start();
require_once 'env.php'; // Koneksi ke database

// Inisialisasi variabel session untuk login attempt
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
    $_SESSION['lock_time'] = 0;
}

// Cek apakah user sedang dalam masa blokir
if ($_SESSION['login_attempts'] >= 3 && time() - $_SESSION['lock_time'] < 300) {
    $_SESSION['login_error'] = "Terlalu banyak percobaan login gagal. Coba lagi dalam 5 menit.";
    header("Location: login.php");
    exit();
}

// Ambil data dari form login
$username = mysqli_real_escape_string($connection, $_POST['username']);
$password = mysqli_real_escape_string($connection, $_POST['password']);

// Hash password yang diinput pengguna
$hashed_input_password = hash('sha256', $password);

// Query untuk mendapatkan data admin berdasarkan username
$query = "SELECT nama, passwd FROM tb_admin WHERE nama = '$username'";
$result = mysqli_query($connection, $query);

// Cek apakah username ditemukan
if (mysqli_num_rows($result) > 0) {
    $admin = mysqli_fetch_assoc($result);

    // Verifikasi password
    if ($hashed_input_password === $admin['passwd']) {
        // Reset login attempts setelah login berhasil
        $_SESSION['login_attempts'] = 0;
        $_SESSION['lock_time'] = 0;

        // Set session untuk login dan role
        $_SESSION['logged_in'] = true;
        $_SESSION['role'] = 'admin'; // Role bisa ditambahkan jika tabel memiliki kolom role
        header("Location: dashboard.php");
        exit();
    } else {
        // Password salah, tambahkan login attempt
        $_SESSION['login_attempts']++;
        if ($_SESSION['login_attempts'] >= 3) {
            $_SESSION['lock_time'] = time(); // Catat waktu blokir
            $_SESSION['login_error'] = "Terlalu banyak percobaan login gagal. Coba lagi dalam 5 menit.";
        } else {
            $_SESSION['login_error'] = "Password salah!";
        }
    }
} else {
    // Username tidak ditemukan
    $_SESSION['login_attempts']++;
    if ($_SESSION['login_attempts'] >= 3) {
        $_SESSION['lock_time'] = time(); // Catat waktu blokir
        $_SESSION['login_error'] = "Terlalu banyak percobaan login gagal. Coba lagi dalam 5 menit.";
    } else {
        $_SESSION['login_error'] = "Username tidak ditemukan!";
    }
}

// Redirect kembali ke halaman login jika gagal
header("Location: login.php");
exit();
?>
