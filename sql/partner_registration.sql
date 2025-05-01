-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 30, 2025 at 04:54 PM
-- Server version: 8.0.41-0ubuntu0.22.04.1
-- PHP Version: 8.1.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `witw_production`
--

-- --------------------------------------------------------

--
-- Table structure for table `partner_registration`
--

CREATE TABLE `partner_registration` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `legal_entity_name` varchar(255) DEFAULT NULL,
  `legal_entity_type` int DEFAULT NULL COMMENT '1= PROP_WRITER,\r\n2= PVT_LTD,\r\n3=LLP',
  `brand_name` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `legal_entity_phone` int DEFAULT NULL,
  `legal_entity_whatsapp` bigint DEFAULT NULL,
  `legal_entity_email` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `registration_number` bigint DEFAULT NULL,
  `registration_copy_upload` varchar(255) DEFAULT NULL,
  `pan_number` varchar(255) DEFAULT NULL,
  `pan_upload` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `operated_park` int DEFAULT NULL,
  `about_business` text,
  `gst_id` int DEFAULT NULL,
  `state` int DEFAULT NULL,
  `gst_number` varchar(255) DEFAULT NULL,
  `gst_upload` varchar(255) DEFAULT NULL,
  `billing_mail` varchar(255) DEFAULT NULL,
  `billing_phone` bigint DEFAULT NULL,
  `bank_name` varchar(255) DEFAULT NULL,
  `account_holder_name` varchar(255) DEFAULT NULL,
  `account_number` bigint DEFAULT NULL,
  `ifsc_number` varchar(255) DEFAULT NULL,
  `cancel_check_upload` varchar(255) DEFAULT NULL,
  `owner_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `kyc_phone` bigint DEFAULT NULL,
  `kyc_whatsapp` bigint DEFAULT NULL,
  `kyc_email` varchar(255) DEFAULT NULL,
  `kyc_pan` varchar(255) DEFAULT NULL,
  `kyc_pan_upload` varchar(255) DEFAULT NULL,
  `aadhar_number` bigint DEFAULT NULL,
  `aadhar_front_upload` varchar(255) DEFAULT NULL,
  `aadhar_back_upload` varchar(255) DEFAULT NULL,
  `current_step` int NOT NULL DEFAULT '1',
  `form1_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 => empty,\r\n1 => filled,\r\n2 => approved,\r\n3 => rejected ',
  `form2_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 => empty,\r\n1 => filled,\r\n2 => approved,\r\n3 => rejected ',
  `form3_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 => empty,\r\n1 => filled,\r\n2 => approved,\r\n3 => rejected ',
  `form4_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 => empty,\r\n1 => filled,\r\n2 => approved,\r\n3 => rejected ',
  `form5_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 => empty,\r\n1 => filled,\r\n2 => approved,\r\n3 => rejected ',
  `is_sendforapproval` tinyint(1) NOT NULL DEFAULT '0',
  `form1_reject_reason` text,
  `form2_reject_reason` text,
  `form3_reject_reason` text,
  `form4_reject_reason` text,
  `form5_reject_reason` text,
  `updated_time_form_1` datetime DEFAULT NULL,
  `updated_time_form_2` datetime DEFAULT NULL,
  `updated_time_form_3` datetime DEFAULT NULL,
  `updated_time_form_4` datetime DEFAULT NULL,
  `updated_time_form_5` datetime DEFAULT NULL,
  `final` int DEFAULT NULL,
  `final_approved` int NOT NULL DEFAULT '0',
  `updated_time_final_approved` datetime DEFAULT NULL,
  `updated_time_final` datetime DEFAULT NULL,
  `status` int DEFAULT '0',
  `created_at` int NOT NULL,
  `created_by` int NOT NULL,
  `updated_at` int NOT NULL,
  `updated_by` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `partner_registration`
--
ALTER TABLE `partner_registration`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `partner_registration`
--
ALTER TABLE `partner_registration`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;