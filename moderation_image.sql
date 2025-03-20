-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 20, 2025 at 10:56 AM
-- Server version: 8.0.41-0ubuntu0.22.04.1
-- PHP Version: 8.1.2-1ubuntu2.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `witw_moderation`
--

-- --------------------------------------------------------

--
-- Table structure for table `image_alcohol`
--

DROP TABLE IF EXISTS `image_alcohol`;
CREATE TABLE `image_alcohol` (
  `id` int NOT NULL,
  `moderation_id` int NOT NULL,
  `media_id` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `prob` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `image_colors`
--

DROP TABLE IF EXISTS `image_colors`;
CREATE TABLE `image_colors` (
  `id` int NOT NULL,
  `moderation_id` int NOT NULL,
  `media_id` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `dominant_r` float DEFAULT NULL,
  `dominant_g` float DEFAULT NULL,
  `dominant_b` float DEFAULT NULL,
  `dominant_hex` varchar(7) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `image_colors_other`
--

DROP TABLE IF EXISTS `image_colors_other`;
CREATE TABLE `image_colors_other` (
  `id` int NOT NULL,
  `color_id` int NOT NULL,
  `moderation_id` int NOT NULL,
  `media_id` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `r` float DEFAULT NULL,
  `g` float DEFAULT NULL,
  `b` float DEFAULT NULL,
  `hex` varchar(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `image_destruction`
--

DROP TABLE IF EXISTS `image_destruction`;
CREATE TABLE `image_destruction` (
  `id` int NOT NULL,
  `moderation_id` int DEFAULT NULL,
  `media_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `prob` float DEFAULT NULL,
  `building_major_damage` float DEFAULT NULL,
  `building_minor_damage` float DEFAULT NULL,
  `building_on_fire` float DEFAULT NULL,
  `building_burned` float DEFAULT NULL,
  `vehicle_major_damage` float DEFAULT NULL,
  `vehicle_minor_damage` float DEFAULT NULL,
  `vehicle_on_fire` float DEFAULT NULL,
  `vehicle_burned` float DEFAULT NULL,
  `wildfire` float DEFAULT NULL,
  `unsafe_fire` float DEFAULT NULL,
  `violent_protest` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `image_faces`
--

DROP TABLE IF EXISTS `image_faces`;
CREATE TABLE `image_faces` (
  `id` int NOT NULL,
  `moderation_id` int DEFAULT NULL,
  `media_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `x1` float DEFAULT NULL,
  `y1` float DEFAULT NULL,
  `x2` float DEFAULT NULL,
  `y2` float DEFAULT NULL,
  `feature_left_eye_x` float DEFAULT NULL,
  `feature_left_eye_y` float DEFAULT NULL,
  `feature_right_eye_x` float DEFAULT NULL,
  `feature_right_eye_y` float DEFAULT NULL,
  `feature_nose_tip_x` float DEFAULT NULL,
  `feature_nose_tip_y` float DEFAULT NULL,
  `feature_left_mouth_corner_x` float DEFAULT NULL,
  `feature_left_mouth_corner_y` float DEFAULT NULL,
  `feature_right_mouth_corner_x` float DEFAULT NULL,
  `feature_right_mouth_corner_y` float DEFAULT NULL,
  `minor` float DEFAULT NULL,
  `sunglasses` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `image_gambling`
--

DROP TABLE IF EXISTS `image_gambling`;
CREATE TABLE `image_gambling` (
  `id` int NOT NULL,
  `moderation_id` int NOT NULL,
  `media_id` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `prob` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `image_gore`
--

DROP TABLE IF EXISTS `image_gore`;
CREATE TABLE `image_gore` (
  `id` int NOT NULL,
  `moderation_id` int NOT NULL,
  `media_id` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `prob` float DEFAULT NULL,
  `very_bloody` float DEFAULT NULL,
  `slightly_bloody` float DEFAULT NULL,
  `body_organ` float DEFAULT NULL,
  `serious_injury` float DEFAULT NULL,
  `superficial_injury` float DEFAULT NULL,
  `corpse` float DEFAULT NULL,
  `skull` float DEFAULT NULL,
  `unconscious` float DEFAULT NULL,
  `body_waste` float DEFAULT NULL,
  `other` float DEFAULT NULL,
  `animated` float DEFAULT NULL,
  `fake` float DEFAULT NULL,
  `real` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `image_media`
--

DROP TABLE IF EXISTS `image_media`;
CREATE TABLE `image_media` (
  `id` int NOT NULL,
  `moderation_id` int DEFAULT NULL,
  `media_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `uri` varchar(512) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `image_medical`
--

DROP TABLE IF EXISTS `image_medical`;
CREATE TABLE `image_medical` (
  `id` int NOT NULL,
  `moderation_id` int NOT NULL,
  `media_id` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `prob` float DEFAULT NULL,
  `pills` float DEFAULT NULL,
  `paraphernalia` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `image_military`
--

DROP TABLE IF EXISTS `image_military`;
CREATE TABLE `image_military` (
  `id` int NOT NULL,
  `moderation_id` int DEFAULT NULL,
  `media_id` varchar(255) DEFAULT NULL,
  `prob` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `military_equipment` float DEFAULT NULL,
  `military_personnel` float DEFAULT NULL,
  `military_profile_photo` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `image_money`
--

DROP TABLE IF EXISTS `image_money`;
CREATE TABLE `image_money` (
  `id` int NOT NULL,
  `moderation_id` int NOT NULL,
  `media_id` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `prob` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `image_nudity`
--

DROP TABLE IF EXISTS `image_nudity`;
CREATE TABLE `image_nudity` (
  `id` int NOT NULL,
  `moderation_id` int NOT NULL,
  `media_id` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `request_timestamp` int DEFAULT NULL,
  `sexual_activity` float DEFAULT NULL,
  `sexual_display` float DEFAULT NULL,
  `erotica` float DEFAULT NULL,
  `very_suggestive` float DEFAULT NULL,
  `suggestive` float DEFAULT NULL,
  `mildly_suggestive` float DEFAULT NULL,
  `bikini` float DEFAULT NULL,
  `cleavage` float DEFAULT NULL,
  `lingerie` float DEFAULT NULL,
  `male_chest` float DEFAULT NULL,
  `male_underwear` float DEFAULT NULL,
  `miniskirt` float DEFAULT NULL,
  `other` float DEFAULT NULL,
  `minishort` float DEFAULT NULL,
  `nudity_art` float DEFAULT NULL,
  `schematic` float DEFAULT NULL,
  `sextoy` float DEFAULT NULL,
  `suggestive_focus` float DEFAULT NULL,
  `suggestive_pose` float DEFAULT NULL,
  `swimwear_male` float DEFAULT NULL,
  `swimwear_one_piece` float DEFAULT NULL,
  `visibly_undressed` float DEFAULT NULL,
  `none` float DEFAULT NULL,
  `sea_lake_pool` float DEFAULT NULL,
  `outdoor_other` float DEFAULT NULL,
  `indoor_other` float DEFAULT NULL,
  `cleavage_very_revealing` float DEFAULT NULL,
  `cleavage_revealing` float DEFAULT NULL,
  `cleavage_none` float DEFAULT NULL,
  `male_chest_very_revealing` float DEFAULT NULL,
  `male_chest_revealing` float DEFAULT NULL,
  `male_chest_slightly_revealing` float DEFAULT NULL,
  `male_chest_none` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `image_offensive`
--

DROP TABLE IF EXISTS `image_offensive`;
CREATE TABLE `image_offensive` (
  `id` int NOT NULL,
  `moderation_id` int NOT NULL,
  `media_id` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `nazi` float DEFAULT NULL,
  `asian_swastika` float DEFAULT NULL,
  `confederate` float DEFAULT NULL,
  `supremacist` float DEFAULT NULL,
  `terrorist` float DEFAULT NULL,
  `middle_finger` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `image_quality`
--

DROP TABLE IF EXISTS `image_quality`;
CREATE TABLE `image_quality` (
  `id` int NOT NULL,
  `moderation_id` int NOT NULL,
  `media_id` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `score` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `image_recreational_drug`
--

DROP TABLE IF EXISTS `image_recreational_drug`;
CREATE TABLE `image_recreational_drug` (
  `id` int NOT NULL,
  `moderation_id` int NOT NULL,
  `media_id` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `prob` float DEFAULT NULL,
  `cannabis` float DEFAULT NULL,
  `cannabis_logo_only` float DEFAULT NULL,
  `cannabis_plant` float DEFAULT NULL,
  `cannabis_drug` float DEFAULT NULL,
  `recreational_drugs_not_cannabis` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `image_request`
--

DROP TABLE IF EXISTS `image_request`;
CREATE TABLE `image_request` (
  `id` int NOT NULL,
  `request_id` varchar(255) DEFAULT NULL,
  `moderation_id` int DEFAULT NULL,
  `media_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `timestamp` float DEFAULT NULL,
  `operations` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `image_scam`
--

DROP TABLE IF EXISTS `image_scam`;
CREATE TABLE `image_scam` (
  `id` int NOT NULL,
  `moderation_id` int NOT NULL,
  `media_id` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `prob` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `image_self_harm`
--

DROP TABLE IF EXISTS `image_self_harm`;
CREATE TABLE `image_self_harm` (
  `id` int NOT NULL,
  `moderation_id` int DEFAULT NULL,
  `media_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `prob` float DEFAULT NULL,
  `real` float DEFAULT NULL,
  `fake` float DEFAULT NULL,
  `animated` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `image_tobacco`
--

DROP TABLE IF EXISTS `image_tobacco`;
CREATE TABLE `image_tobacco` (
  `id` int NOT NULL,
  `moderation_id` int DEFAULT NULL,
  `media_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `prob` float DEFAULT NULL,
  `regular_tobacco` float DEFAULT NULL,
  `ambiguous_tobacco` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `image_type`
--

DROP TABLE IF EXISTS `image_type`;
CREATE TABLE `image_type` (
  `id` int NOT NULL,
  `moderation_id` int DEFAULT NULL,
  `media_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `photo` float DEFAULT NULL,
  `illustration` float DEFAULT NULL,
  `ai_generated` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `image_violence`
--

DROP TABLE IF EXISTS `image_violence`;
CREATE TABLE `image_violence` (
  `id` int NOT NULL,
  `moderation_id` int DEFAULT NULL,
  `media_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `prob` float DEFAULT NULL,
  `physical_violence` float DEFAULT NULL,
  `firearm_threat` float DEFAULT NULL,
  `combat_sport` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `image_weapon`
--

DROP TABLE IF EXISTS `image_weapon`;
CREATE TABLE `image_weapon` (
  `id` int NOT NULL,
  `moderation_id` int NOT NULL,
  `media_id` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `firearm` float DEFAULT NULL,
  `firearm_gesture` float DEFAULT NULL,
  `firearm_toy` float DEFAULT NULL,
  `knife` float DEFAULT NULL,
  `animated` float DEFAULT NULL,
  `aiming_threat` float DEFAULT NULL,
  `aiming_camera` float DEFAULT NULL,
  `aiming_safe` float DEFAULT NULL,
  `in_hand_not_aiming` float DEFAULT NULL,
  `worn_not_in_hand` float DEFAULT NULL,
  `not_worn` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `image_alcohol`
--
ALTER TABLE `image_alcohol`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `image_colors`
--
ALTER TABLE `image_colors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `image_colors_other`
--
ALTER TABLE `image_colors_other`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `image_destruction`
--
ALTER TABLE `image_destruction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `image_faces`
--
ALTER TABLE `image_faces`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `image_gambling`
--
ALTER TABLE `image_gambling`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `image_gore`
--
ALTER TABLE `image_gore`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `image_media`
--
ALTER TABLE `image_media`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `image_medical`
--
ALTER TABLE `image_medical`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `image_military`
--
ALTER TABLE `image_military`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `image_money`
--
ALTER TABLE `image_money`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `image_nudity`
--
ALTER TABLE `image_nudity`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `image_offensive`
--
ALTER TABLE `image_offensive`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `image_quality`
--
ALTER TABLE `image_quality`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `image_recreational_drug`
--
ALTER TABLE `image_recreational_drug`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `image_request`
--
ALTER TABLE `image_request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `image_scam`
--
ALTER TABLE `image_scam`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `image_self_harm`
--
ALTER TABLE `image_self_harm`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `image_tobacco`
--
ALTER TABLE `image_tobacco`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `image_type`
--
ALTER TABLE `image_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `image_violence`
--
ALTER TABLE `image_violence`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `image_weapon`
--
ALTER TABLE `image_weapon`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `image_alcohol`
--
ALTER TABLE `image_alcohol`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `image_colors`
--
ALTER TABLE `image_colors`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `image_colors_other`
--
ALTER TABLE `image_colors_other`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `image_destruction`
--
ALTER TABLE `image_destruction`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `image_faces`
--
ALTER TABLE `image_faces`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `image_gambling`
--
ALTER TABLE `image_gambling`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `image_gore`
--
ALTER TABLE `image_gore`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `image_media`
--
ALTER TABLE `image_media`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `image_medical`
--
ALTER TABLE `image_medical`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `image_military`
--
ALTER TABLE `image_military`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `image_money`
--
ALTER TABLE `image_money`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `image_nudity`
--
ALTER TABLE `image_nudity`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `image_offensive`
--
ALTER TABLE `image_offensive`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `image_quality`
--
ALTER TABLE `image_quality`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `image_recreational_drug`
--
ALTER TABLE `image_recreational_drug`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `image_request`
--
ALTER TABLE `image_request`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `image_scam`
--
ALTER TABLE `image_scam`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `image_self_harm`
--
ALTER TABLE `image_self_harm`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `image_tobacco`
--
ALTER TABLE `image_tobacco`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `image_type`
--
ALTER TABLE `image_type`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `image_violence`
--
ALTER TABLE `image_violence`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `image_weapon`
--
ALTER TABLE `image_weapon`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
