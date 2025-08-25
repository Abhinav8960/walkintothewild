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
-- Table structure for table `share_safari_installment`
--

DROP TABLE IF EXISTS `share_safari_installment`;
CREATE TABLE `share_safari_installment` (
  `id` int NOT NULL,
  `share_safari_id` int NOT NULL,
  `share_safari_user_id` int NOT NULL,
  `share_safari_partner_id` int DEFAULT NULL,
  `version` int NOT NULL,
  `type` int NOT NULL COMMENT '1=>share safari, 2=> Fixed Departure',
  `notes` varchar(255) DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `amount` double(10,2) DEFAULT NULL,
  `due_datetime` datetime DEFAULT NULL,
  `payment_link` varchar(255) DEFAULT NULL,
  `payment_hash` varchar(255) DEFAULT NULL,
  `transaction_id` int DEFAULT NULL,
  `payment_gateway` int DEFAULT NULL COMMENT '1=>payu,2=>icici',
  `transaction_datetime` datetime DEFAULT NULL,
  `created_at` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0=>not received, 1=> received'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `share_safari_installment`
--
ALTER TABLE `share_safari_installment`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `share_safari_installment`
--
ALTER TABLE `share_safari_installment`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
