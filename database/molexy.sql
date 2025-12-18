-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 15, 2025 at 08:38 PM
-- Server version: 8.0.43-0ubuntu0.22.04.1
-- PHP Version: 8.1.2-1ubuntu2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `molexy`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mobile` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `timing` datetime DEFAULT CURRENT_TIMESTAMP,
  `admin` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int NOT NULL,
  `admin` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `stars` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `thoughts` text COLLATE utf8mb4_general_ci,
  `timing` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `customer_name` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `customer_mobile` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `customer_address` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mobile_model` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `problems` text COLLATE utf8mb4_general_ci,
  `amount` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `paid` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `text_password` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pattern_password` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `image` text COLLATE utf8mb4_general_ci,
  `addition_details` text COLLATE utf8mb4_general_ci,
  `timing` datetime DEFAULT CURRENT_TIMESTAMP,
  `admin` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` varchar(100) COLLATE utf8mb4_general_ci DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `userdata`
--

CREATE TABLE `userdata` (
  `id` int NOT NULL,
  `shop_name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `owner_name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mobile_number` varchar(15) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `shop_address` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `gstin` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `shop_logo` text COLLATE utf8mb4_general_ci,
  `email` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_general_ci DEFAULT 'pending',
  `otp` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `premium` varchar(20) COLLATE utf8mb4_general_ci DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `userdata`
--
ALTER TABLE `userdata`
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `userdata`
--
ALTER TABLE `userdata`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
