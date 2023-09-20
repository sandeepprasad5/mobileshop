-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 20, 2023 at 12:23 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `e-commercestore`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `password`, `status`) VALUES
(1, 'admin', 'admin1', 1),
(2, 'sandy2', 'sandy2', 0),
(3, 'rahul', 'rahul', 0);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category`, `status`) VALUES
(1, 'Smart Phone', 1),
(2, 'Key Pad Phone', 1),
(3, 'Telephone', 0);

-- --------------------------------------------------------

--
-- Table structure for table `discounts`
--

CREATE TABLE `discounts` (
  `id` int(11) NOT NULL,
  `coupon_code` varchar(255) NOT NULL,
  `discount_type` varchar(255) NOT NULL,
  `discount_value` varchar(255) NOT NULL,
  `product_category` varchar(255) NOT NULL,
  `start_date` varchar(255) NOT NULL,
  `end_date` varchar(255) NOT NULL,
  `is_active` tinyint(4) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `discounts`
--

INSERT INTO `discounts` (`id`, `coupon_code`, `discount_type`, `discount_value`, `product_category`, `start_date`, `end_date`, `is_active`, `created_at`) VALUES
(1, '0001', 'fixed_amount', '100', 'all_products', '2023-07-24', '2023-07-31', 1, '2023-09-18 12:31:11'),
(2, '0002', 'percentage', '10', 'all_products', '2023-07-24', '2023-07-28', 1, '2023-09-18 12:31:16'),
(3, '0003', 'percentage', '15', 'all_products', '2023-07-28', '2023-07-31', 1, '2023-09-18 12:31:19'),
(4, '0004', 'fixed_amount', '20', 'all_products', '2023-07-25', '2023-07-31', 0, '2023-09-18 12:32:15'),
(5, '0005', 'percentage', '25', 'all_products', '2023-07-29', '2023-07-31', 0, '2023-09-18 12:31:25'),
(6, '0005', 'percentage', '25', 'all_products', '2023-07-29', '2023-07-31', 1, '2023-09-18 12:31:27'),
(7, '0006', 'fixed_amount', '26', 'all_products', '2023-07-26', '2023-07-19', 0, '2023-09-18 12:32:01'),
(8, '0007', 'percentage', '7', 'all_products', '2023-07-24', '2023-07-07', 1, '2023-09-18 16:47:27'),
(9, '454', 'fixed_amount', '45', 'all_products', '2023-07-28', '2023-07-31', 1, '2023-09-18 12:32:05'),
(10, '898', 'percentage', '64.99', 'all_products', '2023-07-24', '2023-07-04', 1, '2023-09-18 12:31:38'),
(11, 'uu', 'percentage', '484', 'all_products', '2023-07-24', '2023-07-07', 1, '2023-09-18 12:31:41'),
(12, 'global', 'fixed_amount', '200', 'all_products', '2023-07-27', '2023-07-29', 1, '2023-08-19 21:44:53'),
(13, '556456', 'percentage', '1221', 'product_specific', '2023-07-29', '2023-07-29', 1, '2023-07-27 08:38:42'),
(14, '445', 'percentage', '878', 'product_specific', '2023-07-28', '2023-07-28', 1, '2023-07-27 08:40:31'),
(15, '1212', 'percentage', '12', 'product_specific', '2023-07-28', '2023-08-01', 1, '2023-07-27 08:41:28'),
(16, '3', 'percentage', '2.99', 'product_specific', '2023-07-28', '2023-08-01', 1, '2023-07-27 10:10:03'),
(17, '33', 'percentage', '554', 'product_specific', '2023-07-29', '2023-07-29', 1, '2023-07-27 10:12:02'),
(18, '121212', 'fixed_amount', '21', 'all_products', '2023-09-20', '2023-09-28', 0, '2023-09-18 12:30:40');

-- --------------------------------------------------------

--
-- Table structure for table `featured`
--

CREATE TABLE `featured` (
  `id` int(255) NOT NULL,
  `product_id` int(255) NOT NULL,
  `featured_status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `featured`
--

INSERT INTO `featured` (`id`, `product_id`, `featured_status`) VALUES
(2, 2, 1),
(3, 3, 1),
(4, 4, 0),
(5, 5, 0),
(6, 6, 1),
(7, 7, 1),
(8, 8, 1),
(9, 9, 1),
(10, 10, 0),
(11, 11, 1),
(12, 12, 1),
(13, 13, 0),
(14, 14, 0),
(15, 15, 1);

-- --------------------------------------------------------

--
-- Table structure for table `logo`
--

CREATE TABLE `logo` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` text NOT NULL,
  `set_status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `logo`
--

INSERT INTO `logo` (`id`, `name`, `image`, `set_status`) VALUES
(1, 'logo', 'logo.png', 1),
(2, 'logo4', 'logo2.png', 0),
(3, 'belt', 'belt-buckle-knife-img.jpg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `product_ids` varchar(255) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `total_amount` varchar(255) NOT NULL,
  `shipping_address` text NOT NULL,
  `city` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `reason_for_cancellation` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `product_ids`, `order_date`, `total_amount`, `shipping_address`, `city`, `country`, `status`, `reason_for_cancellation`, `created_at`, `updated_at`) VALUES
(1, '1', '3', '2023-09-18 17:35:58', '20000', '4440 North Cherry Street', 'Winston-Salem', 'India', 'Cancel', 'unknown', '2023-09-18 21:05:58', '2023-09-18 21:05:58'),
(2, '1', '10,8', '2023-09-18 17:38:06', '13680', '4440 North Cherry Street', 'Winston-Salem', 'India', 'Paid', '', '2023-09-18 21:08:06', '2023-09-18 21:08:06'),
(3, '1', '11', '2023-09-19 07:21:31', '9500', '4440 North Cherry Street', 'Winston-Salem', 'India', 'Paid', '', '2023-09-19 10:51:31', '2023-09-19 10:51:31'),
(4, '1', '9', '2023-09-19 10:14:07', '39000', '4440 North Cherry Street', 'Winston-Salem', 'India', 'Paid', '', '2023-09-19 13:44:07', '2023-09-19 13:44:07'),
(5, '1', '3,2', '2023-09-20 05:43:10', '75000', '4440 North Cherry Street', 'Winston-Salem', 'India', 'Paid', '', '2023-09-20 09:13:10', '2023-09-20 09:13:10');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_items_id` int(11) NOT NULL,
  `order_id` varchar(255) NOT NULL,
  `product_id` varchar(255) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `subtotal` varchar(255) NOT NULL,
  `sale_date` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_items_id`, `order_id`, `product_id`, `quantity`, `subtotal`, `sale_date`, `updated_at`) VALUES
(1, '1', '3', '1', '20000', '2023-09-18 17:35:58', NULL),
(2, '2', '10', '2', '9000', '2023-09-18 17:38:06', NULL),
(3, '2', '8', '1', '6200', '2023-09-18 17:38:06', NULL),
(4, '3', '11', '1', '9500', '2023-09-19 07:21:31', NULL),
(5, '4', '9', '1', '39000', '2023-09-19 10:14:07', NULL),
(6, '5', '3', '3', '60000', '2023-09-20 05:43:10', NULL),
(7, '5', '2', '1', '15000', '2023-09-20 05:43:10', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `categories_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `sku` varchar(255) NOT NULL,
  `mrp` float NOT NULL,
  `selling_price` float NOT NULL,
  `with_discounted_price` varchar(255) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `short_desc` varchar(2000) NOT NULL,
  `description` varchar(2000) NOT NULL,
  `image` varchar(255) NOT NULL,
  `meta_title` text NOT NULL,
  `meta_desc` varchar(2000) NOT NULL,
  `meta_keyword` varchar(2000) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `featured_status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `categories_id`, `name`, `sku`, `mrp`, `selling_price`, `with_discounted_price`, `quantity`, `short_desc`, `description`, `image`, `meta_title`, `meta_desc`, `meta_keyword`, `status`, `featured_status`) VALUES
(2, 1, 'One Plus', 'OP0001', 15000, 15000, '', '4', 'Richard McClintock, a Latin professor.', 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form.', '0244he8B2BeMYIAYRB8LNH5-15.webp', 'One Plus', 'One Plus Phone', 'One Plus', 1, 1),
(3, 1, 'Galaxy M12', 'SGM0001', 20000, 20000, '', '3', 'Richard McClintock, a Latin professor.', 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form.', 'best-camera-phone.webp', 'Galaxy M12', 'Galaxy M12 Phone', 'Galaxy M12', 1, 1),
(4, 2, 'LG 512', 'LG5120001', 5000, 5000, '', '0', 'Richard McClintock, a Latin professor.', 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form.', '81xrnlT6sxL.jpg', 'LG 512', 'LG 512 Phone', 'LG 512', 1, 0),
(5, 2, 'Sony Yellow 65', 'SonyY650001', 3000, 3000, '', '5', 'Richard McClintock, a Latin professor.', 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form.', 'Best-basic-phones-summary_trans_NvBQzQNjv4Bq5TYBpLgmrbnwEHtt5Xn-LbBvtnfnIFoQId2o5lve8eo.jpg', 'Sony Yellow 65', 'Sony Yellow 65 Phone', 'Sony Yellow 65', 0, 0),
(6, 2, 'Samsung Guru 6', 'SAMGU0006', 2500, 2500, '', '5', 'Richard McClintock, a Lat', 'There are many variations of passages of Lorem Ips', 'H714a645e12ad4a5da75575d27b7a8425p.jpg', 'Samsung Gu', 'Samsung Guru 6 Phone', 'Samsung Gu', 1, 1),
(7, 1, 'Red Plus 78', 'REDP78001', 15500, 15500, '', '5', 'Richard McClintock, a Lat', 'There are many variations of passages of Lorem Ips', 'Best-mid-range-phone.webp', 'Red Plus 7', 'Red Plus 78 Phone', 'Red Plus 7', 1, 1),
(8, 2, 'Sony Black Mamba', 'SBLAKM001', 6200, 6200, '', '4', 'Richard McClintock, a Lat', 'There are many variations of passages of Lorem Ips', 'H486122fa81a642a2a4896a7ad71416e4M.jpg', 'Sony Black', 'Sony Black Mamba Phone', 'Sony Black', 1, 1),
(9, 1, 'IPhone 12 Max', 'IPHONE012 ', 39000, 39000, '', '7', 'Richard McClintock, a Lat', 'There are many variations of passages of Lorem Ips', 'best-phone-2022.webp', 'IPhone 12 ', 'IPhone 12 Max Phone', 'IPhone 12 ', 1, 1),
(10, 2, 'Samsung Guru 7', 'SAMGU0007', 4500, 4500, '', '5', 'Richard McClintock, a Lat', 'There are many variations of passages of Lorem Ips', 'image.webp', 'Samsung Gu', 'Samsung Guru 7 Phone', 'Samsung Gu', 1, 0),
(11, 1, 'Narzo A+', 'NARZO001', 9500, 9500, '', '8', 'Richard McClintock, a Lat', 'There are many variations of passages of Lorem Ips', 'download.jpg', 'Narzo A+', 'Narzo A+ Phone', 'Narzo A+', 1, 1),
(12, 1, 'Google Pixel 4', 'GOOGPIX01', 45000, 45000, '', '8', 'Richard McClintock, a Lat', 'There are many variations of passages of Lorem Ips', 'google-pixel-6a-review-16.webp', 'Google Pix', 'Google Pixel 4 Phone', 'Google Pix', 1, 1),
(13, 2, 'Moto S31', 'MOTOS0031', 5000, 5000, '', '5', 'Richard McClintock, a Lat', 'There are many variations of passages of Lorem Ips', 'hHp0F0htIv.jpg', 'Moto S31', 'Moto S31 Phone', 'Moto S31', 1, 0),
(14, 1, 'Google Pixel 5', 'GOOGPIX05', 51000, 51000, '', '5', 'Richard McClintock, a Lat', 'There are many variations of passages of Lorem Ips', 'images (2).jpg', 'Google Pix', 'Google Pixel 5 Phone', 'Google Pix', 1, 0),
(15, 2, 'Nokia 150', 'NOK00150', 3500, 3500, '', '8', 'Richard McClintock, a Lat', 'There are many variations of passages of Lorem Ips', 'looking-to-buy-a-new-phone-here-are-the-top-10-affordable-feature-devices-to-considerorfrom-samsung-guru-to-nokia-105-here-are-the-top-10-feature-phones-to-pick-from (1).jpg', 'Nokia 150', 'Nokia 150 Phone', 'Nokia 150', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` text NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `is_active` tinyint(4) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password`, `address`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Sandeep Prasad', 'sandy@gmail.com', '123456', 'kolkata,wb', 1, '2023-09-18 20:42:08', '2023-09-18 20:42:08');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `discounts`
--
ALTER TABLE `discounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `featured`
--
ALTER TABLE `featured`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logo`
--
ALTER TABLE `logo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_items_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `discounts`
--
ALTER TABLE `discounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `featured`
--
ALTER TABLE `featured`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `logo`
--
ALTER TABLE `logo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_items_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
