-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 14, 2025 lúc 08:00 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.0.30

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

--
-- Đang đổ dữ liệu cho bảng `cart_items`
--

INSERT INTO `cart_items` (`id`, `product_id`, `quantity`, `created_at`, `updated_at`, `session_id`, `product_name`, `price`, `image_url`, `specs`) VALUES
(333, 6, 1, '2025-04-14 03:09:42', '2025-04-14 03:09:42', 'sglvesrkdd75la0v706kc1irsi', 'Hyper Liquid Alloy Black Mamba', 7189.00, 'uploads/products/67f1f1b81d87b.png', 'GeForce RTX™ 5090 32GB GDDR7 Video Card (DLSS 4.0) [AI-Powered Graphics]');

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
(1, 'Phạm', 'Minh Minh', 'phamminhkhai3690@gmail.com', '0706604408', '1151/19 Huỳnh Tấn Phát', 'xxxr', 'xxxr', 'UK', '2025-04-07 05:45:03'),
(3, 'Phạm Khải', 'Minh', 'phamminhkhai36900@gmail.com', '0706604405', '1151/17 Huỳnh Tấn Phát', 'xxxrt', 'xxxrt', 'US', '2025-04-07 05:46:04'),
(5, 'Phạm', 'Pham', 'phamminhkhai36999@gmail.com', '0706604444', '1151/19 Huỳnh Tấn Phát', 'New York', 'Korean', 'UK', '2025-04-07 05:46:31'),
(8, 'Phạm', 'Pham', 'phamminhkhai3619@gmail.com', '0706604456', '1151/19 Huỳnh Tấn Phát', 'New York', 'Korean', 'CA', '2025-04-07 05:47:35'),
(9, 'Phạm Minh', 'Quý', 'pmqadmin@techhub.com', '0907337542', 'Hoang Viet', 'Ba Ria', 'Viet Nam', 'VN', '2025-04-11 17:36:07'),
(10, 'Pham Minh', 'Quy', 'pmqadmin1@techhub.com', '1234567890', 'Do Xuan Hop', 'Thu Duc', 'Quan 9', 'VN', '2025-04-12 00:09:02'),
(11, 'Phạm', 'Minh Khải', 'phamminhkhai369@gmail.com', '0706604402', '1151/15 Huỳnh Tấn Phát', 'xxx', 'xxx', 'VN', '2025-04-13 13:37:27');

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
(119, 11, '0vqt9dn0a388gt7h4fsnavrc99', 'ORD5818831184', 'Processing', 'Phạm', 'Minh Khải', 'phamminhkhai369@gmail.com', '0706604402', '1151/15 Huỳnh Tấn Phát', 'xxx', 'xxx', 'VN', '', 'Credit card', '', 14378.00, 0.00, 862.68, 15240.68, '2025-04-13 15:35:26', '2025-04-13 15:35:26'),
(120, 1, '7psrdknlifm1ro0q0pfp4tfbjl', 'ORD6740608753', 'Shipped', 'Phạm', 'Minh Minh', 'phamminhkhai3690@gmail.com', '0706604408', '1151/19 Huỳnh Tấn Phát', 'xxxr', 'xxxr', 'UK', '', 'Credit card', '', 1658.00, 0.00, 99.48, 1757.48, '2025-04-13 16:23:50', '2025-04-14 03:11:17'),
(121, 3, 'coscfte2i7db8fpvcnpcpu35oc', 'ORD9299063169', 'Processing', 'Phạm Khải', 'Minh', 'phamminhkhai36900@gmail.com', '0706604405', '1151/17 Huỳnh Tấn Phát', 'xxxrt', 'xxxrt', 'US', '', 'Credit card', '', 20862.00, 0.00, 1251.72, 22113.72, '2025-04-13 16:31:11', '2025-04-13 16:31:11');

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
(202, 119, 6, 'Hyper Liquid Alloy Black Mamba', 7189.00, 2, 'GeForce RTX™ 5090 32GB GDDR7 Video Card (DLSS 4.0) [AI-Powered Graphics]', '2025-04-13 15:35:26'),
(203, 120, 11, 'AMD Ryzen 5 8600G AM5 4.3GHz 6-Core', 159.00, 1, '8MB L2, 16MB L3 Cache', '2025-04-13 16:23:50'),
(204, 120, 7, 'LG 39GS95QE-B.AUS 39&quot; 2K WQHD', 1499.00, 1, '240 Hz Refresh Rate, .03 ms Response Time, OLED Panel', '2025-04-13 16:23:50'),
(205, 121, 5, 'Creator PC Ultimate', 4909.00, 3, 'GeForce RTX™ 5090 32GB GDDR7 Video Card (DLSS 4.0) [AI-Powered Graphics]', '2025-04-13 16:31:11'),
(206, 121, 4, 'Ultra 5070 Gaming PC', 2045.00, 3, 'GeForce RTX™ 5070 12GB GDDR7 Video Card (DLSS 4.0) [AI-Powered Graphics]', '2025-04-13 16:31:11');

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
(12, 'AMD Ryzen 5 5600XT Vermeer 3.7GHz 6-Core AM4', 'processors', 'amd', 169.00, 20, 'in-stock', 'AMD Ryzen 5 5600XT gaming desktop processors feature 6 high-performance cores for those who just want to game.', '3MB L2, 32MB L3 Cache', '[\"uploads\\/products\\/67f1f668ced53.jpg\",\"uploads\\/products\\/67f1f668cef4e.jpg\",\"uploads\\/products\\/67f1f668cf12f.jpg\"]', '[]', '[\"new\"]', 0.00, '2025-04-06 03:35:04', '2025-04-14 03:12:37');

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
(26, 16, 'd5defc4f99b3d43ca8f016e726c78669', '2025-05-08 04:49:02', '2025-04-08 09:49:02'),
(27, 18, '6660ee401489f6d4a3f96e20d7f998c6', '2025-05-13 15:36:59', '2025-04-13 20:36:59'),
(28, 19, '2c2d7ecda78c1e813b89a42b9d99bdad', '2025-05-13 18:30:32', '2025-04-13 23:30:32'),
(29, 5, '20a20ef82c99a85b5bc60bddd4da0215', '2025-05-14 05:08:17', '2025-04-14 10:08:17');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `support_tickets`
--

CREATE TABLE `support_tickets` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `order_number` varchar(50) DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `category` varchar(50) NOT NULL,
  `priority` varchar(20) NOT NULL,
  `message` text NOT NULL,
  `admin_notes` text DEFAULT NULL,
  `status` varchar(50) DEFAULT 'Open',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `support_tickets`
--

INSERT INTO `support_tickets` (`id`, `name`, `email`, `order_number`, `subject`, `category`, `priority`, `message`, `admin_notes`, `status`, `created_at`, `updated_at`) VALUES
(1, 'khai', 'minhkhai1132003@gmail.com', NULL, 'hello admin', 'product', 'normal', 'help', 'hello', 'Open', '2025-04-14 03:54:19', '2025-04-14 03:57:20');

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
(18, 'test12345', 'test12345@gmail.com', '$2y$10$ruDDGzYj4tdrrKZTBrGz6eRR2w4gPHtfkdB7g90qM6KMtyKGKrxyu', '2025-04-13 20:36:48', '2025-04-13 20:36:48', 'user', NULL, NULL, NULL, 'default-avatar.png'),
(19, 'khai1132003', 'khai1132003@gmail.com', '$2y$10$hfsc8BX/hLpTJeimx0x/sOj1biMfQp7H1lapScpvil3roou5elIMS', '2025-04-13 23:30:12', '2025-04-13 23:30:12', 'user', NULL, NULL, NULL, 'default-avatar.png');

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
-- Chỉ mục cho bảng `support_tickets`
--
ALTER TABLE `support_tickets`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=334;

--
-- AUTO_INCREMENT cho bảng `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT cho bảng `order_items`
--
ALTER TABLE `order_item
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT cho bảng `support_tickets`
--
ALTER TABLE `support_tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

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
