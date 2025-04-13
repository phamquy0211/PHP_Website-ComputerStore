-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 12, 2025 lúc 03:57 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `techhub`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `session_id` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart_items`
--

CREATE TABLE `cart_items` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `session_id` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `specs` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `customers`
--

CREATE TABLE `customers` (
  `id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `customers`
--

INSERT INTO `customers` (`id`, `first_name`, `last_name`, `email`, `phone`, `address`, `city`, `state`, `country`, `created_at`) VALUES
(1, 'Phạm', 'Khải Minh Minh', 'phamminhkhai3690@gmail.com', '0706604403', '1151/19 Huỳnh Tấn Phát', 'New York', 'Korean', 'CA', '2025-04-07 05:45:03'),
(3, 'Phạm', 'Khải Minh Minh', 'phamminhkhai36900@gmail.com', '0706604444', '1151/19 Huỳnh Tấn Phát', 'New York', 'Korean', 'UK', '2025-04-07 05:46:04'),
(5, 'Phạm', 'Pham', 'phamminhkhai36999@gmail.com', '0706604444', '1151/19 Huỳnh Tấn Phát', 'New York', 'Korean', 'UK', '2025-04-07 05:46:31'),
(8, 'Phạm', 'Pham', 'phamminhkhai3619@gmail.com', '0706604456', '1151/19 Huỳnh Tấn Phát', 'New York', 'Korean', 'CA', '2025-04-07 05:47:35'),
(9, 'Phạm Minh', 'Quý', 'pmqadmin@techhub.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', '2025-04-11 17:36:07'),
(10, 'Pham Minh', 'Quy', 'pmqadmin1@techhub.com', '1234567890', 'Do Xuan Hop', 'Thu Duc', 'Quan 9', 'VN', '2025-04-12 00:09:02');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `customer_id` int(10) UNSIGNED DEFAULT NULL,
  `session_id` varchar(255) DEFAULT NULL,
  `order_number` varchar(50) NOT NULL,
  `status` varchar(50) DEFAULT 'Pending',
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `zip_code` varchar(20) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `order_notes` text DEFAULT NULL,
  `subtotal` decimal(10,2) NOT NULL DEFAULT 0.00,
  `shipping` decimal(10,2) NOT NULL DEFAULT 0.00,
  `tax` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `session_id`, `order_number`, `status`, `first_name`, `last_name`, `email`, `phone`, `address`, `city`, `state`, `country`, `zip_code`, `payment_method`, `order_notes`, `subtotal`, `shipping`, `tax`, `total`, `created_at`, `updated_at`) VALUES
(1, NULL, '58jjbi5jmvvtap05b9eop4tqof', '', 'pending', 'Phạm', 'Minh Test', 'phamminhkhai113@gmail.com', '706604406', '1151/19 Huỳnh Tấn Phát', 'New York', 'Korean', 'US', '', 'credit_card', '', 1199.00, 0.00, 71.94, 1270.94, '2025-04-07 05:43:12', '2025-04-07 05:43:12'),
(15, NULL, 'flaqms9g18o6jvaglcj8m49g94', 'ORD17440050291080', 'Pending', 'Phạm', 'Pham', 'phamminhkhai3619@gmail.com', '0706604456', '1151/19 Huỳnh Tấn Phát', 'New York', 'Korean', 'CA', NULL, NULL, NULL, 0.78, 5.99, 0.05, 6.82, '2025-04-07 05:50:29', '2025-04-07 05:50:29'),
(16, NULL, 'flaqms9g18o6jvaglcj8m49g94', 'ORD17440052174894', 'pending', 'Phạm', 'PhamKhai', 'phamminhkhai111@gmail.com', '0706604457', '1151/19 Huỳnh Tấn Phát', 'New York', 'Korean', 'US', '', 'credit_card', '', 7.00, 5.99, 0.42, 13.41, '2025-04-07 05:53:37', '2025-04-07 05:53:37'),
(17, NULL, 'flaqms9g18o6jvaglcj8m49g94', 'ORD17440055818180', 'pending', 'PhạmMinh', 'PhamKhai', 'phamminhkhai1121@gmail.com', '0706604452', '1151/19 Huỳnh Tấn Phát', 'New York', 'Korean', 'US', '', 'credit_card', '', 1199.00, 0.00, 71.94, 1270.94, '2025-04-07 05:59:41', '2025-04-07 05:59:41'),
(18, NULL, '93g1f8fm47j5s2e0hh7cqjh2ar', 'ORD17440059543148', 'pending', 'PhạmMinh', 'Pham', 'phamminhkhai11@gmail.com', '0706604459', '1151/18 Huỳnh Tấn Phát', 'New York', 'Korean', 'US', '', 'credit_card', '', 159.00, 0.00, 9.54, 168.54, '2025-04-07 06:05:54', '2025-04-07 06:05:54'),
(19, NULL, '4impepchl7dr83rn7jo71vq8km', 'ORD17440189801517', 'pending', 'Pham', 'Quy', 'pmquy123@gmail.com', '0907337542', 'Hoàng Việt', 'Ba Ria', 'Viet Nam', 'US', '', 'credit_card', '', 3897.00, 0.00, 233.82, 4130.82, '2025-04-07 09:43:00', '2025-04-07 09:43:00'),
(20, NULL, '4impepchl7dr83rn7jo71vq8km', 'ORD17440200281871', 'pending', 'Pham', 'Quy', 'pmquy123@gmail.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', '', 'credit_card', '', 3597.00, 0.00, 215.82, 3812.82, '2025-04-07 10:00:28', '2025-04-07 10:00:28'),
(21, NULL, '4impepchl7dr83rn7jo71vq8km', 'ORD17440210486393', 'pending', 'Pham', 'Quy', 'pmquy123@gmail.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', '', 'credit_card', '', 1199.00, 0.00, 71.94, 1270.94, '2025-04-07 10:17:28', '2025-04-07 10:17:28'),
(22, NULL, '4impepchl7dr83rn7jo71vq8km', 'ORD17440211186115', 'pending', 'Pham', 'Quy', 'pmquy123@gmail.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', '', 'credit_card', '', 2398.00, 0.00, 143.88, 2541.88, '2025-04-07 10:18:38', '2025-04-07 10:18:38'),
(23, NULL, '4impepchl7dr83rn7jo71vq8km', 'ORD17440212339845', 'pending', 'Pham', 'Quy', 'pmquy123@gmail.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', '', 'credit_card', '', 1199.00, 0.00, 71.94, 1270.94, '2025-04-07 10:20:33', '2025-04-07 10:20:33'),
(24, NULL, '55hv8408o9l9iu8n8fjr42u4da', 'ORD17440595532274', 'Pending', '12312', '31231231', '536546b54hgf#!)(@gmail.com', '0000000000', '648n784#@$#', '648n784#@$#', '648n784#@$#', 'CA', NULL, NULL, NULL, 5263.00, 0.00, 315.78, 5578.78, '2025-04-07 20:59:13', '2025-04-07 20:59:13'),
(25, NULL, '55hv8408o9l9iu8n8fjr42u4da', 'ORD17440600677076', 'pending', '1324154tdfsg', '54654wtgsf', '$23#*O4J3FSD@gmail.com', '1234567890', '#@$^$YREGFDH&$5478ur', '#@$^$YREGFDH&$5478ur', '#@$^$YREGFDH&$5478ur', 'CA', '', 'credit_card', '', 3895.00, 0.00, 233.70, 4128.70, '2025-04-07 21:07:47', '2025-04-07 21:07:47'),
(26, NULL, 'oahbo14r028m8dl6ihe0t8d2os', 'ORD17440638089241', 'pending', 'Pham', 'Quy', 'pmquy123@gmail.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Ba Ria - Vung Tau', 'VN', '', 'credit_card', '', 1199.00, 0.00, 71.94, 1270.94, '2025-04-07 22:10:08', '2025-04-07 22:10:08'),
(27, NULL, 'i7b8hksevv90uiapvfru4rkf12', 'ORD17440644802612', 'pending', '#@$^$YREGFDH&$5478ur', '#@$^$YREGFDH&$5478ur', '$23#*O4J3FSD@gmail.com', '0000000000', '#@$^$YREGFDH&$5478ur', '23508h3tvrt457345', '30b69n492$#%)(', 'CA', '', 'credit_card', '', 467.00, 0.00, 28.02, 495.02, '2025-04-07 22:21:20', '2025-04-07 22:21:20'),
(28, NULL, 'bg4lcuseo3jqr2qi4lk4sgnm41', 'ORD17443759547889', 'pending', 'Phạm', 'Quý', 'admin@techhub.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', '', 'credit_card', '', 3941.00, 0.00, 236.46, 4177.46, '2025-04-11 12:52:34', '2025-04-11 12:52:34'),
(29, NULL, 'bg4lcuseo3jqr2qi4lk4sgnm41', 'ORD17443762772771', 'pending', 'Phạm', 'Quý', 'admin@techhub.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', '', 'credit_card', '', 2738.00, 0.00, 164.28, 2902.28, '2025-04-11 12:57:57', '2025-04-11 12:57:57'),
(30, NULL, 'bg4lcuseo3jqr2qi4lk4sgnm41', 'ORD17443763749673', 'pending', 'Phạm', 'Quý', 'pmqadmin@techhub.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', '', 'credit_card', '', 173.00, 0.00, 10.38, 183.38, '2025-04-11 12:59:34', '2025-04-11 12:59:34'),
(31, NULL, 'bg4lcuseo3jqr2qi4lk4sgnm41', 'ORD17443764895590', 'pending', 'Phạm', 'Quý', 'pmqadmin@techhub.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', '', 'credit_card', '', 3937.00, 0.00, 236.22, 4173.22, '2025-04-11 13:01:29', '2025-04-11 13:01:29'),
(32, NULL, 'bg4lcuseo3jqr2qi4lk4sgnm41', 'ORD17443768338406', 'Pending', 'Phạm', 'Quý', 'pmqadmin@techhub.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', NULL, NULL, NULL, 4275.00, 0.00, 256.50, 4531.50, '2025-04-11 13:07:13', '2025-04-11 13:07:13'),
(33, NULL, 'bg4lcuseo3jqr2qi4lk4sgnm41', 'ORD17443769615073', 'Pending', 'Phạm', 'Quý', 'pmqadmin@techhub.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', NULL, NULL, NULL, 3770.00, 0.00, 226.20, 3996.20, '2025-04-11 13:09:21', '2025-04-11 13:09:21'),
(34, NULL, 'bg4lcuseo3jqr2qi4lk4sgnm41', 'ORD17443777692968', 'pending', 'Phạm', 'Quý', 'pmqadmin@techhub.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', '', 'credit_card', '', 3491.00, 0.00, 209.46, 3700.46, '2025-04-11 13:22:49', '2025-04-11 13:22:49'),
(35, NULL, 'goa2sn6tkcmsh0kphd7un5k2l8', 'ORD17443858501034', 'Pending', 'Phạm', 'Quý', 'pmqadmin@techhub.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', NULL, NULL, NULL, 2750.00, 0.00, 165.00, 2915.00, '2025-04-11 15:37:30', '2025-04-11 15:37:30'),
(36, NULL, 'goa2sn6tkcmsh0kphd7un5k2l8', 'ORD17443860959202', 'Pending', 'Phạm', 'Quý', 'pmqadmin@techhub.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', NULL, NULL, NULL, 4101.00, 0.00, 246.06, 4347.06, '2025-04-11 15:41:35', '2025-04-11 15:41:35'),
(37, NULL, 'goa2sn6tkcmsh0kphd7un5k2l8', 'ORD17443874518558', 'Pending', 'Phạm', 'Quý', 'pmqadmin@techhub.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', NULL, NULL, NULL, 4068.00, 0.00, 244.08, 4312.08, '2025-04-11 16:04:11', '2025-04-11 16:04:11'),
(38, NULL, 'goa2sn6tkcmsh0kphd7un5k2l8', 'ORD17443878541807', 'Pending', 'Phạm', 'Quý', 'pmqadmin@techhub.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', NULL, NULL, NULL, 2.00, 5.99, 0.12, 8.11, '2025-04-11 16:10:54', '2025-04-11 16:10:54'),
(39, NULL, 'goa2sn6tkcmsh0kphd7un5k2l8', 'ORD17443878857903', 'Pending', 'Phạm', 'Quý', 'pmqadmin@techhub.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', NULL, NULL, NULL, 4376.00, 0.00, 262.56, 4638.56, '2025-04-11 16:11:25', '2025-04-11 16:11:25'),
(40, NULL, 'goa2sn6tkcmsh0kphd7un5k2l8', 'ORD17443885618056', 'Pending', 'Phạm', 'Quý', 'pmqadmin@techhub.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', NULL, NULL, NULL, 2869.00, 0.00, 172.14, 3041.14, '2025-04-11 16:22:41', '2025-04-11 16:22:41'),
(42, NULL, 'goa2sn6tkcmsh0kphd7un5k2l8', 'ORD17443892793544', 'Pending', 'Phạm', 'Quý', 'pmqadmin@techhub.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', NULL, NULL, NULL, 3904.00, 0.00, 234.24, 4138.24, '2025-04-11 16:34:39', '2025-04-11 16:34:39'),
(44, NULL, 'goa2sn6tkcmsh0kphd7un5k2l8', 'ORD17443893373540', 'Pending', 'Phạm', 'Quý', 'pmqadmin@techhub.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', NULL, NULL, NULL, 3904.00, 0.00, 234.24, 4138.24, '2025-04-11 16:35:37', '2025-04-11 16:35:37'),
(46, NULL, 'goa2sn6tkcmsh0kphd7un5k2l8', 'ORD17443902882759', 'Pending', 'Phạm', 'Quý', 'pmqadmin@techhub.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', NULL, NULL, NULL, 3877.00, 0.00, 232.62, 4109.62, '2025-04-11 16:51:28', '2025-04-11 16:51:28'),
(48, NULL, 'goa2sn6tkcmsh0kphd7un5k2l8', 'ORD17443908093941', 'Pending', 'Phạm', 'Quý', 'pmqadmin@techhub.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', NULL, NULL, NULL, 4668.00, 0.00, 280.08, 4948.08, '2025-04-11 17:00:09', '2025-04-11 17:00:09'),
(50, NULL, 'goa2sn6tkcmsh0kphd7un5k2l8', 'ORD17443915695551', 'Pending', 'Phạm', 'Quý', 'pmqadmin@techhub.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', NULL, NULL, NULL, 5872.00, 0.00, 352.32, 6224.32, '2025-04-11 17:12:49', '2025-04-11 17:12:49'),
(52, NULL, 'goa2sn6tkcmsh0kphd7un5k2l8', 'ORD17443916163687', 'Pending', 'Phạm', 'Quý', 'pmqadmin@techhub.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', NULL, NULL, NULL, 7.00, 5.99, 0.42, 13.41, '2025-04-11 17:13:36', '2025-04-11 17:13:36'),
(54, NULL, 'goa2sn6tkcmsh0kphd7un5k2l8', 'ORD17443919819561', 'Pending', 'Phạm', 'Quý', 'pmqadmin@techhub.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', NULL, NULL, NULL, 5872.00, 0.00, 352.32, 6224.32, '2025-04-11 17:19:41', '2025-04-11 17:19:41'),
(56, NULL, 'goa2sn6tkcmsh0kphd7un5k2l8', 'ORD17443926177773', 'Pending', 'Phạm', 'Quý', 'pmqadmin@techhub.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', NULL, NULL, NULL, 4675.00, 0.00, 280.50, 4955.50, '2025-04-11 17:30:17', '2025-04-11 17:30:17'),
(58, NULL, 'goa2sn6tkcmsh0kphd7un5k2l8', 'ORD17443927419433', 'Pending', 'Phạm', 'Quý', 'pmqadmin@techhub.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', NULL, NULL, NULL, 1499.00, 0.00, 89.94, 1588.94, '2025-04-11 17:32:21', '2025-04-11 17:32:21'),
(59, 9, 'goa2sn6tkcmsh0kphd7un5k2l8', 'ORD17443929674048', 'Processing', 'Phạm', 'Quý', 'pmqadmin@techhub.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', '', 'credit_card', '', 14.00, 5.99, 0.84, 20.83, '2025-04-11 17:36:07', '2025-04-11 17:36:07'),
(60, 9, 'goa2sn6tkcmsh0kphd7un5k2l8', 'ORD17443930766492', 'Processing', 'Phạm', 'Quý', 'pmqadmin@techhub.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', '', 'credit_card', '', 2871.00, 0.00, 172.26, 3043.26, '2025-04-11 17:37:56', '2025-04-11 17:37:56'),
(61, 9, 'goa2sn6tkcmsh0kphd7un5k2l8', 'ORD17443933795448', 'Processing', 'Phạm', 'Quý', 'pmqadmin@techhub.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', '', 'credit_card', '', 3768.00, 0.00, 226.08, 3994.08, '2025-04-11 17:42:59', '2025-04-11 17:42:59'),
(62, 9, 'goa2sn6tkcmsh0kphd7un5k2l8', 'ORD17443940648477', 'Processing', 'Phạm', 'Quý', 'pmqadmin@techhub.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', '', 'credit_card', '', 2574.00, 0.00, 154.44, 2728.44, '2025-04-11 17:54:24', '2025-04-11 17:54:24'),
(63, NULL, 'goa2sn6tkcmsh0kphd7un5k2l8', 'ORD17443973979078', 'Pending', 'Phạm', 'Quý', 'pmqadmin@techhub.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', NULL, NULL, NULL, 28.00, 5.99, 1.68, 35.67, '2025-04-11 18:49:57', '2025-04-11 18:49:57'),
(64, NULL, 'goa2sn6tkcmsh0kphd7un5k2l8', 'ORD17443980401494', 'Pending', 'Phạm', 'Quý', 'pmqadmin@techhub.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', NULL, NULL, NULL, 1375.00, 0.00, 82.50, 1457.50, '2025-04-11 19:00:40', '2025-04-11 19:00:40'),
(65, NULL, 'goa2sn6tkcmsh0kphd7un5k2l8', 'ORD17443981634922', 'Pending', 'Phạm', 'Quý', 'pmqadmin@techhub.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', NULL, NULL, NULL, 1206.00, 0.00, 72.36, 1278.36, '2025-04-11 19:02:43', '2025-04-11 19:02:43'),
(66, NULL, 'goa2sn6tkcmsh0kphd7un5k2l8', 'ORD17443983377453', 'Pending', 'Phạm', 'Quý', 'pmqadmin@techhub.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', NULL, NULL, NULL, 169.00, 0.00, 10.14, 179.14, '2025-04-11 19:05:37', '2025-04-11 19:05:37'),
(67, NULL, 'goa2sn6tkcmsh0kphd7un5k2l8', 'ORD17443983503664', 'Pending', 'Phạm', 'Quý', 'pmqadmin@techhub.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', NULL, NULL, NULL, 159.00, 0.00, 9.54, 168.54, '2025-04-11 19:05:50', '2025-04-11 19:05:50'),
(68, NULL, 'goa2sn6tkcmsh0kphd7un5k2l8', 'ORD17443986888853', 'Pending', 'Phạm', 'Quý', 'pmqadmin@techhub.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', NULL, NULL, NULL, 338.00, 0.00, 20.28, 358.28, '2025-04-11 19:11:28', '2025-04-11 19:11:28'),
(69, NULL, 'goa2sn6tkcmsh0kphd7un5k2l8', 'ORD17443989156203', 'Pending', 'Phạm', 'Quý', 'pmqadmin@techhub.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', NULL, NULL, NULL, 169.00, 0.00, 10.14, 179.14, '2025-04-11 19:15:15', '2025-04-11 19:15:15'),
(70, NULL, 'goa2sn6tkcmsh0kphd7un5k2l8', 'ORD17443990033872', 'Pending', 'Phạm', 'Quý', 'pmqadmin@techhub.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', NULL, NULL, NULL, 278.00, 0.00, 16.68, 294.68, '2025-04-11 19:16:43', '2025-04-11 19:16:43'),
(71, NULL, 'goa2sn6tkcmsh0kphd7un5k2l8', 'ORD17443990557079', 'Pending', 'Phạm', 'Quý', 'pmqadmin@techhub.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', NULL, NULL, NULL, 467.00, 0.00, 28.02, 495.02, '2025-04-11 19:17:35', '2025-04-11 19:17:35'),
(72, NULL, 'goa2sn6tkcmsh0kphd7un5k2l8', 'ORD17443990814005', 'Pending', 'Phạm', 'Quý', 'pmqadmin@techhub.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', NULL, NULL, NULL, 467.00, 0.00, 28.02, 495.02, '2025-04-11 19:18:01', '2025-04-11 19:18:01'),
(73, 9, 'goa2sn6tkcmsh0kphd7un5k2l8', 'ORD17443991226687', 'Processing', 'Phạm', 'Quý', 'pmqadmin@techhub.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', '', 'credit_card', '', 1340.00, 0.00, 80.40, 1420.40, '2025-04-11 19:18:42', '2025-04-11 19:18:42'),
(74, 9, 'goa2sn6tkcmsh0kphd7un5k2l8', 'ORD17443995629845', 'Processing', 'Phạm', 'Quý', 'pmqadmin@techhub.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', '', 'credit_card', '', 139.00, 0.00, 8.34, 147.34, '2025-04-11 19:26:02', '2025-04-11 19:26:02'),
(75, NULL, 'goa2sn6tkcmsh0kphd7un5k2l8', 'ORD17443995631967', 'Pending', 'Phạm', 'Quý', 'pmqadmin@techhub.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', NULL, NULL, NULL, 139.00, 0.00, 8.34, 147.34, '2025-04-11 19:26:03', '2025-04-11 19:26:03'),
(76, 9, 'goa2sn6tkcmsh0kphd7un5k2l8', 'ORD17443998086916', 'Processing', 'Phạm', 'Quý', 'pmqadmin@techhub.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', '', 'credit_card', '', 169.00, 0.00, 10.14, 179.14, '2025-04-11 19:30:08', '2025-04-11 19:30:08'),
(77, NULL, 'goa2sn6tkcmsh0kphd7un5k2l8', 'ORD17443998124426', 'Pending', 'Phạm', 'Quý', 'pmqadmin@techhub.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', NULL, NULL, NULL, 169.00, 0.00, 10.14, 179.14, '2025-04-11 19:30:12', '2025-04-11 19:30:12'),
(78, 9, 'goa2sn6tkcmsh0kphd7un5k2l8', 'ORD17444000168051', 'Processing', 'Phạm', 'Quý', 'pmqadmin@techhub.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', '', 'credit_card', '', 139.00, 0.00, 8.34, 147.34, '2025-04-11 19:33:36', '2025-04-11 19:33:36'),
(80, NULL, 'goa2sn6tkcmsh0kphd7un5k2l8', 'ORD17444003763950', 'Pending', 'Phạm', 'Quý', 'pmqadmin@techhub.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', NULL, NULL, NULL, 1837.00, 0.00, 110.22, 1947.22, '2025-04-11 19:39:36', '2025-04-11 19:39:36'),
(82, NULL, 'goa2sn6tkcmsh0kphd7un5k2l8', 'ORD17444004561357', 'Pending', 'Phạm', 'Quý', 'pmqadmin@techhub.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', NULL, NULL, NULL, 4.00, 5.99, 0.24, 10.23, '2025-04-11 19:40:56', '2025-04-11 19:40:56'),
(83, NULL, 'goa2sn6tkcmsh0kphd7un5k2l8', 'ORD17444005869995', 'Pending', 'Phạm', 'Quý', 'pmqadmin@techhub.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', NULL, NULL, NULL, 169.00, 0.00, 10.14, 179.14, '2025-04-11 19:43:06', '2025-04-11 19:43:06'),
(84, NULL, 'goa2sn6tkcmsh0kphd7un5k2l8', 'ORD17444010077041', 'Pending', 'Phạm', 'Quý', 'pmqadmin@techhub.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', NULL, NULL, NULL, 169.00, 0.00, 10.14, 179.14, '2025-04-11 19:50:07', '2025-04-11 19:50:07'),
(85, NULL, 'goa2sn6tkcmsh0kphd7un5k2l8', 'ORD17444010259020', 'Pending', 'Phạm', 'Quý', 'pmqadmin@techhub.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', NULL, NULL, NULL, 169.00, 0.00, 10.14, 179.14, '2025-04-11 19:50:25', '2025-04-11 19:50:25'),
(86, NULL, 'goa2sn6tkcmsh0kphd7un5k2l8', 'ORD17444011237791', 'Pending', 'Phạm', 'Quý', 'pmqadmin@techhub.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', NULL, NULL, NULL, 141.00, 0.00, 8.46, 149.46, '2025-04-11 19:52:03', '2025-04-11 19:52:03'),
(87, NULL, 'goa2sn6tkcmsh0kphd7un5k2l8', 'ORD17444012187976', 'Pending', 'Phạm', 'Quý', 'pmqadmin@techhub.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', NULL, NULL, NULL, 139.00, 0.00, 8.34, 147.34, '2025-04-11 19:53:38', '2025-04-11 19:53:38'),
(88, NULL, 'goa2sn6tkcmsh0kphd7un5k2l8', 'ORD17444012455074', 'Pending', 'Phạm', 'Quý', 'pmqadmin@techhub.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', NULL, NULL, NULL, 139.00, 0.00, 8.34, 147.34, '2025-04-11 19:54:05', '2025-04-11 19:54:05'),
(89, NULL, 'goa2sn6tkcmsh0kphd7un5k2l8', 'ORD17444012867102', 'Pending', 'Phạm', 'Quý', 'pmqadmin@techhub.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', NULL, NULL, NULL, 139.00, 0.00, 8.34, 147.34, '2025-04-11 19:54:46', '2025-04-11 19:54:46'),
(90, NULL, 'goa2sn6tkcmsh0kphd7un5k2l8', 'ORD17444013293305', 'Pending', 'Phạm', 'Quý', 'pmqadmin@techhub.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', NULL, NULL, NULL, 139.00, 0.00, 8.34, 147.34, '2025-04-11 19:55:29', '2025-04-11 19:55:29'),
(91, NULL, 'goa2sn6tkcmsh0kphd7un5k2l8', 'ORD17444013685428', 'Pending', 'Phạm', 'Quý', 'pmqadmin@techhub.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', NULL, NULL, NULL, 139.00, 0.00, 8.34, 147.34, '2025-04-11 19:56:08', '2025-04-11 19:56:08'),
(92, NULL, 'goa2sn6tkcmsh0kphd7un5k2l8', 'ORD17444014429002', 'Pending', 'Phạm', 'Quý', 'pmqadmin@techhub.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', NULL, NULL, NULL, 139.00, 0.00, 8.34, 147.34, '2025-04-11 19:57:22', '2025-04-11 19:57:22'),
(93, NULL, 'goa2sn6tkcmsh0kphd7un5k2l8', 'ORD17444016029014', 'Pending', 'Phạm', 'Quý', 'pmqadmin@techhub.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', NULL, NULL, NULL, 139.00, 0.00, 8.34, 147.34, '2025-04-11 20:00:02', '2025-04-11 20:00:02'),
(94, NULL, 'goa2sn6tkcmsh0kphd7un5k2l8', 'ORD17444016721557', 'Pending', 'Phạm', 'Quý', 'pmqadmin@techhub.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', NULL, NULL, NULL, 139.00, 0.00, 8.34, 147.34, '2025-04-11 20:01:12', '2025-04-11 20:01:12'),
(95, NULL, 'goa2sn6tkcmsh0kphd7un5k2l8', 'ORD17444017891741', 'Pending', 'Phạm', 'Quý', 'pmqadmin@techhub.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', NULL, NULL, NULL, 338.00, 0.00, 20.28, 358.28, '2025-04-11 20:03:09', '2025-04-11 20:03:09'),
(96, NULL, 'goa2sn6tkcmsh0kphd7un5k2l8', 'ORD17444019012398', 'Pending', 'Phạm', 'Quý', 'pmqadmin@techhub.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', NULL, NULL, NULL, 169.00, 0.00, 10.14, 179.14, '2025-04-11 20:05:01', '2025-04-11 20:05:01'),
(97, NULL, 'goa2sn6tkcmsh0kphd7un5k2l8', 'ORD17444020525346', 'Pending', 'Phạm', 'Quý', 'pmqadmin@techhub.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', NULL, NULL, NULL, 338.00, 0.00, 20.28, 358.28, '2025-04-11 20:07:32', '2025-04-11 20:07:32'),
(98, NULL, 'goa2sn6tkcmsh0kphd7un5k2l8', 'ORD17444023508835', 'Pending', 'Phạm', 'Quý', 'pmqadmin@techhub.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', NULL, NULL, NULL, 338.00, 0.00, 20.28, 358.28, '2025-04-11 20:12:30', '2025-04-11 20:12:30'),
(99, NULL, 'goa2sn6tkcmsh0kphd7un5k2l8', 'ORD17444027746875', 'Pending', 'Phạm', 'Quý', 'pmqadmin@techhub.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', NULL, NULL, NULL, 169.00, 0.00, 10.14, 179.14, '2025-04-11 20:19:34', '2025-04-11 20:19:34'),
(100, NULL, 'goa2sn6tkcmsh0kphd7un5k2l8', 'ORD17444072685676', 'Pending', 'Phạm', 'Quý', 'pmqadmin@techhub.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', NULL, NULL, NULL, 338.00, 0.00, 20.28, 358.28, '2025-04-11 21:34:28', '2025-04-11 21:34:28'),
(101, NULL, 'goa2sn6tkcmsh0kphd7un5k2l8', 'ORD17444072942579', 'Pending', 'Phạm', 'Quý', 'pmqadmin@techhub.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', NULL, NULL, NULL, 338.00, 0.00, 20.28, 358.28, '2025-04-11 21:34:54', '2025-04-11 21:34:54'),
(102, 9, 'goa2sn6tkcmsh0kphd7un5k2l8', 'ORD17444076568244', 'Processing', 'Phạm', 'Quý', 'pmqadmin@techhub.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', '', 'credit_card', '', 169.00, 0.00, 10.14, 179.14, '2025-04-11 21:40:56', '2025-04-11 21:40:56'),
(103, NULL, 'goa2sn6tkcmsh0kphd7un5k2l8', 'ORD17444147193257', 'Pending', 'Pham Minh', 'Quy', 'pmqadmin@techhub.com', '1234567890', 'Do Xuan Hop', 'Thu Duc', 'Quan 9', 'VN', NULL, NULL, NULL, 8758.00, 0.00, 525.48, 9283.48, '2025-04-11 23:38:39', '2025-04-11 23:38:39'),
(104, 9, 'vqfapq7c063pq53kaj83rfsotn', 'ORD17444164903016', 'Processing', 'Pham Minh', 'Quy', 'pmqadmin@techhub.com', '1234567890', 'Do Xuan Hop', 'Thu Duc', 'Quan 9', 'VN', '', 'credit_card', '', 1368.00, 0.00, 82.08, 1450.08, '2025-04-12 00:08:10', '2025-04-12 00:08:10'),
(105, 10, 'vqfapq7c063pq53kaj83rfsotn', 'ORD17444165422958', 'Processing', 'Pham Minh', 'Quy', 'pmqadmin1@techhub.com', '1234567890', 'Do Xuan Hop', 'Thu Duc', 'Quan 9', 'VN', '', 'credit_card', '', 1499.00, 0.00, 89.94, 1588.94, '2025-04-12 00:09:02', '2025-04-12 00:09:02'),
(106, 9, 'vqfapq7c063pq53kaj83rfsotn', 'ORD174441690443', 'Processing', 'Phạm Minh', 'Quý', 'pmqadmin@techhub.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', '', 'credit_card', '', 1358.00, 0.00, 81.48, 1439.48, '2025-04-12 00:15:04', '2025-04-12 00:15:04'),
(107, NULL, 'vqfapq7c063pq53kaj83rfsotn', 'ORD17444169465145', 'Pending', 'Phạm Minh', 'Quý', 'pmqadmin@techhub.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', NULL, NULL, NULL, 139.00, 0.00, 8.34, 147.34, '2025-04-12 00:15:46', '2025-04-12 00:15:46'),
(108, 9, 'vqfapq7c063pq53kaj83rfsotn', 'ORD17444169901', 'Processing', 'Phạm Minh', 'Quý', 'pmqadmin@techhub.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', '', 'credit_card', '', 139.00, 0.00, 8.34, 147.34, '2025-04-12 00:16:30', '2025-04-12 00:16:30'),
(109, 9, 'vqfapq7c063pq53kaj83rfsotn', 'ORD3297', 'Processing', 'Phạm Minh', 'Quý', 'pmqadmin@techhub.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', '', 'credit_card', '', 1199.00, 0.00, 71.94, 1270.94, '2025-04-12 00:17:10', '2025-04-12 00:17:10'),
(110, NULL, 'vqfapq7c063pq53kaj83rfsotn', 'ORD17444170989147', 'Pending', 'Phạm Minh', 'Quý', 'pmqadmin@techhub.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', NULL, NULL, NULL, 169.00, 0.00, 10.14, 179.14, '2025-04-12 00:18:18', '2025-04-12 00:18:18'),
(111, 9, 'vqfapq7c063pq53kaj83rfsotn', 'ORD17444171503120', 'Processing', 'Phạm Minh', 'Quý', 'pmqadmin@techhub.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', '', 'credit_card', '', 139.00, 0.00, 8.34, 147.34, '2025-04-12 00:19:10', '2025-04-12 00:19:10'),
(112, 9, 'vqfapq7c063pq53kaj83rfsotn', 'ORD1775228275', 'Processing', 'Phạm Minh', 'Quý', 'pmqadmin@techhub.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', '', 'credit_card', '', 2398.00, 0.00, 143.88, 2541.88, '2025-04-12 00:28:12', '2025-04-12 00:28:12'),
(113, 9, 'vqfapq7c063pq53kaj83rfsotn', 'ORD7700838803', 'Processing', 'Phạm Minh', 'Quý', 'pmqadmin@techhub.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', '', 'Credit card', '', 507.00, 0.00, 30.42, 537.42, '2025-04-12 00:46:56', '2025-04-12 00:46:56'),
(114, 9, 'vqfapq7c063pq53kaj83rfsotn', 'ORD5669946014', 'Processing', 'Phạm Minh', 'Quý', 'pmqadmin@techhub.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', '', 'Credit card', '', 1199.00, 0.00, 71.94, 1270.94, '2025-04-12 00:48:58', '2025-04-12 00:48:58'),
(115, 9, 'vqfapq7c063pq53kaj83rfsotn', 'ORD3858279995', 'Processing', 'Phạm Minh', 'Quý', 'pmqadmin@techhub.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', '', 'Credit card', '', 169.00, 0.00, 10.14, 179.14, '2025-04-12 01:30:38', '2025-04-12 01:30:38'),
(116, 9, 'vqfapq7c063pq53kaj83rfsotn', 'ORD2488660617', 'Processing', 'Phạm Minh', 'Quý', 'pmqadmin@techhub.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', '', 'Credit card', '', 169.00, 0.00, 10.14, 179.14, '2025-04-12 01:47:48', '2025-04-12 01:47:48');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_items`
--

CREATE TABLE `order_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `quantity` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `specs` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_name`, `price`, `quantity`, `specs`, `created_at`) VALUES
(1, 1, 9, 'Corsair XENEON 34WQHD240-C 34&quot; UHD', 1199.00, 1, NULL, '2025-04-07 05:43:12'),
(6, 15, 48, 'Phạm Minh Khải', 0.26, 3, '\"hello\"', '2025-04-07 05:50:29'),
(7, 16, 6, 'Hyper Liquid Alloy Black Mamba', 7.00, 1, 'GeForce RTX™ 5090 32GB GDDR7 Video Card (DLSS 4.0) [AI-Powered Graphics]', '2025-04-07 05:53:37'),
(8, 17, 8, 'ASUS ROG Swift PG32UCDM 31.5&quot; 4K UHD', 1199.00, 1, '240 Hz Refresh Rate, .03 ms Response Time, QD-OLED Panel', '2025-04-07 05:59:41'),
(9, 18, 11, 'AMD Ryzen 5 8600G AM5 4.3GHz 6-Core', 159.00, 1, '8MB L2, 16MB L3 Cache', '2025-04-07 06:05:54'),
(10, 19, 9, 'Corsair XENEON 34WQHD240-C 34&quot; UHD', 1199.00, 1, '240 Hz Refresh Rate, 0.03 ms Response Time, QD-OLED Panel', '2025-04-07 09:43:00'),
(11, 19, 8, 'ASUS ROG Swift PG32UCDM 31.5&quot; 4K UHD', 1199.00, 1, '240 Hz Refresh Rate, .03 ms Response Time, QD-OLED Panel', '2025-04-07 09:43:00'),
(12, 19, 7, 'LG 39GS95QE-B.AUS 39&quot; 2K WQHD', 1499.00, 1, '240 Hz Refresh Rate, .03 ms Response Time, OLED Panel', '2025-04-07 09:43:00'),
(13, 20, 9, 'Corsair XENEON 34WQHD240-C 34&quot; UHD', 1199.00, 1, '240 Hz Refresh Rate, 0.03 ms Response Time, QD-OLED Panel', '2025-04-07 10:00:28'),
(14, 20, 8, 'ASUS ROG Swift PG32UCDM 31.5&quot; 4K UHD', 1199.00, 2, '240 Hz Refresh Rate, .03 ms Response Time, QD-OLED Panel', '2025-04-07 10:00:28'),
(15, 21, 9, 'Corsair XENEON 34WQHD240-C 34&quot; UHD', 1199.00, 1, '240 Hz Refresh Rate, 0.03 ms Response Time, QD-OLED Panel', '2025-04-07 10:17:28'),
(16, 22, 9, 'Corsair XENEON 34WQHD240-C 34&quot; UHD', 1199.00, 1, '240 Hz Refresh Rate, 0.03 ms Response Time, QD-OLED Panel', '2025-04-07 10:18:38'),
(17, 22, 8, 'ASUS ROG Swift PG32UCDM 31.5&quot; 4K UHD', 1199.00, 1, '240 Hz Refresh Rate, .03 ms Response Time, QD-OLED Panel', '2025-04-07 10:18:38'),
(18, 23, 9, 'Corsair XENEON 34WQHD240-C 34&quot; UHD', 1199.00, 1, '240 Hz Refresh Rate, 0.03 ms Response Time, QD-OLED Panel', '2025-04-07 10:20:33'),
(19, 24, 77, 'Corsair XENEON 34WQHD240-C 34&quot; UHD', 1199.00, 3, '\"240 Hz Refresh Rate, 0.03 ms Response Time, QD-OLED Panel\"', '2025-04-07 20:59:13'),
(20, 24, 76, 'ASUS ROG Swift PG32UCDM 31.5&quot; 4K UHD', 1199.00, 1, '\"240 Hz Refresh Rate, .03 ms Response Time, QD-OLED Panel\"', '2025-04-07 20:59:13'),
(21, 24, 75, 'AMD Ryzen 7 5800XT Vermeer AM4 3.80GHz 8-Core', 139.00, 1, '\"4MB L2, 32MB L3 Cache\"', '2025-04-07 20:59:13'),
(22, 24, 73, 'AMD Ryzen 5 5600XT Vermeer 3.7GHz 6-Core AM4', 169.00, 1, '\"3MB L2, 32MB L3 Cache\"', '2025-04-07 20:59:13'),
(23, 24, 74, 'AMD Ryzen 5 8600G AM5 4.3GHz 6-Core', 159.00, 1, '\"8MB L2, 16MB L3 Cache\"', '2025-04-07 20:59:13'),
(24, 25, 11, 'AMD Ryzen 5 8600G AM5 4.3GHz 6-Core', 159.00, 1, '8MB L2, 16MB L3 Cache', '2025-04-07 21:07:47'),
(25, 25, 10, 'AMD Ryzen 7 5800XT Vermeer AM4 3.80GHz 8-Core', 139.00, 1, '4MB L2, 32MB L3 Cache', '2025-04-07 21:07:47'),
(26, 25, 8, 'ASUS ROG Swift PG32UCDM 31.5&quot; 4K UHD', 1199.00, 2, '240 Hz Refresh Rate, .03 ms Response Time, QD-OLED Panel', '2025-04-07 21:07:47'),
(27, 25, 9, 'Corsair XENEON 34WQHD240-C 34&quot; UHD', 1199.00, 1, '240 Hz Refresh Rate, 0.03 ms Response Time, QD-OLED Panel', '2025-04-07 21:07:47'),
(28, 26, 8, 'ASUS ROG Swift PG32UCDM 31.5&quot; 4K UHD', 1199.00, 1, '240 Hz Refresh Rate, .03 ms Response Time, QD-OLED Panel', '2025-04-07 22:10:08'),
(29, 27, 12, 'AMD Ryzen 5 5600XT Vermeer 3.7GHz 6-Core AM4', 169.00, 1, '3MB L2, 32MB L3 Cache', '2025-04-07 22:21:20'),
(30, 27, 11, 'AMD Ryzen 5 8600G AM5 4.3GHz 6-Core', 159.00, 1, '8MB L2, 16MB L3 Cache', '2025-04-07 22:21:20'),
(31, 27, 10, 'AMD Ryzen 7 5800XT Vermeer AM4 3.80GHz 8-Core', 139.00, 1, '4MB L2, 32MB L3 Cache', '2025-04-07 22:21:20'),
(32, 28, 17, 'PC GVN x ASUS Back to Future', 2.00, 1, '', '2025-04-11 12:52:34'),
(33, 28, 5, 'Creator PC Ultimate', 4.00, 1, 'GeForce RTX™ 5090 32GB GDDR7 Video Card (DLSS 4.0) [AI-Powered Graphics]', '2025-04-11 12:52:34'),
(34, 28, 12, 'AMD Ryzen 5 5600XT Vermeer 3.7GHz 6-Core AM4', 169.00, 2, '3MB L2, 32MB L3 Cache', '2025-04-11 12:52:34'),
(35, 28, 9, 'Corsair XENEON 34WQHD240-C 34&quot; UHD', 1199.00, 1, '240 Hz Refresh Rate, 0.03 ms Response Time, QD-OLED Panel', '2025-04-11 12:52:34'),
(36, 28, 8, 'ASUS ROG Swift PG32UCDM 31.5&quot; 4K UHD', 1199.00, 2, '240 Hz Refresh Rate, .03 ms Response Time, QD-OLED Panel', '2025-04-11 12:52:34'),
(37, 29, 17, 'PC GVN x ASUS Back to Future', 2.00, 1, '', '2025-04-11 12:57:57'),
(38, 29, 12, 'AMD Ryzen 5 5600XT Vermeer 3.7GHz 6-Core AM4', 169.00, 2, '3MB L2, 32MB L3 Cache', '2025-04-11 12:57:57'),
(39, 29, 8, 'ASUS ROG Swift PG32UCDM 31.5&quot; 4K UHD', 1199.00, 1, '240 Hz Refresh Rate, .03 ms Response Time, QD-OLED Panel', '2025-04-11 12:57:57'),
(40, 29, 9, 'Corsair XENEON 34WQHD240-C 34&quot; UHD', 1199.00, 1, '240 Hz Refresh Rate, 0.03 ms Response Time, QD-OLED Panel', '2025-04-11 12:57:57'),
(41, 30, 17, 'PC GVN x ASUS Back to Future', 2.00, 1, '', '2025-04-11 12:59:34'),
(42, 30, 14, 'PC GVN x ASUS Back to Future', 2.00, 1, '', '2025-04-11 12:59:34'),
(43, 30, 12, 'AMD Ryzen 5 5600XT Vermeer 3.7GHz 6-Core AM4', 169.00, 1, '3MB L2, 32MB L3 Cache', '2025-04-11 12:59:34'),
(44, 31, 12, 'AMD Ryzen 5 5600XT Vermeer 3.7GHz 6-Core AM4', 169.00, 2, '3MB L2, 32MB L3 Cache', '2025-04-11 13:01:29'),
(45, 31, 8, 'ASUS ROG Swift PG32UCDM 31.5&quot; 4K UHD', 1199.00, 2, '240 Hz Refresh Rate, .03 ms Response Time, QD-OLED Panel', '2025-04-11 13:01:29'),
(46, 31, 9, 'Corsair XENEON 34WQHD240-C 34&quot; UHD', 1199.00, 1, '240 Hz Refresh Rate, 0.03 ms Response Time, QD-OLED Panel', '2025-04-11 13:01:29'),
(47, 31, 14, 'PC GVN x ASUS Back to Future', 2.00, 1, '', '2025-04-11 13:01:29'),
(48, 32, 132, 'ASUS ROG Swift PG32UCDM 31.5&quot; 4K UHD', 1199.00, 2, '\"240 Hz Refresh Rate, .03 ms Response Time, QD-OLED Panel\"', '2025-04-11 13:07:13'),
(49, 32, 131, 'Corsair XENEON 34WQHD240-C 34&quot; UHD', 1199.00, 1, '\"240 Hz Refresh Rate, 0.03 ms Response Time, QD-OLED Panel\"', '2025-04-11 13:07:13'),
(50, 32, 130, 'AMD Ryzen 5 5600XT Vermeer 3.7GHz 6-Core AM4', 169.00, 4, '\"3MB L2, 32MB L3 Cache\"', '2025-04-11 13:07:13'),
(51, 32, 129, 'PC GVN x ASUS Back to Future', 2.00, 1, '\"\"', '2025-04-11 13:07:13'),
(52, 33, 136, 'Corsair XENEON 34WQHD240-C 34&quot; UHD', 1199.00, 2, '\"240 Hz Refresh Rate, 0.03 ms Response Time, QD-OLED Panel\"', '2025-04-11 13:09:21'),
(53, 33, 135, 'ASUS ROG Swift PG32UCDM 31.5&quot; 4K UHD', 1199.00, 1, '\"240 Hz Refresh Rate, .03 ms Response Time, QD-OLED Panel\"', '2025-04-11 13:09:21'),
(54, 33, 134, 'AMD Ryzen 5 5600XT Vermeer 3.7GHz 6-Core AM4', 169.00, 1, '\"3MB L2, 32MB L3 Cache\"', '2025-04-11 13:09:21'),
(55, 33, 133, 'PC GVN x ASUS Back to Future', 2.00, 2, '\"\"', '2025-04-11 13:09:21'),
(56, 34, 17, 'PC GVN x ASUS Back to Future', 2.00, 2, '', '2025-04-11 13:22:49'),
(57, 34, 4, 'Ultra 5070 Gaming PC', 2.00, 1, 'GeForce RTX™ 5070 12GB GDDR7 Video Card (DLSS 4.0) [AI-Powered Graphics]', '2025-04-11 13:22:49'),
(58, 34, 12, 'AMD Ryzen 5 5600XT Vermeer 3.7GHz 6-Core AM4', 169.00, 1, '3MB L2, 32MB L3 Cache', '2025-04-11 13:22:49'),
(59, 34, 11, 'AMD Ryzen 5 8600G AM5 4.3GHz 6-Core', 159.00, 2, '8MB L2, 16MB L3 Cache', '2025-04-11 13:22:49'),
(60, 34, 7, 'LG 39GS95QE-B.AUS 39&quot; 2K WQHD', 1499.00, 2, '240 Hz Refresh Rate, .03 ms Response Time, OLED Panel', '2025-04-11 13:22:49'),
(61, 35, 144, 'ASUS ROG Swift PG32UCDM 31.5&quot; 4K UHD', 1199.00, 2, '\"240 Hz Refresh Rate, .03 ms Response Time, QD-OLED Panel\"', '2025-04-11 15:37:30'),
(62, 35, 143, 'Hyper Liquid Alloy Black Mamba', 7.00, 2, '\"GeForce RTX\\u2122 5090 32GB GDDR7 Video Card (DLSS 4.0) [AI-Powered Graphics]\"', '2025-04-11 15:37:30'),
(63, 35, 142, 'AMD Ryzen 5 5600XT Vermeer 3.7GHz 6-Core AM4', 169.00, 2, '\"3MB L2, 32MB L3 Cache\"', '2025-04-11 15:37:30'),
(64, 36, 149, 'Corsair XENEON 34WQHD240-C 34&quot; UHD', 1199.00, 1, '\"240 Hz Refresh Rate, 0.03 ms Response Time, QD-OLED Panel\"', '2025-04-11 15:41:35'),
(65, 36, 148, 'ASUS ROG Swift PG32UCDM 31.5&quot; 4K UHD', 1199.00, 2, '\"240 Hz Refresh Rate, .03 ms Response Time, QD-OLED Panel\"', '2025-04-11 15:41:35'),
(66, 36, 147, 'AMD Ryzen 5 8600G AM5 4.3GHz 6-Core', 159.00, 1, '\"8MB L2, 16MB L3 Cache\"', '2025-04-11 15:41:35'),
(67, 36, 146, 'AMD Ryzen 5 5600XT Vermeer 3.7GHz 6-Core AM4', 169.00, 2, '\"3MB L2, 32MB L3 Cache\"', '2025-04-11 15:41:35'),
(68, 36, 145, 'Hyper Liquid Alloy Black Mamba', 7.00, 1, '\"GeForce RTX\\u2122 5090 32GB GDDR7 Video Card (DLSS 4.0) [AI-Powered Graphics]\"', '2025-04-11 15:41:35'),
(69, 37, 153, 'AMD Ryzen 5 5600XT Vermeer 3.7GHz 6-Core AM4', 169.00, 1, '\"3MB L2, 32MB L3 Cache\"', '2025-04-11 16:04:11'),
(70, 37, 152, 'ASUS ROG Swift PG32UCDM 31.5&quot; 4K UHD', 1199.00, 2, '\"240 Hz Refresh Rate, .03 ms Response Time, QD-OLED Panel\"', '2025-04-11 16:04:11'),
(71, 37, 151, 'LG 39GS95QE-B.AUS 39&quot; 2K WQHD', 1499.00, 1, '\"240 Hz Refresh Rate, .03 ms Response Time, OLED Panel\"', '2025-04-11 16:04:11'),
(72, 37, 150, 'PC GVN x ASUS Back to Future', 2.00, 1, '\"\"', '2025-04-11 16:04:11'),
(73, 38, 154, 'PC GVN x ASUS Back to Future', 2.00, 1, '\"\"', '2025-04-11 16:10:54'),
(74, 39, 159, 'Corsair XENEON 34WQHD240-C 34&quot; UHD', 1199.00, 2, '\"240 Hz Refresh Rate, 0.03 ms Response Time, QD-OLED Panel\"', '2025-04-11 16:11:25'),
(75, 39, 158, 'LG 39GS95QE-B.AUS 39&quot; 2K WQHD', 1499.00, 1, '\"240 Hz Refresh Rate, .03 ms Response Time, OLED Panel\"', '2025-04-11 16:11:25'),
(76, 39, 157, 'AMD Ryzen 7 5800XT Vermeer AM4 3.80GHz 8-Core', 139.00, 1, '\"4MB L2, 32MB L3 Cache\"', '2025-04-11 16:11:25'),
(77, 39, 156, 'AMD Ryzen 5 5600XT Vermeer 3.7GHz 6-Core AM4', 169.00, 2, '\"3MB L2, 32MB L3 Cache\"', '2025-04-11 16:11:25'),
(78, 39, 155, 'Ultra 5070 Gaming PC', 2.00, 1, '\"GeForce RTX\\u2122 5070 12GB GDDR7 Video Card (DLSS 4.0) [AI-Powered Graphics]\"', '2025-04-11 16:11:25'),
(79, 40, 163, 'LG 39GS95QE-B.AUS 39&quot; 2K WQHD', 1499.00, 1, '\"240 Hz Refresh Rate, .03 ms Response Time, OLED Panel\"', '2025-04-11 16:22:41'),
(80, 40, 162, 'ASUS ROG Swift PG32UCDM 31.5&quot; 4K UHD', 1199.00, 1, '\"240 Hz Refresh Rate, .03 ms Response Time, QD-OLED Panel\"', '2025-04-11 16:22:41'),
(81, 40, 161, 'AMD Ryzen 5 5600XT Vermeer 3.7GHz 6-Core AM4', 169.00, 1, '\"3MB L2, 32MB L3 Cache\"', '2025-04-11 16:22:41'),
(82, 40, 160, 'PC GVN x ASUS Back to Future', 2.00, 1, '\"\"', '2025-04-11 16:22:41'),
(83, 42, 166, 'Hyper Liquid Alloy Black Mamba', 7.00, 1, '\"GeForce RTX\\u2122 5090 32GB GDDR7 Video Card (DLSS 4.0) [AI-Powered Graphics]\"', '2025-04-11 16:34:39'),
(84, 42, 165, 'Corsair XENEON 34WQHD240-C 34&quot; UHD', 1199.00, 2, '\"240 Hz Refresh Rate, 0.03 ms Response Time, QD-OLED Panel\"', '2025-04-11 16:34:39'),
(85, 42, 164, 'LG 39GS95QE-B.AUS 39&quot; 2K WQHD', 1499.00, 1, '\"240 Hz Refresh Rate, .03 ms Response Time, OLED Panel\"', '2025-04-11 16:34:39'),
(86, 44, 169, 'Corsair XENEON 34WQHD240-C 34&quot; UHD', 1199.00, 2, '\"240 Hz Refresh Rate, 0.03 ms Response Time, QD-OLED Panel\"', '2025-04-11 16:35:37'),
(87, 44, 168, 'LG 39GS95QE-B.AUS 39&quot; 2K WQHD', 1499.00, 1, '\"240 Hz Refresh Rate, .03 ms Response Time, OLED Panel\"', '2025-04-11 16:35:37'),
(88, 44, 167, 'Hyper Liquid Alloy Black Mamba', 7.00, 1, '\"GeForce RTX\\u2122 5090 32GB GDDR7 Video Card (DLSS 4.0) [AI-Powered Graphics]\"', '2025-04-11 16:35:37'),
(89, 46, 173, 'ASUS ROG Swift PG32UCDM 31.5&quot; 4K UHD', 1199.00, 1, '\"240 Hz Refresh Rate, .03 ms Response Time, QD-OLED Panel\"', '2025-04-11 16:51:28'),
(90, 46, 172, 'Corsair XENEON 34WQHD240-C 34&quot; UHD', 1199.00, 2, '\"240 Hz Refresh Rate, 0.03 ms Response Time, QD-OLED Panel\"', '2025-04-11 16:51:28'),
(91, 46, 171, 'AMD Ryzen 7 5800XT Vermeer AM4 3.80GHz 8-Core', 139.00, 2, '\"4MB L2, 32MB L3 Cache\"', '2025-04-11 16:51:28'),
(92, 46, 170, 'Ultra 5070 Gaming PC', 2.00, 1, '\"GeForce RTX\\u2122 5070 12GB GDDR7 Video Card (DLSS 4.0) [AI-Powered Graphics]\"', '2025-04-11 16:51:28'),
(93, 48, 176, 'LG 39GS95QE-B.AUS 39&quot; 2K WQHD', 1499.00, 3, '\"240 Hz Refresh Rate, .03 ms Response Time, OLED Panel\"', '2025-04-11 17:00:09'),
(94, 48, 175, 'AMD Ryzen 5 5600XT Vermeer 3.7GHz 6-Core AM4', 169.00, 1, '\"3MB L2, 32MB L3 Cache\"', '2025-04-11 17:00:09'),
(95, 48, 174, 'Ultra 5070 Gaming PC', 2.00, 1, '\"GeForce RTX\\u2122 5070 12GB GDDR7 Video Card (DLSS 4.0) [AI-Powered Graphics]\"', '2025-04-11 17:00:09'),
(96, 50, 180, 'ASUS ROG Swift PG32UCDM 31.5&quot; 4K UHD', 1199.00, 1, '\"240 Hz Refresh Rate, .03 ms Response Time, QD-OLED Panel\"', '2025-04-11 17:12:49'),
(97, 50, 179, 'LG 39GS95QE-B.AUS 39&quot; 2K WQHD', 1499.00, 3, '\"240 Hz Refresh Rate, .03 ms Response Time, OLED Panel\"', '2025-04-11 17:12:49'),
(98, 50, 178, 'AMD Ryzen 5 5600XT Vermeer 3.7GHz 6-Core AM4', 169.00, 1, '\"3MB L2, 32MB L3 Cache\"', '2025-04-11 17:12:49'),
(99, 50, 177, 'Hyper Liquid Alloy Black Mamba', 7.00, 1, '\"GeForce RTX\\u2122 5090 32GB GDDR7 Video Card (DLSS 4.0) [AI-Powered Graphics]\"', '2025-04-11 17:12:49'),
(100, 52, 181, 'Hyper Liquid Alloy Black Mamba', 7.00, 1, '\"GeForce RTX\\u2122 5090 32GB GDDR7 Video Card (DLSS 4.0) [AI-Powered Graphics]\"', '2025-04-11 17:13:36'),
(101, 54, 185, 'ASUS ROG Swift PG32UCDM 31.5&quot; 4K UHD', 1199.00, 1, '\"240 Hz Refresh Rate, .03 ms Response Time, QD-OLED Panel\"', '2025-04-11 17:19:41'),
(102, 54, 184, 'LG 39GS95QE-B.AUS 39&quot; 2K WQHD', 1499.00, 3, '\"240 Hz Refresh Rate, .03 ms Response Time, OLED Panel\"', '2025-04-11 17:19:41'),
(103, 54, 183, 'AMD Ryzen 5 5600XT Vermeer 3.7GHz 6-Core AM4', 169.00, 1, '\"3MB L2, 32MB L3 Cache\"', '2025-04-11 17:19:41'),
(104, 54, 182, 'Hyper Liquid Alloy Black Mamba', 7.00, 1, '\"GeForce RTX\\u2122 5090 32GB GDDR7 Video Card (DLSS 4.0) [AI-Powered Graphics]\"', '2025-04-11 17:19:41'),
(105, 56, 189, 'LG 39GS95QE-B.AUS 39&quot; 2K WQHD', 1499.00, 3, '\"240 Hz Refresh Rate, .03 ms Response Time, OLED Panel\"', '2025-04-11 17:30:17'),
(106, 56, 188, 'AMD Ryzen 5 5600XT Vermeer 3.7GHz 6-Core AM4', 169.00, 1, '\"3MB L2, 32MB L3 Cache\"', '2025-04-11 17:30:17'),
(107, 56, 187, 'PC GVN x ASUS Back to Future', 2.00, 1, '\"\"', '2025-04-11 17:30:17'),
(108, 56, 186, 'Hyper Liquid Alloy Black Mamba', 7.00, 1, '\"GeForce RTX\\u2122 5090 32GB GDDR7 Video Card (DLSS 4.0) [AI-Powered Graphics]\"', '2025-04-11 17:30:17'),
(109, 58, 190, 'LG 39GS95QE-B.AUS 39&quot; 2K WQHD', 1499.00, 1, '\"240 Hz Refresh Rate, .03 ms Response Time, OLED Panel\"', '2025-04-11 17:32:21'),
(110, 59, 6, 'Hyper Liquid Alloy Black Mamba', 7.00, 2, 'GeForce RTX™ 5090 32GB GDDR7 Video Card (DLSS 4.0) [AI-Powered Graphics]', '2025-04-11 17:36:07'),
(111, 60, 4, 'Ultra 5070 Gaming PC', 2.00, 2, 'GeForce RTX™ 5070 12GB GDDR7 Video Card (DLSS 4.0) [AI-Powered Graphics]', '2025-04-11 17:37:56'),
(112, 60, 12, 'AMD Ryzen 5 5600XT Vermeer 3.7GHz 6-Core AM4', 169.00, 1, '3MB L2, 32MB L3 Cache', '2025-04-11 17:37:56'),
(113, 60, 7, 'LG 39GS95QE-B.AUS 39&quot; 2K WQHD', 1499.00, 1, '240 Hz Refresh Rate, .03 ms Response Time, OLED Panel', '2025-04-11 17:37:56'),
(114, 60, 9, 'Corsair XENEON 34WQHD240-C 34&quot; UHD', 1199.00, 1, '240 Hz Refresh Rate, 0.03 ms Response Time, QD-OLED Panel', '2025-04-11 17:37:56'),
(115, 61, 14, 'PC GVN x ASUS Back to Future', 2.00, 1, '', '2025-04-11 17:42:59'),
(116, 61, 12, 'AMD Ryzen 5 5600XT Vermeer 3.7GHz 6-Core AM4', 169.00, 1, '3MB L2, 32MB L3 Cache', '2025-04-11 17:42:59'),
(117, 61, 9, 'Corsair XENEON 34WQHD240-C 34&quot; UHD', 1199.00, 3, '240 Hz Refresh Rate, 0.03 ms Response Time, QD-OLED Panel', '2025-04-11 17:42:59'),
(118, 62, 6, 'Hyper Liquid Alloy Black Mamba', 7.00, 1, 'GeForce RTX™ 5090 32GB GDDR7 Video Card (DLSS 4.0) [AI-Powered Graphics]', '2025-04-11 17:54:24'),
(119, 62, 8, 'ASUS ROG Swift PG32UCDM 31.5&quot; 4K UHD', 1199.00, 2, '240 Hz Refresh Rate, .03 ms Response Time, QD-OLED Panel', '2025-04-11 17:54:24'),
(120, 62, 12, 'AMD Ryzen 5 5600XT Vermeer 3.7GHz 6-Core AM4', 169.00, 1, '3MB L2, 32MB L3 Cache', '2025-04-11 17:54:24'),
(121, 63, 205, 'Hyper Liquid Alloy Black Mamba', 7.00, 4, '\"GeForce RTX\\u2122 5090 32GB GDDR7 Video Card (DLSS 4.0) [AI-Powered Graphics]\"', '2025-04-11 18:49:57'),
(122, 64, 208, 'Corsair XENEON 34WQHD240-C 34&quot; UHD', 1199.00, 1, '\"240 Hz Refresh Rate, 0.03 ms Response Time, QD-OLED Panel\"', '2025-04-11 19:00:40'),
(123, 64, 207, 'AMD Ryzen 5 5600XT Vermeer 3.7GHz 6-Core AM4', 169.00, 1, '\"3MB L2, 32MB L3 Cache\"', '2025-04-11 19:00:40'),
(124, 64, 206, 'Hyper Liquid Alloy Black Mamba', 7.00, 1, '\"GeForce RTX\\u2122 5090 32GB GDDR7 Video Card (DLSS 4.0) [AI-Powered Graphics]\"', '2025-04-11 19:00:40'),
(125, 65, 210, 'ASUS ROG Swift PG32UCDM 31.5&quot; 4K UHD', 1199.00, 1, '\"240 Hz Refresh Rate, .03 ms Response Time, QD-OLED Panel\"', '2025-04-11 19:02:43'),
(126, 65, 209, 'Hyper Liquid Alloy Black Mamba', 7.00, 1, '\"GeForce RTX\\u2122 5090 32GB GDDR7 Video Card (DLSS 4.0) [AI-Powered Graphics]\"', '2025-04-11 19:02:43'),
(127, 66, 211, 'AMD Ryzen 5 5600XT Vermeer 3.7GHz 6-Core AM4', 169.00, 1, '\"3MB L2, 32MB L3 Cache\"', '2025-04-11 19:05:37'),
(128, 67, 212, 'AMD Ryzen 5 8600G AM5 4.3GHz 6-Core', 159.00, 1, '\"8MB L2, 16MB L3 Cache\"', '2025-04-11 19:05:50'),
(129, 68, 213, 'AMD Ryzen 5 5600XT Vermeer 3.7GHz 6-Core AM4', 169.00, 2, '\"3MB L2, 32MB L3 Cache\"', '2025-04-11 19:11:28'),
(130, 69, 214, 'AMD Ryzen 5 5600XT Vermeer 3.7GHz 6-Core AM4', 169.00, 1, '\"3MB L2, 32MB L3 Cache\"', '2025-04-11 19:15:15'),
(131, 70, 215, 'AMD Ryzen 7 5800XT Vermeer AM4 3.80GHz 8-Core', 139.00, 2, '\"4MB L2, 32MB L3 Cache\"', '2025-04-11 19:16:43'),
(132, 71, 217, 'AMD Ryzen 5 5600XT Vermeer 3.7GHz 6-Core AM4', 169.00, 1, '\"3MB L2, 32MB L3 Cache\"', '2025-04-11 19:17:35'),
(133, 71, 218, 'AMD Ryzen 7 5800XT Vermeer AM4 3.80GHz 8-Core', 139.00, 1, '\"4MB L2, 32MB L3 Cache\"', '2025-04-11 19:17:35'),
(134, 71, 216, 'AMD Ryzen 5 8600G AM5 4.3GHz 6-Core', 159.00, 1, '\"8MB L2, 16MB L3 Cache\"', '2025-04-11 19:17:35'),
(135, 72, 219, 'AMD Ryzen 5 5600XT Vermeer 3.7GHz 6-Core AM4', 169.00, 1, '\"3MB L2, 32MB L3 Cache\"', '2025-04-11 19:18:01'),
(136, 72, 220, 'AMD Ryzen 5 8600G AM5 4.3GHz 6-Core', 159.00, 1, '\"8MB L2, 16MB L3 Cache\"', '2025-04-11 19:18:01'),
(137, 72, 221, 'AMD Ryzen 7 5800XT Vermeer AM4 3.80GHz 8-Core', 139.00, 1, '\"4MB L2, 32MB L3 Cache\"', '2025-04-11 19:18:01'),
(138, 73, 17, 'PC GVN x ASUS Back to Future', 2.00, 1, '', '2025-04-11 19:18:42'),
(139, 73, 10, 'AMD Ryzen 7 5800XT Vermeer AM4 3.80GHz 8-Core', 139.00, 1, '4MB L2, 32MB L3 Cache', '2025-04-11 19:18:42'),
(140, 73, 8, 'ASUS ROG Swift PG32UCDM 31.5&quot; 4K UHD', 1199.00, 1, '240 Hz Refresh Rate, .03 ms Response Time, QD-OLED Panel', '2025-04-11 19:18:42'),
(141, 75, 225, 'AMD Ryzen 7 5800XT Vermeer AM4 3.80GHz 8-Core', 139.00, 1, '\"4MB L2, 32MB L3 Cache\"', '2025-04-11 19:26:03'),
(142, 77, 226, 'AMD Ryzen 5 5600XT Vermeer 3.7GHz 6-Core AM4', 169.00, 1, '\"3MB L2, 32MB L3 Cache\"', '2025-04-11 19:30:12'),
(143, 78, 10, 'AMD Ryzen 7 5800XT Vermeer AM4 3.80GHz 8-Core', 139.00, 1, '4MB L2, 32MB L3 Cache', '2025-04-11 19:33:36'),
(146, 80, 229, 'AMD Ryzen 5 5600XT Vermeer 3.7GHz 6-Core AM4', 169.00, 2, '\"3MB L2, 32MB L3 Cache\"', '2025-04-11 19:39:36'),
(147, 80, 228, 'LG 39GS95QE-B.AUS 39&quot; 2K WQHD', 1499.00, 1, '\"240 Hz Refresh Rate, .03 ms Response Time, OLED Panel\"', '2025-04-11 19:39:36'),
(148, 82, 230, 'Ultra 5070 Gaming PC', 2.00, 2, '\"GeForce RTX\\u2122 5070 12GB GDDR7 Video Card (DLSS 4.0) [AI-Powered Graphics]\"', '2025-04-11 19:40:56'),
(149, 83, 231, 'AMD Ryzen 5 5600XT Vermeer 3.7GHz 6-Core AM4', 169.00, 1, '\"3MB L2, 32MB L3 Cache\"', '2025-04-11 19:43:06'),
(150, 84, 232, 'AMD Ryzen 5 5600XT Vermeer 3.7GHz 6-Core AM4', 169.00, 1, '\"3MB L2, 32MB L3 Cache\"', '2025-04-11 19:50:07'),
(151, 85, 233, 'AMD Ryzen 5 5600XT Vermeer 3.7GHz 6-Core AM4', 169.00, 1, '\"3MB L2, 32MB L3 Cache\"', '2025-04-11 19:50:25'),
(152, 86, 238, 'PC GVN x ASUS Back to Future', 2.00, 1, '\"\"', '2025-04-11 19:52:03'),
(153, 86, 234, 'AMD Ryzen 7 5800XT Vermeer AM4 3.80GHz 8-Core', 139.00, 1, '\"4MB L2, 32MB L3 Cache\"', '2025-04-11 19:52:03'),
(154, 87, 244, 'AMD Ryzen 7 5800XT Vermeer AM4 3.80GHz 8-Core', 139.00, 1, '\"4MB L2, 32MB L3 Cache\"', '2025-04-11 19:53:38'),
(155, 88, 245, 'AMD Ryzen 7 5800XT Vermeer AM4 3.80GHz 8-Core', 139.00, 1, '\"4MB L2, 32MB L3 Cache\"', '2025-04-11 19:54:05'),
(156, 89, 246, 'AMD Ryzen 7 5800XT Vermeer AM4 3.80GHz 8-Core', 139.00, 1, '\"4MB L2, 32MB L3 Cache\"', '2025-04-11 19:54:46'),
(157, 90, 247, 'AMD Ryzen 7 5800XT Vermeer AM4 3.80GHz 8-Core', 139.00, 1, '\"4MB L2, 32MB L3 Cache\"', '2025-04-11 19:55:29'),
(158, 91, 248, 'AMD Ryzen 7 5800XT Vermeer AM4 3.80GHz 8-Core', 139.00, 1, '\"4MB L2, 32MB L3 Cache\"', '2025-04-11 19:56:08'),
(159, 92, 249, 'AMD Ryzen 7 5800XT Vermeer AM4 3.80GHz 8-Core', 139.00, 1, '\"4MB L2, 32MB L3 Cache\"', '2025-04-11 19:57:22'),
(160, 93, 250, 'AMD Ryzen 7 5800XT Vermeer AM4 3.80GHz 8-Core', 139.00, 1, '\"4MB L2, 32MB L3 Cache\"', '2025-04-11 20:00:02'),
(161, 94, 251, 'AMD Ryzen 7 5800XT Vermeer AM4 3.80GHz 8-Core', 139.00, 1, '\"4MB L2, 32MB L3 Cache\"', '2025-04-11 20:01:12'),
(162, 95, 252, 'AMD Ryzen 5 5600XT Vermeer 3.7GHz 6-Core AM4', 169.00, 2, '\"3MB L2, 32MB L3 Cache\"', '2025-04-11 20:03:09'),
(163, 96, 253, 'AMD Ryzen 5 5600XT Vermeer 3.7GHz 6-Core AM4', 169.00, 1, '\"3MB L2, 32MB L3 Cache\"', '2025-04-11 20:05:01'),
(164, 97, 254, 'AMD Ryzen 5 5600XT Vermeer 3.7GHz 6-Core AM4', 169.00, 2, '\"3MB L2, 32MB L3 Cache\"', '2025-04-11 20:07:32'),
(165, 98, 255, 'AMD Ryzen 5 5600XT Vermeer 3.7GHz 6-Core AM4', 169.00, 2, '\"3MB L2, 32MB L3 Cache\"', '2025-04-11 20:12:30'),
(166, 99, 256, 'AMD Ryzen 5 5600XT Vermeer 3.7GHz 6-Core AM4', 169.00, 1, '\"3MB L2, 32MB L3 Cache\"', '2025-04-11 20:19:34'),
(167, 100, 258, 'AMD Ryzen 5 5600XT Vermeer 3.7GHz 6-Core AM4', 169.00, 1, '\"3MB L2, 32MB L3 Cache\"', '2025-04-11 21:34:28'),
(168, 100, 257, 'AMD Ryzen 5 5600XT Vermeer 3.7GHz 6-Core AM4', 169.00, 1, '\"3MB L2, 32MB L3 Cache\"', '2025-04-11 21:34:28'),
(169, 101, 260, 'AMD Ryzen 5 5600XT Vermeer 3.7GHz 6-Core AM4', 169.00, 1, '\"3MB L2, 32MB L3 Cache\"', '2025-04-11 21:34:54'),
(170, 101, 259, 'AMD Ryzen 5 5600XT Vermeer 3.7GHz 6-Core AM4', 169.00, 1, '\"3MB L2, 32MB L3 Cache\"', '2025-04-11 21:34:54'),
(171, 102, 12, 'AMD Ryzen 5 5600XT Vermeer 3.7GHz 6-Core AM4', 169.00, 1, '3MB L2, 32MB L3 Cache', '2025-04-11 21:40:56'),
(172, 103, 271, 'LG 39GS95QE-B.AUS 39&quot; 2K WQHD', 1499.00, 2, '\"240 Hz Refresh Rate, .03 ms Response Time, OLED Panel\"', '2025-04-11 23:38:39'),
(173, 103, 270, 'ASUS ROG Swift PG32UCDM 31.5&quot; 4K UHD', 1199.00, 2, '\"240 Hz Refresh Rate, .03 ms Response Time, QD-OLED Panel\"', '2025-04-11 23:38:39'),
(174, 103, 269, 'Corsair XENEON 34WQHD240-C 34&quot; UHD', 1199.00, 2, '\"240 Hz Refresh Rate, 0.03 ms Response Time, QD-OLED Panel\"', '2025-04-11 23:38:39'),
(175, 103, 267, 'AMD Ryzen 5 8600G AM5 4.3GHz 6-Core', 159.00, 2, '\"8MB L2, 16MB L3 Cache\"', '2025-04-11 23:38:39'),
(176, 103, 268, 'AMD Ryzen 7 5800XT Vermeer AM4 3.80GHz 8-Core', 139.00, 2, '\"4MB L2, 32MB L3 Cache\"', '2025-04-11 23:38:39'),
(177, 103, 266, 'AMD Ryzen 5 5600XT Vermeer 3.7GHz 6-Core AM4', 169.00, 2, '\"3MB L2, 32MB L3 Cache\"', '2025-04-11 23:38:39'),
(178, 103, 265, 'Ultra 5070 Gaming PC', 2.00, 2, '\"GeForce RTX\\u2122 5070 12GB GDDR7 Video Card (DLSS 4.0) [AI-Powered Graphics]\"', '2025-04-11 23:38:39'),
(179, 103, 264, 'Creator PC Ultimate', 4.00, 2, '\"GeForce RTX\\u2122 5090 32GB GDDR7 Video Card (DLSS 4.0) [AI-Powered Graphics]\"', '2025-04-11 23:38:39'),
(180, 103, 262, 'PC GVN x ASUS Back to Future', 2.00, 2, '\"\"', '2025-04-11 23:38:39'),
(181, 103, 263, 'Hyper Liquid Alloy Black Mamba', 7.00, 2, '\"GeForce RTX\\u2122 5090 32GB GDDR7 Video Card (DLSS 4.0) [AI-Powered Graphics]\"', '2025-04-11 23:38:39'),
(182, 104, 12, 'AMD Ryzen 5 5600XT Vermeer 3.7GHz 6-Core AM4', 169.00, 1, '3MB L2, 32MB L3 Cache', '2025-04-12 00:08:10'),
(183, 104, 8, 'ASUS ROG Swift PG32UCDM 31.5&quot; 4K UHD', 1199.00, 1, '240 Hz Refresh Rate, .03 ms Response Time, QD-OLED Panel', '2025-04-12 00:08:10'),
(184, 105, 7, 'LG 39GS95QE-B.AUS 39&quot; 2K WQHD', 1499.00, 1, '240 Hz Refresh Rate, .03 ms Response Time, OLED Panel', '2025-04-12 00:09:02'),
(185, 106, 9, 'Corsair XENEON 34WQHD240-C 34&quot; UHD', 1199.00, 1, '240 Hz Refresh Rate, 0.03 ms Response Time, QD-OLED Panel', '2025-04-12 00:15:04'),
(186, 106, 11, 'AMD Ryzen 5 8600G AM5 4.3GHz 6-Core', 159.00, 1, '8MB L2, 16MB L3 Cache', '2025-04-12 00:15:04'),
(187, 107, 277, 'AMD Ryzen 7 5800XT Vermeer AM4 3.80GHz 8-Core', 139.00, 1, '\"4MB L2, 32MB L3 Cache\"', '2025-04-12 00:15:46'),
(188, 108, 10, 'AMD Ryzen 7 5800XT Vermeer AM4 3.80GHz 8-Core', 139.00, 1, '4MB L2, 32MB L3 Cache', '2025-04-12 00:16:30'),
(189, 109, 8, 'ASUS ROG Swift PG32UCDM 31.5&quot; 4K UHD', 1199.00, 1, '240 Hz Refresh Rate, .03 ms Response Time, QD-OLED Panel', '2025-04-12 00:17:10'),
(190, 110, 280, 'AMD Ryzen 5 5600XT Vermeer 3.7GHz 6-Core AM4', 169.00, 1, '\"3MB L2, 32MB L3 Cache\"', '2025-04-12 00:18:18'),
(191, 111, 10, 'AMD Ryzen 7 5800XT Vermeer AM4 3.80GHz 8-Core', 139.00, 1, '4MB L2, 32MB L3 Cache', '2025-04-12 00:19:10'),
(192, 112, 9, 'Corsair XENEON 34WQHD240-C 34&quot; UHD', 1199.00, 2, '240 Hz Refresh Rate, 0.03 ms Response Time, QD-OLED Panel', '2025-04-12 00:28:12'),
(193, 113, 12, 'AMD Ryzen 5 5600XT Vermeer 3.7GHz 6-Core AM4', 169.00, 3, '3MB L2, 32MB L3 Cache', '2025-04-12 00:46:56'),
(194, 114, 8, 'ASUS ROG Swift PG32UCDM 31.5&quot; 4K UHD', 1199.00, 1, '240 Hz Refresh Rate, .03 ms Response Time, QD-OLED Panel', '2025-04-12 00:48:58'),
(195, 115, 12, 'AMD Ryzen 5 5600XT Vermeer 3.7GHz 6-Core AM4', 169.00, 1, '3MB L2, 32MB L3 Cache', '2025-04-12 01:30:38'),
(196, 116, 12, 'AMD Ryzen 5 5600XT Vermeer 3.7GHz 6-Core AM4', 169.00, 1, '3MB L2, 32MB L3 Cache', '2025-04-12 01:47:48');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL,
  `brand` varchar(100) NOT NULL,
  `regular_price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `status` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `specifications` text DEFAULT NULL,
  `images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`images`)),
  `tags` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`tags`)),
  `features` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`features`)),
  `rating` decimal(3,2) DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `name`, `category`, `brand`, `regular_price`, `quantity`, `status`, `description`, `specifications`, `images`, `tags`, `features`, `rating`, `created_at`, `updated_at`) VALUES
(4, 'Ultra 5070 Gaming PC', 'desktop', 'other', 2045.00, 80, '0', 'CyberPowerPC PRISM 360V Mid-Tower Gaming Case w/ Front, side Tempered Glass Swing Door + 3X 120mm ARGB Fans (Silver)', 'GeForce RTX™ 5070 12GB GDDR7 Video Card (DLSS 4.0) [AI-Powered Graphics]', '[\"uploads\\/products\\/67f1f01d97632.png\",\"uploads\\/products\\/67f1f01d9782e.png\",\"uploads\\/products\\/67f1f01d97a21.png\"]', '[]', '[\"bestseller\"]', 0.00, '2025-04-06 03:08:13', '2025-04-06 03:08:13'),
(5, 'Creator PC Ultimate', 'desktop', 'other', 4909.00, 250, '0', 'CyberPowerPC HYTE Y60 Dual Chamber Mid-Tower Gaming Case w/ Panoramic View Tempered Glass + 2x120mm Fans (PANDA)', 'GeForce RTX™ 5090 32GB GDDR7 Video Card (DLSS 4.0) [AI-Powered Graphics]', '[\"uploads\\/products\\/67f1f11615468.png\",\"uploads\\/products\\/67f1f116155b3.png\",\"uploads\\/products\\/67f1f1161571c.png\"]', '[]', '[\"bestseller\",\"limited\"]', 0.00, '2025-04-06 03:12:22', '2025-04-06 03:12:22'),
(6, 'Hyper Liquid Alloy Black Mamba', 'desktop', 'other', 7189.00, 200, '0', 'Phanteks Enthoo Elite Aluminum Extreme Full Tower Case W/ Full-size Tempered Glass Panel Window on Hinges + RGB light (Black Color)', 'GeForce RTX™ 5090 32GB GDDR7 Video Card (DLSS 4.0) [AI-Powered Graphics]', '[\"uploads\\/products\\/67f1f1b81d87b.png\",\"uploads\\/products\\/67f1f1b81da13.png\",\"uploads\\/products\\/67f1f1b81dbf4.png\"]', '[]', '[\"new\",\"limited\"]', 0.00, '2025-04-06 03:15:04', '2025-04-06 03:15:04'),
(7, 'LG 39GS95QE-B.AUS 39&quot; 2K WQHD', 'monitor', 'other', 1499.00, 10, '0', 'NVIDIA G-Sync / AMD FreeSync Premium Pro; HDR; HDMI DisplayPort; 4-Side Virtually Borderless', '240 Hz Refresh Rate, .03 ms Response Time, OLED Panel', '[\"uploads\\/products\\/67f1f35c8f8a4.jpg\",\"uploads\\/products\\/67f1f35c8fac7.jpg\",\"uploads\\/products\\/67f1f35c8fc7b.jpg\"]', '[]', '[\"bestseller\"]', 0.00, '2025-04-06 03:22:04', '2025-04-06 03:22:04'),
(8, 'ASUS ROG Swift PG32UCDM 31.5&quot; 4K UHD', 'monitor', 'asus', 1199.00, 22, '0', 'AMD FreeSync Premium Pro; / NVIDA G-Sync Compatible; HDR; HDMI DisplayPort USB Type-C', '240 Hz Refresh Rate, .03 ms Response Time, QD-OLED Panel', '[\"uploads\\/products\\/67f1f3ff2851a.jpg\",\"uploads\\/products\\/67f1f3ff2870e.jpg\",\"uploads\\/products\\/67f1f3ff28854.jpg\"]', '[]', '[\"bestseller\"]', 0.00, '2025-04-06 03:24:47', '2025-04-06 03:24:47'),
(9, 'Corsair XENEON 34WQHD240-C 34&quot; UHD', 'monitor', 'corsair', 1199.00, 20, '0', 'AMD FreeSync Technology and NVIDIA G-Sync Compatible; HDR; HDMI DisplayPort; Proximity sensor OSD', '240 Hz Refresh Rate, 0.03 ms Response Time, QD-OLED Panel', '[\"uploads\\/products\\/67f1f47551a1d.jpg\",\"uploads\\/products\\/67f1f47551bdf.jpg\",\"uploads\\/products\\/67f1f47551da5.jpg\"]', '[]', '[\"featured\"]', 0.00, '2025-04-06 03:26:45', '2025-04-06 03:26:45'),
(10, 'AMD Ryzen 7 5800XT Vermeer AM4 3.80GHz 8-Core', 'processor', 'amd', 139.00, 35, '0', 'Designed for socket AM4 motherboards using the powerful Zen 3 architecture, the 7nm 5th generation Ryzen processor offers significantly improved performance compared to its predecessor. With a base clock speed of 3.8 GHz and a max boost clock speed of 4.8 GHz in addition to 32MB of L3 Cache, the Ryzen 7 5800XT is built to deliver the power needed to smoothly handle tasks ranging from content creation to immersive gaming experiences. You can boost performance further by overclocking this unlocked processor. Other features include support for PCIe Gen 4 technology and 3200 MHz DDR4 RAM with compatible motherboards.', '4MB L2, 32MB L3 Cache', '[\"uploads\\/products\\/67f1f53905ee4.jpg\",\"uploads\\/products\\/67f1f53906055.jpg\",\"uploads\\/products\\/67f1f539061b1.jpg\"]', '[]', '[\"sale\"]', 0.00, '2025-04-06 03:30:01', '2025-04-06 03:30:01'),
(11, 'AMD Ryzen 5 8600G AM5 4.3GHz 6-Core', 'processor', 'amd', 159.00, 100, '0', 'Incredible PC gaming is within your reach. Get your hands on an AMD Ryzen 8000G Series processor and start playing in high definition out of the box. With the power of Radeon 700M graphics built-in, the complete experience your game deserves is finally here. AMD Ryzen 8000G Series processors come with Radeon 700M series graphics built in to get you in the game, no graphics card necessary. And if you want to go beyond, like all AMD Ryzen processors, 8000G Series models are compatible with graphics cards for even more performance.', '8MB L2, 16MB L3 Cache', '[\"uploads\\/products\\/67f1f5c972dbb.jpg\",\"uploads\\/products\\/67f1f5c972f20.jpg\",\"uploads\\/products\\/67f1f5c97309a.jpg\"]', '[]', '[\"sale\",\"limited\"]', 0.00, '2025-04-06 03:32:25', '2025-04-06 03:32:25'),
(12, 'AMD Ryzen 5 5600XT Vermeer 3.7GHz 6-Core AM4', 'processor', 'amd', 169.00, 5, '0', 'AMD Ryzen 5 5600XT gaming desktop processors feature 6 high-performance cores for those who just want to game.', '3MB L2, 32MB L3 Cache', '[\"uploads\\/products\\/67f1f668ced53.jpg\",\"uploads\\/products\\/67f1f668cef4e.jpg\",\"uploads\\/products\\/67f1f668cf12f.jpg\"]', '[]', '[\"new\"]', 0.00, '2025-04-06 03:35:04', '2025-04-06 03:35:04'),
(14, 'PC GVN x ASUS Back to Future', 'desktop', 'asus', 2249.00, 5, '0', 'Mainboard ASUS TUF GAMING Z790-BTF WIFI DDR5 - 36 Tháng\r\nCPU Intel Core i7 14700K / Turbo up to 5.6GHz / 20 Nhân 28 Luồng / 33MB / LGA 1700 - 36 Tháng\r\nRAM Corsair Vengeance RGB White 32GB (2x16GB) 5600 DDR5 - 36 Tháng\r\nVGA ASUS TUF Gaming GeForce RTX 4070 Ti SUPER BTF White OC Edition 16GB GDDR6X - 36 Tháng\r\nSSD Tùy chọn nâng cấp - 60 Tháng\r\nHDD Tùy chọn nâng cấp - 24 Tháng\r\nPSU Corsair RM850e ATX 3.0 - 80 Plus Gold - Full Modular (850W) - 84 Tháng\r\nCASE ASUS TUF Gaming GT302 ARGB White - 24 Tháng', '', '[\"uploads\\/products\\/67f45a0fcfd21.jpg\",\"uploads\\/products\\/67f45a0fcfebd.jpg\",\"uploads\\/products\\/67f45a0fcffee.jpg\"]', '[]', '[\"bestseller\",\"limited\"]', 0.00, '2025-04-07 23:04:47', '2025-04-07 23:04:47'),
(17, 'PC GVN x ASUS Back to Future', 'desktop', 'asus', 2249.00, 5, '0', 'Mainboard ASUS TUF GAMING Z790-BTF WIFI DDR5 - 36 Tháng\r\nCPU Intel Core i7 14700K / Turbo up to 5.6GHz / 20 Nhân 28 Luồng / 33MB / LGA 1700 - 36 Tháng\r\nRAM Corsair Vengeance RGB White 32GB (2x16GB) 5600 DDR5 - 36 Tháng\r\nVGA ASUS TUF Gaming GeForce RTX 4070 Ti SUPER BTF White OC Edition 16GB GDDR6X - 36 Tháng\r\nSSD Tùy chọn nâng cấp - 60 Tháng\r\nHDD Tùy chọn nâng cấp - 24 Tháng\r\nPSU Corsair RM850e ATX 3.0 - 80 Plus Gold - Full Modular (850W) - 84 Tháng\r\nCASE ASUS TUF Gaming GT302 ARGB White - 24 Tháng', '', '[\"uploads\\/products\\/67f465a5c529b.jpg\",\"uploads\\/products\\/67f465a5c55a3.jpg\",\"uploads\\/products\\/67f465a5c5764.jpg\"]', '[]', '[\"bestseller\",\"limited\"]', 0.00, '2025-04-07 23:54:13', '2025-04-07 23:54:13');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_features`
--

CREATE TABLE `product_features` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `feature` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_images`
--

CREATE TABLE `product_images` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `is_main` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image_path`, `is_main`, `created_at`) VALUES
(13, 18, 'uploads/products/67ebfe9fd3b98_1743519391.png', 1, '2025-04-01 14:56:31'),
(14, 17, 'uploads/products/67ebfed91221c_1743519449.png', 1, '2025-04-01 14:57:29'),
(15, 20, 'uploads/products/67eca6d9c9c2e_1743562457.png', 1, '2025-04-02 02:54:17');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_tags`
--

CREATE TABLE `product_tags` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `tag` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `product_tags`
--

INSERT INTO `product_tags` (`id`, `product_id`, `tag`, `created_at`) VALUES
(7, 17, '[]', '2025-04-01 14:57:29'),
(8, 20, '[]', '2025-04-02 02:54:17');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `remember_tokens`
--

CREATE TABLE `remember_tokens` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(64) NOT NULL,
  `expiry` datetime NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `remember_tokens`
--

INSERT INTO `remember_tokens` (`id`, `user_id`, `token`, `expiry`, `created_at`) VALUES
(3, 5, 'f3debc8f21cfc1863868273139f7bb09', '2025-05-01 15:19:56', '2025-04-01 20:19:56'),
(4, 6, 'ae3bfcaa5fc3da3a729419c1e216276b', '2025-05-04 08:06:09', '2025-04-04 13:06:09'),
(5, 6, 'dd87e847348fa25a42bd2aa13b0b05e3', '2025-05-05 02:37:51', '2025-04-05 07:37:51'),
(6, 6, '2e19bb6c9c2329d52d54f323839dfd39', '2025-05-05 17:46:48', '2025-04-05 22:46:48'),
(7, 6, 'bf8519018ccec1c772091cffb7b625bf', '2025-05-05 17:59:51', '2025-04-05 22:59:51'),
(8, 6, '559572a0901d5fa10f99f6dd6badd6a1', '2025-05-06 12:20:46', '2025-04-06 17:20:46'),
(9, 6, 'deb5c70829737d315837ff7de0c2bbbd', '2025-05-07 04:52:47', '2025-04-07 09:52:47'),
(10, 10, 'c05cc3db0242631b8dc9996494ef9d7a', '2025-05-07 16:57:14', '2025-04-07 21:57:14'),
(11, 15, '46d1cd1f933f26819ec9272e38b3ce1f', '2025-05-07 20:16:27', '2025-04-08 01:16:27'),
(12, 15, 'f7475b094d87f3420132ea4d7d7a3b42', '2025-05-07 20:17:43', '2025-04-08 01:17:43'),
(13, 14, 'bb755fd74f402eab9ca91e89d135f143', '2025-05-07 20:19:36', '2025-04-08 01:19:36'),
(14, 8, '09a647cf138615e5967760d6b024fdde', '2025-05-07 21:36:28', '2025-04-08 02:36:28'),
(15, 8, '4d1f7a5be31ddbfa2db3526ee57e8eca', '2025-05-07 23:19:27', '2025-04-08 04:19:27'),
(16, 8, '648a4c55069e3e83a67acc5080054226', '2025-05-08 00:35:04', '2025-04-08 05:35:04'),
(17, 8, '2fe81ee96a27904680c3488f40640a62', '2025-05-08 00:44:46', '2025-04-08 05:44:46'),
(18, 8, '6e6e7bd94769ac2db88a31cea2a6ca48', '2025-05-08 00:50:05', '2025-04-08 05:50:05'),
(19, 15, 'ae3a23eeddb194e51d9c8c6d64d0be98', '2025-05-08 00:54:30', '2025-04-08 05:54:30'),
(20, 16, '758c226a3c3ebac51d83598f89be6bbc', '2025-05-08 04:14:59', '2025-04-08 09:14:59'),
(21, 16, 'd65618b479d9a90ba694c27452adc062', '2025-05-08 04:25:05', '2025-04-08 09:25:05'),
(22, 8, '0a36b221139a7d61bfbe2b9943961e5b', '2025-05-08 04:28:43', '2025-04-08 09:28:43'),
(23, 8, '818fcf327d20c8d5580343f909068698', '2025-05-08 04:29:31', '2025-04-08 09:29:31'),
(24, 16, 'e0b7a3ea40d78e0cdf431d3eee445de6', '2025-05-08 04:38:00', '2025-04-08 09:38:00'),
(25, 16, '4c21bf74d7402eddd9950477a8b3777e', '2025-05-08 04:47:26', '2025-04-08 09:47:26'),
(26, 16, 'd5defc4f99b3d43ca8f016e726c78669', '2025-05-08 04:49:02', '2025-04-08 09:49:02');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `gender` enum('male','female','other') DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `avatar` varchar(255) DEFAULT 'default-avatar.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `password`, `created_at`, `updated_at`, `role`, `gender`, `phone`, `date_of_birth`, `avatar`) VALUES
(5, 'Admin User', 'admin@techhub.com', '$2y$10$jbGYP54x6wHFEq3xUAqCw.mn.flivJyUsT.HMeQq68CU1gYn8mo.m', '2025-04-01 14:55:01', '2025-04-01 14:55:01', 'admin', NULL, NULL, NULL, 'default-avatar.png'),
(6, 'test', 'test12345@gmail.com', '$2y$10$h.YV8kEFtslazAsrO3Wf3O9XL0MD0qj3ca2EvnFoRZ/GXdzdxOaFS', '2025-04-04 13:05:57', '2025-04-04 13:05:57', 'user', NULL, NULL, NULL, 'default-avatar.png'),
(7, 'Phạm Minh Minh', 'phamminhkhai2003@gmail.com', '$2y$10$EfdygTQfGY.usKyjotG5QOZak31Ra55Bg50ISAxAebJeadHD00S.6', '2025-04-07 12:21:12', '2025-04-07 12:21:12', 'user', NULL, NULL, NULL, 'default-avatar.png'),
(8, 'Phạm Minh Quý', 'pmquy123@gmail.com', '$2y$10$cKWxe8kNumspQeebd5xCLO2vzBzG8YcodDXv80KHsDZHf/ho.wtAe', '2025-04-07 15:27:07', '2025-04-07 15:27:07', 'user', NULL, NULL, NULL, 'default-avatar.png'),
(15, 'Admin Minh Quý', 'pmqadmin@techhub.com', '$2y$10$2WxwlEbATnpOYj6a49Ww5.omXJeTw81zYhlyhsyv4PNBSb08vBLFO', '2025-04-08 01:16:12', '2025-04-12 08:53:59', 'admin', 'male', '0907337542', '2002-11-02', 'avatar_67f9c7b7e8f05.jpg'),
(16, 'Minh Quy', 'pmquser1@gmail.com', '$2y$10$X4w0l02Zv31e.mbgVEs8vOVigFJcdLUSAfHBYxyJvvfsTQDzllmK6', '2025-04-08 09:14:12', '2025-04-08 09:14:12', 'user', NULL, NULL, NULL, 'default-avatar.png'),
(17, 'testing', 'emailtest1@gmail.com', '$2y$10$6a7vYIvHJUUHUSKOtd.VHeRbgpMVLzG2luaGwHdlpODseMfIkK9ii', '2025-04-11 21:37:25', '2025-04-11 21:37:25', 'user', NULL, NULL, NULL, 'default-avatar.png');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `session_id` (`session_id`);

--
-- Chỉ mục cho bảng `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_unique` (`email`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_number_unique` (`order_number`),
  ADD KEY `idx_session_id` (`session_id`),
  ADD KEY `fk_orders_customer` (`customer_id`);

--
-- Chỉ mục cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_order_items_order` (`order_id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `product_features`
--
ALTER TABLE `product_features`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `product_tags`
--
ALTER TABLE `product_tags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `remember_tokens`
--
ALTER TABLE `remember_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=287;

--
-- AUTO_INCREMENT cho bảng `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;

--
-- AUTO_INCREMENT cho bảng `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=197;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT cho bảng `product_features`
--
ALTER TABLE `product_features`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT cho bảng `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT cho bảng `product_tags`
--
ALTER TABLE `product_tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `remember_tokens`
--
ALTER TABLE `remember_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_orders_customer` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `fk_order_items_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `product_features`
--
ALTER TABLE `product_features`
  ADD CONSTRAINT `product_features_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
