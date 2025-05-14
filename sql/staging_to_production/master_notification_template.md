-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 14, 2025 at 01:27 PM
-- Server version: 8.0.42-0ubuntu0.22.04.1
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
-- Table structure for table `master_notification_template`
--

DROP TABLE IF EXISTS `master_notification_template`;
CREATE TABLE `master_notification_template` (
  `id` int NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `title` varchar(512) NOT NULL,
  `message` text NOT NULL,
  `status` int DEFAULT '1',
  `created_at` int DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL,
  `updated_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `master_notification_template`
--

INSERT INTO `master_notification_template` (`id`, `type`, `title`, `message`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'Joined Safari', 'Joined Safari', 'New member alert : {{var1}} has joined your {{var2}} Visit the interested member section to review and connect for your trip planning.', 1, 1735733224, 30, 1735733224, 30),
(2, 'New Comment', 'New Comment', 'A new comment has been posted in the {{var1}} Join the conversation to discuss and finalize the shared safari plans.', 1, 1735794886, 30, 1735794886, 30),
(3, 'New Comment', 'New Comment', '{{var1}} new comment {{var2}}', 1, 1735796316, 30, 1735796316, 30),
(4, 'New Follower', 'New Follower', '{{var1}} is now following you!', 1, 1735796519, 30, 1735796519, 30),
(5, 'Package Intrest', 'Package Intrest', '{{var1}} has shown interest in your package.', 1, 1735806508, 30, 1735806508, 30),
(6, 'Quote Request', 'Quote Request', 'You have a new quote request!', 1, 1735806532, 30, 1735806532, 30),
(7, 'New Review', 'New Review', 'You\'ve received a new review!', 1, 1735806556, 30, 1735806556, 30),
(8, 'chat message received', '{{sender}}', '{{message}}', 1, 1735806556, 30, 1735806556, 30),
(9, 'Unjoined Safari', 'Unjoined Safari', '{{var1}} has Unjoined your {{var2}} Visit the interested member section to review.', 1, 1746790635, 30, 1746790635, 30),
(10, 'Unfollow Operator', 'Unfollow Operator', '{{var1}} unfollowed you!', 1, 1746790635, 30, 1746790635, 30),
(11, 'Package Quotation Received', 'Quotation Received', 'Quotation Received on package: {{package_name}} by {{user_name}}!', 1, 1746790635, 30, 1746790635, 30),
(12, 'Partner Quotation Received', 'Quotation Received', 'Quotation Received on park: {{park_name}} by {{user_name}}!', 1, 1746790635, 30, 1746790635, 30);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `master_notification_template`
--
ALTER TABLE `master_notification_template`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `master_notification_template`
--
ALTER TABLE `master_notification_template`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
