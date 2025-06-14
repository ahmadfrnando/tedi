/*
 Navicat Premium Data Transfer

 Source Server         : mysql
 Source Server Type    : MySQL
 Source Server Version : 90200 (9.2.0)
 Source Host           : localhost:3307
 Source Schema         : tedi

 Target Server Type    : MySQL
 Target Server Version : 90200 (9.2.0)
 File Encoding         : 65001

 Date: 24/05/2025 15:05:32
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for pertanyaan
-- ----------------------------
DROP TABLE IF EXISTS `pertanyaan`;
CREATE TABLE `pertanyaan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `no_urut` int NOT NULL,
  `pertanyaan` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `no_urut` (`no_urut`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- ----------------------------
-- Records of pertanyaan
-- ----------------------------
BEGIN;
INSERT INTO `pertanyaan` (`id`, `no_urut`, `pertanyaan`) VALUES (1, 1, 'siapa namamu');
INSERT INTO `pertanyaan` (`id`, `no_urut`, `pertanyaan`) VALUES (2, 2, 'dimana rumahmu');
INSERT INTO `pertanyaan` (`id`, `no_urut`, `pertanyaan`) VALUES (3, 3, 'siapa nama hewan pertamamu');
INSERT INTO `pertanyaan` (`id`, `no_urut`, `pertanyaan`) VALUES (4, 4, 'apa hobimu');
INSERT INTO `pertanyaan` (`id`, `no_urut`, `pertanyaan`) VALUES (5, 5, 'bagaimana kamu bekerja');
INSERT INTO `pertanyaan` (`id`, `no_urut`, `pertanyaan`) VALUES (6, 6, 'dimana kuliahmu');
INSERT INTO `pertanyaan` (`id`, `no_urut`, `pertanyaan`) VALUES (7, 7, 'berapa ipk mu');
INSERT INTO `pertanyaan` (`id`, `no_urut`, `pertanyaan`) VALUES (8, 8, 'puas puas');
INSERT INTO `pertanyaan` (`id`, `no_urut`, `pertanyaan`) VALUES (9, 9, 'puas kali');
INSERT INTO `pertanyaan` (`id`, `no_urut`, `pertanyaan`) VALUES (10, 10, 'hhehee');
COMMIT;

-- ----------------------------
-- Table structure for survey
-- ----------------------------
DROP TABLE IF EXISTS `survey`;
CREATE TABLE `survey` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `persepsi0` int NOT NULL,
  `persepsi1` int NOT NULL,
  `persepsi2` int NOT NULL,
  `persepsi3` int NOT NULL,
  `persepsi4` int NOT NULL,
  `persepsi5` int NOT NULL,
  `persepsi6` int NOT NULL,
  `persepsi7` int NOT NULL,
  `persepsi8` int NOT NULL,
  `persepsi9` int NOT NULL,
  `total_penilaian` int NOT NULL,
  `rata_rata_penilaian` decimal(10,2) NOT NULL,
  `tingkat_kepuasan` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`),
  CONSTRAINT `survey_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- ----------------------------
-- Records of survey
-- ----------------------------
BEGIN;
INSERT INTO `survey` (`id`, `user_id`, `persepsi0`, `persepsi1`, `persepsi2`, `persepsi3`, `persepsi4`, `persepsi5`, `persepsi6`, `persepsi7`, `persepsi8`, `persepsi9`, `total_penilaian`, `rata_rata_penilaian`, `tingkat_kepuasan`) VALUES (5, 10, 5, 5, 5, 5, 5, 1, 5, 5, 2, 2, 40, 4.00, 'Puas');
INSERT INTO `survey` (`id`, `user_id`, `persepsi0`, `persepsi1`, `persepsi2`, `persepsi3`, `persepsi4`, `persepsi5`, `persepsi6`, `persepsi7`, `persepsi8`, `persepsi9`, `total_penilaian`, `rata_rata_penilaian`, `tingkat_kepuasan`) VALUES (6, 11, 2, 5, 4, 5, 2, 5, 3, 5, 5, 4, 40, 4.00, 'Puas');
INSERT INTO `survey` (`id`, `user_id`, `persepsi0`, `persepsi1`, `persepsi2`, `persepsi3`, `persepsi4`, `persepsi5`, `persepsi6`, `persepsi7`, `persepsi8`, `persepsi9`, `total_penilaian`, `rata_rata_penilaian`, `tingkat_kepuasan`) VALUES (7, 13, 4, 3, 1, 4, 5, 5, 5, 2, 5, 4, 38, 3.80, 'Puas');
COMMIT;

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `nomor` char(13) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `nik` char(16) NOT NULL,
  `password` varchar(200) NOT NULL,
  `role` enum('admin','user') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'user',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- ----------------------------
-- Records of user
-- ----------------------------
BEGIN;
INSERT INTO `user` (`id`, `username`, `nomor`, `nik`, `password`, `role`) VALUES (1, 'teddyprasetyo', '0895613485230', '1207261105030009', '$2y$10$NSIabLKzkvKPKliVn3hqIOPijtR7Cpk3yw183pFsUafSUI/9MTanG', 'user');
INSERT INTO `user` (`id`, `username`, `nomor`, `nik`, `password`, `role`) VALUES (2, 'niko', '0895613485230', '1234', '$2y$10$NSIabLKzkvKPKliVn3hqIOPijtR7Cpk3yw183pFsUafSUI/9MTanG', 'admin');
INSERT INTO `user` (`id`, `username`, `nomor`, `nik`, `password`, `role`) VALUES (9, 'andi', '112233', '123', '$2y$10$hatjauN1Py3kJSaXjor5D.HQbMrUJ30Yd5MLnWtLl4NN.lT6rVLP.', 'user');
INSERT INTO `user` (`id`, `username`, `nomor`, `nik`, `password`, `role`) VALUES (10, 'jojo', '12312345678', '696969', '$2y$10$rXdD386EP8nh0mCD9wBn9uxUFObKGPCFelUECeVraITsLBv6y5HHO', 'user');
INSERT INTO `user` (`id`, `username`, `nomor`, `nik`, `password`, `role`) VALUES (11, 'brata', '12345678', '009900', '$2y$10$V9o59An11ATI5H1E74kXseOq0Sj08QSG6lX403YRRn5gP75nkrobq', 'user');
INSERT INTO `user` (`id`, `username`, `nomor`, `nik`, `password`, `role`) VALUES (12, 'tedipras', '11991199', '4599', '$2y$10$H15M21YV3grYB6JYPctONOm1j3msEY0gf1r7OAB50vpWYVEw9h98O', 'user');
INSERT INTO `user` (`id`, `username`, `nomor`, `nik`, `password`, `role`) VALUES (13, 'tediprasetya', '1234567890', '123123123', '$2y$10$H5cpRXyVKt2Pr2w8tNcMweZd8jztsD.XpI6wtD5L/kXnpsxAIV6hu', 'user');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
