ALTER TABLE `package` DROP `package_slug`;
ALTER TABLE `package` CHANGE `status` `status` INT NULL DEFAULT '1' COMMENT '0=Not Approved,1=>Approved and Live,2=>Send For Approval,3=Editable,4=>Terminated';
ALTER TABLE `package` ADD `uuid` VARCHAR(255) NOT NULL AFTER `id`, ADD `version` VARCHAR(10) NOT NULL DEFAULT 'v1' AFTER `uuid`, ADD `cancellation_reason` TEXT NULL DEFAULT NULL AFTER `version`;
ALTER TABLE `package` CHANGE `id` `id` INT NOT NULL auto_increment FIRST, CHANGE `uuid` `uuid` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL AFTER `id`, CHANGE `version` `version` VARCHAR(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'v1' AFTER `uuid`, CHANGE `package_name` `package_name` VARCHAR(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL AFTER `version`, CHANGE `owned_by_id` `owned_by_id` INT NULL DEFAULT NULL AFTER `package_name`, CHANGE `package_slug` `package_slug` VARCHAR(720) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL AFTER `owned_by_id`, CHANGE `package_agenda_id` `package_agenda_id` INT NULL DEFAULT NULL AFTER `package_slug`, CHANGE `no_of_day` `no_of_day` INT NOT NULL DEFAULT '0' AFTER `package_agenda_id`, CHANGE `no_of_night` `no_of_night` INT NULL DEFAULT '0' AFTER `no_of_day`, CHANGE `safari_type` `safari_type` INT NULL DEFAULT NULL AFTER `no_of_night`, CHANGE `no_of_safari` `no_of_safari` INT NULL DEFAULT '0' AFTER `safari_type`, CHANGE `start_location` `start_location` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL AFTER `no_of_safari`, CHANGE `end_location` `end_location` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL AFTER `start_location`, CHANGE `start_date` `start_date` DATE NULL DEFAULT NULL AFTER `end_location`, CHANGE `end_date` `end_date` DATE NULL DEFAULT NULL AFTER `start_date`, CHANGE `package_image` `package_image` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL AFTER `end_date`, CHANGE `package_banner_image` `package_banner_image` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL AFTER `package_image`, CHANGE `stay_category_id` `stay_category_id` INT NULL DEFAULT NULL AFTER `package_banner_image`, CHANGE `cost_per_person` `cost_per_person` DECIMAL(10,2) NULL DEFAULT '0.00' AFTER `stay_category_id`, CHANGE `type` `type` INT NULL DEFAULT NULL AFTER `cost_per_person`, CHANGE `gst_percentage` `gst_percentage` INT NULL DEFAULT NULL AFTER `type`, CHANGE `total_price` `total_price` DECIMAL(10,2) NULL DEFAULT '0.00' AFTER `gst_percentage`, CHANGE `package_description` `package_description` LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL AFTER `total_price`, CHANGE `package_itinerary_overview` `package_itinerary_overview` LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL AFTER `package_description`, CHANGE `package_inclusion` `package_inclusion` LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL AFTER `package_itinerary_overview`, CHANGE `package_exclusion` `package_exclusion` LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL AFTER `package_inclusion`, CHANGE `package_terms_condtition` `package_terms_condtition` LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL AFTER `package_exclusion`, CHANGE `privacy_policy` `privacy_policy` LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL AFTER `package_terms_condtition`, CHANGE `change_policy` `change_policy` LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL AFTER `privacy_policy`, CHANGE `what_you_must_carry` `what_you_must_carry` LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL AFTER `change_policy`, CHANGE `date_change_policy` `date_change_policy` LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL AFTER `what_you_must_carry`, CHANGE `refund_policy` `refund_policy` LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL AFTER `date_change_policy`, CHANGE `getting_there` `getting_there` LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL AFTER `refund_policy`, CHANGE `master_vehicle_id` `master_vehicle_id` INT NULL DEFAULT NULL AFTER `getting_there`, CHANGE `lunch_included` `lunch_included` TINYINT NOT NULL DEFAULT '0' AFTER `breakfast_included`, CHANGE `dinner_included` `dinner_included` TINYINT NOT NULL DEFAULT '0' AFTER `lunch_included`, CHANGE `meal_not_included` `meal_not_included` TINYINT NOT NULL DEFAULT '0' AFTER `dinner_included`, CHANGE `popular_package` `popular_package` INT NULL DEFAULT NULL AFTER `meal_not_included`, CHANGE `delete_reason_id` `delete_reason_id` INT NULL DEFAULT NULL AFTER `popular_package`, CHANGE `delete_reason` `delete_reason` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL AFTER `delete_reason_id`, CHANGE `created_at` `created_at` INT NULL DEFAULT NULL AFTER `delete_reason`, CHANGE `created_by` `created_by` INT NULL DEFAULT NULL AFTER `created_at`, CHANGE `updated_at` `updated_at` INT NULL DEFAULT NULL AFTER `created_by`, CHANGE `updated_by` `updated_by` INT NULL DEFAULT NULL AFTER `updated_at`, CHANGE `is_published_on_web` `is_published_on_web` TINYINT(1) NOT NULL DEFAULT '1' AFTER `updated_by`, CHANGE `is_published_on_api` `is_published_on_api` TINYINT(1) NOT NULL DEFAULT '1' AFTER `is_published_on_web`
ALTER TABLE `package` CHANGE `status` `status` INT NULL DEFAULT '3' COMMENT '0=Not Approved,1=>Approved and Live,2=>Send For Approval,3=Editable,4=>Terminated';
DROP TABLE `package_approval`, `package_comment_approval`, `package_comment_report_approval`, `package_day_approval`, `package_enquiry_approval`, `package_faq_approval`, `package_feature_approval`, `package_gallery_approval`, `package_included_approval`, `package_quote_approval`, `package_safari_park_approval`, `package_states_approval`;
UPDATE `package_states` SET `live_version`='v1',`editable_version`='v2';
UPDATE `package` SET `status`=1 WHERE `version` ='v1';
-- 
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
  `is_step_1_approved` int DEFAULT '0',
  `is_step_2_approved` int DEFAULT '0',
  `is_step_3_approved` int DEFAULT '0',
  `is_step_4_approved` int DEFAULT '0',
  `is_step_5_approved` int DEFAULT '0',
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