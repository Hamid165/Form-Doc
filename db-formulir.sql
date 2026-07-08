-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.4.3 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table db-formulir.cache
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db-formulir.cache: ~0 rows (approximately)

-- Dumping structure for table db-formulir.cache_locks
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db-formulir.cache_locks: ~0 rows (approximately)

-- Dumping structure for table db-formulir.categories
CREATE TABLE IF NOT EXISTS `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db-formulir.categories: ~0 rows (approximately)
INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
	(2, 'UMUM', '2026-07-01 20:38:24', '2026-07-01 20:38:24');

-- Dumping structure for table db-formulir.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db-formulir.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table db-formulir.form_cctvs
CREATE TABLE IF NOT EXISTS `form_cctvs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `no_ref` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `business_area` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_cctv` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lokasi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mengetahui_nama` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mengetahui_nipp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mengetahui_jabatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `kota_tanggal` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db-formulir.form_cctvs: ~3 rows (approximately)
INSERT INTO `form_cctvs` (`id`, `no_ref`, `tanggal`, `business_area`, `id_cctv`, `lokasi`, `mengetahui_nama`, `mengetahui_nipp`, `mengetahui_jabatan`, `created_at`, `updated_at`, `kota_tanggal`) VALUES
	(13, '01/02/2020', '2026-07-03', 'hamid', 'CCTV-2', 'Kantor Daop - SDM', 'Hamid Sabirin', '15432', 'Manajer', '2026-07-02 23:49:56', '2026-07-06 06:45:52', '3 Juli 2026'),
	(14, '12345', '2026-07-05', 'B060', 'CCTV-3', 'SEKRE', 'Hamid', '12345', 'Staff Sistem Informasi', '2026-07-05 19:16:54', '2026-07-06 06:41:12', '5 Juli 2026'),
	(17, '12324356', '2026-07-06', 'B060', 'CCTV-5', 'SATPAM', 'Hamid', '12345', 'Staff Sistem Informasi', '2026-07-05 20:24:50', '2026-07-06 06:41:12', '06 Juli 2026');

-- Dumping structure for table db-formulir.form_cctv_items
CREATE TABLE IF NOT EXISTS `form_cctv_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `form_cctv_id` bigint unsigned NOT NULL,
  `no` int DEFAULT NULL,
  `tanggal` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis_kegiatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `paraf` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `form_cctv_items_form_cctv_id_foreign` (`form_cctv_id`),
  CONSTRAINT `form_cctv_items_form_cctv_id_foreign` FOREIGN KEY (`form_cctv_id`) REFERENCES `form_cctvs` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=623 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db-formulir.form_cctv_items: ~42 rows (approximately)
INSERT INTO `form_cctv_items` (`id`, `form_cctv_id`, `no`, `tanggal`, `jenis_kegiatan`, `keterangan`, `paraf`, `created_at`, `updated_at`) VALUES
	(459, 13, 1, '3 Juli 2026', '{"perawatan":"V","perbaikan":"-"}', 'wq', 'wqd', '2026-07-03 00:25:26', '2026-07-03 00:25:26'),
	(460, 13, 2, NULL, '{"perawatan":"-","perbaikan":"-"}', NULL, NULL, '2026-07-03 00:25:26', '2026-07-03 00:25:26'),
	(461, 13, 3, NULL, '{"perawatan":"-","perbaikan":"-"}', NULL, NULL, '2026-07-03 00:25:26', '2026-07-03 00:25:26'),
	(462, 13, 4, NULL, '{"perawatan":"-","perbaikan":"-"}', NULL, NULL, '2026-07-03 00:25:26', '2026-07-03 00:25:26'),
	(463, 13, 5, NULL, '{"perawatan":"-","perbaikan":"-"}', NULL, NULL, '2026-07-03 00:25:26', '2026-07-03 00:25:26'),
	(464, 13, 6, NULL, '{"perawatan":"-","perbaikan":"-"}', NULL, NULL, '2026-07-03 00:25:26', '2026-07-03 00:25:26'),
	(465, 13, 7, NULL, '{"perawatan":"-","perbaikan":"-"}', NULL, NULL, '2026-07-03 00:25:26', '2026-07-03 00:25:26'),
	(466, 13, 8, NULL, '{"perawatan":"-","perbaikan":"-"}', NULL, NULL, '2026-07-03 00:25:26', '2026-07-03 00:25:26'),
	(467, 13, 9, NULL, '{"perawatan":"-","perbaikan":"-"}', NULL, NULL, '2026-07-03 00:25:26', '2026-07-03 00:25:26'),
	(468, 13, 10, NULL, '{"perawatan":"-","perbaikan":"-"}', NULL, NULL, '2026-07-03 00:25:26', '2026-07-03 00:25:26'),
	(469, 13, 11, NULL, '{"perawatan":"-","perbaikan":"-"}', NULL, NULL, '2026-07-03 00:25:26', '2026-07-03 00:25:26'),
	(470, 13, 12, NULL, '{"perawatan":"-","perbaikan":"-"}', NULL, NULL, '2026-07-03 00:25:26', '2026-07-03 00:25:26'),
	(471, 13, 13, NULL, '{"perawatan":"-","perbaikan":"-"}', NULL, NULL, '2026-07-03 00:25:26', '2026-07-03 00:25:26'),
	(472, 13, 14, NULL, '{"perawatan":"-","perbaikan":"-"}', NULL, NULL, '2026-07-03 00:25:26', '2026-07-03 00:25:26'),
	(473, 13, 15, NULL, '{"perawatan":"-","perbaikan":"-"}', NULL, NULL, '2026-07-03 00:25:26', '2026-07-03 00:25:26'),
	(474, 13, 16, NULL, '{"perawatan":"-","perbaikan":"-"}', NULL, NULL, '2026-07-03 00:25:26', '2026-07-03 00:25:26'),
	(475, 13, 17, NULL, '{"perawatan":"-","perbaikan":"-"}', NULL, NULL, '2026-07-03 00:25:26', '2026-07-03 00:25:26'),
	(476, 13, 18, NULL, '{"perawatan":"-","perbaikan":"-"}', NULL, NULL, '2026-07-03 00:25:26', '2026-07-03 00:25:26'),
	(477, 13, 19, NULL, '{"perawatan":"-","perbaikan":"-"}', NULL, NULL, '2026-07-03 00:25:26', '2026-07-03 00:25:26'),
	(478, 13, 20, NULL, '{"perawatan":"-","perbaikan":"-"}', NULL, NULL, '2026-07-03 00:25:26', '2026-07-03 00:25:26'),
	(539, 14, 1, '2026-07-07', '{"perawatan":"V","perbaikan":"-"}', NULL, NULL, '2026-07-05 19:51:06', '2026-07-05 19:51:06'),
	(540, 14, 2, '2026-07-06', '{"perawatan":"-","perbaikan":"V"}', NULL, NULL, '2026-07-05 19:51:06', '2026-07-05 19:51:06'),
	(541, 14, 3, '2026-07-01', '{"perawatan":"V","perbaikan":"-"}', NULL, NULL, '2026-07-05 19:51:06', '2026-07-05 19:51:06'),
	(542, 14, 4, NULL, '{"perawatan":"-","perbaikan":"-"}', NULL, NULL, '2026-07-05 19:51:06', '2026-07-05 19:51:06'),
	(543, 14, 5, NULL, '{"perawatan":"-","perbaikan":"-"}', NULL, NULL, '2026-07-05 19:51:06', '2026-07-05 19:51:06'),
	(544, 14, 6, NULL, '{"perawatan":"-","perbaikan":"-"}', NULL, NULL, '2026-07-05 19:51:06', '2026-07-05 19:51:06'),
	(545, 14, 7, NULL, '{"perawatan":"-","perbaikan":"-"}', NULL, NULL, '2026-07-05 19:51:06', '2026-07-05 19:51:06'),
	(546, 14, 8, NULL, '{"perawatan":"-","perbaikan":"-"}', NULL, NULL, '2026-07-05 19:51:06', '2026-07-05 19:51:06'),
	(547, 14, 9, NULL, '{"perawatan":"-","perbaikan":"-"}', NULL, NULL, '2026-07-05 19:51:06', '2026-07-05 19:51:06'),
	(548, 14, 10, NULL, '{"perawatan":"-","perbaikan":"-"}', NULL, NULL, '2026-07-05 19:51:06', '2026-07-05 19:51:06'),
	(549, 14, 11, NULL, '{"perawatan":"-","perbaikan":"-"}', NULL, NULL, '2026-07-05 19:51:06', '2026-07-05 19:51:06'),
	(550, 14, 12, NULL, '{"perawatan":"-","perbaikan":"-"}', NULL, NULL, '2026-07-05 19:51:06', '2026-07-05 19:51:06'),
	(551, 14, 13, NULL, '{"perawatan":"-","perbaikan":"-"}', NULL, NULL, '2026-07-05 19:51:06', '2026-07-05 19:51:06'),
	(552, 14, 14, NULL, '{"perawatan":"-","perbaikan":"-"}', NULL, NULL, '2026-07-05 19:51:06', '2026-07-05 19:51:06'),
	(553, 14, 15, NULL, '{"perawatan":"-","perbaikan":"-"}', NULL, NULL, '2026-07-05 19:51:06', '2026-07-05 19:51:06'),
	(554, 14, 16, NULL, '{"perawatan":"-","perbaikan":"-"}', NULL, NULL, '2026-07-05 19:51:06', '2026-07-05 19:51:06'),
	(555, 14, 17, NULL, '{"perawatan":"-","perbaikan":"-"}', NULL, NULL, '2026-07-05 19:51:06', '2026-07-05 19:51:06'),
	(556, 14, 18, NULL, '{"perawatan":"-","perbaikan":"-"}', NULL, NULL, '2026-07-05 19:51:06', '2026-07-05 19:51:06'),
	(557, 14, 19, NULL, '{"perawatan":"-","perbaikan":"-"}', NULL, NULL, '2026-07-05 19:51:06', '2026-07-05 19:51:06'),
	(558, 14, 20, NULL, '{"perawatan":"-","perbaikan":"-"}', NULL, NULL, '2026-07-05 19:51:06', '2026-07-05 19:51:06'),
	(621, 17, 1, '06 Juli 2026', '{"perawatan":"V","perbaikan":"-"}', 'tes', NULL, '2026-07-05 21:00:20', '2026-07-05 21:00:20'),
	(622, 17, 2, '07 Juli 2026', '{"perawatan":"-","perbaikan":"V"}', 'hari 7 juli', NULL, '2026-07-05 21:00:20', '2026-07-05 21:00:20');

-- Dumping structure for table db-formulir.form_revocations
CREATE TABLE IF NOT EXISTS `form_revocations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `no_ref` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `business_area` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_permohonan` date DEFAULT NULL,
  `nama_pemohon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nip_pemohon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bagian_fungsi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kota_tanggal_pemohon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_persetujuan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kota_tanggal_setuju` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mengetahui_nama` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jabatan_mengetahui` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db-formulir.form_revocations: ~2 rows (approximately)
INSERT INTO `form_revocations` (`id`, `no_ref`, `tanggal`, `business_area`, `tanggal_permohonan`, `nama_pemohon`, `nip_pemohon`, `bagian_fungsi`, `kota_tanggal_pemohon`, `status_persetujuan`, `kota_tanggal_setuju`, `mengetahui_nama`, `jabatan_mengetahui`, `created_at`, `updated_at`) VALUES
	(3, '123', '2026-07-07', 'B060', '2026-07-07', 'Agus Pratama', '53421', 'tes', '07 - Juli - 2026', 'DISETUJUI', '07 - Juli - 2026', 'hamid', 'Manajemen Puncak', '2026-07-07 00:01:57', '2026-07-07 00:27:09'),
	(4, '321', '2026-07-07', 'B060', '2026-07-07', 'Budi Santoso', '12345', 'tes', '07 - Juli - 2026', 'DISETUJUI', '07 - Juli - 2026', 'hamid', 'Manajemen Puncak', '2026-07-07 00:02:20', '2026-07-07 00:26:14');

-- Dumping structure for table db-formulir.form_revocation_items
CREATE TABLE IF NOT EXISTS `form_revocation_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `form_revocation_id` bigint unsigned NOT NULL,
  `no` int DEFAULT NULL,
  `nama_pengguna` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis_akun` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unit_kerja` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alasan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `form_revocation_items_form_revocation_id_foreign` (`form_revocation_id`),
  CONSTRAINT `form_revocation_items_form_revocation_id_foreign` FOREIGN KEY (`form_revocation_id`) REFERENCES `form_revocations` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db-formulir.form_revocation_items: ~2 rows (approximately)
INSERT INTO `form_revocation_items` (`id`, `form_revocation_id`, `no`, `nama_pengguna`, `jenis_akun`, `unit_kerja`, `alasan`, `created_at`, `updated_at`) VALUES
	(3, 3, 0, 'Agus Pratama - 53421', 'tes', 'tes', 'tes', '2026-07-07 00:01:57', '2026-07-07 00:27:09'),
	(4, 4, 0, 'Budi Santoso - 12345', 'ty', 'ty', 'ty', '2026-07-07 00:02:20', '2026-07-07 00:26:14');

-- Dumping structure for table db-formulir.form_templates
CREATE TABLE IF NOT EXISTS `form_templates` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `route_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_dokumen` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_dokumen` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `versi_dokumen` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db-formulir.form_templates: ~2 rows (approximately)
INSERT INTO `form_templates` (`id`, `nama`, `kategori`, `route_name`, `no_dokumen`, `tanggal_dokumen`, `versi_dokumen`, `created_at`, `updated_at`) VALUES
	(1, 'Pemeliharaan CCTV', 'Umum', 'form-cctv.index', 'FR.SM/TI/015.013/10-2020', '12 Oktober 2020', '002-2020', '2026-07-06 06:11:30', '2026-07-06 06:38:59'),
	(2, 'Permohonan Pencabutan Hak Akses', 'Public', 'form-pencabutan-hak-akses.index', 'FR.SM/TI/011/02-2020', '10 Februari 2020', '001-2020', '2026-07-06 06:11:30', '2026-07-06 06:11:30');

-- Dumping structure for table db-formulir.jobs
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db-formulir.jobs: ~0 rows (approximately)

-- Dumping structure for table db-formulir.job_batches
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db-formulir.job_batches: ~0 rows (approximately)

-- Dumping structure for table db-formulir.master_cctvs
CREATE TABLE IF NOT EXISTS `master_cctvs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_cctv` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lokasi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db-formulir.master_cctvs: ~8 rows (approximately)
INSERT INTO `master_cctvs` (`id`, `id_cctv`, `lokasi`, `created_at`, `updated_at`) VALUES
	(4, 'CCTV-2', 'Kantor Daop - SDM', '2026-07-02 23:29:43', '2026-07-05 19:48:02'),
	(5, 'CCTV-3', 'SEKRE', '2026-07-02 23:29:58', '2026-07-02 23:29:58'),
	(6, 'CCTV-4', 'BENDAHARA', '2026-07-02 23:30:07', '2026-07-02 23:30:07'),
	(7, 'CCTV-5', 'SATPAM', '2026-07-02 23:30:18', '2026-07-02 23:30:18'),
	(8, 'CCTV-6', 'PARKIRAN', '2026-07-02 23:30:26', '2026-07-02 23:30:26'),
	(9, 'CCTV-1', 'Hamid', '2026-07-02 23:52:30', '2026-07-05 19:36:35'),
	(10, 'CCTV-X1', 'Stasiun Tugu', '2026-07-05 21:29:54', '2026-07-05 21:29:54'),
	(12, 'CCTV-X2', 'Ruang Server', '2026-07-05 22:05:18', '2026-07-05 22:05:18');

-- Dumping structure for table db-formulir.master_pemohons
CREATE TABLE IF NOT EXISTS `master_pemohons` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_pemohon` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nip_pemohon` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db-formulir.master_pemohons: ~7 rows (approximately)
INSERT INTO `master_pemohons` (`id`, `nama_pemohon`, `nip_pemohon`, `created_at`, `updated_at`) VALUES
	(1, 'Budi Santoso', '12345', '2026-07-07 00:01:24', '2026-07-07 00:26:14'),
	(2, 'Siti Aminah', '23451', '2026-07-07 00:01:24', '2026-07-07 00:26:24'),
	(3, 'Andi Wijaya', '34512', '2026-07-07 00:01:24', '2026-07-07 00:26:35'),
	(4, 'Rina Melati', '45123', '2026-07-07 00:01:24', '2026-07-07 00:26:42'),
	(5, 'Hendra Gunawan', '51234', '2026-07-07 00:01:24', '2026-07-07 00:26:50'),
	(6, 'Dewi Lestari', '54321', '2026-07-07 00:01:24', '2026-07-07 00:27:02'),
	(7, 'Agus Pratama', '53421', '2026-07-07 00:01:24', '2026-07-07 00:27:09');

-- Dumping structure for table db-formulir.master_signers
CREATE TABLE IF NOT EXISTS `master_signers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nipp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jabatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db-formulir.master_signers: ~6 rows (approximately)
INSERT INTO `master_signers` (`id`, `nama`, `nipp`, `jabatan`, `created_at`, `updated_at`) VALUES
	(1, 'Hamid Sabirin', '15432', 'Manajer', '2026-07-02 23:14:13', '2026-07-06 06:45:52'),
	(2, 'Qonita Rahayu Atmi', '13245', 'Asisten Manager Support 1', '2026-07-02 23:16:34', '2026-07-06 06:46:07'),
	(3, 'Qonita', '12324', 'Manajer SI', '2026-07-02 23:24:55', '2026-07-05 20:45:19'),
	(4, 'Hamid', '12345', 'Staff Sistem Informasi', '2026-07-02 23:25:01', '2026-07-06 06:41:12'),
	(5, 'wqer', '12', NULL, '2026-07-02 23:25:06', '2026-07-02 23:25:06'),
	(6, 'we', '12354', 'Asisten Manager Support 2', '2026-07-02 23:25:12', '2026-07-06 06:46:15');

-- Dumping structure for table db-formulir.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db-formulir.migrations: ~16 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(6, '0001_01_01_000000_create_users_table', 1),
	(7, '0001_01_01_000001_create_cache_table', 1),
	(8, '0001_01_01_000002_create_jobs_table', 1),
	(9, '2026_07_01_031010_create_form_cctvs_table', 1),
	(10, '2026_07_01_031015_create_form_cctv_items_table', 1),
	(11, '2026_07_01_041423_add_kota_tanggal_to_form_cctvs_table', 2),
	(12, '2026_07_02_033417_create_categories_table', 3),
	(13, '2026_07_03_035657_create_form_pencabutan_hak_akses_table', 4),
	(14, '2026_07_03_035700_create_form_pencabutan_hak_akses_items_table', 4),
	(15, '2026_07_03_053000_add_nip_pemohon_to_form_pencabutan_hak_akses_table', 4),
	(16, '2026_07_03_060757_create_master_cctvs_table', 5),
	(17, '2026_07_03_060803_create_master_signers_table', 5),
	(18, '2026_07_06_033346_add_jabatan_to_master_signers_table', 6),
	(19, '2026_07_06_033352_add_mengetahui_jabatan_to_form_cctvs_table', 6),
	(20, '2026_07_06_131038_create_form_templates_table', 7),
	(21, '2026_07_07_044310_create_master_pemohons_table', 8);

-- Dumping structure for table db-formulir.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db-formulir.password_reset_tokens: ~0 rows (approximately)

-- Dumping structure for table db-formulir.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db-formulir.sessions: ~3 rows (approximately)
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('Eo5WmeaqVjs7FitByCfGqshO62nTThilq6fOSU0U', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJWcjhaRzRWeUY3Y2NBMkxQTGZkSWM0Q05HM29PS3oxcUNEeHJOY3RUIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9mb3JtLXBlbmNhYnV0YW4taGFrLWFrc2VzIiwicm91dGUiOiJmb3JtLXBlbmNhYnV0YW4taGFrLWFrc2VzLmluZGV4In0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1783409271),
	('KffUJoZieMhUsm8waTFpVcpioSlnq7YnQmt3IXzj', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJkT0FWZmZ0YWRMc0UxUmpkdVF2bWRLMjNkVW5LVEFNNjNsR0JlUjNJIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9mb3JtLWNjdHYiLCJyb3V0ZSI6ImZvcm0tY2N0di5pbmRleCJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19', 1783407103),
	('q86HgJn8Q2LSer8TRNgJnPZGiivZhl9Jtdk15Xfs', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJydWlrT2JBbG80REJSalBsWEdWMGVPTGtEVkxMcVY0VE80ZW9vY2R0IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9mb3JtLWNjdHYiLCJyb3V0ZSI6ImZvcm0tY2N0di5pbmRleCJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19', 1783407103);

-- Dumping structure for table db-formulir.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db-formulir.users: ~1 rows (approximately)
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Test User', 'test@example.com', '2026-07-06 23:51:49', '$2y$12$zZwRXJGqPNYYHQZkxeYALeUR8HC1nzhoEU6zoEJd5Q8IEHr2EDwy6', 'HBUjCXmfq2', '2026-07-06 23:51:50', '2026-07-06 23:51:50');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
