-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
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

-- Dumping data for table db_goldmart.kredit_detail: ~8 rows (approximately)
DELETE FROM `kredit_detail`;
INSERT INTO `kredit_detail` (`id`, `id_kredit_nasabah`, `gramasi`, `no_seri`, `image`, `created_at`, `updated_at`, `deleted_at`, `restored_at`, `created_by`, `updated_by`, `deleted_by`, `restored_by`) VALUES
	(1, 1, 5.00, 'Seri 1', NULL, NULL, '2024-12-28 09:02:37', NULL, NULL, NULL, 'Super Admin', NULL, NULL),
	(2, 1, 1.00, 'Seri 2', NULL, NULL, '2024-12-28 09:02:37', NULL, NULL, NULL, 'Super Admin', NULL, NULL),
	(3, 1, 2.00, 'Seri 3', NULL, NULL, '2024-12-28 09:02:37', NULL, NULL, NULL, 'Super Admin', NULL, NULL),
	(4, 1, 1.00, 'Seri 4', NULL, NULL, '2024-12-28 09:02:37', NULL, NULL, NULL, 'Super Admin', NULL, NULL),
	(5, 1, 10.00, 'Seri 5', NULL, NULL, '2024-12-28 09:02:37', NULL, NULL, NULL, 'Super Admin', NULL, NULL),
	(6, 2, 1.00, 'Seri 11', NULL, NULL, '2024-12-28 09:02:37', NULL, NULL, NULL, 'Super Admin', NULL, NULL),
	(7, 2, 2.00, 'Seri 22', NULL, NULL, '2024-12-28 09:02:37', NULL, NULL, NULL, 'Super Admin', NULL, NULL),
	(8, 2, 5.00, 'Seri 33', NULL, NULL, '2024-12-28 09:02:37', NULL, NULL, NULL, 'Super Admin', NULL, NULL);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
