-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 28, 2026 at 04:35 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `asrago_db1`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `dorm_no` varchar(20) NOT NULL,
  `status` enum('Sedang Diproses','Dalam Penghantaran','Selesai Dihantar') DEFAULT 'Sedang Diproses',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_price`, `dorm_no`, `status`, `created_at`) VALUES
(1, 4, 6.50, 'A5-2-13', 'Sedang Diproses', '2026-08-23 06:11:38'),
(2, 5, 2.50, 'A3-1-12', 'Dalam Penghantaran', '2026-08-23 06:15:04'),
(3, 5, 6.50, 'A3-1-12', 'Sedang Diproses', '2026-08-23 06:18:39'),
(4, 5, 6.50, 'A3-1-12', 'Sedang Diproses', '2026-08-23 06:19:37'),
(5, 5, 3.80, 'A3-1-12', 'Sedang Diproses', '2026-08-23 06:19:53'),
(6, 3, 2.50, 'A3-1-12', 'Sedang Diproses', '2026-08-27 11:42:53'),
(7, 3, 7.50, 'A3-1-12', 'Selesai Dihantar', '2026-08-27 11:43:27'),
(8, 3, 6.50, 'A3-1-12', 'Dalam Penghantaran', '2026-08-27 12:19:02'),
(9, 3, 6.50, 'A3-1-12', 'Dalam Penghantaran', '2026-08-27 12:33:24'),
(10, 3, 6.50, 'A3-1-12', 'Selesai Dihantar', '2026-08-27 12:39:15'),
(11, 3, 6.50, 'A3-1-12', 'Dalam Penghantaran', '2026-08-27 12:46:54'),
(12, 3, 6.50, 'A3-1-12', 'Sedang Diproses', '2026-08-28 02:24:02');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `category` varchar(50) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category`, `price`, `stock`, `image`) VALUES
(1, 'Maggi Goreng 5-Pack', 'Makanan', 6.50, 15, 'maggie.jpg'),
(2, 'Air Kotak Milo 250ml', 'Minuman', 2.50, 24, 'milo.jpg'),
(3, 'Sabun Mandi Lifebuoy', 'Penjagaan Diri', 3.80, 8, 'sabun.jpg'),
(4, 'Biskut Munchys Cream Crackers', 'Makanan', 4.20, 0, 'biskut.jpg'),
(5, 'Roti Gardenia Coklat', 'Makanan', 1.60, 10, 'roti.jpg'),
(6, 'Nescafe 3 in 1 (15-Pack)', 'Minuman', 12.00, 5, 'nescafe.jpg'),
(7, 'Ubat Gigi Colgate 150g', 'Penjagaan Diri', 7.50, 12, 'ubat_gigi.jpg'),
(8, 'Syampu Rejoice 320ml', 'Penjagaan Diri', 11.90, 0, 'syampu.jpg'),
(9, 'Tisu Muka Kleenex 3-Pack', 'Keperluan', 8.90, 20, 'tisu.jpg'),
(10, 'Minyak Angin Cap Kapak', 'Keperluan', 5.50, 7, 'minyak_angin.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('student','admin','courier') DEFAULT 'student',
  `dorm_no` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `password`, `role`, `dorm_no`) VALUES
(1, 'Pengurus Asrama', 'admin@gmail.com', 'admin123', 'admin', NULL),
(2, 'Runner Dorm A', 'courier@gmail.com', 'courier123', 'courier', NULL),
(3, 'Ammar Farhat', 'ammar031@gmail.com', '123456', 'student', 'A3-1-12'),
(4, 'Azim zulrih bin senafi', 'azim@gmail.com', '1234567', 'student', 'A5-2-13'),
(5, 'Ammar Farhat', 'ammar@gmail.com', '$2y$10$e0MYzXyjpJS7Pd0RVvHwHe10I2p81N5G92kI669A7UaJ26L3kE1p2', 'student', 'A3-1-12'),
(6, 'Nama Pengguna', 'email@contoh.com', '$2y$10$e0MYzXyjpJS7Pd0RVvHwHe10I2p81N5G92kI669A7UaJ26L3kE1p2', 'student', 'no dorm');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
