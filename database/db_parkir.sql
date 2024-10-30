-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 30, 2024 at 09:08 AM
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
-- Database: `db_parkir`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_karyawan`
--

CREATE TABLE `tbl_karyawan` (
  `id` int(11) NOT NULL,
  `nik` varchar(20) NOT NULL,
  `nama_karyawan` varchar(100) NOT NULL,
  `tanggal_masuk` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_karyawan`
--

INSERT INTO `tbl_karyawan` (`id`, `nik`, `nama_karyawan`, `tanggal_masuk`) VALUES
(7, '102', 'Budi Santoso', '2019-03-20'),
(8, '103', 'Citra Dewi', '2021-07-10'),
(9, '104', 'Doni Prabowo', '2022-05-05'),
(10, '105', 'Eka Putri', '2023-02-18'),
(11, '452', 'septian nugraha', '0000-00-00'),
(12, '555555', 'septian nugraha', '0000-00-00'),
(13, '55555', 'septian nugraha', '0000-00-00'),
(14, '222222', 'sdsds', '0000-00-00'),
(15, '123456', 'sdsdsff', '0000-00-00'),
(16, '1122335', 'asasasa', '0000-00-00'),
(17, '1234567890', 'asasasadswdw', '0000-00-00'),
(19, '2121', 'septian nugraha', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_kendaraan`
--

CREATE TABLE `tbl_kendaraan` (
  `id_kendaraan` int(11) NOT NULL,
  `id_karyawan` int(11) DEFAULT NULL,
  `jenis_kendaraan` enum('motor','mobil','lainnya') DEFAULT NULL,
  `nopol` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_kendaraan`
--

INSERT INTO `tbl_kendaraan` (`id_kendaraan`, `id_karyawan`, `jenis_kendaraan`, `nopol`) VALUES
(1, 7, 'motor', 'd4024xyu'),
(2, 7, 'mobil', 'd3232xyz'),
(3, 17, 'motor', '123456'),
(4, 17, 'motor', '123456'),
(5, 19, 'motor', '452502');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_parkir`
--

CREATE TABLE `tbl_parkir` (
  `id` int(15) NOT NULL,
  `nopol` varchar(10) NOT NULL,
  `jenis_kendaraan` varchar(100) NOT NULL,
  `pemilik` varchar(100) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `masuk` timestamp NOT NULL DEFAULT current_timestamp(),
  `keluar` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_parkir`
--

INSERT INTO `tbl_parkir` (`id`, `nopol`, `jenis_kendaraan`, `pemilik`, `tanggal`, `masuk`, `keluar`) VALUES
(9, 'x4431yu', 'motor', 'umum', '2024-10-28', '2024-10-28 06:39:02', '2024-10-30 03:43:25'),
(10, 'd4024xyu', 'mobil', 'Budi Santoso', NULL, '2024-10-29 03:39:29', '2024-10-29 04:40:09'),
(11, '45654654', '', 'umum', '2024-10-29', '2024-10-29 06:54:44', NULL),
(12, 'd42w41', 'mobil', 'umum', '2024-10-29', '2024-10-29 06:55:13', NULL),
(13, 'd23454', 'motor', 'umum', '2024-10-30', '2024-10-30 02:25:52', NULL),
(14, '5444333', 'mobil', 'umum', NULL, '2024-10-30 02:26:14', NULL),
(15, 'qwerwrrw', '', 'umum', '2024-10-30', '2024-10-30 02:41:09', '2024-10-30 04:29:23'),
(16, 'qwerwrrwer', '', 'umum', '2024-10-30', '2024-10-30 02:41:15', '2024-10-30 04:29:25'),
(17, 'qwewqeqweq', '', 'umum', '2024-10-30', '2024-10-30 02:41:19', '2024-10-30 04:29:28'),
(18, 'qwewqeqweq', '', 'umum', '2024-10-30', '2024-10-30 02:41:20', '2024-10-30 04:29:30'),
(19, 'qwerweweqr', '', 'umum', '2024-10-30', '2024-10-30 02:41:31', '2024-10-30 04:29:32'),
(20, '', 'motor', '', '2024-10-30', '2024-10-30 03:32:45', NULL),
(21, 'asadsda', 'motor', 'umum', '2024-10-30', '2024-10-30 07:01:48', NULL),
(22, 'D245fu', 'motor', NULL, '2024-10-30', '2024-10-30 07:07:23', NULL),
(23, 'qwer3211', '', 'umum', '2024-10-30', '2024-10-30 07:14:33', NULL),
(24, 'asdawasd', 'motor', 'umum', '2024-10-30', '2024-10-30 08:05:29', '2024-10-30 09:05:36');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `username`, `password`, `role`) VALUES
(1, 'septian', '123456', 'admin'),
(2, 'ucing', 'qwerty', 'user'),
(3, 'admin', '$2y$10$FJTFsMMsVRUozvBLJHtOOeZu3IinSpQkht3Onmv/nb6lOKkdvXqEq', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_karyawan`
--
ALTER TABLE `tbl_karyawan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nik` (`nik`);

--
-- Indexes for table `tbl_kendaraan`
--
ALTER TABLE `tbl_kendaraan`
  ADD PRIMARY KEY (`id_kendaraan`);

--
-- Indexes for table `tbl_parkir`
--
ALTER TABLE `tbl_parkir`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_karyawan`
--
ALTER TABLE `tbl_karyawan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tbl_kendaraan`
--
ALTER TABLE `tbl_kendaraan`
  MODIFY `id_kendaraan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_parkir`
--
ALTER TABLE `tbl_parkir`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
