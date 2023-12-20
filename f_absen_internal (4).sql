-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 20, 2023 at 10:20 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `f_absen_internal`
--

-- --------------------------------------------------------

--
-- Table structure for table `fai_absen`
--

CREATE TABLE `fai_absen` (
  `id_absen` varchar(255) NOT NULL,
  `id_user` varchar(255) NOT NULL,
  `tgl_absen` date DEFAULT NULL,
  `absen_masuk` varchar(5) NOT NULL,
  `absen_pulang` varchar(5) NOT NULL,
  `pending` int(11) NOT NULL COMMENT '0 - live absen, 1 - pending, 2- pending acc,3 - pending ditolak, 4 - Cuti, 5 - unpaid leave, 6 - sakit, 7 - pending cuti, 8 - pending unpaid leave, 9 - pending sakit, 10 - pending libur shift, 11 - libur shift',
  `catatan_pending` text NOT NULL,
  `id_lokasi` varchar(255) DEFAULT NULL,
  `tgl_add` datetime NOT NULL DEFAULT current_timestamp(),
  `tgl_update` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fai_absen`
--

INSERT INTO `fai_absen` (`id_absen`, `id_user`, `tgl_absen`, `absen_masuk`, `absen_pulang`, `pending`, `catatan_pending`, `id_lokasi`, `tgl_add`, `tgl_update`) VALUES
('0405092411c51d61f3a316aff18525e6', '4bc0c527a7c2a9053450a7fb8f92746f', '2023-06-12', '', '', 4, 'tes', NULL, '2023-06-12 09:49:32', '2023-06-21 16:59:26'),
('0f957cf7abe229af565e89f7c5d5d15b', '4bc0c527a7c2a9053450a7fb8f92746f', '2023-07-24', '07:30', '18:00', 0, 'auto absen', NULL, '2023-07-26 13:13:49', NULL),
('1bd1dd5081780535706f893094f0f436', 'd366b0867097f7a0dc3d309cbbd3179e', '2023-10-13', '07:30', '18:00', 6, 'absen sakit - Muhammad Alfan Alfad', NULL, '2023-10-30 14:18:10', NULL),
('20c5bbdd87e221c5411c8cd8a85c10e2', '4bc0c527a7c2a9053450a7fb8f92123', '2023-11-04', '07:30', '18:00', 0, 'auto absen - Muhammad Alfan Alfad', 'bac9ed7276e1034d458d97cfd3445e0c', '2023-11-14 15:52:31', NULL),
('2131ca5a21d54b962ef6ef1efeee472c', '4bc0c527a7c2a9053450a7fb8f92746f', '2023-07-09', '07:30', '18:00', 4, 'auto cuti', NULL, '2023-07-04 14:43:46', NULL),
('228b6fedabfe84c6515b88f0129c7812', '4bc0c527a7c2a9053450a7fb8f92123', '2023-11-03', '07:30', '18:00', 0, 'auto absen - Muhammad Alfan Alfad', 'bac9ed7276e1034d458d97cfd3445e0c', '2023-11-14 15:52:31', NULL),
('311826c195861c333e9b18922216618b', '4bc0c527a7c2a9053450a7fb8f92746f', '2023-07-02', '', '', 11, 'Libur Shift', NULL, '2023-07-03 11:59:39', NULL),
('3b73a7e0d0e756324fe73c5f11fc3312', '4bc0c527a7c2a9053450a7fb8f92746f', '2023-06-10', '', '', 5, 'luar kota', NULL, '2023-06-05 14:28:51', '2023-06-06 16:36:23'),
('3e63010fded411202bd1da1968026d99', '4bc0c527a7c2a9053450a7fb8f92746f', '2023-07-08', '07:30', '18:00', 4, 'auto cuti', NULL, '2023-07-04 14:43:46', NULL),
('40240e6b92c5fb898f2a7e746e0bd6a7', '4bc0c527a7c2a9053450a7fb8f92123', '2023-11-07', '07:30', '18:00', 0, 'auto absen - Muhammad Alfan Alfad', 'f5859c122e621de2dfc7da86dbda2497', '2023-11-14 15:52:43', NULL),
('518adfa3068e25360f98c98a2a768a84', '4bc0c527a7c2a9053450a7fb8f92746f', '2023-06-17', '', '', 11, 'lbr', NULL, '2023-06-19 14:08:02', '2023-06-19 14:08:22'),
('580a512a9a92a273eff89d71a7b59467', '4bc0c527a7c2a9053450a7fb8f92123', '2023-11-13', '07:30', '18:00', 0, 'auto absen - Muhammad Alfan Alfad', 'f5859c122e621de2dfc7da86dbda2497', '2023-11-14 14:27:15', NULL),
('5b88813671f34726b1a67af5486aaaaf', '4bc0c527a7c2a9053450a7fb8f92746f', '2023-07-07', '07:30', '18:00', 4, 'auto cuti', NULL, '2023-07-04 14:43:46', NULL),
('600c456677ffe07fb4b580e486c261ec', '4bc0c527a7c2a9053450a7fb8f92746f', '2023-07-28', '07:59', '', 1, 'lupa', NULL, '2023-07-28 08:41:09', NULL),
('6304dd1ba42f45bd0b28f665528a820f', 'd366b0867097f7a0dc3d309cbbd3179e', '2023-10-03', '07:30', '18:00', 4, 'auto cuti - Muhammad Alfan Alfad', NULL, '2023-10-30 14:18:29', NULL),
('6d9c6cd7b82fe6fe53676620709b4541', '4bc0c527a7c2a9053450a7fb8f92123', '2023-11-11', '07:30', '18:00', 0, 'auto absen - Muhammad Alfan Alfad', 'f5859c122e621de2dfc7da86dbda2497', '2023-11-14 15:52:43', NULL),
('70b991cec2d6209389e54c6639591c03', '4bc0c527a7c2a9053450a7fb8f92746f', '2023-06-29', '11:07', '11:07', 0, '', NULL, '2023-06-28 11:07:03', '2023-06-28 11:07:28'),
('738f1ed6d3648c89bad58bfeb953ed33', 'd366b0867097f7a0dc3d309cbbd3179e', '2023-10-05', '07:30', '18:00', 4, 'auto cuti - Muhammad Alfan Alfad', NULL, '2023-10-30 14:18:29', NULL),
('76c09140cf070a0ed12d7a80ebce1ff6', '4bc0c527a7c2a9053450a7fb8f92746f', '2023-07-22', '07:30', '18:00', 0, 'auto absen', NULL, '2023-07-26 13:13:49', NULL),
('76f34d3307dc2144b9e9620daf63665d', '4bc0c527a7c2a9053450a7fb8f92746f', '2023-05-31', '11:15', '', 0, '', NULL, '2023-05-25 11:15:53', '2023-05-31 17:09:25'),
('7844689008809f9cf34fff9db1ab1c02', '4bc0c527a7c2a9053450a7fb8f92123', '2023-11-08', '07:30', '18:00', 0, 'auto absen - Muhammad Alfan Alfad', 'f5859c122e621de2dfc7da86dbda2497', '2023-11-14 15:52:43', NULL),
('7af211768894d0070fa2504bac27c4ea', 'd366b0867097f7a0dc3d309cbbd3179e', '2023-10-11', '07:30', '18:00', 6, 'absen sakit - Muhammad Alfan Alfad', NULL, '2023-10-30 14:18:10', NULL),
('7daf3da64a3b97407801e78421fad193', 'd366b0867097f7a0dc3d309cbbd3179e', '2023-10-28', '07:30', '18:00', 5, 'absen unpaid leave - Muhammad Alfan Alfad', NULL, '2023-10-30 14:17:48', NULL),
('8dc73f6c9088dedbeda864c14dcb34f5', '4bc0c527a7c2a9053450a7fb8f92123', '2023-11-10', '07:30', '18:00', 0, 'auto absen - Muhammad Alfan Alfad', 'f5859c122e621de2dfc7da86dbda2497', '2023-11-14 15:52:43', NULL),
('a3a61bba1cb2cdf755dff3cbc8247a29', 'd366b0867097f7a0dc3d309cbbd3179e', '2023-10-04', '07:30', '18:00', 4, 'auto cuti - Muhammad Alfan Alfad', NULL, '2023-10-30 14:18:29', NULL),
('a468a7950e74a64ae26a4dc85b652bc4', '4bc0c527a7c2a9053450a7fb8f92746f', '2023-06-18', '', '', 11, 'libur', NULL, '2023-06-19 12:00:14', '2023-06-19 14:07:43'),
('a7243d31e80eea483cc5a1dcb1e3d590', '4bc0c527a7c2a9053450a7fb8f92123', '2023-11-02', '07:30', '18:00', 0, 'auto absen - Muhammad Alfan Alfad', 'bac9ed7276e1034d458d97cfd3445e0c', '2023-11-14 15:52:31', NULL),
('ba7d3decc7265504b88b60dc724c50cf', '4bc0c527a7c2a9053450a7fb8f92746f', '2023-07-06', '07:30', '18:00', 4, 'auto cuti', NULL, '2023-07-04 14:43:46', NULL),
('bac19c8385a063d3e46bb0e2d0811a51', '4bc0c527a7c2a9053450a7fb8f92123', '2023-11-15', '07:30', '18:00', 4, 'auto cuti', NULL, '2023-11-15 14:25:20', NULL),
('bae24217a5756ad25f7493c2b6ee247b', '4bc0c527a7c2a9053450a7fb8f92746f', '2023-07-01', '', '', 11, 'Libur Shift', NULL, '2023-07-03 11:53:15', NULL),
('c0448e43819a6ba722b84c44b94cf682', '4bc0c527a7c2a9053450a7fb8f92123', '2023-11-14', '07:30', '18:00', 0, 'auto absen - Muhammad Alfan Alfad', 'bac9ed7276e1034d458d97cfd3445e0c', '2023-11-14 14:24:59', NULL),
('c81705a1fed614b5f857d1d59bc9c223', '4bc0c527a7c2a9053450a7fb8f92123', '2023-11-06', '07:30', '18:00', 0, 'auto absen - Muhammad Alfan Alfad', 'f5859c122e621de2dfc7da86dbda2497', '2023-11-14 15:52:43', NULL),
('cd3f19d985172cfd1013554d3d02b3ea', '4bc0c527a7c2a9053450a7fb8f92123', '2023-11-09', '07:30', '18:00', 0, 'auto absen - Muhammad Alfan Alfad', '', '2023-11-14 15:52:43', '2023-11-14 16:07:01'),
('d063d98163a5edf9523a86eb8e632e67', '4bc0c527a7c2a9053450a7fb8f92746f', '2023-06-04', '', '', 11, 'lbr', NULL, '2023-06-19 14:07:28', '2023-06-19 14:08:19'),
('e134b26c27e38e79dcadb60d063c8b8b', '4bc0c527a7c2a9053450a7fb8f92746f', '2023-07-10', '07:30', '18:00', 4, 'auto cuti', NULL, '2023-07-04 14:43:46', NULL),
('f90c0fc4e1faafa449c052e97c26629a', 'd366b0867097f7a0dc3d309cbbd3179e', '2023-10-26', '07:30', '18:00', 5, 'absen unpaid leave - Muhammad Alfan Alfad', NULL, '2023-10-30 14:17:48', NULL),
('f91480543f0dc38483a14e4134a1a67e', '4bc0c527a7c2a9053450a7fb8f92746f', '2023-06-25', '', '', 11, 'lbr', NULL, '2023-06-19 14:08:09', '2023-06-19 14:08:15'),
('fad64a90d7f1046555d370b0e2966512', 'd366b0867097f7a0dc3d309cbbd3179e', '2023-10-12', '07:30', '18:00', 6, 'absen sakit - Muhammad Alfan Alfad', NULL, '2023-10-30 14:18:10', NULL),
('fb3aa62c27719b34b614244c9437c4b0', '4bc0c527a7c2a9053450a7fb8f92123', '2023-11-01', '07:30', '18:00', 0, 'auto absen - Muhammad Alfan Alfad', 'bac9ed7276e1034d458d97cfd3445e0c', '2023-11-14 15:52:31', NULL),
('fb6c18e11f47596192b61607e2211a3f', '4bc0c527a7c2a9053450a7fb8f92746f', '2023-06-19', '14:00', '14:00', 0, '', NULL, '2023-06-19 14:00:06', '2023-06-19 14:00:11'),
('fd247386ac47faefcbacbb0c3765a3ce', 'd366b0867097f7a0dc3d309cbbd3179e', '2023-10-27', '07:30', '18:00', 5, 'absen unpaid leave - Muhammad Alfan Alfad', NULL, '2023-10-30 14:17:48', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fai_akun`
--

CREATE TABLE `fai_akun` (
  `id_akun` varchar(255) NOT NULL,
  `nama_user` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `id_jabatan` varchar(255) NOT NULL,
  `id_lokasi` varchar(255) NOT NULL,
  `sisa_cuti` int(2) NOT NULL,
  `role_user` tinyint(1) NOT NULL COMMENT '1-user,2-admin, 3 - su admin',
  `role_pegawai` tinyint(1) NOT NULL COMMENT '1-staff,2-atasan',
  `role_shift` tinyint(1) NOT NULL COMMENT '1 - tetap/non shift; 2 - ada shift/ berubah ubah per bulan',
  `no_telp` varchar(20) NOT NULL,
  `tgl_add` datetime NOT NULL DEFAULT current_timestamp(),
  `tgl_update` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `tgl_delete` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fai_akun`
--

INSERT INTO `fai_akun` (`id_akun`, `nama_user`, `email`, `password`, `id_jabatan`, `id_lokasi`, `sisa_cuti`, `role_user`, `role_pegawai`, `role_shift`, `no_telp`, `tgl_add`, `tgl_update`, `tgl_delete`) VALUES
('4bc0c527a7c2a9053450a7fb8f92123', 'Muhammad Alfan Alfad', 'alfan@gmail.com', '25f9e794323b453885f5181f1b624d0b', '056f1e0921dec47f2d7a5c99dc263c5e', 'f5859c122e621de2dfc7da86dbda2497', 3, 3, 1, 2, '085232998963', '2023-05-24 09:43:00', '2023-11-22 10:25:42', '2023-11-06 10:25:39'),
('4bc0c527a7c2a9053450a7fb8f92746f', 'Muhammad Alfan Alfad', 'muhammad.alfan2000@gmail.com', '25f9e794323b453885f5181f1b624d0b', '6e5dfcdab3ed5991d49692be6442f415', 'f5859c122e621de2dfc7da86dbda2497', 3, 3, 1, 2, '085232998963', '2023-05-24 09:43:00', '2023-11-22 16:02:17', NULL),
('95ddf26fe5ead88db8b23936157aff0f', 'user2', 'ok2@ok.com', '25f9e794323b453885f5181f1b624d0b', 'f9c3eb7acc5cc81ba3ee91f0d96f1016', 'bac9ed7276e1034d458d97cfd3445e0c', 12, 1, 2, 1, '08222222222', '2023-05-29 17:06:21', '2023-06-19 08:48:59', NULL),
('ab6af1532a5c53c0a48ceede821ce6fa', 'NON ASET', 'naset@ok.com', '25f9e794323b453885f5181f1b624d0b', '056f1e0921dec47f2d7a5c99dc263c5e', 'bac9ed7276e1034d458d97cfd3445e0c', 12, 1, 1, 1, '0811111', '2023-11-22 10:34:46', NULL, NULL),
('c3b06e21efb13a2e6049143971e969a1', 'user3', 'user3@gmail.com', '25f9e794323b453885f5181f1b624d0b', '056f1e0921dec47f2d7a5c99dc263c5e', 'bac9ed7276e1034d458d97cfd3445e0c', 12, 1, 1, 2, '08777777777777', '2023-06-19 11:08:18', NULL, NULL),
('d366b0867097f7a0dc3d309cbbd3179e', 'user12', 'ok12@ok.com', '25f9e794323b453885f5181f1b624d0b', 'f9c3eb7acc5cc81ba3ee91f0d96f1016', 'f5859c122e621de2dfc7da86dbda2497', 12, 1, 1, 1, '08511111111111111', '2023-05-29 16:40:46', '2023-06-19 08:49:03', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fai_akun_lokasi`
--

CREATE TABLE `fai_akun_lokasi` (
  `id_al` varchar(255) NOT NULL,
  `id_akun` varchar(255) NOT NULL,
  `id_lokasi` varchar(255) NOT NULL,
  `tgl_add` datetime NOT NULL DEFAULT current_timestamp(),
  `tgl_update` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `tgl_delete` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `fai_jabatan`
--

CREATE TABLE `fai_jabatan` (
  `id_jabatan` varchar(255) NOT NULL,
  `nama_jabatan` varchar(100) NOT NULL,
  `tgl_add` datetime NOT NULL DEFAULT current_timestamp(),
  `tgl_update` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `tgl_delete` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fai_jabatan`
--

INSERT INTO `fai_jabatan` (`id_jabatan`, `nama_jabatan`, `tgl_add`, `tgl_update`, `tgl_delete`) VALUES
('056f1e0921dec47f2d7a5c99dc263c5e', 'IT Engineer', '2023-05-24 09:40:40', '2023-05-30 10:27:30', NULL),
('08f6e62663b6cc3dc4e63226f59f95a0', 'Operator Level 2', '2023-06-26 03:43:42', NULL, NULL),
('2138422265bd7a372b01157adbed7a2a', 'Office Boy Level 2', '2023-06-26 03:44:44', NULL, NULL),
('2bdcf9262064c8d7ff90b92fcd38c869', 'Operator Level 1', '2023-06-26 03:43:36', NULL, NULL),
('2d072100fe66cd70d66f9db98f4c4f85', 'Admin Project', '2023-05-30 04:40:28', NULL, NULL),
('32ca2df67bd97b74daf8f53dfcc231b7', 'Office Boy Level 1', '2023-05-30 04:39:54', NULL, NULL),
('515cca23f0dd96270ca792d353976da5', 'Admin Finance', '2023-09-14 02:27:49', '2023-09-14 03:25:53', NULL),
('58aa5ff26563b7b33ca96a1a1e500242', 'Techinical Level 1', '2023-05-30 04:40:02', NULL, NULL),
('6e5dfcdab3ed5991d49692be6442f415', 'Accounting, Tax & SDM', '2023-05-30 04:39:05', NULL, NULL),
('762fb2da997a068ed1057094b4370cab', 'Admin Marketing', '2023-05-30 04:39:39', NULL, NULL),
('77c6418746bf94232261edb14d4566c9', 'Engineer Level 3 ', '2023-05-30 04:40:09', NULL, NULL),
('8022f429c5af2dccbb5e0f08901218ee', 'Technical Advisior', '2023-06-26 03:47:48', NULL, NULL),
('80813326aa9f0dd7e6978e8bde1b3d6b', 'Procurement & Cost Control ', '2023-05-30 04:39:32', NULL, NULL),
('863c9b7569ef8af008613508a584e233', 'Direktur Utama', '2023-05-30 04:39:12', NULL, NULL),
('890e32271f245e14ac9b067318d953aa', 'Kepala Cabang', '2023-06-26 03:47:19', NULL, NULL),
('a3cd4d59dddb35743983714f155b6235', 'Manager Konstruksi', '2023-07-04 09:16:09', NULL, NULL),
('aaccca3d661d23a0f03f5324af3fdcfe', 'Direktur Operasional', '2023-05-30 04:39:18', NULL, NULL),
('cc644bf4a4e6d469d31a26d4340156f9', 'Admin Operasional', '2023-05-30 04:39:25', NULL, NULL),
('e2a9afd6fa65c5b2b56541a5a1164993', 'HSE', '2023-06-26 07:49:53', NULL, NULL),
('e3ecf0c2f6e742364f2b1ae784b29cf0', 'Leader Grup', '2023-06-26 03:47:33', NULL, NULL),
('ebbc27a4eefcbc023708cde85a637db3', 'Admin Cabang', '2023-05-30 04:40:20', NULL, NULL),
('ed516e1c7cb6ed550295d6817cb8dba6', 'Manager Engineer', '2023-07-04 09:16:00', NULL, NULL),
('f89b0c7f9e76ff5f4c94c0344b082bc8', 'Engineer Level 2 ', '2023-05-30 04:40:14', NULL, NULL),
('f9c3eb7acc5cc81ba3ee91f0d96f1016', 'Engineer', '2023-05-29 14:40:18', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fai_lembur`
--

CREATE TABLE `fai_lembur` (
  `id_lembur` varchar(255) NOT NULL,
  `id_akun` varchar(255) NOT NULL,
  `tgl_lembur` date NOT NULL,
  `mulai_lembur` varchar(5) NOT NULL,
  `selesai_lembur` varchar(5) NOT NULL,
  `point_lembur` decimal(10,2) NOT NULL,
  `status_lembur` tinyint(1) NOT NULL COMMENT '0 - pending; 1 - acc',
  `keterangan` varchar(255) NOT NULL,
  `tgl_add` datetime NOT NULL DEFAULT current_timestamp(),
  `tgl_update` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fai_lembur`
--

INSERT INTO `fai_lembur` (`id_lembur`, `id_akun`, `tgl_lembur`, `mulai_lembur`, `selesai_lembur`, `point_lembur`, `status_lembur`, `keterangan`, `tgl_add`, `tgl_update`) VALUES
('6ca7c0f16fd34829fb5177b3bb127639', '4bc0c527a7c2a9053450a7fb8f92746f', '2023-07-03', '00:00', '05:00', '0.50', 1, 'Kerja Lembur', '2023-07-03 11:54:38', NULL),
('6d0d942ca768707679ce0cff5fa9c8d8', '4bc0c527a7c2a9053450a7fb8f92123', '2023-11-16', '00:01', '04:01', '0.91', 1, 'Kerja Lembur', '2023-11-15 13:52:40', '2023-11-16 08:45:16'),
('95baa136783469bc91f9e1aaa5ddf433', '4bc0c527a7c2a9053450a7fb8f92746f', '2023-07-31', '00:00', '07:00', '4.00', 1, 'Kerja Lembur', '2023-07-31 13:59:49', NULL),
('c6ec668cbf95c36da984d5a5ff3ffea1', '4bc0c527a7c2a9053450a7fb8f92746f', '2023-06-13', '17:00', '19:00', '1.50', 1, 'tes', '2023-06-13 16:16:22', '2023-06-14 11:02:54');

-- --------------------------------------------------------

--
-- Table structure for table `fai_libur`
--

CREATE TABLE `fai_libur` (
  `id_libur` varchar(255) NOT NULL,
  `tgl_libur` date NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `tgl_add` datetime NOT NULL DEFAULT current_timestamp(),
  `tgl_update` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fai_libur`
--

INSERT INTO `fai_libur` (`id_libur`, `tgl_libur`, `keterangan`, `tgl_add`, `tgl_update`) VALUES
('79beead82620fffa5cab09b118a4f5bd', '2023-06-17', 'tes libur', '2023-06-06 14:04:19', '2023-06-06 14:19:35');

-- --------------------------------------------------------

--
-- Table structure for table `fai_log`
--

CREATE TABLE `fai_log` (
  `id_log` varchar(255) NOT NULL,
  `data_log` text NOT NULL,
  `tgl_add` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fai_log`
--

INSERT INTO `fai_log` (`id_log`, `data_log`, `tgl_add`) VALUES
('005d6a0e76e0e97acb75ec96c95e3cb1', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"28-07-2023 13:40:31\"}', '2023-07-28 13:40:31'),
('03b35992d5b47669f50347c26d40bd19', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Absen\",\"function\":\"pulang\",\"table\":\"fai_absen\",\"txt\":\"simpan data pulang - \",\"waktu\":\"28-06-2023 11:07:09\"}', '2023-06-28 11:07:09'),
('05737b691ce36396e0fc6bafee9f8226', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Absen\",\"function\":\"masuk\",\"table\":\"fai_absen\",\"txt\":\"simpan data masuk - []\",\"waktu\":\"19-06-2023 11:35:23\"}', '2023-06-19 11:35:23'),
('096b7255e504d7b67c047aecfecc8d84', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Absen\",\"function\":\"simpan tertunda\",\"table\":\"fai_absen || fai_akun\",\"txt\":\"simpan data pending - {\\\"id_absen\\\":\\\"f7ea812bbf8e69a2cd6289a36a080cd9\\\",\\\"id_user\\\":\\\"4bc0c527a7c2a9053450a7fb8f92746f\\\",\\\"tgl_absen\\\":\\\"2023-06-20\\\",\\\"absen_masuk\\\":\\\"07:59\\\",\\\"absen_pulang\\\":\\\"\\\",\\\"pending\\\":\\\"1\\\",\\\"catatan_pending\\\":\\\"libur\\\"}\",\"waktu\":\"19-06-2023 11:59:28\"}', '2023-06-19 11:59:28'),
('0c0bc9a4150772cb7aad55e53eba5058', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Absen\",\"function\":\"pulang\",\"table\":\"\",\"txt\":\"Diluar jam absen pulang\",\"waktu\":\"19-06-2023 11:35:18\"}', '2023-06-19 11:35:18'),
('0d72d5b254cd02f74859bc9e7c76ffda', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"11-08-2023 08:38:11\"}', '2023-08-11 08:38:11'),
('0ed9535bb83b74f5f8b01c141b96ff9f', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"05-08-2023 09:52:50\"}', '2023-08-05 09:52:50'),
('1066e9924719c12126b4d4b8390a7fb6', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"31-07-2023 13:44:15\"}', '2023-07-31 13:44:15'),
('10cd9096de662af2a1229da880f4e226', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"22-08-2023 13:32:26\"}', '2023-08-22 13:32:26'),
('10faa64089ff16a1cbc278e372bd2b0f', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"16-06-2023 08:30:41\"}', '2023-06-16 08:30:41'),
('1243e64b56588018b3d25c02b037abe7', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"03-07-2023 08:18:32\"}', '2023-07-03 08:18:32'),
('12a055db5060e9cb4854628cb1870f43', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Absen\",\"function\":\"masuk\",\"table\":\"fai_absen\",\"txt\":\"simpan data masuk - []\",\"waktu\":\"19-06-2023 11:35:11\"}', '2023-06-19 11:35:11'),
('14a3576bb8c197ed0e8adb645045a6a6', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"09-08-2023 08:12:37\"}', '2023-08-09 08:12:37'),
('1553ee48f4e2fbff13ae744c3c5e63fc', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Absen\",\"function\":\"masuk\",\"table\":\"fai_absen\",\"txt\":\"simpan data masuk - null\",\"waktu\":\"19-06-2023 11:30:43\"}', '2023-06-19 11:30:43'),
('16add41b138ec45e8986d388c66b7cb1', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Absen\",\"function\":\"masuk\",\"table\":\"fai_absen\",\"txt\":\"simpan data masuk - []\",\"waktu\":\"19-06-2023 11:36:14\"}', '2023-06-19 11:36:14'),
('174521f435230332a51364da031c5929', '{\"id_user\":\"muhammad.alfan2000@gmail.com\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"gagal login\",\"waktu\":\"31-07-2023 16:50:14\"}', '2023-07-31 16:50:14'),
('174d2a4fe61d9c2c7aee6a19047ee415', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"14-10-2023 08:45:59\"}', '2023-10-14 08:45:59'),
('180cd750c8875f35a1c73341ada4676c', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Akun\",\"function\":\"simpan\",\"table\":\"fai_akun\",\"txt\":\"update data user\",\"waktu\":\"27-06-2023 09:17:36\"}', '2023-06-27 09:17:36'),
('185526c2f1c19c8c12962e5e22fb5122', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"22-08-2023 11:15:07\"}', '2023-08-22 11:15:07'),
('19bd159a45c0779c00d9947159b5c03b', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"15-08-2023 13:44:41\"}', '2023-08-15 13:44:41'),
('1a727be5b2b6d8a1da09e3e472321199', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"29-07-2023 08:53:38\"}', '2023-07-29 08:53:38'),
('1cc322c58e4020137a84d6a2ecacdd83', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"19-10-2023 08:06:48\"}', '2023-10-19 08:06:48'),
('1e0e34bbab358d365fbe9a1a8dcdcb3b', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"22-08-2023 08:19:13\"}', '2023-08-22 08:19:13'),
('1e47b3cbf7a86b5f605c7e9d3a620fdb', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Absen\",\"function\":\"masuk\",\"table\":\"fai_absen\",\"txt\":\"simpan data masuk - null\",\"waktu\":\"19-06-2023 11:32:08\"}', '2023-06-19 11:32:08'),
('214d9549f45f5d3a49857295d20febdc', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Absen\",\"function\":\"simpan tertunda\",\"table\":\"fai_absen || fai_akun\",\"txt\":\"simpan data pending - {\\\"id_absen\\\":\\\"a468a7950e74a64ae26a4dc85b652bc4\\\",\\\"id_user\\\":\\\"4bc0c527a7c2a9053450a7fb8f92746f\\\",\\\"tgl_absen\\\":\\\"2023-06-20\\\",\\\"absen_masuk\\\":\\\"\\\",\\\"absen_pulang\\\":\\\"\\\",\\\"pending\\\":\\\"10\\\",\\\"catatan_pending\\\":\\\"libur\\\"}\",\"waktu\":\"19-06-2023 12:00:14\"}', '2023-06-19 12:00:14'),
('26b79b9c5fa4c0ab2c9a0ec50803b16e', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"23-08-2023 08:20:56\"}', '2023-08-23 08:20:56'),
('2732bafffed151728aab01c14b398255', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"23-11-2023 08:14:05\"}', '2023-11-23 08:14:05'),
('27e2b841addeab345877fdb0a2e51e71', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"15-12-2023 09:11:08\"}', '2023-12-15 09:11:08'),
('28b5914f69755ad9d222553f2c0f4d1d', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Absen\",\"function\":\"masuk\",\"table\":\"fai_absen\",\"txt\":\"simpan data masuk - null\",\"waktu\":\"19-06-2023 11:28:37\"}', '2023-06-19 11:28:37'),
('28f0c5eadbbf9ca586561eafef556578', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Akun\",\"function\":\"simpan\",\"table\":\"fai_akun\",\"txt\":\"update data user\",\"waktu\":\"27-06-2023 09:14:08\"}', '2023-06-27 09:14:08'),
('28f5954965a492468e943601310a3006', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"10-08-2023 08:56:37\"}', '2023-08-10 08:56:37'),
('2b739fd12043f506dbc99aa2c8e99074', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"15-11-2023 13:39:32\"}', '2023-11-15 13:39:32'),
('2e3dcccd62adefed6ad37965ae2cda72', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"19-12-2023 08:16:57\"}', '2023-12-19 08:16:57'),
('3200354d6b2606fcd03c8aee01210ab4', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"24-10-2023 11:13:32\"}', '2023-10-24 11:13:32'),
('32502af7123f537f3df29067214b033a', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Absen\",\"function\":\"pulang\",\"table\":\"fai_absen\",\"txt\":\"simpan data pulang - \",\"waktu\":\"28-06-2023 10:52:14\"}', '2023-06-28 10:52:14'),
('355885426d98142bc52b75b23cd45630', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"31-07-2023 16:49:36\"}', '2023-07-31 16:49:36'),
('3a9e41603626c4d4a2654ee1f1a37307', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92123\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"21-10-2023 09:39:07\"}', '2023-10-21 09:39:07'),
('3bb49818968ead3c11d6d0af56690fb6', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"16-12-2023 08:22:23\"}', '2023-12-16 08:22:23'),
('3e0d65e92cb4b65a812659682debc55c', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"15-06-2023 13:55:51\"}', '2023-06-15 13:55:51'),
('3e97059a27390bd3ae2dc9e5f565da24', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"06-11-2023 11:49:27\"}', '2023-11-06 11:49:27'),
('3f602a38578c5ac5dcce11048ab856e7', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Absen\",\"function\":\"pulang\",\"table\":\"fai_absen\",\"txt\":\"simpan data pulang - \",\"waktu\":\"28-06-2023 11:06:16\"}', '2023-06-28 11:06:16'),
('4095b399e698a8d7d84fe7e64fdfae4f', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"15-06-2023 14:09:12\"}', '2023-06-15 14:09:12'),
('40adabf8a5aaea33f71b4c7dba008e8b', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"20-10-2023 08:28:41\"}', '2023-10-20 08:28:41'),
('4227602463d7241eae185630a5a262f8', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"keluar\",\"table\":\"\",\"txt\":\"logout\",\"waktu\":\"31-07-2023 16:49:34\"}', '2023-07-31 16:49:34'),
('42a4b66920d6d97bac7fcb45cbd63da3', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"24-11-2023 08:16:12\"}', '2023-11-24 08:16:12'),
('42dacbf5fdbb359adad38332fd0ea0ea', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Absen\",\"function\":\"masuk\",\"table\":\"fai_absen\",\"txt\":\"simpan data masuk - null\",\"waktu\":\"19-06-2023 11:25:53\"}', '2023-06-19 11:25:53'),
('42f2c0f78a2cd97c1f777dc02a9e1cff', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Absen\",\"function\":\"masuk\",\"table\":\"fai_absen\",\"txt\":\"simpan data masuk - null\",\"waktu\":\"19-06-2023 11:33:53\"}', '2023-06-19 11:33:53'),
('462146d97f23a132aabbfeb768e44802', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"23-08-2023 16:15:55\"}', '2023-08-23 16:15:55'),
('464e6f784533be9ec3a80b99a5dbf9db', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"04-11-2023 08:17:36\"}', '2023-11-04 08:17:36'),
('48a6a8d98894a8da9a80188f14474101', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"02-11-2023 14:05:51\"}', '2023-11-02 14:05:51'),
('4a1ef2632d08ffedc4e57df5a2e17d2e', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Lembur\",\"function\":\"simpan_lembur\",\"table\":\"fai_lembur\",\"txt\":\"simpan data lembur - {\\\"id_lembur\\\":\\\"f0c5f0d25a07452191c03aeba0fd7339\\\",\\\"id_akun\\\":\\\"4bc0c527a7c2a9053450a7fb8f92746f\\\",\\\"tgl_lembur\\\":\\\"2023-06-17\\\",\\\"mulai_lembur\\\":\\\"15:00\\\",\\\"selesai_lembur\\\":\\\"18:00\\\",\\\"point_lembur\\\":0,\\\"status_lembur\\\":0,\\\"keterangan\\\":\\\"tes2\\\"}\",\"waktu\":\"14-06-2023 15:55:16\"}', '2023-06-14 15:55:16'),
('4aa91ad29cd0427d6cebb0de55d8cb7e', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"13-06-2023 13:43:24\"}', '2023-06-13 13:43:24'),
('4e8d331a5fedca123927215a35b15edf', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Absen\",\"function\":\"simpan tertunda\",\"table\":\"fai_absen || fai_akun\",\"txt\":\"simpan data pending - {\\\"id_absen\\\":\\\"d063d98163a5edf9523a86eb8e632e67\\\",\\\"id_user\\\":\\\"4bc0c527a7c2a9053450a7fb8f92746f\\\",\\\"tgl_absen\\\":\\\"2023-06-04\\\",\\\"absen_masuk\\\":\\\"\\\",\\\"absen_pulang\\\":\\\"\\\",\\\"pending\\\":\\\"10\\\",\\\"catatan_pending\\\":\\\"lbr\\\"}\",\"waktu\":\"19-06-2023 14:07:28\"}', '2023-06-19 14:07:28'),
('4f9984863e3d3212c526f0081d889917', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"keluar\",\"table\":\"\",\"txt\":\"logout\",\"waktu\":\"21-08-2023 14:55:40\"}', '2023-08-21 14:55:40'),
('50bb6fda27686cedeb6ba074ea3e119f', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"10-08-2023 15:48:49\"}', '2023-08-10 15:48:49'),
('5220cd84df2186eec7ee1993533fa67e', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Absen\",\"function\":\"masuk\",\"table\":\"fai_absen\",\"txt\":\"simpan data masuk - null\",\"waktu\":\"19-06-2023 11:32:46\"}', '2023-06-19 11:32:46'),
('5336947c8c14ee6e8006d377082950c9', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"20-10-2023 13:51:53\"}', '2023-10-20 13:51:53'),
('54f179816204a916cbc18cbbda0af944', '{\"id_user\":\"muhammad.alfan2000@gmail.com\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"gagal login\",\"waktu\":\"31-07-2023 16:48:52\"}', '2023-07-31 16:48:52'),
('56d580dce585c88aaaee0c9cca6c095a', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Absen\",\"function\":\"pulang\",\"table\":\"\",\"txt\":\"Diluar jam absen pulang\",\"waktu\":\"19-06-2023 11:36:35\"}', '2023-06-19 11:36:35'),
('56fbdfdef5e06868fa032289bc69ded1', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"21-08-2023 14:40:56\"}', '2023-08-21 14:40:56'),
('57be05645b5115c0e85569b2e221215b', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"11-08-2023 08:47:53\"}', '2023-08-11 08:47:53'),
('57ee286c538d8f8387971f72566fd9c6', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"20-12-2023 16:09:42\"}', '2023-12-20 16:09:42'),
('5a859493883ea6260d85f0e3404ce018', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"21-11-2023 08:21:47\"}', '2023-11-21 08:21:47'),
('62926e8c3aa8a4fa8ef56a4b478cc028', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Absen\",\"function\":\"masuk\",\"table\":\"fai_absen\",\"txt\":\"simpan data masuk - []\",\"waktu\":\"19-06-2023 11:35:20\"}', '2023-06-19 11:35:20'),
('62f301223a693edd0793d231bf1fb7b1', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Absen\",\"function\":\"masuk\",\"table\":\"fai_absen\",\"txt\":\"simpan data masuk - null\",\"waktu\":\"19-06-2023 11:24:16\"}', '2023-06-19 11:24:16'),
('64daab8ce6b2e376eb021bb9adc92eae', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"28-06-2023 10:01:17\"}', '2023-06-28 10:01:17'),
('660ea1f47130c9b648fa24dcbb42dfc9', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"19-06-2023 11:24:12\"}', '2023-06-19 11:24:12'),
('6a0e6161b11e156783795e5b357b04b5', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Absen\",\"function\":\"simpan tertunda\",\"table\":\"fai_absen || fai_akun\",\"txt\":\"simpan data pending - {\\\"id_absen\\\":\\\"f91480543f0dc38483a14e4134a1a67e\\\",\\\"id_user\\\":\\\"4bc0c527a7c2a9053450a7fb8f92746f\\\",\\\"tgl_absen\\\":\\\"2023-06-25\\\",\\\"absen_masuk\\\":\\\"\\\",\\\"absen_pulang\\\":\\\"\\\",\\\"pending\\\":\\\"10\\\",\\\"catatan_pending\\\":\\\"lbr\\\"}\",\"waktu\":\"19-06-2023 14:08:09\"}', '2023-06-19 14:08:09'),
('6abb7913dfd13af9e833035b5f64e478', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"26-10-2023 11:06:26\"}', '2023-10-26 11:06:26'),
('6b95ea46dd5355cf0e12f9dcda82011e', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Absen\",\"function\":\"simpan tertunda\",\"table\":\"fai_absen || fai_akun\",\"txt\":\"simpan data pending - {\\\"id_absen\\\":\\\"518adfa3068e25360f98c98a2a768a84\\\",\\\"id_user\\\":\\\"4bc0c527a7c2a9053450a7fb8f92746f\\\",\\\"tgl_absen\\\":\\\"2023-06-17\\\",\\\"absen_masuk\\\":\\\"\\\",\\\"absen_pulang\\\":\\\"\\\",\\\"pending\\\":\\\"10\\\",\\\"catatan_pending\\\":\\\"lbr\\\"}\",\"waktu\":\"19-06-2023 14:08:02\"}', '2023-06-19 14:08:02'),
('6dba19450e89cc03f47281899ab0ad60', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"09-11-2023 08:20:32\"}', '2023-11-09 08:20:32'),
('6f94523fa467fb62709318d2a8ea5296', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92123\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"21-10-2023 09:31:18\"}', '2023-10-21 09:31:18'),
('6fce9d5c60b3009c2d25ee47cc76aced', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Absen\",\"function\":\"pulang\",\"table\":\"\",\"txt\":\"Diluar jam absen pulang\",\"waktu\":\"19-06-2023 11:27:33\"}', '2023-06-19 11:27:33'),
('73e85afa4b9b55607538857a7e5ce34b', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"15-12-2023 13:50:50\"}', '2023-12-15 13:50:50'),
('767038dc558ba826309fbcdd3dc5deb8', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"13-06-2023 08:25:03\"}', '2023-06-13 08:25:03'),
('78574e0ae775a3dcb0b1b6d6ca83b993', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"09-08-2023 08:12:42\"}', '2023-08-09 08:12:42'),
('78fb3f4b9c83c3567071e3b1ff96a76f', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Absen\",\"function\":\"pulang\",\"table\":\"fai_absen\",\"txt\":\"simpan data pulang - \",\"waktu\":\"28-06-2023 10:53:27\"}', '2023-06-28 10:53:27'),
('795765f1bdea16a35e04cef28ef0229c', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Akun\",\"function\":\"simpan\",\"table\":\"fai_akun\",\"txt\":\"update data user\",\"waktu\":\"27-06-2023 09:13:33\"}', '2023-06-27 09:13:33'),
('7b96b7b3812c5f380efb20d0b07c86f5', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Absen\",\"function\":\"simpan tertunda\",\"table\":\"fai_absen || fai_akun\",\"txt\":\"simpan data pending - null\",\"waktu\":\"12-06-2023 10:09:02\"}', '2023-06-12 10:09:02'),
('7c9b73459d6ae26a0a3a614c6c52c342', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"31-07-2023 16:49:21\"}', '2023-07-31 16:49:21'),
('7cf068235ff401b5a3f6de6e393036c2', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"15-08-2023 08:22:08\"}', '2023-08-15 08:22:08'),
('7fdb075ba599cfb90d68584f76705da6', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"18-10-2023 10:57:13\"}', '2023-10-18 10:57:13'),
('806d451df1e620f6cc292d2ec7364db1', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"18-10-2023 08:23:47\"}', '2023-10-18 08:23:47'),
('80da539f082bda69644f5ba91bad3489', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"07-11-2023 13:21:33\"}', '2023-11-07 13:21:33'),
('81811b99fab09d177af2c580651dd5da', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"03-08-2023 14:41:35\"}', '2023-08-03 14:41:35'),
('81ca1adf3c6f0f7107d496ec6a2f4ce7', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"21-10-2023 08:09:26\"}', '2023-10-21 08:09:26'),
('822626888ee3f394ad57b540b202c8e7', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"04-08-2023 08:20:41\"}', '2023-08-04 08:20:41'),
('82b83318b057036413de083ed5cf3fef', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"22-06-2023 13:56:44\"}', '2023-06-22 13:56:44'),
('82d41d3f63299a243e1437d2f0d13b21', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"17-11-2023 08:43:04\"}', '2023-11-17 08:43:04'),
('83971be1e9aa81b243c751e9fa68aed9', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"31-07-2023 13:26:54\"}', '2023-07-31 13:26:54'),
('84def16ef5d4c77a2fcf3a6f3be6374b', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Absen\",\"function\":\"masuk\",\"table\":\"fai_absen\",\"txt\":\"simpan data masuk - {\\\"id_absen\\\":\\\"70b991cec2d6209389e54c6639591c03\\\",\\\"id_user\\\":\\\"4bc0c527a7c2a9053450a7fb8f92746f\\\",\\\"tgl_absen\\\":\\\"2023-06-28\\\",\\\"absen_masuk\\\":\\\"11:07\\\",\\\"absen_pulang\\\":\\\"\\\",\\\"pending\\\":0,\\\"catatan_pending\\\":\\\"\\\"}\",\"waktu\":\"28-06-2023 11:07:03\"}', '2023-06-28 11:07:03'),
('85e522c07d0d9209a826056211ad5a8d', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"20-11-2023 13:36:15\"}', '2023-11-20 13:36:15'),
('86554f44a2a1ffd76029c105b3db5bee', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Absen\",\"function\":\"masuk\",\"table\":\"fai_absen\",\"txt\":\"simpan data masuk - null\",\"waktu\":\"19-06-2023 11:27:31\"}', '2023-06-19 11:27:31'),
('865a171fb18fff2fab2a6947cf1a48ca', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Absen\",\"function\":\"simpan tertunda\",\"table\":\"fai_absen || fai_akun\",\"txt\":\"simpan data pending - {\\\"id_absen\\\":\\\"e1c7f21a20621961e88f2210bfdedb70\\\",\\\"id_user\\\":\\\"4bc0c527a7c2a9053450a7fb8f92746f\\\",\\\"tgl_absen\\\":\\\"2023-06-19\\\",\\\"absen_masuk\\\":\\\"\\\",\\\"absen_pulang\\\":\\\"\\\",\\\"pending\\\":\\\"10\\\",\\\"catatan_pending\\\":\\\"libur\\\"}\",\"waktu\":\"19-06-2023 09:46:58\"}', '2023-06-19 09:46:58'),
('8a628d7e3b2c3bcacae2f4a29a9b2609', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"keluar\",\"table\":\"\",\"txt\":\"logout\",\"waktu\":\"31-07-2023 16:49:38\"}', '2023-07-31 16:49:38'),
('8bd55323397016239d8af8bf69b8f487', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Absen\",\"function\":\"masuk\",\"table\":\"fai_absen\",\"txt\":\"simpan data masuk - null\",\"waktu\":\"19-06-2023 11:28:17\"}', '2023-06-19 11:28:17'),
('8c83ef10f0d1dc3d4e695deb2b5b5818', '{\"id_user\":null,\"page\":\"Login\",\"function\":\"keluar\",\"table\":\"\",\"txt\":\"logout\",\"waktu\":\"31-07-2023 16:43:38\"}', '2023-07-31 16:43:38'),
('8d32f3613bf243c9d37c13692755e69e', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"22-11-2023 08:09:11\"}', '2023-11-22 08:09:11'),
('8e9be0a1093601a9803f95e25b279976', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"27-11-2023 08:14:30\"}', '2023-11-27 08:14:30'),
('8edc5fd7470edf1dc2e8f64785679017', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"14-06-2023 08:35:59\"}', '2023-06-14 08:35:59'),
('90f6a121cb55e3570852ea5b9a45bf83', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"13-10-2023 08:18:52\"}', '2023-10-13 08:18:52'),
('92290b220561f115a186dedd92ce1722', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"16-10-2023 08:21:41\"}', '2023-10-16 08:21:41'),
('92896aa0f3b12698978f16d0a76d020d', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"20-12-2023 13:14:43\"}', '2023-12-20 13:14:43'),
('92e3e766fad1d04c8b022bac44e215cc', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Absen\",\"function\":\"masuk\",\"table\":\"fai_absen\",\"txt\":\"simpan data masuk - null\",\"waktu\":\"19-06-2023 11:25:58\"}', '2023-06-19 11:25:58'),
('966f75f88e647be54ad38d85d10141cf', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"08-08-2023 16:24:56\"}', '2023-08-08 16:24:56'),
('98dd25ff6e87f0438b72f7e7a80cee8d', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"27-06-2023 09:09:33\"}', '2023-06-27 09:09:33'),
('9b1b31486ff62fad3cd558b24c557890', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"19-10-2023 14:02:01\"}', '2023-10-19 14:02:01'),
('9efe5f836ad04b2c778d14f57746ce06', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Akun\",\"function\":\"simpan\",\"table\":\"fai_akun\",\"txt\":\"update data user\",\"waktu\":\"27-06-2023 09:17:16\"}', '2023-06-27 09:17:16'),
('a039dbb340801636a6bbac607b5048b7', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Absen\",\"function\":\"masuk\",\"table\":\"fai_absen\",\"txt\":\"simpan data masuk - null\",\"waktu\":\"19-06-2023 11:28:13\"}', '2023-06-19 11:28:13'),
('a09cc4b30769ee40cd6952e6ba258697', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"08-08-2023 10:46:42\"}', '2023-08-08 10:46:42'),
('a1408dad91f01a2206214cc4890c09d6', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"10-11-2023 08:12:04\"}', '2023-11-10 08:12:04'),
('a1c4635619b6c3597aa0d6b6bce63ec6', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"11-08-2023 13:50:04\"}', '2023-08-11 13:50:04'),
('a1eb2360e42289f0fe9a367791bda688', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"keluar\",\"table\":\"\",\"txt\":\"logout\",\"waktu\":\"15-06-2023 13:55:50\"}', '2023-06-15 13:55:50'),
('a3610d76ab54c871b3d02cd3f9688d07', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"21-08-2023 14:58:39\"}', '2023-08-21 14:58:39'),
('a36cce1580a592b06cf2a8d16261fb13', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"16-11-2023 14:24:57\"}', '2023-11-16 14:24:57'),
('a450bda884c05a7f8aefb8b06f74d21b', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"02-08-2023 10:06:46\"}', '2023-08-02 10:06:46'),
('a4af34d0191fed0d933aa5c9c2592852', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"07-11-2023 08:09:32\"}', '2023-11-07 08:09:32'),
('a4b5f145c1e1b2889f22da5d6ece0eff', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"28-06-2023 09:57:03\"}', '2023-06-28 09:57:03'),
('a4ee1630fb8557240d147a90455d0517', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Absen\",\"function\":\"simpan tertunda\",\"table\":\"fai_absen || fai_akun\",\"txt\":\"simpan data pending - null\",\"waktu\":\"12-06-2023 10:09:11\"}', '2023-06-12 10:09:11'),
('a7e6aceddea258fc9ae5f5075580c464', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"06-11-2023 08:19:03\"}', '2023-11-06 08:19:03'),
('a8e99246dd9f01186987e434455055d8', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"23-11-2023 08:14:00\"}', '2023-11-23 08:14:00'),
('a976acb09337d2463681924b86be7600', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"21-06-2023 13:22:49\"}', '2023-06-21 13:22:49'),
('abecb6705274fe092fabf5bd538607c8', '{\"id_user\":\"muhammad.alfan2000@gmail.com\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"gagal login\",\"waktu\":\"31-07-2023 16:50:28\"}', '2023-07-31 16:50:28'),
('adb6d5dc4117bdb118bde7ac99d4b84f', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Absen\",\"function\":\"masuk\",\"table\":\"fai_absen\",\"txt\":\"simpan data masuk - {\\\"id_absen\\\":\\\"2e2f3c84ae0f46f46be0fe309c631eea\\\",\\\"id_user\\\":\\\"4bc0c527a7c2a9053450a7fb8f92746f\\\",\\\"tgl_absen\\\":\\\"2023-06-19\\\",\\\"absen_masuk\\\":\\\"11:36\\\",\\\"absen_pulang\\\":\\\"\\\",\\\"pending\\\":0,\\\"catatan_pending\\\":\\\"\\\"}\",\"waktu\":\"19-06-2023 11:36:22\"}', '2023-06-19 11:36:22'),
('adf2478efeddeab8a80de008a2fddba8', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"31-07-2023 08:13:34\"}', '2023-07-31 08:13:34'),
('ae0dd848d7acbf7a799cdeb80d210bf5', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"20-06-2023 08:14:13\"}', '2023-06-20 08:14:13'),
('af0522c06a863f03d52ade0e53f9f4c9', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"17-10-2023 08:10:34\"}', '2023-10-17 08:10:34'),
('afb3ae3ba363d2992746424598f4ec9b', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"keluar\",\"table\":\"\",\"txt\":\"logout\",\"waktu\":\"15-06-2023 14:09:11\"}', '2023-06-15 14:09:11'),
('b096ea4d42955e9ed0244d9dcd736d83', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"19-06-2023 09:34:19\"}', '2023-06-19 09:34:19'),
('b09bc162cafcec2c12aba196a1569a82', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Absen\",\"function\":\"masuk\",\"table\":\"fai_absen\",\"txt\":\"simpan data masuk - []\",\"waktu\":\"19-06-2023 14:00:08\"}', '2023-06-19 14:00:08'),
('b240c7dc520c9b3ed2f620d9d49d7c69', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"03-11-2023 08:31:34\"}', '2023-11-03 08:31:34'),
('b36b04f32871a533c24578af26817956', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"keluar\",\"table\":\"\",\"txt\":\"logout\",\"waktu\":\"16-06-2023 15:05:05\"}', '2023-06-16 15:05:05'),
('b56772f4ce08fd1f5c3252216c1e621b', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Absen\",\"function\":\"masuk\",\"table\":\"fai_absen\",\"txt\":\"simpan data masuk - []\",\"waktu\":\"19-06-2023 11:35:46\"}', '2023-06-19 11:35:46'),
('b6642707460601ffd9b846afb3514aa9', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"19-06-2023 14:00:04\"}', '2023-06-19 14:00:04'),
('b9e5c0b45801f0c5cc7dba0159d5a56e', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"27-11-2023 14:34:58\"}', '2023-11-27 14:34:58'),
('ba7fef3267f660c11dfc8c0f909af944', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"05-08-2023 09:52:55\"}', '2023-08-05 09:52:55'),
('bcb2ca9be0c3ec267c48fcd88ca1c809', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Akun\",\"function\":\"simpan\",\"table\":\"fai_akun\",\"txt\":\"update data user\",\"waktu\":\"27-06-2023 09:16:28\"}', '2023-06-27 09:16:28'),
('bcf30e82b4d64b3f1874e835f107f98c', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"19-08-2023 08:11:03\"}', '2023-08-19 08:11:03'),
('bf66b780ce8124d7b7736c87cd762954', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"01-08-2023 08:31:47\"}', '2023-08-01 08:31:47'),
('c19c2a725432fdd6039ab055f3ee450b', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Absen\",\"function\":\"masuk\",\"table\":\"fai_absen\",\"txt\":\"simpan data masuk - null\",\"waktu\":\"19-06-2023 11:33:09\"}', '2023-06-19 11:33:09'),
('c286ba02e2769bad1c2282e3a44684b2', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Akun\",\"function\":\"simpan\",\"table\":\"fai_akun\",\"txt\":\"update data user\",\"waktu\":\"27-06-2023 09:09:49\"}', '2023-06-27 09:09:49'),
('c39fb50c73319930be39f845b940c56c', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Absen\",\"function\":\"masuk\",\"table\":\"fai_absen\",\"txt\":\"simpan data masuk - null\",\"waktu\":\"19-06-2023 11:29:35\"}', '2023-06-19 11:29:35'),
('c3b73b6eaa624a45bc26b895c730167c', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"11-11-2023 08:23:44\"}', '2023-11-11 08:23:44'),
('c538e75dfca8b04af844ff958aa181bc', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"03-11-2023 13:28:49\"}', '2023-11-03 13:28:49'),
('c8f49329abb19da6263735ad11a1febe', '{\"id_user\":\"\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"gagal login\",\"waktu\":\"17-07-2023 11:23:58\"}', '2023-07-17 11:23:58'),
('c93fe1a87e94a9b825567af28d3e7c69', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"12-08-2023 09:09:04\"}', '2023-08-12 09:09:04'),
('c96fa7e7882d2fc3174e47fd48f3b041', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"22-11-2023 16:02:43\"}', '2023-11-22 16:02:43'),
('cb765faa2c0f954fbfc640b9d48f35d7', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"04-08-2023 08:20:37\"}', '2023-08-04 08:20:37'),
('cdc3161ac8ffb7cb78f1c47d95340536', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"16-06-2023 15:05:07\"}', '2023-06-16 15:05:07'),
('cfb927f9a52ee6f3302bb54db02c1da0', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"08-11-2023 08:13:37\"}', '2023-11-08 08:13:37'),
('d09521fe8e2beede95796f52d532d206', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"09-08-2023 13:29:15\"}', '2023-08-09 13:29:15'),
('d0b516bf5938365255b7db2e5420604d', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Absen\",\"function\":\"masuk\",\"table\":\"fai_absen\",\"txt\":\"simpan data masuk - {\\\"id_absen\\\":\\\"fb6c18e11f47596192b61607e2211a3f\\\",\\\"id_user\\\":\\\"4bc0c527a7c2a9053450a7fb8f92746f\\\",\\\"tgl_absen\\\":\\\"2023-06-19\\\",\\\"absen_masuk\\\":\\\"14:00\\\",\\\"absen_pulang\\\":\\\"\\\",\\\"pending\\\":0,\\\"catatan_pending\\\":\\\"\\\"}\",\"waktu\":\"19-06-2023 14:00:06\"}', '2023-06-19 14:00:06'),
('d10ab7409576e220367894a55d02e4c0', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"13-10-2023 13:20:00\"}', '2023-10-13 13:20:00'),
('d1d442c2d08e3e5d117c280a9ca68d3e', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"keluar\",\"table\":\"\",\"txt\":\"logout\",\"waktu\":\"15-06-2023 13:50:42\"}', '2023-06-15 13:50:42'),
('d34229d6aba4c4e41cb6a4193a6408c7', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"08-08-2023 08:09:37\"}', '2023-08-08 08:09:37'),
('d367f500c47038154f562c6b37ac3ebf', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"20-11-2023 08:38:03\"}', '2023-11-20 08:38:03'),
('d427f8a044f35c05298c27a6ad99b42a', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Absen\",\"function\":\"simpan tertunda\",\"table\":\"fai_absen || fai_akun\",\"txt\":\"simpan data pending - null\",\"waktu\":\"19-06-2023 11:59:49\"}', '2023-06-19 11:59:49'),
('d546df6be4cc82bde5dcb17a46e0ec53', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Riwayat\",\"function\":\"data_rilis\",\"table\":\"fai_absen\",\"txt\":\"getdata riwayat dari range tanggal\",\"waktu\":\"12-06-2023 10:08:54\"}', '2023-06-12 10:08:54'),
('d6c1c7230fc9e47f98155a4b829823e9', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"09-11-2023 08:15:37\"}', '2023-11-09 08:15:37'),
('d70dbc89bbd4b7d2f2860a6e49e9123c', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Akun\",\"function\":\"simpan\",\"table\":\"fai_akun\",\"txt\":\"update data user\",\"waktu\":\"27-06-2023 09:16:21\"}', '2023-06-27 09:16:21'),
('d76af5bb7f6a928b6445e20a749a2f67', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"11-11-2023 08:23:42\"}', '2023-11-11 08:23:42'),
('d7ce371227652957ad52ea7a27384c88', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"16-10-2023 14:17:03\"}', '2023-10-16 14:17:03'),
('da03ae966d26e374320d092fc82557f5', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"keluar\",\"table\":\"\",\"txt\":\"logout\",\"waktu\":\"22-11-2023 16:02:41\"}', '2023-11-22 16:02:41'),
('da04f700d666e04b14744a15cb48fba0', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"16-08-2023 08:24:15\"}', '2023-08-16 08:24:15'),
('dc05a8fae3b66bdd2b5a4d18beb5951e', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"20-12-2023 08:03:58\"}', '2023-12-20 08:03:58'),
('dc972065a92741c645e4ae29a0d25f60', '{\"id_user\":\"muhammad.alfan2000@gmail.com\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"gagal login\",\"waktu\":\"31-07-2023 16:49:41\"}', '2023-07-31 16:49:41'),
('dd85d38a8af8d02e761c81270bf591f4', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"27-10-2023 08:16:56\"}', '2023-10-27 08:16:56'),
('de3c758344ba3a57377857e792c321e5', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Absen\",\"function\":\"masuk\",\"table\":\"fai_absen\",\"txt\":\"simpan data masuk - null\",\"waktu\":\"19-06-2023 11:30:02\"}', '2023-06-19 11:30:02'),
('deffa8a5775bbd69f7ba9a4bde7d2347', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Absen\",\"function\":\"pulang\",\"table\":\"fai_absen\",\"txt\":\"simpan data pulang - \",\"waktu\":\"28-06-2023 11:06:20\"}', '2023-06-28 11:06:20'),
('e06afe2518784c4a31775bcc2400eeb0', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"10-11-2023 14:14:46\"}', '2023-11-10 14:14:46'),
('e2d0e0745f1f71b5548707060f2bb687', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"15-08-2023 08:22:11\"}', '2023-08-15 08:22:11'),
('e4a238f9ac81169bf8684cde1386a96c', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"21-08-2023 08:05:57\"}', '2023-08-21 08:05:57'),
('e5dd247e243515a55d1e11e9d58fb9a6', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"06-11-2023 08:07:44\"}', '2023-11-06 08:07:44'),
('e85f4d47b9f1b39c3b8cc0f3f7fa48b8', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"03-08-2023 09:38:27\"}', '2023-08-03 09:38:27'),
('e99859bcf793be9adeb86630d53b73b8', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"13-11-2023 08:11:47\"}', '2023-11-13 08:11:47'),
('ec394e688100bf41a5dfac275473782c', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"10-08-2023 09:52:16\"}', '2023-08-10 09:52:16'),
('ecb3d3aa6341d84ead5a3b49cf8e4973', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"keluar\",\"table\":\"\",\"txt\":\"logout\",\"waktu\":\"31-07-2023 16:33:45\"}', '2023-07-31 16:33:45'),
('eee5cf9fbed6893b20f05941bbb6b902', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"17-07-2023 11:24:09\"}', '2023-07-17 11:24:09'),
('ergergwerrg', 'rgsrsgsergerg', '2023-06-21 15:47:59'),
('f0549a942a73339f62de92b7fd5c1766', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Absen\",\"function\":\"simpan tertunda\",\"table\":\"fai_absen || fai_akun\",\"txt\":\"simpan data pending - {\\\"id_absen\\\":\\\"600c456677ffe07fb4b580e486c261ec\\\",\\\"id_user\\\":\\\"4bc0c527a7c2a9053450a7fb8f92746f\\\",\\\"tgl_absen\\\":\\\"2023-07-28\\\",\\\"absen_masuk\\\":\\\"07:59\\\",\\\"absen_pulang\\\":\\\"\\\",\\\"pending\\\":\\\"1\\\",\\\"catatan_pending\\\":\\\"lupa\\\"}\",\"waktu\":\"28-07-2023 08:41:09\"}', '2023-07-28 08:41:09'),
('f30c59c6f1b7d04daa614db9b118c34b', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"15-06-2023 13:50:59\"}', '2023-06-15 13:50:59'),
('f53dc95af712efb3eebc5d90d7e4b693', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"14-11-2023 08:19:14\"}', '2023-11-14 08:19:14'),
('f7128eb28125f86e61c2d9466bf1f742', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"18-08-2023 08:11:30\"}', '2023-08-18 08:11:30'),
('f79096b7e29dc49560802e1cba8d4e3c', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Absen\",\"function\":\"simpan tertunda\",\"table\":\"fai_absen || fai_akun\",\"txt\":\"simpan data pending - null\",\"waktu\":\"28-07-2023 08:41:23\"}', '2023-07-28 08:41:23'),
('f9a9a03556de2c344e1418e29dfd4fd4', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Login\",\"function\":\"cek_akun\",\"table\":\"fai_akun\",\"txt\":\"berhasil login\",\"waktu\":\"15-11-2023 11:33:53\"}', '2023-11-15 11:33:53'),
('fc0c2f7b8e05d72386d477a54b16744a', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Absen\",\"function\":\"masuk\",\"table\":\"fai_absen\",\"txt\":\"simpan data masuk - null\",\"waktu\":\"19-06-2023 11:27:35\"}', '2023-06-19 11:27:35'),
('ff466d8d18dceba737a96aa1cade4f7d', '{\"id_user\":\"4bc0c527a7c2a9053450a7fb8f92746f\",\"page\":\"Absen\",\"function\":\"pulang\",\"table\":\"fai_absen\",\"txt\":\"simpan data pulang - \",\"waktu\":\"19-06-2023 14:00:11\"}', '2023-06-19 14:00:11'),
('rtsgbsdffbddffgb', 'fgbgbdgbdgb', '2023-06-21 15:47:59');

-- --------------------------------------------------------

--
-- Table structure for table `fai_lokasi`
--

CREATE TABLE `fai_lokasi` (
  `id_lokasi` varchar(255) NOT NULL,
  `nama_lokasi` varchar(40) NOT NULL,
  `long_lokasi` varchar(200) NOT NULL,
  `lat_lokasi` varchar(200) NOT NULL,
  `batas_lokasi` int(9) NOT NULL COMMENT 'satuan meter; 60 meter - 0.2',
  `warna_lokasi` varchar(10) DEFAULT NULL,
  `tgl_add` datetime NOT NULL DEFAULT current_timestamp(),
  `tgl_update` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `tgl_delete` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fai_lokasi`
--

INSERT INTO `fai_lokasi` (`id_lokasi`, `nama_lokasi`, `long_lokasi`, `lat_lokasi`, `batas_lokasi`, `warna_lokasi`, `tgl_add`, `tgl_update`, `tgl_delete`) VALUES
('bac9ed7276e1034d458d97cfd3445e0c', 'Semarang', '1111111111111111', '2222222222222222222', 20, '#fd5706', '2023-06-14 16:46:10', '2023-11-14 13:51:00', NULL),
('f5859c122e621de2dfc7da86dbda2497', 'Office', '112.777079', '-7.297968', 60, 'green', '2023-06-14 16:44:39', '2023-11-14 13:42:17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fai_notif`
--

CREATE TABLE `fai_notif` (
  `id_notif` varchar(255) NOT NULL,
  `mode_notif` tinyint(1) NOT NULL COMMENT '1 - alert; 2 - success',
  `isi_notif` varchar(255) NOT NULL,
  `alasan` varchar(255) NOT NULL,
  `status_baca` tinyint(1) NOT NULL COMMENT '0 - unread; 1 - read',
  `id_user` varchar(255) NOT NULL,
  `tgl_add` datetime NOT NULL DEFAULT current_timestamp(),
  `tgl_update` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fai_notif`
--

INSERT INTO `fai_notif` (`id_notif`, `mode_notif`, `isi_notif`, `alasan`, `status_baca`, `id_user`, `tgl_add`, `tgl_update`) VALUES
('0382b62171c51b16b3cee744575cb5df', 1, 'Pengajuan Absen Unpaid Leave tanggal 16/06/2023 ditolak', 'tgl salah', 1, '4bc0c527a7c2a9053450a7fb8f92746f', '2023-06-08 10:15:25', '2023-06-08 13:08:50'),
('073d7189df8f38c7e9f25d4f0ac19f59', 2, 'Pengajuan Lembur disetujui', '', 1, '4bc0c527a7c2a9053450a7fb8f92746f', '2023-06-14 10:52:13', '2023-06-14 11:06:04'),
('0d03840f501769cc27f2adf9c55b7c9f', 2, 'Pengajuan Absen Libur Shift tanggal 19/06/2023 disetujui', '', 1, '4bc0c527a7c2a9053450a7fb8f92746f', '2023-06-19 10:27:17', '2023-06-19 11:23:36'),
('12c3266c40c19ec474895ee631f27fcf', 2, 'Pengajuan Absen Cuti tanggal 12/06/2023 disetujui', '', 1, '4bc0c527a7c2a9053450a7fb8f92746f', '2023-06-21 16:59:26', '2023-11-02 14:25:46'),
('154e613e96110dd697d8675493d0a515', 2, 'Pengajuan Absen Unpaid Leave ditolak', 'tgl salah', 1, '4bc0c527a7c2a9053450a7fb8f92746f', '2023-06-08 09:33:52', '2023-06-08 13:08:50'),
('19d3e7b72bfa8e3a372cb754ac18b66b', 2, 'Pengajuan Lembur disetujui', '', 1, '4bc0c527a7c2a9053450a7fb8f92746f', '2023-06-14 11:02:26', '2023-06-14 11:06:04'),
('38ff768556b17f53fa5f591eb11f2be5', 2, 'Pengajuan Lembur disetujui', '', 1, '4bc0c527a7c2a9053450a7fb8f92746f', '2023-06-14 10:59:31', '2023-06-14 11:06:04'),
('3c7503f263b98fb5eec8c05c1a3673a7', 1, 'Pengajuan Absen Unpaid Leave tanggal 16/06/2023 ditolak', '', 1, '4bc0c527a7c2a9053450a7fb8f92746f', '2023-06-08 10:46:24', '2023-06-08 13:08:50'),
('43fc84e9c418089e17ec4a39d9b9ba5e', 2, 'Pengajuan Absen Libur Shift tanggal 25/06/2023 disetujui', '', 1, '4bc0c527a7c2a9053450a7fb8f92746f', '2023-06-19 14:08:15', '2023-06-19 15:50:57'),
('4afaf84dcdc3dcc3adf070b62a4efa8d', 1, 'Pengajuan Absen Unpaid Leave tanggal 16/06/2023 ditolak', '', 1, '4bc0c527a7c2a9053450a7fb8f92746f', '2023-06-08 10:46:34', '2023-06-08 13:08:50'),
('4d296ad3f9e842d88f8a21b3ff911831', 1, 'Pengajuan Absen Cuti tanggal 23/06/2023 ditolak', 'tdk boleh bos', 1, '4bc0c527a7c2a9053450a7fb8f92746f', '2023-06-10 11:04:15', '2023-06-12 09:16:03'),
('4fe800e69e536937c4f4b729a4274969', 2, 'Pengajuan Absen Unpaid Leave tanggal 16/06/2023 disetujui', '', 1, '4bc0c527a7c2a9053450a7fb8f92746f', '2023-06-08 10:51:08', '2023-06-08 13:08:50'),
('50eff75a363b0f2c34976b648123133d', 2, 'Pengajuan Lembur disetujui', '', 1, '4bc0c527a7c2a9053450a7fb8f92746f', '2023-06-14 10:53:41', '2023-06-14 11:06:04'),
('60291a067af8c9ded2fc92897e9ffab2', 2, 'Pengajuan Lembur disetujui', '', 1, '4bc0c527a7c2a9053450a7fb8f92746f', '2023-06-14 10:50:18', '2023-06-14 11:06:04'),
('604ab2aff5866b95c388602355c11a79', 2, 'Pengajuan Lembur disetujui', '', 1, '4bc0c527a7c2a9053450a7fb8f92746f', '2023-06-14 11:01:53', '2023-06-14 11:06:04'),
('604f16719c1c52c6bdbd4a813e5bf511', 2, 'Pengajuan Lembur disetujui', '', 1, '4bc0c527a7c2a9053450a7fb8f92746f', '2023-06-14 15:55:34', '2023-06-14 16:15:15'),
('626a3b766eac166a8690236baa313e72', 1, 'Pengajuan Absen Cuti tanggal 17/06/2023 ditolak', 'hapus', 1, '4bc0c527a7c2a9053450a7fb8f92746f', '2023-06-10 09:47:16', '2023-06-10 09:47:23'),
('8109d4fb0ca117e30c6aeaf9fb661c4a', 1, 'Pengajuan Absen Lupa Absen tanggal 20/06/2023 ditolak', 'salah', 1, '4bc0c527a7c2a9053450a7fb8f92746f', '2023-06-19 12:00:05', '2023-06-19 15:50:57'),
('8206489fafd22ba311ad7f3ae18988fc', 1, 'Pengajuan Absen Unpaid Leave tanggal 16/06/2023 ditolak', '', 1, '4bc0c527a7c2a9053450a7fb8f92746f', '2023-06-08 10:46:30', '2023-06-08 13:08:50'),
('8b8a843f3c4a39e01234331180f72a4a', 2, 'Pengajuan Absen  tanggal 19/06/2023 disetujui', '', 1, '4bc0c527a7c2a9053450a7fb8f92746f', '2023-06-19 10:25:21', '2023-06-19 11:23:36'),
('9087938e461ac35f93e7c55968ea6728', 2, 'Pengajuan Absen Libur Shift tanggal 04/06/2023 disetujui', '', 1, '4bc0c527a7c2a9053450a7fb8f92746f', '2023-06-19 14:08:19', '2023-06-19 15:50:57'),
('a181c4737d810c0514189612e0a57c1d', 2, 'Pengajuan Lembur disetujui', '', 1, '4bc0c527a7c2a9053450a7fb8f92746f', '2023-06-14 10:58:16', '2023-06-14 11:06:04'),
('a87461545211fe3b67c7d107f00e3cd7', 2, 'Pengajuan Lembur disetujui', '', 1, '4bc0c527a7c2a9053450a7fb8f92746f', '2023-06-14 10:51:24', '2023-06-14 11:06:04'),
('a8f7a4e5b2e11567312e93413f33662c', 2, 'Pengajuan Lembur disetujui', '', 1, '4bc0c527a7c2a9053450a7fb8f92746f', '2023-06-14 11:02:40', '2023-06-14 11:06:04'),
('af741923eaeb1b737e09eaca283e1e8a', 1, 'Pengajuan Absen Unpaid Leave tanggal  ditolak', 'tgl salah', 1, '4bc0c527a7c2a9053450a7fb8f92746f', '2023-06-08 10:14:53', '2023-06-08 13:08:50'),
('b0b3badec0985c93cb5d805e82bb6e1c', 2, 'Pengajuan Lembur disetujui', '', 1, '4bc0c527a7c2a9053450a7fb8f92746f', '2023-06-14 10:54:23', '2023-06-14 11:06:04'),
('cb5f2838082e4b2f362dae2e693339c3', 2, 'Pengajuan Absen Unpaid Leave disetujui', '', 1, '4bc0c527a7c2a9053450a7fb8f92746f', '2023-06-08 10:48:56', '2023-06-08 13:08:50'),
('ce8fef066a6f775b82800552e7fb3694', 2, 'Pengajuan Lembur disetujui', '', 1, '4bc0c527a7c2a9053450a7fb8f92746f', '2023-06-14 11:02:54', '2023-06-14 11:06:04'),
('da037bc8ce667281bd6c136df527541a', 2, 'Pengajuan Lembur disetujui', '', 0, '', '2023-06-14 10:42:47', NULL),
('f47886fd7a3e4baedd1c44e5b3773463', 2, 'Pengajuan Absen Libur Shift tanggal 17/06/2023 disetujui', '', 1, '4bc0c527a7c2a9053450a7fb8f92746f', '2023-06-19 14:08:22', '2023-06-19 15:50:57'),
('f6173ba93428609ec9de2859bba468b4', 2, 'Pengajuan Absen Libur Shift tanggal 20/06/2023 disetujui', '', 1, '4bc0c527a7c2a9053450a7fb8f92746f', '2023-06-19 12:00:27', '2023-06-19 15:50:57'),
('fd5f9a5f285a300d85e4ab2fe092a546', 1, 'Pengajuan Absen Cuti tanggal 19/06/2023 ditolak', 'tdk boleh libur', 1, '4bc0c527a7c2a9053450a7fb8f92746f', '2023-06-10 09:27:14', '2023-06-10 09:27:24');

-- --------------------------------------------------------

--
-- Table structure for table `fai_pending_detail`
--

CREATE TABLE `fai_pending_detail` (
  `id_pending` int(5) NOT NULL,
  `nama_pending` varchar(100) NOT NULL,
  `tgl_add` datetime NOT NULL DEFAULT current_timestamp(),
  `tgl_update` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fai_pending_detail`
--

INSERT INTO `fai_pending_detail` (`id_pending`, `nama_pending`, `tgl_add`, `tgl_update`) VALUES
(0, 'Live Absen', '2023-06-05 09:11:16', NULL),
(1, 'Pending Absen', '2023-06-05 09:11:16', '2023-06-07 09:12:51'),
(2, 'Pending Acc', '2023-06-05 09:11:39', NULL),
(3, 'Pending Ditolak', '2023-06-05 09:11:39', NULL),
(4, 'Cuti', '2023-06-05 09:12:06', NULL),
(5, 'Unpaid Leave', '2023-06-05 09:12:06', '2023-06-07 08:49:06'),
(6, 'Sakit', '2023-06-05 09:12:25', NULL),
(7, 'Pending Cuti', '2023-06-05 09:12:25', NULL),
(8, 'Pending Unpaid Leave', '2023-06-05 09:12:44', '2023-06-07 08:49:00'),
(9, 'Pending Sakit', '2023-06-05 09:12:44', NULL),
(10, 'Pending Libur Shift', '2023-06-19 10:23:27', NULL),
(11, 'Libur Shift', '2023-06-19 10:23:27', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fai_pengumuman`
--

CREATE TABLE `fai_pengumuman` (
  `id_pengumuman` varchar(255) NOT NULL,
  `nama_pengumuman` varchar(200) NOT NULL,
  `tgl_add` datetime NOT NULL DEFAULT current_timestamp(),
  `tgl_update` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `tgl_delete` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `fesp32_data_esp`
--

CREATE TABLE `fesp32_data_esp` (
  `id_data_esp` varchar(255) NOT NULL,
  `id_esp` varchar(255) NOT NULL,
  `nomor_data_esp` int(11) NOT NULL,
  `nama_data_esp` varchar(100) NOT NULL,
  `value_data_esp` varchar(255) DEFAULT NULL,
  `satuan_data_esp` varchar(10) DEFAULT NULL,
  `tgl_add` datetime NOT NULL DEFAULT current_timestamp(),
  `tgl_update` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `tgl_delete` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fesp32_data_esp`
--

INSERT INTO `fesp32_data_esp` (`id_data_esp`, `id_esp`, `nomor_data_esp`, `nama_data_esp`, `value_data_esp`, `satuan_data_esp`, `tgl_add`, `tgl_update`, `tgl_delete`) VALUES
('2a549124723320979c8bedb819c298f7', 'bd7d0b251dda132f39c0fcbc93c60db5', 0, 'EM_01', '0', NULL, '2023-12-19 10:14:03', NULL, NULL),
('aa3a4d0fa6cc6db1511b94a44e454484', '1db72ea7e89413d2ea5f9b2737a8a353', 0, 'var_11', '224', 'kgm', '2023-12-19 08:48:44', '2023-12-20 16:10:08', NULL),
('f0af1d72f0853847ac126fb3615b4bb1', '1db72ea7e89413d2ea5f9b2737a8a353', 0, 'Var_2', NULL, 'km/h', '2023-12-19 09:09:20', '2023-12-20 16:01:32', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fesp32_esp`
--

CREATE TABLE `fesp32_esp` (
  `id_esp` varchar(255) NOT NULL,
  `kode_esp` varchar(100) NOT NULL,
  `deskripsi_esp` text NOT NULL,
  `tgl_add` datetime NOT NULL DEFAULT current_timestamp(),
  `tgl_update` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `tgl_delete` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fesp32_esp`
--

INSERT INTO `fesp32_esp` (`id_esp`, `kode_esp`, `deskripsi_esp`, `tgl_add`, `tgl_update`, `tgl_delete`) VALUES
('1db72ea7e89413d2ea5f9b2737a8a353', 'SBY_012', 'lokasi Surabaya PT ABC2', '2023-12-15 13:51:13', '2023-12-15 14:18:28', NULL),
('bd7d0b251dda132f39c0fcbc93c60db5', 'BTM_001', 'Batam, PLTGU', '2023-12-19 10:13:52', '2023-12-19 10:48:10', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fesp32_log`
--

CREATE TABLE `fesp32_log` (
  `id_log` varchar(255) NOT NULL,
  `id_data_esp` varchar(255) NOT NULL,
  `nama_data_esp` varchar(100) NOT NULL,
  `value_data_esp` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `fesp32_relasi_data`
--

CREATE TABLE `fesp32_relasi_data` (
  `id_relasi` varchar(255) NOT NULL,
  `id_user` varchar(255) NOT NULL,
  `id_data_esp` varchar(255) NOT NULL,
  `tgl_add` datetime NOT NULL DEFAULT current_timestamp(),
  `tgl_update` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `tgl_delete` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `fesp32_user`
--

CREATE TABLE `fesp32_user` (
  `id_user` varchar(255) NOT NULL,
  `id_esp` varchar(255) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` tinyint(1) NOT NULL COMMENT '1-spu;2-user',
  `tgl_add` datetime NOT NULL DEFAULT current_timestamp(),
  `tgl_update` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `tgl_delete` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fesp32_user`
--

INSERT INTO `fesp32_user` (`id_user`, `id_esp`, `username`, `password`, `role`, `tgl_add`, `tgl_update`, `tgl_delete`) VALUES
('c2f13fd384d9b624a0679bc69923683a', '1db72ea7e89413d2ea5f9b2737a8a353', 'falcon', '25f9e794323b453885f5181f1b624d0b', 1, '2023-12-15 16:58:15', '2023-12-16 10:13:25', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fki_dana_pengajuan`
--

CREATE TABLE `fki_dana_pengajuan` (
  `id_dana_pengajuan` int(10) NOT NULL,
  `id_data_kas` varchar(255) NOT NULL,
  `id_lokasi` varchar(255) NOT NULL,
  `nominal` decimal(15,0) NOT NULL,
  `tgl_add` datetime NOT NULL DEFAULT current_timestamp(),
  `tgl_edit` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `tgl_delete` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fki_dana_pengajuan`
--

INSERT INTO `fki_dana_pengajuan` (`id_dana_pengajuan`, `id_data_kas`, `id_lokasi`, `nominal`, `tgl_add`, `tgl_edit`, `tgl_delete`) VALUES
(1, '871239cfa66095455d91954fd254adf1', 'f5859c122e621de2dfc7da86dbda2497', '1500000000', '2023-10-14 11:11:40', '2023-10-14 11:45:27', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fki_data`
--

CREATE TABLE `fki_data` (
  `id_data` varchar(255) NOT NULL,
  `deskripsi_data` varchar(100) NOT NULL,
  `tgl_data` date NOT NULL,
  `id_minggu` varchar(255) NOT NULL,
  `id_tipe` int(5) NOT NULL COMMENT 'tipe kas,bbm,laundry,dll',
  `id_status` tinyint(1) NOT NULL COMMENT '1-luar rab;2-rab',
  `id_jenis_kas` tinyint(1) NOT NULL COMMENT '1 - keluar; 2 - masuk',
  `pic_data` varchar(255) NOT NULL,
  `qty_data` decimal(15,3) NOT NULL,
  `nominal_data` varchar(50) NOT NULL,
  `tgl_add` datetime NOT NULL DEFAULT current_timestamp(),
  `tgl_update` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `tgl_delete` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fki_data`
--

INSERT INTO `fki_data` (`id_data`, `deskripsi_data`, `tgl_data`, `id_minggu`, `id_tipe`, `id_status`, `id_jenis_kas`, `pic_data`, `qty_data`, `nominal_data`, `tgl_add`, `tgl_update`, `tgl_delete`) VALUES
('006e5fe1b319a30d8dc9ec560d638cb0', '-', '2023-06-28', '8f3cf527968bedc080c97d2018a6c24e', 4, 2, 1, '-', '1.000', '0', '2023-07-24 16:47:40', NULL, NULL),
('04490f423668bd3a10fcec05b8d0dffe', 'Materai', '2023-06-10', 'b4d7666306bacee0d512dca40c348cf7', 2, 2, 1, 'Kilah', '5.000', '10500', '2023-07-18 10:23:22', '2023-08-10 16:01:07', NULL),
('07e1cab9e702967a797b5b3a6fb4b18b', 'Pertalite Mobil HRV', '2023-06-14', '34573e9e35eab6ca872a796c1e81000d', 1, 2, 1, 'Bery', '1.000', '100000', '2023-07-24 14:16:01', '2023-07-24 14:18:09', '2023-07-24 14:18:09'),
('0c9ba69be504b478666dd8d538f0712b', 'dana', '2023-06-26', '8f3cf527968bedc080c97d2018a6c24e', 13, 2, 2, '-', '1.000', '225000', '2023-07-24 16:49:25', NULL, NULL),
('0d5b400044c6be42fd403e5055d9c859', 'KAS 008 Commisioning Minggu I Juli 2023', '2023-08-08', '3547c529c6f4417ff6bbef9f58900052', 1, 2, 1, 'Mas Hari', '1.000', '1920100', '0000-00-00 00:00:00', NULL, NULL),
('11a0e0e01f5bea52cf8709a3af555a76', 'BPJS TK Surabaya', '2023-06-04', 'b4d7666306bacee0d512dca40c348cf7', 8, 2, 1, 'Bu Lina', '1.000', '6579000', '2023-07-24 16:39:59', NULL, NULL),
('12934d223e70246f12c457431a5a4eef', 'KAS minggu 4 Agustus 2023', '2023-08-30', '3547c529c6f4417ff6bbef9f58900052', 1, 2, 1, 'Mas Hari', '1.000', '1526752', '0000-00-00 00:00:00', NULL, NULL),
('12eca524617b97defe111b919b100a4f', 'sgnns', '2023-07-12', 'b4d7666306bacee0d512dca40c348cf7', 2, 1, 2, 'user1', '12.000', '5000', '2023-07-17 10:54:21', '2023-07-20 13:49:13', '2023-07-20 13:49:13'),
('132ea8527063fae4fcda1a8f5bb31652', 'KAS minggu 2 Agustus 2023', '2023-08-18', '3547c529c6f4417ff6bbef9f58900052', 1, 2, 1, 'Mas Hari', '1.000', '2639000', '0000-00-00 00:00:00', NULL, NULL),
('137aa918271f61457149d101bce298e5', 'KAS Office minggu 2 Agustus 2023', '2023-08-18', '3547c529c6f4417ff6bbef9f58900052', 1, 2, 1, 'Bu ike', '1.000', '1455901', '0000-00-00 00:00:00', NULL, NULL),
('1546cadbce8abfed4b73b2c0b679fd55', '-', '2023-06-17', '2edf12dbd56bf3a501415f56fdad6be5', 4, 2, 1, '-', '1.000', '0', '2023-07-24 16:10:27', NULL, NULL),
('168255fe8b93e731e2f08297f350f3b0', 'Pembelian Tiket Tugas SUB-BTH Mas Majid', '2023-08-28', '7b40fc6ce51e645f5d570292523cc35c', 14, 1, 1, 'P.Fitri', '1.000', '1382680', '0000-00-00 00:00:00', NULL, NULL),
('16d905c7150fc2130c267027b75e19ce', 'KAS LUAR RAB Comm Semarang AGUSTUS 2023', '2023-08-28', '3547c529c6f4417ff6bbef9f58900052', 1, 2, 1, 'Pak Fitri', '1.000', '9210000', '0000-00-00 00:00:00', NULL, NULL),
('17ae4f3780dbb2116b718f7ae076d0db', 'Materai 10.000', '2023-06-28', '8f3cf527968bedc080c97d2018a6c24e', 2, 2, 1, 'Bu Lina', '5.000', '10000', '2023-07-24 16:46:14', '2023-11-14 10:51:12', NULL),
('1899d1bd9a2d92a3cf8469672a18f06c', 'KAS Office Minggu 1 Agustus 2023', '2023-08-08', '3547c529c6f4417ff6bbef9f58900052', 1, 2, 1, 'Bu Ike', '1.000', '2270300', '0000-00-00 00:00:00', NULL, NULL),
('18ffdbee9fdcb72097e8e43eb13aefe8', 'Besi 6m', '2023-08-10', '3547c529c6f4417ff6bbef9f58900052', 5, 2, 1, 'Mas Yosin', '1.000', '30000', '0000-00-00 00:00:00', NULL, NULL),
('1affff48c7390ede836b0c3e8fcb945a', 'Pembelian Tiket Cuti BTH-SUB Fery', '2023-08-26', '7b40fc6ce51e645f5d570292523cc35c', 14, 1, 1, 'P.Fitri', '1.000', '1352000', '0000-00-00 00:00:00', NULL, NULL),
('1b5b9601d1989cd20d87de699033e2d1', 'Kirim SPK & BAU R1 Ke PP Elnusa', '2023-06-19', '2edf12dbd56bf3a501415f56fdad6be5', 9, 2, 1, 'Berry', '1.000', '15000', '2023-07-24 16:23:11', NULL, NULL),
('1dfd6e0988515ebd733b3f3d844353a6', 'KAS Batam Minggu 2', '2023-08-13', '3547c529c6f4417ff6bbef9f58900052', 1, 2, 1, 'Mbak Ike', '1.000', '3910650', '0000-00-00 00:00:00', NULL, NULL),
('1e7aacbbd4caaa3d271f597a87e61efd', 'dana laundry', '2023-06-17', '2edf12dbd56bf3a501415f56fdad6be5', 4, 2, 2, '-', '1.000', '25000', '2023-07-24 16:10:27', NULL, NULL),
('20c828ce5e7b3c79fbda73c084a700fe', 'Biaya Reschedule kereta SBI-SMT Mas Yunus', '2023-08-12', '7b40fc6ce51e645f5d570292523cc35c', 14, 1, 1, 'Ike', '1.000', '82000', '0000-00-00 00:00:00', NULL, NULL),
('2258fa159c2b11715b07ccf2950988c3', 'Sisa Kas 0006 Office Minggu II	', '2023-06-19', '2edf12dbd56bf3a501415f56fdad6be5', 1, 2, 1, 'Kilah', '1.000', '-70700', '2023-07-24 11:29:20', NULL, NULL),
('2462b2d0321f148085cd6574cc4ac90b', 'KAS LUAR RAB FO Semarang AGUSTUS 2023', '2023-08-28', '3547c529c6f4417ff6bbef9f58900052', 1, 2, 1, 'Pak Fitri', '1.000', '5610000', '0000-00-00 00:00:00', NULL, NULL),
('24cc5c9e4590e1fc1df51366c38c37f5', 'dana laundry', '2023-06-15', 'b4d7666306bacee0d512dca40c348cf7', 4, 2, 2, '-', '1.000', '25000', '2023-07-21 15:57:04', NULL, NULL),
('24ce7d3d101ab8a8fdd88ab379f7941c', 'Cleo Galon', '2023-06-15', '34573e9e35eab6ca872a796c1e81000d', 3, 2, 1, 'Bu Lina', '4.000', '20000', '2023-07-24 14:24:21', NULL, NULL),
('25b3fa9c15ea90ffd1fa6aea1f7d058d', 'Indihome', '2023-06-08', 'b4d7666306bacee0d512dca40c348cf7', 10, 2, 1, 'Bu Lina', '1.000', '1049378', '2023-07-24 16:41:28', NULL, NULL),
('27042ddc9b06556936be737d4522b594', 'Sapu', '2023-06-09', 'b4d7666306bacee0d512dca40c348cf7', 7, 1, 1, 'Bu Ike', '1.000', '45000', '2023-07-22 10:22:00', NULL, NULL),
('27319e86971b0f33e497da70f81eaf5a', 'Pembelian Tiket Cuti BTH-SUB Majid', '2023-08-11', '7b40fc6ce51e645f5d570292523cc35c', 14, 1, 1, 'P.Fitri', '1.000', '1474500', '0000-00-00 00:00:00', NULL, NULL),
('277fa922acb0253e57a1608247880a28', 'KAS Batam Minggu 3', '2023-08-20', '3547c529c6f4417ff6bbef9f58900052', 1, 2, 1, 'Mbak Ike', '1.000', '3358025', '0000-00-00 00:00:00', NULL, NULL),
('28fcfdefeafd15d67704df34059c3945', 'Baterai Cordless AAA Panasonic 1,2 V', '2023-06-02', 'b4d7666306bacee0d512dca40c348cf7', 2, 2, 1, 'Kilah', '1.000', '80000', '2023-07-18 10:23:22', '2023-07-21 10:45:29', NULL),
('29033c5ae55a550507e066f1cc81013f', 'KAS 0008 FO Semarang Minggu ke III', '2023-08-24', '3547c529c6f4417ff6bbef9f58900052', 1, 2, 1, 'Mas Yosin', '1.000', '1651420', '0000-00-00 00:00:00', NULL, NULL),
('2974dc344c2b8335fb0baefb02925381', 'data 17', '2023-07-17', 'b4d7666306bacee0d512dca40c348cf7', 1, 2, 1, 'user1', '11.000', '22', '2023-07-17 10:47:48', '2023-07-18 14:31:28', '2023-07-18 09:17:41'),
('29d83a237a5a4dd4d60f05502df17087', 'Pertalite Motor Mio', '2023-06-07', 'b4d7666306bacee0d512dca40c348cf7', 5, 2, 1, 'Bu Lina', '1.000', '20000', '2023-07-18 09:38:53', '2023-07-18 14:31:28', NULL),
('2cce5db847da21e6a175bf63356c18d0', 'Kirim ke Situbondo', '2023-06-15', '34573e9e35eab6ca872a796c1e81000d', 9, 2, 1, 'Bu Lina', '1.000', '15000', '2023-07-24 14:35:42', NULL, NULL),
('2cf6210fb07735b0e2ea4633d14a14c2', 'Kirim Dokumen (Inv.Termin 4) PT. PP Tbk', '2023-06-07', 'b4d7666306bacee0d512dca40c348cf7', 9, 2, 1, 'Kilah', '1.000', '17000', '2023-07-24 16:42:31', NULL, NULL),
('2dbd5bf5fde2500cb6bc47ea675687d4', 'Pembelian Tiket Tugas SUB-BTH P. Djaka', '2023-08-22', '7b40fc6ce51e645f5d570292523cc35c', 14, 1, 1, 'P.Fitri', '1.000', '1257090', '0000-00-00 00:00:00', NULL, NULL),
('309b1051252d17f3112b581b7492f75a', 'KAS LUAR RAB Office AGUSTUS 2023', '2023-08-28', '3547c529c6f4417ff6bbef9f58900052', 1, 2, 1, 'Pak Fitri', '1.000', '3547500', '0000-00-00 00:00:00', NULL, NULL),
('319df654e5183f04c60822a5dfed8682', 'PDAM', '2023-06-20', '2edf12dbd56bf3a501415f56fdad6be5', 10, 2, 1, 'Bu Lina', '1.000', '236940', '2023-07-24 16:21:52', NULL, NULL),
('31d45f58eb4494312057c51bd52086f4', 'Pertalite Mobil HRV	', '2023-06-14', '34573e9e35eab6ca872a796c1e81000d', 5, 2, 1, 'Bery', '1.000', '100000', '2023-07-24 14:17:52', NULL, NULL),
('33edef8f7fad016c69044cb803716b03', 'Pertalite Mio', '2023-06-18', '2edf12dbd56bf3a501415f56fdad6be5', 5, 2, 1, 'Bu Lina', '1.000', '25000', '2023-07-24 15:15:02', NULL, NULL),
('34cca2028898f7068563cac697a1bc81', 'hutang', '2023-07-01', 'b4d7666306bacee0d512dca40c348cf7', 1, 2, 1, 'sdbdfsbdffb', '1.000', '-1', '2023-07-17 13:20:46', '2023-07-18 14:31:28', '2023-07-18 08:20:18'),
('36129635b79d878f92e5d6b59762dacf', 'KAS Pembelian Tiket Pesawat & Hotel Agustus 2023', '2023-08-31', '3547c529c6f4417ff6bbef9f58900052', 1, 2, 1, 'Bu Ike', '1.000', '18286749', '0000-00-00 00:00:00', NULL, NULL),
('363a99645cc81adea2d2fe9065260e3d', 'dana', '2023-06-26', '8f3cf527968bedc080c97d2018a6c24e', 5, 2, 2, '-', '1.000', '200000', '2023-07-24 16:43:55', NULL, NULL),
('37f8c5ea2e50fcdc4ac4b085d3fc6ad7', 'Isi E-toll', '2023-06-08', 'b4d7666306bacee0d512dca40c348cf7', 5, 2, 1, 'Bu Lina', '1.000', '51500', '2023-07-18 09:38:53', '2023-07-18 14:31:28', NULL),
('383164a0082b764c902788e172f9aa31', 'Tambang 110L', '2023-08-11', '3547c529c6f4417ff6bbef9f58900052', 5, 2, 1, 'Mas Yosin', '1.000', '12500', '0000-00-00 00:00:00', NULL, NULL),
('389c0f3c338f865858d40f5425f1406d', 'dana masuk', '2023-06-22', '2edf12dbd56bf3a501415f56fdad6be5', 10, 2, 2, '-', '1.000', '745000', '2023-07-24 16:21:52', NULL, NULL),
('3916ca57566436909c0cad143995c0d5', 'Iuran Keamanan & Kebersihan ', '2023-06-26', '8f3cf527968bedc080c97d2018a6c24e', 13, 2, 1, 'Bu Lina', '1.000', '225000', '2023-07-24 16:49:25', NULL, NULL),
('3a61be275a1b9395325485249449dc90', 'Bensin Pertalite Mobil CRV', '2023-06-20', '2edf12dbd56bf3a501415f56fdad6be5', 5, 2, 1, 'Berry', '1.000', '120000', '2023-07-24 15:15:02', NULL, NULL),
('3b180d8a2874011f4cf5a1316c63ad76', 'Kirim Sepatu Ke Semarang', '2023-06-19', '2edf12dbd56bf3a501415f56fdad6be5', 9, 2, 1, 'Berry', '1.000', '20000', '2023-07-24 16:23:11', NULL, NULL),
('3d574b308682d45a3e34e042b057eb31', 'ABC Biru Batu Baterai', '2023-08-26', '3547c529c6f4417ff6bbef9f58900052', 5, 2, 1, 'Mas Yosin', '1.000', '15500', '0000-00-00 00:00:00', NULL, NULL),
('3da07ef1f4aa141273326c8633ddafd3', 'Tang Potong', '2023-08-20', '3547c529c6f4417ff6bbef9f58900052', 5, 2, 1, 'Mas Yosin', '1.000', '50000', '0000-00-00 00:00:00', NULL, NULL),
('3db72b2e1b1adc03be6ecaada8c902bb', 'Sisa Saldo Kas 0007', '2023-07-31', '3547c529c6f4417ff6bbef9f58900052', 1, 2, 1, 'Pradita', '1.000', '0106000', '0000-00-00 00:00:00', NULL, NULL),
('3e370034ffee685c545ac5c0deff3be0', 'Kawat', '2023-08-14', '3547c529c6f4417ff6bbef9f58900052', 5, 2, 1, 'Mas Yosin', '1.000', '20000', '0000-00-00 00:00:00', NULL, NULL),
('4091926d67928507c32a9c8d311cc877', 'BPJS Kesehatan Surabaya', '2023-06-04', 'b4d7666306bacee0d512dca40c348cf7', 8, 2, 1, 'Bu Lina', '1.000', '3939240', '2023-07-24 16:39:59', NULL, NULL),
('49457b0a5b649cc063ead04d06f572ea', 'Materai 10.000', '2023-06-26', '8f3cf527968bedc080c97d2018a6c24e', 2, 2, 1, 'Bu Lina', '18.000', '12000', '2023-07-24 16:46:14', NULL, NULL),
('4995de00b01bc59127869acb85bea7f9', 'Parkir Notaris', '2023-06-19', '2edf12dbd56bf3a501415f56fdad6be5', 5, 2, 1, 'Bu Lina', '3.000', '5000', '2023-07-24 15:15:02', NULL, NULL),
('4b25f08a14a3264859c98091367bffa8', 'dana', '2023-06-15', '34573e9e35eab6ca872a796c1e81000d', 4, 2, 2, '-', '1.000', '25000', '2023-07-24 16:27:14', NULL, NULL),
('4df1ee28469e2d8124922759e069dd0d', 'KAS 0008 FO Semarang Minggu ke IV', '2023-08-30', '3547c529c6f4417ff6bbef9f58900052', 1, 2, 1, 'Mas Yosin', '1.000', '1750600', '0000-00-00 00:00:00', NULL, NULL),
('4e12e34d80ac081f7f7eb64ad208fba8', 'Bensin Pertalite Mio	', '2023-06-15', '34573e9e35eab6ca872a796c1e81000d', 5, 2, 1, 'Bery', '1.000', '20000', '2023-07-24 14:17:52', NULL, NULL),
('505afddaf8a44f1b9d29b079b06e2f35', 'Adm bank', '2023-06-23', '2edf12dbd56bf3a501415f56fdad6be5', 2, 2, 1, 'Bu Lina', '1.000', '1000', '2023-07-24 16:20:02', NULL, NULL),
('513f48116b73d08264bc0b4addb704a1', 'dana', '2023-06-28', '8f3cf527968bedc080c97d2018a6c24e', 10, 2, 2, '-', '1.000', '500000', '2023-07-24 16:47:06', '2023-11-14 10:51:23', NULL),
('5148adf4081e7eb9f18d65a49d0a99d5', 'Token Listrik', '2023-06-08', 'b4d7666306bacee0d512dca40c348cf7', 10, 2, 1, 'Bu Lina', '1.000', '503000', '2023-07-24 16:41:28', NULL, NULL),
('51aae8b403904262cf37cb23bef95ae2', 'Bensin Pertalite Mio', '2023-06-15', '34573e9e35eab6ca872a796c1e81000d', 1, 2, 1, 'Bery', '1.000', '20000', '2023-07-24 14:16:01', '2023-07-24 14:18:02', '2023-07-24 14:18:02'),
('53054f4016cf1a870dfb7e193ab46ddb', 'KAS Isma Banjarsari Minggu 4 Agustus 2023', '2023-08-30', '3547c529c6f4417ff6bbef9f58900052', 1, 2, 1, 'Bu Ike', '1.000', '391500', '0000-00-00 00:00:00', NULL, NULL),
('542b51b00870b6d6e1f3c9fac958d36d', 'KAS 0008 FO Semarang Minggu ke II Agustus', '2023-08-13', '3547c529c6f4417ff6bbef9f58900052', 1, 2, 1, 'Mas Yosin', '1.000', '3391840', '0000-00-00 00:00:00', NULL, NULL),
('54d7748f1f7397fc2a8568df55a98ea1', 'BPJS Office Agustus 2023', '2023-08-04', '3547c529c6f4417ff6bbef9f58900052', 1, 2, 1, 'Bu Lina', '1.000', '27306272', '0000-00-00 00:00:00', NULL, NULL),
('55befcc7b60bdb303e75c31e76e1779d', 'tes data float', '2023-08-01', 'b4d7666306bacee0d512dca40c348cf7', 1, 2, 1, 'a1', '1.123', '10000', '2023-08-09 11:06:36', '2023-08-09 13:29:24', '2023-08-09 13:29:24'),
('5606830b9b521f4c838751ed3cc56dd8', 'Reimburse Travel Pak Yunus LSM - Bandara Medan + Uang Makan', '2023-06-12', 'b4d7666306bacee0d512dca40c348cf7', 5, 1, 1, 'Pak Fitri', '1.000', '360000', '2023-07-22 10:19:39', '2023-07-22 10:19:59', NULL),
('57351062f49c13b82e35296e6ef1b36a', 'kas masuk', '2023-06-15', '2edf12dbd56bf3a501415f56fdad6be5', 5, 2, 2, '-', '1.000', '100000', '2023-07-24 15:15:59', NULL, NULL),
('58e06b08052344333914b17b1ea8f991', 'Sisa KAS 0007 FO Semarang Minggu ke IV Juli', '2023-07-31', '3547c529c6f4417ff6bbef9f58900052', 1, 2, 1, 'Mas Yosin', '1.000', '1072569974', '0000-00-00 00:00:00', NULL, NULL),
('58e10ff043f456c8a2f28a62acbe3cd5', 'Le Mineral 330 ml', '2023-06-03', 'b4d7666306bacee0d512dca40c348cf7', 3, 2, 1, 'Kilah', '1.000', '42000', '2023-07-18 10:18:49', '2023-07-18 14:31:28', NULL),
('5b90b5ccfa871aeb3f3162af35c91071', 'Stop Kontak 4Lubang', '2023-08-06', '3547c529c6f4417ff6bbef9f58900052', 5, 2, 1, 'Pak Arif', '1.000', '30000', '0000-00-00 00:00:00', NULL, NULL),
('5cb5d888e9c1561c192f657dbabf9708', 'KAS Office Minggu 3 Agustus 2023', '2023-08-24', '3547c529c6f4417ff6bbef9f58900052', 1, 2, 1, 'Bu Lina', '1.000', '1067900', '0000-00-00 00:00:00', NULL, NULL),
('5dfb6a7b07c03fd2c80773dabc6f760d', 'Pertalite Mio', '2023-07-03', 'b4d7666306bacee0d512dca40c348cf7', 5, 2, 1, 'Bu Lina', '1.000', '17000', '2023-07-17 11:34:05', '2023-07-18 14:31:28', '2023-07-17 16:25:42'),
('5e036731780b9b3685f1dbd822ed2014', 'Uang Makan Tukang Minggu 2 (12-17 Juni 2023)', '2023-06-18', 'b4d7666306bacee0d512dca40c348cf7', 3, 1, 1, 'Pak Fitri', '1.000', '360000', '2023-07-22 10:22:59', '2023-11-14 10:57:50', NULL),
('5eddaef325a38340ce9a4079dc69449a', 'Kirim BAP Ke PT. SKP Tenaga Listrik', '2023-06-19', '2edf12dbd56bf3a501415f56fdad6be5', 9, 2, 1, 'Berry', '1.000', '15000', '2023-07-24 16:23:11', NULL, NULL),
('5f960b4dc575a40f511831cf639271a7', 'Token Listrik', '2023-06-22', '2edf12dbd56bf3a501415f56fdad6be5', 10, 2, 1, 'Bu Lina', '1.000', '503000', '2023-07-24 16:21:52', NULL, NULL),
('608fcc42ae4eb385906dc74e8c033422', 'KAS Masuk Minggu 4', '2023-08-27', '3547c529c6f4417ff6bbef9f58900052', 1, 2, 1, 'Mbak Ike', '1.000', '3097250', '0000-00-00 00:00:00', NULL, NULL),
('661126b89fca5afa05d51a752631075e', 'Cleo Galon', '2023-06-27', '8f3cf527968bedc080c97d2018a6c24e', 3, 2, 1, 'Berry', '3.000', '20000', '2023-07-24 16:44:51', NULL, NULL),
('66ab31d9e0e0598a98f1f7fe6c43f612', 'Grenda Potong WD 4\" 105 x 1,2 x 16mm', '2023-08-10', '3547c529c6f4417ff6bbef9f58900052', 5, 2, 1, 'Mas Hari', '6.000', '4000', '0000-00-00 00:00:00', NULL, NULL),
('67d3772a8f848c0d09c7cd276735318e', '-', '2023-06-26', '8f3cf527968bedc080c97d2018a6c24e', 5, 2, 1, '-', '1.000', '0', '2023-07-24 16:43:55', NULL, NULL),
('68ed431cb140d1ec53d8650219af973c', 'dana', '2023-06-15', '34573e9e35eab6ca872a796c1e81000d', 10, 2, 2, '-', '1.000', '500000', '2023-07-24 16:27:14', NULL, NULL),
('69f1756f9f3177be9448f447b6ae3274', 'data 14', '2023-07-01', 'b4d7666306bacee0d512dca40c348cf7', 1, 2, 1, '1', '1.000', '2', '2023-07-17 10:51:36', '2023-07-18 14:31:28', '2023-07-18 08:20:20'),
('6d0f55c0597efef14595f4974414dd07', '-', '2023-06-09', 'b4d7666306bacee0d512dca40c348cf7', 4, 2, 1, '-', '1.000', '0', '2023-07-21 16:20:16', NULL, NULL),
('6df0000fcdead2153957decfbdefec47', 'Parkir ', '2023-06-21', '2edf12dbd56bf3a501415f56fdad6be5', 5, 2, 1, 'Berry', '1.000', '5000', '2023-07-24 15:15:02', NULL, NULL),
('716cb6d3afb2f0021c3df93250d68169', 'Cuci Baju(kg)', '2023-07-02', 'b4d7666306bacee0d512dca40c348cf7', 4, 1, 1, 'Adam', '10.000', '7000', '2023-07-17 11:12:55', '2023-07-18 14:31:28', '2023-07-18 09:17:46'),
('725299950588f702cd70bb2b0cdf37de', 'LPG', '2023-06-07', 'b4d7666306bacee0d512dca40c348cf7', 7, 2, 1, 'Bu Lina', '1.000', '18000', '2023-07-18 10:28:13', '2023-07-18 14:31:28', NULL),
('7265109a50f4abd1f4a22cd5b93946c5', 'Pembelian Tiket Tugas SMT-SBI Mas Yunus & P. Abu', '2023-08-05', '7b40fc6ce51e645f5d570292523cc35c', 14, 1, 1, 'P.Fitri', '2.000', '306750', '0000-00-00 00:00:00', NULL, NULL),
('783feccee8e90486b188736c823d4c5f', 'Club Gelas 1 Dus', '2023-06-09', 'b4d7666306bacee0d512dca40c348cf7', 3, 2, 1, 'Kilah', '1.000', '22000', '2023-07-18 10:18:49', '2023-07-18 14:31:28', NULL),
('7863f1ea257a68614af229c98f8d7f3b', 'Cleo Galon', '2023-06-09', 'b4d7666306bacee0d512dca40c348cf7', 3, 2, 1, 'Kilah', '3.000', '20000', '2023-07-24 16:36:51', NULL, NULL),
('79b5c10944e8b32b5f659115e0ce213d', 'Cuci Mobil HRV', '2023-06-08', 'b4d7666306bacee0d512dca40c348cf7', 5, 1, 1, 'Pak Fitri', '1.000', '100000', '2023-07-22 10:19:39', NULL, NULL),
('7d8c9b5e9811017012ebd78db0acd0d0', 'Tinta Refill Brother BT6000bk', '2023-06-23', '2edf12dbd56bf3a501415f56fdad6be5', 2, 2, 1, 'Bu Lina', '1.000', '98000', '2023-07-24 16:20:02', NULL, NULL),
('816d2e2460ec2aded3547813c21137bd', 'dana', '2023-06-15', '34573e9e35eab6ca872a796c1e81000d', 5, 2, 2, '-', '1.000', '200000', '2023-07-24 16:27:14', NULL, NULL),
('83b73cb605f6a786bfa63221fa04588e', 'Pembelian Tiket Balik Cuti SUB-BTH P. Yogi', '2023-08-04', '7b40fc6ce51e645f5d570292523cc35c', 14, 1, 1, 'P.Fitri', '1.000', '1386000', '0000-00-00 00:00:00', NULL, NULL),
('85af790a55f25c2830f39af828acfc63', 'Sisa Kas 0006 Office Minggu III	', '2023-06-27', '8f3cf527968bedc080c97d2018a6c24e', 1, 2, 1, 'Kilah', '1.000', '-167980', '2023-07-24 11:31:44', NULL, NULL),
('869e3e7e6d46feeea6a56b3b71c92c13', 'Steker', '2023-08-06', '3547c529c6f4417ff6bbef9f58900052', 5, 2, 1, 'Pak Arif', '2.000', '10000', '0000-00-00 00:00:00', NULL, NULL),
('8a2ff06bf75754803eaedf127d98a176', 'dana', '2023-06-04', 'b4d7666306bacee0d512dca40c348cf7', 8, 2, 2, '-', '1.000', '28009199', '2023-07-24 16:39:59', NULL, NULL),
('8b0d558906396b568f7f8ba8ff585b0c', 'dana', '2023-06-15', '34573e9e35eab6ca872a796c1e81000d', 3, 2, 2, '-', '1.000', '150000', '2023-07-24 16:27:14', NULL, NULL),
('8ca613fb4b10dd2978ef005445c17eb4', 'Gesek Visik Fortuner', '2023-06-06', 'b4d7666306bacee0d512dca40c348cf7', 5, 2, 1, 'Bu Lina', '1.000', '50000', '2023-07-18 09:38:53', '2023-07-18 14:31:28', NULL),
('8cd6e17ef022145dc61cdd2917ff6bd9', 'Kas Batam Minggu 1', '2023-08-08', '3547c529c6f4417ff6bbef9f58900052', 1, 2, 1, 'Mbak Ike', '1.000', '4251000', '0000-00-00 00:00:00', NULL, NULL),
('8d7ff1760d3181dbea38bc1851084ed0', 'KAS 0006 Office Juni Minggu ke II', '2023-06-15', '34573e9e35eab6ca872a796c1e81000d', 1, 2, 2, 'Bu Ike', '1.000', '1261943', '2023-07-24 09:59:11', NULL, NULL),
('8e7fe332dd1e01758a914b802de91efc', 'Senter Power 138290-00 Luby', '2023-08-18', '3547c529c6f4417ff6bbef9f58900052', 5, 2, 1, 'Mas Yosin', '1.000', '29520', '0000-00-00 00:00:00', NULL, NULL),
('93e9996e0986b80ee3152be14e3b9d1b', 'Sisa Kas 0006 Office Minggu II', '2023-06-19', '2edf12dbd56bf3a501415f56fdad6be5', 1, 2, 2, 'Kilah', '1.000', '-70700', '2023-07-24 10:11:54', '2023-07-24 11:29:26', '2023-07-24 11:29:26'),
('9ea47590e038c434844217a0ba7a1609', 'BPJS Kesehatan Batam', '2023-06-04', 'b4d7666306bacee0d512dca40c348cf7', 8, 2, 1, 'Bu Lina', '1.000', '6863034', '2023-07-24 16:39:59', NULL, NULL),
('a1e9d6c50b9ebb1dfb98af987172b3fe', 'Bak Sampah', '2023-06-09', 'b4d7666306bacee0d512dca40c348cf7', 7, 1, 1, 'Bu Ike', '1.000', '30000', '2023-07-22 10:22:00', NULL, NULL),
('a216941aee78d318734aca6a75a4e8c6', 'Uang Makan Tukang Minggu 1 (1-10 Juni 2023)', '2023-06-18', 'b4d7666306bacee0d512dca40c348cf7', 3, 1, 1, 'Pak Fitri', '1.000', '540000', '2023-07-22 10:22:59', NULL, NULL),
('a60ec7f8e77360d1b8da761b4a0cefaa', 'Materai 10.000', '2023-06-15', '34573e9e35eab6ca872a796c1e81000d', 2, 2, 1, 'Bu Lina', '6.000', '11000', '2023-07-24 14:35:42', NULL, NULL),
('a610ea75712c3b3897ced992acefe402', 'Token Listrik', '2023-06-15', '34573e9e35eab6ca872a796c1e81000d', 10, 2, 1, 'Bu Lina', '1.000', '503000', '2023-07-24 14:27:15', NULL, NULL),
('a6832135581135e4e638291c0e20e898', 'masker', '2023-06-15', '34573e9e35eab6ca872a796c1e81000d', 12, 2, 1, 'Bu Lina', '1.000', '17500', '2023-07-24 14:48:26', NULL, NULL),
('a7a379cf6d573805b8164eb150a36087', 'Sisa Kas 0006 Office Minggu I	', '2023-06-12', '34573e9e35eab6ca872a796c1e81000d', 1, 2, 1, 'Kilah', '1.000', '-236943', '2023-07-24 11:26:05', NULL, NULL),
('a7e6ea70b1208239c35b72d40e9df958', 'dana', '2023-06-08', 'b4d7666306bacee0d512dca40c348cf7', 10, 2, 2, '-', '1.000', '1600000', '2023-07-24 16:41:28', NULL, NULL),
('ab8b7ee1f778f8d6d85866eef307cac9', 'Grab Berry Kantor- Medokan Semampir', '2023-06-14', '34573e9e35eab6ca872a796c1e81000d', 1, 2, 1, 'Bery', '1.000', '13500', '2023-07-24 14:16:01', '2023-07-24 14:17:59', '2023-07-24 14:17:59'),
('adffd4400435e0948e123abe074a64b5', 'Sisa Kas 0006 Office Minggu I', '2023-06-12', '34573e9e35eab6ca872a796c1e81000d', 1, 2, 2, 'Kilah', '1.000', '-236943', '2023-07-24 09:59:11', '2023-07-24 11:26:13', '2023-07-24 11:26:13'),
('ae9081b7655132331758dcd288fd49ec', 'Cleo Galon', '2023-06-09', 'b4d7666306bacee0d512dca40c348cf7', 3, 2, 1, 'Kilah', '3.000', '20000', '2023-07-18 10:18:49', '2023-07-18 14:31:28', NULL),
('afe29747a7711a7866df6e72fcaecd3f', 'Parkir Stasiun Gubeng', '2023-06-08', 'b4d7666306bacee0d512dca40c348cf7', 5, 2, 1, 'Berry', '1.000', '6000', '2023-07-18 09:38:53', '2023-07-18 14:31:28', NULL),
('b00e5de7e7b0bde84f5d5fac0ab536ff', 'Pembelian hotel di Palembang Mas Alfan', '2023-08-24', '7b40fc6ce51e645f5d570292523cc35c', 14, 1, 1, 'Ike', '1.000', '206769', '0000-00-00 00:00:00', NULL, NULL),
('b1bd0a8d810b3ccdeb45a8afaa26884c', 'Gula', '2023-06-15', '34573e9e35eab6ca872a796c1e81000d', 7, 2, 1, 'Bu Lina', '1.000', '12500', '2023-07-24 14:24:21', NULL, NULL),
('b2829598a36336939121a875ff7b8021', 'Cet/poles total mobil fortuner', '2023-06-17', 'b4d7666306bacee0d512dca40c348cf7', 5, 1, 1, 'Pak Fitri', '1.000', '1000000', '2023-07-22 10:19:39', '2023-07-22 10:20:10', NULL),
('b3852f61bba50da3d48548efdbe0c955', 'KAS minggu 3 Agustus 2023', '2023-08-24', '3547c529c6f4417ff6bbef9f58900052', 1, 2, 1, 'Mas Hari', '1.000', '1970500', '0000-00-00 00:00:00', NULL, NULL),
('b5ff72fb7782b76e2500092f95830535', 'Cleo Galon', '2023-06-24', '2edf12dbd56bf3a501415f56fdad6be5', 3, 2, 1, 'Berry', '3.000', '20000', '2023-07-24 16:10:27', NULL, NULL),
('b69c69d70d3b6f6e1d5e340a8e35c3a0', 'BPJS TK Batam', '2023-06-04', 'b4d7666306bacee0d512dca40c348cf7', 8, 2, 1, 'Bu Lina', '1.000', '10377925', '2023-07-24 16:39:59', NULL, NULL),
('b6ee6cd8d64c7ca44120f31e2608df0e', 'dana', '2023-06-28', '8f3cf527968bedc080c97d2018a6c24e', 2, 2, 2, '-', '1.000', '100000', '2023-07-24 16:46:14', NULL, NULL),
('b735b448c3ffad8c8246f39251a3ef9e', 'dana masuk', '2023-06-23', '2edf12dbd56bf3a501415f56fdad6be5', 2, 2, 2, '-', '1.000', '150000', '2023-07-24 16:20:02', NULL, NULL),
('b84805673e6893c73e82207ae2b8579a', 'Dana ATK', '2023-07-13', 'b4d7666306bacee0d512dca40c348cf7', 2, 2, 2, 'mbak Ike', '1.000', '200000', '2023-07-18 16:55:03', '2023-11-14 11:44:49', NULL),
('b877ae6b75fa029677faafd9c0b8f809', 'Pembelian Tiket Tugas SRG-BTH P. Arief', '2023-08-15', '7b40fc6ce51e645f5d570292523cc35c', 14, 1, 1, 'P.Fitri', '1.000', '1974000', '0000-00-00 00:00:00', NULL, NULL),
('ba0263783143c013ab4c26c59692bf92', 'Sisa KAS 0007 Commisioning Semarang Minggu Ke IV Juli', '2023-08-01', '3547c529c6f4417ff6bbef9f58900052', 1, 2, 1, 'Mas Hari', '1.000', '090100', '0000-00-00 00:00:00', NULL, NULL),
('bb62693f076c845b88d1544b2d961eac', 'Materai', '2023-06-02', 'b4d7666306bacee0d512dca40c348cf7', 2, 2, 1, 'Kilah', '10.000', '10000', '2023-07-18 10:23:22', '2023-07-18 14:31:28', NULL),
('be199c48b91298e75671a472e85c2e16', 'Sisa Kas Office Mei 2023	', '2023-05-31', 'b4d7666306bacee0d512dca40c348cf7', 1, 2, 2, 'Kilah', '1.000', '-719340', '2023-07-24 11:34:44', NULL, NULL),
('c00379dc369ccf8cc2e4c23c3d2c8611', 'dana pantry', '2023-06-14', 'b4d7666306bacee0d512dca40c348cf7', 7, 2, 2, 'mbak Ike', '1.000', '400000', '2023-07-21 10:50:42', NULL, NULL),
('c12b46a5ac4b2dd61b28f713976b3a27', 'KAS 0006 Office Juni Minggu ke III', '2023-06-22', '2edf12dbd56bf3a501415f56fdad6be5', 1, 2, 2, 'Bu Ike', '1.000', '1190700', '2023-07-24 10:11:54', '2023-07-24 10:15:09', NULL),
('c1338b0ef6c85a418bca8920cbf510d3', 'BPJS FPT Juni 2023', '2023-06-04', 'b4d7666306bacee0d512dca40c348cf7', 1, 2, 2, 'Bu Lina', '1.000', '28009199', '2023-07-18 09:21:50', '2023-07-24 11:23:55', NULL),
('c1871f8853d915cf0513990d843eec55', 'Tang', '2023-08-14', '3547c529c6f4417ff6bbef9f58900052', 5, 2, 1, 'Mas Yosin', '1.000', '35000', '0000-00-00 00:00:00', NULL, NULL),
('c2a4b9e7019c8c6503321b82622b3503', 'Sisa KAS Office Juli 2023', '2023-08-01', '3547c529c6f4417ff6bbef9f58900052', 1, 2, 1, 'Bu Lina', '1.000', '045300', '0000-00-00 00:00:00', NULL, NULL),
('c36bc979d0130fd238ee1093011f1cfa', 'Pembelian Tiket Cuti BTH-SUB P. Yogi', '2023-08-04', '7b40fc6ce51e645f5d570292523cc35c', 14, 1, 1, 'P.Fitri', '1.000', '1363500', '0000-00-00 00:00:00', NULL, NULL),
('c3e39e4b308010fcbe00c49362f2fc49', 'Cuci Kering Setrika', '2023-06-12', '34573e9e35eab6ca872a796c1e81000d', 4, 2, 1, 'Berry', '1.000', '28000', '2023-07-24 14:27:15', NULL, NULL),
('c5af5b0ae6430580f519366d98ade2ca', 'Grab Berry Kantor- Medokan Semampir	', '2023-06-14', '34573e9e35eab6ca872a796c1e81000d', 5, 2, 1, 'Bery', '1.000', '13500', '2023-07-24 14:17:52', NULL, NULL),
('c5b383b3b7c70560a2bb51ea80a94f58', 'Pembelian Tiket Tugas SMC-SBI Kuli FO Semarang', '2023-08-19', '7b40fc6ce51e645f5d570292523cc35c', 14, 1, 1, 'P.Fitri', '4.000', '117750', '0000-00-00 00:00:00', NULL, NULL),
('c5bab707562ca51f1746662d3b35c42a', 'Parkir Notaris', '2023-06-16', '2edf12dbd56bf3a501415f56fdad6be5', 5, 2, 1, 'Bu Lina', '1.000', '5000', '2023-07-24 15:15:02', NULL, NULL),
('c8d088928ae01798f2c9cab2b1f708ed', 'Pertalite Mobil CRV', '2023-06-08', 'b4d7666306bacee0d512dca40c348cf7', 5, 2, 1, 'Berry', '1.000', '100000', '2023-07-18 09:38:53', '2023-07-18 14:31:28', NULL),
('c9a82c24b988053e201fc13d27304ceb', 'Pembelian Tiket Tugas SGU-SMT Mas Yunus ', '2023-08-11', '7b40fc6ce51e645f5d570292523cc35c', 14, 1, 1, 'P.Fitri', '1.000', '299500', '0000-00-00 00:00:00', NULL, NULL),
('cbfe7f274968cc0b5867a66a71e7cad7', 'Paku Pinus', '2023-08-02', '3547c529c6f4417ff6bbef9f58900052', 5, 2, 1, 'Mas Tiko', '2.000', '2000', '0000-00-00 00:00:00', NULL, NULL),
('cd1fcdbc4a1dada590ea81896657c368', 'Gergaji Besi', '2023-08-08', '3547c529c6f4417ff6bbef9f58900052', 5, 2, 1, 'Mas Yosin', '3.000', '6000', '0000-00-00 00:00:00', NULL, NULL),
('d6373cf939b3a041eb28969e4bd86e1c', 'Cuci Kering Setrika', '2023-06-14', '34573e9e35eab6ca872a796c1e81000d', 4, 2, 1, 'Berry', '1.000', '15000', '2023-07-24 14:27:15', NULL, NULL),
('d6bb92bde072be6fd52ac4840bedac3d', 'Sisa Kas Office Mei 2023', '2023-05-31', 'b4d7666306bacee0d512dca40c348cf7', 1, 2, 1, 'Kilah', '1.000', '-719340', '2023-07-18 09:21:50', '2023-07-24 11:34:54', '2023-07-24 11:34:54'),
('d6f02ebf737e674898c302dff502aeea', 'KAS LUAR RAB Tj Uncang Batam AGUSTUS 2023', '2023-08-09', '3547c529c6f4417ff6bbef9f58900052', 1, 2, 1, 'Pak Fitri', '1.000', '33892000', '0000-00-00 00:00:00', NULL, NULL),
('d7153e642a7e0ad83edc4e1a50eaf206', 'Pembelian Tiket Tugas SRG-BTH P. Burhan', '2023-08-30', '7b40fc6ce51e645f5d570292523cc35c', 14, 1, 1, 'P.Fitri', '1.000', '1590130', '0000-00-00 00:00:00', NULL, NULL),
('d91c9793b9f319ad9b8215e7c95fa91c', 'Pembelian Tiket Tugas SUB-BTH Mas Yunus & P. Abu', '2023-08-06', '7b40fc6ce51e645f5d570292523cc35c', 14, 1, 1, 'P.Fitri', '2.000', '1482000', '0000-00-00 00:00:00', NULL, NULL),
('ddb7d33154e9b04beb593d30d85badf7', 'Pembelian Tiket Kereta Tugas KPT-ME Mas Alfan', '2023-08-24', '7b40fc6ce51e645f5d570292523cc35c', 14, 1, 1, 'Ike', '1.000', '188500', '0000-00-00 00:00:00', NULL, NULL),
('ddea37f9f6bd66f69e30a4619a5f335d', 'Token Listrik', '2023-06-28', '8f3cf527968bedc080c97d2018a6c24e', 10, 2, 1, 'Bu Lina', '1.000', '503000', '2023-07-24 16:47:06', NULL, NULL),
('decba7d10507311973cbc53d11257257', 'Parkir Indomaret', '2023-06-08', 'b4d7666306bacee0d512dca40c348cf7', 5, 2, 1, 'Berry', '1.000', '10000', '2023-07-18 09:38:53', '2023-07-18 14:31:28', NULL),
('e0981206a5ac67fc535f6f03fd8554bb', 'dana', '2023-06-28', '8f3cf527968bedc080c97d2018a6c24e', 4, 2, 2, '-', '1.000', '25000', '2023-07-24 16:47:40', NULL, NULL),
('e151e85f7e3f9b621736f2fe483dd305', 'Tinta Brother Yellow ', '2023-06-23', '2edf12dbd56bf3a501415f56fdad6be5', 2, 2, 1, 'Bu Lina', '1.000', '98000', '2023-07-24 16:20:02', NULL, NULL),
('e1f705015262e18db16d195b6a5e18dc', 'Sisa Kas 0006 Office Minggu II	', '2023-06-19', '2edf12dbd56bf3a501415f56fdad6be5', 1, 2, 1, 'Kilah', '1.000', '70700', '2023-07-24 11:27:24', '2023-07-24 11:29:29', '2023-07-24 11:29:29'),
('e2de2df1135cbd9e81de2e8516bef325', 'dana masuk', '2023-06-24', '2edf12dbd56bf3a501415f56fdad6be5', 3, 2, 2, '-', '1.000', '100000', '2023-07-24 16:12:32', NULL, NULL),
('e2f2fe30e5053629291e369d69673899', 'Sticky notes, klip kertas, binder klip,dll.', '2023-06-15', '34573e9e35eab6ca872a796c1e81000d', 2, 2, 1, 'Bu Lina', '1.000', '183200', '2023-07-24 14:35:42', NULL, NULL),
('e4d3bb6b51db080ba9e6da01ab2323a3', 'Pertalite Mio', '2023-06-23', '2edf12dbd56bf3a501415f56fdad6be5', 5, 2, 1, 'Bu Lina', '1.000', '20000', '2023-07-24 15:15:02', NULL, NULL),
('e62360156be84fe66e97195c08be26a5', 'Philips Paket 12w', '2023-06-09', 'b4d7666306bacee0d512dca40c348cf7', 7, 1, 1, 'Bu Ike', '1.000', '160000', '2023-07-22 10:22:00', NULL, NULL),
('e7bfadc7a2bd2dd4b67f72760b3d797a', 'Pembelian Tiket Tugas SBI-SMC Kuli FO Semarang', '2023-08-02', '7b40fc6ce51e645f5d570292523cc35c', 14, 1, 1, 'Ike', '4.000', '56875', '0000-00-00 00:00:00', NULL, NULL),
('e8a0c9dfe21f480535ae955050e8313e', 'Le Mineral 330 ml ', '2023-06-24', '2edf12dbd56bf3a501415f56fdad6be5', 3, 2, 1, 'Berry', '1.000', '42000', '2023-07-24 16:10:27', NULL, NULL),
('e950351a302d828c1a15b4bfd36c89d4', 'Le Mineral 330 Ml', '2023-06-15', '34573e9e35eab6ca872a796c1e81000d', 3, 2, 1, 'Bu Lina', '1.000', '42000', '2023-07-24 14:24:21', NULL, NULL),
('ea1cebd13011b453a205f5fc1373c9c5', 'KAS 0006 Office Juni Minggu ke I', '2023-06-08', 'b4d7666306bacee0d512dca40c348cf7', 1, 2, 2, 'Bu Ike', '1.000', '2944340', '2023-07-18 09:21:50', '2023-07-24 11:33:19', NULL),
('ea23627360243d9ebdf203ec6aca102c', 'Paku 9 ons', '2023-06-09', 'b4d7666306bacee0d512dca40c348cf7', 6, 2, 1, 'Berry', '1.000', '20000', '2023-07-18 09:55:52', '2023-07-18 14:31:28', NULL),
('ea52075b4de31e7720025e81c2b6bca4', 'Pantry Juni 2023', '2023-06-08', 'b4d7666306bacee0d512dca40c348cf7', 7, 2, 1, 'Bu Lina', '1.000', '17500', '2023-07-18 10:28:13', '2023-07-18 14:31:28', NULL),
('eafbb89c2113d6092c81c1abd24efa55', 'Pembelian Tiket Tugas SUB-PLM Mas Alfan', '2023-08-24', '7b40fc6ce51e645f5d570292523cc35c', 14, 1, 1, 'P.Fitri', '1.000', '1454080', '0000-00-00 00:00:00', NULL, NULL),
('edae13cfcffee1162f9a2b7d2e46d703', 'KAS 0008 FO Semarang Minggu ke I Agustus', '2023-08-08', '3547c529c6f4417ff6bbef9f58900052', 1, 2, 1, 'Mas Yosin', '1.000', '2801850', '0000-00-00 00:00:00', NULL, NULL),
('f0d88b334e0969628af2c79b08d75f00', 'Spuit 20 cc', '2023-06-23', '2edf12dbd56bf3a501415f56fdad6be5', 2, 2, 1, 'Bu Lina', '1.000', '2020', '2023-07-24 16:20:02', NULL, NULL),
('f1e383b1e5b4cb0fc3a5d9aa8c8232d1', 'Parkir Notaris', '2023-06-20', '2edf12dbd56bf3a501415f56fdad6be5', 5, 2, 1, 'Bu Lina', '1.000', '5000', '2023-07-24 15:15:02', NULL, NULL),
('f1e65b9fdbf40347be8bfb8bd0e6962d', 'Bubble Wrap', '2023-06-23', '2edf12dbd56bf3a501415f56fdad6be5', 2, 2, 1, 'Bu Lina', '1.000', '2020', '2023-07-24 16:20:02', NULL, NULL),
('f29595e6e29490208be76b1c9d4a0b79', 'Pantry Juni 2023', '2023-06-08', 'b4d7666306bacee0d512dca40c348cf7', 7, 2, 1, 'Bu Lina', '1.000', '411065', '2023-07-18 10:28:13', '2023-07-18 14:31:28', NULL),
('f3a71557355d3999dc5f7c082d325828', 'Kirim Dokumen (Inv. DP&Pelunasan) PT. Mucoindo', '2023-06-07', 'b4d7666306bacee0d512dca40c348cf7', 9, 2, 1, 'Kilah', '1.000', '12000', '2023-07-24 16:42:31', NULL, NULL),
('f7a10bf176ce9d280aa1eb4526ff92f7', 'dana', '2023-06-27', '8f3cf527968bedc080c97d2018a6c24e', 3, 2, 2, '-', '1.000', '150000', '2023-07-24 16:44:51', NULL, NULL),
('f97551403ce3f704e5915159b3fb1f0a', 'Parkir Remaja', '2023-06-08', 'b4d7666306bacee0d512dca40c348cf7', 5, 2, 1, 'Berry', '1.000', '10000', '2023-07-18 09:38:53', '2023-07-18 14:31:28', NULL),
('faae1d7e558fb61a0ebd925d139507a5', 'KAS Office Minggu 4 Agustus 2023', '2023-08-30', '3547c529c6f4417ff6bbef9f58900052', 1, 2, 1, 'Bu Lina', '1.000', '1144440', '0000-00-00 00:00:00', NULL, NULL),
('fad83f9bb5ea901f5b859a1099892de5', 'data 181', '2023-07-17', 'b4d7666306bacee0d512dca40c348cf7', 3, 1, 1, 'user21', '331.000', '441', '2023-07-17 10:47:48', '2023-07-18 14:31:28', '2023-07-18 09:17:39'),
('fc4ccb912503ef74518218f58fd0dd74', 'KAS 0006 Office Juni Minggu ke IV', '2023-06-28', '8f3cf527968bedc080c97d2018a6c24e', 1, 2, 2, 'Bu Ike', '1.000', '1367980', '2023-07-24 10:14:01', NULL, NULL),
('fd82b2e224ee4348445e8ca2114945a1', 'dana', '2023-06-15', '34573e9e35eab6ca872a796c1e81000d', 2, 2, 2, '-', '1.000', '150000', '2023-07-24 16:27:14', NULL, NULL),
('ff3deebc416574fdb615209e1dff2ee1', 'Sisa Kas 0006 Office Minggu III', '2023-06-27', '8f3cf527968bedc080c97d2018a6c24e', 1, 2, 2, 'Kilah', '1.000', '-167980', '2023-07-24 10:14:01', '2023-07-24 11:31:51', '2023-07-24 11:31:51');

-- --------------------------------------------------------

--
-- Table structure for table `fki_data_kas`
--

CREATE TABLE `fki_data_kas` (
  `id_data_kas` varchar(255) NOT NULL,
  `nama_data_kas` varchar(100) NOT NULL,
  `tgl_add` datetime NOT NULL DEFAULT current_timestamp(),
  `tgl_update` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `tgl_delete` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fki_data_kas`
--

INSERT INTO `fki_data_kas` (`id_data_kas`, `nama_data_kas`, `tgl_add`, `tgl_update`, `tgl_delete`) VALUES
('6961553d51c4c0ad578ae37a10b4604e', 'AGUSTUS 2023', '2023-07-31 16:22:19', NULL, NULL),
('871239cfa66095455d91954fd254adf1', 'Juni 2023', '2023-07-12 14:48:11', '2023-07-18 09:12:28', NULL),
('9907e4f1db40926d1cfc9b0fc66d7fb8', 'Mei 2023', '2023-07-17 11:26:04', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fki_kas_tipe`
--

CREATE TABLE `fki_kas_tipe` (
  `id_kas_tipe` varchar(255) NOT NULL,
  `id_tipe` varchar(255) NOT NULL,
  `id_minggu` varchar(255) NOT NULL,
  `tgl_add` datetime NOT NULL DEFAULT current_timestamp(),
  `tgl_update` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `tgl_delete` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `fki_minggu`
--

CREATE TABLE `fki_minggu` (
  `id_minggu` varchar(255) NOT NULL,
  `nama_minggu` varchar(40) NOT NULL,
  `id_lokasi` varchar(255) NOT NULL COMMENT 'konek ke fai_lokasi',
  `id_data_kas` varchar(255) NOT NULL,
  `dana_pengajuan` decimal(15,0) NOT NULL,
  `tgl_add` datetime NOT NULL DEFAULT current_timestamp(),
  `tgl_update` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `tgl_delete` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fki_minggu`
--

INSERT INTO `fki_minggu` (`id_minggu`, `nama_minggu`, `id_lokasi`, `id_data_kas`, `dana_pengajuan`, `tgl_add`, `tgl_update`, `tgl_delete`) VALUES
('2edf12dbd56bf3a501415f56fdad6be5', 'Minggu 3', 'f5859c122e621de2dfc7da86dbda2497', '871239cfa66095455d91954fd254adf1', '0', '2023-07-24 10:10:20', '2023-08-10 16:05:13', NULL),
('34573e9e35eab6ca872a796c1e81000d', 'Minggu 2', 'f5859c122e621de2dfc7da86dbda2497', '871239cfa66095455d91954fd254adf1', '3500020', '2023-07-13 14:25:13', '2023-08-10 16:05:24', NULL),
('3547c529c6f4417ff6bbef9f58900052', 'Minggu 1', 'f5859c122e621de2dfc7da86dbda2497', '9907e4f1db40926d1cfc9b0fc66d7fb8', '0', '2023-10-21 09:14:03', NULL, NULL),
('7b40fc6ce51e645f5d570292523cc35c', 'Minggu 2', 'f5859c122e621de2dfc7da86dbda2497', '9907e4f1db40926d1cfc9b0fc66d7fb8', '0', '2023-10-21 09:58:43', NULL, NULL),
('8f3cf527968bedc080c97d2018a6c24e', 'Minggu 4', 'f5859c122e621de2dfc7da86dbda2497', '871239cfa66095455d91954fd254adf1', '0', '2023-07-24 10:12:57', '2023-08-10 16:05:07', NULL),
('b4d7666306bacee0d512dca40c348cf7', 'Minggu 1', 'f5859c122e621de2dfc7da86dbda2497', '871239cfa66095455d91954fd254adf1', '3000000', '2023-07-13 14:08:09', '2023-08-10 16:05:28', NULL),
('e8e6fa1571d9d0de440e323ce4ed8994', 'Minggu 1', 'f5859c122e621de2dfc7da86dbda2497', '6961553d51c4c0ad578ae37a10b4604e', '0', '2023-07-31 16:22:41', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fki_nota`
--

CREATE TABLE `fki_nota` (
  `id_nota` varchar(255) NOT NULL,
  `id_minggu` varchar(255) NOT NULL,
  `id_tipe` varchar(255) NOT NULL,
  `tgl_add` datetime NOT NULL DEFAULT current_timestamp(),
  `tgl_update` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `tgl_delete` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fki_nota`
--

INSERT INTO `fki_nota` (`id_nota`, `id_minggu`, `id_tipe`, `tgl_add`, `tgl_update`, `tgl_delete`) VALUES
('0c8906fb4342f496b1dd39fb499cc79c', 'b4d7666306bacee0d512dca40c348cf7', '1', '2023-08-03 16:30:41', '2023-08-04 08:57:00', NULL),
('44a9d487e6b44a94d972af71985296e3', 'b4d7666306bacee0d512dca40c348cf7', '3', '2023-08-03 16:32:08', '2023-08-04 09:35:57', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fki_tipe`
--

CREATE TABLE `fki_tipe` (
  `id_tipe` int(5) NOT NULL,
  `nama_tipe` varchar(50) NOT NULL,
  `tgl_add` datetime NOT NULL DEFAULT current_timestamp(),
  `tgl_update` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `tgl_delete` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fki_tipe`
--

INSERT INTO `fki_tipe` (`id_tipe`, `nama_tipe`, `tgl_add`, `tgl_update`, `tgl_delete`) VALUES
(1, 'KAS', '2023-07-11 13:59:38', NULL, NULL),
(2, 'ATK', '2023-07-11 13:59:38', NULL, NULL),
(3, 'MAKANAN/MINUMAN', '2023-07-11 14:00:14', NULL, NULL),
(4, 'LAUNDRY', '2023-07-11 14:00:14', NULL, NULL),
(5, 'TRANSPORTASI / TOLL', '2023-07-17 11:18:56', '2023-08-01 08:33:08', NULL),
(6, 'ALAT', '2023-07-18 09:45:15', NULL, NULL),
(7, 'PANTRY', '2023-07-18 09:45:15', NULL, NULL),
(8, 'BPJS', '2023-07-18 09:45:59', NULL, NULL),
(9, 'EKSPEDISI', '2023-07-18 09:45:59', NULL, NULL),
(10, 'LISTRIK, AIR & INTERNET								', '2023-07-18 09:50:19', NULL, NULL),
(11, 'TES 12', '2023-07-18 13:54:50', '2023-07-18 14:17:06', '2023-07-18 14:17:06'),
(12, 'KESEHATAN', '2023-07-24 14:35:58', NULL, NULL),
(13, 'ADMINISTRASI DAN UMUM', '2023-07-24 16:48:22', NULL, NULL),
(14, 'PERJALANAN DINAS', '2023-10-21 09:58:19', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fma_barang`
--

CREATE TABLE `fma_barang` (
  `id_barang` varchar(255) NOT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `tgl_pembelian` date DEFAULT NULL,
  `qty_asli` decimal(15,2) NOT NULL,
  `qty_sisa` decimal(15,2) NOT NULL,
  `id_lokasi` varchar(255) NOT NULL COMMENT 'lokasi tempat simpan barang/asset',
  `kondisi_barang` smallint(2) NOT NULL COMMENT '1-baik, 2-rusak',
  `id_user` varchar(255) NOT NULL COMMENT 'user yg mendaftarkan barang',
  `tgl_add` datetime NOT NULL DEFAULT current_timestamp(),
  `tgl_update` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `tgl_delete` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fma_barang`
--

INSERT INTO `fma_barang` (`id_barang`, `nama_barang`, `tgl_pembelian`, `qty_asli`, `qty_sisa`, `id_lokasi`, `kondisi_barang`, `id_user`, `tgl_add`, `tgl_update`, `tgl_delete`) VALUES
('2501e416315ff1063366baa921cdb7a1', 'Barang 12', NULL, '13.05', '13.05', 'f5859c122e621de2dfc7da86dbda2497', 1, '4bc0c527a7c2a9053450a7fb8f92746f', '2023-11-03 13:39:55', '2023-11-09 15:20:35', NULL),
('2d52d701372e14fe8258b90ff4ca7507', 'Barang 4', NULL, '20.00', '20.00', 'f5859c122e621de2dfc7da86dbda2497', 1, '4bc0c527a7c2a9053450a7fb8f92746f', '2023-11-11 10:19:09', '2023-11-11 10:19:25', NULL),
('befac8ebff9515919338ea7a2070b697', 'Barang 2', '2023-11-01', '10.00', '10.00', 'f5859c122e621de2dfc7da86dbda2497', 1, '4bc0c527a7c2a9053450a7fb8f92746f', '2023-11-06 09:37:02', '2023-11-13 11:51:53', NULL),
('f348eb219758897b11099ec7249ba727', 'Tiang Besi (pcs)', '2023-11-13', '50.00', '50.00', 'f5859c122e621de2dfc7da86dbda2497', 1, '4bc0c527a7c2a9053450a7fb8f92746f', '2023-11-13 09:54:46', '2023-11-13 14:02:30', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fma_permission`
--

CREATE TABLE `fma_permission` (
  `id_permission` int(10) NOT NULL,
  `id_user` varchar(255) NOT NULL,
  `id_menu` varchar(40) NOT NULL COMMENT 'huruf kecil semua',
  `tgl_add` datetime NOT NULL DEFAULT current_timestamp(),
  `tgl_update` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `tgl_delete` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fma_permission`
--

INSERT INTO `fma_permission` (`id_permission`, `id_user`, `id_menu`, `tgl_add`, `tgl_update`, `tgl_delete`) VALUES
(11, 'ab6af1532a5c53c0a48ceede821ce6fa', 'kas', '2023-11-22 11:40:42', NULL, NULL),
(12, 'ab6af1532a5c53c0a48ceede821ce6fa', 'kas_tipe', '2023-11-22 11:40:42', NULL, NULL),
(13, 'ab6af1532a5c53c0a48ceede821ce6fa', 'monitoring_bayar', '2023-11-22 11:40:42', NULL, NULL),
(14, 'ab6af1532a5c53c0a48ceede821ce6fa', 'monitoring_riwayat_bayar', '2023-11-22 11:40:42', NULL, NULL),
(26, '4bc0c527a7c2a9053450a7fb8f92746f', 'kas', '2023-11-22 16:02:17', NULL, NULL),
(27, '4bc0c527a7c2a9053450a7fb8f92746f', 'kas_tipe', '2023-11-22 16:02:17', NULL, NULL),
(28, '4bc0c527a7c2a9053450a7fb8f92746f', 'aset_pinjam', '2023-11-22 16:02:17', NULL, NULL),
(29, '4bc0c527a7c2a9053450a7fb8f92746f', 'aset', '2023-11-22 16:02:17', NULL, NULL),
(30, '4bc0c527a7c2a9053450a7fb8f92746f', 'aset_kembali', '2023-11-22 16:02:17', NULL, NULL),
(31, '4bc0c527a7c2a9053450a7fb8f92746f', 'monitoring_bayar', '2023-11-22 16:02:17', NULL, NULL),
(32, '4bc0c527a7c2a9053450a7fb8f92746f', 'monitoring_riwayat_bayar', '2023-11-22 16:02:17', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fma_pinjam`
--

CREATE TABLE `fma_pinjam` (
  `id_pinjam` varchar(255) NOT NULL,
  `id_barang` varchar(255) NOT NULL,
  `qty_pinjam` decimal(15,2) NOT NULL,
  `tgl_pinjam` date NOT NULL,
  `tgl_kembali` date DEFAULT NULL,
  `status` tinyint(1) NOT NULL COMMENT '1-pending pinjam;2-pinjam;3-pending selesai;4-selesai/kembali',
  `kondisi_barang_asal` tinyint(1) NOT NULL COMMENT '1-baik, 2-rusak',
  `kondisi_barang_kembali` tinyint(1) NOT NULL COMMENT '1-baik, 2-rusak',
  `id_lokasi` varchar(255) NOT NULL COMMENT 'lokasi barang dipakai',
  `id_user` varchar(255) NOT NULL COMMENT 'user PIC/ peminjam',
  `id_admin` varchar(255) DEFAULT NULL COMMENT 'id_user yg acc peminjaman',
  `tgl_add` datetime NOT NULL DEFAULT current_timestamp(),
  `tgl_update` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `tgl_delete` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fma_pinjam`
--

INSERT INTO `fma_pinjam` (`id_pinjam`, `id_barang`, `qty_pinjam`, `tgl_pinjam`, `tgl_kembali`, `status`, `kondisi_barang_asal`, `kondisi_barang_kembali`, `id_lokasi`, `id_user`, `id_admin`, `tgl_add`, `tgl_update`, `tgl_delete`) VALUES
('006d0e4165fc78540281780bfc8ca887', 'f348eb219758897b11099ec7249ba727', '10.00', '2023-11-13', '2023-11-13', 4, 1, 2, 'bac9ed7276e1034d458d97cfd3445e0c', '4bc0c527a7c2a9053450a7fb8f92746f', '4bc0c527a7c2a9053450a7fb8f92746f', '2023-11-13 13:48:24', '2023-11-13 14:02:30', NULL),
('137e314aecbcb4ae542b24b37d1afc3c', '2501e416315ff1063366baa921cdb7a1', '2.00', '2023-11-11', '0000-00-00', 1, 1, 0, 'f5859c122e621de2dfc7da86dbda2497', '4bc0c527a7c2a9053450a7fb8f92746f', NULL, '2023-11-11 10:16:46', NULL, NULL),
('602d589ec95ca3f5c8aa9c8df6841e6c', 'befac8ebff9515919338ea7a2070b697', '3.00', '2023-11-10', '0000-00-00', 4, 1, 2, 'f5859c122e621de2dfc7da86dbda2497', '4bc0c527a7c2a9053450a7fb8f92746f', '4bc0c527a7c2a9053450a7fb8f92746f', '2023-11-10 08:44:05', '2023-11-13 11:51:53', NULL),
('8ec9c2cb3e49e648678325eb7c8b7195', 'befac8ebff9515919338ea7a2070b697', '1.00', '2023-11-08', '0000-00-00', 4, 1, 0, 'bac9ed7276e1034d458d97cfd3445e0c', '4bc0c527a7c2a9053450a7fb8f92746f', '4bc0c527a7c2a9053450a7fb8f92746f', '2023-11-08 09:30:32', '2023-11-13 11:06:21', NULL),
('a1553a61ae94cd5538621a06df416d6d', '2501e416315ff1063366baa921cdb7a1', '20.00', '2023-11-08', '0000-00-00', 1, 1, 0, 'f5859c122e621de2dfc7da86dbda2497', '4bc0c527a7c2a9053450a7fb8f92746f', '4bc0c527a7c2a9053450a7fb8f92746f', '2023-11-08 16:38:11', '2023-11-13 13:49:04', '2023-11-13 13:49:04');

-- --------------------------------------------------------

--
-- Table structure for table `fmp_project`
--

CREATE TABLE `fmp_project` (
  `id_project` varchar(255) NOT NULL,
  `nama_project` varchar(100) NOT NULL,
  `nomor_project` varchar(100) NOT NULL,
  `jenis_project` tinyint(1) NOT NULL COMMENT '1 - so ; 2 - po',
  `lokasi_project` varchar(100) NOT NULL,
  `nama_vendor` varchar(100) NOT NULL,
  `tgl_mulai` date NOT NULL,
  `durasi_project` int(11) NOT NULL COMMENT 'hari',
  `nominal_project` decimal(15,0) NOT NULL,
  `status_project` tinyint(3) NOT NULL COMMENT '1-rilis,2-selesai, lanjut bayar,3-selesai',
  `id_procurement` varchar(255) NOT NULL,
  `id_keu` varchar(255) DEFAULT NULL,
  `dokumen_project` varchar(40) DEFAULT NULL COMMENT 'ex : 1,2,3,4',
  `tgl_add` datetime NOT NULL DEFAULT current_timestamp(),
  `tgl_update` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `tgl_delete` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fmp_project`
--

INSERT INTO `fmp_project` (`id_project`, `nama_project`, `nomor_project`, `jenis_project`, `lokasi_project`, `nama_vendor`, `tgl_mulai`, `durasi_project`, `nominal_project`, `status_project`, `id_procurement`, `id_keu`, `dokumen_project`, `tgl_add`, `tgl_update`, `tgl_delete`) VALUES
('68c694b6bc2f70e4a3e69e8095728345', 'PRO 22', '222/222', 1, 'bac9ed7276e1034d458d97cfd3445e0c', 'PT BBB', '2023-11-21', 11, '12000000', 1, '4bc0c527a7c2a9053450a7fb8f92746f', NULL, NULL, '2023-11-21 11:27:59', '2023-11-21 15:08:27', NULL),
('a56d8ab3b6f77713e1ce69dfbf7a2969', 'pro 11', '111/222', 2, 'f5859c122e621de2dfc7da86dbda2497', 'PT AB', '2023-11-22', 20, '1100000', 3, '4bc0c527a7c2a9053450a7fb8f92746f', '4bc0c527a7c2a9053450a7fb8f92746f', NULL, '2023-11-21 09:34:34', '2023-11-22 16:06:43', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fsrmr_data`
--

CREATE TABLE `fsrmr_data` (
  `id_data` varchar(255) NOT NULL,
  `jenis_data` tinyint(1) NOT NULL COMMENT '1-SR; 2-MR',
  `nomor_data` int(11) NOT NULL,
  `tgl_data` date NOT NULL,
  `proyek_data` varchar(50) NOT NULL,
  `subject_data` varchar(50) NOT NULL,
  `customer_data` varchar(40) NOT NULL,
  `status_data` tinyint(1) NOT NULL COMMENT '1-dibuat;2-disetujui;3-cancel',
  `kode_proyek` varchar(20) NOT NULL,
  `id_user` varchar(255) NOT NULL COMMENT 'relasi fai_akun',
  `tgl_add` datetime NOT NULL DEFAULT current_timestamp(),
  `tgl_update` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `tgl_delete` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fsrmr_data`
--

INSERT INTO `fsrmr_data` (`id_data`, `jenis_data`, `nomor_data`, `tgl_data`, `proyek_data`, `subject_data`, `customer_data`, `status_data`, `kode_proyek`, `id_user`, `tgl_add`, `tgl_update`, `tgl_delete`) VALUES
('8bb407f7ec24b555a6168b691d61c063', 2, 2, '2023-10-18', 'tes222', 'tes11', 'a1', 1, 'SMG002', '4bc0c527a7c2a9053450a7fb8f92746f', '2023-10-17 10:47:03', NULL, NULL),
('ae9a57b8fd8939afb9a019b914ef92d5', 2, 1, '2023-08-22', 'tes', 'tes1', 'a12', 1, 'SMG002', '4bc0c527a7c2a9053450a7fb8f92746f', '2023-08-22 15:14:18', NULL, NULL),
('e0a98645aa80715fd2947da6012d1d1b', 2, 1, '2023-08-23', 'tes', 'tes1', 'a12', 1, 'SMG001', '4bc0c527a7c2a9053450a7fb8f92746f', '2023-08-22 15:09:37', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fsrmr_detail`
--

CREATE TABLE `fsrmr_detail` (
  `id_detail` varchar(255) NOT NULL,
  `id_data` varchar(255) NOT NULL,
  `deskripsi_data` varchar(100) NOT NULL,
  `spek_data` varchar(100) NOT NULL,
  `qty_data` decimal(15,2) NOT NULL,
  `satuan_data` varchar(10) NOT NULL,
  `estimasi_data` date DEFAULT NULL,
  `nominal_data` decimal(15,0) NOT NULL,
  `remark_data` varchar(100) DEFAULT NULL,
  `tgl_add` datetime NOT NULL DEFAULT current_timestamp(),
  `tgl_update` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `tgl_delete` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fsrmr_detail`
--

INSERT INTO `fsrmr_detail` (`id_detail`, `id_data`, `deskripsi_data`, `spek_data`, `qty_data`, `satuan_data`, `estimasi_data`, `nominal_data`, `remark_data`, `tgl_add`, `tgl_update`, `tgl_delete`) VALUES
('1dae489d634669e50bc3c480924d4ae8', '8bb407f7ec24b555a6168b691d61c063', 'b3', 'b3', '1.00', '', '2023-10-17', '0', '', '2023-10-17 10:47:03', NULL, NULL),
('31afe41fb2751d454ee9873025fe74b3', 'ae9a57b8fd8939afb9a019b914ef92d5', '1', '1', '1.00', '-', '2023-08-22', '1', '-', '2023-08-22 15:14:18', NULL, NULL),
('62beb821c9607c18bfaa84bbec4930ba', 'e0a98645aa80715fd2947da6012d1d1b', '4', '4', '4.00', 'ok', '2023-08-22', '0', '', '2023-08-22 15:09:37', NULL, NULL),
('6ca51dd7edee6e279e643a004d983283', 'e0a98645aa80715fd2947da6012d1d1b', '', '', '0.00', '', '0000-00-00', '0', '', '2023-08-22 15:09:37', NULL, NULL),
('87e6b7d50f42f4ca0253d4f4601b8c0f', 'e0a98645aa80715fd2947da6012d1d1b', '', '', '0.00', '', '0000-00-00', '0', '', '2023-08-22 15:09:37', NULL, NULL),
('8c1e78f4999547edbcf306dd8d3d44d7', 'e0a98645aa80715fd2947da6012d1d1b', '', '', '0.00', '', '0000-00-00', '0', '', '2023-08-22 15:09:37', NULL, NULL),
('93ec8dc02c549fbfb571d3ee91776ebb', 'e0a98645aa80715fd2947da6012d1d1b', '3', '3', '3.00', 'ok', '2023-08-22', '0', '', '2023-08-22 15:09:37', NULL, NULL),
('a2364a72d008b6f0b4dc0bf30b8a008a', 'ae9a57b8fd8939afb9a019b914ef92d5', '2', '2', '2.00', '-', '2023-08-22', '2', '-', '2023-08-22 15:14:18', NULL, NULL),
('ab148fb425b2239480f0cb496ab50ef1', 'ae9a57b8fd8939afb9a019b914ef92d5', '3', '3', '3.00', '-', '2023-08-22', '3', '-', '2023-08-22 15:14:18', NULL, NULL),
('b5c94ef942e19dc6273a6e4125387ebe', 'e0a98645aa80715fd2947da6012d1d1b', '', '', '0.00', '', '0000-00-00', '0', '', '2023-08-22 15:09:37', NULL, NULL),
('eb662d5dadfa3f16a1586a22842450fb', 'e0a98645aa80715fd2947da6012d1d1b', '1', '1', '1.00', 'ok', '2023-08-22', '0', '', '2023-08-22 15:09:37', NULL, NULL),
('ededde850edfd82488f4f7c230f23369', 'e0a98645aa80715fd2947da6012d1d1b', '2', '2', '2.00', 'ok', '2023-08-22', '0', '', '2023-08-22 15:09:37', NULL, NULL),
('fd00eca2d1412603d91442b8f82a3211', 'e0a98645aa80715fd2947da6012d1d1b', '', '', '0.00', '', '0000-00-00', '0', '', '2023-08-22 15:09:37', NULL, NULL),
('fe5ac166a49dbbd48601b4770be53bf1', 'e0a98645aa80715fd2947da6012d1d1b', '', '', '0.00', '', '0000-00-00', '0', '', '2023-08-22 15:09:37', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fai_absen`
--
ALTER TABLE `fai_absen`
  ADD PRIMARY KEY (`id_absen`);

--
-- Indexes for table `fai_akun`
--
ALTER TABLE `fai_akun`
  ADD PRIMARY KEY (`id_akun`);

--
-- Indexes for table `fai_akun_lokasi`
--
ALTER TABLE `fai_akun_lokasi`
  ADD PRIMARY KEY (`id_al`);

--
-- Indexes for table `fai_jabatan`
--
ALTER TABLE `fai_jabatan`
  ADD PRIMARY KEY (`id_jabatan`),
  ADD UNIQUE KEY `nama_jabatan` (`nama_jabatan`);

--
-- Indexes for table `fai_lembur`
--
ALTER TABLE `fai_lembur`
  ADD PRIMARY KEY (`id_lembur`);

--
-- Indexes for table `fai_libur`
--
ALTER TABLE `fai_libur`
  ADD PRIMARY KEY (`id_libur`);

--
-- Indexes for table `fai_log`
--
ALTER TABLE `fai_log`
  ADD PRIMARY KEY (`id_log`);

--
-- Indexes for table `fai_lokasi`
--
ALTER TABLE `fai_lokasi`
  ADD PRIMARY KEY (`id_lokasi`);

--
-- Indexes for table `fai_notif`
--
ALTER TABLE `fai_notif`
  ADD PRIMARY KEY (`id_notif`);

--
-- Indexes for table `fai_pending_detail`
--
ALTER TABLE `fai_pending_detail`
  ADD PRIMARY KEY (`id_pending`);

--
-- Indexes for table `fai_pengumuman`
--
ALTER TABLE `fai_pengumuman`
  ADD PRIMARY KEY (`id_pengumuman`);

--
-- Indexes for table `fesp32_data_esp`
--
ALTER TABLE `fesp32_data_esp`
  ADD PRIMARY KEY (`id_data_esp`);

--
-- Indexes for table `fesp32_esp`
--
ALTER TABLE `fesp32_esp`
  ADD PRIMARY KEY (`id_esp`);

--
-- Indexes for table `fesp32_log`
--
ALTER TABLE `fesp32_log`
  ADD PRIMARY KEY (`id_log`);

--
-- Indexes for table `fesp32_relasi_data`
--
ALTER TABLE `fesp32_relasi_data`
  ADD PRIMARY KEY (`id_relasi`);

--
-- Indexes for table `fesp32_user`
--
ALTER TABLE `fesp32_user`
  ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `fki_dana_pengajuan`
--
ALTER TABLE `fki_dana_pengajuan`
  ADD PRIMARY KEY (`id_dana_pengajuan`);

--
-- Indexes for table `fki_data`
--
ALTER TABLE `fki_data`
  ADD PRIMARY KEY (`id_data`);

--
-- Indexes for table `fki_data_kas`
--
ALTER TABLE `fki_data_kas`
  ADD PRIMARY KEY (`id_data_kas`),
  ADD UNIQUE KEY `nama_data_kas` (`nama_data_kas`);

--
-- Indexes for table `fki_kas_tipe`
--
ALTER TABLE `fki_kas_tipe`
  ADD PRIMARY KEY (`id_kas_tipe`);

--
-- Indexes for table `fki_minggu`
--
ALTER TABLE `fki_minggu`
  ADD PRIMARY KEY (`id_minggu`);

--
-- Indexes for table `fki_nota`
--
ALTER TABLE `fki_nota`
  ADD PRIMARY KEY (`id_nota`);

--
-- Indexes for table `fki_tipe`
--
ALTER TABLE `fki_tipe`
  ADD PRIMARY KEY (`id_tipe`);

--
-- Indexes for table `fma_barang`
--
ALTER TABLE `fma_barang`
  ADD PRIMARY KEY (`id_barang`);

--
-- Indexes for table `fma_permission`
--
ALTER TABLE `fma_permission`
  ADD PRIMARY KEY (`id_permission`);

--
-- Indexes for table `fma_pinjam`
--
ALTER TABLE `fma_pinjam`
  ADD PRIMARY KEY (`id_pinjam`);

--
-- Indexes for table `fmp_project`
--
ALTER TABLE `fmp_project`
  ADD PRIMARY KEY (`id_project`);

--
-- Indexes for table `fsrmr_data`
--
ALTER TABLE `fsrmr_data`
  ADD PRIMARY KEY (`id_data`);

--
-- Indexes for table `fsrmr_detail`
--
ALTER TABLE `fsrmr_detail`
  ADD PRIMARY KEY (`id_detail`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fki_dana_pengajuan`
--
ALTER TABLE `fki_dana_pengajuan`
  MODIFY `id_dana_pengajuan` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `fki_tipe`
--
ALTER TABLE `fki_tipe`
  MODIFY `id_tipe` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `fma_permission`
--
ALTER TABLE `fma_permission`
  MODIFY `id_permission` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
