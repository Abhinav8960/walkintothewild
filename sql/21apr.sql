

-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 22, 2025 at 12:09 PM
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
  `step_1` int DEFAULT '0',
  `step_2` int DEFAULT '0',
  `step_3` int DEFAULT '0',
  `step_4` int DEFAULT '0',
  `step_5` int DEFAULT '0',
  `updated_time_step_1` int DEFAULT NULL,
  `updated_time_step_2` int DEFAULT NULL,
  `updated_time_step_3` int DEFAULT NULL,
  `updated_time_step_4` int DEFAULT NULL,
  `updated_time_step_5` int DEFAULT NULL,
  `final` int DEFAULT NULL,
  `updated_time_final` int DEFAULT NULL,
  `status` int DEFAULT NULL,
  `created_at` int DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL,
  `updated_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `operator_registration_form`
--

INSERT INTO `operator_registration_form` (`id`, `user_id`, `name`, `email`, `phone_no`, `whatsap_no`, `dob`, `gender`, `kyc_detail`, `business_registration_name`, `business_brand_name`, `business_full_name`, `business_phone_no`, `business_whatsap_no`, `business_email_id`, `business_logo_upload`, `type_of_business`, `business_doc_reg_no`, `business_kyc_detail`, `business_operated_park`, `business_detail`, `gst`, `bank_name`, `account_holder_name`, `account_no`, `ifsc_code`, `cancle_check`, `upload_adhar_no`, `upload_aadhar_front`, `upload_aadhar_back`, `pan_no`, `pan_upload`, `upload_registration_number`, `upload_registration_cert`, `upload_document`, `current_step`, `step_1`, `step_2`, `step_3`, `step_4`, `step_5`, `updated_time_step_1`, `updated_time_step_2`, `updated_time_step_3`, `updated_time_step_4`, `updated_time_step_5`, `final`, `updated_time_final`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 747, 'asfdasf', 'sadfasf@gmail.com', '1234567890', NULL, NULL, NULL, NULL, 'Business Registration Name', 'Business Brand Name', NULL, NULL, '8761249310', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'adfsdf', 'sdfasdf', '1234567890', '1234567890', NULL, '1234567890', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1745303418, 747, 1745303439, 747);

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;