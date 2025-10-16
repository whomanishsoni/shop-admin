-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 16, 2025 at 11:53 AM
-- Server version: 9.1.0
-- PHP Version: 8.2.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravel`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

DROP TABLE IF EXISTS `activity_logs`;
CREATE TABLE IF NOT EXISTS `activity_logs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `action` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `activity_logs_user_id_foreign` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

DROP TABLE IF EXISTS `addresses`;
CREATE TABLE IF NOT EXISTS `addresses` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pincode` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_default` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `addresses_customer_id_foreign` (`customer_id`)
) ENGINE=MyISAM AUTO_INCREMENT=78 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`id`, `customer_id`, `name`, `address`, `city`, `state`, `pincode`, `country`, `is_default`, `created_at`, `updated_at`) VALUES
(61, 1, 'Rashad Franks', '762 North Nobel Freeway Aperiam id quidem vo', 'Aute quia sed volupt', '', 'Non nostrud ipsum v', 'India', 1, '2025-10-16 03:11:30', '2025-10-16 03:11:30'),
(77, 1, 'Fitzgerald Bruce', '31 West Fabien Boulevard Lorem ad ex aliquam', 'Iusto rem aliquip do', '', '311001', 'India', 0, '2025-10-16 05:36:08', '2025-10-16 05:36:08'),
(76, 1, 'Kermit Hoffman', '74 Nobel Lane Tempor incidunt odi', 'Eu pariatur Quaerat', '', '311001', 'India', 0, '2025-10-16 05:34:13', '2025-10-16 05:34:13'),
(74, 1, 'Alden Walton', '621 White First Court Et in ut accusantium', 'Assumenda rerum anim', '', 'Quia ut ipsam qui se', 'India', 0, '2025-10-16 03:31:04', '2025-10-16 03:31:04'),
(75, 1, 'Chancellor Perry', '22 North Cowley Avenue Tempora quia ut volu', 'Nulla pariatur Exce', '', 'Exercitationem elit', 'India', 0, '2025-10-16 03:43:38', '2025-10-16 03:43:38');

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

DROP TABLE IF EXISTS `banners`;
CREATE TABLE IF NOT EXISTS `banners` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blog_categories`
--

DROP TABLE IF EXISTS `blog_categories`;
CREATE TABLE IF NOT EXISTS `blog_categories` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `blog_categories_slug_unique` (`slug`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blog_categories`
--

INSERT INTO `blog_categories` (`id`, `name`, `slug`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'sdf', 'sdf', 'sdfsfd', 1, '2025-10-13 22:40:28', '2025-10-13 22:40:28');

-- --------------------------------------------------------

--
-- Table structure for table `blog_comments`
--

DROP TABLE IF EXISTS `blog_comments`;
CREATE TABLE IF NOT EXISTS `blog_comments` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `blog_post_id` bigint UNSIGNED NOT NULL,
  `customer_id` bigint UNSIGNED NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `approved` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `blog_comments_blog_post_id_foreign` (`blog_post_id`),
  KEY `blog_comments_customer_id_foreign` (`customer_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blog_posts`
--

DROP TABLE IF EXISTS `blog_posts`;
CREATE TABLE IF NOT EXISTS `blog_posts` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `blog_category_id` bigint UNSIGNED NOT NULL,
  `author_id` bigint UNSIGNED NOT NULL,
  `featured_image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `blog_posts_slug_unique` (`slug`),
  KEY `blog_posts_blog_category_id_foreign` (`blog_category_id`),
  KEY `blog_posts_author_id_foreign` (`author_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blog_posts`
--

INSERT INTO `blog_posts` (`id`, `title`, `slug`, `content`, `blog_category_id`, `author_id`, `featured_image`, `status`, `created_at`, `updated_at`) VALUES
(1, 'sdf', 'sdf', '<p>sdfsdf</p>', 1, 1, 'blog-posts/XkZkwHARxxL0KgstlyJWmu0LDZEY1vYzsiGr6jhD.jpg', 'published', '2025-10-13 22:40:53', '2025-10-13 22:40:53');

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

DROP TABLE IF EXISTS `brands`;
CREATE TABLE IF NOT EXISTS `brands` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `brands_slug_unique` (`slug`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`, `slug`, `image`, `status`, `created_at`, `updated_at`) VALUES
(5, 'Mandir', 'mandir', NULL, 1, '2025-10-13 05:17:18', '2025-10-13 05:17:18'),
(3, 'Rangoli', 'rangoli', NULL, 1, '2025-10-13 05:14:49', '2025-10-13 05:14:49'),
(4, 'Radhika', 'radhika', NULL, 1, '2025-10-13 05:17:01', '2025-10-13 05:17:01'),
(6, 'Neeru\'s', 'neeru-s', NULL, 1, '2025-10-13 05:17:43', '2025-10-13 05:17:43'),
(7, 'Kashish', 'kashish', NULL, 1, '2025-10-13 05:18:02', '2025-10-13 05:18:02'),
(8, 'Kalanjali', 'kalanjali', NULL, 1, '2025-10-13 05:18:40', '2025-10-13 05:18:40'),
(9, 'Kalamandir', 'kalamandir', NULL, 1, '2025-10-13 05:18:56', '2025-10-13 05:18:56'),
(10, 'Sri Lakshmi', 'sri-lakshmi', NULL, 1, '2025-10-13 05:19:36', '2025-10-13 05:19:36');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_slug_unique` (`slug`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `image`, `order`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Women', 'women', 'women', 'categories/8BzrjjGHH2vLSUgcJm5bGf1QRgVa4g9w2wJUJyj4.jpg', 0, 1, '2025-10-11 01:30:22', '2025-10-11 01:30:51'),
(2, 'Men', 'men', 'men', 'categories/y9IbjasZyhl8H1luR4JHm5Bmm2sVTZpwPB0LA9HG.jpg', 0, 1, '2025-10-11 01:30:42', '2025-10-11 01:30:42');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

DROP TABLE IF EXISTS `coupons`;
CREATE TABLE IF NOT EXISTS `coupons` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` decimal(10,2) NOT NULL,
  `usage_limit` int DEFAULT NULL,
  `used` int NOT NULL DEFAULT '0',
  `valid_from` date DEFAULT NULL,
  `valid_to` date DEFAULT NULL,
  `min_purchase` decimal(10,2) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `coupons_code_unique` (`code`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `code`, `type`, `value`, `usage_limit`, `used`, `valid_from`, `valid_to`, `min_purchase`, `status`, `created_at`, `updated_at`) VALUES
(3, 'DIWALI50', 'fixed', 100.00, 100, 1, '2025-10-16', '2025-10-31', 1000.00, 1, '2025-10-16 05:57:10', '2025-10-16 05:58:39');

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

DROP TABLE IF EXISTS `currencies`;
CREATE TABLE IF NOT EXISTS `currencies` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `symbol` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `exchange_rate` decimal(10,4) NOT NULL DEFAULT '1.0000',
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `currencies_code_unique` (`code`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`id`, `code`, `name`, `symbol`, `exchange_rate`, `is_default`, `status`, `created_at`, `updated_at`) VALUES
(1, 'USD', 'US Dollar', '$', 1.0000, 1, 1, '2025-10-11 01:01:40', '2025-10-11 01:01:40'),
(2, 'INR', 'Indian Rupee', '₹', 83.0000, 0, 1, '2025-10-11 01:01:40', '2025-10-11 01:01:40');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
CREATE TABLE IF NOT EXISTS `customers` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alternative_contact_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `home_address` text COLLATE utf8mb4_unicode_ci,
  `shipping_address` text COLLATE utf8mb4_unicode_ci,
  `office_address` text COLLATE utf8mb4_unicode_ci,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pincode` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `customers_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `first_name`, `last_name`, `email`, `password`, `contact_no`, `alternative_contact_no`, `home_address`, `shipping_address`, `office_address`, `city`, `state`, `pincode`, `country`, `created_at`, `updated_at`, `remember_token`) VALUES
(1, 'manish', 'soni', 'whomanishsoni@gmail.com', '$2y$12$GY1BfFcisgiiNJeUEU7omeGefp6A9VdKgSAG7prE4J5ooD5nZsa.e', '9460966996', '9460966996', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-11 01:02:17', '2025-10-13 06:58:13', NULL),
(2, 'Kadeem', 'Gilbert', 'whomanishsonii@gmail.com', '$2y$12$qFbf20bsAtwhAVztj3TPE.tPCUZv4cfmoP53NoygWz8w8PU.BY7UG', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-11 02:59:00', '2025-10-11 02:59:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `email_templates`
--

DROP TABLE IF EXISTS `email_templates`;
CREATE TABLE IF NOT EXISTS `email_templates` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `variables` json DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `email_templates`
--

INSERT INTO `email_templates` (`id`, `name`, `subject`, `body`, `variables`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Welcome Email', 'Welcome to {{site_name}}!', '<h1>Welcome {{user_name}}!</h1><p>Thank you for registering at {{site_name}}. We are excited to have you on board.</p><p>Best regards,<br>{{site_name}} Team</p>', '\"[\\\"{{user_name}}\\\",\\\"{{user_email}}\\\",\\\"{{site_name}}\\\",\\\"{{site_url}}\\\"]\"', 1, '2025-10-11 01:01:40', '2025-10-11 01:01:40'),
(2, 'Forgot Password', 'Reset Your Password - {{site_name}}', '<h1>Password Reset Request</h1><p>Hi {{user_name}},</p><p>You have requested to reset your password. Click the link below to reset:</p><p><a href=\"{{reset_link}}\">Reset Password</a></p><p>This link will expire in 60 minutes.</p><p>If you did not request this, please ignore this email.</p><p>Best regards,<br>{{site_name}} Team</p>', '\"[\\\"{{user_name}}\\\",\\\"{{user_email}}\\\",\\\"{{reset_link}}\\\",\\\"{{site_name}}\\\"]\"', 1, '2025-10-11 01:01:40', '2025-10-11 01:01:40'),
(3, 'Order Confirmation', 'Order Confirmation #{{order_number}} - {{site_name}}', '<h1>Thank you for your order!</h1><p>Hi {{customer_name}},</p><p>Your order #{{order_number}} has been confirmed and is being processed.</p><h3>Order Details:</h3><p>Order Number: {{order_number}}<br>Order Total: {{order_total}}<br>Payment Method: {{payment_method}}<br>Shipping Address: {{shipping_address}}</p><p>You can track your order status from your account dashboard.</p><p>Best regards,<br>{{site_name}} Team</p>', '\"[\\\"{{customer_name}}\\\",\\\"{{order_number}}\\\",\\\"{{order_total}}\\\",\\\"{{payment_method}}\\\",\\\"{{shipping_address}}\\\",\\\"{{site_name}}\\\"]\"', 1, '2025-10-11 01:01:40', '2025-10-11 01:01:40'),
(4, 'Order Shipped', 'Your Order #{{order_number}} Has Been Shipped', '<h1>Your order is on the way!</h1><p>Hi {{customer_name}},</p><p>Great news! Your order #{{order_number}} has been shipped and is on its way to you.</p><h3>Shipping Details:</h3><p>Tracking Number: {{tracking_number}}<br>Carrier: {{carrier_name}}<br>Estimated Delivery: {{estimated_delivery}}</p><p>You can track your package using the tracking number above.</p><p>Best regards,<br>{{site_name}} Team</p>', '\"[\\\"{{customer_name}}\\\",\\\"{{order_number}}\\\",\\\"{{tracking_number}}\\\",\\\"{{carrier_name}}\\\",\\\"{{estimated_delivery}}\\\",\\\"{{site_name}}\\\"]\"', 1, '2025-10-11 01:01:40', '2025-10-11 01:01:40'),
(5, 'Order Delivered', 'Your Order #{{order_number}} Has Been Delivered', '<h1>Order Delivered Successfully!</h1><p>Hi {{customer_name}},</p><p>Your order #{{order_number}} has been delivered successfully.</p><p>We hope you love your purchase! If you have any questions or concerns, please don\'t hesitate to contact us.</p><p>Please take a moment to leave a review of your products.</p><p>Thank you for shopping with us!</p><p>Best regards,<br>{{site_name}} Team</p>', '\"[\\\"{{customer_name}}\\\",\\\"{{order_number}}\\\",\\\"{{site_name}}\\\"]\"', 1, '2025-10-11 01:01:40', '2025-10-11 01:01:40'),
(6, 'Order Cancelled', 'Order #{{order_number}} Cancelled - {{site_name}}', '<h1>Order Cancelled</h1><p>Hi {{customer_name}},</p><p>Your order #{{order_number}} has been cancelled as per your request.</p><h3>Cancellation Details:</h3><p>Order Number: {{order_number}}<br>Cancellation Reason: {{cancellation_reason}}<br>Refund Status: {{refund_status}}</p><p>If you paid online, your refund will be processed within 5-7 business days.</p><p>If you have any questions, please contact our support team.</p><p>Best regards,<br>{{site_name}} Team</p>', '\"[\\\"{{customer_name}}\\\",\\\"{{order_number}}\\\",\\\"{{cancellation_reason}}\\\",\\\"{{refund_status}}\\\",\\\"{{site_name}}\\\"]\"', 1, '2025-10-11 01:01:40', '2025-10-11 01:01:40'),
(7, 'New Customer Registration', 'Verify Your Email - {{site_name}}', '<h1>Welcome to {{site_name}}!</h1><p>Hi {{user_name}},</p><p>Thank you for registering with us. Please verify your email address by clicking the link below:</p><p><a href=\"{{verification_link}}\">Verify Email Address</a></p><p>This link will expire in 24 hours.</p><p>If you did not create an account, please ignore this email.</p><p>Best regards,<br>{{site_name}} Team</p>', '\"[\\\"{{user_name}}\\\",\\\"{{user_email}}\\\",\\\"{{verification_link}}\\\",\\\"{{site_name}}\\\"]\"', 1, '2025-10-11 01:01:40', '2025-10-11 01:01:40'),
(8, 'Low Stock Alert', 'Low Stock Alert - {{product_name}}', '<h1>Low Stock Alert</h1><p>Hello Admin,</p><p>The following product is running low on stock:</p><p>Product: {{product_name}}<br>SKU: {{product_sku}}<br>Current Stock: {{current_stock}}<br>Threshold: {{threshold}}</p><p>Please restock soon to avoid going out of stock.</p>', '\"[\\\"{{product_name}}\\\",\\\"{{product_sku}}\\\",\\\"{{current_stock}}\\\",\\\"{{threshold}}\\\"]\"', 1, '2025-10-11 01:01:40', '2025-10-11 01:01:40');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

DROP TABLE IF EXISTS `faqs`;
CREATE TABLE IF NOT EXISTS `faqs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `question` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `faqs_slug_unique` (`slug`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

DROP TABLE IF EXISTS `languages`;
CREATE TABLE IF NOT EXISTS `languages` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `locale` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `direction` enum('ltr','rtl') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `languages_code_unique` (`code`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `code`, `locale`, `direction`, `status`, `created_at`, `updated_at`) VALUES
(1, 'English', 'en', 'en_US', 'ltr', 1, '2025-10-11 01:01:40', '2025-10-11 01:01:40'),
(2, 'Hindi', 'hi', 'hi_IN', 'ltr', 1, '2025-10-11 01:01:40', '2025-10-11 01:01:40');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_10_06_152615_create_products_table', 1),
(5, '2025_10_06_152616_create_customers_table', 1),
(6, '2025_10_06_152616_create_orders_table', 1),
(7, '2025_10_06_153245_create_categories_table', 1),
(8, '2025_10_06_153245_create_subcategories_table', 1),
(9, '2025_10_06_153246_create_product_attributes_table', 1),
(10, '2025_10_06_153246_create_product_images_table', 1),
(11, '2025_10_06_153247_create_product_attribute_values_table', 1),
(12, '2025_10_06_153247_create_product_variants_table', 1),
(13, '2025_10_06_153248_create_order_items_table', 1),
(14, '2025_10_06_153249_create_coupons_table', 1),
(15, '2025_10_06_153249_create_product_reviews_table', 1),
(16, '2025_10_06_153249_create_transactions_table', 1),
(17, '2025_10_06_153250_create_shipping_methods_table', 1),
(18, '2025_10_06_153251_create_shipping_zones_table', 1),
(19, '2025_10_06_153251_create_taxes_table', 1),
(20, '2025_10_06_153252_create_currencies_table', 1),
(21, '2025_10_06_153252_create_payment_gateways_table', 1),
(22, '2025_10_06_153253_create_ticket_replies_table', 1),
(23, '2025_10_06_153253_create_tickets_table', 1),
(24, '2025_10_06_153254_create_settings_table', 1),
(25, '2025_10_06_153254_create_sliders_table', 1),
(26, '2025_10_06_153255_create_email_templates_table', 1),
(27, '2025_10_06_153256_create_faqs_table', 1),
(28, '2025_10_06_153256_create_languages_table', 1),
(29, '2025_10_06_153257_create_blog_categories_table', 1),
(30, '2025_10_06_153257_create_blog_posts_table', 1),
(31, '2025_10_06_153258_create_blog_comments_table', 1),
(32, '2025_10_06_153259_create_banners_table', 1),
(33, '2025_10_06_153259_create_pages_table', 1),
(34, '2025_10_06_153259_create_subscribers_table', 1),
(35, '2025_10_06_153300_create_activity_logs_table', 1),
(36, '2025_10_06_153301_create_notifications_table', 1),
(37, '2025_10_08_124631_create_addresses_table', 1),
(39, '2025_10_13_091353_create_brands_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_user_id_foreign` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_id` bigint UNSIGNED NOT NULL,
  `subtotal` decimal(10,2) NOT NULL DEFAULT '0.00',
  `tax` decimal(10,2) NOT NULL DEFAULT '0.00',
  `shipping` decimal(10,2) NOT NULL DEFAULT '0.00',
  `discount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `payment_method` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `shipping_address` text COLLATE utf8mb4_unicode_ci,
  `billing_address` text COLLATE utf8mb4_unicode_ci,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `orders_order_number_unique` (`order_number`),
  KEY `orders_customer_id_foreign` (`customer_id`)
) ENGINE=MyISAM AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_number`, `customer_id`, `subtotal`, `tax`, `shipping`, `discount`, `total`, `status`, `payment_method`, `payment_status`, `shipping_address`, `billing_address`, `notes`, `created_at`, `updated_at`) VALUES
(45, 'ORD-2EQC6TTR', 1, 1840.00, 331.20, 0.00, 100.00, 2071.20, 'pending', 'cod', 'pending', '31 West Fabien Boulevard Lorem ad ex aliquam, Iusto rem aliquip do, 311001, India', '762 North Nobel Freeway Aperiam id quidem vo, Aute quia sed volupt, Non nostrud ipsum v, India', NULL, '2025-10-16 05:58:39', '2025-10-16 06:06:05');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
CREATE TABLE IF NOT EXISTS `order_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int NOT NULL,
  `attributes` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `name`, `price`, `quantity`, `attributes`, `created_at`, `updated_at`) VALUES
(42, 45, 1, 'Rhysley Rayon Red Kurti', 1840.00, 1, '{\"size\": \"L\", \"color\": \"Yellow\"}', '2025-10-16 05:58:39', '2025-10-16 05:58:39');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
CREATE TABLE IF NOT EXISTS `pages` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pages_slug_unique` (`slug`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `title`, `slug`, `content`, `meta_title`, `meta_description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'About Us', 'about-us', '<p>Welcome to <strong>Vyuga</strong>, your ultimate online destination for stylish, high-quality women&rsquo;s clothing. We believe fashion is more than just dressing up &mdash; it&rsquo;s a way to express your individuality, confidence, and personality. Our mission is to bring you a thoughtfully curated collection of kurtis, tops, and trendy apparel that blends comfort, elegance, and affordability.</p>\r\n\r\n<p>Founded with a passion for style and customer satisfaction, <strong>Vyuga </strong>was created to make fashion accessible to every woman, no matter where she lives. Whether you&rsquo;re looking for something chic for the office, casual for a day out, or elegant for festive occasions, our versatile designs cater to every mood and moment.</p>\r\n\r\n<p>At <strong>Vyuga</strong>, we prioritize quality and craftsmanship. Each product in our collection is selected for its premium fabrics, flattering fits, and on-trend styles. We work closely with trusted manufacturers and designers to ensure that every piece meets our high standards before it reaches you.</p>\r\n\r\n<p>Shopping at <strong>Vyuga </strong>is more than just a purchase &mdash; it&rsquo;s an experience. Our easy-to-use online store, secure payment options, and fast delivery ensure a smooth and enjoyable shopping journey. We also provide responsive customer support, because your satisfaction is our priority.</p>\r\n\r\n<p>What makes us special? It&rsquo;s our commitment to combining style with comfort, trend with tradition, and quality with affordability. We&rsquo;re not just selling clothes; we&rsquo;re helping you build a wardrobe that reflects who you are.</p>\r\n\r\n<p>Join thousands of women who trust <strong>Vyuga </strong>to keep them fashionable all year round. Stay connected through our newsletter to get early access to new collections, exclusive offers, and style inspiration.</p>\r\n\r\n<p>At <strong>Vyuga</strong>, your style is our passion, and we&rsquo;re here to make sure you always look and feel your best.</p>\r\n\r\n<p><strong>Your style. Your story</strong>. <strong>Vyuga</strong>.</p>', 'About Us - Vyuga', 'Discover Vyuga, your go-to online store for stylish and high-quality women’s clothing. Explore our curated collection of kurtis, tops, and trendy apparel designed for comfort, elegance, and affordability.', 1, '2025-10-11 03:31:07', '2025-10-11 03:43:19'),
(2, 'Privacy Policy', 'privacy-policy', '<p>At Vyuga, we strive to ensure your satisfaction with every purchase. This Refund Policy outlines the conditions under which you may be eligible for a refund. Please review it carefully before making a purchase.</p>\r\n\r\n<p>Eligibility for Refunds: Refunds are available only for defective, damaged, or incorrect items received. Products must be returned within 7 days of delivery in their original condition&mdash;unused, unwashed, and with tags and packaging intact. Non-returnable items include sale products, personalized orders, and items marked as non-refundable.</p>\r\n\r\n<p>Refund Process: To request a refund, contact us at info@vyuga.in or call +91-9876543210 within 7 days of delivery. Provide your order number and a brief description of the issue. Once approved, we will initiate a refund to your original payment method within 7-10 business days after receiving the returned item.</p>\r\n\r\n<p>Non-Refundable Cases: Refunds will not be issued for change of mind, incorrect size selection, or items damaged due to improper handling after delivery. Shipping costs are non-refundable unless the error is on our part.</p>\r\n\r\n<p>Exchanges: If you prefer an exchange instead of a refund, we will replace the item with an available equivalent, subject to stock availability. Exchange requests follow the same 7-day return window.</p>\r\n\r\n<p>Policy Updates: Vyuga reserves the right to modify this Refund Policy at any time. Changes will be posted on this page with an updated effective date.</p>\r\n\r\n<p>For any questions or assistance, contact us at:<br />\r\nEmail: info@vyuga.in | Phone: +91-9876543210</p>', 'Privacy Policy - Vyuga', 'Learn how Vyuga protects your personal information. Our Privacy Policy explains data collection, usage, security, and your rights when shopping on our online fashion store.', 1, '2025-10-11 03:48:36', '2025-10-11 03:48:36'),
(3, 'Refund Policy', 'refund-policy', '<p>At Vyuga, we strive to ensure your satisfaction with every purchase. This Refund Policy outlines the conditions under which you may be eligible for a refund. Please review it carefully before making a purchase.</p>\r\n\r\n<p><strong>Eligibility for Refunds</strong>: Refunds are available only for defective, damaged, or incorrect items received. Products must be returned within 7 days of delivery in their original condition&mdash;unused, unwashed, and with tags and packaging intact. Non-returnable items include sale products, personalized orders, and items marked as non-refundable.</p>\r\n\r\n<p><strong>Refund Process</strong>: To request a refund, contact us at <strong>info@vyuga.in</strong> or call <strong>+91-9876543210</strong> within 7 days of delivery. Provide your order number and a brief description of the issue. Once approved, we will initiate a refund to your original payment method within 7-10 business days after receiving the returned item.</p>\r\n\r\n<p><strong>Non-Refundable Cases</strong>: Refunds will not be issued for change of mind, incorrect size selection, or items damaged due to improper handling after delivery. Shipping costs are non-refundable unless the error is on our part.</p>\r\n\r\n<p><strong>Exchanges</strong>: If you prefer an exchange instead of a refund, we will replace the item with an available equivalent, subject to stock availability. Exchange requests follow the same 7-day return window.</p>\r\n\r\n<p><strong>Policy Updates</strong>: Vyuga reserves the right to modify this Refund Policy at any time. Changes will be posted on this page with an updated effective date.</p>\r\n\r\n<p>For any questions or assistance, contact us at:<br />\r\nEmail: <strong>info@vyuga.in</strong> | Phone: +<strong>91-9876543210</strong></p>', 'Refund Policy - Vyuga', 'Understand Vyuga’s Refund Policy for returns and exchanges. Learn the conditions for refunds, non-refunded items, and how to process a return for your purchase.', 1, '2025-10-11 03:49:42', '2025-10-11 05:23:43'),
(4, 'Shipping Policy', 'shipping-policy', '<p>Vyuga is committed to delivering your orders efficiently. This Shipping Policy outlines our shipping procedures and estimated delivery times. Please read it carefully before placing an order.</p>\r\n\r\n<p>Shipping Rates: Shipping charges are calculated at checkout based on your location and order value. We offer free shipping on orders above Rs. 999 within India. Additional charges may apply for international orders.</p>\r\n\r\n<p>Processing Time: Orders are typically processed within 1-2 business days. Processing time may vary during sales or festive seasons.</p>\r\n\r\n<p>Delivery Time: Standard delivery within India takes 3-7 business days, depending on your location. International shipping may take 10-20 business days. Delays may occur due to customs clearance or unforeseen circumstances.</p>\r\n\r\n<p>Shipping Methods: We partner with reliable courier services to ensure safe delivery. You will receive a tracking number via email once your order is dispatched.</p>\r\n\r\n<p>Non-Deliverable Areas: Vyuga reserves the right to cancel orders for remote or non-serviceable areas. You will be notified and refunded if applicable.</p>\r\n\r\n<p>Damaged or Lost Shipments: If your order arrives damaged or is lost in transit, contact us at info@vyuga.in or +91-9876543210 within 7 days of the expected delivery date. We will investigate and arrange a replacement or refund.</p>\r\n\r\n<p>Policy Updates: Vyuga may update this Shipping Policy as needed. Changes will be reflected on this page with an updated effective date.</p>\r\n\r\n<p>For any shipping-related queries, contact us at:<br />\r\nEmail: info@vyuga.in | Phone: +91-9876543210</p>', 'Shipping Policy - Vyuga', 'Explore Vyuga’s Shipping Policy for details on shipping rates, processing times, delivery schedules, and handling of damaged or lost shipments for your orders.', 1, '2025-10-11 03:50:28', '2025-10-11 03:50:28'),
(5, 'Terms & Conditions', 'terms-conditions', '<p>Welcome to Vyuga. By accessing or using our website (the &ldquo;Site&rdquo;) and purchasing products from our online store, you agree to comply with and be bound by these Terms &amp; Conditions. Please read them carefully before placing an order.</p>\r\n\r\n<p>General: Vyuga is an online fashion e-commerce portal offering women&rsquo;s clothing, including kurtis, tops, and other apparel. By using our Site, you confirm that you are at least 18 years old or have parental/guardian consent to make purchases.</p>\r\n\r\n<p>Product Information: We strive to ensure that all product descriptions, images, and prices are accurate. However, slight variations in color, fabric, or design may occur due to photography or display settings. Vyuga reserves the right to modify or discontinue products without prior notice.</p>\r\n\r\n<p>Orders &amp; Payments: All orders placed on the Site are subject to acceptance and availability. Prices are listed in INR and include applicable taxes unless otherwise stated. Payment must be made in full via our secure payment gateways before your order is processed.</p>\r\n\r\n<p>Shipping &amp; Delivery: We aim to dispatch orders promptly. Delivery times may vary depending on your location and courier services. Vyuga is not responsible for delays beyond our control.</p>\r\n\r\n<p>Returns &amp; Exchanges: We accept returns and exchanges only if the product is unused, unwashed, and in its original packaging with tags intact. Requests must be made within 7 days of delivery. Certain items, such as sale products or personalized orders, are non-returnable. Please refer to our Return Policy for complete details.</p>\r\n\r\n<p>Intellectual Property: All content on the Site, including images, text, graphics, and logos, is the property of Vyuga and is protected by copyright laws. Unauthorized use is strictly prohibited.</p>\r\n\r\n<p>Limitation of Liability: Vyuga is not liable for any indirect, incidental, or consequential damages arising from the use of our Site or products.</p>\r\n\r\n<p>Governing Law: These Terms &amp; Conditions are governed by the laws of India. Any disputes shall be subject to the exclusive jurisdiction of the courts in Hyderabad, Telangana.</p>\r\n\r\n<p>Contact Us: For any questions regarding this policy, contact us at:<br />\r\nEmail: info@vyuga.in | Phone: +91-9876543210</p>', 'Terms & Conditions - Vyuga', 'Review Vyuga’s Terms & Conditions for using our online store. Learn about orders, payments, shipping, returns, and intellectual property policies before shopping.', 1, '2025-10-11 03:51:12', '2025-10-11 03:51:12');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_gateways`
--

DROP TABLE IF EXISTS `payment_gateways`;
CREATE TABLE IF NOT EXISTS `payment_gateways` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gateway_key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `api_key` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `api_secret` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `config` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `payment_gateways_gateway_key_unique` (`gateway_key`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_gateways`
--

INSERT INTO `payment_gateways` (`id`, `name`, `gateway_key`, `api_key`, `api_secret`, `status`, `config`, `created_at`, `updated_at`) VALUES
(1, 'Stripe', 'stripe', '', '', 0, '\"{\\\"publishable_key\\\":\\\"\\\",\\\"currency\\\":\\\"usd\\\",\\\"description\\\":\\\"Credit card payment via Stripe\\\"}\"', '2025-10-11 01:01:40', '2025-10-11 01:01:40'),
(2, 'PayPal', 'paypal', '', '', 0, '\"{\\\"client_id\\\":\\\"\\\",\\\"mode\\\":\\\"sandbox\\\",\\\"currency\\\":\\\"usd\\\",\\\"description\\\":\\\"PayPal payment gateway\\\"}\"', '2025-10-11 01:01:40', '2025-10-11 01:01:40'),
(3, 'Razorpay', 'razorpay', '', '', 0, '\"{\\\"key_id\\\":\\\"\\\",\\\"key_secret\\\":\\\"\\\",\\\"currency\\\":\\\"INR\\\",\\\"description\\\":\\\"Razorpay payment gateway for India\\\"}\"', '2025-10-11 01:01:40', '2025-10-11 01:01:40'),
(5, 'Cash on Delivery', 'cod', '', '', 1, '{\"description\": \"Pay when you receive the order\", \"instructions\": \"Please have exact amount ready for delivery\", \"additional_fee\": 0}', '2025-10-15 06:43:28', '2025-10-15 06:43:28');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `short_description` text COLLATE utf8mb4_unicode_ci,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `sale_price` decimal(10,2) DEFAULT NULL,
  `stock` int NOT NULL DEFAULT '0',
  `sku` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` bigint UNSIGNED DEFAULT NULL,
  `subcategory_id` bigint UNSIGNED DEFAULT NULL,
  `brand_id` bigint UNSIGNED DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `meta_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `meta_keywords` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_slug_unique` (`slug`),
  UNIQUE KEY `products_sku_unique` (`sku`),
  KEY `products_category_id_foreign` (`category_id`),
  KEY `products_subcategory_id_foreign` (`subcategory_id`),
  KEY `products_brand_id_foreign` (`brand_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `slug`, `description`, `short_description`, `price`, `sale_price`, `stock`, `sku`, `category_id`, `subcategory_id`, `brand_id`, `status`, `meta_title`, `meta_description`, `meta_keywords`, `created_at`, `updated_at`) VALUES
(1, 'Rhysley Rayon Red Kurti', 'rhysley-rayon-red-kurti', NULL, 'Rhysley Rayon Red Kurti', 2399.00, 1840.00, 10, 'PROD-VEVC1LZN', 1, 1, 3, 'active', NULL, NULL, NULL, '2025-10-11 02:30:34', '2025-10-13 06:33:43'),
(2, 'Women\'s Rayon Viscose Anarkali Printed Kurta', 'women-s-rayon-viscose-anarkali-printed-kurta', '<p>Be a picture of grace and beauty in this beautiful and elegant red Bandhej print kurta. With this red kurti for women, you would never fail to make an impression.</p>', 'Be a picture of grace and beauty in this beautiful and elegant red Bandhej print kurta. With this red kurti for women, you would never fail to make an impression.', 2000.00, 1200.00, 10, 'PROD-I576V1J7', 1, 2, 7, 'active', NULL, NULL, NULL, '2025-10-11 07:05:06', '2025-10-13 06:33:52');

-- --------------------------------------------------------

--
-- Table structure for table `product_attributes`
--

DROP TABLE IF EXISTS `product_attributes`;
CREATE TABLE IF NOT EXISTS `product_attributes` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `values` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_attributes`
--

INSERT INTO `product_attributes` (`id`, `name`, `display_name`, `values`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Size', 'size', '[\"XS\",\"S\",\"M\",\"L\",\"XL\",\"XXL\"]', 1, '2025-10-13 01:32:44', '2025-10-13 01:32:44'),
(2, 'Color', 'color', '[\"Red\",\"Green\",\"Blue\",\"White\",\"Yellow\"]', 1, '2025-10-13 01:33:27', '2025-10-13 01:33:27');

-- --------------------------------------------------------

--
-- Table structure for table `product_attribute_values`
--

DROP TABLE IF EXISTS `product_attribute_values`;
CREATE TABLE IF NOT EXISTS `product_attribute_values` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` bigint UNSIGNED NOT NULL,
  `attribute_id` bigint UNSIGNED NOT NULL,
  `value` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_attribute_values_product_id_foreign` (`product_id`),
  KEY `product_attribute_values_attribute_id_foreign` (`attribute_id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_attribute_values`
--

INSERT INTO `product_attribute_values` (`id`, `product_id`, `attribute_id`, `value`, `created_at`, `updated_at`) VALUES
(13, 1, 1, '[\"XS\",\"S\",\"M\",\"L\",\"XL\",\"XXL\"]', '2025-10-14 07:02:39', '2025-10-14 07:02:39'),
(8, 2, 2, '[\"Green\",\"White\",\"Yellow\"]', '2025-10-13 06:33:52', '2025-10-13 06:33:52'),
(7, 2, 1, '[\"S\",\"M\",\"L\",\"XL\"]', '2025-10-13 06:33:52', '2025-10-13 06:33:52'),
(14, 1, 2, '[\"Red\",\"Blue\",\"White\",\"Yellow\"]', '2025-10-14 07:02:39', '2025-10-14 07:02:39');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

DROP TABLE IF EXISTS `product_images`;
CREATE TABLE IF NOT EXISTS `product_images` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` bigint UNSIGNED NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alt_text` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  `is_primary` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_images_product_id_foreign` (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image`, `alt_text`, `sort_order`, `is_primary`, `created_at`, `updated_at`) VALUES
(1, 1, 'products/aftyoTmIsw9ZepjDDhqvB0ndpZZEgt2yUTplWFOJ.jpg', NULL, 0, 1, '2025-10-11 02:30:34', '2025-10-11 02:30:34'),
(2, 1, 'products/V78hNv1B0QJLXH1NrJmoQ2XjMt50ySy5bFQN37sd.jpg', NULL, 1, 0, '2025-10-11 06:44:46', '2025-10-11 06:44:46'),
(3, 1, 'products/uveuT92Q3k0DZhKF7IXl5TSEf2JPOEDYWcxvQxKE.jpg', NULL, 2, 0, '2025-10-11 06:44:46', '2025-10-11 06:44:46'),
(4, 2, 'products/jpoP4U3MWXqW9ZcEHJSQOqvLJoT5faUrspm3XNor.jpg', NULL, 0, 1, '2025-10-11 07:05:06', '2025-10-11 07:05:06'),
(5, 2, 'products/V0VisT2ahEUutxMx5MQXmrWvcPKabkrdQ3fs8ToR.jpg', NULL, 1, 0, '2025-10-11 07:05:06', '2025-10-11 07:05:06'),
(6, 1, 'products/IQwGTsKGvgPmUD3p6LahRFc969p4hNIg0ZXPSAmo.png', NULL, 3, 0, '2025-10-14 07:02:39', '2025-10-14 07:02:39'),
(7, 1, 'products/qm6rYJu6M49gglxTnLw1nsHOgcc6hItQQD5iE7Nn.png', NULL, 4, 0, '2025-10-14 07:02:39', '2025-10-14 07:02:39'),
(8, 1, 'products/bHz19Khu0PnaoksAcvDdpTwWHC6l5vFvSyf0vwEA.jpg', NULL, 5, 0, '2025-10-14 07:02:39', '2025-10-14 07:02:39'),
(9, 1, 'products/M873Yu7zZ2SrdGq1I8nw7oe8v6EQ0Q78lNVB2yVZ.jpg', NULL, 6, 0, '2025-10-14 07:02:39', '2025-10-14 07:02:39');

-- --------------------------------------------------------

--
-- Table structure for table `product_reviews`
--

DROP TABLE IF EXISTS `product_reviews`;
CREATE TABLE IF NOT EXISTS `product_reviews` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` bigint UNSIGNED NOT NULL,
  `customer_id` bigint UNSIGNED NOT NULL,
  `rating` int NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci,
  `approved` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_reviews_product_id_foreign` (`product_id`),
  KEY `product_reviews_customer_id_foreign` (`customer_id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_reviews`
--

INSERT INTO `product_reviews` (`id`, `product_id`, `customer_id`, `rating`, `comment`, `approved`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 5, 'Excellent product! The quality exceeded my expectations. Fast shipping and great customer service.', 1, '2025-10-13 08:59:40', '2025-10-13 08:59:40'),
(2, 2, 1, 4, 'Good product overall. Works as described but took longer to arrive than expected.', 1, '2025-10-13 08:59:40', '2025-10-13 08:59:40'),
(3, 1, 2, 3, 'Average product. Does the job but nothing special. The packaging could be better.', 1, '2025-10-13 08:59:40', '2025-10-13 08:59:40'),
(4, 3, 2, 5, 'Absolutely love this! Better than I imagined. Will definitely purchase again.', 1, '2025-10-13 08:59:40', '2025-10-13 08:59:40'),
(5, 4, 1, 2, 'Not happy with the quality. Product arrived damaged and customer service was unhelpful.', 0, '2025-10-13 08:59:40', '2025-10-13 08:59:40'),
(6, 5, 2, 4, 'Very satisfied with this purchase. Good value for money and fast delivery.', 1, '2025-10-13 08:59:40', '2025-10-13 08:59:40'),
(7, 1, 1, 5, 'Excellent product! The quality exceeded my expectations. Fast shipping and great customer service.', 1, '2025-10-13 09:00:56', '2025-10-13 09:00:56'),
(8, 1, 2, 3, 'Average product. Does the job but nothing special. The packaging could be better.', 1, '2025-10-13 09:00:56', '2025-10-13 09:00:56'),
(9, 2, 1, 4, 'Good product overall. Works as described but took longer to arrive than expected.', 1, '2025-10-13 09:00:56', '2025-10-13 09:00:56'),
(10, 2, 2, 5, 'Absolutely love this! Better than I imagined. Will definitely purchase again.', 1, '2025-10-13 09:00:56', '2025-10-13 09:00:56'),
(11, 1, 1, 2, 'Not happy with the quality. Product arrived damaged and customer service was unhelpful.', 0, '2025-10-13 09:00:56', '2025-10-13 09:00:56'),
(12, 2, 2, 4, 'Very satisfied with this purchase. Good value for money and fast delivery.', 1, '2025-10-13 09:00:56', '2025-10-13 09:00:56'),
(14, 1, 1, 2, 'asdasdsdf', 0, '2025-10-13 23:17:43', '2025-10-13 23:17:43');

-- --------------------------------------------------------

--
-- Table structure for table `product_variants`
--

DROP TABLE IF EXISTS `product_variants`;
CREATE TABLE IF NOT EXISTS `product_variants` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` bigint UNSIGNED NOT NULL,
  `sku` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int NOT NULL DEFAULT '0',
  `attributes` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_variants_sku_unique` (`sku`),
  KEY `product_variants_product_id_foreign` (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('ID22uVyw95NwvsPWw2LHOfpV3EMWEw9hN1fudXkT', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YToxMDp7czo2OiJfdG9rZW4iO3M6NDA6InJpeGtHSVRVeHJkaWJJeDJyZE84QVFtSzhiUDJtVUoxT1VGZ3JXcjIiO3M6ODoid2lzaGxpc3QiO2E6MDp7fXM6NjoiX2ZsYXNoIjthOjI6e3M6MzoibmV3IjthOjA6e31zOjM6Im9sZCI7YTowOnt9fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjc0OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvcHJvZHVjdC93b21lbi1zLXJheW9uLXZpc2Nvc2UtYW5hcmthbGktcHJpbnRlZC1rdXJ0YSI7fXM6NTU6ImxvZ2luX2N1c3RvbWVyXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjE1OiJjb3Vwb25fZGlzY291bnQiO3M6NjoiMTAwLjAwIjtzOjE1OiJvcmRlcl9jb21wbGV0ZWQiO2I6MTtzOjM6InVybCI7YTowOnt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjQ6ImNhcnQiO2E6Mjp7czozNDoiMS0xNGMzYzAyYTAyY2YzZTA3YTc1MTljMzk3NjY0NzQ4YSI7YTo3OntzOjEwOiJwcm9kdWN0X2lkIjtpOjE7czo0OiJzbHVnIjtzOjIzOiJyaHlzbGV5LXJheW9uLXJlZC1rdXJ0aSI7czo0OiJuYW1lIjtzOjIzOiJSaHlzbGV5IFJheW9uIFJlZCBLdXJ0aSI7czo1OiJwcmljZSI7czo3OiIxODQwLjAwIjtzOjU6ImltYWdlIjtzOjgzOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvc3RvcmFnZS9wcm9kdWN0cy9hZnR5b1RtSXN3OVplcGpERGhxdkIwbmRwWlpFZ3QyeVVUcGxXRk9KLmpwZyI7czo4OiJxdWFudGl0eSI7aToxO3M6MTA6ImF0dHJpYnV0ZXMiO2E6Mjp7czo1OiJjb2xvciI7czozOiJSZWQiO3M6NDoic2l6ZSI7czoyOiJYUyI7fX1zOjM0OiIyLTM4YTQ1YzRkYzVhZTA2NWUzMDQ1YzBlMWE5ZGU5YmFhIjthOjc6e3M6MTA6InByb2R1Y3RfaWQiO2k6MjtzOjQ6InNsdWciO3M6NDQ6IndvbWVuLXMtcmF5b24tdmlzY29zZS1hbmFya2FsaS1wcmludGVkLWt1cnRhIjtzOjQ6Im5hbWUiO3M6NDQ6IldvbWVuJ3MgUmF5b24gVmlzY29zZSBBbmFya2FsaSBQcmludGVkIEt1cnRhIjtzOjU6InByaWNlIjtzOjc6IjEyMDAuMDAiO3M6NToiaW1hZ2UiO3M6ODM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zdG9yYWdlL3Byb2R1Y3RzL2pwb1A0VTNNV1hxVzlaY0VISlNRT3F2TEpvVDVmYVVyc3BtM1hOb3IuanBnIjtzOjg6InF1YW50aXR5IjtzOjE6IjEiO3M6MTA6ImF0dHJpYnV0ZXMiO2E6Mjp7czo1OiJjb2xvciI7czo1OiJHcmVlbiI7czo0OiJzaXplIjtzOjE6IlMiO319fX0=', 1760615377);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'text',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_key_unique` (`key`)
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `type`, `created_at`, `updated_at`) VALUES
(1, 'site_name', 'Vyuga', 'text', '2025-10-11 01:01:40', '2025-10-11 05:32:27'),
(2, 'site_tagline', 'Your style. Your story', 'text', '2025-10-11 01:01:40', '2025-10-11 05:32:27'),
(3, 'site_email', 'info@example.com', 'text', '2025-10-11 01:01:40', '2025-10-11 01:01:40'),
(4, 'site_phone', '+91 1234567890', 'text', '2025-10-11 01:01:40', '2025-10-11 01:01:40'),
(5, 'site_address', '123 Main Street, New Delhi, India', 'textarea', '2025-10-11 01:01:40', '2025-10-11 01:01:40'),
(6, 'site_logo', 'settings/MIlx5Zt80BIsMwwSWY1SBxb354MWOzsuBfnAtQ9l.png', 'image', '2025-10-11 01:01:40', '2025-10-13 23:14:45'),
(7, 'site_favicon', 'settings/5yJWBFT2WMpr9oTCEEKADPQEUo0otCcgdy5HGFtD.png', 'image', '2025-10-11 01:01:40', '2025-10-11 06:10:32'),
(8, 'footer_logo', 'settings/qbIQKY2EcasszyV0Ea12L8soRHqJWgYGRpNcLHpm.png', 'image', '2025-10-11 01:01:40', '2025-10-11 06:10:32'),
(9, 'footer_text', '© 2025 My E-Commerce Store. All rights reserved.', 'textarea', '2025-10-11 01:01:40', '2025-10-11 01:01:40'),
(10, 'facebook_url', 'https://www.facebook.com/', 'text', '2025-10-11 01:01:40', '2025-10-11 05:40:19'),
(11, 'twitter_url', 'http://x.com/whomanishsoni', 'text', '2025-10-11 01:01:40', '2025-10-11 05:42:19'),
(12, 'instagram_url', 'https://www.instagram.com/', 'text', '2025-10-11 01:01:40', '2025-10-11 05:41:04'),
(13, 'youtube_url', 'https://www.youtube.com/', 'text', '2025-10-11 01:01:40', '2025-10-11 05:41:04'),
(14, 'linkedin_url', NULL, 'text', '2025-10-11 01:01:40', '2025-10-11 05:43:00'),
(15, 'pinterest_url', '', 'text', '2025-10-11 01:01:40', '2025-10-11 01:01:40'),
(16, 'smtp_host', 'smtp.gmail.com', 'text', '2025-10-11 01:01:40', '2025-10-11 01:01:40'),
(17, 'smtp_port', '587', 'text', '2025-10-11 01:01:40', '2025-10-11 01:01:40'),
(18, 'smtp_username', '', 'text', '2025-10-11 01:01:40', '2025-10-11 01:01:40'),
(19, 'smtp_password', '', 'text', '2025-10-11 01:01:40', '2025-10-11 01:01:40'),
(20, 'smtp_encryption', 'tls', 'text', '2025-10-11 01:01:40', '2025-10-11 01:01:40'),
(21, 'mail_from_address', 'noreply@example.com', 'text', '2025-10-11 01:01:40', '2025-10-11 01:01:40'),
(22, 'mail_from_name', 'My E-Commerce Store', 'text', '2025-10-11 01:01:40', '2025-10-11 01:01:40'),
(23, 'meta_title', 'My E-Commerce Store - Best Online Shopping', 'text', '2025-10-11 01:01:40', '2025-10-11 01:01:40'),
(24, 'meta_description', 'Shop the latest products at great prices. Fast shipping across India.', 'textarea', '2025-10-11 01:01:40', '2025-10-11 01:01:40'),
(25, 'meta_keywords', 'ecommerce, online shopping, india, products', 'text', '2025-10-11 01:01:40', '2025-10-11 01:01:40'),
(26, 'currency_symbol', '₹', 'text', '2025-10-11 01:01:40', '2025-10-11 01:01:40'),
(27, 'currency_position', 'left', 'text', '2025-10-11 01:01:40', '2025-10-11 01:01:40'),
(28, 'tax_enabled', '1', 'boolean', '2025-10-11 01:01:40', '2025-10-11 01:01:40'),
(29, 'tax_rate', '18', 'number', '2025-10-11 01:01:40', '2025-10-11 01:01:40'),
(30, 'min_order_amount', '0', 'number', '2025-10-11 01:01:40', '2025-10-11 01:01:40'),
(31, 'free_shipping_threshold', '500', 'number', '2025-10-11 01:01:40', '2025-10-11 01:01:40'),
(32, 'google_analytics_id', '', 'text', '2025-10-11 01:01:40', '2025-10-11 01:01:40'),
(33, 'facebook_pixel_id', '', 'text', '2025-10-11 01:01:40', '2025-10-11 01:01:40'),
(34, 'maintenance_mode', '0', 'boolean', '2025-10-11 01:01:40', '2025-10-11 01:01:40'),
(35, 'maintenance_message', 'We are currently undergoing maintenance. Please check back soon.', 'textarea', '2025-10-11 01:01:40', '2025-10-11 01:01:40'),
(36, 'site_description', 'We are an online clothing destination dedicated to bringing you stylish, high-quality women’s wear with a special focus on kurtis and tops that blend comfort with trend-setting designs.', 'text', '2025-10-11 03:11:40', '2025-10-11 05:55:02'),
(37, 'admin_email', NULL, 'text', '2025-10-11 03:11:40', '2025-10-11 03:11:40'),
(38, 'support_email', 'support@vyuga.in', 'text', '2025-10-11 03:11:40', '2025-10-11 05:32:27'),
(39, 'whatsapp_number', '+91-9876543210', 'text', '2025-10-11 03:11:40', '2025-10-11 05:34:23'),
(40, 'contact_phone', '+91-9876543210', 'text', '2025-10-11 03:11:40', '2025-10-11 05:33:30'),
(41, 'contact_email', 'info@vyuga.in', 'text', '2025-10-11 03:11:40', '2025-10-11 05:33:30'),
(42, 'business_address', '#101, Hyderabad, Telangana - 500001', 'text', '2025-10-11 03:11:40', '2025-10-11 06:00:00'),
(43, 'business_hours', NULL, 'text', '2025-10-11 03:11:40', '2025-10-11 03:11:40');

-- --------------------------------------------------------

--
-- Table structure for table `shipping_methods`
--

DROP TABLE IF EXISTS `shipping_methods`;
CREATE TABLE IF NOT EXISTS `shipping_methods` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `cost` decimal(10,2) NOT NULL DEFAULT '0.00',
  `delivery_time` int DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shipping_methods`
--

INSERT INTO `shipping_methods` (`id`, `name`, `description`, `cost`, `delivery_time`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Standard Shipping', 'Delivery within 5-7 business days', 0.00, 7, 1, '2025-10-11 01:01:40', '2025-10-11 01:01:40'),
(2, 'Express Shipping', 'Delivery within 2-3 business days', 150.00, 3, 1, '2025-10-11 01:01:40', '2025-10-11 01:01:40'),
(3, 'Same Day Delivery', 'Delivery on the same day for metro cities', 250.00, 1, 1, '2025-10-11 01:01:40', '2025-10-11 01:01:40');

-- --------------------------------------------------------

--
-- Table structure for table `shipping_zones`
--

DROP TABLE IF EXISTS `shipping_zones`;
CREATE TABLE IF NOT EXISTS `shipping_zones` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `states` json DEFAULT NULL,
  `shipping_method_id` bigint UNSIGNED NOT NULL,
  `rate` decimal(10,2) NOT NULL DEFAULT '0.00',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `shipping_zones_shipping_method_id_foreign` (`shipping_method_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shipping_zones`
--

INSERT INTO `shipping_zones` (`id`, `name`, `states`, `shipping_method_id`, `rate`, `status`, `created_at`, `updated_at`) VALUES
(1, 'North Zone', '\"[\\\"DL\\\",\\\"HR\\\",\\\"PB\\\",\\\"HP\\\",\\\"JK\\\",\\\"UT\\\",\\\"CH\\\"]\"', 1, 0.00, 1, '2025-10-11 01:01:40', '2025-10-11 01:01:40'),
(2, 'South Zone', '\"[\\\"AP\\\",\\\"KA\\\",\\\"KL\\\",\\\"TN\\\",\\\"TG\\\",\\\"PY\\\",\\\"LD\\\"]\"', 1, 0.00, 1, '2025-10-11 01:01:40', '2025-10-11 01:01:40'),
(3, 'East Zone', '\"[\\\"BR\\\",\\\"JH\\\",\\\"OR\\\",\\\"WB\\\",\\\"AN\\\"]\"', 1, 0.00, 1, '2025-10-11 01:01:40', '2025-10-11 01:01:40'),
(4, 'West Zone', '\"[\\\"GA\\\",\\\"GJ\\\",\\\"MH\\\",\\\"RJ\\\",\\\"DN\\\"]\"', 1, 0.00, 1, '2025-10-11 01:01:40', '2025-10-11 01:01:40'),
(5, 'Central Zone', '\"[\\\"CT\\\",\\\"MP\\\",\\\"UP\\\"]\"', 1, 0.00, 1, '2025-10-11 01:01:40', '2025-10-11 01:01:40'),
(6, 'North East Zone', '\"[\\\"AR\\\",\\\"AS\\\",\\\"MN\\\",\\\"ML\\\",\\\"MZ\\\",\\\"NL\\\",\\\"SK\\\",\\\"TR\\\"]\"', 1, 100.00, 1, '2025-10-11 01:01:40', '2025-10-11 01:01:40'),
(7, 'North Zone - Express', '\"[\\\"DL\\\",\\\"HR\\\",\\\"PB\\\",\\\"HP\\\",\\\"JK\\\",\\\"UT\\\",\\\"CH\\\"]\"', 2, 150.00, 1, '2025-10-11 01:01:40', '2025-10-11 01:01:40'),
(8, 'South Zone - Express', '\"[\\\"AP\\\",\\\"KA\\\",\\\"KL\\\",\\\"TN\\\",\\\"TG\\\",\\\"PY\\\",\\\"LD\\\"]\"', 2, 200.00, 1, '2025-10-11 01:01:40', '2025-10-11 01:01:40'),
(9, 'East Zone - Express', '\"[\\\"BR\\\",\\\"JH\\\",\\\"OR\\\",\\\"WB\\\",\\\"AN\\\"]\"', 2, 150.00, 1, '2025-10-11 01:01:40', '2025-10-11 01:01:40'),
(10, 'West Zone - Express', '\"[\\\"GA\\\",\\\"GJ\\\",\\\"MH\\\",\\\"RJ\\\",\\\"DN\\\"]\"', 2, 150.00, 1, '2025-10-11 01:01:40', '2025-10-11 01:01:40'),
(11, 'Central Zone - Express', '\"[\\\"CT\\\",\\\"MP\\\",\\\"UP\\\"]\"', 2, 150.00, 1, '2025-10-11 01:01:40', '2025-10-11 01:01:40'),
(12, 'North East Zone - Express', '\"[\\\"AR\\\",\\\"AS\\\",\\\"MN\\\",\\\"ML\\\",\\\"MZ\\\",\\\"NL\\\",\\\"SK\\\",\\\"TR\\\"]\"', 2, 300.00, 1, '2025-10-11 01:01:40', '2025-10-11 01:01:40');

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

DROP TABLE IF EXISTS `sliders`;
CREATE TABLE IF NOT EXISTS `sliders` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sliders`
--

INSERT INTO `sliders` (`id`, `title`, `image`, `link`, `order`, `status`, `created_at`, `updated_at`) VALUES
(1, 'slider one', 'sliders/RaZMUDD2uQdUHVIaDxIkjbZEKxMXciynI0Fk39Hc.jpg', NULL, 0, 1, '2025-10-11 02:36:14', '2025-10-11 02:36:14'),
(2, 'slider two', 'sliders/SBNNyDGwdqXTC3uhedlUMMa7NsER8yn27exiRoL3.jpg', NULL, 0, 1, '2025-10-11 02:36:29', '2025-10-11 02:36:29'),
(3, 'slider three', 'sliders/hQaJDrYE2Vgh9CRUQpeI0zAWr6ik9E3oGmpcXbuW.jpg', NULL, 0, 1, '2025-10-11 02:36:44', '2025-10-11 02:36:44');

-- --------------------------------------------------------

--
-- Table structure for table `subcategories`
--

DROP TABLE IF EXISTS `subcategories`;
CREATE TABLE IF NOT EXISTS `subcategories` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `order` int NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `subcategories_slug_unique` (`slug`),
  KEY `subcategories_category_id_foreign` (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subcategories`
--

INSERT INTO `subcategories` (`id`, `category_id`, `name`, `slug`, `description`, `order`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Kurti', 'kurti', 'kurti', 0, 1, '2025-10-11 01:38:17', '2025-10-11 01:38:17'),
(2, 1, 'Lengha', 'lengha', 'lengha', 0, 1, '2025-10-11 01:38:44', '2025-10-11 03:07:32'),
(3, 2, 'Shirt', 'shirt', 'shirt', 0, 1, '2025-10-11 01:52:17', '2025-10-11 01:52:17');

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

DROP TABLE IF EXISTS `subscribers`;
CREATE TABLE IF NOT EXISTS `subscribers` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `subscribed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `subscribers_email_unique` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `taxes`
--

DROP TABLE IF EXISTS `taxes`;
CREATE TABLE IF NOT EXISTS `taxes` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rate` decimal(5,2) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `taxes`
--

INSERT INTO `taxes` (`id`, `name`, `type`, `rate`, `status`, `created_at`, `updated_at`) VALUES
(1, 'GST 5%', 'percentage', 5.00, 1, '2025-10-11 01:01:40', '2025-10-11 01:01:40'),
(2, 'GST 12%', 'percentage', 12.00, 1, '2025-10-11 01:01:40', '2025-10-11 01:01:40'),
(3, 'GST 18%', 'percentage', 18.00, 1, '2025-10-14 06:27:20', '2025-10-14 06:27:20');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

DROP TABLE IF EXISTS `tickets`;
CREATE TABLE IF NOT EXISTS `tickets` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_id` bigint UNSIGNED NOT NULL,
  `subject` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci,
  `priority` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'medium',
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open',
  `category` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tickets_customer_id_foreign` (`customer_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ticket_replies`
--

DROP TABLE IF EXISTS `ticket_replies`;
CREATE TABLE IF NOT EXISTS `ticket_replies` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `ticket_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ticket_replies_ticket_id_foreign` (`ticket_id`),
  KEY `ticket_replies_user_id_foreign` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
CREATE TABLE IF NOT EXISTS `transactions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` bigint UNSIGNED NOT NULL,
  `transaction_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `payment_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `transactions_transaction_id_unique` (`transaction_id`),
  KEY `transactions_order_id_foreign` (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin User', 'admin@gmail.com', NULL, '$2y$12$lCH6SzC/9jeCfGpQ6UNJYeTfmDnXJtBhBywMO14PNYOqeaLi5i7oW', 'Lkkbb6kU9Sdr467vURqQCJAKfdmdfB5ka5ADrxQq3yUJJKd0eKl78ixuZQO7', '2025-10-11 01:01:40', '2025-10-11 01:01:40');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
