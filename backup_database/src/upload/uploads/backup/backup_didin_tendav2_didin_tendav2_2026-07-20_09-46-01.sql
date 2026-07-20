-- --------------------------------------------------
-- AUTO DATABASE BACKUP
-- Database : didin_tendav2
-- Dibuat   : 2026-07-20 09:46:01
-- --------------------------------------------------

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for activity_log
-- ----------------------------
DROP TABLE IF EXISTS `activity_log`;
CREATE TABLE `activity_log` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `log_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject_id` bigint(20) unsigned DEFAULT NULL,
  `causer_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `causer_id` bigint(20) unsigned DEFAULT NULL,
  `properties` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `batch_uuid` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `subject` (`subject_type`,`subject_id`),
  KEY `causer` (`causer_type`,`causer_id`),
  KEY `activity_log_log_name_index` (`log_name`)
) ENGINE=InnoDB AUTO_INCREMENT=344 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of activity_log
-- ----------------------------
INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES
(1, 'Resource', 'Role Created', 'Spatie\\Permission\\Models\\Role', 'Created', 1, NULL, NULL, '{\"guard_name\":\"web\",\"name\":\"super_admin\",\"updated_at\":\"2026-05-01 23:11:05\",\"created_at\":\"2026-05-01 23:11:05\",\"id\":1}', NULL, '2026-05-01 23:11:05', '2026-05-01 23:11:05'),
(2, 'Resource', 'User Created', 'App\\Models\\User', 'Created', 2, NULL, NULL, '{\"name\":\"ARHAN MALIK ALRASYID\",\"email\":\"arhanmali96@gmail.com\",\"phone\":\"082112123333\",\"whatsapp\":\"082112123333\",\"updated_at\":\"2026-05-01 23:12:08\",\"created_at\":\"2026-05-01 23:12:08\",\"id\":2}', NULL, '2026-05-01 23:12:08', '2026-05-01 23:12:08'),
(3, 'Access', 'ARHAN MALIK ALRASYID logged in', 'App\\Models\\User', 'Login', 2, 'App\\Models\\User', 2, '{\"ip\":\"192.168.64.1\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/147.0.0.0 Safari\\/537.36\"}', NULL, '2026-05-01 23:12:08', '2026-05-01 23:12:08'),
(4, 'Access', 'Admin logged in', 'App\\Models\\User', 'Login', 1, 'App\\Models\\User', 1, '{\"ip\":\"192.168.64.1\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/147.0.0.0 Safari\\/537.36\"}', NULL, '2026-05-01 23:29:14', '2026-05-01 23:29:14'),
(5, 'Resource', 'User Updated by Admin', 'App\\Models\\User', 'Updated', 1, 'App\\Models\\User', 1, '{\"avatar_url\":\"01KQJANM6R4H578PKDXTHH3SXA.jpg\",\"updated_at\":\"2026-05-02 00:51:33\"}', NULL, '2026-05-02 00:51:33', '2026-05-02 00:51:33'),
(6, 'Access', 'Admin logged in', 'App\\Models\\User', 'Login', 1, 'App\\Models\\User', 1, '{\"ip\":\"192.168.64.1\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/147.0.0.0 Safari\\/537.36\"}', NULL, '2026-05-02 01:13:32', '2026-05-02 01:13:32'),
(7, 'Resource', 'Package Updated by Admin', 'App\\Models\\Package', 'Updated', 1, 'App\\Models\\User', 1, '{\"main_image\":\"packages\\/main\\/01KQJC5FAAV75D9A575Y96J1D6.jpg\",\"images\":\"[\\\"packages\\\\\\/gallery\\\\\\/01KQJC5FACVC3EPK04SQHCAF7H.jpg\\\"]\",\"updated_at\":\"2026-05-02 01:17:40\"}', NULL, '2026-05-02 01:17:40', '2026-05-02 01:17:40'),
(8, 'Resource', 'Package Updated by Admin', 'App\\Models\\Package', 'Updated', 1, 'App\\Models\\User', 1, '{\"images\":\"[\\\"packages\\\\\\/gallery\\\\\\/01KQJC5FACVC3EPK04SQHCAF7H.jpg\\\",\\\"packages\\\\\\/gallery\\\\\\/01KQJC60EM804JRE5XPEXQGPD3.jpg\\\",\\\"packages\\\\\\/gallery\\\\\\/01KQJC60EP2B8QJ0X120AFRWGP.jpg\\\"]\",\"updated_at\":\"2026-05-02 01:17:58\"}', NULL, '2026-05-02 01:17:58', '2026-05-02 01:17:58'),
(9, 'Resource', 'Package Deleted by Admin', 'App\\Models\\Package', 'Deleted', 6, 'App\\Models\\User', 1, '[]', NULL, '2026-05-02 01:23:18', '2026-05-02 01:23:18'),
(10, 'Resource', 'Addon Updated by Admin', 'App\\Models\\Addon', 'Updated', 1, 'App\\Models\\User', 1, '{\"unit\":\"pcs\",\"image\":null,\"updated_at\":\"2026-05-02 01:54:24\"}', NULL, '2026-05-02 01:54:24', '2026-05-02 01:54:24'),
(11, 'Resource', 'Addon Updated by Admin', 'App\\Models\\Addon', 'Updated', 5, 'App\\Models\\User', 1, '{\"unit\":\"pcs\",\"image\":null,\"updated_at\":\"2026-05-02 01:54:36\"}', NULL, '2026-05-02 01:54:36', '2026-05-02 01:54:36'),
(12, 'Resource', 'Addon Updated by Admin', 'App\\Models\\Addon', 'Updated', 6, 'App\\Models\\User', 1, '{\"unit\":\"pcs\",\"image\":null,\"updated_at\":\"2026-05-02 01:54:46\"}', NULL, '2026-05-02 01:54:46', '2026-05-02 01:54:46'),
(13, 'Resource', 'Beranda Created by Admin', 'App\\Models\\Beranda', 'Created', 1, 'App\\Models\\User', 1, '{\"title_1\":\"Sejak 1996 \\u2022 Terpercaya\",\"title_2\":\"Sewakan Tenda & Dekorasi Impian untuk Acara Istimewa Anda\",\"deskripsi\":\"Booking online 24\\/7, cek ketersediaan real-time, dan pembayaran aman via berbagai metode. Wujudkan acara impian bersama Didin Tenda Decoration.\",\"image\":\"beranda\\/01KQJQW84F3RN8HKT8PR54K5VW.png\",\"updated_at\":\"2026-05-02 04:42:21\",\"created_at\":\"2026-05-02 04:42:21\",\"id\":1}', NULL, '2026-05-02 04:42:21', '2026-05-02 04:42:21'),
(14, 'Resource', 'Beranda Updated by Admin', 'App\\Models\\Beranda', 'Updated', 1, 'App\\Models\\User', 1, '{\"title_1\":\"Sejak 1996 \\u2022 Terpercayassssssss\",\"updated_at\":\"2026-05-02 04:42:30\"}', NULL, '2026-05-02 04:42:30', '2026-05-02 04:42:30'),
(15, 'Resource', 'Beranda Updated by Admin', 'App\\Models\\Beranda', 'Updated', 1, 'App\\Models\\User', 1, '{\"title_1\":\"Sejak 1996 \\u2022 Terpercaya\",\"updated_at\":\"2026-05-02 04:42:37\"}', NULL, '2026-05-02 04:42:37', '2026-05-02 04:42:37'),
(16, 'Resource', 'Galery Created by Admin', 'App\\Models\\Galery', 'Created', 1, 'App\\Models\\User', 1, '{\"title\":\"Pelaminan Mewah\",\"deskripsi\":\"pelaminan mewah - 2025\",\"image\":\"galeries\\/01KQJSBVH31EJFWA03V42PMDD6.webp\",\"updated_at\":\"2026-05-02 05:08:21\",\"created_at\":\"2026-05-02 05:08:21\",\"id\":1}', NULL, '2026-05-02 05:08:21', '2026-05-02 05:08:21'),
(17, 'Resource', 'Galery Created by Admin', 'App\\Models\\Galery', 'Created', 2, 'App\\Models\\User', 1, '{\"title\":\"pemasangan tenda pelaminan\",\"deskripsi\":\"pemasangan tenda pelaminan 2025\",\"image\":\"galeries\\/01KQJSDT7VEFRBW8J14J9SNKNA.webp\",\"updated_at\":\"2026-05-02 05:09:25\",\"created_at\":\"2026-05-02 05:09:25\",\"id\":2}', NULL, '2026-05-02 05:09:25', '2026-05-02 05:09:25'),
(18, 'Resource', 'Footer Created by Admin', 'App\\Models\\Footer', 'Created', 1, 'App\\Models\\User', 1, '{\"alamat\":\"Jl. Ki Mas Laeng Kp. Katomas, Tigaraksa, Kab. Tangerang, Banten\",\"nomor_telfon\":\"0882-8925-8764\",\"email\":\"info@didintenda.com\",\"copyright\":\"\\u00a9 2026 Didin Tenda Decoration. All rights reserved.\",\"develop_by\":\"Developed for Tugas Akhir - Muhamad Darlan (20220803005)\",\"updated_at\":\"2026-05-02 05:19:22\",\"created_at\":\"2026-05-02 05:19:22\",\"id\":1}', NULL, '2026-05-02 05:19:22', '2026-05-02 05:19:22'),
(19, 'Resource', 'Footer Updated by Admin', 'App\\Models\\Footer', 'Updated', 1, 'App\\Models\\User', 1, '{\"alamat\":\"Jl. Ki Mas Laeng Kp. Katomas, Tigaraksa, Kab. Tangerang, Bantenssssssssssssssssssssss\",\"updated_at\":\"2026-05-02 05:21:50\"}', NULL, '2026-05-02 05:21:50', '2026-05-02 05:21:50'),
(20, 'Resource', 'Footer Updated by Admin', 'App\\Models\\Footer', 'Updated', 1, 'App\\Models\\User', 1, '{\"alamat\":\"Jl. Ki Mas Laeng Kp. Katomas, Tigaraksa, Kab. Tangerang, Banten\",\"updated_at\":\"2026-05-02 05:22:00\"}', NULL, '2026-05-02 05:22:00', '2026-05-02 05:22:00'),
(21, 'Resource', 'Sosial Media Created by Admin', 'App\\Models\\SosialMedia', 'Created', 1, 'App\\Models\\User', 1, '{\"icon\":\"bi bi-facebook\",\"link\":null,\"updated_at\":\"2026-05-02 05:27:00\",\"created_at\":\"2026-05-02 05:27:00\",\"id\":1}', NULL, '2026-05-02 05:27:00', '2026-05-02 05:27:00'),
(22, 'Resource', 'Sosial Media Created by Admin', 'App\\Models\\SosialMedia', 'Created', 2, 'App\\Models\\User', 1, '{\"icon\":\"bi bi-instagram\",\"link\":null,\"updated_at\":\"2026-05-02 05:27:11\",\"created_at\":\"2026-05-02 05:27:11\",\"id\":2}', NULL, '2026-05-02 05:27:11', '2026-05-02 05:27:11'),
(23, 'Resource', 'Sosial Media Created by Admin', 'App\\Models\\SosialMedia', 'Created', 3, 'App\\Models\\User', 1, '{\"icon\":\"bi bi-whatsapp\",\"link\":null,\"updated_at\":\"2026-05-02 05:27:20\",\"created_at\":\"2026-05-02 05:27:20\",\"id\":3}', NULL, '2026-05-02 05:27:20', '2026-05-02 05:27:20'),
(24, 'Resource', 'Sosial Media Created by Admin', 'App\\Models\\SosialMedia', 'Created', 4, 'App\\Models\\User', 1, '{\"icon\":\"bi bi-youtube\",\"link\":null,\"updated_at\":\"2026-05-02 05:27:28\",\"created_at\":\"2026-05-02 05:27:28\",\"id\":4}', NULL, '2026-05-02 05:27:28', '2026-05-02 05:27:28'),
(25, 'Resource', 'Sosial Media Updated by Admin', 'App\\Models\\SosialMedia', 'Updated', 2, 'App\\Models\\User', 1, '{\"link\":\"https:\\/\\/www.instagram.com\\/didin.tenda\\/\",\"updated_at\":\"2026-05-02 05:29:40\"}', NULL, '2026-05-02 05:29:40', '2026-05-02 05:29:40'),
(26, 'Notification', 'ResetPassword Notification sent to arhanmcz@gmail.com', NULL, 'Notification Sent', NULL, NULL, NULL, '[]', NULL, '2026-05-02 05:43:47', '2026-05-02 05:43:47'),
(27, 'Resource', 'User Created', 'App\\Models\\User', 'Created', 4, NULL, NULL, '{\"name\":\"test\",\"email\":\"rasyidmalik456@gmail.com\",\"phone\":\"082122222222\",\"whatsapp\":\"082122222222\",\"updated_at\":\"2026-05-02 05:45:03\",\"created_at\":\"2026-05-02 05:45:03\",\"id\":4}', NULL, '2026-05-02 05:45:03', '2026-05-02 05:45:03'),
(28, 'Access', 'test logged in', 'App\\Models\\User', 'Login', 4, 'App\\Models\\User', 4, '{\"ip\":\"192.168.64.1\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/147.0.0.0 Safari\\/537.36\"}', NULL, '2026-05-02 05:45:03', '2026-05-02 05:45:03'),
(29, 'Notification', 'ResetPassword Notification sent to rasyidmalik456@gmail.com', NULL, 'Notification Sent', NULL, NULL, NULL, '[]', NULL, '2026-05-02 05:45:21', '2026-05-02 05:45:21'),
(30, 'Notification', 'ResetPassword Notification sent to arhanmcz@gmail.com', NULL, 'Notification Sent', NULL, NULL, NULL, '[]', NULL, '2026-05-02 05:51:58', '2026-05-02 05:51:58'),
(31, 'Notification', 'ResetPassword Notification sent to arhanmcz@gmail.com', NULL, 'Notification Sent', NULL, NULL, NULL, '[]', NULL, '2026-05-02 05:56:15', '2026-05-02 05:56:15'),
(32, 'Notification', 'ResetPassword Notification sent to arhanmali96@gmail.com', NULL, 'Notification Sent', NULL, NULL, NULL, '[]', NULL, '2026-05-02 06:05:55', '2026-05-02 06:05:55'),
(33, 'Notification', 'ResetPassword Notification sent to arhanmali96@gmail.com', NULL, 'Notification Sent', NULL, NULL, NULL, '[]', NULL, '2026-05-02 13:03:01', '2026-05-02 13:03:01'),
(34, 'Notification', 'ResetPassword Notification sent to arhanmcz@gmail.com', NULL, 'Notification Sent', NULL, NULL, NULL, '[]', NULL, '2026-05-02 23:57:02', '2026-05-02 23:57:02'),
(35, 'Notification', 'ResetPassword Notification sent to arhanmcz@gmail.com', NULL, 'Notification Sent', NULL, NULL, NULL, '[]', NULL, '2026-05-03 00:05:47', '2026-05-03 00:05:47'),
(36, 'Access', 'Admin logged in', 'App\\Models\\User', 'Login', 1, 'App\\Models\\User', 1, '{\"ip\":\"192.168.64.1\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/147.0.0.0 Safari\\/537.36\"}', NULL, '2026-05-03 03:25:49', '2026-05-03 03:25:49'),
(37, 'Resource', 'Package Created by Admin', 'App\\Models\\Package', 'Created', 7, 'App\\Models\\User', 1, '{\"name\":\"test\",\"slug\":\"test\",\"type\":\"fixed\",\"short_description\":\"test\",\"description\":\"test\",\"price\":15000000,\"price_unit\":\"paket\",\"badge\":\"Best Seller\",\"is_popular\":false,\"is_active\":true,\"sort_order\":0,\"main_image\":\"packages\\/main\\/01KQPM09GDKT2F099PHARXZ1B3.png\",\"images\":\"[\\\"packages\\\\\\/gallery\\\\\\/01KQPM09GERMTMTV7RQT60MSKJ.png\\\",\\\"packages\\\\\\/gallery\\\\\\/01KQPM09GFP7CEZRJNRWSD093G.png\\\",\\\"packages\\\\\\/gallery\\\\\\/01KQPM09GH1PYCTZM0FXMC7HYT.png\\\"]\",\"updated_at\":\"2026-05-03 16:51:37\",\"created_at\":\"2026-05-03 16:51:37\",\"id\":7}', NULL, '2026-05-03 16:51:37', '2026-05-03 16:51:37'),
(38, 'Notification', 'ResetPassword Notification sent to arhanmcz@gmail.com', NULL, 'Notification Sent', NULL, NULL, NULL, '[]', NULL, '2026-05-03 18:05:52', '2026-05-03 18:05:52'),
(39, 'Resource', 'User Updated', 'App\\Models\\User', 'Updated', 3, NULL, NULL, '{\"updated_at\":\"2026-05-03 18:06:07\"}', NULL, '2026-05-03 18:06:07', '2026-05-03 18:06:07'),
(40, 'Access', 'arhan malik  logged in', 'App\\Models\\User', 'Login', 3, 'App\\Models\\User', 3, '{\"ip\":\"192.168.64.1\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/147.0.0.0 Safari\\/537.36\"}', NULL, '2026-05-03 18:06:17', '2026-05-03 18:06:17'),
(41, 'Resource', 'Addon Updated by arhan malik ', 'App\\Models\\Addon', 'Updated', 1, 'App\\Models\\User', 3, '{\"stock\":6}', NULL, '2026-05-03 19:38:26', '2026-05-03 19:38:26'),
(42, 'Resource', 'Addon Updated by arhan malik ', 'App\\Models\\Addon', 'Updated', 2, 'App\\Models\\User', 3, '{\"stock\":8}', NULL, '2026-05-03 19:38:26', '2026-05-03 19:38:26'),
(43, 'Resource', 'Addon Updated by arhan malik ', 'App\\Models\\Addon', 'Updated', 3, 'App\\Models\\User', 3, '{\"stock\":2}', NULL, '2026-05-03 19:38:26', '2026-05-03 19:38:26'),
(44, 'Resource', 'Addon Updated by arhan malik ', 'App\\Models\\Addon', 'Updated', 4, 'App\\Models\\User', 3, '{\"stock\":1}', NULL, '2026-05-03 19:38:26', '2026-05-03 19:38:26'),
(45, 'Resource', 'Addon Updated by arhan malik ', 'App\\Models\\Addon', 'Updated', 5, 'App\\Models\\User', 3, '{\"stock\":3}', NULL, '2026-05-03 19:38:26', '2026-05-03 19:38:26'),
(46, 'Resource', 'Addon Updated by arhan malik ', 'App\\Models\\Addon', 'Updated', 6, 'App\\Models\\User', 3, '{\"stock\":18}', NULL, '2026-05-03 19:38:26', '2026-05-03 19:38:26'),
(47, 'Resource', 'Order Created by arhan malik ', 'App\\Models\\Order', 'Created', 3, 'App\\Models\\User', 3, '{\"invoice_number\":\"INV\\/2026\\/0003-XXAJ\",\"user_id\":3,\"package_id\":5,\"order_type\":\"package\",\"customer_name\":\"JACOBI JAWARNA\",\"customer_phone\":\"082123333344\",\"customer_email\":\"arhanmcz@gmail.com\",\"event_date\":\"2026-05-27 00:00:00\",\"event_location_name\":\"GEDUNG BIRAWA CAKRA\",\"event_address\":\"Bursa Efek Jakarta, Kav 52-53, Sudirman Central Business District Northway, RW 03, Senayan, Kebayoran Baru, Jakarta Selatan, Daerah Khusus Ibukota Jakarta, Jawa, 12190, Indonesia\",\"event_latitude\":\"-6.2236851\",\"event_longitude\":\"106.8086123\",\"distance_km\":48.06,\"shipping_fee\":290000,\"subtotal_package\":12000000,\"subtotal_custom\":0,\"subtotal_addons\":12200000,\"total_price\":24490000,\"status\":\"waiting_payment\",\"payment_status\":\"unpaid\",\"payment_deadline\":\"2026-05-04 19:38:26\",\"notes\":null,\"updated_at\":\"2026-05-03 19:38:26\",\"created_at\":\"2026-05-03 19:38:26\",\"id\":3}', NULL, '2026-05-03 19:38:26', '2026-05-03 19:38:26'),
(48, 'Resource', 'Order Item Created by arhan malik ', 'App\\Models\\OrderItem', 'Created', 3, 'App\\Models\\User', 3, '{\"item_type\":\"package\",\"source_id\":5,\"name\":\"Paket Tenda Akbar\",\"unit\":\"paket\",\"quantity\":1,\"price\":12000000,\"total_price\":12000000,\"snapshot\":\"{\\\"id\\\":5,\\\"slug\\\":\\\"paket-tenda-akbar\\\",\\\"name\\\":\\\"Paket Tenda Akbar\\\",\\\"price\\\":12000000,\\\"price_unit\\\":\\\"paket\\\",\\\"main_image\\\":\\\"https:\\\\\\/\\\\\\/placehold.co\\\\\\/800x500\\\\\\/e67e22\\\\\\/ffffff?text=Paket+Tenda+Akbar\\\",\\\"short_description\\\":\\\"Paket tenda besar untuk acara outdoor dan acara skala besar.\\\"}\",\"order_id\":3,\"updated_at\":\"2026-05-03 19:38:26\",\"created_at\":\"2026-05-03 19:38:26\",\"id\":3}', NULL, '2026-05-03 19:38:26', '2026-05-03 19:38:26'),
(49, 'Resource', 'Order Addon Created by arhan malik ', 'App\\Models\\OrderAddon', 'Created', 11, 'App\\Models\\User', 3, '{\"addon_id\":1,\"name\":\"Sound System\",\"detail\":\"Speaker aktif, mixer, dan microphone untuk kebutuhan acara.\",\"unit\":\"pcs\",\"quantity\":2,\"price\":750000,\"total_price\":1500000,\"snapshot\":\"{\\\"slug\\\":\\\"sound-system\\\",\\\"image\\\":null,\\\"icon\\\":\\\"bi-speaker\\\",\\\"is_quantity_based\\\":true}\",\"order_id\":3,\"updated_at\":\"2026-05-03 19:38:26\",\"created_at\":\"2026-05-03 19:38:26\",\"id\":11}', NULL, '2026-05-03 19:38:26', '2026-05-03 19:38:26'),
(50, 'Resource', 'Order Addon Created by arhan malik ', 'App\\Models\\OrderAddon', 'Created', 12, 'App\\Models\\User', 3, '{\"addon_id\":2,\"name\":\"Lighting Dekorasi\",\"detail\":\"Lampu dekorasi untuk mempercantik area acara.\",\"unit\":\"set\",\"quantity\":2,\"price\":500000,\"total_price\":1000000,\"snapshot\":\"{\\\"slug\\\":\\\"lighting-dekorasi\\\",\\\"image\\\":\\\"https:\\\\\\/\\\\\\/placehold.co\\\\\\/600x400\\\\\\/f1c40f\\\\\\/000000?text=Lighting\\\",\\\"icon\\\":\\\"bi-lightbulb\\\",\\\"is_quantity_based\\\":true}\",\"order_id\":3,\"updated_at\":\"2026-05-03 19:38:26\",\"created_at\":\"2026-05-03 19:38:26\",\"id\":12}', NULL, '2026-05-03 19:38:26', '2026-05-03 19:38:26'),
(51, 'Resource', 'Order Addon Created by arhan malik ', 'App\\Models\\OrderAddon', 'Created', 13, 'App\\Models\\User', 3, '{\"addon_id\":3,\"name\":\"Photobooth\",\"detail\":\"Area foto dekoratif untuk tamu undangan.\",\"unit\":\"set\",\"quantity\":2,\"price\":1200000,\"total_price\":2400000,\"snapshot\":\"{\\\"slug\\\":\\\"photobooth\\\",\\\"image\\\":\\\"https:\\\\\\/\\\\\\/placehold.co\\\\\\/600x400\\\\\\/9b59b6\\\\\\/ffffff?text=Photobooth\\\",\\\"icon\\\":\\\"bi-camera\\\",\\\"is_quantity_based\\\":true}\",\"order_id\":3,\"updated_at\":\"2026-05-03 19:38:26\",\"created_at\":\"2026-05-03 19:38:26\",\"id\":13}', NULL, '2026-05-03 19:38:26', '2026-05-03 19:38:26'),
(52, 'Resource', 'Order Addon Created by arhan malik ', 'App\\Models\\OrderAddon', 'Created', 14, 'App\\Models\\User', 3, '{\"addon_id\":4,\"name\":\"Panggung Rigging\",\"detail\":\"Panggung dan rigging untuk acara besar atau outdoor.\",\"unit\":\"set\",\"quantity\":2,\"price\":2500000,\"total_price\":5000000,\"snapshot\":\"{\\\"slug\\\":\\\"panggung-rigging\\\",\\\"image\\\":\\\"https:\\\\\\/\\\\\\/placehold.co\\\\\\/600x400\\\\\\/e74c3c\\\\\\/ffffff?text=Panggung+Rigging\\\",\\\"icon\\\":\\\"bi-grid-3x3-gap\\\",\\\"is_quantity_based\\\":true}\",\"order_id\":3,\"updated_at\":\"2026-05-03 19:38:26\",\"created_at\":\"2026-05-03 19:38:26\",\"id\":14}', NULL, '2026-05-03 19:38:26', '2026-05-03 19:38:26'),
(53, 'Resource', 'Order Addon Created by arhan malik ', 'App\\Models\\OrderAddon', 'Created', 15, 'App\\Models\\User', 3, '{\"addon_id\":5,\"name\":\"Genset\",\"detail\":\"Genset cadangan listrik untuk acara outdoor.\",\"unit\":\"pcs\",\"quantity\":2,\"price\":1000000,\"total_price\":2000000,\"snapshot\":\"{\\\"slug\\\":\\\"genset\\\",\\\"image\\\":null,\\\"icon\\\":\\\"bi-lightning-charge\\\",\\\"is_quantity_based\\\":true}\",\"order_id\":3,\"updated_at\":\"2026-05-03 19:38:26\",\"created_at\":\"2026-05-03 19:38:26\",\"id\":15}', NULL, '2026-05-03 19:38:26', '2026-05-03 19:38:26'),
(54, 'Resource', 'Order Addon Created by arhan malik ', 'App\\Models\\OrderAddon', 'Created', 16, 'App\\Models\\User', 3, '{\"addon_id\":6,\"name\":\"Kipas Blower\",\"detail\":\"Kipas blower untuk area tenda agar lebih nyaman.\",\"unit\":\"pcs\",\"quantity\":2,\"price\":150000,\"total_price\":300000,\"snapshot\":\"{\\\"slug\\\":\\\"kipas-blower\\\",\\\"image\\\":null,\\\"icon\\\":\\\"bi-wind\\\",\\\"is_quantity_based\\\":true}\",\"order_id\":3,\"updated_at\":\"2026-05-03 19:38:26\",\"created_at\":\"2026-05-03 19:38:26\",\"id\":16}', NULL, '2026-05-03 19:38:26', '2026-05-03 19:38:26'),
(55, 'Resource', 'Order Updated by arhan malik ', 'App\\Models\\Order', 'Updated', 3, 'App\\Models\\User', 3, '{\"payment_status\":\"pending\",\"updated_at\":\"2026-05-03 19:38:30\"}', NULL, '2026-05-03 19:38:30', '2026-05-03 19:38:30'),
(56, 'Resource', 'Order Updated by arhan malik ', 'App\\Models\\Order', 'Updated', 3, 'App\\Models\\User', 3, '{\"status\":\"confirmed\",\"payment_status\":\"paid\",\"paid_at\":\"2026-05-03 19:38:42\",\"confirmed_at\":\"2026-05-03 19:38:42\",\"updated_at\":\"2026-05-03 19:38:42\"}', NULL, '2026-05-03 19:38:42', '2026-05-03 19:38:42'),
(57, 'Resource', 'Addon Updated by arhan malik ', 'App\\Models\\Addon', 'Updated', 2, 'App\\Models\\User', 3, '{\"stock\":6}', NULL, '2026-05-03 19:40:16', '2026-05-03 19:40:16'),
(58, 'Resource', 'Order Created by arhan malik ', 'App\\Models\\Order', 'Created', 4, 'App\\Models\\User', 3, '{\"invoice_number\":\"INV\\/2026\\/0004-LQ6G\",\"user_id\":3,\"package_id\":5,\"order_type\":\"package\",\"customer_name\":\"arhan malik\",\"customer_phone\":\"082222222211\",\"customer_email\":\"arhanmcz@gmail.com\",\"event_date\":\"2026-05-15 00:00:00\",\"event_location_name\":\"ESA UNGGUL LEADERSHIP\",\"event_address\":\"Universitas Esa Unggul, Jalan Arjuna Utara, RW 02, Duri Kepa, Kebon Jeruk, Jakarta Barat, Daerah Khusus Ibukota Jakarta, Jawa, 11430, Indonesia\",\"event_latitude\":\"-6.1856846\",\"event_longitude\":\"106.7789088\",\"distance_km\":39.68,\"shipping_fee\":200000,\"subtotal_package\":12000000,\"subtotal_custom\":0,\"subtotal_addons\":1000000,\"total_price\":13200000,\"status\":\"waiting_payment\",\"payment_status\":\"unpaid\",\"payment_deadline\":\"2026-05-04 19:40:16\",\"notes\":null,\"updated_at\":\"2026-05-03 19:40:16\",\"created_at\":\"2026-05-03 19:40:16\",\"id\":4}', NULL, '2026-05-03 19:40:16', '2026-05-03 19:40:16'),
(59, 'Resource', 'Order Item Created by arhan malik ', 'App\\Models\\OrderItem', 'Created', 4, 'App\\Models\\User', 3, '{\"item_type\":\"package\",\"source_id\":5,\"name\":\"Paket Tenda Akbar\",\"unit\":\"paket\",\"quantity\":1,\"price\":12000000,\"total_price\":12000000,\"snapshot\":\"{\\\"id\\\":5,\\\"slug\\\":\\\"paket-tenda-akbar\\\",\\\"name\\\":\\\"Paket Tenda Akbar\\\",\\\"price\\\":12000000,\\\"price_unit\\\":\\\"paket\\\",\\\"main_image\\\":\\\"https:\\\\\\/\\\\\\/placehold.co\\\\\\/800x500\\\\\\/e67e22\\\\\\/ffffff?text=Paket+Tenda+Akbar\\\",\\\"short_description\\\":\\\"Paket tenda besar untuk acara outdoor dan acara skala besar.\\\"}\",\"order_id\":4,\"updated_at\":\"2026-05-03 19:40:16\",\"created_at\":\"2026-05-03 19:40:16\",\"id\":4}', NULL, '2026-05-03 19:40:16', '2026-05-03 19:40:16'),
(60, 'Resource', 'Order Addon Created by arhan malik ', 'App\\Models\\OrderAddon', 'Created', 17, 'App\\Models\\User', 3, '{\"addon_id\":2,\"name\":\"Lighting Dekorasi\",\"detail\":\"Lampu dekorasi untuk mempercantik area acara.\",\"unit\":\"set\",\"quantity\":2,\"price\":500000,\"total_price\":1000000,\"snapshot\":\"{\\\"slug\\\":\\\"lighting-dekorasi\\\",\\\"image\\\":\\\"https:\\\\\\/\\\\\\/placehold.co\\\\\\/600x400\\\\\\/f1c40f\\\\\\/000000?text=Lighting\\\",\\\"icon\\\":\\\"bi-lightbulb\\\",\\\"is_quantity_based\\\":true}\",\"order_id\":4,\"updated_at\":\"2026-05-03 19:40:16\",\"created_at\":\"2026-05-03 19:40:16\",\"id\":17}', NULL, '2026-05-03 19:40:16', '2026-05-03 19:40:16'),
(61, 'Resource', 'Order Updated by arhan malik ', 'App\\Models\\Order', 'Updated', 4, 'App\\Models\\User', 3, '{\"payment_status\":\"pending\",\"updated_at\":\"2026-05-03 19:40:18\"}', NULL, '2026-05-03 19:40:18', '2026-05-03 19:40:18'),
(62, 'Resource', 'Order Updated by arhan malik ', 'App\\Models\\Order', 'Updated', 4, 'App\\Models\\User', 3, '{\"status\":\"confirmed\",\"payment_status\":\"paid\",\"paid_at\":\"2026-05-03 19:40:28\",\"confirmed_at\":\"2026-05-03 19:40:28\",\"updated_at\":\"2026-05-03 19:40:28\"}', NULL, '2026-05-03 19:40:28', '2026-05-03 19:40:28'),
(63, 'Access', 'arhan malik  logged in', 'App\\Models\\User', 'Login', 3, 'App\\Models\\User', 3, '{\"ip\":\"192.168.64.1\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/147.0.0.0 Safari\\/537.36\"}', NULL, '2026-05-03 19:41:29', '2026-05-03 19:41:29'),
(64, 'Access', 'Admin logged in', 'App\\Models\\User', 'Login', 1, 'App\\Models\\User', 1, '{\"ip\":\"192.168.64.1\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/147.0.0.0 Safari\\/537.36 Edg\\/147.0.0.0\"}', NULL, '2026-05-03 22:26:45', '2026-05-03 22:26:45'),
(65, 'Access', 'arhan malik  logged in', 'App\\Models\\User', 'Login', 3, 'App\\Models\\User', 3, '{\"ip\":\"192.168.64.1\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/147.0.0.0 Safari\\/537.36 Edg\\/147.0.0.0\"}', NULL, '2026-05-03 22:33:43', '2026-05-03 22:33:43'),
(66, 'Resource', 'Order Created by arhan malik ', 'App\\Models\\Order', 'Created', 5, 'App\\Models\\User', 3, '{\"invoice_number\":\"INV\\/2026\\/0005-C6XS\",\"user_id\":3,\"package_id\":1,\"order_type\":\"package\",\"customer_name\":\"arhan malik\",\"customer_phone\":\"089966669999\",\"customer_email\":\"arhanmcz@gmail.com\",\"event_date\":\"2026-05-20 00:00:00\",\"event_location_name\":\"ATHAR NIKAH SAMA AVERY\",\"event_address\":\"Universitas Esa Unggul, Jalan Arjuna Utara, RW 02, Duri Kepa, Kebon Jeruk, Jakarta Barat, Daerah Khusus Ibukota Jakarta, Jawa, 11430, Indonesia\",\"event_latitude\":\"-6.1856846\",\"event_longitude\":\"106.7789088\",\"distance_km\":39.68,\"shipping_fee\":200000,\"subtotal_package\":15000000,\"subtotal_custom\":0,\"subtotal_addons\":0,\"total_price\":15200000,\"status\":\"waiting_payment\",\"payment_status\":\"unpaid\",\"payment_deadline\":\"2026-05-04 22:36:36\",\"notes\":null,\"updated_at\":\"2026-05-03 22:36:36\",\"created_at\":\"2026-05-03 22:36:36\",\"id\":5}', NULL, '2026-05-03 22:36:36', '2026-05-03 22:36:36'),
(67, 'Resource', 'Order Item Created by arhan malik ', 'App\\Models\\OrderItem', 'Created', 5, 'App\\Models\\User', 3, '{\"item_type\":\"package\",\"source_id\":1,\"name\":\"Paket Wedding Premium\",\"unit\":\"paket\",\"quantity\":1,\"price\":15000000,\"total_price\":15000000,\"snapshot\":\"{\\\"id\\\":1,\\\"slug\\\":\\\"paket-wedding-premium\\\",\\\"name\\\":\\\"Paket Wedding Premium\\\",\\\"price\\\":15000000,\\\"price_unit\\\":\\\"paket\\\",\\\"main_image\\\":\\\"packages\\\\\\/main\\\\\\/01KQJC5FAAV75D9A575Y96J1D6.jpg\\\",\\\"short_description\\\":\\\"Paket dekorasi pernikahan lengkap untuk acara resepsi besar.\\\"}\",\"order_id\":5,\"updated_at\":\"2026-05-03 22:36:36\",\"created_at\":\"2026-05-03 22:36:36\",\"id\":5}', NULL, '2026-05-03 22:36:36', '2026-05-03 22:36:36'),
(68, 'Resource', 'Order Updated by arhan malik ', 'App\\Models\\Order', 'Updated', 5, 'App\\Models\\User', 3, '{\"payment_status\":\"pending\",\"updated_at\":\"2026-05-03 22:36:38\"}', NULL, '2026-05-03 22:36:38', '2026-05-03 22:36:38'),
(69, 'Resource', 'Order Updated by arhan malik ', 'App\\Models\\Order', 'Updated', 5, 'App\\Models\\User', 3, '{\"status\":\"confirmed\",\"payment_status\":\"paid\",\"paid_at\":\"2026-05-03 22:37:18\",\"confirmed_at\":\"2026-05-03 22:37:18\",\"updated_at\":\"2026-05-03 22:37:18\"}', NULL, '2026-05-03 22:37:18', '2026-05-03 22:37:18'),
(70, 'Notification', 'ResetPassword Notification sent to arhanmcz@gmail.com', NULL, 'Notification Sent', NULL, NULL, NULL, '[]', NULL, '2026-05-03 22:38:46', '2026-05-03 22:38:46'),
(71, 'Access', 'Admin logged in', 'App\\Models\\User', 'Login', 1, 'App\\Models\\User', 1, '{\"ip\":\"192.168.64.1\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/147.0.0.0 Safari\\/537.36 Edg\\/147.0.0.0\"}', NULL, '2026-05-03 22:39:27', '2026-05-03 22:39:27'),
(72, 'Access', 'Admin logged in', 'App\\Models\\User', 'Login', 1, 'App\\Models\\User', 1, '{\"ip\":\"192.168.64.1\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/147.0.0.0 Safari\\/537.36\"}', NULL, '2026-05-08 09:01:50', '2026-05-08 09:01:50'),
(73, 'Access', 'Admin logged in', 'App\\Models\\User', 'Login', 1, 'App\\Models\\User', 1, '{\"ip\":\"192.168.64.1\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/148.0.0.0 Safari\\/537.36\"}', NULL, '2026-05-12 11:05:36', '2026-05-12 11:05:36'),
(74, 'Access', 'Admin logged in', 'App\\Models\\User', 'Login', 1, 'App\\Models\\User', 1, '{\"ip\":\"192.168.64.1\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/147.0.0.0 Safari\\/537.36\"}', NULL, '2026-05-12 13:58:05', '2026-05-12 13:58:05'),
(75, 'Access', 'Admin logged in', 'App\\Models\\User', 'Login', 1, 'App\\Models\\User', 1, '{\"ip\":\"192.168.64.1\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/147.0.0.0 Safari\\/537.36\"}', NULL, '2026-05-12 15:43:37', '2026-05-12 15:43:37'),
(76, 'Access', 'Admin logged in', 'App\\Models\\User', 'Login', 1, 'App\\Models\\User', 1, '{\"ip\":\"192.168.64.1\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/147.0.0.0 Safari\\/537.36\"}', NULL, '2026-05-12 19:22:49', '2026-05-12 19:22:49'),
(77, 'Access', 'Admin logged in', 'App\\Models\\User', 'Login', 1, 'App\\Models\\User', 1, '{\"ip\":\"192.168.64.1\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/147.0.0.0 Safari\\/537.36\"}', NULL, '2026-05-12 19:26:16', '2026-05-12 19:26:16'),
(78, 'Access', 'Admin logged in', 'App\\Models\\User', 'Login', 1, 'App\\Models\\User', 1, '{\"ip\":\"192.168.64.1\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/148.0.0.0 Safari\\/537.36\"}', NULL, '2026-05-13 13:05:58', '2026-05-13 13:05:58'),
(79, 'Access', 'Admin logged in', 'App\\Models\\User', 'Login', 1, 'App\\Models\\User', 1, '{\"ip\":\"192.168.64.1\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/148.0.0.0 Safari\\/537.36 Edg\\/148.0.0.0\"}', NULL, '2026-05-15 06:04:08', '2026-05-15 06:04:08'),
(80, 'Resource', 'User Created', 'App\\Models\\User', 'Created', 5, NULL, NULL, '{\"name\":\"djncloud\",\"email\":\"djncloud@gmail.com\",\"phone\":\"082222222222\",\"whatsapp\":\"082222222222\",\"updated_at\":\"2026-05-15 12:17:34\",\"created_at\":\"2026-05-15 12:17:34\",\"id\":5}', NULL, '2026-05-15 12:17:34', '2026-05-15 12:17:34'),
(81, 'Access', 'djncloud logged in', 'App\\Models\\User', 'Login', 5, 'App\\Models\\User', 5, '{\"ip\":\"192.168.64.1\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/148.0.0.0 Safari\\/537.36\"}', NULL, '2026-05-15 12:17:34', '2026-05-15 12:17:34'),
(82, 'Access', 'ARHAN MALIK ALRASYID logged in', 'App\\Models\\User', 'Login', 2, 'App\\Models\\User', 2, '{\"ip\":\"192.168.64.1\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/148.0.0.0 Safari\\/537.36\"}', NULL, '2026-05-15 12:20:28', '2026-05-15 12:20:28'),
(83, 'Resource', 'Addon Updated by ARHAN MALIK ALRASYID', 'App\\Models\\Addon', 'Updated', 3, 'App\\Models\\User', 2, '{\"stock\":1}', NULL, '2026-05-15 12:21:20', '2026-05-15 12:21:20'),
(84, 'Resource', 'Order Created by ARHAN MALIK ALRASYID', 'App\\Models\\Order', 'Created', 6, 'App\\Models\\User', 2, '{\"invoice_number\":\"INV\\/2026\\/0006-UJYE\",\"user_id\":2,\"package_id\":3,\"order_type\":\"package\",\"customer_name\":\"ARHAN MALIK ALRASYID\",\"customer_phone\":\"082112123333\",\"customer_email\":\"arhanmali96@gmail.com\",\"event_date\":\"2026-05-28 00:00:00\",\"event_location_name\":\"testtttt\",\"event_address\":\"Universitas Esa Unggul, Jalan Arjuna Utara, RW 02, Duri Kepa, Kebon Jeruk, Jakarta Barat, Daerah Khusus Ibukota Jakarta, Jawa, 11430, Indonesia\",\"event_latitude\":\"-6.1856846\",\"event_longitude\":\"106.7789088\",\"distance_km\":39.68,\"shipping_fee\":200000,\"subtotal_package\":4500000,\"subtotal_custom\":0,\"subtotal_addons\":1200000,\"total_price\":5900000,\"status\":\"waiting_payment\",\"payment_status\":\"unpaid\",\"payment_deadline\":\"2026-05-16 12:21:20\",\"notes\":null,\"updated_at\":\"2026-05-15 12:21:20\",\"created_at\":\"2026-05-15 12:21:20\",\"id\":6}', NULL, '2026-05-15 12:21:20', '2026-05-15 12:21:20'),
(85, 'Resource', 'Order Item Created by ARHAN MALIK ALRASYID', 'App\\Models\\OrderItem', 'Created', 6, 'App\\Models\\User', 2, '{\"item_type\":\"package\",\"source_id\":3,\"name\":\"Paket Lamaran\",\"unit\":\"paket\",\"quantity\":1,\"price\":4500000,\"total_price\":4500000,\"snapshot\":\"{\\\"id\\\":3,\\\"slug\\\":\\\"paket-lamaran\\\",\\\"name\\\":\\\"Paket Lamaran\\\",\\\"price\\\":4500000,\\\"price_unit\\\":\\\"paket\\\",\\\"main_image\\\":\\\"https:\\\\\\/\\\\\\/placehold.co\\\\\\/800x500\\\\\\/9b59b6\\\\\\/ffffff?text=Paket+Lamaran\\\",\\\"short_description\\\":\\\"Paket dekorasi untuk acara lamaran dan pertunangan.\\\"}\",\"order_id\":6,\"updated_at\":\"2026-05-15 12:21:20\",\"created_at\":\"2026-05-15 12:21:20\",\"id\":6}', NULL, '2026-05-15 12:21:20', '2026-05-15 12:21:20'),
(86, 'Resource', 'Order Addon Created by ARHAN MALIK ALRASYID', 'App\\Models\\OrderAddon', 'Created', 18, 'App\\Models\\User', 2, '{\"addon_id\":3,\"name\":\"Photobooth\",\"detail\":\"Area foto dekoratif untuk tamu undangan.\",\"unit\":\"set\",\"quantity\":1,\"price\":1200000,\"total_price\":1200000,\"snapshot\":\"{\\\"slug\\\":\\\"photobooth\\\",\\\"image\\\":\\\"https:\\\\\\/\\\\\\/placehold.co\\\\\\/600x400\\\\\\/9b59b6\\\\\\/ffffff?text=Photobooth\\\",\\\"icon\\\":\\\"bi-camera\\\",\\\"is_quantity_based\\\":true}\",\"order_id\":6,\"updated_at\":\"2026-05-15 12:21:20\",\"created_at\":\"2026-05-15 12:21:20\",\"id\":18}', NULL, '2026-05-15 12:21:20', '2026-05-15 12:21:20'),
(87, 'Resource', 'Order Updated by ARHAN MALIK ALRASYID', 'App\\Models\\Order', 'Updated', 6, 'App\\Models\\User', 2, '{\"payment_status\":\"pending\",\"updated_at\":\"2026-05-15 12:21:23\"}', NULL, '2026-05-15 12:21:23', '2026-05-15 12:21:23'),
(88, 'Resource', 'Order Updated by ARHAN MALIK ALRASYID', 'App\\Models\\Order', 'Updated', 6, 'App\\Models\\User', 2, '{\"status\":\"confirmed\",\"payment_status\":\"paid\",\"paid_at\":\"2026-05-15 12:21:43\",\"confirmed_at\":\"2026-05-15 12:21:43\",\"updated_at\":\"2026-05-15 12:21:43\"}', NULL, '2026-05-15 12:21:43', '2026-05-15 12:21:43'),
(89, 'Access', 'arhan malik  logged in', 'App\\Models\\User', 'Login', 3, 'App\\Models\\User', 3, '{\"ip\":\"192.168.64.1\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/148.0.0.0 Safari\\/537.36\"}', NULL, '2026-05-15 12:22:51', '2026-05-15 12:22:51'),
(90, 'Resource', 'Addon Updated by arhan malik ', 'App\\Models\\Addon', 'Updated', 1, 'App\\Models\\User', 3, '{\"stock\":5}', NULL, '2026-05-15 12:23:25', '2026-05-15 12:23:25'),
(91, 'Resource', 'Order Created by arhan malik ', 'App\\Models\\Order', 'Created', 7, 'App\\Models\\User', 3, '{\"invoice_number\":\"INV\\/2026\\/0007-HXDX\",\"user_id\":3,\"package_id\":3,\"order_type\":\"package\",\"customer_name\":\"arhan malik\",\"customer_phone\":\"082122222222\",\"customer_email\":\"arhanmcz@gmail.com\",\"event_date\":\"2026-05-22 00:00:00\",\"event_location_name\":\"ESA UNGGUL LEADERSHIP\",\"event_address\":\"Universitas Esa Unggul, Jalan Inspeksi BKT, RW 03, Ujung Menteng, Cilincing, Jakarta Utara, Pusakarakyat, Kab Bekasi, Jawa Barat, Jawa, 17214, Indonesia\",\"event_latitude\":\"-6.1582481\",\"event_longitude\":\"106.9728742\",\"distance_km\":68.13,\"shipping_fee\":490000,\"subtotal_package\":4500000,\"subtotal_custom\":0,\"subtotal_addons\":750000,\"total_price\":5740000,\"status\":\"waiting_payment\",\"payment_status\":\"unpaid\",\"payment_deadline\":\"2026-05-16 12:23:25\",\"notes\":null,\"updated_at\":\"2026-05-15 12:23:25\",\"created_at\":\"2026-05-15 12:23:25\",\"id\":7}', NULL, '2026-05-15 12:23:25', '2026-05-15 12:23:25'),
(92, 'Resource', 'Order Item Created by arhan malik ', 'App\\Models\\OrderItem', 'Created', 7, 'App\\Models\\User', 3, '{\"item_type\":\"package\",\"source_id\":3,\"name\":\"Paket Lamaran\",\"unit\":\"paket\",\"quantity\":1,\"price\":4500000,\"total_price\":4500000,\"snapshot\":\"{\\\"id\\\":3,\\\"slug\\\":\\\"paket-lamaran\\\",\\\"name\\\":\\\"Paket Lamaran\\\",\\\"price\\\":4500000,\\\"price_unit\\\":\\\"paket\\\",\\\"main_image\\\":\\\"https:\\\\\\/\\\\\\/placehold.co\\\\\\/800x500\\\\\\/9b59b6\\\\\\/ffffff?text=Paket+Lamaran\\\",\\\"short_description\\\":\\\"Paket dekorasi untuk acara lamaran dan pertunangan.\\\"}\",\"order_id\":7,\"updated_at\":\"2026-05-15 12:23:25\",\"created_at\":\"2026-05-15 12:23:25\",\"id\":7}', NULL, '2026-05-15 12:23:25', '2026-05-15 12:23:25'),
(93, 'Resource', 'Order Addon Created by arhan malik ', 'App\\Models\\OrderAddon', 'Created', 19, 'App\\Models\\User', 3, '{\"addon_id\":1,\"name\":\"Sound System\",\"detail\":\"Speaker aktif, mixer, dan microphone untuk kebutuhan acara.\",\"unit\":\"pcs\",\"quantity\":1,\"price\":750000,\"total_price\":750000,\"snapshot\":\"{\\\"slug\\\":\\\"sound-system\\\",\\\"image\\\":null,\\\"icon\\\":\\\"bi-speaker\\\",\\\"is_quantity_based\\\":true}\",\"order_id\":7,\"updated_at\":\"2026-05-15 12:23:25\",\"created_at\":\"2026-05-15 12:23:25\",\"id\":19}', NULL, '2026-05-15 12:23:25', '2026-05-15 12:23:25'),
(94, 'Resource', 'Order Updated by arhan malik ', 'App\\Models\\Order', 'Updated', 7, 'App\\Models\\User', 3, '{\"payment_status\":\"pending\",\"updated_at\":\"2026-05-15 12:23:34\"}', NULL, '2026-05-15 12:23:34', '2026-05-15 12:23:34'),
(95, 'Resource', 'Order Updated by arhan malik ', 'App\\Models\\Order', 'Updated', 7, 'App\\Models\\User', 3, '{\"status\":\"confirmed\",\"payment_status\":\"paid\",\"paid_at\":\"2026-05-15 12:23:47\",\"confirmed_at\":\"2026-05-15 12:23:47\",\"updated_at\":\"2026-05-15 12:23:47\"}', NULL, '2026-05-15 12:23:47', '2026-05-15 12:23:47'),
(96, 'Access', 'Admin logged in', 'App\\Models\\User', 'Login', 1, 'App\\Models\\User', 1, '{\"ip\":\"192.168.64.1\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/148.0.0.0 Safari\\/537.36\"}', NULL, '2026-05-15 13:51:54', '2026-05-15 13:51:54'),
(97, 'Resource', 'Custom Item Updated by Admin', 'App\\Models\\CustomItem', 'Updated', 2, 'App\\Models\\User', 1, '{\"max_quantity\":20,\"image\":null,\"updated_at\":\"2026-05-15 13:52:22\"}', NULL, '2026-05-15 13:52:22', '2026-05-15 13:52:22'),
(98, 'Resource', 'User Created', 'App\\Models\\User', 'Created', 6, NULL, NULL, '{\"name\":\"Muhamad Darlan\",\"email\":\"muhamaddarlan76@gmail.com\",\"phone\":\"088289258764\",\"whatsapp\":\"088289258764\",\"updated_at\":\"2026-05-15 13:56:43\",\"created_at\":\"2026-05-15 13:56:43\",\"id\":6}', NULL, '2026-05-15 13:56:43', '2026-05-15 13:56:43'),
(99, 'Access', 'Muhamad Darlan logged in', 'App\\Models\\User', 'Login', 6, 'App\\Models\\User', 6, '{\"ip\":\"192.168.64.1\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/148.0.0.0 Safari\\/537.36 Edg\\/148.0.0.0\"}', NULL, '2026-05-15 13:56:43', '2026-05-15 13:56:43'),
(100, 'Access', 'Muhamad Darlan logged in', 'App\\Models\\User', 'Login', 6, 'App\\Models\\User', 6, '{\"ip\":\"192.168.64.1\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/148.0.0.0 Safari\\/537.36 Edg\\/148.0.0.0\"}', NULL, '2026-05-15 13:59:10', '2026-05-15 13:59:10'),
(101, 'Resource', 'Addon Updated by Muhamad Darlan', 'App\\Models\\Addon', 'Updated', 1, 'App\\Models\\User', 6, '{\"stock\":4}', NULL, '2026-05-15 14:01:08', '2026-05-15 14:01:08'),
(102, 'Resource', 'Addon Updated by Muhamad Darlan', 'App\\Models\\Addon', 'Updated', 2, 'App\\Models\\User', 6, '{\"stock\":5}', NULL, '2026-05-15 14:01:08', '2026-05-15 14:01:08'),
(103, 'Resource', 'Addon Updated by Muhamad Darlan', 'App\\Models\\Addon', 'Updated', 3, 'App\\Models\\User', 6, '{\"stock\":0}', NULL, '2026-05-15 14:01:08', '2026-05-15 14:01:08'),
(104, 'Resource', 'Order Created by Muhamad Darlan', 'App\\Models\\Order', 'Created', 8, 'App\\Models\\User', 6, '{\"invoice_number\":\"INV\\/2026\\/0008-MRPN\",\"user_id\":6,\"package_id\":5,\"order_type\":\"package\",\"customer_name\":\"Muhamad Darlan\",\"customer_phone\":\"088289258764\",\"customer_email\":\"muhamaddarlan76@gmail.com\",\"event_date\":\"2026-05-22 00:00:00\",\"event_location_name\":\"gedung serbaguna tangerang\",\"event_address\":\"Universitas Esa Unggul, Jalan Inspeksi BKT, RW 03, Ujung Menteng, Cilincing, Jakarta Utara, Pusakarakyat, Kab Bekasi, Jawa Barat, Jawa, 17214, Indonesia\",\"event_latitude\":\"-6.1582481\",\"event_longitude\":\"106.9728742\",\"distance_km\":68.13,\"shipping_fee\":490000,\"subtotal_package\":12000000,\"subtotal_custom\":0,\"subtotal_addons\":2450000,\"total_price\":14940000,\"status\":\"waiting_payment\",\"payment_status\":\"unpaid\",\"payment_deadline\":\"2026-05-16 14:01:08\",\"notes\":null,\"updated_at\":\"2026-05-15 14:01:08\",\"created_at\":\"2026-05-15 14:01:08\",\"id\":8}', NULL, '2026-05-15 14:01:08', '2026-05-15 14:01:08'),
(105, 'Resource', 'Order Item Created by Muhamad Darlan', 'App\\Models\\OrderItem', 'Created', 8, 'App\\Models\\User', 6, '{\"item_type\":\"package\",\"source_id\":5,\"name\":\"Paket Tenda Akbar\",\"unit\":\"paket\",\"quantity\":1,\"price\":12000000,\"total_price\":12000000,\"snapshot\":\"{\\\"id\\\":5,\\\"slug\\\":\\\"paket-tenda-akbar\\\",\\\"name\\\":\\\"Paket Tenda Akbar\\\",\\\"price\\\":12000000,\\\"price_unit\\\":\\\"paket\\\",\\\"main_image\\\":\\\"https:\\\\\\/\\\\\\/placehold.co\\\\\\/800x500\\\\\\/e67e22\\\\\\/ffffff?text=Paket+Tenda+Akbar\\\",\\\"short_description\\\":\\\"Paket tenda besar untuk acara outdoor dan acara skala besar.\\\"}\",\"order_id\":8,\"updated_at\":\"2026-05-15 14:01:08\",\"created_at\":\"2026-05-15 14:01:08\",\"id\":8}', NULL, '2026-05-15 14:01:08', '2026-05-15 14:01:08'),
(106, 'Resource', 'Order Addon Created by Muhamad Darlan', 'App\\Models\\OrderAddon', 'Created', 20, 'App\\Models\\User', 6, '{\"addon_id\":1,\"name\":\"Sound System\",\"detail\":\"Speaker aktif, mixer, dan microphone untuk kebutuhan acara.\",\"unit\":\"pcs\",\"quantity\":1,\"price\":750000,\"total_price\":750000,\"snapshot\":\"{\\\"slug\\\":\\\"sound-system\\\",\\\"image\\\":null,\\\"icon\\\":\\\"bi-speaker\\\",\\\"is_quantity_based\\\":true}\",\"order_id\":8,\"updated_at\":\"2026-05-15 14:01:08\",\"created_at\":\"2026-05-15 14:01:08\",\"id\":20}', NULL, '2026-05-15 14:01:08', '2026-05-15 14:01:08'),
(107, 'Resource', 'Order Addon Created by Muhamad Darlan', 'App\\Models\\OrderAddon', 'Created', 21, 'App\\Models\\User', 6, '{\"addon_id\":2,\"name\":\"Lighting Dekorasi\",\"detail\":\"Lampu dekorasi untuk mempercantik area acara.\",\"unit\":\"set\",\"quantity\":1,\"price\":500000,\"total_price\":500000,\"snapshot\":\"{\\\"slug\\\":\\\"lighting-dekorasi\\\",\\\"image\\\":\\\"https:\\\\\\/\\\\\\/placehold.co\\\\\\/600x400\\\\\\/f1c40f\\\\\\/000000?text=Lighting\\\",\\\"icon\\\":\\\"bi-lightbulb\\\",\\\"is_quantity_based\\\":true}\",\"order_id\":8,\"updated_at\":\"2026-05-15 14:01:08\",\"created_at\":\"2026-05-15 14:01:08\",\"id\":21}', NULL, '2026-05-15 14:01:08', '2026-05-15 14:01:08'),
(108, 'Resource', 'Order Addon Created by Muhamad Darlan', 'App\\Models\\OrderAddon', 'Created', 22, 'App\\Models\\User', 6, '{\"addon_id\":3,\"name\":\"Photobooth\",\"detail\":\"Area foto dekoratif untuk tamu undangan.\",\"unit\":\"set\",\"quantity\":1,\"price\":1200000,\"total_price\":1200000,\"snapshot\":\"{\\\"slug\\\":\\\"photobooth\\\",\\\"image\\\":\\\"https:\\\\\\/\\\\\\/placehold.co\\\\\\/600x400\\\\\\/9b59b6\\\\\\/ffffff?text=Photobooth\\\",\\\"icon\\\":\\\"bi-camera\\\",\\\"is_quantity_based\\\":true}\",\"order_id\":8,\"updated_at\":\"2026-05-15 14:01:08\",\"created_at\":\"2026-05-15 14:01:08\",\"id\":22}', NULL, '2026-05-15 14:01:08', '2026-05-15 14:01:08'),
(109, 'Resource', 'Order Updated by Muhamad Darlan', 'App\\Models\\Order', 'Updated', 8, 'App\\Models\\User', 6, '{\"payment_status\":\"pending\",\"updated_at\":\"2026-05-15 14:01:13\"}', NULL, '2026-05-15 14:01:13', '2026-05-15 14:01:13'),
(110, 'Resource', 'Order Updated by Muhamad Darlan', 'App\\Models\\Order', 'Updated', 8, 'App\\Models\\User', 6, '{\"status\":\"confirmed\",\"payment_status\":\"paid\",\"paid_at\":\"2026-05-15 14:03:05\",\"confirmed_at\":\"2026-05-15 14:03:05\",\"updated_at\":\"2026-05-15 14:03:05\"}', NULL, '2026-05-15 14:03:05', '2026-05-15 14:03:05'),
(111, 'Access', 'Admin logged in', 'App\\Models\\User', 'Login', 1, 'App\\Models\\User', 1, '{\"ip\":\"192.168.64.1\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/148.0.0.0 Safari\\/537.36\"}', NULL, '2026-05-15 14:07:28', '2026-05-15 14:07:28'),
(112, 'Access', 'Admin logged in', 'App\\Models\\User', 'Login', 1, 'App\\Models\\User', 1, '{\"ip\":\"192.168.64.1\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/148.0.0.0 Safari\\/537.36 Edg\\/148.0.0.0\"}', NULL, '2026-05-15 14:08:25', '2026-05-15 14:08:25'),
(113, 'Resource', 'Order Created by Admin', 'App\\Models\\Order', 'Created', 9, 'App\\Models\\User', 1, '{\"invoice_number\":\"INV\\/2026\\/0009-E9SH\",\"user_id\":1,\"package_id\":null,\"order_type\":\"custom\",\"customer_name\":\"Admin\",\"customer_phone\":\"088289258764\",\"customer_email\":\"admin@admin.com\",\"event_date\":\"2026-05-27 00:00:00\",\"event_location_name\":\"gedung serbaguna tangerang\",\"event_address\":\"Esa Unggul University, Jalan Arjuna Utara, RW 02, Duri Kepa, Kebon Jeruk, West Jakarta, Special Capital Region of Jakarta, Java, 11430, Indonesia\",\"event_latitude\":\"-6.1856846\",\"event_longitude\":\"106.7789088\",\"distance_km\":39.88,\"shipping_fee\":150000,\"subtotal_package\":0,\"subtotal_custom\":1050000,\"subtotal_addons\":0,\"total_price\":1200000,\"status\":\"waiting_payment\",\"payment_status\":\"unpaid\",\"payment_deadline\":\"2026-05-16 14:16:38\",\"notes\":null,\"updated_at\":\"2026-05-15 14:16:38\",\"created_at\":\"2026-05-15 14:16:38\",\"id\":9}', NULL, '2026-05-15 14:16:38', '2026-05-15 14:16:38'),
(114, 'Resource', 'Order Item Created by Admin', 'App\\Models\\OrderItem', 'Created', 9, 'App\\Models\\User', 1, '{\"item_type\":\"custom\",\"source_id\":1,\"name\":\"Tenda Per Meter\",\"unit\":\"meter\",\"quantity\":14,\"price\":75000,\"total_price\":1050000,\"snapshot\":\"{\\\"slug\\\":\\\"tenda-per-meter\\\",\\\"image\\\":\\\"https:\\\\\\/\\\\\\/placehold.co\\\\\\/600x400\\\\\\/2c7be5\\\\\\/ffffff?text=Tenda+Per+Meter\\\",\\\"icon\\\":\\\"bi-house\\\",\\\"unit\\\":\\\"meter\\\"}\",\"order_id\":9,\"updated_at\":\"2026-05-15 14:16:38\",\"created_at\":\"2026-05-15 14:16:38\",\"id\":9}', NULL, '2026-05-15 14:16:38', '2026-05-15 14:16:38'),
(115, 'Resource', 'Order Updated by Admin', 'App\\Models\\Order', 'Updated', 9, 'App\\Models\\User', 1, '{\"payment_status\":\"pending\",\"updated_at\":\"2026-05-15 14:16:44\"}', NULL, '2026-05-15 14:16:44', '2026-05-15 14:16:44'),
(116, 'Resource', 'Order Updated by Admin', 'App\\Models\\Order', 'Updated', 9, 'App\\Models\\User', 1, '{\"status\":\"confirmed\",\"payment_status\":\"paid\",\"paid_at\":\"2026-05-15 14:19:01\",\"confirmed_at\":\"2026-05-15 14:19:01\",\"updated_at\":\"2026-05-15 14:19:01\"}', NULL, '2026-05-15 14:19:01', '2026-05-15 14:19:01'),
(117, 'Access', 'arhan malik  logged in', 'App\\Models\\User', 'Login', 3, 'App\\Models\\User', 3, '{\"ip\":\"192.168.64.1\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/148.0.0.0 Safari\\/537.36\"}', NULL, '2026-05-18 18:40:15', '2026-05-18 18:40:15'),
(118, 'Resource', 'Order Created by arhan malik ', 'App\\Models\\Order', 'Created', 10, 'App\\Models\\User', 3, '{\"invoice_number\":\"INV\\/2026\\/0010-MDXD\",\"user_id\":3,\"package_id\":1,\"order_type\":\"package\",\"customer_name\":\"athar suki\",\"customer_phone\":\"082122222222\",\"customer_email\":\"arhanmcz@gmail.com\",\"event_date\":\"2026-05-19 00:00:00\",\"event_location_name\":\"test\",\"event_address\":\"Universitas Esa Unggul, Jalan Arjuna Utara, RW 02, Duri Kepa, Kebon Jeruk, Jakarta Barat, Daerah Khusus Ibukota Jakarta, Jawa, 11430, Indonesia\",\"event_latitude\":\"-6.1856846\",\"event_longitude\":\"106.7789088\",\"distance_km\":39.68,\"shipping_fee\":200000,\"subtotal_package\":15000000,\"subtotal_custom\":0,\"subtotal_addons\":0,\"total_price\":15200000,\"status\":\"waiting_payment\",\"payment_status\":\"unpaid\",\"payment_deadline\":\"2026-05-19 18:49:52\",\"notes\":null,\"updated_at\":\"2026-05-18 18:49:52\",\"created_at\":\"2026-05-18 18:49:52\",\"id\":10}', NULL, '2026-05-18 18:49:52', '2026-05-18 18:49:52'),
(119, 'Resource', 'Order Item Created by arhan malik ', 'App\\Models\\OrderItem', 'Created', 10, 'App\\Models\\User', 3, '{\"item_type\":\"package\",\"source_id\":1,\"name\":\"Paket Wedding Premium\",\"unit\":\"paket\",\"quantity\":1,\"price\":15000000,\"total_price\":15000000,\"snapshot\":\"{\\\"id\\\":1,\\\"slug\\\":\\\"paket-wedding-premium\\\",\\\"name\\\":\\\"Paket Wedding Premium\\\",\\\"price\\\":15000000,\\\"price_unit\\\":\\\"paket\\\",\\\"main_image\\\":\\\"packages\\\\\\/main\\\\\\/01KQJC5FAAV75D9A575Y96J1D6.jpg\\\",\\\"short_description\\\":\\\"Paket dekorasi pernikahan lengkap untuk acara resepsi besar.\\\"}\",\"order_id\":10,\"updated_at\":\"2026-05-18 18:49:52\",\"created_at\":\"2026-05-18 18:49:52\",\"id\":10}', NULL, '2026-05-18 18:49:52', '2026-05-18 18:49:52'),
(120, 'Resource', 'Order Updated by arhan malik ', 'App\\Models\\Order', 'Updated', 10, 'App\\Models\\User', 3, '{\"payment_status\":\"pending\",\"updated_at\":\"2026-05-18 18:49:59\"}', NULL, '2026-05-18 18:49:59', '2026-05-18 18:49:59'),
(121, 'Resource', 'Order Updated by arhan malik ', 'App\\Models\\Order', 'Updated', 10, 'App\\Models\\User', 3, '{\"status\":\"confirmed\",\"payment_status\":\"paid\",\"paid_at\":\"2026-05-18 18:50:12\",\"confirmed_at\":\"2026-05-18 18:50:12\",\"updated_at\":\"2026-05-18 18:50:12\"}', NULL, '2026-05-18 18:50:12', '2026-05-18 18:50:12'),
(122, 'Resource', 'Addon Updated by arhan malik ', 'App\\Models\\Addon', 'Updated', 6, 'App\\Models\\User', 3, '{\"stock\":10}', NULL, '2026-05-18 18:51:22', '2026-05-18 18:51:22'),
(123, 'Resource', 'Order Created by arhan malik ', 'App\\Models\\Order', 'Created', 11, 'App\\Models\\User', 3, '{\"invoice_number\":\"INV\\/2026\\/0011-D33K\",\"user_id\":3,\"package_id\":2,\"order_type\":\"package\",\"customer_name\":\"FATHAN SUKI\",\"customer_phone\":\"082233333333\",\"customer_email\":\"arhanmcz@gmail.com\",\"event_date\":\"2026-05-19 00:00:00\",\"event_location_name\":\"test\",\"event_address\":\"Universitas Esa Unggul, Jalan Inspeksi BKT, RW 03, Ujung Menteng, Cilincing, Jakarta Utara, Pusakarakyat, Kab Bekasi, Jawa Barat, Jawa, 17214, Indonesia\",\"event_latitude\":\"-6.1582481\",\"event_longitude\":\"106.9728742\",\"distance_km\":68.13,\"shipping_fee\":490000,\"subtotal_package\":9500000,\"subtotal_custom\":0,\"subtotal_addons\":1200000,\"total_price\":11190000,\"status\":\"waiting_payment\",\"payment_status\":\"unpaid\",\"payment_deadline\":\"2026-05-19 18:51:22\",\"notes\":null,\"updated_at\":\"2026-05-18 18:51:22\",\"created_at\":\"2026-05-18 18:51:22\",\"id\":11}', NULL, '2026-05-18 18:51:22', '2026-05-18 18:51:22'),
(124, 'Resource', 'Order Item Created by arhan malik ', 'App\\Models\\OrderItem', 'Created', 11, 'App\\Models\\User', 3, '{\"item_type\":\"package\",\"source_id\":2,\"name\":\"Paket Wedding Standar\",\"unit\":\"paket\",\"quantity\":1,\"price\":9500000,\"total_price\":9500000,\"snapshot\":\"{\\\"id\\\":2,\\\"slug\\\":\\\"paket-wedding-standar\\\",\\\"name\\\":\\\"Paket Wedding Standar\\\",\\\"price\\\":9500000,\\\"price_unit\\\":\\\"paket\\\",\\\"main_image\\\":\\\"https:\\\\\\/\\\\\\/placehold.co\\\\\\/800x500\\\\\\/3498db\\\\\\/ffffff?text=Paket+Wedding+Standar\\\",\\\"short_description\\\":\\\"Paket dekorasi pernikahan standar untuk acara keluarga.\\\"}\",\"order_id\":11,\"updated_at\":\"2026-05-18 18:51:22\",\"created_at\":\"2026-05-18 18:51:22\",\"id\":11}', NULL, '2026-05-18 18:51:22', '2026-05-18 18:51:22'),
(125, 'Resource', 'Order Addon Created by arhan malik ', 'App\\Models\\OrderAddon', 'Created', 23, 'App\\Models\\User', 3, '{\"addon_id\":6,\"name\":\"Kipas Blower\",\"detail\":\"Kipas blower untuk area tenda agar lebih nyaman.\",\"unit\":\"pcs\",\"quantity\":8,\"price\":150000,\"total_price\":1200000,\"snapshot\":\"{\\\"slug\\\":\\\"kipas-blower\\\",\\\"image\\\":null,\\\"icon\\\":\\\"bi-wind\\\",\\\"is_quantity_based\\\":true}\",\"order_id\":11,\"updated_at\":\"2026-05-18 18:51:22\",\"created_at\":\"2026-05-18 18:51:22\",\"id\":23}', NULL, '2026-05-18 18:51:22', '2026-05-18 18:51:22'),
(126, 'Resource', 'Order Updated by arhan malik ', 'App\\Models\\Order', 'Updated', 11, 'App\\Models\\User', 3, '{\"payment_status\":\"pending\",\"updated_at\":\"2026-05-18 18:51:28\"}', NULL, '2026-05-18 18:51:28', '2026-05-18 18:51:28'),
(127, 'Resource', 'Order Updated by arhan malik ', 'App\\Models\\Order', 'Updated', 11, 'App\\Models\\User', 3, '{\"status\":\"confirmed\",\"payment_status\":\"paid\",\"paid_at\":\"2026-05-18 18:51:43\",\"confirmed_at\":\"2026-05-18 18:51:43\",\"updated_at\":\"2026-05-18 18:51:43\"}', NULL, '2026-05-18 18:51:43', '2026-05-18 18:51:43'),
(128, 'Resource', 'Addon Updated by arhan malik ', 'App\\Models\\Addon', 'Updated', 5, 'App\\Models\\User', 3, '{\"stock\":2}', NULL, '2026-05-18 18:53:41', '2026-05-18 18:53:41'),
(129, 'Resource', 'Order Created by arhan malik ', 'App\\Models\\Order', 'Created', 12, 'App\\Models\\User', 3, '{\"invoice_number\":\"INV\\/2026\\/0012-GE4R\",\"user_id\":3,\"package_id\":3,\"order_type\":\"package\",\"customer_name\":\"DARLAN SUKI\",\"customer_phone\":\"089909999999\",\"customer_email\":\"arhanmcz@gmail.com\",\"event_date\":\"2026-05-19 00:00:00\",\"event_location_name\":\"test\",\"event_address\":\"Jalan Krama Yudha Kampung Petukangan, RW 05, Rawa Terate, Cakung, Jakarta Timur, Daerah Khusus Ibukota Jakarta, Jawa, 13920, Indonesia\",\"event_latitude\":\"-6.1798055\",\"event_longitude\":\"106.9221190\",\"distance_km\":58.18,\"shipping_fee\":390000,\"subtotal_package\":4500000,\"subtotal_custom\":0,\"subtotal_addons\":1000000,\"total_price\":5890000,\"status\":\"waiting_payment\",\"payment_status\":\"unpaid\",\"payment_deadline\":\"2026-05-19 18:53:41\",\"notes\":null,\"updated_at\":\"2026-05-18 18:53:41\",\"created_at\":\"2026-05-18 18:53:41\",\"id\":12}', NULL, '2026-05-18 18:53:41', '2026-05-18 18:53:41'),
(130, 'Resource', 'Order Item Created by arhan malik ', 'App\\Models\\OrderItem', 'Created', 12, 'App\\Models\\User', 3, '{\"item_type\":\"package\",\"source_id\":3,\"name\":\"Paket Lamaran\",\"unit\":\"paket\",\"quantity\":1,\"price\":4500000,\"total_price\":4500000,\"snapshot\":\"{\\\"id\\\":3,\\\"slug\\\":\\\"paket-lamaran\\\",\\\"name\\\":\\\"Paket Lamaran\\\",\\\"price\\\":4500000,\\\"price_unit\\\":\\\"paket\\\",\\\"main_image\\\":\\\"https:\\\\\\/\\\\\\/placehold.co\\\\\\/800x500\\\\\\/9b59b6\\\\\\/ffffff?text=Paket+Lamaran\\\",\\\"short_description\\\":\\\"Paket dekorasi untuk acara lamaran dan pertunangan.\\\"}\",\"order_id\":12,\"updated_at\":\"2026-05-18 18:53:41\",\"created_at\":\"2026-05-18 18:53:41\",\"id\":12}', NULL, '2026-05-18 18:53:41', '2026-05-18 18:53:41'),
(131, 'Resource', 'Order Addon Created by arhan malik ', 'App\\Models\\OrderAddon', 'Created', 24, 'App\\Models\\User', 3, '{\"addon_id\":5,\"name\":\"Genset\",\"detail\":\"Genset cadangan listrik untuk acara outdoor.\",\"unit\":\"pcs\",\"quantity\":1,\"price\":1000000,\"total_price\":1000000,\"snapshot\":\"{\\\"slug\\\":\\\"genset\\\",\\\"image\\\":null,\\\"icon\\\":\\\"bi-lightning-charge\\\",\\\"is_quantity_based\\\":true}\",\"order_id\":12,\"updated_at\":\"2026-05-18 18:53:41\",\"created_at\":\"2026-05-18 18:53:41\",\"id\":24}', NULL, '2026-05-18 18:53:41', '2026-05-18 18:53:41'),
(132, 'Resource', 'Order Updated by arhan malik ', 'App\\Models\\Order', 'Updated', 12, 'App\\Models\\User', 3, '{\"payment_status\":\"pending\",\"updated_at\":\"2026-05-18 18:53:46\"}', NULL, '2026-05-18 18:53:46', '2026-05-18 18:53:46'),
(133, 'Resource', 'Order Updated by arhan malik ', 'App\\Models\\Order', 'Updated', 12, 'App\\Models\\User', 3, '{\"status\":\"confirmed\",\"payment_status\":\"paid\",\"paid_at\":\"2026-05-18 18:53:59\",\"confirmed_at\":\"2026-05-18 18:53:59\",\"updated_at\":\"2026-05-18 18:53:59\"}', NULL, '2026-05-18 18:53:59', '2026-05-18 18:53:59'),
(134, 'Access', 'Admin logged in', 'App\\Models\\User', 'Login', 1, 'App\\Models\\User', 1, '{\"ip\":\"192.168.64.1\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/148.0.0.0 Safari\\/537.36\"}', NULL, '2026-05-19 07:18:46', '2026-05-19 07:18:46'),
(135, 'Access', 'ARHAN MALIK ALRASYID logged in', 'App\\Models\\User', 'Login', 2, 'App\\Models\\User', 2, '{\"ip\":\"192.168.64.1\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/148.0.0.0 Safari\\/537.36\"}', NULL, '2026-05-19 07:24:19', '2026-05-19 07:24:19'),
(136, 'Access', 'Admin logged in', 'App\\Models\\User', 'Login', 1, 'App\\Models\\User', 1, '{\"ip\":\"192.168.64.1\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/148.0.0.0 Safari\\/537.36\"}', NULL, '2026-05-19 07:34:50', '2026-05-19 07:34:50'),
(137, 'Access', 'ARHAN MALIK ALRASYID logged in', 'App\\Models\\User', 'Login', 2, 'App\\Models\\User', 2, '{\"ip\":\"192.168.64.1\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/148.0.0.0 Safari\\/537.36\"}', NULL, '2026-05-19 07:37:57', '2026-05-19 07:37:57'),
(138, 'Access', 'Admin logged in', 'App\\Models\\User', 'Login', 1, 'App\\Models\\User', 1, '{\"ip\":\"192.168.64.1\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/148.0.0.0 Safari\\/537.36\"}', NULL, '2026-05-19 07:50:25', '2026-05-19 07:50:25'),
(139, 'Access', 'Admin logged in', 'App\\Models\\User', 'Login', 1, 'App\\Models\\User', 1, '{\"ip\":\"192.168.64.1\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/148.0.0.0 Safari\\/537.36 Edg\\/148.0.0.0\"}', NULL, '2026-05-21 20:09:08', '2026-05-21 20:09:08'),
(140, 'Resource', 'Galery Updated by Admin', 'App\\Models\\Galery', 'Updated', 1, 'App\\Models\\User', 1, '{\"image\":null,\"updated_at\":\"2026-05-21 20:14:07\"}', NULL, '2026-05-21 20:14:07', '2026-05-21 20:14:07'),
(141, 'Resource', 'Galery Updated by Admin', 'App\\Models\\Galery', 'Updated', 1, 'App\\Models\\User', 1, '{\"title\":\"Pelaminan Minimalis\",\"image\":\"galeries\\/01KS5B29G7X444JE0C6PEESA96.jpg\",\"updated_at\":\"2026-05-21 20:19:44\"}', NULL, '2026-05-21 20:19:44', '2026-05-21 20:19:44'),
(142, 'Resource', 'Galery Updated by Admin', 'App\\Models\\Galery', 'Updated', 2, 'App\\Models\\User', 1, '{\"image\":\"galeries\\/01KS5B3RP0MP7JAF9HJR7ZXGAX.webp\",\"updated_at\":\"2026-05-21 20:20:32\"}', NULL, '2026-05-21 20:20:32', '2026-05-21 20:20:32'),
(143, 'Resource', 'Beranda Updated by Admin', 'App\\Models\\Beranda', 'Updated', 1, 'App\\Models\\User', 1, '{\"image\":\"beranda\\/01KS5B7GG4V2V91051R5NVASNJ.jpg\",\"updated_at\":\"2026-05-21 20:22:35\"}', NULL, '2026-05-21 20:22:35', '2026-05-21 20:22:35'),
(144, 'Resource', 'Beranda Updated by Admin', 'App\\Models\\Beranda', 'Updated', 1, 'App\\Models\\User', 1, '{\"image\":\"beranda\\/01KS5DPRXQX15Z5DGD6Q5WG4Q2.jpeg\",\"updated_at\":\"2026-05-21 21:05:52\"}', NULL, '2026-05-21 21:05:52', '2026-05-21 21:05:52'),
(145, 'Access', 'Admin logged in', 'App\\Models\\User', 'Login', 1, 'App\\Models\\User', 1, '{\"ip\":\"192.168.64.1\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/148.0.0.0 Safari\\/537.36 Edg\\/148.0.0.0\"}', NULL, '2026-05-22 12:03:29', '2026-05-22 12:03:29'),
(146, 'Resource', 'Galery Updated by Admin', 'App\\Models\\Galery', 'Updated', 2, 'App\\Models\\User', 1, '{\"title\":\"pelaminan 8 meter\",\"deskripsi\":null,\"image\":\"galeries\\/01KS7152WCT0AS5D0WYN8P2XYF.jpeg\",\"updated_at\":\"2026-05-22 12:04:58\"}', NULL, '2026-05-22 12:04:58', '2026-05-22 12:04:58'),
(147, 'Resource', 'Galery Updated by Admin', 'App\\Models\\Galery', 'Updated', 2, 'App\\Models\\User', 1, '{\"image\":\"galeries\\/01KS7163BP6HKP9DKTDPEN4XYH.jpeg\",\"updated_at\":\"2026-05-22 12:05:32\"}', NULL, '2026-05-22 12:05:32', '2026-05-22 12:05:32'),
(148, 'Resource', 'Galery Updated by Admin', 'App\\Models\\Galery', 'Updated', 2, 'App\\Models\\User', 1, '{\"image\":\"galeries\\/01KS717MZ683YKJ3N3BKVY670M.jpeg\",\"updated_at\":\"2026-05-22 12:06:22\"}', NULL, '2026-05-22 12:06:22', '2026-05-22 12:06:22'),
(149, 'Access', 'Admin logged in', 'App\\Models\\User', 'Login', 1, 'App\\Models\\User', 1, '{\"ip\":\"192.168.64.1\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/148.0.0.0 Safari\\/537.36 Edg\\/148.0.0.0\"}', NULL, '2026-05-22 18:57:10', '2026-05-22 18:57:10'),
(150, 'Resource', 'Galery Created by Admin', 'App\\Models\\Galery', 'Created', 3, 'App\\Models\\User', 1, '{\"title\":null,\"deskripsi\":null,\"image\":\"galeries\\/01KS7SDWA8B1T83QK1M1CSADQJ.jpeg\",\"updated_at\":\"2026-05-22 19:09:12\",\"created_at\":\"2026-05-22 19:09:12\",\"id\":3}', NULL, '2026-05-22 19:09:12', '2026-05-22 19:09:12'),
(151, 'Resource', 'Galery Updated by Admin', 'App\\Models\\Galery', 'Updated', 2, 'App\\Models\\User', 1, '{\"image\":\"galeries\\/01KS7SFGMX22V2J5P3ZAHGQQ8F.jpeg\",\"updated_at\":\"2026-05-22 19:10:06\"}', NULL, '2026-05-22 19:10:06', '2026-05-22 19:10:06'),
(152, 'Resource', 'Galery Updated by Admin', 'App\\Models\\Galery', 'Updated', 3, 'App\\Models\\User', 1, '{\"title\":\"Pelaminan dengan lebar 7 meter premium\",\"updated_at\":\"2026-05-22 19:11:15\"}', NULL, '2026-05-22 19:11:15', '2026-05-22 19:11:15'),
(153, 'Resource', 'Galery Updated by Admin', 'App\\Models\\Galery', 'Updated', 3, 'App\\Models\\User', 1, '{\"title\":\"Pelaminan dengan lebar 5 meter Minimalis\",\"image\":\"galeries\\/01KS7SK59Q88WHKMJFNH8272K3.jpeg\",\"updated_at\":\"2026-05-22 19:12:05\"}', NULL, '2026-05-22 19:12:05', '2026-05-22 19:12:05'),
(154, 'Resource', 'Custom Item Updated by Admin', 'App\\Models\\CustomItem', 'Updated', 1, 'App\\Models\\User', 1, '{\"name\":\"Tenda Per Meter\\u00b2\",\"slug\":\"tenda-per-meter2\",\"price\":60000,\"min_quantity\":30,\"max_quantity\":600,\"image\":\"custom-items\\/01KS7SYA1V632VZYFD5R6BW46Z.jpeg\",\"updated_at\":\"2026-05-22 19:18:11\"}', NULL, '2026-05-22 19:18:11', '2026-05-22 19:18:11'),
(155, 'Resource', 'Custom Item Updated by Admin', 'App\\Models\\CustomItem', 'Updated', 1, 'App\\Models\\User', 1, '{\"icon\":null,\"updated_at\":\"2026-05-22 19:19:21\"}', NULL, '2026-05-22 19:19:21', '2026-05-22 19:19:21'),
(156, 'Resource', 'Custom Item Updated by Admin', 'App\\Models\\CustomItem', 'Updated', 1, 'App\\Models\\User', 1, '{\"image\":\"custom-items\\/01KS7T1JX8RX654BDBFH6PTB69.jpeg\",\"updated_at\":\"2026-05-22 19:19:58\"}', NULL, '2026-05-22 19:19:58', '2026-05-22 19:19:58'),
(157, 'Resource', 'Galery Updated by Admin', 'App\\Models\\Galery', 'Updated', 2, 'App\\Models\\User', 1, '{\"title\":\"pelaminan 8 meter Premium\",\"updated_at\":\"2026-05-22 19:24:03\"}', NULL, '2026-05-22 19:24:03', '2026-05-22 19:24:03'),
(158, 'Access', 'Admin logged in', 'App\\Models\\User', 'Login', 1, 'App\\Models\\User', 1, '{\"ip\":\"192.168.64.1\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/148.0.0.0 Safari\\/537.36\"}', NULL, '2026-05-22 19:24:09', '2026-05-22 19:24:09'),
(159, 'Resource', 'Galery Updated by Admin', 'App\\Models\\Galery', 'Updated', 1, 'App\\Models\\User', 1, '{\"title\":\"Pelaminan Minimalis 8 Meter\",\"updated_at\":\"2026-05-22 19:24:32\"}', NULL, '2026-05-22 19:24:32', '2026-05-22 19:24:32'),
(160, 'Resource', 'Custom Item Updated by Admin', 'App\\Models\\CustomItem', 'Updated', 1, 'App\\Models\\User', 1, '{\"icon\":\"bi-speaker\",\"updated_at\":\"2026-05-22 19:24:41\"}', NULL, '2026-05-22 19:24:41', '2026-05-22 19:24:41'),
(161, 'Resource', 'Addon Updated by Admin', 'App\\Models\\Addon', 'Updated', 1, 'App\\Models\\User', 1, '{\"image\":\"addons\\/01KS7VHRGV1A12NE8C7WH9AK2V.jpeg\",\"updated_at\":\"2026-05-22 19:46:17\"}', NULL, '2026-05-22 19:46:17', '2026-05-22 19:46:17'),
(162, 'Resource', 'Addon Updated by Admin', 'App\\Models\\Addon', 'Updated', 1, 'App\\Models\\User', 1, '{\"image\":\"addons\\/01KS7XRW8SPWYX87HEK77D4923.png\",\"updated_at\":\"2026-05-22 20:25:07\"}', NULL, '2026-05-22 20:25:07', '2026-05-22 20:25:07'),
(163, 'Resource', 'Addon Updated by Admin', 'App\\Models\\Addon', 'Updated', 6, 'App\\Models\\User', 1, '{\"price\":450000,\"stock\":13,\"image\":\"addons\\/01KS7Y6RKF4BMHDFW07HX9J51J.webp\",\"updated_at\":\"2026-05-22 20:32:42\"}', NULL, '2026-05-22 20:32:42', '2026-05-22 20:32:42'),
(164, 'Resource', 'Addon Updated by Admin', 'App\\Models\\Addon', 'Updated', 6, 'App\\Models\\User', 1, '{\"image\":\"addons\\/01KS7Y7W4N2SNWSQNNB1CQSZBB.webp\",\"updated_at\":\"2026-05-22 20:33:18\"}', NULL, '2026-05-22 20:33:18', '2026-05-22 20:33:18'),
(165, 'Resource', 'Addon Updated by Admin', 'App\\Models\\Addon', 'Updated', 6, 'App\\Models\\User', 1, '{\"image\":\"addons\\/01KS7Y9JKA1A7BKWVC5XSEYJQ3.webp\",\"updated_at\":\"2026-05-22 20:34:14\"}', NULL, '2026-05-22 20:34:14', '2026-05-22 20:34:14'),
(166, 'Resource', 'Addon Updated by Admin', 'App\\Models\\Addon', 'Updated', 4, 'App\\Models\\User', 1, '{\"image\":\"addons\\/01KS7YBA1X2WMFDG0P45YTB70S.webp\",\"updated_at\":\"2026-05-22 20:35:11\"}', NULL, '2026-05-22 20:35:11', '2026-05-22 20:35:11'),
(167, 'Access', 'Admin logged in', 'App\\Models\\User', 'Login', 1, 'App\\Models\\User', 1, '{\"ip\":\"192.168.64.1\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/148.0.0.0 Safari\\/537.36 Edg\\/148.0.0.0\"}', NULL, '2026-05-23 20:13:01', '2026-05-23 20:13:01'),
(168, 'Access', 'Admin logged in', 'App\\Models\\User', 'Login', 1, 'App\\Models\\User', 1, '{\"ip\":\"192.168.64.1\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/148.0.0.0 Safari\\/537.36 Edg\\/148.0.0.0\"}', NULL, '2026-05-24 20:20:41', '2026-05-24 20:20:41'),
(169, 'Resource', 'Addon Updated by Admin', 'App\\Models\\Addon', 'Updated', 5, 'App\\Models\\User', 1, '{\"name\":\"Karpet ( Merah, Abu-Abu & biru )\",\"slug\":\"karpet-merah-abu-abu-biru\",\"detail\":\"Karpet Untuk Alas Jalan\",\"price\":15000,\"unit\":\"meter persegi\",\"stock\":700,\"image\":\"addons\\/01KSD2ZDHJHB152ETSP1NRDJ94.webp\",\"icon\":null,\"updated_at\":\"2026-05-24 20:32:16\"}', NULL, '2026-05-24 20:32:16', '2026-05-24 20:32:16'),
(170, 'Resource', 'Addon Updated by Admin', 'App\\Models\\Addon', 'Updated', 4, 'App\\Models\\User', 1, '{\"image\":\"addons\\/01KSD3SJYPZQEBVD0YS5X5WJRH.png\",\"updated_at\":\"2026-05-24 20:46:34\"}', NULL, '2026-05-24 20:46:34', '2026-05-24 20:46:34'),
(171, 'Resource', 'Addon Updated by Admin', 'App\\Models\\Addon', 'Updated', 5, 'App\\Models\\User', 1, '{\"unit\":\" meter persegi\",\"updated_at\":\"2026-05-24 20:47:42\"}', NULL, '2026-05-24 20:47:42', '2026-05-24 20:47:42'),
(172, 'Resource', 'Addon Updated by Admin', 'App\\Models\\Addon', 'Updated', 1, 'App\\Models\\User', 1, '{\"detail\":\"Speaker aktif, mixer, dan microphone untuk kebutuhan berbagai acara.\",\"price\":1000000,\"updated_at\":\"2026-05-24 21:06:52\"}', NULL, '2026-05-24 21:06:52', '2026-05-24 21:06:52'),
(173, 'Resource', 'Addon Updated by Admin', 'App\\Models\\Addon', 'Updated', 4, 'App\\Models\\User', 1, '{\"price\":2000000,\"unit\":\"unit\",\"updated_at\":\"2026-05-24 21:08:09\"}', NULL, '2026-05-24 21:08:09', '2026-05-24 21:08:09'),
(174, 'Resource', 'Addon Updated by Admin', 'App\\Models\\Addon', 'Updated', 5, 'App\\Models\\User', 1, '{\"stock\":10000,\"updated_at\":\"2026-05-24 21:08:44\"}', NULL, '2026-05-24 21:08:44', '2026-05-24 21:08:44'),
(175, 'Resource', 'Addon Updated by Admin', 'App\\Models\\Addon', 'Updated', 6, 'App\\Models\\User', 1, '{\"unit\":\"unit\",\"stock\":20,\"updated_at\":\"2026-05-24 21:09:11\"}', NULL, '2026-05-24 21:09:11', '2026-05-24 21:09:11'),
(176, 'Resource', 'Addon Updated by Admin', 'App\\Models\\Addon', 'Updated', 2, 'App\\Models\\User', 1, '{\"name\":\"lampu Gantung besar berabgai model\",\"slug\":\"lampu-gantung-besar-berabgai-model\",\"price\":750000,\"stock\":8,\"image\":null,\"updated_at\":\"2026-05-24 21:09:56\"}', NULL, '2026-05-24 21:09:56', '2026-05-24 21:09:56'),
(177, 'Resource', 'Addon Updated by Admin', 'App\\Models\\Addon', 'Updated', 2, 'App\\Models\\User', 1, '{\"image\":\"addons\\/01KSD54TM5YWJTMGHWVR47H4P2.avif\",\"updated_at\":\"2026-05-24 21:10:11\"}', NULL, '2026-05-24 21:10:11', '2026-05-24 21:10:11'),
(178, 'Resource', 'Addon Updated by Admin', 'App\\Models\\Addon', 'Updated', 3, 'App\\Models\\User', 1, '{\"name\":\"Photobooth drevary 3x3 meter\",\"slug\":\"photobooth-drevary-3x3-meter\",\"stock\":5,\"image\":\"addons\\/01KSD5AVVT1Z6XKR6875QDZ74F.jpg\",\"updated_at\":\"2026-05-24 21:13:29\"}', NULL, '2026-05-24 21:13:29', '2026-05-24 21:13:29'),
(179, 'Resource', 'Addon Updated by Admin', 'App\\Models\\Addon', 'Updated', 5, 'App\\Models\\User', 1, '{\"icon\":\"bi-carpet\",\"updated_at\":\"2026-05-24 21:14:23\"}', NULL, '2026-05-24 21:14:23', '2026-05-24 21:14:23'),
(180, 'Resource', 'Addon Updated by Admin', 'App\\Models\\Addon', 'Updated', 5, 'App\\Models\\User', 1, '{\"icon\":\"bi-floor\",\"updated_at\":\"2026-05-24 21:15:15\"}', NULL, '2026-05-24 21:15:15', '2026-05-24 21:15:15'),
(181, 'Resource', 'Addon Updated by Admin', 'App\\Models\\Addon', 'Updated', 5, 'App\\Models\\User', 1, '{\"icon\":\"bi-layout-text-window\",\"updated_at\":\"2026-05-24 21:17:44\"}', NULL, '2026-05-24 21:17:44', '2026-05-24 21:17:44'),
(182, 'Resource', 'Addon Updated by Admin', 'App\\Models\\Addon', 'Updated', 5, 'App\\Models\\User', 1, '{\"icon\":\"bi-square-fill\",\"updated_at\":\"2026-05-24 21:18:20\"}', NULL, '2026-05-24 21:18:20', '2026-05-24 21:18:20'),
(183, 'Resource', 'Addon Updated by Admin', 'App\\Models\\Addon', 'Updated', 5, 'App\\Models\\User', 1, '{\"detail\":\"Karpet Untuk Alas Jalan, terhitung per meter persegi, ada berbagai pilihan warna\",\"updated_at\":\"2026-05-24 21:19:21\"}', NULL, '2026-05-24 21:19:21', '2026-05-24 21:19:21'),
(184, 'Resource', 'Addon Updated by Admin', 'App\\Models\\Addon', 'Updated', 5, 'App\\Models\\User', 1, '{\"detail\":\"karpet untuk alas jalan, terhitung per meter persegi, ada berbagai pilihan warna\",\"updated_at\":\"2026-05-24 21:19:56\"}', NULL, '2026-05-24 21:19:56', '2026-05-24 21:19:56'),
(185, 'Resource', 'Addon Updated by Admin', 'App\\Models\\Addon', 'Updated', 4, 'App\\Models\\User', 1, '{\"stock\":10,\"updated_at\":\"2026-05-24 21:20:58\"}', NULL, '2026-05-24 21:20:58', '2026-05-24 21:20:58'),
(186, 'Resource', 'User Created', 'App\\Models\\User', 'Created', 7, NULL, NULL, '{\"name\":\"Athar Arya\",\"email\":\"tar123@gmail.com\",\"phone\":\"000000000000000\",\"whatsapp\":\"000000000000000\",\"updated_at\":\"2026-05-24 23:21:43\",\"created_at\":\"2026-05-24 23:21:43\",\"id\":7}', NULL, '2026-05-24 23:21:43', '2026-05-24 23:21:43'),
(187, 'Access', 'Athar Arya logged in', 'App\\Models\\User', 'Login', 7, 'App\\Models\\User', 7, '{\"ip\":\"192.168.64.1\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/148.0.0.0 Safari\\/537.36 Edg\\/148.0.0.0\"}', NULL, '2026-05-24 23:21:43', '2026-05-24 23:21:43'),
(188, 'Access', 'Admin logged in', 'App\\Models\\User', 'Login', 1, 'App\\Models\\User', 1, '{\"ip\":\"192.168.64.1\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/148.0.0.0 Safari\\/537.36 Edg\\/148.0.0.0\"}', NULL, '2026-05-25 10:15:23', '2026-05-25 10:15:23'),
(189, 'Resource', 'Custom Item Updated by Admin', 'App\\Models\\CustomItem', 'Updated', 1, 'App\\Models\\User', 1, '{\"description\":\"Sewa tenda berdasarkan luas kebutuhan acara plus dekorasi kain dan o.\",\"min_quantity\":10,\"image\":\"custom-items\\/01KSEJ7E312CJV59T6CD05SC9C.jpeg\",\"updated_at\":\"2026-05-25 10:18:02\"}', NULL, '2026-05-25 10:18:02', '2026-05-25 10:18:02'),
(190, 'Resource', 'Custom Item Updated by Admin', 'App\\Models\\CustomItem', 'Updated', 1, 'App\\Models\\User', 1, '{\"description\":\"Sewa tenda berdasarkan luas kebutuhan acara plus dekorasi kain dan penyesuaian pernak pernik dekorasi.\",\"updated_at\":\"2026-05-25 10:19:00\"}', NULL, '2026-05-25 10:19:00', '2026-05-25 10:19:00'),
(191, 'Resource', 'Custom Item Updated by Admin', 'App\\Models\\CustomItem', 'Updated', 1, 'App\\Models\\User', 1, '{\"icon\":null,\"updated_at\":\"2026-05-25 10:19:26\"}', NULL, '2026-05-25 10:19:26', '2026-05-25 10:19:26'),
(192, 'Resource', 'Custom Item Updated by Admin', 'App\\Models\\CustomItem', 'Updated', 2, 'App\\Models\\User', 1, '{\"name\":\"Kursi Plastik\",\"slug\":\"kursi-plastik\",\"description\":\"Kursi tamu standar untuk acara plastik napolly.\",\"max_quantity\":500,\"image\":\"custom-items\\/01KSEJDASKTWPE273NR71G7YCV.webp\",\"icon\":null,\"updated_at\":\"2026-05-25 10:21:15\"}', NULL, '2026-05-25 10:21:15', '2026-05-25 10:21:15'),
(193, 'Resource', 'Custom Item Updated by Admin', 'App\\Models\\CustomItem', 'Updated', 3, 'App\\Models\\User', 1, '{\"name\":\"Meja Prasmanan atau meja tamu ( plus cover )\",\"slug\":\"meja-prasmanan-atau-meja-tamu-plus-cover\",\"description\":\"Meja untuk area hidangan dan konsumsi ukuran 1.75 meter x 1 meter \",\"price\":50000,\"min_quantity\":5,\"max_quantity\":80,\"image\":\"custom-items\\/01KSEJJCXKC5TC504G8379PXKD.webp\",\"updated_at\":\"2026-05-25 10:24:01\"}', NULL, '2026-05-25 10:24:01', '2026-05-25 10:24:01'),
(194, 'Resource', 'Custom Item Updated by Admin', 'App\\Models\\CustomItem', 'Updated', 4, 'App\\Models\\User', 1, '{\"name\":\"Kursi Lipat Stainless\",\"slug\":\"kursi-lipat-stainless\",\"description\":\"Kursi Lipat Merk Chitosse \",\"price\":10000,\"unit\":\"unit\",\"min_quantity\":50,\"max_quantity\":500,\"image\":\"custom-items\\/01KSEJNZJJB8HJGWN2XD5AZ2QH.webp\",\"icon\":null,\"updated_at\":\"2026-05-25 10:25:59\"}', NULL, '2026-05-25 10:25:59', '2026-05-25 10:25:59'),
(195, 'Resource', 'Custom Item Updated by Admin', 'App\\Models\\CustomItem', 'Updated', 3, 'App\\Models\\User', 1, '{\"name\":\"Meja Prasmanan Atau Meja Tamu ( Plus Cover )\",\"updated_at\":\"2026-05-25 10:26:53\"}', NULL, '2026-05-25 10:26:53', '2026-05-25 10:26:53'),
(196, 'Resource', 'Custom Item Updated by Admin', 'App\\Models\\CustomItem', 'Updated', 5, 'App\\Models\\User', 1, '{\"name\":\"Kursi Merah Merk Futura\",\"slug\":\"kursi-merah-merk-futura\",\"description\":\"Kursi Sofa empuk merk Futura\",\"price\":12000,\"min_quantity\":30,\"max_quantity\":400,\"image\":\"custom-items\\/01KSEJVAWB46YV2D4G8ZN3JWN5.jpg\",\"updated_at\":\"2026-05-25 10:28:54\"}', NULL, '2026-05-25 10:28:54', '2026-05-25 10:28:54'),
(197, 'Resource', 'Custom Item Updated by Admin', 'App\\Models\\CustomItem', 'Updated', 3, 'App\\Models\\User', 1, '{\"sort_order\":5,\"updated_at\":\"2026-05-25 10:29:24\"}', NULL, '2026-05-25 10:29:24', '2026-05-25 10:29:24'),
(198, 'Resource', 'Custom Item Updated by Admin', 'App\\Models\\CustomItem', 'Updated', 3, 'App\\Models\\User', 1, '{\"sort_order\":6,\"updated_at\":\"2026-05-25 10:29:41\"}', NULL, '2026-05-25 10:29:41', '2026-05-25 10:29:41'),
(199, 'Resource', 'Custom Item Updated by Admin', 'App\\Models\\CustomItem', 'Updated', 6, 'App\\Models\\User', 1, '{\"name\":\"Meja Bundar Kapassitas 5 Atau 6 Orang ( Plus Cover )\",\"slug\":\"meja-bundar-kapassitas-5-atau-6-orang-plus-cover\",\"description\":\"Meja bundar untuk acara formal, rapat dan tamu\",\"price\":50000,\"unit\":\"unit\",\"min_quantity\":20,\"max_quantity\":88,\"image\":\"custom-items\\/01KSEK488DB0TDTK0SQS88ZNAX.avif\",\"sort_order\":7,\"updated_at\":\"2026-05-25 10:33:46\"}', NULL, '2026-05-25 10:33:46', '2026-05-25 10:33:46'),
(200, 'Resource', 'Custom Item Updated by Admin', 'App\\Models\\CustomItem', 'Updated', 4, 'App\\Models\\User', 1, '{\"unit\":\"pcs\",\"updated_at\":\"2026-05-25 10:34:37\"}', NULL, '2026-05-25 10:34:37', '2026-05-25 10:34:37');

INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES
(201, 'Resource', 'Custom Item Updated by Admin', 'App\\Models\\CustomItem', 'Updated', 5, 'App\\Models\\User', 1, '{\"unit\":\"pcs\",\"updated_at\":\"2026-05-25 10:34:58\"}', NULL, '2026-05-25 10:34:58', '2026-05-25 10:34:58'),
(202, 'Resource', 'Custom Item Updated by Admin', 'App\\Models\\CustomItem', 'Updated', 6, 'App\\Models\\User', 1, '{\"unit\":\"pcs\",\"updated_at\":\"2026-05-25 10:35:20\"}', NULL, '2026-05-25 10:35:20', '2026-05-25 10:35:20'),
(203, 'Resource', 'Custom Item Deleted by Admin', 'App\\Models\\CustomItem', 'Deleted', 7, 'App\\Models\\User', 1, '[]', NULL, '2026-05-25 10:36:05', '2026-05-25 10:36:05'),
(204, 'Resource', 'Custom Item Deleted by Admin', 'App\\Models\\CustomItem', 'Deleted', 8, 'App\\Models\\User', 1, '[]', NULL, '2026-05-25 10:36:08', '2026-05-25 10:36:08'),
(205, 'Resource', 'Custom Item Updated by Admin', 'App\\Models\\CustomItem', 'Updated', 1, 'App\\Models\\User', 1, '{\"unit\":\"meter persegi\",\"image\":\"custom-items\\/01KSEKCQM647HFY6ME3381YCK4.jpeg\",\"updated_at\":\"2026-05-25 10:38:24\"}', NULL, '2026-05-25 10:38:24', '2026-05-25 10:38:24'),
(206, 'Resource', 'Custom Item Updated by Admin', 'App\\Models\\CustomItem', 'Updated', 1, 'App\\Models\\User', 1, '{\"description\":\"Sewa tenda berdasarkan luas kebutuhan acara plus dekorasi kain dan penyesuaian pernak pernik dekorasi. tersedia semua warna ( hubungi admin untuk pemilihan warna )\",\"updated_at\":\"2026-05-25 10:39:29\"}', NULL, '2026-05-25 10:39:29', '2026-05-25 10:39:29'),
(207, 'Resource', 'Addon Updated by Admin', 'App\\Models\\Addon', 'Updated', 2, 'App\\Models\\User', 1, '{\"name\":\"lampu Gantung besar berbagai model\",\"slug\":\"lampu-gantung-besar-berbagai-model\",\"updated_at\":\"2026-05-25 10:40:28\"}', NULL, '2026-05-25 10:40:28', '2026-05-25 10:40:28'),
(208, 'Resource', 'Addon Updated by Admin', 'App\\Models\\Addon', 'Updated', 2, 'App\\Models\\User', 1, '{\"unit\":\"Unit\",\"updated_at\":\"2026-05-25 10:40:43\"}', NULL, '2026-05-25 10:40:43', '2026-05-25 10:40:43'),
(209, 'Resource', 'Addon Updated by Admin', 'App\\Models\\Addon', 'Updated', 1, 'App\\Models\\User', 1, '{\"unit\":\"set\",\"updated_at\":\"2026-05-25 10:41:00\"}', NULL, '2026-05-25 10:41:00', '2026-05-25 10:41:00'),
(210, 'Resource', 'User Created', 'App\\Models\\User', 'Created', 8, NULL, NULL, '{\"name\":\"gyt\",\"email\":\"tar1234@gmail.com\",\"phone\":\"444444444232\",\"whatsapp\":\"444444444232\",\"updated_at\":\"2026-05-25 10:52:17\",\"created_at\":\"2026-05-25 10:52:17\",\"id\":8}', NULL, '2026-05-25 10:52:17', '2026-05-25 10:52:17'),
(211, 'Access', 'gyt logged in', 'App\\Models\\User', 'Login', 8, 'App\\Models\\User', 8, '{\"ip\":\"192.168.64.1\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/148.0.0.0 Safari\\/537.36 Edg\\/148.0.0.0\"}', NULL, '2026-05-25 10:52:17', '2026-05-25 10:52:17'),
(212, 'Access', 'arhan malik  logged in', 'App\\Models\\User', 'Login', 3, 'App\\Models\\User', 3, '{\"ip\":\"192.168.64.1\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/148.0.0.0 Safari\\/537.36\"}', NULL, '2026-05-25 10:54:56', '2026-05-25 10:54:56'),
(213, 'Access', 'gyt logged in', 'App\\Models\\User', 'Login', 8, 'App\\Models\\User', 8, '{\"ip\":\"192.168.64.1\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/148.0.0.0 Safari\\/537.36 Edg\\/148.0.0.0\"}', NULL, '2026-05-25 10:56:42', '2026-05-25 10:56:42'),
(214, 'Access', 'Admin logged in', 'App\\Models\\User', 'Login', 1, 'App\\Models\\User', 1, '{\"ip\":\"192.168.64.1\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/148.0.0.0 Safari\\/537.36 Edg\\/148.0.0.0\"}', NULL, '2026-05-25 13:47:32', '2026-05-25 13:47:32'),
(215, 'Access', 'arhan malik  logged in', 'App\\Models\\User', 'Login', 3, 'App\\Models\\User', 3, '{\"ip\":\"192.168.64.1\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/148.0.0.0 Safari\\/537.36\"}', NULL, '2026-05-26 11:47:12', '2026-05-26 11:47:12'),
(216, 'Access', 'Admin logged in', 'App\\Models\\User', 'Login', 1, 'App\\Models\\User', 1, '{\"ip\":\"192.168.64.1\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/148.0.0.0 Safari\\/537.36 Edg\\/148.0.0.0\"}', NULL, '2026-05-29 10:43:16', '2026-05-29 10:43:16'),
(217, 'Access', 'Admin logged in', 'App\\Models\\User', 'Login', 1, 'App\\Models\\User', 1, '{\"ip\":\"192.168.64.1\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/148.0.0.0 Safari\\/537.36 Edg\\/148.0.0.0\"}', NULL, '2026-05-30 09:26:16', '2026-05-30 09:26:16'),
(218, 'Resource', 'Package Updated by Admin', 'App\\Models\\Package', 'Updated', 1, 'App\\Models\\User', 1, '{\"name\":\"PAKET AKAT MINIMALIS RP.7.500.000\",\"slug\":\"paket-akat-minimalis-rp7500000\",\"short_description\":\"Paket lengkap pernikahan dari Decoration Kab. Tangerang yang mencakup dekorasi tenda (4\\u00d78), backdrop rumahan, make-up & busana pengantin, serta dokumentasi 6 jam. Bebas pilih warna kain dan tema backdrop. Tersedia transportasi gratis untuk area Tigaraksa \",\"description\":\"Paket Akad Minimalis \\u2014 Rp 7.500.000\\n\\nDekorasi\\n\\nTenda ukuran 4\\u00d78 lengkap dengan dekorasi kain dan lampu, 5 meja kotak, 2 meja bulat, karpet tenda, lighting tenda, kotak uang, 40 kursi dengan sarung, 1 set perasmanan minimalis, dan 100 set alat makan.\\n\\nAlat pendukung\\n\\nBlower atau kipas angin. Klien bebas memilih warna kain dan tema backdrop yang telah disediakan.\\n\\nBackdrop rumahan\\n\\nUkuran tersedia: 2\\u00d72, 3\\u00d73, atau 2\\u00d73 (disesuaikan foto dan lokasi). Termasuk backdrop rumahan, sofa\\/kursi pengantin, flower artificial, karpet, standing flower, standing foto, dan lighting backdrop.\\n\\nMake-up & busana\\n\\n1 sesi make-up, kebaya akad, beskap akad, siger atau mahkota, dan artificial melati.\\n\\nDokumentasi\\n\\n1 fotografer profesional, file dokumen disimpan dalam flashdisk, dengan durasi kerja 6 jam.\\n\\n\",\"price\":75000000,\"main_image\":null,\"images\":\"[]\",\"updated_at\":\"2026-05-30 09:35:21\"}', NULL, '2026-05-30 09:35:21', '2026-05-30 09:35:21'),
(219, 'Resource', 'Package Updated by Admin', 'App\\Models\\Package', 'Updated', 1, 'App\\Models\\User', 1, '{\"main_image\":\"packages\\/main\\/01KSVBVPT5TPD8THJE4424C5BG.webp\",\"updated_at\":\"2026-05-30 09:36:54\"}', NULL, '2026-05-30 09:36:54', '2026-05-30 09:36:54'),
(220, 'Resource', 'Package Updated by Admin', 'App\\Models\\Package', 'Updated', 1, 'App\\Models\\User', 1, '{\"main_image\":\"packages\\/main\\/01KSVBZ8SWX5G625J4D83V11D5.png\",\"updated_at\":\"2026-05-30 09:38:51\"}', NULL, '2026-05-30 09:38:51', '2026-05-30 09:38:51'),
(221, 'Resource', 'Package Deleted by Admin', 'App\\Models\\Package', 'Deleted', 1, 'App\\Models\\User', 1, '[]', NULL, '2026-05-30 09:39:51', '2026-05-30 09:39:51'),
(222, 'Resource', 'Package Deleted by Admin', 'App\\Models\\Package', 'Deleted', 2, 'App\\Models\\User', 1, '[]', NULL, '2026-05-30 09:39:54', '2026-05-30 09:39:54'),
(223, 'Resource', 'Package Deleted by Admin', 'App\\Models\\Package', 'Deleted', 3, 'App\\Models\\User', 1, '[]', NULL, '2026-05-30 09:39:58', '2026-05-30 09:39:58'),
(224, 'Resource', 'Package Deleted by Admin', 'App\\Models\\Package', 'Deleted', 4, 'App\\Models\\User', 1, '[]', NULL, '2026-05-30 09:40:00', '2026-05-30 09:40:00'),
(225, 'Resource', 'Package Deleted by Admin', 'App\\Models\\Package', 'Deleted', 5, 'App\\Models\\User', 1, '[]', NULL, '2026-05-30 09:40:03', '2026-05-30 09:40:03'),
(226, 'Resource', 'Package Deleted by Admin', 'App\\Models\\Package', 'Deleted', 7, 'App\\Models\\User', 1, '[]', NULL, '2026-05-30 09:40:06', '2026-05-30 09:40:06'),
(227, 'Resource', 'Package Created by Admin', 'App\\Models\\Package', 'Created', 8, 'App\\Models\\User', 1, '{\"name\":\"PAKET AKAT MINIMALIS RP.7.500.000\",\"slug\":\"paket-akat-minimalis-rp7500000\",\"type\":\"fixed\",\"short_description\":\"Paket lengkap pernikahan dari Decoration Kab. Tangerang yang mencakup dekorasi tenda (4\\u00d78), backdrop rumahan, make-up & busana pengantin, serta dokumentasi 6 jam. Bebas pilih warna kain dan tema backdrop. Tersedia transportasi gratis untuk area Tigaraksa \",\"description\":\"Paket Akad Minimalis \\u2014 Rp 7.500.000\\n\\nDekorasi\\n\\nTenda ukuran 4\\u00d78 lengkap dengan dekorasi kain dan lampu, 5 meja kotak, 2 meja bulat, karpet tenda, lighting tenda, kotak uang, 40 kursi dengan sarung, 1 set perasmanan minimalis, dan 100 set alat makan.\\n\\nAlat pendukung\\n\\nBlower atau kipas angin. Klien bebas memilih warna kain dan tema backdrop yang telah disediakan.\\n\\nBackdrop rumahan\\n\\nUkuran tersedia: 2\\u00d72, 3\\u00d73, atau 2\\u00d73 (disesuaikan foto dan lokasi). Termasuk backdrop rumahan, sofa\\/kursi pengantin, flower artificial, karpet, standing flower, standing foto, dan lighting backdrop.\\n\\nMake-up & busana\\n\\n1 sesi make-up, kebaya akad, beskap akad, siger atau mahkota, dan artificial melati.\\n\\nDokumentasi\\n\\n1 fotografer profesional, file dokumen disimpan dalam flashdisk, dengan durasi kerja 6 jam.\\n\\n\",\"price\":75000000,\"price_unit\":\"paket\",\"badge\":null,\"is_popular\":false,\"is_active\":true,\"sort_order\":0,\"main_image\":\"packages\\/main\\/01KSVC3DZWS1PGBKRCD9ETM31E.png\",\"images\":\"[]\",\"updated_at\":\"2026-05-30 09:41:07\",\"created_at\":\"2026-05-30 09:41:07\",\"id\":8}', NULL, '2026-05-30 09:41:07', '2026-05-30 09:41:07'),
(228, 'Resource', 'Package Updated by Admin', 'App\\Models\\Package', 'Updated', 8, 'App\\Models\\User', 1, '{\"price\":7500000,\"updated_at\":\"2026-05-30 09:41:30\"}', NULL, '2026-05-30 09:41:30', '2026-05-30 09:41:30'),
(229, 'Resource', 'Package Item Created by Admin', 'App\\Models\\PackageItem', 'Created', 29, 'App\\Models\\User', 1, '{\"package_id\":8,\"name\":\"tenda dekorasi 4x8 lengkap full dekorasi\",\"quantity\":1,\"unit\":\"set\",\"description\":null,\"sort_order\":0,\"is_active\":true,\"updated_at\":\"2026-05-30 09:48:58\",\"created_at\":\"2026-05-30 09:48:58\",\"id\":29}', NULL, '2026-05-30 09:48:58', '2026-05-30 09:48:58'),
(230, 'Resource', 'Package Item Updated by Admin', 'App\\Models\\PackageItem', 'Updated', 29, 'App\\Models\\User', 1, '{\"name\":\"Backdrop Backdrop rumahan  Ukuran tersedia: 2\\u00d72, 3\\u00d73, atau 2\\u00d73 (disesuaikan foto dan lokasi). Termasuk backdrop rumahan, sofa\\/kursi pengantin, flower artificial, karpet, standing flower, standing foto, dan lighting backdrop.\",\"updated_at\":\"2026-05-30 09:50:52\"}', NULL, '2026-05-30 09:50:52', '2026-05-30 09:50:52'),
(231, 'Resource', 'Package Item Updated by Admin', 'App\\Models\\PackageItem', 'Updated', 29, 'App\\Models\\User', 1, '{\"sort_order\":1,\"updated_at\":\"2026-05-30 09:51:07\"}', NULL, '2026-05-30 09:51:07', '2026-05-30 09:51:07'),
(232, 'Resource', 'Package Item Deleted by Admin', 'App\\Models\\PackageItem', 'Deleted', 29, 'App\\Models\\User', 1, '[]', NULL, '2026-05-30 09:51:48', '2026-05-30 09:51:48'),
(233, 'Resource', 'Package Item Created by Admin', 'App\\Models\\PackageItem', 'Created', 30, 'App\\Models\\User', 1, '{\"package_id\":8,\"name\":\"Tenda 8x4 dan Prasmaann set full dekorasi\",\"quantity\":1,\"unit\":\"unit\",\"description\":\"warna bebas pilih\",\"sort_order\":0,\"is_active\":true,\"updated_at\":\"2026-05-30 09:53:04\",\"created_at\":\"2026-05-30 09:53:04\",\"id\":30}', NULL, '2026-05-30 09:53:04', '2026-05-30 09:53:04'),
(234, 'Resource', 'Package Item Created by Admin', 'App\\Models\\PackageItem', 'Created', 31, 'App\\Models\\User', 1, '{\"package_id\":8,\"name\":\"Kipas Blower\",\"quantity\":1,\"unit\":\"unit\",\"description\":null,\"sort_order\":0,\"is_active\":true,\"updated_at\":\"2026-05-30 09:53:25\",\"created_at\":\"2026-05-30 09:53:25\",\"id\":31}', NULL, '2026-05-30 09:53:25', '2026-05-30 09:53:25'),
(235, 'Resource', 'Package Item Created by Admin', 'App\\Models\\PackageItem', 'Created', 32, 'App\\Models\\User', 1, '{\"package_id\":8,\"name\":\"Backdrop rumahan Backdrop rumahan  Ukuran tersedia: 2\\u00d72, 3\\u00d73, atau 2\\u00d73 (disesuaikan foto dan lokasi). Termasuk backdrop rumahan, sofa\\/kursi pengantin, flower artificial, karpet, standing flower, standing foto, dan lighting backdrop.\",\"quantity\":1,\"unit\":\"set\",\"description\":null,\"sort_order\":0,\"is_active\":true,\"updated_at\":\"2026-05-30 09:54:16\",\"created_at\":\"2026-05-30 09:54:16\",\"id\":32}', NULL, '2026-05-30 09:54:16', '2026-05-30 09:54:16'),
(236, 'Resource', 'Package Item Updated by Admin', 'App\\Models\\PackageItem', 'Updated', 32, 'App\\Models\\User', 1, '{\"name\":\" Backdrop rumahan  Ukuran tersedia: 2\\u00d72, 3\\u00d73, atau 2\\u00d73 (disesuaikan foto dan lokasi). Termasuk backdrop rumahan, sofa\\/kursi pengantin, flower artificial, karpet, standing flower, standing foto, dan lighting backdrop.\",\"updated_at\":\"2026-05-30 09:54:44\"}', NULL, '2026-05-30 09:54:44', '2026-05-30 09:54:44'),
(237, 'Resource', 'Package Item Updated by Admin', 'App\\Models\\PackageItem', 'Updated', 32, 'App\\Models\\User', 1, '{\"name\":\" Backdrop rumahan  Ukuran tersedia: 2\\u00d72, 3\\u00d73, atau 2\\u00d73 (disesuaikan foto dan lokasi). Termasuk sofa \\/ kursi pengantin, flower artificial, karpet, standing flower, standing foto, dan lighting backdrop.\",\"updated_at\":\"2026-05-30 09:57:27\"}', NULL, '2026-05-30 09:57:27', '2026-05-30 09:57:27'),
(238, 'Resource', 'Package Item Updated by Admin', 'App\\Models\\PackageItem', 'Updated', 32, 'App\\Models\\User', 1, '{\"name\":\" Backdrop rumahan Ukuran tersedia: 2\\u00d72, 3\\u00d73, atau 2\\u00d73 \",\"updated_at\":\"2026-05-30 09:57:50\"}', NULL, '2026-05-30 09:57:50', '2026-05-30 09:57:50'),
(239, 'Resource', 'Package Item Updated by Admin', 'App\\Models\\PackageItem', 'Updated', 32, 'App\\Models\\User', 1, '{\"name\":\" fotographer\",\"unit\":\"6 jam\",\"updated_at\":\"2026-05-30 09:58:24\"}', NULL, '2026-05-30 09:58:24', '2026-05-30 09:58:24'),
(240, 'Resource', 'Package Item Updated by Admin', 'App\\Models\\PackageItem', 'Updated', 32, 'App\\Models\\User', 1, '{\"quantity\":null,\"updated_at\":\"2026-05-30 09:58:43\"}', NULL, '2026-05-30 09:58:43', '2026-05-30 09:58:43'),
(241, 'Resource', 'Package Item Updated by Admin', 'App\\Models\\PackageItem', 'Updated', 32, 'App\\Models\\User', 1, '{\"name\":\"make up dan busana\",\"quantity\":1,\"unit\":\"1 paket\",\"description\":\"\\n\\n1 sesi make-up, kebaya akad, beskap akad, siger atau mahkota, dan artificial melati.\",\"updated_at\":\"2026-05-30 09:59:33\"}', NULL, '2026-05-30 09:59:33', '2026-05-30 09:59:33'),
(242, 'Resource', 'Package Item Updated by Admin', 'App\\Models\\PackageItem', 'Updated', 32, 'App\\Models\\User', 1, '{\"unit\":\"paket\",\"updated_at\":\"2026-05-30 09:59:53\"}', NULL, '2026-05-30 09:59:53', '2026-05-30 09:59:53'),
(243, 'Resource', 'Package Item Created by Admin', 'App\\Models\\PackageItem', 'Created', 33, 'App\\Models\\User', 1, '{\"package_id\":8,\"name\":\"Kipas Blower\",\"quantity\":1,\"unit\":\"pcs\",\"description\":null,\"sort_order\":0,\"is_active\":true,\"updated_at\":\"2026-05-30 10:00:38\",\"created_at\":\"2026-05-30 10:00:38\",\"id\":33}', NULL, '2026-05-30 10:00:38', '2026-05-30 10:00:38'),
(244, 'Resource', 'Package Created by Admin', 'App\\Models\\Package', 'Created', 9, 'App\\Models\\User', 1, '{\"name\":\"PAKET AKAD PREMIUM 9 JT\",\"slug\":\"paket-akad-premium-9-jt\",\"type\":\"fixed\",\"short_description\":\"Paket pernikahan premium dari Decoration Kab. Tangerang yang menghadirkan dekorasi mewah tenda 4\\u00d712, backdrop rumahan elegan, make-up & busana premium lengkap dengan bonus fresh melati, henna, dan softlens, serta dokumentasi 6 jam. Bebas pilih warna kain \",\"description\":\"Dekorasi\\n\\nTenda ukuran 4\\u00d712 dengan dekorasi kain dan lampu, meja prasmanan, pagar ayu, meja buah, karpet full, lighting tenda, 50 kursi dengan sarung, 1 set perasmanan, 100 set alat makan, gapura depan, dan kotak uang.\\n\\nAlat pendukung\\n\\nKipas angin atau blower. Klien bebas memilih warna kain dan tema backdrop yang telah disediakan.\\n\\nBackdrop rumahan\\n\\nUkuran tersedia: 2\\u00d72, 3\\u00d73, atau 2\\u00d73 (disesuaikan foto dan lokasi). Termasuk sofa\\/kursi pengantin, flower artificial, karpet, standing flower, standing foto, dan lighting backdrop.\\n\\nMake-up & busana premium\\n\\n1 sesi make-up, kebaya akad, beskap akad, siger\\/sulo putri\\/modern. FREE fresh melati, henna white tangan, dan softlens minus\\/normal.\\n\\nDokumentasi premium\\n\\n1 fotografer profesional, file dokumen tersimpan dalam flashdisk, dengan durasi kerja 6 jam.\",\"price\":9000000,\"price_unit\":\"paket\",\"badge\":null,\"is_popular\":false,\"is_active\":true,\"sort_order\":0,\"main_image\":\"packages\\/main\\/01KSVE2DNXZKCMWQCY302DGT4W.png\",\"images\":\"[]\",\"updated_at\":\"2026-05-30 10:15:31\",\"created_at\":\"2026-05-30 10:15:31\",\"id\":9}', NULL, '2026-05-30 10:15:31', '2026-05-30 10:15:31'),
(245, 'Resource', 'Package Updated by Admin', 'App\\Models\\Package', 'Updated', 9, 'App\\Models\\User', 1, '{\"name\":\"PAKET AKAD PREMIUM RP.9.000.000\",\"slug\":\"paket-akad-premium-rp9000000\",\"updated_at\":\"2026-05-30 10:15:54\"}', NULL, '2026-05-30 10:15:54', '2026-05-30 10:15:54'),
(246, 'Resource', 'Package Item Created by Admin', 'App\\Models\\PackageItem', 'Created', 34, 'App\\Models\\User', 1, '{\"package_id\":9,\"name\":\"tenda dekorasi 4x12 full dekorasi lengkap prasmanan set\",\"quantity\":1,\"unit\":\"set\",\"description\":null,\"sort_order\":0,\"is_active\":true,\"updated_at\":\"2026-05-30 10:16:58\",\"created_at\":\"2026-05-30 10:16:58\",\"id\":34}', NULL, '2026-05-30 10:16:58', '2026-05-30 10:16:58'),
(247, 'Resource', 'Package Item Created by Admin', 'App\\Models\\PackageItem', 'Created', 35, 'App\\Models\\User', 1, '{\"package_id\":9,\"name\":\"Kipas Blower\",\"quantity\":1,\"unit\":\"pcs\",\"description\":null,\"sort_order\":0,\"is_active\":true,\"updated_at\":\"2026-05-30 10:22:26\",\"created_at\":\"2026-05-30 10:22:26\",\"id\":35}', NULL, '2026-05-30 10:22:26', '2026-05-30 10:22:26'),
(248, 'Resource', 'Package Item Created by Admin', 'App\\Models\\PackageItem', 'Created', 36, 'App\\Models\\User', 1, '{\"package_id\":9,\"name\":\"kursi tamu \",\"quantity\":50,\"unit\":\"pcs\",\"description\":null,\"sort_order\":0,\"is_active\":true,\"updated_at\":\"2026-05-30 10:23:36\",\"created_at\":\"2026-05-30 10:23:36\",\"id\":36}', NULL, '2026-05-30 10:23:36', '2026-05-30 10:23:36'),
(249, 'Resource', 'Package Item Created by Admin', 'App\\Models\\PackageItem', 'Created', 37, 'App\\Models\\User', 1, '{\"package_id\":9,\"name\":\"backdrop rumahan 1 set\",\"quantity\":null,\"unit\":null,\"description\":null,\"sort_order\":0,\"is_active\":true,\"updated_at\":\"2026-05-30 10:24:19\",\"created_at\":\"2026-05-30 10:24:19\",\"id\":37}', NULL, '2026-05-30 10:24:19', '2026-05-30 10:24:19'),
(250, 'Resource', 'Package Item Created by Admin', 'App\\Models\\PackageItem', 'Created', 38, 'App\\Models\\User', 1, '{\"package_id\":9,\"name\":\"makeup dan busana 1xmakeup dan kebaya akad dan beskap akad\",\"quantity\":1,\"unit\":\"hari\",\"description\":null,\"sort_order\":0,\"is_active\":true,\"updated_at\":\"2026-05-30 10:25:28\",\"created_at\":\"2026-05-30 10:25:28\",\"id\":38}', NULL, '2026-05-30 10:25:28', '2026-05-30 10:25:28'),
(251, 'Resource', 'Package Item Created by Admin', 'App\\Models\\PackageItem', 'Created', 39, 'App\\Models\\User', 1, '{\"package_id\":9,\"name\":\"Dokumentasi Fotograper \",\"quantity\":4,\"unit\":\"jam\",\"description\":null,\"sort_order\":0,\"is_active\":true,\"updated_at\":\"2026-05-30 10:26:07\",\"created_at\":\"2026-05-30 10:26:07\",\"id\":39}', NULL, '2026-05-30 10:26:07', '2026-05-30 10:26:07'),
(252, 'Resource', 'Package Updated by Admin', 'App\\Models\\Package', 'Updated', 9, 'App\\Models\\User', 1, '{\"description\":\"Dekorasi\\n\\nTenda ukuran 4\\u00d712 dengan dekorasi kain dan lampu, meja prasmanan, pagar ayu, meja buah, karpet full, lighting tenda, 50 kursi dengan sarung, 1 set perasmanan, 100 set alat makan, gapura depan, dan kotak uang.\\n\\nAlat pendukung\\n\\nKipas angin atau blower. Klien bebas memilih warna kain dan tema backdrop yang telah disediakan.\\n\\nBackdrop rumahan\\n\\nUkuran tersedia: 2\\u00d72, 3\\u00d73, atau 2\\u00d73 (disesuaikan foto dan lokasi). Termasuk sofa\\/kursi pengantin, flower artificial, karpet, standing flower, standing foto, dan lighting backdrop.\\n\\nMake-up & busana premium\\n\\n1 sesi make-up, kebaya akad, beskap akad, siger\\/sulo putri\\/modern. FREE fresh melati, henna white tangan, dan softlens minus\\/normal.\\n\\nDokumentasi premium\\n\\n1 fotografer profesional, file dokumen tersimpan dalam flashdisk, dengan durasi kerja 4 jam.\",\"updated_at\":\"2026-05-30 10:27:01\"}', NULL, '2026-05-30 10:27:01', '2026-05-30 10:27:01'),
(253, 'Resource', 'Package Updated by Admin', 'App\\Models\\Package', 'Updated', 9, 'App\\Models\\User', 1, '{\"short_description\":\"Paket pernikahan premium dari Decoration Kab. Tangerang yang menghadirkan dekorasi mewah tenda 4\\u00d712, backdrop rumahan elegan, make-up & busana premium lengkap dengan bonus fresh melati, henna, dan softlens, serta dokumentasi 4 jam. Bebas pilih warna kain \",\"updated_at\":\"2026-05-30 10:29:43\"}', NULL, '2026-05-30 10:29:43', '2026-05-30 10:29:43'),
(254, 'Resource', 'Package Updated by Admin', 'App\\Models\\Package', 'Updated', 8, 'App\\Models\\User', 1, '{\"name\":\"PAKET AKAD MINIMALIS RP.7.500.000\",\"slug\":\"paket-akad-minimalis-rp7500000\",\"updated_at\":\"2026-05-30 10:30:24\"}', NULL, '2026-05-30 10:30:24', '2026-05-30 10:30:24'),
(255, 'Access', 'arhan malik  logged in', 'App\\Models\\User', 'Login', 3, 'App\\Models\\User', 3, '{\"ip\":\"192.168.64.1\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/148.0.0.0 Safari\\/537.36\"}', NULL, '2026-05-30 13:43:47', '2026-05-30 13:43:47'),
(256, 'Resource', 'Order Created by arhan malik ', 'App\\Models\\Order', 'Created', 13, 'App\\Models\\User', 3, '{\"invoice_number\":\"INV\\/2026\\/0013-DTC8\",\"user_id\":3,\"package_id\":9,\"order_type\":\"package\",\"customer_name\":\"arhan malik\",\"customer_phone\":\"082111565144\",\"customer_email\":\"arhanmcz@gmail.com\",\"event_date\":\"2026-06-03 00:00:00\",\"event_location_name\":\"gedung vincent\",\"event_address\":\"West Jakarta City\",\"event_latitude\":\"-6.1856846\",\"event_longitude\":\"106.7789088\",\"distance_km\":39.68,\"shipping_fee\":200000,\"subtotal_package\":9000000,\"subtotal_custom\":0,\"subtotal_addons\":0,\"total_price\":9200000,\"status\":\"waiting_payment\",\"payment_status\":\"unpaid\",\"payment_deadline\":\"2026-05-31 13:47:35\",\"notes\":null,\"updated_at\":\"2026-05-30 13:47:35\",\"created_at\":\"2026-05-30 13:47:35\",\"id\":13}', NULL, '2026-05-30 13:47:35', '2026-05-30 13:47:35'),
(257, 'Resource', 'Order Item Created by arhan malik ', 'App\\Models\\OrderItem', 'Created', 13, 'App\\Models\\User', 3, '{\"item_type\":\"package\",\"source_id\":9,\"name\":\"PAKET AKAD PREMIUM RP.9.000.000\",\"unit\":\"paket\",\"quantity\":1,\"price\":9000000,\"total_price\":9000000,\"snapshot\":\"{\\\"id\\\":9,\\\"slug\\\":\\\"paket-akad-premium-rp9000000\\\",\\\"name\\\":\\\"PAKET AKAD PREMIUM RP.9.000.000\\\",\\\"price\\\":9000000,\\\"price_unit\\\":\\\"paket\\\",\\\"main_image\\\":\\\"packages\\\\\\/main\\\\\\/01KSVE2DNXZKCMWQCY302DGT4W.png\\\",\\\"short_description\\\":\\\"Paket pernikahan premium dari Decoration Kab. Tangerang yang menghadirkan dekorasi mewah tenda 4\\\\u00d712, backdrop rumahan elegan, make-up & busana premium lengkap dengan bonus fresh melati, henna, dan softlens, serta dokumentasi 4 jam. Bebas pilih warna kain \\\"}\",\"order_id\":13,\"updated_at\":\"2026-05-30 13:47:35\",\"created_at\":\"2026-05-30 13:47:35\",\"id\":13}', NULL, '2026-05-30 13:47:35', '2026-05-30 13:47:35'),
(258, 'Resource', 'Order Updated by arhan malik ', 'App\\Models\\Order', 'Updated', 13, 'App\\Models\\User', 3, '{\"payment_status\":\"pending\",\"updated_at\":\"2026-05-30 13:47:47\"}', NULL, '2026-05-30 13:47:48', '2026-05-30 13:47:48'),
(259, 'Resource', 'Order Updated by arhan malik ', 'App\\Models\\Order', 'Updated', 13, 'App\\Models\\User', 3, '{\"status\":\"confirmed\",\"payment_status\":\"paid\",\"paid_at\":\"2026-05-30 13:48:25\",\"confirmed_at\":\"2026-05-30 13:48:25\",\"updated_at\":\"2026-05-30 13:48:25\"}', NULL, '2026-05-30 13:48:25', '2026-05-30 13:48:25'),
(260, 'Access', 'Admin logged in', 'App\\Models\\User', 'Login', 1, 'App\\Models\\User', 1, '{\"ip\":\"192.168.64.1\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/148.0.0.0 Safari\\/537.36\"}', NULL, '2026-05-30 13:50:44', '2026-05-30 13:50:44'),
(261, 'Access', 'Admin logged in', 'App\\Models\\User', 'Login', 1, 'App\\Models\\User', 1, '{\"ip\":\"192.168.64.1\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/148.0.0.0 Safari\\/537.36 Edg\\/148.0.0.0\"}', NULL, '2026-05-30 17:57:48', '2026-05-30 17:57:48'),
(262, 'Access', 'Admin logged in', 'App\\Models\\User', 'Login', 1, 'App\\Models\\User', 1, '{\"ip\":\"192.168.64.1\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/148.0.0.0 Safari\\/537.36 Edg\\/148.0.0.0\"}', NULL, '2026-05-30 17:57:55', '2026-05-30 17:57:55'),
(263, 'Access', 'Admin logged in', 'App\\Models\\User', 'Login', 1, 'App\\Models\\User', 1, '{\"ip\":\"192.168.64.1\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/148.0.0.0 Safari\\/537.36 Edg\\/148.0.0.0\"}', NULL, '2026-05-30 17:58:00', '2026-05-30 17:58:00'),
(264, 'Resource', 'Addon Updated by Admin', 'App\\Models\\Addon', 'Updated', 5, 'App\\Models\\User', 1, '{\"stock\":1000,\"updated_at\":\"2026-05-30 17:58:39\"}', NULL, '2026-05-30 17:58:39', '2026-05-30 17:58:39'),
(265, 'Resource', 'Package Created by Admin', 'App\\Models\\Package', 'Created', 10, 'App\\Models\\User', 1, '{\"name\":\"PAKET AKAD MINIMALIS RP.8.500.000\",\"slug\":\"paket-akad-minimalis-rp8500000\",\"type\":\"fixed\",\"short_description\":\"Paket pernikahan elegan dan berkesan dari PT. Didin Tenda Decorationdengan dekorasi tenda 4\\u00d712 lengkap panggung pelaminan 4m, backdrop panggung, make-up & busana standar plus bonus fresh melati, softlens, dan henna, serta dokumentasi 6 jam. Bebas pilih wa\",\"description\":\"\\nTenda 36 m\\u00b2 (4\\u00d712) dengan dekorasi kain dan lampu, panggung pelaminan 4m, 5 meja kotak, 3 meja bulat, karpet full, kotak uang, lighting tenda, 70 kursi plastik dengan sarung, 1 set perasmanan minimalis, dan 100 set alat makan.\\n\\nAlat pendukung\\n\\nBlower atau kipas angin. Klien bebas memilih warna kain dan tema backdrop yang telah disediakan.\\n\\nBackdrop panggung\\n\\nUkuran tersedia: 2\\u00d72, 3\\u00d73, atau 2\\u00d73 (disesuaikan foto dan lokasi). Termasuk backdrop panggung, sofa\\/kursi pengantin, flower artificial over, karpet, standing flower, standing foto, dan lighting backdrop.\\n\\nMake-up & busana standar\\n\\n1 sesi make-up, kebaya akad, beskap akad, siger\\/mahkota, fresh melati. FREE softlens normal\\/minus dan henna white tempel.\\n\\nDokumentasi standar\\n\\n1 fotografer profesional, file dokumen tersimpan dalam flashdisk, dengan durasi kerja 6 jam.\",\"price\":8500000,\"price_unit\":\"paket\",\"badge\":null,\"is_popular\":false,\"is_active\":true,\"sort_order\":0,\"main_image\":\"packages\\/main\\/01KSW8ZQ6E40FV4Z5T8GQH5MMP.png\",\"images\":\"[]\",\"updated_at\":\"2026-05-30 18:05:54\",\"created_at\":\"2026-05-30 18:05:54\",\"id\":10}', NULL, '2026-05-30 18:05:54', '2026-05-30 18:05:54'),
(266, 'Resource', 'Package Updated by Admin', 'App\\Models\\Package', 'Updated', 8, 'App\\Models\\User', 1, '{\"short_description\":\"Paket lengkap pernikahan dari PT. Didin Tenda Decoration yang mencakup dekorasi tenda (4\\u00d78), backdrop rumahan, make-up & busana pengantin, serta dokumentasi 6 jam. Bebas pilih warna kain dan tema backdrop. \",\"updated_at\":\"2026-05-30 18:07:50\"}', NULL, '2026-05-30 18:07:50', '2026-05-30 18:07:50'),
(267, 'Resource', 'Package Updated by Admin', 'App\\Models\\Package', 'Updated', 9, 'App\\Models\\User', 1, '{\"short_description\":\"Paket pernikahan premium dari PT. Didin Tenda Decoratio yang menghadirkan dekorasi mewah tenda 4\\u00d712, backdrop rumahan elegan, make-up & busana premium lengkap dengan bonus fresh melati, henna, dan softlens, serta dokumentasi 4 jam. Bebas pilih warna kain \",\"updated_at\":\"2026-05-30 18:08:08\"}', NULL, '2026-05-30 18:08:08', '2026-05-30 18:08:08'),
(268, 'Resource', 'Package Updated by Admin', 'App\\Models\\Package', 'Updated', 10, 'App\\Models\\User', 1, '{\"short_description\":\"Paket pernikahan elegan dan berkesan dari PT. Didin Tenda Decorationdengan dekorasi tenda 4\\u00d712 lengkap panggung pelaminan 4m, backdrop panggung, make-up & busana standar plus bonus fresh melati, softlens, dan henna, serta dokumentasi 6 jam. \",\"sort_order\":2,\"updated_at\":\"2026-05-30 18:08:54\"}', NULL, '2026-05-30 18:08:54', '2026-05-30 18:08:54'),
(269, 'Resource', 'Package Updated by Admin', 'App\\Models\\Package', 'Updated', 10, 'App\\Models\\User', 1, '{\"sort_order\":3,\"updated_at\":\"2026-05-30 18:09:14\"}', NULL, '2026-05-30 18:09:14', '2026-05-30 18:09:14'),
(270, 'Resource', 'Package Updated by Admin', 'App\\Models\\Package', 'Updated', 10, 'App\\Models\\User', 1, '{\"sort_order\":0,\"updated_at\":\"2026-05-30 18:09:30\"}', NULL, '2026-05-30 18:09:30', '2026-05-30 18:09:30'),
(271, 'Resource', 'Package Updated by Admin', 'App\\Models\\Package', 'Updated', 9, 'App\\Models\\User', 1, '{\"sort_order\":3,\"updated_at\":\"2026-05-30 18:09:51\"}', NULL, '2026-05-30 18:09:51', '2026-05-30 18:09:51'),
(272, 'Resource', 'Package Item Created by Admin', 'App\\Models\\PackageItem', 'Created', 40, 'App\\Models\\User', 1, '{\"package_id\":10,\"name\":\"tenda dekorasi 4x12m lengkap dekorasi prasmanan set\",\"quantity\":1,\"unit\":\"set\",\"description\":null,\"sort_order\":0,\"is_active\":true,\"updated_at\":\"2026-05-30 18:11:30\",\"created_at\":\"2026-05-30 18:11:30\",\"id\":40}', NULL, '2026-05-30 18:11:30', '2026-05-30 18:11:30'),
(273, 'Resource', 'Package Item Created by Admin', 'App\\Models\\PackageItem', 'Created', 41, 'App\\Models\\User', 1, '{\"package_id\":10,\"name\":\"Satu set Backdrop panggung lengkap Ukuran tersedia: 2\\u00d72, 3\\u00d73, atau 2\\u00d73\",\"quantity\":1,\"unit\":\"set\",\"description\":null,\"sort_order\":0,\"is_active\":true,\"updated_at\":\"2026-05-30 18:13:40\",\"created_at\":\"2026-05-30 18:13:40\",\"id\":41}', NULL, '2026-05-30 18:13:40', '2026-05-30 18:13:40'),
(274, 'Resource', 'Package Item Created by Admin', 'App\\Models\\PackageItem', 'Created', 42, 'App\\Models\\User', 1, '{\"package_id\":10,\"name\":\"Make-up & busana 1 sesi make-up, kebaya akad, beskap akad, siger\\/mahkota, fresh melati. \",\"quantity\":null,\"unit\":\"1 set\",\"description\":null,\"sort_order\":0,\"is_active\":true,\"updated_at\":\"2026-05-30 18:14:33\",\"created_at\":\"2026-05-30 18:14:33\",\"id\":42}', NULL, '2026-05-30 18:14:33', '2026-05-30 18:14:33'),
(275, 'Resource', 'Package Item Created by Admin', 'App\\Models\\PackageItem', 'Created', 43, 'App\\Models\\User', 1, '{\"package_id\":10,\"name\":\"1 fotografer profesional, file dokumen tersimpan dalam flashdisk, dengan durasi kerja 6 jam.\",\"quantity\":1,\"unit\":\"set\",\"description\":null,\"sort_order\":0,\"is_active\":true,\"updated_at\":\"2026-05-30 18:15:02\",\"created_at\":\"2026-05-30 18:15:02\",\"id\":43}', NULL, '2026-05-30 18:15:02', '2026-05-30 18:15:02'),
(276, 'Resource', 'Package Item Updated by Admin', 'App\\Models\\PackageItem', 'Updated', 43, 'App\\Models\\User', 1, '{\"name\":\"1 fotografer, file dokumen dalam flashdisk, dengan  6 jam.\",\"updated_at\":\"2026-05-30 18:15:54\"}', NULL, '2026-05-30 18:15:54', '2026-05-30 18:15:54'),
(277, 'Resource', 'Package Item Updated by Admin', 'App\\Models\\PackageItem', 'Updated', 43, 'App\\Models\\User', 1, '{\"unit\":null,\"updated_at\":\"2026-05-30 18:16:06\"}', NULL, '2026-05-30 18:16:06', '2026-05-30 18:16:06'),
(278, 'Resource', 'Package Item Updated by Admin', 'App\\Models\\PackageItem', 'Updated', 43, 'App\\Models\\User', 1, '{\"quantity\":null,\"updated_at\":\"2026-05-30 18:16:17\"}', NULL, '2026-05-30 18:16:17', '2026-05-30 18:16:17'),
(279, 'Resource', 'Package Created by Admin', 'App\\Models\\Package', 'Created', 11, 'App\\Models\\User', 1, '{\"name\":\"PAKET AKAD PREMIUM RP.11.500.000\",\"slug\":\"paket-akad-premium-rp11500000\",\"type\":\"fixed\",\"short_description\":\"Paket pernikahan paling lengkap dan mewah dari Decoration Kab. Tangerang. Hadir dengan dekorasi tenda 5\\u00d712 + panggung pelaminan 5m, backdrop panggung elegan, make-up & busana premium, dokumentasi foto 4 jam, plus Wedding Content Creator \",\"description\":null,\"price\":1150000,\"price_unit\":\"paket\",\"badge\":null,\"is_popular\":false,\"is_active\":true,\"sort_order\":0,\"main_image\":\"packages\\/main\\/01KSWDMGRD0DRJMY3G7KQ7E8CD.png\",\"images\":\"[]\",\"updated_at\":\"2026-05-30 19:27:10\",\"created_at\":\"2026-05-30 19:27:10\",\"id\":11}', NULL, '2026-05-30 19:27:10', '2026-05-30 19:27:10'),
(280, 'Resource', 'Package Updated by Admin', 'App\\Models\\Package', 'Updated', 11, 'App\\Models\\User', 1, '{\"sort_order\":4,\"updated_at\":\"2026-05-30 19:27:49\"}', NULL, '2026-05-30 19:27:49', '2026-05-30 19:27:49'),
(281, 'Resource', 'Package Updated by Admin', 'App\\Models\\Package', 'Updated', 11, 'App\\Models\\User', 1, '{\"price\":11500000,\"updated_at\":\"2026-05-30 19:37:59\"}', NULL, '2026-05-30 19:37:59', '2026-05-30 19:37:59'),
(282, 'Resource', 'Package Item Created by Admin', 'App\\Models\\PackageItem', 'Created', 44, 'App\\Models\\User', 1, '{\"package_id\":11,\"name\":\"Tenda 5x12 full dekorasi dan prasmanan set\",\"quantity\":1,\"unit\":\"set\",\"description\":null,\"sort_order\":0,\"is_active\":true,\"updated_at\":\"2026-05-30 19:42:23\",\"created_at\":\"2026-05-30 19:42:23\",\"id\":44}', NULL, '2026-05-30 19:42:23', '2026-05-30 19:42:23'),
(283, 'Resource', 'Package Item Created by Admin', 'App\\Models\\PackageItem', 'Created', 45, 'App\\Models\\User', 1, '{\"package_id\":11,\"name\":\"kursi meja dan lainnya untuk 100 orang\",\"quantity\":null,\"unit\":null,\"description\":null,\"sort_order\":0,\"is_active\":true,\"updated_at\":\"2026-05-30 19:59:33\",\"created_at\":\"2026-05-30 19:59:33\",\"id\":45}', NULL, '2026-05-30 19:59:33', '2026-05-30 19:59:33'),
(284, 'Resource', 'Package Item Created by Admin', 'App\\Models\\PackageItem', 'Created', 46, 'App\\Models\\User', 1, '{\"package_id\":11,\"name\":\"1 sesi make-up, kebaya akad, beskap akad, siger\\/solo putri\\/modern\",\"quantity\":1,\"unit\":\"set\",\"description\":null,\"sort_order\":0,\"is_active\":true,\"updated_at\":\"2026-05-30 20:01:58\",\"created_at\":\"2026-05-30 20:01:58\",\"id\":46}', NULL, '2026-05-30 20:01:58', '2026-05-30 20:01:58'),
(285, 'Resource', 'Package Updated by Admin', 'App\\Models\\Package', 'Updated', 9, 'App\\Models\\User', 1, '{\"short_description\":\"Paket pernikahan premium dari PT. Didin Tenda Decoration yang menghadirkan dekorasi mewah tenda 4\\u00d712, backdrop rumahan elegan, make-up & busana premium lengkap dengan bonus fresh melati, henna, dan softlens, serta dokumentasi 4 jam. \",\"updated_at\":\"2026-05-30 20:19:34\"}', NULL, '2026-05-30 20:19:34', '2026-05-30 20:19:34'),
(286, 'Resource', 'Package Updated by Admin', 'App\\Models\\Package', 'Updated', 10, 'App\\Models\\User', 1, '{\"short_description\":\"Paket pernikahan elegan dan berkesan dari PT. Didin Tenda Decoration dengan dekorasi tenda 4\\u00d712 lengkap panggung pelaminan 4m, backdrop panggung, make-up & busana standar plus bonus fresh melati, softlens, dan henna, serta dokumentasi 6 jam. \",\"updated_at\":\"2026-05-30 20:20:13\"}', NULL, '2026-05-30 20:20:13', '2026-05-30 20:20:13'),
(287, 'Resource', 'Package Updated by Admin', 'App\\Models\\Package', 'Updated', 11, 'App\\Models\\User', 1, '{\"short_description\":\"Paket pernikahan paling lengkap dan mewah dari PT. Didin Tenda Decoration Hadir dengan dekorasi tenda 5\\u00d712 + panggung pelaminan 5m, backdrop panggung elegan, make-up & busana premium, dokumentasi foto 4 jam, plus Wedding Content Creator \",\"updated_at\":\"2026-05-30 20:21:34\"}', NULL, '2026-05-30 20:21:34', '2026-05-30 20:21:34'),
(288, 'Access', 'Admin logged in', 'App\\Models\\User', 'Login', 1, 'App\\Models\\User', 1, '{\"ip\":\"192.168.64.1\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/148.0.0.0 Safari\\/537.36 Edg\\/148.0.0.0\"}', NULL, '2026-05-31 19:57:51', '2026-05-31 19:57:51'),
(289, 'Access', 'Admin logged in', 'App\\Models\\User', 'Login', 1, 'App\\Models\\User', 1, '{\"ip\":\"192.168.64.1\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/148.0.0.0 Safari\\/537.36 Edg\\/148.0.0.0\"}', NULL, '2026-06-01 09:42:35', '2026-06-01 09:42:35'),
(290, 'Access', 'Admin logged in', 'App\\Models\\User', 'Login', 1, 'App\\Models\\User', 1, '{\"ip\":\"192.168.64.1\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/148.0.0.0 Safari\\/537.36 Edg\\/148.0.0.0\"}', NULL, '2026-06-01 16:21:18', '2026-06-01 16:21:18'),
(291, 'Access', 'Admin logged in', 'App\\Models\\User', 'Login', 1, 'App\\Models\\User', 1, '{\"ip\":\"192.168.64.1\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/148.0.0.0 Safari\\/537.36 Edg\\/148.0.0.0\"}', NULL, '2026-06-01 18:37:28', '2026-06-01 18:37:28'),
(292, 'Access', 'Admin logged in', 'App\\Models\\User', 'Login', 1, 'App\\Models\\User', 1, '{\"ip\":\"192.168.64.1\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/148.0.0.0 Safari\\/537.36\"}', NULL, '2026-06-01 19:43:28', '2026-06-01 19:43:28'),
(293, 'Resource', 'Sosial Media Updated by Admin', 'App\\Models\\SosialMedia', 'Updated', 3, 'App\\Models\\User', 1, '{\"link\":\"https:\\/\\/api.whatsapp.com\\/send?phone=6288289258764\",\"updated_at\":\"2026-06-01 19:53:07\"}', NULL, '2026-06-01 19:53:07', '2026-06-01 19:53:07'),
(294, 'Access', 'Admin logged in', 'App\\Models\\User', 'Login', 1, 'App\\Models\\User', 1, '{\"ip\":\"192.168.64.1\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/148.0.0.0 Safari\\/537.36 Edg\\/148.0.0.0\"}', NULL, '2026-06-03 13:20:56', '2026-06-03 13:20:56'),
(295, 'Resource', 'Addon Updated by Admin', 'App\\Models\\Addon', 'Updated', 3, 'App\\Models\\User', 1, '{\"stock\":4}', NULL, '2026-06-03 14:27:26', '2026-06-03 14:27:26'),
(296, 'Resource', 'Addon Updated by Admin', 'App\\Models\\Addon', 'Updated', 4, 'App\\Models\\User', 1, '{\"stock\":6}', NULL, '2026-06-03 14:27:26', '2026-06-03 14:27:26'),
(297, 'Resource', 'Order Created by Admin', 'App\\Models\\Order', 'Created', 14, 'App\\Models\\User', 1, '{\"invoice_number\":\"INV\\/2026\\/0014-KXZZ\",\"user_id\":1,\"package_id\":null,\"order_type\":\"custom\",\"customer_name\":\"darlan\",\"customer_phone\":\"088289258764\",\"customer_email\":\"admin@admin.com\",\"event_date\":\"2026-06-04 00:00:00\",\"event_location_name\":\"Masjid Universitas Esa Unggul\",\"event_address\":\"Masjid Universitas Esa Unggul, Jalan Haji Niming, RW 02, Duri Kepa, Kebon Jeruk, West Jakarta, Special Capital Region of Jakarta, Java, 11430, Indonesia\",\"event_latitude\":\"-6.1836986\",\"event_longitude\":\"106.7795913\",\"distance_km\":40.13,\"shipping_fee\":155000,\"subtotal_package\":0,\"subtotal_custom\":740000,\"subtotal_addons\":9200000,\"total_price\":10095000,\"status\":\"waiting_payment\",\"payment_status\":\"unpaid\",\"payment_deadline\":\"2026-06-04 14:27:26\",\"notes\":null,\"updated_at\":\"2026-06-03 14:27:26\",\"created_at\":\"2026-06-03 14:27:26\",\"id\":14}', NULL, '2026-06-03 14:27:26', '2026-06-03 14:27:26'),
(298, 'Resource', 'Order Item Created by Admin', 'App\\Models\\OrderItem', 'Created', 14, 'App\\Models\\User', 1, '{\"item_type\":\"custom\",\"source_id\":1,\"name\":\"Tenda Per Meter\\u00b2\",\"unit\":\"meter persegi\",\"quantity\":10,\"price\":60000,\"total_price\":600000,\"snapshot\":\"{\\\"slug\\\":\\\"tenda-per-meter2\\\",\\\"image\\\":\\\"custom-items\\\\\\/01KSEKCQM647HFY6ME3381YCK4.jpeg\\\",\\\"icon\\\":null,\\\"unit\\\":\\\"meter persegi\\\"}\",\"order_id\":14,\"updated_at\":\"2026-06-03 14:27:26\",\"created_at\":\"2026-06-03 14:27:26\",\"id\":14}', NULL, '2026-06-03 14:27:26', '2026-06-03 14:27:26'),
(299, 'Resource', 'Order Item Created by Admin', 'App\\Models\\OrderItem', 'Created', 15, 'App\\Models\\User', 1, '{\"item_type\":\"custom\",\"source_id\":2,\"name\":\"Kursi Plastik\",\"unit\":\"pcs\",\"quantity\":20,\"price\":7000,\"total_price\":140000,\"snapshot\":\"{\\\"slug\\\":\\\"kursi-plastik\\\",\\\"image\\\":\\\"custom-items\\\\\\/01KSEJDASKTWPE273NR71G7YCV.webp\\\",\\\"icon\\\":null,\\\"unit\\\":\\\"pcs\\\"}\",\"order_id\":14,\"updated_at\":\"2026-06-03 14:27:26\",\"created_at\":\"2026-06-03 14:27:26\",\"id\":15}', NULL, '2026-06-03 14:27:26', '2026-06-03 14:27:26'),
(300, 'Resource', 'Order Addon Created by Admin', 'App\\Models\\OrderAddon', 'Created', 25, 'App\\Models\\User', 1, '{\"addon_id\":3,\"name\":\"Photobooth drevary 3x3 meter\",\"detail\":\"Area foto dekoratif untuk tamu undangan.\",\"unit\":\"set\",\"quantity\":1,\"price\":1200000,\"total_price\":1200000,\"snapshot\":\"{\\\"slug\\\":\\\"photobooth-drevary-3x3-meter\\\",\\\"image\\\":\\\"addons\\\\\\/01KSD5AVVT1Z6XKR6875QDZ74F.jpg\\\",\\\"icon\\\":\\\"bi-camera\\\",\\\"is_quantity_based\\\":true}\",\"order_id\":14,\"updated_at\":\"2026-06-03 14:27:26\",\"created_at\":\"2026-06-03 14:27:26\",\"id\":25}', NULL, '2026-06-03 14:27:26', '2026-06-03 14:27:26'),
(301, 'Resource', 'Order Addon Created by Admin', 'App\\Models\\OrderAddon', 'Created', 26, 'App\\Models\\User', 1, '{\"addon_id\":4,\"name\":\"Panggung Rigging\",\"detail\":\"Panggung dan rigging untuk acara besar atau outdoor.\",\"unit\":\"unit\",\"quantity\":4,\"price\":2000000,\"total_price\":8000000,\"snapshot\":\"{\\\"slug\\\":\\\"panggung-rigging\\\",\\\"image\\\":\\\"addons\\\\\\/01KSD3SJYPZQEBVD0YS5X5WJRH.png\\\",\\\"icon\\\":\\\"bi-grid-3x3-gap\\\",\\\"is_quantity_based\\\":true}\",\"order_id\":14,\"updated_at\":\"2026-06-03 14:27:26\",\"created_at\":\"2026-06-03 14:27:26\",\"id\":26}', NULL, '2026-06-03 14:27:26', '2026-06-03 14:27:26'),
(302, 'Resource', 'Order Updated by Admin', 'App\\Models\\Order', 'Updated', 14, 'App\\Models\\User', 1, '{\"payment_status\":\"pending\",\"updated_at\":\"2026-06-03 14:27:40\"}', NULL, '2026-06-03 14:27:40', '2026-06-03 14:27:40'),
(303, 'Resource', 'Order Updated by Admin', 'App\\Models\\Order', 'Updated', 14, 'App\\Models\\User', 1, '{\"status\":\"confirmed\",\"payment_status\":\"paid\",\"paid_at\":\"2026-06-03 14:28:38\",\"confirmed_at\":\"2026-06-03 14:28:38\",\"updated_at\":\"2026-06-03 14:28:38\"}', NULL, '2026-06-03 14:28:38', '2026-06-03 14:28:38'),
(304, 'Resource', 'User Created', 'App\\Models\\User', 'Created', 9, NULL, NULL, '{\"name\":\"abcdef\",\"email\":\"didintendaa@gmail.com\",\"phone\":\"088289258764\",\"whatsapp\":\"088289258764\",\"updated_at\":\"2026-06-03 14:35:53\",\"created_at\":\"2026-06-03 14:35:53\",\"id\":9}', NULL, '2026-06-03 14:35:53', '2026-06-03 14:35:53'),
(305, 'Access', 'abcdef logged in', 'App\\Models\\User', 'Login', 9, 'App\\Models\\User', 9, '{\"ip\":\"192.168.64.1\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/148.0.0.0 Safari\\/537.36 Edg\\/148.0.0.0\"}', NULL, '2026-06-03 14:35:53', '2026-06-03 14:35:53'),
(306, 'Resource', 'Addon Updated by abcdef', 'App\\Models\\Addon', 'Updated', 1, 'App\\Models\\User', 9, '{\"stock\":2}', NULL, '2026-06-03 14:37:57', '2026-06-03 14:37:57'),
(307, 'Resource', 'Order Created by abcdef', 'App\\Models\\Order', 'Created', 15, 'App\\Models\\User', 9, '{\"invoice_number\":\"INV\\/2026\\/0015-T6CA\",\"user_id\":9,\"package_id\":10,\"order_type\":\"package\",\"customer_name\":\"abcdef\",\"customer_phone\":\"088289258764\",\"customer_email\":\"didintendaa@gmail.com\",\"event_date\":\"2026-06-05 00:00:00\",\"event_location_name\":\"Masjid Universitas Esa Unggul\",\"event_address\":\"Masjid Universitas Esa Unggul, Jalan Haji Niming, RW 02, Duri Kepa, Kebon Jeruk, Jakarta Barat, Daerah Khusus Ibukota Jakarta, Jawa, 11430, Indonesia\",\"event_latitude\":\"-6.1836986\",\"event_longitude\":\"106.7795913\",\"distance_km\":39.93,\"shipping_fee\":200000,\"subtotal_package\":8500000,\"subtotal_custom\":0,\"subtotal_addons\":2000000,\"total_price\":10700000,\"status\":\"waiting_payment\",\"payment_status\":\"unpaid\",\"payment_deadline\":\"2026-06-04 14:37:57\",\"notes\":null,\"updated_at\":\"2026-06-03 14:37:57\",\"created_at\":\"2026-06-03 14:37:57\",\"id\":15}', NULL, '2026-06-03 14:37:57', '2026-06-03 14:37:57'),
(308, 'Resource', 'Order Item Created by abcdef', 'App\\Models\\OrderItem', 'Created', 16, 'App\\Models\\User', 9, '{\"item_type\":\"package\",\"source_id\":10,\"name\":\"PAKET AKAD MINIMALIS RP.8.500.000\",\"unit\":\"paket\",\"quantity\":1,\"price\":8500000,\"total_price\":8500000,\"snapshot\":\"{\\\"id\\\":10,\\\"slug\\\":\\\"paket-akad-minimalis-rp8500000\\\",\\\"name\\\":\\\"PAKET AKAD MINIMALIS RP.8.500.000\\\",\\\"price\\\":8500000,\\\"price_unit\\\":\\\"paket\\\",\\\"main_image\\\":\\\"packages\\\\\\/main\\\\\\/01KSW8ZQ6E40FV4Z5T8GQH5MMP.png\\\",\\\"short_description\\\":\\\"Paket pernikahan elegan dan berkesan dari PT. Didin Tenda Decoration dengan dekorasi tenda 4\\\\u00d712 lengkap panggung pelaminan 4m, backdrop panggung, make-up & busana standar plus bonus fresh melati, softlens, dan henna, serta dokumentasi 6 jam. \\\"}\",\"order_id\":15,\"updated_at\":\"2026-06-03 14:37:57\",\"created_at\":\"2026-06-03 14:37:57\",\"id\":16}', NULL, '2026-06-03 14:37:57', '2026-06-03 14:37:57'),
(309, 'Resource', 'Order Addon Created by abcdef', 'App\\Models\\OrderAddon', 'Created', 27, 'App\\Models\\User', 9, '{\"addon_id\":1,\"name\":\"Sound System\",\"detail\":\"Speaker aktif, mixer, dan microphone untuk kebutuhan berbagai acara.\",\"unit\":\"set\",\"quantity\":2,\"price\":1000000,\"total_price\":2000000,\"snapshot\":\"{\\\"slug\\\":\\\"sound-system\\\",\\\"image\\\":\\\"addons\\\\\\/01KS7XRW8SPWYX87HEK77D4923.png\\\",\\\"icon\\\":\\\"bi-speaker\\\",\\\"is_quantity_based\\\":true}\",\"order_id\":15,\"updated_at\":\"2026-06-03 14:37:57\",\"created_at\":\"2026-06-03 14:37:57\",\"id\":27}', NULL, '2026-06-03 14:37:57', '2026-06-03 14:37:57'),
(310, 'Resource', 'Order Updated by abcdef', 'App\\Models\\Order', 'Updated', 15, 'App\\Models\\User', 9, '{\"payment_status\":\"pending\",\"updated_at\":\"2026-06-03 14:38:05\"}', NULL, '2026-06-03 14:38:05', '2026-06-03 14:38:05'),
(311, 'Resource', 'Order Updated by abcdef', 'App\\Models\\Order', 'Updated', 15, 'App\\Models\\User', 9, '{\"status\":\"confirmed\",\"payment_status\":\"paid\",\"paid_at\":\"2026-06-03 14:38:34\",\"confirmed_at\":\"2026-06-03 14:38:34\",\"updated_at\":\"2026-06-03 14:38:34\"}', NULL, '2026-06-03 14:38:34', '2026-06-03 14:38:34'),
(312, 'Access', 'abcdef logged in', 'App\\Models\\User', 'Login', 9, 'App\\Models\\User', 9, '{\"ip\":\"192.168.64.1\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/149.0.0.0 Safari\\/537.36 Edg\\/149.0.0.0\"}', NULL, '2026-06-10 10:54:57', '2026-06-10 10:54:57'),
(313, 'Resource', 'Addon Updated by abcdef', 'App\\Models\\Addon', 'Updated', 2, 'App\\Models\\User', 9, '{\"stock\":7}', NULL, '2026-06-10 11:01:44', '2026-06-10 11:01:44'),
(314, 'Resource', 'Addon Updated by abcdef', 'App\\Models\\Addon', 'Updated', 4, 'App\\Models\\User', 9, '{\"stock\":5}', NULL, '2026-06-10 11:01:44', '2026-06-10 11:01:44'),
(315, 'Resource', 'Order Created by abcdef', 'App\\Models\\Order', 'Created', 16, 'App\\Models\\User', 9, '{\"invoice_number\":\"INV\\/2026\\/0016-MZDE\",\"user_id\":9,\"package_id\":null,\"order_type\":\"custom\",\"customer_name\":\"Muhamad Darlan\",\"customer_phone\":\"088289258764\",\"customer_email\":\"didintendaa@gmail.com\",\"event_date\":\"2026-06-11 00:00:00\",\"event_location_name\":\"Masjid Universitas Esa Unggul\",\"event_address\":\"Kampus Gunadarma, Jalan Boulevard Raya, RW 14, Cengkareng Timur, Cengkareng, West Jakarta, Special Capital Region of Jakarta, 11730, Indonesia\",\"event_latitude\":\"-6.1344655\",\"event_longitude\":\"106.7333605\",\"distance_km\":39.63,\"shipping_fee\":150000,\"subtotal_package\":0,\"subtotal_custom\":740000,\"subtotal_addons\":2750000,\"total_price\":3640000,\"status\":\"waiting_payment\",\"payment_status\":\"unpaid\",\"payment_deadline\":\"2026-06-11 11:01:44\",\"notes\":null,\"updated_at\":\"2026-06-10 11:01:44\",\"created_at\":\"2026-06-10 11:01:44\",\"id\":16}', NULL, '2026-06-10 11:01:44', '2026-06-10 11:01:44'),
(316, 'Resource', 'Order Item Created by abcdef', 'App\\Models\\OrderItem', 'Created', 17, 'App\\Models\\User', 9, '{\"item_type\":\"custom\",\"source_id\":1,\"name\":\"Tenda Per Meter\\u00b2\",\"unit\":\"meter persegi\",\"quantity\":10,\"price\":60000,\"total_price\":600000,\"snapshot\":\"{\\\"slug\\\":\\\"tenda-per-meter2\\\",\\\"image\\\":\\\"custom-items\\\\\\/01KSEKCQM647HFY6ME3381YCK4.jpeg\\\",\\\"icon\\\":null,\\\"unit\\\":\\\"meter persegi\\\"}\",\"order_id\":16,\"updated_at\":\"2026-06-10 11:01:44\",\"created_at\":\"2026-06-10 11:01:44\",\"id\":17}', NULL, '2026-06-10 11:01:44', '2026-06-10 11:01:44'),
(317, 'Resource', 'Order Item Created by abcdef', 'App\\Models\\OrderItem', 'Created', 18, 'App\\Models\\User', 9, '{\"item_type\":\"custom\",\"source_id\":2,\"name\":\"Kursi Plastik\",\"unit\":\"pcs\",\"quantity\":20,\"price\":7000,\"total_price\":140000,\"snapshot\":\"{\\\"slug\\\":\\\"kursi-plastik\\\",\\\"image\\\":\\\"custom-items\\\\\\/01KSEJDASKTWPE273NR71G7YCV.webp\\\",\\\"icon\\\":null,\\\"unit\\\":\\\"pcs\\\"}\",\"order_id\":16,\"updated_at\":\"2026-06-10 11:01:44\",\"created_at\":\"2026-06-10 11:01:44\",\"id\":18}', NULL, '2026-06-10 11:01:44', '2026-06-10 11:01:44'),
(318, 'Resource', 'Order Addon Created by abcdef', 'App\\Models\\OrderAddon', 'Created', 28, 'App\\Models\\User', 9, '{\"addon_id\":2,\"name\":\"lampu Gantung besar berbagai model\",\"detail\":\"Lampu dekorasi untuk mempercantik area acara.\",\"unit\":\"Unit\",\"quantity\":1,\"price\":750000,\"total_price\":750000,\"snapshot\":\"{\\\"slug\\\":\\\"lampu-gantung-besar-berbagai-model\\\",\\\"image\\\":\\\"addons\\\\\\/01KSD54TM5YWJTMGHWVR47H4P2.avif\\\",\\\"icon\\\":\\\"bi-lightbulb\\\",\\\"is_quantity_based\\\":true}\",\"order_id\":16,\"updated_at\":\"2026-06-10 11:01:44\",\"created_at\":\"2026-06-10 11:01:44\",\"id\":28}', NULL, '2026-06-10 11:01:44', '2026-06-10 11:01:44'),
(319, 'Resource', 'Order Addon Created by abcdef', 'App\\Models\\OrderAddon', 'Created', 29, 'App\\Models\\User', 9, '{\"addon_id\":4,\"name\":\"Panggung Rigging\",\"detail\":\"Panggung dan rigging untuk acara besar atau outdoor.\",\"unit\":\"unit\",\"quantity\":1,\"price\":2000000,\"total_price\":2000000,\"snapshot\":\"{\\\"slug\\\":\\\"panggung-rigging\\\",\\\"image\\\":\\\"addons\\\\\\/01KSD3SJYPZQEBVD0YS5X5WJRH.png\\\",\\\"icon\\\":\\\"bi-grid-3x3-gap\\\",\\\"is_quantity_based\\\":true}\",\"order_id\":16,\"updated_at\":\"2026-06-10 11:01:44\",\"created_at\":\"2026-06-10 11:01:44\",\"id\":29}', NULL, '2026-06-10 11:01:44', '2026-06-10 11:01:44'),
(320, 'Resource', 'Order Updated by abcdef', 'App\\Models\\Order', 'Updated', 16, 'App\\Models\\User', 9, '{\"payment_status\":\"pending\",\"updated_at\":\"2026-06-10 11:02:21\"}', NULL, '2026-06-10 11:02:21', '2026-06-10 11:02:21'),
(321, 'Resource', 'Order Updated by abcdef', 'App\\Models\\Order', 'Updated', 16, 'App\\Models\\User', 9, '{\"status\":\"confirmed\",\"payment_status\":\"paid\",\"paid_at\":\"2026-06-10 11:03:12\",\"confirmed_at\":\"2026-06-10 11:03:12\",\"updated_at\":\"2026-06-10 11:03:12\"}', NULL, '2026-06-10 11:03:12', '2026-06-10 11:03:12'),
(322, 'Access', 'Admin logged in', 'App\\Models\\User', 'Login', 1, 'App\\Models\\User', 1, '{\"ip\":\"192.168.64.1\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/149.0.0.0 Safari\\/537.36\"}', NULL, '2026-06-10 11:15:33', '2026-06-10 11:15:33'),
(323, 'Access', 'arhan malik  logged in', 'App\\Models\\User', 'Login', 3, 'App\\Models\\User', 3, '{\"ip\":\"192.168.64.1\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/149.0.0.0 Safari\\/537.36\"}', NULL, '2026-06-14 18:32:19', '2026-06-14 18:32:19'),
(324, 'Resource', 'Order Created by arhan malik ', 'App\\Models\\Order', 'Created', 17, 'App\\Models\\User', 3, '{\"invoice_number\":\"INV\\/2026\\/0017-CMFO\",\"user_id\":3,\"package_id\":10,\"order_type\":\"package\",\"customer_name\":\"arhan malik alrasyid\",\"customer_phone\":\"082111565144\",\"customer_email\":\"arhanmcz@gmail.com\",\"event_date\":\"2026-08-14 00:00:00\",\"event_location_name\":\"GEDUNG PAK ANGGARA\",\"event_address\":\"West Jakarta City\",\"event_latitude\":\"-6.1856846\",\"event_longitude\":\"106.7789088\",\"distance_km\":39.68,\"shipping_fee\":200000,\"subtotal_package\":8500000,\"subtotal_custom\":0,\"subtotal_addons\":0,\"total_price\":8700000,\"status\":\"waiting_payment\",\"payment_status\":\"unpaid\",\"payment_deadline\":\"2026-06-15 18:34:33\",\"notes\":null,\"updated_at\":\"2026-06-14 18:34:33\",\"created_at\":\"2026-06-14 18:34:33\",\"id\":17}', NULL, '2026-06-14 18:34:33', '2026-06-14 18:34:33'),
(325, 'Resource', 'Order Item Created by arhan malik ', 'App\\Models\\OrderItem', 'Created', 19, 'App\\Models\\User', 3, '{\"item_type\":\"package\",\"source_id\":10,\"name\":\"PAKET AKAD MINIMALIS RP.8.500.000\",\"unit\":\"paket\",\"quantity\":1,\"price\":8500000,\"total_price\":8500000,\"snapshot\":\"{\\\"id\\\":10,\\\"slug\\\":\\\"paket-akad-minimalis-rp8500000\\\",\\\"name\\\":\\\"PAKET AKAD MINIMALIS RP.8.500.000\\\",\\\"price\\\":8500000,\\\"price_unit\\\":\\\"paket\\\",\\\"main_image\\\":\\\"packages\\\\\\/main\\\\\\/01KSW8ZQ6E40FV4Z5T8GQH5MMP.png\\\",\\\"short_description\\\":\\\"Paket pernikahan elegan dan berkesan dari PT. Didin Tenda Decoration dengan dekorasi tenda 4\\\\u00d712 lengkap panggung pelaminan 4m, backdrop panggung, make-up & busana standar plus bonus fresh melati, softlens, dan henna, serta dokumentasi 6 jam. \\\"}\",\"order_id\":17,\"updated_at\":\"2026-06-14 18:34:33\",\"created_at\":\"2026-06-14 18:34:33\",\"id\":19}', NULL, '2026-06-14 18:34:33', '2026-06-14 18:34:33'),
(326, 'Resource', 'Order Updated by arhan malik ', 'App\\Models\\Order', 'Updated', 17, 'App\\Models\\User', 3, '{\"payment_status\":\"pending\",\"updated_at\":\"2026-06-14 18:34:38\"}', NULL, '2026-06-14 18:34:38', '2026-06-14 18:34:38'),
(327, 'Resource', 'Order Updated by arhan malik ', 'App\\Models\\Order', 'Updated', 17, 'App\\Models\\User', 3, '{\"status\":\"confirmed\",\"payment_status\":\"paid\",\"paid_at\":\"2026-06-14 18:34:49\",\"confirmed_at\":\"2026-06-14 18:34:49\",\"updated_at\":\"2026-06-14 18:34:49\"}', NULL, '2026-06-14 18:34:49', '2026-06-14 18:34:49'),
(328, 'Access', 'Admin logged in', 'App\\Models\\User', 'Login', 1, 'App\\Models\\User', 1, '{\"ip\":\"192.168.64.1\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/149.0.0.0 Safari\\/537.36\"}', NULL, '2026-06-14 18:35:49', '2026-06-14 18:35:49'),
(329, 'Access', 'arhan malik  logged in', 'App\\Models\\User', 'Login', 3, 'App\\Models\\User', 3, '{\"ip\":\"192.168.64.1\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/149.0.0.0 Safari\\/537.36\"}', NULL, '2026-06-19 02:09:34', '2026-06-19 02:09:34'),
(330, 'Resource', 'User Created', 'App\\Models\\User', 'Created', 10, NULL, NULL, '{\"name\":\"Nindyy\",\"email\":\"nindyabp95@gmail.com\",\"phone\":\"081398889380\",\"whatsapp\":\"081398889380\",\"updated_at\":\"2026-06-20 22:06:19\",\"created_at\":\"2026-06-20 22:06:19\",\"id\":10}', NULL, '2026-06-20 22:06:19', '2026-06-20 22:06:19'),
(331, 'Access', 'Nindyy logged in', 'App\\Models\\User', 'Login', 10, 'App\\Models\\User', 10, '{\"ip\":\"192.168.64.1\",\"user_agent\":\"Mozilla\\/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit\\/605.1.15 (KHTML, like Gecko) Version\\/26.5 Mobile\\/15E148 Safari\\/604.1\"}', NULL, '2026-06-20 22:06:20', '2026-06-20 22:06:20'),
(332, 'Resource', 'Order Created by Nindyy', 'App\\Models\\Order', 'Created', 18, 'App\\Models\\User', 10, '{\"invoice_number\":\"INV\\/2026\\/0018-RMEY\",\"user_id\":10,\"package_id\":11,\"order_type\":\"package\",\"customer_name\":\"Nindyy\",\"customer_phone\":\"081398889380\",\"customer_email\":\"nindyabp95@gmail.com\",\"event_date\":\"2026-06-30 00:00:00\",\"event_location_name\":\"Rumah sendiri\",\"event_address\":\"Suka Mulya, Kabupaten Tangerang, Cikupa, Banten, 15710, Indonesia\",\"event_latitude\":\"-6.2428171\",\"event_longitude\":\"106.5078868\",\"distance_km\":9.21,\"shipping_fee\":0,\"subtotal_package\":11500000,\"subtotal_custom\":0,\"subtotal_addons\":0,\"total_price\":11500000,\"status\":\"waiting_payment\",\"payment_status\":\"unpaid\",\"payment_deadline\":\"2026-06-21 22:11:23\",\"notes\":null,\"updated_at\":\"2026-06-20 22:11:23\",\"created_at\":\"2026-06-20 22:11:23\",\"id\":18}', NULL, '2026-06-20 22:11:23', '2026-06-20 22:11:23'),
(333, 'Resource', 'Order Item Created by Nindyy', 'App\\Models\\OrderItem', 'Created', 20, 'App\\Models\\User', 10, '{\"item_type\":\"package\",\"source_id\":11,\"name\":\"PAKET AKAD PREMIUM RP.11.500.000\",\"unit\":\"paket\",\"quantity\":1,\"price\":11500000,\"total_price\":11500000,\"snapshot\":\"{\\\"id\\\":11,\\\"slug\\\":\\\"paket-akad-premium-rp11500000\\\",\\\"name\\\":\\\"PAKET AKAD PREMIUM RP.11.500.000\\\",\\\"price\\\":11500000,\\\"price_unit\\\":\\\"paket\\\",\\\"main_image\\\":\\\"packages\\\\\\/main\\\\\\/01KSWDMGRD0DRJMY3G7KQ7E8CD.png\\\",\\\"short_description\\\":\\\"Paket pernikahan paling lengkap dan mewah dari PT. Didin Tenda Decoration Hadir dengan dekorasi tenda 5\\\\u00d712 + panggung pelaminan 5m, backdrop panggung elegan, make-up & busana premium, dokumentasi foto 4 jam, plus Wedding Content Creator \\\"}\",\"order_id\":18,\"updated_at\":\"2026-06-20 22:11:23\",\"created_at\":\"2026-06-20 22:11:23\",\"id\":20}', NULL, '2026-06-20 22:11:23', '2026-06-20 22:11:23'),
(334, 'Resource', 'Order Updated by Nindyy', 'App\\Models\\Order', 'Updated', 18, 'App\\Models\\User', 10, '{\"payment_status\":\"pending\",\"updated_at\":\"2026-06-20 22:11:35\"}', NULL, '2026-06-20 22:11:35', '2026-06-20 22:11:35'),
(335, 'Access', 'Nindyy logged in', 'App\\Models\\User', 'Login', 10, 'App\\Models\\User', 10, '{\"ip\":\"192.168.64.1\",\"user_agent\":\"Mozilla\\/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit\\/605.1.15 (KHTML, like Gecko) Version\\/26.5 Mobile\\/15E148 Safari\\/604.1\"}', NULL, '2026-06-20 22:15:58', '2026-06-20 22:15:58'),
(336, 'Resource', 'Order Created by Nindyy', 'App\\Models\\Order', 'Created', 19, 'App\\Models\\User', 10, '{\"invoice_number\":\"INV\\/2026\\/0019-LM9T\",\"user_id\":10,\"package_id\":8,\"order_type\":\"package\",\"customer_name\":\"Nindyy\",\"customer_phone\":\"081398889380\",\"customer_email\":\"nindyabp95@gmail.com\",\"event_date\":\"2026-06-26 00:00:00\",\"event_location_name\":\"Rumah\",\"event_address\":\"Suka Mulya, Kabupaten Tangerang, Cikupa, Banten, 15710, Indonesia\",\"event_latitude\":\"-6.2397978\",\"event_longitude\":\"106.5048465\",\"distance_km\":8.71,\"shipping_fee\":0,\"subtotal_package\":7500000,\"subtotal_custom\":0,\"subtotal_addons\":0,\"total_price\":7500000,\"status\":\"waiting_payment\",\"payment_status\":\"unpaid\",\"payment_deadline\":\"2026-06-21 22:24:03\",\"notes\":null,\"updated_at\":\"2026-06-20 22:24:03\",\"created_at\":\"2026-06-20 22:24:03\",\"id\":19}', NULL, '2026-06-20 22:24:03', '2026-06-20 22:24:03'),
(337, 'Resource', 'Order Item Created by Nindyy', 'App\\Models\\OrderItem', 'Created', 21, 'App\\Models\\User', 10, '{\"item_type\":\"package\",\"source_id\":8,\"name\":\"PAKET AKAD MINIMALIS RP.7.500.000\",\"unit\":\"paket\",\"quantity\":1,\"price\":7500000,\"total_price\":7500000,\"snapshot\":\"{\\\"id\\\":8,\\\"slug\\\":\\\"paket-akad-minimalis-rp7500000\\\",\\\"name\\\":\\\"PAKET AKAD MINIMALIS RP.7.500.000\\\",\\\"price\\\":7500000,\\\"price_unit\\\":\\\"paket\\\",\\\"main_image\\\":\\\"packages\\\\\\/main\\\\\\/01KSVC3DZWS1PGBKRCD9ETM31E.png\\\",\\\"short_description\\\":\\\"Paket lengkap pernikahan dari PT. Didin Tenda Decoration yang mencakup dekorasi tenda (4\\\\u00d78), backdrop rumahan, make-up & busana pengantin, serta dokumentasi 6 jam. Bebas pilih warna kain dan tema backdrop. \\\"}\",\"order_id\":19,\"updated_at\":\"2026-06-20 22:24:03\",\"created_at\":\"2026-06-20 22:24:03\",\"id\":21}', NULL, '2026-06-20 22:24:03', '2026-06-20 22:24:03'),
(338, 'Resource', 'Order Updated by Nindyy', 'App\\Models\\Order', 'Updated', 19, 'App\\Models\\User', 10, '{\"payment_status\":\"pending\",\"updated_at\":\"2026-06-20 22:24:14\"}', NULL, '2026-06-20 22:24:14', '2026-06-20 22:24:14'),
(339, 'Access', 'Admin logged in', 'App\\Models\\User', 'Login', 1, 'App\\Models\\User', 1, '{\"ip\":\"192.168.64.1\",\"user_agent\":\"Mozilla\\/5.0 (Linux; Android 10; K) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/149.0.0.0 Mobile Safari\\/537.36\"}', NULL, '2026-06-20 22:35:09', '2026-06-20 22:35:09'),
(340, 'Resource', 'Order Updated by Nindyy', 'App\\Models\\Order', 'Updated', 19, 'App\\Models\\User', 10, '{\"status\":\"confirmed\",\"payment_status\":\"paid\",\"paid_at\":\"2026-06-20 22:44:14\",\"confirmed_at\":\"2026-06-20 22:44:14\",\"updated_at\":\"2026-06-20 22:44:14\"}', NULL, '2026-06-20 22:44:14', '2026-06-20 22:44:14'),
(341, 'Access', 'Admin logged in', 'App\\Models\\User', 'Login', 1, 'App\\Models\\User', 1, '{\"ip\":\"192.168.64.1\",\"user_agent\":\"Mozilla\\/5.0 (Linux; Android 10; K) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/149.0.0.0 Mobile Safari\\/537.36\"}', NULL, '2026-06-21 09:53:42', '2026-06-21 09:53:42'),
(342, 'Access', 'Admin logged in', 'App\\Models\\User', 'Login', 1, 'App\\Models\\User', 1, '{\"ip\":\"192.168.64.1\",\"user_agent\":\"Mozilla\\/5.0 (Linux; Android 10; K) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/149.0.0.0 Mobile Safari\\/537.36\"}', NULL, '2026-06-21 14:13:50', '2026-06-21 14:13:50'),
(343, 'Access', 'Admin logged in', 'App\\Models\\User', 'Login', 1, 'App\\Models\\User', 1, '{\"ip\":\"192.168.64.1\",\"user_agent\":\"Mozilla\\/5.0 (Linux; Android 10; K) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/149.0.0.0 Mobile Safari\\/537.36\"}', NULL, '2026-06-21 17:51:27', '2026-06-21 17:51:27');

-- ----------------------------
-- Table structure for addons
-- ----------------------------
DROP TABLE IF EXISTS `addons`;
CREATE TABLE `addons` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `detail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` bigint(20) unsigned NOT NULL DEFAULT 0,
  `unit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pcs',
  `is_quantity_based` tinyint(1) NOT NULL DEFAULT 1,
  `stock` int(10) unsigned DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(10) unsigned NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `addons_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of addons
-- ----------------------------
INSERT INTO `addons` (`id`, `name`, `slug`, `detail`, `price`, `unit`, `is_quantity_based`, `stock`, `image`, `icon`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'Sound System', 'sound-system', 'Speaker aktif, mixer, dan microphone untuk kebutuhan berbagai acara.', 1000000, 'set', 1, 2, 'addons/01KS7XRW8SPWYX87HEK77D4923.png', 'bi-speaker', 1, 1, '2026-05-01 23:11:28', '2026-06-03 14:37:57'),
(2, 'lampu Gantung besar berbagai model', 'lampu-gantung-besar-berbagai-model', 'Lampu dekorasi untuk mempercantik area acara.', 750000, 'Unit', 1, 7, 'addons/01KSD54TM5YWJTMGHWVR47H4P2.avif', 'bi-lightbulb', 1, 2, '2026-05-01 23:11:28', '2026-06-10 11:01:43'),
(3, 'Photobooth drevary 3x3 meter', 'photobooth-drevary-3x3-meter', 'Area foto dekoratif untuk tamu undangan.', 1200000, 'set', 1, 4, 'addons/01KSD5AVVT1Z6XKR6875QDZ74F.jpg', 'bi-camera', 1, 3, '2026-05-01 23:11:28', '2026-06-03 14:27:26'),
(4, 'Panggung Rigging', 'panggung-rigging', 'Panggung dan rigging untuk acara besar atau outdoor.', 2000000, 'unit', 1, 5, 'addons/01KSD3SJYPZQEBVD0YS5X5WJRH.png', 'bi-grid-3x3-gap', 1, 4, '2026-05-01 23:11:28', '2026-06-10 11:01:44'),
(5, 'Karpet ( Merah, Abu-Abu & biru )', 'karpet-merah-abu-abu-biru', 'karpet untuk alas jalan, terhitung per meter persegi, ada berbagai pilihan warna', 15000, ' meter persegi', 1, 1000, 'addons/01KSD2ZDHJHB152ETSP1NRDJ94.webp', 'bi-square-fill', 1, 5, '2026-05-01 23:11:28', '2026-05-30 17:58:39'),
(6, 'Kipas Blower', 'kipas-blower', 'Kipas blower untuk area tenda agar lebih nyaman.', 450000, 'unit', 1, 20, 'addons/01KS7Y9JKA1A7BKWVC5XSEYJQ3.webp', 'bi-wind', 1, 6, '2026-05-01 23:11:28', '2026-05-24 21:09:11');

-- ----------------------------
-- Table structure for berandas
-- ----------------------------
DROP TABLE IF EXISTS `berandas`;
CREATE TABLE `berandas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title_1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deskripsi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of berandas
-- ----------------------------
INSERT INTO `berandas` (`id`, `title_1`, `title_2`, `deskripsi`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Sejak 1996 • Terpercaya', 'Sewakan Tenda & Dekorasi Impian untuk Acara Istimewa Anda', 'Booking online 24/7, cek ketersediaan real-time, dan pembayaran aman via berbagai metode. Wujudkan acara impian bersama Didin Tenda Decoration.', 'beranda/01KS5DPRXQX15Z5DGD6Q5WG4Q2.jpeg', '2026-05-02 04:42:21', '2026-05-21 21:05:52');

-- ----------------------------
-- Table structure for cache
-- ----------------------------
DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of cache
-- ----------------------------
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('pt-didin-tenda-cache-356a192b7913b04c54574d18c28d46e6395428ab', 'i:1;', 1780144003),
('pt-didin-tenda-cache-356a192b7913b04c54574d18c28d46e6395428ab:timer', 'i:1780144003;', 1780144003),
('pt-didin-tenda-cache-livewire-rate-limiter:5365e54bead5e0059562d73e32883eda662ec400', 'i:1;', 1781437008),
('pt-didin-tenda-cache-livewire-rate-limiter:5365e54bead5e0059562d73e32883eda662ec400:timer', 'i:1781437008;', 1781437008),
('pt-didin-tenda-cache-spatie.permission.cache', 'a:3:{s:5:\"alias\";a:4:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:73:{i:0;a:4:{s:1:\"a\";i:1;s:1:\"b\";s:12:\"ViewAny:User\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:1;a:4:{s:1:\"a\";i:2;s:1:\"b\";s:9:\"View:User\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:2;a:4:{s:1:\"a\";i:3;s:1:\"b\";s:11:\"Create:User\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:3;a:4:{s:1:\"a\";i:4;s:1:\"b\";s:11:\"Update:User\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:4;a:4:{s:1:\"a\";i:5;s:1:\"b\";s:11:\"Delete:User\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:5;a:4:{s:1:\"a\";i:6;s:1:\"b\";s:12:\"ViewAny:Role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:6;a:4:{s:1:\"a\";i:7;s:1:\"b\";s:9:\"View:Role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:7;a:4:{s:1:\"a\";i:8;s:1:\"b\";s:11:\"Create:Role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:8;a:4:{s:1:\"a\";i:9;s:1:\"b\";s:11:\"Update:Role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:9;a:4:{s:1:\"a\";i:10;s:1:\"b\";s:11:\"Delete:Role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:10;a:4:{s:1:\"a\";i:11;s:1:\"b\";s:16:\"ViewAny:Activity\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:11;a:4:{s:1:\"a\";i:12;s:1:\"b\";s:13:\"View:Activity\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:12;a:4:{s:1:\"a\";i:13;s:1:\"b\";s:15:\"Create:Activity\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:13;a:4:{s:1:\"a\";i:14;s:1:\"b\";s:15:\"Update:Activity\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:14;a:4:{s:1:\"a\";i:15;s:1:\"b\";s:15:\"Delete:Activity\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:15;a:4:{s:1:\"a\";i:16;s:1:\"b\";s:18:\"View:MyProfilePage\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:16;a:4:{s:1:\"a\";i:17;s:1:\"b\";s:19:\"View:OverlookWidget\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:17;a:4:{s:1:\"a\";i:18;s:1:\"b\";s:21:\"View:LatestAccessLogs\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:18;a:4:{s:1:\"a\";i:19;s:1:\"b\";s:13:\"ViewAny:Addon\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:19;a:4:{s:1:\"a\";i:20;s:1:\"b\";s:10:\"View:Addon\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:20;a:4:{s:1:\"a\";i:21;s:1:\"b\";s:12:\"Create:Addon\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:21;a:4:{s:1:\"a\";i:22;s:1:\"b\";s:12:\"Update:Addon\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:22;a:4:{s:1:\"a\";i:23;s:1:\"b\";s:12:\"Delete:Addon\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:23;a:4:{s:1:\"a\";i:24;s:1:\"b\";s:18:\"ViewAny:CustomItem\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:24;a:4:{s:1:\"a\";i:25;s:1:\"b\";s:15:\"View:CustomItem\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:25;a:4:{s:1:\"a\";i:26;s:1:\"b\";s:17:\"Create:CustomItem\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:26;a:4:{s:1:\"a\";i:27;s:1:\"b\";s:17:\"Update:CustomItem\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:27;a:4:{s:1:\"a\";i:28;s:1:\"b\";s:17:\"Delete:CustomItem\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:28;a:4:{s:1:\"a\";i:29;s:1:\"b\";s:19:\"ViewAny:PackageItem\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:29;a:4:{s:1:\"a\";i:30;s:1:\"b\";s:16:\"View:PackageItem\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:30;a:4:{s:1:\"a\";i:31;s:1:\"b\";s:18:\"Create:PackageItem\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:31;a:4:{s:1:\"a\";i:32;s:1:\"b\";s:18:\"Update:PackageItem\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:32;a:4:{s:1:\"a\";i:33;s:1:\"b\";s:18:\"Delete:PackageItem\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:33;a:4:{s:1:\"a\";i:34;s:1:\"b\";s:15:\"ViewAny:Package\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:34;a:4:{s:1:\"a\";i:35;s:1:\"b\";s:12:\"View:Package\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:35;a:4:{s:1:\"a\";i:36;s:1:\"b\";s:14:\"Create:Package\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:36;a:4:{s:1:\"a\";i:37;s:1:\"b\";s:14:\"Update:Package\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:37;a:4:{s:1:\"a\";i:38;s:1:\"b\";s:14:\"Delete:Package\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:38;a:4:{s:1:\"a\";i:39;s:1:\"b\";s:15:\"ViewAny:Beranda\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:39;a:4:{s:1:\"a\";i:40;s:1:\"b\";s:12:\"View:Beranda\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:40;a:4:{s:1:\"a\";i:41;s:1:\"b\";s:14:\"Create:Beranda\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:41;a:4:{s:1:\"a\";i:42;s:1:\"b\";s:14:\"Update:Beranda\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:42;a:4:{s:1:\"a\";i:43;s:1:\"b\";s:14:\"Delete:Beranda\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:43;a:4:{s:1:\"a\";i:44;s:1:\"b\";s:18:\"ViewAny:OrderAddon\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:44;a:4:{s:1:\"a\";i:45;s:1:\"b\";s:15:\"View:OrderAddon\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:45;a:4:{s:1:\"a\";i:46;s:1:\"b\";s:17:\"Create:OrderAddon\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:46;a:4:{s:1:\"a\";i:47;s:1:\"b\";s:17:\"Update:OrderAddon\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:47;a:4:{s:1:\"a\";i:48;s:1:\"b\";s:17:\"Delete:OrderAddon\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:48;a:4:{s:1:\"a\";i:49;s:1:\"b\";s:17:\"ViewAny:OrderItem\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:49;a:4:{s:1:\"a\";i:50;s:1:\"b\";s:14:\"View:OrderItem\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:50;a:4:{s:1:\"a\";i:51;s:1:\"b\";s:16:\"Create:OrderItem\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:51;a:4:{s:1:\"a\";i:52;s:1:\"b\";s:16:\"Update:OrderItem\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:52;a:4:{s:1:\"a\";i:53;s:1:\"b\";s:16:\"Delete:OrderItem\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:53;a:4:{s:1:\"a\";i:54;s:1:\"b\";s:13:\"ViewAny:Order\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:54;a:4:{s:1:\"a\";i:55;s:1:\"b\";s:10:\"View:Order\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:55;a:4:{s:1:\"a\";i:56;s:1:\"b\";s:12:\"Create:Order\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:56;a:4:{s:1:\"a\";i:57;s:1:\"b\";s:12:\"Update:Order\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:57;a:4:{s:1:\"a\";i:58;s:1:\"b\";s:12:\"Delete:Order\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:58;a:4:{s:1:\"a\";i:59;s:1:\"b\";s:14:\"ViewAny:Galery\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:59;a:4:{s:1:\"a\";i:60;s:1:\"b\";s:11:\"View:Galery\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:60;a:4:{s:1:\"a\";i:61;s:1:\"b\";s:13:\"Create:Galery\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:61;a:4:{s:1:\"a\";i:62;s:1:\"b\";s:13:\"Update:Galery\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:62;a:4:{s:1:\"a\";i:63;s:1:\"b\";s:13:\"Delete:Galery\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:63;a:4:{s:1:\"a\";i:64;s:1:\"b\";s:14:\"ViewAny:Footer\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:64;a:4:{s:1:\"a\";i:65;s:1:\"b\";s:11:\"View:Footer\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:65;a:4:{s:1:\"a\";i:66;s:1:\"b\";s:13:\"Create:Footer\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:66;a:4:{s:1:\"a\";i:67;s:1:\"b\";s:13:\"Update:Footer\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:67;a:4:{s:1:\"a\";i:68;s:1:\"b\";s:13:\"Delete:Footer\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:68;a:4:{s:1:\"a\";i:69;s:1:\"b\";s:19:\"ViewAny:SosialMedia\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:69;a:4:{s:1:\"a\";i:70;s:1:\"b\";s:16:\"View:SosialMedia\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:70;a:4:{s:1:\"a\";i:71;s:1:\"b\";s:18:\"Create:SosialMedia\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:71;a:4:{s:1:\"a\";i:72;s:1:\"b\";s:18:\"Update:SosialMedia\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:72;a:4:{s:1:\"a\";i:73;s:1:\"b\";s:18:\"Delete:SosialMedia\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}}s:5:\"roles\";a:1:{i:0;a:3:{s:1:\"a\";i:1;s:1:\"b\";s:11:\"super_admin\";s:1:\"c\";s:3:\"web\";}}}', 1782056504);

-- ----------------------------
-- Table structure for cache_locks
-- ----------------------------
DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of cache_locks
-- ----------------------------
-- ----------------------------
-- Table structure for custom_items
-- ----------------------------
DROP TABLE IF EXISTS `custom_items`;
CREATE TABLE `custom_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` bigint(20) unsigned NOT NULL DEFAULT 0,
  `unit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pcs',
  `min_quantity` int(10) unsigned NOT NULL DEFAULT 0,
  `max_quantity` int(10) unsigned DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(10) unsigned NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `custom_items_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of custom_items
-- ----------------------------
INSERT INTO `custom_items` (`id`, `name`, `slug`, `description`, `price`, `unit`, `min_quantity`, `max_quantity`, `image`, `icon`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'Tenda Per Meter²', 'tenda-per-meter2', 'Sewa tenda berdasarkan luas kebutuhan acara plus dekorasi kain dan penyesuaian pernak pernik dekorasi. tersedia semua warna ( hubungi admin untuk pemilihan warna )', 60000, 'meter persegi', 10, 600, 'custom-items/01KSEKCQM647HFY6ME3381YCK4.jpeg', NULL, 1, 1, '2026-05-01 23:11:28', '2026-05-25 10:39:29'),
(2, 'Kursi Plastik', 'kursi-plastik', 'Kursi tamu standar untuk acara plastik napolly.', 7000, 'pcs', 20, 500, 'custom-items/01KSEJDASKTWPE273NR71G7YCV.webp', NULL, 1, 2, '2026-05-01 23:11:28', '2026-05-25 10:21:15'),
(3, 'Meja Prasmanan Atau Meja Tamu ( Plus Cover )', 'meja-prasmanan-atau-meja-tamu-plus-cover', 'Meja untuk area hidangan dan konsumsi ukuran 1.75 meter x 1 meter ', 50000, 'pcs', 5, 80, 'custom-items/01KSEJJCXKC5TC504G8379PXKD.webp', 'bi-table', 1, 6, '2026-05-01 23:11:28', '2026-05-25 10:29:41'),
(4, 'Kursi Lipat Stainless', 'kursi-lipat-stainless', 'Kursi Lipat Merk Chitosse ', 10000, 'pcs', 50, 500, 'custom-items/01KSEJNZJJB8HJGWN2XD5AZ2QH.webp', NULL, 1, 4, '2026-05-01 23:11:28', '2026-05-25 10:34:37'),
(5, 'Kursi Merah Merk Futura', 'kursi-merah-merk-futura', 'Kursi Sofa empuk merk Futura', 12000, 'pcs', 30, 400, 'custom-items/01KSEJVAWB46YV2D4G8ZN3JWN5.jpg', 'bi-image', 1, 5, '2026-05-01 23:11:28', '2026-05-25 10:34:58'),
(6, 'Meja Bundar Kapassitas 5 Atau 6 Orang ( Plus Cover )', 'meja-bundar-kapassitas-5-atau-6-orang-plus-cover', 'Meja bundar untuk acara formal, rapat dan tamu', 50000, 'pcs', 20, 88, 'custom-items/01KSEK488DB0TDTK0SQS88ZNAX.avif', 'bi-easel', 1, 7, '2026-05-01 23:11:28', '2026-05-25 10:35:20');

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of failed_jobs
-- ----------------------------
-- ----------------------------
-- Table structure for footers
-- ----------------------------
DROP TABLE IF EXISTS `footers`;
CREATE TABLE `footers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomor_telfon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `copyright` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `develop_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of footers
-- ----------------------------
INSERT INTO `footers` (`id`, `alamat`, `nomor_telfon`, `email`, `copyright`, `develop_by`, `created_at`, `updated_at`) VALUES
(1, 'Jl. Ki Mas Laeng Kp. Katomas, Tigaraksa, Kab. Tangerang, Banten', '0882-8925-8764', 'info@didintenda.com', '© 2026 Didin Tenda Decoration. All rights reserved.', 'Developed for Tugas Akhir - Muhamad Darlan (20220803005)', '2026-05-02 05:19:22', '2026-05-02 05:22:00');

-- ----------------------------
-- Table structure for galeries
-- ----------------------------
DROP TABLE IF EXISTS `galeries`;
CREATE TABLE `galeries` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deskripsi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of galeries
-- ----------------------------
INSERT INTO `galeries` (`id`, `title`, `deskripsi`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Pelaminan Minimalis 8 Meter', 'pelaminan mewah - 2025', 'galeries/01KS5B29G7X444JE0C6PEESA96.jpg', '2026-05-02 05:08:21', '2026-05-22 19:24:32'),
(2, 'pelaminan 8 meter Premium', NULL, 'galeries/01KS7SFGMX22V2J5P3ZAHGQQ8F.jpeg', '2026-05-02 05:09:25', '2026-05-22 19:24:03'),
(3, 'Pelaminan dengan lebar 5 meter Minimalis', NULL, 'galeries/01KS7SK59Q88WHKMJFNH8272K3.jpeg', '2026-05-22 19:09:12', '2026-05-22 19:12:05');

-- ----------------------------
-- Table structure for job_batches
-- ----------------------------
DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of job_batches
-- ----------------------------
-- ----------------------------
-- Table structure for jobs
-- ----------------------------
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of jobs
-- ----------------------------
-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '0001_01_01_000003_create_notifications_table', 1),
(5, '0001_01_01_000004_create_permission_tables', 1),
(6, '0001_01_01_000005_create_activity_log_table', 1),
(7, '0001_01_01_000006_add_event_column_to_activity_log_table', 1),
(8, '0001_01_01_000007_add_batch_uuid_column_to_activity_log_table', 1),
(9, '2026_04_28_070543_create_packages_table', 1),
(10, '2026_04_28_070548_create_package_items_table', 1),
(11, '2026_04_28_070552_create_addons_table', 1),
(12, '2026_04_28_070556_create_custom_items_table', 1),
(13, '2026_04_28_070630_create_orders_table', 1),
(14, '2026_04_28_070635_create_order_items_table', 1),
(15, '2026_04_28_070639_create_order_addons_table', 1),
(16, '2026_04_28_070650_create_reviews_table', 1),
(17, '2026_04_28_070832_create_payments_table', 1),
(18, '2026_04_30_080827_create_berandas_table', 1),
(19, '2026_05_02_045124_create_galeries_table', 2),
(20, '2026_05_02_051237_create_footers_table', 3),
(21, '2026_05_02_052236_create_sosial_media_table', 4);

-- ----------------------------
-- Table structure for model_has_permissions
-- ----------------------------
DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of model_has_permissions
-- ----------------------------
-- ----------------------------
-- Table structure for model_has_roles
-- ----------------------------
DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of model_has_roles
-- ----------------------------
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1);

-- ----------------------------
-- Table structure for notifications
-- ----------------------------
DROP TABLE IF EXISTS `notifications`;
CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint(20) unsigned NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of notifications
-- ----------------------------
-- ----------------------------
-- Table structure for order_addons
-- ----------------------------
DROP TABLE IF EXISTS `order_addons`;
CREATE TABLE `order_addons` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) unsigned NOT NULL,
  `addon_id` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `detail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` int(10) unsigned NOT NULL DEFAULT 1,
  `price` bigint(20) unsigned NOT NULL DEFAULT 0,
  `total_price` bigint(20) unsigned NOT NULL DEFAULT 0,
  `snapshot` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_addons_addon_id_foreign` (`addon_id`),
  KEY `order_addons_order_id_addon_id_index` (`order_id`,`addon_id`),
  CONSTRAINT `order_addons_addon_id_foreign` FOREIGN KEY (`addon_id`) REFERENCES `addons` (`id`) ON DELETE SET NULL,
  CONSTRAINT `order_addons_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of order_addons
-- ----------------------------
INSERT INTO `order_addons` (`id`, `order_id`, `addon_id`, `name`, `detail`, `unit`, `quantity`, `price`, `total_price`, `snapshot`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Sound System', 'Speaker aktif, mixer, dan microphone untuk kebutuhan acara.', 'set', 2, 750000, 1500000, '{\"slug\":\"sound-system\",\"image\":\"https:\\/\\/placehold.co\\/600x400\\/2c3e50\\/ffffff?text=Sound+System\",\"icon\":\"bi-speaker\",\"is_quantity_based\":true}', '2026-05-01 23:20:26', '2026-05-01 23:20:26'),
(2, 1, 3, 'Photobooth', 'Area foto dekoratif untuk tamu undangan.', 'set', 2, 1200000, 2400000, '{\"slug\":\"photobooth\",\"image\":\"https:\\/\\/placehold.co\\/600x400\\/9b59b6\\/ffffff?text=Photobooth\",\"icon\":\"bi-camera\",\"is_quantity_based\":true}', '2026-05-01 23:20:26', '2026-05-01 23:20:26'),
(3, 1, 5, 'Genset', 'Genset cadangan listrik untuk acara outdoor.', 'unit', 2, 1000000, 2000000, '{\"slug\":\"genset\",\"image\":\"https:\\/\\/placehold.co\\/600x400\\/34495e\\/ffffff?text=Genset\",\"icon\":\"bi-lightning-charge\",\"is_quantity_based\":true}', '2026-05-01 23:20:26', '2026-05-01 23:20:26'),
(4, 1, 6, 'Kipas Blower', 'Kipas blower untuk area tenda agar lebih nyaman.', 'unit', 2, 150000, 300000, '{\"slug\":\"kipas-blower\",\"image\":\"https:\\/\\/placehold.co\\/600x400\\/17a2b8\\/ffffff?text=Kipas+Blower\",\"icon\":\"bi-wind\",\"is_quantity_based\":true}', '2026-05-01 23:20:26', '2026-05-01 23:20:26'),
(5, 2, 1, 'Sound System', 'Speaker aktif, mixer, dan microphone untuk kebutuhan acara.', 'set', 1, 750000, 750000, '{\"slug\":\"sound-system\",\"image\":\"https:\\/\\/placehold.co\\/600x400\\/2c3e50\\/ffffff?text=Sound+System\",\"icon\":\"bi-speaker\",\"is_quantity_based\":true}', '2026-05-01 23:25:15', '2026-05-01 23:25:15'),
(6, 2, 2, 'Lighting Dekorasi', 'Lampu dekorasi untuk mempercantik area acara.', 'set', 1, 500000, 500000, '{\"slug\":\"lighting-dekorasi\",\"image\":\"https:\\/\\/placehold.co\\/600x400\\/f1c40f\\/000000?text=Lighting\",\"icon\":\"bi-lightbulb\",\"is_quantity_based\":true}', '2026-05-01 23:25:15', '2026-05-01 23:25:15'),
(7, 2, 3, 'Photobooth', 'Area foto dekoratif untuk tamu undangan.', 'set', 1, 1200000, 1200000, '{\"slug\":\"photobooth\",\"image\":\"https:\\/\\/placehold.co\\/600x400\\/9b59b6\\/ffffff?text=Photobooth\",\"icon\":\"bi-camera\",\"is_quantity_based\":true}', '2026-05-01 23:25:15', '2026-05-01 23:25:15'),
(8, 2, 4, 'Panggung Rigging', 'Panggung dan rigging untuk acara besar atau outdoor.', 'set', 1, 2500000, 2500000, '{\"slug\":\"panggung-rigging\",\"image\":\"https:\\/\\/placehold.co\\/600x400\\/e74c3c\\/ffffff?text=Panggung+Rigging\",\"icon\":\"bi-grid-3x3-gap\",\"is_quantity_based\":true}', '2026-05-01 23:25:15', '2026-05-01 23:25:15'),
(9, 2, 5, 'Genset', 'Genset cadangan listrik untuk acara outdoor.', 'unit', 1, 1000000, 1000000, '{\"slug\":\"genset\",\"image\":\"https:\\/\\/placehold.co\\/600x400\\/34495e\\/ffffff?text=Genset\",\"icon\":\"bi-lightning-charge\",\"is_quantity_based\":true}', '2026-05-01 23:25:15', '2026-05-01 23:25:15'),
(10, 2, 6, 'Kipas Blower', 'Kipas blower untuk area tenda agar lebih nyaman.', 'unit', 1, 150000, 150000, '{\"slug\":\"kipas-blower\",\"image\":\"https:\\/\\/placehold.co\\/600x400\\/17a2b8\\/ffffff?text=Kipas+Blower\",\"icon\":\"bi-wind\",\"is_quantity_based\":true}', '2026-05-01 23:25:15', '2026-05-01 23:25:15'),
(11, 3, 1, 'Sound System', 'Speaker aktif, mixer, dan microphone untuk kebutuhan acara.', 'pcs', 2, 750000, 1500000, '{\"slug\":\"sound-system\",\"image\":null,\"icon\":\"bi-speaker\",\"is_quantity_based\":true}', '2026-05-03 19:38:26', '2026-05-03 19:38:26'),
(12, 3, 2, 'Lighting Dekorasi', 'Lampu dekorasi untuk mempercantik area acara.', 'set', 2, 500000, 1000000, '{\"slug\":\"lighting-dekorasi\",\"image\":\"https:\\/\\/placehold.co\\/600x400\\/f1c40f\\/000000?text=Lighting\",\"icon\":\"bi-lightbulb\",\"is_quantity_based\":true}', '2026-05-03 19:38:26', '2026-05-03 19:38:26'),
(13, 3, 3, 'Photobooth', 'Area foto dekoratif untuk tamu undangan.', 'set', 2, 1200000, 2400000, '{\"slug\":\"photobooth\",\"image\":\"https:\\/\\/placehold.co\\/600x400\\/9b59b6\\/ffffff?text=Photobooth\",\"icon\":\"bi-camera\",\"is_quantity_based\":true}', '2026-05-03 19:38:26', '2026-05-03 19:38:26'),
(14, 3, 4, 'Panggung Rigging', 'Panggung dan rigging untuk acara besar atau outdoor.', 'set', 2, 2500000, 5000000, '{\"slug\":\"panggung-rigging\",\"image\":\"https:\\/\\/placehold.co\\/600x400\\/e74c3c\\/ffffff?text=Panggung+Rigging\",\"icon\":\"bi-grid-3x3-gap\",\"is_quantity_based\":true}', '2026-05-03 19:38:26', '2026-05-03 19:38:26'),
(15, 3, 5, 'Genset', 'Genset cadangan listrik untuk acara outdoor.', 'pcs', 2, 1000000, 2000000, '{\"slug\":\"genset\",\"image\":null,\"icon\":\"bi-lightning-charge\",\"is_quantity_based\":true}', '2026-05-03 19:38:26', '2026-05-03 19:38:26'),
(16, 3, 6, 'Kipas Blower', 'Kipas blower untuk area tenda agar lebih nyaman.', 'pcs', 2, 150000, 300000, '{\"slug\":\"kipas-blower\",\"image\":null,\"icon\":\"bi-wind\",\"is_quantity_based\":true}', '2026-05-03 19:38:26', '2026-05-03 19:38:26'),
(17, 4, 2, 'Lighting Dekorasi', 'Lampu dekorasi untuk mempercantik area acara.', 'set', 2, 500000, 1000000, '{\"slug\":\"lighting-dekorasi\",\"image\":\"https:\\/\\/placehold.co\\/600x400\\/f1c40f\\/000000?text=Lighting\",\"icon\":\"bi-lightbulb\",\"is_quantity_based\":true}', '2026-05-03 19:40:16', '2026-05-03 19:40:16'),
(18, 6, 3, 'Photobooth', 'Area foto dekoratif untuk tamu undangan.', 'set', 1, 1200000, 1200000, '{\"slug\":\"photobooth\",\"image\":\"https:\\/\\/placehold.co\\/600x400\\/9b59b6\\/ffffff?text=Photobooth\",\"icon\":\"bi-camera\",\"is_quantity_based\":true}', '2026-05-15 12:21:20', '2026-05-15 12:21:20'),
(19, 7, 1, 'Sound System', 'Speaker aktif, mixer, dan microphone untuk kebutuhan acara.', 'pcs', 1, 750000, 750000, '{\"slug\":\"sound-system\",\"image\":null,\"icon\":\"bi-speaker\",\"is_quantity_based\":true}', '2026-05-15 12:23:25', '2026-05-15 12:23:25'),
(20, 8, 1, 'Sound System', 'Speaker aktif, mixer, dan microphone untuk kebutuhan acara.', 'pcs', 1, 750000, 750000, '{\"slug\":\"sound-system\",\"image\":null,\"icon\":\"bi-speaker\",\"is_quantity_based\":true}', '2026-05-15 14:01:08', '2026-05-15 14:01:08'),
(21, 8, 2, 'Lighting Dekorasi', 'Lampu dekorasi untuk mempercantik area acara.', 'set', 1, 500000, 500000, '{\"slug\":\"lighting-dekorasi\",\"image\":\"https:\\/\\/placehold.co\\/600x400\\/f1c40f\\/000000?text=Lighting\",\"icon\":\"bi-lightbulb\",\"is_quantity_based\":true}', '2026-05-15 14:01:08', '2026-05-15 14:01:08'),
(22, 8, 3, 'Photobooth', 'Area foto dekoratif untuk tamu undangan.', 'set', 1, 1200000, 1200000, '{\"slug\":\"photobooth\",\"image\":\"https:\\/\\/placehold.co\\/600x400\\/9b59b6\\/ffffff?text=Photobooth\",\"icon\":\"bi-camera\",\"is_quantity_based\":true}', '2026-05-15 14:01:08', '2026-05-15 14:01:08'),
(23, 11, 6, 'Kipas Blower', 'Kipas blower untuk area tenda agar lebih nyaman.', 'pcs', 8, 150000, 1200000, '{\"slug\":\"kipas-blower\",\"image\":null,\"icon\":\"bi-wind\",\"is_quantity_based\":true}', '2026-05-18 18:51:22', '2026-05-18 18:51:22'),
(24, 12, 5, 'Genset', 'Genset cadangan listrik untuk acara outdoor.', 'pcs', 1, 1000000, 1000000, '{\"slug\":\"genset\",\"image\":null,\"icon\":\"bi-lightning-charge\",\"is_quantity_based\":true}', '2026-05-18 18:53:41', '2026-05-18 18:53:41'),
(25, 14, 3, 'Photobooth drevary 3x3 meter', 'Area foto dekoratif untuk tamu undangan.', 'set', 1, 1200000, 1200000, '{\"slug\":\"photobooth-drevary-3x3-meter\",\"image\":\"addons\\/01KSD5AVVT1Z6XKR6875QDZ74F.jpg\",\"icon\":\"bi-camera\",\"is_quantity_based\":true}', '2026-06-03 14:27:26', '2026-06-03 14:27:26'),
(26, 14, 4, 'Panggung Rigging', 'Panggung dan rigging untuk acara besar atau outdoor.', 'unit', 4, 2000000, 8000000, '{\"slug\":\"panggung-rigging\",\"image\":\"addons\\/01KSD3SJYPZQEBVD0YS5X5WJRH.png\",\"icon\":\"bi-grid-3x3-gap\",\"is_quantity_based\":true}', '2026-06-03 14:27:26', '2026-06-03 14:27:26'),
(27, 15, 1, 'Sound System', 'Speaker aktif, mixer, dan microphone untuk kebutuhan berbagai acara.', 'set', 2, 1000000, 2000000, '{\"slug\":\"sound-system\",\"image\":\"addons\\/01KS7XRW8SPWYX87HEK77D4923.png\",\"icon\":\"bi-speaker\",\"is_quantity_based\":true}', '2026-06-03 14:37:57', '2026-06-03 14:37:57'),
(28, 16, 2, 'lampu Gantung besar berbagai model', 'Lampu dekorasi untuk mempercantik area acara.', 'Unit', 1, 750000, 750000, '{\"slug\":\"lampu-gantung-besar-berbagai-model\",\"image\":\"addons\\/01KSD54TM5YWJTMGHWVR47H4P2.avif\",\"icon\":\"bi-lightbulb\",\"is_quantity_based\":true}', '2026-06-10 11:01:44', '2026-06-10 11:01:44'),
(29, 16, 4, 'Panggung Rigging', 'Panggung dan rigging untuk acara besar atau outdoor.', 'unit', 1, 2000000, 2000000, '{\"slug\":\"panggung-rigging\",\"image\":\"addons\\/01KSD3SJYPZQEBVD0YS5X5WJRH.png\",\"icon\":\"bi-grid-3x3-gap\",\"is_quantity_based\":true}', '2026-06-10 11:01:44', '2026-06-10 11:01:44');

-- ----------------------------
-- Table structure for order_items
-- ----------------------------
DROP TABLE IF EXISTS `order_items`;
CREATE TABLE `order_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) unsigned NOT NULL,
  `item_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'package',
  `source_id` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` int(10) unsigned NOT NULL DEFAULT 1,
  `price` bigint(20) unsigned NOT NULL DEFAULT 0,
  `total_price` bigint(20) unsigned NOT NULL DEFAULT 0,
  `snapshot` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_items_order_id_item_type_index` (`order_id`,`item_type`),
  CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of order_items
-- ----------------------------
INSERT INTO `order_items` (`id`, `order_id`, `item_type`, `source_id`, `name`, `unit`, `quantity`, `price`, `total_price`, `snapshot`, `created_at`, `updated_at`) VALUES
(1, 1, 'package', 4, 'Paket Event Kantor', 'paket', 1, 7500000, 7500000, '{\"id\":4,\"slug\":\"paket-event-kantor\",\"name\":\"Paket Event Kantor\",\"price\":7500000,\"price_unit\":\"paket\",\"main_image\":\"https:\\/\\/placehold.co\\/800x500\\/34495e\\/ffffff?text=Paket+Event+Kantor\",\"short_description\":\"Paket tenda dan perlengkapan untuk acara kantor atau perusahaan.\"}', '2026-05-01 23:20:26', '2026-05-01 23:20:26'),
(2, 2, 'package', 5, 'Paket Tenda Akbar', 'paket', 1, 12000000, 12000000, '{\"id\":5,\"slug\":\"paket-tenda-akbar\",\"name\":\"Paket Tenda Akbar\",\"price\":12000000,\"price_unit\":\"paket\",\"main_image\":\"https:\\/\\/placehold.co\\/800x500\\/e67e22\\/ffffff?text=Paket+Tenda+Akbar\",\"short_description\":\"Paket tenda besar untuk acara outdoor dan acara skala besar.\"}', '2026-05-01 23:25:15', '2026-05-01 23:25:15'),
(3, 3, 'package', 5, 'Paket Tenda Akbar', 'paket', 1, 12000000, 12000000, '{\"id\":5,\"slug\":\"paket-tenda-akbar\",\"name\":\"Paket Tenda Akbar\",\"price\":12000000,\"price_unit\":\"paket\",\"main_image\":\"https:\\/\\/placehold.co\\/800x500\\/e67e22\\/ffffff?text=Paket+Tenda+Akbar\",\"short_description\":\"Paket tenda besar untuk acara outdoor dan acara skala besar.\"}', '2026-05-03 19:38:26', '2026-05-03 19:38:26'),
(4, 4, 'package', 5, 'Paket Tenda Akbar', 'paket', 1, 12000000, 12000000, '{\"id\":5,\"slug\":\"paket-tenda-akbar\",\"name\":\"Paket Tenda Akbar\",\"price\":12000000,\"price_unit\":\"paket\",\"main_image\":\"https:\\/\\/placehold.co\\/800x500\\/e67e22\\/ffffff?text=Paket+Tenda+Akbar\",\"short_description\":\"Paket tenda besar untuk acara outdoor dan acara skala besar.\"}', '2026-05-03 19:40:16', '2026-05-03 19:40:16'),
(5, 5, 'package', 1, 'Paket Wedding Premium', 'paket', 1, 15000000, 15000000, '{\"id\":1,\"slug\":\"paket-wedding-premium\",\"name\":\"Paket Wedding Premium\",\"price\":15000000,\"price_unit\":\"paket\",\"main_image\":\"packages\\/main\\/01KQJC5FAAV75D9A575Y96J1D6.jpg\",\"short_description\":\"Paket dekorasi pernikahan lengkap untuk acara resepsi besar.\"}', '2026-05-03 22:36:36', '2026-05-03 22:36:36'),
(6, 6, 'package', 3, 'Paket Lamaran', 'paket', 1, 4500000, 4500000, '{\"id\":3,\"slug\":\"paket-lamaran\",\"name\":\"Paket Lamaran\",\"price\":4500000,\"price_unit\":\"paket\",\"main_image\":\"https:\\/\\/placehold.co\\/800x500\\/9b59b6\\/ffffff?text=Paket+Lamaran\",\"short_description\":\"Paket dekorasi untuk acara lamaran dan pertunangan.\"}', '2026-05-15 12:21:20', '2026-05-15 12:21:20'),
(7, 7, 'package', 3, 'Paket Lamaran', 'paket', 1, 4500000, 4500000, '{\"id\":3,\"slug\":\"paket-lamaran\",\"name\":\"Paket Lamaran\",\"price\":4500000,\"price_unit\":\"paket\",\"main_image\":\"https:\\/\\/placehold.co\\/800x500\\/9b59b6\\/ffffff?text=Paket+Lamaran\",\"short_description\":\"Paket dekorasi untuk acara lamaran dan pertunangan.\"}', '2026-05-15 12:23:25', '2026-05-15 12:23:25'),
(8, 8, 'package', 5, 'Paket Tenda Akbar', 'paket', 1, 12000000, 12000000, '{\"id\":5,\"slug\":\"paket-tenda-akbar\",\"name\":\"Paket Tenda Akbar\",\"price\":12000000,\"price_unit\":\"paket\",\"main_image\":\"https:\\/\\/placehold.co\\/800x500\\/e67e22\\/ffffff?text=Paket+Tenda+Akbar\",\"short_description\":\"Paket tenda besar untuk acara outdoor dan acara skala besar.\"}', '2026-05-15 14:01:08', '2026-05-15 14:01:08'),
(9, 9, 'custom', 1, 'Tenda Per Meter', 'meter', 14, 75000, 1050000, '{\"slug\":\"tenda-per-meter\",\"image\":\"https:\\/\\/placehold.co\\/600x400\\/2c7be5\\/ffffff?text=Tenda+Per+Meter\",\"icon\":\"bi-house\",\"unit\":\"meter\"}', '2026-05-15 14:16:38', '2026-05-15 14:16:38'),
(10, 10, 'package', 1, 'Paket Wedding Premium', 'paket', 1, 15000000, 15000000, '{\"id\":1,\"slug\":\"paket-wedding-premium\",\"name\":\"Paket Wedding Premium\",\"price\":15000000,\"price_unit\":\"paket\",\"main_image\":\"packages\\/main\\/01KQJC5FAAV75D9A575Y96J1D6.jpg\",\"short_description\":\"Paket dekorasi pernikahan lengkap untuk acara resepsi besar.\"}', '2026-05-18 18:49:52', '2026-05-18 18:49:52'),
(11, 11, 'package', 2, 'Paket Wedding Standar', 'paket', 1, 9500000, 9500000, '{\"id\":2,\"slug\":\"paket-wedding-standar\",\"name\":\"Paket Wedding Standar\",\"price\":9500000,\"price_unit\":\"paket\",\"main_image\":\"https:\\/\\/placehold.co\\/800x500\\/3498db\\/ffffff?text=Paket+Wedding+Standar\",\"short_description\":\"Paket dekorasi pernikahan standar untuk acara keluarga.\"}', '2026-05-18 18:51:22', '2026-05-18 18:51:22'),
(12, 12, 'package', 3, 'Paket Lamaran', 'paket', 1, 4500000, 4500000, '{\"id\":3,\"slug\":\"paket-lamaran\",\"name\":\"Paket Lamaran\",\"price\":4500000,\"price_unit\":\"paket\",\"main_image\":\"https:\\/\\/placehold.co\\/800x500\\/9b59b6\\/ffffff?text=Paket+Lamaran\",\"short_description\":\"Paket dekorasi untuk acara lamaran dan pertunangan.\"}', '2026-05-18 18:53:41', '2026-05-18 18:53:41'),
(13, 13, 'package', 9, 'PAKET AKAD PREMIUM RP.9.000.000', 'paket', 1, 9000000, 9000000, '{\"id\":9,\"slug\":\"paket-akad-premium-rp9000000\",\"name\":\"PAKET AKAD PREMIUM RP.9.000.000\",\"price\":9000000,\"price_unit\":\"paket\",\"main_image\":\"packages\\/main\\/01KSVE2DNXZKCMWQCY302DGT4W.png\",\"short_description\":\"Paket pernikahan premium dari Decoration Kab. Tangerang yang menghadirkan dekorasi mewah tenda 4\\u00d712, backdrop rumahan elegan, make-up & busana premium lengkap dengan bonus fresh melati, henna, dan softlens, serta dokumentasi 4 jam. Bebas pilih warna kain \"}', '2026-05-30 13:47:35', '2026-05-30 13:47:35'),
(14, 14, 'custom', 1, 'Tenda Per Meter²', 'meter persegi', 10, 60000, 600000, '{\"slug\":\"tenda-per-meter2\",\"image\":\"custom-items\\/01KSEKCQM647HFY6ME3381YCK4.jpeg\",\"icon\":null,\"unit\":\"meter persegi\"}', '2026-06-03 14:27:26', '2026-06-03 14:27:26'),
(15, 14, 'custom', 2, 'Kursi Plastik', 'pcs', 20, 7000, 140000, '{\"slug\":\"kursi-plastik\",\"image\":\"custom-items\\/01KSEJDASKTWPE273NR71G7YCV.webp\",\"icon\":null,\"unit\":\"pcs\"}', '2026-06-03 14:27:26', '2026-06-03 14:27:26'),
(16, 15, 'package', 10, 'PAKET AKAD MINIMALIS RP.8.500.000', 'paket', 1, 8500000, 8500000, '{\"id\":10,\"slug\":\"paket-akad-minimalis-rp8500000\",\"name\":\"PAKET AKAD MINIMALIS RP.8.500.000\",\"price\":8500000,\"price_unit\":\"paket\",\"main_image\":\"packages\\/main\\/01KSW8ZQ6E40FV4Z5T8GQH5MMP.png\",\"short_description\":\"Paket pernikahan elegan dan berkesan dari PT. Didin Tenda Decoration dengan dekorasi tenda 4\\u00d712 lengkap panggung pelaminan 4m, backdrop panggung, make-up & busana standar plus bonus fresh melati, softlens, dan henna, serta dokumentasi 6 jam. \"}', '2026-06-03 14:37:57', '2026-06-03 14:37:57'),
(17, 16, 'custom', 1, 'Tenda Per Meter²', 'meter persegi', 10, 60000, 600000, '{\"slug\":\"tenda-per-meter2\",\"image\":\"custom-items\\/01KSEKCQM647HFY6ME3381YCK4.jpeg\",\"icon\":null,\"unit\":\"meter persegi\"}', '2026-06-10 11:01:44', '2026-06-10 11:01:44'),
(18, 16, 'custom', 2, 'Kursi Plastik', 'pcs', 20, 7000, 140000, '{\"slug\":\"kursi-plastik\",\"image\":\"custom-items\\/01KSEJDASKTWPE273NR71G7YCV.webp\",\"icon\":null,\"unit\":\"pcs\"}', '2026-06-10 11:01:44', '2026-06-10 11:01:44'),
(19, 17, 'package', 10, 'PAKET AKAD MINIMALIS RP.8.500.000', 'paket', 1, 8500000, 8500000, '{\"id\":10,\"slug\":\"paket-akad-minimalis-rp8500000\",\"name\":\"PAKET AKAD MINIMALIS RP.8.500.000\",\"price\":8500000,\"price_unit\":\"paket\",\"main_image\":\"packages\\/main\\/01KSW8ZQ6E40FV4Z5T8GQH5MMP.png\",\"short_description\":\"Paket pernikahan elegan dan berkesan dari PT. Didin Tenda Decoration dengan dekorasi tenda 4\\u00d712 lengkap panggung pelaminan 4m, backdrop panggung, make-up & busana standar plus bonus fresh melati, softlens, dan henna, serta dokumentasi 6 jam. \"}', '2026-06-14 18:34:33', '2026-06-14 18:34:33'),
(20, 18, 'package', 11, 'PAKET AKAD PREMIUM RP.11.500.000', 'paket', 1, 11500000, 11500000, '{\"id\":11,\"slug\":\"paket-akad-premium-rp11500000\",\"name\":\"PAKET AKAD PREMIUM RP.11.500.000\",\"price\":11500000,\"price_unit\":\"paket\",\"main_image\":\"packages\\/main\\/01KSWDMGRD0DRJMY3G7KQ7E8CD.png\",\"short_description\":\"Paket pernikahan paling lengkap dan mewah dari PT. Didin Tenda Decoration Hadir dengan dekorasi tenda 5\\u00d712 + panggung pelaminan 5m, backdrop panggung elegan, make-up & busana premium, dokumentasi foto 4 jam, plus Wedding Content Creator \"}', '2026-06-20 22:11:23', '2026-06-20 22:11:23'),
(21, 19, 'package', 8, 'PAKET AKAD MINIMALIS RP.7.500.000', 'paket', 1, 7500000, 7500000, '{\"id\":8,\"slug\":\"paket-akad-minimalis-rp7500000\",\"name\":\"PAKET AKAD MINIMALIS RP.7.500.000\",\"price\":7500000,\"price_unit\":\"paket\",\"main_image\":\"packages\\/main\\/01KSVC3DZWS1PGBKRCD9ETM31E.png\",\"short_description\":\"Paket lengkap pernikahan dari PT. Didin Tenda Decoration yang mencakup dekorasi tenda (4\\u00d78), backdrop rumahan, make-up & busana pengantin, serta dokumentasi 6 jam. Bebas pilih warna kain dan tema backdrop. \"}', '2026-06-20 22:24:03', '2026-06-20 22:24:03');

-- ----------------------------
-- Table structure for orders
-- ----------------------------
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `invoice_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `package_id` bigint(20) unsigned DEFAULT NULL,
  `order_type` enum('package','custom') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'package',
  `customer_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event_date` date NOT NULL,
  `event_location_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event_address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event_latitude` decimal(10,7) DEFAULT NULL,
  `event_longitude` decimal(10,7) DEFAULT NULL,
  `distance_km` decimal(8,2) DEFAULT NULL,
  `shipping_fee` bigint(20) unsigned NOT NULL DEFAULT 0,
  `subtotal_package` bigint(20) unsigned NOT NULL DEFAULT 0,
  `subtotal_custom` bigint(20) unsigned NOT NULL DEFAULT 0,
  `subtotal_addons` bigint(20) unsigned NOT NULL DEFAULT 0,
  `total_price` bigint(20) unsigned NOT NULL DEFAULT 0,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'waiting_payment',
  `payment_status` enum('unpaid','pending','paid','expired','failed','cancelled','refunded') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unpaid',
  `payment_deadline` timestamp NULL DEFAULT NULL,
  `paid_at` timestamp NULL DEFAULT NULL,
  `confirmed_at` timestamp NULL DEFAULT NULL,
  `invoice_sent_at` timestamp NULL DEFAULT NULL,
  `processed_at` timestamp NULL DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `cancelled_at` timestamp NULL DEFAULT NULL,
  `cancelled_reason` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `orders_invoice_number_unique` (`invoice_number`),
  KEY `orders_package_id_foreign` (`package_id`),
  KEY `orders_event_date_status_index` (`event_date`,`status`),
  KEY `orders_user_id_status_index` (`user_id`,`status`),
  KEY `orders_payment_status_index` (`payment_status`),
  CONSTRAINT `orders_package_id_foreign` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE SET NULL,
  CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of orders
-- ----------------------------
INSERT INTO `orders` (`id`, `invoice_number`, `user_id`, `package_id`, `order_type`, `customer_name`, `customer_phone`, `customer_email`, `event_date`, `event_location_name`, `event_address`, `event_latitude`, `event_longitude`, `distance_km`, `shipping_fee`, `subtotal_package`, `subtotal_custom`, `subtotal_addons`, `total_price`, `status`, `payment_status`, `payment_deadline`, `paid_at`, `confirmed_at`, `invoice_sent_at`, `processed_at`, `completed_at`, `cancelled_at`, `cancelled_reason`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'INV/2026/0001-HAZU', 2, NULL, 'package', 'ARHAN MALIK ALRASYID', '082112123333', 'arhanmali96@gmail.com', '2026-05-14', 'ACARA NIKAHAN WAHYU', 'Panongan, Kabupaten Tangerang, Banten, Jawa, 15711, Indonesia', '-6.2795471', '106.5304957', '13.84', 20000, 7500000, 0, 6200000, 13720000, 'confirmed', 'paid', '2026-05-02 23:20:26', '2026-05-01 23:20:56', '2026-05-01 23:20:56', '2026-05-01 23:20:56', NULL, NULL, NULL, NULL, NULL, '2026-05-01 23:20:26', '2026-05-01 23:20:56'),
(2, 'INV/2026/0002-FDED', 2, NULL, 'package', 'ARHAN MALIK ALRASYID', '082112123333', 'arhanmali96@gmail.com', '2026-05-19', 'DJNCLOUD HOSTING', 'Balaraja, Kabupaten Tangerang, Banten, Jawa, Indonesia', '-6.1911184', '106.4627867', '11.69', 10000, 12000000, 0, 6100000, 18110000, 'confirmed', 'paid', '2026-05-02 23:25:15', '2026-05-01 23:26:03', '2026-05-01 23:26:03', '2026-05-01 23:26:03', NULL, NULL, NULL, NULL, NULL, '2026-05-01 23:25:15', '2026-05-01 23:26:03'),
(3, 'INV/2026/0003-XXAJ', 3, NULL, 'package', 'JACOBI JAWARNA', '082123333344', 'arhanmcz@gmail.com', '2026-05-27', 'GEDUNG BIRAWA CAKRA', 'Bursa Efek Jakarta, Kav 52-53, Sudirman Central Business District Northway, RW 03, Senayan, Kebayoran Baru, Jakarta Selatan, Daerah Khusus Ibukota Jakarta, Jawa, 12190, Indonesia', '-6.2236851', '106.8086123', '48.06', 290000, 12000000, 0, 12200000, 24490000, 'confirmed', 'paid', '2026-05-04 19:38:26', '2026-05-03 19:38:42', '2026-05-03 19:38:42', '2026-05-03 19:38:42', NULL, NULL, NULL, NULL, NULL, '2026-05-03 19:38:26', '2026-05-03 19:38:42'),
(4, 'INV/2026/0004-LQ6G', 3, NULL, 'package', 'arhan malik', '082222222211', 'arhanmcz@gmail.com', '2026-05-15', 'ESA UNGGUL LEADERSHIP', 'Universitas Esa Unggul, Jalan Arjuna Utara, RW 02, Duri Kepa, Kebon Jeruk, Jakarta Barat, Daerah Khusus Ibukota Jakarta, Jawa, 11430, Indonesia', '-6.1856846', '106.7789088', '39.68', 200000, 12000000, 0, 1000000, 13200000, 'confirmed', 'paid', '2026-05-04 19:40:16', '2026-05-03 19:40:28', '2026-05-03 19:40:28', '2026-05-03 19:40:28', NULL, NULL, NULL, NULL, NULL, '2026-05-03 19:40:16', '2026-05-03 19:40:28'),
(5, 'INV/2026/0005-C6XS', 3, NULL, 'package', 'arhan malik', '089966669999', 'arhanmcz@gmail.com', '2026-05-20', 'ATHAR NIKAH SAMA AVERY', 'Universitas Esa Unggul, Jalan Arjuna Utara, RW 02, Duri Kepa, Kebon Jeruk, Jakarta Barat, Daerah Khusus Ibukota Jakarta, Jawa, 11430, Indonesia', '-6.1856846', '106.7789088', '39.68', 200000, 15000000, 0, 0, 15200000, 'confirmed', 'paid', '2026-05-04 22:36:36', '2026-05-03 22:37:18', '2026-05-03 22:37:18', '2026-05-03 22:37:18', NULL, NULL, NULL, NULL, NULL, '2026-05-03 22:36:36', '2026-05-03 22:37:18'),
(6, 'INV/2026/0006-UJYE', 2, NULL, 'package', 'ARHAN MALIK ALRASYID', '082112123333', 'arhanmali96@gmail.com', '2026-05-28', 'testtttt', 'Universitas Esa Unggul, Jalan Arjuna Utara, RW 02, Duri Kepa, Kebon Jeruk, Jakarta Barat, Daerah Khusus Ibukota Jakarta, Jawa, 11430, Indonesia', '-6.1856846', '106.7789088', '39.68', 200000, 4500000, 0, 1200000, 5900000, 'confirmed', 'paid', '2026-05-16 12:21:20', '2026-05-15 12:21:43', '2026-05-15 12:21:43', '2026-05-15 12:21:43', NULL, NULL, NULL, NULL, NULL, '2026-05-15 12:21:20', '2026-05-15 12:21:43'),
(7, 'INV/2026/0007-HXDX', 3, NULL, 'package', 'arhan malik', '082122222222', 'arhanmcz@gmail.com', '2026-05-22', 'ESA UNGGUL LEADERSHIP', 'Universitas Esa Unggul, Jalan Inspeksi BKT, RW 03, Ujung Menteng, Cilincing, Jakarta Utara, Pusakarakyat, Kab Bekasi, Jawa Barat, Jawa, 17214, Indonesia', '-6.1582481', '106.9728742', '68.13', 490000, 4500000, 0, 750000, 5740000, 'confirmed', 'paid', '2026-05-16 12:23:25', '2026-05-15 12:23:47', '2026-05-15 12:23:47', '2026-05-15 12:23:47', NULL, NULL, NULL, NULL, NULL, '2026-05-15 12:23:25', '2026-05-15 12:23:47'),
(8, 'INV/2026/0008-MRPN', 6, NULL, 'package', 'Muhamad Darlan', '088289258764', 'muhamaddarlan76@gmail.com', '2026-05-22', 'gedung serbaguna tangerang', 'Universitas Esa Unggul, Jalan Inspeksi BKT, RW 03, Ujung Menteng, Cilincing, Jakarta Utara, Pusakarakyat, Kab Bekasi, Jawa Barat, Jawa, 17214, Indonesia', '-6.1582481', '106.9728742', '68.13', 490000, 12000000, 0, 2450000, 14940000, 'confirmed', 'paid', '2026-05-16 14:01:08', '2026-05-15 14:03:05', '2026-05-15 14:03:05', '2026-05-15 14:03:05', NULL, NULL, NULL, NULL, NULL, '2026-05-15 14:01:08', '2026-05-15 14:03:05'),
(9, 'INV/2026/0009-E9SH', 1, NULL, 'custom', 'Admin', '088289258764', 'admin@admin.com', '2026-05-27', 'gedung serbaguna tangerang', 'Esa Unggul University, Jalan Arjuna Utara, RW 02, Duri Kepa, Kebon Jeruk, West Jakarta, Special Capital Region of Jakarta, Java, 11430, Indonesia', '-6.1856846', '106.7789088', '39.88', 150000, 0, 1050000, 0, 1200000, 'confirmed', 'paid', '2026-05-16 14:16:38', '2026-05-15 14:19:01', '2026-05-15 14:19:01', '2026-05-15 14:19:01', NULL, NULL, NULL, NULL, NULL, '2026-05-15 14:16:38', '2026-05-15 14:19:01'),
(10, 'INV/2026/0010-MDXD', 3, NULL, 'package', 'athar suki', '082122222222', 'arhanmcz@gmail.com', '2026-05-19', 'test', 'Universitas Esa Unggul, Jalan Arjuna Utara, RW 02, Duri Kepa, Kebon Jeruk, Jakarta Barat, Daerah Khusus Ibukota Jakarta, Jawa, 11430, Indonesia', '-6.1856846', '106.7789088', '39.68', 200000, 15000000, 0, 0, 15200000, 'confirmed', 'paid', '2026-05-19 18:49:52', '2026-05-18 18:50:12', '2026-05-18 18:50:12', '2026-05-18 18:50:12', NULL, NULL, NULL, NULL, NULL, '2026-05-18 18:49:52', '2026-05-18 18:50:12'),
(11, 'INV/2026/0011-D33K', 3, NULL, 'package', 'FATHAN SUKI', '082233333333', 'arhanmcz@gmail.com', '2026-05-19', 'test', 'Universitas Esa Unggul, Jalan Inspeksi BKT, RW 03, Ujung Menteng, Cilincing, Jakarta Utara, Pusakarakyat, Kab Bekasi, Jawa Barat, Jawa, 17214, Indonesia', '-6.1582481', '106.9728742', '68.13', 490000, 9500000, 0, 1200000, 11190000, 'confirmed', 'paid', '2026-05-19 18:51:22', '2026-05-18 18:51:43', '2026-05-18 18:51:43', '2026-05-18 18:51:43', NULL, NULL, NULL, NULL, NULL, '2026-05-18 18:51:22', '2026-05-18 18:51:43'),
(12, 'INV/2026/0012-GE4R', 3, NULL, 'package', 'DARLAN SUKI', '089909999999', 'arhanmcz@gmail.com', '2026-05-19', 'test', 'Jalan Krama Yudha Kampung Petukangan, RW 05, Rawa Terate, Cakung, Jakarta Timur, Daerah Khusus Ibukota Jakarta, Jawa, 13920, Indonesia', '-6.1798055', '106.9221190', '58.18', 390000, 4500000, 0, 1000000, 5890000, 'confirmed', 'paid', '2026-05-19 18:53:41', '2026-05-18 18:53:59', '2026-05-18 18:53:59', '2026-05-18 18:53:59', NULL, NULL, NULL, NULL, NULL, '2026-05-18 18:53:41', '2026-05-18 18:53:59'),
(13, 'INV/2026/0013-DTC8', 3, 9, 'package', 'arhan malik', '082111565144', 'arhanmcz@gmail.com', '2026-06-03', 'gedung vincent', 'West Jakarta City', '-6.1856846', '106.7789088', '39.68', 200000, 9000000, 0, 0, 9200000, 'confirmed', 'paid', '2026-05-31 13:47:35', '2026-05-30 13:48:25', '2026-05-30 13:48:25', '2026-05-30 13:48:25', NULL, NULL, NULL, NULL, NULL, '2026-05-30 13:47:35', '2026-05-30 13:48:25'),
(14, 'INV/2026/0014-KXZZ', 1, NULL, 'custom', 'darlan', '088289258764', 'admin@admin.com', '2026-06-04', 'Masjid Universitas Esa Unggul', 'Masjid Universitas Esa Unggul, Jalan Haji Niming, RW 02, Duri Kepa, Kebon Jeruk, West Jakarta, Special Capital Region of Jakarta, Java, 11430, Indonesia', '-6.1836986', '106.7795913', '40.13', 155000, 0, 740000, 9200000, 10095000, 'confirmed', 'paid', '2026-06-04 14:27:26', '2026-06-03 14:28:38', '2026-06-03 14:28:38', '2026-06-03 14:28:38', NULL, NULL, NULL, NULL, NULL, '2026-06-03 14:27:26', '2026-06-03 14:28:38'),
(15, 'INV/2026/0015-T6CA', 9, 10, 'package', 'abcdef', '088289258764', 'didintendaa@gmail.com', '2026-06-05', 'Masjid Universitas Esa Unggul', 'Masjid Universitas Esa Unggul, Jalan Haji Niming, RW 02, Duri Kepa, Kebon Jeruk, Jakarta Barat, Daerah Khusus Ibukota Jakarta, Jawa, 11430, Indonesia', '-6.1836986', '106.7795913', '39.93', 200000, 8500000, 0, 2000000, 10700000, 'confirmed', 'paid', '2026-06-04 14:37:57', '2026-06-03 14:38:34', '2026-06-03 14:38:34', '2026-06-03 14:38:34', NULL, NULL, NULL, NULL, NULL, '2026-06-03 14:37:57', '2026-06-03 14:38:34'),
(16, 'INV/2026/0016-MZDE', 9, NULL, 'custom', 'Muhamad Darlan', '088289258764', 'didintendaa@gmail.com', '2026-06-11', 'Masjid Universitas Esa Unggul', 'Kampus Gunadarma, Jalan Boulevard Raya, RW 14, Cengkareng Timur, Cengkareng, West Jakarta, Special Capital Region of Jakarta, 11730, Indonesia', '-6.1344655', '106.7333605', '39.63', 150000, 0, 740000, 2750000, 3640000, 'confirmed', 'paid', '2026-06-11 11:01:44', '2026-06-10 11:03:12', '2026-06-10 11:03:12', '2026-06-10 11:03:12', NULL, NULL, NULL, NULL, NULL, '2026-06-10 11:01:44', '2026-06-10 11:03:12'),
(17, 'INV/2026/0017-CMFO', 3, 10, 'package', 'arhan malik alrasyid', '082111565144', 'arhanmcz@gmail.com', '2026-08-14', 'GEDUNG PAK ANGGARA', 'West Jakarta City', '-6.1856846', '106.7789088', '39.68', 200000, 8500000, 0, 0, 8700000, 'confirmed', 'paid', '2026-06-15 18:34:33', '2026-06-14 18:34:49', '2026-06-14 18:34:49', '2026-06-14 18:34:49', NULL, NULL, NULL, NULL, NULL, '2026-06-14 18:34:33', '2026-06-14 18:34:49'),
(18, 'INV/2026/0018-RMEY', 10, 11, 'package', 'Nindyy', '081398889380', 'nindyabp95@gmail.com', '2026-06-30', 'Rumah sendiri', 'Suka Mulya, Kabupaten Tangerang, Cikupa, Banten, 15710, Indonesia', '-6.2428171', '106.5078868', '9.21', 0, 11500000, 0, 0, 11500000, 'waiting_payment', 'pending', '2026-06-21 22:11:23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-20 22:11:23', '2026-06-20 22:11:35'),
(19, 'INV/2026/0019-LM9T', 10, 8, 'package', 'Nindyy', '081398889380', 'nindyabp95@gmail.com', '2026-06-26', 'Rumah', 'Suka Mulya, Kabupaten Tangerang, Cikupa, Banten, 15710, Indonesia', '-6.2397978', '106.5048465', '8.71', 0, 7500000, 0, 0, 7500000, 'confirmed', 'paid', '2026-06-21 22:24:03', '2026-06-20 22:44:14', '2026-06-20 22:44:14', '2026-06-20 22:44:14', NULL, NULL, NULL, NULL, NULL, '2026-06-20 22:24:03', '2026-06-20 22:44:14');

-- ----------------------------
-- Table structure for package_items
-- ----------------------------
DROP TABLE IF EXISTS `package_items`;
CREATE TABLE `package_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `package_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int(10) unsigned DEFAULT NULL,
  `unit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int(10) unsigned NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `package_items_package_id_foreign` (`package_id`),
  CONSTRAINT `package_items_package_id_foreign` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of package_items
-- ----------------------------
INSERT INTO `package_items` (`id`, `package_id`, `name`, `quantity`, `unit`, `description`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(30, 8, 'Tenda 8x4 dan Prasmaann set full dekorasi', 1, 'unit', 'warna bebas pilih', 0, 1, '2026-05-30 09:53:04', '2026-05-30 09:53:04'),
(31, 8, 'Kipas Blower', 1, 'unit', NULL, 0, 1, '2026-05-30 09:53:25', '2026-05-30 09:53:25'),
(32, 8, 'make up dan busana', 1, 'paket', '\n\n1 sesi make-up, kebaya akad, beskap akad, siger atau mahkota, dan artificial melati.', 0, 1, '2026-05-30 09:54:16', '2026-05-30 09:59:53'),
(33, 8, 'Kipas Blower', 1, 'pcs', NULL, 0, 1, '2026-05-30 10:00:38', '2026-05-30 10:00:38'),
(34, 9, 'tenda dekorasi 4x12 full dekorasi lengkap prasmanan set', 1, 'set', NULL, 0, 1, '2026-05-30 10:16:58', '2026-05-30 10:16:58'),
(35, 9, 'Kipas Blower', 1, 'pcs', NULL, 0, 1, '2026-05-30 10:22:26', '2026-05-30 10:22:26'),
(36, 9, 'kursi tamu ', 50, 'pcs', NULL, 0, 1, '2026-05-30 10:23:36', '2026-05-30 10:23:36'),
(37, 9, 'backdrop rumahan 1 set', NULL, NULL, NULL, 0, 1, '2026-05-30 10:24:19', '2026-05-30 10:24:19'),
(38, 9, 'makeup dan busana 1xmakeup dan kebaya akad dan beskap akad', 1, 'hari', NULL, 0, 1, '2026-05-30 10:25:28', '2026-05-30 10:25:28'),
(39, 9, 'Dokumentasi Fotograper ', 4, 'jam', NULL, 0, 1, '2026-05-30 10:26:07', '2026-05-30 10:26:07'),
(40, 10, 'tenda dekorasi 4x12m lengkap dekorasi prasmanan set', 1, 'set', NULL, 0, 1, '2026-05-30 18:11:30', '2026-05-30 18:11:30'),
(41, 10, 'Satu set Backdrop panggung lengkap Ukuran tersedia: 2×2, 3×3, atau 2×3', 1, 'set', NULL, 0, 1, '2026-05-30 18:13:40', '2026-05-30 18:13:40'),
(42, 10, 'Make-up & busana 1 sesi make-up, kebaya akad, beskap akad, siger/mahkota, fresh melati. ', NULL, '1 set', NULL, 0, 1, '2026-05-30 18:14:33', '2026-05-30 18:14:33'),
(43, 10, '1 fotografer, file dokumen dalam flashdisk, dengan  6 jam.', NULL, NULL, NULL, 0, 1, '2026-05-30 18:15:02', '2026-05-30 18:16:17'),
(44, 11, 'Tenda 5x12 full dekorasi dan prasmanan set', 1, 'set', NULL, 0, 1, '2026-05-30 19:42:23', '2026-05-30 19:42:23'),
(45, 11, 'kursi meja dan lainnya untuk 100 orang', NULL, NULL, NULL, 0, 1, '2026-05-30 19:59:33', '2026-05-30 19:59:33'),
(46, 11, '1 sesi make-up, kebaya akad, beskap akad, siger/solo putri/modern', 1, 'set', NULL, 0, 1, '2026-05-30 20:01:58', '2026-05-30 20:01:58');

-- ----------------------------
-- Table structure for packages
-- ----------------------------
DROP TABLE IF EXISTS `packages`;
CREATE TABLE `packages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('fixed','custom') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'fixed',
  `short_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` bigint(20) unsigned NOT NULL DEFAULT 0,
  `price_unit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'paket',
  `main_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `badge` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_popular` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(10) unsigned NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `packages_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of packages
-- ----------------------------
INSERT INTO `packages` (`id`, `name`, `slug`, `type`, `short_description`, `description`, `price`, `price_unit`, `main_image`, `images`, `color`, `badge`, `is_popular`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(8, 'PAKET AKAD MINIMALIS RP.7.500.000', 'paket-akad-minimalis-rp7500000', 'fixed', 'Paket lengkap pernikahan dari PT. Didin Tenda Decoration yang mencakup dekorasi tenda (4×8), backdrop rumahan, make-up & busana pengantin, serta dokumentasi 6 jam. Bebas pilih warna kain dan tema backdrop. ', 'Paket Akad Minimalis — Rp 7.500.000\n\nDekorasi\n\nTenda ukuran 4×8 lengkap dengan dekorasi kain dan lampu, 5 meja kotak, 2 meja bulat, karpet tenda, lighting tenda, kotak uang, 40 kursi dengan sarung, 1 set perasmanan minimalis, dan 100 set alat makan.\n\nAlat pendukung\n\nBlower atau kipas angin. Klien bebas memilih warna kain dan tema backdrop yang telah disediakan.\n\nBackdrop rumahan\n\nUkuran tersedia: 2×2, 3×3, atau 2×3 (disesuaikan foto dan lokasi). Termasuk backdrop rumahan, sofa/kursi pengantin, flower artificial, karpet, standing flower, standing foto, dan lighting backdrop.\n\nMake-up & busana\n\n1 sesi make-up, kebaya akad, beskap akad, siger atau mahkota, dan artificial melati.\n\nDokumentasi\n\n1 fotografer profesional, file dokumen disimpan dalam flashdisk, dengan durasi kerja 6 jam.\n\n', 7500000, 'paket', 'packages/main/01KSVC3DZWS1PGBKRCD9ETM31E.png', '[]', NULL, NULL, 0, 1, 0, '2026-05-30 09:41:07', '2026-05-30 18:07:50'),
(9, 'PAKET AKAD PREMIUM RP.9.000.000', 'paket-akad-premium-rp9000000', 'fixed', 'Paket pernikahan premium dari PT. Didin Tenda Decoration yang menghadirkan dekorasi mewah tenda 4×12, backdrop rumahan elegan, make-up & busana premium lengkap dengan bonus fresh melati, henna, dan softlens, serta dokumentasi 4 jam. ', 'Dekorasi\n\nTenda ukuran 4×12 dengan dekorasi kain dan lampu, meja prasmanan, pagar ayu, meja buah, karpet full, lighting tenda, 50 kursi dengan sarung, 1 set perasmanan, 100 set alat makan, gapura depan, dan kotak uang.\n\nAlat pendukung\n\nKipas angin atau blower. Klien bebas memilih warna kain dan tema backdrop yang telah disediakan.\n\nBackdrop rumahan\n\nUkuran tersedia: 2×2, 3×3, atau 2×3 (disesuaikan foto dan lokasi). Termasuk sofa/kursi pengantin, flower artificial, karpet, standing flower, standing foto, dan lighting backdrop.\n\nMake-up & busana premium\n\n1 sesi make-up, kebaya akad, beskap akad, siger/sulo putri/modern. FREE fresh melati, henna white tangan, dan softlens minus/normal.\n\nDokumentasi premium\n\n1 fotografer profesional, file dokumen tersimpan dalam flashdisk, dengan durasi kerja 4 jam.', 9000000, 'paket', 'packages/main/01KSVE2DNXZKCMWQCY302DGT4W.png', '[]', NULL, NULL, 0, 1, 3, '2026-05-30 10:15:31', '2026-05-30 20:19:34'),
(10, 'PAKET AKAD MINIMALIS RP.8.500.000', 'paket-akad-minimalis-rp8500000', 'fixed', 'Paket pernikahan elegan dan berkesan dari PT. Didin Tenda Decoration dengan dekorasi tenda 4×12 lengkap panggung pelaminan 4m, backdrop panggung, make-up & busana standar plus bonus fresh melati, softlens, dan henna, serta dokumentasi 6 jam. ', '\nTenda 36 m² (4×12) dengan dekorasi kain dan lampu, panggung pelaminan 4m, 5 meja kotak, 3 meja bulat, karpet full, kotak uang, lighting tenda, 70 kursi plastik dengan sarung, 1 set perasmanan minimalis, dan 100 set alat makan.\n\nAlat pendukung\n\nBlower atau kipas angin. Klien bebas memilih warna kain dan tema backdrop yang telah disediakan.\n\nBackdrop panggung\n\nUkuran tersedia: 2×2, 3×3, atau 2×3 (disesuaikan foto dan lokasi). Termasuk backdrop panggung, sofa/kursi pengantin, flower artificial over, karpet, standing flower, standing foto, dan lighting backdrop.\n\nMake-up & busana standar\n\n1 sesi make-up, kebaya akad, beskap akad, siger/mahkota, fresh melati. FREE softlens normal/minus dan henna white tempel.\n\nDokumentasi standar\n\n1 fotografer profesional, file dokumen tersimpan dalam flashdisk, dengan durasi kerja 6 jam.', 8500000, 'paket', 'packages/main/01KSW8ZQ6E40FV4Z5T8GQH5MMP.png', '[]', NULL, NULL, 0, 1, 0, '2026-05-30 18:05:54', '2026-05-30 20:20:13'),
(11, 'PAKET AKAD PREMIUM RP.11.500.000', 'paket-akad-premium-rp11500000', 'fixed', 'Paket pernikahan paling lengkap dan mewah dari PT. Didin Tenda Decoration Hadir dengan dekorasi tenda 5×12 + panggung pelaminan 5m, backdrop panggung elegan, make-up & busana premium, dokumentasi foto 4 jam, plus Wedding Content Creator ', NULL, 11500000, 'paket', 'packages/main/01KSWDMGRD0DRJMY3G7KQ7E8CD.png', '[]', NULL, NULL, 0, 1, 4, '2026-05-30 19:27:10', '2026-05-30 20:21:34');

-- ----------------------------
-- Table structure for password_reset_tokens
-- ----------------------------
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of password_reset_tokens
-- ----------------------------
INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('arhanmali96@gmail.com', '$2y$12$TUB55dYV5RY0GI34ErgyTuCYMJccmKIJAbEBjdDEwLuQ/pSkNwuiG', '2026-05-02 13:02:57'),
('arhanmcz@gmail.com', '$2y$12$NBnJEI712Shk7Lt/qRF0x.zbzI2xMrSaE0/Ern9ylRNxRgtfNlZJe', '2026-05-03 22:38:43'),
('rasyidmalik456@gmail.com', '$2y$12$iP89ckqm4qet7t14bhNGWewD.g8BvNrXaIGFH65.rttX4mjrSAIW.', '2026-05-02 05:45:17');

-- ----------------------------
-- Table structure for payments
-- ----------------------------
DROP TABLE IF EXISTS `payments`;
CREATE TABLE `payments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) unsigned NOT NULL,
  `payment_gateway` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'midtrans',
  `midtrans_order_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `snap_token` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect_url` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gross_amount` bigint(20) unsigned NOT NULL DEFAULT 0,
  `currency` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'IDR',
  `payment_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `va_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `permata_va_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bill_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `biller_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pdf_url` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `fraud_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_message` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `paid_at` timestamp NULL DEFAULT NULL,
  `expired_at` timestamp NULL DEFAULT NULL,
  `cancelled_at` timestamp NULL DEFAULT NULL,
  `raw_response` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `payments_order_id_unique` (`order_id`),
  UNIQUE KEY `payments_midtrans_order_id_unique` (`midtrans_order_id`),
  KEY `payments_order_id_index` (`order_id`),
  KEY `payments_midtrans_order_id_index` (`midtrans_order_id`),
  KEY `payments_transaction_id_index` (`transaction_id`),
  KEY `payments_transaction_status_index` (`transaction_status`),
  KEY `payments_payment_status_index` (`payment_status`),
  CONSTRAINT `payments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of payments
-- ----------------------------
INSERT INTO `payments` (`id`, `order_id`, `payment_gateway`, `midtrans_order_id`, `transaction_id`, `snap_token`, `redirect_url`, `gross_amount`, `currency`, `payment_type`, `bank`, `va_number`, `permata_va_number`, `bill_key`, `biller_code`, `pdf_url`, `transaction_status`, `fraud_status`, `status_code`, `status_message`, `payment_status`, `paid_at`, `expired_at`, `cancelled_at`, `raw_response`, `created_at`, `updated_at`) VALUES
(1, 1, 'midtrans', 'DT-1-20260501232034', 'b019f821-7687-45eb-a3f6-c0f1dc1bf29e', '015e88fa-5d25-4263-8342-2251aea12584', 'https://app.sandbox.midtrans.com/snap/v4/redirection/015e88fa-5d25-4263-8342-2251aea12584', 13720000, 'IDR', 'bank_transfer', 'bca', '26955753869186737873479', NULL, NULL, NULL, NULL, 'settlement', 'accept', '200', 'Success, transaction is found', 'paid', '2026-05-01 23:20:56', NULL, NULL, '{\"status_code\":\"200\",\"transaction_id\":\"b019f821-7687-45eb-a3f6-c0f1dc1bf29e\",\"gross_amount\":\"13720000.00\",\"currency\":\"IDR\",\"order_id\":\"DT-1-20260501232034\",\"payment_type\":\"bank_transfer\",\"signature_key\":\"779c286f0783200d66d5dad0f21c6a7004189978626cd8ddf0086497639d3262fe0c3403e1630e553b1b6ba725afbaa0e25f219736c5e7f3f72a2c449bbcd4d5\",\"transaction_status\":\"settlement\",\"fraud_status\":\"accept\",\"status_message\":\"Success, transaction is found\",\"merchant_id\":\"G110926955\",\"va_numbers\":[{\"bank\":\"bca\",\"va_number\":\"26955753869186737873479\"}],\"payment_amounts\":[],\"transaction_time\":\"2026-05-01 23:20:36\",\"settlement_time\":\"2026-05-01 23:20:52\",\"expiry_time\":\"2026-05-02 23:20:36\"}', '2026-05-01 23:20:34', '2026-05-01 23:20:56'),
(2, 2, 'midtrans', 'DT-2-20260501232525', '630deefb-dd51-4451-8a0e-873231d1580d', '6f465237-980e-40f3-a932-7050ca8e886c', 'https://app.sandbox.midtrans.com/snap/v4/redirection/6f465237-980e-40f3-a932-7050ca8e886c', 18110000, 'IDR', 'bank_transfer', 'bca', '26955399346659351177003', NULL, NULL, NULL, NULL, 'settlement', 'accept', '200', 'Success, transaction is found', 'paid', '2026-05-01 23:26:03', NULL, NULL, '{\"status_code\":\"200\",\"transaction_id\":\"630deefb-dd51-4451-8a0e-873231d1580d\",\"gross_amount\":\"18110000.00\",\"currency\":\"IDR\",\"order_id\":\"DT-2-20260501232525\",\"payment_type\":\"bank_transfer\",\"signature_key\":\"4b702022d104427ee3a9704a46fa1d960b53bd7a10790c85b4aff249b8bd61e6d051fed9a3a6366b48109ba05cd9bc31e5a1ad42aed077a4762d9920d2d28267\",\"transaction_status\":\"settlement\",\"fraud_status\":\"accept\",\"status_message\":\"Success, transaction is found\",\"merchant_id\":\"G110926955\",\"va_numbers\":[{\"bank\":\"bca\",\"va_number\":\"26955399346659351177003\"}],\"payment_amounts\":[],\"transaction_time\":\"2026-05-01 23:25:27\",\"settlement_time\":\"2026-05-01 23:25:43\",\"expiry_time\":\"2026-05-02 23:25:27\"}', '2026-05-01 23:25:26', '2026-05-01 23:26:03'),
(3, 3, 'midtrans', 'DT-3-20260503193829', '6acd75b0-1412-41ee-bbfa-0b5c91ff02c8', '6f4f55d1-8bf4-440e-aa55-ac4c65ae5fb4', 'https://app.sandbox.midtrans.com/snap/v4/redirection/6f4f55d1-8bf4-440e-aa55-ac4c65ae5fb4', 24490000, 'IDR', 'bank_transfer', 'bca', '26955862653666003980094', NULL, NULL, NULL, NULL, 'settlement', 'accept', '200', 'Success, transaction is found', 'paid', '2026-05-03 19:38:42', NULL, NULL, '{\"status_code\":\"200\",\"transaction_id\":\"6acd75b0-1412-41ee-bbfa-0b5c91ff02c8\",\"gross_amount\":\"24490000.00\",\"currency\":\"IDR\",\"order_id\":\"DT-3-20260503193829\",\"payment_type\":\"bank_transfer\",\"signature_key\":\"2262d6f8761efdc66bc3b8278929c0cef5a39206a2099bcf34a0e7d0541701cc43365fc9cfd69be16826b533d7fcb65ffe58f56990f59394afa7fcf75dda0f40\",\"transaction_status\":\"settlement\",\"fraud_status\":\"accept\",\"status_message\":\"Success, transaction is found\",\"merchant_id\":\"G110926955\",\"va_numbers\":[{\"bank\":\"bca\",\"va_number\":\"26955862653666003980094\"}],\"payment_amounts\":[],\"transaction_time\":\"2026-05-03 19:38:31\",\"settlement_time\":\"2026-05-03 19:38:39\",\"expiry_time\":\"2026-05-04 19:38:31\"}', '2026-05-03 19:38:30', '2026-05-03 19:38:42'),
(4, 4, 'midtrans', 'DT-4-20260503194018', '9810e6ef-3156-464d-bb35-0803c883eeba', '3faeabf4-1f8f-49c0-b353-027791573ca8', 'https://app.sandbox.midtrans.com/snap/v4/redirection/3faeabf4-1f8f-49c0-b353-027791573ca8', 13200000, 'IDR', 'bank_transfer', 'bca', '26955936753534774327806', NULL, NULL, NULL, NULL, 'settlement', 'accept', '200', 'Success, transaction is found', 'paid', '2026-05-03 19:40:28', NULL, NULL, '{\"status_code\":\"200\",\"transaction_id\":\"9810e6ef-3156-464d-bb35-0803c883eeba\",\"gross_amount\":\"13200000.00\",\"currency\":\"IDR\",\"order_id\":\"DT-4-20260503194018\",\"payment_type\":\"bank_transfer\",\"signature_key\":\"284e87fc1affb38f876f2e172c4715edff2710f1a2f2532f405eae8eae71e51f758cb65750a0f2bf016695e4026e48ebc1a04ab7460251e314d492bd0da33f20\",\"transaction_status\":\"settlement\",\"fraud_status\":\"accept\",\"status_message\":\"Success, transaction is found\",\"merchant_id\":\"G110926955\",\"va_numbers\":[{\"bank\":\"bca\",\"va_number\":\"26955936753534774327806\"}],\"payment_amounts\":[],\"transaction_time\":\"2026-05-03 19:40:20\",\"settlement_time\":\"2026-05-03 19:40:24\",\"expiry_time\":\"2026-05-04 19:40:20\"}', '2026-05-03 19:40:18', '2026-05-03 19:40:28'),
(5, 5, 'midtrans', 'DT-5-20260503223638', 'b668fb23-6a32-4624-941a-4ed179f2e2df', 'e529cf05-c5ea-4a0c-a7e1-6c9f546131b0', 'https://app.sandbox.midtrans.com/snap/v4/redirection/e529cf05-c5ea-4a0c-a7e1-6c9f546131b0', 15200000, 'IDR', 'bank_transfer', 'bca', '26955896399274394524193', NULL, NULL, NULL, NULL, 'settlement', 'accept', '200', 'Success, transaction is found', 'paid', '2026-05-03 22:37:18', NULL, NULL, '{\"status_code\":\"200\",\"transaction_id\":\"b668fb23-6a32-4624-941a-4ed179f2e2df\",\"gross_amount\":\"15200000.00\",\"currency\":\"IDR\",\"order_id\":\"DT-5-20260503223638\",\"payment_type\":\"bank_transfer\",\"signature_key\":\"c0d440c2569a2d247c1b0939a87738863cf1d5294f05eb4b3770d2c5a5c1f5af25ab078e26e58bd52ede97223f0a42cfa698fa991c68a798b29a37f842b28569\",\"transaction_status\":\"settlement\",\"fraud_status\":\"accept\",\"status_message\":\"Success, transaction is found\",\"merchant_id\":\"G110926955\",\"va_numbers\":[{\"bank\":\"bca\",\"va_number\":\"26955896399274394524193\"}],\"payment_amounts\":[],\"transaction_time\":\"2026-05-03 22:36:43\",\"settlement_time\":\"2026-05-03 22:37:11\",\"expiry_time\":\"2026-05-04 22:36:43\"}', '2026-05-03 22:36:38', '2026-05-03 22:37:18'),
(6, 6, 'midtrans', 'DT-6-20260515122123', 'b0e801f1-28c6-471a-a11f-0842a33a6e26', 'da6f9bd3-66ed-4f27-8ebc-365dd98291cd', 'https://app.sandbox.midtrans.com/snap/v4/redirection/da6f9bd3-66ed-4f27-8ebc-365dd98291cd', 5900000, 'IDR', 'bank_transfer', 'bca', '26955834636105355480605', NULL, NULL, NULL, NULL, 'settlement', 'accept', '200', 'Success, transaction is found', 'paid', '2026-05-15 12:21:43', NULL, NULL, '{\"status_code\":\"200\",\"transaction_id\":\"b0e801f1-28c6-471a-a11f-0842a33a6e26\",\"gross_amount\":\"5900000.00\",\"currency\":\"IDR\",\"order_id\":\"DT-6-20260515122123\",\"payment_type\":\"bank_transfer\",\"signature_key\":\"476a5a9a586e0cca1479429f6e5f384b1e5741bf219be707f1f92bce2710ff1e4cd508038b9fa7f076a0d5b4be4194c6b4dfdc1f2956b3c57adf7ee06d91fcc6\",\"transaction_status\":\"settlement\",\"fraud_status\":\"accept\",\"status_message\":\"Success, transaction is found\",\"merchant_id\":\"G110926955\",\"va_numbers\":[{\"bank\":\"bca\",\"va_number\":\"26955834636105355480605\"}],\"payment_amounts\":[],\"transaction_time\":\"2026-05-15 12:21:24\",\"settlement_time\":\"2026-05-15 12:21:38\",\"expiry_time\":\"2026-05-16 12:21:24\"}', '2026-05-15 12:21:23', '2026-05-15 12:21:43'),
(7, 7, 'midtrans', 'DT-7-20260515122334', 'a5179a41-835c-417c-8d35-de8e43f57654', '8187bf59-c1f3-43a4-82c1-bd64fdb7e56b', 'https://app.sandbox.midtrans.com/snap/v4/redirection/8187bf59-c1f3-43a4-82c1-bd64fdb7e56b', 5740000, 'IDR', 'bank_transfer', 'bca', '26955046819426732603046', NULL, NULL, NULL, NULL, 'settlement', 'accept', '200', 'Success, transaction is found', 'paid', '2026-05-15 12:23:47', NULL, NULL, '{\"status_code\":\"200\",\"transaction_id\":\"a5179a41-835c-417c-8d35-de8e43f57654\",\"gross_amount\":\"5740000.00\",\"currency\":\"IDR\",\"order_id\":\"DT-7-20260515122334\",\"payment_type\":\"bank_transfer\",\"signature_key\":\"0bc9dfa11277efc2c4e60fa448cdf303615e33dcfd036cd9e9ccfacee22edaacefc7a29cb93af4b5555a39ba3f0c782d7eb20e37109abccbc807206d4fdd2020\",\"transaction_status\":\"settlement\",\"fraud_status\":\"accept\",\"status_message\":\"Success, transaction is found\",\"merchant_id\":\"G110926955\",\"va_numbers\":[{\"bank\":\"bca\",\"va_number\":\"26955046819426732603046\"}],\"payment_amounts\":[],\"transaction_time\":\"2026-05-15 12:23:36\",\"settlement_time\":\"2026-05-15 12:23:40\",\"expiry_time\":\"2026-05-16 12:23:35\"}', '2026-05-15 12:23:34', '2026-05-15 12:23:47'),
(8, 8, 'midtrans', 'DT-8-20260515140112', '0f862022-744c-4296-a488-21c47620629b', '706abeaa-cb8f-4c76-aa29-7c5708ad4813', 'https://app.sandbox.midtrans.com/snap/v4/redirection/706abeaa-cb8f-4c76-aa29-7c5708ad4813', 14940000, 'IDR', 'bank_transfer', 'bca', '26955637708049115735371', NULL, NULL, NULL, NULL, 'settlement', 'accept', '200', 'Success, transaction is found', 'paid', '2026-05-15 14:03:05', NULL, NULL, '{\"status_code\":\"200\",\"transaction_id\":\"0f862022-744c-4296-a488-21c47620629b\",\"gross_amount\":\"14940000.00\",\"currency\":\"IDR\",\"order_id\":\"DT-8-20260515140112\",\"payment_type\":\"bank_transfer\",\"signature_key\":\"4c218db81bc0d87b03887b10ba4430d61c912c1f241f5368a9cbc86f0fb4f2e1546a5f5939357f8cc19ae30747abb041cea89a91e48894b9073f124f1ad5cf2e\",\"transaction_status\":\"settlement\",\"fraud_status\":\"accept\",\"status_message\":\"Success, transaction is found\",\"merchant_id\":\"G110926955\",\"va_numbers\":[{\"bank\":\"bca\",\"va_number\":\"26955637708049115735371\"}],\"payment_amounts\":[],\"transaction_time\":\"2026-05-15 14:02:04\",\"settlement_time\":\"2026-05-15 14:02:53\",\"expiry_time\":\"2026-05-16 14:02:04\"}', '2026-05-15 14:01:13', '2026-05-15 14:03:05'),
(9, 9, 'midtrans', 'DT-9-20260515141643', 'f1b8ce15-627e-444a-be9e-4177186f71fb', '3ac28132-bece-4bd9-adda-0f53fad89238', 'https://app.sandbox.midtrans.com/snap/v4/redirection/3ac28132-bece-4bd9-adda-0f53fad89238', 1200000, 'IDR', 'bank_transfer', 'bca', '26955607098177636364293', NULL, NULL, NULL, NULL, 'settlement', 'accept', '200', 'Success, transaction is found', 'paid', '2026-05-15 14:19:01', NULL, NULL, '{\"status_code\":\"200\",\"transaction_id\":\"f1b8ce15-627e-444a-be9e-4177186f71fb\",\"gross_amount\":\"1200000.00\",\"currency\":\"IDR\",\"order_id\":\"DT-9-20260515141643\",\"payment_type\":\"bank_transfer\",\"signature_key\":\"98f51bc73c6acd188090b32e3439343ada3a4b26b306ec432db5d5e80a5d1ee3e28a6eb13e08f9de1b4a756201217da1063424507f135e062ca5503d36876334\",\"transaction_status\":\"settlement\",\"fraud_status\":\"accept\",\"status_message\":\"Success, transaction is found\",\"merchant_id\":\"G110926955\",\"va_numbers\":[{\"bank\":\"bca\",\"va_number\":\"26955607098177636364293\"}],\"payment_amounts\":[],\"transaction_time\":\"2026-05-15 14:16:54\",\"settlement_time\":\"2026-05-15 14:18:45\",\"expiry_time\":\"2026-05-16 14:16:54\"}', '2026-05-15 14:16:44', '2026-05-15 14:19:01'),
(10, 10, 'midtrans', 'DT-10-20260518184956', 'cc952f71-6f3b-4337-be67-121baa5e29dd', '33df1bec-321a-4763-a1be-e8c85a7cb154', 'https://app.sandbox.midtrans.com/snap/v4/redirection/33df1bec-321a-4763-a1be-e8c85a7cb154', 15200000, 'IDR', 'bank_transfer', 'bca', '26955275844354036124292', NULL, NULL, NULL, NULL, 'settlement', 'accept', '200', 'Success, transaction is found', 'paid', '2026-05-18 18:50:12', NULL, NULL, '{\"status_code\":\"200\",\"transaction_id\":\"cc952f71-6f3b-4337-be67-121baa5e29dd\",\"gross_amount\":\"15200000.00\",\"currency\":\"IDR\",\"order_id\":\"DT-10-20260518184956\",\"payment_type\":\"bank_transfer\",\"signature_key\":\"fbe7a75a6b944d336c259b5ff4e15beb0c3e93e2ab755adaf10d49ccd531181bd33d9c028242ff487ad0167f4286b40f6e09bbf7fbf6c053eecb2e1f7c8d4a4b\",\"transaction_status\":\"settlement\",\"fraud_status\":\"accept\",\"status_message\":\"Success, transaction is found\",\"merchant_id\":\"G110926955\",\"va_numbers\":[{\"bank\":\"bca\",\"va_number\":\"26955275844354036124292\"}],\"payment_amounts\":[],\"transaction_time\":\"2026-05-18 18:50:01\",\"settlement_time\":\"2026-05-18 18:50:04\",\"expiry_time\":\"2026-05-19 18:50:01\"}', '2026-05-18 18:49:59', '2026-05-18 18:50:12'),
(11, 11, 'midtrans', 'DT-11-20260518185124', '6904bb71-4231-4782-93a4-54d584fbbef8', '6bd041a5-661b-4657-9740-8ce346b0fce7', 'https://app.sandbox.midtrans.com/snap/v4/redirection/6bd041a5-661b-4657-9740-8ce346b0fce7', 11190000, 'IDR', 'bank_transfer', 'bca', '26955431067460901105451', NULL, NULL, NULL, NULL, 'settlement', 'accept', '200', 'Success, transaction is found', 'paid', '2026-05-18 18:51:43', NULL, NULL, '{\"status_code\":\"200\",\"transaction_id\":\"6904bb71-4231-4782-93a4-54d584fbbef8\",\"gross_amount\":\"11190000.00\",\"currency\":\"IDR\",\"order_id\":\"DT-11-20260518185124\",\"payment_type\":\"bank_transfer\",\"signature_key\":\"873e6eac458c81748b01a0ecb2770d41593d5617c302aa486dfe6d21eecc3d8e1d8ac943f5df4335a6971bd54c4e4c2923fea6da7c961fc108809079b89f4ecd\",\"transaction_status\":\"settlement\",\"fraud_status\":\"accept\",\"status_message\":\"Success, transaction is found\",\"merchant_id\":\"G110926955\",\"va_numbers\":[{\"bank\":\"bca\",\"va_number\":\"26955431067460901105451\"}],\"payment_amounts\":[],\"transaction_time\":\"2026-05-18 18:51:32\",\"settlement_time\":\"2026-05-18 18:51:36\",\"expiry_time\":\"2026-05-19 18:51:32\"}', '2026-05-18 18:51:28', '2026-05-18 18:51:43'),
(12, 12, 'midtrans', 'DT-12-20260518185343', 'a6065224-63e4-4bd8-a0a2-c25b1ff568c8', '7af94f30-8912-48d5-be4c-2646653211fd', 'https://app.sandbox.midtrans.com/snap/v4/redirection/7af94f30-8912-48d5-be4c-2646653211fd', 5890000, 'IDR', 'bank_transfer', 'bca', '26955611408971056691835', NULL, NULL, NULL, NULL, 'settlement', 'accept', '200', 'Success, transaction is found', 'paid', '2026-05-18 18:53:59', NULL, NULL, '{\"status_code\":\"200\",\"transaction_id\":\"a6065224-63e4-4bd8-a0a2-c25b1ff568c8\",\"gross_amount\":\"5890000.00\",\"currency\":\"IDR\",\"order_id\":\"DT-12-20260518185343\",\"payment_type\":\"bank_transfer\",\"signature_key\":\"e594eb4fa6c9b05e55413f7cb2d09fb096f41e026abe332b0c190cd3b0c9028840f5a1949d811e072d19ad8195786b2d988977a1a65690d78e0594114593684a\",\"transaction_status\":\"settlement\",\"fraud_status\":\"accept\",\"status_message\":\"Success, transaction is found\",\"merchant_id\":\"G110926955\",\"va_numbers\":[{\"bank\":\"bca\",\"va_number\":\"26955611408971056691835\"}],\"payment_amounts\":[],\"transaction_time\":\"2026-05-18 18:53:47\",\"settlement_time\":\"2026-05-18 18:53:53\",\"expiry_time\":\"2026-05-19 18:53:47\"}', '2026-05-18 18:53:46', '2026-05-18 18:53:59'),
(13, 13, 'midtrans', 'DT-13-20260530134744', '02dd5ae3-751c-422d-864e-7acd625f460f', 'e5e597ec-d1e9-4d7c-9bb3-41cecbc11d15', 'https://app.sandbox.midtrans.com/snap/v4/redirection/e5e597ec-d1e9-4d7c-9bb3-41cecbc11d15', 9200000, 'IDR', 'bank_transfer', 'bca', '26955286105867464361246', NULL, NULL, NULL, NULL, 'settlement', 'accept', '200', 'Success, transaction is found', 'paid', '2026-05-30 13:48:25', NULL, NULL, '{\"status_code\":\"200\",\"transaction_id\":\"02dd5ae3-751c-422d-864e-7acd625f460f\",\"gross_amount\":\"9200000.00\",\"currency\":\"IDR\",\"order_id\":\"DT-13-20260530134744\",\"payment_type\":\"bank_transfer\",\"signature_key\":\"972a4c4b2bd5e7c9d84a7437f1233240ea0f627944f1a91e67a8b033cf74b8165591c62703b4f8fcbac53dc36f878ad42b034e8bb3e2c17b026925b71ddc5f87\",\"transaction_status\":\"settlement\",\"fraud_status\":\"accept\",\"status_message\":\"Success, transaction is found\",\"merchant_id\":\"G110926955\",\"va_numbers\":[{\"bank\":\"bca\",\"va_number\":\"26955286105867464361246\"}],\"payment_amounts\":[],\"transaction_time\":\"2026-05-30 13:48:02\",\"settlement_time\":\"2026-05-30 13:48:17\",\"expiry_time\":\"2026-05-31 13:48:02\"}', '2026-05-30 13:47:47', '2026-05-30 13:48:25'),
(14, 14, 'midtrans', 'DT-14-20260603142739', '37d4db30-1ebc-49f9-9b0f-0f09dfbfa079', 'deafbb22-77cf-43b1-89b4-ad16a51702e2', 'https://app.sandbox.midtrans.com/snap/v4/redirection/deafbb22-77cf-43b1-89b4-ad16a51702e2', 10095000, 'IDR', 'bank_transfer', 'bca', '26955645615898863979768', NULL, NULL, NULL, NULL, 'settlement', 'accept', '200', 'Success, transaction is found', 'paid', '2026-06-03 14:28:38', NULL, NULL, '{\"status_code\":\"200\",\"transaction_id\":\"37d4db30-1ebc-49f9-9b0f-0f09dfbfa079\",\"gross_amount\":\"10095000.00\",\"currency\":\"IDR\",\"order_id\":\"DT-14-20260603142739\",\"payment_type\":\"bank_transfer\",\"signature_key\":\"1a85957753a908eb56eb65bc0fc6ee2b32484c2ca019145493821472aa831ea5ce784f9b409eb1b9f571ccdd6a5b613f70513adcdcf97c97649bff03dc25a422\",\"transaction_status\":\"settlement\",\"fraud_status\":\"accept\",\"status_message\":\"Success, transaction is found\",\"merchant_id\":\"G110926955\",\"va_numbers\":[{\"bank\":\"bca\",\"va_number\":\"26955645615898863979768\"}],\"payment_amounts\":[],\"transaction_time\":\"2026-06-03 14:27:42\",\"settlement_time\":\"2026-06-03 14:28:27\",\"expiry_time\":\"2026-06-04 14:27:42\"}', '2026-06-03 14:27:40', '2026-06-03 14:28:38'),
(15, 15, 'midtrans', 'DT-15-20260603143805', '73c88b71-c01a-417b-b99d-8eb2a6db14b5', '9bf842cf-2e3d-427f-9e2d-417a3bf981db', 'https://app.sandbox.midtrans.com/snap/v4/redirection/9bf842cf-2e3d-427f-9e2d-417a3bf981db', 10700000, 'IDR', 'bank_transfer', 'bca', '26955033814800123373869', NULL, NULL, NULL, NULL, 'settlement', 'accept', '200', 'Success, transaction is found', 'paid', '2026-06-03 14:38:34', NULL, NULL, '{\"status_code\":\"200\",\"transaction_id\":\"73c88b71-c01a-417b-b99d-8eb2a6db14b5\",\"gross_amount\":\"10700000.00\",\"currency\":\"IDR\",\"order_id\":\"DT-15-20260603143805\",\"payment_type\":\"bank_transfer\",\"signature_key\":\"2fad3e8185aab986e17bc479c3941f286ab2d24b81f90867388a3e39930c0ffccb175cca43a9426718b9e2a2a3ea2cdf4e8d51258712d4cbeb6c39ddbf3ac156\",\"transaction_status\":\"settlement\",\"fraud_status\":\"accept\",\"status_message\":\"Success, transaction is found\",\"merchant_id\":\"G110926955\",\"va_numbers\":[{\"bank\":\"bca\",\"va_number\":\"26955033814800123373869\"}],\"payment_amounts\":[],\"transaction_time\":\"2026-06-03 14:38:13\",\"settlement_time\":\"2026-06-03 14:38:25\",\"expiry_time\":\"2026-06-04 14:38:13\"}', '2026-06-03 14:38:05', '2026-06-03 14:38:34'),
(16, 16, 'midtrans', 'DT-16-20260610110220', 'f6c20891-97a7-4961-83ef-dd4012e30885', 'f20cd715-3b49-4533-8bed-5f00ed2f5b68', 'https://app.sandbox.midtrans.com/snap/v4/redirection/f20cd715-3b49-4533-8bed-5f00ed2f5b68', 3640000, 'IDR', 'bank_transfer', 'bca', '26955637246151970607633', NULL, NULL, NULL, NULL, 'settlement', 'accept', '200', 'Success, transaction is found', 'paid', '2026-06-10 11:03:12', NULL, NULL, '{\"status_code\":\"200\",\"transaction_id\":\"f6c20891-97a7-4961-83ef-dd4012e30885\",\"gross_amount\":\"3640000.00\",\"currency\":\"IDR\",\"order_id\":\"DT-16-20260610110220\",\"payment_type\":\"bank_transfer\",\"signature_key\":\"d0eacaec89e8bc746493b803e51406726bbf8906897f4cf989647b936262d7d35134300c4c9d19ab7ef26f89dd5d9f9eb78238651fb36af1b2f83aa6b280ddd2\",\"transaction_status\":\"settlement\",\"fraud_status\":\"accept\",\"status_message\":\"Success, transaction is found\",\"merchant_id\":\"G110926955\",\"va_numbers\":[{\"bank\":\"bca\",\"va_number\":\"26955637246151970607633\"}],\"payment_amounts\":[],\"transaction_time\":\"2026-06-10 11:02:26\",\"settlement_time\":\"2026-06-10 11:02:53\",\"expiry_time\":\"2026-06-11 11:02:25\"}', '2026-06-10 11:02:21', '2026-06-10 11:03:12'),
(17, 17, 'midtrans', 'DT-17-20260614183436', '3e6f8491-fa28-4480-9918-4636517869b1', '047f3756-4c8b-4430-9b78-9da20d1570cd', 'https://app.sandbox.midtrans.com/snap/v4/redirection/047f3756-4c8b-4430-9b78-9da20d1570cd', 8700000, 'IDR', 'bank_transfer', 'bca', '26955695637293094774070', NULL, NULL, NULL, NULL, 'settlement', 'accept', '200', 'Success, transaction is found', 'paid', '2026-06-14 18:34:48', NULL, NULL, '{\"status_code\":\"200\",\"transaction_id\":\"3e6f8491-fa28-4480-9918-4636517869b1\",\"gross_amount\":\"8700000.00\",\"currency\":\"IDR\",\"order_id\":\"DT-17-20260614183436\",\"payment_type\":\"bank_transfer\",\"signature_key\":\"e8841dac8b55148f8c4a1c35e89659b03183c37fee9916124b0b4b893103d68310bb24c75906b76006dc82e9792daae1f1923e957c7b67b03ab68a6f11afbbbc\",\"transaction_status\":\"settlement\",\"fraud_status\":\"accept\",\"status_message\":\"Success, transaction is found\",\"merchant_id\":\"G110926955\",\"va_numbers\":[{\"bank\":\"bca\",\"va_number\":\"26955695637293094774070\"}],\"payment_amounts\":[],\"transaction_time\":\"2026-06-14 18:34:39\",\"settlement_time\":\"2026-06-14 18:34:43\",\"expiry_time\":\"2026-06-15 18:34:39\"}', '2026-06-14 18:34:38', '2026-06-14 18:34:48'),
(18, 18, 'midtrans', 'DT-18-20260620221134', 'a8747897-37ac-46e4-a74c-5d589cb4e0f6', '202f275f-ca8a-4c85-b63b-eca0bdf76890', 'https://app.sandbox.midtrans.com/snap/v4/redirection/202f275f-ca8a-4c85-b63b-eca0bdf76890', 11500000, 'IDR', 'bank_transfer', 'bca', '26955579041611441636365', NULL, NULL, NULL, NULL, 'pending', 'accept', '201', 'Success, transaction is found', 'pending', NULL, NULL, NULL, '{\"status_code\":\"201\",\"transaction_id\":\"a8747897-37ac-46e4-a74c-5d589cb4e0f6\",\"gross_amount\":\"11500000.00\",\"currency\":\"IDR\",\"order_id\":\"DT-18-20260620221134\",\"payment_type\":\"bank_transfer\",\"signature_key\":\"5af9fbcb19fc78584e6fe20351edeb585f06768614b898a1a0b6e49be4bc93f2cff0f9bedc1a4921abb03b42b5d76bcde6fa5d56ebc6a3e5f21da8db9691605d\",\"transaction_status\":\"pending\",\"fraud_status\":\"accept\",\"status_message\":\"Success, transaction is found\",\"merchant_id\":\"G110926955\",\"va_numbers\":[{\"bank\":\"bca\",\"va_number\":\"26955579041611441636365\"}],\"payment_amounts\":[],\"transaction_time\":\"2026-06-20 22:11:41\",\"expiry_time\":\"2026-06-21 22:11:41\"}', '2026-06-20 22:11:35', '2026-06-20 22:11:55'),
(19, 19, 'midtrans', 'DT-19-20260620222414', '1fa4ee26-e02d-4ac4-b654-48b26c32ca9f', '91ab912d-e59f-4533-9557-988b1a00cf65', 'https://app.sandbox.midtrans.com/snap/v4/redirection/91ab912d-e59f-4533-9557-988b1a00cf65', 7500000, 'IDR', 'bank_transfer', 'bca', '26955431665720251878738', NULL, NULL, NULL, NULL, 'settlement', 'accept', '200', 'Success, transaction is found', 'paid', '2026-06-20 22:44:14', NULL, NULL, '{\"status_code\":\"200\",\"transaction_id\":\"1fa4ee26-e02d-4ac4-b654-48b26c32ca9f\",\"gross_amount\":\"7500000.00\",\"currency\":\"IDR\",\"order_id\":\"DT-19-20260620222414\",\"payment_type\":\"bank_transfer\",\"signature_key\":\"444e2a94694afd3f41d973e7f1f8b8010d8cf5f9b1bad6e23c59dcbacf19fb9f1bfc8432e65254966f443cf8f501c47ea551ad6b141c72aba527eaffbacf47a8\",\"transaction_status\":\"settlement\",\"fraud_status\":\"accept\",\"status_message\":\"Success, transaction is found\",\"merchant_id\":\"G110926955\",\"va_numbers\":[{\"bank\":\"bca\",\"va_number\":\"26955431665720251878738\"}],\"payment_amounts\":[],\"transaction_time\":\"2026-06-20 22:24:28\",\"settlement_time\":\"2026-06-20 22:26:05\",\"expiry_time\":\"2026-06-21 22:24:28\"}', '2026-06-20 22:24:14', '2026-06-20 22:44:14');

-- ----------------------------
-- Table structure for permissions
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of permissions
-- ----------------------------
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'ViewAny:User', 'web', '2026-05-01 23:11:05', '2026-05-01 23:11:05'),
(2, 'View:User', 'web', '2026-05-01 23:11:05', '2026-05-01 23:11:05'),
(3, 'Create:User', 'web', '2026-05-01 23:11:05', '2026-05-01 23:11:05'),
(4, 'Update:User', 'web', '2026-05-01 23:11:05', '2026-05-01 23:11:05'),
(5, 'Delete:User', 'web', '2026-05-01 23:11:05', '2026-05-01 23:11:05'),
(6, 'ViewAny:Role', 'web', '2026-05-01 23:11:05', '2026-05-01 23:11:05'),
(7, 'View:Role', 'web', '2026-05-01 23:11:05', '2026-05-01 23:11:05'),
(8, 'Create:Role', 'web', '2026-05-01 23:11:05', '2026-05-01 23:11:05'),
(9, 'Update:Role', 'web', '2026-05-01 23:11:05', '2026-05-01 23:11:05'),
(10, 'Delete:Role', 'web', '2026-05-01 23:11:05', '2026-05-01 23:11:05'),
(11, 'ViewAny:Activity', 'web', '2026-05-01 23:11:05', '2026-05-01 23:11:05'),
(12, 'View:Activity', 'web', '2026-05-01 23:11:05', '2026-05-01 23:11:05'),
(13, 'Create:Activity', 'web', '2026-05-01 23:11:05', '2026-05-01 23:11:05'),
(14, 'Update:Activity', 'web', '2026-05-01 23:11:05', '2026-05-01 23:11:05'),
(15, 'Delete:Activity', 'web', '2026-05-01 23:11:05', '2026-05-01 23:11:05'),
(16, 'View:MyProfilePage', 'web', '2026-05-01 23:11:06', '2026-05-01 23:11:06'),
(17, 'View:OverlookWidget', 'web', '2026-05-01 23:11:06', '2026-05-01 23:11:06'),
(18, 'View:LatestAccessLogs', 'web', '2026-05-01 23:11:06', '2026-05-01 23:11:06'),
(19, 'ViewAny:Addon', 'web', '2026-05-02 02:32:27', '2026-05-02 02:32:27'),
(20, 'View:Addon', 'web', '2026-05-02 02:32:27', '2026-05-02 02:32:27'),
(21, 'Create:Addon', 'web', '2026-05-02 02:32:27', '2026-05-02 02:32:27'),
(22, 'Update:Addon', 'web', '2026-05-02 02:32:27', '2026-05-02 02:32:27'),
(23, 'Delete:Addon', 'web', '2026-05-02 02:32:27', '2026-05-02 02:32:27'),
(24, 'ViewAny:CustomItem', 'web', '2026-05-02 02:32:28', '2026-05-02 02:32:28'),
(25, 'View:CustomItem', 'web', '2026-05-02 02:32:28', '2026-05-02 02:32:28'),
(26, 'Create:CustomItem', 'web', '2026-05-02 02:32:28', '2026-05-02 02:32:28'),
(27, 'Update:CustomItem', 'web', '2026-05-02 02:32:28', '2026-05-02 02:32:28'),
(28, 'Delete:CustomItem', 'web', '2026-05-02 02:32:28', '2026-05-02 02:32:28'),
(29, 'ViewAny:PackageItem', 'web', '2026-05-02 02:32:28', '2026-05-02 02:32:28'),
(30, 'View:PackageItem', 'web', '2026-05-02 02:32:28', '2026-05-02 02:32:28'),
(31, 'Create:PackageItem', 'web', '2026-05-02 02:32:28', '2026-05-02 02:32:28'),
(32, 'Update:PackageItem', 'web', '2026-05-02 02:32:28', '2026-05-02 02:32:28'),
(33, 'Delete:PackageItem', 'web', '2026-05-02 02:32:28', '2026-05-02 02:32:28'),
(34, 'ViewAny:Package', 'web', '2026-05-02 02:32:28', '2026-05-02 02:32:28'),
(35, 'View:Package', 'web', '2026-05-02 02:32:28', '2026-05-02 02:32:28'),
(36, 'Create:Package', 'web', '2026-05-02 02:32:28', '2026-05-02 02:32:28'),
(37, 'Update:Package', 'web', '2026-05-02 02:32:28', '2026-05-02 02:32:28'),
(38, 'Delete:Package', 'web', '2026-05-02 02:32:28', '2026-05-02 02:32:28'),
(39, 'ViewAny:Beranda', 'web', '2026-05-02 04:38:22', '2026-05-02 04:38:22'),
(40, 'View:Beranda', 'web', '2026-05-02 04:38:22', '2026-05-02 04:38:22'),
(41, 'Create:Beranda', 'web', '2026-05-02 04:38:22', '2026-05-02 04:38:22'),
(42, 'Update:Beranda', 'web', '2026-05-02 04:38:22', '2026-05-02 04:38:22'),
(43, 'Delete:Beranda', 'web', '2026-05-02 04:38:22', '2026-05-02 04:38:22'),
(44, 'ViewAny:OrderAddon', 'web', '2026-05-02 04:38:22', '2026-05-02 04:38:22'),
(45, 'View:OrderAddon', 'web', '2026-05-02 04:38:22', '2026-05-02 04:38:22'),
(46, 'Create:OrderAddon', 'web', '2026-05-02 04:38:22', '2026-05-02 04:38:22'),
(47, 'Update:OrderAddon', 'web', '2026-05-02 04:38:22', '2026-05-02 04:38:22'),
(48, 'Delete:OrderAddon', 'web', '2026-05-02 04:38:22', '2026-05-02 04:38:22'),
(49, 'ViewAny:OrderItem', 'web', '2026-05-02 04:38:22', '2026-05-02 04:38:22'),
(50, 'View:OrderItem', 'web', '2026-05-02 04:38:22', '2026-05-02 04:38:22'),
(51, 'Create:OrderItem', 'web', '2026-05-02 04:38:22', '2026-05-02 04:38:22'),
(52, 'Update:OrderItem', 'web', '2026-05-02 04:38:22', '2026-05-02 04:38:22'),
(53, 'Delete:OrderItem', 'web', '2026-05-02 04:38:22', '2026-05-02 04:38:22'),
(54, 'ViewAny:Order', 'web', '2026-05-02 04:38:23', '2026-05-02 04:38:23'),
(55, 'View:Order', 'web', '2026-05-02 04:38:23', '2026-05-02 04:38:23'),
(56, 'Create:Order', 'web', '2026-05-02 04:38:23', '2026-05-02 04:38:23'),
(57, 'Update:Order', 'web', '2026-05-02 04:38:23', '2026-05-02 04:38:23'),
(58, 'Delete:Order', 'web', '2026-05-02 04:38:23', '2026-05-02 04:38:23'),
(59, 'ViewAny:Galery', 'web', '2026-05-02 04:56:48', '2026-05-02 04:56:48'),
(60, 'View:Galery', 'web', '2026-05-02 04:56:48', '2026-05-02 04:56:48'),
(61, 'Create:Galery', 'web', '2026-05-02 04:56:48', '2026-05-02 04:56:48'),
(62, 'Update:Galery', 'web', '2026-05-02 04:56:48', '2026-05-02 04:56:48'),
(63, 'Delete:Galery', 'web', '2026-05-02 04:56:48', '2026-05-02 04:56:48'),
(64, 'ViewAny:Footer', 'web', '2026-05-02 05:18:34', '2026-05-02 05:18:34'),
(65, 'View:Footer', 'web', '2026-05-02 05:18:34', '2026-05-02 05:18:34'),
(66, 'Create:Footer', 'web', '2026-05-02 05:18:34', '2026-05-02 05:18:34'),
(67, 'Update:Footer', 'web', '2026-05-02 05:18:34', '2026-05-02 05:18:34'),
(68, 'Delete:Footer', 'web', '2026-05-02 05:18:34', '2026-05-02 05:18:34'),
(69, 'ViewAny:SosialMedia', 'web', '2026-05-02 05:25:54', '2026-05-02 05:25:54'),
(70, 'View:SosialMedia', 'web', '2026-05-02 05:25:54', '2026-05-02 05:25:54'),
(71, 'Create:SosialMedia', 'web', '2026-05-02 05:25:54', '2026-05-02 05:25:54'),
(72, 'Update:SosialMedia', 'web', '2026-05-02 05:25:54', '2026-05-02 05:25:54'),
(73, 'Delete:SosialMedia', 'web', '2026-05-02 05:25:54', '2026-05-02 05:25:54');

-- ----------------------------
-- Table structure for reviews
-- ----------------------------
DROP TABLE IF EXISTS `reviews`;
CREATE TABLE `reviews` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `rating` tinyint(3) unsigned NOT NULL,
  `review` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_visible` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `reviews_order_id_unique` (`order_id`),
  KEY `reviews_user_id_foreign` (`user_id`),
  KEY `reviews_rating_is_visible_index` (`rating`,`is_visible`),
  CONSTRAINT `reviews_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of reviews
-- ----------------------------
-- ----------------------------
-- Table structure for role_has_permissions
-- ----------------------------
DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of role_has_permissions
-- ----------------------------
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(33, 1),
(34, 1),
(35, 1),
(36, 1),
(37, 1),
(38, 1),
(39, 1),
(40, 1),
(41, 1),
(42, 1),
(43, 1),
(44, 1),
(45, 1),
(46, 1),
(47, 1),
(48, 1),
(49, 1),
(50, 1),
(51, 1),
(52, 1),
(53, 1),
(54, 1),
(55, 1),
(56, 1),
(57, 1),
(58, 1),
(59, 1),
(60, 1),
(61, 1),
(62, 1),
(63, 1),
(64, 1),
(65, 1),
(66, 1),
(67, 1),
(68, 1),
(69, 1),
(70, 1),
(71, 1),
(72, 1),
(73, 1);

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'super_admin', 'web', '2026-05-01 23:11:05', '2026-05-01 23:11:05');

-- ----------------------------
-- Table structure for sessions
-- ----------------------------
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of sessions
-- ----------------------------
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('3RyY95JBAS1zKPjYcPd7k6QYBxtMeGPe5kBTxgbE', NULL, '192.168.64.1', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.4 Mobile/15E148 Safari/604.1', 'ZXlKcGRpSTZJakV2VVVGdVlsbFpNMmxwVkVWT2J6aGFhalUxU0ZFOVBTSXNJblpoYkhWbElqb2lVamhVV2xCcVkyeFBVbVJGTTBSdVl6VnBUMEo2VW1Kdk5FNVRVakZoTUdabVoyWnBXRGRMUTBsWE1HTk9UazVVY0VGbUwwWnFNbVJVUWxaUlMwTjNOWHBWTms5TE5rZHRjVmRKV0U1S2RETlBXbU16Y2trdlRWcERNek55UjJwV2IyWmFPVU5yY1RrelpqbHFiV2c0T1ZsMFQya3dja0paWlhadlptZzFhelJDUkRWa1RWWkhjbXBvUkZOUmNHVTNkM0l2WTBkMVRVTTVZbm80SzNRdlJFUnNOemhxTWpoM1NFeDRabVF3WkV0c1pqa3dUekZoV2xkS1NsaG5TazlLVTJGYVNGZExOa3gzU0dad1VVOW5jREJvT0hGbFVUYzRhRE5wTkhCV2RXZENhblV6TVhOa2NGSndNMncwTTB4cU4yeERaV1pKTUU5RFFuWTNNREp2WjNscVZWRnlZVVJpU1ZodGVuUkphbkJEWnk5eVVFMURXVzh4VmsxM2NWWlVZVEpKZERKM2RYa3pXV0ZzWVhCTFVWUkJjRXRtY1c1T05ETjJXRGR1U2pBNWRtYzFWR1l3VTFkeFUzUldSWGRtVW5sV1ZYWkdhVXRUTlhaQ2FEQXdPR0ZUZHpab2JFaHVLM2xpYm5VeFFVZ3ZZMDk0VTBGak1USlRNbTloVFd0eVVUWnBUMWRhTUUxWWQycERNVE5NVDJkemNHUjBObWhZY2tKc2QyVm5WV2hqWkhOcmFucHBOR0pJYXowaUxDSnRZV01pT2lKa05qSTRNMlZqTWpSa05ESTVOVGxsT1dKaVlUQmlNRE0yTWpaa05UVTRaV1ZqT0dGak1EWTJOakZpTXpWak9XSmhZalppTWpZMlpXVXlaRGxqTmpabUlpd2lkR0ZuSWpvaUluMD0=', 1784425678),
('EcTkGKrToQFlXPPYcNXEFGD52o00yu0IG2PJphGn', NULL, '192.168.64.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'ZXlKcGRpSTZJa2xzTVRsRFpEa3JUblpOZDBSMFJITjRRM2RtZEhjOVBTSXNJblpoYkhWbElqb2lSamRLTkhoMlZUWkRTR2xpVmxOTVRHYzJRV3hQWVZkcVoyVmxjRlZFU0RWV2VYaGlla1pXY0U1bVZESlFaaXMwYUdwWU5reEpabWhXTlc1ME5FZHhZVWsxYmxnclVrODJXVEZsY1RSaFVIQnRZalZIV0VSV1YwSjJjemxQV0ZkV1VqRXdSV2x5VVVOSmMwTkdRV1J2ZURGM1RtVjZSRkZETldKaVpXaDZiVTFhYlc5T2FDOWFXR3R3U0ZCeVZFSlBjVWhvTVdaV2JHcFpUbFpMWWtkWWJURlJla1ZNV2xWbGFGTnFaVWRTZFhvNWVEUllSemQ2Vm13eVNreEpVM1JRWTBsVlZYTTRMMFI2TmtVMloyVllhRmQ0TkdKcldERTFZbFJGYkhOcWMxZGFVMkZwVVc4MVlVdENVVTVCZVZSelMwRnNhbUZtU25SV2RrSldaaXQ2ZGt0Nk9IVldSbTFYTDB0UFFXeENNMnRZUTFoclVtOUpkM0kxYmtKWGJsUjRUakp3Wld0MlpEbDRUR1pMUVU1MlZWcDVMM2hWVFZWNlpIQndWbk5ZVm1NaUxDSnRZV01pT2lKaVkySmxOREkwTlRCaU5qZG1Oakl4TVRrd1pESmlNREF5TlRCallUUTJZamt5WldNMllqTXhZalE1TkRReVpEWmpOakpsWTJJeFpURmlNV1kwTXpabUlpd2lkR0ZuSWpvaUluMD0=', 1784425421),
('FYtfx7T29Har3wwy7oQt8bdUfazh7zqx3Wft7Qv1', NULL, '192.168.64.1', 'WhatsApp/2.23.20.0', 'ZXlKcGRpSTZJbmRKVVd0VFkxRklablJ6VVhOVVJVVnVhMnRXWW5jOVBTSXNJblpoYkhWbElqb2lVR2xaUzJWS1oyOWFRVzB5UjBWVFlVSXpaRmxZWkRaRlZDdDBMME5yT0ZWRlRYSmFRek5CYkVkVFdFSklhM2hxWlcwclREUlBhbE4zY2tWeFkyOVFjekphZDFwc1NsUjBUWEJIVkRkdlRqTmtlbTFqTTFGaUwwc3dibGRpZVVNeFlVUkNVV0pxVDA1a1NrazRORFJ6ZEZSVU9IVkpTRVZJV0cxM2JIbFhZekF2VW5ObU9ESjRiamhPVlVSYWRHMVhhaXRSVERRM2QxRjFiMWxzVDFSTGN6QlRRMWhqV0VsVGJqaGpVbVYxUXl0aWNXcFJWVmxZTTJoak1HTm1OSFZrVm5CS00xTkJjbEowTlhoNFVEQnpRVEZ3VVRGNGFIazROa3hTVG0wcldqbFdWM1pzYW0xbFIzUkVNSFpJVkUxblNrcFRXazVCTUUxelJVcGlTV0l6TUdJeWJXRk9WSGxuTVUxSGRuTlFOM2RQVWxOM1JVUkNORWRLWld3ckwyZFNNM2g1Y2tSV1l6aDFRamxyUmtoelYzRnNObWd5WVhwMlRWZExWemRxYUc0aUxDSnRZV01pT2lJeU5tWmtObUV5TldVMllXRTJOelkwWXpCbU16a3pZVFkzTnpjNE5UUTFZams0WXpNMU1qZGxZelZqTVdZMU5qSm1OVFU0T0ROall6bGlaRFU0TVRkbElpd2lkR0ZuSWpvaUluMD0=', 1784425486),
('N2m35rVkK3PM7e5pXVu0VijMnoZ4qAnInxjoGkgQ', NULL, '192.168.64.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'ZXlKcGRpSTZJbTVpTkVSS2JFdGxNalp4WXpsQ2RXWTNVbE5hVWxFOVBTSXNJblpoYkhWbElqb2lWV3RZZG5nd1ZrMXFSRUZpUlVkd2JrcERMemhpWlhoU1dERkJPVkJpZVZSWFREVlRNV3hITkVObU15OXZZaXN3ZWtOc2JqZEZaVVZHYjNBNGRXdFJRbnBLYVc1TE1HeDZTRUZ4VmtwWGNtbHdXUzkzYlZSdmFWbFBTbEI1UzFGSlpHMW9LM1ZKU2t0d1ZtVlJSalpPWWtKTUwxWTRha3RFUmxaVmRHUkpXVkphTkZSa2IyOURjVmRIYmxGT1RqUjJVUzlaZG5oMFdXRkdaREpMTnpoelVUVkRSMVJuU2xoVFlsUlFkVEp0YTFjMVpEQnJUMnRDV0VneldHNTBkSEZJVXpsWlZsTkplWGd4WlZweWIxRmpUV00xYVc5WE9VSTJOR2hCV1RkbFZYVmpWMUJtVkdKNU9WRlFlVTl6UVN0MWQxbzRiSFZQTWtoRVpIQkpSMWwxTDJsUk1IRjRkR0Z1UW05dmRIRTRRM2MyYzJ4T1RERnJkMWg2T0ZRMFRWVnlNVzlhU2tSNE5HVlFUMGczZDNWbVVHdElaSFV4YWxGeVZFbERZWFF4TjFGWVdXSTBTVlJHTWxoelNuTkRiR1ZHV1hsU1Z6RmtaaXRCTkVaQmQzUldWWEJpT1VSeWVIb3JTak12U0daaWRsVmtNVTlaVW5ObmNFMVFSemRJUW04eklpd2liV0ZqSWpvaVlUSmtObVpsTWpKak9UWTJOV1pqWVRObVltSmpPREU0TTJFM1lqWTBOREppWkdabFpqUTFabVUyWVRZeU4yTXhOVGt3TlRNek5tVXpaamN4WldWaVpTSXNJblJoWnlJNklpSjk=', 1784425559),
('WgrxVWDNw9Vs9j1qG9tCgNqZ6YQRnwy2Bgj4BBYB', NULL, '192.168.64.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'ZXlKcGRpSTZJbWxUZDFoblR6WkVRMUpYWkRoVFdVMURPSGhXUW5jOVBTSXNJblpoYkhWbElqb2lRbU40V25GMFdXaHhVbTh3TVd3NVJ6TlFZekptWVhOdldERkhTMnhLYW1SUWJVd3JaemcyUkZsNVJHcEtiMGQzUzFWQ2NXTlJNbGw0UnpkemJFOU9SWGw2WldZNWNsQnVkREJqYURGM1MwTjJVSFpVTlV0eFNtNWhOMGxOWTNrdmNXNVBiMGh1Y0haVVJIUnpla2RzYTFnelEwRXpjMjAwU1hkaFFqRllVVEJ5TUdkdmVpOHdPRlJ6TTB0NGJFNXlaV0pLYjNsM2VXMUxXbU4xTnpneFRURmpXbFJKZFU1T2Mxb3ljakZ1YmxWNFpFaEtaMnRqZUV0RmMwZG1iVWd4WTBRd1JrSXpRVlJOVTBONlNWTnFZelJzYm1VclNUaENkVEZDSzNjM01tSmpWbmxRUW5GVE1VUnhWQzltUlVKcFIzaGtNVlphUzNwbFRrTjJTMXBoTldvMFFVZFJialpETjIxaGRsWXJRMWxNTmtKRVpEUjRNM281VFU5eVNYVkJOalpuTUhKTWJYQXJLMnAwYWtKWloxZG1USFpWY1VsVk5HRnJlbTVEYkVraUxDSnRZV01pT2lKaU5qa3lZak0yTURFMlkyUXhOVEV5TVdNME9EZGhOREZoWTJVek16VTNOVGRpWWpBM1pEQm1OakZqTkdKaVlqTXpaR00yTUdKaE9HUXdabUpqTmpFMklpd2lkR0ZuSWpvaUluMD0=', 1784425419);

-- ----------------------------
-- Table structure for sosial_media
-- ----------------------------
DROP TABLE IF EXISTS `sosial_media`;
CREATE TABLE `sosial_media` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of sosial_media
-- ----------------------------
INSERT INTO `sosial_media` (`id`, `icon`, `link`, `created_at`, `updated_at`) VALUES
(1, 'bi bi-facebook', NULL, '2026-05-02 05:27:00', '2026-05-02 05:27:00'),
(2, 'bi bi-instagram', 'https://www.instagram.com/didin.tenda/', '2026-05-02 05:27:11', '2026-05-02 05:29:40'),
(3, 'bi bi-whatsapp', 'https://api.whatsapp.com/send?phone=6288289258764', '2026-05-02 05:27:20', '2026-06-01 19:53:07'),
(4, 'bi bi-youtube', NULL, '2026-05-02 05:27:28', '2026-05-02 05:27:28');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `avatar_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `whatsapp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kota` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kode_pos` bigint(20) DEFAULT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` (`id`, `avatar_url`, `name`, `email`, `email_verified_at`, `password`, `phone`, `whatsapp`, `kota`, `kode_pos`, `alamat`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, '01KQJANM6R4H578PKDXTHH3SXA.jpg', 'Admin', 'admin@admin.com', '2026-05-01 23:11:06', '$2y$12$j2YlAbstHqQcW8JJYNEHLOh4.95WKprKZGT4XoTJ3r0BKxyPuBvgC', NULL, NULL, NULL, NULL, NULL, 'FKygXv8Njdx0xp798OowGRcdTt9FwiswlfrxVrGkLxhe3a85ezKSG5u1BX30', '2026-05-01 23:11:06', '2026-05-02 00:51:33'),
(2, NULL, 'ARHAN MALIK', 'arhanmali96@gmail.com', NULL, '$2y$12$j2YlAbstHqQcW8JJYNEHLOh4.95WKprKZGT4XoTJ3r0BKxyPuBvgC', '082112123333', '082112123333', NULL, NULL, NULL, NULL, '2026-05-01 23:12:08', '2026-05-01 23:12:08'),
(3, NULL, 'arhan malik ', 'arhanmcz@gmail.com', NULL, '$2y$12$j2YlAbstHqQcW8JJYNEHLOh4.95WKprKZGT4XoTJ3r0BKxyPuBvgC', NULL, NULL, NULL, NULL, NULL, 'YMlrSr7bBonxX0hj8xlyKKqfKEDnvEt05wz7HO2MadSvN5h70wCuhZmgcALn', NULL, '2026-05-03 18:06:07'),
(4, NULL, 'test', 'rasyidmalik456@gmail.com', NULL, '$2y$12$pTKu6GNZPOO9DtFkScRnLOZEvs9pw9o2t3B8amH7G7CAy3NIielKu', '082122222222', '082122222222', NULL, NULL, NULL, NULL, '2026-05-02 05:45:03', '2026-05-02 05:45:03'),
(5, NULL, 'djncloud', 'djncloud@gmail.com', NULL, '$2y$12$m/rYaENJHgw4kHRNRhLlXuzHOexAkqKiUb2f0MQq3Yc0wNBm89aIu', '082222222222', '082222222222', NULL, NULL, NULL, NULL, '2026-05-15 12:17:34', '2026-05-15 12:17:34'),
(6, NULL, 'Muhamad Darlan', 'muhamaddarlan76@gmail.com', NULL, '$2y$12$yu0WdJeYh3yu0Z/05IkhCuB3sDoWJp8ZC1DG2PUJHjsmTJEEOc0fa', '088289258764', '088289258764', NULL, NULL, NULL, NULL, '2026-05-15 13:56:43', '2026-05-15 13:56:43'),
(7, NULL, 'Athar Arya', 'tar123@gmail.com', NULL, '$2y$12$aIBNej/h/VHuSegCQP9qtedCxJEa9FLm13iAPmdejEog..IWakDBm', '000000000000000', '000000000000000', NULL, NULL, NULL, NULL, '2026-05-24 23:21:43', '2026-05-24 23:21:43'),
(8, NULL, 'gyt', 'tar1234@gmail.com', NULL, '$2y$12$8o/Cdt0I9Ps5CaMpsIsZ4.tA66.B5poI118fUF3CVTOkf6mvnu28W', '444444444232', '444444444232', NULL, NULL, NULL, NULL, '2026-05-25 10:52:17', '2026-05-25 10:52:17'),
(9, NULL, 'abcdef', 'didintendaa@gmail.com', NULL, '$2y$12$sEdNWIYVgxa57eGcoF194.bsFUw5r.CBj7kWhx/n7pknWCIkNcjQu', '088289258764', '088289258764', NULL, NULL, NULL, NULL, '2026-06-03 14:35:53', '2026-06-03 14:35:53'),
(10, NULL, 'Nindyy', 'nindyabp95@gmail.com', NULL, '$2y$12$Deeb38OvSphuGwgXFDba5.hNTlc16kpt/qLMCtOvChuBIOg8u.nja', '081398889380', '081398889380', NULL, NULL, NULL, NULL, '2026-06-20 22:06:19', '2026-06-20 22:06:19');

SET FOREIGN_KEY_CHECKS = 1;
