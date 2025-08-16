-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for student
CREATE DATABASE IF NOT EXISTS `student` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `student`;

-- Dumping structure for table student.student_info
CREATE TABLE IF NOT EXISTS `student_info` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `roll` int NOT NULL,
  `subject` varchar(100) DEFAULT '',
  `class` varchar(15) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `city` varchar(15) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `pcontact` varchar(11) NOT NULL,
  `photo` varchar(50) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roll` (`roll`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table student.student_info: ~6 rows (approximately)
INSERT INTO `student_info` (`id`, `name`, `roll`, `subject`, `class`, `city`, `pcontact`, `photo`, `datetime`) VALUES
	(48, 'Emiliano Zapata', 234109, 'Math', 'Twelfth', 'Carrera 54 N 12', '3162453578', '23411292024-05-11-05-56.png', '2020-08-14 15:23:34'),
	(49, 'Rafael Castro', 234110, 'Science', 'Twelfth', 'Calle 78 N 19 1', '3145648712', '23411292024-05-11-05-56.png', '2020-08-14 15:38:13'),
	(50, 'Julia Barón', 234111, 'Math', 'Ninth', 'Calle 20 N 17 8', '3215468719', '23411292024-05-11-05-56.png', '2020-08-14 17:19:16'),
	(51, 'Natalia Cardona', 234112, 'English Language and Writing', 'Tenth', 'Carrera 54 N 12', '3015824671', '23411292024-05-11-05-56.png', '2020-08-14 19:54:22'),
	(52, 'Sofia Tamayo', 234113, 'History', 'Eleventh', 'Carrera 55 N 97', '3147894512', '23411292024-05-11-05-56.png', '2020-08-14 21:51:22'),
	(53, 'Pancho Lopez', 2381903, 'History', 'Eleventh', '1234', '6194955512', '23411292024-05-11-05-56.png', '2024-05-03 18:29:44');

-- Dumping structure for table student.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `photo` varchar(50) NOT NULL,
  `status` varchar(12) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table student.users: ~2 rows (approximately)
INSERT INTO `users` (`id`, `name`, `email`, `username`, `password`, `photo`, `status`, `datetime`) VALUES
	(21, 'configuroweb', 'hola@cweb.com', 'configuroweb', 'c42a54b24089898a208cd520efa47bf79141330d', 'configuroweb23-08-20-08-2020avatar1.png', 'activo', '2020-08-14 15:00:09'),
	(22, 'usuario', 'usuario@cweb.com', 'usuario1', 'c42a54b24089898a208cd520efa47bf79141330d', 'usuario1.jpg', 'inactivo', '2020-08-14 16:32:36');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
