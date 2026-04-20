/*
 Navicat Premium Data Transfer

 Source Server         : project_triastra
 Source Server Type    : MySQL
 Source Server Version : 100244
 Source Host           : 103.156.113.227:23306
 Source Schema         : tri_astra_persada

 Target Server Type    : MySQL
 Target Server Version : 100244
 File Encoding         : 65001

 Date: 24/10/2024 17:43:06
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for category_products
-- ----------------------------
DROP TABLE IF EXISTS `category_products`;
CREATE TABLE `category_products`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of category_products
-- ----------------------------
INSERT INTO `category_products` VALUES (1, 'Kamera', NULL, NULL, NULL);
INSERT INTO `category_products` VALUES (2, 'LAPTOP', '2024-10-23 12:19:15', '2024-10-23 12:19:15', NULL);

-- ----------------------------
-- Table structure for clients
-- ----------------------------
DROP TABLE IF EXISTS `clients`;
CREATE TABLE `clients`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama_client` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `alamat_client` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `branch_client` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `nomor_telfon1_client` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `nomor_telfon2_client` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `faximile_client` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `email_client` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of clients
-- ----------------------------
INSERT INTO `clients` VALUES (1, 'Tunas Mobilindo Parama ( BMW bekasi )', 'AXC Summarecon Bekasi Jalan Bulevar Timur Blok VA No. 9 - 10 Summarecon Bekasi, RT.003/RW.002, Marga Mulya, Kec. Bekasi Utara, Kota Bks, Jawa Barat 17142', 'Bekasi Showroom', '08123456789', '0628123456789', NULL, 'tyas.prastika@bmw-tunas.co.id', '2024-10-19 10:29:58', '2024-10-21 12:58:14', NULL);
INSERT INTO `clients` VALUES (2, 'Tunas Mobilindo Parama ( BMW Tomang )', 'Jl. Tomang Raya No.19, RT.1/RW.1, Tomang, Kec. Grogol petamburan, Kota Jakarta Barat, Daerah Khusus Ibukota Jakarta 11440', 'Tomang Showroom', '0215633152', '081293252493', NULL, 'hanif.amin@bmw-tunas.co.id', '2024-10-19 10:29:58', '2024-10-21 12:57:58', NULL);
INSERT INTO `clients` VALUES (3, 'Tunas Mobilindo Parama ( BMW Tomang )', 'Jl. Tomang Raya No.19, RT.1/RW.1, Tomang, Kec. Grogol petamburan, Kota Jakarta Barat, Daerah Khusus Ibukota Jakarta 11440', 'Tomang Workshop', '0215633152', '083873261695', NULL, 'bmw.adm.tomang@bmw-tunas.co.id', '2024-10-19 10:29:58', '2024-10-21 12:57:12', NULL);
INSERT INTO `clients` VALUES (4, 'Tunas Mobilindo Parama ( BMW Tebet )', 'Jl. Prof. DR. Soepomo No.174, Menteng Dalam, Kec. Tebet, Kota Jakarta Selatan, Daerah Khusus Ibukota Jakarta 12870', 'Tebet Showroom', '0218301805', '08995697010', NULL, 'bmw.adm.saharjo@bmw-tunas.co.id', '2024-10-19 10:29:58', '2024-10-21 12:56:59', NULL);
INSERT INTO `clients` VALUES (5, 'Tunas Mobilindo Parama ( BMW Tebet )', 'Jl. Prof. DR. Soepomo No.174, Menteng Dalam, Kec. Tebet, Kota Jakarta Selatan, Daerah Khusus Ibukota Jakarta 12870', 'Tebet Workshop', '0218301805', '089629677062', NULL, 'bmw.adm.saharjo@bmw-tunas.co.id', '2024-10-19 10:29:58', '2024-10-21 12:56:46', NULL);
INSERT INTO `clients` VALUES (6, 'Tunas Mobilindo Parama ( BMW Hayamwuruk )', 'Hayam Wuruk St No.51, RT.7/RW.7, Maphar, Taman Sari, West Jakarta City, Jakarta 11160', 'TUNAS BMW HAYAMWURUK (Showroom)', '(021) 6495550', '6281287211686', NULL, 'syindi.saputri@bmw-tunas.co.id', '2024-10-21 12:44:19', '2024-10-21 12:49:35', NULL);
INSERT INTO `clients` VALUES (7, 'Tunas Mobilindo Parama ( BMW HO )', 'Jl. Prof. DR. Soepomo No.174, Menteng Dalam, Kec. Tebet, Kota Jakarta Selatan, Daerah Khusus Ibukota Jakarta 12870', 'TUNAS BMW TEBET ( HO )', '(021) 8301805', '085890433242', NULL, 'sarah.cicilia@tunasgroup.com', '2024-10-23 12:18:35', '2024-10-23 12:18:35', NULL);

-- ----------------------------
-- Table structure for discounts
-- ----------------------------
DROP TABLE IF EXISTS `discounts`;
CREATE TABLE `discounts`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `code_discount` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_discount` enum('percentage','value') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value_discount` decimal(8, 2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `discounts_code_discount_unique`(`code_discount`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of discounts
-- ----------------------------

-- ----------------------------
-- Table structure for invoices
-- ----------------------------
DROP TABLE IF EXISTS `invoices`;
CREATE TABLE `invoices`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `client_id` bigint UNSIGNED NULL DEFAULT NULL,
  `alamat_id` bigint UNSIGNED NULL DEFAULT NULL,
  `cabang_id` bigint UNSIGNED NULL DEFAULT NULL,
  `product` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `price` bigint NOT NULL,
  `bukti_pembayaran` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `status_bayar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `tax` decimal(5, 2) NULL DEFAULT NULL,
  `start` date NULL DEFAULT NULL,
  `end` date NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `invoices_client_id_foreign`(`client_id`) USING BTREE,
  INDEX `invoices_alamat_id_foreign`(`alamat_id`) USING BTREE,
  INDEX `invoices_cabang_id_foreign`(`cabang_id`) USING BTREE,
  CONSTRAINT `invoices_alamat_id_foreign` FOREIGN KEY (`alamat_id`) REFERENCES `clients` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `invoices_cabang_id_foreign` FOREIGN KEY (`cabang_id`) REFERENCES `clients` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `invoices_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 24 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of invoices
-- ----------------------------
INSERT INTO `invoices` VALUES (10, 6, 6, 6, '[{\"id\":8,\"qty\":\"1\",\"price\":\"320000.00\"},{\"id\":12,\"qty\":\"1\",\"price\":\"150000.00\"},{\"id\":14,\"qty\":\"1\",\"price\":\"30000.00\"}]', 500000, 'CASH', 'Belum bayar', NULL, '2024-10-23', '2024-10-23', '2024-10-24 09:18:33', '2024-10-24 09:18:33', NULL);
INSERT INTO `invoices` VALUES (11, 4, 4, 4, '[{\"id\":15,\"qty\":\"1\",\"price\":\"385000.00\"}]', 385000, 'CASH', 'Sudah bayar', NULL, '2024-10-24', '2024-10-24', '2024-10-24 10:20:16', '2024-10-24 14:53:26', NULL);

-- ----------------------------
-- Table structure for karyawans
-- ----------------------------
DROP TABLE IF EXISTS `karyawans`;
CREATE TABLE `karyawans`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama_karyawan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_telp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_kelamin` enum('laki-laki','perempuan') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'laki-laki',
  `tanggal_lahir` date NOT NULL,
  `tempat_lahir` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `position_id` bigint UNSIGNED NOT NULL,
  `gaji` decimal(15, 2) NULL DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `karyawans_position_id_foreign`(`position_id`) USING BTREE,
  CONSTRAINT `karyawans_position_id_foreign` FOREIGN KEY (`position_id`) REFERENCES `positions` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of karyawans
-- ----------------------------

-- ----------------------------
-- Table structure for media
-- ----------------------------
DROP TABLE IF EXISTS `media`;
CREATE TABLE `media`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  `uuid` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `collection_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `disk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `conversions_disk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `size` bigint UNSIGNED NOT NULL,
  `manipulations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `custom_properties` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `generated_conversions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `responsive_images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `order_column` int UNSIGNED NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `media_uuid_unique`(`uuid`) USING BTREE,
  INDEX `media_model_type_model_id_index`(`model_type`, `model_id`) USING BTREE,
  INDEX `media_order_column_index`(`order_column`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of media
-- ----------------------------

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 20 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '2014_10_12_100000_create_password_resets_table', 1);
INSERT INTO `migrations` VALUES (2, '2019_12_14_000001_create_personal_access_tokens_table', 1);
INSERT INTO `migrations` VALUES (3, '2024_04_05_000001_create_media_table', 1);
INSERT INTO `migrations` VALUES (4, '2024_04_05_000002_create_permissions_table', 1);
INSERT INTO `migrations` VALUES (5, '2024_04_05_000003_create_roles_table', 1);
INSERT INTO `migrations` VALUES (6, '2024_04_05_000004_create_users_table', 1);
INSERT INTO `migrations` VALUES (7, '2024_04_05_000015_create_vendors_table', 1);
INSERT INTO `migrations` VALUES (8, '2024_04_05_000016_create_category_products_table', 1);
INSERT INTO `migrations` VALUES (9, '2024_04_05_000016_create_products_table', 1);
INSERT INTO `migrations` VALUES (10, '2024_04_05_000017_create_permission_role_pivot_table', 1);
INSERT INTO `migrations` VALUES (11, '2024_04_05_000018_create_role_user_pivot_table', 1);
INSERT INTO `migrations` VALUES (12, '2024_10_02_085601_create_positions_table', 1);
INSERT INTO `migrations` VALUES (13, '2024_10_02_085611_create_karyawans_table', 1);
INSERT INTO `migrations` VALUES (14, '2024_10_04_070100_create_clients_table', 1);
INSERT INTO `migrations` VALUES (15, '2024_10_04_112244_create_orders_table', 1);
INSERT INTO `migrations` VALUES (16, '2024_10_08_205332_create_discounts_table', 1);
INSERT INTO `migrations` VALUES (17, '2024_10_18_093009_create_monitorings_table', 1);
INSERT INTO `migrations` VALUES (18, '2024_10_23_121702_create_producteches_table', 2);
INSERT INTO `migrations` VALUES (19, '2024_10_23_121725_create_invoices_table', 2);

-- ----------------------------
-- Table structure for monitorings
-- ----------------------------
DROP TABLE IF EXISTS `monitorings`;
CREATE TABLE `monitorings`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` bigint UNSIGNED NULL DEFAULT NULL,
  `stock_awal` bigint NULL DEFAULT NULL,
  `stock_outstanding` bigint NULL DEFAULT NULL,
  `nama_client` bigint UNSIGNED NULL DEFAULT NULL,
  `branch_client` bigint UNSIGNED NULL DEFAULT NULL,
  `alamat_client` bigint UNSIGNED NULL DEFAULT NULL,
  `category_id` bigint UNSIGNED NULL DEFAULT NULL,
  `vendor_id` bigint UNSIGNED NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `monitorings_product_id_foreign`(`product_id`) USING BTREE,
  INDEX `monitorings_nama_client_foreign`(`nama_client`) USING BTREE,
  INDEX `monitorings_branch_client_foreign`(`branch_client`) USING BTREE,
  INDEX `monitorings_alamat_client_foreign`(`alamat_client`) USING BTREE,
  INDEX `monitorings_category_id_foreign`(`category_id`) USING BTREE,
  INDEX `monitorings_vendor_id_foreign`(`vendor_id`) USING BTREE,
  CONSTRAINT `monitorings_alamat_client_foreign` FOREIGN KEY (`alamat_client`) REFERENCES `clients` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `monitorings_branch_client_foreign` FOREIGN KEY (`branch_client`) REFERENCES `clients` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `monitorings_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `category_products` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `monitorings_nama_client_foreign` FOREIGN KEY (`nama_client`) REFERENCES `clients` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `monitorings_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `monitorings_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of monitorings
-- ----------------------------
INSERT INTO `monitorings` VALUES (1, 1, 100, 99, 1, 1, 1, 1, 1, '2024-10-19 10:33:07', '2024-10-19 10:33:07', NULL);
INSERT INTO `monitorings` VALUES (2, 3, 5, 5, 7, 7, 7, 2, 1, '2024-10-23 12:19:38', '2024-10-23 12:19:38', NULL);

-- ----------------------------
-- Table structure for orders
-- ----------------------------
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `client_id` bigint UNSIGNED NULL DEFAULT NULL,
  `alamat_id` bigint UNSIGNED NULL DEFAULT NULL,
  `cabang_id` bigint UNSIGNED NULL DEFAULT NULL,
  `product` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `price` bigint NOT NULL,
  `start` date NULL DEFAULT NULL,
  `end` date NULL DEFAULT NULL,
  `bukti_pembayaran` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `status_bayar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `tax` decimal(5, 2) NULL DEFAULT NULL,
  `status_sewa` enum('Sudah Selesai','Belum Selesai') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `orders_client_id_foreign`(`client_id`) USING BTREE,
  INDEX `orders_alamat_id_foreign`(`alamat_id`) USING BTREE,
  INDEX `orders_cabang_id_foreign`(`cabang_id`) USING BTREE,
  CONSTRAINT `orders_alamat_id_foreign` FOREIGN KEY (`alamat_id`) REFERENCES `clients` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `orders_cabang_id_foreign` FOREIGN KEY (`cabang_id`) REFERENCES `clients` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `orders_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 19 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of orders
-- ----------------------------
INSERT INTO `orders` VALUES (1, 1, 2, 2, '[]', 0, '2024-10-19', '2024-11-19', NULL, 'Belum bayar', NULL, 'Belum Selesai', '2024-10-19 10:32:22', '2024-10-19 10:32:25', '2024-10-19 10:32:25');
INSERT INTO `orders` VALUES (2, 1, 1, 1, '[{\"id\":1,\"qty\":\"1\",\"price\":\"1000000.00\"}]', 1000000, '2024-10-19', '2024-11-19', NULL, 'Belum bayar', NULL, 'Belum Selesai', '2024-10-19 10:33:23', '2024-10-21 12:05:59', '2024-10-21 12:05:59');
INSERT INTO `orders` VALUES (3, 2, 1, 1, '[{\"id\":1,\"qty\":\"1\",\"price\":\"900000.00\"}]', 900000, '2024-08-20', '2024-09-20', NULL, 'Belum bayar', NULL, 'Belum Selesai', '2024-10-21 12:07:24', '2024-10-21 12:59:52', '2024-10-21 12:59:52');
INSERT INTO `orders` VALUES (4, 5, 4, 4, '[{\"id\":1,\"qty\":\"1\",\"price\":\"900000.00\"}]', 900000, '2024-08-20', '2024-09-20', NULL, 'Belum bayar', NULL, 'Belum Selesai', '2024-10-21 12:11:59', '2024-10-21 12:59:55', '2024-10-21 12:59:55');
INSERT INTO `orders` VALUES (5, 4, 4, 4, '[{\"id\":1,\"qty\":\"1\",\"price\":\"900000.00\"}]', 900000, '2024-08-20', '2024-09-20', NULL, 'Belum bayar', NULL, 'Sudah Selesai', '2024-10-21 13:00:33', '2024-10-22 16:10:17', NULL);
INSERT INTO `orders` VALUES (6, 5, 5, 3, '[{\"id\":1,\"qty\":\"1\",\"price\":\"900000.00\"}]', 900000, '2024-08-20', '2024-09-20', NULL, 'Belum bayar', NULL, 'Sudah Selesai', '2024-10-21 13:02:31', '2024-10-22 16:56:25', NULL);
INSERT INTO `orders` VALUES (7, 4, 4, 4, '[{\"id\":1,\"qty\":\"1\",\"price\":\"900000.00\"}]', 900000, '2024-09-20', '2024-10-20', NULL, 'Belum bayar', NULL, 'Belum Selesai', '2024-10-21 13:04:47', '2024-10-21 13:04:47', NULL);
INSERT INTO `orders` VALUES (8, 5, 5, 5, '[{\"id\":1,\"qty\":\"1\",\"price\":\"900000.00\"}]', 900000, '2024-09-20', '2024-10-20', NULL, 'Belum bayar', NULL, 'Belum Selesai', '2024-10-22 16:12:09', '2024-10-22 16:12:09', NULL);
INSERT INTO `orders` VALUES (9, 5, 5, 5, '[{\"id\":1,\"qty\":\"1\",\"price\":\"900000.00\"}]', 900000, '2024-09-20', '2024-10-20', NULL, 'Belum bayar', NULL, 'Belum Selesai', '2024-10-22 16:14:21', '2024-10-22 16:16:48', '2024-10-22 16:16:48');
INSERT INTO `orders` VALUES (10, 2, 2, 2, '[{\"id\":1,\"qty\":\"1\",\"price\":\"900000.00\"}]', 900000, '2024-08-20', '2024-10-20', NULL, 'Belum bayar', NULL, 'Sudah Selesai', '2024-10-22 16:45:33', '2024-10-22 16:52:41', NULL);
INSERT INTO `orders` VALUES (11, 2, 2, 2, '[{\"id\":1,\"qty\":\"1\",\"price\":\"900000.00\"}]', 900000, '2024-09-20', '2024-10-20', NULL, 'Belum bayar', NULL, 'Belum Selesai', '2024-10-22 16:49:54', '2024-10-22 16:49:54', NULL);
INSERT INTO `orders` VALUES (12, 3, 3, 3, '[{\"id\":1,\"qty\":\"1\",\"price\":\"900000.00\"}]', 900000, '2024-08-20', '2024-09-20', NULL, 'Belum bayar', NULL, 'Belum Selesai', '2024-10-22 16:55:22', '2024-10-22 16:55:22', NULL);
INSERT INTO `orders` VALUES (13, 3, 3, 3, '[{\"id\":1,\"qty\":\"1\",\"price\":\"900000.00\"}]', 900000, '2024-09-20', '2024-10-20', NULL, 'Belum bayar', NULL, 'Sudah Selesai', '2024-10-22 16:55:41', '2024-10-22 17:41:45', NULL);
INSERT INTO `orders` VALUES (14, 1, 1, 1, '[{\"id\":1,\"qty\":\"1\",\"price\":\"900000.00\"}]', 900000, '2024-08-20', '2024-09-20', NULL, 'Belum bayar', NULL, 'Belum Selesai', '2024-10-23 08:21:15', '2024-10-23 08:21:15', NULL);
INSERT INTO `orders` VALUES (15, 1, 1, 1, '[{\"id\":1,\"qty\":\"1\",\"price\":\"900000.00\"}]', 900000, '2024-09-20', '2024-10-20', NULL, 'Belum bayar', NULL, 'Belum Selesai', '2024-10-23 08:21:52', '2024-10-23 08:21:52', NULL);
INSERT INTO `orders` VALUES (16, 6, 6, 6, '[{\"id\":1,\"qty\":\"1\",\"price\":\"900000.00\"}]', 900000, '2024-08-20', '2024-09-20', NULL, 'Belum bayar', NULL, 'Belum Selesai', '2024-10-23 08:22:25', '2024-10-23 08:22:25', NULL);
INSERT INTO `orders` VALUES (17, 6, 6, 6, '[{\"id\":1,\"qty\":\"1\",\"price\":\"900000.00\"}]', 900000, '2024-09-20', '2024-10-20', NULL, 'Belum bayar', NULL, 'Belum Selesai', '2024-10-23 08:22:52', '2024-10-23 08:22:52', NULL);
INSERT INTO `orders` VALUES (18, 7, 7, 7, '[{\"id\":3,\"qty\":\"5\",\"price\":\"650000.00\"}]', 3250000, '2024-09-20', '2024-10-20', NULL, 'Belum bayar', NULL, 'Belum Selesai', '2024-10-23 12:20:25', '2024-10-23 12:20:25', NULL);

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets`  (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  INDEX `password_resets_email_index`(`email`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of password_resets
-- ----------------------------
INSERT INTO `password_resets` VALUES ('arhanmali96@gmail.com', '$2y$10$ffLLGDNmFmp9nBGtPG3jsOV1sIDALnr8EItlldNzTt95Yx6v2j8cm', '2024-10-24 11:33:35');

-- ----------------------------
-- Table structure for permission_role
-- ----------------------------
DROP TABLE IF EXISTS `permission_role`;
CREATE TABLE `permission_role`  (
  `role_id` bigint UNSIGNED NOT NULL,
  `permission_id` bigint UNSIGNED NOT NULL,
  INDEX `role_id_fk_9665208`(`role_id`) USING BTREE,
  INDEX `permission_id_fk_9665208`(`permission_id`) USING BTREE,
  CONSTRAINT `permission_id_fk_9665208` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `role_id_fk_9665208` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of permission_role
-- ----------------------------
INSERT INTO `permission_role` VALUES (1, 1);
INSERT INTO `permission_role` VALUES (1, 2);
INSERT INTO `permission_role` VALUES (1, 3);
INSERT INTO `permission_role` VALUES (1, 4);
INSERT INTO `permission_role` VALUES (1, 5);
INSERT INTO `permission_role` VALUES (1, 6);
INSERT INTO `permission_role` VALUES (1, 7);
INSERT INTO `permission_role` VALUES (1, 8);
INSERT INTO `permission_role` VALUES (1, 9);
INSERT INTO `permission_role` VALUES (1, 10);
INSERT INTO `permission_role` VALUES (1, 11);
INSERT INTO `permission_role` VALUES (1, 12);
INSERT INTO `permission_role` VALUES (1, 13);
INSERT INTO `permission_role` VALUES (1, 14);
INSERT INTO `permission_role` VALUES (1, 15);
INSERT INTO `permission_role` VALUES (1, 16);
INSERT INTO `permission_role` VALUES (1, 17);
INSERT INTO `permission_role` VALUES (1, 18);
INSERT INTO `permission_role` VALUES (1, 19);
INSERT INTO `permission_role` VALUES (1, 20);
INSERT INTO `permission_role` VALUES (1, 21);
INSERT INTO `permission_role` VALUES (1, 22);
INSERT INTO `permission_role` VALUES (1, 23);
INSERT INTO `permission_role` VALUES (1, 24);
INSERT INTO `permission_role` VALUES (1, 25);
INSERT INTO `permission_role` VALUES (1, 26);
INSERT INTO `permission_role` VALUES (1, 27);
INSERT INTO `permission_role` VALUES (1, 28);
INSERT INTO `permission_role` VALUES (1, 29);
INSERT INTO `permission_role` VALUES (1, 30);
INSERT INTO `permission_role` VALUES (1, 31);
INSERT INTO `permission_role` VALUES (1, 32);
INSERT INTO `permission_role` VALUES (1, 33);
INSERT INTO `permission_role` VALUES (1, 34);
INSERT INTO `permission_role` VALUES (1, 35);
INSERT INTO `permission_role` VALUES (1, 36);
INSERT INTO `permission_role` VALUES (1, 37);
INSERT INTO `permission_role` VALUES (1, 38);
INSERT INTO `permission_role` VALUES (1, 39);
INSERT INTO `permission_role` VALUES (1, 40);
INSERT INTO `permission_role` VALUES (1, 41);
INSERT INTO `permission_role` VALUES (1, 42);
INSERT INTO `permission_role` VALUES (1, 43);
INSERT INTO `permission_role` VALUES (1, 44);
INSERT INTO `permission_role` VALUES (1, 45);
INSERT INTO `permission_role` VALUES (1, 46);
INSERT INTO `permission_role` VALUES (1, 47);
INSERT INTO `permission_role` VALUES (1, 48);
INSERT INTO `permission_role` VALUES (1, 49);
INSERT INTO `permission_role` VALUES (1, 50);
INSERT INTO `permission_role` VALUES (1, 51);
INSERT INTO `permission_role` VALUES (1, 52);
INSERT INTO `permission_role` VALUES (1, 53);
INSERT INTO `permission_role` VALUES (1, 54);
INSERT INTO `permission_role` VALUES (1, 55);
INSERT INTO `permission_role` VALUES (1, 56);
INSERT INTO `permission_role` VALUES (1, 57);
INSERT INTO `permission_role` VALUES (1, 58);
INSERT INTO `permission_role` VALUES (1, 59);
INSERT INTO `permission_role` VALUES (1, 60);
INSERT INTO `permission_role` VALUES (2, 17);
INSERT INTO `permission_role` VALUES (2, 18);
INSERT INTO `permission_role` VALUES (2, 19);
INSERT INTO `permission_role` VALUES (2, 20);
INSERT INTO `permission_role` VALUES (2, 21);
INSERT INTO `permission_role` VALUES (2, 22);
INSERT INTO `permission_role` VALUES (2, 23);
INSERT INTO `permission_role` VALUES (2, 24);
INSERT INTO `permission_role` VALUES (2, 27);
INSERT INTO `permission_role` VALUES (2, 29);
INSERT INTO `permission_role` VALUES (2, 32);
INSERT INTO `permission_role` VALUES (2, 34);
INSERT INTO `permission_role` VALUES (2, 37);
INSERT INTO `permission_role` VALUES (2, 39);
INSERT INTO `permission_role` VALUES (2, 40);
INSERT INTO `permission_role` VALUES (2, 41);
INSERT INTO `permission_role` VALUES (2, 42);
INSERT INTO `permission_role` VALUES (2, 43);
INSERT INTO `permission_role` VALUES (2, 44);
INSERT INTO `permission_role` VALUES (2, 45);
INSERT INTO `permission_role` VALUES (3, 17);
INSERT INTO `permission_role` VALUES (3, 18);
INSERT INTO `permission_role` VALUES (3, 21);
INSERT INTO `permission_role` VALUES (3, 60);
INSERT INTO `permission_role` VALUES (3, 61);
INSERT INTO `permission_role` VALUES (3, 62);
INSERT INTO `permission_role` VALUES (3, 63);
INSERT INTO `permission_role` VALUES (3, 64);
INSERT INTO `permission_role` VALUES (3, 65);
INSERT INTO `permission_role` VALUES (3, 66);
INSERT INTO `permission_role` VALUES (3, 67);
INSERT INTO `permission_role` VALUES (3, 68);
INSERT INTO `permission_role` VALUES (3, 69);
INSERT INTO `permission_role` VALUES (3, 70);
INSERT INTO `permission_role` VALUES (3, 71);

-- ----------------------------
-- Table structure for permissions
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 72 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of permissions
-- ----------------------------
INSERT INTO `permissions` VALUES (1, 'user_management_access', NULL, NULL, NULL);
INSERT INTO `permissions` VALUES (2, 'permission_create', NULL, NULL, NULL);
INSERT INTO `permissions` VALUES (3, 'permission_edit', NULL, NULL, NULL);
INSERT INTO `permissions` VALUES (4, 'permission_show', NULL, NULL, NULL);
INSERT INTO `permissions` VALUES (5, 'permission_delete', NULL, NULL, NULL);
INSERT INTO `permissions` VALUES (6, 'permission_access', NULL, NULL, NULL);
INSERT INTO `permissions` VALUES (7, 'role_create', NULL, NULL, NULL);
INSERT INTO `permissions` VALUES (8, 'role_edit', NULL, NULL, NULL);
INSERT INTO `permissions` VALUES (9, 'role_show', NULL, NULL, NULL);
INSERT INTO `permissions` VALUES (10, 'role_delete', NULL, NULL, NULL);
INSERT INTO `permissions` VALUES (11, 'role_access', NULL, NULL, NULL);
INSERT INTO `permissions` VALUES (12, 'user_create', NULL, NULL, NULL);
INSERT INTO `permissions` VALUES (13, 'user_edit', NULL, NULL, NULL);
INSERT INTO `permissions` VALUES (14, 'user_show', NULL, NULL, NULL);
INSERT INTO `permissions` VALUES (15, 'user_delete', NULL, NULL, NULL);
INSERT INTO `permissions` VALUES (16, 'user_access', NULL, NULL, NULL);
INSERT INTO `permissions` VALUES (17, 'management_client_access', NULL, NULL, NULL);
INSERT INTO `permissions` VALUES (18, 'client_access', NULL, NULL, NULL);
INSERT INTO `permissions` VALUES (19, 'client_create', NULL, NULL, NULL);
INSERT INTO `permissions` VALUES (20, 'client_edit', NULL, NULL, NULL);
INSERT INTO `permissions` VALUES (21, 'client_show', NULL, NULL, NULL);
INSERT INTO `permissions` VALUES (22, 'client_delete', NULL, NULL, NULL);
INSERT INTO `permissions` VALUES (23, 'management_sdm_access', NULL, NULL, NULL);
INSERT INTO `permissions` VALUES (24, 'position_access', NULL, NULL, NULL);
INSERT INTO `permissions` VALUES (25, 'position_create', NULL, NULL, NULL);
INSERT INTO `permissions` VALUES (26, 'position_edit', NULL, NULL, NULL);
INSERT INTO `permissions` VALUES (27, 'position_show', NULL, NULL, NULL);
INSERT INTO `permissions` VALUES (28, 'position_delete', NULL, NULL, NULL);
INSERT INTO `permissions` VALUES (29, 'karyawan_access', NULL, NULL, NULL);
INSERT INTO `permissions` VALUES (30, 'karyawan_create', NULL, NULL, NULL);
INSERT INTO `permissions` VALUES (31, 'karyawan_edit', NULL, NULL, NULL);
INSERT INTO `permissions` VALUES (32, 'karyawan_show', NULL, NULL, NULL);
INSERT INTO `permissions` VALUES (33, 'karyawan_delete', NULL, NULL, NULL);
INSERT INTO `permissions` VALUES (34, 'productmanagement_access', NULL, NULL, NULL);
INSERT INTO `permissions` VALUES (35, 'vendor_create', NULL, NULL, NULL);
INSERT INTO `permissions` VALUES (36, 'vendor_edit', NULL, NULL, NULL);
INSERT INTO `permissions` VALUES (37, 'vendor_show', NULL, NULL, NULL);
INSERT INTO `permissions` VALUES (38, 'vendor_delete', NULL, NULL, NULL);
INSERT INTO `permissions` VALUES (39, 'vendor_access', NULL, NULL, NULL);
INSERT INTO `permissions` VALUES (40, 'categoryproduct_create', NULL, NULL, NULL);
INSERT INTO `permissions` VALUES (41, 'categoryproduct_edit', NULL, NULL, NULL);
INSERT INTO `permissions` VALUES (42, 'categoryproduct_show', NULL, NULL, NULL);
INSERT INTO `permissions` VALUES (43, 'categoryproduct_delete', NULL, NULL, NULL);
INSERT INTO `permissions` VALUES (44, 'categoryproduct_access', NULL, NULL, NULL);
INSERT INTO `permissions` VALUES (45, 'product_create', NULL, NULL, NULL);
INSERT INTO `permissions` VALUES (46, 'product_edit', NULL, NULL, NULL);
INSERT INTO `permissions` VALUES (47, 'product_show', NULL, NULL, NULL);
INSERT INTO `permissions` VALUES (48, 'product_delete', NULL, NULL, NULL);
INSERT INTO `permissions` VALUES (49, 'product_access', NULL, NULL, NULL);
INSERT INTO `permissions` VALUES (50, 'order_create', NULL, NULL, NULL);
INSERT INTO `permissions` VALUES (51, 'order_edit', NULL, NULL, NULL);
INSERT INTO `permissions` VALUES (52, 'order_show', NULL, NULL, NULL);
INSERT INTO `permissions` VALUES (53, 'order_delete', NULL, NULL, NULL);
INSERT INTO `permissions` VALUES (54, 'order_access', NULL, NULL, NULL);
INSERT INTO `permissions` VALUES (55, 'monitoring_create', NULL, NULL, NULL);
INSERT INTO `permissions` VALUES (56, 'monitoring_edit', NULL, NULL, NULL);
INSERT INTO `permissions` VALUES (57, 'monitoring_show', NULL, NULL, NULL);
INSERT INTO `permissions` VALUES (58, 'monitoring_delete', NULL, NULL, NULL);
INSERT INTO `permissions` VALUES (59, 'monitoring_access', NULL, NULL, NULL);
INSERT INTO `permissions` VALUES (60, 'profile_password_edit', NULL, NULL, NULL);
INSERT INTO `permissions` VALUES (61, 'sahabatechinvoice_access', '2024-10-23 12:48:07', '2024-10-23 12:48:07', NULL);
INSERT INTO `permissions` VALUES (62, 'sahabatechinvoice_create', '2024-10-23 12:48:15', '2024-10-23 12:48:15', NULL);
INSERT INTO `permissions` VALUES (63, 'sahabatechinvoice_edit', '2024-10-23 12:48:24', '2024-10-23 12:48:24', NULL);
INSERT INTO `permissions` VALUES (64, 'sahabatechinvoice_show', '2024-10-23 12:48:33', '2024-10-23 12:48:33', NULL);
INSERT INTO `permissions` VALUES (65, 'sahabatechinvoice_delete', '2024-10-23 12:48:48', '2024-10-23 12:48:48', NULL);
INSERT INTO `permissions` VALUES (66, 'sahabatechproduct_access', '2024-10-23 12:49:14', '2024-10-23 12:49:14', NULL);
INSERT INTO `permissions` VALUES (67, 'sahabatechproduct_create', '2024-10-23 12:49:32', '2024-10-23 12:49:32', NULL);
INSERT INTO `permissions` VALUES (68, 'sahabatechproduct_edit', '2024-10-23 12:49:44', '2024-10-23 12:49:44', NULL);
INSERT INTO `permissions` VALUES (69, 'sahabatechproduct_show', '2024-10-23 12:49:51', '2024-10-23 12:49:51', NULL);
INSERT INTO `permissions` VALUES (70, 'sahabatechproduct_delete', '2024-10-23 12:50:04', '2024-10-23 12:50:04', NULL);
INSERT INTO `permissions` VALUES (71, 'sahabatech_access', '2024-10-23 12:50:37', '2024-10-23 12:50:37', NULL);

-- ----------------------------
-- Table structure for personal_access_tokens
-- ----------------------------
DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `personal_access_tokens_token_unique`(`token`) USING BTREE,
  INDEX `personal_access_tokens_tokenable_type_tokenable_id_index`(`tokenable_type`, `tokenable_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of personal_access_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for positions
-- ----------------------------
DROP TABLE IF EXISTS `positions`;
CREATE TABLE `positions`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama_posisi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi_posisi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `tugas_posisi` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `gaji_pokok` bigint NULL DEFAULT NULL,
  `tunjangan_makan` bigint NULL DEFAULT NULL,
  `tunjangan_transport` bigint NULL DEFAULT NULL,
  `tunjangan_kesehatan` bigint NULL DEFAULT NULL,
  `tunjangan_ketenagakerjaan` bigint NULL DEFAULT NULL,
  `total_gaji` bigint NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of positions
-- ----------------------------
INSERT INTO `positions` VALUES (1, 'Manager', 'Bertanggung jawab atas operasional tim', 'Mengawasi kegiatan tim, membuat laporan', 10000000, 1000000, 1000000, 500000, 1500000, 14000000, '2024-10-19 10:29:58', '2024-10-19 10:29:58', NULL);
INSERT INTO `positions` VALUES (2, 'IT Support', 'Membantu tim IT dalam troubleshooting', 'Menangani masalah IT dan memberikan dukungan teknis', 5000000, 500000, 500000, 250000, 750000, 7000000, '2024-10-19 10:29:58', '2024-10-19 10:29:58', NULL);
INSERT INTO `positions` VALUES (3, 'Staff Administrasi', 'Mengelola administrasi perusahaan', 'Melakukan pengarsipan, penjadwalan, dan korespondensi', 4000000, 400000, 400000, 200000, 600000, 5600000, '2024-10-19 10:29:58', '2024-10-19 10:29:58', NULL);
INSERT INTO `positions` VALUES (4, 'Marketing', 'Mengembangkan strategi pemasaran', 'Merancang dan menjalankan kampanye pemasaran', 6000000, 600000, 600000, 300000, 900000, 8400000, '2024-10-19 10:29:58', '2024-10-19 10:29:58', NULL);
INSERT INTO `positions` VALUES (5, 'HRD', 'Bertanggung jawab atas manajemen sumber daya manusia', 'Rekrutmen, pelatihan, dan evaluasi karyawan', 8000000, 800000, 800000, 400000, 1200000, 11200000, '2024-10-19 10:29:58', '2024-10-19 10:29:58', NULL);

-- ----------------------------
-- Table structure for producteches
-- ----------------------------
DROP TABLE IF EXISTS `producteches`;
CREATE TABLE `producteches`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `harga_beli` decimal(15, 2) NULL DEFAULT NULL,
  `harga_jual` decimal(15, 2) NULL DEFAULT NULL,
  `stock_barang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `jangka_waktu` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 22 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of producteches
-- ----------------------------
INSERT INTO `producteches` VALUES (7, 'testing', 1500000.00, 200000.00, '5', NULL, '2024-10-23 21:43:00', '2024-10-24 17:28:57', NULL);
INSERT INTO `producteches` VALUES (8, 'Print head HP Deskjet 2336', 300000.00, 320000.00, '3', NULL, '2024-10-24 09:08:02', '2024-10-24 09:08:02', NULL);
INSERT INTO `producteches` VALUES (12, 'ASF Roller HP Deskjet 2336', 250000.00, 150000.00, '2', NULL, '2024-10-24 09:13:49', '2024-10-24 09:13:49', NULL);
INSERT INTO `producteches` VALUES (14, 'Refiil Inkjet HP 682 Black', 400000.00, 30000.00, '5', NULL, '2024-10-24 09:17:52', '2024-10-24 09:17:52', NULL);
INSERT INTO `producteches` VALUES (15, 'Vention Kabel HDMI 2.1 Male to Male Braided ALG Blue 5m 1unit', 300000.00, 385000.00, '4', NULL, '2024-10-24 09:21:29', '2024-10-24 09:21:40', NULL);
INSERT INTO `producteches` VALUES (16, 'keyboard Laptop Probook 4430 G8', 50000.00, 435000.00, '5', NULL, '2024-10-24 09:22:23', '2024-10-24 14:49:10', NULL);
INSERT INTO `producteches` VALUES (17, 'Samsung SSD NVME PM9A1 512GB - MZ-VL2512HCJQ / SSD 512GB', 1283000.00, 1492500.00, '3', NULL, '2024-10-24 14:50:50', '2024-10-24 14:50:50', NULL);
INSERT INTO `producteches` VALUES (18, 'WDC 2TB SATA3 64MB - Red Plus - WD20EFPX', 200000.00, 1674000.00, '2', NULL, '2024-10-24 14:52:56', '2024-10-24 14:52:56', NULL);
INSERT INTO `producteches` VALUES (19, 'PNY XLR8 DDR4 lap25600 3200MHz 16GB (1x16GB) Low Profile / RAM 16 GIGA', 1500000.00, 1674000.00, '3', NULL, '2024-10-24 14:55:45', '2024-10-24 14:55:45', NULL);
INSERT INTO `producteches` VALUES (20, 'RAM Patriot Signature Line Series SO-DIMM DDR5 PC44800 16GB - PSD516G560081S / RAM Laptop 16GB', 400000.00, 1098300.00, '2', NULL, '2024-10-24 14:58:00', '2024-10-24 14:58:00', NULL);
INSERT INTO `producteches` VALUES (21, 'Samsung SSD PM9C1 512 GB PCIe NVME M2 2280 - Super Hi Speed', 50000.00, 1592400.00, '3', NULL, '2024-10-24 15:03:47', '2024-10-24 15:03:47', NULL);

-- ----------------------------
-- Table structure for products
-- ----------------------------
DROP TABLE IF EXISTS `products`;
CREATE TABLE `products`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `harga_beli` decimal(15, 2) NULL DEFAULT NULL,
  `harga_sewa` decimal(15, 2) NULL DEFAULT NULL,
  `jangka_waktu` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of products
-- ----------------------------
INSERT INTO `products` VALUES (1, 'Kyocera ECOSYS M2040dn KX', 5600000.00, 900000.00, '1 bulan', '2024-10-19 10:29:58', '2024-10-21 12:05:51', NULL);
INSERT INTO `products` VALUES (2, NULL, NULL, NULL, '1 bulan', '2024-10-22 17:23:43', '2024-10-22 17:23:47', '2024-10-22 17:23:47');
INSERT INTO `products` VALUES (3, 'LAPTOP LENOVO L3 THINKPAD I3', 300000.00, 650000.00, '1 bulan', '2024-10-23 11:56:44', '2024-10-23 11:56:44', NULL);

-- ----------------------------
-- Table structure for role_user
-- ----------------------------
DROP TABLE IF EXISTS `role_user`;
CREATE TABLE `role_user`  (
  `user_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL,
  INDEX `user_id_fk_9665217`(`user_id`) USING BTREE,
  INDEX `role_id_fk_9665217`(`role_id`) USING BTREE,
  CONSTRAINT `role_id_fk_9665217` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `user_id_fk_9665217` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of role_user
-- ----------------------------
INSERT INTO `role_user` VALUES (1, 1);
INSERT INTO `role_user` VALUES (2, 2);
INSERT INTO `role_user` VALUES (3, 1);
INSERT INTO `role_user` VALUES (4, 3);

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES (1, 'super_admin', NULL, NULL, NULL);
INSERT INTO `roles` VALUES (2, 'admin', NULL, NULL, NULL);
INSERT INTO `roles` VALUES (3, 'admin_sahabatech', '2024-10-23 12:57:39', '2024-10-24 16:06:58', NULL);

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `google_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `email_verified_at` datetime NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_email_unique`(`email`) USING BTREE,
  UNIQUE INDEX `users_google_id_unique`(`google_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'Admin', 'admin@admin.com', NULL, NULL, '$2y$10$kGDhh3reigQ10NGx3bWulOhuBx34zm2jOvEWYRTLO3iTi4ZZVFYvq', NULL, '2024-10-19 10:29:58', '2024-10-19 10:29:58', NULL);
INSERT INTO `users` VALUES (2, 'arhan malik alrasyid', 'arhanmali96@gmail.com', NULL, NULL, '$2y$10$6e1LIoIU4puZwTQrui5v4e66iUynYbVGBLQmkTgUz2.clR2PjiLOS', NULL, '2024-10-19 10:29:58', '2024-10-19 10:29:58', NULL);
INSERT INTO `users` VALUES (3, 'moko', 'moko@gmail.com', NULL, NULL, '$2y$10$4/hoAC8DBrvIR3dylyiWDOs2oTmVe0n1WwdJtNX/oZZsqU4rnIZK6', NULL, '2024-10-19 10:29:58', '2024-10-19 10:29:58', NULL);
INSERT INTO `users` VALUES (4, 'sahabatech', 'sahabatech@gmail.com', NULL, NULL, '$2y$10$5IGPIeRXI9Zlt2mEle61zOWul86iYfxo8lQ.pYygyAQajlbSV8kby', NULL, '2024-10-23 12:58:09', '2024-10-23 12:58:09', NULL);

-- ----------------------------
-- Table structure for vendors
-- ----------------------------
DROP TABLE IF EXISTS `vendors`;
CREATE TABLE `vendors`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama_vendor` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat_vendor` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of vendors
-- ----------------------------
INSERT INTO `vendors` VALUES (1, 'PT. Mitra Integrasi Informatika', 'Jl. Raya Bogor KM 26, Ciracas, Jakarta Timur', NULL, NULL, NULL);

SET FOREIGN_KEY_CHECKS = 1;
