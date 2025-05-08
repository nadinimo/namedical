-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 23, 2025 at 03:32 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_namedical`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$AIy0X1Ep6alaHDTofiChGeqq7k/d1Kc8vKQf1JZo0mKrzkkj6M626');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `kode_customer` varchar(100) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `telp` varchar(200) NOT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `kota` varchar(100) DEFAULT NULL,
  `gender` enum('L','P') DEFAULT NULL,
  `paypal` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `ttl` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`kode_customer`, `nama`, `email`, `username`, `password`, `telp`, `alamat`, `kota`, `gender`, `paypal`, `image`, `ttl`) VALUES
('C0004', 'Nadiya', 'nadiya@gmail.com', 'nadiya', '$2y$10$6wHH.7rF1q3JtzKgAhNFy.4URchgJC8R.POT1osTAWmasDXTTO7ZG', '0898765432', NULL, NULL, NULL, NULL, NULL, NULL),
('C0006', 'Nadin Isna Monica', 'nadine@gmail.com', 'nadinku', '$2y$10$uZ3SRQU43apBhBlAmAA57.21SjTssAPzKpeKxoFJxA3pLd5kLjVZe', '081234567890', 'Sidoarjo', 'Sidoarjo', 'P', '12345678', '68032533b3e90.jpg', '2014-02-11'),
('C0007', 'Monica Kim', 'paw@gmail.com', 'papaw', '$2y$10$W5lhqN6FpSMySL4ZJiXzF.x5cvWzSSyMrEY3D0GJmqiAMi27PT1Q2', '081357083977', 'Darmo, Surabaya', 'Surabaya', 'P', '8888888', '6804b8e24af44.jpg', '2005-02-08'),
('C0008', 'Nadin', 'nadinestudy1@gmail.com', 'nadin7', '$2y$10$mbWM8it2jxAyL/E3yQhPCuL/ho9vgMfEW1cgBUKk1W57v.WoYpo8.', '081357083977', 'Jln Kyai Husein No. 77', 'Sidoarjo', 'L', '88888887', '680657187c239.jpg', '2004-01-04'),
('C0009', 'Isna', 'nadinestudy1@gmail.com', 'Isna1', '$2y$10$jOoqnBBG3cONrxSXt1M0cO4qXDRllTFA1i5Y4SZ/G3pCBgoGZnI0O', '081357083977', 'Jln Kyai Husein No. 77', 'Sidoarjo', 'P', '11111111', '68065f6366389.jpg', '2025-04-21'),
('C0010', 'mama', 'paw@gmail.com', 'mama', '$2y$10$v4JDMeQxdeMSVt/DPpgnh.cQwlYRdkiHStcwxKWq7r8p56QuPIoq2', '081357083977', 'Darmo, Surabaya', 'Surabaya', '', '0000007', NULL, '2025-04-23');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `komentar` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `order_id`, `rating`, `komentar`) VALUES
(1, 17, 5, 'barang bagus original dan cepat sampai. terima kasih banyak! nanti mau order lagi yeay!'),
(2, 16, 4, 'barang bagus dan berkualitas. oke!'),
(3, 15, 4, 'produk bagus dan datang cepat!'),
(4, 9, 1, 'Produk penyok, saya kecewa!'),
(5, 19, 4, 'Produk bagus banget dan pelayanan cepat'),
(6, 21, 1, 'Barang rusak :(');

-- --------------------------------------------------------

--
-- Table structure for table `kategori_produk`
--

CREATE TABLE `kategori_produk` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori_produk`
--

INSERT INTO `kategori_produk` (`id_kategori`, `nama_kategori`) VALUES
(1, 'Alat Diagnostik'),
(2, 'Alat Tes Kesehatan'),
(3, 'Alat Terapi & Rehabilitasi'),
(4, 'Alat Kesehatan Ibu & Bayi');

-- --------------------------------------------------------

--
-- Table structure for table `keranjang`
--

CREATE TABLE `keranjang` (
  `id_keranjang` int(11) NOT NULL,
  `kode_customer` varchar(100) NOT NULL,
  `kode_produk` varchar(100) NOT NULL,
  `nama_produk` varchar(100) NOT NULL,
  `qty` int(11) NOT NULL,
  `harga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `keranjang`
--

INSERT INTO `keranjang` (`id_keranjang`, `kode_customer`, `kode_produk`, `nama_produk`, `qty`, `harga`) VALUES
(69, 'C0010', 'P0005', 'Alat Pijat Elektrik', 1, 73500);

-- --------------------------------------------------------

--
-- Table structure for table `order_detail`
--

CREATE TABLE `order_detail` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `kode_produk` varchar(100) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `harga` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_detail`
--

INSERT INTO `order_detail` (`id`, `order_id`, `kode_produk`, `qty`, `harga`) VALUES
(1, 1, 'P0007', 1, 350000.00),
(2, 1, 'P0008', 1, 13000.00),
(3, 2, 'P0007', 1, 350000.00),
(4, 2, 'P0008', 1, 13000.00),
(5, 8, 'P0005', 1, 73500.00),
(6, 8, 'P0007', 1, 350000.00),
(7, 9, 'P0004', 1, 315000.00),
(8, 9, 'P0005', 1, 73500.00),
(9, 9, 'P0007', 1, 350000.00),
(10, 10, 'P0008', 1, 13000.00),
(11, 10, 'P0007', 1, 350000.00),
(12, 10, 'P0005', 1, 73500.00),
(13, 10, 'P0004', 1, 315000.00),
(14, 11, 'P0008', 2, 13000.00),
(15, 11, 'P0005', 1, 73500.00),
(16, 11, 'P0007', 1, 350000.00),
(17, 12, 'P0008', 2, 13000.00),
(18, 12, 'P0007', 1, 350000.00),
(19, 12, 'P0004', 1, 315000.00),
(20, 13, 'P0007', 1, 350000.00),
(21, 13, 'P0004', 1, 315000.00),
(22, 13, 'P0008', 1, 13000.00),
(23, 13, 'P0005', 2, 73500.00),
(24, 14, 'P0007', 1, 350000.00),
(25, 15, 'P0007', 1, 350000.00),
(26, 16, 'P0005', 1, 73500.00),
(27, 16, 'P0008', 1, 13000.00),
(28, 17, 'P0007', 1, 350000.00),
(29, 17, 'P0008', 1, 13000.00),
(30, 18, 'P0010', 1, 45000.00),
(31, 19, 'P0004', 2, 315000.00),
(32, 19, 'P0007', 1, 350000.00),
(33, 20, 'P0004', 1, 315000.00),
(34, 20, 'P0011', 1, 2000000.00),
(35, 21, 'P0007', 1, 350000.00),
(36, 21, 'P0011', 1, 10000.00);

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `informasi_pembayaran` varchar(255) NOT NULL,
  `metode_pembayaran` enum('BNI','COD') NOT NULL,
  `tanggal_bayar` date NOT NULL,
  `status_pembayaran` enum('Menunggu Konfirmasi Admin','Lunas') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id`, `order_id`, `informasi_pembayaran`, `metode_pembayaran`, `tanggal_bayar`, `status_pembayaran`) VALUES
(1, 8, 'Monica Kim (Dana)', 'BNI', '2025-04-20', 'Menunggu Konfirmasi Admin'),
(2, 18, 'Monica Kim (BCA 12345678)', 'BNI', '2025-04-21', 'Menunggu Konfirmasi Admin'),
(3, 19, 'Nadin (Shopeepy 081357083888)', 'BNI', '2025-04-21', 'Menunggu Konfirmasi Admin'),
(4, 20, 'Nadin (Shopeepy 081357083888)', 'BNI', '2025-04-21', 'Menunggu Konfirmasi Admin'),
(5, 21, 'Monica Kim (BCA 12345678)', 'BNI', '2025-04-23', 'Menunggu Konfirmasi Admin');

-- --------------------------------------------------------

--
-- Table structure for table `pembelian`
--

CREATE TABLE `pembelian` (
  `id` int(11) NOT NULL,
  `kode_customer` varchar(50) DEFAULT NULL,
  `nama_produk` varchar(255) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `tanggal` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `id` int(11) NOT NULL,
  `kode_order` varchar(50) DEFAULT NULL,
  `kode_customer` varchar(50) DEFAULT NULL,
  `pembayaran` enum('COD','BNI') DEFAULT NULL,
  `status_pesanan` enum('Menunggu Pembayaran','Dikemas','Dikirim','Selesai') DEFAULT NULL,
  `tanggal_order` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pesanan`
--

INSERT INTO `pesanan` (`id`, `kode_order`, `kode_customer`, `pembayaran`, `status_pesanan`, `tanggal_order`) VALUES
(1, 'ORD68033F60386BE', 'C0006', 'BNI', 'Selesai', NULL),
(2, 'ORD68034B3AA1702', 'C0006', 'COD', 'Selesai', NULL),
(3, 'ORD68046A1175521', '', 'COD', 'Dikirim', '2025-04-20 10:29:21'),
(4, 'ORD68046A329CAE3', '', 'COD', 'Dikemas', '2025-04-20 10:29:54'),
(5, 'ORD68046D7250886', '', 'COD', 'Dikirim', '2025-04-20 10:43:46'),
(6, 'ORD68046EF6B1A25', '', 'COD', 'Dikirim', '2025-04-20 10:50:14'),
(7, 'ORD6804705D17822', '', 'COD', 'Dikirim', '2025-04-20 10:56:13'),
(8, 'ORD680471296FE1C', 'C0007', 'COD', 'Selesai', '2025-04-20 10:59:37'),
(9, 'ORD680472F7ED9C8', 'C0007', 'COD', 'Selesai', '2025-04-20 11:07:19'),
(10, 'ORD680473867EDD1', 'C0007', 'COD', 'Selesai', '2025-04-20 11:09:42'),
(11, 'ORD680473D763256', 'C0007', 'COD', 'Selesai', '2025-04-20 11:11:03'),
(12, 'ORD680474713E99F', 'C0007', 'COD', 'Dikirim', '2025-04-20 11:13:37'),
(13, 'ORD6804779562727', 'C0007', 'COD', 'Menunggu Pembayaran', '2025-04-20 11:27:01'),
(14, 'ORD680479DD7F222', 'C0007', 'COD', 'Dikemas', '2025-04-20 11:36:45'),
(15, 'ORD68047CFC6FC39', 'C0007', 'COD', 'Selesai', '2025-04-20 11:50:04'),
(16, 'ORD6804879413B4A', 'C0007', 'COD', 'Selesai', '2025-04-20 12:35:16'),
(17, 'ORD680488D150A53', 'C0007', 'COD', 'Selesai', '2025-04-20 12:40:33'),
(18, 'ORD68061D23655E1', 'C0007', 'COD', 'Selesai', '2025-04-21 17:25:39'),
(19, 'ORD6806568FEFA32', 'C0008', 'COD', 'Selesai', '2025-04-21 21:30:39'),
(20, 'ORD68065ED64A3AB', 'C0009', 'COD', '', '2025-04-21 22:05:58'),
(21, 'ORD6808EA630A548', 'C0009', 'COD', 'Selesai', '2025-04-23 20:25:55');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `kode_produk` varchar(100) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `image` text NOT NULL,
  `deskripsi` text NOT NULL,
  `harga` int(11) NOT NULL,
  `id_kategori` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`kode_produk`, `nama`, `image`, `deskripsi`, `harga`, `id_kategori`) VALUES
('P0004', 'Timbangan Bayi', '680255d55dffe.png', 'Timbangan Bayi Digital ini dirancang khusus untuk memantau pertumbuhan bayi dan balita dengan hasil pengukuran yang akurat, cepat, dan mudah digunakan. Dilengkapi dengan layar LCD yang besar dan fitur tara otomatis, membuat proses penimbangan lebih praktis, bahkan saat bayi banyak bergerak!', 315000, 4),
('P0005', 'Alat Pijat Elektrik', '6802554d63d4d.jpg', 'Lepaskan penat setelah seharian beraktivitas dengan Alat Pijat Elektrik Portable. Didesain ergonomis untuk memberikan sensasi pijatan yang menenangkan dan meredakan nyeri otot di leher, punggung, pinggang, dan kaki. Cocok digunakan di rumah, kantor, atau saat bepergian.', 73500, 3),
('P0007', 'Alat tes kolesterol', '68024b062cb9b.jpg', 'Pantau kadar kolesterol, gula darah, dan asam urat Anda hanya dalam hitungan detik! Alat Tes Kolesterol Digital 3-in-1 ini dirancang khusus untuk penggunaan di rumah dengan hasil yang cepat dan akurat. Cocok untuk penderita diabetes, kolesterol tinggi, maupun yang peduli dengan kesehatan secara berkala.\r\n\r\nFitur Unggulan: ✅ 3 Fungsi dalam 1 alat (Kolesterol, Gula Darah, Asam Urat)\r\n✅ Layar LCD besar dan jelas\r\n✅ Pengoperasian mudah hanya dengan satu tombol\r\n✅ Hasil keluar hanya dalam 10 detik\r\n✅ Dilengkapi dengan jarum lancet & strip uji (paket awal)\r\n✅ Ukuran kompak dan mudah dibawa ke mana saja\r\n\r\nSpesifikasi:\r\n\r\nJenis: Digital Multi-Function Monitoring System\r\n\r\nSumber daya: Baterai AAA\r\n\r\nAkurasi tinggi, telah melalui uji klinis\r\n\r\nBahasa: Indonesia & Inggris (opsional)\r\n\r\nIsi Paket:\r\n\r\n1x Alat Tes Digital\r\n\r\n10x Strip Kolesterol\r\n\r\n10x Strip Gula Darah\r\n\r\n10x Strip Asam Urat\r\n\r\n10x Jarum Lancet\r\n\r\n1x Alat Penusuk\r\n\r\n1x Buku Panduan\r\n\r\n1x Tas Penyimpanan\r\n\r\nGaransi Resmi 1 Tahun\r\nSiap kirim hari ini! 💥', 350000, 2),
('P0008', 'Alat Tes Kehamilan', '68026d051f021.jpg', 'Cek kehamilan dengan mudah dan nyaman di rumah menggunakan Test Pack Sensitif & Akurat ini. Dengan tingkat akurasi hingga 99%, alat tes kehamilan ini mampu mendeteksi hormon hCG sejak hari pertama keterlambatan haid. Cukup celupkan, tunggu beberapa detik, dan baca hasilnya dengan jelas!', 20000, 4),
('P0010', 'Termometer Ketiak', '6804ff6090ece.jpeg', '• Thermometer pengukur panas\r\n• Tampilan besar sampai dengan 3 digit angka\r\n• Sudah termasuk ba 1 x 1,55V battery LR41\r\n• Akurasi perhitungan 0.1C (antara 35.5C and 42C)\r\n• Akurasi perhitungan 0.2C (antara 32 - 35.4C and 42.1 - 42.9C)', 45000, 1),
('P0011', 'Betadine 5 ML', '680675d616ba9.jpeg', 'obat sakit luka luka, dll', 10000, 3),
('P0012', 'Sedot Ingus Bayi', '6808eae172d76.jpeg', 'Sedot ingus bayi lembut bikin bayi tidak kaget', 25000, 4);

-- --------------------------------------------------------

--
-- Table structure for table `toko`
--

CREATE TABLE `toko` (
  `id_toko` int(11) NOT NULL,
  `kode_customer` varchar(255) NOT NULL,
  `nama_toko` varchar(255) NOT NULL,
  `kategori_toko` varchar(255) NOT NULL,
  `alamat_toko` text NOT NULL,
  `deskripsi_toko` text NOT NULL,
  `status_pengajuan` enum('Menunggu','Disetujui','Ditolak') DEFAULT 'Menunggu',
  `tanggal_pengajuan` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `toko`
--

INSERT INTO `toko` (`id_toko`, `kode_customer`, `nama_toko`, `kategori_toko`, `alamat_toko`, `deskripsi_toko`, `status_pengajuan`, `tanggal_pengajuan`) VALUES
(1, 'C0007', 'Delima Medic', 'Alat Tes Kesehatan', 'Gubeng, Surabaya', 'menyediakan berbagai macam produk dan perangkat medis yang digunakan untuk mendukung kesehatan dan perawatan tubuh. Toko ini menawarkan alat-alat kesehatan untuk penggunaan pribadi maupun profesional, baik di rumah, klinik, rumah sakit, atau fasilitas kesehatan lainnya.', 'Menunggu', '2025-04-21 10:55:42'),
(2, 'C0008', 'Delima Kasih Ibu', 'Toko Kesehatan Ibuk dan Anak', 'Gubeng, Surabaya', 'Toko Sehat Ibu & Bayi hadir sebagai solusi lengkap untuk kebutuhan kesehatan ibu hamil, menyusui, dan si kecil tercinta. Kami menyediakan berbagai produk berkualitas tinggi yang telah teruji dan aman, demi mendukung tumbuh kembang bayi dan menjaga kesehatan ibu secara optimal.', 'Menunggu', '2025-04-21 14:34:04'),
(3, 'C0009', 'Sayang Anak', 'Toko Kesehatan Ibuk dan Anak', 'Gubeng, Surabaya', 'Toko Sehat Ibu & Bayi hadir sebagai solusi lengkap untuk kebutuhan kesehatan ibu hamil, menyusui, dan si kecil tercinta. Kami menyediakan berbagai produk berkualitas tinggi yang telah teruji dan aman, demi mendukung tumbuh kembang bayi dan menjaga kesehatan ibu secara optimal.', 'Menunggu', '2025-04-21 15:09:16'),
(4, 'C0009', 'Toko AHA', 'Bayi', 'Gubeng, Surabaya', 'toko perlengkapan bayi', 'Disetujui', '2025-04-23 13:29:33');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`kode_customer`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `kategori_produk`
--
ALTER TABLE `kategori_produk`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `keranjang`
--
ALTER TABLE `keranjang`
  ADD PRIMARY KEY (`id_keranjang`),
  ADD KEY `fk_keranjang_produk` (`kode_produk`);

--
-- Indexes for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `fk_kode_produk` (`kode_produk`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kode_customer` (`kode_customer`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`kode_produk`),
  ADD KEY `fk_produk_kategori` (`id_kategori`);

--
-- Indexes for table `toko`
--
ALTER TABLE `toko`
  ADD PRIMARY KEY (`id_toko`),
  ADD KEY `kode_customer` (`kode_customer`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `kategori_produk`
--
ALTER TABLE `kategori_produk`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `keranjang`
--
ALTER TABLE `keranjang`
  MODIFY `id_keranjang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pembelian`
--
ALTER TABLE `pembelian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `toko`
--
ALTER TABLE `toko`
  MODIFY `id_toko` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `pesanan` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `keranjang`
--
ALTER TABLE `keranjang`
  ADD CONSTRAINT `fk_keranjang_produk` FOREIGN KEY (`kode_produk`) REFERENCES `produk` (`kode_produk`);

--
-- Constraints for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD CONSTRAINT `fk_kode_produk` FOREIGN KEY (`kode_produk`) REFERENCES `produk` (`kode_produk`),
  ADD CONSTRAINT `order_detail_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `pesanan` (`id`);

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `pesanan` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD CONSTRAINT `pembelian_ibfk_1` FOREIGN KEY (`kode_customer`) REFERENCES `customer` (`kode_customer`);

--
-- Constraints for table `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `fk_produk_kategori` FOREIGN KEY (`id_kategori`) REFERENCES `kategori_produk` (`id_kategori`);

--
-- Constraints for table `toko`
--
ALTER TABLE `toko`
  ADD CONSTRAINT `toko_ibfk_1` FOREIGN KEY (`kode_customer`) REFERENCES `customer` (`kode_customer`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
