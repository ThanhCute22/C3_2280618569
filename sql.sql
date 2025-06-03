-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for my_store
CREATE DATABASE IF NOT EXISTS `my_store` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `my_store`;

-- Dumping structure for table my_store.account
CREATE TABLE IF NOT EXISTS `account` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table my_store.account: ~4 rows (approximately)
INSERT INTO `account` (`id`, `username`, `fullname`, `password`, `role`, `email`, `phone`, `avatar`) VALUES
	(1, 'Luki', 'Hoàng Thị Mỹ Thanh', '$2y$10$ojdBZq1cCMA1cA7SSwdvP.zffIXgfpP925H3RGFrEeaCs0SdQc38S', 'admin', '', '', NULL),
	(2, 'Finn', 'Đoàn Trần Ngọc Long', '$2y$10$/1gNmLkTrSVKpb2uFxSchewjq.oISNBFbZXNmYRmgj8qDSg90XXui', 'user', '', '', NULL),
	(3, 'Phát', 'Huỳnh Tấn Phát', '$2y$10$N9SZR0ZCpzjprcMjRp7MBOApzHPwCjXkOxF4HRy6MCN02FBv7BgFi', 'user', 'phatdet2312@gmail.com', '0559992099', 'uploads/avatars/hinh-anh-hoa-bi-ngan-xanh-tuyet-dep_091633577.jpg'),
	(4, 'hehe', 'Nguyễn Thị', '$2y$10$CeX5zX/HzXJWxFE33K6aZ.7R7Pek.xBqyfk48k5RC8kAMwj7HgEzq', 'user', 'lukiotonashi@gmail.com', '0765148019', 'uploads/avatars/hinh-anh-hoa-bi-ngan-xanh-tuyet-dep_091633577.jpg');

-- Dumping structure for table my_store.category
CREATE TABLE IF NOT EXISTS `category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table my_store.category: ~5 rows (approximately)
INSERT INTO `category` (`id`, `name`, `description`) VALUES
	(1, 'Điện thoại', 'Danh mục các loại điện thoại'),
	(2, 'Laptop', 'Danh mục các loại laptop'),
	(3, 'Máy tính bảng', 'Danh mục các loại máy tính bảng'),
	(4, 'Phụ kiện', 'Danh mục phụ kiện điện tử'),
	(5, 'Thiết bị âm thanh', 'Danh mục loa, tai nghe, micro');

-- Dumping structure for table my_store.orders
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `address` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `total_price` decimal(10,2) NOT NULL,
  `payment_method` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  CONSTRAINT `valid_payment_method` CHECK ((`payment_method` in (1,2,3)))
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table my_store.orders: ~8 rows (approximately)
INSERT INTO `orders` (`id`, `name`, `phone`, `email`, `address`, `created_at`, `total_price`, `payment_method`) VALUES
	(1, 'Hoàng Thị Mỹ Thanh', '0765148019', '', '22/32\r\n', '2025-05-27 08:16:16', 925200.00, 1),
	(2, 'Hoàng Thị Mỹ Thanh', '0765148019', '', '222222222222', '2025-05-27 08:16:51', 333000.00, 1),
	(3, 'Hoàng Thị Mỹ Thanh', '0765148019', '', '33333333333', '2025-05-27 08:17:53', 1482200.00, 1),
	(4, 'Hoàng Thị Mỹ Thanh', '0765148019', 'hoangthimythanh95@gmail.com', '222222222222222', '2025-05-27 08:32:27', 333000.00, 1),
	(5, 'Hoàng Thị Mỹ Thanh', '0765148019', 'hoangthimythanh95@gmail.com', 'qqqqqqqqqq', '2025-05-27 08:49:58', 499500.00, 1),
	(6, 'Hoàng Thị Mỹ Thanh', '0765148019', 'hoangthimythanh95@gmail.com', 'aaaaaaaaaa', '2025-05-27 08:56:05', 333000.00, 1),
	(7, 'Hoàng Thị Mỹ Thanh', '0765148019', 'hoangthimythanh95@gmail.com', 'aaaaaaaaaa', '2025-05-27 09:07:52', 662000.00, 1),
	(8, 'Hoàng Thị Mỹ Thanh', '0765148019', 'hoangthimythanh95@gmail.com', 'aaaaaaaaaaaa', '2025-05-27 09:08:40', 1665000.00, 1);

-- Dumping structure for table my_store.order_details
CREATE TABLE IF NOT EXISTS `order_details` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table my_store.order_details: ~11 rows (approximately)
INSERT INTO `order_details` (`id`, `order_id`, `product_id`, `quantity`, `price`, `total_price`) VALUES
	(1, 1, 3, 2, 166500.00, 333000.00),
	(2, 1, 2, 2, 296100.00, 592200.00),
	(3, 2, 3, 2, 166500.00, 333000.00),
	(4, 3, 2, 2, 296100.00, 592200.00),
	(5, 3, 1, 1, 890000.00, 890000.00),
	(6, 4, 3, 2, 166500.00, 333000.00),
	(7, 5, 3, 3, 166500.00, 499500.00),
	(8, 6, 3, 2, 166500.00, 333000.00),
	(9, 7, 2, 1, 329000.00, 329000.00),
	(10, 7, 3, 2, 166500.00, 333000.00),
	(11, 8, 3, 10, 166500.00, 1665000.00);

-- Dumping structure for table my_store.product
CREATE TABLE IF NOT EXISTS `product` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table my_store.product: ~6 rows (approximately)
INSERT INTO `product` (`id`, `name`, `description`, `price`, `image`, `category_id`) VALUES
	(1, 'Chuột không dây Gaming DAREU A950 TRIPLE MODE', 'Siêu nhẹ, sạc nhanh', 890000.00, 'uploads/chuot-khong-day-gaming-dareu-a950-triple-mode-sieu-nhe-01.jpg', 4),
	(2, 'Tai nghe gaming DAREU EH416 RGB', 'Hiệu ứng: giả lập 7.1', 329000.00, 'uploads/tai-nghe-gaming-dareu-eh416-rgb-01.jpg', 4),
	(3, 'Bàn phím DAREU LK135 ', 'Chống nước', 185000.00, 'uploads/ban-phim-chong-nuoc-dare-lk135-01.jpg', 4),
	(4, 'Laptop Asus ROG Zephyrus G16 GU603VI-G16.I74070 ', 'CPU i7-13620H | RAM 16GB DDR4 | SSD 512GB PCIe | VGA RTX 4070 8GB | 16.0 FHD+ IPS, 100% sRGB', 33990000.00, 'uploads/asus-rog-zephyrus-g16-gu603-man-06f11cb6-ae27-413c-a0a7-bc9703103b7d.jpg', 2),
	(5, 'iPad Air M3 13 inch Wifi 128GB ', 'Chính hãng VN - MCNL4ZA/A', 21330000.00, 'uploads/250305094517-ipad-air-7-purple.jpg', 3),
	(6, 'iPhone 16 128GB', 'Chính hãng VN/A - MYEA3VN/A', 18790000.00, 'uploads/241207031455-3.jpg', 1);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
