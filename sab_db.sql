-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.4.3 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.10.0.7000
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table sab_db.categories
CREATE TABLE IF NOT EXISTS `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('สินค้า','บริการ') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_code_unique` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sab_db.categories: ~0 rows (approximately)

-- Dumping structure for table sab_db.customers
CREATE TABLE IF NOT EXISTS `customers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_person` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tax_id` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_account` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ใช้งาน',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sab_db.customers: ~0 rows (approximately)

-- Dumping structure for table sab_db.failed_jobs
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

-- Dumping data for table sab_db.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table sab_db.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sab_db.migrations: ~17 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_resets_table', 1),
	(3, '2019_08_19_000000_create_failed_jobs_table', 1),
	(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(5, '2025_10_20_123239_add_status_and_role_name_to_users_table', 1),
	(6, '2025_10_20_133052_create_categories_table', 1),
	(7, '2025_10_20_135150_create_products_table', 1),
	(8, '2025_10_20_142657_add_category_id_to_products_table', 1),
	(9, '2025_10_20_155615_create_customers_table', 1),
	(10, '2025_10_20_164809_create_payment_vouchers_table', 1),
	(15, '2025_10_20_175450_create_receipts_table', 2),
	(16, '2025_10_21_025840_create_tax_invoices_table', 2),
	(17, '2025_10_21_031343_create_purchase_orders_table', 2),
	(18, '2025_10_21_033001_create_quotations_table', 2),
	(19, '2025_10_21_042045_create_receive_vouchers_table', 3),
	(20, '2025_10_21_043307_create_withholding_taxes_table', 4),
	(21, '2025_10_21_043319_create_withholding_tax_items_table', 4);

-- Dumping structure for table sab_db.password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sab_db.password_resets: ~0 rows (approximately)

-- Dumping structure for table sab_db.payment_vouchers
CREATE TABLE IF NOT EXISTS `payment_vouchers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `payee` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `amount` decimal(15,2) NOT NULL,
  `status` enum('รอจ่าย','รออนุมัติ','จ่ายแล้ว','ยกเลิก') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'รออนุมัติ',
  `payment_method` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `withholding_tax_no` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `withholding_tax_amount` decimal(15,2) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sab_db.payment_vouchers: ~1 rows (approximately)
INSERT INTO `payment_vouchers` (`id`, `date`, `payee`, `description`, `amount`, `status`, `payment_method`, `withholding_tax_no`, `withholding_tax_amount`, `payment_date`, `created_at`, `updated_at`) VALUES
	(1, '2025-10-21', 'กกกก', 'กกกกกกกกกกกกกกก', 5000.00, 'รออนุมัติ', 'โอนเงิน', NULL, NULL, '2025-10-21', '2025-10-20 21:51:09', '2025-10-20 21:51:09');

-- Dumping structure for table sab_db.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sab_db.personal_access_tokens: ~0 rows (approximately)

-- Dumping structure for table sab_db.products
CREATE TABLE IF NOT EXISTS `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` bigint unsigned DEFAULT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `stock` int NOT NULL DEFAULT '0',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ใช้งาน',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_code_unique` (`code`),
  KEY `products_category_id_foreign` (`category_id`),
  CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sab_db.products: ~0 rows (approximately)

-- Dumping structure for table sab_db.purchase_orders
CREATE TABLE IF NOT EXISTS `purchase_orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `po_number` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `supplier` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `amount` decimal(15,2) NOT NULL,
  `status` enum('ร่าง','รอจัดส่ง','จัดส่งแล้ว','ยกเลิก') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ร่าง',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `purchase_orders_po_number_unique` (`po_number`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sab_db.purchase_orders: ~1 rows (approximately)
INSERT INTO `purchase_orders` (`id`, `po_number`, `date`, `supplier`, `description`, `amount`, `status`, `created_at`, `updated_at`) VALUES
	(1, 'PO-202510-001', '2025-10-21', 'ปาม', NULL, 1200.00, 'จัดส่งแล้ว', '2025-10-20 21:50:00', '2025-10-20 23:22:43');

-- Dumping structure for table sab_db.quotations
CREATE TABLE IF NOT EXISTS `quotations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `quotation_number` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `customer` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `amount` decimal(15,2) NOT NULL,
  `status` enum('ร่าง','รออนุมัติ','อนุมัติแล้ว','ยกเลิก') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ร่าง',
  `valid_until` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `quotations_quotation_number_unique` (`quotation_number`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sab_db.quotations: ~1 rows (approximately)
INSERT INTO `quotations` (`id`, `quotation_number`, `date`, `customer`, `description`, `amount`, `status`, `valid_until`, `created_at`, `updated_at`) VALUES
	(1, 'QT-202510-001', '2025-10-21', 'ดดดด', NULL, 6000.00, 'อนุมัติแล้ว', NULL, '2025-10-20 21:50:18', '2025-10-20 23:22:33');

-- Dumping structure for table sab_db.receipts
CREATE TABLE IF NOT EXISTS `receipts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `receipt_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `customer` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `invoice_ref` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` enum('ร่าง','รอออก','ออกแล้ว','ยกเลิก') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ร่าง',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `receipts_receipt_no_unique` (`receipt_no`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sab_db.receipts: ~1 rows (approximately)
INSERT INTO `receipts` (`id`, `receipt_no`, `date`, `customer`, `invoice_ref`, `amount`, `description`, `status`, `created_at`, `updated_at`) VALUES
	(1, 'REC111222', '2025-10-21', 'บริษัท ABC จำกัด', NULL, 2461.00, '1. การชำระเงินภายในเวลาที่กำหนด 7 วัน ตั้งแต่วันที่ได้รับสินค้า\n2. การส่งมอบสินค้าต้องเป็นไปตามเงื่อนไขที่ระบุไว้ในใบสั่งซื้อนี้เท่านั้น คลาง POSTER ONLY การขนส่ง\n3. ค่าบริการจัดส่งคิดตามระยะทางจริงรวมภาษีมูลค่าเพิ่ม', 'ร่าง', '2025-10-20 23:12:06', '2025-10-20 23:12:06');

-- Dumping structure for table sab_db.receive_vouchers
CREATE TABLE IF NOT EXISTS `receive_vouchers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `voucher_no` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `payer` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `amount` decimal(15,2) NOT NULL,
  `status` enum('รอรับ','รออนุมัติ','รับแล้ว','ยกเลิก') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'รอรับ',
  `receive_method` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `withholding_tax_no` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `withholding_tax_amount` decimal(15,2) DEFAULT NULL,
  `receive_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `receive_vouchers_voucher_no_unique` (`voucher_no`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sab_db.receive_vouchers: ~1 rows (approximately)
INSERT INTO `receive_vouchers` (`id`, `voucher_no`, `date`, `payer`, `description`, `amount`, `status`, `receive_method`, `withholding_tax_no`, `withholding_tax_amount`, `receive_date`, `created_at`, `updated_at`) VALUES
	(1, 'RV-202510-001', '2025-10-21', 'palmy', 'ทดสอบ', 2500.00, 'รับแล้ว', 'โอนเงิน', NULL, NULL, '2025-10-21', '2025-10-20 21:28:11', '2025-10-20 23:28:33');

-- Dumping structure for table sab_db.tax_invoices
CREATE TABLE IF NOT EXISTS `tax_invoices` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `doc_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `document_type` enum('invoice','receipt') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'invoice',
  `doc_date` date NOT NULL,
  `customer_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_address` text COLLATE utf8mb4_unicode_ci,
  `customer_tax_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `selected_document` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_address` text COLLATE utf8mb4_unicode_ci,
  `shipping_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `items` json NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `discount` decimal(5,2) NOT NULL DEFAULT '0.00',
  `vat_rate` decimal(5,2) NOT NULL DEFAULT '7.00',
  `subtotal` decimal(15,2) NOT NULL,
  `discount_amount` decimal(15,2) NOT NULL,
  `after_discount` decimal(15,2) NOT NULL,
  `vat` decimal(15,2) NOT NULL,
  `grand_total` decimal(15,2) NOT NULL,
  `status` enum('draft','approved','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tax_invoices_doc_number_unique` (`doc_number`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sab_db.tax_invoices: ~4 rows (approximately)
INSERT INTO `tax_invoices` (`id`, `doc_number`, `document_type`, `doc_date`, `customer_code`, `customer_name`, `customer_address`, `customer_tax_id`, `selected_document`, `shipping_address`, `shipping_phone`, `items`, `notes`, `discount`, `vat_rate`, `subtotal`, `discount_amount`, `after_discount`, `vat`, `grand_total`, `status`, `created_at`, `updated_at`) VALUES
	(1, 'REC934867', 'receipt', '2025-10-21', 'CUST-001', 'บริษัท ABC จำกัด', '123 ถนนสุขุมวิท กรุงเทพฯ 10110', '0105558123456', '2', '123 ถนนสุขุมวิท กรุงเทพฯ 10110', '02-123-4567', '[{"id": "1761019946083", "amount": 3600, "description": "ทดสอบๆๆๆ"}]', '1. การชำระเงินภายในเวลาที่กำหนด 7 วัน ตั้งแต่วันที่ได้รับสินค้า\n2. การส่งมอบสินค้าต้องเป็นไปตามเงื่อนไขที่ระบุไว้ในใบสั่งซื้อนี้เท่านั้น คลาง POSTER ONLY การขนส่ง\n3. ค่าบริการจัดส่งคิดตามระยะทางจริงรวมภาษีมูลค่าเพิ่ม', 10.00, 7.00, 3600.00, 360.00, 3240.00, 226.80, 3466.80, 'draft', '2025-10-20 21:12:40', '2025-10-20 21:12:40'),
	(2, 'REC617590', 'receipt', '2025-10-21', 'BOTH-001', 'ร้าน DEF การค้า', '789 ถนนรัชดาภิเษก กรุงเทพฯ 10400', NULL, '1', '789 ถนนรัชดาภิเษก กรุงเทพฯ 10400', '089-123-4567', '[{"id": "1761026626637", "amount": 23000, "description": "ดดดด"}]', '1. การชำระเงินภายในเวลาที่กำหนด 7 วัน ตั้งแต่วันที่ได้รับสินค้า\n2. การส่งมอบสินค้าต้องเป็นไปตามเงื่อนไขที่ระบุไว้ในใบสั่งซื้อนี้เท่านั้น คลาง POSTER ONLY การขนส่ง\n3. ค่าบริการจัดส่งคิดตามระยะทางจริงรวมภาษีมูลค่าเพิ่ม', 10.00, 7.00, 23000.00, 2300.00, 20700.00, 1449.00, 22149.00, 'draft', '2025-10-20 23:03:57', '2025-10-20 23:03:57'),
	(3, 'REC666927', 'receipt', '2025-10-21', 'CUST-003', 'บริษัท สมาร์ท โซลูชั่น จำกัด', '222 ถนนพระราม 9 กรุงเทพฯ 10310', NULL, '3', '222 ถนนพระราม 9 กรุงเทพฯ 10310', '081-234-5678', '[{"id": "1761026674318", "amount": 15400, "description": "ออออ"}]', '1. การชำระเงินภายในเวลาที่กำหนด 7 วัน ตั้งแต่วันที่ได้รับสินค้า\n2. การส่งมอบสินค้าต้องเป็นไปตามเงื่อนไขที่ระบุไว้ในใบสั่งซื้อนี้เท่านั้น คลาง POSTER ONLY การขนส่ง\n3. ค่าบริการจัดส่งคิดตามระยะทางจริงรวมภาษีมูลค่าเพิ่ม', 0.00, 7.00, 15400.00, 0.00, 15400.00, 1078.00, 16478.00, 'draft', '2025-10-20 23:04:41', '2025-10-20 23:04:41'),
	(4, 'REC111222', 'receipt', '2025-10-21', 'CUST-001', 'บริษัท ABC จำกัด', '123 ถนนสุขุมวิท กรุงเทพฯ 10110', '0105558123456', '2', '123 ถนนสุขุมวิท กรุงเทพฯ 10110', '02-123-4567', '[{"id": "1761027117117", "amount": 2300, "description": "ดดดดดดดดดปผหห"}]', '1. การชำระเงินภายในเวลาที่กำหนด 7 วัน ตั้งแต่วันที่ได้รับสินค้า\n2. การส่งมอบสินค้าต้องเป็นไปตามเงื่อนไขที่ระบุไว้ในใบสั่งซื้อนี้เท่านั้น คลาง POSTER ONLY การขนส่ง\n3. ค่าบริการจัดส่งคิดตามระยะทางจริงรวมภาษีมูลค่าเพิ่ม', 0.00, 7.00, 2300.00, 0.00, 2300.00, 161.00, 2461.00, 'draft', '2025-10-20 23:12:04', '2025-10-20 23:12:04');

-- Dumping structure for table sab_db.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fullname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','account','user') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `role_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ผู้ใช้งาน',
  `status` enum('active','suspended') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sab_db.users: ~0 rows (approximately)
INSERT INTO `users` (`id`, `username`, `fullname`, `email`, `password`, `role`, `role_name`, `status`, `created_at`, `updated_at`) VALUES
	(1, 'testuser', 'Test User', 'test@example.com', '$2y$10$Wt5bljbPIiMMu4v69lElt.vghniYiy36mf37U2NnptRmqMXjPBHm.', 'user', 'ผู้ใช้งาน', 'active', '2025-10-20 19:30:30', '2025-10-20 19:30:30'),
	(2, 'testuser2', 'Test User 2', 'test2@example.com', '$2y$10$X0ZxStRiRREGQEnAII4tYeyaU4t0CXgYVMxt1ol1vqyfyC.O4cD1u', 'user', 'ผู้ใช้งาน', 'active', '2025-10-20 19:42:59', '2025-10-20 19:42:59'),
	(3, 'admin', 'ผู้ดูแลระบบ', 'admin@example.com', '$2y$10$OwdThBziAl/eAAGurZTnJe7Bou1yN5ejJZRr1aTBR5DnJaP3b938G', 'admin', 'ผู้ดูแลระบบ', 'active', '2025-10-20 19:48:31', '2025-10-20 19:48:31'),
	(4, 'account', 'พนักงานบัญชี', 'account@example.com', '$2y$10$BrBJTqWP1zp.V8g2J99RduDxBwyL0Ei2ETeoN7mxcfo5OvC4nmOdq', 'account', 'พนักงานบัญชี', 'active', '2025-10-20 19:48:31', '2025-10-20 19:48:31'),
	(5, 'user1', 'สมชาย ใจดี', 'somchai@example.com', '$2y$10$sYZwcQhzsg73gE099P82m.mQssd9VXMMkrj.wDX9vfsyMnlWUUrv2', 'user', 'ผู้ใช้งาน', 'active', '2025-10-20 19:48:31', '2025-10-20 19:48:31'),
	(6, 'user2', 'สมหญิง รักสนุก', 'somying@example.com', '$2y$10$2cjXYkxj677iKCHr6DERJuch/mgrxfTQPZlgZpgf64XVHeJdhEkbm', 'user', 'ผู้ใช้งาน', 'active', '2025-10-20 19:48:31', '2025-10-20 19:48:31'),
	(7, 'user3', 'วิชัย ทำงาน', 'wichai@example.com', '$2y$10$yiw1/XjbRqIWVXAu/nHrg.xjg0pqPXcl71flT2GI9XPvjBSpCZH0O', 'user', 'ผู้ใช้งาน', 'active', '2025-10-20 19:48:31', '2025-10-20 19:48:31'),
	(8, 'testcurl', 'Test Curl', 'testcurl@example.com', '$2y$10$K6nlvJUo9gB8AuTDRn9FHe5WapHMn1YD/9cd8K8CuF/LvNVwBloaS', 'user', 'ผู้ใช้งาน', 'active', '2025-10-20 19:49:39', '2025-10-20 19:49:39'),
	(9, 'test', 'Test User', 'test@test.com', '$2y$10$zYhvbF6GNV7IaO31o.9ZnOU5qpad4csTb2wsONlR6V0R6YKj6em12', 'user', 'ผู้ใช้งาน', 'active', '2025-10-20 23:42:22', '2025-10-20 23:42:22'),
	(10, 'u1', 'palmy ppp', 'kupalmma@gmail.com', '$2y$10$wIcF4U/i16G2ekzq7LUgPu5Se7ESKAShgdt9P0uzXTXPFUSU/rgW6', 'user', 'ผู้ใช้งาน', 'active', '2025-10-20 23:44:41', '2025-10-20 23:44:41');

-- Dumping structure for table sab_db.withholding_taxes
CREATE TABLE IF NOT EXISTS `withholding_taxes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `doc_number` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `doc_date` date NOT NULL,
  `sequence_number` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payer_tax_id` varchar(13) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payer_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `recipient_tax_id` varchar(13) COLLATE utf8mb4_unicode_ci NOT NULL,
  `recipient_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `recipient_address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `recipient_type` enum('individual','juristic','partnership','other') COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_type` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_amount` decimal(15,2) NOT NULL,
  `total_tax` decimal(15,2) NOT NULL,
  `status` enum('ร่าง','รออนุมัติ','อนุมัติแล้ว','ยกเลิก') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ร่าง',
  `created_by` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `withholding_taxes_doc_number_unique` (`doc_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sab_db.withholding_taxes: ~0 rows (approximately)

-- Dumping structure for table sab_db.withholding_tax_items
CREATE TABLE IF NOT EXISTS `withholding_tax_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `withholding_tax_id` bigint unsigned NOT NULL,
  `type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `tax_rate` decimal(5,2) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `tax_amount` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `withholding_tax_items_withholding_tax_id_foreign` (`withholding_tax_id`),
  CONSTRAINT `withholding_tax_items_withholding_tax_id_foreign` FOREIGN KEY (`withholding_tax_id`) REFERENCES `withholding_taxes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sab_db.withholding_tax_items: ~0 rows (approximately)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
