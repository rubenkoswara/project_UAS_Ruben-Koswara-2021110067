-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.4.3 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for renesca_aquatic_database
CREATE DATABASE IF NOT EXISTS `renesca_aquatic_database` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `renesca_aquatic_database`;

-- Dumping structure for table renesca_aquatic_database.brands
CREATE TABLE IF NOT EXISTS `brands` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table renesca_aquatic_database.brands: ~4 rows (approximately)
DELETE FROM `brands`;
INSERT INTO `brands` (`id`, `name`, `deleted_at`, `created_at`, `updated_at`) VALUES
	(1, 'Kandila', NULL, '2025-12-17 06:08:45', '2025-12-17 06:08:45'),
	(2, 'Amara', NULL, '2025-12-17 06:08:49', '2025-12-17 06:08:49'),
	(3, 'Resun', NULL, '2025-12-17 06:08:53', '2025-12-17 06:08:53'),
	(4, 'tetra', NULL, '2025-12-17 06:21:12', '2025-12-17 06:21:12');

-- Dumping structure for table renesca_aquatic_database.cache
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table renesca_aquatic_database.cache: ~8 rows (approximately)
DELETE FROM `cache`;
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
	('laravel-cache-356a192b7913b04c54574d18c28d46e6395428ab', 'i:1;', 1765999626),
	('laravel-cache-356a192b7913b04c54574d18c28d46e6395428ab:timer', 'i:1765999626;', 1765999626),
	('laravel-cache-3890421404265a888471e77356607867', 'i:3;', 1765993511),
	('laravel-cache-3890421404265a888471e77356607867:timer', 'i:1765993511;', 1765993511),
	('laravel-cache-77de68daecd823babbb58edb1c8e14d7106e83bb', 'i:2;', 1765994312),
	('laravel-cache-77de68daecd823babbb58edb1c8e14d7106e83bb:timer', 'i:1765994312;', 1765994312),
	('laravel-cache-dc44958e29ffba8b810d21377ae366b5', 'i:1;', 1765994985),
	('laravel-cache-dc44958e29ffba8b810d21377ae366b5:timer', 'i:1765994985;', 1765994985);

-- Dumping structure for table renesca_aquatic_database.cache_locks
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table renesca_aquatic_database.cache_locks: ~0 rows (approximately)
DELETE FROM `cache_locks`;

-- Dumping structure for table renesca_aquatic_database.cart_items
CREATE TABLE IF NOT EXISTS `cart_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cart_items_user_id_foreign` (`user_id`),
  KEY `cart_items_product_id_foreign` (`product_id`),
  CONSTRAINT `cart_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `cart_items_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table renesca_aquatic_database.cart_items: ~0 rows (approximately)
DELETE FROM `cart_items`;

-- Dumping structure for table renesca_aquatic_database.categories
CREATE TABLE IF NOT EXISTS `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table renesca_aquatic_database.categories: ~6 rows (approximately)
DELETE FROM `categories`;
INSERT INTO `categories` (`id`, `name`, `description`, `deleted_at`, `created_at`, `updated_at`) VALUES
	(1, 'Lampu', NULL, NULL, '2025-12-17 06:07:22', '2025-12-17 06:07:22'),
	(2, 'Pompa', '', NULL, '2025-12-17 06:07:27', '2025-12-17 06:07:27'),
	(3, 'Aerarasi', '', NULL, '2025-12-17 06:07:37', '2025-12-17 06:07:37'),
	(4, 'Filter', '', NULL, '2025-12-17 06:07:49', '2025-12-17 06:07:49'),
	(5, 'Makanan ', '', NULL, '2025-12-17 06:08:11', '2025-12-17 06:08:29'),
	(6, 'Obat', '', NULL, '2025-12-17 06:08:20', '2025-12-17 06:08:20');

-- Dumping structure for table renesca_aquatic_database.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table renesca_aquatic_database.failed_jobs: ~0 rows (approximately)
DELETE FROM `failed_jobs`;

-- Dumping structure for table renesca_aquatic_database.jobs
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table renesca_aquatic_database.jobs: ~0 rows (approximately)
DELETE FROM `jobs`;

-- Dumping structure for table renesca_aquatic_database.job_batches
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table renesca_aquatic_database.job_batches: ~0 rows (approximately)
DELETE FROM `job_batches`;

-- Dumping structure for table renesca_aquatic_database.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table renesca_aquatic_database.migrations: ~18 rows (approximately)
DELETE FROM `migrations`;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '0001_01_01_000000_create_users_table', 1),
	(2, '0001_01_01_000001_create_cache_table', 1),
	(3, '0001_01_01_000002_create_jobs_table', 1),
	(4, '2025_11_24_180144_add_two_factor_columns_to_users_table', 1),
	(5, '2025_11_24_180214_create_personal_access_tokens_table', 1),
	(6, '2025_11_24_181820_create_categories_table', 1),
	(7, '2025_11_24_181827_create_brands_table', 1),
	(8, '2025_11_24_181834_create_vendors_table', 1),
	(9, '2025_11_24_181841_create_products_table', 1),
	(10, '2025_11_24_181847_create_orders_table', 1),
	(11, '2025_11_24_181857_create_order_items_table', 1),
	(12, '2025_11_24_181912_create_reviews_table', 1),
	(13, '2025_11_24_181919_create_shipping_methods_table', 1),
	(14, '2025_11_24_181925_create_payment_methods_table', 1),
	(15, '2025_11_24_181933_create_trash_table', 1),
	(16, '2025_11_24_184943_create_returns_table', 1),
	(17, '2025_11_24_202140_add_role_to_users_table', 1),
	(18, '2025_11_30_113849_create_cart_items_table', 1);

-- Dumping structure for table renesca_aquatic_database.orders
CREATE TABLE IF NOT EXISTS `orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `total` decimal(12,2) NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_info` text COLLATE utf8mb4_unicode_ci,
  `payment_proof` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `receipt` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delivery_proof` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `orders_user_id_foreign` (`user_id`),
  CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table renesca_aquatic_database.orders: ~3 rows (approximately)
DELETE FROM `orders`;
INSERT INTO `orders` (`id`, `user_id`, `total`, `status`, `payment_method`, `shipping_info`, `payment_proof`, `receipt`, `delivery_proof`, `deleted_at`, `created_at`, `updated_at`) VALUES
	(1, 3, 41000.00, 'canceled', 'BCA', '{"alamat":"jalan gunung rahayu 3 no f3","kota":"cimahi","kecamatan":"cimahi utara","kelurahan":"pasirkaliki","no_telp":"123456789","note":null,"shipping":"JNE","shipping_cost":"12000.00"}', 'payment-proof/a0wgckaHPJ0hW4Qzz2pkjcT13nMII6dzUUAmmczr.jpg', NULL, NULL, NULL, '2025-12-17 10:46:25', '2025-12-17 12:26:37'),
	(2, 3, 160000.00, 'dikirim', 'BCA', '{"alamat":"jalan gunung rahayu 3 no f3","kota":"cimahi","kecamatan":"cimahi utara","kelurahan":"pasirkaliki","no_telp":"123456789","note":null,"shipping":"JNE","shipping_cost":"12000.00"}', 'payment-proof/VlxBuTBwfPFyZsOsaiU4sr3zBn8T3c3rG46oanHe.jpg', 'resi/lb4hID8CAHRg2Hp1aKJpzHxpZOHbzmW34rs0PdHl.jpg', NULL, NULL, '2025-12-17 10:57:39', '2025-12-17 12:26:08'),
	(3, 3, 108000.00, 'processing', 'BCA', '{"alamat":"jalan gunung rahayu 3 no f3","kota":"cimahi","kecamatan":"cimahi utara","kelurahan":"pasirkaliki","no_telp":"123456789","note":null,"shipping":"JNE","shipping_cost":"12000.00"}', 'payment-proof/xWb6VqLO1HScbpoZzj6fd6pIzkyxCFDUAqYYf1Sa.jpg', NULL, NULL, NULL, '2025-12-17 10:58:22', '2025-12-17 12:11:16');

-- Dumping structure for table renesca_aquatic_database.order_items
CREATE TABLE IF NOT EXISTS `order_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_items_order_id_foreign` (`order_id`),
  KEY `order_items_product_id_foreign` (`product_id`),
  CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table renesca_aquatic_database.order_items: ~3 rows (approximately)
DELETE FROM `order_items`;
INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 1, 2, 1, 29000.00, '2025-12-17 10:46:25', '2025-12-17 10:46:25', NULL),
	(2, 2, 1, 1, 148000.00, '2025-12-17 10:57:39', '2025-12-17 10:57:39', NULL),
	(3, 3, 3, 1, 96000.00, '2025-12-17 10:58:22', '2025-12-17 10:58:22', NULL);

-- Dumping structure for table renesca_aquatic_database.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table renesca_aquatic_database.password_reset_tokens: ~0 rows (approximately)
DELETE FROM `password_reset_tokens`;

-- Dumping structure for table renesca_aquatic_database.payment_methods
CREATE TABLE IF NOT EXISTS `payment_methods` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table renesca_aquatic_database.payment_methods: ~1 rows (approximately)
DELETE FROM `payment_methods`;
INSERT INTO `payment_methods` (`id`, `name`, `bank_name`, `account_number`, `account_name`, `deleted_at`, `created_at`, `updated_at`) VALUES
	(1, 'BCA', 'Bank Central Asia', '123456789', 'Renesca Aquatic', NULL, '2025-12-17 10:43:31', '2025-12-17 10:43:31');

-- Dumping structure for table renesca_aquatic_database.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  KEY `personal_access_tokens_expires_at_index` (`expires_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table renesca_aquatic_database.personal_access_tokens: ~0 rows (approximately)
DELETE FROM `personal_access_tokens`;

-- Dumping structure for table renesca_aquatic_database.products
CREATE TABLE IF NOT EXISTS `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `category_id` bigint unsigned NOT NULL,
  `brand_id` bigint unsigned NOT NULL,
  `vendor_id` bigint unsigned NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `stock` int NOT NULL DEFAULT '0',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `products_category_id_foreign` (`category_id`),
  KEY `products_brand_id_foreign` (`brand_id`),
  KEY `products_vendor_id_foreign` (`vendor_id`),
  CONSTRAINT `products_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE,
  CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `products_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table renesca_aquatic_database.products: ~4 rows (approximately)
DELETE FROM `products`;
INSERT INTO `products` (`id`, `name`, `description`, `category_id`, `brand_id`, `vendor_id`, `price`, `stock`, `image`, `deleted_at`, `created_at`, `updated_at`) VALUES
	(1, 'Kandila S1200 New', 'Lampu Aquarium Aquascape Dengan Panjang 120 Cm', 1, 1, 1, 148000.00, 11, 'products/Vn0wjgJSdUAPbZwngaNL2ai0o5Ul1RSrdUdeFMyt.jpg', NULL, '2025-12-17 06:17:39', '2025-12-17 11:13:06'),
	(2, 'Kandila ECO 1200 PowerHead ', 'Pompa Aquarium Dengan Daya listrik 10 Watt dan kubikasi 500 l/h', 2, 1, 1, 29000.00, 12, 'products/FHI2LiVaseo1gFCHA7d5TOlwTewsWCMepjPzkDUm.jpg', NULL, '2025-12-17 06:19:31', '2025-12-17 12:26:37'),
	(3, 'Tetra Bits Complete 93 Gram', 'Makanan Ikan Kualitas Premium Buatan Jerman ', 5, 4, 1, 96000.00, 11, 'products/pCsT3GFUm2pOANMwaxgRODcIcysEehrqY5t2y58L.jpg', NULL, '2025-12-17 06:21:03', '2025-12-17 10:58:22'),
	(4, 'Kandila ECO 888 Aerator Aquarium', 'Mesin Aerasi Aquarium 1 lubang dengan daya listrik 8 Watt', 3, 1, 1, 20000.00, 12, 'products/kxwFY5w2D3ZhqFHABe6lA9JSbhXhDfQI8GNrimJU.jpg', NULL, '2025-12-17 06:23:54', '2025-12-17 06:24:13');

-- Dumping structure for table renesca_aquatic_database.returns
CREATE TABLE IF NOT EXISTS `returns` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `order_item_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `status` enum('pending','reviewed','rejected','approved','shipped','received','rejected_by_admin') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `reason` text COLLATE utf8mb4_unicode_ci,
  `item_proof` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipment_proof` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `refund_proof` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `review_reason` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `returns_order_id_foreign` (`order_id`),
  KEY `returns_order_item_id_foreign` (`order_item_id`),
  KEY `returns_user_id_foreign` (`user_id`),
  CONSTRAINT `returns_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `returns_order_item_id_foreign` FOREIGN KEY (`order_item_id`) REFERENCES `order_items` (`id`) ON DELETE CASCADE,
  CONSTRAINT `returns_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table renesca_aquatic_database.returns: ~0 rows (approximately)
DELETE FROM `returns`;

-- Dumping structure for table renesca_aquatic_database.reviews
CREATE TABLE IF NOT EXISTS `reviews` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `rating` tinyint NOT NULL DEFAULT '0',
  `comment` text COLLATE utf8mb4_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reviews_user_id_foreign` (`user_id`),
  KEY `reviews_product_id_foreign` (`product_id`),
  CONSTRAINT `reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table renesca_aquatic_database.reviews: ~0 rows (approximately)
DELETE FROM `reviews`;

-- Dumping structure for table renesca_aquatic_database.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table renesca_aquatic_database.sessions: ~1 rows (approximately)
DELETE FROM `sessions`;
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('a37DPUstgQZAZRG4UdvcV9HJ6jsbSTorkQlPk1aK', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiRVY3bkhLdXpwb20zVzhQc2ZTdXJmUWdYNURtNDRXaEVZYm5zdU11ZyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9yZXBvcnRzIjtzOjU6InJvdXRlIjtzOjEzOiJhZG1pbi5yZXBvcnRzIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjIxOiJwYXNzd29yZF9oYXNoX3NhbmN0dW0iO3M6NjA6IiQyeSQxMiRVNFZxT1Jqa0hzaUdOcUhWdnpXTGtPQnpFM2xXUlRqZ3l3NDNnTWl1VzVVMlBwSzJZam53ZSI7fQ==', 1766003250);

-- Dumping structure for table renesca_aquatic_database.shipping_methods
CREATE TABLE IF NOT EXISTS `shipping_methods` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cost` decimal(12,2) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table renesca_aquatic_database.shipping_methods: ~1 rows (approximately)
DELETE FROM `shipping_methods`;
INSERT INTO `shipping_methods` (`id`, `name`, `cost`, `deleted_at`, `created_at`, `updated_at`) VALUES
	(1, 'JNE', 12000.00, NULL, '2025-12-17 10:43:53', '2025-12-17 10:43:53');

-- Dumping structure for table renesca_aquatic_database.trash
CREATE TABLE IF NOT EXISTS `trash` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table renesca_aquatic_database.trash: ~0 rows (approximately)
DELETE FROM `trash`;

-- Dumping structure for table renesca_aquatic_database.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'customer',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kota` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kecamatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kelurahan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_telepon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `current_team_id` bigint unsigned DEFAULT NULL,
  `profile_photo_path` varchar(2048) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table renesca_aquatic_database.users: ~3 rows (approximately)
DELETE FROM `users`;
INSERT INTO `users` (`id`, `name`, `email`, `role`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `jenis_kelamin`, `alamat`, `kota`, `kecamatan`, `kelurahan`, `no_telepon`, `remember_token`, `current_team_id`, `profile_photo_path`, `created_at`, `updated_at`) VALUES
	(1, 'Admin', 'admin@example.com', 'admin', '2025-12-17 06:06:01', '$2y$12$U4VqORjkHsiGNqHVvzWLkOBzE3lWRTjgyw43gMiuW5U2PpK2Yjnwe', NULL, NULL, NULL, 'Laki-laki', 'jalan gunung rahayu 3 no f3', 'bandung', 'cimahi utara', 'pasirkaliki', '789456123', 'xddQJDrKnOHWMwiPWgRzS2KZIt0UC7vTkGDndFUMfnojB1ElD6tZZIimWaIH', NULL, 'profile-photos/uAW1XslwXD6yHJlzr6jWCGsuChpQrchVHjV7SsC5.jpg', '2025-12-17 06:06:01', '2025-12-17 11:10:36'),
	(2, 'Test User', 'user@example.com', 'user', '2025-12-17 06:06:01', '$2y$12$QMYq1UEb7oJt6qi0VbDAx.5qZWyX/A2XwIx1Cfv7C6ClfgX5C4QtG', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'lFpvweP7fA', NULL, NULL, '2025-12-17 06:06:01', '2025-12-17 06:06:01'),
	(3, 'Ruben', 'rubenkoswara655@gmail.com', 'customer', NULL, '$2y$12$TCAhPqrJedjmAO5DG.mlR.pr2R2GJGRq5T9cxoKI0LV4/lHVm0VEO', NULL, NULL, NULL, 'Laki-laki', 'jalan gunung rahayu 3 no f3', 'cimahi', 'cimahi utara', 'pasirkaliki', '123456789', NULL, NULL, 'profile-photos/1G1kUMKLeRNpf8LBXpnelLzyjhmLietngOW0rPjY.jpg', '2025-12-17 08:33:07', '2025-12-17 09:18:41');

-- Dumping structure for table renesca_aquatic_database.vendors
CREATE TABLE IF NOT EXISTS `vendors` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table renesca_aquatic_database.vendors: ~2 rows (approximately)
DELETE FROM `vendors`;
INSERT INTO `vendors` (`id`, `name`, `address`, `phone`, `deleted_at`, `created_at`, `updated_at`) VALUES
	(1, 'BGM', 'Jalan pik 2', '123456789', NULL, '2025-12-17 06:14:35', '2025-12-17 06:14:35'),
	(2, 'CBDK aquatic', 'jln bandung 123', '123456789', NULL, '2025-12-17 06:15:01', '2025-12-17 06:15:01');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
