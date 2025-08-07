-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 05, 2025 at 03:55 PM
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
-- Database: `prod_witw`
--

-- --------------------------------------------------------

--
-- Table structure for table `payu_webhook_response`
--

DROP TABLE IF EXISTS `payu_webhook_response`;
CREATE TABLE `payu_webhook_response` (
  `id` int NOT NULL,
  `mihpayid` varchar(255) DEFAULT NULL,
  `mode` varchar(50) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `unmappedstatus` varchar(255) DEFAULT NULL,
  `key` varchar(50) DEFAULT NULL,
  `txnid` varchar(255) DEFAULT NULL,
  `amount` varchar(255) DEFAULT NULL,
  `card_category` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `discount` varchar(255) DEFAULT NULL,
  `net_amount_debit` varchar(255) DEFAULT NULL,
  `addedon` date DEFAULT NULL,
  `productinfo` varchar(255) DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `address1` varchar(255) DEFAULT NULL,
  `address2` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `zipcode` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `udf1` varchar(255) DEFAULT NULL,
  `udf2` varchar(255) DEFAULT NULL,
  `udf3` varchar(255) DEFAULT NULL,
  `udf4` varchar(255) DEFAULT NULL,
  `udf5` varchar(255) DEFAULT NULL,
  `udf6` varchar(255) DEFAULT NULL,
  `udf7` varchar(255) DEFAULT NULL,
  `udf8` varchar(255) DEFAULT NULL,
  `udf9` varchar(255) DEFAULT NULL,
  `udf10` varchar(255) DEFAULT NULL,
  `hash` varchar(255) DEFAULT NULL,
  `field1` varchar(255) DEFAULT NULL,
  `field2` varchar(255) DEFAULT NULL,
  `field3` varchar(255) DEFAULT NULL,
  `field4` varchar(255) DEFAULT NULL,
  `field5` varchar(255) DEFAULT NULL,
  `field6` varchar(255) DEFAULT NULL,
  `field7` varchar(255) DEFAULT NULL,
  `field8` varchar(255) DEFAULT NULL,
  `field9` varchar(255) DEFAULT NULL,
  `payment_source` varchar(255) DEFAULT NULL,
  `pa_name` varchar(255) DEFAULT NULL,
  `pg_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `bank_ref_num` varchar(255) DEFAULT NULL,
  `bankcode` varchar(255) DEFAULT NULL,
  `error` varchar(255) DEFAULT NULL,
  `error_Message` varchar(255) DEFAULT NULL,
  `cardnum` varchar(255) DEFAULT NULL,
  `cardhash` varchar(255) DEFAULT NULL,
  `response` json DEFAULT NULL,
  `created_at` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `payu_webhook_response`
--
ALTER TABLE `payu_webhook_response`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `payu_webhook_response`
--
ALTER TABLE `payu_webhook_response`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
