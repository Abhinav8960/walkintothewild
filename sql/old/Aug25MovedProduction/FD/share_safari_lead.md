-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 04, 2025 at 08:04 PM
-- Server version: 8.0.42-0ubuntu0.22.04.2
-- PHP Version: 8.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `prod_witw`
--

-- --------------------------------------------------------

--
-- Table structure for table `share_safari_lead`
--

DROP TABLE IF EXISTS `share_safari_lead`;
CREATE TABLE `share_safari_lead` (
  `id` int NOT NULL,
  `share_safari_id` int NOT NULL,
  `share_safari_user_id` int NOT NULL,
  `share_safari_partner_id` int DEFAULT NULL,
  `version` int NOT NULL,
  `type` int NOT NULL COMMENT '1=>share safari, 2=> Fixed Departure',
  `quantity` int NOT NULL DEFAULT '1' COMMENT 'seat',
  `notes` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `name` int NOT NULL,
  `email` int NOT NULL,
  `phone` int NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `cost_per_quantity` double(10,2) NOT NULL DEFAULT '0.00',
  `gross_price` double(10,2) NOT NULL DEFAULT '0.00',
  `discount` double(10,2) NOT NULL DEFAULT '0.00',
  `net_price` double(10,2) NOT NULL,
  `installment` int NOT NULL DEFAULT '1',
  `received_amount` double(10,2) NOT NULL DEFAULT '0.00',
  `is_payment_received` tinyint(1) NOT NULL DEFAULT '0',
  `payment_receipt` varchar(255) NOT NULL,
  `transaction_datetime` datetime DEFAULT NULL,
  `payment_gateway` int NOT NULL COMMENT '1=>payu,2=>icici	',
  `is_payment_expired` int NOT NULL DEFAULT '0',
  `collection` json DEFAULT NULL,
  `status` int NOT NULL,
  `created_at` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `updated_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `share_safari_lead`
--
ALTER TABLE `share_safari_lead`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `share_safari_lead`
--
ALTER TABLE `share_safari_lead`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
