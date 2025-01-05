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

-- Dumping data for table db_goldmart.permissions: ~20 rows (approximately)
DELETE FROM `permissions`;
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `group_name`, `created_at`, `updated_at`) VALUES
	(1, 'user approve', 'web', 'User Permission', '2025-01-03 06:48:15', '2025-01-03 06:48:15'),
	(2, 'user create', 'web', 'User Permission', '2025-01-03 06:48:15', '2025-01-03 06:48:15'),
	(3, 'user delete', 'web', 'User Permission', '2025-01-03 06:48:15', '2025-01-03 06:48:15'),
	(4, 'user index', 'web', 'User Permission', '2025-01-03 06:48:15', '2025-01-03 06:48:15'),
	(5, 'user restore', 'web', 'User Permission', '2025-01-03 06:48:15', '2025-01-03 06:48:15'),
	(6, 'user update', 'web', 'User Permission', '2025-01-03 06:48:15', '2025-01-03 06:48:15'),
	(7, 'role create', 'web', 'Role Permission', '2025-01-03 06:48:15', '2025-01-03 06:48:15'),
	(8, 'role delete', 'web', 'Role Permission', '2025-01-03 06:48:15', '2025-01-03 06:48:15'),
	(9, 'role index', 'web', 'Role Permission', '2025-01-03 06:48:15', '2025-01-03 06:48:15'),
	(10, 'role update', 'web', 'Role Permission', '2025-01-03 06:48:15', '2025-01-03 06:48:15'),
	(11, 'permission create', 'web', 'Permission Permission', '2025-01-03 06:48:15', '2025-01-03 06:48:15'),
	(12, 'permission delete', 'web', 'Permission Permission', '2025-01-03 06:48:15', '2025-01-03 06:48:15'),
	(13, 'permission index', 'web', 'Permission Permission', '2025-01-03 06:48:15', '2025-01-03 06:48:15'),
	(14, 'permission update', 'web', 'Permission Permission', '2025-01-03 06:48:15', '2025-01-03 06:48:15'),
	(15, 'kredit nasabah index', 'web', 'Kredit Nasabah Permission', '2025-01-03 06:48:15', '2025-01-03 06:48:15'),
	(16, 'kredit nasabah update', 'web', 'Kredit Nasabah Permission', '2025-01-03 06:48:15', '2025-01-03 06:48:15'),
	(17, 'setting system', 'web', 'Setting System Permission', '2025-01-03 06:48:15', '2025-01-03 06:48:15'),
	(18, 'nasabah index', 'web', 'Nasabah Permission', '2025-01-03 06:48:15', '2025-01-03 06:48:15'),
	(19, 'nasabah update', 'web', 'Nasabah Permission', '2025-01-03 06:48:15', '2025-01-03 06:48:15'),
	(20, 'external update', 'web', 'External Permission', '2025-01-03 06:48:15', '2025-01-03 06:48:15');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
