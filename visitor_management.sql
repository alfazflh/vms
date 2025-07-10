-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 10, 2025 at 08:11 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `visitor_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `data_tamu`
--

CREATE TABLE `data_tamu` (
  `id` int(11) NOT NULL,
  `timestamp` datetime DEFAULT current_timestamp(),
  `nama_tamu` varchar(100) DEFAULT NULL,
  `perusahaan` varchar(100) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `unit` varchar(100) DEFAULT NULL,
  `pegawai` varchar(100) DEFAULT NULL,
  `apd` text DEFAULT NULL,
  `keperluan` text DEFAULT NULL,
  `ktp` varchar(100) DEFAULT NULL,
  `kendaraan` varchar(100) DEFAULT NULL,
  `name_tag` varchar(50) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `induksi` varchar(20) DEFAULT NULL,
  `link_foto` text DEFAULT NULL,
  `status` enum('check-in','check-out') DEFAULT 'check-in',
  `jam_checkout` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `data_tamu`
--

INSERT INTO `data_tamu` (`id`, `timestamp`, `nama_tamu`, `perusahaan`, `alamat`, `unit`, `pegawai`, `apd`, `keperluan`, `ktp`, `kendaraan`, `name_tag`, `jumlah`, `induksi`, `link_foto`, `status`, `jam_checkout`) VALUES
(5, '2025-07-10 04:28:45', 'al', 'pt', 'jl', 'ku', 'pak', 'Safety Helmet', 'aa', '543', 'L2321BA', '12', 1, 'Ya', 'uploads/1752114525_686f255d9a67e.png', 'check-out', '2025-07-10 10:23:43'),
(6, '2025-07-10 06:03:57', 'tes', 'tes', 'tes', 'tes', 'tes', 'Safety Helmet, Safety Shoes, Seragam Kerja', 'tes', 'tes', 'tes', 'tes', 5, 'Ya', 'uploads/1752120237_686f3bad51f59.jpeg', 'check-out', '2025-07-10 11:04:49'),
(7, '2025-07-10 07:27:27', 'alfaz', 'pt telkom', 'jalan pecantingan', 'workshop 1', 'pak ', 'Safety Helmet, Safety Shoes, Seragam Kerja', 'lihat lihat', '123', 'B5432VA', '1', 3, 'Ya', 'uploads/1752125247_686f4f3f0c583.png', 'check-out', '2025-07-10 12:29:04'),
(8, '2025-07-10 12:30:07', 'epan', 'pt benowo', 'benowo', 'umum', 'bu', 'Safety Helmet, Safety Shoes, Seragam Kerja', 'gatau', '6543', 'B54321DA', '1', 1, 'Ya', 'uploads/1752125407_686f4fdf825ca.jpeg', 'check-out', '2025-07-10 12:33:19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data_tamu`
--
ALTER TABLE `data_tamu`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data_tamu`
--
ALTER TABLE `data_tamu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
