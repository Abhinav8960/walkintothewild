-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 09, 2025 at 01:06 PM
-- Server version: 8.0.42-0ubuntu0.22.04.1
-- PHP Version: 8.1.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `witw_staging`
--

-- --------------------------------------------------------

--
-- Table structure for table `mobile_verification`
--

DROP TABLE IF EXISTS `mobile_verification`;
CREATE TABLE `mobile_verification` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `source_type` int DEFAULT NULL COMMENT '1 => ''Calling'',\r\n2 =>''Whatsapp''',
  `mobile_no` bigint DEFAULT NULL,
  `otp` int DEFAULT NULL,
  `otp_by_user` int DEFAULT NULL,
  `exp_datetime` datetime NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  `created_at` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `updated_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mobile_verification`
--
ALTER TABLE `mobile_verification`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mobile_verification`
--
ALTER TABLE `mobile_verification`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;