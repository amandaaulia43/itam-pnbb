-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 25, 2026 at 06:41 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_itam_pnbb`
--

-- --------------------------------------------------------

--
-- Table structure for table `assets`
--

CREATE TABLE `assets` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `asset_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `asset_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `serial_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kondisi_penggantian` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Belum Diganti',
  `item_status` enum('BMN','Pihak Ketiga','Barang Lainnya') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'BMN',
  `status` enum('active','broken','maintenance') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serial_number_photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `purchase_date` date DEFAULT NULL,
  `purchase_price` decimal(15,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `assets`
--

INSERT INTO `assets` (`id`, `uuid`, `asset_code`, `asset_name`, `category_id`, `serial_number`, `location`, `kondisi_penggantian`, `item_status`, `status`, `photo`, `serial_number_photo`, `purchase_date`, `purchase_price`, `created_at`, `updated_at`) VALUES
(1, '0bfa7190-955d-4b6a-a1bd-e51e61be26dc', 'ITAM-D7XPH', 'Laptop Lenovo Thinkpad T450', 1, 'SN-12345678198', 'Ruang Kesekretariatan', 'Belum Diganti', 'Pihak Ketiga', 'broken', 'assets_photos/v55G4p4TZwHVvheaWjM6tT8A97XytL2PNCNNMeBo.jpg', NULL, NULL, NULL, '2026-04-06 18:49:57', '2026-04-28 21:26:14'),
(2, 'a9341ed1-7e62-43ed-864f-47630a53d931', 'ITAM-0MHD3', 'PC HP', 1, 'SN-12345678876', 'Ruang Sidang Utama', 'Belum Diganti', 'BMN', 'active', 'assets_photos/vBEuFRI1jAgW6RtHGIBf5vw2FIVZOOgkicQDpBDC.jpg', NULL, '2018-06-07', 10000000.00, '2026-04-07 00:21:49', '2026-04-28 23:54:23'),
(3, 'e3201fb0-f8e6-4390-a7bb-79101a5781c8', 'ITAM-RKPTH', 'Laptop AXIOO', 1, 'SN-1234567801', 'Ruang Kesekretariatan', 'Sudah Diganti', 'BMN', 'maintenance', 'assets_photos/zK5jHoG9IbjKpRGdV8zwQfjsMlYmIcMfwWVOBM7S.jpg', 'assets_photos/serial_numbers/aGUZHhOeTTZkxBLMs31qHQdcLLLVgQExzIkX9Pnu.png', '2021-04-19', 5000000.00, '2026-04-14 00:19:46', '2026-04-27 01:28:59'),
(4, '976b77da-6320-46a1-a200-940a27ce8eee', 'ITAM-L2DGL', 'LAPTOP LENOVO THINKPAD YOGA 260', 1, 'SN-12345678876', 'Ruang Sidang Anak', 'Belum Diganti', 'BMN', 'maintenance', 'assets_photos/s1eCrnUsWC281VryYg3a6IJWeEW9NoNOmmwYFsaj.jpg', 'assets_photos/serial_numbers/hCcyrhvJm5FS2y7C1ShNwwUqJK9pOxo5KxN8X43s.png', '2020-04-20', 4000000.00, '2026-04-20 00:29:27', '2026-04-20 00:29:27'),
(5, '2d5d6fc0-a9bb-423d-bb1b-4b9a8ec61512', 'ITAM-MQZQC', 'PC AXIOO', 1, 'SN-12345678198', 'Ruang Sidang Anak', 'Belum Diganti', 'BMN', 'active', 'assets_photos/xSd7C0uP1S7nG843huLqMnbJVKjxuLXsszP5O401.jpg', 'assets_photos/serial_numbers/2hnKk6jciypAdwkcJZ6ePqKU2UjbHHAwuRnSAsJb.png', '2026-04-07', 4000000.00, '2026-04-29 01:19:43', '2026-04-29 01:25:13'),
(6, '53c74e31-d1da-4103-af31-fd4aa189e719', 'ITAM-AM195', 'LAPTOP DELL', 1, 'SN-1904050065', 'Ruang Kesekretariatan', 'Belum Diganti', 'Pihak Ketiga', 'active', NULL, NULL, NULL, NULL, '2026-05-12 19:40:48', '2026-05-12 19:40:48');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'PC & Laptop', '2026-04-06 18:48:05', '2026-04-06 18:48:05'),
(2, 'Printer & Scanner', '2026-04-06 18:48:20', '2026-04-06 18:48:20'),
(3, 'Jaringan & Server', '2026-04-06 18:48:30', '2026-04-06 18:48:30');

-- --------------------------------------------------------

--
-- Table structure for table `criteria`
--

CREATE TABLE `criteria` (
  `id` bigint UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('benefit','cost') COLLATE utf8mb4_unicode_ci NOT NULL,
  `weight` decimal(5,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `criteria`
--

INSERT INTO `criteria` (`id`, `code`, `name`, `type`, `weight`, `created_at`, `updated_at`) VALUES
(1, 'C1', 'Kondisi Fisik', 'benefit', 0.30, '2026-04-20 02:20:10', '2026-04-20 02:20:10'),
(2, 'C2', 'Umur Ekonomis', 'benefit', 0.15, '2026-04-20 02:20:10', '2026-04-20 02:20:10'),
(3, 'C3', 'Frekuensi Kerusakan', 'benefit', 0.25, '2026-04-20 02:20:10', '2026-04-20 02:20:10'),
(4, 'C4', 'Tingkat Urgensi', 'benefit', 0.20, '2026-04-20 02:20:10', '2026-04-20 02:20:10'),
(5, 'C5', 'Harga Penggantian', 'cost', 0.10, '2026-04-20 02:20:10', '2026-04-20 02:20:10');

-- --------------------------------------------------------

--
-- Table structure for table `evaluations`
--

CREATE TABLE `evaluations` (
  `id` bigint UNSIGNED NOT NULL,
  `asset_id` bigint UNSIGNED NOT NULL,
  `c1` int NOT NULL,
  `c2` int NOT NULL,
  `c3` int NOT NULL,
  `c4` int NOT NULL,
  `c5` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `evaluations`
--

INSERT INTO `evaluations` (`id`, `asset_id`, `c1`, `c2`, `c3`, `c4`, `c5`, `created_at`, `updated_at`) VALUES
(1, 3, 3, 4, 2, 2, 3, '2026-04-14 01:45:24', '2026-04-14 01:45:24'),
(2, 1, 2, 1, 2, 1, 5, '2026-04-19 20:15:05', '2026-04-19 20:15:05'),
(3, 5, 4, 3, 2, 5, 3, '2026-04-29 01:27:44', '2026-04-29 01:27:44');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Ruang PTSP', '2026-05-24 20:28:21', '2026-05-24 20:28:21'),
(2, 'Ruang Sidang Utama', '2026-05-24 20:28:21', '2026-05-24 20:28:21'),
(3, 'Ruang Mediasi', '2026-05-24 20:28:21', '2026-05-24 20:28:21'),
(4, 'Ruang Posbakum', '2026-05-24 20:28:21', '2026-05-24 20:28:21'),
(5, 'Ruang Kerja Ketua PN', '2026-05-24 20:28:21', '2026-05-24 20:28:21'),
(6, 'Ruang Kerja Wakil Ketua PN', '2026-05-24 20:28:21', '2026-05-24 20:28:21'),
(7, 'Ruang Hakim', '2026-05-24 20:28:21', '2026-05-24 20:28:21'),
(8, 'Ruang Kerja Panitera', '2026-05-24 20:28:21', '2026-05-24 20:28:21'),
(9, 'Ruang Kepaniteraan Pidana', '2026-05-24 20:28:21', '2026-05-24 20:28:21'),
(10, 'Ruang Kepaniteraan Perdata', '2026-05-24 20:28:21', '2026-05-24 20:28:21'),
(11, 'Ruang Kepaniteraan Hukum', '2026-05-24 20:28:21', '2026-05-24 20:28:21'),
(12, 'Ruang Jurusita / Jurusita Pengganti', '2026-05-24 20:28:21', '2026-05-24 20:28:21'),
(13, 'Ruang Kerja Sekretaris', '2026-05-24 20:28:21', '2026-05-24 20:28:21'),
(14, 'Ruang Sub Bagian Umum dan Keuangan', '2026-05-24 20:28:21', '2026-05-24 20:28:21'),
(15, 'Ruang Sub Bagian Kepegawaian & ORTALA', '2026-05-24 20:28:21', '2026-05-24 20:28:21'),
(16, 'Ruang Sub Bagian PTIP', '2026-05-24 20:28:21', '2026-05-24 20:28:21'),
(17, 'Ruang Arsip', '2026-05-24 20:28:21', '2026-05-24 20:28:21'),
(18, 'Gudang', '2026-05-24 20:28:21', '2026-05-24 20:28:21');

-- --------------------------------------------------------

--
-- Table structure for table `maintenances`
--

CREATE TABLE `maintenances` (
  `id` bigint UNSIGNED NOT NULL,
  `asset_id` bigint UNSIGNED NOT NULL,
  `maintenance_date` date NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `action_taken` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `repair_cost` bigint DEFAULT NULL,
  `technician_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `maintenances`
--

INSERT INTO `maintenances` (`id`, `asset_id`, `maintenance_date`, `description`, `action_taken`, `repair_cost`, `technician_name`, `created_at`, `updated_at`) VALUES
(1, 1, '2026-04-07', 'laptop awalnya lemot terus blue scrint dan tidak bisa di charger (masuk tapi tidak nambah)', 'instal ulang windows dan mengganti baterai', 0, 'PTIP PN BALE BANDUNG', '2026-04-06 18:52:42', '2026-04-06 18:52:42'),
(2, 3, '2026-04-14', 'penyimpanan penuh', 'ganti SSD', 350000, 'PTIP PN BALE BANDUNG', '2026-04-14 01:31:59', '2026-04-14 01:31:59'),
(3, 1, '2026-04-29', 'TICKETING LAPORAN MASUK | Dari: DESI | Ruangan: RUANG SERVER | Keluhan: layar blank dan kursor tidak bisa gerak', 'Menunggu Pengecekan Teknisi', NULL, '-', '2026-04-28 21:40:22', '2026-04-28 21:40:22'),
(4, 2, '2026-04-29', 'TICKETING LAPORAN MASUK | Dari: MANDA | Ruangan: LOBBY | Keluhan: blue screen', 'Menunggu Pengecekan Teknisi', NULL, '-', '2026-04-28 21:47:56', '2026-04-28 21:47:56'),
(5, 5, '2026-04-29', 'TICKETING LAPORAN MASUK | Dari: DIAN | Ruangan: RUANG SERVER | Keluhan: lemot', 'Menunggu Pengecekan Teknisi', NULL, '-', '2026-04-29 01:20:43', '2026-04-29 01:20:43'),
(6, 2, '2026-05-05', 'TICKETING LAPORAN MASUK | Dari: SINDI | Ruangan: RUANG RAPAT PTIP | Keluhan: Penyimpanan penuh', 'Penggantian SSID', 300000, 'PTIP PN BALE BANDUNG', '2026-05-04 22:24:28', '2026-05-04 22:26:39'),
(7, 5, '2026-05-05', 'TICKETING LAPORAN MASUK | Dari: SINDI | Ruangan: RUANG RAPAT PTIP | Keluhan: layar ngeblank', 'PENDING - Menunggu Pengecekan Admin', NULL, '-', '2026-05-05 01:02:59', '2026-05-05 01:02:59');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_03_04_065047_create_categories_table', 1),
(5, '2026_03_04_065058_create_assets_table', 1),
(6, '2026_03_04_065105_create_maintenances_table', 1),
(7, '2026_03_10_050223_add_cost_to_maintenances_table', 1),
(8, '2026_03_10_050235_create_software_licenses_table', 1),
(9, '2026_03_10_050242_create_criterias_table', 1),
(10, '2026_03_10_050250_create_evaluations_table', 1),
(11, '2026_03_10_050257_create_evaluation_details_table', 1),
(12, '2026_03_11_065100_create_criteria_table', 1),
(13, '2026_03_11_065119_create_evaluations_table', 1),
(14, '2026_04_14_064122_add_serial_photo_to_assets_table', 2),
(15, '2026_04_20_040439_add_replacement_condition_to_assets_table', 3),
(16, '2026_04_20_061709_drop_criterias_table', 4),
(17, '2026_05_25_024620_create_locations_table', 5);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('1q2cIRj7s4pGNZxh5OUQvNEauFiqS7hSFuBeunP1', NULL, '10.15.0.44', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Mobile Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSlhYQ3FIMEwyQUV2UDBhekI4bllXa0xVcDJXRnhnMTY5MEE1TWFWMiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjg6Imh0dHA6Ly8xMC4xNS4wLjIxOjgwMDAvbG9naW4iO3M6NToicm91dGUiO3M6NToibG9naW4iO319', 1778640246),
('FYbKLNijJcg4CGOz89MkTKYnZN9zoDk9uFgEv4cN', 1, '10.15.0.21', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRXVOYndDbHIzNVVFalE5RHVsajRCTDJUNzJsaDJzZXVBeGJkVFMzcSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly8xMC4xNS4wLjIxOjgwMDAvZGFzaGJvYXJkIjtzOjU6InJvdXRlIjtzOjk6ImRhc2hib2FyZCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1778660559),
('IEXRANoJSvFcUsCcvskY7TLWtErOgbHO2gEYf6Zq', 1, '10.15.1.104', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoibFByNGl5VGRKMUVMb1BvOTNQRTFoZHo0TXhmRGJBNDlkckpqdEdheCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xMC4xNS4xLjEwNDo4MDAwL2xvY2F0aW9ucyI7czo1OiJyb3V0ZSI7czoxNToibG9jYXRpb25zLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1779680433),
('iQwWVjJr0XbX9EWW3mlXN2iroy8ifhv5FNKztL2I', 1, '10.15.0.21', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTG5VdWVGa3BlVTJ4RW5xcDBjbVZEZTdIaWJPS3ZCb1RGM01SdFdVOCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly8xMC4xNS4wLjIxOjgwMDAvYXNzZXRzL2V4cG9ydCI7czo1OiJyb3V0ZSI7czoxMzoiYXNzZXRzLmV4cG9ydCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1778640418);

-- --------------------------------------------------------

--
-- Table structure for table `software_licenses`
--

CREATE TABLE `software_licenses` (
  `id` bigint UNSIGNED NOT NULL,
  `asset_id` bigint UNSIGNED NOT NULL,
  `software_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin ITAM', 'admin@admin.com', NULL, '$2y$12$fGltkxwhPXiQYiOByd.68u1UvJslX8ues/qVMViZpl.9QQQCPFs1G', NULL, '2026-04-01 02:11:45', '2026-04-01 02:11:45');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assets`
--
ALTER TABLE `assets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `assets_uuid_unique` (`uuid`),
  ADD UNIQUE KEY `assets_asset_code_unique` (`asset_code`),
  ADD KEY `assets_category_id_foreign` (`category_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `criteria`
--
ALTER TABLE `criteria`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `criteria_code_unique` (`code`);

--
-- Indexes for table `evaluations`
--
ALTER TABLE `evaluations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `evaluations_asset_id_foreign` (`asset_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `maintenances`
--
ALTER TABLE `maintenances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `maintenances_asset_id_foreign` (`asset_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `software_licenses`
--
ALTER TABLE `software_licenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `software_licenses_asset_id_foreign` (`asset_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assets`
--
ALTER TABLE `assets`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `criteria`
--
ALTER TABLE `criteria`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `evaluations`
--
ALTER TABLE `evaluations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `maintenances`
--
ALTER TABLE `maintenances`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `software_licenses`
--
ALTER TABLE `software_licenses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assets`
--
ALTER TABLE `assets`
  ADD CONSTRAINT `assets_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `evaluations`
--
ALTER TABLE `evaluations`
  ADD CONSTRAINT `evaluations_asset_id_foreign` FOREIGN KEY (`asset_id`) REFERENCES `assets` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `maintenances`
--
ALTER TABLE `maintenances`
  ADD CONSTRAINT `maintenances_asset_id_foreign` FOREIGN KEY (`asset_id`) REFERENCES `assets` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `software_licenses`
--
ALTER TABLE `software_licenses`
  ADD CONSTRAINT `software_licenses_asset_id_foreign` FOREIGN KEY (`asset_id`) REFERENCES `assets` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
