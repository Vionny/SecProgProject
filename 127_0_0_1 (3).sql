-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 13, 2023 at 10:41 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `secprogdb`
--
DROP DATABASE IF EXISTS `secprogdb`;
CREATE DATABASE IF NOT EXISTS `secprogdb` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `secprogdb`;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `user_id` int(11) NOT NULL,
  `customer_first_name` varchar(50) NOT NULL,
  `customer_last_name` varchar(50) NOT NULL,
  `customer_dob` date DEFAULT NULL,
  `customer_money` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`user_id`, `customer_first_name`, `customer_last_name`, `customer_dob`, `customer_money`) VALUES
(1, 'customer', 'number 1', '2013-02-02', 0),
(3, 'customer', 'customer', '1999-03-22', 0),
(6, 'customer', 'number 2', '1999-02-21', 0);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `item_id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `item_name` varchar(100) DEFAULT NULL,
  `item_description` varchar(255) DEFAULT NULL,
  `item_price` int(11) DEFAULT NULL,
  `item_stock` int(11) DEFAULT NULL,
  `item_photo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_id`, `seller_id`, `item_name`, `item_description`, `item_price`, `item_stock`, `item_photo`) VALUES
(11, 2, 'Item 1', 'Hello hello item description 1 here', 222, 12, ''),
(12, 7, 'Item 2', 'Hello hello item description 2 here', 123123, 23, ''),
(13, 7, 'Item 3', 'Hello hello item description 3 here', 234123, 12, ''),
(14, 2, 'Item 4', 'Hello hello item description 4 here', 2342454, 4, ''),
(15, 7, 'Item 5', 'Hello hello item description 5 here', 324353, 3, ''),
(16, 7, 'Item 6', 'Hello hello item description 6 here', 435123, 5, ''),
(18, 2, 'Item 8', 'Hello hello item description 8 here', 4244332, 21, ''),
(19, 2, 'Item 9', 'Hello hello item description 9 here', 15234, 34, ''),
(20, 2, 'Item 10', 'Hello hello item description 10 here', 2434325, 54, ''),
(21, 7, 'itemname', 'itemdesc', 222222, 222, ''),
(22, 7, 'item', 'item', 20000, 20, '../assets/itemImage/ITEM_IMAGE_ERD_VA_JZ.jpg'),
(23, 7, 'asdasd', 'asdasdas', 23232, 2222, '../assets/itemImage/ITEM_IMAGE_1300540.jpg'),
(24, 7, 'test inserting', 'asdasd', 2222, 2222, '../assets/itemImage/ITEM_IMAGE_icon.png'),
(25, 7, 'here testing', 'sadasdasd', 2222222, 222, '../assets/itemImage/ITEM_IMAGE_7_here testing'),
(26, 7, 'asdasda', 'asdasdsadsad', 22222, 2222, '../assets/itemImage/ITEM_IMAGE_7_asdasda'),
(27, 7, 'asdasdasd', 'asdasdasd', 22, 2222, '../assets/itemImage/ITEM_IMAGE_7_asdasdasd.png');

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `rating_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `rating` int(11) DEFAULT NULL,
  `comment` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sellers`
--

CREATE TABLE `sellers` (
  `user_id` int(11) NOT NULL,
  `seller_name` varchar(100) NOT NULL,
  `seller_address` varchar(255) NOT NULL,
  `seller_money` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sellers`
--

INSERT INTO `sellers` (`user_id`, `seller_name`, `seller_address`, `seller_money`) VALUES
(2, 'seller', 'seller address temporary :D', 0),
(7, 'seller number 1', 'asdasdasdasdasdasdasdasdasdasd', 0);

-- --------------------------------------------------------

--
-- Table structure for table `transactions_detail`
--

CREATE TABLE `transactions_detail` (
  `transaction_detail_id` int(11) NOT NULL,
  `transaction_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions_header`
--

CREATE TABLE `transactions_header` (
  `transaction_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `transaction_date` date DEFAULT NULL,
  `transaction_status` char(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_email` varchar(100) DEFAULT NULL,
  `user_password` varchar(100) NOT NULL,
  `user_type` char(10) DEFAULT NULL,
  `user_token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_email`, `user_password`, `user_type`, `user_token`) VALUES
(1, 'customer@email.com', '$2y$10$v8ffq5zGk/RbuPaK3XVKEen7tXYbMZIjYIdLyZKzcjnGUOlcsjT4S', 'customer', '60ZnU7++5LUPU+Ll5kCv3CnwTRK8npdFqRzBnOl3PRwFDUzxq9ppgxwVjpLC5zAX3PiYW/PiQdny9Ob+iiWdj7ar/PwA5SAgm1FbVflGJFM='),
(2, 'seller@email.com', '$2y$10$W9fP202CPAS1OqKWrnhiHO.d4SAk1nB/PK1WqOYdB37LxlUtOQX1.', 'seller', '40ydVJnYrEVaFMJ3PbXtav+O5tYtRFVntMRcudCVQvFWX2+iGwfj2yHmLsbZsT+2xOkC9zqOvDNYTJsp3qfz3hV51aIYmeSHbV7EMucGcJc='),
(3, 'customer1@email.com', '$2y$10$O6riqA/SivLo9KZwru8v8e3ESy4e6A8eJr55u5KmTVeENvQDJZNgu', 'customer', ''),
(6, 'customer2@email.com', '$2y$10$UiTtEzVuYb0Zij3SHPpa9u3eyHarF/FyCMv2S4Z4buPpk3gnu9D4G', 'customer', ''),
(7, 'seller1@email.com', '$2y$10$NZX2lUA/llXlamEKclioIO//KhIU.Zd4a2G.LJRRgeGPn4zcqZH0W', 'seller', 'QbWoIEM8cvpdDyJLzocyO8yrhLJWuuZ7waTVVgTIHcYodB//cGqaXnnu35fSYdcqJJpB4wi8KEK1Q0Ra5B1mowqo1gi4IVpf1z6nukB/rN8=');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `seller_id` (`seller_id`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`rating_id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `sellers`
--
ALTER TABLE `sellers`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `transactions_detail`
--
ALTER TABLE `transactions_detail`
  ADD PRIMARY KEY (`transaction_detail_id`),
  ADD KEY `transaction_id` (`transaction_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `transactions_header`
--
ALTER TABLE `transactions_header`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `seller_id` (`seller_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_email` (`user_email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `rating_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions_detail`
--
ALTER TABLE `transactions_detail`
  MODIFY `transaction_detail_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions_header`
--
ALTER TABLE `transactions_header`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_ibfk_1` FOREIGN KEY (`seller_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `ratings_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `items` (`item_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ratings_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sellers`
--
ALTER TABLE `sellers`
  ADD CONSTRAINT `sellers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transactions_detail`
--
ALTER TABLE `transactions_detail`
  ADD CONSTRAINT `transactions_detail_ibfk_1` FOREIGN KEY (`transaction_id`) REFERENCES `transactions_header` (`transaction_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transactions_detail_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `items` (`item_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transactions_header`
--
ALTER TABLE `transactions_header`
  ADD CONSTRAINT `transactions_header_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transactions_header_ibfk_2` FOREIGN KEY (`seller_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
