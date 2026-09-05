-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 05, 2026 at 07:47 AM
-- Server version: 8.4.7
-- PHP Version: 8.4.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jivhala_healthcare`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
CREATE TABLE IF NOT EXISTS `customers` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_number` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_customer_number` (`customer_number`),
  UNIQUE KEY `unique_customer_mobile` (`mobile`),
  KEY `idx_customer_name` (`name`),
  KEY `idx_customer_city` (`city`),
  KEY `idx_customer_status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `customer_number`, `name`, `mobile`, `email`, `city`, `status`, `created_at`, `updated_at`) VALUES
(1, 'JIV-CUST-00001', 'Test Booking', '1111111111', NULL, 'Chandrapur', 'active', '2026-09-04 09:06:50', '2026-09-04 09:06:50'),
(2, 'JIV-CUST-00002', 'Test Booking 2', '7412555555', NULL, 'Pune', 'active', '2026-09-04 09:09:24', '2026-09-04 09:09:24'),
(3, 'JIV-CUST-00003', 'Gateway testing 1', '9885465132', NULL, 'Chandrapur', 'active', '2026-09-04 10:30:38', '2026-09-04 10:30:38'),
(4, 'JIV-CUST-00004', 'Gateway testing 2', '6546546546', NULL, 'Pune', 'active', '2026-09-04 10:35:04', '2026-09-04 10:35:04'),
(5, 'JIV-CUST-00005', 'Gateway testing 3', '9874563210', NULL, 'Pune', 'active', '2026-09-04 10:44:43', '2026-09-04 10:44:43'),
(6, 'JIV-CUST-00006', 'Gateway testing 4', '9874563244', NULL, 'Pune', 'active', '2026-09-04 10:57:17', '2026-09-04 10:57:17'),
(7, 'JIV-CUST-00007', 'Gateway testing duplicate', '7859854120', NULL, 'Pune', 'active', '2026-09-04 11:07:20', '2026-09-04 11:07:20');

-- --------------------------------------------------------

--
-- Table structure for table `equipment`
--

DROP TABLE IF EXISTS `equipment`;
CREATE TABLE IF NOT EXISTS `equipment` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_id` int UNSIGNED DEFAULT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `short_description` text COLLATE utf8mb4_unicode_ci,
  `description` text COLLATE utf8mb4_unicode_ci,
  `technical_specifications` text COLLATE utf8mb4_unicode_ci,
  `brands` text COLLATE utf8mb4_unicode_ci,
  `purchase_price` decimal(10,2) DEFAULT NULL,
  `rental_price` decimal(10,2) DEFAULT NULL,
  `rental_period` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  UNIQUE KEY `unique_equipment_name` (`name`),
  KEY `fk_equipment_category` (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `equipment`
--

INSERT INTO `equipment` (`id`, `category_id`, `name`, `slug`, `image`, `short_description`, `description`, `technical_specifications`, `brands`, `purchase_price`, `rental_price`, `rental_period`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Motorized Wheelchair Without Battery', 'motorized-wheelchair-without-battery', 'assets/images/equipment/motorized-wheelchair-without-battery-1788428808-6a994208b6b8d.jpg', 'Motorized wheelchair without battery for purchase, providing support to patients in need. We assist in selecting the right product and method of administration. We also offer a range of superior healthcare services, including doctor consultations, physiotherapy, nursing home care, diagnostics and vaccination services.', 'A motorized wheelchair is an electrically powered mobility chair aid designed to assist individuals with limited mobility. These wheelchairs offer increased independence and convenience for users who may have difficulty propelling a manual wheelchair. With ergonomic designs and various customizable features, motorized wheelchairs provide a comfortable and efficient means of transportation for individuals with mobility challenges.', 'Frame: Breaks down into 4 component\r\nFootrest: Removable, height adjustable\r\nArmrest: Swing away, height adjustable with ergonomic pad\r\nController: Right or left-hand side mount Brands & Models Available: Karma KP 10.3S', 'Prajwal,Arrex Novamed, Med-E-Move, Karma Eflexx', 1.00, 1.00, '15', 1, '2026-09-03 09:46:48', '2026-09-04 10:56:39'),
(2, 2, 'Oxygen Concentrator 9/10 LPM', 'oxygen-concentrator-9-10-lpm', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-09-03 10:17:35', '2026-09-03 10:17:35');

-- --------------------------------------------------------

--
-- Table structure for table `equipment_bookings`
--

DROP TABLE IF EXISTS `equipment_bookings`;
CREATE TABLE IF NOT EXISTS `equipment_bookings` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_id` int UNSIGNED DEFAULT NULL,
  `booking_number` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `equipment_id` int UNSIGNED NOT NULL,
  `customer_name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `booking_type` enum('rental','purchase') COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `booking_status` enum('pending','confirmed','cancelled','completed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `payment_status` enum('pending','paid','failed','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `razorpay_order_id` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `razorpay_payment_id` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paid_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_booking_number` (`booking_number`),
  KEY `idx_equipment_id` (`equipment_id`),
  KEY `idx_mobile` (`mobile`),
  KEY `idx_payment_status` (`payment_status`),
  KEY `idx_booking_status` (`booking_status`),
  KEY `idx_customer_id` (`customer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `equipment_bookings`
--

INSERT INTO `equipment_bookings` (`id`, `customer_id`, `booking_number`, `equipment_id`, `customer_name`, `mobile`, `email`, `city`, `booking_type`, `amount`, `booking_status`, `payment_status`, `razorpay_order_id`, `razorpay_payment_id`, `paid_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'JIV-20260904-00001', 1, 'Test Booking', '1111111111', NULL, 'Chandrapur', 'rental', 25000.00, 'pending', 'pending', NULL, NULL, NULL, '2026-09-04 07:51:59', '2026-09-04 09:07:04'),
(2, 2, 'JIV-20260904-00002', 1, 'Test Booking 2', '7412555555', NULL, 'Pune', 'rental', 25000.00, 'pending', 'pending', NULL, NULL, NULL, '2026-09-04 09:09:24', '2026-09-04 09:09:24'),
(3, 3, 'JIV-20260904-00003', 1, 'Gateway testing 1', '9885465132', NULL, 'Chandrapur', 'rental', 25000.00, 'pending', 'pending', 'order_TXvYkKyHNGq1rV', NULL, NULL, '2026-09-04 10:30:38', '2026-09-04 10:30:38'),
(4, 4, 'JIV-20260904-00004', 1, 'Gateway testing 2', '6546546546', NULL, 'Pune', 'rental', 25000.00, 'pending', 'pending', 'order_TXvdQrIcMGoU7y', NULL, NULL, '2026-09-04 10:35:04', '2026-09-04 10:35:05'),
(5, 5, 'JIV-20260904-00005', 1, 'Gateway testing 3', '9874563210', NULL, 'Pune', 'rental', 25000.00, 'pending', 'pending', 'order_TXvnd3MX3AsJiO', NULL, NULL, '2026-09-04 10:44:43', '2026-09-04 10:44:44'),
(6, 6, 'JIV-20260904-00006', 1, 'Gateway testing 4', '9874563244', NULL, 'Pune', 'rental', 1.00, 'confirmed', 'paid', 'order_TXw0tZXduW6N8n', 'pay_TXw1YRP4IQtoTK', '2026-09-04 16:28:13', '2026-09-04 10:57:17', '2026-09-04 10:58:13'),
(7, 7, 'JIV-20260904-00007', 1, 'Gateway testing duplicate', '7859854120', NULL, 'Pune', 'rental', 1.00, 'confirmed', 'paid', 'order_TXwBWEsNPAP0h7', 'pay_TXwC93DxMxuB9c', '2026-09-04 16:38:15', '2026-09-04 11:07:20', '2026-09-04 11:08:15'),
(8, 7, 'JIV-20260904-00008', 1, 'Gateway testing duplicate', '7859854120', NULL, 'Pune', 'rental', 1.00, 'pending', 'pending', 'order_TXwTNssC30OcbU', NULL, NULL, '2026-09-04 11:24:15', '2026-09-04 11:24:15');

-- --------------------------------------------------------

--
-- Table structure for table `equipment_categories`
--

DROP TABLE IF EXISTS `equipment_categories`;
CREATE TABLE IF NOT EXISTS `equipment_categories` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `equipment_categories`
--

INSERT INTO `equipment_categories` (`id`, `name`, `slug`, `description`, `image`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Wheelchair', 'wheelchair', NULL, 'assets/images/equipment/categories/wheelchair-1788428669-6a99417d1d6a4.png', 1, '2026-09-03 09:44:29', '2026-09-03 09:44:29'),
(2, 'Oxygen', 'oxygen', NULL, 'assets/images/equipment/categories/oxygen-1788430623-6a99491f9b8ec.jpg', 1, '2026-09-03 10:17:03', '2026-09-03 10:17:03');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'admin',
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'admin@jivhalahealthcare.com', '$2y$12$oaZ/OOerBSSj0s5oQnkDY.ENlG0gSwzoXU5paeTkbrTB2mTflalrq', 'admin', 'active', '2026-09-02 10:37:48', '2026-09-02 10:37:48');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
