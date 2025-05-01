-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 30, 2025 at 05:31 PM
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
-- Database: `witw_staging`
--

-- --------------------------------------------------------

--
-- Table structure for table `package_version`
--

DROP TABLE IF EXISTS `package_version`;
CREATE TABLE `package_version` (
  `id` int NOT NULL,
  `package_id` int NOT NULL,
  `version` varchar(10) NOT NULL,
  `package_name` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `owned_by_id` int DEFAULT NULL,
  `package_agenda_id` int DEFAULT NULL,
  `no_of_day` int NOT NULL DEFAULT '0',
  `no_of_night` int DEFAULT '0',
  `safari_type` int DEFAULT NULL,
  `no_of_safari` int DEFAULT '0',
  `start_location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `end_location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `package_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `package_banner_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `stay_category_id` int DEFAULT NULL,
  `cost_per_person` decimal(10,2) DEFAULT '0.00',
  `type` int DEFAULT NULL,
  `gst_percentage` int DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT '0.00',
  `package_description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `package_itinerary_overview` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `package_inclusion` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `package_exclusion` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `package_terms_condtition` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `privacy_policy` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `change_policy` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `what_you_must_carry` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `date_change_policy` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `refund_policy` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `getting_there` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `master_vehicle_id` int DEFAULT NULL,
  `cancellation_reason` text,
  `breakfast_included` tinyint NOT NULL DEFAULT '0',
  `lunch_included` tinyint NOT NULL DEFAULT '0',
  `dinner_included` tinyint NOT NULL DEFAULT '0',
  `meal_not_included` tinyint NOT NULL DEFAULT '0',
  `popular_package` int DEFAULT NULL,
  `delete_reason_id` int DEFAULT NULL,
  `delete_reason` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `created_at` int DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `is_published_on_web` tinyint(1) NOT NULL DEFAULT '1',
  `is_published_on_api` tinyint(1) NOT NULL DEFAULT '1',
  `status` int DEFAULT '3' COMMENT '0=Not Approved,1=>Approved and Live,2=>Send For Approval,3=Editable,4=>Terminated',
  `total_view` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `package_version`
--
ALTER TABLE `package_version`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `package_version`
--
ALTER TABLE `package_version`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;