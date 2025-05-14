-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 14, 2025 at 01:19 PM
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
-- Table structure for table `lead`
--

DROP TABLE IF EXISTS `lead`;
CREATE TABLE `lead` (
  `id` int NOT NULL,
  `source` int NOT NULL COMMENT '1=>package,2=>park,3=>operator ',
  `package_id` int DEFAULT NULL,
  `package_version` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `park_id` int DEFAULT NULL,
  `operator_id` int DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `phone` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `destination` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `from_date` date NOT NULL,
  `to_date` date DEFAULT NULL,
  `is_date_flexible` tinyint(1) NOT NULL DEFAULT '0',
  `safaris` int DEFAULT NULL,
  `travelers` int NOT NULL DEFAULT '1',
  `stay_category_id` int DEFAULT NULL,
  `transport` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `meals` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `budget` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `addional_notes` text,
  `user_id` int NOT NULL,
  `is_booking_for_login_user` tinyint(1) NOT NULL DEFAULT '1',
  `is_seen_by_admin` tinyint(1) NOT NULL DEFAULT '0',
  `status` int NOT NULL DEFAULT '1',
  `created_at` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `updated_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lead_partners`
--

DROP TABLE IF EXISTS `lead_partners`;
CREATE TABLE `lead_partners` (
  `id` int NOT NULL,
  `lead_id` int NOT NULL,
  `partner_id` int NOT NULL COMMENT 'safari_operator',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` int NOT NULL,
  `updated_by` int NOT NULL,
  `created_at` int NOT NULL,
  `updated_at` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lead_partner_quotes`
--

DROP TABLE IF EXISTS `lead_partner_quotes`;
CREATE TABLE `lead_partner_quotes` (
  `id` int NOT NULL,
  `lead_partner_id` int NOT NULL,
  `lead_id` int NOT NULL,
  `partner_id` int NOT NULL,
  `safaris` int NOT NULL,
  `travelers` int NOT NULL,
  `stay_category_id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `partner_selling_price` double(10,2) NOT NULL,
  `plateform_partner_fees_percentage` int NOT NULL COMMENT '%',
  `plateform_partner_fees` double(10,2) NOT NULL DEFAULT '0.00',
  `partner_net_selling_price` double(10,2) NOT NULL,
  `plateform_customer_discount` double(10,2) NOT NULL DEFAULT '0.00',
  `net_payment_price` double(10,2) NOT NULL,
  `installment` int NOT NULL DEFAULT '1',
  `received_amount` double(10,2) NOT NULL DEFAULT '0.00',
  `addtional_data` json DEFAULT NULL,
  `is_approved_by_admin` tinyint(1) NOT NULL DEFAULT '0',
  `datetime_of_approval_by_admin` datetime DEFAULT NULL,
  `rejection_reason` varchar(255) DEFAULT NULL,
  `status` int DEFAULT '1',
  `created_at` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `updated_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lead_partner_quote_installments`
--

DROP TABLE IF EXISTS `lead_partner_quote_installments`;
CREATE TABLE `lead_partner_quote_installments` (
  `id` int NOT NULL,
  `lead_partner_quote_id` int NOT NULL,
  `lead_id` int NOT NULL,
  `partner_id` int NOT NULL,
  `amount` double(10,2) NOT NULL,
  `payment_link` varchar(255) DEFAULT NULL,
  `payment_hash` varchar(255) NOT NULL,
  `before_datetime` datetime NOT NULL,
  `status` int NOT NULL DEFAULT '0' COMMENT '0=>not recived',
  `created_at` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `updated_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lead`
--
ALTER TABLE `lead`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lead_partners`
--
ALTER TABLE `lead_partners`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `lead_id` (`lead_id`,`partner_id`);

--
-- Indexes for table `lead_partner_quotes`
--
ALTER TABLE `lead_partner_quotes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lead_partner_quote_installments`
--
ALTER TABLE `lead_partner_quote_installments`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `lead`
--
ALTER TABLE `lead`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lead_partners`
--
ALTER TABLE `lead_partners`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lead_partner_quotes`
--
ALTER TABLE `lead_partner_quotes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lead_partner_quote_installments`
--
ALTER TABLE `lead_partner_quote_installments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

ALTER TABLE `lead_partner_quotes` ADD `park_id` INT NULL DEFAULT NULL AFTER `partner_id`, ADD `notes` TEXT NULL DEFAULT NULL AFTER `park_id`;