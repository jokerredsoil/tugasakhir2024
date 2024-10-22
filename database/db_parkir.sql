-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 22, 2024 at 09:50 AM
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
(10, '105', 'Eka Putri', '2023-02-18');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_kendaraan`
--

CREATE TABLE `tbl_kendaraan` (
  `id` int(11) NOT NULL,
  `id_karyawan` int(11) DEFAULT NULL,
  `jenis_kendara` enum('motor','mobil','lainnya') DEFAULT NULL,
  `nopol` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_kendaraan`
--

INSERT INTO `tbl_kendaraan` (`id`, `id_karyawan`, `jenis_kendara`, `nopol`) VALUES
(1, 1, 'motor', 'd4024xyu'),
(2, 1, 'mobil', 'd3232xyz');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_parkir`
--

CREATE TABLE `tbl_parkir` (
  `id` int(15) NOT NULL,
  `nopol` varchar(10) NOT NULL,
  `jenis kendaraan` varchar(100) NOT NULL,
  `masuk` timestamp NOT NULL DEFAULT current_timestamp(),
  `keluar` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_parkir`
--
ALTER TABLE `tbl_parkir`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_karyawan`
--
ALTER TABLE `tbl_karyawan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_kendaraan`
--
ALTER TABLE `tbl_kendaraan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_parkir`
--
ALTER TABLE `tbl_parkir`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
