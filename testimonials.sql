-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 21, 2025 at 11:08 AM
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
-- Table structure for table `testimonials`
--

DROP TABLE IF EXISTS `testimonials`;
CREATE TABLE IF NOT EXISTS `testimonials` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `designation` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `rating` tinyint UNSIGNED NOT NULL DEFAULT '5',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `name`, `designation`, `image`, `message`, `rating`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Raj Bansal', 'Customer', 'testimonials/RNyU93zX5TZgAYVB84b73iWdZqrZZSYZY1xcWvim.png', 'I ordered couple of sarees. The color/pattern/quality was exactly the same as shown in pics. Great customer service. Will definitely order more in future. Highly recommended.', 5, 1, '2025-10-18 04:24:01', '2025-10-17 23:25:26'),
(2, 'Manisha Reddy', 'Fashion Enthusiast', 'testimonials/KElxlJQuCHdDOZk79Z5mxrhLEIU55gcg2estmKh1.png', 'I really loved your collections. They have a very beautiful collection. It was home delivered to me. I really loved the designs and looking forward to see more outfits. Anjali is really decent and professional at her work. Highly recommend Ardha Couture for online shopping and excellent customer service.', 5, 1, '2025-10-18 04:24:01', '2025-10-17 23:21:06'),
(3, 'S.K.Khanna', 'Regular Customer', 'testimonials/w8ARCJjr0mJeJf0vzDieHqeRbuH6gKsTgrAKAj84.png', 'Thank you for the lovely outfits! The quality of the fabric is great and dresses fit so perfect. They look amazing and classy. As always, I love your designs and looking forward to add more outfits to my wardrobe. Highly recommend Ardha Couture for online shopping and excellent customer service!!!', 5, 1, '2025-10-18 04:24:01', '2025-10-17 23:21:54'),
(4, 'Priya Sharma', 'Boutique Owner', 'testimonials/0thFeJZpJclUk5NVHbZnoopmVLDei1r9chnZ7gpd.png', 'Absolutely stunning collection! The embroidery work is impeccable and the fabrics are luxurious. My customers loved the new sarees I ordered. Fast shipping and excellent packaging. 5 stars!', 5, 1, '2025-10-18 04:24:01', '2025-10-17 23:21:42'),
(5, 'Amit Patel', 'Fashion Blogger', 'testimonials/GgxCR64sqYMA0fEU5YGbBC6XKx8D0CUNwD6k0LVB.png', 'As a fashion blogger, I\'ve tried many designers but Ardha Couture stands out! Unique designs, perfect fit, and amazing quality. My followers are obsessed with these outfits. Highly recommend!', 5, 1, '2025-10-18 04:24:01', '2025-10-17 23:22:05'),
(6, 'Neha Gupta', 'Working Professional', 'testimonials/vh59wPXytvLPDSl6puOYAxz2yiSBNcwinr1R9Hrc.png', 'Perfect for office wear! Got a beautiful Anarkali suit that\'s elegant yet comfortable. Received so many compliments at work. Great for both formal and festive occasions. Love it!', 5, 1, '2025-10-18 04:24:01', '2025-10-17 23:22:14'),
(7, 'Rohit Singh', 'Groom\'s Brother', 'testimonials/OiGQrXVrmzqT6AAAUniaSCVcbgamvMzlP2gxXj7l.png', 'Ordered sherwanis for my brother\'s wedding. The fabric quality and stitching were outstanding! Everyone at the wedding complimented the outfits. Highly professional service. Will order again!', 5, 1, '2025-10-18 04:24:01', '2025-10-17 23:22:31'),
(8, 'Sneha Desai', 'New Mom', 'testimonials/Xko9rpNIeuiPHJASQIJnHm6H7z8vo9kCzihL0ciX.png', 'Bought a postpartum lehenga and it\'s gorgeous! Comfortable yet stylish. The team was very helpful in suggesting the right size. Perfect for baby showers and family functions. Thank you!', 5, 1, '2025-10-18 04:24:01', '2025-10-17 23:22:21'),
(9, 'Vikram Malhotra', 'NRI Customer', 'testimonials/vrP171jMpp7AJTb7WOx5MG2topRGyOINBb1ViUo4.png', 'Living in USA but ordered for my sister\'s wedding in India. Perfect delivery and quality! The lehenga looked exactly like the pictures. Saved me a trip back home. Excellent service!', 5, 1, '2025-10-18 04:24:01', '2025-10-17 23:22:38');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
