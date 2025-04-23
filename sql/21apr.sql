
ALTER TABLE `user_wishlist` CHANGE `item_id` `item_id` VARCHAR(255) NULL DEFAULT NULL;
ALTER TABLE `package_safari_park`  ADD `package_uuid` VARCHAR(255) NOT NULL  AFTER `package_id`;

-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 23, 2025 at 01:44 PM
-- Server version: 8.0.41-0ubuntu0.22.04.1
-- PHP Version: 8.1.2-1ubuntu2.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `walkintothewild`
--

-- --------------------------------------------------------

--
-- Table structure for table `operator_registration_form`
--

DROP TABLE IF EXISTS `operator_registration_form`;
CREATE TABLE `operator_registration_form` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone_no` varchar(15) DEFAULT NULL,
  `whatsap_no` varchar(15) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `kyc_detail` longblob,
  `business_registration_name` varchar(150) DEFAULT NULL,
  `business_brand_name` varchar(150) DEFAULT NULL,
  `business_full_name` varchar(150) DEFAULT NULL,
  `business_phone_no` varchar(20) DEFAULT NULL,
  `business_whatsap_no` varchar(20) DEFAULT NULL,
  `business_email_id` varchar(150) DEFAULT NULL,
  `business_logo_upload` varchar(255) DEFAULT NULL,
  `type_of_business` varchar(100) DEFAULT NULL,
  `business_doc_reg_no` varchar(100) DEFAULT NULL,
  `business_kyc_detail` varchar(255) DEFAULT NULL,
  `business_operated_park` varchar(255) DEFAULT NULL,
  `business_detail` text,
  `gst` varchar(30) DEFAULT NULL,
  `bank_name` varchar(100) DEFAULT NULL,
  `account_holder_name` varchar(100) DEFAULT NULL,
  `account_no` varchar(50) DEFAULT NULL,
  `ifsc_code` varchar(20) DEFAULT NULL,
  `cancle_check` varchar(255) DEFAULT NULL,
  `upload_adhar_no` varchar(20) DEFAULT NULL,
  `upload_aadhar_front` varchar(255) DEFAULT NULL,
  `upload_aadhar_back` varchar(255) DEFAULT NULL,
  `pan_no` varchar(20) DEFAULT NULL,
  `pan_upload` varchar(255) DEFAULT NULL,
  `upload_registration_number` varchar(100) DEFAULT NULL,
  `upload_registration_cert` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `upload_document` varchar(255) DEFAULT NULL,
  `current_step` int DEFAULT '1',
  `is_step_1_submit` tinyint(1) DEFAULT '0',
  `is_step_2_submit` tinyint(1) DEFAULT '0',
  `is_step_3_submit` tinyint(1) DEFAULT '0',
  `is_step_4_submit` tinyint(1) DEFAULT '0',
  `is_step_1_approved` int DEFAULT '0',
  `is_step_2_approved` int DEFAULT '0',
  `is_step_3_approved` int DEFAULT '0',
  `is_step_4_approved` int DEFAULT '0',
  `is_step_5_approved` int DEFAULT '0',
  `step_1_reject_reason` varchar(512) DEFAULT NULL,
  `step_2_reject_reason` varchar(512) DEFAULT NULL,
  `step_3_reject_reason` varchar(512) DEFAULT NULL,
  `step_4_reject_reason` varchar(512) DEFAULT NULL,
  `updated_time_step_1` datetime DEFAULT NULL,
  `updated_time_step_2` datetime DEFAULT NULL,
  `updated_time_step_3` datetime DEFAULT NULL,
  `updated_time_step_4` datetime DEFAULT NULL,
  `updated_time_step_5` datetime DEFAULT NULL,
  `final` int DEFAULT NULL,
  `final_approved` int DEFAULT '0',
  `updated_time_final_approved` datetime DEFAULT NULL,
  `updated_time_final` datetime DEFAULT NULL,
  `status` int DEFAULT '0',
  `created_at` int DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL,
  `updated_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `operator_registration_form`
--
ALTER TABLE `operator_registration_form`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `operator_registration_form`
--
ALTER TABLE `operator_registration_form`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;