-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 21, 2025 at 08:45 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sab_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` enum('สินค้า','บริการ') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `code`, `name`, `type`, `created_at`, `updated_at`) VALUES
(1, 'CAT-01', 'Server', 'สินค้า', '2025-11-20 23:40:48', '2025-11-20 23:40:48'),
(2, 'Cat-02', 'ตรวจสภาพ', 'บริการ', '2025-11-20 23:41:03', '2025-11-20 23:41:03');

-- --------------------------------------------------------

--
-- Table structure for table `company_settings`
--

CREATE TABLE `company_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `branch_name` varchar(255) DEFAULT NULL,
  `tax_id` varchar(13) NOT NULL,
  `address` text NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `logo` text DEFAULT NULL,
  `enable_email` tinyint(1) NOT NULL DEFAULT 1,
  `enable_sms` tinyint(1) NOT NULL DEFAULT 0,
  `auto_backup` tinyint(1) NOT NULL DEFAULT 1,
  `vat_rate` decimal(5,2) NOT NULL DEFAULT 7.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `company_settings`
--

INSERT INTO `company_settings` (`id`, `company_name`, `branch_name`, `tax_id`, `address`, `phone`, `email`, `logo`, `enable_email`, `enable_sms`, `auto_backup`, `vat_rate`, `created_at`, `updated_at`) VALUES
(1, 'บริษัท ไอ ที บี ที คอร์ปอเรชั่น จำกัด', 'สำนักงานใหญ่', '0135561023453', '170/372 หมู่ที่ 1 ตำบลบางคูวัต อำเภอเมืองปทุมธานี จังหวัดปทุมธานี 12000', '02-1014461', 'service@itbtthai.com', 'data:image/png;base64,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', 1, 0, 1, 7.00, '2025-10-31 02:13:18', '2025-11-20 23:38:28');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(50) NOT NULL,
  `account_name` varchar(191) DEFAULT NULL,
  `branch_name` varchar(191) DEFAULT NULL,
  `contact_person` varchar(100) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `note` varchar(500) DEFAULT NULL,
  `tax_id` varchar(50) DEFAULT NULL,
  `bank_name` varchar(100) DEFAULT NULL,
  `bank_account` varchar(50) DEFAULT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'ใช้งาน',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `code`, `name`, `type`, `account_name`, `branch_name`, `contact_person`, `phone`, `email`, `address`, `note`, `tax_id`, `bank_name`, `bank_account`, `status`, `created_at`, `updated_at`) VALUES
(1, 'CUS-0001', 'Test', 'ลูกค้า', 'tester', 'สำนักงานใหญ่', 'ทดสอบ', '0987654321', 'tester@gmail.com', '128/47 หมู่ 6 ถนนแจ้งวัฒนะ ต.คลองเกลือ อ.ปากเกร็ด จ.นนทบุรี 11120', 'test', '1234567890123', 'กสิกรไทย', '1234567890', 'active', '2025-10-31 02:29:12', '2025-10-31 02:29:12'),
(2, 'CUS-0002', 'Yok-enterprise', 'ลูกค้า', NULL, 'แก่งคอย', 'ยก', '082456987', 'yok@gmail.com', 'แก่งคอย สระบุรี 18110', NULL, '0123654781231', NULL, NULL, 'active', '2025-11-16 23:49:35', '2025-11-16 23:49:35');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_no` varchar(255) NOT NULL,
  `invoice_date` date NOT NULL,
  `customer_code` varchar(255) DEFAULT NULL,
  `customer_name` varchar(255) NOT NULL,
  `seller_name` varchar(255) DEFAULT NULL,
  `customer_address` text DEFAULT NULL,
  `customer_tax_id` varchar(255) DEFAULT NULL,
  `customer_phone` varchar(255) DEFAULT NULL,
  `customer_email` varchar(255) DEFAULT NULL,
  `reference_doc` varchar(255) DEFAULT NULL,
  `shipping_address` text DEFAULT NULL,
  `shipping_phone` varchar(255) DEFAULT NULL,
  `items` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`items`)),
  `notes` text DEFAULT NULL,
  `discount` decimal(5,2) NOT NULL DEFAULT 0.00,
  `vat_rate` decimal(5,2) NOT NULL DEFAULT 7.00,
  `subtotal` decimal(15,2) NOT NULL,
  `discount_amount` decimal(15,2) NOT NULL,
  `after_discount` decimal(15,2) NOT NULL,
  `vat` decimal(15,2) NOT NULL,
  `grand_total` decimal(15,2) NOT NULL,
  `status` enum('draft','pending','paid','cancelled') DEFAULT 'draft',
  `doc_type` enum('original','copy') NOT NULL DEFAULT 'original',
  `due_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `invoice_no`, `invoice_date`, `customer_code`, `customer_name`, `seller_name`, `customer_address`, `customer_tax_id`, `customer_phone`, `customer_email`, `reference_doc`, `shipping_address`, `shipping_phone`, `items`, `notes`, `discount`, `vat_rate`, `subtotal`, `discount_amount`, `after_discount`, `vat`, `grand_total`, `status`, `doc_type`, `due_date`, `created_at`, `updated_at`) VALUES
(10, 'INV20250001', '2025-11-19', 'CUS-0002', 'Yok-enterprise', NULL, 'แก่งคอย สระบุรี 18110', '0123654781231', '082456987', 'yok@gmail.com', '1', 'แก่งคอย สระบุรี 18110', '082456987', '[{\"id\":\"1763544284753\",\"description\":\"kokok\",\"amount\":6000}]', '1. การชำระเงินภายในเวลาที่กำหนด 7 วัน ตั้งแต่วันที่ได้รับสินค้า\n2. การส่งมอบสินค้าต้องเป็นไปตามเงื่อนไขที่ระบุไว้ในใบสั่งซื้อนี้เท่านั้น คลาง POSTER ONLY การขนส่ง\n3. ค่าบริการจัดส่งคิดตามระยะทางจริงรวมภาษีมูลค่าเพิ่ม', 0.00, 7.00, 6000.00, 0.00, 6000.00, 420.00, 6420.00, 'pending', 'original', NULL, '2025-11-19 02:25:39', '2025-11-20 23:19:48'),
(12, 'INV20250002', '2025-11-20', 'CUS-0001', 'Test', 'bmnz', '128/47 หมู่ 6 ถนนแจ้งวัฒนะ ต.คลองเกลือ อ.ปากเกร็ด จ.นนทบุรี 11120', '1234567890123', '0987654321', 'tester@gmail.com', '1', '128/47 หมู่ 6 ถนนแจ้งวัฒนะ ต.คลองเกลือ อ.ปากเกร็ด จ.นนทบุรี 11120', '0987654321', '[{\"id\":\"1763607290722\",\"description\":\"hona\",\"amount\":8000}]', '1. การชำระเงินภายในเวลาที่กำหนด 7 วัน ตั้งแต่วันที่ได้รับสินค้า\n2. การส่งมอบสินค้าต้องเป็นไปตามเงื่อนไขที่ระบุไว้ในใบสั่งซื้อนี้เท่านั้น คลาง POSTER ONLY การขนส่ง\n3. ค่าบริการจัดส่งคิดตามระยะทางจริงรวมภาษีมูลค่าเพิ่ม', 0.00, 7.00, 8000.00, 0.00, 8000.00, 560.00, 8560.00, 'pending', 'copy', NULL, '2025-11-19 19:55:02', '2025-11-20 23:42:23');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

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
(21, '2025_10_21_043319_create_withholding_tax_items_table', 4),
(22, '2025_10_22_030607_create_company_settings_table', 5),
(23, '2025_10_22_053714_create_projects_table', 5),
(24, '2025_10_27_011844_update_company_settings_table_remove_vat_number_add_logo', 5),
(25, '2025_10_27_074932_add_new_fields_to_products_table', 5),
(26, '2025_10_27_080333_remove_category_column_from_products_table', 5),
(27, '2025_10_28_033808_add_new_fields_to_receive_vouchers_table', 5),
(28, '2025_10_28_033900_add_new_fields_to_payment_vouchers_table', 5),
(29, '2025_10_28_041829_create_invoices_table', 5),
(30, '2025_10_28_042905_migrate_tax_invoices_to_invoices_table', 5),
(31, '2025_10_28_050100_add_invoice_fields_to_quotations_table', 5),
(32, '2025_10_28_052000_add_invoice_fields_to_purchase_orders_table', 5),
(33, '2025_10_28_061743_update_invoices_status_enum_to_pending', 5),
(34, '2025_11_06_045255_add_seller_fields_to_quotations_table', 6),
(35, '2025_11_06_000000_add_buyer_fields_to_purchase_orders_table', 7),
(37, '2025_11_07_084306_add_doc_type_to_all_document_tables', 8),
(39, '2025_11_12_094729_add_customer_details_to_receipts_table', 9),
(40, '2025_11_13_060739_add_payer_and_representative_fields_to_withholding_taxes_table', 10),
(41, '2025_11_13_061457_add_new_fields_to_withholding_taxes_table', 11),
(42, '2025_11_13_071053_add_deduction_format_to_withholding_taxes_table', 12),
(43, '2025_11_13_083434_add_deduction_order_to_withholding_taxes_table', 13),
(44, '2025_11_20_020036_add_seller_name_to_receipts_table', 14),
(45, '2025_11_20_021100_add_seller_name_to_invoices_table', 15);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_vouchers`
--

CREATE TABLE `payment_vouchers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `voucher_no` varchar(50) DEFAULT NULL,
  `date` date NOT NULL,
  `payee` varchar(255) NOT NULL,
  `payee_id` bigint(20) UNSIGNED DEFAULT NULL,
  `description` text DEFAULT NULL,
  `amount` decimal(15,2) NOT NULL,
  `status` enum('รอจ่าย','รออนุมัติ','จ่ายแล้ว','ยกเลิก') NOT NULL DEFAULT 'รออนุมัติ',
  `payment_method` varchar(100) DEFAULT NULL,
  `withholding_tax_no` varchar(50) DEFAULT NULL,
  `withholding_tax_amount` decimal(15,2) DEFAULT NULL,
  `tax_type` varchar(20) NOT NULL DEFAULT 'excluding',
  `salesperson` varchar(255) DEFAULT NULL,
  `items` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`items`)),
  `notes` text DEFAULT NULL,
  `discount` decimal(5,2) NOT NULL DEFAULT 0.00,
  `vat_rate` decimal(5,2) NOT NULL DEFAULT 7.00,
  `subtotal` decimal(15,2) NOT NULL DEFAULT 0.00,
  `discount_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `after_discount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `vat` decimal(15,2) NOT NULL DEFAULT 0.00,
  `grand_total` decimal(15,2) NOT NULL DEFAULT 0.00,
  `payment_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_vouchers`
--

INSERT INTO `payment_vouchers` (`id`, `voucher_no`, `date`, `payee`, `payee_id`, `description`, `amount`, `status`, `payment_method`, `withholding_tax_no`, `withholding_tax_amount`, `tax_type`, `salesperson`, `items`, `notes`, `discount`, `vat_rate`, `subtotal`, `discount_amount`, `after_discount`, `vat`, `grand_total`, `payment_date`, `created_at`, `updated_at`) VALUES
(3, 'PV20250001', '2025-11-17', 'Yok-enterprise', 2, NULL, 6838.00, 'จ่ายแล้ว', 'โอนเงิน', '1234567891011', 10.00, 'excluding', 'GGG', '\"[{\\\"id\\\":\\\"1763370787945\\\",\\\"description\\\":\\\"GASD\\\",\\\"amount\\\":8000}]\"', 'zxc', 20.00, 7.00, 8000.00, 1600.00, 6400.00, 448.00, 6838.00, '2025-11-17', '2025-11-17 02:13:43', '2025-11-20 23:36:48'),
(4, 'PV20250002', '2025-11-21', 'Test', 1, NULL, 106786.00, 'รอจ่าย', 'โอนเงิน', NULL, 0.00, 'excluding', NULL, '\"[{\\\"id\\\":\\\"1763706979185\\\",\\\"description\\\":\\\"Door\\\",\\\"amount\\\":99800}]\"', NULL, 0.00, 7.00, 99800.00, 0.00, 99800.00, 6986.00, 106786.00, '2025-11-21', '2025-11-20 23:36:28', '2025-11-20 23:36:28');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `purchase_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `sale_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `stock` int(11) NOT NULL DEFAULT 0,
  `status` varchar(255) NOT NULL DEFAULT 'ใช้งาน',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(50) NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `installments` int(11) NOT NULL,
  `guarantee` decimal(15,2) NOT NULL DEFAULT 0.00,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` enum('กำลังดำเนินงาน','จบโครงการแล้ว','ยกเลิก') NOT NULL DEFAULT 'กำลังดำเนินงาน',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_orders`
--

CREATE TABLE `purchase_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `po_number` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `supplier_code` varchar(255) DEFAULT NULL,
  `supplier_name` varchar(255) DEFAULT NULL,
  `supplier_address` text DEFAULT NULL,
  `supplier_tax_id` varchar(255) DEFAULT NULL,
  `supplier_phone` varchar(255) DEFAULT NULL,
  `supplier_email` varchar(255) DEFAULT NULL,
  `reference_doc` varchar(255) DEFAULT NULL,
  `shipping_address` text DEFAULT NULL,
  `shipping_phone` varchar(255) DEFAULT NULL,
  `items` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`items`)),
  `supplier` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `discount` decimal(5,2) NOT NULL DEFAULT 0.00,
  `vat_rate` decimal(5,2) NOT NULL DEFAULT 7.00,
  `subtotal` decimal(15,2) NOT NULL DEFAULT 0.00,
  `discount_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `after_discount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `vat` decimal(15,2) NOT NULL DEFAULT 0.00,
  `grand_total` decimal(15,2) NOT NULL DEFAULT 0.00,
  `notes` text DEFAULT NULL,
  `expected_delivery_date` date DEFAULT NULL,
  `buyer_name` varchar(255) DEFAULT NULL,
  `buyer_phone` varchar(255) DEFAULT NULL,
  `buyer_email` varchar(255) DEFAULT NULL,
  `amount` decimal(15,2) DEFAULT NULL,
  `status` enum('ร่าง','รอจัดส่ง','จัดส่งแล้ว','ยกเลิก') NOT NULL DEFAULT 'ร่าง',
  `doc_type` enum('original','copy') NOT NULL DEFAULT 'original',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_orders`
--

INSERT INTO `purchase_orders` (`id`, `po_number`, `date`, `supplier_code`, `supplier_name`, `supplier_address`, `supplier_tax_id`, `supplier_phone`, `supplier_email`, `reference_doc`, `shipping_address`, `shipping_phone`, `items`, `supplier`, `description`, `discount`, `vat_rate`, `subtotal`, `discount_amount`, `after_discount`, `vat`, `grand_total`, `notes`, `expected_delivery_date`, `buyer_name`, `buyer_phone`, `buyer_email`, `amount`, `status`, `doc_type`, `created_at`, `updated_at`) VALUES
(12, 'PO20250001', '2025-11-21', 'CUS-0002', 'Yok-enterprise', 'แก่งคอย สระบุรี 18110', '0123654781231', '082456987', 'yok@gmail.com', '2', 'แก่งคอย สระบุรี 18110', '082456987', '[{\"id\":\"1763705656778\",\"description\":\"Cartoon\",\"amount\":2000}]', NULL, NULL, 0.00, 7.00, 2000.00, 0.00, 2000.00, 140.00, 2140.00, '1. การชำระเงินภายในเวลาที่กำหนด 7 วัน ตั้งแต่วันที่ได้รับสินค้า\n2. การส่งมอบสินค้าต้องเป็นไปตามเงื่อนไขที่ระบุไว้ในใบสั่งซื้อนี้เท่านั้น คลาง POSTER ONLY การขนส่ง\n3. ค่าบริการจัดส่งคิดตามระยะทางจริงรวมภาษีมูลค่าเพิ่ม', NULL, 'YoungYok', NULL, NULL, NULL, 'รอจัดส่ง', 'original', '2025-11-20 23:14:35', '2025-11-20 23:21:01'),
(13, 'PO20250002-1', '2025-11-21', 'CUS-0002', 'Yok-enterprise', 'แก่งคอย สระบุรี 18110', '0123654781231', '082456987', 'yok@gmail.com', '2', 'แก่งคอย สระบุรี 18110', '082456987', '[{\"id\":\"1763705684941\",\"description\":\"Comic\",\"amount\":100}]', NULL, NULL, 0.00, 7.00, 100.00, 0.00, 100.00, 7.00, 107.00, '1. การชำระเงินภายในเวลาที่กำหนด 7 วัน ตั้งแต่วันที่ได้รับสินค้า\n2. การส่งมอบสินค้าต้องเป็นไปตามเงื่อนไขที่ระบุไว้ในใบสั่งซื้อนี้เท่านั้น คลาง POSTER ONLY การขนส่ง\n3. ค่าบริการจัดส่งคิดตามระยะทางจริงรวมภาษีมูลค่าเพิ่ม', NULL, 'toomtam', NULL, NULL, NULL, 'รอจัดส่ง', 'copy', '2025-11-20 23:15:05', '2025-11-20 23:20:59');

-- --------------------------------------------------------

--
-- Table structure for table `quotations`
--

CREATE TABLE `quotations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `quotation_number` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `seller_name` varchar(255) DEFAULT NULL,
  `seller_phone` varchar(255) DEFAULT NULL,
  `seller_email` varchar(255) DEFAULT NULL,
  `customer_code` varchar(255) DEFAULT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `customer_address` text DEFAULT NULL,
  `customer_tax_id` varchar(255) DEFAULT NULL,
  `customer_phone` varchar(255) DEFAULT NULL,
  `customer_email` varchar(255) DEFAULT NULL,
  `reference_doc` varchar(255) DEFAULT NULL,
  `shipping_address` text DEFAULT NULL,
  `shipping_phone` varchar(255) DEFAULT NULL,
  `items` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`items`)),
  `customer` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `discount` decimal(5,2) NOT NULL DEFAULT 0.00,
  `vat_rate` decimal(5,2) NOT NULL DEFAULT 7.00,
  `subtotal` decimal(15,2) NOT NULL DEFAULT 0.00,
  `discount_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `after_discount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `vat` decimal(15,2) NOT NULL DEFAULT 0.00,
  `grand_total` decimal(15,2) NOT NULL DEFAULT 0.00,
  `notes` text DEFAULT NULL,
  `amount` decimal(15,2) DEFAULT NULL,
  `status` enum('ร่าง','รออนุมัติ','อนุมัติแล้ว','ยกเลิก') NOT NULL DEFAULT 'ร่าง',
  `doc_type` enum('original','copy') NOT NULL DEFAULT 'original',
  `valid_until` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quotations`
--

INSERT INTO `quotations` (`id`, `quotation_number`, `date`, `seller_name`, `seller_phone`, `seller_email`, `customer_code`, `customer_name`, `customer_address`, `customer_tax_id`, `customer_phone`, `customer_email`, `reference_doc`, `shipping_address`, `shipping_phone`, `items`, `customer`, `description`, `discount`, `vat_rate`, `subtotal`, `discount_amount`, `after_discount`, `vat`, `grand_total`, `notes`, `amount`, `status`, `doc_type`, `valid_until`, `created_at`, `updated_at`) VALUES
(50, 'QT20250001', '2025-11-17', 'xv', NULL, NULL, 'CUS-0002', 'Yok-enterprise', 'แก่งคอย สระบุรี 18110', '0123654781231', '082456987', 'yok@gmail.com', '2', 'แก่งคอย สระบุรี 18110', '082456987', '[{\"id\":\"1763368019034\",\"description\":\"gggg\",\"amount\":50000}]', NULL, NULL, 0.00, 7.00, 50000.00, 0.00, 50000.00, 3500.00, 53500.00, '1. การชำระเงินภายในเวลาที่กำหนด 7 วัน ตั้งแต่วันที่ได้รับสินค้า\n2. การส่งมอบสินค้าต้องเป็นไปตามเงื่อนไขที่ระบุไว้ในใบสั่งซื้อนี้เท่านั้น คลาง POSTER ONLY การขนส่ง\n3. ค่าบริการจัดส่งคิดตามระยะทางจริงรวมภาษีมูลค่าเพิ่ม', NULL, 'อนุมัติแล้ว', 'copy', NULL, '2025-11-17 01:27:05', '2025-11-20 23:22:08'),
(51, 'QT20250002', '2025-11-18', 'homd', NULL, NULL, 'CUS-0001', 'Test', '128/47 หมู่ 6 ถนนแจ้งวัฒนะ ต.คลองเกลือ อ.ปากเกร็ด จ.นนทบุรี 11120', '1234567890123', '0987654321', 'tester@gmail.com', '3', '128/47 หมู่ 6 ถนนแจ้งวัฒนะ ต.คลองเกลือ อ.ปากเกร็ด จ.นนทบุรี 11120', '0987654321', '[{\"id\":\"1763434760067\",\"description\":\"zzcv\",\"amount\":5000}]', NULL, NULL, 20.00, 7.00, 5000.00, 1000.00, 4000.00, 280.00, 4280.00, '1. การชำระเงินภายในเวลาที่กำหนด 7 วัน ตั้งแต่วันที่ได้รับสินค้า\n2. การส่งมอบสินค้าต้องเป็นไปตามเงื่อนไขที่ระบุไว้ในใบสั่งซื้อนี้เท่านั้น คลาง POSTER ONLY การขนส่ง\n3. ค่าบริการจัดส่งคิดตามระยะทางจริงรวมภาษีมูลค่าเพิ่ม', NULL, 'รออนุมัติ', 'original', NULL, '2025-11-17 19:59:36', '2025-11-20 23:23:11');

-- --------------------------------------------------------

--
-- Table structure for table `receipts`
--

CREATE TABLE `receipts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `receipt_no` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `customer` varchar(255) NOT NULL,
  `seller_name` varchar(255) DEFAULT NULL,
  `customer_address` text DEFAULT NULL,
  `customer_tax_id` varchar(255) DEFAULT NULL,
  `customer_phone` varchar(255) DEFAULT NULL,
  `customer_email` varchar(255) DEFAULT NULL,
  `invoice_ref` varchar(255) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL,
  `status` enum('ร่าง','รอออก','ออกแล้ว','ยกเลิก') NOT NULL DEFAULT 'ร่าง',
  `doc_type` enum('original','copy') NOT NULL DEFAULT 'original',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `receipts`
--

INSERT INTO `receipts` (`id`, `receipt_no`, `date`, `customer`, `seller_name`, `customer_address`, `customer_tax_id`, `customer_phone`, `customer_email`, `invoice_ref`, `amount`, `description`, `status`, `doc_type`, `created_at`, `updated_at`) VALUES
(19, 'REC20250001', '2025-11-21', 'Test', NULL, '128/47 หมู่ 6 ถนนแจ้งวัฒนะ ต.คลองเกลือ อ.ปากเกร็ด จ.นนทบุรี 11120', '1234567890123', '0987654321', 'tester@gmail.com', '3', 214.00, '1. การชำระเงินภายในเวลาที่กำหนด 7 วัน ตั้งแต่วันที่ได้รับสินค้า\n2. การส่งมอบสินค้าต้องเป็นไปตามเงื่อนไขที่ระบุไว้ในใบสั่งซื้อนี้เท่านั้น คลาง POSTER ONLY การขนส่ง\n3. ค่าบริการจัดส่งคิดตามระยะทางจริงรวมภาษีมูลค่าเพิ่ม', 'รอออก', 'original', '2025-11-20 23:16:20', '2025-11-20 23:37:36'),
(20, 'REC20250002', '2025-11-21', 'Test', 'ฝน', '128/47 หมู่ 6 ถนนแจ้งวัฒนะ ต.คลองเกลือ อ.ปากเกร็ด จ.นนทบุรี 11120', '1234567890123', '0987654321', 'tester@gmail.com', '2', 535.00, '1. การชำระเงินภายในเวลาที่กำหนด 7 วัน ตั้งแต่วันที่ได้รับสินค้า\n2. การส่งมอบสินค้าต้องเป็นไปตามเงื่อนไขที่ระบุไว้ในใบสั่งซื้อนี้เท่านั้น คลาง POSTER ONLY การขนส่ง\n3. ค่าบริการจัดส่งคิดตามระยะทางจริงรวมภาษีมูลค่าเพิ่ม', 'ร่าง', 'copy', '2025-11-20 23:16:41', '2025-11-20 23:41:43');

-- --------------------------------------------------------

--
-- Table structure for table `receive_vouchers`
--

CREATE TABLE `receive_vouchers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `voucher_no` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `payer` varchar(255) NOT NULL,
  `payer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `description` text DEFAULT NULL,
  `amount` decimal(15,2) NOT NULL,
  `status` enum('รอรับ','รออนุมัติ','รับแล้ว','ยกเลิก') NOT NULL DEFAULT 'รอรับ',
  `receive_method` varchar(50) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `withholding_tax_no` varchar(50) DEFAULT NULL,
  `withholding_tax_amount` decimal(15,2) DEFAULT NULL,
  `tax_type` varchar(20) NOT NULL DEFAULT 'excluding',
  `salesperson` varchar(255) DEFAULT NULL,
  `items` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`items`)),
  `notes` text DEFAULT NULL,
  `discount` decimal(5,2) NOT NULL DEFAULT 0.00,
  `vat_rate` decimal(5,2) NOT NULL DEFAULT 7.00,
  `subtotal` decimal(15,2) NOT NULL DEFAULT 0.00,
  `discount_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `after_discount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `vat` decimal(15,2) NOT NULL DEFAULT 0.00,
  `grand_total` decimal(15,2) NOT NULL DEFAULT 0.00,
  `receive_date` date DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `receive_vouchers`
--

INSERT INTO `receive_vouchers` (`id`, `voucher_no`, `date`, `payer`, `payer_id`, `description`, `amount`, `status`, `receive_method`, `payment_method`, `withholding_tax_no`, `withholding_tax_amount`, `tax_type`, `salesperson`, `items`, `notes`, `discount`, `vat_rate`, `subtotal`, `discount_amount`, `after_discount`, `vat`, `grand_total`, `receive_date`, `payment_date`, `created_at`, `updated_at`) VALUES
(4, 'RV20250001', '2025-11-21', 'Yok-enterprise', 2, NULL, 42800.00, 'รับแล้ว', NULL, 'โอนเงิน', '1', 0.00, 'excluding', NULL, '\"[{\\\"id\\\":\\\"1763706657515\\\",\\\"description\\\":\\\"\\u0e02\\u0e19\\u0e21\\u0e1b\\u0e31\\u0e07\\\",\\\"amount\\\":40000}]\"', NULL, 0.00, 7.00, 40000.00, 0.00, 40000.00, 2800.00, 42800.00, NULL, '2025-11-21', '2025-11-20 23:31:15', '2025-11-20 23:35:29'),
(5, 'RV20250002', '2025-09-09', 'Test', 1, NULL, 53500.00, 'รับแล้ว', NULL, 'โอนเงิน', '1', 0.00, 'excluding', NULL, '\"[{\\\"id\\\":\\\"1763706865165\\\",\\\"description\\\":\\\"Gun\\\",\\\"amount\\\":50000}]\"', NULL, 0.00, 7.00, 50000.00, 0.00, 50000.00, 3500.00, 53500.00, NULL, '2025-11-21', '2025-11-20 23:34:53', '2025-11-20 23:35:58');

-- --------------------------------------------------------

--
-- Table structure for table `tax_invoices`
--

CREATE TABLE `tax_invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `doc_number` varchar(255) NOT NULL,
  `document_type` enum('invoice','receipt') NOT NULL DEFAULT 'invoice',
  `doc_date` date NOT NULL,
  `customer_code` varchar(255) DEFAULT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_address` text DEFAULT NULL,
  `customer_tax_id` varchar(255) DEFAULT NULL,
  `selected_document` varchar(255) DEFAULT NULL,
  `shipping_address` text DEFAULT NULL,
  `shipping_phone` varchar(255) DEFAULT NULL,
  `items` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`items`)),
  `notes` text DEFAULT NULL,
  `discount` decimal(5,2) NOT NULL DEFAULT 0.00,
  `vat_rate` decimal(5,2) NOT NULL DEFAULT 7.00,
  `subtotal` decimal(15,2) NOT NULL,
  `discount_amount` decimal(15,2) NOT NULL,
  `after_discount` decimal(15,2) NOT NULL,
  `vat` decimal(15,2) NOT NULL,
  `grand_total` decimal(15,2) NOT NULL,
  `status` enum('draft','approved','cancelled') NOT NULL DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tax_invoices`
--

INSERT INTO `tax_invoices` (`id`, `doc_number`, `document_type`, `doc_date`, `customer_code`, `customer_name`, `customer_address`, `customer_tax_id`, `selected_document`, `shipping_address`, `shipping_phone`, `items`, `notes`, `discount`, `vat_rate`, `subtotal`, `discount_amount`, `after_discount`, `vat`, `grand_total`, `status`, `created_at`, `updated_at`) VALUES
(1, 'REC934867', 'receipt', '2025-10-21', 'CUST-001', 'บริษัท ABC จำกัด', '123 ถนนสุขุมวิท กรุงเทพฯ 10110', '0105558123456', '2', '123 ถนนสุขุมวิท กรุงเทพฯ 10110', '02-123-4567', '[{\"id\": \"1761019946083\", \"amount\": 3600, \"description\": \"ทดสอบๆๆๆ\"}]', '1. การชำระเงินภายในเวลาที่กำหนด 7 วัน ตั้งแต่วันที่ได้รับสินค้า\n2. การส่งมอบสินค้าต้องเป็นไปตามเงื่อนไขที่ระบุไว้ในใบสั่งซื้อนี้เท่านั้น คลาง POSTER ONLY การขนส่ง\n3. ค่าบริการจัดส่งคิดตามระยะทางจริงรวมภาษีมูลค่าเพิ่ม', 10.00, 7.00, 3600.00, 360.00, 3240.00, 226.80, 3466.80, 'draft', '2025-10-20 21:12:40', '2025-10-20 21:12:40'),
(2, 'REC617590', 'receipt', '2025-10-21', 'BOTH-001', 'ร้าน DEF การค้า', '789 ถนนรัชดาภิเษก กรุงเทพฯ 10400', NULL, '1', '789 ถนนรัชดาภิเษก กรุงเทพฯ 10400', '089-123-4567', '[{\"id\": \"1761026626637\", \"amount\": 23000, \"description\": \"ดดดด\"}]', '1. การชำระเงินภายในเวลาที่กำหนด 7 วัน ตั้งแต่วันที่ได้รับสินค้า\n2. การส่งมอบสินค้าต้องเป็นไปตามเงื่อนไขที่ระบุไว้ในใบสั่งซื้อนี้เท่านั้น คลาง POSTER ONLY การขนส่ง\n3. ค่าบริการจัดส่งคิดตามระยะทางจริงรวมภาษีมูลค่าเพิ่ม', 10.00, 7.00, 23000.00, 2300.00, 20700.00, 1449.00, 22149.00, 'draft', '2025-10-20 23:03:57', '2025-10-20 23:03:57'),
(3, 'REC666927', 'receipt', '2025-10-21', 'CUST-003', 'บริษัท สมาร์ท โซลูชั่น จำกัด', '222 ถนนพระราม 9 กรุงเทพฯ 10310', NULL, '3', '222 ถนนพระราม 9 กรุงเทพฯ 10310', '081-234-5678', '[{\"id\": \"1761026674318\", \"amount\": 15400, \"description\": \"ออออ\"}]', '1. การชำระเงินภายในเวลาที่กำหนด 7 วัน ตั้งแต่วันที่ได้รับสินค้า\n2. การส่งมอบสินค้าต้องเป็นไปตามเงื่อนไขที่ระบุไว้ในใบสั่งซื้อนี้เท่านั้น คลาง POSTER ONLY การขนส่ง\n3. ค่าบริการจัดส่งคิดตามระยะทางจริงรวมภาษีมูลค่าเพิ่ม', 0.00, 7.00, 15400.00, 0.00, 15400.00, 1078.00, 16478.00, 'draft', '2025-10-20 23:04:41', '2025-10-20 23:04:41'),
(4, 'REC111222', 'receipt', '2025-10-21', 'CUST-001', 'บริษัท ABC จำกัด', '123 ถนนสุขุมวิท กรุงเทพฯ 10110', '0105558123456', '2', '123 ถนนสุขุมวิท กรุงเทพฯ 10110', '02-123-4567', '[{\"id\": \"1761027117117\", \"amount\": 2300, \"description\": \"ดดดดดดดดดปผหห\"}]', '1. การชำระเงินภายในเวลาที่กำหนด 7 วัน ตั้งแต่วันที่ได้รับสินค้า\n2. การส่งมอบสินค้าต้องเป็นไปตามเงื่อนไขที่ระบุไว้ในใบสั่งซื้อนี้เท่านั้น คลาง POSTER ONLY การขนส่ง\n3. ค่าบริการจัดส่งคิดตามระยะทางจริงรวมภาษีมูลค่าเพิ่ม', 0.00, 7.00, 2300.00, 0.00, 2300.00, 161.00, 2461.00, 'draft', '2025-10-20 23:12:04', '2025-10-20 23:12:04');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','account','user') NOT NULL DEFAULT 'user',
  `role_name` varchar(255) NOT NULL DEFAULT 'ผู้ใช้งาน',
  `status` enum('active','suspended') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

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
(10, 'u1', 'palmy ppp', 'kupalmma@gmail.com', '$2y$10$wIcF4U/i16G2ekzq7LUgPu5Se7ESKAShgdt9P0uzXTXPFUSU/rgW6', 'user', 'ผู้ใช้งาน', 'active', '2025-10-20 23:44:41', '2025-10-20 23:44:41'),
(11, 'tester', '1', 'tester@gmail.com', '$2y$10$ExiBpXMCDs0u9GgEPdBSO.8rUqMqfbK8cD6yqknoHlWFPyaIw5fyS', 'admin', 'ผู้ใช้งาน', 'active', '2025-10-30 21:16:31', '2025-10-30 21:16:31'),
(12, 'yok', 'dss', 'k.33@gmail.com', '$2y$10$j13Zp4bMujZqnwFUKSmHJuCXDkkquyMGzcFkyb9KcHl2aATK17cOm', 'admin', 'ผู้ใช้งาน', 'active', '2025-11-04 23:28:44', '2025-11-04 23:28:44'),
(13, 'dd', 'd', 'dss@gmail.com', '$2y$10$LGvClblXeacX6YDfeyv1R.PczpndgG2u2XxR6FQEEQqSzgGSBf5oS', 'user', 'ผู้ใช้งาน', 'active', '2025-11-07 02:37:34', '2025-11-07 02:37:34'),
(14, 'yok2', 'dddd', 'dd@gmail.com', '$2y$10$azw.uW.Evp8AeK97ESNKA.xHBlpR258ujmw7An0IT0BCjkUZLXehC', 'user', 'ผู้ใช้งาน', 'active', '2025-11-17 00:18:50', '2025-11-17 00:18:50');

-- --------------------------------------------------------

--
-- Table structure for table `withholding_taxes`
--

CREATE TABLE `withholding_taxes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `doc_number` varchar(50) NOT NULL,
  `doc_date` date NOT NULL,
  `sequence_number` varchar(50) NOT NULL,
  `payer_tax_id` varchar(13) NOT NULL,
  `payer_name` varchar(255) NOT NULL,
  `payer_address` text DEFAULT NULL,
  `representative_tax_id` varchar(13) DEFAULT NULL,
  `representative_name` varchar(255) DEFAULT NULL,
  `representative_address` text DEFAULT NULL,
  `deduction_mode` varchar(50) DEFAULT NULL,
  `deduction_other` varchar(255) DEFAULT NULL,
  `deduction_format` varchar(50) DEFAULT NULL,
  `deduction_order` varchar(50) DEFAULT NULL,
  `recipient_tax_id` varchar(13) NOT NULL,
  `recipient_name` varchar(255) NOT NULL,
  `recipient_address` text NOT NULL,
  `recipient_type` enum('individual','juristic','partnership','other') NOT NULL,
  `company_type` varchar(10) DEFAULT NULL,
  `total_amount` decimal(15,2) NOT NULL,
  `total_tax` decimal(15,2) NOT NULL,
  `status` enum('ร่าง','รออนุมัติ','อนุมัติแล้ว','ยกเลิก') NOT NULL DEFAULT 'ร่าง',
  `created_by` varchar(100) NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `withholding_tax_items`
--

CREATE TABLE `withholding_tax_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `withholding_tax_id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `date` date NOT NULL,
  `tax_rate` decimal(5,2) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `tax_amount` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_code_unique` (`code`);

--
-- Indexes for table `company_settings`
--
ALTER TABLE `company_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoices_invoice_no_unique` (`invoice_no`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payment_vouchers`
--
ALTER TABLE `payment_vouchers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_code_unique` (`code`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `projects_code_unique` (`code`),
  ADD KEY `projects_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `purchase_orders_po_number_unique` (`po_number`);

--
-- Indexes for table `quotations`
--
ALTER TABLE `quotations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `quotations_quotation_number_unique` (`quotation_number`);

--
-- Indexes for table `receipts`
--
ALTER TABLE `receipts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `receipts_receipt_no_unique` (`receipt_no`);

--
-- Indexes for table `receive_vouchers`
--
ALTER TABLE `receive_vouchers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `receive_vouchers_voucher_no_unique` (`voucher_no`);

--
-- Indexes for table `tax_invoices`
--
ALTER TABLE `tax_invoices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tax_invoices_doc_number_unique` (`doc_number`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `withholding_taxes`
--
ALTER TABLE `withholding_taxes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `withholding_taxes_doc_number_unique` (`doc_number`);

--
-- Indexes for table `withholding_tax_items`
--
ALTER TABLE `withholding_tax_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `withholding_tax_items_withholding_tax_id_foreign` (`withholding_tax_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `company_settings`
--
ALTER TABLE `company_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `payment_vouchers`
--
ALTER TABLE `payment_vouchers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `quotations`
--
ALTER TABLE `quotations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `receipts`
--
ALTER TABLE `receipts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `receive_vouchers`
--
ALTER TABLE `receive_vouchers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tax_invoices`
--
ALTER TABLE `tax_invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `withholding_taxes`
--
ALTER TABLE `withholding_taxes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `withholding_tax_items`
--
ALTER TABLE `withholding_tax_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `withholding_tax_items`
--
ALTER TABLE `withholding_tax_items`
  ADD CONSTRAINT `withholding_tax_items_withholding_tax_id_foreign` FOREIGN KEY (`withholding_tax_id`) REFERENCES `withholding_taxes` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
