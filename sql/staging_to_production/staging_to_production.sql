-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 27, 2025 at 04:00 PM
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
-- Database: `wildwalks`
--

-- --------------------------------------------------------

--
-- Table structure for table `site_api_request`
--

DROP TABLE IF EXISTS `site_api_request`;
CREATE TABLE `site_api_request` (
  `id` int NOT NULL,
  `user_id` int NOT NULL DEFAULT '0',
  `user_ip` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `request_group` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `slug` varchar(555) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `route` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `request_url` varchar(555) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `request_full_url` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `request_type` varchar(55) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `request_parameter` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `request_data` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `request_code` int NOT NULL DEFAULT '0',
  `response_error` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `is_server_error` tinyint DEFAULT NULL,
  `is_client_error` tinyint DEFAULT NULL,
  `response` text COLLATE utf8mb4_general_ci,
  `device` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `system` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `platform` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `browser` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `browser_version` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `is_count` tinyint NOT NULL DEFAULT '0',
  `is_reqeust_trace` tinyint NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `site_api_request`
--


--
-- Indexes for dumped tables
--

--
-- Indexes for table `site_api_request`
--
ALTER TABLE `site_api_request`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `site_api_request`
--
ALTER TABLE `site_api_request`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 13, 2025 at 09:08 PM
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
-- Database: `walkintothewild`
--

-- --------------------------------------------------------

--
-- Table structure for table `user_post_like`
--

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
COMMIT;


-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 02, 2025 at 04:16 PM
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
-- Table structure for table `post_report`
--

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
COMMIT;


-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 01, 2025 at 06:57 PM
-- Server version: 8.0.41-0ubuntu0.22.04.1
-- PHP Version: 8.1.2-1ubuntu2.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;


--
-- Table structure for table `sighting`
--

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
COMMIT;


-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 02, 2025 at 02:17 PM
-- Server version: 8.0.41-0ubuntu0.22.04.1
-- PHP Version: 8.1.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `walkintothewild`
--

-- --------------------------------------------------------

--
-- Table structure for table `sighting_report`
--

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
COMMIT;


-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 17, 2025 at 04:04 PM
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
-- Database: `witw_prod`
--

-- --------------------------------------------------------

--
-- Table structure for table `user_posts`
--

CREATE TABLE `user_posts` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `file` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `filepath` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `etag` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `size` int DEFAULT NULL,
  `caption` text,
  `height` int DEFAULT NULL,
  `width` int DEFAULT NULL,
  `status` int NOT NULL DEFAULT '1',
  `total_view` int DEFAULT '0',
  `created_at` int DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL,
  `updated_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user_posts`
--
ALTER TABLE `user_posts`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user_posts`
--
ALTER TABLE `user_posts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


ALTER TABLE `user_post_comment` CHANGE `message` `comment` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL;
ALTER TABLE `user_post_comment` CHANGE `comment_datetime` `dateTime` DATETIME NOT NULL;
ALTER TABLE `sighting_comment` CHANGE `comment_datetime` `dateTime` DATETIME NOT NULL;
ALTER TABLE `sighting_comment` CHANGE `message` `comment` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL;
ALTER TABLE site_api_request MODIFY COLUMN response LONGTEXT;

ALTER TABLE `share_safari` ADD `is_published_on_api` BOOLEAN NOT NULL DEFAULT TRUE AFTER `status`, ADD `is_published_on_web` BOOLEAN NOT NULL DEFAULT TRUE AFTER `is_published_on_api`;
ALTER TABLE `safari_park` ADD `is_published_on_web` BOOLEAN NOT NULL DEFAULT TRUE AFTER `google_review_count`, ADD `is_published_on_api` BOOLEAN NOT NULL DEFAULT TRUE AFTER `is_published_on_web`;
ALTER TABLE `package` ADD `is_published_on_web` BOOLEAN NOT NULL DEFAULT TRUE AFTER `updated_by`, ADD `is_published_on_api` BOOLEAN NOT NULL DEFAULT TRUE AFTER `is_published_on_web`;


-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 03, 2025 at 12:45 PM
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
-- Database: walkintothewild
--

-- --------------------------------------------------------

--
-- Table structure for table url_shortner
--

DROP TABLE IF EXISTS url_shortner;
CREATE TABLE url_shortner (
  id int NOT NULL,
  shortner_url text NOT NULL,
  short_id varchar(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  code int NOT NULL DEFAULT '302',
  alias varchar(10) DEFAULT NULL,
  one_time_valid int DEFAULT '0',
  click_count int NOT NULL DEFAULT '0',
  status int NOT NULL DEFAULT '1',
  created_at int DEFAULT NULL,
  updated_at int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table url_shortner_log
--

DROP TABLE IF EXISTS url_shortner_log;
CREATE TABLE url_shortner_log (
  id int NOT NULL,
  url_shortner_id int NOT NULL,
  user_device varchar(255) DEFAULT NULL,
  user_agent varchar(255) DEFAULT NULL,
  user_platform varchar(255) DEFAULT NULL,
  user_platform_version varchar(255) DEFAULT NULL,
  user_browser varchar(255) DEFAULT NULL,
  user_browser_version varchar(255) DEFAULT NULL,
  user_ip_address varchar(255) DEFAULT NULL,
  created_at int DEFAULT NULL,
  updated_at int DEFAULT NULL,
  status int DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table url_shortner
--
ALTER TABLE url_shortner
  ADD PRIMARY KEY (id),
  ADD UNIQUE KEY short_id (short_id);

--
-- Indexes for table url_shortner_log
--
ALTER TABLE url_shortner_log
  ADD PRIMARY KEY (id);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table url_shortner
--
ALTER TABLE url_shortner
  MODIFY id int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table url_shortner_log
--
ALTER TABLE url_shortner_log
  MODIFY id int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 21, 2025 at 11:05 AM
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
-- Table structure for table `image_brightness`
--

DROP TABLE IF EXISTS `image_brightness`;
CREATE TABLE `image_brightness` (
  `id` int NOT NULL,
  `moderation_id` int NOT NULL,
  `media_id` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `brightness` float DEFAULT NULL
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
-- Table structure for table `image_contrast`
--

DROP TABLE IF EXISTS `image_contrast`;
CREATE TABLE `image_contrast` (
  `id` int NOT NULL,
  `moderation_id` int NOT NULL,
  `media_id` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `contrast` float DEFAULT NULL
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
-- Table structure for table `image_face`
--

DROP TABLE IF EXISTS `image_face`;
CREATE TABLE `image_face` (
  `id` int NOT NULL,
  `moderation_id` int NOT NULL,
  `media_id` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
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
-- Table structure for table `image_face_info`
--

DROP TABLE IF EXISTS `image_face_info`;
CREATE TABLE `image_face_info` (
  `id` int NOT NULL,
  `video_face_id` int NOT NULL,
  `moderation_id` int DEFAULT NULL,
  `x1` float DEFAULT NULL,
  `y1` float DEFAULT NULL,
  `x2` float DEFAULT NULL,
  `y2` float DEFAULT NULL,
  `left_eye_x` float DEFAULT NULL,
  `left_eye_y` float DEFAULT NULL,
  `right_eye_x` float DEFAULT NULL,
  `right_eye_y` float DEFAULT NULL,
  `nose_tip_x` float DEFAULT NULL,
  `nose_tip_y` float DEFAULT NULL,
  `left_mouth_corner_x` float DEFAULT NULL,
  `left_mouth_corner_y` float DEFAULT NULL,
  `right_mouth_corner_x` float DEFAULT NULL,
  `right_mouth_corner_y` float DEFAULT NULL,
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
-- Table structure for table `image_metadata`
--

DROP TABLE IF EXISTS `image_metadata`;
CREATE TABLE `image_metadata` (
  `id` int NOT NULL,
  `moderation_id` int DEFAULT NULL,
  `size` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'in kb',
  `height` varchar(255) DEFAULT NULL,
  `width` varchar(255) DEFAULT NULL,
  `extension` varchar(255) DEFAULT NULL,
  `resolution` varchar(255) DEFAULT NULL,
  `orientation` varchar(255) DEFAULT NULL,
  `uploaded_at` varchar(255) DEFAULT NULL
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
-- Table structure for table `image_sharpness`
--

DROP TABLE IF EXISTS `image_sharpness`;
CREATE TABLE `image_sharpness` (
  `id` int NOT NULL,
  `moderation_id` int NOT NULL,
  `media_id` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `sharpness` float DEFAULT NULL
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

-- --------------------------------------------------------

--
-- Table structure for table `moderation`
--

DROP TABLE IF EXISTS `moderation`;
CREATE TABLE `moderation` (
  `id` int NOT NULL,
  `type` int NOT NULL,
  `video_url` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `video` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `etag` varchar(512) DEFAULT NULL,
  `image_url` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `created_at` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `updated_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `moderation_text`
--

DROP TABLE IF EXISTS `moderation_text`;
CREATE TABLE `moderation_text` (
  `id` int NOT NULL,
  `moderation_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `request_id` varchar(255) DEFAULT NULL,
  `request_timestamp` varchar(255) DEFAULT NULL,
  `moderation_type` varchar(255) DEFAULT NULL,
  `sexual` decimal(3,3) NOT NULL DEFAULT '0.000',
  `discriminatory` decimal(3,3) NOT NULL DEFAULT '0.000',
  `insulting` decimal(3,3) NOT NULL DEFAULT '0.000',
  `violent` decimal(3,3) NOT NULL DEFAULT '0.000',
  `toxic` decimal(3,3) NOT NULL DEFAULT '0.000',
  `self_harm` decimal(3,3) NOT NULL DEFAULT '0.000',
  `personal` tinyint(1) NOT NULL DEFAULT '0',
  `link` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `video_alcohol`
--

DROP TABLE IF EXISTS `video_alcohol`;
CREATE TABLE `video_alcohol` (
  `id` int NOT NULL,
  `moderation_id` int NOT NULL,
  `info_id` varchar(512) DEFAULT NULL,
  `info_position` int DEFAULT NULL,
  `prob` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `video_audio`
--

DROP TABLE IF EXISTS `video_audio`;
CREATE TABLE `video_audio` (
  `id` int NOT NULL,
  `moderation_id` int NOT NULL,
  `info_id` varchar(512) DEFAULT NULL,
  `info_position` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `video_audio_meta_data`
--

DROP TABLE IF EXISTS `video_audio_meta_data`;
CREATE TABLE `video_audio_meta_data` (
  `id` int NOT NULL,
  `moderation_id` int NOT NULL,
  `codec_name` varchar(255) DEFAULT NULL,
  `codec_long_name` varchar(255) DEFAULT NULL,
  `profile` varchar(255) DEFAULT NULL,
  `codec_type` varchar(255) DEFAULT NULL,
  `codec_tag_string` varchar(255) DEFAULT NULL,
  `codec_tag` varchar(255) DEFAULT NULL,
  `sample_fmt` varchar(255) DEFAULT NULL,
  `sample_rate` bigint DEFAULT NULL,
  `channels` int DEFAULT NULL,
  `channel_layout` float DEFAULT NULL,
  `bits_per_sample` varchar(255) DEFAULT NULL,
  `r_frame_rate` varchar(255) DEFAULT NULL,
  `avg_frame_rate` varchar(255) DEFAULT NULL,
  `time_base` varchar(255) DEFAULT NULL,
  `start_pts` bigint DEFAULT NULL,
  `start_time` float DEFAULT NULL,
  `duration_ts` bigint DEFAULT NULL,
  `duration` float DEFAULT NULL,
  `bit_rate` bigint DEFAULT NULL,
  `nb_frames` bigint DEFAULT NULL,
  `disposition` json DEFAULT NULL,
  `tags` json DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `video_audio_profanity`
--

DROP TABLE IF EXISTS `video_audio_profanity`;
CREATE TABLE `video_audio_profanity` (
  `id` int NOT NULL,
  `moderation_id` int NOT NULL,
  `video_audio_id` int NOT NULL,
  `type` varchar(512) DEFAULT NULL,
  `profanity_match` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `start_ms` float DEFAULT NULL,
  `end_ms` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `video_colors`
--

DROP TABLE IF EXISTS `video_colors`;
CREATE TABLE `video_colors` (
  `id` int NOT NULL,
  `moderation_id` int NOT NULL,
  `info_id` varchar(512) DEFAULT NULL,
  `info_position` int DEFAULT NULL,
  `dominant_r` float DEFAULT NULL,
  `dominant_g` float DEFAULT NULL,
  `dominant_b` float DEFAULT NULL,
  `dominant_hex` varchar(7) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `video_colors_accent`
--

DROP TABLE IF EXISTS `video_colors_accent`;
CREATE TABLE `video_colors_accent` (
  `id` int NOT NULL,
  `color_id` int NOT NULL,
  `moderation_id` int NOT NULL,
  `info_id` varchar(512) DEFAULT NULL,
  `info_position` int DEFAULT NULL,
  `r` float DEFAULT NULL,
  `g` float DEFAULT NULL,
  `b` float DEFAULT NULL,
  `hex` varchar(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `video_colors_other`
--

DROP TABLE IF EXISTS `video_colors_other`;
CREATE TABLE `video_colors_other` (
  `id` int NOT NULL,
  `color_id` int NOT NULL,
  `moderation_id` int NOT NULL,
  `info_id` varchar(512) DEFAULT NULL,
  `info_position` int DEFAULT NULL,
  `r` float DEFAULT NULL,
  `g` float DEFAULT NULL,
  `b` float DEFAULT NULL,
  `hex` varchar(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `video_destruction`
--

DROP TABLE IF EXISTS `video_destruction`;
CREATE TABLE `video_destruction` (
  `id` int NOT NULL,
  `moderation_id` int NOT NULL,
  `info_id` varchar(512) DEFAULT NULL,
  `info_position` int DEFAULT NULL,
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
-- Table structure for table `video_face`
--

DROP TABLE IF EXISTS `video_face`;
CREATE TABLE `video_face` (
  `id` int NOT NULL,
  `moderation_id` int NOT NULL,
  `info_id` varchar(512) DEFAULT NULL,
  `info_position` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `video_face_info`
--

DROP TABLE IF EXISTS `video_face_info`;
CREATE TABLE `video_face_info` (
  `id` int NOT NULL,
  `moderation_id` int NOT NULL,
  `video_face_id` int NOT NULL,
  `x1` float DEFAULT NULL,
  `y1` float DEFAULT NULL,
  `x2` float DEFAULT NULL,
  `y2` float DEFAULT NULL,
  `left_eye_x` float DEFAULT NULL,
  `left_eye_y` float DEFAULT NULL,
  `right_eye_x` float DEFAULT NULL,
  `right_eye_y` float DEFAULT NULL,
  `nose_tip_x` float DEFAULT NULL,
  `nose_tip_y` float DEFAULT NULL,
  `left_mouth_corner_x` float DEFAULT NULL,
  `left_mouth_corner_y` float DEFAULT NULL,
  `right_mouth_corner_x` float DEFAULT NULL,
  `right_mouth_corner_y` float DEFAULT NULL,
  `sunglasses` float DEFAULT NULL,
  `no_sunglasses` float DEFAULT NULL,
  `angle_back_side` float DEFAULT NULL,
  `angle_back_straight` float DEFAULT NULL,
  `filter_false` float DEFAULT NULL,
  `filter_true` float DEFAULT NULL,
  `obstruction_complete` float DEFAULT NULL,
  `obstruction_extreme` float DEFAULT NULL,
  `obstruction_heavy` float DEFAULT NULL,
  `obstruction_light` float DEFAULT NULL,
  `obstruction_medium` float DEFAULT NULL,
  `obstruction_none` float DEFAULT NULL,
  `quality_high` float DEFAULT NULL,
  `quality_low` float DEFAULT NULL,
  `quality_medium` float DEFAULT NULL,
  `quality_perfect` float DEFAULT NULL,
  `attributes_minor` float DEFAULT NULL,
  `attributes_sunglasses` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `video_format`
--

DROP TABLE IF EXISTS `video_format`;
CREATE TABLE `video_format` (
  `id` int NOT NULL,
  `moderation_id` int NOT NULL,
  `nb_streams` int DEFAULT NULL,
  `nb_programs` int DEFAULT NULL,
  `format_name` varchar(255) DEFAULT NULL,
  `format_long_name` varchar(255) DEFAULT NULL,
  `start_time` float DEFAULT NULL,
  `duration` float DEFAULT NULL,
  `size` bigint DEFAULT NULL,
  `bit_rate` bigint DEFAULT NULL,
  `probe_score` int DEFAULT NULL,
  `tags` json DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `video_gambling`
--

DROP TABLE IF EXISTS `video_gambling`;
CREATE TABLE `video_gambling` (
  `id` int NOT NULL,
  `moderation_id` int NOT NULL,
  `info_id` varchar(512) DEFAULT NULL,
  `info_position` int DEFAULT NULL,
  `prob` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `video_gore`
--

DROP TABLE IF EXISTS `video_gore`;
CREATE TABLE `video_gore` (
  `id` int NOT NULL,
  `moderation_id` int NOT NULL,
  `info_id` varchar(512) DEFAULT NULL,
  `info_position` int DEFAULT NULL,
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
  `gore_real` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `video_image_quality_detection`
--

DROP TABLE IF EXISTS `video_image_quality_detection`;
CREATE TABLE `video_image_quality_detection` (
  `id` int NOT NULL,
  `moderation_id` int NOT NULL,
  `info_id` varchar(512) DEFAULT NULL,
  `info_position` int DEFAULT NULL,
  `score` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `video_medical`
--

DROP TABLE IF EXISTS `video_medical`;
CREATE TABLE `video_medical` (
  `id` int NOT NULL,
  `moderation_id` int NOT NULL,
  `info_id` varchar(512) DEFAULT NULL,
  `info_position` int DEFAULT NULL,
  `prob` float DEFAULT NULL,
  `pills` float DEFAULT NULL,
  `paraphernalia` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `video_metadata`
--

DROP TABLE IF EXISTS `video_metadata`;
CREATE TABLE `video_metadata` (
  `id` int NOT NULL,
  `moderation_id` int NOT NULL,
  `duration` float DEFAULT NULL,
  `r_frame_rate` int DEFAULT NULL,
  `average_frame_rate` int DEFAULT NULL,
  `codec_name` varchar(512) DEFAULT NULL,
  `codec_long_name` text,
  `profile` varchar(512) DEFAULT NULL,
  `codec_type` varchar(512) DEFAULT NULL,
  `codec_tag_string` varchar(512) DEFAULT NULL,
  `codec_tag` varchar(512) DEFAULT NULL,
  `width` int DEFAULT NULL,
  `height` int DEFAULT NULL,
  `coded_width` int DEFAULT NULL,
  `coded_height` int DEFAULT NULL,
  `closed_captions` int DEFAULT NULL,
  `has_b_frames` int DEFAULT NULL,
  `pix_fmt` varchar(512) DEFAULT NULL,
  `level` int DEFAULT NULL,
  `chroma_location` varchar(512) DEFAULT NULL,
  `refs` int DEFAULT NULL,
  `is_avc` int DEFAULT NULL,
  `nal_length_size` int DEFAULT NULL,
  `time_base` varchar(512) DEFAULT NULL,
  `start_pts` float DEFAULT NULL,
  `start_time` float DEFAULT NULL,
  `duration_ts` float DEFAULT NULL,
  `bit_rate` bigint DEFAULT NULL,
  `bits_per_raw_sample` int DEFAULT NULL,
  `nb_frames` int DEFAULT NULL,
  `disposition` json NOT NULL,
  `tags` json NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `video_military`
--

DROP TABLE IF EXISTS `video_military`;
CREATE TABLE `video_military` (
  `id` int NOT NULL,
  `moderation_id` int NOT NULL,
  `info_id` varchar(512) DEFAULT NULL,
  `info_position` int DEFAULT NULL,
  `prob` float DEFAULT NULL,
  `military_equipment` float DEFAULT NULL,
  `military_personnel` float DEFAULT NULL,
  `military_profile_photo` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `video_money`
--

DROP TABLE IF EXISTS `video_money`;
CREATE TABLE `video_money` (
  `id` int NOT NULL,
  `moderation_id` int NOT NULL,
  `info_id` varchar(512) DEFAULT NULL,
  `info_position` int DEFAULT NULL,
  `prob` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `video_nudity`
--

DROP TABLE IF EXISTS `video_nudity`;
CREATE TABLE `video_nudity` (
  `id` int NOT NULL,
  `moderation_id` int NOT NULL,
  `info_id` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `info_position` int DEFAULT NULL,
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
  `male_chest_` float DEFAULT NULL,
  `male_chest_very_revealing` float DEFAULT NULL,
  `male_chest_revealing` float DEFAULT NULL,
  `male_chest_slightly_revealing` float DEFAULT NULL,
  `male_chest_none` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `video_offensive`
--

DROP TABLE IF EXISTS `video_offensive`;
CREATE TABLE `video_offensive` (
  `id` int NOT NULL,
  `moderation_id` int NOT NULL,
  `info_id` varchar(512) DEFAULT NULL,
  `info_position` int DEFAULT NULL,
  `nazi` float DEFAULT NULL,
  `asian_swastika` float DEFAULT NULL,
  `confederate` float DEFAULT NULL,
  `supremacist` float DEFAULT NULL,
  `terrorist` float DEFAULT NULL,
  `middle_finger` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `video_recreational_drug`
--

DROP TABLE IF EXISTS `video_recreational_drug`;
CREATE TABLE `video_recreational_drug` (
  `id` int NOT NULL,
  `moderation_id` int NOT NULL,
  `info_id` varchar(512) DEFAULT NULL,
  `info_position` int DEFAULT NULL,
  `prob` float DEFAULT NULL,
  `cannabis` float DEFAULT NULL,
  `cannabis_logo_only` float DEFAULT NULL,
  `cannabis_plant` float DEFAULT NULL,
  `cannabis_drug` float DEFAULT NULL,
  `recreational_drugs_not_cannabis` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `video_scam`
--

DROP TABLE IF EXISTS `video_scam`;
CREATE TABLE `video_scam` (
  `id` int NOT NULL,
  `moderation_id` int NOT NULL,
  `info_id` varchar(512) DEFAULT NULL,
  `info_position` int DEFAULT NULL,
  `prob` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `video_selfharm`
--

DROP TABLE IF EXISTS `video_selfharm`;
CREATE TABLE `video_selfharm` (
  `id` int NOT NULL,
  `moderation_id` int NOT NULL,
  `info_id` varchar(512) DEFAULT NULL,
  `info_position` int DEFAULT NULL,
  `prob` float DEFAULT NULL,
  `self_harm_real` float DEFAULT NULL,
  `fake` float DEFAULT NULL,
  `animated` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `video_smoking`
--

DROP TABLE IF EXISTS `video_smoking`;
CREATE TABLE `video_smoking` (
  `id` int NOT NULL,
  `moderation_id` int NOT NULL,
  `info_id` varchar(512) DEFAULT NULL,
  `info_position` int DEFAULT NULL,
  `prob` float DEFAULT NULL,
  `regular_tobacco` float DEFAULT NULL,
  `ambiguous_tobacco` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `video_text`
--

DROP TABLE IF EXISTS `video_text`;
CREATE TABLE `video_text` (
  `id` int NOT NULL,
  `moderation_id` int NOT NULL,
  `info_id` varchar(512) DEFAULT NULL,
  `info_position` int DEFAULT NULL,
  `has_artificial` float DEFAULT NULL,
  `has_natural` float DEFAULT NULL,
  `ignored_text` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `video_type`
--

DROP TABLE IF EXISTS `video_type`;
CREATE TABLE `video_type` (
  `id` int NOT NULL,
  `moderation_id` int NOT NULL,
  `info_id` varchar(512) DEFAULT NULL,
  `info_position` int DEFAULT NULL,
  `illustration` float DEFAULT NULL,
  `photo` float DEFAULT NULL,
  `ai_generated` float DEFAULT NULL,
  `deepfake` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `video_violence`
--

DROP TABLE IF EXISTS `video_violence`;
CREATE TABLE `video_violence` (
  `id` int NOT NULL,
  `moderation_id` int NOT NULL,
  `info_id` varchar(512) DEFAULT NULL,
  `info_position` int DEFAULT NULL,
  `prob` float DEFAULT NULL,
  `physical_violence` float DEFAULT NULL,
  `firearm_threat` float DEFAULT NULL,
  `combat_sport` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `video_weapon`
--

DROP TABLE IF EXISTS `video_weapon`;
CREATE TABLE `video_weapon` (
  `id` int NOT NULL,
  `moderation_id` int NOT NULL,
  `info_id` varchar(512) DEFAULT NULL,
  `info_position` int DEFAULT NULL,
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
-- Indexes for table `image_brightness`
--
ALTER TABLE `image_brightness`
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
-- Indexes for table `image_contrast`
--
ALTER TABLE `image_contrast`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `image_destruction`
--
ALTER TABLE `image_destruction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `image_face`
--
ALTER TABLE `image_face`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `image_faces`
--
ALTER TABLE `image_faces`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `image_face_info`
--
ALTER TABLE `image_face_info`
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
-- Indexes for table `image_metadata`
--
ALTER TABLE `image_metadata`
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
-- Indexes for table `image_sharpness`
--
ALTER TABLE `image_sharpness`
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
-- Indexes for table `moderation`
--
ALTER TABLE `moderation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `moderation_text`
--
ALTER TABLE `moderation_text`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `video_alcohol`
--
ALTER TABLE `video_alcohol`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `video_audio`
--
ALTER TABLE `video_audio`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `video_audio_meta_data`
--
ALTER TABLE `video_audio_meta_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `video_audio_profanity`
--
ALTER TABLE `video_audio_profanity`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `video_colors`
--
ALTER TABLE `video_colors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `video_colors_accent`
--
ALTER TABLE `video_colors_accent`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `video_colors_other`
--
ALTER TABLE `video_colors_other`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `video_destruction`
--
ALTER TABLE `video_destruction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `video_face`
--
ALTER TABLE `video_face`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `video_face_info`
--
ALTER TABLE `video_face_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `video_format`
--
ALTER TABLE `video_format`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `video_gambling`
--
ALTER TABLE `video_gambling`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `video_gore`
--
ALTER TABLE `video_gore`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `video_image_quality_detection`
--
ALTER TABLE `video_image_quality_detection`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `video_medical`
--
ALTER TABLE `video_medical`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `video_metadata`
--
ALTER TABLE `video_metadata`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `video_military`
--
ALTER TABLE `video_military`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `video_money`
--
ALTER TABLE `video_money`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `video_nudity`
--
ALTER TABLE `video_nudity`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `video_offensive`
--
ALTER TABLE `video_offensive`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `video_recreational_drug`
--
ALTER TABLE `video_recreational_drug`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `video_scam`
--
ALTER TABLE `video_scam`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `video_selfharm`
--
ALTER TABLE `video_selfharm`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `video_smoking`
--
ALTER TABLE `video_smoking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `video_text`
--
ALTER TABLE `video_text`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `video_type`
--
ALTER TABLE `video_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `video_violence`
--
ALTER TABLE `video_violence`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `video_weapon`
--
ALTER TABLE `video_weapon`
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
-- AUTO_INCREMENT for table `image_brightness`
--
ALTER TABLE `image_brightness`
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
-- AUTO_INCREMENT for table `image_contrast`
--
ALTER TABLE `image_contrast`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `image_destruction`
--
ALTER TABLE `image_destruction`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `image_face`
--
ALTER TABLE `image_face`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `image_faces`
--
ALTER TABLE `image_faces`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `image_face_info`
--
ALTER TABLE `image_face_info`
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
-- AUTO_INCREMENT for table `image_metadata`
--
ALTER TABLE `image_metadata`
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
-- AUTO_INCREMENT for table `image_sharpness`
--
ALTER TABLE `image_sharpness`
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

--
-- AUTO_INCREMENT for table `moderation`
--
ALTER TABLE `moderation`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `moderation_text`
--
ALTER TABLE `moderation_text`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `video_alcohol`
--
ALTER TABLE `video_alcohol`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `video_audio`
--
ALTER TABLE `video_audio`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `video_audio_meta_data`
--
ALTER TABLE `video_audio_meta_data`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `video_audio_profanity`
--
ALTER TABLE `video_audio_profanity`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `video_colors`
--
ALTER TABLE `video_colors`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `video_colors_accent`
--
ALTER TABLE `video_colors_accent`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `video_colors_other`
--
ALTER TABLE `video_colors_other`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `video_destruction`
--
ALTER TABLE `video_destruction`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `video_face`
--
ALTER TABLE `video_face`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `video_face_info`
--
ALTER TABLE `video_face_info`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `video_format`
--
ALTER TABLE `video_format`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `video_gambling`
--
ALTER TABLE `video_gambling`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `video_gore`
--
ALTER TABLE `video_gore`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `video_image_quality_detection`
--
ALTER TABLE `video_image_quality_detection`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `video_medical`
--
ALTER TABLE `video_medical`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `video_metadata`
--
ALTER TABLE `video_metadata`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `video_military`
--
ALTER TABLE `video_military`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `video_money`
--
ALTER TABLE `video_money`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `video_nudity`
--
ALTER TABLE `video_nudity`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `video_offensive`
--
ALTER TABLE `video_offensive`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `video_recreational_drug`
--
ALTER TABLE `video_recreational_drug`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `video_scam`
--
ALTER TABLE `video_scam`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `video_selfharm`
--
ALTER TABLE `video_selfharm`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `video_smoking`
--
ALTER TABLE `video_smoking`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `video_text`
--
ALTER TABLE `video_text`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `video_type`
--
ALTER TABLE `video_type`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `video_violence`
--
ALTER TABLE `video_violence`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `video_weapon`
--
ALTER TABLE `video_weapon`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 02, 2025 at 04:16 PM
-- Server version: 8.0.41-0ubuntu0.22.04.1
-- PHP Version: 8.1.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
