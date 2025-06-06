-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 16, 2024 at 09:54 AM
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
-- Database: `shoe_shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `name`, `email`, `address`, `product_name`, `total_price`, `payment_method`, `status`, `user_id`, `created_at`) VALUES
(1, 'Fern', 'f@gmail.com', 'Highway', NULL, 6195.00, 'GCash', 'received', 6, '2024-10-12 04:03:45'),
(2, 'Fern', 'f@gmail.com', 'Tisa', NULL, 4795.00, 'GCash', 'not_received', 6, '2024-10-12 04:44:28'),
(3, 'Allen', 'a@gmail.com', 'Napo', NULL, 7395.00, 'GCash', 'not_received', 6, '2024-10-12 07:44:17'),
(6, 'Oscar', 'oscar@gmail.com', 'Bonbon', NULL, 6195.00, 'Cash on Delivery', 'not_received', 7, '2024-10-12 08:30:31');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `category` enum('women','men') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `price`, `image_url`, `category`, `created_at`) VALUES
(1, 'Giannis Freak 6', 7895.00, '/Shoe Shop/images/men/m.png', 'men', '2024-10-10 09:21:43'),
(2, 'Nike P-6000', 6195.00, '/Shoe Shop/images/men/m2.png', 'men', '2024-10-10 09:21:43'),
(3, 'Nike Impact 4', 4795.00, '/Shoe Shop/images/men/m3.png', 'men', '2024-10-10 09:21:43'),
(4, 'Nike Air Max Dn', 9395.00, '/Shoe Shop/images/women/w.png', 'women', '2024-10-10 09:22:09'),
(5, 'Nike Air Max Plus', 9895.00, '/Shoe Shop/images/women/w2.png', 'women', '2024-10-10 09:22:09'),
(6, 'Nike Air Force 1', 6895.00, '/Shoe Shop/images/women/w3.png', 'women', '2024-10-10 09:22:09'),
(9, 'Nike V2K Run', 6895.00, '/Shoe Shop/images/women/w4.png', 'women', '2024-10-11 08:58:47'),
(10, 'Nike Cortez Textile', 3884.00, '/Shoe Shop/images/women/w5.png', 'women', '2024-10-11 09:04:23'),
(11, 'Sabrina 2 EP', 7395.00, '/Shoe Shop/images/men/m7.png', 'men', '2024-10-11 09:14:54');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`) VALUES
(1, 'admin'),
(2, 'user');

-- --------------------------------------------------------

--
-- Table structure for table `shopping_bag`
--

CREATE TABLE `shopping_bag` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `item_price` decimal(10,2) NOT NULL,
  `item_image` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shopping_bag`
--

INSERT INTO `shopping_bag` (`id`, `item_id`, `item_name`, `item_price`, `item_image`, `category`, `added_at`, `user_id`) VALUES
(20, 2, 'Nike P-6000', 6195.00, '/Shoe Shop/images/men/m2.png', 'men', '2024-10-12 02:03:37', 6),
(22, 2, 'Nike P-6000', 6195.00, '/Shoe Shop/images/men/m2.png', 'men', '2024-10-12 02:38:40', 7);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `email`, `role_id`, `created_at`) VALUES
(1, 'admin', 'admin123', 'admin@gmail.com', 1, '2024-10-11 05:55:59'),
(6, 'Allen', 'allen123', 'allen@gmail.com', 2, '2024-10-11 07:16:25'),
(7, 'oscar', 'bongbong123', 'oscar@gmail.com', NULL, '2024-10-12 08:26:38');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `or_user_id` (`user_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`),
  ADD UNIQUE KEY `role_name` (`role_name`);

--
-- Indexes for table `shopping_bag`
--
ALTER TABLE `shopping_bag`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `shopping_bag`
--
ALTER TABLE `shopping_bag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `or_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `shopping_bag`
--
ALTER TABLE `shopping_bag`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
