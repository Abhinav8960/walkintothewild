-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 20, 2025 at 10:58 AM
-- Server version: 8.0.41-0ubuntu0.22.04.1
-- PHP Version: 8.1.2-1ubuntu2.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `witw_moderation`
--

-- --------------------------------------------------------

--
-- Table structure for table `moderation_text`
--

CREATE TABLE `moderation_text` (
  `id` int NOT NULL,
  `moderation_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `request_id` varchar(255) DEFAULT NULL,
  `request_timestamp` varchar(255) DEFAULT NULL,
  `moderation_type` varchar(255) DEFAULT NULL,
  `sexual` decimal(3,3) NOT NULL DEFAULT '0.000',
  `discriminatory` decimal(3,3) NOT NULL DEFAULT '0.000',
  `insulting` decimal(3,3) NOT NULL DEFAULT '0.000',
  `violent` decimal(3,3) NOT NULL DEFAULT '0.000',
  `toxic` decimal(3,3) NOT NULL DEFAULT '0.000',
  `self_harm` decimal(3,3) NOT NULL DEFAULT '0.000',
  `personal` tinyint(1) NOT NULL DEFAULT '0',
  `link` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `moderation_text_personal`
--

CREATE TABLE `moderation_text_personal` (
  `id` int NOT NULL,
  `moderation_text_id` int NOT NULL,
  `is_personal` int NOT NULL DEFAULT '0',
  `is_link` int NOT NULL DEFAULT '0',
  `type` varchar(255) NOT NULL,
  `category` varchar(255) DEFAULT NULL,
  `match` varchar(255) DEFAULT NULL,
  `start` varchar(255) DEFAULT NULL,
  `end` varchar(255) DEFAULT NULL,
  `sequnce` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--
--
-- Indexes for table `moderation_text`
--
ALTER TABLE `moderation_text`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `moderation_text_personal`
--
ALTER TABLE `moderation_text_personal`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--


--
-- AUTO_INCREMENT for table `moderation_text`
--
ALTER TABLE `moderation_text`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `moderation_text_personal`
--
ALTER TABLE `moderation_text_personal`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
