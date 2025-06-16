-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 04, 2025 at 07:46 PM
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
-- Database: `wildwalks_logs`
--

-- --------------------------------------------------------

--
-- Table structure for table `call_log`
--

DROP TABLE IF EXISTS `call_log`;
CREATE TABLE `call_log` (
  `id` int NOT NULL,
  `reference_id` varchar(50) NOT NULL,
  `unique_id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `chat_id` int NOT NULL,
  `lead_id` int DEFAULT NULL,
  `request_vnm` varchar(100) NOT NULL,
  `request_caller_1_no` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `request_caller_1_user_id` int DEFAULT NULL,
  `request_caller_2_no` varchar(20) DEFAULT NULL,
  `request_caller_2_user_id` int DEFAULT NULL,
  `caller_id` varchar(50) DEFAULT NULL,
  `received_id` varchar(50) DEFAULT NULL,
  `ivr_number` varchar(50) DEFAULT NULL,
  `recording_url` varchar(255) DEFAULT NULL,
  `dial_status` varchar(255) DEFAULT NULL,
  `rec_duration` varchar(50) DEFAULT NULL,
  `call_type` varchar(255) DEFAULT NULL,
  `call_status` varchar(255) DEFAULT NULL,
  `datetime` varchar(100) DEFAULT NULL,
  `duration` varchar(100) DEFAULT NULL,
  `operator_user_id` int DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `call_initiated_user_id` int DEFAULT NULL,
  `call_initiated_partner_id` int DEFAULT NULL,
  `call_request_status` varchar(255) DEFAULT NULL,
  `call_request_message` varchar(255) DEFAULT NULL,
  `status` int NOT NULL DEFAULT '0' COMMENT '0=>Failed,1=>Success',
  `is_detail_fetched` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `call_log`
--
ALTER TABLE `call_log`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reference_id` (`reference_id`),
  ADD UNIQUE KEY `unique_id` (`unique_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `call_log`
--
ALTER TABLE `call_log`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
