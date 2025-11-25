-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 25, 2025 at 02:15 PM
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
-- Database: `perpus`
--

-- --------------------------------------------------------

--
-- Table structure for table `buku`
--

CREATE TABLE `buku` (
  `id` int(10) UNSIGNED NOT NULL,
  `judul` varchar(150) NOT NULL,
  `penulis` varchar(100) NOT NULL,
  `penerbit` varchar(100) NOT NULL,
  `tahun` int(4) NOT NULL,
  `stok` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `buku`
--

INSERT INTO `buku` (`id`, `judul`, `penulis`, `penerbit`, `tahun`, `stok`, `created_at`, `updated_at`) VALUES
(1, 'indonesia cemas', 'anonym', 'Gramedia', 2025, 191, '2025-11-18 02:49:52', '2025-11-25 03:10:04'),
(2, 'buku1', 'anonym', 'Gramedia', 2026, 10, '2025-11-21 04:31:45', '2025-11-21 04:31:45'),
(3, 'buku2', 'anonym', 'Gramedia', 2025, 10, '2025-11-21 04:32:22', '2025-11-21 04:32:22'),
(4, 'buku3', 'anonym', 'Gramedia', 2024, 10, '2025-11-21 04:32:49', '2025-11-21 04:32:49'),
(5, 'buku4', 'anonym', 'Gramedia', 2026, 10, '2025-11-21 04:33:17', '2025-11-21 04:33:17'),
(6, 'buku5', 'anonym', 'Gramedia', 2025, 10, '2025-11-21 04:33:47', '2025-11-21 04:33:47');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-5c785c036466adea360111aa28563bfd556b5fba', 'i:1;', 1764065964),
('laravel-cache-5c785c036466adea360111aa28563bfd556b5fba:timer', 'i:1764065964;', 1764065964);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2025_11_01_193451_create_buku_table', 1),
(2, '2025_11_01_193902_create_mst_anggota_table', 1),
(3, '2025_11_01_193914_create_pinjam_table', 1),
(4, '2025_11_01_195715_create_sessions_table', 2),
(5, '2025_11_21_135156_create_cache_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `mst_anggota`
--

CREATE TABLE `mst_anggota` (
  `id` int(10) UNSIGNED NOT NULL,
  `nim` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `prodi` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mst_anggota`
--

INSERT INTO `mst_anggota` (`id`, `nim`, `nama`, `prodi`, `created_at`, `updated_at`) VALUES
(3, 'U.111.11.1112', 'Mahardika', 'Ilmu Komunikasi', '2025-11-23 09:15:54', '2025-11-23 09:15:54'),
(4, 'U.111.11.1113', 'user3', 'Teknik Informatika', '2025-11-25 03:08:05', '2025-11-25 03:08:05');

-- --------------------------------------------------------

--
-- Table structure for table `pinjams`
--

CREATE TABLE `pinjams` (
  `id` int(10) UNSIGNED NOT NULL,
  `anggota_id` int(10) UNSIGNED NOT NULL,
  `buku_id` int(10) UNSIGNED NOT NULL,
  `tgl_pinjam` date NOT NULL,
  `tgl_kembali` date NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `nim` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `nim`, `email`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'A.111.11.1111', 'officialadmin@gmail.com', '$2y$12$0cvJyiE80TnO268Q5V/BbebNq3z1FTWBue03qLUHzCy6MTViriHee', 'admin', '2025-11-22 08:19:52', '2025-11-22 08:19:52'),
(2, 'user', 'U.111.11.1111', 'offcialuser@gmail.com', '$2y$12$3jbaB/p5oErdaiuFR.tEMOlwEW4minOuF3CAhey9UokTfYCXUOLx2', 'user', '2025-11-23 06:04:11', '2025-11-23 06:04:11'),
(3, 'Mahardika', 'U.111.11.1112', 'mahardika@gmail.com', '$2y$12$7SW42JnT7yCcccU2bsAgYuYXPaXuqRilnr.cBBhDrLxwG.uQIqZau', 'user', '2025-11-23 09:15:54', '2025-11-24 22:38:15'),
(4, 'user3', 'U.111.11.1113', 'contoh@gmail.com', '$2y$12$xf8wgkDdzHZs7pagEgu0zeuUFkOfQXHnjen7QmHFcBROtpJTYFKkG', 'admin', '2025-11-25 03:08:05', '2025-11-25 03:12:38');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mst_anggota`
--
ALTER TABLE `mst_anggota`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pinjams`
--
ALTER TABLE `pinjams`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pinjams_anggota` (`anggota_id`),
  ADD KEY `fk_pinjams_buku` (`buku_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nim` (`nim`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `buku`
--
ALTER TABLE `buku`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `mst_anggota`
--
ALTER TABLE `mst_anggota`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pinjams`
--
ALTER TABLE `pinjams`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pinjams`
--
ALTER TABLE `pinjams`
  ADD CONSTRAINT `fk_pinjams_anggota` FOREIGN KEY (`anggota_id`) REFERENCES `mst_anggota` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pinjams_buku` FOREIGN KEY (`buku_id`) REFERENCES `buku` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
