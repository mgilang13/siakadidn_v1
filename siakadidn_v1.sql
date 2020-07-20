-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 20, 2020 at 05:56 AM
-- Server version: 10.3.22-MariaDB-1ubuntu1
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `siakadidn_v1`
--

DELIMITER $$
--
-- Procedures
--
CREATE PROCEDURE `tahfidz_absensi` (IN `id_student` BIGINT(20))  SELECT 
	COUNT(absen) AS total_hadir, 
	(SELECT COUNT(absen) FROM tahfidzs WHERE absen = 'a') as total_alpha,
	(SELECT COUNT(absen) FROM tahfidzs WHERE absen = 'i') as total_izin,
	(SELECT COUNT(absen) FROM tahfidzs WHERE absen = 's') as total_sakit
FROM tahfidzs
WHERE absen = 'h' and id_student = id_student$$

CREATE PROCEDURE `tahfidz_report_manzil` (IN `id_student` BIGINT(20))  select
 		sum(page*15+line) as total_line,
		CONCAT(DAY(max(tanggal_setor)), '/', MONTH(MAX(tanggal_setor))) as tgl_bln
from tahfidzs 
where id_student = id_student and type = "manzil" and tanggal_setor >= CURDATE() - INTERVAL 30 DAY 
GROUP BY CONCAT(WEEK(tanggal_setor), MONTH(tanggal_setor), YEAR(tanggal_setor))$$

CREATE PROCEDURE `tahfidz_report_sabaq` (IN `id_student` BIGINT(20))  select
 		sum(page*15+line) as total_line,
		CONCAT(DAY(max(tanggal_setor)), '/', MONTH(MAX(tanggal_setor))) as tgl_bln
from tahfidzs 
where id_student = id_student and type = "sabaq" and tanggal_setor >= CURDATE() - INTERVAL 30 DAY 
GROUP BY CONCAT(WEEK(tanggal_setor), MONTH(tanggal_setor), YEAR(tanggal_setor))$$

CREATE PROCEDURE `tahfidz_total_manzil` (IN `id_student` BIGINT(20))  select 
	floor((sum(page) + floor(sum(line) / 15)) / 20) as juz,
	((sum(page) + floor(sum(line) / 15)) % 20) as halaman,
	sum(line) % 15 as total_line ,
	concat(floor((sum(page) + floor(sum(line) / 15)) / 20),' Juz ',
	((sum(page) + floor(sum(line) / 15)) % 20), ' Halaman ',
	sum(line) % 15, ' Baris') as Total
from tahfidzs 
where 
	id_student = id_student and type ="manzil"$$

CREATE PROCEDURE `tahfidz_total_sabaq` (IN `id_student` BIGINT(20))  select 
	floor((sum(page) + floor(sum(line) / 15)) / 20) as juz,
	((sum(page) + floor(sum(line) / 15)) % 20) as halaman,
	sum(line) % 15 as total_line ,
	concat(floor((sum(page) + floor(sum(line) / 15)) / 20),' Juz ',
	((sum(page) + floor(sum(line) / 15)) % 20), ' Halaman ',
	sum(line) % 15, ' Baris') as Total
from tahfidzs 
where 
	id_student = id_student and type ="sabaq"$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `halaqahs`
--

CREATE TABLE `halaqahs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_teacher` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `halaqahs`
--

INSERT INTO `halaqahs` (`id`, `id_teacher`, `name`, `description`, `created_at`, `updated_at`) VALUES
(2, 52, 'asfasf', 'sadfsdf', '2020-07-18 00:24:56', '2020-07-18 00:24:56'),
(3, 52, 'asfasf', 'sadfsdf', '2020-07-18 00:25:04', '2020-07-18 00:25:04'),
(4, 52, 'asdfws', 'asdfasdf', '2020-07-18 00:25:35', '2020-07-18 00:25:35'),
(5, 52, 'asdfasf', 'dsfsadf', '2020-07-18 00:26:38', '2020-07-18 00:26:38'),
(6, 52, 'sdfsadfdsf', 'sdfsdf', '2020-07-18 02:56:59', '2020-07-18 02:56:59');

-- --------------------------------------------------------

--
-- Table structure for table `juzs`
--

CREATE TABLE `juzs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `juz` int(11) NOT NULL,
  `total_ayat` int(11) NOT NULL,
  `soorah_start` int(11) NOT NULL,
  `verse_start` int(11) NOT NULL,
  `soorah_end` int(11) NOT NULL,
  `verse_end` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `juzs`
--

INSERT INTO `juzs` (`id`, `juz`, `total_ayat`, `soorah_start`, `verse_start`, `soorah_end`, `verse_end`, `created_at`, `updated_at`) VALUES
(1, 1, 148, 1, 1, 2, 141, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(2, 2, 111, 2, 142, 2, 252, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(3, 3, 125, 2, 253, 3, 91, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(4, 4, 131, 3, 92, 4, 23, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(5, 5, 124, 4, 24, 4, 147, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(6, 6, 110, 4, 148, 5, 82, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(7, 7, 149, 5, 83, 6, 110, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(8, 8, 142, 6, 111, 7, 87, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(9, 9, 159, 7, 88, 8, 40, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(10, 10, 127, 8, 41, 9, 93, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(11, 11, 151, 9, 94, 11, 5, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(12, 12, 170, 11, 6, 12, 52, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(13, 13, 154, 12, 53, 14, 52, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(14, 14, 227, 15, 1, 16, 128, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(15, 15, 185, 17, 1, 18, 74, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(16, 16, 269, 18, 75, 20, 135, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(17, 17, 190, 21, 1, 22, 78, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(18, 18, 202, 23, 1, 25, 20, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(19, 19, 339, 25, 21, 27, 55, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(20, 20, 171, 27, 56, 29, 45, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(21, 21, 178, 29, 46, 33, 30, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(22, 22, 169, 33, 31, 36, 27, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(23, 23, 357, 36, 28, 39, 31, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(24, 24, 175, 39, 32, 41, 46, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(25, 25, 246, 41, 47, 45, 37, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(26, 26, 195, 46, 1, 51, 30, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(27, 27, 399, 51, 31, 57, 29, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(28, 28, 137, 58, 1, 66, 12, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(29, 29, 431, 67, 1, 77, 50, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(30, 30, 553, 78, 1, 114, 6, '2020-07-17 01:42:31', '2020-07-17 01:42:31');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2020_07_04_014721_create_roles_table', 1),
(5, '2020_07_04_014749_create_routes_table', 1),
(6, '2020_07_04_014801_create_roles_routes_table', 1),
(7, '2020_07_04_014816_create_roles_users_table', 1),
(8, '2020_07_06_160531_create_subjects_table', 1),
(9, '2020_07_06_171956_create_teachers_table', 1),
(10, '2020_07_08_044309_create_halaqahs_table', 1),
(11, '2020_07_08_125947_create_juzs_table', 1),
(12, '2020_07_08_203101_create_students_table', 1),
(13, '2020_07_09_055838_create_tahfidzs_table', 1),
(14, '2020_07_10_233104_create_soorahs_table', 1),
(15, '2020_07_13_102413_create_soorah_verses_table', 1),
(16, '2020_07_16_162505_create_parents_table', 1),
(17, '2020_07_17_024714_create_school_years_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `parents`
--

CREATE TABLE `parents` (
  `id_parents` bigint(20) UNSIGNED NOT NULL,
  `id_student` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `group` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `group`, `description`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'admin', NULL, 'admin', NULL, '2020-07-17 01:42:30', '2020-07-17 01:42:30'),
(2, 'operator', 'admin', 'operator', NULL, '2020-07-17 01:42:30', '2020-07-17 01:42:30'),
(3, 'guru', 'guru', 'guru', NULL, '2020-07-17 01:42:30', '2020-07-17 01:42:30'),
(4, 'murid', 'murid', 'murid', NULL, '2020-07-17 01:42:30', '2020-07-17 01:42:30'),
(5, 'orang_tua', 'orang_tua', 'orang_tua', NULL, '2020-07-17 01:42:30', '2020-07-17 01:42:30');

-- --------------------------------------------------------

--
-- Table structure for table `roles_routes`
--

CREATE TABLE `roles_routes` (
  `roles_id` tinyint(3) UNSIGNED NOT NULL,
  `routes_id` bigint(20) UNSIGNED NOT NULL,
  `access` enum('yes','no') COLLATE utf8mb4_unicode_ci DEFAULT 'yes',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles_routes`
--

INSERT INTO `roles_routes` (`roles_id`, `routes_id`, `access`, `created_at`, `updated_at`) VALUES
(4, 1, 'yes', '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(4, 11, 'yes', '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(1, 2, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 3, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 20, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 22, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 21, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 4, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 23, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 25, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 24, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 26, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 27, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 5, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 28, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 29, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 32, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 33, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 30, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 31, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 1, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 18, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 19, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 34, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 35, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 36, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 9, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 37, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 90, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 38, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 39, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 40, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 41, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 42, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 43, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 44, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 13, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 45, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 91, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 46, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 47, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 48, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 49, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 50, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 14, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 51, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 52, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 53, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 54, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 55, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 56, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 57, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 10, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 58, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 89, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 59, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 60, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 61, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 62, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 63, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 8, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 64, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 65, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 66, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 67, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 68, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 69, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 70, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 7, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 71, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 72, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 73, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 74, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 6, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 75, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 76, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 77, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 78, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 11, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 79, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 80, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 81, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 82, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 83, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 84, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 85, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 86, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 87, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46'),
(1, 88, 'yes', '2020-07-19 07:40:46', '2020-07-19 07:40:46');

-- --------------------------------------------------------

--
-- Table structure for table `roles_users`
--

CREATE TABLE `roles_users` (
  `roles_id` tinyint(3) UNSIGNED NOT NULL,
  `users_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles_users`
--

INSERT INTO `roles_users` (`roles_id`, `users_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(3, 52, '2020-07-17 02:04:35', '2020-07-17 02:04:35'),
(4, 53, '2020-07-17 02:05:19', '2020-07-17 02:05:19'),
(5, 58, '2020-07-17 02:57:28', '2020-07-17 02:57:28'),
(5, 59, '2020-07-17 06:32:49', '2020-07-17 06:32:49'),
(3, 60, '2020-07-19 00:05:36', '2020-07-19 00:05:36'),
(5, 63, '2020-07-19 06:39:21', '2020-07-19 06:39:21');

-- --------------------------------------------------------

--
-- Table structure for table `routes`
--

CREATE TABLE `routes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parent` bigint(20) UNSIGNED DEFAULT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `menu` enum('yes','no') COLLATE utf8mb4_unicode_ci DEFAULT 'no',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `routes`
--

INSERT INTO `routes` (`id`, `parent`, `icon`, `name`, `title`, `order`, `menu`, `created_at`, `updated_at`) VALUES
(1, NULL, 'home', 'dashboard', 'Dashboard', 1, 'yes', '2020-07-17 01:42:30', '2020-07-17 01:42:30'),
(2, NULL, 'settings', 'core', 'Pengaturan', 10000, 'yes', '2020-07-17 01:42:30', '2020-07-17 01:42:30'),
(3, 2, NULL, 'core.menu', 'Menu', 10001, 'yes', '2020-07-17 01:42:30', '2020-07-17 01:42:30'),
(4, 2, NULL, 'core.roles', 'Hak Akses', 10002, 'yes', '2020-07-17 01:42:30', '2020-07-17 01:42:30'),
(5, 2, NULL, 'core.users', 'User', 10003, 'yes', '2020-07-17 01:42:30', '2020-07-17 01:42:30'),
(6, NULL, 'list', 'reference', 'Referensi', 20, 'yes', '2020-07-17 01:42:30', '2020-07-17 01:42:30'),
(7, 6, NULL, 'ref.teacher.index', 'Guru', 1001, 'yes', '2020-07-17 01:42:30', '2020-07-17 01:42:30'),
(8, 6, NULL, 'ref.subject.index', 'Mata Pelajaran', 1002, 'yes', '2020-07-17 01:42:30', '2020-07-17 01:42:30'),
(9, 6, NULL, 'ref.halaqah.index', 'Halaqah', 1004, 'yes', '2020-07-17 01:42:30', '2020-07-17 01:42:30'),
(10, 6, NULL, 'ref.student.index', 'Murid', 1000, 'yes', '2020-07-17 01:42:30', '2020-07-17 01:42:30'),
(11, NULL, 'book-open', 'tahfidz.index', 'Tahfidz', 10, 'yes', '2020-07-17 01:42:30', '2020-07-17 01:42:30'),
(13, 6, NULL, 'ref.parent.index', 'Orang Tua / Wali Murid', 1005, 'yes', '2020-07-17 01:42:30', '2020-07-17 01:42:30'),
(14, 6, NULL, 'ref.schoolyear.index', 'Tahun Ajaran', 1006, 'yes', '2020-07-17 01:42:30', '2020-07-17 01:42:30'),
(18, NULL, NULL, 'profile', NULL, NULL, 'no', '2020-07-17 01:42:30', '2020-07-17 01:42:30'),
(19, NULL, NULL, 'profile.update.process', NULL, NULL, 'no', '2020-07-17 01:42:30', '2020-07-17 01:42:30'),
(20, NULL, NULL, 'core.menu.add.process', NULL, NULL, 'no', '2020-07-17 01:42:30', '2020-07-17 01:42:30'),
(21, NULL, NULL, 'core.menu.edit.process', NULL, NULL, 'no', '2020-07-17 01:42:30', '2020-07-17 01:42:30'),
(22, NULL, NULL, 'core.menu.delete.process', NULL, NULL, 'no', '2020-07-17 01:42:30', '2020-07-17 01:42:30'),
(23, NULL, NULL, 'core.roles.add.process', NULL, NULL, 'no', '2020-07-17 01:42:30', '2020-07-17 01:42:30'),
(24, NULL, NULL, 'core.roles.edit.process', NULL, NULL, 'no', '2020-07-17 01:42:30', '2020-07-17 01:42:30'),
(25, NULL, NULL, 'core.roles.delete.process', NULL, NULL, 'no', '2020-07-17 01:42:30', '2020-07-17 01:42:30'),
(26, NULL, NULL, 'core.roles.routes', NULL, NULL, 'no', '2020-07-17 01:42:30', '2020-07-17 01:42:30'),
(27, NULL, NULL, 'core.roles.routes.update.process', NULL, NULL, 'no', '2020-07-17 01:42:30', '2020-07-17 01:42:30'),
(28, NULL, NULL, 'core.users.add', NULL, NULL, 'no', '2020-07-17 01:42:30', '2020-07-17 01:42:30'),
(29, NULL, NULL, 'core.users.add.process', NULL, NULL, 'no', '2020-07-17 01:42:30', '2020-07-17 01:42:30'),
(30, NULL, NULL, 'core.users.edit', NULL, NULL, 'no', '2020-07-17 01:42:30', '2020-07-17 01:42:30'),
(31, NULL, NULL, 'core.users.edit.process', NULL, NULL, 'no', '2020-07-17 01:42:30', '2020-07-17 01:42:30'),
(32, NULL, NULL, 'core.users.delete', NULL, NULL, 'no', '2020-07-17 01:42:30', '2020-07-17 01:42:30'),
(33, NULL, NULL, 'core.users.delete.process', NULL, NULL, 'no', '2020-07-17 01:42:30', '2020-07-17 01:42:30'),
(34, NULL, NULL, 'ref.halaqah.create', NULL, NULL, 'no', '2020-07-17 01:44:50', '2020-07-17 01:44:50'),
(35, NULL, NULL, 'ref.halaqah.destroy', NULL, NULL, 'no', '2020-07-17 01:44:50', '2020-07-17 01:44:50'),
(36, NULL, NULL, 'ref.halaqah.edit', NULL, NULL, 'no', '2020-07-17 01:44:50', '2020-07-17 01:44:50'),
(37, NULL, NULL, 'ref.halaqah.show', NULL, NULL, 'no', '2020-07-17 01:44:50', '2020-07-17 01:44:50'),
(38, NULL, NULL, 'ref.halaqah.show.add', NULL, NULL, 'no', '2020-07-17 01:44:50', '2020-07-17 01:44:50'),
(39, NULL, NULL, 'ref.halaqah.show.add.process', NULL, NULL, 'no', '2020-07-17 01:44:50', '2020-07-17 01:44:50'),
(40, NULL, NULL, 'ref.halaqah.store', NULL, NULL, 'no', '2020-07-17 01:44:50', '2020-07-17 01:44:50'),
(41, NULL, NULL, 'ref.halaqah.update', NULL, NULL, 'no', '2020-07-17 01:44:50', '2020-07-17 01:44:50'),
(42, NULL, NULL, 'ref.parent.create', NULL, NULL, 'no', '2020-07-17 01:44:50', '2020-07-17 01:44:50'),
(43, NULL, NULL, 'ref.parent.destroy', NULL, NULL, 'no', '2020-07-17 01:44:50', '2020-07-17 01:44:50'),
(44, NULL, NULL, 'ref.parent.edit', NULL, NULL, 'no', '2020-07-17 01:44:50', '2020-07-17 01:44:50'),
(45, NULL, NULL, 'ref.parent.show', NULL, NULL, 'no', '2020-07-17 01:44:50', '2020-07-17 01:44:50'),
(46, NULL, NULL, 'ref.parent.store', NULL, NULL, 'no', '2020-07-17 01:44:50', '2020-07-17 01:44:50'),
(47, NULL, NULL, 'ref.parent.update', NULL, NULL, 'no', '2020-07-17 01:44:50', '2020-07-17 01:44:50'),
(48, NULL, NULL, 'ref.schoolyear.create', NULL, NULL, 'no', '2020-07-17 01:44:50', '2020-07-17 01:44:50'),
(49, NULL, NULL, 'ref.schoolyear.destroy', NULL, NULL, 'no', '2020-07-17 01:44:50', '2020-07-17 01:44:50'),
(50, NULL, NULL, 'ref.schoolyear.edit', NULL, NULL, 'no', '2020-07-17 01:44:50', '2020-07-17 01:44:50'),
(51, NULL, NULL, 'ref.schoolyear.show', NULL, NULL, 'no', '2020-07-17 01:44:50', '2020-07-17 01:44:50'),
(52, NULL, NULL, 'ref.schoolyear.show-json', NULL, NULL, 'no', '2020-07-17 01:44:50', '2020-07-17 01:44:50'),
(53, NULL, NULL, 'ref.schoolyear.store', NULL, NULL, 'no', '2020-07-17 01:44:50', '2020-07-17 01:44:50'),
(54, NULL, NULL, 'ref.schoolyear.update', NULL, NULL, 'no', '2020-07-17 01:44:50', '2020-07-17 01:44:50'),
(55, NULL, NULL, 'ref.student.create', NULL, NULL, 'no', '2020-07-17 01:44:50', '2020-07-17 01:44:50'),
(56, NULL, NULL, 'ref.student.destroy', NULL, NULL, 'no', '2020-07-17 01:44:50', '2020-07-17 01:44:50'),
(57, NULL, NULL, 'ref.student.edit', NULL, NULL, 'no', '2020-07-17 01:44:50', '2020-07-17 01:44:50'),
(58, NULL, NULL, 'ref.student.show', NULL, NULL, 'no', '2020-07-17 01:44:50', '2020-07-17 01:44:50'),
(59, NULL, NULL, 'ref.student.store', NULL, NULL, 'no', '2020-07-17 01:44:50', '2020-07-17 01:44:50'),
(60, NULL, NULL, 'ref.student.update', NULL, NULL, 'no', '2020-07-17 01:44:50', '2020-07-17 01:44:50'),
(61, NULL, NULL, 'ref.subject.create', NULL, NULL, 'no', '2020-07-17 01:44:50', '2020-07-17 01:44:50'),
(62, NULL, NULL, 'ref.subject.destroy', NULL, NULL, 'no', '2020-07-17 01:44:50', '2020-07-17 01:44:50'),
(63, NULL, NULL, 'ref.subject.edit', NULL, NULL, 'no', '2020-07-17 01:44:50', '2020-07-17 01:44:50'),
(64, NULL, NULL, 'ref.subject.show', NULL, NULL, 'no', '2020-07-17 01:44:50', '2020-07-17 01:44:50'),
(65, NULL, NULL, 'ref.subject.show-json', NULL, NULL, 'no', '2020-07-17 01:44:50', '2020-07-17 01:44:50'),
(66, NULL, NULL, 'ref.subject.store', NULL, NULL, 'no', '2020-07-17 01:44:50', '2020-07-17 01:44:50'),
(67, NULL, NULL, 'ref.subject.update', NULL, NULL, 'no', '2020-07-17 01:44:50', '2020-07-17 01:44:50'),
(68, NULL, NULL, 'ref.teacher.create', NULL, NULL, 'no', '2020-07-17 01:44:50', '2020-07-17 01:44:50'),
(69, NULL, NULL, 'ref.teacher.destroy', NULL, NULL, 'no', '2020-07-17 01:44:50', '2020-07-17 01:44:50'),
(70, NULL, NULL, 'ref.teacher.edit', NULL, NULL, 'no', '2020-07-17 01:44:50', '2020-07-17 01:44:50'),
(71, NULL, NULL, 'ref.teacher.show', NULL, NULL, 'no', '2020-07-17 01:44:50', '2020-07-17 01:44:50'),
(72, NULL, NULL, 'ref.teacher.show-json', NULL, NULL, 'no', '2020-07-17 01:44:50', '2020-07-17 01:44:50'),
(73, NULL, NULL, 'ref.teacher.store', NULL, NULL, 'no', '2020-07-17 01:44:50', '2020-07-17 01:44:50'),
(74, NULL, NULL, 'ref.teacher.update', NULL, NULL, 'no', '2020-07-17 01:44:50', '2020-07-17 01:44:50'),
(75, NULL, NULL, 'tahfidz.add-notes', NULL, NULL, 'no', '2020-07-17 01:44:50', '2020-07-17 01:44:50'),
(76, NULL, NULL, 'tahfidz.create', NULL, NULL, 'no', '2020-07-17 01:44:50', '2020-07-17 01:44:50'),
(77, NULL, NULL, 'tahfidz.destroy', NULL, NULL, 'no', '2020-07-17 01:44:50', '2020-07-17 01:44:50'),
(78, NULL, NULL, 'tahfidz.edit', NULL, NULL, 'no', '2020-07-17 01:44:50', '2020-07-17 01:44:50'),
(79, NULL, NULL, 'tahfidz.list-halaqah', NULL, NULL, 'no', '2020-07-17 01:44:50', '2020-07-17 01:44:50'),
(80, NULL, NULL, 'tahfidz.list-santri', NULL, NULL, 'no', '2020-07-17 01:44:50', '2020-07-17 01:44:50'),
(81, NULL, NULL, 'tahfidz.report-murid', NULL, NULL, 'no', '2020-07-17 01:44:50', '2020-07-17 01:44:50'),
(82, NULL, NULL, 'tahfidz.report.parent', NULL, NULL, 'no', '2020-07-17 01:44:50', '2020-07-17 01:44:50'),
(83, NULL, NULL, 'tahfidz.show', NULL, NULL, 'no', '2020-07-17 01:44:50', '2020-07-17 01:44:50'),
(84, NULL, NULL, 'tahfidz.show-json', NULL, NULL, 'no', '2020-07-17 01:44:50', '2020-07-17 01:44:50'),
(85, NULL, NULL, 'tahfidz.show-member', NULL, NULL, 'no', '2020-07-17 01:44:50', '2020-07-17 01:44:50'),
(86, NULL, NULL, 'tahfidz.store', NULL, NULL, 'no', '2020-07-17 01:44:50', '2020-07-17 01:44:50'),
(87, NULL, NULL, 'tahfidz.update', NULL, NULL, 'no', '2020-07-17 01:44:50', '2020-07-17 01:44:50'),
(88, NULL, NULL, 'template', NULL, NULL, 'no', '2020-07-17 01:44:50', '2020-07-17 01:44:50'),
(89, NULL, NULL, 'ref.student.show-json', NULL, NULL, 'no', '2020-07-18 01:14:52', '2020-07-18 01:14:52'),
(90, NULL, NULL, 'ref.halaqah.show-json', NULL, NULL, 'no', '2020-07-19 06:06:06', '2020-07-19 06:06:06'),
(91, NULL, NULL, 'ref.parent.show-json', NULL, NULL, 'no', '2020-07-19 07:40:46', '2020-07-19 07:40:46');

-- --------------------------------------------------------

--
-- Table structure for table `school_years`
--

CREATE TABLE `school_years` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `semester` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `school_years`
--

INSERT INTO `school_years` (`id`, `semester`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, '1', 'lskdjfds', '1', '2020-07-17 08:38:49', '2020-07-17 08:38:49');

-- --------------------------------------------------------

--
-- Table structure for table `soorahs`
--

CREATE TABLE `soorahs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `soorahs`
--

INSERT INTO `soorahs` (`id`, `name`, `order`, `created_at`, `updated_at`) VALUES
(1, 'Al-Faatihah', 1, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(2, 'Al-Baqarah', 2, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(3, 'Ali \'Imran', 3, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(4, 'An-Nisaa\'', 4, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(5, 'Al-Maa\'idah', 5, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(6, 'Al-An\'am', 6, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(7, 'Al-A’raf', 7, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(8, 'Al-Anfal', 8, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(9, 'At-Taubah', 9, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(10, 'Yunus', 10, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(11, 'Hud', 11, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(12, 'Yusuf', 12, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(13, 'Ar-Ra’d', 13, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(14, 'Ibrahim', 14, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(15, 'Al-Hijr', 15, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(16, 'An-Nahl', 16, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(17, 'Al-Israa’', 17, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(18, 'Al-Kahf', 18, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(19, 'Maryam', 19, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(20, 'Taa Haa', 20, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(21, 'Al-Anbiyaa\'', 21, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(22, 'Al-Hajj', 22, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(23, 'Al-Mu’minuun', 23, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(24, 'An-Nuur', 24, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(25, 'Al-Furqaan', 25, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(26, 'Asy-Syu’araa’ ', 26, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(27, 'An-Naml', 27, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(28, 'Al-Qashash', 28, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(29, 'Al-‘Ankabuut', 29, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(30, 'Ar-Ruum', 30, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(31, 'Luqmaan', 31, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(32, 'As-Sajdah', 32, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(33, 'Al-Ahzaab', 33, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(34, 'Sabaa’ ', 34, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(35, 'Faathir ', 35, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(36, 'Ya Sin', 36, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(37, 'Ash-Shaaffat', 37, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(38, 'Sad', 38, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(39, 'Az-Zumar ', 39, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(40, 'Al-Mu’min', 40, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(41, 'Fussilat', 41, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(42, 'Asy-Syuura', 42, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(43, 'Az-Zukhruf', 43, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(44, 'Ad-Dukhaan', 44, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(45, 'Al-Jaatsiyah', 45, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(46, 'Al-Ahqaaf', 46, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(47, 'Muhammad ', 47, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(48, 'Al-Fath', 48, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(49, 'Al-Hujuraat', 49, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(50, 'Qaf', 50, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(51, 'Adz-Dzaariyaat', 51, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(52, 'Ath-Thuur', 52, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(53, 'An-Najm', 53, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(54, 'Al-Qamar', 54, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(55, 'Ar-Rahman', 55, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(56, 'Al-Waaqi’ah', 56, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(57, 'Al-Hadiid', 57, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(58, 'Al-Mujaadilah', 58, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(59, 'Al-Hasyr', 59, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(60, 'Al-Mumtahanah', 60, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(61, 'Ash-Shaff ', 61, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(62, 'Al-Jumu’ah', 62, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(63, 'Al-Munaafiquun', 63, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(64, 'At-Taghaabun', 64, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(65, 'Ath-Thalaaq', 65, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(66, 'At-Tahriim', 66, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(67, 'Al-Mulk', 67, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(68, 'Al-Qalam', 68, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(69, 'Al-Haaqqah', 69, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(70, 'Al-Ma’arij', 70, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(71, 'Nuh', 71, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(72, 'Al-Jinn', 72, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(73, 'Al-Muzzammil', 73, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(74, 'Al-Muddatstsir', 74, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(75, 'Al-Qiyamah', 75, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(76, 'Al-Insan', 76, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(77, 'Al-Mursalat', 77, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(78, 'An-Naba’', 78, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(79, 'An-Nazi’at', 79, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(80, '‘Abasa', 80, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(81, 'At-Takwir', 81, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(82, 'Al-Infitar', 82, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(83, 'Al-Muthaffifin', 83, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(84, 'Al-Insyiqaq', 84, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(85, 'Al-Buruj', 85, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(86, 'At-Tariq', 86, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(87, 'Al-A’la', 87, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(88, 'Al-Ghaasyiyah', 88, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(89, 'Al-Fajr', 89, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(90, 'Al-Balad', 90, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(91, 'Asy-Syams', 91, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(92, 'Al-Lail', 92, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(93, 'Ad-Duhaa', 93, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(94, 'Al-Insyirah', 94, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(95, 'At-Tiin', 95, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(96, 'Al-‘Alaq', 96, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(97, 'Al-Qadr', 97, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(98, 'Al-Bayyinah', 98, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(99, 'Az-Zalzalah', 99, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(100, 'Al-‘Aadiyat', 100, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(101, 'Al-Qaari’ah', 101, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(102, 'At-Takatsur ', 102, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(103, 'Al-‘Asr', 103, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(104, 'Al-Humazah', 104, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(105, 'Al-Fiil', 105, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(106, 'Quraisy', 106, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(107, 'Al-Maa’uun', 107, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(108, 'Al-Kautsar', 108, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(109, 'Al-Kaafiruun', 109, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(110, 'An-Nasr', 110, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(111, 'Al-Lahab', 111, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(112, 'Al-Ikhlas', 112, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(113, 'Al-Falaq', 113, '2020-07-17 01:42:31', '2020-07-17 01:42:31'),
(114, 'An-Naas', 114, '2020-07-17 01:42:31', '2020-07-17 01:42:31');

-- --------------------------------------------------------

--
-- Table structure for table `soorah_verses`
--

CREATE TABLE `soorah_verses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_soorah` bigint(20) UNSIGNED NOT NULL,
  `verse` int(11) NOT NULL,
  `juz` int(11) NOT NULL,
  `page` int(11) NOT NULL,
  `row_start` int(11) NOT NULL,
  `row_end` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id_student` bigint(20) UNSIGNED NOT NULL,
  `nisn` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nis` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_halaqah` bigint(20) UNSIGNED DEFAULT NULL,
  `entry_date` date DEFAULT NULL,
  `hafalan_pra_idn` int(11) DEFAULT NULL,
  `target_hafalan` int(11) DEFAULT NULL,
  `father_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `father_job` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mother_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mother_job` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `name`, `subject`, `description`, `created_at`, `updated_at`) VALUES
(1, 'asdfsdf', 'it', 'sfsdfasdf', '2020-07-17 02:03:57', '2020-07-17 02:03:57'),
(2, 'dfdsfj', 'it', 'sdkldfjsd', '2020-07-18 03:11:19', '2020-07-18 03:11:19');

-- --------------------------------------------------------

--
-- Table structure for table `tahfidzs`
--

CREATE TABLE `tahfidzs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_halaqah` bigint(20) UNSIGNED NOT NULL,
  `id_student` bigint(20) UNSIGNED NOT NULL,
  `id_teacher` bigint(20) UNSIGNED NOT NULL,
  `tanggal_setor` date DEFAULT NULL,
  `soorah_start` int(11) DEFAULT NULL,
  `soorah_end` int(11) DEFAULT NULL,
  `verse_start` int(11) DEFAULT NULL,
  `verse_end` int(11) DEFAULT NULL,
  `assessment` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` enum('manzil','sabaq') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `line` int(11) DEFAULT 0,
  `page` int(11) DEFAULT 0,
  `absen` enum('h','a','i','s') COLLATE utf8mb4_unicode_ci DEFAULT 'h',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id_teacher` bigint(20) UNSIGNED NOT NULL,
  `id_subject` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id_teacher`, `id_subject`, `created_at`, `updated_at`) VALUES
(52, 1, '2020-07-17 02:04:35', '2020-07-17 02:04:35'),
(60, 1, '2020-07-19 00:05:36', '2020-07-19 00:05:36');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` enum('l','p') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'l',
  `birth_place` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_large` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_medium` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_small` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `name`, `email`, `password`, `phone`, `gender`, `birth_place`, `birth_date`, `address`, `image_large`, `image_medium`, `image_small`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'admin', 'Admin', 'admin@admin.com', '$2y$10$3nGFc5EaT8JjXa5Yfx4ME.z4hf10/mvsFW0TiNMDT.xsgxsBkQV.e', '0', 'l', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-07-17 01:42:25', '2020-07-18 00:50:13', NULL),
(2, 'wehner.adela@example.com', 'Aurelie Price', 'nikolaus.ewald@example.org', '$2y$10$uuDfYrUCHpFThwpOOI0yYulQuiTglI7qhYsTRBqkKXncIi6LJ3Snu', '+2078733620344', 'l', NULL, NULL, NULL, NULL, NULL, NULL, 'XkFsBVtoxo', '2020-07-17 01:42:25', '2020-07-17 01:42:25', NULL),
(3, 'isabelle.hagenes@example.org', 'Hillary Langosh', 'hhaley@example.org', '$2y$10$97nZtdOt8Mg9C5D60yq2lOeFQSQ5N6PcdDjJYWTksOfBhW9appzPu', '+3178967654537', 'l', NULL, NULL, NULL, NULL, NULL, NULL, 'SsD5gadkox', '2020-07-17 01:42:26', '2020-07-17 01:42:26', NULL),
(4, 'rmcclure@example.net', 'Francis Mraz', 'meggie.effertz@example.org', '$2y$10$LzeVCV/tdkSBNo0jI5d/yOEMRptFC.ePxuJ1eWJrtXusNMDwR8YvG', '+5158586164921', 'l', NULL, NULL, NULL, NULL, NULL, NULL, 'BALxUgi5Eb', '2020-07-17 01:42:26', '2020-07-17 01:42:26', NULL),
(5, 'royce.block@example.net', 'Alberta Bartoletti', 'zmcglynn@example.org', '$2y$10$ef6gUcCIH3SxKWdxMfomvO1svzzpvcsNZhVJc/zrsOgDcDEsG6AMy', '+8415105298539', 'l', NULL, NULL, NULL, NULL, NULL, NULL, 'fB2A5fXguC', '2020-07-17 01:42:26', '2020-07-17 01:42:26', NULL),
(6, 'gcronin@example.org', 'Aglae Ernser IV', 'beryl63@example.com', '$2y$10$WxjiUaBjNZjFquXVY4qHreiXHxWbp8NhOXf5tM.3N/6ITRAm4F2Oi', '+5405952936585', 'l', NULL, NULL, NULL, NULL, NULL, NULL, 'HTMJ8VDF9a', '2020-07-17 01:42:26', '2020-07-17 01:42:26', NULL),
(7, 'geoffrey.lockman@example.net', 'Dr. King Monahan', 'gustave28@example.net', '$2y$10$GaOJxEFhF8Nad6Ft12eoMO/lJIQXvgdYLXjjKf0uPTBE44.ZFpMGa', '+6310673291075', 'l', NULL, NULL, NULL, NULL, NULL, NULL, '5AQKZ0lXPY', '2020-07-17 01:42:26', '2020-07-17 01:42:26', NULL),
(8, 'chelsie25@example.net', 'Mrs. Viviane Huel Jr.', 'king74@example.com', '$2y$10$PqcGjNoSaSSKiC4PKOmeouaVl5cgnbrvc9cqmTGtqVJGJKzwixPOO', '+9278361565112', 'l', NULL, NULL, NULL, NULL, NULL, NULL, 'qGvypqRsXP', '2020-07-17 01:42:26', '2020-07-17 01:42:26', NULL),
(9, 'schowalter.bethany@example.org', 'Dr. Royal Prohaska IV', 'anastasia.pacocha@example.org', '$2y$10$qN8f6ZKA8valvEVuGVWM5uTqLrD6trsEArQbMOSKopj9uK/sgT/oa', '+9520120705519', 'l', NULL, NULL, NULL, NULL, NULL, NULL, 'hCSdZV7i0F', '2020-07-17 01:42:26', '2020-07-17 01:42:26', NULL),
(10, 'jenkins.eloise@example.net', 'Mrs. Beryl Mayer', 'derick.conn@example.net', '$2y$10$4NID85khVU58HQsddUUbree0Mkl7LBqaInRZYOqW38n1PbLiddJxa', '+9670589107675', 'l', NULL, NULL, NULL, NULL, NULL, NULL, 'i0TcBWTXtQ', '2020-07-17 01:42:26', '2020-07-17 01:42:26', NULL),
(11, 'dleannon@example.org', 'Kristina Durgan', 'sheldon16@example.com', '$2y$10$b8SCL0Xoy3zR/enun7sZ/egrEXCVALGqiguMmsVeGcq.cgdx55gmW', '+4314732933551', 'l', NULL, NULL, NULL, NULL, NULL, NULL, 'XWjqsowZUL', '2020-07-17 01:42:26', '2020-07-17 01:42:26', NULL),
(12, 'kuhlman.alejandrin@example.org', 'Rosario Kassulke', 'pfeffer.jaydon@example.com', '$2y$10$Ht0oRxiVQkBnp7qnbi6zBuz0oN/YhwGnbquWm0UDtPR9dh3K429y.', '+9570533548712', 'l', NULL, NULL, NULL, NULL, NULL, NULL, 'sc1mSwkPUm', '2020-07-17 01:42:26', '2020-07-17 01:42:26', NULL),
(13, 'reyna87@example.net', 'Prof. Bruce Hartmann', 'schneider.rylee@example.com', '$2y$10$EPlKUx.bK20lvyW2AYGKEOhqX23csunbg1CGfPqbBZIMNQ1aoqJq6', '+6913104536822', 'l', NULL, NULL, NULL, NULL, NULL, NULL, 'LbUl269q0g', '2020-07-17 01:42:27', '2020-07-17 01:42:27', NULL),
(14, 'clarissa.pagac@example.com', 'Francisca Fisher', 'christina83@example.org', '$2y$10$IJx81EqTIFCpEx5xilJX8ON7nODvnFeX21HgjSef/7igq/CPjOHbu', '+4285026236469', 'l', NULL, NULL, NULL, NULL, NULL, NULL, 'PyHT5nc1NA', '2020-07-17 01:42:27', '2020-07-17 01:42:27', NULL),
(15, 'amir56@example.net', 'Howell O\'Connell', 'dubuque.keshaun@example.com', '$2y$10$haYCouUAqQpq8E1BA05cbuTSm8NwdmNDvumyVGd6dmZT8fPtEEIHW', '+2772535289583', 'l', NULL, NULL, NULL, NULL, NULL, NULL, 'RrI0VtgCE0', '2020-07-17 01:42:27', '2020-07-17 01:42:27', NULL),
(16, 'adrianna.waelchi@example.com', 'Mr. Darryl Carter Sr.', 'linda.mcclure@example.com', '$2y$10$IxPPiU42kqsgidBatMrI9OjF9DPadmPT3n5vRXk8ro7jyxwjniZIi', '+8320026849898', 'l', NULL, NULL, NULL, NULL, NULL, NULL, 'MfANL3aN5f', '2020-07-17 01:42:27', '2020-07-17 01:42:27', NULL),
(17, 'kellie58@example.org', 'Jordy O\'Hara', 'fwalker@example.com', '$2y$10$npLNgRFhvxGpfnMxRss3ruKE1sO/Bw3/VRz08rp1rO2/Xp7gJzcZK', '+2268705433923', 'l', NULL, NULL, NULL, NULL, NULL, NULL, '4LMYhuAiyN', '2020-07-17 01:42:27', '2020-07-17 01:42:27', NULL),
(18, 'dean.heller@example.org', 'Bartholome Lemke', 'jensen.tremblay@example.com', '$2y$10$ZuHFIbmZnCGDolTVlqscRudhJ2Pzu98mI64qhg5UpcE1iFcAMZr.a', '+8310765893520', 'l', NULL, NULL, NULL, NULL, NULL, NULL, 'wI8YOYVwhr', '2020-07-17 01:42:27', '2020-07-17 01:42:27', NULL),
(19, 'sammy.kuhlman@example.org', 'Tyrel Luettgen', 'jmoen@example.net', '$2y$10$A2SsBdUP8lJR0NNg73kWJeYJGIACT2YL5NykZZ9NaU.yHR.eleFSq', '+4676963903672', 'l', NULL, NULL, NULL, NULL, NULL, NULL, 'dpYpKY6Wzr', '2020-07-17 01:42:27', '2020-07-17 01:42:27', NULL),
(20, 'rice.lurline@example.org', 'Tobin Pouros PhD', 'matteo29@example.net', '$2y$10$0PDPmonTXrXJPt6Ew2A0VusgKVIWZ0WuvgadTdL/D.u7SmP3.8V3S', '+6975175238101', 'l', NULL, NULL, NULL, NULL, NULL, NULL, 'jh4lhJXBaj', '2020-07-17 01:42:27', '2020-07-17 01:42:27', NULL),
(21, 'emely.beier@example.net', 'Jaeden Denesik', 'kariane.maggio@example.org', '$2y$10$7uRwGRL5oSpzLO4KUBtJUOIGp/5n49BCTYQAzukVGq7hsdZ9hczWi', '+8248571626967', 'l', NULL, NULL, NULL, NULL, NULL, NULL, 'kCa88PL6iR', '2020-07-17 01:42:27', '2020-07-17 01:42:27', NULL),
(22, 'pbartoletti@example.org', 'Jaylin Stanton', 'winnifred41@example.com', '$2y$10$CObA9yx3RqjMEjANuAZcUu.pfc2fwjhEUiMmwdKEbJmNLWzbfMMMS', '+6532049497929', 'l', NULL, NULL, NULL, NULL, NULL, NULL, 'LecjLfW8e6', '2020-07-17 01:42:27', '2020-07-17 01:42:27', NULL),
(23, 'cremin.nella@example.org', 'Ryleigh Buckridge', 'gaylord.leilani@example.com', '$2y$10$LubC5/yJnEuiArDyEw8PMOKwIIFCjp1svjlpkAOHQ5GnPdbDQXDVK', '+5357863356567', 'l', NULL, NULL, NULL, NULL, NULL, NULL, 'QMW7DGWEQr', '2020-07-17 01:42:28', '2020-07-17 01:42:28', NULL),
(24, 'sauer.dave@example.net', 'Jannie Halvorson', 'keyon.ohara@example.org', '$2y$10$u3Lv7Ymz2UAreZ3pPpB4.u0GXuT9QCwE141gUYTVAZAqAZBNMCsqi', '+9956649049328', 'l', NULL, NULL, NULL, NULL, NULL, NULL, 'WzRMTaiJyF', '2020-07-17 01:42:28', '2020-07-17 01:42:28', NULL),
(25, 'ahoppe@example.net', 'Noel Ward', 'gkris@example.net', '$2y$10$ynRl1hIFuG6BSSSb/SkywekPyJpZU1YseOkTNwLUBKD.cHPvHWxGa', '+4587259994264', 'l', NULL, NULL, NULL, NULL, NULL, NULL, '5Nf2UwZK0r', '2020-07-17 01:42:28', '2020-07-17 01:42:28', NULL),
(26, 'waters.reynold@example.net', 'Darren Bailey', 'dion.runolfsdottir@example.org', '$2y$10$mFESLO5PTD5M8X2TAkMZl.3EG.ou7z7ipbJevaWpIhxweFdKqsjZm', '+9479435734735', 'l', NULL, NULL, NULL, NULL, NULL, NULL, 'PbF2CuGHSQ', '2020-07-17 01:42:28', '2020-07-17 01:42:28', NULL),
(27, 'logan.satterfield@example.org', 'Albertha Hickle', 'rita94@example.com', '$2y$10$edalorDvs7dHIAY/5Jj5xe0QlAGjOY6trnx8NkVWI1TUxy/urv5eO', '+9452200735342', 'l', NULL, NULL, NULL, NULL, NULL, NULL, 'BxkhByvZBz', '2020-07-17 01:42:28', '2020-07-17 01:42:28', NULL),
(28, 'mcremin@example.org', 'Louisa Bergstrom', 'wilhelmine.braun@example.com', '$2y$10$f0.J6bcP7eqOKLnbtI5H0.Vxa//ffRTqGSrGUEYP7PuE0bw.wtyYS', '+2332821918051', 'l', NULL, NULL, NULL, NULL, NULL, NULL, 'C8irEZPrPf', '2020-07-17 01:42:28', '2020-07-17 01:42:28', NULL),
(29, 'annalise15@example.com', 'Sarina Douglas', 'huel.kaci@example.com', '$2y$10$acb.12tDfi6ygrL/r.oc/ON52PgFOghq4uXqVZudNzSvXjPkGLVhG', '+6032411570597', 'l', NULL, NULL, NULL, NULL, NULL, NULL, 'beGpyXmUtm', '2020-07-17 01:42:28', '2020-07-17 01:42:28', NULL),
(30, 'cweimann@example.org', 'Prof. Niko Kozey', 'mohr.alexandria@example.org', '$2y$10$OGhQqRcJ4yqmkHRGZlg1qegdCjJ6o9PkO6ORqsekmCLbADYUGSh8m', '+9528150217238', 'l', NULL, NULL, NULL, NULL, NULL, NULL, 'Id46O7fdR5', '2020-07-17 01:42:28', '2020-07-17 01:42:28', NULL),
(31, 'nlegros@example.org', 'Abraham Dooley', 'kareem52@example.com', '$2y$10$hGNV.twur0QlCpPZSFIh3.N5fpWId2fwqVq8LvyDnEVz1bDS2S7Du', '+3259656365370', 'l', NULL, NULL, NULL, NULL, NULL, NULL, 'WBL3ZW2K4K', '2020-07-17 01:42:28', '2020-07-17 01:42:28', NULL),
(32, 'sabernathy@example.net', 'Miss Elena Skiles', 'gislason.mabelle@example.net', '$2y$10$IFtqSakTkPnhtob4y3t5iuqKDBkgLD/E2JhKnmrDbLY3nDvT63kXe', '+2486629995317', 'l', NULL, NULL, NULL, NULL, NULL, NULL, 'jdRh1e67vn', '2020-07-17 01:42:28', '2020-07-17 01:42:28', NULL),
(33, 'qvandervort@example.net', 'Bernice Hodkiewicz', 'xgoodwin@example.org', '$2y$10$WnpLwLzzoiNDLpiPETsOMO4hTTI9vBvMrjKBV0//P215T2.4Tupqe', '+3662572180273', 'l', NULL, NULL, NULL, NULL, NULL, NULL, 'wqjI861omQ', '2020-07-17 01:42:29', '2020-07-17 01:42:29', NULL),
(34, 'arely.oberbrunner@example.com', 'Dolly Thompson Jr.', 'beatrice54@example.net', '$2y$10$/gNwfaXmiVdRl8qI86RbZu3fyTSDVOTn4aEMAacGxYva5gUelOPvm', '+1285886404697', 'l', NULL, NULL, NULL, NULL, NULL, NULL, 'B9W0W7QtQS', '2020-07-17 01:42:29', '2020-07-17 01:42:29', NULL),
(35, 'hyatt.emmitt@example.com', 'Louie Wisoky', 'olson.drew@example.com', '$2y$10$fzfoJpetlEXLjJ4.KLj..eECFLFyPhTEc7eLWDuvRwXkL95OE0eeu', '+2215925117021', 'l', NULL, NULL, NULL, NULL, NULL, NULL, 'zQIRn8aFPv', '2020-07-17 01:42:29', '2020-07-17 01:42:29', NULL),
(36, 'astanton@example.org', 'Ford Jerde PhD', 'emma.hessel@example.org', '$2y$10$GcAcJEIWgeAFvxl3Lpb4auK1KZqRIU5i4lbyHQXnQh3H5qa90e85W', '+3954220833056', 'l', NULL, NULL, NULL, NULL, NULL, NULL, '5ONd8MNZ0O', '2020-07-17 01:42:29', '2020-07-17 01:42:29', NULL),
(37, 'fhagenes@example.org', 'Dr. Casper Durgan PhD', 'hbruen@example.org', '$2y$10$28HnL6Unzv21sBfwtKXUcOSL.adPPsRMpcX3SCN2fltIJkgAk2aom', '+4061748307237', 'l', NULL, NULL, NULL, NULL, NULL, NULL, '3HO29NZuCU', '2020-07-17 01:42:29', '2020-07-17 01:42:29', NULL),
(38, 'roberto.kovacek@example.net', 'Henry Jakubowski', 'hrunte@example.net', '$2y$10$8JcWYhHOuDEVyHgMZxiGLeL13udQaBo2QpCIYrEm3Mun8pXlzX53i', '+4181718975190', 'l', NULL, NULL, NULL, NULL, NULL, NULL, 'ZyYXzXk9sC', '2020-07-17 01:42:29', '2020-07-17 01:42:29', NULL),
(39, 'ptromp@example.com', 'Asha Marquardt', 'enid63@example.org', '$2y$10$7Gjxsg6Chu8Ia1.iy0S4zeffXA5CBNmPWmJI.clFcjG2N7Bpzm7ga', '+5193223414430', 'l', NULL, NULL, NULL, NULL, NULL, NULL, 'I71AzBjNrw', '2020-07-17 01:42:29', '2020-07-17 01:42:29', NULL),
(40, 'kklein@example.net', 'Isac Wehner', 'sconroy@example.org', '$2y$10$APOuc8CC/Tli3DSAmgpPRuas32C9KqebUZYpAYIMnkzI0lK3WWt.a', '+2640167163210', 'l', NULL, NULL, NULL, NULL, NULL, NULL, 'IRSRvqIx8z', '2020-07-17 01:42:29', '2020-07-17 01:42:29', NULL),
(41, 'henriette72@example.org', 'Florence Brown', 'nsimonis@example.net', '$2y$10$xpu0nluN8sz6HayS1rs3beXvP/5Zen/j9w/I.586HBLd8lBCpa1qu', '+5440131225477', 'l', NULL, NULL, NULL, NULL, NULL, NULL, 'Qy3VIbI7JE', '2020-07-17 01:42:29', '2020-07-17 01:42:29', NULL),
(42, 'haley.haylie@example.org', 'Kathryne Rosenbaum', 'omorissette@example.net', '$2y$10$tUhPQKSYLHai0QQkS3qCf.FUkuvB8fYBaQbb96/PqAbhc04BXJCs6', '+6979822086368', 'l', NULL, NULL, NULL, NULL, NULL, NULL, '8KTIC0zjKv', '2020-07-17 01:42:29', '2020-07-17 01:42:29', NULL),
(43, 'columbus42@example.org', 'Dana Batz II', 'brakus.zita@example.com', '$2y$10$FNsE9YVmNLm/PPf6MCSy/ejngX1ZwTMDYQPsH/3xsCY8jFr1/ZZBC', '+7845864988321', 'l', NULL, NULL, NULL, NULL, NULL, NULL, 'm6HEeARpyE', '2020-07-17 01:42:30', '2020-07-17 01:42:30', NULL),
(44, 'mariela.oberbrunner@example.com', 'Dr. Lori Walter II', 'cassie.friesen@example.com', '$2y$10$PQK4UeE8wCyROYZqs/jxKeOUfnr2DwZuH2KG./xDISpBT.YNfDj9O', '+7475694905250', 'l', NULL, NULL, NULL, NULL, NULL, NULL, 'MinnfeHVjK', '2020-07-17 01:42:30', '2020-07-17 01:42:30', NULL),
(45, 'briana.kozey@example.com', 'Pauline Dickinson', 'shirley.rohan@example.net', '$2y$10$8vfAGXLbbB5B3D.9Eu1.c.H28zaZo6r8wlL9oMq83m9yjzlcskYj.', '+7642414580894', 'l', NULL, NULL, NULL, NULL, NULL, NULL, '0QTdjktGWX', '2020-07-17 01:42:30', '2020-07-17 01:42:30', NULL),
(46, 'oceane.krajcik@example.org', 'Tremayne Hermann', 'ycarroll@example.net', '$2y$10$ln46cGUK/e4fy0xuIXB2G.f.m69n/M5UfVndKnFgRAMzAkDhvl5ma', '+2383833887476', 'l', NULL, NULL, NULL, NULL, NULL, NULL, 'l0ClFDb6jK', '2020-07-17 01:42:30', '2020-07-17 01:42:30', NULL),
(47, 'hoeger.meaghan@example.com', 'Maxine Murazik', 'iwintheiser@example.org', '$2y$10$uRbuYAoUwNKVPtV1c85rd.tsq70wJntrhqFFtUmEyPiJHargIwV6C', '+8035740918236', 'l', NULL, NULL, NULL, NULL, NULL, NULL, 'HQjYklbd3y', '2020-07-17 01:42:30', '2020-07-17 01:42:30', NULL),
(48, 'mikel.braun@example.net', 'Eda Nicolas', 'idella90@example.net', '$2y$10$9fJkUnhF65Te5si/Y.PUFevAPlfVBLjkJxsjeKOQ5Ujg3fJfk3NNa', '+1946183352368', 'l', NULL, NULL, NULL, NULL, NULL, NULL, 'qeKrOHLRuB', '2020-07-17 01:42:30', '2020-07-17 01:42:30', NULL),
(49, 'gkutch@example.com', 'Hannah Daniel', 'stroman.oma@example.org', '$2y$10$L1IpU0aVOBbzfl87MbBiHeWvnapwAABCW21Wc/bNVNmZ2vkgAc2y2', '+8774498726037', 'l', NULL, NULL, NULL, NULL, NULL, NULL, 'W3Y9BZ3h4e', '2020-07-17 01:42:30', '2020-07-17 01:42:30', NULL),
(50, 'windler.brock@example.net', 'Mr. Columbus Howe', 'simonis.carey@example.org', '$2y$10$6dKLK3lTjFZ8zGw6SzuvWeKV7lvZxR07y7beVl7GIxvDeFmtn/KCC', '+8482613412197', 'l', NULL, NULL, NULL, NULL, NULL, NULL, 'BEzEKrzzSU', '2020-07-17 01:42:30', '2020-07-17 01:42:30', NULL),
(51, 'oconnell.herbert@example.net', 'Wilma Feest', 'mccullough.lily@example.com', '$2y$10$eVEtwjVogoB2KGuyDUAQN.VSVuC.6eBOnJhokVvQpTJnWXW9PTDc.', '+8547701520591', 'l', NULL, NULL, NULL, NULL, NULL, NULL, 'QRdgQdySMr', '2020-07-17 01:42:30', '2020-07-17 01:42:30', NULL),
(52, 'lkasdfjsd', 'sdsdfewsaf', 'sdfsdf@gmail.com', '$2y$10$Sn79etJ9EeBcqJC1.J6IQO57/RuRfORqnej.1DzFuy4xh6jfWVIL2', '87383738', 'l', 'sdjf', '2019-12-31', 'sdklfsdfj', 'users/52/image_lg_52_20200719150634.png', 'users/52/image_md_52_20200719150635.png', 'users/52/image_sm_52_20200719150635.png', NULL, '2020-07-17 02:04:35', '2020-07-19 08:06:35', NULL),
(53, 'sdlkafjkls', 'klasfdjeiwsdf', 'sdlkfjsdf@gmail.com', '$2y$10$CqgivAh7bgyaf7/iOHRFBOPRCP5pKZ/TQ1d5q7t5WcSE6k42z.cA6', '838398373', 'l', 'adsfwafsdf', '2019-12-31', 'sdfkjsdfj', NULL, NULL, NULL, NULL, '2020-07-17 02:05:19', '2020-07-17 02:05:19', NULL),
(58, 'slkdfj', 'adminsdfasfd', 'sdfasdf@gmail.com', '$2y$10$g21JpXc74rn6Uz5mHrR9uec.ItPmIGmeMnXs5jSeAEsq1xrVKDAPi', '948393389', 'l', 'sadfewsadf', '2020-07-16', NULL, NULL, NULL, NULL, NULL, '2020-07-17 02:57:28', '2020-07-17 02:57:28', NULL),
(59, 'sldkfjkdslf', 'klasfdjkdsf', 'slkfjksldf@gmail.com', '$2y$10$1mVnBpxiCuVD5gGRKFQT6.j2oaOxwehghv7.Kn31q84Zttvcd.w1O', '983893839', 'l', 'sdfwesdfsdf', '2017-01-01', 'sdfwesfwesdf', NULL, NULL, NULL, NULL, '2020-07-17 06:32:49', '2020-07-17 06:32:49', NULL),
(60, 'lkasdfjlksdfj', 'sdfewsadfsdf', 'sdflksdf@gmail.com', '$2y$10$VX62xyQZxTTH3ZNATD7onucASRr1oRk4T66WZldrXKyIrrEsMMfX2', '84847473883', 'p', 'sdfwesadfsdf', '2019-12-31', 'sdafsdfsaf', 'users/60/image_lg_60_20200719070536.JPG', 'users/60/image_md_60_20200719070536.JPG', 'users/60/image_sm_60_20200719070536.JPG', NULL, '2020-07-19 00:05:36', '2020-07-19 00:05:36', NULL),
(63, 'ortu2', 'ortu2', 'ortu2@gmail.com', '$2y$10$vrCLIxIzfWe3VEQO4M4Cku9JwKShjz./0tP9ZUr1rJNJd84Qr4WV2', '38488494838', 'l', NULL, NULL, NULL, 'users/63/image_lg_63_20200719143329.png', 'users/63/image_md_63_20200719143330.png', 'users/63/image_sm_63_20200719143330.png', NULL, '2020-07-19 06:39:21', '2020-07-19 07:33:31', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `halaqahs`
--
ALTER TABLE `halaqahs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `halaqahs_id_teacher_foreign` (`id_teacher`);

--
-- Indexes for table `juzs`
--
ALTER TABLE `juzs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parents`
--
ALTER TABLE `parents`
  ADD KEY `parents_id_parents_foreign` (`id_parents`),
  ADD KEY `parents_id_student_foreign` (`id_student`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles_routes`
--
ALTER TABLE `roles_routes`
  ADD KEY `roles_routes_roles_id_foreign` (`roles_id`),
  ADD KEY `roles_routes_routes_id_foreign` (`routes_id`);

--
-- Indexes for table `roles_users`
--
ALTER TABLE `roles_users`
  ADD KEY `roles_users_roles_id_foreign` (`roles_id`),
  ADD KEY `roles_users_users_id_foreign` (`users_id`);

--
-- Indexes for table `routes`
--
ALTER TABLE `routes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `school_years`
--
ALTER TABLE `school_years`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `soorahs`
--
ALTER TABLE `soorahs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `soorah_verses`
--
ALTER TABLE `soorah_verses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `soorah_verses_id_soorah_foreign` (`id_soorah`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD KEY `students_id_student_foreign` (`id_student`),
  ADD KEY `students_id_halaqah_foreign` (`id_halaqah`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tahfidzs`
--
ALTER TABLE `tahfidzs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tahfidzs_id_halaqah_foreign` (`id_halaqah`),
  ADD KEY `tahfidzs_id_student_foreign` (`id_student`),
  ADD KEY `tahfidzs_id_teacher_foreign` (`id_teacher`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD KEY `teachers_id_teacher_foreign` (`id_teacher`),
  ADD KEY `teachers_id_subject_foreign` (`id_subject`);

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
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `halaqahs`
--
ALTER TABLE `halaqahs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `juzs`
--
ALTER TABLE `juzs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `routes`
--
ALTER TABLE `routes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `school_years`
--
ALTER TABLE `school_years`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `soorahs`
--
ALTER TABLE `soorahs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT for table `soorah_verses`
--
ALTER TABLE `soorah_verses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tahfidzs`
--
ALTER TABLE `tahfidzs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `halaqahs`
--
ALTER TABLE `halaqahs`
  ADD CONSTRAINT `halaqahs_id_teacher_foreign` FOREIGN KEY (`id_teacher`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `parents`
--
ALTER TABLE `parents`
  ADD CONSTRAINT `parents_id_parents_foreign` FOREIGN KEY (`id_parents`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `parents_id_student_foreign` FOREIGN KEY (`id_student`) REFERENCES `students` (`id_student`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `roles_routes`
--
ALTER TABLE `roles_routes`
  ADD CONSTRAINT `roles_routes_roles_id_foreign` FOREIGN KEY (`roles_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `roles_routes_routes_id_foreign` FOREIGN KEY (`routes_id`) REFERENCES `routes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `roles_users`
--
ALTER TABLE `roles_users`
  ADD CONSTRAINT `roles_users_roles_id_foreign` FOREIGN KEY (`roles_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `roles_users_users_id_foreign` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `soorah_verses`
--
ALTER TABLE `soorah_verses`
  ADD CONSTRAINT `soorah_verses_id_soorah_foreign` FOREIGN KEY (`id_soorah`) REFERENCES `soorahs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_id_halaqah_foreign` FOREIGN KEY (`id_halaqah`) REFERENCES `halaqahs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `students_id_student_foreign` FOREIGN KEY (`id_student`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tahfidzs`
--
ALTER TABLE `tahfidzs`
  ADD CONSTRAINT `tahfidzs_id_halaqah_foreign` FOREIGN KEY (`id_halaqah`) REFERENCES `halaqahs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tahfidzs_id_student_foreign` FOREIGN KEY (`id_student`) REFERENCES `students` (`id_student`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tahfidzs_id_teacher_foreign` FOREIGN KEY (`id_teacher`) REFERENCES `teachers` (`id_teacher`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `teachers`
--
ALTER TABLE `teachers`
  ADD CONSTRAINT `teachers_id_subject_foreign` FOREIGN KEY (`id_subject`) REFERENCES `subjects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `teachers_id_teacher_foreign` FOREIGN KEY (`id_teacher`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
