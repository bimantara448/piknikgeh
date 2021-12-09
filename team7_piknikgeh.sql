-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 09, 2021 at 09:49 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `team7_piknikgeh`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(10) NOT NULL,
  `nama` varchar(255) COLLATE utf8_swedish_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8_swedish_ci NOT NULL,
  `username` varchar(50) COLLATE utf8_swedish_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `api_key` varchar(100) COLLATE utf8_swedish_ci NOT NULL,
  `status` enum('AKTIF','NONAKTIF') COLLATE utf8_swedish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `nama`, `email`, `username`, `password`, `api_key`, `status`) VALUES
(2, 'abim', 'abimarib@gmail.com', 'bimantara', '$2y$10$ksgmD8lxUVMAyESRLLz8Qur.YVBg540AqQGJW8mz/zzwcY7Ce89K.', 'M7GLhWCl8JqqgunKH3JGmNNGEXNo4I', 'AKTIF');

-- --------------------------------------------------------

--
-- Table structure for table `kategori_wisata`
--

CREATE TABLE `kategori_wisata` (
  `id_kat` int(11) NOT NULL,
  `nama_kat` varchar(50) NOT NULL,
  `logo_kat` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kategori_wisata`
--

INSERT INTO `kategori_wisata` (`id_kat`, `nama_kat`, `logo_kat`) VALUES
(7, 'Wisata Gunung', 'WisataGunung.png'),
(8, 'Wisata Pantai', 'WisataPantai.png'),
(9, 'Wisata Air Terjun', 'WisataAirTerjun.png'),
(10, 'Wisata Buatan', 'WisataBuatan.png'),
(11, 'Wisata Kota', 'WisataKota.png');

-- --------------------------------------------------------

--
-- Table structure for table `metode_pembayaran`
--

CREATE TABLE `metode_pembayaran` (
  `id_metode_pembayaran` int(11) NOT NULL,
  `nama_metode_pembayaran` varchar(100) NOT NULL,
  `catatan_metode_pembayaran` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `metode_pembayaran`
--

INSERT INTO `metode_pembayaran` (`id_metode_pembayaran`, `nama_metode_pembayaran`, `catatan_metode_pembayaran`) VALUES
(1, 'COD', 'Pembayaran dilakukan di tempat wisata. Ketika anda ingin masuk'),
(2, 'Pembayaran Online', 'Pembayaran Online menggunakan transfer bank dan dompet digital.');

-- --------------------------------------------------------

--
-- Table structure for table `pemesanan`
--

CREATE TABLE `pemesanan` (
  `id_pemesanan` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_wisata` int(11) NOT NULL,
  `code_tiket` varchar(50) NOT NULL,
  `nama_pembeli` varchar(50) NOT NULL,
  `email_pembeli` varchar(50) NOT NULL,
  `nohp_pembeli` varchar(50) NOT NULL,
  `jumlah_tiket` int(11) NOT NULL,
  `harga_tiket` int(11) NOT NULL,
  `id_metode_pembayaran` int(11) NOT NULL,
  `gateway_pembayaran` varchar(100) NOT NULL,
  `status_pembayaran` enum('Pending','Sukses','Gagal') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pemesanan`
--

INSERT INTO `pemesanan` (`id_pemesanan`, `id_user`, `id_wisata`, `code_tiket`, `nama_pembeli`, `email_pembeli`, `nohp_pembeli`, `jumlah_tiket`, `harga_tiket`, `id_metode_pembayaran`, `gateway_pembayaran`, `status_pembayaran`) VALUES
(1, 1, 10, 'sdsdsdfssf', '', '', '', 5, 250000, 1, '-', 'Gagal'),
(2, 1, 11, 'I7GZ2YQ1', 'Khanza', '', '', 1, 20000, 1, '-', 'Sukses'),
(3, 1, 9, 'UXVK4S0R', '', '', '', 1, 250000, 2, 'https://app.sandbox.midtrans.com/payment-links/1638815007248', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `tempat_wisata`
--

CREATE TABLE `tempat_wisata` (
  `id_wisata` int(11) NOT NULL,
  `id_kat` int(11) NOT NULL,
  `nama_wisata` varchar(100) NOT NULL,
  `deskripsi` text NOT NULL,
  `harga_tiket` int(11) NOT NULL,
  `pic1` varchar(100) NOT NULL,
  `pic2` varchar(100) NOT NULL,
  `pic3` varchar(100) NOT NULL,
  `pic4` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tempat_wisata`
--

INSERT INTO `tempat_wisata` (`id_wisata`, `id_kat`, `nama_wisata`, `deskripsi`, `harga_tiket`, `pic1`, `pic2`, `pic3`, `pic4`) VALUES
(9, 7, 'Semeru', 'keren gunungnya', 250000, 'Semeru1.jpg', 'Semeru2.jpg', 'Semeru3.jpg', 'Semeru4.jpg'),
(10, 7, 'Gigi Hiu', 'keren abis', 20000, 'GigiHiu1.jpg', 'GigiHiu2.jpg', 'GigiHiu3.jpg', 'GigiHiu4.jpg'),
(11, 7, 'Pahawang', 'bebek', 20000, 'Pahawang1.jpg', 'Pahawang2.jpg', 'Pahawang3.jpg', 'Pahawang4.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `nama`, `email`, `username`, `password`) VALUES
(1, 'Abim ari bimantara', 'abimarib@gmail.com', 'abim', '123'),
(3, 'sia', 'sia@gmail.com', 'sia', 'sia'),
(4, 'silvia amelia', 'silvi@gmail.com', 'silvi', '321'),
(5, 'Yogi Pratama', 'yogi@gmail.com', 'Yogi', 'yogi'),
(6, 'alexandrea ale', 'ale@gmail.com', 'ale', 'ale'),
(7, 'ANDI KHUSAIRI', 'andi@gmail.com', 'andi', 'andi'),
(8, 'Muhammad Ali', 'muhmmadalii2020@gmail.com', 'Alee', '123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `kategori_wisata`
--
ALTER TABLE `kategori_wisata`
  ADD PRIMARY KEY (`id_kat`);

--
-- Indexes for table `metode_pembayaran`
--
ALTER TABLE `metode_pembayaran`
  ADD PRIMARY KEY (`id_metode_pembayaran`);

--
-- Indexes for table `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD PRIMARY KEY (`id_pemesanan`),
  ADD KEY `id_user` (`id_user`,`id_wisata`,`id_metode_pembayaran`),
  ADD KEY `id_wisata` (`id_wisata`),
  ADD KEY `id_metode_pembayaran` (`id_metode_pembayaran`);

--
-- Indexes for table `tempat_wisata`
--
ALTER TABLE `tempat_wisata`
  ADD PRIMARY KEY (`id_wisata`),
  ADD KEY `id_kat` (`id_kat`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kategori_wisata`
--
ALTER TABLE `kategori_wisata`
  MODIFY `id_kat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `pemesanan`
--
ALTER TABLE `pemesanan`
  MODIFY `id_pemesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tempat_wisata`
--
ALTER TABLE `tempat_wisata`
  MODIFY `id_wisata` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD CONSTRAINT `pemesanan_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pemesanan_ibfk_2` FOREIGN KEY (`id_wisata`) REFERENCES `tempat_wisata` (`id_wisata`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pemesanan_ibfk_3` FOREIGN KEY (`id_metode_pembayaran`) REFERENCES `metode_pembayaran` (`id_metode_pembayaran`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tempat_wisata`
--
ALTER TABLE `tempat_wisata`
  ADD CONSTRAINT `tempat_wisata_ibfk_1` FOREIGN KEY (`id_kat`) REFERENCES `kategori_wisata` (`id_kat`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
