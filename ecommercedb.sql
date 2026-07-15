-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jul 15, 2026 at 10:51 AM
-- Server version: 5.7.39
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecommercedb`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `address_line_1` varchar(255) NOT NULL,
  `address_line_2` varchar(255) DEFAULT NULL,
  `city` varchar(100) NOT NULL,
  `province` varchar(100) NOT NULL,
  `postal_code` varchar(20) NOT NULL,
  `country` varchar(100) NOT NULL DEFAULT 'Canada',
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`id`, `user_id`, `full_name`, `phone`, `address_line_1`, `address_line_2`, `city`, `province`, `postal_code`, `country`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 7, 'Robert Thompson', '555-8443', '6198 Trade St', NULL, 'Atlanta', 'XX', '45242', 'US', 1, '2026-05-28 18:23:44', '2026-05-28 18:23:44'),
(2, 21, 'Tyler Harris', '555-6768', '4990 Main St', NULL, 'Boston', 'XX', '64373', 'US', 1, '2026-05-28 18:23:44', '2026-05-28 18:23:44'),
(3, 2, 'Customer', '555-9124', '8471 Manufacturing Pkwy', '', 'Seattle', 'Zambales', '25439', 'US', 1, '2026-05-28 18:23:44', '2026-07-15 02:38:39'),
(4, 18, 'Nicole Miller', '555-4875', '1071 Industrial Blvd', NULL, 'Dallas', 'XX', '31571', 'US', 1, '2026-05-28 18:23:44', '2026-05-28 18:23:44'),
(5, 12, 'Michelle Patel', '555-9156', '7487 Tool Ct', NULL, 'Denver', 'XX', '35499', 'US', 1, '2026-05-28 18:23:44', '2026-05-28 18:23:44'),
(6, 3, 'James Wilson', '555-3372', '3297 Manufacturing Pkwy', NULL, 'Denver', 'XX', '63029', 'US', 1, '2026-05-28 18:23:44', '2026-05-28 18:23:44'),
(7, 8, 'Jessica Martinez', '555-3795', '6435 Manufacturing Pkwy', NULL, 'Seattle', 'XX', '60521', 'US', 1, '2026-05-28 18:23:44', '2026-05-28 18:23:44'),
(8, 17, 'Andrew Davis', '555-5287', '1213 Manufacturing Pkwy', NULL, 'Portland', 'XX', '77468', 'US', 1, '2026-05-28 18:23:44', '2026-05-28 18:23:44'),
(9, 11, 'Kevin O\'Brien', '555-1973', '1825 Main St', NULL, 'Phoenix', 'XX', '17210', 'US', 1, '2026-05-28 18:23:44', '2026-05-28 18:23:44'),
(10, 9, 'David Anderson', '555-7349', '9420 Commerce Dr', NULL, 'Phoenix', 'XX', '67320', 'US', 1, '2026-05-28 18:23:44', '2026-05-28 18:23:44'),
(11, 10, 'Amanda Taylor', '555-8419', '4145 Trade St', NULL, 'Phoenix', 'XX', '30455', 'US', 1, '2026-05-28 18:23:44', '2026-05-28 18:23:44'),
(12, 13, 'Christopher Lee', '555-2176', '9073 Workshop Rd', NULL, 'Seattle', 'XX', '43813', 'US', 1, '2026-05-28 18:23:44', '2026-05-28 18:23:44'),
(13, 19, 'Brandon Moore', '555-8450', '4982 Main St', NULL, 'Atlanta', 'XX', '49976', 'US', 1, '2026-05-28 18:23:44', '2026-05-28 18:23:44'),
(14, 4, 'Sarah Johnson', '555-3090', '3701 Workshop Rd', NULL, 'Dallas', 'XX', '36768', 'US', 1, '2026-05-28 18:23:44', '2026-05-28 18:23:44'),
(15, 20, 'Rachel Jackson', '555-8927', '6984 Factory Ave', NULL, 'Cleveland', 'XX', '82004', 'US', 1, '2026-05-28 18:23:44', '2026-05-28 18:23:44'),
(16, 6, 'Emily Rodriguez', '555-9190', '6902 Trade St', NULL, 'Boston', 'XX', '23370', 'US', 1, '2026-05-28 18:23:44', '2026-05-28 18:23:44'),
(17, 22, 'Megan Clark', '555-2976', '7335 Trade St', NULL, 'Cleveland', 'XX', '20070', 'US', 1, '2026-05-28 18:23:45', '2026-05-28 18:23:45'),
(18, 23, 'Clydey Ednalan', '45345345', 'Cabalan', NULL, 'Olongapo City', 'Zambales', '2200', 'US', 1, '2026-05-31 20:20:07', '2026-05-31 20:20:07'),
(19, 2, 'Clydey Ednalan', '4234234234999', '8471 Manufacturing Pkwy', '', 'Seattle', 'Zambales', '25439', 'US', 0, '2026-07-15 02:39:50', '2026-07-15 02:39:50'),
(20, 27, 'Raizen Ednalan', '45345345', 'New Cabalan', '', 'Olongapo City', 'Zambales', '22000', 'PH', 1, '2026-07-15 09:57:41', '2026-07-15 09:57:41');

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `description` text,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`, `slug`, `logo`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'DeWalt', 'dewalt', 'brands/1783936381_6a54b57d79870.jpg', 'Professional-grade power tools and accessories', 1, '2026-05-28 18:23:44', '2026-07-13 09:53:01'),
(2, 'Milwaukee', 'milwaukee', 'brands/1783936528_6a54b6107ea45.png', 'Heavy-duty power tools and hand tools', 1, '2026-05-28 18:23:44', '2026-07-13 09:55:28'),
(3, 'Makita', 'makita', 'brands/1783936478_6a54b5debff4c.jpeg', 'Industrial power tools and outdoor equipment', 1, '2026-05-28 18:23:44', '2026-07-13 09:54:38'),
(4, 'Bosch', 'bosch', 'brands/1783936340_6a54b55453bca.png', 'Precision engineering tools and accessories', 1, '2026-05-28 18:23:44', '2026-07-13 09:52:20'),
(5, 'Snap-On', 'snap-on', 'brands/1783936559_6a54b62f90526.png', 'Premium hand tools and diagnostic equipment', 1, '2026-05-28 18:23:44', '2026-07-13 09:55:59'),
(7, '3M', '3m', 'brands/1783936132_6a54b48494a49.png', 'Safety equipment and industrial supplies', 1, '2026-05-28 18:23:44', '2026-07-13 09:48:52'),
(8, 'Lincoln Electric', 'lincoln-electric', 'brands/1783936427_6a54b5ab534ba.png', 'Welding equipment and consumables', 1, '2026-05-28 18:23:44', '2026-07-13 09:53:47'),
(10, 'Stanley', 'stanley', 'brands/1783936640_6a54b6800147b.jpg', 'Stanley updated', 1, '2026-07-13 09:57:20', '2026-07-13 09:57:34');

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 2, '2026-07-14 09:48:36', '2026-07-14 09:48:36'),
(2, 27, '2026-07-15 09:58:48', '2026-07-15 09:58:48');

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT '1',
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `parent_id`, `name`, `slug`, `image`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Power Tools', 'power-tools', 'categories/1783937368_6a54b95804805.webp', 'Electric and battery-powered tools for professional use', 1, '2026-05-28 18:23:44', '2026-07-13 10:09:28'),
(2, NULL, 'Hand Tools', 'hand-tools', 'categories/1783937291_6a54b90bbd49b.webp', 'Manual tools for precision work', 1, '2026-05-28 18:23:44', '2026-07-13 10:08:11'),
(3, NULL, 'Measuring &amp; Layout', 'measuring-layout', 'categories/1783937329_6a54b9318fa14.jpg', 'Precision measuring and layout instruments', 1, '2026-05-28 18:23:44', '2026-07-13 10:08:49'),
(4, NULL, 'Safety Equipment', 'safety-equipment', 'categories/1783937399_6a54b977a8f60.webp', 'Personal protective equipment and safety gear', 1, '2026-05-28 18:23:44', '2026-07-13 10:09:59'),
(5, NULL, 'Cutting Tools', 'cutting-tools', 'categories/1783937161_6a54b88948dc5.jpeg', 'Saws, blades, and cutting accessories', 1, '2026-05-28 18:23:44', '2026-07-13 10:06:01'),
(6, NULL, 'Fasteners &amp; Hardware', 'fasteners-hardware', 'categories/1783937238_6a54b8d6a80bb.jpeg', 'Bolts, nuts, screws, and industrial hardware', 1, '2026-05-28 18:23:44', '2026-07-13 10:07:18'),
(7, NULL, 'Welding &amp; Soldering', 'welding-soldering', 'categories/1783937457_6a54b9b1636c3.jpeg', 'Welding equipment, soldering irons, and supplies', 1, '2026-05-28 18:23:44', '2026-07-13 10:10:57'),
(8, NULL, 'Tool Storage', 'tool-storage', 'categories/1783937428_6a54b9945ae3d.jpg', 'Tool boxes, chests, and storage solutions', 1, '2026-05-28 18:23:44', '2026-07-13 10:10:28');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `subject`, `message`, `is_read`, `created_at`, `updated_at`) VALUES
(1, 'Clydey Ednalan', 'Clydey@gmail.com', 'test subject', 'test messge', 0, '2026-07-15 09:30:21', '2026-07-15 09:30:21');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `type` enum('percentage','fixed') NOT NULL DEFAULT 'percentage',
  `value` decimal(10,2) NOT NULL,
  `minimum_order` decimal(10,2) DEFAULT '0.00',
  `maximum_discount` decimal(10,2) DEFAULT NULL,
  `usage_limit` int(11) DEFAULT NULL,
  `used_count` int(11) NOT NULL DEFAULT '0',
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `code`, `type`, `value`, `minimum_order`, `maximum_discount`, `usage_limit`, `used_count`, `start_date`, `end_date`, `status`, `created_at`, `updated_at`) VALUES
(1, 'WELCOME10', 'percentage', '10.00', '50.00', '50.00', 100, 1, '2026-05-29', '2026-08-29', 0, '2026-05-28 18:23:44', '2026-07-14 02:24:06'),
(2, 'SAVE50', 'fixed', '50.00', '200.00', NULL, 50, 0, '2026-05-29', '2026-07-29', 1, '2026-05-28 18:23:44', '2026-05-28 18:23:44'),
(3, 'TOOL20', 'percentage', '20.00', '100.00', '100.00', 25, 1, '2026-05-29', '2026-06-29', 1, '2026-05-28 18:23:44', '2026-06-01 10:21:39'),
(4, 'FREESHIP', 'fixed', '15.00', '75.00', NULL, 200, 0, '2026-05-29', '2026-11-29', 1, '2026-05-28 18:23:44', '2026-05-28 18:23:44');

-- --------------------------------------------------------

--
-- Table structure for table `coupon_usages`
--

CREATE TABLE `coupon_usages` (
  `id` int(11) NOT NULL,
  `coupon_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `discount_amount` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `inventory_logs`
--

CREATE TABLE `inventory_logs` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `type` enum('stock_in','stock_out','adjustment','return') NOT NULL DEFAULT 'adjustment',
  `quantity` int(11) NOT NULL,
  `reference` varchar(255) DEFAULT NULL,
  `remarks` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL DEFAULT 'order',
  `title` varchar(255) NOT NULL,
  `message` text,
  `order_id` int(11) DEFAULT NULL,
  `order_number` varchar(50) DEFAULT NULL,
  `order_status` varchar(50) DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `type`, `title`, `message`, `order_id`, `order_number`, `order_status`, `is_read`, `created_at`) VALUES
(1, 2, 'order', 'Order #ORD-6A56F79E6A134 - Processing', 'Your order is being processed.', 65, 'ORD-6A56F79E6A134', 'Processing', 1, '2026-07-15 03:24:37'),
(2, 2, 'order', 'Order #ORD-6A56F79E6A134 - Shipped', 'Your order has been shipped!', 65, 'ORD-6A56F79E6A134', 'Shipped', 1, '2026-07-15 03:26:11'),
(3, 2, 'order', 'Order #ORD-6A56F79E6A134 - Delivered', 'Your order has been delivered.', 65, 'ORD-6A56F79E6A134', 'Delivered', 1, '2026-07-15 03:27:05'),
(4, 2, 'order', 'Order #ORD-6A5703CA9C32D - Processing', 'Your order is being processed.', 66, 'ORD-6A5703CA9C32D', 'Processing', 1, '2026-07-15 03:53:50'),
(5, 2, 'order', 'Order #ORD-6A5703CA9C32D - Delivered', 'Your order has been delivered.', 66, 'ORD-6A5703CA9C32D', 'Delivered', 1, '2026-07-15 03:54:53'),
(6, 2, 'order', 'Order #ORD-6A573C3BA3057 - Processing', 'Your order is being processed.', 67, 'ORD-6A573C3BA3057', 'Processing', 1, '2026-07-15 08:02:03'),
(7, 2, 'order', 'Order #ORD-6A573C3BA3057 - Delivered', 'Your order has been delivered.', 67, 'ORD-6A573C3BA3057', 'Delivered', 1, '2026-07-15 08:02:11'),
(8, 27, 'order', 'Order #ORD-6A575A341A89A - Processing', 'Your order is being processed.', 68, 'ORD-6A575A341A89A', 'Processing', 1, '2026-07-15 10:29:05'),
(9, 27, 'order', 'Order #ORD-6A575A341A89A - Shipped', 'Your order has been shipped!', 68, 'ORD-6A575A341A89A', 'Shipped', 1, '2026-07-15 10:29:50'),
(10, 27, 'order', 'Order #ORD-6A575A341A89A - Delivered', 'Your order has been delivered.', 68, 'ORD-6A575A341A89A', 'Delivered', 1, '2026-07-15 10:30:24'),
(11, 27, 'order', 'Order #ORD-6A57628A7F903 - Delivered', 'Your order has been delivered.', 69, 'ORD-6A57628A7F903', 'Delivered', 0, '2026-07-15 10:39:31');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_number` varchar(50) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL DEFAULT '0.00',
  `discount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `shipping_fee` decimal(10,2) NOT NULL DEFAULT '0.00',
  `tax` decimal(10,2) NOT NULL DEFAULT '0.00',
  `grand_total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `payment_method` varchar(50) DEFAULT NULL,
  `payment_status` enum('Pending','Paid','Failed','Refunded') NOT NULL DEFAULT 'Pending',
  `order_status` enum('Pending','Processing','Shipped','Delivered','Cancelled','Returned') NOT NULL DEFAULT 'Pending',
  `shipping_address_id` int(11) DEFAULT NULL,
  `notes` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `order_number`, `subtotal`, `discount`, `shipping_fee`, `tax`, `grand_total`, `payment_method`, `payment_status`, `order_status`, `shipping_address_id`, `notes`, `created_at`, `updated_at`) VALUES
(1, 7, 'ORD-6F3D4E2F', '563.88', '0.00', '15.00', '46.52', '625.40', 'paypal', 'Paid', 'Delivered', 1, NULL, '2026-05-04 11:45:44', '2026-05-04 11:45:44'),
(2, 21, 'ORD-C4D87436', '1439.96', '0.00', '15.00', '118.80', '1573.76', 'credit_card', 'Failed', 'Cancelled', 2, NULL, '2026-05-12 09:41:44', '2026-05-12 09:41:44'),
(3, 2, 'ORD-6AD82714', '3899.89', '0.00', '15.00', '321.74', '4236.63', 'credit_card', 'Paid', 'Shipped', 3, NULL, '2026-05-24 07:54:44', '2026-05-24 07:54:44'),
(4, 18, 'ORD-A446751A', '4519.86', '0.00', '0.00', '372.89', '4892.75', 'credit_card', 'Paid', 'Processing', 4, 'Please leave at the loading dock.', '2026-05-22 03:45:44', '2026-05-22 03:45:44'),
(5, 12, 'ORD-32EE0674', '2599.86', '0.00', '15.00', '214.49', '2829.35', 'paypal', 'Paid', 'Delivered', 5, 'Please leave at the loading dock.', '2026-05-26 07:34:44', '2026-05-26 07:34:44'),
(6, 3, 'ORD-0442F4E9', '1869.90', '0.00', '0.00', '154.27', '2024.17', 'paypal', 'Paid', 'Shipped', 6, 'Please leave at the loading dock.', '2026-05-02 12:16:44', '2026-05-02 12:16:44'),
(7, 3, 'ORD-B5C12EFE', '759.94', '38.00', '0.00', '59.56', '781.50', 'stripe', 'Failed', 'Cancelled', 6, 'Please leave at the loading dock.', '2026-05-28 11:04:44', '2026-05-28 11:04:44'),
(8, 18, 'ORD-E738B467', '849.95', '0.00', '0.00', '70.12', '920.07', 'paypal', 'Pending', 'Pending', 4, 'Please leave at the loading dock.', '2026-05-06 09:59:44', '2026-05-06 09:59:44'),
(9, 8, 'ORD-42688C59', '1479.93', '0.00', '0.00', '122.09', '1602.02', 'paypal', 'Failed', 'Cancelled', 7, NULL, '2026-05-21 07:33:44', '2026-05-21 07:33:44'),
(10, 21, 'ORD-E26EB318', '1049.95', '0.00', '0.00', '86.62', '1136.57', 'stripe', 'Paid', 'Shipped', 2, NULL, '2026-05-21 08:23:44', '2026-05-21 08:23:44'),
(11, 17, 'ORD-7294B8DD', '2279.89', '0.00', '0.00', '188.09', '2467.98', 'stripe', 'Paid', 'Delivered', 8, NULL, '2026-05-12 04:10:44', '2026-05-12 04:10:44'),
(12, 11, 'ORD-AC258B9A', '1729.88', '0.00', '15.00', '142.72', '1887.60', 'stripe', 'Paid', 'Delivered', 9, NULL, '2026-05-23 06:17:44', '2026-05-23 06:17:44'),
(13, 9, 'ORD-1133B7ED', '411.94', '0.00', '15.00', '33.99', '460.93', 'stripe', 'Paid', 'Delivered', 10, NULL, '2026-05-07 04:40:44', '2026-05-07 04:40:44'),
(14, 8, 'ORD-8832D08D', '339.93', '54.39', '0.00', '23.56', '309.10', 'stripe', 'Paid', 'Delivered', 7, NULL, '2026-05-04 08:51:44', '2026-05-04 08:51:44'),
(15, 10, 'ORD-79C661BC', '289.92', '0.00', '0.00', '23.92', '313.84', 'paypal', 'Pending', 'Pending', 11, 'Please leave at the loading dock.', '2026-05-10 12:27:44', '2026-05-10 12:27:44'),
(16, 13, 'ORD-93E56364', '854.91', '42.75', '15.00', '67.00', '894.16', 'credit_card', 'Paid', 'Shipped', 12, 'Please leave at the loading dock.', '2026-05-19 12:57:44', '2026-05-19 12:57:44'),
(17, 18, 'ORD-8F7B0E5C', '249.93', '15.00', '0.00', '19.38', '254.31', 'credit_card', 'Pending', 'Pending', 4, 'Please leave at the loading dock.', '2026-05-19 07:55:44', '2026-05-19 07:55:44'),
(18, 19, 'ORD-EEEE7B9C', '499.97', '40.00', '0.00', '37.95', '497.92', 'credit_card', 'Paid', 'Delivered', 13, NULL, '2026-05-16 02:50:44', '2026-05-16 02:50:44'),
(19, 4, 'ORD-3C021ED9', '1689.91', '253.49', '15.00', '118.50', '1569.92', 'credit_card', 'Pending', 'Pending', 14, NULL, '2026-05-16 11:27:44', '2026-05-16 11:27:44'),
(20, 13, 'ORD-B3E4DFE7', '1919.93', '0.00', '15.00', '158.39', '2093.32', 'credit_card', 'Paid', 'Shipped', 12, NULL, '2026-05-16 12:21:44', '2026-05-16 12:21:44'),
(21, 20, 'ORD-AB2256E7', '159.96', '0.00', '15.00', '13.20', '188.16', 'paypal', 'Pending', 'Pending', 15, 'Please leave at the loading dock.', '2026-05-21 03:55:44', '2026-05-21 03:55:44'),
(22, 7, 'ORD-E269C3BB', '359.95', '0.00', '0.00', '29.70', '389.65', 'credit_card', 'Pending', 'Pending', 1, NULL, '2026-05-28 11:11:44', '2026-05-28 11:11:44'),
(23, 19, 'ORD-B577BE7F', '1499.95', '284.99', '15.00', '100.23', '1330.19', 'paypal', 'Paid', 'Processing', 13, NULL, '2026-04-30 03:20:44', '2026-04-30 03:20:44'),
(24, 6, 'ORD-27B6DFCD', '3224.86', '0.00', '15.00', '266.05', '3505.91', 'credit_card', 'Paid', 'Delivered', 16, NULL, '2026-05-02 11:16:44', '2026-05-02 11:16:44'),
(25, 19, 'ORD-0273E5BB', '126.98', '7.62', '15.00', '9.85', '144.21', 'paypal', 'Paid', 'Delivered', 13, NULL, '2026-05-13 13:19:44', '2026-05-13 13:19:44'),
(26, 8, 'ORD-D77E83D8', '803.92', '0.00', '0.00', '66.32', '870.24', 'paypal', 'Paid', 'Shipped', 7, NULL, '2026-05-12 11:24:44', '2026-05-12 11:24:44'),
(27, 6, 'ORD-0F2BB693', '1669.87', '0.00', '15.00', '137.76', '1822.63', 'paypal', 'Paid', 'Delivered', 16, 'Please leave at the loading dock.', '2026-05-06 07:11:44', '2026-05-06 07:11:44'),
(28, 17, 'ORD-EF4AC865', '79.96', '0.00', '0.00', '6.60', '86.56', 'paypal', 'Paid', 'Processing', 8, NULL, '2026-05-11 07:05:44', '2026-05-11 07:05:44'),
(29, 9, 'ORD-19624EBA', '1829.89', '0.00', '15.00', '150.97', '1995.86', 'stripe', 'Pending', 'Pending', 10, 'Please leave at the loading dock.', '2026-05-14 03:13:44', '2026-05-14 03:13:44'),
(30, 21, 'ORD-8D0A3CA6', '239.96', '43.19', '0.00', '16.23', '213.00', 'paypal', 'Paid', 'Processing', 2, NULL, '2026-05-10 06:53:44', '2026-05-10 06:53:44'),
(31, 10, 'ORD-CCA2EA3B', '1919.91', '0.00', '0.00', '158.39', '2078.30', 'stripe', 'Paid', 'Delivered', 11, NULL, '2026-05-11 12:59:44', '2026-05-11 12:59:44'),
(32, 4, 'ORD-D8B6C353', '1054.92', '0.00', '0.00', '87.03', '1141.95', 'paypal', 'Failed', 'Cancelled', 14, NULL, '2026-05-13 12:50:44', '2026-05-13 12:50:44'),
(33, 11, 'ORD-CC81574B', '624.94', '0.00', '0.00', '51.56', '676.50', 'paypal', 'Pending', 'Pending', 9, 'Please leave at the loading dock.', '2026-05-01 04:52:44', '2026-05-01 04:52:44'),
(34, 12, 'ORD-84BA4074', '1259.93', '113.39', '0.00', '94.59', '1241.13', 'paypal', 'Pending', 'Pending', 5, 'Please leave at the loading dock.', '2026-05-22 06:19:44', '2026-05-22 06:19:44'),
(35, 13, 'ORD-2BA116F9', '519.90', '0.00', '15.00', '42.89', '577.79', 'paypal', 'Failed', 'Cancelled', 12, 'Please leave at the loading dock.', '2026-05-10 08:44:44', '2026-05-10 08:44:44'),
(36, 10, 'ORD-1AA19886', '644.93', '0.00', '15.00', '53.21', '713.14', 'paypal', 'Paid', 'Shipped', 11, NULL, '2026-05-08 05:51:44', '2026-05-08 05:51:44'),
(37, 17, 'ORD-FC9E3283', '118.96', '0.00', '15.00', '9.81', '143.77', 'paypal', 'Pending', 'Pending', 8, NULL, '2026-05-04 03:50:45', '2026-05-04 03:50:45'),
(38, 9, 'ORD-6CE56E07', '609.92', '0.00', '15.00', '50.32', '675.24', 'paypal', 'Pending', 'Pending', 10, NULL, '2026-05-13 08:44:45', '2026-05-13 08:44:45'),
(39, 12, 'ORD-88C76141', '1719.92', '0.00', '0.00', '141.89', '1861.81', 'credit_card', 'Paid', 'Delivered', 5, NULL, '2026-05-06 04:07:45', '2026-05-06 04:07:45'),
(40, 8, 'ORD-737BB892', '883.93', '0.00', '15.00', '72.92', '971.85', 'paypal', 'Paid', 'Processing', 7, NULL, '2026-05-20 13:01:45', '2026-05-20 13:01:45'),
(41, 22, 'ORD-562DE08A', '5576.91', '501.92', '0.00', '418.69', '5493.68', 'paypal', 'Paid', 'Delivered', 17, NULL, '2026-05-07 10:27:45', '2026-05-07 10:27:45'),
(42, 4, 'ORD-B3889766', '559.87', '72.78', '0.00', '40.18', '527.27', 'credit_card', 'Pending', 'Pending', 14, 'Please leave at the loading dock.', '2026-05-23 06:50:45', '2026-05-23 06:50:45'),
(43, 8, 'ORD-08AE4B27', '734.91', '0.00', '0.00', '60.63', '795.54', 'credit_card', 'Paid', 'Delivered', 7, NULL, '2026-05-09 11:07:45', '2026-05-09 11:07:45'),
(44, 18, 'ORD-3E67B16B', '1499.94', '0.00', '15.00', '123.75', '1638.69', 'stripe', 'Paid', 'Delivered', 4, NULL, '2026-04-30 12:48:45', '2026-04-30 12:48:45'),
(45, 13, 'ORD-298A5F66', '2210.88', '0.00', '0.00', '182.40', '2393.28', 'paypal', 'Paid', 'Processing', 12, NULL, '2026-05-06 10:13:45', '2026-05-06 10:13:45'),
(46, 20, 'ORD-D01AD32C', '59.97', '0.00', '0.00', '4.95', '64.92', 'credit_card', 'Failed', 'Cancelled', 15, NULL, '2026-05-03 05:44:45', '2026-05-03 05:44:45'),
(47, 19, 'ORD-5A273B04', '2589.88', '492.08', '0.00', '173.07', '2270.87', 'stripe', 'Pending', 'Pending', 13, NULL, '2026-05-09 08:23:45', '2026-05-09 08:23:45'),
(48, 18, 'ORD-13B836C2', '5689.91', '0.00', '15.00', '469.42', '6174.33', 'credit_card', 'Paid', 'Delivered', 4, 'Please leave at the loading dock.', '2026-05-22 12:02:45', '2026-05-22 12:02:45'),
(49, 6, 'ORD-FC8CE4F0', '1039.94', '0.00', '15.00', '85.80', '1140.74', 'stripe', 'Paid', 'Processing', 16, NULL, '2026-05-04 12:38:45', '2026-05-04 12:38:45'),
(50, 7, 'ORD-A881CC4D', '269.93', '0.00', '0.00', '22.27', '292.20', 'stripe', 'Pending', 'Pending', 1, NULL, '2026-05-07 04:27:45', '2026-05-07 04:27:45'),
(51, 23, 'ORD-1312FCC1', '169.99', '0.00', '0.00', '14.02', '184.01', 'cod', 'Paid', 'Delivered', 18, NULL, '2026-05-31 20:33:06', '2026-05-31 20:53:42'),
(52, 23, 'ORD-7EC3E710', '46.97', '0.00', '15.00', '3.88', '65.85', 'cod', 'Paid', 'Delivered', 18, 'cash on delivery', '2026-05-31 20:55:18', '2026-05-31 21:05:55'),
(53, 23, 'ORD-C1B42A3A', '389.98', '0.00', '0.00', '32.17', '422.15', 'stripe', 'Paid', 'Pending', 18, 'Payment via stripe', '2026-05-31 21:29:45', '2026-05-31 21:29:45'),
(54, 23, 'ORD-9E77B2F7', '329.99', '33.00', '0.00', '24.50', '321.49', 'stripe', 'Paid', 'Pending', 18, 'payment stripe', '2026-05-31 21:41:20', '2026-05-31 21:41:20'),
(56, 23, 'ORD-5014B3A9', '12.99', '0.00', '15.00', '1.07', '29.06', 'paypal', 'Paid', 'Pending', 18, NULL, '2026-06-01 09:07:06', '2026-06-01 09:07:06'),
(57, 23, 'ORD-C3804FB4', '16.99', '0.00', '15.00', '1.40', '33.39', 'paypal', 'Paid', 'Delivered', 18, NULL, '2026-06-01 09:09:36', '2026-06-01 10:16:56'),
(58, 23, 'ORD-B654397F', '169.99', '34.00', '0.00', '11.22', '147.21', 'cod', 'Pending', 'Pending', 18, NULL, '2026-06-01 10:21:39', '2026-06-01 10:21:39'),
(59, 23, 'ORD-2BDA6D2B', '299.99', '0.00', '0.00', '24.75', '324.74', 'stripe', 'Paid', 'Pending', 18, 'paymet stripe', '2026-06-01 10:23:32', '2026-06-01 10:23:32'),
(60, 23, 'ORD-FF315B7C', '109.99', '0.00', '0.00', '9.07', '119.06', 'paypal', 'Paid', 'Pending', 18, 'paypal payment', '2026-06-01 10:26:21', '2026-06-01 10:26:21'),
(61, 2, 'ORD-6A56F5ECC4021', '549.97', '0.00', '0.00', '44.00', '593.97', 'Cash on Delivery', 'Pending', 'Pending', 19, NULL, '2026-07-15 02:52:28', '2026-07-15 02:52:28'),
(62, 2, 'ORD-6A56F65FA38A6', '549.97', '0.00', '0.00', '44.00', '593.97', 'Cash on Delivery', 'Pending', 'Pending', 19, NULL, '2026-07-15 02:54:23', '2026-07-15 02:54:23'),
(63, 2, 'ORD-6A56F6A44FFC2', '549.97', '0.00', '0.00', '44.00', '593.97', 'Cash on Delivery', 'Pending', 'Pending', 19, NULL, '2026-07-15 02:55:32', '2026-07-15 02:55:32'),
(64, 2, 'ORD-6A56F758B6C0E', '549.97', '0.00', '0.00', '44.00', '593.97', 'Cash on Delivery', 'Pending', 'Pending', 19, NULL, '2026-07-15 02:58:32', '2026-07-15 02:58:32'),
(65, 2, 'ORD-6A56F79E6A134', '549.97', '0.00', '0.00', '44.00', '593.97', 'Cash on Delivery', 'Paid', 'Delivered', 19, 'shipped order', '2026-07-15 02:59:42', '2026-07-15 03:27:05'),
(66, 2, 'ORD-6A5703CA9C32D', '59.99', '0.00', '9.99', '4.80', '74.78', 'Credit Card', 'Paid', 'Delivered', 19, '', '2026-07-15 03:51:38', '2026-07-15 03:54:53'),
(67, 2, 'ORD-6A573C3BA3057', '16.99', '0.00', '9.99', '1.36', '28.34', 'PayPal', 'Paid', 'Delivered', 19, '', '2026-07-15 07:52:27', '2026-07-15 08:02:11'),
(68, 27, 'ORD-6A575A341A89A', '596.97', '0.00', '0.00', '47.76', '644.73', 'Cash on Delivery', 'Paid', 'Delivered', 20, '', '2026-07-15 10:00:20', '2026-07-15 10:30:24'),
(69, 27, 'ORD-6A57628A7F903', '19.99', '0.00', '9.99', '1.60', '31.58', 'Credit Card', 'Paid', 'Delivered', 20, '', '2026-07-15 10:35:54', '2026-07-15 10:39:31'),
(70, 27, 'ORD-6A5763EB484F5', '34.99', '0.00', '9.99', '2.80', '47.78', 'PayPal', 'Paid', 'Pending', 20, NULL, '2026-07-15 10:41:47', '2026-07-15 10:41:47');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `sku` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT '1',
  `price` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_name`, `sku`, `quantity`, `price`, `total`, `created_at`, `updated_at`) VALUES
(1, 1, 34, 'Stanley Heavy-Duty Hex Bolt Assortment', 'STN-100-HD-BOLT', 2, '39.99', '79.98', '2026-05-04 11:45:44', '2026-05-04 11:45:44'),
(2, 1, 24, '3M ProGrade Laser Level Kit', '3M-PRO-LEVEL', 1, '219.99', '219.99', '2026-05-04 11:45:44', '2026-05-04 11:45:44'),
(3, 1, 34, 'Stanley Heavy-Duty Hex Bolt Assortment', 'STN-100-HD-BOLT', 3, '39.99', '119.97', '2026-05-04 11:45:44', '2026-05-04 11:45:44'),
(4, 1, 25, '3M P100 Particulate Filter Pair', '3M-2091-P100', 3, '12.99', '38.97', '2026-05-04 11:45:44', '2026-05-04 11:45:44'),
(5, 1, 45, 'Stanley 100ft Fiberglass Long Tape', 'STN-100SQ-SPEED', 3, '34.99', '104.97', '2026-05-04 11:45:44', '2026-05-04 11:45:44'),
(6, 2, 29, 'DeWalt 14\" Chop Saw', 'DWT-DW872', 4, '359.99', '1439.96', '2026-05-12 09:41:44', '2026-05-12 09:41:44'),
(7, 3, 7, 'Lincoln Electric 210 MP Multiprocess Welder', 'LIN-210-MIG', 2, '1149.99', '2299.98', '2026-05-24 07:54:44', '2026-05-24 07:54:44'),
(8, 3, 14, 'Milwaukee M18 Fuel Sawzall Recip Saw', 'MLW-2722-21', 2, '269.99', '539.98', '2026-05-24 07:54:44', '2026-05-24 07:54:44'),
(9, 3, 41, 'Milwaukee Packout 3-Piece Set', 'MLW-48-22-8420', 3, '319.99', '959.97', '2026-05-24 07:54:44', '2026-05-24 07:54:44'),
(10, 3, 27, '3M 1425 Earmuffs (26dB NRR)', '3M-1425-EAR', 4, '24.99', '99.96', '2026-05-24 07:54:44', '2026-05-24 07:54:44'),
(11, 4, 32, 'Stanley 20-Piece Saw Blade Set', 'STN-20-600-BLADE', 4, '39.99', '159.96', '2026-05-22 03:45:44', '2026-05-22 03:45:44'),
(12, 4, 7, 'Lincoln Electric 210 MP Multiprocess Welder', 'LIN-210-MIG', 3, '1149.99', '3449.97', '2026-05-22 03:45:44', '2026-05-22 03:45:44'),
(13, 4, 58, 'Stanley 10-Piece Wood Chisel Set', 'STN-10PC-CHISEL', 3, '49.99', '149.97', '2026-05-22 03:45:44', '2026-05-22 03:45:44'),
(14, 4, 16, 'Snap-On 3-Piece Pliers Set', 'SNP-3PC-PLYRS', 4, '189.99', '759.96', '2026-05-22 03:45:44', '2026-05-22 03:45:44'),
(15, 5, 30, 'Bosch CL700K Jigsaw', 'BOS-CL700-JIG', 1, '159.99', '159.99', '2026-05-26 07:34:44', '2026-05-26 07:34:44'),
(16, 5, 10, 'Milwaukee M18 Fuel Impact Driver', 'MLW-2861-20', 2, '199.99', '399.98', '2026-05-26 07:34:44', '2026-05-26 07:34:44'),
(17, 5, 23, 'Stanley 48\" Aluminum Level', 'STN-48IN-LVL', 4, '49.99', '199.96', '2026-05-26 07:34:44', '2026-05-26 07:34:44'),
(18, 5, 56, 'Makita XPG01 Cordless Soldering Iron', 'MKT-XPG01-SOLD', 3, '79.99', '239.97', '2026-05-26 07:34:44', '2026-05-26 07:34:44'),
(19, 5, 18, 'Snap-On 80-Piece Screwdriver Set', 'SNP-TK80-SCRW', 4, '399.99', '1599.96', '2026-05-26 07:34:44', '2026-05-26 07:34:44'),
(20, 6, 8, 'Stanley 26\" Tool Chest Combo', 'STN-26IN-TCHEST', 1, '349.99', '349.99', '2026-05-02 12:16:44', '2026-05-02 12:16:44'),
(21, 6, 11, 'Makita XGT 40V Angle Grinder', 'MKT-XGT40-GR', 1, '329.99', '329.99', '2026-05-02 12:16:44', '2026-05-02 12:16:44'),
(22, 6, 28, '3M GL80 Nitrile Work Gloves (12-Pack)', '3M-GL80-GLOV', 4, '39.99', '159.96', '2026-05-02 12:16:44', '2026-05-02 12:16:44'),
(23, 6, 22, 'Bosch GLM50C Bluetooth Laser Measure', 'BOS-GLM50C', 3, '159.99', '479.97', '2026-05-02 12:16:44', '2026-05-02 12:16:44'),
(24, 6, 2, 'Milwaukee 12\" Compound Miter Saw', 'MLW-12A-SAW', 1, '549.99', '549.99', '2026-05-02 12:16:44', '2026-05-02 12:16:44'),
(25, 7, 2, 'Milwaukee 12\" Compound Miter Saw', 'MLW-12A-SAW', 1, '549.99', '549.99', '2026-05-28 11:04:44', '2026-05-28 11:04:44'),
(26, 7, 34, 'Stanley Heavy-Duty Hex Bolt Assortment', 'STN-100-HD-BOLT', 3, '39.99', '119.97', '2026-05-28 11:04:44', '2026-05-28 11:04:44'),
(27, 7, 20, 'DeWalt Adjustable Wrench 10\"', 'DWT-10IN-WRENCH', 2, '44.99', '89.98', '2026-05-28 11:04:44', '2026-05-28 11:04:44'),
(28, 8, 33, 'Stanley 25-Pack Shear Nails', 'STN-SHR25-NAIL', 1, '89.99', '89.99', '2026-05-06 09:59:44', '2026-05-06 09:59:44'),
(29, 8, 16, 'Snap-On 3-Piece Pliers Set', 'SNP-3PC-PLYRS', 4, '189.99', '759.96', '2026-05-06 09:59:44', '2026-05-06 09:59:44'),
(30, 9, 46, 'Makita 14\" Cut-Off Saw', 'MKT-UC4051A', 2, '399.99', '799.98', '2026-05-21 07:33:44', '2026-05-21 07:33:44'),
(31, 9, 19, 'Stanley 25ft PowerLock Tape Measure', 'STN-25FT-TAPE', 1, '19.99', '19.99', '2026-05-21 07:33:44', '2026-05-21 07:33:44'),
(32, 9, 1, 'DeWalt 20V Max Cordless Drill', 'DWT-20V-DRL', 2, '169.99', '339.98', '2026-05-21 07:33:44', '2026-05-21 07:33:44'),
(33, 9, 52, 'DeWalt DW088K Self-Leveling Cross Line Laser', 'DWT-DW088K', 2, '159.99', '319.98', '2026-05-21 07:33:44', '2026-05-21 07:33:44'),
(34, 10, 43, 'Bosch PS31 12V Max 3/8\" Impact Wrench', 'BOS-PS31-2', 4, '149.99', '599.96', '2026-05-21 08:23:44', '2026-05-21 08:23:44'),
(35, 10, 31, 'Makita 10\" Compound Miter Saw', 'MKT-LS1019L', 1, '449.99', '449.99', '2026-05-21 08:23:44', '2026-05-21 08:23:44'),
(36, 11, 3, 'Snap-On 6-Piece Combination Wrench Set', 'SNP-6PC-WRENCH', 4, '249.99', '999.96', '2026-05-12 04:10:44', '2026-05-12 04:10:44'),
(37, 11, 13, 'DeWalt 20V Max 7-1/4\" Circular Saw', 'DWT-DCS570B', 4, '199.99', '799.96', '2026-05-12 04:10:44', '2026-05-12 04:10:44'),
(38, 11, 52, 'DeWalt DW088K Self-Leveling Cross Line Laser', 'DWT-DW088K', 3, '159.99', '479.97', '2026-05-12 04:10:44', '2026-05-12 04:10:44'),
(39, 12, 20, 'DeWalt Adjustable Wrench 10\"', 'DWT-10IN-WRENCH', 4, '44.99', '179.96', '2026-05-23 06:17:44', '2026-05-23 06:17:44'),
(40, 12, 12, 'Bosch 12V Max 3/8\" Drill Driver', 'BOS-GSR12V-140', 3, '109.99', '329.97', '2026-05-23 06:17:44', '2026-05-23 06:17:44'),
(41, 12, 36, 'Lincoln Electric Viking 3350 Welding Helmet', 'LIN-VIP-PKG', 4, '299.99', '1199.96', '2026-05-23 06:17:44', '2026-05-23 06:17:44'),
(42, 12, 19, 'Stanley 25ft PowerLock Tape Measure', 'STN-25FT-TAPE', 1, '19.99', '19.99', '2026-05-23 06:17:44', '2026-05-23 06:17:44'),
(43, 13, 52, 'DeWalt DW088K Self-Leveling Cross Line Laser', 'DWT-DW088K', 1, '159.99', '159.99', '2026-05-07 04:40:44', '2026-05-07 04:40:44'),
(44, 13, 25, '3M P100 Particulate Filter Pair', '3M-2091-P100', 4, '12.99', '51.96', '2026-05-07 04:40:44', '2026-05-07 04:40:44'),
(45, 13, 10, 'Milwaukee M18 Fuel Impact Driver', 'MLW-2861-20', 1, '199.99', '199.99', '2026-05-07 04:40:44', '2026-05-07 04:40:44'),
(46, 14, 50, 'Stanley 12\" Quick-Grip Bar Clamp', 'STN-12IN-CLAMP', 4, '24.99', '99.96', '2026-05-04 08:51:44', '2026-05-04 08:51:44'),
(47, 14, 19, 'Stanley 25ft PowerLock Tape Measure', 'STN-25FT-TAPE', 1, '19.99', '19.99', '2026-05-04 08:51:44', '2026-05-04 08:51:44'),
(48, 14, 12, 'Bosch 12V Max 3/8\" Drill Driver', 'BOS-GSR12V-140', 2, '109.99', '219.98', '2026-05-04 08:51:44', '2026-05-04 08:51:44'),
(49, 15, 58, 'Stanley 10-Piece Wood Chisel Set', 'STN-10PC-CHISEL', 4, '49.99', '199.96', '2026-05-10 12:27:44', '2026-05-10 12:27:44'),
(50, 15, 50, 'Stanley 12\" Quick-Grip Bar Clamp', 'STN-12IN-CLAMP', 2, '24.99', '49.98', '2026-05-10 12:27:44', '2026-05-10 12:27:44'),
(51, 15, 19, 'Stanley 25ft PowerLock Tape Measure', 'STN-25FT-TAPE', 2, '19.99', '39.98', '2026-05-10 12:27:44', '2026-05-10 12:27:44'),
(52, 16, 5, '3M 6800 Half Facepiece Reusable Respirator', '3M-6800-RESP', 2, '49.99', '99.98', '2026-05-19 12:57:44', '2026-05-19 12:57:44'),
(53, 16, 13, 'DeWalt 20V Max 7-1/4\" Circular Saw', 'DWT-DCS570B', 3, '199.99', '599.97', '2026-05-19 12:57:44', '2026-05-19 12:57:44'),
(54, 16, 47, 'Stanley 200-Piece Stainless Screw Assortment', 'STN-200-SS-SCR', 2, '24.99', '49.98', '2026-05-19 12:57:44', '2026-05-19 12:57:44'),
(55, 16, 50, 'Stanley 12\" Quick-Grip Bar Clamp', 'STN-12IN-CLAMP', 1, '24.99', '24.99', '2026-05-19 12:57:44', '2026-05-19 12:57:44'),
(56, 16, 39, 'Stanley TB300 Tool Backpack', 'STN-TB300-ORG', 1, '79.99', '79.99', '2026-05-19 12:57:44', '2026-05-19 12:57:44'),
(57, 17, 45, 'Stanley 100ft Fiberglass Long Tape', 'STN-100SQ-SPEED', 3, '34.99', '104.97', '2026-05-19 07:55:44', '2026-05-19 07:55:44'),
(58, 17, 34, 'Stanley Heavy-Duty Hex Bolt Assortment', 'STN-100-HD-BOLT', 1, '39.99', '39.99', '2026-05-19 07:55:44', '2026-05-19 07:55:44'),
(59, 17, 55, 'Stanley 100-Pack Heavy-Duty Latch Kit', 'STN-LG100-LATCH', 3, '34.99', '104.97', '2026-05-19 07:55:44', '2026-05-19 07:55:44'),
(60, 18, 24, '3M ProGrade Laser Level Kit', '3M-PRO-LEVEL', 2, '219.99', '439.98', '2026-05-16 02:50:44', '2026-05-16 02:50:44'),
(61, 18, 15, 'Stanley 20V Cordless Glue Gun', 'STN-SBL20V-GLUE', 1, '59.99', '59.99', '2026-05-16 02:50:44', '2026-05-16 02:50:44'),
(62, 19, 54, 'Bosch 18V Cordless Jigsaw', 'BOS-GST18V-60C', 1, '189.99', '189.99', '2026-05-16 11:27:44', '2026-05-16 11:27:44'),
(63, 19, 13, 'DeWalt 20V Max 7-1/4\" Circular Saw', 'DWT-DCS570B', 4, '199.99', '799.96', '2026-05-16 11:27:44', '2026-05-16 11:27:44'),
(64, 19, 6, 'Makita 7-1/4\" Circular Saw', 'MKT-LXT-7CIRC', 2, '149.99', '299.98', '2026-05-16 11:27:44', '2026-05-16 11:27:44'),
(65, 19, 13, 'DeWalt 20V Max 7-1/4\" Circular Saw', 'DWT-DCS570B', 2, '199.99', '399.98', '2026-05-16 11:27:44', '2026-05-16 11:27:44'),
(66, 20, 22, 'Bosch GLM50C Bluetooth Laser Measure', 'BOS-GLM50C', 3, '159.99', '479.97', '2026-05-16 12:21:44', '2026-05-16 12:21:44'),
(67, 20, 29, 'DeWalt 14\" Chop Saw', 'DWT-DW872', 4, '359.99', '1439.96', '2026-05-16 12:21:44', '2026-05-16 12:21:44'),
(68, 21, 34, 'Stanley Heavy-Duty Hex Bolt Assortment', 'STN-100-HD-BOLT', 1, '39.99', '39.99', '2026-05-21 03:55:44', '2026-05-21 03:55:44'),
(69, 21, 28, '3M GL80 Nitrile Work Gloves (12-Pack)', '3M-GL80-GLOV', 3, '39.99', '119.97', '2026-05-21 03:55:44', '2026-05-21 03:55:44'),
(70, 22, 33, 'Stanley 25-Pack Shear Nails', 'STN-SHR25-NAIL', 3, '89.99', '269.97', '2026-05-28 11:11:44', '2026-05-28 11:11:44'),
(71, 22, 20, 'DeWalt Adjustable Wrench 10\"', 'DWT-10IN-WRENCH', 2, '44.99', '89.98', '2026-05-28 11:11:44', '2026-05-28 11:11:44'),
(72, 23, 43, 'Bosch PS31 12V Max 3/8\" Impact Wrench', 'BOS-PS31-2', 2, '149.99', '299.98', '2026-04-30 03:20:44', '2026-04-30 03:20:44'),
(73, 23, 37, 'Lincoln Electric ED031223 Weld Pack 125', 'LIN-ED031223', 3, '399.99', '1199.97', '2026-04-30 03:20:44', '2026-04-30 03:20:44'),
(74, 24, 31, 'Makita 10\" Compound Miter Saw', 'MKT-LS1019L', 3, '449.99', '1349.97', '2026-05-02 11:16:44', '2026-05-02 11:16:44'),
(75, 24, 4, 'Bosch GLL100 Self-Leveling Cross-Line Laser', 'BOS-GLL100-LASER', 4, '299.99', '1199.96', '2026-05-02 11:16:44', '2026-05-02 11:16:44'),
(76, 24, 15, 'Stanley 20V Cordless Glue Gun', 'STN-SBL20V-GLUE', 3, '59.99', '179.97', '2026-05-02 11:16:44', '2026-05-02 11:16:44'),
(77, 24, 20, 'DeWalt Adjustable Wrench 10\"', 'DWT-10IN-WRENCH', 1, '44.99', '44.99', '2026-05-02 11:16:44', '2026-05-02 11:16:44'),
(78, 24, 43, 'Bosch PS31 12V Max 3/8\" Impact Wrench', 'BOS-PS31-2', 3, '149.99', '449.97', '2026-05-02 11:16:44', '2026-05-02 11:16:44'),
(79, 25, 48, 'Lincoln Electric KF25 MIG Welding Wire 2lb', 'LIN-KF25-MIG', 1, '16.99', '16.99', '2026-05-13 13:19:44', '2026-05-13 13:19:44'),
(80, 25, 12, 'Bosch 12V Max 3/8\" Drill Driver', 'BOS-GSR12V-140', 1, '109.99', '109.99', '2026-05-13 13:19:44', '2026-05-13 13:19:44'),
(81, 26, 39, 'Stanley TB300 Tool Backpack', 'STN-TB300-ORG', 2, '79.99', '159.98', '2026-05-12 11:24:44', '2026-05-12 11:24:44'),
(82, 26, 46, 'Makita 14\" Cut-Off Saw', 'MKT-UC4051A', 1, '399.99', '399.99', '2026-05-12 11:24:44', '2026-05-12 11:24:44'),
(83, 26, 57, 'Bosch GBA 2-28L Tool Case', 'BOS-GBH2-28L', 3, '69.99', '209.97', '2026-05-12 11:24:44', '2026-05-12 11:24:44'),
(84, 26, 48, 'Lincoln Electric KF25 MIG Welding Wire 2lb', 'LIN-KF25-MIG', 2, '16.99', '33.98', '2026-05-12 11:24:44', '2026-05-12 11:24:44'),
(85, 27, 9, 'DeWalt 20V Max XR Hammer Drill', 'DWT-DCD999B', 4, '239.99', '959.96', '2026-05-06 07:11:44', '2026-05-06 07:11:44'),
(86, 27, 11, 'Makita XGT 40V Angle Grinder', 'MKT-XGT40-GR', 1, '329.99', '329.99', '2026-05-06 07:11:44', '2026-05-06 07:11:44'),
(87, 27, 49, '3M High-Visibility Safety Vest Class 2', '3M-SFTY-VEST-HI', 2, '19.99', '39.98', '2026-05-06 07:11:44', '2026-05-06 07:11:44'),
(88, 27, 23, 'Stanley 48\" Aluminum Level', 'STN-48IN-LVL', 2, '49.99', '99.98', '2026-05-06 07:11:44', '2026-05-06 07:11:44'),
(89, 27, 44, 'Snap-On 10\" Flat Pry Bar', 'SNP-BP100-PRY', 4, '59.99', '239.96', '2026-05-06 07:11:44', '2026-05-06 07:11:44'),
(90, 28, 19, 'Stanley 25ft PowerLock Tape Measure', 'STN-25FT-TAPE', 4, '19.99', '79.96', '2026-05-11 07:05:44', '2026-05-11 07:05:44'),
(91, 29, 39, 'Stanley TB300 Tool Backpack', 'STN-TB300-ORG', 4, '79.99', '319.96', '2026-05-14 03:13:44', '2026-05-14 03:13:44'),
(92, 29, 1, 'DeWalt 20V Max Cordless Drill', 'DWT-20V-DRL', 3, '169.99', '509.97', '2026-05-14 03:13:44', '2026-05-14 03:13:44'),
(93, 29, 26, '3M V5 Safety Goggles', '3M-V5-GOGGLE', 1, '19.99', '19.99', '2026-05-14 03:13:44', '2026-05-14 03:13:44'),
(94, 29, 51, 'Snap-On CT882 1/2\" Air Impact Wrench', 'SNP-CT882-AIR', 1, '599.99', '599.99', '2026-05-14 03:13:44', '2026-05-14 03:13:44'),
(95, 29, 54, 'Bosch 18V Cordless Jigsaw', 'BOS-GST18V-60C', 2, '189.99', '379.98', '2026-05-14 03:13:44', '2026-05-14 03:13:44'),
(96, 30, 56, 'Makita XPG01 Cordless Soldering Iron', 'MKT-XPG01-SOLD', 2, '79.99', '159.98', '2026-05-10 06:53:44', '2026-05-10 06:53:44'),
(97, 30, 28, '3M GL80 Nitrile Work Gloves (12-Pack)', '3M-GL80-GLOV', 2, '39.99', '79.98', '2026-05-10 06:53:44', '2026-05-10 06:53:44'),
(98, 31, 46, 'Makita 14\" Cut-Off Saw', 'MKT-UC4051A', 2, '399.99', '799.98', '2026-05-11 12:59:44', '2026-05-11 12:59:44'),
(99, 31, 22, 'Bosch GLM50C Bluetooth Laser Measure', 'BOS-GLM50C', 4, '159.99', '639.96', '2026-05-11 12:59:44', '2026-05-11 12:59:44'),
(100, 31, 30, 'Bosch CL700K Jigsaw', 'BOS-CL700-JIG', 3, '159.99', '479.97', '2026-05-11 12:59:44', '2026-05-11 12:59:44'),
(101, 32, 20, 'DeWalt Adjustable Wrench 10\"', 'DWT-10IN-WRENCH', 1, '44.99', '44.99', '2026-05-13 12:50:44', '2026-05-13 12:50:44'),
(102, 32, 12, 'Bosch 12V Max 3/8\" Drill Driver', 'BOS-GSR12V-140', 4, '109.99', '439.96', '2026-05-13 12:50:44', '2026-05-13 12:50:44'),
(103, 32, 54, 'Bosch 18V Cordless Jigsaw', 'BOS-GST18V-60C', 3, '189.99', '569.97', '2026-05-13 12:50:44', '2026-05-13 12:50:44'),
(104, 33, 1, 'DeWalt 20V Max Cordless Drill', 'DWT-20V-DRL', 3, '169.99', '509.97', '2026-05-01 04:52:44', '2026-05-01 04:52:44'),
(105, 33, 28, '3M GL80 Nitrile Work Gloves (12-Pack)', '3M-GL80-GLOV', 2, '39.99', '79.98', '2026-05-01 04:52:44', '2026-05-01 04:52:44'),
(106, 33, 45, 'Stanley 100ft Fiberglass Long Tape', 'STN-100SQ-SPEED', 1, '34.99', '34.99', '2026-05-01 04:52:44', '2026-05-01 04:52:44'),
(107, 34, 52, 'DeWalt DW088K Self-Leveling Cross Line Laser', 'DWT-DW088K', 4, '159.99', '639.96', '2026-05-22 06:19:44', '2026-05-22 06:19:44'),
(108, 34, 36, 'Lincoln Electric Viking 3350 Welding Helmet', 'LIN-VIP-PKG', 2, '299.99', '599.98', '2026-05-22 06:19:44', '2026-05-22 06:19:44'),
(109, 34, 26, '3M V5 Safety Goggles', '3M-V5-GOGGLE', 1, '19.99', '19.99', '2026-05-22 06:19:44', '2026-05-22 06:19:44'),
(110, 35, 58, 'Stanley 10-Piece Wood Chisel Set', 'STN-10PC-CHISEL', 4, '49.99', '199.96', '2026-05-10 08:44:44', '2026-05-10 08:44:44'),
(111, 35, 32, 'Stanley 20-Piece Saw Blade Set', 'STN-20-600-BLADE', 2, '39.99', '79.98', '2026-05-10 08:44:44', '2026-05-10 08:44:44'),
(112, 35, 15, 'Stanley 20V Cordless Glue Gun', 'STN-SBL20V-GLUE', 4, '59.99', '239.96', '2026-05-10 08:44:44', '2026-05-10 08:44:44'),
(113, 36, 5, '3M 6800 Half Facepiece Reusable Respirator', '3M-6800-RESP', 4, '49.99', '199.96', '2026-05-08 05:51:44', '2026-05-08 05:51:44'),
(114, 36, 49, '3M High-Visibility Safety Vest Class 2', '3M-SFTY-VEST-HI', 1, '19.99', '19.99', '2026-05-08 05:51:44', '2026-05-08 05:51:44'),
(115, 36, 37, 'Lincoln Electric ED031223 Weld Pack 125', 'LIN-ED031223', 1, '399.99', '399.99', '2026-05-08 05:51:44', '2026-05-08 05:51:44'),
(116, 36, 47, 'Stanley 200-Piece Stainless Screw Assortment', 'STN-200-SS-SCR', 1, '24.99', '24.99', '2026-05-08 05:51:44', '2026-05-08 05:51:44'),
(117, 37, 5, '3M 6800 Half Facepiece Reusable Respirator', '3M-6800-RESP', 1, '49.99', '49.99', '2026-05-04 03:50:45', '2026-05-04 03:50:45'),
(118, 37, 55, 'Stanley 100-Pack Heavy-Duty Latch Kit', 'STN-LG100-LATCH', 1, '34.99', '34.99', '2026-05-04 03:50:45', '2026-05-04 03:50:45'),
(119, 37, 35, 'Stanley 50-Pack Toggle Bolt Kit', 'STN-50-TOG-KIT', 2, '16.99', '33.98', '2026-05-04 03:50:45', '2026-05-04 03:50:45'),
(120, 38, 26, '3M V5 Safety Goggles', '3M-V5-GOGGLE', 1, '19.99', '19.99', '2026-05-13 08:44:45', '2026-05-13 08:44:45'),
(121, 38, 22, 'Bosch GLM50C Bluetooth Laser Measure', 'BOS-GLM50C', 2, '159.99', '319.98', '2026-05-13 08:44:45', '2026-05-13 08:44:45'),
(122, 38, 53, '3M H-700 Series Hard Hat', '3M-HT100-HARD', 1, '29.99', '29.99', '2026-05-13 08:44:45', '2026-05-13 08:44:45'),
(123, 38, 40, 'DeWalt TSTAK Tool Box', 'DWT-DWST1-75334', 4, '59.99', '239.96', '2026-05-13 08:44:45', '2026-05-13 08:44:45'),
(124, 39, 29, 'DeWalt 14\" Chop Saw', 'DWT-DW872', 4, '359.99', '1439.96', '2026-05-06 04:07:45', '2026-05-06 04:07:45'),
(125, 39, 57, 'Bosch GBA 2-28L Tool Case', 'BOS-GBH2-28L', 4, '69.99', '279.96', '2026-05-06 04:07:45', '2026-05-06 04:07:45'),
(126, 40, 8, 'Stanley 26\" Tool Chest Combo', 'STN-26IN-TCHEST', 2, '349.99', '699.98', '2026-05-20 13:01:45', '2026-05-20 13:01:45'),
(127, 40, 48, 'Lincoln Electric KF25 MIG Welding Wire 2lb', 'LIN-KF25-MIG', 2, '16.99', '33.98', '2026-05-20 13:01:45', '2026-05-20 13:01:45'),
(128, 40, 5, '3M 6800 Half Facepiece Reusable Respirator', '3M-6800-RESP', 3, '49.99', '149.97', '2026-05-20 13:01:45', '2026-05-20 13:01:45'),
(129, 41, 9, 'DeWalt 20V Max XR Hammer Drill', 'DWT-DCD999B', 4, '239.99', '959.96', '2026-05-07 10:27:45', '2026-05-07 10:27:45'),
(130, 41, 7, 'Lincoln Electric 210 MP Multiprocess Welder', 'LIN-210-MIG', 4, '1149.99', '4599.96', '2026-05-07 10:27:45', '2026-05-07 10:27:45'),
(131, 41, 35, 'Stanley 50-Pack Toggle Bolt Kit', 'STN-50-TOG-KIT', 1, '16.99', '16.99', '2026-05-07 10:27:45', '2026-05-07 10:27:45'),
(132, 42, 39, 'Stanley TB300 Tool Backpack', 'STN-TB300-ORG', 2, '79.99', '159.98', '2026-05-23 06:50:45', '2026-05-23 06:50:45'),
(133, 42, 32, 'Stanley 20-Piece Saw Blade Set', 'STN-20-600-BLADE', 4, '39.99', '159.96', '2026-05-23 06:50:45', '2026-05-23 06:50:45'),
(134, 42, 12, 'Bosch 12V Max 3/8\" Drill Driver', 'BOS-GSR12V-140', 1, '109.99', '109.99', '2026-05-23 06:50:45', '2026-05-23 06:50:45'),
(135, 42, 26, '3M V5 Safety Goggles', '3M-V5-GOGGLE', 4, '19.99', '79.96', '2026-05-23 06:50:45', '2026-05-23 06:50:45'),
(136, 42, 50, 'Stanley 12\" Quick-Grip Bar Clamp', 'STN-12IN-CLAMP', 2, '24.99', '49.98', '2026-05-23 06:50:45', '2026-05-23 06:50:45'),
(137, 43, 47, 'Stanley 200-Piece Stainless Screw Assortment', 'STN-200-SS-SCR', 3, '24.99', '74.97', '2026-05-09 11:07:45', '2026-05-09 11:07:45'),
(138, 43, 32, 'Stanley 20-Piece Saw Blade Set', 'STN-20-600-BLADE', 1, '39.99', '39.99', '2026-05-09 11:07:45', '2026-05-09 11:07:45'),
(139, 43, 49, '3M High-Visibility Safety Vest Class 2', '3M-SFTY-VEST-HI', 1, '19.99', '19.99', '2026-05-09 11:07:45', '2026-05-09 11:07:45'),
(140, 43, 43, 'Bosch PS31 12V Max 3/8\" Impact Wrench', 'BOS-PS31-2', 4, '149.99', '599.96', '2026-05-09 11:07:45', '2026-05-09 11:07:45'),
(141, 44, 26, '3M V5 Safety Goggles', '3M-V5-GOGGLE', 1, '19.99', '19.99', '2026-04-30 12:48:45', '2026-04-30 12:48:45'),
(142, 44, 34, 'Stanley Heavy-Duty Hex Bolt Assortment', 'STN-100-HD-BOLT', 1, '39.99', '39.99', '2026-04-30 12:48:45', '2026-04-30 12:48:45'),
(143, 44, 46, 'Makita 14\" Cut-Off Saw', 'MKT-UC4051A', 3, '399.99', '1199.97', '2026-04-30 12:48:45', '2026-04-30 12:48:45'),
(144, 44, 9, 'DeWalt 20V Max XR Hammer Drill', 'DWT-DCD999B', 1, '239.99', '239.99', '2026-04-30 12:48:45', '2026-04-30 12:48:45'),
(145, 45, 39, 'Stanley TB300 Tool Backpack', 'STN-TB300-ORG', 1, '79.99', '79.99', '2026-05-06 10:13:45', '2026-05-06 10:13:45'),
(146, 45, 55, 'Stanley 100-Pack Heavy-Duty Latch Kit', 'STN-LG100-LATCH', 3, '34.99', '104.97', '2026-05-06 10:13:45', '2026-05-06 10:13:45'),
(147, 45, 13, 'DeWalt 20V Max 7-1/4\" Circular Saw', 'DWT-DCS570B', 2, '199.99', '399.98', '2026-05-06 10:13:45', '2026-05-06 10:13:45'),
(148, 45, 25, '3M P100 Particulate Filter Pair', '3M-2091-P100', 2, '12.99', '25.98', '2026-05-06 10:13:45', '2026-05-06 10:13:45'),
(149, 45, 37, 'Lincoln Electric ED031223 Weld Pack 125', 'LIN-ED031223', 4, '399.99', '1599.96', '2026-05-06 10:13:45', '2026-05-06 10:13:45'),
(150, 46, 49, '3M High-Visibility Safety Vest Class 2', '3M-SFTY-VEST-HI', 3, '19.99', '59.97', '2026-05-03 05:44:45', '2026-05-03 05:44:45'),
(151, 47, 32, 'Stanley 20-Piece Saw Blade Set', 'STN-20-600-BLADE', 4, '39.99', '159.96', '2026-05-09 08:23:45', '2026-05-09 08:23:45'),
(152, 47, 10, 'Milwaukee M18 Fuel Impact Driver', 'MLW-2861-20', 4, '199.99', '799.96', '2026-05-09 08:23:45', '2026-05-09 08:23:45'),
(153, 47, 30, 'Bosch CL700K Jigsaw', 'BOS-CL700-JIG', 3, '159.99', '479.97', '2026-05-09 08:23:45', '2026-05-09 08:23:45'),
(154, 47, 7, 'Lincoln Electric 210 MP Multiprocess Welder', 'LIN-210-MIG', 1, '1149.99', '1149.99', '2026-05-09 08:23:45', '2026-05-09 08:23:45'),
(155, 48, 23, 'Stanley 48\" Aluminum Level', 'STN-48IN-LVL', 2, '49.99', '99.98', '2026-05-22 12:02:45', '2026-05-22 12:02:45'),
(156, 48, 7, 'Lincoln Electric 210 MP Multiprocess Welder', 'LIN-210-MIG', 4, '1149.99', '4599.96', '2026-05-22 12:02:45', '2026-05-22 12:02:45'),
(157, 48, 11, 'Makita XGT 40V Angle Grinder', 'MKT-XGT40-GR', 3, '329.99', '989.97', '2026-05-22 12:02:45', '2026-05-22 12:02:45'),
(158, 49, 18, 'Snap-On 80-Piece Screwdriver Set', 'SNP-TK80-SCRW', 2, '399.99', '799.98', '2026-05-04 12:38:45', '2026-05-04 12:38:45'),
(159, 49, 44, 'Snap-On 10\" Flat Pry Bar', 'SNP-BP100-PRY', 4, '59.99', '239.96', '2026-05-04 12:38:45', '2026-05-04 12:38:45'),
(160, 50, 55, 'Stanley 100-Pack Heavy-Duty Latch Kit', 'STN-LG100-LATCH', 4, '34.99', '139.96', '2026-05-07 04:27:45', '2026-05-07 04:27:45'),
(161, 50, 28, '3M GL80 Nitrile Work Gloves (12-Pack)', '3M-GL80-GLOV', 2, '39.99', '79.98', '2026-05-07 04:27:45', '2026-05-07 04:27:45'),
(162, 50, 23, 'Stanley 48\" Aluminum Level', 'STN-48IN-LVL', 1, '49.99', '49.99', '2026-05-07 04:27:45', '2026-05-07 04:27:45'),
(163, 51, 1, 'DeWalt 20V Max Cordless Drill', 'DWT-20V-DRL', 1, '169.99', '169.99', '2026-05-31 20:33:06', '2026-05-31 20:33:06'),
(164, 52, 25, '3M P100 Particulate Filter Pair', '3M-2091-P100', 1, '12.99', '12.99', '2026-05-31 20:55:18', '2026-05-31 20:55:18'),
(165, 52, 21, 'Makita E-10181 Utility Knife', 'MKT-E-10181', 1, '16.99', '16.99', '2026-05-31 20:55:18', '2026-05-31 20:55:18'),
(166, 52, 35, 'Stanley 50-Pack Toggle Bolt Kit', 'STN-50-TOG-KIT', 1, '16.99', '16.99', '2026-05-31 20:55:18', '2026-05-31 20:55:18'),
(167, 53, 6, 'Makita 7-1/4\" Circular Saw', 'MKT-LXT-7CIRC', 1, '149.99', '149.99', '2026-05-31 21:29:45', '2026-05-31 21:29:45'),
(168, 53, 9, 'DeWalt 20V Max XR Hammer Drill', 'DWT-DCD999B', 1, '239.99', '239.99', '2026-05-31 21:29:45', '2026-05-31 21:29:45'),
(169, 54, 11, 'Makita XGT 40V Angle Grinder', 'MKT-XGT40-GR', 1, '329.99', '329.99', '2026-05-31 21:41:20', '2026-05-31 21:41:20'),
(171, 56, 25, '3M P100 Particulate Filter Pair', '3M-2091-P100', 1, '12.99', '12.99', '2026-06-01 09:07:06', '2026-06-01 09:07:06'),
(172, 57, 21, 'Makita E-10181 Utility Knife', 'MKT-E-10181', 1, '16.99', '16.99', '2026-06-01 09:09:36', '2026-06-01 09:09:36'),
(173, 58, 1, 'DeWalt 20V Max Cordless Drill', 'DWT-20V-DRL', 1, '169.99', '169.99', '2026-06-01 10:21:39', '2026-06-01 10:21:39'),
(174, 59, 4, 'Bosch GLL100 Self-Leveling Cross-Line Laser', 'BOS-GLL100-LASER', 1, '299.99', '299.99', '2026-06-01 10:23:32', '2026-06-01 10:23:32'),
(175, 60, 12, 'Bosch 12V Max 3/8\" Drill Driver', 'BOS-GSR12V-140', 1, '109.99', '109.99', '2026-06-01 10:26:21', '2026-06-01 10:26:21'),
(176, 65, 13, 'DeWalt 20V Max 7-1/4&quot; Circular Saw', 'DWT-DCS570B', 1, '199.99', '199.99', '2026-07-15 02:59:42', '2026-07-15 02:59:42'),
(177, 65, 12, 'Bosch 12V Max 3/8&quot; Drill Driver', 'BOS-GSR12V-140', 1, '109.99', '109.99', '2026-07-15 02:59:42', '2026-07-15 02:59:42'),
(178, 65, 9, 'DeWalt 20V Max XR Hammer Drill', 'DWT-DCD999B', 1, '239.99', '239.99', '2026-07-15 02:59:42', '2026-07-15 02:59:42'),
(179, 66, 15, 'Stanley 20V Cordless Glue Gun', 'STN-SBL20V-GLUE', 1, '59.99', '59.99', '2026-07-15 03:51:38', '2026-07-15 03:51:38'),
(180, 67, 21, 'Makita E-10181 Utility Knife', 'MKT-E-10181', 1, '16.99', '16.99', '2026-07-15 07:52:27', '2026-07-15 07:52:27'),
(181, 68, 21, 'Makita E-10181 Utility Knife', 'MKT-E-10181', 1, '16.99', '16.99', '2026-07-15 10:00:20', '2026-07-15 10:00:20'),
(182, 68, 17, 'Stanley 16oz Curved Claw Hammer', 'STN-16OZ-HMR', 1, '29.99', '29.99', '2026-07-15 10:00:20', '2026-07-15 10:00:20'),
(183, 68, 2, 'Milwaukee 12&quot; Compound Miter Saw', 'MLW-12A-SAW', 1, '549.99', '549.99', '2026-07-15 10:00:20', '2026-07-15 10:00:20'),
(184, 69, 19, 'Stanley 25ft PowerLock Tape Measure', 'STN-25FT-TAPE', 1, '19.99', '19.99', '2026-07-15 10:35:54', '2026-07-15 10:35:54'),
(185, 70, 45, 'Stanley 100ft Fiberglass Long Tape', 'STN-100SQ-SPEED', 1, '34.99', '34.99', '2026-07-15 10:41:47', '2026-07-15 10:41:47');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `payment_gateway` varchar(50) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `currency` varchar(10) NOT NULL DEFAULT 'USD',
  `status` varchar(50) NOT NULL DEFAULT 'Pending',
  `paid_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `order_id`, `transaction_id`, `payment_gateway`, `amount`, `currency`, `status`, `paid_at`, `created_at`, `updated_at`) VALUES
(1, 66, 'pi_3TtJrACXbPPKAWay0hmybGQI', 'stripe', '74.78', 'USD', 'Paid', '2026-07-15 03:51:38', '2026-07-15 03:51:38', '2026-07-15 03:51:38'),
(2, 67, '7R285489EC427573W', 'paypal', '28.34', 'USD', 'Paid', '2026-07-15 07:52:27', '2026-07-15 07:52:27', '2026-07-15 07:52:27'),
(3, 69, 'pi_3TtQAOCXbPPKAWay0O01vObA', 'stripe', '31.58', 'USD', 'Paid', '2026-07-15 10:35:54', '2026-07-15 10:35:54', '2026-07-15 10:35:54'),
(4, 70, '7YH72602C8439080W', 'paypal', '47.78', 'USD', 'Paid', '2026-07-15 10:41:47', '2026-07-15 10:41:47', '2026-07-15 10:41:47');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `sku` varchar(100) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `short_description` text,
  `description` text,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `sale_price` decimal(10,2) DEFAULT NULL,
  `cost_price` decimal(10,2) DEFAULT NULL,
  `weight` decimal(10,2) DEFAULT NULL,
  `dimensions` varchar(255) DEFAULT NULL,
  `stock_quantity` int(11) NOT NULL DEFAULT '0',
  `minimum_stock` int(11) NOT NULL DEFAULT '5',
  `featured` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `brand_id`, `sku`, `name`, `slug`, `short_description`, `description`, `price`, `sale_price`, `cost_price`, `weight`, `dimensions`, `stock_quantity`, `minimum_stock`, `featured`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'DWT-20V-DRL', 'DeWalt 20V Max Cordless Drill&amp;#039;', 'dewalt-20v-max-cordless-drill', 'The DeWalt 20V Max cordless drill features a brushless motor for maximum efficiency and runtime. Includes 1/2\\&amp;quot; ratcheting chuck, LED work light, and ergonomic handle design.', 'The DeWalt 20V Max cordless drill features a brushless motor for maximum efficiency and runtime. Includes 1/2\\\" ratcheting chuck, LED work light, and ergonomic handle design.', '199.00', '199.00', '199.00', NULL, '', 99, 100, 0, 1, '2026-07-13 11:41:27', '2026-07-13 11:41:54'),
(2, 1, 2, 'MLW-12A-SAW', 'Milwaukee 12&quot; Compound Miter Saw', 'milwaukee-12-compound-miter-saw', 'Dual-bevel sliding compound miter saw', 'The Milwaukee 12\" dual-bevel sliding compound miter saw delivers precise cuts with its powerful 15-amp motor. Features dual bevel capacity, laser guide system, and durable steel construction.', '599.99', '549.99', '380.00', '45.00', '30 x 25 x 20 in', 30, 5, 1, 1, '2026-05-28 18:23:44', '2026-07-13 12:27:21'),
(3, 2, 5, 'SNP-6PC-WRENCH', 'Snap-On 6-Piece Combination Wrench Set', 'snap-on-6-piece-combination-wrench-set', 'Professional grade combination wrench set', 'Premium Snap-On combination wrench set featuring chrome vanadium steel construction with mirror finish. Set includes 6 SAE sizes from 3/8\" to 3/4\".', '249.99', NULL, '155.00', '2.50', '10 x 6 x 1 in', 75, 10, 0, 1, '2026-05-28 18:23:44', '2026-05-28 18:23:44'),
(4, 3, 4, 'BOS-GLL100-LASER', 'Bosch GLL100 Self-Leveling Cross-Line Laser', 'bosch-gll100-self-leveling-cross-line-laser', 'Professional self-leveling laser for precise layout', 'The Bosch GLL100 is a professional-grade self-leveling cross-line laser with 100-foot range. Features dual-slope mode for grading applications and IP54 dust/water protection.', '349.99', '299.99', '210.00', '1.80', '8 x 6 x 4 in', 40, 8, 0, 1, '2026-05-28 18:23:44', '2026-05-28 18:23:44'),
(5, 4, 7, '3M-6800-RESP', '3M 6800 Half Facepiece Reusable Respirator', '3m-6800-half-facepiece-reusable-respirator', 'Comfortable reusable respirator for industrial environments', 'The 3M 6800 half facepiece reusable respirator provides reliable respiratory protection. Features silicone face seal for comfort, dual cartridge design, and low profile for use with other PPE.', '49.99', NULL, '28.00', '0.60', '6 x 5 x 4 in', 200, 50, 0, 1, '2026-05-28 18:23:44', '2026-05-28 18:23:44'),
(6, 5, 3, 'MKT-LXT-7CIRC', 'Makita 7-1/4&quot; Circular Saw', 'makita-7-1-4-circular-saw', 'Lightweight yet powerful corded circular saw', 'The Makita 7-1/4\" circular saw features a 15-amp motor delivering 5,800 RPM. Magnesium construction makes it lightweight at only 10.5 lbs. Ideal for framing and general construction.', '179.99', '149.99', '100.00', '10.50', '18 x 12 x 10 in', 60, 12, 1, 1, '2026-05-28 18:23:44', '2026-07-13 12:31:27'),
(7, 7, 8, 'LIN-210-MIG', 'Lincoln Electric 210 MP Multiprocess Welder', 'lincoln-electric-210-mp-multiprocess-welder', 'Versatile multiprocess welder for shop and field', 'The Lincoln Electric 210 MP is a multipurpose welding machine capable of MIG, TIG, stick, and flux-cored welding. Features InfiniteDrive wire drive system and runs on standard 120V or 230V input power.', '1299.99', '1149.99', '820.00', '68.00', '24 x 18 x 22 in', 15, 3, 1, 1, '2026-05-28 18:23:44', '2026-05-28 18:23:44'),
(8, 3, 3, 'STN-26IN-TCHEST', 'Stanley 26&quot; Tool Chest Combo', 'stanley-26-tool-chest-combo', 'Heavy-duty rolling tool chest and cabinet combo', 'The Stanley 26\" tool chest combo features a ball-bearing slide drawer system, lockable cabinets, and a 1,200 lb total weight capacity. Perfect for professional workshops and job sites.', '399.99', '349.99', '240.00', '120.00', '30 x 18 x 40 in', 25, 5, 0, 1, '2026-05-28 18:23:44', '2026-07-13 12:32:46'),
(9, 1, 1, 'DWT-DCD999B', 'DeWalt 20V Max XR Hammer Drill', 'dewalt-20v-max-xr-hammer-drill', 'High-performance hammer drill with anti-rotation technology', 'The DeWalt DCD999B 20V Max XR hammer drill delivers 820 UWO of power. Features anti-rotation technology for user safety, 3-speed all-metal transmission, and a brushless motor.', '279.99', '239.99', '170.00', '4.20', '11 x 9 x 5 in', 85, 15, 0, 1, '2026-05-28 18:23:44', '2026-05-28 18:23:44'),
(10, 1, 2, 'MLW-2861-20', 'Milwaukee M18 Fuel Impact Driver', 'milwaukee-m18-fuel-impact-driver', 'Compact impact driver with 2,000 ft-lbs of torque', 'The Milwaukee 2861-20 M18 Fuel impact driver delivers 2,000 ft-lbs of torque in the most compact package. Features a 4-pole motor and RedLink Plus intelligence.', '229.99', '199.99', '140.00', '2.80', '8 x 7 x 3 in', 110, 20, 0, 1, '2026-05-28 18:23:44', '2026-05-28 18:23:44'),
(11, 1, 3, 'MKT-XGT40-GR', 'Makita XGT 40V Angle Grinder', 'makita-xgt-40v-angle-grinder', 'Powerful cordless angle grinder with XGT technology', 'The Makita XGT 40V angle grinder delivers pro-level grinding performance with a brushless motor. Features anti-restart protection, soft-start, and automatic speed control under load.', '329.99', NULL, '210.00', '6.50', '18 x 6 x 5 in', 45, 10, 0, 1, '2026-05-28 18:23:44', '2026-05-28 18:23:44'),
(12, 1, 4, 'BOS-GSR12V-140', 'Bosch 12V Max 3/8&quot; Drill Driver', 'bosch-12v-max-3-8-drill-driver', 'Compact 12V drill driver for tight spaces', 'The Bosch GSR12V-140 is a compact 12V Max drill driver with 265 in-lbs of torque. Its ergonomic design fits into tight spaces, making it ideal for cabinet work and electrical installations.', '129.99', '109.99', '78.00', '2.20', '9 x 7 x 3 in', 90, 15, 0, 1, '2026-05-28 18:23:44', '2026-07-13 12:40:23'),
(13, 1, 1, 'DWT-DCS570B', 'DeWalt 20V Max 7-1/4&quot; Circular Saw', 'dewalt-20v-max-7-1-4-circular-saw', 'Cordless circular saw with 6,000 RPM brushless motor', 'The DeWalt DCS570B 20V Max circular saw features a brushless motor delivering up to 6,000 RPM. Includes a rafter hook, electric brake, and die-cast magnesium shoe for durability.', '229.99', '199.99', '140.00', '10.20', '19 x 14 x 10 in', 55, 10, 1, 1, '2026-05-28 18:23:44', '2026-07-13 12:41:04'),
(14, 1, 2, 'MLW-2722-21', 'Milwaukee M18 Fuel Sawzall Recip Saw', 'milwaukee-m18-fuel-sawzall-recip-saw', 'Heavy-duty reciprocating saw with 1-1/8&quot; stroke', 'The Milwaukee 2722-21 M18 Fuel Sawzall delivers up to 3,000 SPM with a 1-1/8 inch stroke. Features a one-key tool tracking system, adjustable shoe, and vibration control.', '299.99', '269.99', '185.00', '8.50', '20 x 8 x 6 in', 40, 8, 0, 1, '2026-05-28 18:23:44', '2026-07-13 12:46:35'),
(15, 1, 5, 'STN-SBL20V-GLUE', 'Stanley 20V Cordless Glue Gun', 'stanley-20v-cordless-glue-gun', 'Cordless glue gun for quick adhesive applications', 'The Stanley 20V cordless glue gun provides cordless convenience for woodworking, crafting, and repairs. Heats up in 60 seconds and uses standard 7/16 inch glue sticks.', '69.99', '59.99', '38.00', '1.50', '10 x 4 x 3 in', 120, 25, 0, 1, '2026-05-28 18:23:44', '2026-05-28 18:23:44'),
(16, 2, 5, 'SNP-3PC-PLYRS', 'Snap-On 3-Piece Pliers Set', 'snap-on-3-piece-pliers-set', 'Professional pliers set with ergonomic grips', 'The Snap-On 3-piece pliers set includes slip-joint, long-nose, and diagonal cutting pliers. Forged from high-carbon steel with induction-hardened cutting edges and cushioned grips.', '189.99', NULL, '115.00', '2.00', '12 x 6 x 2 in', 60, 10, 0, 1, '2026-05-28 18:23:44', '2026-05-28 18:23:44'),
(17, 2, 5, 'STN-16OZ-HMR', 'Stanley 16oz Curved Claw Hammer', 'stanley-16oz-curved-claw-hammer', 'Classic curved claw hammer with forged steel head', 'The Stanley 16oz curved claw hammer features a fully polished forged steel head with a curved claw for pulling nails. The fiberglass handle with rubber grip reduces vibration and fatigue.', '34.99', '29.99', '18.00', '1.20', '13 x 4 x 2 in', 200, 40, 0, 1, '2026-05-28 18:23:44', '2026-05-28 18:23:44'),
(18, 2, 5, 'SNP-TK80-SCRW', 'Snap-On 80-Piece Screwdriver Set', 'snap-on-80-piece-screwdriver-set', 'Comprehensive screwdriver kit for every application', 'The Snap-On 80-piece screwdriver set includes Phillips, flathead, Torx, and hex drivers in both standard and precision sizes. Features color-coded handles for quick identification.', '449.99', '399.99', '280.00', '5.50', '18 x 12 x 3 in', 20, 5, 0, 1, '2026-05-28 18:23:44', '2026-05-28 18:23:44'),
(19, 2, 5, 'STN-25FT-TAPE', 'Stanley 25ft PowerLock Tape Measure', 'stanley-25ft-powerlock-tape-measure', 'Durable 25ft tape measure with blade lock', 'The Stanley 25ft PowerLock tape measure features a Mylar-coated blade for durability, a true-zero hook for accurate measurements, and a blade lock for steady readings.', '24.99', '19.99', '12.00', '0.80', '4 x 3 x 3 in', 300, 50, 0, 1, '2026-05-28 18:23:44', '2026-05-28 18:23:44'),
(20, 2, 1, 'DWT-10IN-WRENCH', 'DeWalt Adjustable Wrench 10&quot;', 'dewalt-adjustable-wrench-10', 'Heavy-duty adjustable wrench with laser-etched scale', 'The DeWalt 10-inch adjustable wrench features a heavy-duty forged steel construction with a laser-etched measurement scale. The rust-resistant chrome finish provides durability on the job site.', '44.99', NULL, '26.00', '1.10', '10 x 3 x 1 in', 95, 20, 0, 1, '2026-05-28 18:23:44', '2026-07-13 12:51:49'),
(21, 2, 3, 'MKT-E-10181', 'Makita E-10181 Utility Knife', 'makita-e-10181-utility-knife', 'Retractable utility knife with auto-lock mechanism', 'The Makita E-10181 utility knife features a heavy-duty cast aluminum body with a quick-change blade system. The auto-lock mechanism keeps the blade secure during cutting operations.', '19.99', '16.99', '10.00', '0.40', '7 x 2 x 1 in', 250, 40, 0, 1, '2026-05-28 18:23:44', '2026-05-28 18:23:44'),
(22, 3, 4, 'BOS-GLM50C', 'Bosch GLM50C Bluetooth Laser Measure', 'bosch-glm50c-bluetooth-laser-measure', 'Smart laser measure with Bluetooth connectivity', 'The Bosch GLM50C digital laser measure with Bluetooth connects to your smartphone for easy measurement documentation. Measures up to 165 ft with ±1/16 inch accuracy.', '179.99', '159.99', '105.00', '0.50', '5 x 3 x 2 in', 70, 12, 0, 1, '2026-05-28 18:23:44', '2026-05-28 18:23:44'),
(23, 3, 5, 'STN-48IN-LVL', 'Stanley 48&quot; Aluminum Level', 'stanley-48-aluminum-level', 'Professional aluminum level with shock-absorbing ends', 'The Stanley 48-inch aluminum level features a durable aluminum frame with shock-absorbing rubber end caps. Includes three vials (vertical, horizontal, 45-degree) with magnified viewing.', '59.99', '49.99', '32.00', '3.50', '48 x 4 x 2 in', 80, 15, 0, 1, '2026-05-28 18:23:44', '2026-07-13 22:30:05'),
(24, 3, 5, '3M-PRO-LEVEL', '3M ProGrade Laser Level Kit', '3m-prograde-laser-level-kit', 'Self-leveling cross-line laser with tripod', 'The 3M ProGrade self-leveling cross-line laser projects bright horizontal and vertical lines. Kit includes a lightweight tripod, carrying case, and laser target plate.', '219.99', NULL, '140.00', '4.00', '12 x 10 x 6 in', 35, 8, 0, 1, '2026-05-28 18:23:44', '2026-05-28 18:23:44'),
(25, 4, 5, '3M-2091-P100', '3M P100 Particulate Filter Pair', '3m-p100-particulate-filter-pair', 'High-efficiency particulate filters for 6000 series respirators', 'The 3M 2091 P100 particulate filters offer 99.97% filtration efficiency against oil and non-oil based particulates. Compatible with 3M 6000 series half and full facepiece respirators.', '14.99', '12.99', '7.00', '0.20', '4 x 4 x 2 in', 500, 100, 0, 1, '2026-05-28 18:23:44', '2026-05-28 18:23:44'),
(26, 4, 5, '3M-V5-GOGGLE', '3M V5 Safety Goggles', '3m-v5-safety-goggles', 'Anti-fog safety goggles with wide vision', 'The 3M V5 safety goggles feature an anti-fog coating, wide panoramic lens, and adjustable head strap. Meets ANSI Z87.1 impact standards for industrial environments.', '24.99', '19.99', '12.00', '0.30', '7 x 4 x 3 in', 350, 60, 0, 1, '2026-05-28 18:23:44', '2026-05-28 18:23:44'),
(27, 4, 5, '3M-1425-EAR', '3M 1425 Earmuffs (26dB NRR)', '3m-1425-earmuffs-26db-nrr', 'Over-the-head earmuffs with 26dB noise reduction', 'The 3M 1425 earmuffs provide 26dB noise reduction rating (NRR) with a lightweight design. Features cushioned ear cups, adjustable headband, and fold-away design for convenient storage.', '29.99', '24.99', '16.00', '0.70', '8 x 6 x 4 in', 180, 30, 0, 1, '2026-05-28 18:23:44', '2026-05-28 18:23:44'),
(28, 4, 5, '3M-GL80-GLOV', '3M GL80 Nitrile Work Gloves (12-Pack)', '3m-gl80-nitrile-work-gloves-12-pack', 'Heavy-duty nitrile gloves for industrial tasks', 'The 3M GL80 nitrile work gloves provide excellent puncture resistance and grip in wet or dry conditions. Flock-lined for comfort, these gloves are ideal for handling oily parts and general maintenance.', '39.99', NULL, '22.00', '1.50', '10 x 6 x 2 in', 220, 40, 0, 1, '2026-05-28 18:23:44', '2026-05-28 18:23:44'),
(29, 5, 1, 'DWT-DW872', 'DeWalt 14&quot; Chop Saw', 'dewalt-14-chop-saw', 'Abrasive chop saw for metal cutting', 'The DeWalt DW872 14-inch chop saw features a 15-amp motor delivering 4,000 RPM. Includes a quick-release vise, adjustable fence, and durable steel base for heavy-duty metal cutting.', '399.99', '359.99', '250.00', '38.00', '20 x 14 x 16 in', 30, 5, 0, 1, '2026-05-28 18:23:44', '2026-07-13 22:38:09'),
(30, 5, 4, 'BOS-CL700-JIG', 'Bosch CL700K Jigsaw', 'bosch-cl700k-jigsaw', 'Barrel-grip jigsaw with constant response circuitry', 'The Bosch CL700K barrel-grip jigsaw features constant response circuitry for consistent speed under load. Includes a Smart Blade System for tool-less blade changes and an adjustable dust blower.', '179.99', '159.99', '108.00', '5.20', '12 x 8 x 5 in', 50, 10, 0, 1, '2026-05-28 18:23:44', '2026-05-28 18:23:44'),
(31, 5, 3, 'MKT-LS1019L', 'Makita 10&quot; Compound Miter Saw', 'makita-10-compound-miter-saw', 'Compact 10&quot; miter saw with laser guide', 'The Makita LS1019L 10-inch dual-slide compound miter saw features a 13-amp motor with 3,200 RPM. The direct drive gear system delivers efficient power transfer and consistent cuts.', '499.99', '449.99', '310.00', '42.00', '28 x 22 x 18 in', 25, 4, 1, 1, '2026-05-28 18:23:44', '2026-07-13 22:47:19'),
(32, 5, 5, 'STN-20-600-BLADE', 'Stanley 20-Piece Saw Blade Set', 'stanley-20-piece-saw-blade-set', 'Versatile saw blade assortment for wood and metal', 'The Stanley 20-piece saw blade set includes a variety of carbide-tipped circular saw blades, reciprocating blades, and jigsaw blades. Covers most common cutting tasks in wood, metal, and plastic.', '49.99', '39.99', '25.00', '2.00', '10 x 8 x 1 in', 140, 25, 0, 1, '2026-05-28 18:23:44', '2026-05-28 18:23:44'),
(33, 6, 5, 'STN-SHR25-NAIL', 'Stanley 25-Pack Shear Nails', 'stanley-25-pack-shear-nails', 'High-strength shear nails for heavy timber connections', 'The Stanley 25-pack shear nails feature S5 grade steel with hot-dip galvanized finish for corrosion resistance. Designed for structural timber connections in commercial and residential construction.', '89.99', NULL, '54.00', '5.00', '8 x 6 x 4 in', 70, 15, 0, 1, '2026-05-28 18:23:44', '2026-05-28 18:23:44'),
(34, 6, 5, 'STN-100-HD-BOLT', 'Stanley Heavy-Duty Hex Bolt Assortment', 'stanley-heavy-duty-hex-bolt-assortment', '100-piece hex bolt assortment in storage case', 'The Stanley 100-piece hex bolt assortment includes Grade 5 steel bolts in 10 common sizes from 1/4 to 3/4 inch. Packaged in a compartmentalized storage case for organization.', '44.99', '39.99', '25.00', '3.50', '10 x 7 x 2 in', 160, 30, 0, 1, '2026-05-28 18:23:44', '2026-05-28 18:23:44'),
(35, 6, 5, 'STN-50-TOG-KIT', 'Stanley 50-Pack Toggle Bolt Kit', 'stanley-50-pack-toggle-bolt-kit', 'Assorted toggle bolts for drywall and hollow walls', 'The Stanley 50-pack toggle bolt kit includes spring-toggle and strap-toggle bolts in various sizes for mounting fixtures to drywall and hollow wall surfaces. Each bolt supports up to 50 lbs.', '19.99', '16.99', '10.00', '1.20', '6 x 4 x 2 in', 200, 40, 0, 1, '2026-05-28 18:23:44', '2026-05-28 18:23:44'),
(36, 7, 5, 'LIN-VIP-PKG', 'Lincoln Electric Viking 3350 Welding Helmet', 'lincoln-electric-viking-3350-welding-helmet', 'Auto-darkening welding helmet with 4C lens', 'The Lincoln Electric Viking 3350 features a 4C lens technology providing true color perception. Auto-darkening from shade 5 to 13, with four sensors and adjustable sensitivity/delay controls.', '349.99', '299.99', '215.00', '2.20', '12 x 10 x 8 in', 40, 8, 0, 1, '2026-05-28 18:23:44', '2026-05-28 18:23:44'),
(37, 7, 5, 'LIN-ED031223', 'Lincoln Electric ED031223 Weld Pack 125', 'lincoln-electric-ed031223-weld-pack-125', 'Entry-level flux-cored wire welder', 'The Lincoln Electric Weld Pack 125 is an easy-to-use flux-cored wire welder for home and light industrial use. Runs on standard 120V power, welds up to 1/4 inch mild steel.', '449.99', '399.99', '275.00', '55.00', '20 x 14 x 16 in', 25, 5, 0, 1, '2026-05-28 18:23:44', '2026-05-28 18:23:44'),
(38, 7, 3, 'MKT-WS-1500', 'Makita 1500W Hot Air Welding Gun', 'makita-1500w-hot-air-welding-gun', 'Professional hot air welder for plastic welding', 'The Makita 1500W hot air welding gun delivers adjustable temperature control from 50°C to 600°C for plastic welding, shrink tubing, and stripping applications. Overheat protection included.', '159.99', '139.99', '95.00', '2.00', '12 x 8 x 5 in', 45, 10, 0, 1, '2026-05-28 18:23:44', '2026-05-28 18:23:44'),
(39, 8, 5, 'STN-TB300-ORG', 'Stanley TB300 Tool Backpack', 'stanley-tb300-tool-backpack', 'Heavy-duty tool backpack with organized storage', 'The Stanley TB300 tool backpack features 38 pockets, a padded laptop compartment, and a reinforced base. Made from 600D polyester with water-resistant coating for job site durability.', '89.99', '79.99', '50.00', '4.50', '20 x 14 x 10 in', 65, 12, 0, 1, '2026-05-28 18:23:44', '2026-05-28 18:23:44'),
(40, 8, 1, 'DWT-DWST1-75334', 'DeWalt TSTAK Tool Box', 'dewalt-tstak-tool-box', 'Modular stacking tool box with TSTAK system', 'The DeWalt TSTAK tool box is part of a modular storage system that allows stacking and interlocking with other TSTAK units. Features a metal latch, bi-material handle, and removable tray.', '69.99', '59.99', '38.00', '6.00', '22 x 15 x 11 in', 90, 18, 0, 1, '2026-05-28 18:23:44', '2026-05-28 18:23:44'),
(41, 8, 2, 'MLW-48-22-8420', 'Milwaukee Packout 3-Piece Set', 'milwaukee-packout-3-piece-set', 'Modular Packout storage system starter set', 'The Milwaukee Packout 3-piece set includes a rolling tool box, drawer box, and organizer. The interlocking system allows secure stacking and transport of tools to any job site.', '349.99', '319.99', '220.00', '35.00', '30 x 22 x 24 in', 30, 5, 1, 1, '2026-05-28 18:23:44', '2026-05-28 18:23:44'),
(42, 8, 3, 'MKT-E-15345', 'Makita E-15345 Tool Bag', 'makita-e-15345-tool-bag', 'Large-capacity tool bag with reinforced base', 'The Makita E-15345 tool bag features a large main compartment with multiple interior and exterior pockets. Constructed from heavy-duty canvas with a reinforced base and padded handles.', '54.99', NULL, '32.00', '3.00', '18 x 12 x 12 in', 75, 15, 0, 1, '2026-05-28 18:23:44', '2026-05-28 18:23:44'),
(43, 1, 4, 'BOS-PS31-2', 'Bosch PS31 12V Max 3/8&quot; Impact Wrench', 'bosch-ps31-12v-max-3-8-impact-wrench', 'Compact 12V impact wrench for automotive work', 'The Bosch PS31 12V Max impact wrench delivers 800 in-lbs of torque in a compact 5.5 inch package. Ideal for working in confined spaces under the hood or inside cabinets.', '169.99', '149.99', '100.00', '2.50', '9 x 7 x 3 in', 55, 10, 0, 1, '2026-05-28 18:23:44', '2026-07-13 23:21:51'),
(44, 2, 5, 'SNP-BP100-PRY', 'Snap-On 10&quot; Flat Pry Bar', 'snap-on-10-flat-pry-bar', 'Forged steel pry bar with ergonomic grip', 'The Snap-On 10-inch flat pry bar is forged from high-carbon steel for maximum strength. The ergonomic grip handle reduces hand fatigue, and the angled tip provides optimal leverage.', '59.99', NULL, '36.00', '1.00', '10 x 2 x 1 in', 85, 15, 0, 1, '2026-05-28 18:23:44', '2026-07-13 23:22:54'),
(45, 3, 5, 'STN-100SQ-SPEED', 'Stanley 100ft Fiberglass Long Tape', 'stanley-100ft-fiberglass-long-tape', 'Long fiberglass tape measure for layout work', 'The Stanley 100ft fiberglass long tape features a durable fiberglass blade, folding handle, and a belt clip. Ideal for surveying, landscaping, and large-scale layout projects.', '39.99', '34.99', '22.00', '1.50', '6 x 6 x 4 in', 65, 12, 0, 1, '2026-05-28 18:23:44', '2026-05-28 18:23:44'),
(46, 5, 3, 'MKT-UC4051A', 'Makita 14&quot; Cut-Off Saw', 'makita-14-cut-off-saw', 'Heavy-duty cut-off saw for metal and masonry', 'The Makita UC4051A 14-inch cut-off saw features a 15-amp motor with 3,800 RPM. The sealed ball-bearing construction ensures durability, and the vise securely holds material at various angles.', '449.99', '399.99', '275.00', '42.00', '22 x 15 x 18 in', 20, 4, 0, 1, '2026-05-28 18:23:44', '2026-07-13 23:24:16'),
(47, 6, 5, 'STN-200-SS-SCR', 'Stanley 200-Piece Stainless Screw Assortment', 'stanley-200-piece-stainless-screw-assortment', 'Stainless steel screw assortment in organizer case', 'The Stanley 200-piece stainless steel screw assortment includes Phillips and Torx drive screws in #6, #8, #10, #12 sizes. Packaged in a compartmentalized case with size labels.', '29.99', '24.99', '16.00', '2.50', '9 x 6 x 2 in', 180, 35, 0, 1, '2026-05-28 18:23:44', '2026-05-28 18:23:44'),
(48, 7, 8, 'LIN-KF25-MIG', 'Lincoln Electric KF25 MIG Welding Wire 2lb', 'lincoln-electric-kf25-mig-welding-wire-2lb', 'Premium MIG welding wire for clean welds', 'The Lincoln Electric KF25 0.035 inch MIG welding wire provides smooth feeding and consistent arc characteristics. Copper-coated for corrosion resistance, suitable for mild steel fabrication.', '19.99', '16.99', '11.00', '2.50', '8 x 3 x 3 in', 300, 60, 0, 1, '2026-05-28 18:23:44', '2026-05-28 18:23:44'),
(49, 4, 7, '3M-SFTY-VEST-HI', '3M High-Visibility Safety Vest Class 2', '3m-high-visibility-safety-vest-class-2', 'ANSI Class 2 high-visibility safety vest', 'The 3M Class 2 high-visibility safety vest features 2-inch reflective tape, zipper closure, and multiple pockets. Breathable mesh fabric keeps workers cool while meeting ANSI/ISEA 107 standards.', '22.99', '19.99', '12.00', '0.60', '12 x 10 x 1 in', 250, 50, 0, 1, '2026-05-28 18:23:44', '2026-05-28 18:23:44'),
(50, 2, 5, 'STN-12IN-CLAMP', 'Stanley 12&quot; Quick-Grip Bar Clamp', 'stanley-12-quick-grip-bar-clamp', 'One-handed quick-release bar clamp for woodworking', 'The Stanley 12-inch Quick-Grip bar clamp features a one-handed trigger release for quick adjustments. The padded jaws protect work surfaces while providing up to 350 lbs of clamping force.', '29.99', '24.99', '16.00', '1.50', '18 x 4 x 2 in', 110, 20, 0, 1, '2026-05-28 18:23:44', '2026-07-13 23:27:23'),
(51, 1, 5, 'SNP-CT882-AIR', 'Snap-On CT882 1/2&quot; Air Impact Wrench', 'snap-on-ct882-1-2-air-impact-wrench', 'Professional air impact wrench for heavy-duty work', 'The Snap-On CT882 1/2-inch air impact wrench delivers 1,000 ft-lbs of torque with a twin-hammer impact mechanism. The composite housing reduces weight and insulates against cold air.', '599.99', NULL, '380.00', '5.50', '14 x 6 x 4 in', 25, 5, 0, 1, '2026-05-28 18:23:44', '2026-07-13 23:28:19'),
(52, 3, 1, 'DWT-DW088K', 'DeWalt DW088K Self-Leveling Cross Line Laser', 'dewalt-dw088k-self-leveling-cross-line-laser', 'Self-leveling cross-line laser with 50ft range', 'The DeWalt DW088K self-leveling cross-line laser projects bright red horizontal and vertical lines. The pendulum self-leveling system provides accuracy within ±1/4 inch at 50 feet.', '179.99', '159.99', '108.00', '1.50', '8 x 6 x 4 in', 60, 12, 0, 1, '2026-05-28 18:23:44', '2026-05-28 18:23:44'),
(53, 4, 7, '3M-HT100-HARD', '3M H-700 Series Hard Hat', '3m-h-700-series-hard-hat', 'Lightweight industrial hard hat with 6-point suspension', 'The 3M H-700 series hard hat features a lightweight polyethylene shell with a 6-point ratchet suspension for comfort. Meets ANSI Z89.1 Type I standards for industrial head protection.', '34.99', '29.99', '20.00', '1.20', '12 x 10 x 6 in', 150, 30, 0, 1, '2026-05-28 18:23:44', '2026-05-28 18:23:44'),
(54, 5, 4, 'BOS-GST18V-60C', 'Bosch 18V Cordless Jigsaw', 'bosch-18v-cordless-jigsaw', 'Cordless jigsaw with variable orbital action', 'The Bosch GST18V cordless jigsaw features a 4-stage orbital action and variable speed trigger for cutting a wide range of materials. Tool-less blade change and LED work light included.', '209.99', '189.99', '125.00', '4.00', '14 x 8 x 5 in', 40, 8, 0, 1, '2026-05-28 18:23:44', '2026-05-28 18:23:44'),
(55, 6, 5, 'STN-LG100-LATCH', 'Stanley 100-Pack Heavy-Duty Latch Kit', 'stanley-100-pack-heavy-duty-latch-kit', 'Assorted latch and hasp hardware kit', 'The Stanley 100-pack heavy-duty latch kit includes gate latches, draw latches, and hasps in multiple sizes. Zinc-plated steel construction for corrosion resistance in indoor and outdoor use.', '39.99', '34.99', '22.00', '3.00', '10 x 8 x 3 in', 90, 18, 0, 1, '2026-05-28 18:23:44', '2026-05-28 18:23:44'),
(56, 7, 3, 'MKT-XPG01-SOLD', 'Makita XPG01 Cordless Soldering Iron', 'makita-xpg01-cordless-soldering-iron', 'Cordless soldering iron with quick heat-up', 'The Makita XPG01 cordless soldering iron heats up to 850°F in 30 seconds. Features a fine tip for precision work, LED work light, and runs on 12V CXT batteries for portability.', '89.99', '79.99', '52.00', '1.00', '10 x 3 x 2 in', 55, 10, 0, 1, '2026-05-28 18:23:44', '2026-05-28 18:23:44'),
(57, 8, 4, 'BOS-GBH2-28L', 'Bosch GBA 2-28L Tool Case', 'bosch-gba-2-28l-tool-case', 'Durable tool case with L-BOXX compatibility', 'The Bosch GBA 2-28L tool case is part of the L-BOXX system with stackable design and a removable tray. Made from impact-resistant plastic with a locking latch for secure storage.', '79.99', '69.99', '45.00', '5.00', '24 x 16 x 12 in', 70, 14, 0, 1, '2026-05-28 18:23:44', '2026-05-28 18:23:44'),
(58, 6, 5, 'STN-10PC-CHISEL', 'Stanley 10-Piece Wood Chisel Set', 'stanley-10-piece-wood-chisel-set', 'Professional wood chisel set with impact-resistant handles', 'The Stanley 10-piece wood chisel set includes 10 chisel sizes from 1/4 to 1-1/2 inches. Each chisel features a precision-ground blade and impact-resistant handle for fine woodworking.', '59.99', '49.99', '34.00', '3.00', '14 x 8 x 2 in', 80, 15, 0, 1, '2026-05-28 18:23:44', '2026-05-28 18:23:44');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `is_primary` tinyint(1) NOT NULL DEFAULT '0',
  `sort_order` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image`, `is_primary`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 1, 'products/1783942887_6a54cee764bf8.webp', 1, 0, '2026-07-13 11:41:27', '2026-07-13 11:41:27'),
(2, 2, 'products/1783945641_6a54d9a9b2d04.jpeg', 1, 0, '2026-07-13 12:27:21', '2026-07-13 12:27:21'),
(3, 3, 'products/1783945680_6a54d9d090777.webp', 1, 0, '2026-07-13 12:28:00', '2026-07-13 12:28:00'),
(4, 4, 'products/1783945816_6a54da58a023a.jpeg', 1, 0, '2026-07-13 12:30:16', '2026-07-13 12:30:16'),
(5, 5, 'products/1783945853_6a54da7d0dc0b.webp', 1, 0, '2026-07-13 12:30:53', '2026-07-13 12:30:53'),
(6, 6, 'products/1783945887_6a54da9f184c3.webp', 1, 0, '2026-07-13 12:31:27', '2026-07-13 12:31:27'),
(7, 7, 'products/1783945925_6a54dac548a3d.jpeg', 1, 0, '2026-07-13 12:32:05', '2026-07-13 12:32:05'),
(8, 8, 'products/1783945966_6a54daee0d7c7.webp', 1, 0, '2026-07-13 12:32:46', '2026-07-13 12:32:46'),
(9, 9, 'products/1783946004_6a54db1467a88.jpeg', 1, 0, '2026-07-13 12:33:24', '2026-07-13 12:33:24'),
(10, 10, 'products/1783946058_6a54db4a570b9.webp', 1, 0, '2026-07-13 12:34:18', '2026-07-13 12:34:18'),
(11, 11, 'products/1783946235_6a54dbfb50cbb.webp', 1, 0, '2026-07-13 12:37:15', '2026-07-13 12:37:15'),
(12, 12, 'products/1783946423_6a54dcb78893b.jpeg', 1, 0, '2026-07-13 12:40:23', '2026-07-13 12:40:23'),
(13, 13, 'products/1783946464_6a54dce06cc59.jpeg', 1, 0, '2026-07-13 12:41:04', '2026-07-13 12:41:04'),
(14, 14, 'products/1783946795_6a54de2bddabc.jpeg', 1, 0, '2026-07-13 12:46:35', '2026-07-13 12:46:35'),
(15, 15, 'products/1783946841_6a54de593c2ab.jpg', 1, 0, '2026-07-13 12:47:21', '2026-07-13 12:47:21'),
(16, 16, 'products/1783946886_6a54de86884f1.jpeg', 1, 0, '2026-07-13 12:48:06', '2026-07-13 12:48:06'),
(17, 17, 'products/1783946948_6a54dec453327.jpeg', 1, 0, '2026-07-13 12:49:08', '2026-07-13 12:49:08'),
(18, 18, 'products/1783947003_6a54defbe81dc.jpg', 1, 0, '2026-07-13 12:50:03', '2026-07-13 12:50:03'),
(19, 19, 'products/1783947062_6a54df36aeeb2.jpeg', 1, 0, '2026-07-13 12:51:02', '2026-07-13 12:51:02'),
(20, 20, 'products/1783947109_6a54df6565569.webp', 1, 0, '2026-07-13 12:51:49', '2026-07-13 12:51:49'),
(21, 21, 'products/1783947161_6a54df99b6909.png', 1, 0, '2026-07-13 12:52:41', '2026-07-13 12:52:41'),
(22, 22, 'products/1783947233_6a54dfe1d18e2.webp', 1, 0, '2026-07-13 12:53:53', '2026-07-13 12:53:53'),
(23, 23, 'products/1783981805_6a5566eda71e5.webp', 1, 0, '2026-07-13 22:30:05', '2026-07-13 22:30:05'),
(24, 24, 'products/1783981842_6a556712e6ad0.jpg', 1, 0, '2026-07-13 22:30:42', '2026-07-13 22:30:42'),
(25, 25, 'products/1783981899_6a55674b43b62.jpeg', 1, 0, '2026-07-13 22:31:39', '2026-07-13 22:31:39'),
(26, 26, 'products/1783982149_6a5568451371a.jpeg', 1, 0, '2026-07-13 22:35:49', '2026-07-13 22:35:49'),
(27, 27, 'products/1783982211_6a5568833b5a3.jpg', 1, 0, '2026-07-13 22:36:51', '2026-07-13 22:36:51'),
(28, 28, 'products/1783982249_6a5568a928595.jpeg', 1, 0, '2026-07-13 22:37:29', '2026-07-13 22:37:29'),
(29, 29, 'products/1783982289_6a5568d1e9201.jpeg', 1, 0, '2026-07-13 22:38:09', '2026-07-13 22:38:09'),
(30, 30, 'products/1783982329_6a5568f938cdd.webp', 1, 0, '2026-07-13 22:38:49', '2026-07-13 22:38:49'),
(31, 31, 'products/1783982839_6a556af7ba42a.webp', 1, 0, '2026-07-13 22:47:19', '2026-07-13 22:47:19'),
(32, 32, 'products/1783983586_6a556de2a816e.jpg', 1, 0, '2026-07-13 22:59:46', '2026-07-13 22:59:46'),
(33, 33, 'products/1783983631_6a556e0f651b3.jpg', 1, 0, '2026-07-13 23:00:31', '2026-07-13 23:00:31'),
(34, 34, 'products/1783983672_6a556e3883dc9.jpg', 1, 0, '2026-07-13 23:01:12', '2026-07-13 23:01:12'),
(35, 35, 'products/1783983716_6a556e6416bb9.jpeg', 1, 0, '2026-07-13 23:01:56', '2026-07-13 23:01:56'),
(36, 36, 'products/1783984601_6a5571d9a0128.jpeg', 1, 0, '2026-07-13 23:16:41', '2026-07-13 23:16:41'),
(37, 37, 'products/1783984647_6a5572073b917.jpg', 1, 0, '2026-07-13 23:17:27', '2026-07-13 23:17:27'),
(38, 38, 'products/1783984689_6a5572318e89b.jpg', 1, 0, '2026-07-13 23:18:09', '2026-07-13 23:18:09'),
(39, 39, 'products/1783984726_6a5572563483f.webp', 1, 0, '2026-07-13 23:18:46', '2026-07-13 23:18:46'),
(40, 40, 'products/1783984767_6a55727fe151e.jpeg', 1, 0, '2026-07-13 23:19:27', '2026-07-13 23:19:27'),
(41, 41, 'products/1783984815_6a5572af13217.jpeg', 1, 0, '2026-07-13 23:20:15', '2026-07-13 23:20:15'),
(42, 42, 'products/1783984866_6a5572e248701.jpeg', 1, 0, '2026-07-13 23:21:06', '2026-07-13 23:21:06'),
(43, 43, 'products/1783984911_6a55730f7701a.jpeg', 1, 0, '2026-07-13 23:21:51', '2026-07-13 23:21:51'),
(44, 44, 'products/1783984974_6a55734e3bd08.jpg', 1, 0, '2026-07-13 23:22:54', '2026-07-13 23:22:54'),
(45, 45, 'products/1783985012_6a557374cebbc.jpeg', 1, 0, '2026-07-13 23:23:32', '2026-07-13 23:23:32'),
(46, 46, 'products/1783985056_6a5573a02968e.webp', 1, 0, '2026-07-13 23:24:16', '2026-07-13 23:24:16'),
(47, 47, 'products/1783985101_6a5573cde550f.jpeg', 1, 0, '2026-07-13 23:25:01', '2026-07-13 23:25:01'),
(48, 48, 'products/1783985149_6a5573fdcf7c9.jpeg', 1, 0, '2026-07-13 23:25:49', '2026-07-13 23:25:49'),
(49, 49, 'products/1783985203_6a557433de369.png', 1, 0, '2026-07-13 23:26:43', '2026-07-13 23:26:43'),
(50, 50, 'products/1783985243_6a55745bf1d2e.jpeg', 1, 0, '2026-07-13 23:27:23', '2026-07-13 23:27:23'),
(51, 51, 'products/1783985299_6a557493efa98.jpg', 1, 0, '2026-07-13 23:28:19', '2026-07-13 23:28:19'),
(52, 52, 'products/1783985375_6a5574dfc334a.webp', 1, 0, '2026-07-13 23:29:35', '2026-07-13 23:29:35'),
(53, 53, 'products/1783985420_6a55750c44e8a.jpeg', 1, 0, '2026-07-13 23:30:20', '2026-07-13 23:30:20'),
(54, 54, 'products/1783985463_6a5575374e58e.webp', 1, 0, '2026-07-13 23:31:03', '2026-07-13 23:31:03'),
(55, 55, 'products/1783985529_6a557579757c9.jpg', 1, 0, '2026-07-13 23:32:09', '2026-07-13 23:32:09'),
(56, 56, 'products/1783985585_6a5575b1a1e93.jpeg', 1, 0, '2026-07-13 23:33:05', '2026-07-13 23:33:05'),
(57, 57, 'products/1783985654_6a5575f6b1ca7.jpeg', 1, 0, '2026-07-13 23:34:14', '2026-07-13 23:34:14'),
(58, 58, 'products/1783985699_6a5576233e241.webp', 1, 0, '2026-07-13 23:34:59', '2026-07-13 23:34:59');

-- --------------------------------------------------------

--
-- Table structure for table `product_specifications`
--

CREATE TABLE `product_specifications` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `attribute_name` varchar(255) NOT NULL,
  `attribute_value` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `comment` text,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `product_id`, `user_id`, `rating`, `title`, `comment`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 20, 3, NULL, 'Works as expected, fast shipping.', 1, '2026-04-10 01:18:36', '2026-06-01 09:47:23'),
(2, 2, 15, 3, NULL, 'Works as expected, fast shipping.', 1, '2026-04-24 18:18:36', '2026-04-24 18:18:36'),
(3, 3, 9, 5, NULL, 'Exactly what I needed for the job.', 1, '2026-05-03 13:18:36', '2026-05-03 13:18:36'),
(4, 3, 9, 4, NULL, 'Perfect for my workshop needs.', 1, '2026-04-04 12:18:36', '2026-04-04 12:18:36'),
(5, 4, 21, 3, NULL, 'Not what I expected, but it works.', 0, '2026-04-29 18:18:36', '2026-04-29 18:18:36'),
(6, 4, 14, 3, NULL, 'Not what I expected, but it works.', 1, '2026-05-01 21:18:36', '2026-05-01 21:18:36'),
(7, 4, 20, 4, NULL, 'Perfect for my workshop needs.', 1, '2026-05-23 08:18:36', '2026-05-23 08:18:36'),
(8, 4, 9, 5, NULL, 'Works as expected, fast shipping.', 0, '2026-05-21 07:18:36', '2026-05-21 07:18:36'),
(9, 5, 9, 4, NULL, 'Not what I expected, but it works.', 1, '2026-05-28 11:18:36', '2026-06-01 09:46:26'),
(10, 5, 13, 4, NULL, 'Perfect for my workshop needs.', 1, '2026-04-01 19:18:36', '2026-04-01 19:18:36'),
(11, 5, 14, 4, NULL, 'Great value, will buy again.', 1, '2026-04-22 06:18:36', '2026-04-22 06:18:36'),
(12, 5, 9, 5, NULL, 'Average product, nothing special.', 0, '2026-05-01 21:18:36', '2026-05-01 21:18:36'),
(13, 5, 16, 5, NULL, 'Solid build quality, very durable.', 1, '2026-05-13 21:18:36', '2026-05-13 21:18:36'),
(14, 6, 14, 3, NULL, 'Solid build quality, very durable.', 0, '2026-05-23 12:18:36', '2026-05-23 12:18:36'),
(15, 6, 11, 4, NULL, 'Good product for the price.', 1, '2026-05-10 20:18:36', '2026-05-10 20:18:36'),
(16, 6, 17, 5, NULL, 'Solid build quality, very durable.', 1, '2026-04-29 13:18:36', '2026-04-29 13:18:36'),
(17, 7, 18, 5, NULL, 'Works as expected, fast shipping.', 1, '2026-04-12 23:18:36', '2026-04-12 23:18:36'),
(18, 7, 7, 3, NULL, 'Exactly what I needed for the job.', 1, '2026-04-11 00:18:36', '2026-04-11 00:18:36'),
(19, 7, 22, 4, NULL, 'Solid build quality, very durable.', 1, '2026-05-02 02:18:36', '2026-05-02 02:18:36'),
(20, 8, 4, 5, NULL, 'Great value, will buy again.', 0, '2026-05-04 12:18:36', '2026-05-04 12:18:36'),
(21, 8, 19, 4, NULL, 'Perfect for my workshop needs.', 0, '2026-05-10 09:18:36', '2026-05-10 09:18:36'),
(22, 8, 14, 4, NULL, 'Excellent quality, highly recommended!', 1, '2026-05-02 20:18:36', '2026-05-02 20:18:36'),
(23, 8, 10, 5, NULL, 'Good product for the price.', 0, '2026-04-11 05:18:36', '2026-04-11 05:18:36'),
(24, 8, 3, 5, NULL, 'Perfect for my workshop needs.', 1, '2026-04-16 08:18:36', '2026-04-16 08:18:36'),
(25, 9, 8, 3, NULL, 'Exactly what I needed for the job.', 1, '2026-04-29 10:18:36', '2026-04-29 10:18:36'),
(26, 9, 8, 3, NULL, 'Great value, will buy again.', 1, '2026-05-10 14:18:36', '2026-05-10 14:18:36'),
(27, 9, 13, 5, NULL, 'Not what I expected, but it works.', 1, '2026-05-07 14:18:36', '2026-05-07 14:18:36'),
(28, 10, 8, 5, NULL, 'Not what I expected, but it works.', 1, '2026-05-06 07:18:36', '2026-05-06 07:18:36'),
(29, 10, 21, 3, NULL, 'Great value, will buy again.', 0, '2026-04-18 22:18:36', '2026-04-18 22:18:36'),
(30, 10, 4, 5, NULL, 'Exactly what I needed for the job.', 1, '2026-04-19 04:18:36', '2026-04-19 04:18:36'),
(31, 11, 20, 3, NULL, 'Decent quality but could be better.', 1, '2026-05-15 16:18:36', '2026-05-15 16:18:36'),
(32, 11, 17, 3, NULL, 'Decent quality but could be better.', 1, '2026-05-07 08:18:36', '2026-05-07 08:18:36'),
(33, 11, 16, 3, NULL, 'Perfect for my workshop needs.', 1, '2026-05-11 16:18:36', '2026-05-11 16:18:36'),
(34, 11, 10, 3, NULL, 'Decent quality but could be better.', 1, '2026-05-13 03:18:36', '2026-05-13 03:18:36'),
(35, 12, 20, 3, NULL, 'Works as expected, fast shipping.', 1, '2026-04-09 10:18:36', '2026-04-09 10:18:36'),
(36, 13, 16, 4, NULL, 'Works as expected, fast shipping.', 0, '2026-04-05 12:18:36', '2026-04-05 12:18:36'),
(37, 13, 14, 5, NULL, 'Works as expected, fast shipping.', 1, '2026-04-03 05:18:36', '2026-04-03 05:18:36'),
(38, 13, 17, 3, NULL, 'Decent quality but could be better.', 1, '2026-05-30 03:18:36', '2026-05-30 03:18:36'),
(39, 14, 20, 4, NULL, 'Solid build quality, very durable.', 0, '2026-05-24 19:18:36', '2026-05-24 19:18:36'),
(40, 14, 8, 5, NULL, 'Perfect for my workshop needs.', 1, '2026-05-05 15:18:36', '2026-05-05 15:18:36'),
(41, 14, 5, 4, NULL, 'Excellent quality, highly recommended!', 1, '2026-05-22 16:18:36', '2026-05-22 16:18:36'),
(42, 14, 15, 5, NULL, 'Great value, will buy again.', 0, '2026-05-10 12:18:36', '2026-05-10 12:18:36'),
(43, 15, 21, 4, NULL, 'Good product for the price.', 1, '2026-05-30 22:18:36', '2026-05-30 22:18:36'),
(44, 15, 14, 3, NULL, 'Great value, will buy again.', 0, '2026-04-22 05:18:36', '2026-04-22 05:18:36'),
(45, 16, 15, 5, NULL, 'Great value, will buy again.', 1, '2026-04-11 15:18:36', '2026-04-11 15:18:36'),
(46, 16, 20, 5, NULL, 'Average product, nothing special.', 1, '2026-05-03 06:18:36', '2026-05-03 06:18:36'),
(47, 16, 18, 4, NULL, 'Not what I expected, but it works.', 1, '2026-04-20 03:18:36', '2026-04-20 03:18:36'),
(48, 16, 22, 5, NULL, 'Solid build quality, very durable.', 1, '2026-04-22 12:18:36', '2026-04-22 12:18:36'),
(49, 16, 12, 5, NULL, 'Average product, nothing special.', 1, '2026-04-14 22:18:36', '2026-04-14 22:18:36'),
(50, 17, 12, 4, NULL, 'Great value, will buy again.', 1, '2026-04-19 19:18:36', '2026-04-19 19:18:36'),
(51, 17, 12, 5, NULL, 'Good product for the price.', 1, '2026-05-22 09:18:36', '2026-05-22 09:18:36'),
(52, 17, 2, 5, NULL, 'Exactly what I needed for the job.', 1, '2026-04-13 16:18:36', '2026-04-13 16:18:36'),
(53, 17, 3, 5, NULL, 'Decent quality but could be better.', 1, '2026-04-05 11:18:36', '2026-04-05 11:18:36'),
(54, 17, 13, 4, NULL, 'Exactly what I needed for the job.', 1, '2026-05-11 19:18:36', '2026-05-11 19:18:36'),
(55, 18, 20, 5, NULL, 'Good product for the price.', 1, '2026-05-23 16:18:36', '2026-05-23 16:18:36'),
(56, 18, 18, 5, NULL, 'Average product, nothing special.', 1, '2026-04-06 10:18:36', '2026-04-06 10:18:36'),
(57, 18, 20, 5, NULL, 'Solid build quality, very durable.', 0, '2026-04-01 19:18:36', '2026-04-01 19:18:36'),
(58, 19, 20, 5, NULL, 'Not what I expected, but it works.', 1, '2026-04-01 13:18:36', '2026-04-01 13:18:36'),
(59, 19, 3, 3, NULL, 'Average product, nothing special.', 0, '2026-05-26 19:18:36', '2026-05-26 19:18:36'),
(60, 19, 12, 4, NULL, 'Excellent quality, highly recommended!', 1, '2026-04-15 01:18:36', '2026-04-15 01:18:36'),
(61, 19, 20, 5, NULL, 'Not what I expected, but it works.', 1, '2026-05-04 11:18:36', '2026-05-04 11:18:36'),
(62, 20, 10, 4, NULL, 'Great value, will buy again.', 1, '2026-05-03 19:18:36', '2026-05-03 19:18:36'),
(63, 20, 19, 3, NULL, 'Excellent quality, highly recommended!', 1, '2026-04-06 01:18:36', '2026-04-06 01:18:36'),
(64, 20, 7, 3, NULL, 'Exactly what I needed for the job.', 1, '2026-04-10 18:18:36', '2026-04-10 18:18:36'),
(65, 20, 20, 4, NULL, 'Good product for the price.', 0, '2026-05-18 12:18:36', '2026-05-18 12:18:36'),
(66, 20, 11, 3, NULL, 'Solid build quality, very durable.', 1, '2026-05-20 10:18:36', '2026-05-20 10:18:36'),
(67, 21, 20, 5, NULL, 'Solid build quality, very durable.', 1, '2026-03-31 11:18:36', '2026-03-31 11:18:36'),
(68, 21, 6, 4, NULL, 'Good product for the price.', 1, '2026-03-31 17:18:36', '2026-03-31 17:18:36'),
(69, 21, 6, 3, NULL, 'Exactly what I needed for the job.', 1, '2026-05-18 07:18:36', '2026-05-18 07:18:36'),
(70, 22, 5, 3, NULL, 'Decent quality but could be better.', 0, '2026-05-04 16:18:36', '2026-05-04 16:18:36'),
(71, 23, 9, 4, NULL, 'Great value, will buy again.', 1, '2026-05-23 22:18:36', '2026-05-23 22:18:36'),
(72, 24, 16, 4, NULL, 'Average product, nothing special.', 1, '2026-05-09 04:18:36', '2026-05-09 04:18:36'),
(73, 24, 13, 5, NULL, 'Not what I expected, but it works.', 1, '2026-05-20 19:18:36', '2026-05-20 19:18:36'),
(74, 24, 3, 4, NULL, 'Not what I expected, but it works.', 1, '2026-05-25 20:18:36', '2026-05-25 20:18:36'),
(75, 24, 13, 4, NULL, 'Great value, will buy again.', 0, '2026-05-12 09:18:36', '2026-05-12 09:18:36'),
(76, 25, 5, 5, NULL, 'Not what I expected, but it works.', 0, '2026-05-26 03:18:36', '2026-05-26 03:18:36'),
(77, 25, 12, 4, NULL, 'Solid build quality, very durable.', 1, '2026-05-25 23:18:36', '2026-05-25 23:18:36'),
(78, 25, 13, 3, NULL, 'Works as expected, fast shipping.', 0, '2026-04-18 23:18:36', '2026-04-18 23:18:36'),
(79, 26, 3, 5, NULL, 'Works as expected, fast shipping.', 1, '2026-05-15 11:18:36', '2026-05-15 11:18:36'),
(80, 26, 16, 5, NULL, 'Average product, nothing special.', 1, '2026-04-12 17:18:36', '2026-04-12 17:18:36'),
(81, 26, 20, 5, NULL, 'Perfect for my workshop needs.', 1, '2026-04-29 21:18:36', '2026-04-29 21:18:36'),
(82, 26, 21, 5, NULL, 'Works as expected, fast shipping.', 1, '2026-04-22 11:18:36', '2026-04-22 11:18:36'),
(83, 27, 6, 4, NULL, 'Perfect for my workshop needs.', 1, '2026-04-20 19:18:36', '2026-04-20 19:18:36'),
(84, 28, 13, 3, NULL, 'Solid build quality, very durable.', 0, '2026-04-19 20:18:36', '2026-04-19 20:18:36'),
(85, 28, 7, 3, NULL, 'Solid build quality, very durable.', 1, '2026-05-06 21:18:36', '2026-05-06 21:18:36'),
(86, 28, 21, 4, NULL, 'Good product for the price.', 1, '2026-04-29 15:18:36', '2026-04-29 15:18:36'),
(87, 28, 19, 5, NULL, 'Average product, nothing special.', 1, '2026-05-11 10:18:36', '2026-05-11 10:18:36'),
(88, 28, 6, 4, NULL, 'Good product for the price.', 1, '2026-04-25 22:18:36', '2026-04-25 22:18:36'),
(89, 29, 13, 5, NULL, 'Exactly what I needed for the job.', 1, '2026-05-22 18:18:36', '2026-05-22 18:18:36'),
(90, 29, 17, 4, NULL, 'Decent quality but could be better.', 1, '2026-05-13 23:18:36', '2026-05-13 23:18:36'),
(91, 29, 14, 4, NULL, 'Average product, nothing special.', 1, '2026-04-08 22:18:36', '2026-04-08 22:18:36'),
(92, 29, 19, 4, NULL, 'Great value, will buy again.', 0, '2026-05-23 12:18:36', '2026-05-23 12:18:36'),
(93, 30, 5, 4, NULL, 'Decent quality but could be better.', 0, '2026-05-06 20:18:36', '2026-05-06 20:18:36'),
(94, 30, 15, 5, NULL, 'Works as expected, fast shipping.', 1, '2026-05-12 22:18:36', '2026-05-12 22:18:36'),
(95, 30, 11, 4, NULL, 'Average product, nothing special.', 1, '2026-05-01 11:18:36', '2026-05-01 11:18:36'),
(96, 31, 13, 5, NULL, 'Decent quality but could be better.', 1, '2026-03-31 19:18:36', '2026-03-31 19:18:36'),
(97, 31, 4, 3, NULL, 'Works as expected, fast shipping.', 1, '2026-04-02 01:18:36', '2026-04-02 01:18:36'),
(98, 31, 17, 5, NULL, 'Perfect for my workshop needs.', 1, '2026-05-02 05:18:36', '2026-05-02 05:18:36'),
(99, 32, 20, 3, NULL, 'Exactly what I needed for the job.', 1, '2026-05-08 21:18:36', '2026-05-08 21:18:36'),
(100, 33, 5, 3, NULL, 'Exactly what I needed for the job.', 0, '2026-05-25 11:18:36', '2026-05-25 11:18:36'),
(101, 33, 17, 3, NULL, 'Excellent quality, highly recommended!', 1, '2026-05-20 15:18:36', '2026-05-20 15:18:36'),
(102, 33, 8, 3, NULL, 'Decent quality but could be better.', 1, '2026-05-02 14:18:36', '2026-05-02 14:18:36'),
(103, 33, 15, 3, NULL, 'Great value, will buy again.', 0, '2026-05-19 17:18:36', '2026-05-19 17:18:36'),
(104, 34, 7, 5, NULL, 'Excellent quality, highly recommended!', 1, '2026-04-17 07:18:36', '2026-04-17 07:18:36'),
(105, 34, 15, 4, NULL, 'Solid build quality, very durable.', 1, '2026-04-25 07:18:36', '2026-04-25 07:18:36'),
(106, 34, 18, 5, NULL, 'Good product for the price.', 1, '2026-05-27 10:18:36', '2026-05-27 10:18:36'),
(107, 34, 20, 4, NULL, 'Average product, nothing special.', 1, '2026-04-25 01:18:36', '2026-04-25 01:18:36'),
(108, 34, 10, 4, NULL, 'Excellent quality, highly recommended!', 0, '2026-05-21 21:18:36', '2026-05-21 21:18:36'),
(109, 35, 4, 4, NULL, 'Decent quality but could be better.', 0, '2026-04-03 15:18:36', '2026-04-03 15:18:36'),
(110, 35, 21, 3, NULL, 'Excellent quality, highly recommended!', 1, '2026-04-15 13:18:36', '2026-04-15 13:18:36'),
(111, 36, 9, 4, NULL, 'Good product for the price.', 1, '2026-04-16 02:18:36', '2026-04-16 02:18:36'),
(112, 37, 16, 5, NULL, 'Solid build quality, very durable.', 1, '2026-05-26 18:18:36', '2026-05-26 18:18:36'),
(113, 37, 9, 3, NULL, 'Good product for the price.', 1, '2026-04-18 15:18:36', '2026-04-18 15:18:36'),
(114, 37, 16, 3, NULL, 'Not what I expected, but it works.', 1, '2026-04-03 10:18:36', '2026-04-03 10:18:36'),
(115, 37, 22, 5, NULL, 'Not what I expected, but it works.', 1, '2026-04-28 16:18:36', '2026-04-28 16:18:36'),
(116, 37, 12, 4, NULL, 'Solid build quality, very durable.', 1, '2026-04-13 17:18:36', '2026-04-13 17:18:36'),
(117, 38, 7, 5, NULL, 'Exactly what I needed for the job.', 1, '2026-04-29 05:18:36', '2026-04-29 05:18:36'),
(118, 38, 8, 4, NULL, 'Average product, nothing special.', 1, '2026-05-03 01:18:36', '2026-05-03 01:18:36'),
(119, 38, 2, 4, NULL, 'Perfect for my workshop needs.', 0, '2026-04-12 10:18:36', '2026-04-12 10:18:36'),
(120, 38, 16, 5, NULL, 'Good product for the price.', 1, '2026-05-09 06:18:36', '2026-05-09 06:18:36'),
(121, 38, 21, 5, NULL, 'Decent quality but could be better.', 1, '2026-05-16 05:18:36', '2026-05-16 05:18:36'),
(122, 39, 4, 4, NULL, 'Solid build quality, very durable.', 1, '2026-04-21 16:18:36', '2026-04-21 16:18:36'),
(123, 39, 14, 5, NULL, 'Good product for the price.', 0, '2026-04-20 07:18:36', '2026-04-20 07:18:36'),
(124, 39, 18, 4, NULL, 'Average product, nothing special.', 1, '2026-05-24 16:18:36', '2026-05-24 16:18:36'),
(125, 39, 20, 5, NULL, 'Great value, will buy again.', 0, '2026-04-22 14:18:36', '2026-04-22 14:18:36'),
(126, 39, 7, 5, NULL, 'Decent quality but could be better.', 0, '2026-05-11 20:18:36', '2026-05-11 20:18:36'),
(127, 40, 5, 4, NULL, 'Perfect for my workshop needs.', 1, '2026-05-01 01:18:36', '2026-05-01 01:18:36'),
(128, 40, 4, 3, NULL, 'Good product for the price.', 1, '2026-04-25 17:18:36', '2026-04-25 17:18:36'),
(129, 41, 14, 4, NULL, 'Excellent quality, highly recommended!', 1, '2026-05-16 06:18:36', '2026-05-16 06:18:36'),
(130, 41, 6, 5, NULL, 'Great value, will buy again.', 1, '2026-05-26 21:18:36', '2026-05-26 21:18:36'),
(131, 41, 21, 5, NULL, 'Great value, will buy again.', 0, '2026-04-04 23:18:36', '2026-04-04 23:18:36'),
(132, 41, 15, 3, NULL, 'Solid build quality, very durable.', 0, '2026-05-12 18:18:36', '2026-05-12 18:18:36'),
(133, 42, 17, 5, NULL, 'Exactly what I needed for the job.', 1, '2026-04-04 18:18:36', '2026-04-04 18:18:36'),
(134, 42, 7, 3, NULL, 'Decent quality but could be better.', 1, '2026-04-06 02:18:36', '2026-04-06 02:18:36'),
(135, 42, 2, 3, NULL, 'Good product for the price.', 1, '2026-04-30 11:18:36', '2026-04-30 11:18:36'),
(136, 42, 19, 4, NULL, 'Average product, nothing special.', 1, '2026-04-10 03:18:36', '2026-04-10 03:18:36'),
(137, 42, 11, 4, NULL, 'Good product for the price.', 0, '2026-04-08 06:18:36', '2026-04-08 06:18:36'),
(138, 43, 20, 5, NULL, 'Works as expected, fast shipping.', 1, '2026-05-21 01:18:36', '2026-05-21 01:18:36'),
(139, 43, 21, 3, NULL, 'Decent quality but could be better.', 1, '2026-04-26 18:18:36', '2026-04-26 18:18:36'),
(140, 43, 8, 3, NULL, 'Great value, will buy again.', 1, '2026-04-24 06:18:36', '2026-04-24 06:18:36'),
(141, 44, 18, 3, NULL, 'Average product, nothing special.', 0, '2026-05-04 07:18:36', '2026-05-04 07:18:36'),
(142, 44, 6, 4, NULL, 'Good product for the price.', 1, '2026-05-10 09:18:36', '2026-05-10 09:18:36'),
(143, 44, 21, 5, NULL, 'Perfect for my workshop needs.', 0, '2026-05-11 13:18:36', '2026-05-11 13:18:36'),
(144, 44, 4, 4, NULL, 'Excellent quality, highly recommended!', 1, '2026-05-21 17:18:36', '2026-05-21 17:18:36'),
(145, 45, 5, 3, NULL, 'Perfect for my workshop needs.', 1, '2026-04-13 22:18:36', '2026-04-13 22:18:36'),
(146, 45, 20, 5, NULL, 'Not what I expected, but it works.', 1, '2026-05-05 07:18:36', '2026-05-05 07:18:36'),
(147, 45, 7, 3, NULL, 'Decent quality but could be better.', 1, '2026-04-08 14:18:36', '2026-04-08 14:18:36'),
(148, 46, 15, 5, NULL, 'Excellent quality, highly recommended!', 1, '2026-05-27 11:18:36', '2026-05-27 11:18:36'),
(149, 47, 13, 3, NULL, 'Exactly what I needed for the job.', 1, '2026-05-24 02:18:36', '2026-05-24 02:18:36'),
(150, 47, 19, 5, NULL, 'Great value, will buy again.', 1, '2026-04-17 16:18:36', '2026-04-17 16:18:36'),
(151, 47, 20, 4, NULL, 'Good product for the price.', 1, '2026-04-24 09:18:36', '2026-04-24 09:18:36'),
(152, 47, 10, 5, NULL, 'Solid build quality, very durable.', 0, '2026-05-17 20:18:36', '2026-05-17 20:18:36'),
(153, 48, 18, 3, NULL, 'Not what I expected, but it works.', 1, '2026-05-27 01:18:36', '2026-05-27 01:18:36'),
(154, 48, 7, 4, NULL, 'Average product, nothing special.', 1, '2026-05-11 21:18:36', '2026-05-11 21:18:36'),
(155, 48, 10, 4, NULL, 'Works as expected, fast shipping.', 1, '2026-04-20 14:18:36', '2026-04-20 14:18:36'),
(156, 48, 16, 5, NULL, 'Works as expected, fast shipping.', 0, '2026-05-15 06:18:36', '2026-05-15 06:18:36'),
(157, 48, 12, 4, NULL, 'Great value, will buy again.', 0, '2026-05-25 20:18:36', '2026-05-25 20:18:36'),
(158, 49, 20, 5, NULL, 'Good product for the price.', 1, '2026-04-19 20:18:36', '2026-04-19 20:18:36'),
(159, 49, 22, 3, NULL, 'Exactly what I needed for the job.', 0, '2026-04-11 19:18:36', '2026-04-11 19:18:36'),
(160, 49, 5, 5, NULL, 'Average product, nothing special.', 0, '2026-05-15 09:18:36', '2026-05-15 09:18:36'),
(161, 50, 4, 5, NULL, 'Perfect for my workshop needs.', 1, '2026-05-24 15:18:36', '2026-05-24 15:18:36'),
(162, 50, 12, 5, NULL, 'Perfect for my workshop needs.', 0, '2026-05-11 10:18:36', '2026-05-11 10:18:36'),
(163, 51, 17, 4, NULL, 'Not what I expected, but it works.', 1, '2026-05-25 09:18:36', '2026-05-25 09:18:36'),
(164, 51, 13, 5, NULL, 'Works as expected, fast shipping.', 0, '2026-04-14 04:18:36', '2026-04-14 04:18:36'),
(165, 51, 18, 5, NULL, 'Average product, nothing special.', 0, '2026-05-13 17:18:36', '2026-05-13 17:18:36'),
(166, 51, 13, 3, NULL, 'Decent quality but could be better.', 1, '2026-04-11 04:18:36', '2026-04-11 04:18:36'),
(167, 51, 5, 3, NULL, 'Works as expected, fast shipping.', 1, '2026-04-05 04:18:36', '2026-04-05 04:18:36'),
(168, 52, 9, 4, NULL, 'Exactly what I needed for the job.', 1, '2026-04-10 20:18:36', '2026-04-10 20:18:36'),
(169, 52, 14, 5, NULL, 'Average product, nothing special.', 1, '2026-05-13 11:18:36', '2026-05-13 11:18:36'),
(170, 52, 12, 3, NULL, 'Great value, will buy again.', 1, '2026-04-20 07:18:36', '2026-04-20 07:18:36'),
(171, 52, 9, 5, NULL, 'Solid build quality, very durable.', 1, '2026-05-11 00:18:36', '2026-05-11 00:18:36'),
(172, 52, 15, 3, NULL, 'Works as expected, fast shipping.', 1, '2026-05-08 15:18:36', '2026-05-08 15:18:36'),
(173, 53, 5, 4, NULL, 'Decent quality but could be better.', 1, '2026-05-27 01:18:36', '2026-05-27 01:18:36'),
(174, 54, 11, 3, NULL, 'Excellent quality, highly recommended!', 1, '2026-05-30 07:18:36', '2026-05-30 07:18:36'),
(175, 54, 9, 4, NULL, 'Decent quality but could be better.', 1, '2026-05-28 06:18:36', '2026-05-28 06:18:36'),
(176, 54, 11, 3, NULL, 'Great value, will buy again.', 1, '2026-04-08 11:18:36', '2026-04-08 11:18:36'),
(177, 55, 10, 5, NULL, 'Works as expected, fast shipping.', 1, '2026-05-03 22:18:36', '2026-05-03 22:18:36'),
(178, 55, 4, 5, NULL, 'Works as expected, fast shipping.', 0, '2026-04-14 07:18:36', '2026-04-14 07:18:36'),
(179, 55, 19, 3, NULL, 'Perfect for my workshop needs.', 1, '2026-05-25 11:18:36', '2026-05-25 11:18:36'),
(180, 56, 21, 5, NULL, 'Great value, will buy again.', 1, '2026-05-22 06:18:36', '2026-05-22 06:18:36'),
(181, 56, 6, 3, NULL, 'Decent quality but could be better.', 1, '2026-04-28 08:18:36', '2026-04-28 08:18:36'),
(182, 56, 11, 4, NULL, 'Excellent quality, highly recommended!', 1, '2026-05-14 16:18:36', '2026-05-14 16:18:36'),
(183, 56, 5, 5, NULL, 'Average product, nothing special.', 1, '2026-05-04 11:18:36', '2026-05-04 11:18:36'),
(184, 56, 19, 4, NULL, 'Good product for the price.', 1, '2026-04-13 00:18:36', '2026-04-13 00:18:36'),
(185, 57, 2, 4, NULL, 'Great value, will buy again.', 1, '2026-05-05 19:18:36', '2026-05-05 19:18:36'),
(186, 57, 5, 4, NULL, 'Exactly what I needed for the job.', 1, '2026-04-27 08:18:36', '2026-04-27 08:18:36'),
(187, 57, 8, 4, NULL, 'Exactly what I needed for the job.', 1, '2026-04-05 12:18:36', '2026-04-05 12:18:36'),
(188, 57, 5, 5, NULL, 'Decent quality but could be better.', 0, '2026-05-08 05:18:36', '2026-05-08 05:18:36'),
(189, 58, 10, 5, NULL, 'Exactly what I needed for the job.', 1, '2026-05-31 02:18:36', '2026-06-01 09:46:04'),
(190, 58, 12, 4, NULL, 'Great value, will buy again.', 1, '2026-05-21 13:18:36', '2026-05-21 13:18:36'),
(191, 58, 6, 4, NULL, 'Great value, will buy again.', 1, '2026-04-26 15:18:36', '2026-04-26 15:18:36'),
(192, 1, 23, 4, NULL, 'great product', 1, '2026-06-01 09:49:43', '2026-06-01 09:49:43'),
(193, 35, 23, 4, NULL, 'great product', 1, '2026-06-01 09:51:47', '2026-06-01 09:51:47'),
(194, 21, 23, 5, NULL, 'great product', 1, '2026-06-01 09:53:09', '2026-06-01 09:53:09');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `key` varchar(255) NOT NULL,
  `group` varchar(100) DEFAULT 'general',
  `value` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `group`, `value`, `created_at`, `updated_at`) VALUES
(1, 'site_name', 'general', 'Industrial Tool Shop', '2026-07-13 09:23:11', '2026-07-13 09:23:11'),
(2, 'site_logo', 'general', '', '2026-07-13 09:23:11', '2026-07-13 09:23:11'),
(3, 'support_email', 'general', 'support@toolshop.com', '2026-07-13 09:23:11', '2026-07-13 09:23:11'),
(4, 'support_phone', 'general', '+1 (555) 123-4567', '2026-07-13 09:23:11', '2026-07-13 09:23:11'),
(5, 'currency', 'general', 'USD', '2026-07-13 09:23:11', '2026-07-13 09:23:11'),
(6, 'tax_rate', 'general', '13', '2026-07-13 09:23:11', '2026-07-13 09:23:11'),
(7, 'shipping_fee', 'general', '10', '2026-07-13 09:23:11', '2026-07-13 09:23:11'),
(8, 'stripe_publishable_key', 'payment', 'pk_test', '2026-07-13 09:23:11', '2026-07-13 09:23:11'),
(9, 'stripe_secret_key', 'payment', 'sk_test', '2026-07-13 09:23:11', '2026-07-13 09:23:11'),
(10, 'paypal_client_id', 'payment', 'test', '2026-07-13 09:23:11', '2026-07-13 09:23:11'),
(11, 'paypal_client_secret', 'payment', 'test', '2026-07-13 09:23:11', '2026-07-13 09:23:11');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `role` enum('admin','customer','staff') NOT NULL DEFAULT 'customer',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_token_expires` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `avatar`, `role`, `status`, `email_verified_at`, `remember_token`, `reset_token`, `reset_token_expires`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@admin.com', '$2y$12$LWm.Gak0cBNgpF0mr8BZdeuS0otgLmyBNUxfAIvR2IBPJNgOwsXoi', '', 'avatars/1784111143_6a576027ce568.jpeg', 'admin', 1, NULL, NULL, NULL, NULL, '2026-07-13 09:23:11', '2026-07-15 10:25:43'),
(2, 'Clydey Ednalan', 'clydey@gmail.com', '$2y$10$EB9YHbZTOkhyq29CBpElkepwcLcUy7E5XWkzCnd0su4gXC2kHKPzW', '4234234234999', NULL, 'customer', 1, NULL, NULL, NULL, NULL, '2026-07-14 00:59:06', '2026-07-14 09:31:03'),
(3, 'James Wilson', 'james.wilson@example.com', '$2y$10$kxZtL9t6nrBSu7w26lOppuT7PfDBnSr8GOjdPNO6g8qcYUyBT131y', '4234234', NULL, 'customer', 1, NULL, NULL, NULL, NULL, '2026-07-14 01:03:47', '2026-07-14 01:03:47'),
(4, 'Sarah Johnson', 'sarah.johnson@example.com', '$2y$10$wqQR5KPMyqJQ3sP62iU6IeDECSsoVAyQR/6W3cCKKnAaPpuAYrjSW', '555345345', NULL, 'customer', 1, NULL, NULL, NULL, NULL, '2026-07-14 01:04:25', '2026-07-14 01:04:25'),
(5, 'Michael Chen', 'michael.chen@example.com', '$2y$10$RHDOcdByA8BAMKG5d49Uc.rSRKdgr7msJ8cjYEeFVYSuZi0yjytny', '5345345', NULL, 'customer', 1, NULL, NULL, NULL, NULL, '2026-07-14 01:04:59', '2026-07-14 01:04:59'),
(6, 'Emily Rodriguez', 'emily.rodriguez@example.com', '$2y$10$vRSaLd7u.r460EY6o7bAROE8hXzUUMfCNVCo3BWCX9kT0tIDnekAi', '45345345', NULL, 'customer', 1, NULL, NULL, NULL, NULL, '2026-07-14 01:05:35', '2026-07-14 01:05:35'),
(7, 'Catlin Ednalan', 'catlin@gmail.com', '$2y$10$9O1AY7KBBKcaKTi8XqJyh.wKTsV15FkevAheOHGb7oaycEdAKDCVK', '2324234', NULL, 'customer', 1, NULL, NULL, NULL, NULL, '2026-07-14 01:06:16', '2026-07-14 01:06:16'),
(8, 'Michael Chen', 'MichaelChen@gmail.com', '$2y$10$9O1AY7KBBKcaKTi8XqJyh.wKTsV15FkevAheOHGb7oaycEdAKDCVK', '2324234', NULL, 'customer', 1, NULL, NULL, NULL, NULL, '2026-07-13 17:06:16', '2026-07-13 17:06:16'),
(9, 'Emily Rodriguez', 'EmilyRodriguez@gmail.com', '$2y$10$9O1AY7KBBKcaKTi8XqJyh.wKTsV15FkevAheOHGb7oaycEdAKDCVK', '2324234', NULL, 'customer', 1, NULL, NULL, NULL, NULL, '2026-07-13 17:06:16', '2026-07-13 17:06:16'),
(10, 'Robert Thompson', 'RobertThompson@gmail.com', '$2y$10$9O1AY7KBBKcaKTi8XqJyh.wKTsV15FkevAheOHGb7oaycEdAKDCVK', '2324234', NULL, 'customer', 1, NULL, NULL, NULL, NULL, '2026-07-13 17:06:16', '2026-07-13 17:06:16'),
(11, 'Jessica Martinez', 'JessicaMartinez@gmail.com', '$2y$10$9O1AY7KBBKcaKTi8XqJyh.wKTsV15FkevAheOHGb7oaycEdAKDCVK', '2324234', NULL, 'customer', 1, NULL, NULL, NULL, NULL, '2026-07-13 17:06:16', '2026-07-13 17:06:16'),
(12, 'David Anderson', 'DavidAnderson@gmail.com', '$2y$10$9O1AY7KBBKcaKTi8XqJyh.wKTsV15FkevAheOHGb7oaycEdAKDCVK', '2324234', NULL, 'customer', 1, NULL, NULL, NULL, NULL, '2026-07-13 17:06:16', '2026-07-13 17:06:16'),
(13, 'Amanda Taylor', 'AmandaTaylor@gmail.com', '$2y$10$9O1AY7KBBKcaKTi8XqJyh.wKTsV15FkevAheOHGb7oaycEdAKDCVK', '2324234', NULL, 'customer', 1, NULL, NULL, NULL, NULL, '2026-07-13 17:06:16', '2026-07-13 17:06:16'),
(14, 'Kevin OBrien', 'KevinBrien@gmail.com', '$2y$10$9O1AY7KBBKcaKTi8XqJyh.wKTsV15FkevAheOHGb7oaycEdAKDCVK', '2324234', NULL, 'customer', 1, NULL, NULL, NULL, NULL, '2026-07-13 17:06:16', '2026-07-13 17:06:16'),
(15, 'Michelle Patel', 'MichellePatel@gmail.com', '$2y$10$9O1AY7KBBKcaKTi8XqJyh.wKTsV15FkevAheOHGb7oaycEdAKDCVK', '2324234', NULL, 'customer', 1, NULL, NULL, NULL, NULL, '2026-07-13 17:06:16', '2026-07-13 17:06:16'),
(16, 'Christopher Lee', 'ChristopherLee@gmail.com', '$2y$10$9O1AY7KBBKcaKTi8XqJyh.wKTsV15FkevAheOHGb7oaycEdAKDCVK', '2324234', NULL, 'customer', 1, NULL, NULL, NULL, NULL, '2026-07-13 17:06:16', '2026-07-13 17:06:16'),
(17, 'Lauren Williams', 'catLaurenWilliamslin@gmail.com', '$2y$10$9O1AY7KBBKcaKTi8XqJyh.wKTsV15FkevAheOHGb7oaycEdAKDCVK', '2324234', NULL, 'customer', 1, NULL, NULL, NULL, NULL, '2026-07-13 17:06:16', '2026-07-13 17:06:16'),
(18, 'Daniel Garcia', 'catDanielGarcialin@gmail.com', '$2y$10$9O1AY7KBBKcaKTi8XqJyh.wKTsV15FkevAheOHGb7oaycEdAKDCVK', '2324234', NULL, 'customer', 1, NULL, NULL, NULL, NULL, '2026-07-13 17:06:16', '2026-07-13 17:06:16'),
(19, 'Stephanie Brown', 'stephanie.brown@example.com', '$2y$10$9O1AY7KBBKcaKTi8XqJyh.wKTsV15FkevAheOHGb7oaycEdAKDCVK', '2324234', NULL, 'customer', 1, NULL, NULL, NULL, NULL, '2026-07-13 17:06:16', '2026-07-13 17:06:16'),
(20, 'Andrew Davis', 'AndrewDavis@gmail.com', '$2y$10$9O1AY7KBBKcaKTi8XqJyh.wKTsV15FkevAheOHGb7oaycEdAKDCVK', '2324234', NULL, 'customer', 1, NULL, NULL, NULL, NULL, '2026-07-13 17:06:16', '2026-07-13 17:06:16'),
(21, 'Nicole Miller', 'NicoleMiller@gmail.com', '$2y$10$9O1AY7KBBKcaKTi8XqJyh.wKTsV15FkevAheOHGb7oaycEdAKDCVK', '2324234', NULL, 'customer', 1, NULL, NULL, NULL, NULL, '2026-07-13 17:06:16', '2026-07-13 17:06:16'),
(22, 'Brandon Moore', 'BrandonMoore@gmail.com', '$2y$10$9O1AY7KBBKcaKTi8XqJyh.wKTsV15FkevAheOHGb7oaycEdAKDCVK', '2324234', NULL, 'customer', 1, NULL, NULL, NULL, NULL, '2026-07-13 17:06:16', '2026-07-13 17:06:16'),
(23, 'Rachel Jackson', 'RachelJackson@gmail.com', '$2y$10$9O1AY7KBBKcaKTi8XqJyh.wKTsV15FkevAheOHGb7oaycEdAKDCVK', '2324234', NULL, 'customer', 1, NULL, NULL, NULL, NULL, '2026-07-13 17:06:16', '2026-07-13 17:06:16'),
(24, 'Tyler Harris', 'TylerHarris@gmail.com', '$2y$10$9O1AY7KBBKcaKTi8XqJyh.wKTsV15FkevAheOHGb7oaycEdAKDCVK', '2324234', NULL, 'customer', 1, NULL, NULL, NULL, NULL, '2026-07-13 17:06:16', '2026-07-13 17:06:16'),
(25, 'Megan Clark', 'MeganClark@gmail.com', '$2y$10$9O1AY7KBBKcaKTi8XqJyh.wKTsV15FkevAheOHGb7oaycEdAKDCVK', '2324234', NULL, 'customer', 1, NULL, NULL, NULL, NULL, '2026-07-13 17:06:16', '2026-07-13 17:06:16'),
(26, 'Tin Ednalan', 'tin@test.com', '$2y$10$yyUuqXQjP2h5if4/Lo6PdexilSsGA.UT174IVuJWi7JRCSXz0IqJu', '45345345', NULL, 'customer', 1, NULL, NULL, NULL, NULL, '2026-07-14 09:11:11', '2026-07-14 09:11:11'),
(27, 'Raizen Ednalan', 'raizen@gmail.com', '$2y$10$tJT1URPqXeX3nUmD7p/5BO/ImItA/agBMtLjx3hmsVPw1xZu2iZ4u', '3423434', NULL, 'customer', 1, NULL, NULL, NULL, NULL, '2026-07-15 09:56:31', '2026-07-15 09:56:31');

-- --------------------------------------------------------

--
-- Table structure for table `wishlists`
--

CREATE TABLE `wishlists` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `wishlists`
--

INSERT INTO `wishlists` (`id`, `user_id`, `product_id`, `created_at`, `updated_at`) VALUES
(2, 2, 13, '2026-07-14 09:38:37', '2026-07-14 09:38:37'),
(3, 2, 51, '2026-07-14 09:40:33', '2026-07-14 09:40:33'),
(4, 2, 43, '2026-07-14 09:42:58', '2026-07-14 09:42:58'),
(5, 27, 21, '2026-07-15 09:58:09', '2026-07-15 09:58:09'),
(6, 27, 17, '2026-07-15 09:58:25', '2026-07-15 09:58:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_id` (`cart_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `coupon_usages`
--
ALTER TABLE `coupon_usages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `coupon_id` (`coupon_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `inventory_logs`
--
ALTER TABLE `inventory_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_number` (`order_number`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `shipping_address_id` (`shipping_address_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sku` (`sku`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `brand_id` (`brand_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product_specifications`
--
ALTER TABLE `product_specifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_key_group` (`key`,`group`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_wishlist` (`user_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `coupon_usages`
--
ALTER TABLE `coupon_usages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory_logs`
--
ALTER TABLE `inventory_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=186;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `product_specifications`
--
ALTER TABLE `product_specifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=195;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `coupon_usages`
--
ALTER TABLE `coupon_usages`
  ADD CONSTRAINT `coupon_usages_ibfk_1` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `coupon_usages_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `coupon_usages_ibfk_3` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `inventory_logs`
--
ALTER TABLE `inventory_logs`
  ADD CONSTRAINT `inventory_logs_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notifications_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`shipping_address_id`) REFERENCES `addresses` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_specifications`
--
ALTER TABLE `product_specifications`
  ADD CONSTRAINT `product_specifications_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD CONSTRAINT `wishlists_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wishlists_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
