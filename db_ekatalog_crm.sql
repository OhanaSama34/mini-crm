-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 03 Des 2024 pada 14.00
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_ekatalog_crm`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_activity`
--

CREATE TABLE `tb_activity` (
  `id` int(11) NOT NULL,
  `nama_activity` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_activity`
--

INSERT INTO `tb_activity` (`id`, `nama_activity`) VALUES
(1, 'Follow-Up via Email'),
(2, 'Follow-Up via WhatsApp'),
(3, 'Penawaran Khusus via Email'),
(4, 'Penawaran Khusus via WhatsApp'),
(5, 'Reminder Pembelian via Email'),
(6, 'Reminder Pembelian via WhatsApp'),
(7, 'Permintaan Feedback via Email'),
(8, 'Permintaan Feedback via WhatsApp'),
(9, 'Ucapan Personal via Email'),
(10, 'Ucapan Personal via WhatsApp'),
(11, 'Pengiriman Edukasi Produk via Email'),
(12, 'Pengiriman Edukasi Produk via WhatsApp'),
(13, 'Penawaran Upselling via Email'),
(14, 'Penawaran Upselling via WhatsApp');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_admin`
--

CREATE TABLE `tb_admin` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `passwd` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_admin`
--

INSERT INTO `tb_admin` (`id`, `nama`, `passwd`, `role`) VALUES
(1, 'nflrdtya', 'ef92b778bafe771e89245b89ecbc08a44a4e166c06659911881f383d4473e94f', 'admin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_marketing_activity`
--

CREATE TABLE `tb_marketing_activity` (
  `id` int(11) NOT NULL,
  `user_interest_id` varchar(30) NOT NULL,
  `activity_id` int(11) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `tanggal` date NOT NULL,
  `admin_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_marketing_activity`
--

INSERT INTO `tb_marketing_activity` (`id`, `user_interest_id`, `activity_id`, `deskripsi`, `tanggal`, `admin_id`) VALUES
(1, '6281280717437', 3, 'Mencoba memberikan brosur produk', '2024-12-03', 1),
(2, '6281280717437', 11, 'Follup ulang via wa', '2024-12-03', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_product`
--

CREATE TABLE `tb_product` (
  `id` int(11) NOT NULL,
  `nama_product` varchar(255) NOT NULL,
  `harga` int(50) NOT NULL,
  `deskripsi` varchar(255) NOT NULL,
  `image` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_product`
--

INSERT INTO `tb_product` (`id`, `nama_product`, `harga`, `deskripsi`, `image`) VALUES
(2, 'Iphone 13', 10000000, 'Iphone 13 brand new inbox', '1732699621-iPhone.jpg'),
(3, 'Hp', 5000000, 'Brand New In Box', '1732699707-DM_3C2216949B86BC3158C08D979F24C203_140324150310_ll.jpg'),
(4, 'Laptop Hp Victus 15 inchi', 15000000, 'Laptop Gaming Kapasitas 1TB', '1733167655-HP-Victus-15-Mica-Silver-3.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_user_interest`
--

CREATE TABLE `tb_user_interest` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `no_telp` varchar(20) DEFAULT NULL,
  `produk_id` int(11) DEFAULT NULL,
  `message` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_user_interest`
--

INSERT INTO `tb_user_interest` (`id`, `name`, `no_telp`, `produk_id`, `message`, `email`) VALUES
(1, 'Noufal Radhitya', '6281280717437', 2, 'Test Message', 'noufalgamer124@gmail.com'),
(2, 'Noufal Radhitya', '6281280717437', 3, 'Test Message 2', 'donmaloch98@gmail.com'),
(3, 'Albian', '62895421389238', 2, 'Saya tertarik dengan ini, bisakah saya mendapatkan brosurnya', 'noufalgamer@students.unnes.ac.id'),
(4, 'Noufal Radhitya', '6281280717437', 4, 'Saya tertarik dengan produk ini', 'noufalgamer124@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_activity`
--
ALTER TABLE `tb_activity`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_admin`
--
ALTER TABLE `tb_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_marketing_activity`
--
ALTER TABLE `tb_marketing_activity`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_id` (`activity_id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indeks untuk tabel `tb_product`
--
ALTER TABLE `tb_product`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_user_interest`
--
ALTER TABLE `tb_user_interest`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produk_id` (`produk_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_activity`
--
ALTER TABLE `tb_activity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `tb_admin`
--
ALTER TABLE `tb_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tb_marketing_activity`
--
ALTER TABLE `tb_marketing_activity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `tb_product`
--
ALTER TABLE `tb_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `tb_user_interest`
--
ALTER TABLE `tb_user_interest`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tb_marketing_activity`
--
ALTER TABLE `tb_marketing_activity`
  ADD CONSTRAINT `tb_marketing_activity_ibfk_1` FOREIGN KEY (`activity_id`) REFERENCES `tb_activity` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tb_marketing_activity_ibfk_2` FOREIGN KEY (`admin_id`) REFERENCES `tb_admin` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_user_interest`
--
ALTER TABLE `tb_user_interest`
  ADD CONSTRAINT `tb_user_interest_ibfk_1` FOREIGN KEY (`produk_id`) REFERENCES `tb_product` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
