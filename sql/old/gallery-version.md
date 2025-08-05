-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 14, 2025 at 05:13 PM
-- Server version: 8.0.42-0ubuntu0.22.04.1
-- PHP Version: 8.1.2-1ubuntu2.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `prod_witw_23`
--

-- --------------------------------------------------------

--
-- Table structure for table `partner_gallery_version`
--

DROP TABLE IF EXISTS `partner_gallery_version`;
CREATE TABLE `partner_gallery_version` (
  `id` int NOT NULL,
  `partner_gallery_id` int NOT NULL,
  `version` int NOT NULL,
  `safari_operator_id` int NOT NULL,
  `park_id` int DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `can_send_for_approval` int DEFAULT '1',
  `live_images` longtext,
  `is_live` int NOT NULL DEFAULT '0',
  `status` int DEFAULT '1',
  `created_at` int DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL,
  `updated_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `partner_gallery_version`
--
ALTER TABLE `partner_gallery_version`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `partner_gallery_version`
--
ALTER TABLE `partner_gallery_version`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;