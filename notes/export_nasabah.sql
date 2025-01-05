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

-- Dumping data for table db_goldmart.nasabah: ~57 rows (approximately)
DELETE FROM `nasabah`;
INSERT INTO `nasabah` (`id`, `kode`, `nama`, `email`, `no_tlp`, `alamat`, `created_at`, `updated_at`, `deleted_at`, `restored_at`, `created_by`, `updated_by`, `deleted_by`, `restored_by`) VALUES
	(1, 'N1', 'DARMA WATI', 'nasabah@mail.com', '085218555997', 'GRAHA RAFLESIA II BLOK F 18/30 RT 005 RW 003 Talagasari CIKUPA  KAB. TANGERANG BANTEN', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(2, 'N10', 'Nasabah 10', 'nasabah@mail.com', '-', 'Alamat Nasabah 10', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(3, 'N11', 'Nasabah 11', 'nasabah@mail.com', '-', 'Alamat Nasabah 11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(4, 'N12', 'Nasabah 12', 'nasabah@mail.com', '-', 'Alamat Nasabah 12', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(5, 'N13', 'Nasabah 13', 'nasabah@mail.com', '-', 'Alamat Nasabah 13', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(6, 'N14', 'Nasabah 14', 'nasabah@mail.com', '-', 'Alamat Nasabah 14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(7, 'N15', 'Nasabah 15', 'nasabah@mail.com', '-', 'Alamat Nasabah 15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(8, 'N16', 'Nasabah 16', 'nasabah@mail.com', '-', 'Alamat Nasabah 16', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(9, 'N17', 'Nasabah 17', 'nasabah@mail.com', '-', 'Alamat Nasabah 17', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(10, 'N18', 'Nasabah 18', 'nasabah@mail.com', '-', 'Alamat Nasabah 18', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(11, 'N19', 'Nasabah 19', 'nasabah@mail.com', '-', 'Alamat Nasabah 19', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(12, 'N2', 'RIRIS LINDA RESTANTIN', 'nasabah@mail.com', '081336345717', 'JL TITAN V BLOK K NO 8 RT 003 RW 022 PURWANTORO BLIMBING  KAB. MALANG JAWA TIMUR', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(13, 'N20', 'Nasabah 20', 'nasabah@mail.com', '-', 'Alamat Nasabah 20', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(14, 'N21', 'Nasabah 21', 'nasabah@mail.com', '-', 'Alamat Nasabah 21', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(15, 'N22', 'Nasabah 22', 'nasabah@mail.com', '-', 'Alamat Nasabah 22', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(16, 'N23', 'Nasabah 23', 'nasabah@mail.com', '-', 'Alamat Nasabah 23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(17, 'N24', 'Nasabah 24', 'nasabah@mail.com', '-', 'Alamat Nasabah 24', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(18, 'N25', 'Nasabah 25', 'nasabah@mail.com', '-', 'Alamat Nasabah 25', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(19, 'N26', 'Nasabah 26', 'nasabah@mail.com', '-', 'Alamat Nasabah 26', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(20, 'N27', 'Nasabah 27', 'nasabah@mail.com', '-', 'Alamat Nasabah 27', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(21, 'N28', 'Nasabah 28', 'nasabah@mail.com', '-', 'Alamat Nasabah 28', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(22, 'N29', 'Nasabah 29', 'nasabah@mail.com', '-', 'Alamat Nasabah 29', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(23, 'N3', 'I KADEK SUDARMA', 'nasabah@mail.com', '081916340744', 'DUSUN TOJAN KELODBR TOJAN RT 000 RW 000 SEMARAPURAKANGIN KLUNGKUNG  KAB. BADUNG BALI', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(24, 'N30', 'Nasabah 30', 'nasabah@mail.com', '-', 'Alamat Nasabah 30', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(25, 'N31', 'Nasabah 31', 'nasabah@mail.com', '-', 'Alamat Nasabah 31', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(26, 'N32', 'Nasabah 32', 'nasabah@mail.com', '-', 'Alamat Nasabah 32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(27, 'N33', 'Nasabah 33', 'nasabah@mail.com', '-', 'Alamat Nasabah 33', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(28, 'N34', 'Nasabah 34', 'nasabah@mail.com', '-', 'Alamat Nasabah 34', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(29, 'N35', 'Nasabah 35', 'nasabah@mail.com', '-', 'Alamat Nasabah 35', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(30, 'N36', 'Nasabah 36', 'nasabah@mail.com', '-', 'Alamat Nasabah 36', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(31, 'N37', 'Nasabah 37', 'nasabah@mail.com', '-', 'Alamat Nasabah 37', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(32, 'N38', 'Nasabah 38', 'nasabah@mail.com', '-', 'Alamat Nasabah 38', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(33, 'N39', 'Nasabah 39', 'nasabah@mail.com', '-', 'Alamat Nasabah 39', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(34, 'N4', 'ANREA SIMANULLANG', 'nasabah@mail.com', '089661180104', 'JL PERJUANGAN LV DUSUN LV SIGARA GARANO 3 RT 002 RW 001 PATUMBAK PATUMBAK  KAB. DELI SERDANG SUMATERA UTARA', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(35, 'N40', 'Nasabah 40', 'nasabah@mail.com', '-', 'Alamat Nasabah 40', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(36, 'N41', 'Nasabah 41', 'nasabah@mail.com', '-', 'Alamat Nasabah 41', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(37, 'N42', 'Nasabah 42', 'nasabah@mail.com', '-', 'Alamat Nasabah 42', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(38, 'N43', 'Nasabah 43', 'nasabah@mail.com', '-', 'Alamat Nasabah 43', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(39, 'N44', 'Nasabah 44', 'nasabah@mail.com', '-', 'Alamat Nasabah 44', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(40, 'N45', 'Nasabah 45', 'nasabah@mail.com', '-', 'Alamat Nasabah 45', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(41, 'N46', 'Nasabah 46', 'nasabah@mail.com', '-', 'Alamat Nasabah 46', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(42, 'N47', 'Nasabah 47', 'nasabah@mail.com', '-', 'Alamat Nasabah 47', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(43, 'N48', 'Nasabah 48', 'nasabah@mail.com', '-', 'Alamat Nasabah 48', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(44, 'N49', 'Nasabah 49', 'nasabah@mail.com', '-', 'Alamat Nasabah 49', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(45, 'N5', 'ROSALIA MARIA RENTOR', 'nasabah@mail.com', '081219603882', 'PARADISE RESORT, CLUSTER THE BAY BLOK C15/27 RT 001 RW 001 JOMBANG,SARUA CIPUTAT  KAB. TANGERANG BANTEN', NULL, '2024-12-27 20:13:45', NULL, NULL, NULL, 'Super Admin', NULL, NULL),
	(46, 'N50', 'Nasabah 50', 'nasabah@mail.com', '-', 'Alamat Nasabah 50', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(47, 'N51', 'Nasabah 51', 'nasabah@mail.com', '-', 'Alamat Nasabah 51', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(48, 'N52', 'Nasabah 52', 'nasabah@mail.com', '-', 'Alamat Nasabah 52', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(49, 'N53', 'Nasabah 53', 'nasabah@mail.com', '-', 'Alamat Nasabah 53', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(50, 'N54', 'Nasabah 54', 'nasabah@mail.com', '-', 'Alamat Nasabah 54', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(51, 'N55', 'Nasabah 55', 'nasabah@mail.com', '-', 'Alamat Nasabah 55', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(52, 'N56', 'Nasabah 56', 'nasabah@mail.com', '-', 'Alamat Nasabah 56', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(53, 'N57', 'Nasabah 57', 'nasabah@mail.com', '-', 'Alamat Nasabah 57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(54, 'N6', 'Nasabah 6', 'nasabah@mail.com', '-', 'Alamat Nasabah 6', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(55, 'N7', 'Nasabah 7', 'nasabah@mail.com', '-', 'Alamat Nasabah 7', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(56, 'N8', 'Nasabah 8', 'nasabah@mail.com', '-', 'Alamat Nasabah 8', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(57, 'N9', 'Nasabah 9', 'nasabah@mail.com', '-', 'Alamat Nasabah 9', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
