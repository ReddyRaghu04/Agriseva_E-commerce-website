-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 04, 2026 at 07:22 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `agriseva`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `username`, `product_id`) VALUES
(21, 'reddy', 1),
(23, 'Narendra', 5);

-- --------------------------------------------------------

--
-- Table structure for table `products_details`
--

CREATE TABLE `products_details` (
  `id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `seller_name` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `unit` varchar(50) NOT NULL,
  `quantity` varchar(50) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `previous_price` decimal(10,2) DEFAULT NULL,
  `category` varchar(100) NOT NULL,
  `subcategory` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products_details`
--

INSERT INTO `products_details` (`id`, `seller_id`, `seller_name`, `product_name`, `description`, `image`, `unit`, `quantity`, `price`, `created_at`, `previous_price`, `category`, `subcategory`) VALUES
(1, 2, 'reddy', 'Raja_NPH-369', 'Raja_NPH-369 is a high-yielding paddy seed variety known for its superior grain quality', 'uploads/Raja_NPH-369.png', 'Kgs', '25kg', 350.00, '2025-03-30 05:27:36', 450.00, 'seeds', 'Paddy Seeds'),
(2, 2, 'Reddy Raghu', 'Rasi RCH 773 BG II Hybrid Cotton Seeds ', 'Rasi RCH 773 BG II is a high-performing hybrid cotton seed variety known for its excellent yield potential, early maturity, and strong pest resistance. ', 'uploads/Rasi_cotton_seeds.jpg', 'Kgs', '5 Kg', 300.00, '2025-03-30 05:56:06', 30.00, 'seeds', 'Cotton Seeds'),
(3, 2, 'Raghu', 'PAN 2150', 'PAN 2150 is ideal for commercial rice cultivation.', 'uploads/img_67f4eb855ab615.31671222.png', 'Kgs', '20 Kg', 100.00, '2025-04-08 09:25:25', NULL, 'seeds', 'Paddy Seeds'),
(4, 2, 'Raghu', 'Aadhya NCS 1134 Bt-2 Cotton Hybrid Seeds ', 'Nuziveedu Seeds a corporate giant in the Indian seed industry has the largest germplasm collection of Hybrid and Bt cotton', 'uploads/img_68120b8b5f5b08.83008949.jpeg', 'Kgs', '10 Kg', 200.00, '2025-04-30 11:37:47', NULL, 'seeds', 'Cotton Seeds'),
(5, 1, 'Ram', 'Prograd', 'Prograd Insecticide is a powerful broad-spectrum insect control solution formulated to protect crops from a wide range of pests', 'uploads/img_682c2245ec76a8.53510476.jpg', 'Liters', '10 L', 200.00, '2025-05-20 06:33:41', NULL, 'insecticides', '--Select Type--');

-- --------------------------------------------------------

--
-- Table structure for table `sellers_information`
--

CREATE TABLE `sellers_information` (
  `seller_id` int(6) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `dob` date NOT NULL,
  `state` varchar(100) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `email` varchar(255) NOT NULL,
  `shop_name` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `business_mobile` varchar(15) NOT NULL,
  `business_email` varchar(255) NOT NULL,
  `category` varchar(50) NOT NULL,
  `gst_number` varchar(50) NOT NULL,
  `pan_number` varchar(50) NOT NULL,
  `bank_holder_name` varchar(255) NOT NULL,
  `account_number` varchar(20) NOT NULL,
  `bank_name` varchar(255) NOT NULL,
  `ifsc_code` varchar(20) NOT NULL,
  `gst_certificate` varchar(255) DEFAULT NULL,
  `trade_license` varchar(255) DEFAULT NULL,
  `seed_license` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sellers_information`
--

INSERT INTO `sellers_information` (`seller_id`, `full_name`, `dob`, `state`, `mobile`, `email`, `shop_name`, `address`, `business_mobile`, `business_email`, `category`, `gst_number`, `pan_number`, `bank_holder_name`, `account_number`, `bank_name`, `ifsc_code`, `gst_certificate`, `trade_license`, `seed_license`) VALUES
(1, 'Ram', '2004-04-26', 'telangana', '8522', 'reddy@gmail.com', 'Ram agristore', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(2, 'Raghu', '0000-00-00', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Screenshot 2025-03-21 101347.png', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `seller_auth`
--

CREATE TABLE `seller_auth` (
  `seller_id` int(6) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seller_auth`
--

INSERT INTO `seller_auth` (`seller_id`, `password`) VALUES
(1, '123'),
(2, '123');

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

CREATE TABLE `user_details` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `mobile_no` varchar(15) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_details`
--

INSERT INTO `user_details` (`id`, `full_name`, `mobile_no`, `username`, `email`, `password`, `address`) VALUES
(5, 'Reddy', '8522', 'reddy', 'reddy@gmail.com', '$2y$10$/meiQDjeoAd9h6/guyy7mux327iaAsziEr.DZhBwRqOLqc3j5u9u2', '5-40, Chalmeda, Nizampet, Medak, Telangana, 502102'),
(10, 'Raghu', '8522950545', 'raghu', 'raghu@gmail.com', '$2y$10$dwdMIxq/oFu7k1kmJW2.lu3SjauJprJ/ggs7Cv5lrL4rd0bFolyae', NULL),
(12, 'Narendra Gude', '9177073077', 'Narendra', 'ram1234@gmail.com', '$2y$10$4kmDqkzks.SLyblaacGDd.KPZ4Hu2yvjlkfWFIUAeyhQRt0rXeu8W', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products_details`
--
ALTER TABLE `products_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `seller_id` (`seller_id`);

--
-- Indexes for table `sellers_information`
--
ALTER TABLE `sellers_information`
  ADD PRIMARY KEY (`seller_id`);

--
-- Indexes for table `seller_auth`
--
ALTER TABLE `seller_auth`
  ADD PRIMARY KEY (`seller_id`);

--
-- Indexes for table `user_details`
--
ALTER TABLE `user_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `products_details`
--
ALTER TABLE `products_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_details`
--
ALTER TABLE `user_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products_details` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products_details`
--
ALTER TABLE `products_details`
  ADD CONSTRAINT `products_details_ibfk_1` FOREIGN KEY (`seller_id`) REFERENCES `sellers_information` (`seller_id`) ON DELETE CASCADE;

--
-- Constraints for table `seller_auth`
--
ALTER TABLE `seller_auth`
  ADD CONSTRAINT `seller_auth_ibfk_1` FOREIGN KEY (`seller_id`) REFERENCES `sellers_information` (`seller_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
