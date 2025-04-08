-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 08, 2025 at 12:47 PM
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
-- Database: `websitejadwal_uts`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telp` varchar(15) DEFAULT NULL,
  `user_input` varchar(50) DEFAULT NULL,
  `tanggal_input` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `password`, `nama`, `email`, `telp`, `user_input`, `tanggal_input`) VALUES
(6, 'e00cf25ad42683b3df678c61f42c6bda', 'Darren Lincoln', 'darkaylin0507@gmail.com', '087886759587', 'Darren@admin.ac.id', '2025-04-02 18:34:28'),
(8, 'c84258e9c39059a89ab77d846ddab909', 'Alexander Phangestu', 'alexander@gmail.com', '087886759587', 'Alex@admin.ac.id', '2025-04-07 00:14:39'),
(9, 'e00cf25ad42683b3df678c61f42c6bda', 'Rakha Wihhhhdyaberdana', 'rakha@gmail.com', '081169420404', 'Rakha@admin.ac.id', '2025-04-07 23:04:51');

-- --------------------------------------------------------

--
-- Table structure for table `dosen`
--

CREATE TABLE `dosen` (
  `NIK` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `gelar` varchar(50) NOT NULL,
  `lulusan` varchar(100) NOT NULL,
  `telp` varchar(15) DEFAULT NULL,
  `user_input` varchar(50) DEFAULT NULL,
  `tanggal_input` datetime DEFAULT current_timestamp(),
  `password` varchar(255) NOT NULL,
  `profession_id` int(11) DEFAULT NULL,
  `profession` enum('professor','lecturer','lecture_head','assistant') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dosen`
--

INSERT INTO `dosen` (`NIK`, `nama`, `gelar`, `lulusan`, `telp`, `user_input`, `tanggal_input`, `password`, `profession_id`, `profession`) VALUES
('001', 'Dr. Setiawan Pratama', 'Dr.', 'S3', '0812345678', 'setiawanp@lecturer.ac.id', '2025-04-06 20:48:14', 'edf90aff836f1fc27fc04aeebf6e84b9', NULL, 'lecturer'),
('002', 'M.Pd. Indah Permata', 'M.Pd.', 'S2', '0812345679', 'indahp@lecturer.ac.id', '2025-04-06 20:48:14', '3a3c497dad8cb7af8da97ce8b3f9b7f3', NULL, 'professor'),
('003', 'S.Pd. Rizky Aditya', 'S.Pd.', 'S1', '0812345680', 'rizkya@lecturer.ac.id', '2025-04-06 20:48:14', '99de57cb2350bbac45c7d32fdb57eea3', NULL, 'professor'),
('004', 'Dr. Farhan Nugraha', 'Dr.', 'S3', '0812345681', 'farhann@lecturer.ac.id', '2025-04-06 20:48:14', '9d304cd1cdb9a3756975d64ae9757c61', NULL, 'professor'),
('005', 'M.Pd. Lestari Dewi', 'M.Pd.', 'S2', '0812345682', 'lestarid@lecturer.ac.id', '2025-04-06 20:48:14', 'cbff130c18ca8ad8b324485b9753a0c2', NULL, 'professor');

-- --------------------------------------------------------

--
-- Table structure for table `krs`
--

CREATE TABLE `krs` (
  `id` int(11) NOT NULL,
  `kode_matkul` varchar(10) NOT NULL,
  `NIK_dosen` varchar(20) NOT NULL,
  `NIM_mahasiswa` varchar(20) DEFAULT NULL,
  `hari_matkul` varchar(20) DEFAULT NULL,
  `ruangan` varchar(50) DEFAULT NULL,
  `user_input` varchar(50) DEFAULT NULL,
  `tanggal_input` datetime DEFAULT current_timestamp(),
  `total_mahasiswa` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `krs`
--

INSERT INTO `krs` (`id`, `kode_matkul`, `NIK_dosen`, `NIM_mahasiswa`, `hari_matkul`, `ruangan`, `user_input`, `tanggal_input`, `total_mahasiswa`) VALUES
(111, 'CS101', '001', '001', 'Senin', 'C0304', 'Darren@admin.ac.id', '2025-04-08 14:50:37', 1),
(112, 'CS101', '001', '002', 'Senin', 'C0304', 'Darren@admin.ac.id', '2025-04-08 14:50:37', 1),
(113, 'CS101', '001', '003', 'Senin', 'C0304', 'Darren@admin.ac.id', '2025-04-08 14:50:37', 1),
(114, 'CS101', '001', '004', 'Senin', 'C0304', 'Darren@admin.ac.id', '2025-04-08 14:50:37', 1),
(115, 'CS101', '001', '005', 'Senin', 'C0304', 'Darren@admin.ac.id', '2025-04-08 14:50:37', 1),
(116, 'CS101', '001', '006', 'Senin', 'C0304', 'Darren@admin.ac.id', '2025-04-08 14:50:37', 1),
(117, 'CS101', '001', '007', 'Senin', 'C0304', 'Darren@admin.ac.id', '2025-04-08 14:50:37', 1),
(118, 'CS101', '001', '008', 'Senin', 'C0304', 'Darren@admin.ac.id', '2025-04-08 14:50:37', 1),
(119, 'CS101', '001', '009', 'Senin', 'C0304', 'Darren@admin.ac.id', '2025-04-08 14:50:37', 1),
(120, 'CS101', '001', '010', 'Senin', 'C0304', 'Darren@admin.ac.id', '2025-04-08 14:50:37', 1),
(121, 'CS101', '001', '011', 'Senin', 'C0304', 'Darren@admin.ac.id', '2025-04-08 14:50:37', 1),
(122, 'CS101', '001', '012', 'Senin', 'C0304', 'Darren@admin.ac.id', '2025-04-08 14:50:37', 1),
(123, 'CS101', '001', '013', 'Senin', 'C0304', 'Darren@admin.ac.id', '2025-04-08 14:50:37', 1),
(124, 'CS101', '001', '014', 'Senin', 'C0304', 'Darren@admin.ac.id', '2025-04-08 14:50:37', 1),
(125, 'CS101', '001', '015', 'Senin', 'C0304', 'Darren@admin.ac.id', '2025-04-08 14:50:37', 1),
(126, 'CS101', '001', '016', 'Senin', 'C0304', 'Darren@admin.ac.id', '2025-04-08 14:50:37', 1),
(127, 'CS101', '001', '017', 'Senin', 'C0304', 'Darren@admin.ac.id', '2025-04-08 14:50:37', 1),
(128, 'CS101', '001', '018', 'Senin', 'C0304', 'Darren@admin.ac.id', '2025-04-08 14:50:37', 1),
(129, 'CS101', '001', '019', 'Senin', 'C0304', 'Darren@admin.ac.id', '2025-04-08 14:50:37', 1),
(130, 'CS101', '001', '020', 'Senin', 'C0304', 'Darren@admin.ac.id', '2025-04-08 14:50:37', 1),
(140, 'MA202', '002', '002', 'Selasa', 'C0302', 'Darren@admin.ac.id', '2025-04-08 14:52:28', 1),
(141, 'MA202', '002', '003', 'Selasa', 'C0302', 'Darren@admin.ac.id', '2025-04-08 14:52:28', 1),
(142, 'MA202', '002', '004', 'Selasa', 'C0302', 'Darren@admin.ac.id', '2025-04-08 14:52:28', 1),
(143, 'MA202', '002', '005', 'Selasa', 'C0302', 'Darren@admin.ac.id', '2025-04-08 14:52:28', 1),
(144, 'MA202', '002', '006', 'Selasa', 'C0302', 'Darren@admin.ac.id', '2025-04-08 14:52:28', 1),
(145, 'MA202', '002', '007', 'Selasa', 'C0302', 'Darren@admin.ac.id', '2025-04-08 14:52:28', 1),
(146, 'MA202', '002', '008', 'Selasa', 'C0302', 'Darren@admin.ac.id', '2025-04-08 14:52:28', 1),
(147, 'MA202', '002', '009', 'Selasa', 'C0302', 'Darren@admin.ac.id', '2025-04-08 14:52:28', 1),
(148, 'MA202', '002', '010', 'Selasa', 'C0302', 'Darren@admin.ac.id', '2025-04-08 14:52:28', 1),
(149, 'MA202', '002', '011', 'Selasa', 'C0302', 'Darren@admin.ac.id', '2025-04-08 14:52:28', 1),
(150, 'MA202', '002', '012', 'Selasa', 'C0302', 'Darren@admin.ac.id', '2025-04-08 14:52:28', 1),
(151, 'MA202', '002', '013', 'Selasa', 'C0302', 'Darren@admin.ac.id', '2025-04-08 14:52:28', 1),
(152, 'MA202', '002', '014', 'Selasa', 'C0302', 'Darren@admin.ac.id', '2025-04-08 14:52:28', 1),
(153, 'MA202', '002', '015', 'Selasa', 'C0302', 'Darren@admin.ac.id', '2025-04-08 14:52:28', 1),
(154, 'MA202', '002', '016', 'Selasa', 'C0302', 'Darren@admin.ac.id', '2025-04-08 14:52:28', 1),
(155, 'MA202', '002', '017', 'Selasa', 'C0302', 'Darren@admin.ac.id', '2025-04-08 14:52:28', 1),
(156, 'MA202', '002', '018', 'Selasa', 'C0302', 'Darren@admin.ac.id', '2025-04-08 14:52:28', 1),
(157, 'MA202', '002', '019', 'Selasa', 'C0302', 'Darren@admin.ac.id', '2025-04-08 14:52:28', 1),
(158, 'MA202', '002', '020', 'Selasa', 'C0302', 'Darren@admin.ac.id', '2025-04-08 14:52:28', 1),
(159, 'MA202', '002', '021', 'Selasa', 'C0302', 'Darren@admin.ac.id', '2025-04-08 14:52:28', 1),
(168, 'PH303', '003', '003', 'Rabu', 'D0303', 'Darren@admin.ac.id', '2025-04-08 14:58:33', 1),
(169, 'PH303', '003', '004', 'Rabu', 'D0303', 'Darren@admin.ac.id', '2025-04-08 14:58:33', 1),
(170, 'PH303', '003', '005', 'Rabu', 'D0303', 'Darren@admin.ac.id', '2025-04-08 14:58:33', 1),
(171, 'PH303', '003', '006', 'Rabu', 'D0303', 'Darren@admin.ac.id', '2025-04-08 14:58:33', 1),
(172, 'PH303', '003', '007', 'Rabu', 'D0303', 'Darren@admin.ac.id', '2025-04-08 14:58:33', 1),
(173, 'PH303', '003', '008', 'Rabu', 'D0303', 'Darren@admin.ac.id', '2025-04-08 14:58:33', 1),
(174, 'PH303', '003', '009', 'Rabu', 'D0303', 'Darren@admin.ac.id', '2025-04-08 14:58:33', 1),
(175, 'PH303', '003', '010', 'Rabu', 'D0303', 'Darren@admin.ac.id', '2025-04-08 14:58:33', 1),
(176, 'PH303', '003', '011', 'Rabu', 'D0303', 'Darren@admin.ac.id', '2025-04-08 14:58:33', 1),
(177, 'PH303', '003', '012', 'Rabu', 'D0303', 'Darren@admin.ac.id', '2025-04-08 14:58:33', 1),
(178, 'PH303', '003', '013', 'Rabu', 'D0303', 'Darren@admin.ac.id', '2025-04-08 14:58:33', 1),
(179, 'PH303', '003', '014', 'Rabu', 'D0303', 'Darren@admin.ac.id', '2025-04-08 14:58:33', 1),
(180, 'PH303', '003', '015', 'Rabu', 'D0303', 'Darren@admin.ac.id', '2025-04-08 14:58:33', 1),
(181, 'PH303', '003', '016', 'Rabu', 'D0303', 'Darren@admin.ac.id', '2025-04-08 14:58:33', 1),
(182, 'PH303', '003', '017', 'Rabu', 'D0303', 'Darren@admin.ac.id', '2025-04-08 14:58:33', 1),
(183, 'PH303', '003', '018', 'Rabu', 'D0303', 'Darren@admin.ac.id', '2025-04-08 14:58:33', 1),
(184, 'PH303', '003', '019', 'Rabu', 'D0303', 'Darren@admin.ac.id', '2025-04-08 14:58:33', 1),
(185, 'PH303', '003', '020', 'Rabu', 'D0303', 'Darren@admin.ac.id', '2025-04-08 14:58:33', 1),
(186, 'PH303', '003', '021', 'Rabu', 'D0303', 'Darren@admin.ac.id', '2025-04-08 14:58:33', 1),
(187, 'PH303', '003', '022', 'Rabu', 'D0303', 'Darren@admin.ac.id', '2025-04-08 14:58:33', 1),
(188, 'CH404', '004', '004', 'Kamis', 'B0404', 'Darren@admin.ac.id', '2025-04-08 14:59:10', 1),
(189, 'CH404', '004', '005', 'Kamis', 'B0404', 'Darren@admin.ac.id', '2025-04-08 14:59:10', 1),
(190, 'CH404', '004', '006', 'Kamis', 'B0404', 'Darren@admin.ac.id', '2025-04-08 14:59:10', 1),
(191, 'CH404', '004', '007', 'Kamis', 'B0404', 'Darren@admin.ac.id', '2025-04-08 14:59:10', 1),
(192, 'CH404', '004', '008', 'Kamis', 'B0404', 'Darren@admin.ac.id', '2025-04-08 14:59:10', 1),
(193, 'CH404', '004', '009', 'Kamis', 'B0404', 'Darren@admin.ac.id', '2025-04-08 14:59:10', 1),
(194, 'CH404', '004', '010', 'Kamis', 'B0404', 'Darren@admin.ac.id', '2025-04-08 14:59:10', 1),
(195, 'CH404', '004', '011', 'Kamis', 'B0404', 'Darren@admin.ac.id', '2025-04-08 14:59:10', 1),
(196, 'CH404', '004', '012', 'Kamis', 'B0404', 'Darren@admin.ac.id', '2025-04-08 14:59:10', 1),
(197, 'CH404', '004', '013', 'Kamis', 'B0404', 'Darren@admin.ac.id', '2025-04-08 14:59:10', 1),
(198, 'CH404', '004', '014', 'Kamis', 'B0404', 'Darren@admin.ac.id', '2025-04-08 14:59:10', 1),
(199, 'CH404', '004', '015', 'Kamis', 'B0404', 'Darren@admin.ac.id', '2025-04-08 14:59:10', 1),
(200, 'CH404', '004', '016', 'Kamis', 'B0404', 'Darren@admin.ac.id', '2025-04-08 14:59:10', 1),
(201, 'CH404', '004', '017', 'Kamis', 'B0404', 'Darren@admin.ac.id', '2025-04-08 14:59:10', 1),
(202, 'CH404', '004', '018', 'Kamis', 'B0404', 'Darren@admin.ac.id', '2025-04-08 14:59:10', 1),
(203, 'CH404', '004', '019', 'Kamis', 'B0404', 'Darren@admin.ac.id', '2025-04-08 14:59:10', 1),
(204, 'CH404', '004', '020', 'Kamis', 'B0404', 'Darren@admin.ac.id', '2025-04-08 14:59:10', 1),
(205, 'CH404', '004', '021', 'Kamis', 'B0404', 'Darren@admin.ac.id', '2025-04-08 14:59:10', 1),
(206, 'CH404', '004', '022', 'Kamis', 'B0404', 'Darren@admin.ac.id', '2025-04-08 14:59:10', 1),
(207, 'CH404', '004', '023', 'Kamis', 'B0404', 'Darren@admin.ac.id', '2025-04-08 14:59:10', 1),
(208, 'BI505', '005', '005', 'Jumat', 'C0707', 'Darren@admin.ac.id', '2025-04-08 14:59:36', 1),
(209, 'BI505', '005', '006', 'Jumat', 'C0707', 'Darren@admin.ac.id', '2025-04-08 14:59:36', 1),
(210, 'BI505', '005', '007', 'Jumat', 'C0707', 'Darren@admin.ac.id', '2025-04-08 14:59:36', 1),
(211, 'BI505', '005', '008', 'Jumat', 'C0707', 'Darren@admin.ac.id', '2025-04-08 14:59:36', 1),
(212, 'BI505', '005', '009', 'Jumat', 'C0707', 'Darren@admin.ac.id', '2025-04-08 14:59:36', 1),
(213, 'BI505', '005', '010', 'Jumat', 'C0707', 'Darren@admin.ac.id', '2025-04-08 14:59:36', 1),
(214, 'BI505', '005', '011', 'Jumat', 'C0707', 'Darren@admin.ac.id', '2025-04-08 14:59:36', 1),
(215, 'BI505', '005', '012', 'Jumat', 'C0707', 'Darren@admin.ac.id', '2025-04-08 14:59:36', 1),
(216, 'BI505', '005', '013', 'Jumat', 'C0707', 'Darren@admin.ac.id', '2025-04-08 14:59:36', 1),
(217, 'BI505', '005', '014', 'Jumat', 'C0707', 'Darren@admin.ac.id', '2025-04-08 14:59:36', 1),
(218, 'BI505', '005', '015', 'Jumat', 'C0707', 'Darren@admin.ac.id', '2025-04-08 14:59:36', 1),
(219, 'BI505', '005', '016', 'Jumat', 'C0707', 'Darren@admin.ac.id', '2025-04-08 14:59:36', 1),
(220, 'BI505', '005', '017', 'Jumat', 'C0707', 'Darren@admin.ac.id', '2025-04-08 14:59:36', 1),
(221, 'BI505', '005', '018', 'Jumat', 'C0707', 'Darren@admin.ac.id', '2025-04-08 14:59:36', 1),
(222, 'BI505', '005', '019', 'Jumat', 'C0707', 'Darren@admin.ac.id', '2025-04-08 14:59:36', 1),
(223, 'BI505', '005', '020', 'Jumat', 'C0707', 'Darren@admin.ac.id', '2025-04-08 14:59:36', 1),
(224, 'BI505', '005', '021', 'Jumat', 'C0707', 'Darren@admin.ac.id', '2025-04-08 14:59:36', 1),
(225, 'BI505', '005', '022', 'Jumat', 'C0707', 'Darren@admin.ac.id', '2025-04-08 14:59:36', 1),
(226, 'BI505', '005', '023', 'Jumat', 'C0707', 'Darren@admin.ac.id', '2025-04-08 14:59:36', 1),
(227, 'BI505', '005', '024', 'Jumat', 'C0707', 'Darren@admin.ac.id', '2025-04-08 14:59:36', 1),
(228, 'EN606', '001', '006', 'Senin', 'C1205', 'Darren@admin.ac.id', '2025-04-08 15:00:16', 1),
(229, 'EN606', '001', '007', 'Senin', 'C1205', 'Darren@admin.ac.id', '2025-04-08 15:00:16', 1),
(230, 'EN606', '001', '008', 'Senin', 'C1205', 'Darren@admin.ac.id', '2025-04-08 15:00:16', 1),
(231, 'EN606', '001', '009', 'Senin', 'C1205', 'Darren@admin.ac.id', '2025-04-08 15:00:16', 1),
(232, 'EN606', '001', '010', 'Senin', 'C1205', 'Darren@admin.ac.id', '2025-04-08 15:00:16', 1),
(233, 'EN606', '001', '011', 'Senin', 'C1205', 'Darren@admin.ac.id', '2025-04-08 15:00:16', 1),
(234, 'EN606', '001', '012', 'Senin', 'C1205', 'Darren@admin.ac.id', '2025-04-08 15:00:16', 1),
(235, 'EN606', '001', '013', 'Senin', 'C1205', 'Darren@admin.ac.id', '2025-04-08 15:00:16', 1),
(236, 'EN606', '001', '014', 'Senin', 'C1205', 'Darren@admin.ac.id', '2025-04-08 15:00:16', 1),
(237, 'EN606', '001', '015', 'Senin', 'C1205', 'Darren@admin.ac.id', '2025-04-08 15:00:16', 1),
(238, 'EN606', '001', '016', 'Senin', 'C1205', 'Darren@admin.ac.id', '2025-04-08 15:00:16', 1),
(239, 'EN606', '001', '017', 'Senin', 'C1205', 'Darren@admin.ac.id', '2025-04-08 15:00:16', 1),
(240, 'EN606', '001', '018', 'Senin', 'C1205', 'Darren@admin.ac.id', '2025-04-08 15:00:16', 1),
(241, 'EN606', '001', '019', 'Senin', 'C1205', 'Darren@admin.ac.id', '2025-04-08 15:00:16', 1),
(242, 'EN606', '001', '020', 'Senin', 'C1205', 'Darren@admin.ac.id', '2025-04-08 15:00:16', 1),
(243, 'EN606', '001', '021', 'Senin', 'C1205', 'Darren@admin.ac.id', '2025-04-08 15:00:16', 1),
(244, 'EN606', '001', '022', 'Senin', 'C1205', 'Darren@admin.ac.id', '2025-04-08 15:00:16', 1),
(245, 'EN606', '001', '023', 'Senin', 'C1205', 'Darren@admin.ac.id', '2025-04-08 15:00:16', 1),
(246, 'EN606', '001', '024', 'Senin', 'C1205', 'Darren@admin.ac.id', '2025-04-08 15:00:16', 1),
(247, 'EN606', '001', '025', 'Senin', 'C1205', 'Darren@admin.ac.id', '2025-04-08 15:00:16', 1),
(248, 'GE001', '002', '007', 'Selasa', 'D0502', 'Darren@admin.ac.id', '2025-04-08 15:01:03', 1),
(249, 'GE001', '002', '008', 'Selasa', 'D0502', 'Darren@admin.ac.id', '2025-04-08 15:01:03', 1),
(250, 'GE001', '002', '009', 'Selasa', 'D0502', 'Darren@admin.ac.id', '2025-04-08 15:01:03', 1),
(251, 'GE001', '002', '010', 'Selasa', 'D0502', 'Darren@admin.ac.id', '2025-04-08 15:01:03', 1),
(252, 'GE001', '002', '011', 'Selasa', 'D0502', 'Darren@admin.ac.id', '2025-04-08 15:01:03', 1),
(253, 'GE001', '002', '012', 'Selasa', 'D0502', 'Darren@admin.ac.id', '2025-04-08 15:01:03', 1),
(254, 'GE001', '002', '013', 'Selasa', 'D0502', 'Darren@admin.ac.id', '2025-04-08 15:01:03', 1),
(255, 'GE001', '002', '014', 'Selasa', 'D0502', 'Darren@admin.ac.id', '2025-04-08 15:01:03', 1),
(256, 'GE001', '002', '015', 'Selasa', 'D0502', 'Darren@admin.ac.id', '2025-04-08 15:01:03', 1),
(257, 'GE001', '002', '016', 'Selasa', 'D0502', 'Darren@admin.ac.id', '2025-04-08 15:01:03', 1),
(258, 'GE001', '002', '017', 'Selasa', 'D0502', 'Darren@admin.ac.id', '2025-04-08 15:01:03', 1),
(259, 'GE001', '002', '018', 'Selasa', 'D0502', 'Darren@admin.ac.id', '2025-04-08 15:01:03', 1),
(260, 'GE001', '002', '019', 'Selasa', 'D0502', 'Darren@admin.ac.id', '2025-04-08 15:01:04', 1),
(261, 'GE001', '002', '020', 'Selasa', 'D0502', 'Darren@admin.ac.id', '2025-04-08 15:01:04', 1),
(262, 'GE001', '002', '021', 'Selasa', 'D0502', 'Darren@admin.ac.id', '2025-04-08 15:01:04', 1),
(263, 'GE001', '002', '022', 'Selasa', 'D0502', 'Darren@admin.ac.id', '2025-04-08 15:01:04', 1),
(264, 'GE001', '002', '023', 'Selasa', 'D0502', 'Darren@admin.ac.id', '2025-04-08 15:01:04', 1),
(265, 'GE001', '002', '024', 'Selasa', 'D0502', 'Darren@admin.ac.id', '2025-04-08 15:01:04', 1),
(266, 'GE001', '002', '025', 'Selasa', 'D0502', 'Darren@admin.ac.id', '2025-04-08 15:01:04', 1),
(267, 'GE001', '002', '026', 'Selasa', 'D0502', 'Darren@admin.ac.id', '2025-04-08 15:01:04', 1),
(268, 'IF123', '003', '008', 'Rabu', 'C0808', 'Darren@admin.ac.id', '2025-04-08 15:03:01', 1),
(269, 'IF123', '003', '009', 'Rabu', 'C0808', 'Darren@admin.ac.id', '2025-04-08 15:03:01', 1),
(270, 'IF123', '003', '010', 'Rabu', 'C0808', 'Darren@admin.ac.id', '2025-04-08 15:03:01', 1),
(271, 'IF123', '003', '011', 'Rabu', 'C0808', 'Darren@admin.ac.id', '2025-04-08 15:03:01', 1),
(272, 'IF123', '003', '012', 'Rabu', 'C0808', 'Darren@admin.ac.id', '2025-04-08 15:03:01', 1),
(273, 'IF123', '003', '013', 'Rabu', 'C0808', 'Darren@admin.ac.id', '2025-04-08 15:03:01', 1),
(274, 'IF123', '003', '014', 'Rabu', 'C0808', 'Darren@admin.ac.id', '2025-04-08 15:03:01', 1),
(275, 'IF123', '003', '015', 'Rabu', 'C0808', 'Darren@admin.ac.id', '2025-04-08 15:03:01', 1),
(276, 'IF123', '003', '016', 'Rabu', 'C0808', 'Darren@admin.ac.id', '2025-04-08 15:03:01', 1),
(277, 'IF123', '003', '017', 'Rabu', 'C0808', 'Darren@admin.ac.id', '2025-04-08 15:03:01', 1),
(278, 'IF123', '003', '018', 'Rabu', 'C0808', 'Darren@admin.ac.id', '2025-04-08 15:03:01', 1),
(279, 'IF123', '003', '019', 'Rabu', 'C0808', 'Darren@admin.ac.id', '2025-04-08 15:03:01', 1),
(280, 'IF123', '003', '020', 'Rabu', 'C0808', 'Darren@admin.ac.id', '2025-04-08 15:03:01', 1),
(281, 'IF123', '003', '021', 'Rabu', 'C0808', 'Darren@admin.ac.id', '2025-04-08 15:03:01', 1),
(282, 'IF123', '003', '022', 'Rabu', 'C0808', 'Darren@admin.ac.id', '2025-04-08 15:03:01', 1),
(283, 'IF123', '003', '023', 'Rabu', 'C0808', 'Darren@admin.ac.id', '2025-04-08 15:03:01', 1),
(284, 'IF123', '003', '024', 'Rabu', 'C0808', 'Darren@admin.ac.id', '2025-04-08 15:03:01', 1),
(285, 'IF123', '003', '025', 'Rabu', 'C0808', 'Darren@admin.ac.id', '2025-04-08 15:03:01', 1),
(286, 'IF123', '003', '026', 'Rabu', 'C0808', 'Darren@admin.ac.id', '2025-04-08 15:03:01', 1),
(287, 'IF123', '003', '027', 'Rabu', 'C0808', 'Darren@admin.ac.id', '2025-04-08 15:03:01', 1),
(288, 'IF330', '004', '009', 'Kamis', 'D0403', 'Darren@admin.ac.id', '2025-04-08 15:03:47', 1),
(289, 'IF330', '004', '010', 'Kamis', 'D0403', 'Darren@admin.ac.id', '2025-04-08 15:03:47', 1),
(290, 'IF330', '004', '011', 'Kamis', 'D0403', 'Darren@admin.ac.id', '2025-04-08 15:03:47', 1),
(291, 'IF330', '004', '012', 'Kamis', 'D0403', 'Darren@admin.ac.id', '2025-04-08 15:03:47', 1),
(292, 'IF330', '004', '013', 'Kamis', 'D0403', 'Darren@admin.ac.id', '2025-04-08 15:03:47', 1),
(293, 'IF330', '004', '014', 'Kamis', 'D0403', 'Darren@admin.ac.id', '2025-04-08 15:03:47', 1),
(294, 'IF330', '004', '015', 'Kamis', 'D0403', 'Darren@admin.ac.id', '2025-04-08 15:03:47', 1),
(295, 'IF330', '004', '016', 'Kamis', 'D0403', 'Darren@admin.ac.id', '2025-04-08 15:03:47', 1),
(296, 'IF330', '004', '017', 'Kamis', 'D0403', 'Darren@admin.ac.id', '2025-04-08 15:03:47', 1),
(297, 'IF330', '004', '018', 'Kamis', 'D0403', 'Darren@admin.ac.id', '2025-04-08 15:03:47', 1),
(298, 'IF330', '004', '019', 'Kamis', 'D0403', 'Darren@admin.ac.id', '2025-04-08 15:03:47', 1),
(299, 'IF330', '004', '020', 'Kamis', 'D0403', 'Darren@admin.ac.id', '2025-04-08 15:03:47', 1),
(300, 'IF330', '004', '021', 'Kamis', 'D0403', 'Darren@admin.ac.id', '2025-04-08 15:03:47', 1),
(301, 'IF330', '004', '022', 'Kamis', 'D0403', 'Darren@admin.ac.id', '2025-04-08 15:03:47', 1),
(302, 'IF330', '004', '023', 'Kamis', 'D0403', 'Darren@admin.ac.id', '2025-04-08 15:03:47', 1),
(303, 'IF330', '004', '024', 'Kamis', 'D0403', 'Darren@admin.ac.id', '2025-04-08 15:03:47', 1),
(304, 'IF330', '004', '025', 'Kamis', 'D0403', 'Darren@admin.ac.id', '2025-04-08 15:03:47', 1),
(305, 'IF330', '004', '026', 'Kamis', 'D0403', 'Darren@admin.ac.id', '2025-04-08 15:03:47', 1),
(306, 'IF330', '004', '027', 'Kamis', 'D0403', 'Darren@admin.ac.id', '2025-04-08 15:03:47', 1),
(307, 'IF330', '004', '028', 'Kamis', 'D0403', 'Darren@admin.ac.id', '2025-04-08 15:03:47', 1),
(308, 'CE699', '005', '010', 'Jumat', 'B1010', 'Darren@admin.ac.id', '2025-04-08 15:04:10', 1),
(309, 'CE699', '005', '011', 'Jumat', 'B1010', 'Darren@admin.ac.id', '2025-04-08 15:04:10', 1),
(310, 'CE699', '005', '012', 'Jumat', 'B1010', 'Darren@admin.ac.id', '2025-04-08 15:04:10', 1),
(311, 'CE699', '005', '013', 'Jumat', 'B1010', 'Darren@admin.ac.id', '2025-04-08 15:04:10', 1),
(312, 'CE699', '005', '014', 'Jumat', 'B1010', 'Darren@admin.ac.id', '2025-04-08 15:04:10', 1),
(313, 'CE699', '005', '015', 'Jumat', 'B1010', 'Darren@admin.ac.id', '2025-04-08 15:04:10', 1),
(314, 'CE699', '005', '016', 'Jumat', 'B1010', 'Darren@admin.ac.id', '2025-04-08 15:04:10', 1),
(315, 'CE699', '005', '017', 'Jumat', 'B1010', 'Darren@admin.ac.id', '2025-04-08 15:04:10', 1),
(316, 'CE699', '005', '018', 'Jumat', 'B1010', 'Darren@admin.ac.id', '2025-04-08 15:04:10', 1),
(317, 'CE699', '005', '019', 'Jumat', 'B1010', 'Darren@admin.ac.id', '2025-04-08 15:04:10', 1),
(318, 'CE699', '005', '020', 'Jumat', 'B1010', 'Darren@admin.ac.id', '2025-04-08 15:04:10', 1),
(319, 'CE699', '005', '021', 'Jumat', 'B1010', 'Darren@admin.ac.id', '2025-04-08 15:04:10', 1),
(320, 'CE699', '005', '022', 'Jumat', 'B1010', 'Darren@admin.ac.id', '2025-04-08 15:04:10', 1),
(321, 'CE699', '005', '023', 'Jumat', 'B1010', 'Darren@admin.ac.id', '2025-04-08 15:04:10', 1),
(322, 'CE699', '005', '024', 'Jumat', 'B1010', 'Darren@admin.ac.id', '2025-04-08 15:04:10', 1),
(323, 'CE699', '005', '025', 'Jumat', 'B1010', 'Darren@admin.ac.id', '2025-04-08 15:04:10', 1),
(324, 'CE699', '005', '026', 'Jumat', 'B1010', 'Darren@admin.ac.id', '2025-04-08 15:04:10', 1),
(325, 'CE699', '005', '027', 'Jumat', 'B1010', 'Darren@admin.ac.id', '2025-04-08 15:04:10', 1),
(326, 'CE699', '005', '028', 'Jumat', 'B1010', 'Darren@admin.ac.id', '2025-04-08 15:04:10', 1),
(327, 'CE699', '005', '029', 'Jumat', 'B1010', 'Darren@admin.ac.id', '2025-04-08 15:04:10', 1);

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `NIM` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `tahun_masuk` year(4) NOT NULL,
  `alamat` text DEFAULT NULL,
  `telp` varchar(15) DEFAULT NULL,
  `user_input` varchar(50) DEFAULT NULL,
  `tanggal_input` datetime DEFAULT current_timestamp(),
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`NIM`, `nama`, `tahun_masuk`, `alamat`, `telp`, `user_input`, `tanggal_input`, `password`) VALUES
('001', 'dummy', '2025', 'Jakarta', '123', 'Dummy1@student.ac.id', '2025-04-03 20:49:22', '5e5545d38a68148a2d5bd5ec9a89e327'),
('002', 'dummy2', '2025', 'Serpong', '321', 'Dummy2@student.ac.id', '2025-04-03 20:49:55', '213ee683360d88249109c2f92789dbc3'),
('003', 'Ahmad Faisal', '2025', 'Jakarta', '123', 'ahmadf@student.ac.id', '2025-04-06 20:24:39', '8e4947690532bc44a8e41e9fb365b76a'),
('004', 'Rina Sari', '2025', 'Serpong', '321', 'rinas@student.ac.id', '2025-04-06 20:24:39', '34cc93ece0ba9e3f6f235d4af979b16c'),
('005', 'Dewi Kusuma', '2025', 'Bekasi', '456', 'dewik@student.ac.id', '2025-04-06 20:24:39', 'db0edd04aaac4506f7edab03ac855d56'),
('006', 'Aditya Rahman', '2025', 'Depok', '789', 'adityar@student.ac.id', '2025-04-06 20:24:39', '218dd27aebeccecae69ad8408d9a36bf'),
('007', 'Budi Santoso', '2025', 'Tangerang', '147', 'budis@student.ac.id', '2025-04-06 20:24:39', '00cdb7bb942cf6b290ceb97d6aca64a3'),
('008', 'Nadia Putri', '2025', 'Bogor', '258', 'nadiap@student.ac.id', '2025-04-06 20:24:39', 'b25ef06be3b6948c0bc431da46c2c738'),
('009', 'Rizky Saputra', '2025', 'Bandung', '369', 'rizkys@student.ac.id', '2025-04-06 20:24:39', '5d69dd95ac183c9643780ed7027d128a'),
('010', 'Ayu Kartika', '2025', 'Surabaya', '987', 'ayuk@student.ac.id', '2025-04-06 20:24:39', '87e897e3b54a405da144968b2ca19b45'),
('011', 'Farhan Hakim', '2025', 'Medan', '654', 'farhanh@student.ac.id', '2025-04-06 20:24:39', '1e5c2776cf544e213c3d279c40719643'),
('012', 'Siti Amalia', '2025', 'Bali', '321', 'sitia@student.ac.id', '2025-04-06 20:24:39', 'c24a542f884e144451f9063b79e7994e'),
('013', 'Andi Pratama', '2025', 'Semarang', '741', 'andip@student.ac.id', '2025-04-06 20:24:39', 'ee684912c7e588d03ccb40f17ed080c9'),
('014', 'Jessica Tan', '2025', 'Palembang', '852', 'jessicat@student.ac.id', '2025-04-06 20:24:39', '8ee736784ce419bd16554ed5677ff35b'),
('015', 'Dian Febri', '2025', 'Makassar', '963', 'dianf@student.ac.id', '2025-04-06 20:24:39', '9141fea0574f83e190ab7479d516630d'),
('016', 'Robby Wijaya', '2025', 'Balikpapan', '753', 'robbyw@student.ac.id', '2025-04-06 20:24:39', '2b40aaa979727c43411c305540bbed50'),
('017', 'Mila Zahra', '2025', 'Yogyakarta', '864', 'milaz@student.ac.id', '2025-04-06 20:24:39', 'a63f9709abc75bf8bd8f6e1ba9992573'),
('018', 'Rifqi Ananda', '2025', 'Manado', '951', 'rifqia@student.ac.id', '2025-04-06 20:24:39', '80b8bdceb474b5127b6aca386bb8ce14'),
('019', 'Tasya Melinda', '2025', 'Padang', '357', 'tasyam@student.ac.id', '2025-04-06 20:24:39', 'e532ae6f28f4c2be70b500d3d34724eb'),
('020', 'Fadhil Pratama', '2025', 'Malang', '159', 'fadhilp@student.ac.id', '2025-04-06 20:24:39', 'aee67d9bb569ad1562f7b67cfccbd2ef'),
('021', 'Vina Rosiana', '2025', 'Pontianak', '753', 'vinar@student.ac.id', '2025-04-06 20:24:39', '568c31f0f2406ab70255a1d83291220f'),
('022', 'Arya Nugraha', '2025', 'Jayapura', '468', 'aryan@student.ac.id', '2025-04-06 20:24:39', '069103d83d40b742a336dee5fb92f4e5'),
('023', 'Lisa Arifin', '2025', 'Batam', '951', 'lisaar@student.ac.id', '2025-04-06 20:24:39', '1f82cdf9195b31244721c6026587fb78'),
('024', 'Hafidz Setiawan', '2025', 'Pekanbaru', '753', 'hafidzs@student.ac.id', '2025-04-06 20:24:39', '58bad6b697dff48f4927941962f23e90'),
('025', 'Zahra Indri', '2025', 'Bengkulu', '468', 'zahrai@student.ac.id', '2025-04-06 20:24:39', '6982e82c0b21af5526754d83df2d1635'),
('026', 'Dimas Rahmat', '2025', 'Lampung', '159', 'dimasr@student.ac.id', '2025-04-06 20:24:39', 'dc2d937cba912f093445d008f0461c83'),
('027', 'Reza Putra', '2025', 'Aceh', '753', 'rezap@student.ac.id', '2025-04-06 20:24:39', 'ccf08fd9a560b266470bf8ab97fc7c26'),
('028', 'Michelle Ang', '2025', 'Samarinda', '468', 'michellea@student.ac.id', '2025-04-06 20:24:39', '3b635d4df2c9ece93b97759531d6ed01'),
('029', 'Ilham Yuda', '2025', 'Kupang', '951', 'ilhamy@student.ac.id', '2025-04-06 20:24:39', '926742e502de7d22686bb1d4a07fe635'),
('030', 'Stefan Wijaya', '2025', 'Cirebon', '753', 'stefanw@student.ac.id', '2025-04-06 20:24:39', '3dc94727dbba08bdd21d7b318b410600');

-- --------------------------------------------------------

--
-- Table structure for table `mata_kuliah`
--

CREATE TABLE `mata_kuliah` (
  `kode_matkul` varchar(10) NOT NULL,
  `nama_matkul` varchar(100) NOT NULL,
  `sks` int(11) NOT NULL,
  `semester` int(11) NOT NULL,
  `user_input` varchar(50) DEFAULT NULL,
  `tanggal_input` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mata_kuliah`
--

INSERT INTO `mata_kuliah` (`kode_matkul`, `nama_matkul`, `sks`, `semester`, `user_input`, `tanggal_input`) VALUES
('BI505', 'Biology V', 3, 6, 'Darren@admin.ac.id', '2025-04-06 20:35:20'),
('CE699', 'AI-Management', 3, 6, 'Darren@admin.ac.id', '2025-04-02 20:45:49'),
('CH404', 'Chemistry IV', 2, 5, 'Darren@admin.ac.id', '2025-04-06 20:35:20'),
('CS101', 'Computer Science Basics', 3, 2, 'Darren@admin.ac.id', '2025-04-06 20:35:20'),
('EN606', 'Engineering VI', 2, 1, 'Darren@admin.ac.id', '2025-04-06 20:35:20'),
('GE001', 'English 1', 2, 1, 'Darren@admin.ac.id', '2025-04-02 20:44:59'),
('IF123', 'Algebra', 2, 1, 'Darren@admin.ac.id', '2025-04-03 20:30:37'),
('IF330', 'Web Programming', 3, 4, 'Darren@admin.ac.id', '2025-04-02 20:46:27'),
('MA202', 'Mathematics II', 2, 3, 'Darren@admin.ac.id', '2025-04-06 20:35:20'),
('PH303', 'Physics III', 3, 4, 'Darren@admin.ac.id', '2025-04-06 20:35:20');

-- --------------------------------------------------------

--
-- Table structure for table `menu_roles`
--

CREATE TABLE `menu_roles` (
  `id` int(11) NOT NULL,
  `menu_name` varchar(50) NOT NULL,
  `role` enum('Admin','Dosen','Mahasiswa') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `professions`
--

CREATE TABLE `professions` (
  `id` int(11) NOT NULL,
  `profession_name` enum('professor','lecturer','lecture_head','assistant') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dosen`
--
ALTER TABLE `dosen`
  ADD PRIMARY KEY (`NIK`),
  ADD KEY `profession_id` (`profession_id`);

--
-- Indexes for table `krs`
--
ALTER TABLE `krs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kode_matkul` (`kode_matkul`),
  ADD KEY `NIK_dosen` (`NIK_dosen`),
  ADD KEY `krs_ibfk_3` (`NIM_mahasiswa`);

--
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`NIM`);

--
-- Indexes for table `mata_kuliah`
--
ALTER TABLE `mata_kuliah`
  ADD PRIMARY KEY (`kode_matkul`);

--
-- Indexes for table `menu_roles`
--
ALTER TABLE `menu_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `professions`
--
ALTER TABLE `professions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `krs`
--
ALTER TABLE `krs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=328;

--
-- AUTO_INCREMENT for table `menu_roles`
--
ALTER TABLE `menu_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `professions`
--
ALTER TABLE `professions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dosen`
--
ALTER TABLE `dosen`
  ADD CONSTRAINT `dosen_ibfk_1` FOREIGN KEY (`profession_id`) REFERENCES `professions` (`id`);

--
-- Constraints for table `krs`
--
ALTER TABLE `krs`
  ADD CONSTRAINT `krs_ibfk_1` FOREIGN KEY (`kode_matkul`) REFERENCES `mata_kuliah` (`kode_matkul`),
  ADD CONSTRAINT `krs_ibfk_2` FOREIGN KEY (`NIK_dosen`) REFERENCES `dosen` (`NIK`),
  ADD CONSTRAINT `krs_ibfk_3` FOREIGN KEY (`NIM_mahasiswa`) REFERENCES `mahasiswa` (`NIM`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
