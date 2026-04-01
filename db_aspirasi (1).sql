-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 01, 2026 at 04:53 AM
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
-- Database: `db_aspirasi`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `username`, `password`) VALUES
(1, 'admin', '827ccb0eea8a706c4c34a16891f84e7b');

-- --------------------------------------------------------

--
-- Table structure for table `aspirasi`
--

CREATE TABLE `aspirasi` (
  `id_aspirasi` int(5) NOT NULL,
  `status` enum('Menunggu','Proses','Selesai') NOT NULL,
  `id_pelaporan` int(5) NOT NULL,
  `feedback` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `aspirasi`
--

INSERT INTO `aspirasi` (`id_aspirasi`, `status`, `id_pelaporan`, `feedback`) VALUES
(821, 'Selesai', 7864, 'kelengkapan obat sudah di upgrade'),
(2250, 'Proses', 4421, 'sedang dalam proses memperbanyak menu'),
(2323, 'Menunggu', 2162, 'pelayanan sedang diganti petugas'),
(2454, 'Proses', 1068, 'buku sedang dalam proses perbanyakan'),
(2567, 'Selesai', 1254, 'sudah perbaikan '),
(2781, 'Selesai', 3321, 'ruangan sudah diperluas'),
(3321, 'Proses', 3233, 'aula sedang diperbaiki'),
(8834, 'Selesai', 5531, 'meja sudah diganti'),
(8865, 'Proses', 5673, 'pintu sedang proses perbaikan '),
(9778, 'Menunggu', 3321, 'dalam masa pengajuan perbaikan '),
(9789, 'Selesai', 8790, 'sudah selesai'),
(9790, 'Proses', 8808, 'sedang dalam proses'),
(9791, 'Selesai', 8809, 'sudah diperbarui'),
(9795, 'Proses', 8813, 'sedang dalam masa perubahan');

-- --------------------------------------------------------

--
-- Table structure for table `input_aspirasi`
--

CREATE TABLE `input_aspirasi` (
  `id_pelaporan` int(5) NOT NULL,
  `nis` int(10) NOT NULL,
  `id_kategori` int(5) NOT NULL,
  `lokasi` varchar(50) NOT NULL,
  `ket` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `input_aspirasi`
--

INSERT INTO `input_aspirasi` (`id_pelaporan`, `nis`, `id_kategori`, `lokasi`, `ket`, `created_at`) VALUES
(1068, 83109234, 3212, 'perpustakaan sekolah ', 'koleksi buku kurang lengkap', '2026-03-05 15:10:57'),
(1254, 83225123, 1014, 'musholla smk 5', 'ruang kurang dingin ', '2026-03-05 15:10:57'),
(2162, 83109234, 1512, 'administrasi', 'pelayanan kurang cepat', '2026-03-05 15:10:57'),
(3233, 83225733, 2212, 'aula smk', 'aula kurang nyaman', '2026-03-05 15:10:57'),
(3321, 83225732, 1415, 'ruangan', 'kursi rusak', '2026-03-05 15:10:57'),
(4421, 83225444, 1718, 'kantin smk', 'makanan kurang bervariasi', '2026-03-05 15:10:57'),
(5531, 83242588, 1123, 'rps smk', 'meja kurang tinggi', '2026-03-05 15:10:57'),
(5673, 83115347, 1322, 'wc umum smk', 'pintu rusak', '2026-03-05 15:10:57'),
(7864, 83109234, 1010, 'uks', 'obat perlu diperbarui', '2026-03-05 15:10:57'),
(8790, 83115347, 1012, 'kesiswaan', 'ruangan kurang luas ', '2026-03-05 15:10:57'),
(8808, 83115347, 1415, 'kelas', 'kekurangan meja', '2026-03-10 11:47:11'),
(8809, 83225732, 1010, 'uks', 'obat tidak lengkap', '2026-03-10 12:03:13'),
(8813, 83225732, 1014, 'musolla smk', 'mukenah jubah kurang nyaman', '2026-03-30 10:26:42');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(5) NOT NULL,
  `ket_kategori` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `ket_kategori`) VALUES
(1010, 'ruang kesehatan'),
(1012, 'ruang kesiswaan'),
(1014, 'musholla'),
(1123, 'rps'),
(1322, 'wc'),
(1415, 'ruang kelas'),
(1512, 'ruang administrasi'),
(1718, 'kantin'),
(2212, 'aula'),
(3212, 'perpustakaan');

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `nis` int(10) NOT NULL,
  `kelas` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`nis`, `kelas`) VALUES
(83109234, 'XII tja 2'),
(83115347, 'XII tja 1'),
(83212988, 'XII pf 2'),
(83225123, 'XII tkj 1'),
(83225444, 'XII rpl 3'),
(83225732, 'XII rpl 1'),
(83225733, 'XII rpl 2'),
(83225923, 'XII pf 1'),
(83242567, 'XII tkj 2'),
(83242588, 'XII tkj 3');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `aspirasi`
--
ALTER TABLE `aspirasi`
  ADD PRIMARY KEY (`id_aspirasi`),
  ADD KEY `id_pelaporan` (`id_pelaporan`);

--
-- Indexes for table `input_aspirasi`
--
ALTER TABLE `input_aspirasi`
  ADD PRIMARY KEY (`id_pelaporan`),
  ADD KEY `nis` (`nis`,`id_kategori`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`nis`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `aspirasi`
--
ALTER TABLE `aspirasi`
  MODIFY `id_aspirasi` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9797;

--
-- AUTO_INCREMENT for table `input_aspirasi`
--
ALTER TABLE `input_aspirasi`
  MODIFY `id_pelaporan` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8815;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3213;

--
-- AUTO_INCREMENT for table `siswa`
--
ALTER TABLE `siswa`
  MODIFY `nis` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83242589;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `aspirasi`
--
ALTER TABLE `aspirasi`
  ADD CONSTRAINT `aspirasi_ibfk_1` FOREIGN KEY (`id_pelaporan`) REFERENCES `input_aspirasi` (`id_pelaporan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `input_aspirasi`
--
ALTER TABLE `input_aspirasi`
  ADD CONSTRAINT `input_aspirasi_ibfk_1` FOREIGN KEY (`nis`) REFERENCES `siswa` (`nis`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `input_aspirasi_ibfk_2` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
