-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 16, 2025 at 12:54 PM
-- Server version: 8.0.33
-- PHP Version: 8.2.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `action` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id` bigint UNSIGNED NOT NULL,
  `customer_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pincode` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_default` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`id`, `customer_id`, `name`, `address`, `city`, `state`, `pincode`, `country`, `is_default`, `created_at`, `updated_at`) VALUES
(61, 1, 'Rashad Franks', '762 North Nobel Freeway Aperiam id quidem vo', 'Aute quia sed volupt', '', 'Non nostrud ipsum v', 'India', 1, '2025-10-16 03:11:30', '2025-10-16 03:11:30'),
(77, 1, 'Fitzgerald Bruce', '31 West Fabien Boulevard Lorem ad ex aliquam', 'Iusto rem aliquip do', '', '311001', 'India', 0, '2025-10-16 05:36:08', '2025-10-16 05:36:08'),
(76, 1, 'Kermit Hoffman', '74 Nobel Lane Tempor incidunt odi', 'Eu pariatur Quaerat', '', '311001', 'India', 0, '2025-10-16 05:34:13', '2025-10-16 05:34:13'),
(74, 1, 'Alden Walton', '621 White First Court Et in ut accusantium', 'Assumenda rerum anim', '', 'Quia ut ipsam qui se', 'India', 0, '2025-10-16 03:31:04', '2025-10-16 03:31:04'),
(75, 1, 'Chancellor Perry', '22 North Cowley Avenue Tempora quia ut volu', 'Nulla pariatur Exce', '', 'Exercitationem elit', 'India', 0, '2025-10-16 03:43:38', '2025-10-16 03:43:38'),
(78, 1, 'Lysandra Ratliff', '414 East First Court Corrupti est irure', 'Iure rerum vel labor', '', 'Ipsa esse qui dolor', 'India', 0, '2025-10-18 01:06:47', '2025-10-18 01:06:47'),
(79, 6, 'Ferris Nielsen', '431 North White Milton Extension Alias reiciendis omn', 'Sint voluptatem re', NULL, 'Quod minus ea accusa', 'India', 1, '2025-11-14 06:03:11', '2025-11-14 06:03:11');

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `title`, `image`, `link`, `position`, `order`, `status`, `created_at`, `updated_at`) VALUES
(1, 'ddd', 'banners/1763215015_691886a747b2d.webp', NULL, 'home', 0, 1, '2025-11-15 08:26:55', '2025-11-15 08:26:55');

-- --------------------------------------------------------

--
-- Table structure for table `blog_categories`
--

CREATE TABLE `blog_categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blog_categories`
--

INSERT INTO `blog_categories` (`id`, `name`, `slug`, `description`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Kurti Fashion Trends', 'kurti-fashion-trends', 'Explore the latest trends, styles, and designs in kurtis, a versatile and timeless piece of women’s fashion. This category covers seasonal must-haves, styling tips, and innovative ways to wear kurtis for various occasions.', 1, '2025-10-17 01:56:06', '2025-10-17 01:56:06'),
(3, 'Body Type Fashion Guide', 'body-type-fashion-guide', 'Discover expert advice on choosing clothing, particularly kurtis, that complements different body shapes. This category focuses on helping women find flattering fits to enhance their confidence and style.', 1, '2025-10-17 01:56:29', '2025-10-17 01:56:29'),
(4, 'Occasion-Based Styling', 'occasion-based-styling', 'Get inspired with tips and ideas for styling kurtis and other outfits for every occasion, from casual outings to festive celebrations. This category offers versatile looks for work, parties, and everyday wear.', 1, '2025-10-17 01:56:55', '2025-10-17 01:56:55'),
(5, 'Sustainable Fashion', 'sustainable-fashion', 'Dive into the world of eco-friendly fashion, focusing on sustainable fabrics and ethical practices. This category highlights how women can make environmentally conscious choices without compromising style.', 1, '2025-10-17 01:57:21', '2025-10-17 01:57:21'),
(6, 'Fashion Styling Hacks', 'fashion-styling-hacks', 'Unlock creative and practical styling tips to elevate your wardrobe. This category provides quick hacks and innovative ideas to transform outfits using accessories, layering, and more.', 1, '2025-10-17 01:57:42', '2025-10-17 01:57:42');

-- --------------------------------------------------------

--
-- Table structure for table `blog_comments`
--

CREATE TABLE `blog_comments` (
  `id` bigint UNSIGNED NOT NULL,
  `blog_post_id` bigint UNSIGNED NOT NULL,
  `customer_id` bigint UNSIGNED NOT NULL,
  `comment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `approved` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blog_posts`
--

CREATE TABLE `blog_posts` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `blog_category_id` bigint UNSIGNED NOT NULL,
  `author_id` bigint UNSIGNED NOT NULL,
  `featured_image` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blog_posts`
--

INSERT INTO `blog_posts` (`id`, `title`, `slug`, `content`, `blog_category_id`, `author_id`, `featured_image`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Top 10 Trending Kurti Styles Every Woman Should Own in 2025', 'top-10-trending-kurti-styles-every-woman-should-own-in-2025', '<p>Stay ahead of the fashion curve with our curated list of the top 10 kurti styles dominating 2025. From bold prints to minimalist designs, discover must-have kurtis to refresh your wardrobe.</p>', 2, 1, NULL, 'published', '2025-10-17 02:05:40', '2025-11-11 06:38:22'),
(3, 'The Secret to Choosing the Perfect Kurti for Your Body Type', 'the-secret-to-choosing-the-perfect-kurti-for-your-body-type', '<p>Find the ideal kurti that flatters your unique body shape. This guide breaks down expert tips to select cuts, lengths, and fabrics that enhance your silhouette and boost confidence.</p>', 3, 1, 'blog-posts/1763214973_6918867d933f4.webp', 'published', '2025-10-17 02:08:28', '2025-11-15 08:26:13'),
(4, 'How to Style Your Kurtis for Every Occasion', 'how-to-style-your-kurtis-for-every-occasion', '<p>Learn how to transform your kurtis for any event, from casual brunches to festive gatherings. Explore pairing ideas, accessories, and styling tips for versatile, chic looks.</p>', 4, 1, 'blog-posts/1763214986_6918868ad0ab8.webp', 'published', '2025-10-17 02:09:23', '2025-11-15 08:26:26'),
(5, 'Why Sustainable Fabrics Are the Future of Women’s Fashion', 'why-sustainable-fabrics-are-the-future-of-womens-fashion', '<p>Discover why sustainable fabrics like organic cotton and bamboo are revolutionizing women&rsquo;s fashion. This blog explores eco-friendly kurti options and their impact on style and the planet.</p>', 5, 1, 'blog-posts/1763214961_6918867189461.webp', 'published', '2025-10-17 02:10:06', '2025-11-15 08:26:01'),
(6, 'Transform Your Outfit with These Styling Hacks', 'transform-your-outfit-with-these-styling-hacks', '<p>Elevate your kurti outfits with simple yet effective styling hacks. From layering techniques to accessorizing, learn how to create stunning looks with minimal effort.</p>', 6, 1, 'blog-posts/1763214947_69188663512c2.webp', 'published', '2025-10-17 02:10:33', '2025-11-15 08:25:47');

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`, `slug`, `image`, `status`, `created_at`, `updated_at`) VALUES
(5, 'Mandir', 'mandir', 'brands/1763213847_6918821756f10.webp', 1, '2025-10-13 05:17:18', '2025-11-15 08:07:27'),
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

CREATE TABLE `cache` (
  `key` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `image` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `image`, `sort_order`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Women', 'women', 'women', NULL, 1, 1, '2025-10-11 01:30:42', '2025-11-12 06:39:40');

-- --------------------------------------------------------

--
-- Table structure for table `celebrities`
--

CREATE TABLE `celebrities` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bio` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profession` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `social_links` longtext DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `collections`
--

CREATE TABLE `collections` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `collections`
--

INSERT INTO `collections` (`id`, `name`, `slug`, `description`, `image`, `sort_order`, `status`, `is_featured`, `created_at`, `updated_at`) VALUES
(9, 'Raagmayi', 'raagmayi', 'Elegant and graceful collection inspired by traditional melodies', NULL, 0, 1, 1, '2025-11-12 06:04:29', '2025-11-12 22:51:31'),
(10, 'Jashn De Fleurs', 'jashn-de-fleurs', 'Celebration of flowers in exquisite designs and craftsmanship', 'collections/1763213473_691880a1d9113.webp', 0, 1, 1, '2025-11-12 06:04:29', '2025-11-15 08:01:14'),
(11, 'Swarniraha', 'swarniraha', 'Golden radiance collection with luxurious and shimmering designs', 'collections/1763213525_691880d552f0e.webp', 0, 1, 1, '2025-11-12 06:04:29', '2025-11-15 08:02:05'),
(12, 'Tarang', 'tarang', 'Flowing waves of elegance in contemporary fashion', 'collections/1763213714_6918819270084.webp', 0, 1, 1, '2025-11-12 06:04:29', '2025-11-15 08:05:15'),
(13, 'Fleur', 'fleur', 'Delicate floral inspirations brought to life in stunning garments', NULL, 0, 1, 0, '2025-11-12 06:04:29', '2025-11-12 22:29:14'),
(14, 'Zaria', 'zaria', 'Radiant and bold collection for the modern woman', NULL, 0, 1, 0, '2025-11-12 06:04:29', '2025-11-12 22:29:19'),
(15, 'Avanya', 'avanya', 'Timeless beauty and sophistication in every piece', NULL, 0, 1, 0, '2025-11-12 06:04:29', '2025-11-12 22:29:24'),
(16, 'Ogha', 'ogha', 'Mystical and enchanting designs with intricate detailing', NULL, 0, 1, 0, '2025-11-12 06:04:29', '2025-11-12 22:29:32');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint UNSIGNED NOT NULL,
  `code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` decimal(10,2) NOT NULL,
  `usage_limit` int DEFAULT NULL,
  `used` int NOT NULL DEFAULT '0',
  `valid_from` date DEFAULT NULL,
  `valid_to` date DEFAULT NULL,
  `min_purchase` decimal(10,2) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `code`, `type`, `value`, `usage_limit`, `used`, `valid_from`, `valid_to`, `min_purchase`, `status`, `created_at`, `updated_at`) VALUES
(3, 'DIWALI50', 'fixed', 100.00, 100, 2, '2025-10-16', '2025-10-31', 1000.00, 1, '2025-10-16 05:57:10', '2025-10-18 01:07:21');

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE `currencies` (
  `id` bigint UNSIGNED NOT NULL,
  `code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `symbol` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exchange_rate` decimal(10,4) NOT NULL DEFAULT '1.0000',
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

CREATE TABLE `customers` (
  `id` bigint UNSIGNED NOT NULL,
  `first_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_no` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alternative_contact_no` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `home_address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `shipping_address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `office_address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `city` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pincode` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `first_name`, `last_name`, `email`, `password`, `contact_no`, `alternative_contact_no`, `home_address`, `shipping_address`, `office_address`, `city`, `state`, `pincode`, `country`, `created_at`, `updated_at`, `remember_token`, `email_verified_at`) VALUES
(1, 'manish', 'soni', 'whomanishsoni@gmail.com', '$2y$12$lCH6SzC/9jeCfGpQ6UNJYeTfmDnXJtBhBywMO14PNYOqeaLi5i7oW', '9460966996', '9460966996', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-11 01:02:17', '2025-10-13 06:58:13', NULL, '2025-11-13 08:38:26'),
(2, 'abc', 'xyz', 'customer@gmail.com', '$2y$12$lCH6SzC/9jeCfGpQ6UNJYeTfmDnXJtBhBywMO14PNYOqeaLi5i7oW', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-11 02:59:00', '2025-10-11 02:59:00', NULL, '2025-11-13 08:38:26'),
(3, 'Jenette', 'Francis', '0xmanishsoni@gmail.com', '$2y$12$Lk8bawvtPRbVw0MzGj/oUO.podTpKVijYF5ZK7AZPAz2rWyJ3/jq6', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-13 08:42:26', '2025-11-13 08:42:26', NULL, NULL),
(4, 'Patricia', 'Sykes', 'manishneosoni@gmail.com', '$2y$12$eXmKoTBGlQX5ohGvforFYOGWbTUv1v1Ed/PjBU0pxwYLBnyGLan6G', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-13 10:22:19', '2025-11-13 10:22:40', NULL, '2025-11-13 10:22:40'),
(5, 'Test', 'User', 'test@example.com', '$2y$12$e/C6KUWg1Dl3.TNIJrsLG.TxyMYdTC.bDFKkuV.JPlAix76oPqglG', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-14 05:02:46', '2025-11-14 05:02:46', NULL, '2025-11-14 05:02:46'),
(6, 'Ferris', 'Nielsen', 'lulybevas@mailinator.com', '$2y$12$8BeJynvypNNSF01rnPnu2.XmUf/TzzfwqYSkcXvSHtJK4oYROwOSC', '+1 (794) 493-2143', '988774404', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-14 06:03:11', '2025-11-14 06:13:54', NULL, '2025-11-14 06:03:11');

-- --------------------------------------------------------

--
-- Table structure for table `email_templates`
--

CREATE TABLE `email_templates` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `variables` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `email_templates`
--

INSERT INTO `email_templates` (`id`, `name`, `subject`, `body`, `variables`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Welcome Email', 'Welcome to {{site_name}}!', '<h1>Welcome {{user_name}}!</h1>\r\n\r\n<p>Thank you for registering at {{site_name}}. We are excited to have you on board.</p>\r\n\r\n<p>Best regards,<br />\r\n{{site_name}} Team</p>', '\"[\\\"{{user_name}}\\\",\\\"{{user_email}}\\\",\\\"{{site_name}}\\\",\\\"{{site_url}}\\\"]\"', 1, '2025-10-11 01:01:40', '2025-11-13 10:15:15'),
(2, 'Forgot Password', 'Reset Your Password - {{site_name}}', '<h1>Password Reset Request</h1><p>Hi {{user_name}},</p><p>You have requested to reset your password. Click the link below to reset:</p><p><a href=\"{{reset_link}}\">Reset Password</a></p><p>This link will expire in 60 minutes.</p><p>If you did not request this, please ignore this email.</p><p>Best regards,<br>{{site_name}} Team</p>', '\"[\\\"{{user_name}}\\\",\\\"{{user_email}}\\\",\\\"{{reset_link}}\\\",\\\"{{site_name}}\\\"]\"', 1, '2025-10-11 01:01:40', '2025-10-11 01:01:40'),
(3, 'Order Confirmation', 'Order Confirmation #{{order_number}} - {{site_name}}', '<h1>Thank you for your order!</h1><p>Hi {{customer_name}},</p><p>Your order #{{order_number}} has been confirmed and is being processed.</p><h3>Order Details:</h3><p>Order Number: {{order_number}}<br>Order Total: {{order_total}}<br>Payment Method: {{payment_method}}<br>Shipping Address: {{shipping_address}}</p><p>You can track your order status from your account dashboard.</p><p>Best regards,<br>{{site_name}} Team</p>', '\"[\\\"{{customer_name}}\\\",\\\"{{order_number}}\\\",\\\"{{order_total}}\\\",\\\"{{payment_method}}\\\",\\\"{{shipping_address}}\\\",\\\"{{site_name}}\\\"]\"', 1, '2025-10-11 01:01:40', '2025-10-11 01:01:40'),
(4, 'Order Shipped', 'Your Order #{{order_number}} Has Been Shipped', '<h1>Your order is on the way!</h1><p>Hi {{customer_name}},</p><p>Great news! Your order #{{order_number}} has been shipped and is on its way to you.</p><h3>Shipping Details:</h3><p>Tracking Number: {{tracking_number}}<br>Carrier: {{carrier_name}}<br>Estimated Delivery: {{estimated_delivery}}</p><p>You can track your package using the tracking number above.</p><p>Best regards,<br>{{site_name}} Team</p>', '\"[\\\"{{customer_name}}\\\",\\\"{{order_number}}\\\",\\\"{{tracking_number}}\\\",\\\"{{carrier_name}}\\\",\\\"{{estimated_delivery}}\\\",\\\"{{site_name}}\\\"]\"', 1, '2025-10-11 01:01:40', '2025-10-11 01:01:40'),
(5, 'Order Delivered', 'Your Order #{{order_number}} Has Been Delivered', '<h1>Order Delivered Successfully!</h1><p>Hi {{customer_name}},</p><p>Your order #{{order_number}} has been delivered successfully.</p><p>We hope you love your purchase! If you have any questions or concerns, please don\'t hesitate to contact us.</p><p>Please take a moment to leave a review of your products.</p><p>Thank you for shopping with us!</p><p>Best regards,<br>{{site_name}} Team</p>', '\"[\\\"{{customer_name}}\\\",\\\"{{order_number}}\\\",\\\"{{site_name}}\\\"]\"', 1, '2025-10-11 01:01:40', '2025-10-11 01:01:40'),
(6, 'Order Cancelled', 'Order #{{order_number}} Cancelled - {{site_name}}', '<h1>Order Cancelled</h1><p>Hi {{customer_name}},</p><p>Your order #{{order_number}} has been cancelled as per your request.</p><h3>Cancellation Details:</h3><p>Order Number: {{order_number}}<br>Cancellation Reason: {{cancellation_reason}}<br>Refund Status: {{refund_status}}</p><p>If you paid online, your refund will be processed within 5-7 business days.</p><p>If you have any questions, please contact our support team.</p><p>Best regards,<br>{{site_name}} Team</p>', '\"[\\\"{{customer_name}}\\\",\\\"{{order_number}}\\\",\\\"{{cancellation_reason}}\\\",\\\"{{refund_status}}\\\",\\\"{{site_name}}\\\"]\"', 1, '2025-10-11 01:01:40', '2025-10-11 01:01:40'),
(7, 'New Customer Registration', 'Verify Your Email - {{site_name}}', '<h1>Welcome to {{site_name}}!</h1>\r\n\r\n<p>Hi {{user_name}},</p>\r\n\r\n<p>Thank you for registering with us. Please verify your email address by clicking the link below:</p>\r\n\r\n<p><a href=\"{{verification_link}}\">Verify Email Address</a></p>\r\n\r\n<p>This link will expire in 24 hours.</p>\r\n\r\n<p>If you did not create an account, please ignore this email.</p>\r\n\r\n<p>Best regards,<br />\r\n{{site_name}} Team</p>', '\"[\\\"{{user_name}}\\\",\\\"{{user_email}}\\\",\\\"{{verification_link}}\\\",\\\"{{site_name}}\\\"]\"', 1, '2025-10-11 01:01:40', '2025-11-13 10:18:52'),
(8, 'Low Stock Alert', 'Low Stock Alert - {{product_name}}', '<h1>Low Stock Alert</h1><p>Hello Admin,</p><p>The following product is running low on stock:</p><p>Product: {{product_name}}<br>SKU: {{product_sku}}<br>Current Stock: {{current_stock}}<br>Threshold: {{threshold}}</p><p>Please restock soon to avoid going out of stock.</p>', '\"[\\\"{{product_name}}\\\",\\\"{{product_sku}}\\\",\\\"{{current_stock}}\\\",\\\"{{threshold}}\\\"]\"', 1, '2025-10-11 01:01:40', '2025-10-11 01:01:40');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` bigint UNSIGNED NOT NULL,
  `question` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `locale` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `direction` enum('ltr','rtl') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(39, '2025_10_13_091353_create_brands_table', 2),
(41, '2025_10_17_144046_create_testimonials_table', 3),
(42, '2025_10_23_064827_add_email_verified_at_to_customers_table', 4),
(43, '2025_11_11_112454_add_image_to_subcategories_table', 4),
(44, '2025_11_11_114956_create_product_subcategory_table', 5),
(45, '2025_11_11_140046_add_is_featured_to_products_table', 6),
(46, '2025_11_11_160044_rename_order_to_sort_order_in_categories_and_subcategories_table', 7),
(47, '2025_11_12_040046_rename_order_to_sort_order_in_sliders_table', 8),
(48, '2025_11_12_110022_create_collections_table', 9),
(49, '2025_11_12_110115_drop_product_collections_table', 10),
(50, '2025_11_12_110024_create_product_collections_table', 11),
(51, '2025_11_12_144051_add_is_featured_to_subcategories_table', 12),
(52, '2025_11_12_144157_add_is_featured_to_collections_table', 12),
(53, '2025_11_13_084230_add_razorpay_order_id_to_orders_table', 13),
(54, '2025_11_13_102631_modify_payment_gateways_table_remove_config_add_mode', 14),
(55, '2025_11_13_112040_add_missing_payment_gateway_columns', 15),
(56, '2025_11_13_113109_make_mode_column_nullable_in_payment_gateways_table', 16),
(57, '2025_11_13_114024_add_more_fields_to_transactions_table', 17),
(58, '2025_11_14_060547_modify_transactions_table_add_payment_details', 18),
(59, '2025_11_14_071021_add_additional_transaction_fields', 19),
(60, '2025_11_14_083231_add_webhook_secret_to_payment_gateways_table', 20),
(61, '2025_11_14_104753_add_guest_fields_to_orders_table', 21),
(64, '2025_11_14_143132_create_celebrities_table', 22),
(65, '2025_11_14_143135_create_videos_table', 22),
(66, '2025_11_14_161556_drop_views_column_from_videos_table', 23);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint UNSIGNED NOT NULL,
  `order_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_id` bigint UNSIGNED DEFAULT NULL,
  `subtotal` decimal(10,2) NOT NULL DEFAULT '0.00',
  `tax` decimal(10,2) NOT NULL DEFAULT '0.00',
  `shipping` decimal(10,2) NOT NULL DEFAULT '0.00',
  `discount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `payment_method` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `razorpay_order_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `billing_address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `guest_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `guest_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `guest_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_number`, `customer_id`, `subtotal`, `tax`, `shipping`, `discount`, `total`, `status`, `payment_method`, `payment_status`, `razorpay_order_id`, `shipping_address`, `billing_address`, `notes`, `created_at`, `updated_at`, `guest_name`, `guest_email`, `guest_phone`) VALUES
(11, 'ORD-AGUYAYTS', 6, 2199.00, 395.82, 0.00, 0.00, 2594.82, 'confirmed', 'razorpay', 'paid', 'order_RfbYgUrH8I1YBh', '431 North White Milton Extension Alias reiciendis omn, Sint voluptatem re, Quod minus ea accusa, India', '431 North White Milton Extension Alias reiciendis omn, Sint voluptatem re, Quod minus ea accusa, India', NULL, '2025-11-14 06:02:24', '2025-11-14 06:03:11', 'Ferris Nielsen', 'lulybevas@mailinator.com', '+1 (794) 493-2143');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int NOT NULL,
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int NOT NULL,
  `attributes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `name`, `price`, `quantity`, `attributes`, `created_at`, `updated_at`) VALUES
(11, 11, 7, 'Jiya Saree Set', 2199.00, 1, '[]', '2025-11-14 06:02:24', '2025-11-14 06:02:24');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

CREATE TABLE `password_reset_tokens` (
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('0xmanishsoni@gmail.com', '$2y$12$K5pjRjzqV2ZBfUfyDZqqQOoBVzAowZWN7BkepaiAh.lZml5rehUVG', '2025-11-13 08:42:27');

-- --------------------------------------------------------

--
-- Table structure for table `payment_gateways`
--

CREATE TABLE `payment_gateways` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `gateway_key` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `api_key` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `api_secret` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mode` enum('test','live') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `test_key_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `test_key_secret` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `live_key_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `live_key_secret` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `webhook_secret` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_gateways`
--

INSERT INTO `payment_gateways` (`id`, `name`, `gateway_key`, `api_key`, `api_secret`, `mode`, `test_key_id`, `test_key_secret`, `live_key_id`, `live_key_secret`, `webhook_secret`, `status`, `created_at`, `updated_at`) VALUES
(3, 'Razorpay', 'razorpay', NULL, NULL, 'test', 'rzp_test_Rf8hHEs6KqmbN9', 'FSbOjp2Wzrk9Az0JSdMnpbMI', '', '', NULL, 1, '2025-10-11 01:01:40', '2025-11-13 06:01:25'),
(5, 'Cash on Delivery', 'cod', '', '', 'test', NULL, NULL, NULL, NULL, NULL, 1, '2025-10-15 06:43:28', '2025-11-13 06:03:41');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `short_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `sale_price` decimal(10,2) DEFAULT NULL,
  `stock` int NOT NULL DEFAULT '0',
  `sku` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` bigint UNSIGNED DEFAULT NULL,
  `subcategory_id` bigint UNSIGNED DEFAULT NULL,
  `brand_id` bigint UNSIGNED DEFAULT NULL,
  `status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `meta_title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `meta_keywords` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `slug`, `description`, `short_description`, `price`, `sale_price`, `stock`, `sku`, `category_id`, `subcategory_id`, `brand_id`, `status`, `is_featured`, `meta_title`, `meta_description`, `meta_keywords`, `created_at`, `updated_at`) VALUES
(7, 'Jiya Saree Set', 'jiya-saree-set', '<h1>Jiya Saree Set</h1>\r\n', 'Jiya Saree Set', 2399.00, 2199.00, 10, 'PROD-P3Y8CYMV', 2, 6, 4, 'active', 1, '', '', '', '2025-11-10 04:23:44', '2025-11-15 10:27:06'),
(4, 'neela sharara set', 'neela-sharara-set', '<h1>neela sharara set</h1>', 'neela sharara set', 2000.00, 1800.00, 10, 'PROD-BVIEPDQ0', 2, 8, 5, 'active', 0, NULL, NULL, NULL, '2025-11-10 03:05:32', '2025-11-12 05:13:00'),
(5, 'Zarira Lehenga Set', 'zarira-lehenga-set', '<h1>Zarira Lehenga Set</h1>', 'Zarira Lehenga Set', 3000.00, 2499.00, 1, 'PROD-MLJ8AGEA', 2, 5, 3, 'active', 1, NULL, NULL, NULL, '2025-11-10 04:04:18', '2025-11-11 08:51:05'),
(6, 'Niya Lehenga Set', 'niya-lehenga-set', '<h1>Niya Lehenga Set</h1>', 'Niya Lehenga Set', 2499.00, 2399.00, 10, 'PROD-1LQIDYEQ', 2, NULL, 4, 'active', 0, NULL, NULL, NULL, '2025-11-10 04:07:25', '2025-11-12 05:12:49'),
(8, 'Genda ruffled saree set', 'genda-ruffled-saree-set', '<h1>Genda ruffled saree set</h1>', 'Genda ruffled saree set', 3499.00, 3099.00, 10, 'PROD-IL4V9BZ2', 2, 6, 8, 'active', 1, NULL, NULL, NULL, '2025-11-10 04:27:12', '2025-11-11 08:36:01'),
(9, 'Aira saree set', 'aira-saree-set', '<h1>Aira saree set</h1>', 'Aira saree set', 1000.00, 888.00, 1, 'PROD-9S0GN2VF', 2, 6, 9, 'active', 1, NULL, NULL, NULL, '2025-11-10 04:32:35', '2025-11-12 05:12:39');

-- --------------------------------------------------------

--
-- Table structure for table `product_attributes`
--

CREATE TABLE `product_attributes` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `values` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_attributes`
--

INSERT INTO `product_attributes` (`id`, `name`, `display_name`, `values`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Size', 'size', '[\"XS\",\"S\",\"M\",\"L\",\"XL\",\"2XL\",\"3XL\",\"4XL\",\"5XL\",\"6XL\"]', 1, '2025-10-13 01:32:44', '2025-11-10 01:27:33'),
(2, 'Color', 'color', '[\"Bright Red\",\"Cream\",\"Green & Lemon Yellow\",\"Hot Pink\",\"Lavender\",\"Lime Green\",\"Magenta Pink\",\"Navy Blue\",\"Gold\",\"Mauve\",\"Mauve Pink\",\"Mustard Yellow\",\"Mustard Yellow\",\"Rani Pink\",\"Orange\",\"Peach\",\"Powder Blue\",\"Red\",\"Turquoise Blue\",\"Wine\"]', 1, '2025-10-13 01:33:27', '2025-11-10 01:31:23');

-- --------------------------------------------------------

--
-- Table structure for table `product_attribute_values`
--

CREATE TABLE `product_attribute_values` (
  `id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `attribute_id` bigint UNSIGNED NOT NULL,
  `value` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_attribute_values`
--

INSERT INTO `product_attribute_values` (`id`, `product_id`, `attribute_id`, `value`, `created_at`, `updated_at`) VALUES
(84, 4, 2, '[\"Bright Red\"]', '2025-11-15 09:01:17', '2025-11-15 09:01:17'),
(83, 4, 1, '[\"XS\",\"S\",\"M\",\"L\",\"XL\",\"2XL\",\"3XL\",\"4XL\",\"5XL\",\"6XL\"]', '2025-11-15 09:01:17', '2025-11-15 09:01:17'),
(89, 5, 1, '[\"XS\",\"S\",\"M\",\"L\",\"XL\",\"2XL\",\"3XL\",\"4XL\",\"5XL\",\"6XL\"]', '2025-11-15 09:02:09', '2025-11-15 09:02:09'),
(90, 5, 2, '[\"Magenta Pink\"]', '2025-11-15 09:02:09', '2025-11-15 09:02:09');

-- --------------------------------------------------------

--
-- Table structure for table `product_collections`
--

CREATE TABLE `product_collections` (
  `id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `collection_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_collections`
--

INSERT INTO `product_collections` (`id`, `product_id`, `collection_id`, `created_at`, `updated_at`) VALUES
(3, 7, 9, NULL, NULL),
(4, 7, 11, NULL, NULL),
(5, 9, 10, NULL, NULL),
(6, 9, 12, NULL, NULL),
(7, 4, 13, NULL, NULL),
(8, 4, 15, NULL, NULL),
(9, 5, 10, NULL, NULL),
(10, 5, 13, NULL, NULL),
(11, 6, 11, NULL, NULL),
(12, 6, 12, NULL, NULL),
(13, 8, 11, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `image` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alt_text` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  `is_primary` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image`, `alt_text`, `sort_order`, `is_primary`, `created_at`, `updated_at`) VALUES
(49, 6, 'products/1763217176_69188f18e63bc.webp', NULL, 1, 0, '2025-11-15 09:02:57', '2025-11-15 09:02:57'),
(50, 6, 'products/1763217206_69188f3615c86.webp', NULL, 2, 0, '2025-11-15 09:03:26', '2025-11-15 09:03:26'),
(40, 7, 'products/1763215490_69188882141b5.webp', NULL, 1, 0, '2025-11-15 08:34:50', '2025-11-15 08:34:50'),
(47, 5, 'products/1763217129_69188ee9313bd.webp', NULL, 3, 0, '2025-11-15 09:02:09', '2025-11-15 09:02:09'),
(48, 6, 'products/1763217176_69188f1843c4c.webp', NULL, 0, 1, '2025-11-15 09:02:56', '2025-11-15 09:02:56'),
(46, 5, 'products/1763217128_69188ee889378.webp', NULL, 2, 0, '2025-11-15 09:02:09', '2025-11-15 09:02:09'),
(45, 5, 'products/1763217111_69188ed75d9db.webp', NULL, 1, 0, '2025-11-15 09:01:52', '2025-11-15 09:01:52'),
(44, 5, 'products/1763217110_69188ed6cf2c1.webp', NULL, 0, 1, '2025-11-15 09:01:51', '2025-11-15 09:01:51'),
(43, 4, 'products/1763217077_69188eb5222cc.webp', NULL, 1, 0, '2025-11-15 09:01:17', '2025-11-15 09:01:17'),
(42, 4, 'products/1763217062_69188ea613328.webp', NULL, 0, 1, '2025-11-15 09:01:02', '2025-11-15 09:01:02'),
(51, 8, 'products/1763217297_69188f91007c0.webp', NULL, 0, 1, '2025-11-15 09:04:57', '2025-11-15 09:04:57'),
(53, 9, 'products/1763217651_691890f32fb62.webp', NULL, 1, 0, '2025-11-15 09:10:51', '2025-11-15 09:10:51'),
(52, 9, 'products/1763217597_691890bd8f0ce.webp', NULL, 0, 1, '2025-11-15 09:09:58', '2025-11-15 09:09:58'),
(39, 7, 'products/1763215465_6918886976748.webp', NULL, 0, 1, '2025-11-15 08:34:26', '2025-11-15 08:34:26');

-- --------------------------------------------------------

--
-- Table structure for table `product_reviews`
--

CREATE TABLE `product_reviews` (
  `id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `customer_id` bigint UNSIGNED NOT NULL,
  `rating` int NOT NULL,
  `comment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `approved` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_reviews`
--

INSERT INTO `product_reviews` (`id`, `product_id`, `customer_id`, `rating`, `comment`, `approved`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 5, 'Excellent product! The quality exceeded my expectations. Fast shipping and great customer service.', 1, '2025-10-13 08:59:40', '2025-10-17 23:25:52'),
(2, 2, 1, 4, 'Good product overall. Works as described but took longer to arrive than expected.', 1, '2025-10-13 08:59:40', '2025-10-13 08:59:40'),
(3, 1, 2, 3, 'Average product. Does the job but nothing special. The packaging could be better.', 1, '2025-10-13 08:59:40', '2025-10-13 08:59:40'),
(7, 1, 1, 5, 'Excellent product! The quality exceeded my expectations. Fast shipping and great customer service.', 1, '2025-10-13 09:00:56', '2025-10-13 09:00:56'),
(8, 1, 2, 3, 'Average product. Does the job but nothing special. The packaging could be better.', 1, '2025-10-13 09:00:56', '2025-10-13 09:00:56'),
(9, 2, 1, 4, 'Good product overall. Works as described but took longer to arrive than expected.', 1, '2025-10-13 09:00:56', '2025-10-13 09:00:56'),
(10, 2, 2, 5, 'Absolutely love this! Better than I imagined. Will definitely purchase again.', 1, '2025-10-13 09:00:56', '2025-10-13 09:00:56'),
(11, 1, 1, 2, 'Not happy with the quality. Product arrived damaged and customer service was unhelpful.', 0, '2025-10-13 09:00:56', '2025-10-17 04:08:14'),
(12, 2, 2, 4, 'Very satisfied with this purchase. Good value for money and fast delivery.', 1, '2025-10-13 09:00:56', '2025-10-13 09:00:56');

-- --------------------------------------------------------

--
-- Table structure for table `product_subcategory`
--

CREATE TABLE `product_subcategory` (
  `id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `subcategory_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_subcategory`
--

INSERT INTO `product_subcategory` (`id`, `product_id`, `subcategory_id`, `created_at`, `updated_at`) VALUES
(14, 10, 7, '2025-11-12 05:45:50', '2025-11-12 05:45:50'),
(15, 10, 5, '2025-11-12 05:48:16', '2025-11-12 05:48:16'),
(16, 7, 25, '2025-11-12 06:17:37', '2025-11-12 06:17:37'),
(17, 7, 26, '2025-11-12 06:17:37', '2025-11-12 06:17:37'),
(18, 9, 32, '2025-11-12 06:21:16', '2025-11-12 06:21:16'),
(19, 9, 27, '2025-11-12 06:21:16', '2025-11-12 06:21:16'),
(20, 4, 29, '2025-11-12 06:28:22', '2025-11-12 06:28:22'),
(21, 4, 30, '2025-11-12 06:28:22', '2025-11-12 06:28:22'),
(22, 5, 24, '2025-11-12 06:29:14', '2025-11-12 06:29:14'),
(23, 5, 23, '2025-11-12 06:29:14', '2025-11-12 06:29:14'),
(24, 6, 32, '2025-11-12 06:29:31', '2025-11-12 06:29:31'),
(25, 6, 24, '2025-11-12 06:29:31', '2025-11-12 06:29:31'),
(26, 8, 25, '2025-11-12 06:29:46', '2025-11-12 06:29:46');

-- --------------------------------------------------------

--
-- Table structure for table `product_variants`
--

CREATE TABLE `product_variants` (
  `id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `sku` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int NOT NULL DEFAULT '0',
  `attributes` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('GYUU7A75RWlO3F2dMALUNVcIDU312etfQ7UAyOMp', 1, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoicEZDaHdOQjB1d0FZRHVqRXM2bmVMSE1YcGIwaEdibFFPY3h6dk42NCI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjMyOiJodHRwOi8vc2hvcC50ZXN0L2FkbWluL2Rhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1763295637),
('KHf7jUBT7PPylL2kP3UeAplOFsSP3zFMokJhVWvT', 1, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiR094TzVnc2JYNGZpc25leEE0T0dXQ29zcWRsVFVHRWJsSkxWZm9tdSI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjM5OiJodHRwOi8vc2hvcC50ZXN0L2FkbWluL3Byb2R1Y3RzLzEyL2VkaXQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1763287737),
('7oPJvwyTectHZd1yQy2nmBRe6wo4X5xQ2YRxy6Tf', 1, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoick9PSDVveXdpeENpRHhKeFVDaFZVRFdQNFFRenk1VkpoOVJtTEhEQiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9wcm9kdWN0cyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1763295430);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint UNSIGNED NOT NULL,
  `key` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'text',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `type`, `created_at`, `updated_at`) VALUES
(1, 'site_name', 'Waseem Fashion Studio', 'text', '2025-10-11 01:01:40', '2025-11-13 09:27:19'),
(2, 'site_tagline', 'Premium Ethnic & Contemporary Wear', 'text', '2025-10-11 01:01:40', '2025-11-10 01:55:12'),
(3, 'site_email', 'info@example.com', 'text', '2025-10-11 01:01:40', '2025-10-11 01:01:40'),
(4, 'site_phone', '+91 1234567890', 'text', '2025-10-11 01:01:40', '2025-10-11 01:01:40'),
(5, 'site_address', '123 Main Street, New Delhi, India', 'textarea', '2025-10-11 01:01:40', '2025-10-11 01:01:40'),
(6, 'site_logo', 'settings/O8zDcD9tZw4FLzaABNUZIF9va9kvzV4MBCCK4wqk.png', 'image', '2025-10-11 01:01:40', '2025-11-14 00:19:41'),
(7, 'site_favicon', 'settings/5yJWBFT2WMpr9oTCEEKADPQEUo0otCcgdy5HGFtD.png', 'image', '2025-10-11 01:01:40', '2025-10-11 06:10:32'),
(8, 'footer_logo', 'settings/ew7APp6rKPdEU1V9JazOMZ2NBHOgW4Hit7Nnr7iO.png', 'image', '2025-10-11 01:01:40', '2025-11-13 04:43:15'),
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
(21, 'mail_from_address', 'no-reply@waseemfashionstudio.com', 'text', '2025-10-11 01:01:40', '2025-11-13 09:57:43'),
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
(38, 'support_email', 'info@waseemfashionstudio.com', 'text', '2025-10-11 03:11:40', '2025-11-10 01:55:12'),
(39, 'whatsapp_number', '+91-9876543210', 'text', '2025-10-11 03:11:40', '2025-10-11 05:34:23'),
(40, 'contact_phone', '+91-9876543210', 'text', '2025-10-11 03:11:40', '2025-10-11 05:33:30'),
(41, 'contact_email', 'info@waseemfashionstudio.com', 'text', '2025-10-11 03:11:40', '2025-11-12 09:11:47'),
(42, 'business_address', '#101, Hyderabad, Telangana - 500001', 'text', '2025-10-11 03:11:40', '2025-10-11 06:00:00'),
(43, 'business_hours', NULL, 'text', '2025-10-11 03:11:40', '2025-10-11 03:11:40'),
(44, 'mail_host', 'waseemfashionstudio.com', 'text', '2025-11-10 01:55:12', '2025-11-13 09:58:50'),
(45, 'mail_port', '465', 'text', '2025-11-10 01:55:12', '2025-11-13 09:58:50'),
(46, 'mail_username', 'no-reply@waseemfashionstudio.com', 'text', '2025-11-10 01:55:12', '2025-11-13 09:57:43'),
(47, 'mail_password', 'i3L684rm~', 'text', '2025-11-10 01:55:12', '2025-11-13 09:57:43'),
(48, 'mail_encryption', 'tls', 'text', '2025-11-10 01:55:12', '2025-11-13 09:58:50');

-- --------------------------------------------------------

--
-- Table structure for table `shipping_methods`
--

CREATE TABLE `shipping_methods` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cost` decimal(10,2) NOT NULL DEFAULT '0.00',
  `delivery_time` int DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

CREATE TABLE `shipping_zones` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `states` longtext COLLATE utf8mb4_unicode_ci,
  `shipping_method_id` bigint UNSIGNED NOT NULL,
  `rate` decimal(10,2) NOT NULL DEFAULT '0.00',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

CREATE TABLE `sliders` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sliders`
--

INSERT INTO `sliders` (`id`, `title`, `image`, `link`, `sort_order`, `status`, `created_at`, `updated_at`) VALUES
(7, 'dsds', 'sliders/1763198139_691844bb208b8.webp', NULL, 0, 1, '2025-11-15 03:45:39', '2025-11-15 03:45:39');

-- --------------------------------------------------------

--
-- Table structure for table `subcategories`
--

CREATE TABLE `subcategories` (
  `id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subcategories`
--

INSERT INTO `subcategories` (`id`, `category_id`, `name`, `slug`, `description`, `image`, `sort_order`, `status`, `is_featured`, `created_at`, `updated_at`) VALUES
(32, 2, 'Dresses', 'dresses', 'Elegant dresses for various occasions and events', NULL, 10, 1, 1, '2025-11-12 06:10:57', '2025-11-12 09:37:12'),
(31, 2, 'Co-ord Sets', 'co-ord-sets', 'Matching co-ordinated sets for perfect styling', NULL, 9, 1, 1, '2025-11-12 06:10:57', '2025-11-12 09:47:36'),
(25, 2, 'Saree Sets', 'saree-sets', 'Beautiful saree sets with matching blouses and accessories', 'subcategories/1763209213_69186ffd5d0be.webp', 3, 1, 1, '2025-11-12 06:10:57', '2025-11-15 06:50:14'),
(24, 2, 'Lehenga Sets', 'lehenga-sets', 'Traditional lehenga sets for weddings and festive celebrations', 'subcategories/1763209281_6918704191abc.webp', 2, 1, 1, '2025-11-12 06:10:57', '2025-11-15 06:51:22'),
(23, 2, 'Kaftan Sets', 'kaftan-sets', 'Elegant kaftan sets perfect for casual and semi-formal occasions', NULL, 1, 1, 1, '2025-11-12 06:10:57', '2025-11-12 09:37:12'),
(34, 2, 'Jumpsuits', 'jumpsuits', 'Stylish jumpsuits combining comfort and fashion', NULL, 12, 1, 0, '2025-11-12 06:10:57', '2025-11-12 06:10:57'),
(33, 2, 'Gowns', 'gowns', 'Luxurious gowns for special occasions and celebrations', NULL, 11, 1, 0, '2025-11-12 06:10:57', '2025-11-12 06:10:57'),
(26, 2, 'Anarkali Sets', 'anarkali-sets', 'Graceful Anarkali suits with intricate embroidery work', 'subcategories/1763209323_6918706bba775.webp', 4, 1, 1, '2025-11-12 06:10:57', '2025-11-15 06:52:04'),
(27, 2, 'Sharara Sets', 'sharara-sets', 'Flowing sharara sets with elegant designs and comfort', 'subcategories/1763209355_6918708b49a66.webp', 5, 1, 1, '2025-11-12 06:10:57', '2025-11-15 06:52:35'),
(28, 2, 'Jacket Sets', 'jacket-sets', 'Stylish jacket sets combining tradition with modern fashion', NULL, 6, 1, 0, '2025-11-12 06:10:57', '2025-11-12 06:10:57'),
(29, 2, 'Kurta Sets', 'kurta-sets', 'Comfortable kurta sets for everyday wear and occasions', NULL, 7, 1, 0, '2025-11-12 06:10:57', '2025-11-12 06:10:57'),
(30, 2, 'Palazzo Sets', 'palazzo-sets', 'Modern palazzo sets with contemporary designs', NULL, 8, 1, 0, '2025-11-12 06:10:57', '2025-11-12 06:10:57');

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `id` bigint UNSIGNED NOT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `subscribed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `taxes`
--

CREATE TABLE `taxes` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `rate` decimal(5,2) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `taxes`
--

INSERT INTO `taxes` (`id`, `name`, `type`, `rate`, `status`, `created_at`, `updated_at`) VALUES
(1, 'GST 5%', 'percentage', 5.00, 1, '2025-10-11 01:01:40', '2025-10-11 01:01:40'),
(2, 'GST 12%', 'percentage', 12.00, 1, '2025-10-11 01:01:40', '2025-10-11 01:01:40'),
(3, 'GST 18%', 'percentage', 18.00, 1, '2025-10-14 06:27:20', '2025-10-14 06:27:20');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `designation` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `rating` tinyint UNSIGNED NOT NULL DEFAULT '5',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `name`, `designation`, `image`, `message`, `rating`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Raj Bansal', 'Customer', 'testimonials/3jKfnmRXhw5hNVsL55K10Nqb0P0g3cTBGDSj266I.png', 'I ordered couple of sarees. The color/pattern/quality was exactly the same as shown in pics. Great customer service. Will definitely order more in future. Highly recommended.', 5, 1, '2025-10-18 04:24:01', '2025-11-10 02:46:36'),
(2, 'Manisha Reddy', 'Fashion Enthusiast', 'testimonials/sZCNUT3Y7sUVDlQzOpRwEvuEKKsStt37bA4DuHGY.png', 'I really loved your collections. They have a very beautiful collection. It was home delivered to me. I really loved the designs and looking forward to see more outfits. Anjali is really decent and professional at her work. Highly recommend Ardha Couture for online shopping and excellent customer service.', 5, 1, '2025-10-18 04:24:01', '2025-11-10 02:46:46'),
(3, 'S.K.Khanna', 'Regular Customer', 'testimonials/Mc0gmv26fFPHfwBWKDjHGvRrIYnMG10tlI74XTZX.png', 'Thank you for the lovely outfits! The quality of the fabric is great and dresses fit so perfect. They look amazing and classy. As always, I love your designs and looking forward to add more outfits to my wardrobe. Highly recommend Ardha Couture for online shopping and excellent customer service!!!', 5, 1, '2025-10-18 04:24:01', '2025-11-10 02:46:59'),
(4, 'Priya Sharma', 'Boutique Owner', 'testimonials/TlEhi0Xg1BYkwipMqmibgSaEyFEKjeBUEk84jyae.png', 'Absolutely stunning collection! The embroidery work is impeccable and the fabrics are luxurious. My customers loved the new sarees I ordered. Fast shipping and excellent packaging. 5 stars!', 5, 1, '2025-10-18 04:24:01', '2025-11-10 02:47:11'),
(5, 'Amit Patel', 'Fashion Blogger', 'testimonials/kGCuz0wV4l5ivAarnvlt90GFjpmcNdqkRqmmMhsV.png', 'As a fashion blogger, I\'ve tried many designers but Ardha Couture stands out! Unique designs, perfect fit, and amazing quality. My followers are obsessed with these outfits. Highly recommend!', 5, 1, '2025-10-18 04:24:01', '2025-11-10 02:47:21'),
(6, 'Neha Gupta', 'Working Professional', 'testimonials/xVG2BE9Qn3wWBWXGvAxWa5lXG9mwiYaTx9hCH0mf.png', 'Perfect for office wear! Got a beautiful Anarkali suit that\'s elegant yet comfortable. Received so many compliments at work. Great for both formal and festive occasions. Love it!', 5, 1, '2025-10-18 04:24:01', '2025-11-10 02:47:34'),
(7, 'Rohit Singh', 'Groom\'s Brother', 'testimonials/VV2G5jOuQrlYEU6xZGogj4huiG38I9KTCkoL5XmK.png', 'Ordered sherwanis for my brother\'s wedding. The fabric quality and stitching were outstanding! Everyone at the wedding complimented the outfits. Highly professional service. Will order again!', 5, 1, '2025-10-18 04:24:01', '2025-11-10 02:48:04'),
(8, 'Sneha Desai', 'New Mom', 'testimonials/p7jtiigJ8HGC9iT3f0Y8FwnJNnHcdJT1EY3qvavB.png', 'Bought a postpartum lehenga and it\'s gorgeous! Comfortable yet stylish. The team was very helpful in suggesting the right size. Perfect for baby showers and family functions. Thank you!', 5, 1, '2025-10-18 04:24:01', '2025-11-10 02:47:45'),
(9, 'Vikram Malhotra', 'NRI Customer', 'testimonials/1K2vcIfOdkEz7TVpVJya6qvNWa161EmYaeAaOd6S.png', 'Living in USA but ordered for my sister\'s wedding in India. Perfect delivery and quality! The lehenga looked exactly like the pictures. Saved me a trip back home. Excellent service!', 5, 1, '2025-10-18 04:24:01', '2025-11-10 02:47:55');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` bigint UNSIGNED NOT NULL,
  `customer_id` bigint UNSIGNED NOT NULL,
  `subject` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `priority` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'medium',
  `status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open',
  `category` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ticket_replies`
--

CREATE TABLE `ticket_replies` (
  `id` bigint UNSIGNED NOT NULL,
  `ticket_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `transaction_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `gateway_order_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gateway_transaction_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `currency` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'INR',
  `fee` decimal(10,2) DEFAULT NULL,
  `tax` decimal(10,2) DEFAULT NULL,
  `acquirer_data` longtext DEFAULT NULL,
  `error_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `error_description` text COLLATE utf8mb4_unicode_ci,
  `payment_response` longtext DEFAULT NULL,
  `payment_method` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_mode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `card_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `card_network` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `wallet_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vpa` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gateway_response` longtext DEFAULT NULL,
  `payment_gateway` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `payment_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `order_id`, `transaction_id`, `gateway_order_id`, `gateway_transaction_id`, `amount`, `currency`, `fee`, `tax`, `acquirer_data`, `error_code`, `error_description`, `payment_response`, `payment_method`, `payment_mode`, `bank_name`, `card_type`, `card_network`, `wallet_name`, `vpa`, `gateway_response`, `payment_gateway`, `status`, `payment_date`, `created_at`, `updated_at`) VALUES
(10, 11, 'pay_RfbZ4FJ82ARKZF', 'order_RfbYgUrH8I1YBh', NULL, 2594.82, 'INR', 61.24, 9.34, '{\"auth_code\": \"331098\"}', NULL, NULL, NULL, 'razorpay', 'card', NULL, 'credit', 'Visa', NULL, NULL, '{\"id\": \"pay_RfbZ4FJ82ARKZF\", \"fee\": 6124, \"tax\": 934, \"vpa\": null, \"bank\": null, \"card\": {\"id\": \"card_RfbZ4TtHX3HuQn\", \"emi\": true, \"name\": \"\", \"type\": \"credit\", \"last4\": \"0153\", \"entity\": \"card\", \"issuer\": \"UTIB\", \"network\": \"Visa\", \"sub_type\": \"consumer\", \"token_iin\": null, \"international\": false}, \"email\": \"lulybevas@mailinator.com\", \"notes\": [], \"amount\": 259482, \"entity\": \"payment\", \"method\": \"card\", \"status\": \"captured\", \"wallet\": null, \"card_id\": \"card_RfbZ4TtHX3HuQn\", \"contact\": \"+17944932143\", \"captured\": true, \"currency\": \"INR\", \"order_id\": \"order_RfbYgUrH8I1YBh\", \"created_at\": 1763119973, \"error_code\": null, \"error_step\": null, \"invoice_id\": null, \"description\": \"Order #ORD-AGUYAYTS\", \"error_reason\": null, \"error_source\": null, \"acquirer_data\": {\"auth_code\": \"331098\"}, \"international\": false, \"refund_status\": null, \"amount_refunded\": 0, \"error_description\": null}', NULL, 'paid', '2025-11-14 06:03:11', '2025-11-14 06:03:11', '2025-11-14 06:03:11');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin User', 'admin@gmail.com', NULL, '$2y$12$lCH6SzC/9jeCfGpQ6UNJYeTfmDnXJtBhBywMO14PNYOqeaLi5i7oW', 'Lkkbb6kU9Sdr467vURqQCJAKfdmdfB5ka5ADrxQq3yUJJKd0eKl78ixuZQO7', '2025-10-11 01:01:40', '2025-10-11 01:01:40');

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--

CREATE TABLE `videos` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `video_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `videos`
--

INSERT INTO `videos` (`id`, `title`, `video_path`, `status`, `sort_order`, `created_at`, `updated_at`) VALUES
(8, 'one', 'videos/69180680198bb_v1.mp4', 'active', 1, '2025-11-14 23:20:11', '2025-11-14 23:26:09'),
(9, 'two', 'videos/6918069b944ba_v2.mp4', 'active', 2, '2025-11-14 23:20:37', '2025-11-14 23:26:28'),
(10, 'three', 'videos/691806b686c4e_v3.mp4', 'active', 3, '2025-11-14 23:21:03', '2025-11-14 23:26:32'),
(11, 'four', 'videos/691806c220ad2_v4.mp4', 'active', 4, '2025-11-14 23:21:17', '2025-11-14 23:26:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_logs_user_id_foreign` (`user_id`);

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `addresses_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog_categories`
--
ALTER TABLE `blog_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `blog_categories_slug_unique` (`slug`);

--
-- Indexes for table `blog_comments`
--
ALTER TABLE `blog_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `blog_comments_blog_post_id_foreign` (`blog_post_id`),
  ADD KEY `blog_comments_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `blog_posts_slug_unique` (`slug`),
  ADD KEY `blog_posts_blog_category_id_foreign` (`blog_category_id`),
  ADD KEY `blog_posts_author_id_foreign` (`author_id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `brands_slug_unique` (`slug`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Indexes for table `celebrities`
--
ALTER TABLE `celebrities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `celebrities_slug_unique` (`slug`);

--
-- Indexes for table `collections`
--
ALTER TABLE `collections`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `collections_slug_unique` (`slug`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `coupons_code_unique` (`code`);

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `currencies_code_unique` (`code`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customers_email_unique` (`email`);

--
-- Indexes for table `email_templates`
--
ALTER TABLE `email_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `faqs_slug_unique` (`slug`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `languages_code_unique` (`code`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_user_id_foreign` (`user_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_number_unique` (`order_number`),
  ADD KEY `orders_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pages_slug_unique` (`slug`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payment_gateways`
--
ALTER TABLE `payment_gateways`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payment_gateways_gateway_key_unique` (`gateway_key`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD UNIQUE KEY `products_sku_unique` (`sku`),
  ADD KEY `products_category_id_foreign` (`category_id`),
  ADD KEY `products_subcategory_id_foreign` (`subcategory_id`),
  ADD KEY `products_brand_id_foreign` (`brand_id`);

--
-- Indexes for table `product_attributes`
--
ALTER TABLE `product_attributes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_attribute_values`
--
ALTER TABLE `product_attribute_values`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_attribute_values_product_id_foreign` (`product_id`),
  ADD KEY `product_attribute_values_attribute_id_foreign` (`attribute_id`);

--
-- Indexes for table `product_collections`
--
ALTER TABLE `product_collections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_images_product_id_foreign` (`product_id`);

--
-- Indexes for table `product_reviews`
--
ALTER TABLE `product_reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_reviews_product_id_foreign` (`product_id`),
  ADD KEY `product_reviews_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `product_subcategory`
--
ALTER TABLE `product_subcategory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_variants`
--
ALTER TABLE `product_variants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_variants_sku_unique` (`sku`),
  ADD KEY `product_variants_product_id_foreign` (`product_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Indexes for table `shipping_methods`
--
ALTER TABLE `shipping_methods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shipping_zones`
--
ALTER TABLE `shipping_zones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shipping_zones_shipping_method_id_foreign` (`shipping_method_id`);

--
-- Indexes for table `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `subcategories_slug_unique` (`slug`),
  ADD KEY `subcategories_category_id_foreign` (`category_id`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `subscribers_email_unique` (`email`);

--
-- Indexes for table `taxes`
--
ALTER TABLE `taxes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tickets_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `ticket_replies`
--
ALTER TABLE `ticket_replies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_replies_ticket_id_foreign` (`ticket_id`),
  ADD KEY `ticket_replies_user_id_foreign` (`user_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `transactions_transaction_id_unique` (`transaction_id`),
  ADD KEY `transactions_order_id_foreign` (`order_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `blog_categories`
--
ALTER TABLE `blog_categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `blog_comments`
--
ALTER TABLE `blog_comments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blog_posts`
--
ALTER TABLE `blog_posts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `celebrities`
--
ALTER TABLE `celebrities`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `collections`
--
ALTER TABLE `collections`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `email_templates`
--
ALTER TABLE `email_templates`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `payment_gateways`
--
ALTER TABLE `payment_gateways`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `product_attributes`
--
ALTER TABLE `product_attributes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `product_attribute_values`
--
ALTER TABLE `product_attribute_values`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `product_collections`
--
ALTER TABLE `product_collections`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT for table `product_reviews`
--
ALTER TABLE `product_reviews`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `product_subcategory`
--
ALTER TABLE `product_subcategory`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `product_variants`
--
ALTER TABLE `product_variants`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `shipping_methods`
--
ALTER TABLE `shipping_methods`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `shipping_zones`
--
ALTER TABLE `shipping_zones`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `subcategories`
--
ALTER TABLE `subcategories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `taxes`
--
ALTER TABLE `taxes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ticket_replies`
--
ALTER TABLE `ticket_replies`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `videos`
--
ALTER TABLE `videos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
