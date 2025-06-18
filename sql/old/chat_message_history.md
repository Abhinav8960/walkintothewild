-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 17, 2025 at 12:22 PM
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
-- Database: `wildwalks`
--

-- --------------------------------------------------------

--
-- Table structure for table `chat_message_history`
--

DROP TABLE IF EXISTS `chat_message_history`;
CREATE TABLE `chat_message_history` (
  `id` int NOT NULL,
  `chat_message_id` int NOT NULL,
  `chat_id` int NOT NULL,
  `message` longtext COLLATE utf8mb4_unicode_ci,
  `is_quotation_message` tinyint(1) NOT NULL DEFAULT '0',
  `quotation_id` int DEFAULT NULL,
  `is_quotation_active` tinyint(1) NOT NULL DEFAULT '0',
  `is_call_message` tinyint(1) NOT NULL DEFAULT '0',
  `call_id` int DEFAULT NULL,
  `is_call_request` tinyint(1) NOT NULL DEFAULT '0',
  `data` mediumtext COLLATE utf8mb4_unicode_ci,
  `gallery` text COLLATE utf8mb4_unicode_ci,
  `created_at` int DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `status` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chat_message_history`
--
ALTER TABLE `chat_message_history`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
