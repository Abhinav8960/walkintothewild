-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 25, 2025 at 08:39 PM
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
-- Database: `witw_production`
--

-- --------------------------------------------------------

--
-- Table structure for table `compliance_documents`
--

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;