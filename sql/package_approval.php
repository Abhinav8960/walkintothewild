-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 20, 2025 at 11:16 AM
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
-- Database: `wildwalks`
--

-- --------------------------------------------------------

--
-- Table structure for table `package_approval`
--

DROP TABLE IF EXISTS `package_approval`;
CREATE TABLE `package_approval` (
  `id` int NOT NULL,
  `package_name` varchar(512) NOT NULL,
  `owned_by_id` int DEFAULT NULL,
  `package_slug` varchar(720) NOT NULL,
  `package_agenda_id` int DEFAULT NULL,
  `no_of_day` int NOT NULL DEFAULT '0',
  `no_of_night` int DEFAULT '0',
  `safari_type` int DEFAULT NULL,
  `no_of_safari` int DEFAULT '0',
  `start_location` varchar(255) DEFAULT NULL,
  `end_location` varchar(255) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `package_image` varchar(255) DEFAULT NULL,
  `package_banner_image` varchar(255) DEFAULT NULL,
  `stay_category_id` int DEFAULT NULL,
  `cost_per_person` decimal(10,2) DEFAULT '0.00',
  `type` int DEFAULT NULL,
  `gst_percentage` int DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT '0.00',
  `package_description` longtext,
  `package_itinerary_overview` longtext,
  `package_inclusion` longtext,
  `package_exclusion` longtext,
  `package_terms_condtition` longtext,
  `privacy_policy` longtext,
  `change_policy` longtext,
  `what_you_must_carry` longtext,
  `date_change_policy` longtext,
  `refund_policy` longtext,
  `getting_there` longtext,
  `master_vehicle_id` int DEFAULT NULL,
  `breakfast_included` tinyint NOT NULL DEFAULT '0',
  `lunch_included` tinyint NOT NULL DEFAULT '0',
  `dinner_included` tinyint NOT NULL DEFAULT '0',
  `meal_not_included` tinyint NOT NULL DEFAULT '0',
  `popular_package` int DEFAULT NULL,
  `delete_reason_id` int DEFAULT NULL,
  `delete_reason` text,
  `created_at` int DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `is_published_on_web` tinyint(1) NOT NULL DEFAULT '1',
  `is_published_on_api` tinyint(1) NOT NULL DEFAULT '1',
  `status` int DEFAULT '1',
  `total_view` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `package_comment_approval`
--

DROP TABLE IF EXISTS `package_comment_approval`;
CREATE TABLE `package_comment_approval` (
  `id` int NOT NULL,
  `package_id` int DEFAULT NULL,
  `parent_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `comment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `flaged` int NOT NULL DEFAULT '0',
  `is_deleted` int DEFAULT '0',
  `created_at` int DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `status` int DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `package_comment_report_approval`
--

DROP TABLE IF EXISTS `package_comment_report_approval`;
CREATE TABLE `package_comment_report_approval` (
  `id` int NOT NULL,
  `package_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `package_comment_id` int DEFAULT NULL,
  `reason` varchar(512) DEFAULT NULL,
  `report_reason_id` int DEFAULT NULL,
  `report_detail` varchar(512) DEFAULT NULL,
  `created_at` int DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `status` int DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `package_day_approval`
--

DROP TABLE IF EXISTS `package_day_approval`;
CREATE TABLE `package_day_approval` (
  `id` int NOT NULL,
  `package_id` int NOT NULL,
  `day` int NOT NULL,
  `day_title` varchar(512) DEFAULT NULL,
  `day_description` text,
  `start_location` varchar(255) DEFAULT NULL,
  `end_location` varchar(255) DEFAULT NULL,
  `latitude` varchar(50) DEFAULT NULL,
  `longitude` varchar(50) DEFAULT NULL,
  `hotel_name` varchar(255) DEFAULT NULL,
  `day_image` varchar(255) DEFAULT NULL,
  `meal_lunch` tinyint(1) DEFAULT '0',
  `meal_breakfast` tinyint(1) DEFAULT '0',
  `meal_dinner` tinyint(1) DEFAULT '0',
  `day_activity` text,
  `day_accommodation` text,
  `day_note` text,
  `status` int DEFAULT '1',
  `created_at` int DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL,
  `updated_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `package_enquiry_approval`
--

DROP TABLE IF EXISTS `package_enquiry_approval`;
CREATE TABLE `package_enquiry_approval` (
  `id` int NOT NULL,
  `safari_operator_id` int DEFAULT NULL,
  `package_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `no_of_travelers` int DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `name` varchar(512) DEFAULT NULL,
  `email_address` varchar(512) DEFAULT NULL,
  `phone` varchar(12) DEFAULT NULL,
  `status` int DEFAULT '1',
  `created_at` int DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL,
  `updated_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `package_faq_approval`
--

DROP TABLE IF EXISTS `package_faq_approval`;
CREATE TABLE `package_faq_approval` (
  `id` int NOT NULL,
  `package_id` int NOT NULL,
  `faq_id` int DEFAULT NULL,
  `question` varchar(512) DEFAULT NULL,
  `answer` text,
  `position` int DEFAULT '0',
  `status` int DEFAULT '1',
  `created_at` int DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL,
  `updated_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `package_feature_approval`
--

DROP TABLE IF EXISTS `package_feature_approval`;
CREATE TABLE `package_feature_approval` (
  `id` int NOT NULL,
  `package_id` int NOT NULL,
  `feature_id` int NOT NULL,
  `status` int DEFAULT '1',
  `created_at` int DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `package_gallery_approval`
--

DROP TABLE IF EXISTS `package_gallery_approval`;
CREATE TABLE `package_gallery_approval` (
  `id` int NOT NULL,
  `package_id` int NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `image_caption` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `sequence` int NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` int NOT NULL,
  `updated_at` int NOT NULL,
  `created_by` int NOT NULL,
  `updated_by` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `package_included_approval`
--

DROP TABLE IF EXISTS `package_included_approval`;
CREATE TABLE `package_included_approval` (
  `id` int NOT NULL,
  `package_id` int NOT NULL,
  `include_id` int NOT NULL,
  `selection` int DEFAULT NULL,
  `status` int DEFAULT '1',
  `created_at` int DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `package_quote_approval`
--

DROP TABLE IF EXISTS `package_quote_approval`;
CREATE TABLE `package_quote_approval` (
  `id` int NOT NULL,
  `package_id` int DEFAULT NULL COMMENT 'Package Id',
  `travelers` int DEFAULT NULL,
  `start_date` varchar(255) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `os` varchar(255) DEFAULT NULL COMMENT 'OS',
  `browser` varchar(255) DEFAULT NULL COMMENT 'Browser',
  `device_type` varchar(255) DEFAULT NULL COMMENT 'Browser',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `updated_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `package_safari_park_approval`
--

DROP TABLE IF EXISTS `package_safari_park_approval`;
CREATE TABLE `package_safari_park_approval` (
  `id` int NOT NULL,
  `package_id` int NOT NULL,
  `park_id` int NOT NULL,
  `status` int DEFAULT '1',
  `created_at` int DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL,
  `updated_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `package_approval`
--
ALTER TABLE `package_approval`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `package_slug` (`package_slug`);

--
-- Indexes for table `package_comment_approval`
--
ALTER TABLE `package_comment_approval`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `package_comment_report_approval`
--
ALTER TABLE `package_comment_report_approval`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `package_day_approval`
--
ALTER TABLE `package_day_approval`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `package_id` (`package_id`,`day`);

--
-- Indexes for table `package_enquiry_approval`
--
ALTER TABLE `package_enquiry_approval`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `package_faq_approval`
--
ALTER TABLE `package_faq_approval`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `package_feature_approval`
--
ALTER TABLE `package_feature_approval`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `feature_id` (`feature_id`,`package_id`);

--
-- Indexes for table `package_gallery_approval`
--
ALTER TABLE `package_gallery_approval`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `package_included_approval`
--
ALTER TABLE `package_included_approval`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `package_id` (`package_id`,`include_id`);

--
-- Indexes for table `package_quote_approval`
--
ALTER TABLE `package_quote_approval`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `package_safari_park_approval`
--
ALTER TABLE `package_safari_park_approval`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `package_id` (`package_id`,`park_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `package_approval`
--
ALTER TABLE `package_approval`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `package_comment_approval`
--
ALTER TABLE `package_comment_approval`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `package_comment_report_approval`
--
ALTER TABLE `package_comment_report_approval`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `package_day_approval`
--
ALTER TABLE `package_day_approval`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `package_enquiry_approval`
--
ALTER TABLE `package_enquiry_approval`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `package_faq_approval`
--
ALTER TABLE `package_faq_approval`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `package_feature_approval`
--
ALTER TABLE `package_feature_approval`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `package_gallery_approval`
--
ALTER TABLE `package_gallery_approval`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
