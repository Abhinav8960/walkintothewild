$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$ MISSING TABLES $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$



-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 28, 2025 at 06:05 PM
-- Server version: 8.0.41-0ubuntu0.22.04.1
-- PHP Version: 8.1.31

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
-- Table structure for table `feeds`
--

CREATE TABLE `feeds` (
  `id` int NOT NULL,
  `objective` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `collection` int NOT NULL,
  `collection_id` int NOT NULL,
  `created_by` int DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `updated_at` int NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `feeds`
--
ALTER TABLE `feeds`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `feeds`
--
ALTER TABLE `feeds`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;


CREATE TABLE `user_post_like` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `user_post_id` int NOT NULL,
  `status` int DEFAULT '1',
  `created_at` int DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL,
  `updated_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_post_like`
--


--
-- Indexes for dumped tables
--

--
-- Indexes for table `user_post_like`
--
ALTER TABLE `user_post_like`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user_post_like`
--
ALTER TABLE `user_post_like`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;



CREATE TABLE `post_report` (
  `id` int NOT NULL,
  `message` text,
  `user_id` int NOT NULL,
  `post_id` int NOT NULL,
  `status` tinyint DEFAULT '1',
  `created_at` int DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `post_report`
--
ALTER TABLE `post_report`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `post_report`
--
ALTER TABLE `post_report`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;




DROP TABLE IF EXISTS `sighting`;
CREATE TABLE `sighting` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `file` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `filepath` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `video_thumbnail` text,
  `video_thumbnail_path` varchar(512) DEFAULT NULL,
  `video_thumbnail_etag` varchar(512) DEFAULT NULL,
  `etag` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `height` int DEFAULT NULL,
  `width` int DEFAULT NULL,
  `latitude` decimal(12,9) DEFAULT NULL,
  `longitude` decimal(12,9) DEFAULT NULL,
  `location` int DEFAULT NULL,
  `description` text,
  `master_animal_id` int DEFAULT NULL,
  `safari_session_id` int DEFAULT NULL,
  `post_datetime` datetime DEFAULT NULL,
  `zone_id` int DEFAULT NULL,
  `v_size` int DEFAULT NULL,
  `v_duration` int DEFAULT NULL,
  `status` int NOT NULL DEFAULT '1',
  `total_view` int DEFAULT '0',
  `created_at` int DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL,
  `updated_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sighting_comment`
--

DROP TABLE IF EXISTS `sighting_comment`;
CREATE TABLE `sighting_comment` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `sighting_id` int NOT NULL,
  `parent_id` int DEFAULT NULL,
  `message` text NOT NULL,
  `comment_datetime` datetime NOT NULL,
  `status` tinyint DEFAULT '1',
  `created_by` int DEFAULT NULL,
  `created_at` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL,
  `updated_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sighting_comment_like`
--

DROP TABLE IF EXISTS `sighting_comment_like`;
CREATE TABLE `sighting_comment_like` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `sighting_comment_id` int NOT NULL,
  `status` tinyint DEFAULT '1',
  `created_at` int DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL,
  `updated_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sighting_like`
--

DROP TABLE IF EXISTS `sighting_like`;
CREATE TABLE `sighting_like` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `sighting_id` int NOT NULL,
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
-- Indexes for table `sighting`
--
ALTER TABLE `sighting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sighting_comment`
--
ALTER TABLE `sighting_comment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sighting_comment_like`
--
ALTER TABLE `sighting_comment_like`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sighting_like`
--
ALTER TABLE `sighting_like`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sighting`
--
ALTER TABLE `sighting`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sighting_comment`
--
ALTER TABLE `sighting_comment`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sighting_comment_like`
--
ALTER TABLE `sighting_comment_like`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sighting_like`
--
ALTER TABLE `sighting_like`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;



DROP TABLE IF EXISTS `sighting_report`;
CREATE TABLE `sighting_report` (
  `id` int NOT NULL,
  `message` text,
  `user_id` int NOT NULL,
  `sighting_id` int NOT NULL,
  `status` tinyint DEFAULT '1',
  `created_at` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `updated_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sighting_report`
--
ALTER TABLE `sighting_report`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sighting_report`
--
ALTER TABLE `sighting_report`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;



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


CREATE TABLE `compliance_documents` (
  `id` int NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `policy_for` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `effective_from` datetime DEFAULT NULL,
  `effective_to` datetime DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text,
  `meta_keywords` text,
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '1 => Active , \r\n0 => Suspended\r\n-1 => Deleted',
  `created_at` int DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL,
  `updated_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `compliance_documents_version`
--

CREATE TABLE `compliance_documents_version` (
  `id` int NOT NULL,
  `compliance_documents_id` int NOT NULL,
  `version` varchar(255) NOT NULL DEFAULT 'v1',
  `description` text NOT NULL,
  `is_live` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` int NOT NULL,
  `updated_at` int NOT NULL,
  `created_by` int NOT NULL,
  `updated_by` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `compliance_documents`
--
ALTER TABLE `compliance_documents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `compliance_documents_version`
--
ALTER TABLE `compliance_documents_version`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `compliance_documents_id` (`compliance_documents_id`,`version`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `compliance_documents`
--
ALTER TABLE `compliance_documents`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `compliance_documents_version`
--
ALTER TABLE `compliance_documents_version`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;


DROP TABLE IF EXISTS `url_shortner`;
CREATE TABLE `url_shortner` (
  `id` int NOT NULL,
  `shortner_url` text NOT NULL,
  `short_id` varchar(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `code` int NOT NULL DEFAULT '302',
  `alias` varchar(10) DEFAULT NULL,
  `one_time_valid` int DEFAULT '0',
  `click_count` int NOT NULL DEFAULT '0',
  `status` int NOT NULL DEFAULT '1',
  `created_at` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `url_shortner_log`
--

DROP TABLE IF EXISTS `url_shortner_log`;
CREATE TABLE `url_shortner_log` (
  `id` int NOT NULL,
  `url_shortner_id` int NOT NULL,
  `user_device` varchar(255) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `user_platform` varchar(255) DEFAULT NULL,
  `user_platform_version` varchar(255) DEFAULT NULL,
  `user_browser` varchar(255) DEFAULT NULL,
  `user_browser_version` varchar(255) DEFAULT NULL,
  `user_ip_address` varchar(255) DEFAULT NULL,
  `created_at` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL,
  `status` int DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `url_shortner`
--
ALTER TABLE `url_shortner`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `short_id` (`short_id`);

--
-- Indexes for table `url_shortner_log`
--
ALTER TABLE `url_shortner_log`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `url_shortner`
--
ALTER TABLE `url_shortner`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `url_shortner_log`
--
ALTER TABLE `url_shortner_log`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;






$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$ QUERIES $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$

ALTER TABLE `package` ADD `live_version` CHAR(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL AFTER `total_view`;
ALTER TABLE `package_safari_park`  ADD `version` VARCHAR(10) NOT NULL  AFTER `package_id`;
ALTER TABLE `share_safari` ADD `is_published_on_api` BOOLEAN NOT NULL DEFAULT TRUE AFTER `status`, ADD `is_published_on_web` BOOLEAN NOT NULL DEFAULT TRUE AFTER `is_published_on_api`;
ALTER TABLE `safari_park` ADD `is_published_on_web` BOOLEAN NOT NULL DEFAULT TRUE AFTER `google_review_count`, ADD `is_published_on_api` BOOLEAN NOT NULL DEFAULT TRUE AFTER `is_published_on_web`;
ALTER TABLE `package` ADD `is_published_on_web` BOOLEAN NOT NULL DEFAULT TRUE AFTER `updated_by`, ADD `is_published_on_api` BOOLEAN NOT NULL DEFAULT TRUE AFTER `is_published_on_web`;


ALTER TABLE `user_posts`
  DROP `type_of_post`,
  DROP `like_count`,
  DROP `latitude`,
  DROP `longitude`,
  DROP `location`,
  DROP `description`,
  DROP `v_size`,
  DROP `v_duration`;

  ALTER TABLE `user_posts` ADD `size` INT NULL AFTER `etag`;

ALTER TABLE `user_post_comment` CHANGE `message` `comment` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL;
ALTER TABLE `user_post_comment` CHANGE `comment_datetime` `dateTime` DATETIME NOT NULL;
ALTER TABLE `sighting_comment` CHANGE `comment_datetime` `dateTime` DATETIME NOT NULL;
ALTER TABLE `sighting_comment` CHANGE `message` `comment` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL;


//////////////////rename the table where mentioned  //////////////////////////////////////

ALTER TABLE `package_quote` ADD `package_uuid` VARCHAR(255) NOT NULL AFTER `package_id`;

ALTER TABLE `package`  ADD `package_id` INT NOT NULL  AFTER `id`;
ALTER TABLE `package_comment`  ADD `version` VARCHAR(10) NOT NULL  AFTER `package_id`;
ALTER TABLE `package_comment_report`  ADD `version` VARCHAR(10) NOT NULL  AFTER `package_id`;
ALTER TABLE `package_day`  ADD `version` VARCHAR(10) NOT NULL  AFTER `package_id`;
ALTER TABLE `package_enquiry`  ADD `version` VARCHAR(10) NOT NULL  AFTER `package_id`;
ALTER TABLE `package_faq`  ADD `version` VARCHAR(10) NOT NULL  AFTER `package_id`;
ALTER TABLE `package_feature`  ADD `version` VARCHAR(10) NOT NULL  AFTER `package_id`;
ALTER TABLE `package_feature` DROP INDEX `feature_id`, ADD UNIQUE `feature_id` (`feature_id`, `package_id`, `version`) USING BTREE;
ALTER TABLE `package_gallery`  ADD `version` VARCHAR(10) NOT NULL  AFTER `package_id`;
ALTER TABLE `package_included` ADD `version` VARCHAR(10) NOT NULL AFTER `package_id`;
ALTER TABLE `package_included` DROP INDEX `package_id`, ADD UNIQUE `package_id` (`package_id`, `version`, `include_id`) USING BTREE;
ALTER TABLE `package_safari_park`  ADD `version` VARCHAR(10) NOT NULL  AFTER `package_id`;
ALTER TABLE `package_safari_park` DROP INDEX `package_id`, ADD UNIQUE `package_id` (`package_id`, `version`, `park_id`) USING BTREE;
ALTER TABLE `package_states` DROP `uuid`;
ALTER TABLE `package_states` ADD `live_version_data` JSON NULL DEFAULT NULL AFTER `editable_version`;

ALTER TABLE `package_quote` CHANGE `package_uuid` `version` VARCHAR(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL;
/////////////////////////////////////////////////////////////////////////////////////////

ALTER TABLE `user` ADD `apple_source_id` VARCHAR(255) NULL DEFAULT NULL AFTER `google_source_id`;

ALTER TABLE `user_post_like` ADD `safari_operator_id` INT NULL DEFAULT NULL AFTER `user_id`;
ALTER TABLE `user_post_comment_like` ADD `safari_operator_id` INT NULL DEFAULT NULL AFTER `user_id`;
ALTER TABLE `user_post_comment` ADD `safari_operator_id` INT NULL DEFAULT NULL AFTER `user_id`;
ALTER TABLE `sighting_comment_like` ADD `safari_operator_id` INT NULL DEFAULT NULL AFTER `user_id`;
ALTER TABLE `sighting_like` ADD `safari_operator_id` INT NULL DEFAULT NULL AFTER `user_id`;
ALTER TABLE `sighting_comment` ADD `safari_operator_id` INT NULL DEFAULT NULL AFTER `user_id`;
ALTER TABLE `sighting` ADD `safari_operator_id` INT NULL DEFAULT NULL AFTER `user_id`;
ALTER TABLE `package_comment` ADD `safari_operator_id` INT NULL DEFAULT NULL AFTER `user_id`;
ALTER TABLE `share_safari_comment` ADD `safari_operator_id` INT NULL DEFAULT NULL AFTER `user_id`;



//////////////////////////////Check for MODERATION DB///////////////////////////////////////////////////////
ALTER TABLE `moderation` ADD `duration_flag` BOOLEAN NULL DEFAULT NULL AFTER `text`;
ALTER TABLE `video_audio`
  DROP `info_id`,
  DROP `info_position`;

ALTER TABLE `moderation`  ADD `model` VARCHAR(255) NULL DEFAULT NULL  AFTER `updated_by`,  ADD `model_id` INT NULL DEFAULT NULL  AFTER `model`;
ALTER TABLE `moderation` CHANGE `model` `model` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL AFTER `type`, CHANGE `model_id` `model_id` INT NULL DEFAULT NULL AFTER `model`;
ALTER TABLE `moderation` CHANGE `model` `collection` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL, CHANGE `model_id` `collection_id` INT NULL DEFAULT NULL;


ALTER TABLE `moderation` ADD `is_api_failed` INT NULL DEFAULT '0' AFTER `duration_flag`;
