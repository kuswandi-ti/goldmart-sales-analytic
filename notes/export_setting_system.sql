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

-- Dumping data for table db_goldmart.setting_systems: ~25 rows (approximately)
DELETE FROM `setting_systems`;
INSERT INTO `setting_systems` (`id`, `key`, `value`, `created_at`, `updated_at`, `deleted_at`, `restored_at`, `created_by`, `updated_by`, `deleted_by`, `restored_by`) VALUES
	(1, 'company_name', 'PT. Gold Martindo', '2025-01-03 06:48:15', '2025-01-03 06:48:15', NULL, NULL, 'Super Admin', NULL, NULL, NULL),
	(2, 'site_title', 'Goldmart System', '2025-01-03 06:48:15', '2025-01-03 06:48:15', NULL, NULL, 'Super Admin', NULL, NULL, NULL),
	(3, 'company_email', 'admin@goldmart.com', '2025-01-03 06:48:15', '2025-01-03 06:48:15', NULL, NULL, 'Super Admin', NULL, NULL, NULL),
	(4, 'company_phone', '62-21-6508688', '2025-01-03 06:48:15', '2025-01-03 06:48:15', NULL, NULL, 'Super Admin', NULL, NULL, NULL),
	(5, 'company_address', 'Jl Mitra Sunter Boulevard, Sunter, Jakarta Utara', '2025-01-03 06:48:15', '2025-01-03 06:48:15', NULL, NULL, 'Super Admin', NULL, NULL, NULL),
	(6, 'default_date_format', 'd-m-Y', '2025-01-03 06:48:15', '2025-01-03 06:48:15', NULL, NULL, 'Super Admin', NULL, NULL, NULL),
	(7, 'default_time_format', 'H:i:s', '2025-01-03 06:48:15', '2025-01-03 06:48:15', NULL, NULL, 'Super Admin', NULL, NULL, NULL),
	(8, 'default_language', 'id', '2025-01-03 06:48:15', '2025-01-03 06:48:15', NULL, NULL, 'Super Admin', NULL, NULL, NULL),
	(9, 'decimal_digit_amount', '0', '2025-01-03 06:48:15', '2025-01-03 06:48:15', NULL, NULL, 'Super Admin', NULL, NULL, NULL),
	(10, 'decimal_digit_percent', '2', '2025-01-03 06:48:15', '2025-01-03 06:48:15', NULL, NULL, 'Super Admin', NULL, NULL, NULL),
	(11, 'mail_type', 'smtp', '2025-01-03 06:48:15', '2025-01-03 06:48:15', NULL, NULL, 'Super Admin', NULL, NULL, NULL),
	(12, 'mail_host', 'mail.harmonipayment.my.id', '2025-01-03 06:48:15', '2025-01-03 06:48:15', NULL, NULL, 'Super Admin', NULL, NULL, NULL),
	(13, 'mail_username', 'admin@goldmart.harmonipayment.my.id', '2025-01-03 06:48:15', '2025-01-03 06:48:15', NULL, NULL, 'Super Admin', NULL, NULL, NULL),
	(14, 'mail_password', 'P455w0rdny4', '2025-01-03 06:48:15', '2025-01-03 06:48:15', NULL, NULL, 'Super Admin', NULL, NULL, NULL),
	(15, 'mail_encryption', 'tls', '2025-01-03 06:48:15', '2025-01-03 06:48:15', NULL, NULL, 'Super Admin', NULL, NULL, NULL),
	(16, 'mail_port', '465', '2025-01-03 06:48:15', '2025-01-03 06:48:15', NULL, NULL, 'Super Admin', NULL, NULL, NULL),
	(17, 'mail_from_address', 'admin@goldmart.harmonipayment.my.id', '2025-01-03 06:48:15', '2025-01-03 06:48:15', NULL, NULL, 'Super Admin', NULL, NULL, NULL),
	(18, 'mail_from_name', 'Admin', '2025-01-03 06:48:15', '2025-01-03 06:48:15', NULL, NULL, 'Super Admin', NULL, NULL, NULL),
	(19, 'midtrans_environment', NULL, '2025-01-03 06:48:15', '2025-01-03 06:48:15', NULL, NULL, 'Super Admin', NULL, NULL, NULL),
	(20, 'midtrans_merchant_id', NULL, '2025-01-03 06:48:15', '2025-01-03 06:48:15', NULL, NULL, 'Super Admin', NULL, NULL, NULL),
	(21, 'midtrans_client_key', NULL, '2025-01-03 06:48:15', '2025-01-03 06:48:15', NULL, NULL, 'Super Admin', NULL, NULL, NULL),
	(22, 'midtrans_server_key', NULL, '2025-01-03 06:48:15', '2025-01-03 06:48:15', NULL, NULL, 'Super Admin', NULL, NULL, NULL),
	(23, 'sale_prefix', 'INV', '2025-01-03 06:48:15', '2025-01-03 06:48:15', NULL, NULL, 'Super Admin', NULL, NULL, NULL),
	(24, 'sale_last_number', '0', '2025-01-03 06:48:15', '2025-01-03 06:48:15', NULL, NULL, 'Super Admin', NULL, NULL, NULL),
	(25, 'tahun_periode_aktif', '2024', '2025-01-03 06:48:15', '2025-01-03 06:48:15', NULL, NULL, 'Super Admin', NULL, NULL, NULL),
	(26, 'company_logo', '/images/company_logo/company_logo_20241221034245.jpg', '2024-12-21 08:42:45', '2024-12-21 08:42:45', NULL, NULL, NULL, 'Super Admin', NULL, NULL),
	(27, 'company_logo_toggle', '/images/company_logo_toggle/company_logo_toggle_20241221034511.jpg', '2024-12-21 08:45:11', '2024-12-21 08:45:11', NULL, NULL, NULL, 'Super Admin', NULL, NULL),
	(28, 'company_logo_desktop', '/images/company_logo_desktop/company_logo_desktop_20241221034825.png', '2024-12-21 08:47:28', '2024-12-21 08:48:25', NULL, NULL, NULL, 'Super Admin', NULL, NULL);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
