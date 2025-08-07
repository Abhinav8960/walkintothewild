-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 07, 2025 at 04:31 PM
-- Server version: 8.0.42-0ubuntu0.22.04.1
-- PHP Version: 8.1.2-1ubuntu2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `prod_witw_23`
--

-- --------------------------------------------------------

--
-- Table structure for table `share_safari_version`
--

CREATE TABLE `share_safari_version` (
  `id` int NOT NULL,
  `share_safari_title` varchar(255) NOT NULL,
  `share_safari_id` int NOT NULL,
  `version` int NOT NULL DEFAULT '1',
  `type` int DEFAULT NULL,
  `host_user_id` int DEFAULT NULL,
  `safari_operator_id` int DEFAULT NULL,
  `user_id` int NOT NULL,
  `host_type` int DEFAULT NULL,
  `park_id` int DEFAULT NULL,
  `share_safari_agenda_id` int DEFAULT NULL,
  `no_of_safari` int DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `cut_off_date` date DEFAULT NULL,
  `image_filepath` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `stay_category_id` int DEFAULT NULL,
  `estimate_price_min` int DEFAULT NULL,
  `estimate_price_max` int DEFAULT NULL,
  `cost_per_person` int DEFAULT NULL,
  `safari_plan` text,
  `website_url` text,
  `total_seat` int DEFAULT NULL,
  `share_seat` int DEFAULT NULL,
  `tour_duration` int DEFAULT NULL,
  `share_safari_inclusion` varchar(2000) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `share_safari_exclusion` varchar(2000) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `getting_there` longtext,
  `breakfast_included` tinyint NOT NULL DEFAULT '0',
  `lunch_included` tinyint NOT NULL DEFAULT '0',
  `dinner_included` tinyint NOT NULL DEFAULT '0',
  `meal_not_included` tinyint NOT NULL DEFAULT '0',
  `created_at` int DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `delete_reason_id` tinyint DEFAULT NULL,
  `delete_reason` text,
  `status` int DEFAULT '3' COMMENT '0=Not Approved,1=>Approved and Live,2=>Send For Approval,3=Editable,4=>Terminated',
  `is_published_on_api` tinyint(1) NOT NULL DEFAULT '1',
  `is_published_on_web` tinyint(1) NOT NULL DEFAULT '1',
  `total_view` int NOT NULL DEFAULT '0',
  `pined_safari` int DEFAULT NULL,
  `final_approved_at` int DEFAULT NULL,
  `partner_gallery_id` int DEFAULT NULL,
  `gallery_json` json DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `share_safari_version`
--
ALTER TABLE `share_safari_version`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `share_safari_version`
--
ALTER TABLE `share_safari_version`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;