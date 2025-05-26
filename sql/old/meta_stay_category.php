-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 21, 2025 at 07:30 PM
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
-- Database: `witw_12`
--

-- --------------------------------------------------------

--
-- Table structure for table `meta_stay_category`
--

DROP TABLE IF EXISTS `meta_stay_category`;
CREATE TABLE `meta_stay_category` (
  `id` int NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `status` int NOT NULL DEFAULT '1',
  `sequence` int DEFAULT NULL,
  `sequence_for_share_safari` int DEFAULT NULL,
  `sequence_for_package` int DEFAULT NULL,
  `created_at` int DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL,
  `updated_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `meta_stay_category`
--

INSERT INTO `meta_stay_category` (`id`, `title`, `status`, `sequence`, `sequence_for_share_safari`, `sequence_for_package`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'Premium', 1, 1, 1, 1, 1715926433, 1, 1715926433, 1),
(2, 'Standard', 1, 2, 2, 2, 1715926433, 1, 1715926433, 1),
(3, 'Economical', 1, 3, 3, 3, 1715926433, 1, 1715926433, 1),
(4, 'Not Included', 1, 6, 4, 6, 1715926433, 1, 1715926433, 1),
(5, 'Forest Rest House', 1, 5, 0, 5, 1715926433, 1, 1715926433, 1),
(6, 'Home Stay', 1, 4, 0, 4, 1715926433, 1, 1715926433, 1),
(7, 'Hotel', -1, NULL, NULL, NULL, 1715926433, 1, 1715926433, 1),
(8, 'Resorts', -1, NULL, NULL, NULL, 1715926433, 1, 1715926433, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `meta_stay_category`
--
ALTER TABLE `meta_stay_category`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `meta_stay_category`
--
ALTER TABLE `meta_stay_category`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
