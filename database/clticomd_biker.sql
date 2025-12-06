/*
 Navicat Premium Dump SQL

 Source Server         : localhist
 Source Server Type    : MySQL
 Source Server Version : 80030 (8.0.30)
 Source Host           : localhost:3306
 Source Schema         : clticomd_biker

 Target Server Type    : MySQL
 Target Server Version : 80030 (8.0.30)
 File Encoding         : 65001

 Date: 05/12/2025 19:44:02
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for brands
-- ----------------------------
DROP TABLE IF EXISTS `brands`;
CREATE TABLE `brands`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `brands_name_unique`(`name` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 21 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of brands
-- ----------------------------
INSERT INTO `brands` VALUES (1, 'Bajaj', '2025-06-10 00:00:16', '2025-06-10 00:00:16');
INSERT INTO `brands` VALUES (5, '1', '2025-06-16 17:08:36', '2025-06-16 17:08:36');
INSERT INTO `brands` VALUES (8, 'Cmd', '2025-07-30 03:23:15', '2025-07-30 03:23:15');
INSERT INTO `brands` VALUES (9, 'Molitalie', '2025-07-30 03:48:10', '2025-07-30 03:48:10');
INSERT INTO `brands` VALUES (10, 'Ried', '2025-07-30 03:53:27', '2025-07-30 03:53:27');
INSERT INTO `brands` VALUES (11, 'Gigabyte', '2025-07-30 04:13:21', '2025-07-30 04:13:21');
INSERT INTO `brands` VALUES (12, 'Rain', '2025-07-30 04:19:08', '2025-07-30 04:19:08');
INSERT INTO `brands` VALUES (13, 'Nokia', '2025-07-30 13:57:34', '2025-07-30 13:57:34');
INSERT INTO `brands` VALUES (14, 'Hp', '2025-07-30 14:19:07', '2025-07-30 14:19:07');
INSERT INTO `brands` VALUES (15, 'Huawei', '2025-07-30 14:43:23', '2025-07-30 14:43:23');
INSERT INTO `brands` VALUES (16, 'Samsung', '2025-07-31 18:43:24', '2025-07-31 18:43:24');
INSERT INTO `brands` VALUES (17, 'Gdm', '2025-10-10 00:12:26', '2025-10-10 00:12:26');
INSERT INTO `brands` VALUES (18, 'Cv', '2025-10-10 00:12:26', '2025-10-10 00:12:26');
INSERT INTO `brands` VALUES (19, 'Kigcol', '2025-10-10 00:12:26', '2025-10-10 00:12:26');
INSERT INTO `brands` VALUES (20, 'Rcc', '2025-10-10 00:12:26', '2025-10-10 00:12:26');

-- ----------------------------
-- Table structure for buy_credit_installments
-- ----------------------------
DROP TABLE IF EXISTS `buy_credit_installments`;
CREATE TABLE `buy_credit_installments`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `buy_payment_method_id` bigint UNSIGNED NOT NULL,
  `installment_number` int NOT NULL,
  `amount` decimal(10, 2) NOT NULL,
  `due_date` date NOT NULL,
  `status` enum('pendiente','pagado','vencido') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pendiente',
  `paid_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `buy_credit_installments_buy_payment_method_id_foreign`(`buy_payment_method_id` ASC) USING BTREE,
  CONSTRAINT `buy_credit_installments_buy_payment_method_id_foreign` FOREIGN KEY (`buy_payment_method_id`) REFERENCES `buy_payment_methods` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of buy_credit_installments
-- ----------------------------
INSERT INTO `buy_credit_installments` VALUES (1, 9, 1, 14160.00, '2025-09-02', 'pendiente', NULL, '2025-08-02 00:12:23', '2025-08-02 00:12:23');
INSERT INTO `buy_credit_installments` VALUES (2, 9, 2, 14160.00, '2025-10-02', 'pendiente', NULL, '2025-08-02 00:12:23', '2025-08-02 00:12:23');
INSERT INTO `buy_credit_installments` VALUES (3, 9, 3, 14160.00, '2025-11-02', 'pendiente', NULL, '2025-08-02 00:12:23', '2025-08-02 00:12:23');
INSERT INTO `buy_credit_installments` VALUES (4, 10, 1, 78.67, '2025-09-02', 'pendiente', NULL, '2025-08-02 00:17:49', '2025-08-02 00:17:49');
INSERT INTO `buy_credit_installments` VALUES (5, 10, 2, 78.67, '2025-10-02', 'pendiente', NULL, '2025-08-02 00:17:49', '2025-08-02 00:17:49');
INSERT INTO `buy_credit_installments` VALUES (6, 10, 3, 78.66, '2025-11-02', 'pendiente', NULL, '2025-08-02 00:17:49', '2025-08-02 00:17:49');
INSERT INTO `buy_credit_installments` VALUES (7, 11, 1, 7186.20, '2025-09-02', 'pagado', '2025-08-02 20:02:23', '2025-08-02 15:35:24', '2025-08-02 20:02:23');
INSERT INTO `buy_credit_installments` VALUES (8, 11, 2, 7186.20, '2025-10-02', 'pendiente', NULL, '2025-08-02 15:35:24', '2025-08-02 15:35:24');

-- ----------------------------
-- Table structure for buy_items
-- ----------------------------
DROP TABLE IF EXISTS `buy_items`;
CREATE TABLE `buy_items`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` bigint UNSIGNED NOT NULL,
  `warehouse_id` bigint UNSIGNED NULL DEFAULT NULL,
  `buy_id` bigint UNSIGNED NOT NULL,
  `quantity` int NOT NULL DEFAULT 0,
  `user_register` bigint UNSIGNED NULL DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `price` decimal(10, 2) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `tienda_id` bigint UNSIGNED NULL DEFAULT NULL,
  `custom_price` decimal(10, 2) NULL DEFAULT NULL,
  `scanned_codes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `buy_items_product_id_foreign`(`product_id` ASC) USING BTREE,
  INDEX `buy_items_buy_id_foreign`(`buy_id` ASC) USING BTREE,
  INDEX `buy_items_user_register_foreign`(`user_register` ASC) USING BTREE,
  INDEX `buy_items_tienda_id_foreign`(`tienda_id` ASC) USING BTREE,
  INDEX `warehouse_id`(`warehouse_id` ASC) USING BTREE,
  CONSTRAINT `buy_items_buy_id_foreign` FOREIGN KEY (`buy_id`) REFERENCES `buys` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `buy_items_ibfk_1` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `buy_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `buy_items_tienda_id_foreign` FOREIGN KEY (`tienda_id`) REFERENCES `tiendas` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `buy_items_user_register_foreign` FOREIGN KEY (`user_register`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 23 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of buy_items
-- ----------------------------
INSERT INTO `buy_items` VALUES (2, 24757, NULL, 6, 1, 1, '2025-08-01 15:11:26', 200.00, 1, 1, NULL, '[]', '2025-08-01 15:11:26', '2025-08-01 15:11:26');
INSERT INTO `buy_items` VALUES (3, 24761, NULL, 6, 1, 1, '2025-08-01 15:11:26', 180.00, 1, 1, NULL, '[]', '2025-08-01 15:11:26', '2025-08-01 15:11:26');
INSERT INTO `buy_items` VALUES (4, 24761, NULL, 7, 1, 1, '2025-08-01 15:15:32', 180.00, 1, 1, NULL, '[\"777774714\"]', '2025-08-01 15:15:32', '2025-08-01 15:15:32');
INSERT INTO `buy_items` VALUES (5, 24757, NULL, 7, 1, 1, '2025-08-01 15:15:32', 200.00, 1, 1, NULL, '[\"777774714\"]', '2025-08-01 15:15:32', '2025-08-01 15:15:32');
INSERT INTO `buy_items` VALUES (6, 24757, NULL, 8, 2, 1, '2025-08-01 20:01:55', 240.00, 1, 2, 240.00, '[]', '2025-08-01 20:01:55', '2025-08-01 20:01:55');
INSERT INTO `buy_items` VALUES (7, 24761, NULL, 8, 1, 1, '2025-08-01 20:01:55', 180.00, 1, 2, NULL, '[]', '2025-08-01 20:01:55', '2025-08-01 20:01:55');
INSERT INTO `buy_items` VALUES (8, 24757, NULL, 9, 1, 1, '2025-08-01 23:11:01', 130.00, 1, 2, 130.00, '[]', '2025-08-01 23:11:01', '2025-08-01 23:11:01');
INSERT INTO `buy_items` VALUES (9, 24761, NULL, 9, 1, 1, '2025-08-01 23:11:01', 180.00, 1, 2, NULL, '[]', '2025-08-01 23:11:01', '2025-08-01 23:11:01');
INSERT INTO `buy_items` VALUES (10, 24761, NULL, 10, 1, 1, '2025-08-01 23:26:22', 180.00, 1, 2, NULL, '[\"78787475360\"]', '2025-08-01 23:26:22', '2025-08-02 21:37:43');
INSERT INTO `buy_items` VALUES (11, 24759, NULL, 10, 2, 1, '2025-08-01 23:26:22', 12000.00, 1, 2, NULL, '[]', '2025-08-01 23:26:22', '2025-08-01 23:26:22');
INSERT INTO `buy_items` VALUES (12, 24761, NULL, 11, 1, 1, '2025-08-01 23:36:15', 180.00, 1, 2, NULL, '[\"2000099\"]', '2025-08-01 23:36:15', '2025-08-01 23:36:15');
INSERT INTO `buy_items` VALUES (13, 24757, NULL, 11, 4, 1, '2025-08-01 23:36:15', 200.00, 1, 2, NULL, '[]', '2025-08-01 23:36:15', '2025-08-01 23:36:15');
INSERT INTO `buy_items` VALUES (14, 24761, NULL, 12, 1, 1, '2025-08-02 00:04:26', 180.00, 1, 1, NULL, '[\"741852\"]', '2025-08-02 00:04:26', '2025-08-02 21:53:47');
INSERT INTO `buy_items` VALUES (15, 24757, NULL, 12, 1, 1, '2025-08-02 00:04:26', 200.00, 1, 1, NULL, '[]', '2025-08-02 00:04:26', '2025-08-02 00:04:26');
INSERT INTO `buy_items` VALUES (16, 24761, NULL, 13, 2, 1, '2025-08-02 00:05:32', 180.00, 1, 1, NULL, '[]', '2025-08-02 00:05:32', '2025-08-02 00:05:32');
INSERT INTO `buy_items` VALUES (17, 24759, NULL, 14, 3, 1, '2025-08-02 00:12:23', 12000.00, 1, 1, NULL, '[]', '2025-08-02 00:12:23', '2025-08-02 00:12:23');
INSERT INTO `buy_items` VALUES (18, 24757, NULL, 15, 1, 1, '2025-08-02 00:17:49', 200.00, 1, 1, NULL, '[]', '2025-08-02 00:17:49', '2025-08-02 00:17:49');
INSERT INTO `buy_items` VALUES (19, 24761, NULL, 16, 1, 1, '2025-08-02 15:35:24', 180.00, 1, 1, NULL, '[\"4465564\"]', '2025-08-02 15:35:24', '2025-08-02 15:35:24');
INSERT INTO `buy_items` VALUES (20, 24759, NULL, 16, 1, 1, '2025-08-02 15:35:24', 12000.00, 1, 1, NULL, '[]', '2025-08-02 15:35:24', '2025-08-02 15:35:24');
INSERT INTO `buy_items` VALUES (21, 24757, NULL, 17, 5, 1, '2025-08-02 16:35:30', 15.00, 1, 1, NULL, NULL, '2025-08-02 16:35:30', '2025-08-02 16:35:30');
INSERT INTO `buy_items` VALUES (22, 24759, NULL, 18, 1, 1, '2025-08-20 00:17:04', 12000.00, 1, 3, NULL, '[]', '2025-08-20 00:17:04', '2025-08-20 00:17:04');

-- ----------------------------
-- Table structure for buy_payment_methods
-- ----------------------------
DROP TABLE IF EXISTS `buy_payment_methods`;
CREATE TABLE `buy_payment_methods`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `buy_id` bigint UNSIGNED NOT NULL,
  `payment_method_id` bigint UNSIGNED NOT NULL,
  `amount` decimal(10, 2) NOT NULL,
  `installments` int NOT NULL DEFAULT 1,
  `due_date` date NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `buy_payment_methods_buy_id_foreign`(`buy_id` ASC) USING BTREE,
  INDEX `buy_payment_methods_payment_method_id_foreign`(`payment_method_id` ASC) USING BTREE,
  INDEX `buy_payment_methods_buy_id_payment_method_id_index`(`buy_id` ASC, `payment_method_id` ASC) USING BTREE,
  CONSTRAINT `buy_payment_methods_buy_id_foreign` FOREIGN KEY (`buy_id`) REFERENCES `buys` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `buy_payment_methods_payment_method_id_foreign` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 14 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of buy_payment_methods
-- ----------------------------
INSERT INTO `buy_payment_methods` VALUES (1, 6, 1, 450.00, 1, NULL, '2025-08-01 15:11:26', '2025-08-01 15:11:26');
INSERT INTO `buy_payment_methods` VALUES (2, 7, 1, 450.00, 1, NULL, '2025-08-01 15:15:32', '2025-08-01 15:15:32');
INSERT INTO `buy_payment_methods` VALUES (3, 8, 5, 448.40, 4, '2025-08-27', '2025-08-01 20:01:55', '2025-08-01 20:01:55');
INSERT INTO `buy_payment_methods` VALUES (4, 9, 3, 448.40, 3, NULL, '2025-08-01 23:11:01', '2025-08-01 23:11:01');
INSERT INTO `buy_payment_methods` VALUES (5, 10, 5, 14372.40, 2, NULL, '2025-08-01 23:26:22', '2025-08-01 23:26:22');
INSERT INTO `buy_payment_methods` VALUES (6, 11, 8, 448.40, 2, NULL, '2025-08-01 23:36:15', '2025-08-01 23:36:15');
INSERT INTO `buy_payment_methods` VALUES (7, 12, 4, 448.40, 1, NULL, '2025-08-02 00:04:26', '2025-08-02 00:04:26');
INSERT INTO `buy_payment_methods` VALUES (8, 13, 7, 424.80, 1, NULL, '2025-08-02 00:05:32', '2025-08-02 00:05:32');
INSERT INTO `buy_payment_methods` VALUES (9, 14, 2, 42480.00, 3, NULL, '2025-08-02 00:12:23', '2025-08-02 00:12:23');
INSERT INTO `buy_payment_methods` VALUES (10, 15, 5, 236.00, 3, NULL, '2025-08-02 00:17:49', '2025-08-02 00:17:49');
INSERT INTO `buy_payment_methods` VALUES (11, 16, 5, 14372.40, 2, NULL, '2025-08-02 15:35:24', '2025-08-02 15:35:24');
INSERT INTO `buy_payment_methods` VALUES (12, 17, 8, 75.00, 1, NULL, '2025-08-02 16:35:30', '2025-08-02 16:35:30');
INSERT INTO `buy_payment_methods` VALUES (13, 18, 1, 14160.00, 1, NULL, '2025-08-20 00:17:04', '2025-08-20 00:17:04');

-- ----------------------------
-- Table structure for buy_sunat
-- ----------------------------
DROP TABLE IF EXISTS `buy_sunat`;
CREATE TABLE `buy_sunat`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `buy_id` bigint UNSIGNED NOT NULL,
  `name_xml` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `qr_info` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `hash` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `buy_sunat_buy_id_foreign`(`buy_id` ASC) USING BTREE,
  CONSTRAINT `buy_sunat_buy_id_foreign` FOREIGN KEY (`buy_id`) REFERENCES `buys` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of buy_sunat
-- ----------------------------

-- ----------------------------
-- Table structure for buys
-- ----------------------------
DROP TABLE IF EXISTS `buys`;
CREATE TABLE `buys`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_dni` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `customer_names_surnames` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `customer_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `total_price` decimal(10, 2) NOT NULL,
  `igv` decimal(10, 2) NOT NULL,
  `observation` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `serie` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `number` int UNSIGNED NOT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `status_buy` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `document_type_id` bigint UNSIGNED NULL DEFAULT NULL,
  `supplier_id` bigint UNSIGNED NULL DEFAULT NULL,
  `warehouse_id` bigint UNSIGNED NULL DEFAULT NULL,
  `payment_type` enum('cash','credit') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT 'cash',
  `delivery_status` enum('received','pending') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT 'pending',
  `received_date` timestamp NULL DEFAULT NULL,
  `tienda_id` bigint UNSIGNED NULL DEFAULT NULL,
  `user_register` bigint UNSIGNED NULL DEFAULT NULL,
  `user_update` bigint UNSIGNED NULL DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fecha_vencimiento` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `buys_document_type_id_foreign`(`document_type_id` ASC) USING BTREE,
  INDEX `buys_user_register_foreign`(`user_register` ASC) USING BTREE,
  INDEX `buys_user_update_foreign`(`user_update` ASC) USING BTREE,
  INDEX `buys_supplier_id_foreign`(`supplier_id` ASC) USING BTREE,
  INDEX `buys_tienda_id_foreign`(`tienda_id` ASC) USING BTREE,
  INDEX `warehouse_id`(`warehouse_id` ASC) USING BTREE,
  CONSTRAINT `buys_document_type_id_foreign` FOREIGN KEY (`document_type_id`) REFERENCES `document_types` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `buys_ibfk_1` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `buys_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `clientes_mayoristas` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `buys_tienda_id_foreign` FOREIGN KEY (`tienda_id`) REFERENCES `tiendas` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `buys_user_register_foreign` FOREIGN KEY (`user_register`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `buys_user_update_foreign` FOREIGN KEY (`user_update`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 19 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of buys
-- ----------------------------
INSERT INTO `buys` VALUES (6, '', '', '', 448.40, 68.40, 'Se ha guardado', 'NC01', 1, '1', '0', 6, 2, NULL, 'cash', 'pending', NULL, 1, 1, NULL, '2025-08-01 15:11:26', '2025-08-01 10:11:26', '2025-08-01 10:11:26', '2025-08-01 15:11:26', '2025-08-01 15:11:26');
INSERT INTO `buys` VALUES (7, '', '', '', 448.40, 68.40, 'Se guarda compra 2', 'NC01', 2, '1', '0', 6, 2, NULL, 'cash', 'received', '2025-08-01 15:15:32', 1, 1, NULL, '2025-08-01 15:15:32', '2025-08-01 10:15:32', '2025-08-01 10:15:32', '2025-08-01 15:15:32', '2025-08-01 15:15:32');
INSERT INTO `buys` VALUES (8, '', '', '', 778.80, 118.80, 'Tercera compra, prueba', 'NC01', 3, '1', '0', 6, 2, NULL, 'credit', 'pending', NULL, 2, 1, NULL, '2025-08-01 20:01:55', '2025-08-01 15:01:55', '2025-08-01 15:01:55', '2025-08-01 20:01:55', '2025-08-01 20:01:55');
INSERT INTO `buys` VALUES (9, '', '', '', 365.80, 55.80, 'Guardado con cuotas,', 'NC01', 4, '1', '0', 6, 1, NULL, 'credit', 'pending', NULL, 2, 1, NULL, '2025-08-01 23:11:01', '2025-08-01 18:11:01', '2025-08-01 18:11:01', '2025-08-01 23:11:01', '2025-08-01 23:11:01');
INSERT INTO `buys` VALUES (10, '', '', '', 24180.00, 0.00, 'Guardando 4', 'NC01', 5, '1', '0', 6, 2, NULL, 'credit', 'received', '2025-08-02 21:37:43', 2, 1, 1, '2025-08-02 16:37:43', '2025-08-02 16:37:43', '2025-08-02 21:37:43', '2025-08-01 23:26:22', '2025-08-02 21:37:43');
INSERT INTO `buys` VALUES (11, '', '', '', 1156.40, 176.40, 'Guarda, pero registrando,', 'NC01', 6, '1', '0', 6, 1, NULL, 'credit', 'received', '2025-08-01 23:36:15', 2, 1, NULL, '2025-08-01 23:36:15', '2025-08-01 18:36:15', '2025-08-01 18:36:15', '2025-08-01 23:36:15', '2025-08-01 23:36:15');
INSERT INTO `buys` VALUES (12, '', '', '', 448.40, 68.40, 'Guarded,', 'NC01', 7, '1', '0', 6, 1, NULL, 'credit', 'received', '2025-08-02 21:53:47', 1, 1, 1, '2025-08-02 16:53:47', '2025-08-02 16:53:47', '2025-08-02 21:53:47', '2025-08-02 00:04:26', '2025-08-02 21:53:47');
INSERT INTO `buys` VALUES (13, '', '', '', 424.80, 64.80, NULL, 'NC01', 8, '1', '0', 6, 1, NULL, 'credit', 'pending', NULL, 1, 1, NULL, '2025-08-02 00:05:32', '2025-08-01 19:05:32', '2025-08-01 19:05:32', '2025-08-02 00:05:32', '2025-08-02 00:05:32');
INSERT INTO `buys` VALUES (14, '', '', '', 42480.00, 6480.00, NULL, 'NC01', 9, '1', '0', 6, 1, NULL, 'credit', 'pending', NULL, 1, 1, NULL, '2025-08-02 00:12:23', '2025-08-01 19:12:23', '2025-08-01 19:12:23', '2025-08-02 00:12:23', '2025-08-02 00:12:23');
INSERT INTO `buys` VALUES (15, '', '', '', 236.00, 36.00, 'zrider', 'NC01', 10, '1', '0', 6, 1, NULL, 'credit', 'pending', NULL, 1, 1, NULL, '2025-08-02 00:17:49', '2025-08-01 19:17:49', '2025-08-01 19:17:49', '2025-08-02 00:17:49', '2025-08-02 00:17:49');
INSERT INTO `buys` VALUES (16, '', '', '', 14372.40, 2192.40, NULL, 'NC01', 11, '1', '0', 6, 3, NULL, 'credit', 'received', '2025-08-02 15:35:24', 1, 1, NULL, '2025-08-02 15:35:24', '2025-08-02 10:35:24', '2025-08-02 10:35:24', '2025-08-02 15:35:24', '2025-08-02 15:35:24');
INSERT INTO `buys` VALUES (17, '', '', '', 75.00, 13.50, 'Compra urgente', 'NC01', 12, '1', '0', 6, 5, NULL, 'cash', 'pending', NULL, 1, 1, NULL, '2025-08-02 16:35:30', '2025-08-02 11:35:30', '2025-08-02 11:35:30', '2025-08-02 16:35:30', '2025-08-02 16:35:30');
INSERT INTO `buys` VALUES (18, '', '', '', 14160.00, 2160.00, 'NINGUNA', 'NC01', 13, '1', '0', 6, 2, NULL, 'cash', 'pending', NULL, 3, 1, NULL, '2025-08-20 00:17:04', '2025-08-19 19:17:04', '2025-08-19 19:17:04', '2025-08-20 00:17:04', '2025-08-20 00:17:04');

-- ----------------------------
-- Table structure for cars
-- ----------------------------
DROP TABLE IF EXISTS `cars`;
CREATE TABLE `cars`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `drives_id` bigint UNSIGNED NULL DEFAULT NULL,
  `codigo` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `placa` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `marca` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `modelo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `anio` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `condicion` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `nro_chasis` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `fecha_soat` date NULL DEFAULT NULL,
  `fecha_seguro` date NULL DEFAULT NULL,
  `color` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `user_register` bigint UNSIGNED NULL DEFAULT NULL,
  `user_update` bigint UNSIGNED NULL DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `fecha_registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `cars_codigo_unique`(`codigo` ASC) USING BTREE,
  UNIQUE INDEX `cars_placa_unique`(`placa` ASC) USING BTREE,
  INDEX `cars_drives_id_foreign`(`drives_id` ASC) USING BTREE,
  INDEX `cars_user_register_foreign`(`user_register` ASC) USING BTREE,
  INDEX `cars_user_update_foreign`(`user_update` ASC) USING BTREE,
  CONSTRAINT `cars_drives_id_foreign` FOREIGN KEY (`drives_id`) REFERENCES `drives` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `cars_user_register_foreign` FOREIGN KEY (`user_register`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `cars_user_update_foreign` FOREIGN KEY (`user_update`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of cars
-- ----------------------------
INSERT INTO `cars` VALUES (1, 2, '0000001', '3432', 'MASTER GOLDS', 'AMG-15L', '2004', 'Propio', '2134asd', '2026-02-06', '2026-05-21', 'red', 1, NULL, 1, '2025-08-27 10:20:22', '2025-08-27 10:20:22', '2025-08-27 15:20:22', '2025-08-27 15:20:22');

-- ----------------------------
-- Table structure for clientes_mayoristas
-- ----------------------------
DROP TABLE IF EXISTS `clientes_mayoristas`;
CREATE TABLE `clientes_mayoristas`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `codigo` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_doc` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `nro_documento` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombres` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellido_paterno` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `apellido_materno` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `nombre_negocio` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tienda` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `telefono` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `correo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `departamento` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `provincia` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `distrito` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `direccion_detalle` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `nombres_contacto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `telefono_contacto` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `parentesco_contacto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `user_register` bigint UNSIGNED NOT NULL,
  `user_update` bigint UNSIGNED NULL DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `clientes_mayoristas_codigo_unique`(`codigo` ASC) USING BTREE,
  UNIQUE INDEX `clientes_mayoristas_nro_documento_unique`(`nro_documento` ASC) USING BTREE,
  INDEX `clientes_mayoristas_user_register_foreign`(`user_register` ASC) USING BTREE,
  INDEX `clientes_mayoristas_user_update_foreign`(`user_update` ASC) USING BTREE,
  CONSTRAINT `clientes_mayoristas_user_register_foreign` FOREIGN KEY (`user_register`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `clientes_mayoristas_user_update_foreign` FOREIGN KEY (`user_update`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of clientes_mayoristas
-- ----------------------------
INSERT INTO `clientes_mayoristas` VALUES (1, 'CM0000001', 'DNI', '77426200', 'BRENDY YOSELY', 'ZAPATA', 'Emer', 'comi', 'fvfvf', '993321920', NULL, 'Ancash', 'Asuncion', 'Acochaca', 'Paita 2 de mayo', 'emer', '993321920', 'svdacc', NULL, 1, 1, NULL, '2025-07-25 16:53:19', NULL, '2025-07-25 21:53:19', '2025-07-25 21:53:19');
INSERT INTO `clientes_mayoristas` VALUES (2, 'PROV002', 'DNI', '73894799', 'PIERO ALEXANDER', 'MORALES', 'YANGUA', 'PIERO ALEXANDER MORALES YANGUA', NULL, '960906717', NULL, NULL, NULL, NULL, 'Ciudad Blanca Mz \"O\" Lt 11', NULL, NULL, NULL, NULL, 1, 1, NULL, '2025-08-01 08:25:52', NULL, '2025-08-01 13:25:52', '2025-08-01 13:25:52');
INSERT INTO `clientes_mayoristas` VALUES (3, 'PROV003', 'DNI', '03499309', 'MERCEDES ALEX', 'MORALES', 'COTRINA', 'MERCEDES ALEX MORALES COTRINA', NULL, '95955454', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, '2025-08-02 10:32:52', NULL, '2025-08-02 15:32:52', '2025-08-02 15:32:52');
INSERT INTO `clientes_mayoristas` VALUES (4, 'PROV004', 'RUC', '20123456789', 'Proveedor Ejemplo SAC', NULL, NULL, 'Proveedor Ejemplo SAC', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, '2025-08-02 11:32:07', NULL, '2025-08-02 16:32:07', '2025-08-02 16:32:07');
INSERT INTO `clientes_mayoristas` VALUES (5, 'PROV005', 'RUC', '12345678', 'Juan Pérez López', NULL, NULL, 'Juan Pérez López', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, '2025-08-02 11:32:07', NULL, '2025-08-02 16:32:07', '2025-08-02 16:32:07');

-- ----------------------------
-- Table structure for companies
-- ----------------------------
DROP TABLE IF EXISTS `companies`;
CREATE TABLE `companies`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `razon_social` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ruc` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `direccion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `sol_user` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sol_pass` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cert_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `client_secret` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `production` tinyint(1) NOT NULL DEFAULT 0,
  `ubigeo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `distrito` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `provincia` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `departamento` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of companies
-- ----------------------------
INSERT INTO `companies` VALUES (1, 'Tech Solutions S.A.C.', '20123456789', 'Av. Principal 123, Lima', 'logos/tech.png', 'admin_tech', '$2y$12$8siBbR.IMiY72OgZ5VnB2OjwSddJxv4u5MWLQNoFQELm/AdLK/vMK', 'certs/tech_cert.pem', 'client_id_tech', 'client_secret_tech', 0, '150101', 'Lima', 'Lima', 'Lima', '2025-05-05 16:22:28', '2025-05-05 16:22:28');
INSERT INTO `companies` VALUES (2, 'Innova Business E.I.R.L.', '20100686814', 'Calle Comercio 456, Arequipa', 'logos/innova.png', 'admin_innova', '$2y$12$XSFgThB8P.VSdH7nZR9emOTVfsva2PkKGi43Bbp7aMjqPcEjIGk/O', 'certs/innova_cert.pem', 'client_id_innova', 'client_secret_innova', 0, '040101', 'Arequipa', 'Arequipa', 'Arequipa', '2025-05-05 16:22:29', '2025-05-05 16:22:29');

-- ----------------------------
-- Table structure for devolucion_items
-- ----------------------------
DROP TABLE IF EXISTS `devolucion_items`;
CREATE TABLE `devolucion_items`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `devolucion_id` bigint UNSIGNED NOT NULL,
  `sale_item_id` bigint UNSIGNED NOT NULL,
  `quantity_returned` int NOT NULL,
  `unit_price` decimal(10, 2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `devolucion_id`(`devolucion_id` ASC) USING BTREE,
  INDEX `sale_item_id`(`sale_item_id` ASC) USING BTREE,
  CONSTRAINT `devolucion_items_ibfk_1` FOREIGN KEY (`devolucion_id`) REFERENCES `devoluciones` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `devolucion_items_ibfk_2` FOREIGN KEY (`sale_item_id`) REFERENCES `sale_items` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of devolucion_items
-- ----------------------------
INSERT INTO `devolucion_items` VALUES (1, 1, 4, 1, 12000.00, '2025-08-21 23:08:44', '2025-08-21 23:08:44');

-- ----------------------------
-- Table structure for devoluciones
-- ----------------------------
DROP TABLE IF EXISTS `devoluciones`;
CREATE TABLE `devoluciones`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `sale_id` bigint UNSIGNED NOT NULL,
  `total_amount` decimal(10, 2) NOT NULL,
  `reason` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `user_register` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `sale_id`(`sale_id` ASC) USING BTREE,
  CONSTRAINT `devoluciones_ibfk_1` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of devoluciones
-- ----------------------------
INSERT INTO `devoluciones` VALUES (1, '0000001', 3, 12000.00, 'equipo dañado', 1, '2025-08-21 23:08:43', '2025-08-21 23:08:43');

-- ----------------------------
-- Table structure for districts
-- ----------------------------
DROP TABLE IF EXISTS `districts`;
CREATE TABLE `districts`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ubigeo` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `provinces_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `districts_ubigeo_unique`(`ubigeo` ASC) USING BTREE,
  INDEX `districts_provinces_id_foreign`(`provinces_id` ASC) USING BTREE,
  CONSTRAINT `districts_provinces_id_foreign` FOREIGN KEY (`provinces_id`) REFERENCES `provinces` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1834 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of districts
-- ----------------------------
INSERT INTO `districts` VALUES (1, 'La Peca', '010201', 1, NULL, NULL);
INSERT INTO `districts` VALUES (2, 'Aramango', '010202', 1, NULL, NULL);
INSERT INTO `districts` VALUES (3, 'Copallin', '010203', 1, NULL, NULL);
INSERT INTO `districts` VALUES (4, 'El Parco', '010204', 1, NULL, NULL);
INSERT INTO `districts` VALUES (5, 'Imaza', '010206', 1, NULL, NULL);
INSERT INTO `districts` VALUES (6, 'Jumbilla', '010301', 2, NULL, NULL);
INSERT INTO `districts` VALUES (7, 'Corosha', '010302', 2, NULL, NULL);
INSERT INTO `districts` VALUES (8, 'Cuispes', '010303', 2, NULL, NULL);
INSERT INTO `districts` VALUES (9, 'Chisquilla', '010304', 2, NULL, NULL);
INSERT INTO `districts` VALUES (10, 'Churuja', '010305', 2, NULL, NULL);
INSERT INTO `districts` VALUES (11, 'Florida', '010306', 2, NULL, NULL);
INSERT INTO `districts` VALUES (12, 'Recta', '010307', 2, NULL, NULL);
INSERT INTO `districts` VALUES (13, 'San Carlos', '010308', 2, NULL, NULL);
INSERT INTO `districts` VALUES (14, 'Shipasbamba', '010309', 2, NULL, NULL);
INSERT INTO `districts` VALUES (15, 'Valera', '010310', 2, NULL, NULL);
INSERT INTO `districts` VALUES (16, 'Yambrasbamba', '010311', 2, NULL, NULL);
INSERT INTO `districts` VALUES (17, 'Jazan', '010312', 2, NULL, NULL);
INSERT INTO `districts` VALUES (18, 'Chachapoyas', '010101', 3, NULL, NULL);
INSERT INTO `districts` VALUES (19, 'Asuncion', '010102', 3, NULL, NULL);
INSERT INTO `districts` VALUES (20, 'Balsas', '010103', 3, NULL, NULL);
INSERT INTO `districts` VALUES (21, 'Cheto', '010104', 3, NULL, NULL);
INSERT INTO `districts` VALUES (22, 'Chiliquin', '010105', 3, NULL, NULL);
INSERT INTO `districts` VALUES (23, 'Chuquibamba', '010106', 3, NULL, NULL);
INSERT INTO `districts` VALUES (24, 'Granada', '010107', 3, NULL, NULL);
INSERT INTO `districts` VALUES (25, 'Huancas', '010108', 3, NULL, NULL);
INSERT INTO `districts` VALUES (26, 'La Jalca', '010109', 3, NULL, NULL);
INSERT INTO `districts` VALUES (27, 'Leymebamba', '010110', 3, NULL, NULL);
INSERT INTO `districts` VALUES (28, 'Levanto', '010111', 3, NULL, NULL);
INSERT INTO `districts` VALUES (29, 'Magdalena', '010112', 3, NULL, NULL);
INSERT INTO `districts` VALUES (30, 'Mariscal Castilla', '010113', 3, NULL, NULL);
INSERT INTO `districts` VALUES (31, 'Molinopampa', '010114', 3, NULL, NULL);
INSERT INTO `districts` VALUES (32, 'Montevideo', '010115', 3, NULL, NULL);
INSERT INTO `districts` VALUES (33, 'Olleros', '010116', 3, NULL, NULL);
INSERT INTO `districts` VALUES (34, 'Quinjalca', '010117', 3, NULL, NULL);
INSERT INTO `districts` VALUES (35, 'San Francisco De Daguas', '010118', 3, NULL, NULL);
INSERT INTO `districts` VALUES (36, 'San Isidro De Maino', '010119', 3, NULL, NULL);
INSERT INTO `districts` VALUES (37, 'Soloco', '010120', 3, NULL, NULL);
INSERT INTO `districts` VALUES (38, 'Sonche', '010121', 3, NULL, NULL);
INSERT INTO `districts` VALUES (39, 'Nieva', '010601', 4, NULL, NULL);
INSERT INTO `districts` VALUES (40, 'Rio Santiago', '010602', 4, NULL, NULL);
INSERT INTO `districts` VALUES (41, 'El Cenepa', '010603', 4, NULL, NULL);
INSERT INTO `districts` VALUES (42, 'Lamud', '010401', 5, NULL, NULL);
INSERT INTO `districts` VALUES (43, 'Camporredondo', '010402', 5, NULL, NULL);
INSERT INTO `districts` VALUES (44, 'Cocabamba', '010403', 5, NULL, NULL);
INSERT INTO `districts` VALUES (45, 'Colcamar', '010404', 5, NULL, NULL);
INSERT INTO `districts` VALUES (46, 'Conila', '010405', 5, NULL, NULL);
INSERT INTO `districts` VALUES (47, 'Inguilpata', '010406', 5, NULL, NULL);
INSERT INTO `districts` VALUES (48, 'Longuita', '010407', 5, NULL, NULL);
INSERT INTO `districts` VALUES (49, 'Lonya Chico', '010408', 5, NULL, NULL);
INSERT INTO `districts` VALUES (50, 'Luya', '010409', 5, NULL, NULL);
INSERT INTO `districts` VALUES (51, 'Luya Viejo', '010410', 5, NULL, NULL);
INSERT INTO `districts` VALUES (52, 'Maria', '010411', 5, NULL, NULL);
INSERT INTO `districts` VALUES (53, 'Ocalli', '010412', 5, NULL, NULL);
INSERT INTO `districts` VALUES (54, 'Ocumal', '010413', 5, NULL, NULL);
INSERT INTO `districts` VALUES (55, 'Pisuquia', '010414', 5, NULL, NULL);
INSERT INTO `districts` VALUES (56, 'San Cristobal', '010415', 5, NULL, NULL);
INSERT INTO `districts` VALUES (57, 'San Francisco De Yeso', '010416', 5, NULL, NULL);
INSERT INTO `districts` VALUES (58, 'San Jeronimo', '010417', 5, NULL, NULL);
INSERT INTO `districts` VALUES (59, 'San Juan De Lopecancha', '010418', 5, NULL, NULL);
INSERT INTO `districts` VALUES (60, 'Santa Catalina', '010419', 5, NULL, NULL);
INSERT INTO `districts` VALUES (61, 'Santo Tomas', '010420', 5, NULL, NULL);
INSERT INTO `districts` VALUES (62, 'Tingo', '010421', 5, NULL, NULL);
INSERT INTO `districts` VALUES (63, 'Trita', '010422', 5, NULL, NULL);
INSERT INTO `districts` VALUES (64, 'Providencia', '010423', 5, NULL, NULL);
INSERT INTO `districts` VALUES (65, 'San Nicolas', '010501', 6, NULL, NULL);
INSERT INTO `districts` VALUES (66, 'Cochamal', '010502', 6, NULL, NULL);
INSERT INTO `districts` VALUES (67, 'Chirimoto', '010503', 6, NULL, NULL);
INSERT INTO `districts` VALUES (68, 'Huambo', '010504', 6, NULL, NULL);
INSERT INTO `districts` VALUES (69, 'Limabamba', '010505', 6, NULL, NULL);
INSERT INTO `districts` VALUES (70, 'Longar', '010506', 6, NULL, NULL);
INSERT INTO `districts` VALUES (71, 'Milpucc', '010507', 6, NULL, NULL);
INSERT INTO `districts` VALUES (72, 'Mariscal Benavides', '010508', 6, NULL, NULL);
INSERT INTO `districts` VALUES (73, 'Omia', '010509', 6, NULL, NULL);
INSERT INTO `districts` VALUES (74, 'Santa Rosa', '010510', 6, NULL, NULL);
INSERT INTO `districts` VALUES (75, 'Totora', '010511', 6, NULL, NULL);
INSERT INTO `districts` VALUES (76, 'Vista Alegre', '010512', 6, NULL, NULL);
INSERT INTO `districts` VALUES (77, 'Bagua Grande', '010701', 7, NULL, NULL);
INSERT INTO `districts` VALUES (78, 'Cajaruro', '010702', 7, NULL, NULL);
INSERT INTO `districts` VALUES (79, 'Cumba', '010703', 7, NULL, NULL);
INSERT INTO `districts` VALUES (80, 'El Milagro', '010704', 7, NULL, NULL);
INSERT INTO `districts` VALUES (81, 'Jamalca', '010705', 7, NULL, NULL);
INSERT INTO `districts` VALUES (82, 'Lonya Grande', '010706', 7, NULL, NULL);
INSERT INTO `districts` VALUES (83, 'Yamon', '010707', 7, NULL, NULL);
INSERT INTO `districts` VALUES (84, 'Aija', '020201', 8, NULL, NULL);
INSERT INTO `districts` VALUES (85, 'Coris', '020203', 8, NULL, NULL);
INSERT INTO `districts` VALUES (86, 'Huacllan', '020205', 8, NULL, NULL);
INSERT INTO `districts` VALUES (87, 'La Merced', '020206', 8, NULL, NULL);
INSERT INTO `districts` VALUES (88, 'Succha', '020208', 8, NULL, NULL);
INSERT INTO `districts` VALUES (89, 'Llamellin', '021601', 9, NULL, NULL);
INSERT INTO `districts` VALUES (90, 'Aczo', '021602', 9, NULL, NULL);
INSERT INTO `districts` VALUES (91, 'Chaccho', '021603', 9, NULL, NULL);
INSERT INTO `districts` VALUES (92, 'Chingas', '021604', 9, NULL, NULL);
INSERT INTO `districts` VALUES (93, 'Mirgas', '021605', 9, NULL, NULL);
INSERT INTO `districts` VALUES (94, 'San Juan De Rontoy', '021606', 9, NULL, NULL);
INSERT INTO `districts` VALUES (95, 'Chacas', '021801', 10, NULL, NULL);
INSERT INTO `districts` VALUES (96, 'Acochaca', '021802', 10, NULL, NULL);
INSERT INTO `districts` VALUES (97, 'Chiquian', '020301', 11, NULL, NULL);
INSERT INTO `districts` VALUES (98, 'Abelardo Pardo Lezameta', '020302', 11, NULL, NULL);
INSERT INTO `districts` VALUES (99, 'Aquia', '020304', 11, NULL, NULL);
INSERT INTO `districts` VALUES (100, 'Cajacay', '020305', 11, NULL, NULL);
INSERT INTO `districts` VALUES (101, 'Huayllacayan', '020310', 11, NULL, NULL);
INSERT INTO `districts` VALUES (102, 'Huasta', '020311', 11, NULL, NULL);
INSERT INTO `districts` VALUES (103, 'Mangas', '020313', 11, NULL, NULL);
INSERT INTO `districts` VALUES (104, 'Pacllon', '020315', 11, NULL, NULL);
INSERT INTO `districts` VALUES (105, 'San Miguel De Corpanqui', '020317', 11, NULL, NULL);
INSERT INTO `districts` VALUES (106, 'Ticllos', '020320', 11, NULL, NULL);
INSERT INTO `districts` VALUES (107, 'Antonio Raimondi', '020321', 11, NULL, NULL);
INSERT INTO `districts` VALUES (108, 'Canis', '020322', 11, NULL, NULL);
INSERT INTO `districts` VALUES (109, 'Colquioc', '020323', 11, NULL, NULL);
INSERT INTO `districts` VALUES (110, 'La Primavera', '020324', 11, NULL, NULL);
INSERT INTO `districts` VALUES (111, 'Huallanca', '020325', 11, NULL, NULL);
INSERT INTO `districts` VALUES (112, 'Carhuaz', '020401', 12, NULL, NULL);
INSERT INTO `districts` VALUES (113, 'Acopampa', '020402', 12, NULL, NULL);
INSERT INTO `districts` VALUES (114, 'Amashca', '020403', 12, NULL, NULL);
INSERT INTO `districts` VALUES (115, 'Anta', '020404', 12, NULL, NULL);
INSERT INTO `districts` VALUES (116, 'Ataquero', '020405', 12, NULL, NULL);
INSERT INTO `districts` VALUES (117, 'Marcara', '020406', 12, NULL, NULL);
INSERT INTO `districts` VALUES (118, 'Pariahuanca', '020407', 12, NULL, NULL);
INSERT INTO `districts` VALUES (119, 'San Miguel De Aco', '020408', 12, NULL, NULL);
INSERT INTO `districts` VALUES (120, 'Shilla', '020409', 12, NULL, NULL);
INSERT INTO `districts` VALUES (121, 'Tinco', '020410', 12, NULL, NULL);
INSERT INTO `districts` VALUES (122, 'Yungar', '020411', 12, NULL, NULL);
INSERT INTO `districts` VALUES (123, 'San Luis', '021701', 13, NULL, NULL);
INSERT INTO `districts` VALUES (124, 'Yauya', '021702', 13, NULL, NULL);
INSERT INTO `districts` VALUES (125, 'San Nicolas', '021703', 13, NULL, NULL);
INSERT INTO `districts` VALUES (126, 'Casma', '020501', 14, NULL, NULL);
INSERT INTO `districts` VALUES (127, 'Buena Vista Alta', '020502', 14, NULL, NULL);
INSERT INTO `districts` VALUES (128, 'Comandante Noel', '020503', 14, NULL, NULL);
INSERT INTO `districts` VALUES (129, 'Yautan', '020505', 14, NULL, NULL);
INSERT INTO `districts` VALUES (130, 'Corongo', '020601', 15, NULL, NULL);
INSERT INTO `districts` VALUES (131, 'Aco', '020602', 15, NULL, NULL);
INSERT INTO `districts` VALUES (132, 'Bambas', '020603', 15, NULL, NULL);
INSERT INTO `districts` VALUES (133, 'Cusca', '020604', 15, NULL, NULL);
INSERT INTO `districts` VALUES (134, 'La Pampa', '020605', 15, NULL, NULL);
INSERT INTO `districts` VALUES (135, 'Yanac', '020606', 15, NULL, NULL);
INSERT INTO `districts` VALUES (136, 'Yupan', '020607', 15, NULL, NULL);
INSERT INTO `districts` VALUES (137, 'Huaraz', '020101', 16, NULL, NULL);
INSERT INTO `districts` VALUES (138, 'Independencia', '020102', 16, NULL, NULL);
INSERT INTO `districts` VALUES (139, 'Cochabamba', '020103', 16, NULL, NULL);
INSERT INTO `districts` VALUES (140, 'Colcabamba', '020104', 16, NULL, NULL);
INSERT INTO `districts` VALUES (141, 'Huanchay', '020105', 16, NULL, NULL);
INSERT INTO `districts` VALUES (142, 'Jangas', '020106', 16, NULL, NULL);
INSERT INTO `districts` VALUES (143, 'La Libertad', '020107', 16, NULL, NULL);
INSERT INTO `districts` VALUES (144, 'Olleros', '020108', 16, NULL, NULL);
INSERT INTO `districts` VALUES (145, 'Pampas', '020109', 16, NULL, NULL);
INSERT INTO `districts` VALUES (146, 'Pariacoto', '020110', 16, NULL, NULL);
INSERT INTO `districts` VALUES (147, 'Pira', '020111', 16, NULL, NULL);
INSERT INTO `districts` VALUES (148, 'Tarica', '020112', 16, NULL, NULL);
INSERT INTO `districts` VALUES (149, 'Huari', '020801', 17, NULL, NULL);
INSERT INTO `districts` VALUES (150, 'Cajay', '020802', 17, NULL, NULL);
INSERT INTO `districts` VALUES (151, 'Chavin De Huantar', '020803', 17, NULL, NULL);
INSERT INTO `districts` VALUES (152, 'Huacachi', '020804', 17, NULL, NULL);
INSERT INTO `districts` VALUES (153, 'Huachis', '020805', 17, NULL, NULL);
INSERT INTO `districts` VALUES (154, 'Huacchis', '020806', 17, NULL, NULL);
INSERT INTO `districts` VALUES (155, 'Huantar', '020807', 17, NULL, NULL);
INSERT INTO `districts` VALUES (156, 'Masin', '020808', 17, NULL, NULL);
INSERT INTO `districts` VALUES (157, 'Paucas', '020809', 17, NULL, NULL);
INSERT INTO `districts` VALUES (158, 'Ponto', '020810', 17, NULL, NULL);
INSERT INTO `districts` VALUES (159, 'Rahuapampa', '020811', 17, NULL, NULL);
INSERT INTO `districts` VALUES (160, 'Rapayan', '020812', 17, NULL, NULL);
INSERT INTO `districts` VALUES (161, 'San Marcos', '020813', 17, NULL, NULL);
INSERT INTO `districts` VALUES (162, 'San Pedro De Chana', '020814', 17, NULL, NULL);
INSERT INTO `districts` VALUES (163, 'Uco', '020815', 17, NULL, NULL);
INSERT INTO `districts` VALUES (164, 'Anra', '020816', 17, NULL, NULL);
INSERT INTO `districts` VALUES (165, 'Huarmey', '021901', 18, NULL, NULL);
INSERT INTO `districts` VALUES (166, 'Cochapeti', '021902', 18, NULL, NULL);
INSERT INTO `districts` VALUES (167, 'Huayan', '021903', 18, NULL, NULL);
INSERT INTO `districts` VALUES (168, 'Malvas', '021904', 18, NULL, NULL);
INSERT INTO `districts` VALUES (169, 'Culebras', '021905', 18, NULL, NULL);
INSERT INTO `districts` VALUES (170, 'Caraz', '020701', 19, NULL, NULL);
INSERT INTO `districts` VALUES (171, 'Huallanca', '020702', 19, NULL, NULL);
INSERT INTO `districts` VALUES (172, 'Huata', '020703', 19, NULL, NULL);
INSERT INTO `districts` VALUES (173, 'Huaylas', '020704', 19, NULL, NULL);
INSERT INTO `districts` VALUES (174, 'Mato', '020705', 19, NULL, NULL);
INSERT INTO `districts` VALUES (175, 'Pamparomas', '020706', 19, NULL, NULL);
INSERT INTO `districts` VALUES (176, 'Pueblo Libre', '020707', 19, NULL, NULL);
INSERT INTO `districts` VALUES (177, 'Santa Cruz', '020708', 19, NULL, NULL);
INSERT INTO `districts` VALUES (178, 'Yuracmarca', '020709', 19, NULL, NULL);
INSERT INTO `districts` VALUES (179, 'Santo Toribio', '020710', 19, NULL, NULL);
INSERT INTO `districts` VALUES (180, 'Piscobamba', '020901', 20, NULL, NULL);
INSERT INTO `districts` VALUES (181, 'Casca', '020902', 20, NULL, NULL);
INSERT INTO `districts` VALUES (182, 'Lucma', '020903', 20, NULL, NULL);
INSERT INTO `districts` VALUES (183, 'Fidel Olivas Escudero', '020904', 20, NULL, NULL);
INSERT INTO `districts` VALUES (184, 'Llama', '020905', 20, NULL, NULL);
INSERT INTO `districts` VALUES (185, 'Llumpa', '020906', 20, NULL, NULL);
INSERT INTO `districts` VALUES (186, 'Musga', '020907', 20, NULL, NULL);
INSERT INTO `districts` VALUES (187, 'Eleazar Guzman Barron', '020908', 20, NULL, NULL);
INSERT INTO `districts` VALUES (188, 'Acas', '022001', 21, NULL, NULL);
INSERT INTO `districts` VALUES (189, 'Cajamarquilla', '022002', 21, NULL, NULL);
INSERT INTO `districts` VALUES (190, 'Carhuapampa', '022003', 21, NULL, NULL);
INSERT INTO `districts` VALUES (191, 'Cochas', '022004', 21, NULL, NULL);
INSERT INTO `districts` VALUES (192, 'Congas', '022005', 21, NULL, NULL);
INSERT INTO `districts` VALUES (193, 'Llipa', '022006', 21, NULL, NULL);
INSERT INTO `districts` VALUES (194, 'Ocros', '022007', 21, NULL, NULL);
INSERT INTO `districts` VALUES (195, 'San Cristobal De Rajan', '022008', 21, NULL, NULL);
INSERT INTO `districts` VALUES (196, 'San Pedro', '022009', 21, NULL, NULL);
INSERT INTO `districts` VALUES (197, 'Santiago De Chilcas', '022010', 21, NULL, NULL);
INSERT INTO `districts` VALUES (198, 'Cabana', '021001', 22, NULL, NULL);
INSERT INTO `districts` VALUES (199, 'Bolognesi', '021002', 22, NULL, NULL);
INSERT INTO `districts` VALUES (200, 'Conchucos', '021003', 22, NULL, NULL);
INSERT INTO `districts` VALUES (201, 'Huacaschuque', '021004', 22, NULL, NULL);
INSERT INTO `districts` VALUES (202, 'Huandoval', '021005', 22, NULL, NULL);
INSERT INTO `districts` VALUES (203, 'Lacabamba', '021006', 22, NULL, NULL);
INSERT INTO `districts` VALUES (204, 'Llapo', '021007', 22, NULL, NULL);
INSERT INTO `districts` VALUES (205, 'Pallasca', '021008', 22, NULL, NULL);
INSERT INTO `districts` VALUES (206, 'Pampas', '021009', 22, NULL, NULL);
INSERT INTO `districts` VALUES (207, 'Santa Rosa', '021010', 22, NULL, NULL);
INSERT INTO `districts` VALUES (208, 'Tauca', '021011', 22, NULL, NULL);
INSERT INTO `districts` VALUES (209, 'Pomabamba', '021101', 23, NULL, NULL);
INSERT INTO `districts` VALUES (210, 'Huayllan', '021102', 23, NULL, NULL);
INSERT INTO `districts` VALUES (211, 'Parobamba', '021103', 23, NULL, NULL);
INSERT INTO `districts` VALUES (212, 'Quinuabamba', '021104', 23, NULL, NULL);
INSERT INTO `districts` VALUES (213, 'Recuay', '021201', 24, NULL, NULL);
INSERT INTO `districts` VALUES (214, 'Cotaparaco', '021202', 24, NULL, NULL);
INSERT INTO `districts` VALUES (215, 'Huayllapampa', '021203', 24, NULL, NULL);
INSERT INTO `districts` VALUES (216, 'Marca', '021204', 24, NULL, NULL);
INSERT INTO `districts` VALUES (217, 'Pampas Chico', '021205', 24, NULL, NULL);
INSERT INTO `districts` VALUES (218, 'Pararin', '021206', 24, NULL, NULL);
INSERT INTO `districts` VALUES (219, 'Tapacocha', '021207', 24, NULL, NULL);
INSERT INTO `districts` VALUES (220, 'Ticapampa', '021208', 24, NULL, NULL);
INSERT INTO `districts` VALUES (221, 'Llacllin', '021209', 24, NULL, NULL);
INSERT INTO `districts` VALUES (222, 'Catac', '021210', 24, NULL, NULL);
INSERT INTO `districts` VALUES (223, 'Chimbote', '021301', 25, NULL, NULL);
INSERT INTO `districts` VALUES (224, 'Caceres Del Peru', '021302', 25, NULL, NULL);
INSERT INTO `districts` VALUES (225, 'Macate', '021303', 25, NULL, NULL);
INSERT INTO `districts` VALUES (226, 'Moro', '021304', 25, NULL, NULL);
INSERT INTO `districts` VALUES (227, 'Nepeña', '021305', 25, NULL, NULL);
INSERT INTO `districts` VALUES (228, 'Samanco', '021306', 25, NULL, NULL);
INSERT INTO `districts` VALUES (229, 'Santa', '021307', 25, NULL, NULL);
INSERT INTO `districts` VALUES (230, 'Coishco', '021308', 25, NULL, NULL);
INSERT INTO `districts` VALUES (231, 'Nuevo Chimbote', '021309', 25, NULL, NULL);
INSERT INTO `districts` VALUES (232, 'Sihuas', '021401', 26, NULL, NULL);
INSERT INTO `districts` VALUES (233, 'Alfonso Ugarte', '021402', 26, NULL, NULL);
INSERT INTO `districts` VALUES (234, 'Chingalpo', '021403', 26, NULL, NULL);
INSERT INTO `districts` VALUES (235, 'Huayllabamba', '021404', 26, NULL, NULL);
INSERT INTO `districts` VALUES (236, 'Quiches', '021405', 26, NULL, NULL);
INSERT INTO `districts` VALUES (237, 'Sicsibamba', '021406', 26, NULL, NULL);
INSERT INTO `districts` VALUES (238, 'Acobamba', '021407', 26, NULL, NULL);
INSERT INTO `districts` VALUES (239, 'Cashapampa', '021408', 26, NULL, NULL);
INSERT INTO `districts` VALUES (240, 'Ragash', '021409', 26, NULL, NULL);
INSERT INTO `districts` VALUES (241, 'San Juan', '021410', 26, NULL, NULL);
INSERT INTO `districts` VALUES (242, 'Yungay', '021501', 27, NULL, NULL);
INSERT INTO `districts` VALUES (243, 'Cascapara', '021502', 27, NULL, NULL);
INSERT INTO `districts` VALUES (244, 'Mancos', '021503', 27, NULL, NULL);
INSERT INTO `districts` VALUES (245, 'Matacoto', '021504', 27, NULL, NULL);
INSERT INTO `districts` VALUES (246, 'Quillo', '021505', 27, NULL, NULL);
INSERT INTO `districts` VALUES (247, 'Ranrahirca', '021506', 27, NULL, NULL);
INSERT INTO `districts` VALUES (248, 'Shupluy', '021507', 27, NULL, NULL);
INSERT INTO `districts` VALUES (249, 'Yanama', '021508', 27, NULL, NULL);
INSERT INTO `districts` VALUES (250, 'Abancay', '030101', 28, NULL, NULL);
INSERT INTO `districts` VALUES (251, 'Circa', '030102', 28, NULL, NULL);
INSERT INTO `districts` VALUES (252, 'Curahuasi', '030103', 28, NULL, NULL);
INSERT INTO `districts` VALUES (253, 'Chacoche', '030104', 28, NULL, NULL);
INSERT INTO `districts` VALUES (254, 'Huanipaca', '030105', 28, NULL, NULL);
INSERT INTO `districts` VALUES (255, 'Lambrama', '030106', 28, NULL, NULL);
INSERT INTO `districts` VALUES (256, 'Pichirhua', '030107', 28, NULL, NULL);
INSERT INTO `districts` VALUES (257, 'San Pedro De Cachora', '030108', 28, NULL, NULL);
INSERT INTO `districts` VALUES (258, 'Tamburco', '030109', 28, NULL, NULL);
INSERT INTO `districts` VALUES (259, 'Andahuaylas', '030301', 29, NULL, NULL);
INSERT INTO `districts` VALUES (260, 'Andarapa', '030302', 29, NULL, NULL);
INSERT INTO `districts` VALUES (261, 'Chiara', '030303', 29, NULL, NULL);
INSERT INTO `districts` VALUES (262, 'Huancarama', '030304', 29, NULL, NULL);
INSERT INTO `districts` VALUES (263, 'Huancaray', '030305', 29, NULL, NULL);
INSERT INTO `districts` VALUES (264, 'Kishuara', '030306', 29, NULL, NULL);
INSERT INTO `districts` VALUES (265, 'Pacobamba', '030307', 29, NULL, NULL);
INSERT INTO `districts` VALUES (266, 'Pampachiri', '030308', 29, NULL, NULL);
INSERT INTO `districts` VALUES (267, 'San Antonio De Cachi', '030309', 29, NULL, NULL);
INSERT INTO `districts` VALUES (268, 'San Jeronimo', '030310', 29, NULL, NULL);
INSERT INTO `districts` VALUES (269, 'Talavera', '030311', 29, NULL, NULL);
INSERT INTO `districts` VALUES (270, 'Turpo', '030312', 29, NULL, NULL);
INSERT INTO `districts` VALUES (271, 'Pacucha', '030313', 29, NULL, NULL);
INSERT INTO `districts` VALUES (272, 'Pomacocha', '030314', 29, NULL, NULL);
INSERT INTO `districts` VALUES (273, 'Santa Maria De Chicmo', '030315', 29, NULL, NULL);
INSERT INTO `districts` VALUES (274, 'Tumay Huaraca', '030316', 29, NULL, NULL);
INSERT INTO `districts` VALUES (275, 'Huayana', '030317', 29, NULL, NULL);
INSERT INTO `districts` VALUES (276, 'San Miguel De Chaccrampa', '030318', 29, NULL, NULL);
INSERT INTO `districts` VALUES (277, 'Kaquiabamba', '030319', 29, NULL, NULL);
INSERT INTO `districts` VALUES (278, 'Antabamba', '030401', 30, NULL, NULL);
INSERT INTO `districts` VALUES (279, 'El Oro', '030402', 30, NULL, NULL);
INSERT INTO `districts` VALUES (280, 'Huaquirca', '030403', 30, NULL, NULL);
INSERT INTO `districts` VALUES (281, 'Juan Espinoza Medrano', '030404', 30, NULL, NULL);
INSERT INTO `districts` VALUES (282, 'Oropesa', '030405', 30, NULL, NULL);
INSERT INTO `districts` VALUES (283, 'Pachaconas', '030406', 30, NULL, NULL);
INSERT INTO `districts` VALUES (284, 'Sabaino', '030407', 30, NULL, NULL);
INSERT INTO `districts` VALUES (285, 'Chalhuanca', '030201', 31, NULL, NULL);
INSERT INTO `districts` VALUES (286, 'Capaya', '030202', 31, NULL, NULL);
INSERT INTO `districts` VALUES (287, 'Caraybamba', '030203', 31, NULL, NULL);
INSERT INTO `districts` VALUES (288, 'Colcabamba', '030204', 31, NULL, NULL);
INSERT INTO `districts` VALUES (289, 'Cotaruse', '030205', 31, NULL, NULL);
INSERT INTO `districts` VALUES (290, 'Chapimarca', '030206', 31, NULL, NULL);
INSERT INTO `districts` VALUES (291, 'Ihuayllo', '030207', 31, NULL, NULL);
INSERT INTO `districts` VALUES (292, 'Lucre', '030208', 31, NULL, NULL);
INSERT INTO `districts` VALUES (293, 'Pocohuanca', '030209', 31, NULL, NULL);
INSERT INTO `districts` VALUES (294, 'Sañayca', '030210', 31, NULL, NULL);
INSERT INTO `districts` VALUES (295, 'Soraya', '030211', 31, NULL, NULL);
INSERT INTO `districts` VALUES (296, 'Tapairihua', '030212', 31, NULL, NULL);
INSERT INTO `districts` VALUES (297, 'Tintay', '030213', 31, NULL, NULL);
INSERT INTO `districts` VALUES (298, 'Toraya', '030214', 31, NULL, NULL);
INSERT INTO `districts` VALUES (299, 'Yanaca', '030215', 31, NULL, NULL);
INSERT INTO `districts` VALUES (300, 'San Juan De Chacña', '030216', 31, NULL, NULL);
INSERT INTO `districts` VALUES (301, 'Justo Apu Sahuaraura', '030217', 31, NULL, NULL);
INSERT INTO `districts` VALUES (302, 'Chincheros', '030701', 32, NULL, NULL);
INSERT INTO `districts` VALUES (303, 'Ongoy', '030702', 32, NULL, NULL);
INSERT INTO `districts` VALUES (304, 'Ocobamba', '030703', 32, NULL, NULL);
INSERT INTO `districts` VALUES (305, 'Cocharcas', '030704', 32, NULL, NULL);
INSERT INTO `districts` VALUES (306, 'Anco Huallo', '030705', 32, NULL, NULL);
INSERT INTO `districts` VALUES (307, 'Huaccana', '030706', 32, NULL, NULL);
INSERT INTO `districts` VALUES (308, 'Uranmarca', '030707', 32, NULL, NULL);
INSERT INTO `districts` VALUES (309, 'Ranracancha', '030708', 32, NULL, NULL);
INSERT INTO `districts` VALUES (310, 'Tambobamba', '030501', 33, NULL, NULL);
INSERT INTO `districts` VALUES (311, 'Coyllurqui', '030502', 33, NULL, NULL);
INSERT INTO `districts` VALUES (312, 'Cotabambas', '030503', 33, NULL, NULL);
INSERT INTO `districts` VALUES (313, 'Haquira', '030504', 33, NULL, NULL);
INSERT INTO `districts` VALUES (314, 'Mara', '030505', 33, NULL, NULL);
INSERT INTO `districts` VALUES (315, 'Challhuahuacho', '030506', 33, NULL, NULL);
INSERT INTO `districts` VALUES (316, 'Chuquibambilla', '030601', 34, NULL, NULL);
INSERT INTO `districts` VALUES (317, 'Curpahuasi', '030602', 34, NULL, NULL);
INSERT INTO `districts` VALUES (318, 'Huayllati', '030603', 34, NULL, NULL);
INSERT INTO `districts` VALUES (319, 'Mamara', '030604', 34, NULL, NULL);
INSERT INTO `districts` VALUES (320, 'Mariscal Gamarra', '030605', 34, NULL, NULL);
INSERT INTO `districts` VALUES (321, 'Micaela Bastidas', '030606', 34, NULL, NULL);
INSERT INTO `districts` VALUES (322, 'Progreso', '030607', 34, NULL, NULL);
INSERT INTO `districts` VALUES (323, 'Pataypampa', '030608', 34, NULL, NULL);
INSERT INTO `districts` VALUES (324, 'San Antonio', '030609', 34, NULL, NULL);
INSERT INTO `districts` VALUES (325, 'Turpay', '030610', 34, NULL, NULL);
INSERT INTO `districts` VALUES (326, 'Vilcabamba', '030611', 34, NULL, NULL);
INSERT INTO `districts` VALUES (327, 'Virundo', '030612', 34, NULL, NULL);
INSERT INTO `districts` VALUES (328, 'Santa Rosa', '030613', 34, NULL, NULL);
INSERT INTO `districts` VALUES (329, 'Curasco', '030614', 34, NULL, NULL);
INSERT INTO `districts` VALUES (330, 'Arequipa', '040101', 35, NULL, NULL);
INSERT INTO `districts` VALUES (331, 'Cayma', '040102', 35, NULL, NULL);
INSERT INTO `districts` VALUES (332, 'Cerro Colorado', '040103', 35, NULL, NULL);
INSERT INTO `districts` VALUES (333, 'Characato', '040104', 35, NULL, NULL);
INSERT INTO `districts` VALUES (334, 'Chiguata', '040105', 35, NULL, NULL);
INSERT INTO `districts` VALUES (335, 'La Joya', '040106', 35, NULL, NULL);
INSERT INTO `districts` VALUES (336, 'Miraflores', '040107', 35, NULL, NULL);
INSERT INTO `districts` VALUES (337, 'Mollebaya', '040108', 35, NULL, NULL);
INSERT INTO `districts` VALUES (338, 'Paucarpata', '040109', 35, NULL, NULL);
INSERT INTO `districts` VALUES (339, 'Pocsi', '040110', 35, NULL, NULL);
INSERT INTO `districts` VALUES (340, 'Polobaya', '040111', 35, NULL, NULL);
INSERT INTO `districts` VALUES (341, 'Quequeña', '040112', 35, NULL, NULL);
INSERT INTO `districts` VALUES (342, 'Sabandia', '040113', 35, NULL, NULL);
INSERT INTO `districts` VALUES (343, 'Sachaca', '040114', 35, NULL, NULL);
INSERT INTO `districts` VALUES (344, 'San Juan De Siguas', '040115', 35, NULL, NULL);
INSERT INTO `districts` VALUES (345, 'San Juan De Tarucani', '040116', 35, NULL, NULL);
INSERT INTO `districts` VALUES (346, 'Santa Isabel De Siguas', '040117', 35, NULL, NULL);
INSERT INTO `districts` VALUES (347, 'Santa Rita De Sihuas', '040118', 35, NULL, NULL);
INSERT INTO `districts` VALUES (348, 'Socabaya', '040119', 35, NULL, NULL);
INSERT INTO `districts` VALUES (349, 'Tiabaya', '040120', 35, NULL, NULL);
INSERT INTO `districts` VALUES (350, 'Uchumayo', '040121', 35, NULL, NULL);
INSERT INTO `districts` VALUES (351, 'Vitor', '040122', 35, NULL, NULL);
INSERT INTO `districts` VALUES (352, 'Yanahuara', '040123', 35, NULL, NULL);
INSERT INTO `districts` VALUES (353, 'Yarabamba', '040124', 35, NULL, NULL);
INSERT INTO `districts` VALUES (354, 'Yura', '040125', 35, NULL, NULL);
INSERT INTO `districts` VALUES (355, 'Mariano Melgar', '040126', 35, NULL, NULL);
INSERT INTO `districts` VALUES (356, 'Jacobo Hunter', '040127', 35, NULL, NULL);
INSERT INTO `districts` VALUES (357, 'Alto Selva Alegre', '040128', 35, NULL, NULL);
INSERT INTO `districts` VALUES (358, 'Jose Luis Bustamante Y Rivero', '040129', 35, NULL, NULL);
INSERT INTO `districts` VALUES (359, 'Camana', '040301', 36, NULL, NULL);
INSERT INTO `districts` VALUES (360, 'Jose Maria Quimper', '040302', 36, NULL, NULL);
INSERT INTO `districts` VALUES (361, 'Mariano Nicolas Valcarcel', '040303', 36, NULL, NULL);
INSERT INTO `districts` VALUES (362, 'Mariscal Caceres', '040304', 36, NULL, NULL);
INSERT INTO `districts` VALUES (363, 'Nicolas De Pierola', '040305', 36, NULL, NULL);
INSERT INTO `districts` VALUES (364, 'Ocoña', '040306', 36, NULL, NULL);
INSERT INTO `districts` VALUES (365, 'Quilca', '040307', 36, NULL, NULL);
INSERT INTO `districts` VALUES (366, 'Samuel Pastor', '040308', 36, NULL, NULL);
INSERT INTO `districts` VALUES (367, 'Caraveli', '040401', 37, NULL, NULL);
INSERT INTO `districts` VALUES (368, 'Acari', '040402', 37, NULL, NULL);
INSERT INTO `districts` VALUES (369, 'Atico', '040403', 37, NULL, NULL);
INSERT INTO `districts` VALUES (370, 'Atiquipa', '040404', 37, NULL, NULL);
INSERT INTO `districts` VALUES (371, 'Bella Union', '040405', 37, NULL, NULL);
INSERT INTO `districts` VALUES (372, 'Cahuacho', '040406', 37, NULL, NULL);
INSERT INTO `districts` VALUES (373, 'Chala', '040407', 37, NULL, NULL);
INSERT INTO `districts` VALUES (374, 'Chaparra', '040408', 37, NULL, NULL);
INSERT INTO `districts` VALUES (375, 'Huanuhuanu', '040409', 37, NULL, NULL);
INSERT INTO `districts` VALUES (376, 'Jaqui', '040410', 37, NULL, NULL);
INSERT INTO `districts` VALUES (377, 'Lomas', '040411', 37, NULL, NULL);
INSERT INTO `districts` VALUES (378, 'Quicacha', '040412', 37, NULL, NULL);
INSERT INTO `districts` VALUES (379, 'Yauca', '040413', 37, NULL, NULL);
INSERT INTO `districts` VALUES (380, 'Aplao', '040501', 38, NULL, NULL);
INSERT INTO `districts` VALUES (381, 'Andagua', '040502', 38, NULL, NULL);
INSERT INTO `districts` VALUES (382, 'Ayo', '040503', 38, NULL, NULL);
INSERT INTO `districts` VALUES (383, 'Chachas', '040504', 38, NULL, NULL);
INSERT INTO `districts` VALUES (384, 'Chilcaymarca', '040505', 38, NULL, NULL);
INSERT INTO `districts` VALUES (385, 'Choco', '040506', 38, NULL, NULL);
INSERT INTO `districts` VALUES (386, 'Huancarqui', '040507', 38, NULL, NULL);
INSERT INTO `districts` VALUES (387, 'Machaguay', '040508', 38, NULL, NULL);
INSERT INTO `districts` VALUES (388, 'Orcopampa', '040509', 38, NULL, NULL);
INSERT INTO `districts` VALUES (389, 'Pampacolca', '040510', 38, NULL, NULL);
INSERT INTO `districts` VALUES (390, 'Tipan', '040511', 38, NULL, NULL);
INSERT INTO `districts` VALUES (391, 'Uraca', '040512', 38, NULL, NULL);
INSERT INTO `districts` VALUES (392, 'Uñon', '040513', 38, NULL, NULL);
INSERT INTO `districts` VALUES (393, 'Viraco', '040514', 38, NULL, NULL);
INSERT INTO `districts` VALUES (394, 'Chivay', '040201', 39, NULL, NULL);
INSERT INTO `districts` VALUES (395, 'Achoma', '040202', 39, NULL, NULL);
INSERT INTO `districts` VALUES (396, 'Cabanaconde', '040203', 39, NULL, NULL);
INSERT INTO `districts` VALUES (397, 'Caylloma', '040204', 39, NULL, NULL);
INSERT INTO `districts` VALUES (398, 'Callalli', '040205', 39, NULL, NULL);
INSERT INTO `districts` VALUES (399, 'Coporaque', '040206', 39, NULL, NULL);
INSERT INTO `districts` VALUES (400, 'Huambo', '040207', 39, NULL, NULL);
INSERT INTO `districts` VALUES (401, 'Huanca', '040208', 39, NULL, NULL);
INSERT INTO `districts` VALUES (402, 'Ichupampa', '040209', 39, NULL, NULL);
INSERT INTO `districts` VALUES (403, 'Lari', '040210', 39, NULL, NULL);
INSERT INTO `districts` VALUES (404, 'Lluta', '040211', 39, NULL, NULL);
INSERT INTO `districts` VALUES (405, 'Maca', '040212', 39, NULL, NULL);
INSERT INTO `districts` VALUES (406, 'Madrigal', '040213', 39, NULL, NULL);
INSERT INTO `districts` VALUES (407, 'San Antonio De Chuca', '040214', 39, NULL, NULL);
INSERT INTO `districts` VALUES (408, 'Sibayo', '040215', 39, NULL, NULL);
INSERT INTO `districts` VALUES (409, 'Tapay', '040216', 39, NULL, NULL);
INSERT INTO `districts` VALUES (410, 'Tisco', '040217', 39, NULL, NULL);
INSERT INTO `districts` VALUES (411, 'Tuti', '040218', 39, NULL, NULL);
INSERT INTO `districts` VALUES (412, 'Yanque', '040219', 39, NULL, NULL);
INSERT INTO `districts` VALUES (413, 'Majes', '040220', 39, NULL, NULL);
INSERT INTO `districts` VALUES (414, 'Chuquibamba', '040601', 40, NULL, NULL);
INSERT INTO `districts` VALUES (415, 'Andaray', '040602', 40, NULL, NULL);
INSERT INTO `districts` VALUES (416, 'Cayarani', '040603', 40, NULL, NULL);
INSERT INTO `districts` VALUES (417, 'Chichas', '040604', 40, NULL, NULL);
INSERT INTO `districts` VALUES (418, 'Iray', '040605', 40, NULL, NULL);
INSERT INTO `districts` VALUES (419, 'Salamanca', '040606', 40, NULL, NULL);
INSERT INTO `districts` VALUES (420, 'Yanaquihua', '040607', 40, NULL, NULL);
INSERT INTO `districts` VALUES (421, 'Rio Grande', '040608', 40, NULL, NULL);
INSERT INTO `districts` VALUES (422, 'Mollendo', '040701', 41, NULL, NULL);
INSERT INTO `districts` VALUES (423, 'Cocachacra', '040702', 41, NULL, NULL);
INSERT INTO `districts` VALUES (424, 'Dean Valdivia', '040703', 41, NULL, NULL);
INSERT INTO `districts` VALUES (425, 'Islay', '040704', 41, NULL, NULL);
INSERT INTO `districts` VALUES (426, 'Mejia', '040705', 41, NULL, NULL);
INSERT INTO `districts` VALUES (427, 'Punta De Bombon', '040706', 41, NULL, NULL);
INSERT INTO `districts` VALUES (428, 'Cotahuasi', '040801', 42, NULL, NULL);
INSERT INTO `districts` VALUES (429, 'Alca', '040802', 42, NULL, NULL);
INSERT INTO `districts` VALUES (430, 'Charcana', '040803', 42, NULL, NULL);
INSERT INTO `districts` VALUES (431, 'Huaynacotas', '040804', 42, NULL, NULL);
INSERT INTO `districts` VALUES (432, 'Pampamarca', '040805', 42, NULL, NULL);
INSERT INTO `districts` VALUES (433, 'Puyca', '040806', 42, NULL, NULL);
INSERT INTO `districts` VALUES (434, 'Quechualla', '040807', 42, NULL, NULL);
INSERT INTO `districts` VALUES (435, 'Sayla', '040808', 42, NULL, NULL);
INSERT INTO `districts` VALUES (436, 'Tauria', '040809', 42, NULL, NULL);
INSERT INTO `districts` VALUES (437, 'Tomepampa', '040810', 42, NULL, NULL);
INSERT INTO `districts` VALUES (438, 'Toro', '040811', 42, NULL, NULL);
INSERT INTO `districts` VALUES (439, 'Cangallo', '050201', 43, NULL, NULL);
INSERT INTO `districts` VALUES (440, 'Chuschi', '050204', 43, NULL, NULL);
INSERT INTO `districts` VALUES (441, 'Los Morochucos', '050206', 43, NULL, NULL);
INSERT INTO `districts` VALUES (442, 'Paras', '050207', 43, NULL, NULL);
INSERT INTO `districts` VALUES (443, 'Totos', '050208', 43, NULL, NULL);
INSERT INTO `districts` VALUES (444, 'Maria Parado De Bellido', '050211', 43, NULL, NULL);
INSERT INTO `districts` VALUES (445, 'Ayacucho', '050101', 44, NULL, NULL);
INSERT INTO `districts` VALUES (446, 'Acos Vinchos', '050102', 44, NULL, NULL);
INSERT INTO `districts` VALUES (447, 'Carmen Alto', '050103', 44, NULL, NULL);
INSERT INTO `districts` VALUES (448, 'Chiara', '050104', 44, NULL, NULL);
INSERT INTO `districts` VALUES (449, 'Quinua', '050105', 44, NULL, NULL);
INSERT INTO `districts` VALUES (450, 'San Jose De Ticllas', '050106', 44, NULL, NULL);
INSERT INTO `districts` VALUES (451, 'San Juan Bautista', '050107', 44, NULL, NULL);
INSERT INTO `districts` VALUES (452, 'Santiago De Pischa', '050108', 44, NULL, NULL);
INSERT INTO `districts` VALUES (453, 'Vinchos', '050109', 44, NULL, NULL);
INSERT INTO `districts` VALUES (454, 'Tambillo', '050110', 44, NULL, NULL);
INSERT INTO `districts` VALUES (455, 'Acocro', '050111', 44, NULL, NULL);
INSERT INTO `districts` VALUES (456, 'Socos', '050112', 44, NULL, NULL);
INSERT INTO `districts` VALUES (457, 'Ocros', '050113', 44, NULL, NULL);
INSERT INTO `districts` VALUES (458, 'Pacaycasa', '050114', 44, NULL, NULL);
INSERT INTO `districts` VALUES (459, 'Jesus Nazareno', '050115', 44, NULL, NULL);
INSERT INTO `districts` VALUES (460, 'Sancos', '050801', 45, NULL, NULL);
INSERT INTO `districts` VALUES (461, 'Sacsamarca', '050802', 45, NULL, NULL);
INSERT INTO `districts` VALUES (462, 'Santiago De Lucanamarca', '050803', 45, NULL, NULL);
INSERT INTO `districts` VALUES (463, 'Carapo', '050804', 45, NULL, NULL);
INSERT INTO `districts` VALUES (464, 'Huanta', '050301', 46, NULL, NULL);
INSERT INTO `districts` VALUES (465, 'Ayahuanco', '050302', 46, NULL, NULL);
INSERT INTO `districts` VALUES (466, 'Huamanguilla', '050303', 46, NULL, NULL);
INSERT INTO `districts` VALUES (467, 'Iguain', '050304', 46, NULL, NULL);
INSERT INTO `districts` VALUES (468, 'Luricocha', '050305', 46, NULL, NULL);
INSERT INTO `districts` VALUES (469, 'Santillana', '050307', 46, NULL, NULL);
INSERT INTO `districts` VALUES (470, 'Sivia', '050308', 46, NULL, NULL);
INSERT INTO `districts` VALUES (471, 'Llochegua', '050309', 46, NULL, NULL);
INSERT INTO `districts` VALUES (472, 'San Miguel', '050401', 47, NULL, NULL);
INSERT INTO `districts` VALUES (473, 'Anco', '050402', 47, NULL, NULL);
INSERT INTO `districts` VALUES (474, 'Ayna', '050403', 47, NULL, NULL);
INSERT INTO `districts` VALUES (475, 'Chilcas', '050404', 47, NULL, NULL);
INSERT INTO `districts` VALUES (476, 'Chungui', '050405', 47, NULL, NULL);
INSERT INTO `districts` VALUES (477, 'Tambo', '050406', 47, NULL, NULL);
INSERT INTO `districts` VALUES (478, 'Luis Carranza', '050407', 47, NULL, NULL);
INSERT INTO `districts` VALUES (479, 'Santa Rosa', '050408', 47, NULL, NULL);
INSERT INTO `districts` VALUES (480, 'Puquio', '050501', 48, NULL, NULL);
INSERT INTO `districts` VALUES (481, 'Aucara', '050502', 48, NULL, NULL);
INSERT INTO `districts` VALUES (482, 'Cabana', '050503', 48, NULL, NULL);
INSERT INTO `districts` VALUES (483, 'Carmen Salcedo', '050504', 48, NULL, NULL);
INSERT INTO `districts` VALUES (484, 'Chaviña', '050506', 48, NULL, NULL);
INSERT INTO `districts` VALUES (485, 'Chipao', '050508', 48, NULL, NULL);
INSERT INTO `districts` VALUES (486, 'Huac-huas', '050510', 48, NULL, NULL);
INSERT INTO `districts` VALUES (487, 'Laramate', '050511', 48, NULL, NULL);
INSERT INTO `districts` VALUES (488, 'Leoncio Prado', '050512', 48, NULL, NULL);
INSERT INTO `districts` VALUES (489, 'Lucanas', '050513', 48, NULL, NULL);
INSERT INTO `districts` VALUES (490, 'Llauta', '050514', 48, NULL, NULL);
INSERT INTO `districts` VALUES (491, 'Ocaña', '050516', 48, NULL, NULL);
INSERT INTO `districts` VALUES (492, 'Otoca', '050517', 48, NULL, NULL);
INSERT INTO `districts` VALUES (493, 'Sancos', '050520', 48, NULL, NULL);
INSERT INTO `districts` VALUES (494, 'San Juan', '050521', 48, NULL, NULL);
INSERT INTO `districts` VALUES (495, 'San Pedro', '050522', 48, NULL, NULL);
INSERT INTO `districts` VALUES (496, 'Santa Ana De Huaycahuacho', '050524', 48, NULL, NULL);
INSERT INTO `districts` VALUES (497, 'Santa Lucia', '050525', 48, NULL, NULL);
INSERT INTO `districts` VALUES (498, 'Saisa', '050529', 48, NULL, NULL);
INSERT INTO `districts` VALUES (499, 'San Pedro De Palco', '050531', 48, NULL, NULL);
INSERT INTO `districts` VALUES (500, 'San Cristobal', '050532', 48, NULL, NULL);
INSERT INTO `districts` VALUES (501, 'Coracora', '050601', 49, NULL, NULL);
INSERT INTO `districts` VALUES (502, 'Coronel Castañeda', '050604', 49, NULL, NULL);
INSERT INTO `districts` VALUES (503, 'Chumpi', '050605', 49, NULL, NULL);
INSERT INTO `districts` VALUES (504, 'Pacapausa', '050608', 49, NULL, NULL);
INSERT INTO `districts` VALUES (505, 'Pullo', '050611', 49, NULL, NULL);
INSERT INTO `districts` VALUES (506, 'Puyusca', '050612', 49, NULL, NULL);
INSERT INTO `districts` VALUES (507, 'San Francisco De Ravacayco', '050615', 49, NULL, NULL);
INSERT INTO `districts` VALUES (508, 'Upahuacho', '050616', 49, NULL, NULL);
INSERT INTO `districts` VALUES (509, 'Pausa', '051001', 50, NULL, NULL);
INSERT INTO `districts` VALUES (510, 'Colta', '051002', 50, NULL, NULL);
INSERT INTO `districts` VALUES (511, 'Corculla', '051003', 50, NULL, NULL);
INSERT INTO `districts` VALUES (512, 'Lampa', '051004', 50, NULL, NULL);
INSERT INTO `districts` VALUES (513, 'Marcabamba', '051005', 50, NULL, NULL);
INSERT INTO `districts` VALUES (514, 'Oyolo', '051006', 50, NULL, NULL);
INSERT INTO `districts` VALUES (515, 'Pararca', '051007', 50, NULL, NULL);
INSERT INTO `districts` VALUES (516, 'San Javier De Alpabamba', '051008', 50, NULL, NULL);
INSERT INTO `districts` VALUES (517, 'San Jose De Ushua', '051009', 50, NULL, NULL);
INSERT INTO `districts` VALUES (518, 'Sara Sara', '051010', 50, NULL, NULL);
INSERT INTO `districts` VALUES (519, 'Querobamba', '051101', 51, NULL, NULL);
INSERT INTO `districts` VALUES (520, 'Belen', '051102', 51, NULL, NULL);
INSERT INTO `districts` VALUES (521, 'Chalcos', '051103', 51, NULL, NULL);
INSERT INTO `districts` VALUES (522, 'San Salvador De Quije', '051104', 51, NULL, NULL);
INSERT INTO `districts` VALUES (523, 'Paico', '051105', 51, NULL, NULL);
INSERT INTO `districts` VALUES (524, 'Santiago De Paucaray', '051106', 51, NULL, NULL);
INSERT INTO `districts` VALUES (525, 'San Pedro De Larcay', '051107', 51, NULL, NULL);
INSERT INTO `districts` VALUES (526, 'Soras', '051108', 51, NULL, NULL);
INSERT INTO `districts` VALUES (527, 'Huacaña', '051109', 51, NULL, NULL);
INSERT INTO `districts` VALUES (528, 'Chilcayoc', '051110', 51, NULL, NULL);
INSERT INTO `districts` VALUES (529, 'Morcolla', '051111', 51, NULL, NULL);
INSERT INTO `districts` VALUES (530, 'Huancapi', '050701', 52, NULL, NULL);
INSERT INTO `districts` VALUES (531, 'Alcamenca', '050702', 52, NULL, NULL);
INSERT INTO `districts` VALUES (532, 'Apongo', '050703', 52, NULL, NULL);
INSERT INTO `districts` VALUES (533, 'Canaria', '050704', 52, NULL, NULL);
INSERT INTO `districts` VALUES (534, 'Cayara', '050706', 52, NULL, NULL);
INSERT INTO `districts` VALUES (535, 'Colca', '050707', 52, NULL, NULL);
INSERT INTO `districts` VALUES (536, 'Huaya', '050708', 52, NULL, NULL);
INSERT INTO `districts` VALUES (537, 'Huamanquiquia', '050709', 52, NULL, NULL);
INSERT INTO `districts` VALUES (538, 'Huancaraylla', '050710', 52, NULL, NULL);
INSERT INTO `districts` VALUES (539, 'Sarhua', '050713', 52, NULL, NULL);
INSERT INTO `districts` VALUES (540, 'Vilcanchos', '050714', 52, NULL, NULL);
INSERT INTO `districts` VALUES (541, 'Asquipata', '050715', 52, NULL, NULL);
INSERT INTO `districts` VALUES (542, 'Vilcas Huaman', '050901', 53, NULL, NULL);
INSERT INTO `districts` VALUES (543, 'Vischongo', '050902', 53, NULL, NULL);
INSERT INTO `districts` VALUES (544, 'Accomarca', '050903', 53, NULL, NULL);
INSERT INTO `districts` VALUES (545, 'Carhuanca', '050904', 53, NULL, NULL);
INSERT INTO `districts` VALUES (546, 'Concepcion', '050905', 53, NULL, NULL);
INSERT INTO `districts` VALUES (547, 'Huambalpa', '050906', 53, NULL, NULL);
INSERT INTO `districts` VALUES (548, 'Saurama', '050907', 53, NULL, NULL);
INSERT INTO `districts` VALUES (549, 'Independencia', '050908', 53, NULL, NULL);
INSERT INTO `districts` VALUES (550, 'Cajabamba', '060201', 54, NULL, NULL);
INSERT INTO `districts` VALUES (551, 'Cachachi', '060202', 54, NULL, NULL);
INSERT INTO `districts` VALUES (552, 'Condebamba', '060203', 54, NULL, NULL);
INSERT INTO `districts` VALUES (553, 'Sitacocha', '060205', 54, NULL, NULL);
INSERT INTO `districts` VALUES (554, 'Cajamarca', '060101', 55, NULL, NULL);
INSERT INTO `districts` VALUES (555, 'Asuncion', '060102', 55, NULL, NULL);
INSERT INTO `districts` VALUES (556, 'Cospan', '060103', 55, NULL, NULL);
INSERT INTO `districts` VALUES (557, 'Chetilla', '060104', 55, NULL, NULL);
INSERT INTO `districts` VALUES (558, 'Encañada', '060105', 55, NULL, NULL);
INSERT INTO `districts` VALUES (559, 'Jesus', '060106', 55, NULL, NULL);
INSERT INTO `districts` VALUES (560, 'Los Baños Del Inca', '060107', 55, NULL, NULL);
INSERT INTO `districts` VALUES (561, 'Llacanora', '060108', 55, NULL, NULL);
INSERT INTO `districts` VALUES (562, 'Magdalena', '060109', 55, NULL, NULL);
INSERT INTO `districts` VALUES (563, 'Matara', '060110', 55, NULL, NULL);
INSERT INTO `districts` VALUES (564, 'Namora', '060111', 55, NULL, NULL);
INSERT INTO `districts` VALUES (565, 'San Juan', '060112', 55, NULL, NULL);
INSERT INTO `districts` VALUES (566, 'Celendin', '060301', 56, NULL, NULL);
INSERT INTO `districts` VALUES (567, 'Cortegana', '060302', 56, NULL, NULL);
INSERT INTO `districts` VALUES (568, 'Chumuch', '060303', 56, NULL, NULL);
INSERT INTO `districts` VALUES (569, 'Huasmin', '060304', 56, NULL, NULL);
INSERT INTO `districts` VALUES (570, 'Jorge Chavez', '060305', 56, NULL, NULL);
INSERT INTO `districts` VALUES (571, 'Jose Galvez', '060306', 56, NULL, NULL);
INSERT INTO `districts` VALUES (572, 'Miguel Iglesias', '060307', 56, NULL, NULL);
INSERT INTO `districts` VALUES (573, 'Oxamarca', '060308', 56, NULL, NULL);
INSERT INTO `districts` VALUES (574, 'Sorochuco', '060309', 56, NULL, NULL);
INSERT INTO `districts` VALUES (575, 'Sucre', '060310', 56, NULL, NULL);
INSERT INTO `districts` VALUES (576, 'Utco', '060311', 56, NULL, NULL);
INSERT INTO `districts` VALUES (577, 'La Libertad De Pallan', '060312', 56, NULL, NULL);
INSERT INTO `districts` VALUES (578, 'Chota', '060601', 57, NULL, NULL);
INSERT INTO `districts` VALUES (579, 'Anguia', '060602', 57, NULL, NULL);
INSERT INTO `districts` VALUES (580, 'Cochabamba', '060603', 57, NULL, NULL);
INSERT INTO `districts` VALUES (581, 'Conchan', '060604', 57, NULL, NULL);
INSERT INTO `districts` VALUES (582, 'Chadin', '060605', 57, NULL, NULL);
INSERT INTO `districts` VALUES (583, 'Chiguirip', '060606', 57, NULL, NULL);
INSERT INTO `districts` VALUES (584, 'Chimban', '060607', 57, NULL, NULL);
INSERT INTO `districts` VALUES (585, 'Huambos', '060608', 57, NULL, NULL);
INSERT INTO `districts` VALUES (586, 'Lajas', '060609', 57, NULL, NULL);
INSERT INTO `districts` VALUES (587, 'Llama', '060610', 57, NULL, NULL);
INSERT INTO `districts` VALUES (588, 'Miracosta', '060611', 57, NULL, NULL);
INSERT INTO `districts` VALUES (589, 'Paccha', '060612', 57, NULL, NULL);
INSERT INTO `districts` VALUES (590, 'Pion', '060613', 57, NULL, NULL);
INSERT INTO `districts` VALUES (591, 'Querocoto', '060614', 57, NULL, NULL);
INSERT INTO `districts` VALUES (592, 'Tacabamba', '060615', 57, NULL, NULL);
INSERT INTO `districts` VALUES (593, 'Tocmoche', '060616', 57, NULL, NULL);
INSERT INTO `districts` VALUES (594, 'San Juan De Licupis', '060617', 57, NULL, NULL);
INSERT INTO `districts` VALUES (595, 'Choropampa', '060618', 57, NULL, NULL);
INSERT INTO `districts` VALUES (596, 'Chalamarca', '060619', 57, NULL, NULL);
INSERT INTO `districts` VALUES (597, 'Contumaza', '060401', 58, NULL, NULL);
INSERT INTO `districts` VALUES (598, 'Chilete', '060403', 58, NULL, NULL);
INSERT INTO `districts` VALUES (599, 'Guzmango', '060404', 58, NULL, NULL);
INSERT INTO `districts` VALUES (600, 'San Benito', '060405', 58, NULL, NULL);
INSERT INTO `districts` VALUES (601, 'Cupisnique', '060406', 58, NULL, NULL);
INSERT INTO `districts` VALUES (602, 'Tantarica', '060407', 58, NULL, NULL);
INSERT INTO `districts` VALUES (603, 'Yonan', '060408', 58, NULL, NULL);
INSERT INTO `districts` VALUES (604, 'Santa Cruz De Toled', '060409', 58, NULL, NULL);
INSERT INTO `districts` VALUES (605, 'Cutervo', '060501', 59, NULL, NULL);
INSERT INTO `districts` VALUES (606, 'Callayuc', '060502', 59, NULL, NULL);
INSERT INTO `districts` VALUES (607, 'Cujillo', '060503', 59, NULL, NULL);
INSERT INTO `districts` VALUES (608, 'Choros', '060504', 59, NULL, NULL);
INSERT INTO `districts` VALUES (609, 'La Ramada', '060505', 59, NULL, NULL);
INSERT INTO `districts` VALUES (610, 'Pimpingos', '060506', 59, NULL, NULL);
INSERT INTO `districts` VALUES (611, 'Querocotillo', '060507', 59, NULL, NULL);
INSERT INTO `districts` VALUES (612, 'San Andres De Cutervo', '060508', 59, NULL, NULL);
INSERT INTO `districts` VALUES (613, 'San Juan De Cutervo', '060509', 59, NULL, NULL);
INSERT INTO `districts` VALUES (614, 'San Luis De Lucma', '060510', 59, NULL, NULL);
INSERT INTO `districts` VALUES (615, 'Santa Cruz', '060511', 59, NULL, NULL);
INSERT INTO `districts` VALUES (616, 'Santo Domingo De La Capilla', '060512', 59, NULL, NULL);
INSERT INTO `districts` VALUES (617, 'Santo Tomas', '060513', 59, NULL, NULL);
INSERT INTO `districts` VALUES (618, 'Socota', '060514', 59, NULL, NULL);
INSERT INTO `districts` VALUES (619, 'Toribio Casanova', '060515', 59, NULL, NULL);
INSERT INTO `districts` VALUES (620, 'Bambamarca', '060701', 60, NULL, NULL);
INSERT INTO `districts` VALUES (621, 'Chugur', '060702', 60, NULL, NULL);
INSERT INTO `districts` VALUES (622, 'Hualgayoc', '060703', 60, NULL, NULL);
INSERT INTO `districts` VALUES (623, 'Jaen', '060801', 61, NULL, NULL);
INSERT INTO `districts` VALUES (624, 'Bellavista', '060802', 61, NULL, NULL);
INSERT INTO `districts` VALUES (625, 'Colasay', '060803', 61, NULL, NULL);
INSERT INTO `districts` VALUES (626, 'Chontali', '060804', 61, NULL, NULL);
INSERT INTO `districts` VALUES (627, 'Pomahuaca', '060805', 61, NULL, NULL);
INSERT INTO `districts` VALUES (628, 'Pucara', '060806', 61, NULL, NULL);
INSERT INTO `districts` VALUES (629, 'Sallique', '060807', 61, NULL, NULL);
INSERT INTO `districts` VALUES (630, 'San Felipe', '060808', 61, NULL, NULL);
INSERT INTO `districts` VALUES (631, 'San Jose Del Alto', '060809', 61, NULL, NULL);
INSERT INTO `districts` VALUES (632, 'Santa Rosa', '060810', 61, NULL, NULL);
INSERT INTO `districts` VALUES (633, 'Las Pirias', '060811', 61, NULL, NULL);
INSERT INTO `districts` VALUES (634, 'Huabal', '060812', 61, NULL, NULL);
INSERT INTO `districts` VALUES (635, 'San Ignacio', '061101', 62, NULL, NULL);
INSERT INTO `districts` VALUES (636, 'Chirinos', '061102', 62, NULL, NULL);
INSERT INTO `districts` VALUES (637, 'Huarango', '061103', 62, NULL, NULL);
INSERT INTO `districts` VALUES (638, 'Namballe', '061104', 62, NULL, NULL);
INSERT INTO `districts` VALUES (639, 'La Coipa', '061105', 62, NULL, NULL);
INSERT INTO `districts` VALUES (640, 'San Jose De Lourdes', '061106', 62, NULL, NULL);
INSERT INTO `districts` VALUES (641, 'Tabaconas', '061107', 62, NULL, NULL);
INSERT INTO `districts` VALUES (642, 'Pedro Galvez', '061201', 63, NULL, NULL);
INSERT INTO `districts` VALUES (643, 'Ichocan', '061202', 63, NULL, NULL);
INSERT INTO `districts` VALUES (644, 'Gregorio Pita', '061203', 63, NULL, NULL);
INSERT INTO `districts` VALUES (645, 'Jose Manuel Quiroz', '061204', 63, NULL, NULL);
INSERT INTO `districts` VALUES (646, 'Eduardo Villanueva', '061205', 63, NULL, NULL);
INSERT INTO `districts` VALUES (647, 'Jose Sabogal', '061206', 63, NULL, NULL);
INSERT INTO `districts` VALUES (648, 'Chancay', '061207', 63, NULL, NULL);
INSERT INTO `districts` VALUES (649, 'San Miguel', '061001', 64, NULL, NULL);
INSERT INTO `districts` VALUES (650, 'Calquis', '061002', 64, NULL, NULL);
INSERT INTO `districts` VALUES (651, 'La Florida', '061003', 64, NULL, NULL);
INSERT INTO `districts` VALUES (652, 'Llapa', '061004', 64, NULL, NULL);
INSERT INTO `districts` VALUES (653, 'Nanchoc', '061005', 64, NULL, NULL);
INSERT INTO `districts` VALUES (654, 'Niepos', '061006', 64, NULL, NULL);
INSERT INTO `districts` VALUES (655, 'San Gregorio', '061007', 64, NULL, NULL);
INSERT INTO `districts` VALUES (656, 'San Silvestre De Cochan', '061008', 64, NULL, NULL);
INSERT INTO `districts` VALUES (657, 'El Prado', '061009', 64, NULL, NULL);
INSERT INTO `districts` VALUES (658, 'Union Agua Blanca', '061010', 64, NULL, NULL);
INSERT INTO `districts` VALUES (659, 'Tongod', '061011', 64, NULL, NULL);
INSERT INTO `districts` VALUES (660, 'Catilluc', '061012', 64, NULL, NULL);
INSERT INTO `districts` VALUES (661, 'Bolivar', '061013', 64, NULL, NULL);
INSERT INTO `districts` VALUES (662, 'San Pablo', '061301', 65, NULL, NULL);
INSERT INTO `districts` VALUES (663, 'San Bernardino', '061302', 65, NULL, NULL);
INSERT INTO `districts` VALUES (664, 'San Luis', '061303', 65, NULL, NULL);
INSERT INTO `districts` VALUES (665, 'Tumbaden', '061304', 65, NULL, NULL);
INSERT INTO `districts` VALUES (666, 'Santa Cruz', '060901', 66, NULL, NULL);
INSERT INTO `districts` VALUES (667, 'Catache', '060902', 66, NULL, NULL);
INSERT INTO `districts` VALUES (668, 'Chancaybaños', '060903', 66, NULL, NULL);
INSERT INTO `districts` VALUES (669, 'La Esperanza', '060904', 66, NULL, NULL);
INSERT INTO `districts` VALUES (670, 'Ninabamba', '060905', 66, NULL, NULL);
INSERT INTO `districts` VALUES (671, 'Pulan', '060906', 66, NULL, NULL);
INSERT INTO `districts` VALUES (672, 'Sexi', '060907', 66, NULL, NULL);
INSERT INTO `districts` VALUES (673, 'Uticyacu', '060908', 66, NULL, NULL);
INSERT INTO `districts` VALUES (674, 'Yauyucan', '060909', 66, NULL, NULL);
INSERT INTO `districts` VALUES (675, 'Andabamba', '060910', 66, NULL, NULL);
INSERT INTO `districts` VALUES (676, 'Saucepampa', '060911', 66, NULL, NULL);
INSERT INTO `districts` VALUES (677, 'Callao', '240101', 67, NULL, NULL);
INSERT INTO `districts` VALUES (678, 'Bellavista', '240102', 67, NULL, NULL);
INSERT INTO `districts` VALUES (679, 'La Punta', '240103', 67, NULL, NULL);
INSERT INTO `districts` VALUES (680, 'Carmen De La Legua Reynoso', '240104', 67, NULL, NULL);
INSERT INTO `districts` VALUES (681, 'La Perla', '240105', 67, NULL, NULL);
INSERT INTO `districts` VALUES (682, 'Ventanilla', '240106', 67, NULL, NULL);
INSERT INTO `districts` VALUES (683, 'Acomayo', '070201', 68, NULL, NULL);
INSERT INTO `districts` VALUES (684, 'Acopia', '070202', 68, NULL, NULL);
INSERT INTO `districts` VALUES (685, 'Acos', '070203', 68, NULL, NULL);
INSERT INTO `districts` VALUES (686, 'Pomacanchi', '070204', 68, NULL, NULL);
INSERT INTO `districts` VALUES (687, 'Rondocan', '070205', 68, NULL, NULL);
INSERT INTO `districts` VALUES (688, 'Sangarara', '070206', 68, NULL, NULL);
INSERT INTO `districts` VALUES (689, 'Mosoc Llacta', '070207', 68, NULL, NULL);
INSERT INTO `districts` VALUES (690, 'Anta', '070301', 69, NULL, NULL);
INSERT INTO `districts` VALUES (691, 'Chinchaypujio', '070302', 69, NULL, NULL);
INSERT INTO `districts` VALUES (692, 'Huarocondo', '070303', 69, NULL, NULL);
INSERT INTO `districts` VALUES (693, 'Limatambo', '070304', 69, NULL, NULL);
INSERT INTO `districts` VALUES (694, 'Mollepata', '070305', 69, NULL, NULL);
INSERT INTO `districts` VALUES (695, 'Pucyura', '070306', 69, NULL, NULL);
INSERT INTO `districts` VALUES (696, 'Zurite', '070307', 69, NULL, NULL);
INSERT INTO `districts` VALUES (697, 'Cachimayo', '070308', 69, NULL, NULL);
INSERT INTO `districts` VALUES (698, 'Ancahuasi', '070309', 69, NULL, NULL);
INSERT INTO `districts` VALUES (699, 'Calca', '070401', 70, NULL, NULL);
INSERT INTO `districts` VALUES (700, 'Coya', '070402', 70, NULL, NULL);
INSERT INTO `districts` VALUES (701, 'Lamay', '070403', 70, NULL, NULL);
INSERT INTO `districts` VALUES (702, 'Lares', '070404', 70, NULL, NULL);
INSERT INTO `districts` VALUES (703, 'Pisac', '070405', 70, NULL, NULL);
INSERT INTO `districts` VALUES (704, 'San Salvador', '070406', 70, NULL, NULL);
INSERT INTO `districts` VALUES (705, 'Taray', '070407', 70, NULL, NULL);
INSERT INTO `districts` VALUES (706, 'Yanatile', '070408', 70, NULL, NULL);
INSERT INTO `districts` VALUES (707, 'Yanaoca', '070501', 71, NULL, NULL);
INSERT INTO `districts` VALUES (708, 'Checca', '070502', 71, NULL, NULL);
INSERT INTO `districts` VALUES (709, 'Kunturkanki', '070503', 71, NULL, NULL);
INSERT INTO `districts` VALUES (710, 'Langui', '070504', 71, NULL, NULL);
INSERT INTO `districts` VALUES (711, 'Layo', '070505', 71, NULL, NULL);
INSERT INTO `districts` VALUES (712, 'Pampamarca', '070506', 71, NULL, NULL);
INSERT INTO `districts` VALUES (713, 'Quehue', '070507', 71, NULL, NULL);
INSERT INTO `districts` VALUES (714, 'Tupac Amaru', '070508', 71, NULL, NULL);
INSERT INTO `districts` VALUES (715, 'Sicuani', '070601', 72, NULL, NULL);
INSERT INTO `districts` VALUES (716, 'Combapata', '070602', 72, NULL, NULL);
INSERT INTO `districts` VALUES (717, 'Checacupe', '070603', 72, NULL, NULL);
INSERT INTO `districts` VALUES (718, 'Marangani', '070604', 72, NULL, NULL);
INSERT INTO `districts` VALUES (719, 'Pitumarca', '070605', 72, NULL, NULL);
INSERT INTO `districts` VALUES (720, 'San Pablo', '070606', 72, NULL, NULL);
INSERT INTO `districts` VALUES (721, 'San Pedro', '070607', 72, NULL, NULL);
INSERT INTO `districts` VALUES (722, 'Tinta', '070608', 72, NULL, NULL);
INSERT INTO `districts` VALUES (723, 'Santo Tomas', '070701', 73, NULL, NULL);
INSERT INTO `districts` VALUES (724, 'Capacmarca', '070702', 73, NULL, NULL);
INSERT INTO `districts` VALUES (725, 'Colquemarca', '070703', 73, NULL, NULL);
INSERT INTO `districts` VALUES (726, 'Chamaca', '070704', 73, NULL, NULL);
INSERT INTO `districts` VALUES (727, 'Livitaca', '070705', 73, NULL, NULL);
INSERT INTO `districts` VALUES (728, 'Llusco', '070706', 73, NULL, NULL);
INSERT INTO `districts` VALUES (729, 'Quiñota', '070707', 73, NULL, NULL);
INSERT INTO `districts` VALUES (730, 'Velille', '070708', 73, NULL, NULL);
INSERT INTO `districts` VALUES (731, 'Cusco', '070101', 74, NULL, NULL);
INSERT INTO `districts` VALUES (732, 'Ccorca', '070102', 74, NULL, NULL);
INSERT INTO `districts` VALUES (733, 'Poroy', '070103', 74, NULL, NULL);
INSERT INTO `districts` VALUES (734, 'San Jeronimo', '070104', 74, NULL, NULL);
INSERT INTO `districts` VALUES (735, 'San Sebastian', '070105', 74, NULL, NULL);
INSERT INTO `districts` VALUES (736, 'Santiago', '070106', 74, NULL, NULL);
INSERT INTO `districts` VALUES (737, 'Saylla', '070107', 74, NULL, NULL);
INSERT INTO `districts` VALUES (738, 'Wanchaq', '070108', 74, NULL, NULL);
INSERT INTO `districts` VALUES (739, 'Espinar', '070801', 75, NULL, NULL);
INSERT INTO `districts` VALUES (740, 'Condoroma', '070802', 75, NULL, NULL);
INSERT INTO `districts` VALUES (741, 'Coporaque', '070803', 75, NULL, NULL);
INSERT INTO `districts` VALUES (742, 'Occoruro', '070804', 75, NULL, NULL);
INSERT INTO `districts` VALUES (743, 'Pallpata', '070805', 75, NULL, NULL);
INSERT INTO `districts` VALUES (744, 'Pichigua', '070806', 75, NULL, NULL);
INSERT INTO `districts` VALUES (745, 'Suyckutambo', '070807', 75, NULL, NULL);
INSERT INTO `districts` VALUES (746, 'Alto Pichigua', '070808', 75, NULL, NULL);
INSERT INTO `districts` VALUES (747, 'Santa Ana', '070901', 76, NULL, NULL);
INSERT INTO `districts` VALUES (748, 'Echarati', '070902', 76, NULL, NULL);
INSERT INTO `districts` VALUES (749, 'Huayopata', '070903', 76, NULL, NULL);
INSERT INTO `districts` VALUES (750, 'Maranura', '070904', 76, NULL, NULL);
INSERT INTO `districts` VALUES (751, 'Ocobamba', '070905', 76, NULL, NULL);
INSERT INTO `districts` VALUES (752, 'Santa Teresa', '070906', 76, NULL, NULL);
INSERT INTO `districts` VALUES (753, 'Vilcabamba', '070907', 76, NULL, NULL);
INSERT INTO `districts` VALUES (754, 'Quellouno', '070908', 76, NULL, NULL);
INSERT INTO `districts` VALUES (755, 'Kimbiri', '070909', 76, NULL, NULL);
INSERT INTO `districts` VALUES (756, 'Pichari', '070910', 76, NULL, NULL);
INSERT INTO `districts` VALUES (757, 'Paruro', '071001', 77, NULL, NULL);
INSERT INTO `districts` VALUES (758, 'Accha', '071002', 77, NULL, NULL);
INSERT INTO `districts` VALUES (759, 'Ccapi', '071003', 77, NULL, NULL);
INSERT INTO `districts` VALUES (760, 'Colcha', '071004', 77, NULL, NULL);
INSERT INTO `districts` VALUES (761, 'Huanoquite', '071005', 77, NULL, NULL);
INSERT INTO `districts` VALUES (762, 'Omacha', '071006', 77, NULL, NULL);
INSERT INTO `districts` VALUES (763, 'Yaurisque', '071007', 77, NULL, NULL);
INSERT INTO `districts` VALUES (764, 'Paccaritambo', '071008', 77, NULL, NULL);
INSERT INTO `districts` VALUES (765, 'Pillpinto', '071009', 77, NULL, NULL);
INSERT INTO `districts` VALUES (766, 'Paucartambo', '071101', 78, NULL, NULL);
INSERT INTO `districts` VALUES (767, 'Caicay', '071102', 78, NULL, NULL);
INSERT INTO `districts` VALUES (768, 'Colquepata', '071103', 78, NULL, NULL);
INSERT INTO `districts` VALUES (769, 'Challabamba', '071104', 78, NULL, NULL);
INSERT INTO `districts` VALUES (770, 'Kosñipata', '071105', 78, NULL, NULL);
INSERT INTO `districts` VALUES (771, 'Huancarani', '071106', 78, NULL, NULL);
INSERT INTO `districts` VALUES (772, 'Urcos', '071201', 79, NULL, NULL);
INSERT INTO `districts` VALUES (773, 'Andahuaylillas', '071202', 79, NULL, NULL);
INSERT INTO `districts` VALUES (774, 'Camanti', '071203', 79, NULL, NULL);
INSERT INTO `districts` VALUES (775, 'Ccarhuayo', '071204', 79, NULL, NULL);
INSERT INTO `districts` VALUES (776, 'Ccatca', '071205', 79, NULL, NULL);
INSERT INTO `districts` VALUES (777, 'Cusipata', '071206', 79, NULL, NULL);
INSERT INTO `districts` VALUES (778, 'Huaro', '071207', 79, NULL, NULL);
INSERT INTO `districts` VALUES (779, 'Lucre', '071208', 79, NULL, NULL);
INSERT INTO `districts` VALUES (780, 'Marcapata', '071209', 79, NULL, NULL);
INSERT INTO `districts` VALUES (781, 'Ocongate', '071210', 79, NULL, NULL);
INSERT INTO `districts` VALUES (782, 'Oropesa', '071211', 79, NULL, NULL);
INSERT INTO `districts` VALUES (783, 'Quiquijana', '071212', 79, NULL, NULL);
INSERT INTO `districts` VALUES (784, 'Urubamba', '071301', 80, NULL, NULL);
INSERT INTO `districts` VALUES (785, 'Chinchero', '071302', 80, NULL, NULL);
INSERT INTO `districts` VALUES (786, 'Huayllabamba', '071303', 80, NULL, NULL);
INSERT INTO `districts` VALUES (787, 'Machupicchu', '071304', 80, NULL, NULL);
INSERT INTO `districts` VALUES (788, 'Maras', '071305', 80, NULL, NULL);
INSERT INTO `districts` VALUES (789, 'Ollantaytambo', '071306', 80, NULL, NULL);
INSERT INTO `districts` VALUES (790, 'Yucay', '071307', 80, NULL, NULL);
INSERT INTO `districts` VALUES (791, 'Acobamba', '080201', 81, NULL, NULL);
INSERT INTO `districts` VALUES (792, 'Anta', '080202', 81, NULL, NULL);
INSERT INTO `districts` VALUES (793, 'Andabamba', '080203', 81, NULL, NULL);
INSERT INTO `districts` VALUES (794, 'Caja', '080204', 81, NULL, NULL);
INSERT INTO `districts` VALUES (795, 'Marcas', '080205', 81, NULL, NULL);
INSERT INTO `districts` VALUES (796, 'Paucara', '080206', 81, NULL, NULL);
INSERT INTO `districts` VALUES (797, 'Pomacocha', '080207', 81, NULL, NULL);
INSERT INTO `districts` VALUES (798, 'Rosario', '080208', 81, NULL, NULL);
INSERT INTO `districts` VALUES (799, 'Lircay', '080301', 82, NULL, NULL);
INSERT INTO `districts` VALUES (800, 'Anchonga', '080302', 82, NULL, NULL);
INSERT INTO `districts` VALUES (801, 'Callanmarca', '080303', 82, NULL, NULL);
INSERT INTO `districts` VALUES (802, 'Congalla', '080304', 82, NULL, NULL);
INSERT INTO `districts` VALUES (803, 'Chincho', '080305', 82, NULL, NULL);
INSERT INTO `districts` VALUES (804, 'Huallay-grande', '080306', 82, NULL, NULL);
INSERT INTO `districts` VALUES (805, 'Huanca-huanca', '080307', 82, NULL, NULL);
INSERT INTO `districts` VALUES (806, 'Julcamarca', '080308', 82, NULL, NULL);
INSERT INTO `districts` VALUES (807, 'San Antonio De Antaparco', '080309', 82, NULL, NULL);
INSERT INTO `districts` VALUES (808, 'Santo Tomas De Pata', '080310', 82, NULL, NULL);
INSERT INTO `districts` VALUES (809, 'Secclla', '080311', 82, NULL, NULL);
INSERT INTO `districts` VALUES (810, 'Ccochaccasa', '080312', 82, NULL, NULL);
INSERT INTO `districts` VALUES (811, 'Castrovirreyna', '080401', 83, NULL, NULL);
INSERT INTO `districts` VALUES (812, 'Arma', '080402', 83, NULL, NULL);
INSERT INTO `districts` VALUES (813, 'Aurahua', '080403', 83, NULL, NULL);
INSERT INTO `districts` VALUES (814, 'Capillas', '080405', 83, NULL, NULL);
INSERT INTO `districts` VALUES (815, 'Cocas', '080406', 83, NULL, NULL);
INSERT INTO `districts` VALUES (816, 'Chupamarca', '080408', 83, NULL, NULL);
INSERT INTO `districts` VALUES (817, 'Huachos', '080409', 83, NULL, NULL);
INSERT INTO `districts` VALUES (818, 'Huamatambo', '080410', 83, NULL, NULL);
INSERT INTO `districts` VALUES (819, 'Mollepampa', '080414', 83, NULL, NULL);
INSERT INTO `districts` VALUES (820, 'San Juan', '080422', 83, NULL, NULL);
INSERT INTO `districts` VALUES (821, 'Tantara', '080427', 83, NULL, NULL);
INSERT INTO `districts` VALUES (822, 'Ticrapo', '080428', 83, NULL, NULL);
INSERT INTO `districts` VALUES (823, 'Santa Ana', '080429', 83, NULL, NULL);
INSERT INTO `districts` VALUES (824, 'Churcampa', '080701', 84, NULL, NULL);
INSERT INTO `districts` VALUES (825, 'Anco', '080702', 84, NULL, NULL);
INSERT INTO `districts` VALUES (826, 'Chinchihuasi', '080703', 84, NULL, NULL);
INSERT INTO `districts` VALUES (827, 'El Carmen', '080704', 84, NULL, NULL);
INSERT INTO `districts` VALUES (828, 'La Merced', '080705', 84, NULL, NULL);
INSERT INTO `districts` VALUES (829, 'Locroja', '080706', 84, NULL, NULL);
INSERT INTO `districts` VALUES (830, 'Paucarbamba', '080707', 84, NULL, NULL);
INSERT INTO `districts` VALUES (831, 'San Miguel De Mayocc', '080708', 84, NULL, NULL);
INSERT INTO `districts` VALUES (832, 'San Pedro De Coris', '080709', 84, NULL, NULL);
INSERT INTO `districts` VALUES (833, 'Pachamarca', '080710', 84, NULL, NULL);
INSERT INTO `districts` VALUES (834, 'Huancavelica', '080101', 85, NULL, NULL);
INSERT INTO `districts` VALUES (835, 'Acobambilla', '080102', 85, NULL, NULL);
INSERT INTO `districts` VALUES (836, 'Acoria', '080103', 85, NULL, NULL);
INSERT INTO `districts` VALUES (837, 'Conayca', '080104', 85, NULL, NULL);
INSERT INTO `districts` VALUES (838, 'Cuenca', '080105', 85, NULL, NULL);
INSERT INTO `districts` VALUES (839, 'Huachocolpa', '080106', 85, NULL, NULL);
INSERT INTO `districts` VALUES (840, 'Huayllahuara', '080108', 85, NULL, NULL);
INSERT INTO `districts` VALUES (841, 'Izcuchaca', '080109', 85, NULL, NULL);
INSERT INTO `districts` VALUES (842, 'Laria', '080110', 85, NULL, NULL);
INSERT INTO `districts` VALUES (843, 'Manta', '080111', 85, NULL, NULL);
INSERT INTO `districts` VALUES (844, 'Mariscal Caceres', '080112', 85, NULL, NULL);
INSERT INTO `districts` VALUES (845, 'Moya', '080113', 85, NULL, NULL);
INSERT INTO `districts` VALUES (846, 'Nuevo Occoro', '080114', 85, NULL, NULL);
INSERT INTO `districts` VALUES (847, 'Palca', '080115', 85, NULL, NULL);
INSERT INTO `districts` VALUES (848, 'Pilchaca', '080116', 85, NULL, NULL);
INSERT INTO `districts` VALUES (849, 'Vilca', '080117', 85, NULL, NULL);
INSERT INTO `districts` VALUES (850, 'Yauli', '080118', 85, NULL, NULL);
INSERT INTO `districts` VALUES (851, 'Ascension', '080119', 85, NULL, NULL);
INSERT INTO `districts` VALUES (852, 'Huando', '080120', 85, NULL, NULL);
INSERT INTO `districts` VALUES (853, 'Ayavi', '080601', 86, NULL, NULL);
INSERT INTO `districts` VALUES (854, 'Cordova', '080602', 86, NULL, NULL);
INSERT INTO `districts` VALUES (855, 'Huayacundo Arma', '080603', 86, NULL, NULL);
INSERT INTO `districts` VALUES (856, 'Huaytara', '080604', 86, NULL, NULL);
INSERT INTO `districts` VALUES (857, 'Laramarca', '080605', 86, NULL, NULL);
INSERT INTO `districts` VALUES (858, 'Ocoyo', '080606', 86, NULL, NULL);
INSERT INTO `districts` VALUES (859, 'Pilpichaca', '080607', 86, NULL, NULL);
INSERT INTO `districts` VALUES (860, 'Querco', '080608', 86, NULL, NULL);
INSERT INTO `districts` VALUES (861, 'Quito Arma', '080609', 86, NULL, NULL);
INSERT INTO `districts` VALUES (862, 'San Antonio De Cusicancha', '080610', 86, NULL, NULL);
INSERT INTO `districts` VALUES (863, 'San Francisco De Sangayaico', '080611', 86, NULL, NULL);
INSERT INTO `districts` VALUES (864, 'San Isidro', '080612', 86, NULL, NULL);
INSERT INTO `districts` VALUES (865, 'Santiago De Chocorvos', '080613', 86, NULL, NULL);
INSERT INTO `districts` VALUES (866, 'Santiago De Quirahuara', '080614', 86, NULL, NULL);
INSERT INTO `districts` VALUES (867, 'Santo Domingo De Capillas', '080615', 86, NULL, NULL);
INSERT INTO `districts` VALUES (868, 'Tambo', '080616', 86, NULL, NULL);
INSERT INTO `districts` VALUES (869, 'Pampas', '080501', 87, NULL, NULL);
INSERT INTO `districts` VALUES (870, 'Acostambo', '080502', 87, NULL, NULL);
INSERT INTO `districts` VALUES (871, 'Acraquia', '080503', 87, NULL, NULL);
INSERT INTO `districts` VALUES (872, 'Ahuaycha', '080504', 87, NULL, NULL);
INSERT INTO `districts` VALUES (873, 'Colcabamba', '080506', 87, NULL, NULL);
INSERT INTO `districts` VALUES (874, 'Daniel Hernandez', '080509', 87, NULL, NULL);
INSERT INTO `districts` VALUES (875, 'Huachocolpa', '080511', 87, NULL, NULL);
INSERT INTO `districts` VALUES (876, 'Huaribamba', '080512', 87, NULL, NULL);
INSERT INTO `districts` VALUES (877, 'ñahuimpuquio', '080515', 87, NULL, NULL);
INSERT INTO `districts` VALUES (878, 'Pazos', '080517', 87, NULL, NULL);
INSERT INTO `districts` VALUES (879, 'Quishuar', '080518', 87, NULL, NULL);
INSERT INTO `districts` VALUES (880, 'Salcabamba', '080519', 87, NULL, NULL);
INSERT INTO `districts` VALUES (881, 'San Marcos De Rocchac', '080520', 87, NULL, NULL);
INSERT INTO `districts` VALUES (882, 'Surcabamba', '080523', 87, NULL, NULL);
INSERT INTO `districts` VALUES (883, 'Tintay Puncu', '080525', 87, NULL, NULL);
INSERT INTO `districts` VALUES (884, 'Salcahuasi', '080526', 87, NULL, NULL);
INSERT INTO `districts` VALUES (885, 'Ambo', '090201', 88, NULL, NULL);
INSERT INTO `districts` VALUES (886, 'Cayna', '090202', 88, NULL, NULL);
INSERT INTO `districts` VALUES (887, 'Colpas', '090203', 88, NULL, NULL);
INSERT INTO `districts` VALUES (888, 'Conchamarca', '090204', 88, NULL, NULL);
INSERT INTO `districts` VALUES (889, 'Huacar', '090205', 88, NULL, NULL);
INSERT INTO `districts` VALUES (890, 'San Francisco', '090206', 88, NULL, NULL);
INSERT INTO `districts` VALUES (891, 'San Rafael', '090207', 88, NULL, NULL);
INSERT INTO `districts` VALUES (892, 'Tomay-kichwa', '090208', 88, NULL, NULL);
INSERT INTO `districts` VALUES (893, 'La Union', '090301', 89, NULL, NULL);
INSERT INTO `districts` VALUES (894, 'Chuquis', '090307', 89, NULL, NULL);
INSERT INTO `districts` VALUES (895, 'Marias', '090312', 89, NULL, NULL);
INSERT INTO `districts` VALUES (896, 'Pachas', '090314', 89, NULL, NULL);
INSERT INTO `districts` VALUES (897, 'Quivilla', '090316', 89, NULL, NULL);
INSERT INTO `districts` VALUES (898, 'Ripan', '090317', 89, NULL, NULL);
INSERT INTO `districts` VALUES (899, 'Shunqui', '090321', 89, NULL, NULL);
INSERT INTO `districts` VALUES (900, 'Sillapata', '090322', 89, NULL, NULL);
INSERT INTO `districts` VALUES (901, 'Yanas', '090323', 89, NULL, NULL);
INSERT INTO `districts` VALUES (902, 'Huacaybamba', '090901', 90, NULL, NULL);
INSERT INTO `districts` VALUES (903, 'Pinra', '090902', 90, NULL, NULL);
INSERT INTO `districts` VALUES (904, 'Canchabamba', '090903', 90, NULL, NULL);
INSERT INTO `districts` VALUES (905, 'Cochabamba', '090904', 90, NULL, NULL);
INSERT INTO `districts` VALUES (906, 'Llata', '090401', 91, NULL, NULL);
INSERT INTO `districts` VALUES (907, 'Arancay', '090402', 91, NULL, NULL);
INSERT INTO `districts` VALUES (908, 'Chavin De Pariarca', '090403', 91, NULL, NULL);
INSERT INTO `districts` VALUES (909, 'Jacas Grande', '090404', 91, NULL, NULL);
INSERT INTO `districts` VALUES (910, 'Jircan', '090405', 91, NULL, NULL);
INSERT INTO `districts` VALUES (911, 'Miraflores', '090406', 91, NULL, NULL);
INSERT INTO `districts` VALUES (912, 'Monzon', '090407', 91, NULL, NULL);
INSERT INTO `districts` VALUES (913, 'Punchao', '090408', 91, NULL, NULL);
INSERT INTO `districts` VALUES (914, 'Puños', '090409', 91, NULL, NULL);
INSERT INTO `districts` VALUES (915, 'Singa', '090410', 91, NULL, NULL);
INSERT INTO `districts` VALUES (916, 'Tantamayo', '090411', 91, NULL, NULL);
INSERT INTO `districts` VALUES (917, 'Huanuco', '090101', 92, NULL, NULL);
INSERT INTO `districts` VALUES (918, 'Chinchao', '090102', 92, NULL, NULL);
INSERT INTO `districts` VALUES (919, 'Churubamba', '090103', 92, NULL, NULL);
INSERT INTO `districts` VALUES (920, 'Margos', '090104', 92, NULL, NULL);
INSERT INTO `districts` VALUES (921, 'Quisqui', '090105', 92, NULL, NULL);
INSERT INTO `districts` VALUES (922, 'San Francisco De Cayran', '090106', 92, NULL, NULL);
INSERT INTO `districts` VALUES (923, 'San Pedro De Chaulan', '090107', 92, NULL, NULL);
INSERT INTO `districts` VALUES (924, 'Santa Maria Del Valle', '090108', 92, NULL, NULL);
INSERT INTO `districts` VALUES (925, 'Yarumayo', '090109', 92, NULL, NULL);
INSERT INTO `districts` VALUES (926, 'Amarilis', '090110', 92, NULL, NULL);
INSERT INTO `districts` VALUES (927, 'Pillco Marca', '090111', 92, NULL, NULL);
INSERT INTO `districts` VALUES (928, 'Jesus', '091001', 93, NULL, NULL);
INSERT INTO `districts` VALUES (929, 'Baños', '091002', 93, NULL, NULL);
INSERT INTO `districts` VALUES (930, 'San Francisco De Asis', '091003', 93, NULL, NULL);
INSERT INTO `districts` VALUES (931, 'Queropalca', '091004', 93, NULL, NULL);
INSERT INTO `districts` VALUES (932, 'San Miguel De Cauri', '091005', 93, NULL, NULL);
INSERT INTO `districts` VALUES (933, 'Rondos', '091006', 93, NULL, NULL);
INSERT INTO `districts` VALUES (934, 'Jivia', '091007', 93, NULL, NULL);
INSERT INTO `districts` VALUES (935, 'Rupa-rupa', '090601', 94, NULL, NULL);
INSERT INTO `districts` VALUES (936, 'Daniel Alomia Robles', '090602', 94, NULL, NULL);
INSERT INTO `districts` VALUES (937, 'Hermilio Valdizan', '090603', 94, NULL, NULL);
INSERT INTO `districts` VALUES (938, 'Luyando', '090604', 94, NULL, NULL);
INSERT INTO `districts` VALUES (939, 'Mariano Damaso Beraun', '090605', 94, NULL, NULL);
INSERT INTO `districts` VALUES (940, 'Jose Crespo Y Castillo', '090606', 94, NULL, NULL);
INSERT INTO `districts` VALUES (941, 'Huacrachuco', '090501', 95, NULL, NULL);
INSERT INTO `districts` VALUES (942, 'Cholon', '090502', 95, NULL, NULL);
INSERT INTO `districts` VALUES (943, 'San Buenaventura', '090505', 95, NULL, NULL);
INSERT INTO `districts` VALUES (944, 'Panao', '090701', 96, NULL, NULL);
INSERT INTO `districts` VALUES (945, 'Chaglla', '090702', 96, NULL, NULL);
INSERT INTO `districts` VALUES (946, 'Molino', '090704', 96, NULL, NULL);
INSERT INTO `districts` VALUES (947, 'Umari', '090706', 96, NULL, NULL);
INSERT INTO `districts` VALUES (948, 'Honoria', '090801', 97, NULL, NULL);
INSERT INTO `districts` VALUES (949, 'Puerto Inca', '090802', 97, NULL, NULL);
INSERT INTO `districts` VALUES (950, 'Codo Del Pozuzo', '090803', 97, NULL, NULL);
INSERT INTO `districts` VALUES (951, 'Tournavista', '090804', 97, NULL, NULL);
INSERT INTO `districts` VALUES (952, 'Yuyapichis', '090805', 97, NULL, NULL);
INSERT INTO `districts` VALUES (953, 'Chavinillo', '091101', 98, NULL, NULL);
INSERT INTO `districts` VALUES (954, 'Aparicio Pomares', '091102', 98, NULL, NULL);
INSERT INTO `districts` VALUES (955, 'Cahuac', '091103', 98, NULL, NULL);
INSERT INTO `districts` VALUES (956, 'Chacabamba', '091104', 98, NULL, NULL);
INSERT INTO `districts` VALUES (957, 'Jacas Chico', '091105', 98, NULL, NULL);
INSERT INTO `districts` VALUES (958, 'Obas', '091106', 98, NULL, NULL);
INSERT INTO `districts` VALUES (959, 'Pampamarca', '091107', 98, NULL, NULL);
INSERT INTO `districts` VALUES (960, 'Choras', '091108', 98, NULL, NULL);
INSERT INTO `districts` VALUES (961, 'Chincha Alta', '100201', 99, NULL, NULL);
INSERT INTO `districts` VALUES (962, 'Chavin', '100202', 99, NULL, NULL);
INSERT INTO `districts` VALUES (963, 'Chincha Baja', '100203', 99, NULL, NULL);
INSERT INTO `districts` VALUES (964, 'El Carmen', '100204', 99, NULL, NULL);
INSERT INTO `districts` VALUES (965, 'Grocio Prado', '100205', 99, NULL, NULL);
INSERT INTO `districts` VALUES (966, 'San Pedro De Huacarpana', '100206', 99, NULL, NULL);
INSERT INTO `districts` VALUES (967, 'Sunampe', '100207', 99, NULL, NULL);
INSERT INTO `districts` VALUES (968, 'Tambo De Mora', '100208', 99, NULL, NULL);
INSERT INTO `districts` VALUES (969, 'Alto Laran', '100209', 99, NULL, NULL);
INSERT INTO `districts` VALUES (970, 'Pueblo Nuevo', '100210', 99, NULL, NULL);
INSERT INTO `districts` VALUES (971, 'San Juan De Yanac', '100211', 99, NULL, NULL);
INSERT INTO `districts` VALUES (972, 'Ica', '100101', 100, NULL, NULL);
INSERT INTO `districts` VALUES (973, 'La Tinguiña', '100102', 100, NULL, NULL);
INSERT INTO `districts` VALUES (974, 'Los Aquijes', '100103', 100, NULL, NULL);
INSERT INTO `districts` VALUES (975, 'Parcona', '100104', 100, NULL, NULL);
INSERT INTO `districts` VALUES (976, 'Pueblo Nuevo', '100105', 100, NULL, NULL);
INSERT INTO `districts` VALUES (977, 'Salas', '100106', 100, NULL, NULL);
INSERT INTO `districts` VALUES (978, 'San Jose De Los Molinos', '100107', 100, NULL, NULL);
INSERT INTO `districts` VALUES (979, 'San Juan Bautista', '100108', 100, NULL, NULL);
INSERT INTO `districts` VALUES (980, 'Santiago', '100109', 100, NULL, NULL);
INSERT INTO `districts` VALUES (981, 'Subtanjalla', '100110', 100, NULL, NULL);
INSERT INTO `districts` VALUES (982, 'Yauca Del Rosario', '100111', 100, NULL, NULL);
INSERT INTO `districts` VALUES (983, 'Tate', '100112', 100, NULL, NULL);
INSERT INTO `districts` VALUES (984, 'Pachacutec', '100113', 100, NULL, NULL);
INSERT INTO `districts` VALUES (985, 'Ocucaje', '100114', 100, NULL, NULL);
INSERT INTO `districts` VALUES (986, 'Nazca', '100301', 101, NULL, NULL);
INSERT INTO `districts` VALUES (987, 'Changuillo', '100302', 101, NULL, NULL);
INSERT INTO `districts` VALUES (988, 'El Ingenio', '100303', 101, NULL, NULL);
INSERT INTO `districts` VALUES (989, 'Marcona', '100304', 101, NULL, NULL);
INSERT INTO `districts` VALUES (990, 'Vista Alegre', '100305', 101, NULL, NULL);
INSERT INTO `districts` VALUES (991, 'Palpa', '100501', 102, NULL, NULL);
INSERT INTO `districts` VALUES (992, 'Llipata', '100502', 102, NULL, NULL);
INSERT INTO `districts` VALUES (993, 'Rio Grande', '100503', 102, NULL, NULL);
INSERT INTO `districts` VALUES (994, 'Santa Cruz', '100504', 102, NULL, NULL);
INSERT INTO `districts` VALUES (995, 'Tibillo', '100505', 102, NULL, NULL);
INSERT INTO `districts` VALUES (996, 'Pisco', '100401', 103, NULL, NULL);
INSERT INTO `districts` VALUES (997, 'Huancano', '100402', 103, NULL, NULL);
INSERT INTO `districts` VALUES (998, 'Humay', '100403', 103, NULL, NULL);
INSERT INTO `districts` VALUES (999, 'Independencia', '100404', 103, NULL, NULL);
INSERT INTO `districts` VALUES (1000, 'Paracas', '100405', 103, NULL, NULL);
INSERT INTO `districts` VALUES (1001, 'San Andres', '100406', 103, NULL, NULL);
INSERT INTO `districts` VALUES (1002, 'San Clemente', '100407', 103, NULL, NULL);
INSERT INTO `districts` VALUES (1003, 'Tupac Amaru Inca', '100408', 103, NULL, NULL);
INSERT INTO `districts` VALUES (1004, 'Chanchamayo', '110801', 104, NULL, NULL);
INSERT INTO `districts` VALUES (1005, 'San Ramon', '110802', 104, NULL, NULL);
INSERT INTO `districts` VALUES (1006, 'Vitoc', '110803', 104, NULL, NULL);
INSERT INTO `districts` VALUES (1007, 'San Luis De Shuaro', '110804', 104, NULL, NULL);
INSERT INTO `districts` VALUES (1008, 'Pichanaqui', '110805', 104, NULL, NULL);
INSERT INTO `districts` VALUES (1009, 'Perene', '110806', 104, NULL, NULL);
INSERT INTO `districts` VALUES (1010, 'Chupaca', '110901', 105, NULL, NULL);
INSERT INTO `districts` VALUES (1011, 'Ahuac', '110902', 105, NULL, NULL);
INSERT INTO `districts` VALUES (1012, 'Chongos Bajo', '110903', 105, NULL, NULL);
INSERT INTO `districts` VALUES (1013, 'Huachac', '110904', 105, NULL, NULL);
INSERT INTO `districts` VALUES (1014, 'Huamancaca Chico', '110905', 105, NULL, NULL);
INSERT INTO `districts` VALUES (1015, 'San Juan De Yscos', '110906', 105, NULL, NULL);
INSERT INTO `districts` VALUES (1016, 'San Juan De Jarpa', '110907', 105, NULL, NULL);
INSERT INTO `districts` VALUES (1017, 'Tres De Diciembre', '110908', 105, NULL, NULL);
INSERT INTO `districts` VALUES (1018, 'Yanacancha', '110909', 105, NULL, NULL);
INSERT INTO `districts` VALUES (1019, 'Concepcion', '110201', 106, NULL, NULL);
INSERT INTO `districts` VALUES (1020, 'Aco', '110202', 106, NULL, NULL);
INSERT INTO `districts` VALUES (1021, 'Andamarca', '110203', 106, NULL, NULL);
INSERT INTO `districts` VALUES (1022, 'Comas', '110204', 106, NULL, NULL);
INSERT INTO `districts` VALUES (1023, 'Cochas', '110205', 106, NULL, NULL);
INSERT INTO `districts` VALUES (1024, 'Chambara', '110206', 106, NULL, NULL);
INSERT INTO `districts` VALUES (1025, 'Heroinas Toledo', '110207', 106, NULL, NULL);
INSERT INTO `districts` VALUES (1026, 'Manzanares', '110208', 106, NULL, NULL);
INSERT INTO `districts` VALUES (1027, 'Mariscal Castilla', '110209', 106, NULL, NULL);
INSERT INTO `districts` VALUES (1028, 'Matahuasi', '110210', 106, NULL, NULL);
INSERT INTO `districts` VALUES (1029, 'Mito', '110211', 106, NULL, NULL);
INSERT INTO `districts` VALUES (1030, 'Nueve De Julio', '110212', 106, NULL, NULL);
INSERT INTO `districts` VALUES (1031, 'Orcotuna', '110213', 106, NULL, NULL);
INSERT INTO `districts` VALUES (1032, 'Santa Rosa De Ocopa', '110214', 106, NULL, NULL);
INSERT INTO `districts` VALUES (1033, 'San Jose De Quero', '110215', 106, NULL, NULL);
INSERT INTO `districts` VALUES (1034, 'Huancayo', '110101', 107, NULL, NULL);
INSERT INTO `districts` VALUES (1035, 'Carhuacallanga', '110103', 107, NULL, NULL);
INSERT INTO `districts` VALUES (1036, 'Colca', '110104', 107, NULL, NULL);
INSERT INTO `districts` VALUES (1037, 'Cullhuas', '110105', 107, NULL, NULL);
INSERT INTO `districts` VALUES (1038, 'Chacapampa', '110106', 107, NULL, NULL);
INSERT INTO `districts` VALUES (1039, 'Chicche', '110107', 107, NULL, NULL);
INSERT INTO `districts` VALUES (1040, 'Chilca', '110108', 107, NULL, NULL);
INSERT INTO `districts` VALUES (1041, 'Chongos Alto', '110109', 107, NULL, NULL);
INSERT INTO `districts` VALUES (1042, 'Chupuro', '110112', 107, NULL, NULL);
INSERT INTO `districts` VALUES (1043, 'El Tambo', '110113', 107, NULL, NULL);
INSERT INTO `districts` VALUES (1044, 'Huacrapuquio', '110114', 107, NULL, NULL);
INSERT INTO `districts` VALUES (1045, 'Hualhuas', '110116', 107, NULL, NULL);
INSERT INTO `districts` VALUES (1046, 'Huancan', '110118', 107, NULL, NULL);
INSERT INTO `districts` VALUES (1047, 'Huasicancha', '110119', 107, NULL, NULL);
INSERT INTO `districts` VALUES (1048, 'Huayucachi', '110120', 107, NULL, NULL);
INSERT INTO `districts` VALUES (1049, 'Ingenio', '110121', 107, NULL, NULL);
INSERT INTO `districts` VALUES (1050, 'Pariahuanca', '110122', 107, NULL, NULL);
INSERT INTO `districts` VALUES (1051, 'Pilcomayo', '110123', 107, NULL, NULL);
INSERT INTO `districts` VALUES (1052, 'Pucara', '110124', 107, NULL, NULL);
INSERT INTO `districts` VALUES (1053, 'Quichuay', '110125', 107, NULL, NULL);
INSERT INTO `districts` VALUES (1054, 'Quilcas', '110126', 107, NULL, NULL);
INSERT INTO `districts` VALUES (1055, 'San Agustin', '110127', 107, NULL, NULL);
INSERT INTO `districts` VALUES (1056, 'San Jeronimo De Tunan', '110128', 107, NULL, NULL);
INSERT INTO `districts` VALUES (1057, 'Santo Domingo De Acobamba', '110131', 107, NULL, NULL);
INSERT INTO `districts` VALUES (1058, 'Saño', '110132', 107, NULL, NULL);
INSERT INTO `districts` VALUES (1059, 'Sapallanga', '110133', 107, NULL, NULL);
INSERT INTO `districts` VALUES (1060, 'Sicaya', '110134', 107, NULL, NULL);
INSERT INTO `districts` VALUES (1061, 'Viques', '110136', 107, NULL, NULL);
INSERT INTO `districts` VALUES (1062, 'Jauja', '110301', 108, NULL, NULL);
INSERT INTO `districts` VALUES (1063, 'Acolla', '110302', 108, NULL, NULL);
INSERT INTO `districts` VALUES (1064, 'Apata', '110303', 108, NULL, NULL);
INSERT INTO `districts` VALUES (1065, 'Ataura', '110304', 108, NULL, NULL);
INSERT INTO `districts` VALUES (1066, 'Canchayllo', '110305', 108, NULL, NULL);
INSERT INTO `districts` VALUES (1067, 'El Mantaro', '110306', 108, NULL, NULL);
INSERT INTO `districts` VALUES (1068, 'Huamali', '110307', 108, NULL, NULL);
INSERT INTO `districts` VALUES (1069, 'Huaripampa', '110308', 108, NULL, NULL);
INSERT INTO `districts` VALUES (1070, 'Huertas', '110309', 108, NULL, NULL);
INSERT INTO `districts` VALUES (1071, 'Janjaillo', '110310', 108, NULL, NULL);
INSERT INTO `districts` VALUES (1072, 'Julcan', '110311', 108, NULL, NULL);
INSERT INTO `districts` VALUES (1073, 'Leonor Ordoñez', '110312', 108, NULL, NULL);
INSERT INTO `districts` VALUES (1074, 'Llocllapampa', '110313', 108, NULL, NULL);
INSERT INTO `districts` VALUES (1075, 'Marco', '110314', 108, NULL, NULL);
INSERT INTO `districts` VALUES (1076, 'Masma', '110315', 108, NULL, NULL);
INSERT INTO `districts` VALUES (1077, 'Molinos', '110316', 108, NULL, NULL);
INSERT INTO `districts` VALUES (1078, 'Monobamba', '110317', 108, NULL, NULL);
INSERT INTO `districts` VALUES (1079, 'Muqui', '110318', 108, NULL, NULL);
INSERT INTO `districts` VALUES (1080, 'Muquiyauyo', '110319', 108, NULL, NULL);
INSERT INTO `districts` VALUES (1081, 'Paca', '110320', 108, NULL, NULL);
INSERT INTO `districts` VALUES (1082, 'Paccha', '110321', 108, NULL, NULL);
INSERT INTO `districts` VALUES (1083, 'Pancan', '110322', 108, NULL, NULL);
INSERT INTO `districts` VALUES (1084, 'Parco', '110323', 108, NULL, NULL);
INSERT INTO `districts` VALUES (1085, 'Pomacancha', '110324', 108, NULL, NULL);
INSERT INTO `districts` VALUES (1086, 'Ricran', '110325', 108, NULL, NULL);
INSERT INTO `districts` VALUES (1087, 'San Lorenzo', '110326', 108, NULL, NULL);
INSERT INTO `districts` VALUES (1088, 'San Pedro De Chunan', '110327', 108, NULL, NULL);
INSERT INTO `districts` VALUES (1089, 'Sincos', '110328', 108, NULL, NULL);
INSERT INTO `districts` VALUES (1090, 'Tunan Marca', '110329', 108, NULL, NULL);
INSERT INTO `districts` VALUES (1091, 'Yauli', '110330', 108, NULL, NULL);
INSERT INTO `districts` VALUES (1092, 'Curicaca', '110331', 108, NULL, NULL);
INSERT INTO `districts` VALUES (1093, 'Masma Chicche', '110332', 108, NULL, NULL);
INSERT INTO `districts` VALUES (1094, 'Sausa', '110333', 108, NULL, NULL);
INSERT INTO `districts` VALUES (1095, 'Yauyos', '110334', 108, NULL, NULL);
INSERT INTO `districts` VALUES (1096, 'Junin', '110401', 109, NULL, NULL);
INSERT INTO `districts` VALUES (1097, 'Carhuamayo', '110402', 109, NULL, NULL);
INSERT INTO `districts` VALUES (1098, 'Ondores', '110403', 109, NULL, NULL);
INSERT INTO `districts` VALUES (1099, 'Ulcumayo', '110404', 109, NULL, NULL);
INSERT INTO `districts` VALUES (1100, 'Satipo', '110701', 110, NULL, NULL);
INSERT INTO `districts` VALUES (1101, 'Coviriali', '110702', 110, NULL, NULL);
INSERT INTO `districts` VALUES (1102, 'Llaylla', '110703', 110, NULL, NULL);
INSERT INTO `districts` VALUES (1103, 'Mazamari', '110704', 110, NULL, NULL);
INSERT INTO `districts` VALUES (1104, 'Pampa Hermosa', '110705', 110, NULL, NULL);
INSERT INTO `districts` VALUES (1105, 'Pangoa', '110706', 110, NULL, NULL);
INSERT INTO `districts` VALUES (1106, 'Rio Negro', '110707', 110, NULL, NULL);
INSERT INTO `districts` VALUES (1107, 'Rio Tambo', '110708', 110, NULL, NULL);
INSERT INTO `districts` VALUES (1108, 'Tarma', '110501', 111, NULL, NULL);
INSERT INTO `districts` VALUES (1109, 'Acobamba', '110502', 111, NULL, NULL);
INSERT INTO `districts` VALUES (1110, 'Huaricolca', '110503', 111, NULL, NULL);
INSERT INTO `districts` VALUES (1111, 'Huasahuasi', '110504', 111, NULL, NULL);
INSERT INTO `districts` VALUES (1112, 'La Union', '110505', 111, NULL, NULL);
INSERT INTO `districts` VALUES (1113, 'Palca', '110506', 111, NULL, NULL);
INSERT INTO `districts` VALUES (1114, 'Palcamayo', '110507', 111, NULL, NULL);
INSERT INTO `districts` VALUES (1115, 'San Pedro De Cajas', '110508', 111, NULL, NULL);
INSERT INTO `districts` VALUES (1116, 'Tapo', '110509', 111, NULL, NULL);
INSERT INTO `districts` VALUES (1117, 'La Oroya', '110601', 112, NULL, NULL);
INSERT INTO `districts` VALUES (1118, 'Chacapalpa', '110602', 112, NULL, NULL);
INSERT INTO `districts` VALUES (1119, 'Huay Huay', '110603', 112, NULL, NULL);
INSERT INTO `districts` VALUES (1120, 'Marcapomacocha', '110604', 112, NULL, NULL);
INSERT INTO `districts` VALUES (1121, 'Morococha', '110605', 112, NULL, NULL);
INSERT INTO `districts` VALUES (1122, 'Paccha', '110606', 112, NULL, NULL);
INSERT INTO `districts` VALUES (1123, 'Santa Barbara De Carhuacayan', '110607', 112, NULL, NULL);
INSERT INTO `districts` VALUES (1124, 'Suitucancha', '110608', 112, NULL, NULL);
INSERT INTO `districts` VALUES (1125, 'Yauli', '110609', 112, NULL, NULL);
INSERT INTO `districts` VALUES (1126, 'Santa Rosa De Sacco', '110610', 112, NULL, NULL);
INSERT INTO `districts` VALUES (1127, 'Ascope', '120801', 113, NULL, NULL);
INSERT INTO `districts` VALUES (1128, 'Chicama', '120802', 113, NULL, NULL);
INSERT INTO `districts` VALUES (1129, 'Chocope', '120803', 113, NULL, NULL);
INSERT INTO `districts` VALUES (1130, 'Santiago De Cao', '120804', 113, NULL, NULL);
INSERT INTO `districts` VALUES (1131, 'Magdalena De Cao', '120805', 113, NULL, NULL);
INSERT INTO `districts` VALUES (1132, 'Paijan', '120806', 113, NULL, NULL);
INSERT INTO `districts` VALUES (1133, 'Razuri', '120807', 113, NULL, NULL);
INSERT INTO `districts` VALUES (1134, 'Casa Grande', '120808', 113, NULL, NULL);
INSERT INTO `districts` VALUES (1135, 'Bolivar', '120201', 114, NULL, NULL);
INSERT INTO `districts` VALUES (1136, 'Bambamarca', '120202', 114, NULL, NULL);
INSERT INTO `districts` VALUES (1137, 'Condormarca', '120203', 114, NULL, NULL);
INSERT INTO `districts` VALUES (1138, 'Longotea', '120204', 114, NULL, NULL);
INSERT INTO `districts` VALUES (1139, 'Ucuncha', '120205', 114, NULL, NULL);
INSERT INTO `districts` VALUES (1140, 'Uchumarca', '120206', 114, NULL, NULL);
INSERT INTO `districts` VALUES (1141, 'Chepen', '120901', 115, NULL, NULL);
INSERT INTO `districts` VALUES (1142, 'Pacanga', '120902', 115, NULL, NULL);
INSERT INTO `districts` VALUES (1143, 'Pueblo Nuevo', '120903', 115, NULL, NULL);
INSERT INTO `districts` VALUES (1144, 'Cascas', '121101', 116, NULL, NULL);
INSERT INTO `districts` VALUES (1145, 'Lucma', '121102', 116, NULL, NULL);
INSERT INTO `districts` VALUES (1146, 'Marmot', '121103', 116, NULL, NULL);
INSERT INTO `districts` VALUES (1147, 'Sayapullo', '121104', 116, NULL, NULL);
INSERT INTO `districts` VALUES (1148, 'Julcan', '121001', 117, NULL, NULL);
INSERT INTO `districts` VALUES (1149, 'Carabamba', '121002', 117, NULL, NULL);
INSERT INTO `districts` VALUES (1150, 'Calamarca', '121003', 117, NULL, NULL);
INSERT INTO `districts` VALUES (1151, 'Huaso', '121004', 117, NULL, NULL);
INSERT INTO `districts` VALUES (1152, 'Otuzco', '120401', 118, NULL, NULL);
INSERT INTO `districts` VALUES (1153, 'Agallpampa', '120402', 118, NULL, NULL);
INSERT INTO `districts` VALUES (1154, 'Charat', '120403', 118, NULL, NULL);
INSERT INTO `districts` VALUES (1155, 'Huaranchal', '120404', 118, NULL, NULL);
INSERT INTO `districts` VALUES (1156, 'La Cuesta', '120405', 118, NULL, NULL);
INSERT INTO `districts` VALUES (1157, 'Paranday', '120408', 118, NULL, NULL);
INSERT INTO `districts` VALUES (1158, 'Salpo', '120409', 118, NULL, NULL);
INSERT INTO `districts` VALUES (1159, 'Sinsicap', '120410', 118, NULL, NULL);
INSERT INTO `districts` VALUES (1160, 'Usquil', '120411', 118, NULL, NULL);
INSERT INTO `districts` VALUES (1161, 'Mache', '120413', 118, NULL, NULL);
INSERT INTO `districts` VALUES (1162, 'San Pedro De Lloc', '120501', 119, NULL, NULL);
INSERT INTO `districts` VALUES (1163, 'Guadalupe', '120503', 119, NULL, NULL);
INSERT INTO `districts` VALUES (1164, 'Jequetepeque', '120504', 119, NULL, NULL);
INSERT INTO `districts` VALUES (1165, 'Pacasmayo', '120506', 119, NULL, NULL);
INSERT INTO `districts` VALUES (1166, 'San Jose', '120508', 119, NULL, NULL);
INSERT INTO `districts` VALUES (1167, 'Tayabamba', '120601', 120, NULL, NULL);
INSERT INTO `districts` VALUES (1168, 'Buldibuyo', '120602', 120, NULL, NULL);
INSERT INTO `districts` VALUES (1169, 'Chillia', '120603', 120, NULL, NULL);
INSERT INTO `districts` VALUES (1170, 'Huaylillas', '120604', 120, NULL, NULL);
INSERT INTO `districts` VALUES (1171, 'Huancaspata', '120605', 120, NULL, NULL);
INSERT INTO `districts` VALUES (1172, 'Huayo', '120606', 120, NULL, NULL);
INSERT INTO `districts` VALUES (1173, 'Ongon', '120607', 120, NULL, NULL);
INSERT INTO `districts` VALUES (1174, 'Parcoy', '120608', 120, NULL, NULL);
INSERT INTO `districts` VALUES (1175, 'Pataz', '120609', 120, NULL, NULL);
INSERT INTO `districts` VALUES (1176, 'Pias', '120610', 120, NULL, NULL);
INSERT INTO `districts` VALUES (1177, 'Taurija', '120611', 120, NULL, NULL);
INSERT INTO `districts` VALUES (1178, 'Urpay', '120612', 120, NULL, NULL);
INSERT INTO `districts` VALUES (1179, 'Santiago De Challas', '120613', 120, NULL, NULL);
INSERT INTO `districts` VALUES (1180, 'Huamachuco', '120301', 121, NULL, NULL);
INSERT INTO `districts` VALUES (1181, 'Cochorco', '120302', 121, NULL, NULL);
INSERT INTO `districts` VALUES (1182, 'Curgos', '120303', 121, NULL, NULL);
INSERT INTO `districts` VALUES (1183, 'Chugay', '120304', 121, NULL, NULL);
INSERT INTO `districts` VALUES (1184, 'Marcabal', '120305', 121, NULL, NULL);
INSERT INTO `districts` VALUES (1185, 'Sanagoran', '120306', 121, NULL, NULL);
INSERT INTO `districts` VALUES (1186, 'Sarin', '120307', 121, NULL, NULL);
INSERT INTO `districts` VALUES (1187, 'Sartibamba', '120308', 121, NULL, NULL);
INSERT INTO `districts` VALUES (1188, 'Santiago De Chuco', '120701', 122, NULL, NULL);
INSERT INTO `districts` VALUES (1189, 'Cachicadan', '120702', 122, NULL, NULL);
INSERT INTO `districts` VALUES (1190, 'Mollebamba', '120703', 122, NULL, NULL);
INSERT INTO `districts` VALUES (1191, 'Mollepata', '120704', 122, NULL, NULL);
INSERT INTO `districts` VALUES (1192, 'Quiruvilca', '120705', 122, NULL, NULL);
INSERT INTO `districts` VALUES (1193, 'Santa Cruz De Chuca', '120706', 122, NULL, NULL);
INSERT INTO `districts` VALUES (1194, 'Sitabamba', '120707', 122, NULL, NULL);
INSERT INTO `districts` VALUES (1195, 'Angasmarca', '120708', 122, NULL, NULL);
INSERT INTO `districts` VALUES (1196, 'Trujillo', '120101', 123, NULL, NULL);
INSERT INTO `districts` VALUES (1197, 'Huanchaco', '120102', 123, NULL, NULL);
INSERT INTO `districts` VALUES (1198, 'Laredo', '120103', 123, NULL, NULL);
INSERT INTO `districts` VALUES (1199, 'Moche', '120104', 123, NULL, NULL);
INSERT INTO `districts` VALUES (1200, 'Salaverry', '120105', 123, NULL, NULL);
INSERT INTO `districts` VALUES (1201, 'Simbal', '120106', 123, NULL, NULL);
INSERT INTO `districts` VALUES (1202, 'Victor Larco Herrera', '120107', 123, NULL, NULL);
INSERT INTO `districts` VALUES (1203, 'Poroto', '120109', 123, NULL, NULL);
INSERT INTO `districts` VALUES (1204, 'El Porvenir', '120110', 123, NULL, NULL);
INSERT INTO `districts` VALUES (1205, 'La Esperanza', '120111', 123, NULL, NULL);
INSERT INTO `districts` VALUES (1206, 'Florencia De Mora', '120112', 123, NULL, NULL);
INSERT INTO `districts` VALUES (1207, 'Viru', '121201', 124, NULL, NULL);
INSERT INTO `districts` VALUES (1208, 'Chao', '121202', 124, NULL, NULL);
INSERT INTO `districts` VALUES (1209, 'Guadalupito', '121203', 124, NULL, NULL);
INSERT INTO `districts` VALUES (1210, 'Chiclayo', '130101', 125, NULL, NULL);
INSERT INTO `districts` VALUES (1211, 'Chongoyape', '130102', 125, NULL, NULL);
INSERT INTO `districts` VALUES (1212, 'Eten', '130103', 125, NULL, NULL);
INSERT INTO `districts` VALUES (1213, 'Eten Puerto', '130104', 125, NULL, NULL);
INSERT INTO `districts` VALUES (1214, 'Lagunas', '130105', 125, NULL, NULL);
INSERT INTO `districts` VALUES (1215, 'Monsefu', '130106', 125, NULL, NULL);
INSERT INTO `districts` VALUES (1216, 'Nueva Arica', '130107', 125, NULL, NULL);
INSERT INTO `districts` VALUES (1217, 'Oyotun', '130108', 125, NULL, NULL);
INSERT INTO `districts` VALUES (1218, 'Picsi', '130109', 125, NULL, NULL);
INSERT INTO `districts` VALUES (1219, 'Pimentel', '130110', 125, NULL, NULL);
INSERT INTO `districts` VALUES (1220, 'Reque', '130111', 125, NULL, NULL);
INSERT INTO `districts` VALUES (1221, 'Jose Leonardo Ortiz', '130112', 125, NULL, NULL);
INSERT INTO `districts` VALUES (1222, 'Santa Rosa', '130113', 125, NULL, NULL);
INSERT INTO `districts` VALUES (1223, 'Saña', '130114', 125, NULL, NULL);
INSERT INTO `districts` VALUES (1224, 'La Victoria', '130115', 125, NULL, NULL);
INSERT INTO `districts` VALUES (1225, 'Cayalti', '130116', 125, NULL, NULL);
INSERT INTO `districts` VALUES (1226, 'Patapo', '130117', 125, NULL, NULL);
INSERT INTO `districts` VALUES (1227, 'Pomalca', '130118', 125, NULL, NULL);
INSERT INTO `districts` VALUES (1228, 'Pucala', '130119', 125, NULL, NULL);
INSERT INTO `districts` VALUES (1229, 'Tuman', '130120', 125, NULL, NULL);
INSERT INTO `districts` VALUES (1230, 'Ferreñafe', '130201', 126, NULL, NULL);
INSERT INTO `districts` VALUES (1231, 'Incahuasi', '130202', 126, NULL, NULL);
INSERT INTO `districts` VALUES (1232, 'Cañaris', '130203', 126, NULL, NULL);
INSERT INTO `districts` VALUES (1233, 'Pitipo', '130204', 126, NULL, NULL);
INSERT INTO `districts` VALUES (1234, 'Pueblo Nuevo', '130205', 126, NULL, NULL);
INSERT INTO `districts` VALUES (1235, 'Manuel Antonio Mesones Muro', '130206', 126, NULL, NULL);
INSERT INTO `districts` VALUES (1236, 'Lambayeque', '130301', 127, NULL, NULL);
INSERT INTO `districts` VALUES (1237, 'Chochope', '130302', 127, NULL, NULL);
INSERT INTO `districts` VALUES (1238, 'Illimo', '130303', 127, NULL, NULL);
INSERT INTO `districts` VALUES (1239, 'Jayanca', '130304', 127, NULL, NULL);
INSERT INTO `districts` VALUES (1240, 'Mochumi', '130305', 127, NULL, NULL);
INSERT INTO `districts` VALUES (1241, 'Morrope', '130306', 127, NULL, NULL);
INSERT INTO `districts` VALUES (1242, 'Motupe', '130307', 127, NULL, NULL);
INSERT INTO `districts` VALUES (1243, 'Olmos', '130308', 127, NULL, NULL);
INSERT INTO `districts` VALUES (1244, 'Pacora', '130309', 127, NULL, NULL);
INSERT INTO `districts` VALUES (1245, 'Salas', '130310', 127, NULL, NULL);
INSERT INTO `districts` VALUES (1246, 'San Jose', '130311', 127, NULL, NULL);
INSERT INTO `districts` VALUES (1247, 'Tucume', '130312', 127, NULL, NULL);
INSERT INTO `districts` VALUES (1248, 'Barranca', '140901', 128, NULL, NULL);
INSERT INTO `districts` VALUES (1249, 'Paramonga', '140902', 128, NULL, NULL);
INSERT INTO `districts` VALUES (1250, 'Pativilca', '140903', 128, NULL, NULL);
INSERT INTO `districts` VALUES (1251, 'Supe', '140904', 128, NULL, NULL);
INSERT INTO `districts` VALUES (1252, 'Supe Puerto', '140905', 128, NULL, NULL);
INSERT INTO `districts` VALUES (1253, 'Cajatambo', '140201', 129, NULL, NULL);
INSERT INTO `districts` VALUES (1254, 'Copa', '140205', 129, NULL, NULL);
INSERT INTO `districts` VALUES (1255, 'Gorgor', '140206', 129, NULL, NULL);
INSERT INTO `districts` VALUES (1256, 'Huancapon', '140207', 129, NULL, NULL);
INSERT INTO `districts` VALUES (1257, 'Manas', '140208', 129, NULL, NULL);
INSERT INTO `districts` VALUES (1258, 'San Vicente De Cañete', '140401', 130, NULL, NULL);
INSERT INTO `districts` VALUES (1259, 'Calango', '140402', 130, NULL, NULL);
INSERT INTO `districts` VALUES (1260, 'Cerro Azul', '140403', 130, NULL, NULL);
INSERT INTO `districts` VALUES (1261, 'Coayllo', '140404', 130, NULL, NULL);
INSERT INTO `districts` VALUES (1262, 'Chilca', '140405', 130, NULL, NULL);
INSERT INTO `districts` VALUES (1263, 'Imperial', '140406', 130, NULL, NULL);
INSERT INTO `districts` VALUES (1264, 'Lunahuana', '140407', 130, NULL, NULL);
INSERT INTO `districts` VALUES (1265, 'Mala', '140408', 130, NULL, NULL);
INSERT INTO `districts` VALUES (1266, 'Nuevo Imperial', '140409', 130, NULL, NULL);
INSERT INTO `districts` VALUES (1267, 'Pacaran', '140410', 130, NULL, NULL);
INSERT INTO `districts` VALUES (1268, 'Quilmana', '140411', 130, NULL, NULL);
INSERT INTO `districts` VALUES (1269, 'San Antonio', '140412', 130, NULL, NULL);
INSERT INTO `districts` VALUES (1270, 'San Luis', '140413', 130, NULL, NULL);
INSERT INTO `districts` VALUES (1271, 'Santa Cruz De Flores', '140414', 130, NULL, NULL);
INSERT INTO `districts` VALUES (1272, 'Zuñiga', '140415', 130, NULL, NULL);
INSERT INTO `districts` VALUES (1273, 'Asia', '140416', 130, NULL, NULL);
INSERT INTO `districts` VALUES (1274, 'Canta', '140301', 131, NULL, NULL);
INSERT INTO `districts` VALUES (1275, 'Arahuay', '140302', 131, NULL, NULL);
INSERT INTO `districts` VALUES (1276, 'Huamantanga', '140303', 131, NULL, NULL);
INSERT INTO `districts` VALUES (1277, 'Huaros', '140304', 131, NULL, NULL);
INSERT INTO `districts` VALUES (1278, 'Lachaqui', '140305', 131, NULL, NULL);
INSERT INTO `districts` VALUES (1279, 'San Buenaventura', '140306', 131, NULL, NULL);
INSERT INTO `districts` VALUES (1280, 'Santa Rosa De Quives', '140307', 131, NULL, NULL);
INSERT INTO `districts` VALUES (1281, 'Huaral', '140801', 132, NULL, NULL);
INSERT INTO `districts` VALUES (1282, 'Atavillos Alto', '140802', 132, NULL, NULL);
INSERT INTO `districts` VALUES (1283, 'Atavillos Bajo', '140803', 132, NULL, NULL);
INSERT INTO `districts` VALUES (1284, 'Aucallama', '140804', 132, NULL, NULL);
INSERT INTO `districts` VALUES (1285, 'Chancay', '140805', 132, NULL, NULL);
INSERT INTO `districts` VALUES (1286, 'Ihuari', '140806', 132, NULL, NULL);
INSERT INTO `districts` VALUES (1287, 'Lampian', '140807', 132, NULL, NULL);
INSERT INTO `districts` VALUES (1288, 'Pacaraos', '140808', 132, NULL, NULL);
INSERT INTO `districts` VALUES (1289, 'San Miguel De Acos', '140809', 132, NULL, NULL);
INSERT INTO `districts` VALUES (1290, 'Veintisiete De Noviembre', '140810', 132, NULL, NULL);
INSERT INTO `districts` VALUES (1291, 'Santa Cruz De Andamarca', '140811', 132, NULL, NULL);
INSERT INTO `districts` VALUES (1292, 'Sumbilca', '140812', 132, NULL, NULL);
INSERT INTO `districts` VALUES (1293, 'Matucana', '140601', 133, NULL, NULL);
INSERT INTO `districts` VALUES (1294, 'Antioquia', '140602', 133, NULL, NULL);
INSERT INTO `districts` VALUES (1295, 'Callahuanca', '140603', 133, NULL, NULL);
INSERT INTO `districts` VALUES (1296, 'Carampoma', '140604', 133, NULL, NULL);
INSERT INTO `districts` VALUES (1297, 'San Pedro De Casta', '140605', 133, NULL, NULL);
INSERT INTO `districts` VALUES (1298, 'Cuenca', '140606', 133, NULL, NULL);
INSERT INTO `districts` VALUES (1299, 'Chicla', '140607', 133, NULL, NULL);
INSERT INTO `districts` VALUES (1300, 'Huanza', '140608', 133, NULL, NULL);
INSERT INTO `districts` VALUES (1301, 'Huarochiri', '140609', 133, NULL, NULL);
INSERT INTO `districts` VALUES (1302, 'Lahuaytambo', '140610', 133, NULL, NULL);
INSERT INTO `districts` VALUES (1303, 'Langa', '140611', 133, NULL, NULL);
INSERT INTO `districts` VALUES (1304, 'Mariatana', '140612', 133, NULL, NULL);
INSERT INTO `districts` VALUES (1305, 'Ricardo Palma', '140613', 133, NULL, NULL);
INSERT INTO `districts` VALUES (1306, 'San Andres De Tupicocha', '140614', 133, NULL, NULL);
INSERT INTO `districts` VALUES (1307, 'San Antonio', '140615', 133, NULL, NULL);
INSERT INTO `districts` VALUES (1308, 'San Bartolome', '140616', 133, NULL, NULL);
INSERT INTO `districts` VALUES (1309, 'San Damian', '140617', 133, NULL, NULL);
INSERT INTO `districts` VALUES (1310, 'Sangallaya', '140618', 133, NULL, NULL);
INSERT INTO `districts` VALUES (1311, 'San Juan De Tantaranche', '140619', 133, NULL, NULL);
INSERT INTO `districts` VALUES (1312, 'San Lorenzo De Quinti', '140620', 133, NULL, NULL);
INSERT INTO `districts` VALUES (1313, 'San Mateo', '140621', 133, NULL, NULL);
INSERT INTO `districts` VALUES (1314, 'San Mateo De Otao', '140622', 133, NULL, NULL);
INSERT INTO `districts` VALUES (1315, 'San Pedro De Huancayre', '140623', 133, NULL, NULL);
INSERT INTO `districts` VALUES (1316, 'Santa Cruz De Cocachacra', '140624', 133, NULL, NULL);
INSERT INTO `districts` VALUES (1317, 'Santa Eulalia', '140625', 133, NULL, NULL);
INSERT INTO `districts` VALUES (1318, 'Santiago De Anchucaya', '140626', 133, NULL, NULL);
INSERT INTO `districts` VALUES (1319, 'Santiago De Tuna', '140627', 133, NULL, NULL);
INSERT INTO `districts` VALUES (1320, 'Santo Domingo De Los Olleros', '140628', 133, NULL, NULL);
INSERT INTO `districts` VALUES (1321, 'Surco', '140629', 133, NULL, NULL);
INSERT INTO `districts` VALUES (1322, 'Huachupampa', '140630', 133, NULL, NULL);
INSERT INTO `districts` VALUES (1323, 'Laraos', '140631', 133, NULL, NULL);
INSERT INTO `districts` VALUES (1324, 'San Juan De Iris', '140632', 133, NULL, NULL);
INSERT INTO `districts` VALUES (1325, 'Huacho', '140501', 134, NULL, NULL);
INSERT INTO `districts` VALUES (1326, 'Ambar', '140502', 134, NULL, NULL);
INSERT INTO `districts` VALUES (1327, 'Caleta De Carquin', '140504', 134, NULL, NULL);
INSERT INTO `districts` VALUES (1328, 'Checras', '140505', 134, NULL, NULL);
INSERT INTO `districts` VALUES (1329, 'Hualmay', '140506', 134, NULL, NULL);
INSERT INTO `districts` VALUES (1330, 'Huaura', '140507', 134, NULL, NULL);
INSERT INTO `districts` VALUES (1331, 'Leoncio Prado', '140508', 134, NULL, NULL);
INSERT INTO `districts` VALUES (1332, 'Paccho', '140509', 134, NULL, NULL);
INSERT INTO `districts` VALUES (1333, 'Santa Leonor', '140511', 134, NULL, NULL);
INSERT INTO `districts` VALUES (1334, 'Santa Maria', '140512', 134, NULL, NULL);
INSERT INTO `districts` VALUES (1335, 'Sayan', '140513', 134, NULL, NULL);
INSERT INTO `districts` VALUES (1336, 'Vegueta', '140516', 134, NULL, NULL);
INSERT INTO `districts` VALUES (1337, 'Lima', '140101', 135, NULL, NULL);
INSERT INTO `districts` VALUES (1338, 'Ancon', '140102', 135, NULL, NULL);
INSERT INTO `districts` VALUES (1339, 'Ate', '140103', 135, NULL, NULL);
INSERT INTO `districts` VALUES (1340, 'Breña', '140104', 135, NULL, NULL);
INSERT INTO `districts` VALUES (1341, 'Carabayllo', '140105', 135, NULL, NULL);
INSERT INTO `districts` VALUES (1342, 'Comas', '140106', 135, NULL, NULL);
INSERT INTO `districts` VALUES (1343, 'Chaclacayo', '140107', 135, NULL, NULL);
INSERT INTO `districts` VALUES (1344, 'Chorrillos', '140108', 135, NULL, NULL);
INSERT INTO `districts` VALUES (1345, 'La Victoria', '140109', 135, NULL, NULL);
INSERT INTO `districts` VALUES (1346, 'La Molina', '140110', 135, NULL, NULL);
INSERT INTO `districts` VALUES (1347, 'Lince', '140111', 135, NULL, NULL);
INSERT INTO `districts` VALUES (1348, 'Lurigancho', '140112', 135, NULL, NULL);
INSERT INTO `districts` VALUES (1349, 'Lurin', '140113', 135, NULL, NULL);
INSERT INTO `districts` VALUES (1350, 'Magdalena Del Mar', '140114', 135, NULL, NULL);
INSERT INTO `districts` VALUES (1351, 'Miraflores', '140115', 135, NULL, NULL);
INSERT INTO `districts` VALUES (1352, 'Pachacamac', '140116', 135, NULL, NULL);
INSERT INTO `districts` VALUES (1353, 'Pueblo Libre', '140117', 135, NULL, NULL);
INSERT INTO `districts` VALUES (1354, 'Pucusana', '140118', 135, NULL, NULL);
INSERT INTO `districts` VALUES (1355, 'Puente Piedra', '140119', 135, NULL, NULL);
INSERT INTO `districts` VALUES (1356, 'Punta Hermosa', '140120', 135, NULL, NULL);
INSERT INTO `districts` VALUES (1357, 'Punta Negra', '140121', 135, NULL, NULL);
INSERT INTO `districts` VALUES (1358, 'Rimac', '140122', 135, NULL, NULL);
INSERT INTO `districts` VALUES (1359, 'San Bartolo', '140123', 135, NULL, NULL);
INSERT INTO `districts` VALUES (1360, 'San Isidro', '140124', 135, NULL, NULL);
INSERT INTO `districts` VALUES (1361, 'Barranco', '140125', 135, NULL, NULL);
INSERT INTO `districts` VALUES (1362, 'San Martin De Porres', '140126', 135, NULL, NULL);
INSERT INTO `districts` VALUES (1363, 'San Miguel', '140127', 135, NULL, NULL);
INSERT INTO `districts` VALUES (1364, 'Santa Maria Del Mar', '140128', 135, NULL, NULL);
INSERT INTO `districts` VALUES (1365, 'Santa Rosa', '140129', 135, NULL, NULL);
INSERT INTO `districts` VALUES (1366, 'Santiago De Surco', '140130', 135, NULL, NULL);
INSERT INTO `districts` VALUES (1367, 'Surquillo', '140131', 135, NULL, NULL);
INSERT INTO `districts` VALUES (1368, 'Villa Maria Del Triunfo', '140132', 135, NULL, NULL);
INSERT INTO `districts` VALUES (1369, 'Jesus Maria', '140133', 135, NULL, NULL);
INSERT INTO `districts` VALUES (1370, 'Independencia', '140134', 135, NULL, NULL);
INSERT INTO `districts` VALUES (1371, 'El Agustino', '140135', 135, NULL, NULL);
INSERT INTO `districts` VALUES (1372, 'San Juan De Miraflores', '140136', 135, NULL, NULL);
INSERT INTO `districts` VALUES (1373, 'San Juan De Lurigancho', '140137', 135, NULL, NULL);
INSERT INTO `districts` VALUES (1374, 'San Luis', '140138', 135, NULL, NULL);
INSERT INTO `districts` VALUES (1375, 'Cieneguilla', '140139', 135, NULL, NULL);
INSERT INTO `districts` VALUES (1376, 'San Borja', '140140', 135, NULL, NULL);
INSERT INTO `districts` VALUES (1377, 'Villa El Salvador', '140141', 135, NULL, NULL);
INSERT INTO `districts` VALUES (1378, 'Los Olivos', '140142', 135, NULL, NULL);
INSERT INTO `districts` VALUES (1379, 'Santa Anita', '140143', 135, NULL, NULL);
INSERT INTO `districts` VALUES (1380, 'Oyon', '141001', 136, NULL, NULL);
INSERT INTO `districts` VALUES (1381, 'Navan', '141002', 136, NULL, NULL);
INSERT INTO `districts` VALUES (1382, 'Caujul', '141003', 136, NULL, NULL);
INSERT INTO `districts` VALUES (1383, 'Andajes', '141004', 136, NULL, NULL);
INSERT INTO `districts` VALUES (1384, 'Pachangara', '141005', 136, NULL, NULL);
INSERT INTO `districts` VALUES (1385, 'Cochamarca', '141006', 136, NULL, NULL);
INSERT INTO `districts` VALUES (1386, 'Yauyos', '140701', 137, NULL, NULL);
INSERT INTO `districts` VALUES (1387, 'Alis', '140702', 137, NULL, NULL);
INSERT INTO `districts` VALUES (1388, 'Ayauca', '140703', 137, NULL, NULL);
INSERT INTO `districts` VALUES (1389, 'Ayaviri', '140704', 137, NULL, NULL);
INSERT INTO `districts` VALUES (1390, 'Azangaro', '140705', 137, NULL, NULL);
INSERT INTO `districts` VALUES (1391, 'Cacra', '140706', 137, NULL, NULL);
INSERT INTO `districts` VALUES (1392, 'Carania', '140707', 137, NULL, NULL);
INSERT INTO `districts` VALUES (1393, 'Cochas', '140708', 137, NULL, NULL);
INSERT INTO `districts` VALUES (1394, 'Colonia', '140709', 137, NULL, NULL);
INSERT INTO `districts` VALUES (1395, 'Chocos', '140710', 137, NULL, NULL);
INSERT INTO `districts` VALUES (1396, 'Huampara', '140711', 137, NULL, NULL);
INSERT INTO `districts` VALUES (1397, 'Huancaya', '140712', 137, NULL, NULL);
INSERT INTO `districts` VALUES (1398, 'Huangascar', '140713', 137, NULL, NULL);
INSERT INTO `districts` VALUES (1399, 'Huantan', '140714', 137, NULL, NULL);
INSERT INTO `districts` VALUES (1400, 'Huañec', '140715', 137, NULL, NULL);
INSERT INTO `districts` VALUES (1401, 'Laraos', '140716', 137, NULL, NULL);
INSERT INTO `districts` VALUES (1402, 'Lincha', '140717', 137, NULL, NULL);
INSERT INTO `districts` VALUES (1403, 'Miraflores', '140718', 137, NULL, NULL);
INSERT INTO `districts` VALUES (1404, 'Omas', '140719', 137, NULL, NULL);
INSERT INTO `districts` VALUES (1405, 'Quinches', '140720', 137, NULL, NULL);
INSERT INTO `districts` VALUES (1406, 'Quinocay', '140721', 137, NULL, NULL);
INSERT INTO `districts` VALUES (1407, 'San Joaquin', '140722', 137, NULL, NULL);
INSERT INTO `districts` VALUES (1408, 'San Pedro De Pilas', '140723', 137, NULL, NULL);
INSERT INTO `districts` VALUES (1409, 'Tanta', '140724', 137, NULL, NULL);
INSERT INTO `districts` VALUES (1410, 'Tauripampa', '140725', 137, NULL, NULL);
INSERT INTO `districts` VALUES (1411, 'Tupe', '140726', 137, NULL, NULL);
INSERT INTO `districts` VALUES (1412, 'Tomas', '140727', 137, NULL, NULL);
INSERT INTO `districts` VALUES (1413, 'Viñac', '140728', 137, NULL, NULL);
INSERT INTO `districts` VALUES (1414, 'Vitis', '140729', 137, NULL, NULL);
INSERT INTO `districts` VALUES (1415, 'Hongos', '140730', 137, NULL, NULL);
INSERT INTO `districts` VALUES (1416, 'Madean', '140731', 137, NULL, NULL);
INSERT INTO `districts` VALUES (1417, 'Putinza', '140732', 137, NULL, NULL);
INSERT INTO `districts` VALUES (1418, 'Catahuasi', '140733', 137, NULL, NULL);
INSERT INTO `districts` VALUES (1419, 'Yurimaguas', '150201', 138, NULL, NULL);
INSERT INTO `districts` VALUES (1420, 'Balsa Puerto', '150202', 138, NULL, NULL);
INSERT INTO `districts` VALUES (1421, 'Jeberos', '150205', 138, NULL, NULL);
INSERT INTO `districts` VALUES (1422, 'Lagunas', '150206', 138, NULL, NULL);
INSERT INTO `districts` VALUES (1423, 'Santa Cruz', '150210', 138, NULL, NULL);
INSERT INTO `districts` VALUES (1424, 'Teniente Cesar Lopez Rojas', '150211', 138, NULL, NULL);
INSERT INTO `districts` VALUES (1425, 'Barranca', '150701', 139, NULL, NULL);
INSERT INTO `districts` VALUES (1426, 'Andoas', '150702', 139, NULL, NULL);
INSERT INTO `districts` VALUES (1427, 'Cahuapanas', '150703', 139, NULL, NULL);
INSERT INTO `districts` VALUES (1428, 'Manseriche', '150704', 139, NULL, NULL);
INSERT INTO `districts` VALUES (1429, 'Morona', '150705', 139, NULL, NULL);
INSERT INTO `districts` VALUES (1430, 'Pastaza', '150706', 139, NULL, NULL);
INSERT INTO `districts` VALUES (1431, 'Nauta', '150301', 140, NULL, NULL);
INSERT INTO `districts` VALUES (1432, 'Parinari', '150302', 140, NULL, NULL);
INSERT INTO `districts` VALUES (1433, 'Tigre', '150303', 140, NULL, NULL);
INSERT INTO `districts` VALUES (1434, 'Urarinas', '150304', 140, NULL, NULL);
INSERT INTO `districts` VALUES (1435, 'Trompeteros', '150305', 140, NULL, NULL);
INSERT INTO `districts` VALUES (1436, 'Ramon Castilla', '150601', 141, NULL, NULL);
INSERT INTO `districts` VALUES (1437, 'Pebas', '150602', 141, NULL, NULL);
INSERT INTO `districts` VALUES (1438, 'Yavari', '150603', 141, NULL, NULL);
INSERT INTO `districts` VALUES (1439, 'San Pablo', '150604', 141, NULL, NULL);
INSERT INTO `districts` VALUES (1440, 'Iquitos', '150101', 142, NULL, NULL);
INSERT INTO `districts` VALUES (1441, 'Alto Nanay', '150102', 142, NULL, NULL);
INSERT INTO `districts` VALUES (1442, 'Fernando Lores', '150103', 142, NULL, NULL);
INSERT INTO `districts` VALUES (1443, 'Las Amazonas', '150104', 142, NULL, NULL);
INSERT INTO `districts` VALUES (1444, 'Mazan', '150105', 142, NULL, NULL);
INSERT INTO `districts` VALUES (1445, 'Napo', '150106', 142, NULL, NULL);
INSERT INTO `districts` VALUES (1446, 'Putumayo', '150107', 142, NULL, NULL);
INSERT INTO `districts` VALUES (1447, 'Torres Causana', '150108', 142, NULL, NULL);
INSERT INTO `districts` VALUES (1448, 'Indiana', '150110', 142, NULL, NULL);
INSERT INTO `districts` VALUES (1449, 'Punchana', '150111', 142, NULL, NULL);
INSERT INTO `districts` VALUES (1450, 'Belen', '150112', 142, NULL, NULL);
INSERT INTO `districts` VALUES (1451, 'San Juan Bautista', '150113', 142, NULL, NULL);
INSERT INTO `districts` VALUES (1452, 'Tnte Manuel Clavero', '150114', 142, NULL, NULL);
INSERT INTO `districts` VALUES (1453, 'Requena', '150401', 143, NULL, NULL);
INSERT INTO `districts` VALUES (1454, 'Alto Tapiche', '150402', 143, NULL, NULL);
INSERT INTO `districts` VALUES (1455, 'Capelo', '150403', 143, NULL, NULL);
INSERT INTO `districts` VALUES (1456, 'Emilio San Martin', '150404', 143, NULL, NULL);
INSERT INTO `districts` VALUES (1457, 'Maquia', '150405', 143, NULL, NULL);
INSERT INTO `districts` VALUES (1458, 'Puinahua', '150406', 143, NULL, NULL);
INSERT INTO `districts` VALUES (1459, 'Saquena', '150407', 143, NULL, NULL);
INSERT INTO `districts` VALUES (1460, 'Soplin', '150408', 143, NULL, NULL);
INSERT INTO `districts` VALUES (1461, 'Tapiche', '150409', 143, NULL, NULL);
INSERT INTO `districts` VALUES (1462, 'Jenaro Herrera', '150410', 143, NULL, NULL);
INSERT INTO `districts` VALUES (1463, 'Yaquerana', '150411', 143, NULL, NULL);
INSERT INTO `districts` VALUES (1464, 'Contamana', '150501', 144, NULL, NULL);
INSERT INTO `districts` VALUES (1465, 'Vargas Guerra', '150502', 144, NULL, NULL);
INSERT INTO `districts` VALUES (1466, 'Padre Marquez', '150503', 144, NULL, NULL);
INSERT INTO `districts` VALUES (1467, 'Pampa Hermosa', '150504', 144, NULL, NULL);
INSERT INTO `districts` VALUES (1468, 'Sarayacu', '150505', 144, NULL, NULL);
INSERT INTO `districts` VALUES (1469, 'Inahuaya', '150506', 144, NULL, NULL);
INSERT INTO `districts` VALUES (1470, 'Manu', '160201', 145, NULL, NULL);
INSERT INTO `districts` VALUES (1471, 'Fitzcarrald', '160202', 145, NULL, NULL);
INSERT INTO `districts` VALUES (1472, 'Madre De Dios', '160203', 145, NULL, NULL);
INSERT INTO `districts` VALUES (1473, 'Huepetuhe', '160204', 145, NULL, NULL);
INSERT INTO `districts` VALUES (1474, 'Iñapari', '160301', 146, NULL, NULL);
INSERT INTO `districts` VALUES (1475, 'Iberia', '160302', 146, NULL, NULL);
INSERT INTO `districts` VALUES (1476, 'Tahuamanu', '160303', 146, NULL, NULL);
INSERT INTO `districts` VALUES (1477, 'Tambopata', '160101', 147, NULL, NULL);
INSERT INTO `districts` VALUES (1478, 'Inambari', '160102', 147, NULL, NULL);
INSERT INTO `districts` VALUES (1479, 'Las Piedras', '160103', 147, NULL, NULL);
INSERT INTO `districts` VALUES (1480, 'Laberinto', '160104', 147, NULL, NULL);
INSERT INTO `districts` VALUES (1481, 'Omate', '170201', 148, NULL, NULL);
INSERT INTO `districts` VALUES (1482, 'Coalaque', '170202', 148, NULL, NULL);
INSERT INTO `districts` VALUES (1483, 'Chojata', '170203', 148, NULL, NULL);
INSERT INTO `districts` VALUES (1484, 'Ichuña', '170204', 148, NULL, NULL);
INSERT INTO `districts` VALUES (1485, 'La Capilla', '170205', 148, NULL, NULL);
INSERT INTO `districts` VALUES (1486, 'Lloque', '170206', 148, NULL, NULL);
INSERT INTO `districts` VALUES (1487, 'Matalaque', '170207', 148, NULL, NULL);
INSERT INTO `districts` VALUES (1488, 'Puquina', '170208', 148, NULL, NULL);
INSERT INTO `districts` VALUES (1489, 'Quinistaquillas', '170209', 148, NULL, NULL);
INSERT INTO `districts` VALUES (1490, 'Ubinas', '170210', 148, NULL, NULL);
INSERT INTO `districts` VALUES (1491, 'Yunga', '170211', 148, NULL, NULL);
INSERT INTO `districts` VALUES (1492, 'Ilo', '170301', 149, NULL, NULL);
INSERT INTO `districts` VALUES (1493, 'El Algarrobal', '170302', 149, NULL, NULL);
INSERT INTO `districts` VALUES (1494, 'Pacocha', '170303', 149, NULL, NULL);
INSERT INTO `districts` VALUES (1495, 'Moquegua', '170101', 150, NULL, NULL);
INSERT INTO `districts` VALUES (1496, 'Carumas', '170102', 150, NULL, NULL);
INSERT INTO `districts` VALUES (1497, 'Cuchumbaya', '170103', 150, NULL, NULL);
INSERT INTO `districts` VALUES (1498, 'San Cristobal', '170104', 150, NULL, NULL);
INSERT INTO `districts` VALUES (1499, 'Torata', '170105', 150, NULL, NULL);
INSERT INTO `districts` VALUES (1500, 'Samegua', '170106', 150, NULL, NULL);
INSERT INTO `districts` VALUES (1501, 'Yanahuanca', '180201', 151, NULL, NULL);
INSERT INTO `districts` VALUES (1502, 'Chacayan', '180202', 151, NULL, NULL);
INSERT INTO `districts` VALUES (1503, 'Goyllarisquizga', '180203', 151, NULL, NULL);
INSERT INTO `districts` VALUES (1504, 'Paucar', '180204', 151, NULL, NULL);
INSERT INTO `districts` VALUES (1505, 'San Pedro De Pillao', '180205', 151, NULL, NULL);
INSERT INTO `districts` VALUES (1506, 'Santa Ana De Tusi', '180206', 151, NULL, NULL);
INSERT INTO `districts` VALUES (1507, 'Tapuc', '180207', 151, NULL, NULL);
INSERT INTO `districts` VALUES (1508, 'Vilcabamba', '180208', 151, NULL, NULL);
INSERT INTO `districts` VALUES (1509, 'Oxapampa', '180301', 152, NULL, NULL);
INSERT INTO `districts` VALUES (1510, 'Chontabamba', '180302', 152, NULL, NULL);
INSERT INTO `districts` VALUES (1511, 'Huancabamba', '180303', 152, NULL, NULL);
INSERT INTO `districts` VALUES (1512, 'Puerto Bermudez', '180304', 152, NULL, NULL);
INSERT INTO `districts` VALUES (1513, 'Villa Rica', '180305', 152, NULL, NULL);
INSERT INTO `districts` VALUES (1514, 'Pozuzo', '180306', 152, NULL, NULL);
INSERT INTO `districts` VALUES (1515, 'Palcazu', '180307', 152, NULL, NULL);
INSERT INTO `districts` VALUES (1516, 'Chaupimarca', '180101', 153, NULL, NULL);
INSERT INTO `districts` VALUES (1517, 'Huachon', '180103', 153, NULL, NULL);
INSERT INTO `districts` VALUES (1518, 'Huariaca', '180104', 153, NULL, NULL);
INSERT INTO `districts` VALUES (1519, 'Huayllay', '180105', 153, NULL, NULL);
INSERT INTO `districts` VALUES (1520, 'Ninacaca', '180106', 153, NULL, NULL);
INSERT INTO `districts` VALUES (1521, 'Pallanchacra', '180107', 153, NULL, NULL);
INSERT INTO `districts` VALUES (1522, 'Paucartambo', '180108', 153, NULL, NULL);
INSERT INTO `districts` VALUES (1523, 'San Francisco De Asis De Yarus', '180109', 153, NULL, NULL);
INSERT INTO `districts` VALUES (1524, 'Simon Bolivar', '180110', 153, NULL, NULL);
INSERT INTO `districts` VALUES (1525, 'Ticlacayan', '180111', 153, NULL, NULL);
INSERT INTO `districts` VALUES (1526, 'Tinyahuarco', '180112', 153, NULL, NULL);
INSERT INTO `districts` VALUES (1527, 'Vicco', '180113', 153, NULL, NULL);
INSERT INTO `districts` VALUES (1528, 'Yanacancha', '180114', 153, NULL, NULL);
INSERT INTO `districts` VALUES (1529, 'Ayabaca', '190201', 154, NULL, NULL);
INSERT INTO `districts` VALUES (1530, 'Frias', '190202', 154, NULL, NULL);
INSERT INTO `districts` VALUES (1531, 'Lagunas', '190203', 154, NULL, NULL);
INSERT INTO `districts` VALUES (1532, 'Montero', '190204', 154, NULL, NULL);
INSERT INTO `districts` VALUES (1533, 'Pacaipampa', '190205', 154, NULL, NULL);
INSERT INTO `districts` VALUES (1534, 'Sapillica', '190206', 154, NULL, NULL);
INSERT INTO `districts` VALUES (1535, 'Sicchez', '190207', 154, NULL, NULL);
INSERT INTO `districts` VALUES (1536, 'Suyo', '190208', 154, NULL, NULL);
INSERT INTO `districts` VALUES (1537, 'Jilili', '190209', 154, NULL, NULL);
INSERT INTO `districts` VALUES (1538, 'Paimas', '190210', 154, NULL, NULL);
INSERT INTO `districts` VALUES (1539, 'Huancabamba', '190301', 155, NULL, NULL);
INSERT INTO `districts` VALUES (1540, 'Canchaque', '190302', 155, NULL, NULL);
INSERT INTO `districts` VALUES (1541, 'Huarmaca', '190303', 155, NULL, NULL);
INSERT INTO `districts` VALUES (1542, 'Sondor', '190304', 155, NULL, NULL);
INSERT INTO `districts` VALUES (1543, 'Sondorillo', '190305', 155, NULL, NULL);
INSERT INTO `districts` VALUES (1544, 'El Carmen De La Frontera', '190306', 155, NULL, NULL);
INSERT INTO `districts` VALUES (1545, 'San Miguel De El Faique', '190307', 155, NULL, NULL);
INSERT INTO `districts` VALUES (1546, 'Lalaquiz', '190308', 155, NULL, NULL);
INSERT INTO `districts` VALUES (1547, 'Chulucanas', '190401', 156, NULL, NULL);
INSERT INTO `districts` VALUES (1548, 'Buenos Aires', '190402', 156, NULL, NULL);
INSERT INTO `districts` VALUES (1549, 'Chalaco', '190403', 156, NULL, NULL);
INSERT INTO `districts` VALUES (1550, 'Morropon', '190404', 156, NULL, NULL);
INSERT INTO `districts` VALUES (1551, 'Salitral', '190405', 156, NULL, NULL);
INSERT INTO `districts` VALUES (1552, 'Santa Catalina De Mossa', '190406', 156, NULL, NULL);
INSERT INTO `districts` VALUES (1553, 'Santo Domingo', '190407', 156, NULL, NULL);
INSERT INTO `districts` VALUES (1554, 'La Matanza', '190408', 156, NULL, NULL);
INSERT INTO `districts` VALUES (1555, 'Yamango', '190409', 156, NULL, NULL);
INSERT INTO `districts` VALUES (1556, 'San Juan De Bigote', '190410', 156, NULL, NULL);
INSERT INTO `districts` VALUES (1557, 'Paita', '190501', 157, NULL, NULL);
INSERT INTO `districts` VALUES (1558, 'Amotape', '190502', 157, NULL, NULL);
INSERT INTO `districts` VALUES (1559, 'Arenal', '190503', 157, NULL, NULL);
INSERT INTO `districts` VALUES (1560, 'La Huaca', '190504', 157, NULL, NULL);
INSERT INTO `districts` VALUES (1561, 'Colan', '190505', 157, NULL, NULL);
INSERT INTO `districts` VALUES (1562, 'Tamarindo', '190506', 157, NULL, NULL);
INSERT INTO `districts` VALUES (1563, 'Vichayal', '190507', 157, NULL, NULL);
INSERT INTO `districts` VALUES (1564, 'Piura', '190101', 158, NULL, NULL);
INSERT INTO `districts` VALUES (1565, 'Castilla', '190103', 158, NULL, NULL);
INSERT INTO `districts` VALUES (1566, 'Catacaos', '190104', 158, NULL, NULL);
INSERT INTO `districts` VALUES (1567, 'La Arena', '190105', 158, NULL, NULL);
INSERT INTO `districts` VALUES (1568, 'La Union', '190106', 158, NULL, NULL);
INSERT INTO `districts` VALUES (1569, 'Las Lomas', '190107', 158, NULL, NULL);
INSERT INTO `districts` VALUES (1570, 'Tambo Grande', '190109', 158, NULL, NULL);
INSERT INTO `districts` VALUES (1571, 'Cura Mori', '190113', 158, NULL, NULL);
INSERT INTO `districts` VALUES (1572, 'El Tallan', '190114', 158, NULL, NULL);
INSERT INTO `districts` VALUES (1573, 'Sechura', '190801', 159, NULL, NULL);
INSERT INTO `districts` VALUES (1574, 'Vice', '190802', 159, NULL, NULL);
INSERT INTO `districts` VALUES (1575, 'Bernal', '190803', 159, NULL, NULL);
INSERT INTO `districts` VALUES (1576, 'Bellavista De La Union', '190804', 159, NULL, NULL);
INSERT INTO `districts` VALUES (1577, 'Cristo Nos Valga', '190805', 159, NULL, NULL);
INSERT INTO `districts` VALUES (1578, 'Rinconada-llicuar', '190806', 159, NULL, NULL);
INSERT INTO `districts` VALUES (1579, 'Sullana', '190601', 160, NULL, NULL);
INSERT INTO `districts` VALUES (1580, 'Bellavista', '190602', 160, NULL, NULL);
INSERT INTO `districts` VALUES (1581, 'Lancones', '190603', 160, NULL, NULL);
INSERT INTO `districts` VALUES (1582, 'Marcavelica', '190604', 160, NULL, NULL);
INSERT INTO `districts` VALUES (1583, 'Miguel Checa', '190605', 160, NULL, NULL);
INSERT INTO `districts` VALUES (1584, 'Querecotillo', '190606', 160, NULL, NULL);
INSERT INTO `districts` VALUES (1585, 'Salitral', '190607', 160, NULL, NULL);
INSERT INTO `districts` VALUES (1586, 'Ignacio Escudero', '190608', 160, NULL, NULL);
INSERT INTO `districts` VALUES (1587, 'Pariñas', '190701', 161, NULL, NULL);
INSERT INTO `districts` VALUES (1588, 'El Alto', '190702', 161, NULL, NULL);
INSERT INTO `districts` VALUES (1589, 'La Brea', '190703', 161, NULL, NULL);
INSERT INTO `districts` VALUES (1590, 'Lobitos', '190704', 161, NULL, NULL);
INSERT INTO `districts` VALUES (1591, 'Mancora', '190705', 161, NULL, NULL);
INSERT INTO `districts` VALUES (1592, 'Los Organos', '190706', 161, NULL, NULL);
INSERT INTO `districts` VALUES (1593, 'Azangaro', '200201', 162, NULL, NULL);
INSERT INTO `districts` VALUES (1594, 'Achaya', '200202', 162, NULL, NULL);
INSERT INTO `districts` VALUES (1595, 'Arapa', '200203', 162, NULL, NULL);
INSERT INTO `districts` VALUES (1596, 'Asillo', '200204', 162, NULL, NULL);
INSERT INTO `districts` VALUES (1597, 'Caminaca', '200205', 162, NULL, NULL);
INSERT INTO `districts` VALUES (1598, 'Chupa', '200206', 162, NULL, NULL);
INSERT INTO `districts` VALUES (1599, 'Jose Domingo Choquehuanca', '200207', 162, NULL, NULL);
INSERT INTO `districts` VALUES (1600, 'Muñani', '200208', 162, NULL, NULL);
INSERT INTO `districts` VALUES (1601, 'Potoni', '200210', 162, NULL, NULL);
INSERT INTO `districts` VALUES (1602, 'Saman', '200212', 162, NULL, NULL);
INSERT INTO `districts` VALUES (1603, 'San Anton', '200213', 162, NULL, NULL);
INSERT INTO `districts` VALUES (1604, 'San Jose', '200214', 162, NULL, NULL);
INSERT INTO `districts` VALUES (1605, 'San Juan De Salinas', '200215', 162, NULL, NULL);
INSERT INTO `districts` VALUES (1606, 'Santiago De Pupuja', '200216', 162, NULL, NULL);
INSERT INTO `districts` VALUES (1607, 'Tirapata', '200217', 162, NULL, NULL);
INSERT INTO `districts` VALUES (1608, 'Macusani', '200301', 163, NULL, NULL);
INSERT INTO `districts` VALUES (1609, 'Ajoyani', '200302', 163, NULL, NULL);
INSERT INTO `districts` VALUES (1610, 'Ayapata', '200303', 163, NULL, NULL);
INSERT INTO `districts` VALUES (1611, 'Coasa', '200304', 163, NULL, NULL);
INSERT INTO `districts` VALUES (1612, 'Corani', '200305', 163, NULL, NULL);
INSERT INTO `districts` VALUES (1613, 'Crucero', '200306', 163, NULL, NULL);
INSERT INTO `districts` VALUES (1614, 'Ituata', '200307', 163, NULL, NULL);
INSERT INTO `districts` VALUES (1615, 'Ollachea', '200308', 163, NULL, NULL);
INSERT INTO `districts` VALUES (1616, 'San Gaban', '200309', 163, NULL, NULL);
INSERT INTO `districts` VALUES (1617, 'Usicayos', '200310', 163, NULL, NULL);
INSERT INTO `districts` VALUES (1618, 'Juli', '200401', 164, NULL, NULL);
INSERT INTO `districts` VALUES (1619, 'Desaguadero', '200402', 164, NULL, NULL);
INSERT INTO `districts` VALUES (1620, 'Huacullani', '200403', 164, NULL, NULL);
INSERT INTO `districts` VALUES (1621, 'Pisacoma', '200406', 164, NULL, NULL);
INSERT INTO `districts` VALUES (1622, 'Pomata', '200407', 164, NULL, NULL);
INSERT INTO `districts` VALUES (1623, 'Zepita', '200410', 164, NULL, NULL);
INSERT INTO `districts` VALUES (1624, 'Kelluyo', '200412', 164, NULL, NULL);
INSERT INTO `districts` VALUES (1625, 'Ilave', '201201', 165, NULL, NULL);
INSERT INTO `districts` VALUES (1626, 'Pilcuyo', '201202', 165, NULL, NULL);
INSERT INTO `districts` VALUES (1627, 'Santa Rosa', '201203', 165, NULL, NULL);
INSERT INTO `districts` VALUES (1628, 'Capaso', '201204', 165, NULL, NULL);
INSERT INTO `districts` VALUES (1629, 'Conduriri', '201205', 165, NULL, NULL);
INSERT INTO `districts` VALUES (1630, 'Huancane', '200501', 166, NULL, NULL);
INSERT INTO `districts` VALUES (1631, 'Cojata', '200502', 166, NULL, NULL);
INSERT INTO `districts` VALUES (1632, 'Inchupalla', '200504', 166, NULL, NULL);
INSERT INTO `districts` VALUES (1633, 'Pusi', '200506', 166, NULL, NULL);
INSERT INTO `districts` VALUES (1634, 'Rosaspata', '200507', 166, NULL, NULL);
INSERT INTO `districts` VALUES (1635, 'Taraco', '200508', 166, NULL, NULL);
INSERT INTO `districts` VALUES (1636, 'Vilque Chico', '200509', 166, NULL, NULL);
INSERT INTO `districts` VALUES (1637, 'Huatasani', '200511', 166, NULL, NULL);
INSERT INTO `districts` VALUES (1638, 'Lampa', '200601', 167, NULL, NULL);
INSERT INTO `districts` VALUES (1639, 'Cabanilla', '200602', 167, NULL, NULL);
INSERT INTO `districts` VALUES (1640, 'Calapuja', '200603', 167, NULL, NULL);
INSERT INTO `districts` VALUES (1641, 'Nicasio', '200604', 167, NULL, NULL);
INSERT INTO `districts` VALUES (1642, 'Ocuviri', '200605', 167, NULL, NULL);
INSERT INTO `districts` VALUES (1643, 'Palca', '200606', 167, NULL, NULL);
INSERT INTO `districts` VALUES (1644, 'Paratia', '200607', 167, NULL, NULL);
INSERT INTO `districts` VALUES (1645, 'Pucara', '200608', 167, NULL, NULL);
INSERT INTO `districts` VALUES (1646, 'Santa Lucia', '200609', 167, NULL, NULL);
INSERT INTO `districts` VALUES (1647, 'Vilavila', '200610', 167, NULL, NULL);
INSERT INTO `districts` VALUES (1648, 'Ayaviri', '200701', 168, NULL, NULL);
INSERT INTO `districts` VALUES (1649, 'Antauta', '200702', 168, NULL, NULL);
INSERT INTO `districts` VALUES (1650, 'Cupi', '200703', 168, NULL, NULL);
INSERT INTO `districts` VALUES (1651, 'Llalli', '200704', 168, NULL, NULL);
INSERT INTO `districts` VALUES (1652, 'Macari', '200705', 168, NULL, NULL);
INSERT INTO `districts` VALUES (1653, 'Nuñoa', '200706', 168, NULL, NULL);
INSERT INTO `districts` VALUES (1654, 'Orurillo', '200707', 168, NULL, NULL);
INSERT INTO `districts` VALUES (1655, 'Santa Rosa', '200708', 168, NULL, NULL);
INSERT INTO `districts` VALUES (1656, 'Umachiri', '200709', 168, NULL, NULL);
INSERT INTO `districts` VALUES (1657, 'Moho', '201301', 169, NULL, NULL);
INSERT INTO `districts` VALUES (1658, 'Conima', '201302', 169, NULL, NULL);
INSERT INTO `districts` VALUES (1659, 'Tilali', '201303', 169, NULL, NULL);
INSERT INTO `districts` VALUES (1660, 'Huayrapata', '201304', 169, NULL, NULL);
INSERT INTO `districts` VALUES (1661, 'Puno', '200101', 170, NULL, NULL);
INSERT INTO `districts` VALUES (1662, 'Acora', '200102', 170, NULL, NULL);
INSERT INTO `districts` VALUES (1663, 'Atuncolla', '200103', 170, NULL, NULL);
INSERT INTO `districts` VALUES (1664, 'Capachica', '200104', 170, NULL, NULL);
INSERT INTO `districts` VALUES (1665, 'Coata', '200105', 170, NULL, NULL);
INSERT INTO `districts` VALUES (1666, 'Chucuito', '200106', 170, NULL, NULL);
INSERT INTO `districts` VALUES (1667, 'Huata', '200107', 170, NULL, NULL);
INSERT INTO `districts` VALUES (1668, 'Mañazo', '200108', 170, NULL, NULL);
INSERT INTO `districts` VALUES (1669, 'Paucarcolla', '200109', 170, NULL, NULL);
INSERT INTO `districts` VALUES (1670, 'Pichacani', '200110', 170, NULL, NULL);
INSERT INTO `districts` VALUES (1671, 'San Antonio', '200111', 170, NULL, NULL);
INSERT INTO `districts` VALUES (1672, 'Tiquillaca', '200112', 170, NULL, NULL);
INSERT INTO `districts` VALUES (1673, 'Vilque', '200113', 170, NULL, NULL);
INSERT INTO `districts` VALUES (1674, 'Plateria', '200114', 170, NULL, NULL);
INSERT INTO `districts` VALUES (1675, 'Amantani', '200115', 170, NULL, NULL);
INSERT INTO `districts` VALUES (1676, 'Putina', '201101', 171, NULL, NULL);
INSERT INTO `districts` VALUES (1677, 'Pedro Vilca Apaza', '201102', 171, NULL, NULL);
INSERT INTO `districts` VALUES (1678, 'Quilcapuncu', '201103', 171, NULL, NULL);
INSERT INTO `districts` VALUES (1679, 'Ananea', '201104', 171, NULL, NULL);
INSERT INTO `districts` VALUES (1680, 'Sina', '201105', 171, NULL, NULL);
INSERT INTO `districts` VALUES (1681, 'Juliaca', '200901', 172, NULL, NULL);
INSERT INTO `districts` VALUES (1682, 'Cabana', '200902', 172, NULL, NULL);
INSERT INTO `districts` VALUES (1683, 'Cabanillas', '200903', 172, NULL, NULL);
INSERT INTO `districts` VALUES (1684, 'Caracoto', '200904', 172, NULL, NULL);
INSERT INTO `districts` VALUES (1685, 'Sandia', '200801', 173, NULL, NULL);
INSERT INTO `districts` VALUES (1686, 'Cuyocuyo', '200803', 173, NULL, NULL);
INSERT INTO `districts` VALUES (1687, 'Limbani', '200804', 173, NULL, NULL);
INSERT INTO `districts` VALUES (1688, 'Phara', '200805', 173, NULL, NULL);
INSERT INTO `districts` VALUES (1689, 'Patambuco', '200806', 173, NULL, NULL);
INSERT INTO `districts` VALUES (1690, 'Quiaca', '200807', 173, NULL, NULL);
INSERT INTO `districts` VALUES (1691, 'San Juan Del Oro', '200808', 173, NULL, NULL);
INSERT INTO `districts` VALUES (1692, 'Yanahuaya', '200810', 173, NULL, NULL);
INSERT INTO `districts` VALUES (1693, 'Alto Inambari', '200811', 173, NULL, NULL);
INSERT INTO `districts` VALUES (1694, 'San Pedro De Putina Punco', '200812', 173, NULL, NULL);
INSERT INTO `districts` VALUES (1695, 'Yunguyo', '201001', 174, NULL, NULL);
INSERT INTO `districts` VALUES (1696, 'Unicachi', '201002', 174, NULL, NULL);
INSERT INTO `districts` VALUES (1697, 'Anapia', '201003', 174, NULL, NULL);
INSERT INTO `districts` VALUES (1698, 'Copani', '201004', 174, NULL, NULL);
INSERT INTO `districts` VALUES (1699, 'Cuturapi', '201005', 174, NULL, NULL);
INSERT INTO `districts` VALUES (1700, 'Ollaraya', '201006', 174, NULL, NULL);
INSERT INTO `districts` VALUES (1701, 'Tinicachi', '201007', 174, NULL, NULL);
INSERT INTO `districts` VALUES (1702, 'Bellavista', '210701', 175, NULL, NULL);
INSERT INTO `districts` VALUES (1703, 'San Rafael', '210702', 175, NULL, NULL);
INSERT INTO `districts` VALUES (1704, 'San Pablo', '210703', 175, NULL, NULL);
INSERT INTO `districts` VALUES (1705, 'Alto Biavo', '210704', 175, NULL, NULL);
INSERT INTO `districts` VALUES (1706, 'Huallaga', '210705', 175, NULL, NULL);
INSERT INTO `districts` VALUES (1707, 'Bajo Biavo', '210706', 175, NULL, NULL);
INSERT INTO `districts` VALUES (1708, 'San Jose De Sisa', '211001', 176, NULL, NULL);
INSERT INTO `districts` VALUES (1709, 'Agua Blanca', '211002', 176, NULL, NULL);
INSERT INTO `districts` VALUES (1710, 'Shatoja', '211003', 176, NULL, NULL);
INSERT INTO `districts` VALUES (1711, 'San Martin', '211004', 176, NULL, NULL);
INSERT INTO `districts` VALUES (1712, 'Santa Rosa', '211005', 176, NULL, NULL);
INSERT INTO `districts` VALUES (1713, 'Saposoa', '210201', 177, NULL, NULL);
INSERT INTO `districts` VALUES (1714, 'Piscoyacu', '210202', 177, NULL, NULL);
INSERT INTO `districts` VALUES (1715, 'Sacanche', '210203', 177, NULL, NULL);
INSERT INTO `districts` VALUES (1716, 'Tingo De Saposoa', '210204', 177, NULL, NULL);
INSERT INTO `districts` VALUES (1717, 'Alto Saposoa', '210205', 177, NULL, NULL);
INSERT INTO `districts` VALUES (1718, 'El Eslabon', '210206', 177, NULL, NULL);
INSERT INTO `districts` VALUES (1719, 'Lamas', '210301', 178, NULL, NULL);
INSERT INTO `districts` VALUES (1720, 'Barranquita', '210303', 178, NULL, NULL);
INSERT INTO `districts` VALUES (1721, 'Caynarachi', '210304', 178, NULL, NULL);
INSERT INTO `districts` VALUES (1722, 'Cuñumbuqui', '210305', 178, NULL, NULL);
INSERT INTO `districts` VALUES (1723, 'Pinto Recodo', '210306', 178, NULL, NULL);
INSERT INTO `districts` VALUES (1724, 'Rumisapa', '210307', 178, NULL, NULL);
INSERT INTO `districts` VALUES (1725, 'Shanao', '210311', 178, NULL, NULL);
INSERT INTO `districts` VALUES (1726, 'Tabalosos', '210313', 178, NULL, NULL);
INSERT INTO `districts` VALUES (1727, 'Zapatero', '210314', 178, NULL, NULL);
INSERT INTO `districts` VALUES (1728, 'Alonso De Alvarado', '210315', 178, NULL, NULL);
INSERT INTO `districts` VALUES (1729, 'San Roque De Cumbaza', '210316', 178, NULL, NULL);
INSERT INTO `districts` VALUES (1730, 'Juanjui', '210401', 179, NULL, NULL);
INSERT INTO `districts` VALUES (1731, 'Campanilla', '210402', 179, NULL, NULL);
INSERT INTO `districts` VALUES (1732, 'Huicungo', '210403', 179, NULL, NULL);
INSERT INTO `districts` VALUES (1733, 'Pachiza', '210404', 179, NULL, NULL);
INSERT INTO `districts` VALUES (1734, 'Pajarillo', '210405', 179, NULL, NULL);
INSERT INTO `districts` VALUES (1735, 'Moyobamba', '210101', 180, NULL, NULL);
INSERT INTO `districts` VALUES (1736, 'Calzada', '210102', 180, NULL, NULL);
INSERT INTO `districts` VALUES (1737, 'Habana', '210103', 180, NULL, NULL);
INSERT INTO `districts` VALUES (1738, 'Jepelacio', '210104', 180, NULL, NULL);
INSERT INTO `districts` VALUES (1739, 'Soritor', '210105', 180, NULL, NULL);
INSERT INTO `districts` VALUES (1740, 'Yantalo', '210106', 180, NULL, NULL);
INSERT INTO `districts` VALUES (1741, 'Picota', '210901', 181, NULL, NULL);
INSERT INTO `districts` VALUES (1742, 'Buenos Aires', '210902', 181, NULL, NULL);
INSERT INTO `districts` VALUES (1743, 'Caspizapa', '210903', 181, NULL, NULL);
INSERT INTO `districts` VALUES (1744, 'Pilluana', '210904', 181, NULL, NULL);
INSERT INTO `districts` VALUES (1745, 'Pucacaca', '210905', 181, NULL, NULL);
INSERT INTO `districts` VALUES (1746, 'San Cristobal', '210906', 181, NULL, NULL);
INSERT INTO `districts` VALUES (1747, 'San Hilarion', '210907', 181, NULL, NULL);
INSERT INTO `districts` VALUES (1748, 'Tingo De Ponasa', '210908', 181, NULL, NULL);
INSERT INTO `districts` VALUES (1749, 'Tres Unidos', '210909', 181, NULL, NULL);
INSERT INTO `districts` VALUES (1750, 'Shamboyacu', '210910', 181, NULL, NULL);
INSERT INTO `districts` VALUES (1751, 'Rioja', '210501', 182, NULL, NULL);
INSERT INTO `districts` VALUES (1752, 'Posic', '210502', 182, NULL, NULL);
INSERT INTO `districts` VALUES (1753, 'Yorongos', '210503', 182, NULL, NULL);
INSERT INTO `districts` VALUES (1754, 'Yuracyacu', '210504', 182, NULL, NULL);
INSERT INTO `districts` VALUES (1755, 'Nueva Cajamarca', '210505', 182, NULL, NULL);
INSERT INTO `districts` VALUES (1756, 'Elias Soplin', '210506', 182, NULL, NULL);
INSERT INTO `districts` VALUES (1757, 'San Fernando', '210507', 182, NULL, NULL);
INSERT INTO `districts` VALUES (1758, 'Pardo Miguel', '210508', 182, NULL, NULL);
INSERT INTO `districts` VALUES (1759, 'Awajun', '210509', 182, NULL, NULL);
INSERT INTO `districts` VALUES (1760, 'Tarapoto', '210601', 183, NULL, NULL);
INSERT INTO `districts` VALUES (1761, 'Alberto Leveau', '210602', 183, NULL, NULL);
INSERT INTO `districts` VALUES (1762, 'Cacatachi', '210604', 183, NULL, NULL);
INSERT INTO `districts` VALUES (1763, 'Chazuta', '210606', 183, NULL, NULL);
INSERT INTO `districts` VALUES (1764, 'Chipurana', '210607', 183, NULL, NULL);
INSERT INTO `districts` VALUES (1765, 'El Porvenir', '210608', 183, NULL, NULL);
INSERT INTO `districts` VALUES (1766, 'Huimbayoc', '210609', 183, NULL, NULL);
INSERT INTO `districts` VALUES (1767, 'Juan Guerra', '210610', 183, NULL, NULL);
INSERT INTO `districts` VALUES (1768, 'Morales', '210611', 183, NULL, NULL);
INSERT INTO `districts` VALUES (1769, 'Papa-playa', '210612', 183, NULL, NULL);
INSERT INTO `districts` VALUES (1770, 'San Antonio', '210616', 183, NULL, NULL);
INSERT INTO `districts` VALUES (1771, 'Sauce', '210619', 183, NULL, NULL);
INSERT INTO `districts` VALUES (1772, 'Shapaja', '210620', 183, NULL, NULL);
INSERT INTO `districts` VALUES (1773, 'La Banda De Shilcayo', '210621', 183, NULL, NULL);
INSERT INTO `districts` VALUES (1774, 'Tocache', '210801', 184, NULL, NULL);
INSERT INTO `districts` VALUES (1775, 'Nuevo Progreso', '210802', 184, NULL, NULL);
INSERT INTO `districts` VALUES (1776, 'Polvora', '210803', 184, NULL, NULL);
INSERT INTO `districts` VALUES (1777, 'Shunte', '210804', 184, NULL, NULL);
INSERT INTO `districts` VALUES (1778, 'Uchiza', '210805', 184, NULL, NULL);
INSERT INTO `districts` VALUES (1779, 'Candarave', '220401', 185, NULL, NULL);
INSERT INTO `districts` VALUES (1780, 'Cairani', '220402', 185, NULL, NULL);
INSERT INTO `districts` VALUES (1781, 'Curibaya', '220403', 185, NULL, NULL);
INSERT INTO `districts` VALUES (1782, 'Huanuara', '220404', 185, NULL, NULL);
INSERT INTO `districts` VALUES (1783, 'Quilahuani', '220405', 185, NULL, NULL);
INSERT INTO `districts` VALUES (1784, 'Camilaca', '220406', 185, NULL, NULL);
INSERT INTO `districts` VALUES (1785, 'Locumba', '220301', 186, NULL, NULL);
INSERT INTO `districts` VALUES (1786, 'Ite', '220302', 186, NULL, NULL);
INSERT INTO `districts` VALUES (1787, 'Ilabaya', '220303', 186, NULL, NULL);
INSERT INTO `districts` VALUES (1788, 'Tacna', '220101', 187, NULL, NULL);
INSERT INTO `districts` VALUES (1789, 'Calana', '220102', 187, NULL, NULL);
INSERT INTO `districts` VALUES (1790, 'Inclan', '220104', 187, NULL, NULL);
INSERT INTO `districts` VALUES (1791, 'Pachia', '220107', 187, NULL, NULL);
INSERT INTO `districts` VALUES (1792, 'Palca', '220108', 187, NULL, NULL);
INSERT INTO `districts` VALUES (1793, 'Pocollay', '220109', 187, NULL, NULL);
INSERT INTO `districts` VALUES (1794, 'Sama', '220110', 187, NULL, NULL);
INSERT INTO `districts` VALUES (1795, 'Alto De La Alianza', '220111', 187, NULL, NULL);
INSERT INTO `districts` VALUES (1796, 'Ciudad Nueva', '220112', 187, NULL, NULL);
INSERT INTO `districts` VALUES (1797, 'Coronel Gregorio Albarracin La', '220113', 187, NULL, NULL);
INSERT INTO `districts` VALUES (1798, 'Tarata', '220201', 188, NULL, NULL);
INSERT INTO `districts` VALUES (1799, 'Heroes Albarracin', '220205', 188, NULL, NULL);
INSERT INTO `districts` VALUES (1800, 'Estique', '220206', 188, NULL, NULL);
INSERT INTO `districts` VALUES (1801, 'Estique Pampa', '220207', 188, NULL, NULL);
INSERT INTO `districts` VALUES (1802, 'Sitajara', '220210', 188, NULL, NULL);
INSERT INTO `districts` VALUES (1803, 'Susapaya', '220211', 188, NULL, NULL);
INSERT INTO `districts` VALUES (1804, 'Tarucachi', '220212', 188, NULL, NULL);
INSERT INTO `districts` VALUES (1805, 'Ticaco', '220213', 188, NULL, NULL);
INSERT INTO `districts` VALUES (1806, 'Zorritos', '230201', 189, NULL, NULL);
INSERT INTO `districts` VALUES (1807, 'Casitas', '230202', 189, NULL, NULL);
INSERT INTO `districts` VALUES (1808, 'Canoas De Punta Sal', '230203', 189, NULL, NULL);
INSERT INTO `districts` VALUES (1809, 'Tumbes', '230101', 190, NULL, NULL);
INSERT INTO `districts` VALUES (1810, 'Corrales', '230102', 190, NULL, NULL);
INSERT INTO `districts` VALUES (1811, 'La Cruz', '230103', 190, NULL, NULL);
INSERT INTO `districts` VALUES (1812, 'Pampas De Hospital', '230104', 190, NULL, NULL);
INSERT INTO `districts` VALUES (1813, 'San Jacinto', '230105', 190, NULL, NULL);
INSERT INTO `districts` VALUES (1814, 'San Juan De La Virgen', '230106', 190, NULL, NULL);
INSERT INTO `districts` VALUES (1815, 'Zarumilla', '230301', 191, NULL, NULL);
INSERT INTO `districts` VALUES (1816, 'Matapalo', '230302', 191, NULL, NULL);
INSERT INTO `districts` VALUES (1817, 'Papayal', '230303', 191, NULL, NULL);
INSERT INTO `districts` VALUES (1818, 'Aguas Verdes', '230304', 191, NULL, NULL);
INSERT INTO `districts` VALUES (1819, 'Raimondi', '250301', 192, NULL, NULL);
INSERT INTO `districts` VALUES (1820, 'Tahuania', '250302', 192, NULL, NULL);
INSERT INTO `districts` VALUES (1821, 'Yurua', '250303', 192, NULL, NULL);
INSERT INTO `districts` VALUES (1822, 'Sepahua', '250304', 192, NULL, NULL);
INSERT INTO `districts` VALUES (1823, 'Calleria', '250101', 193, NULL, NULL);
INSERT INTO `districts` VALUES (1824, 'Yarinacocha', '250102', 193, NULL, NULL);
INSERT INTO `districts` VALUES (1825, 'Masisea', '250103', 193, NULL, NULL);
INSERT INTO `districts` VALUES (1826, 'Campoverde', '250104', 193, NULL, NULL);
INSERT INTO `districts` VALUES (1827, 'Iparia', '250105', 193, NULL, NULL);
INSERT INTO `districts` VALUES (1828, 'Nueva Requena', '250106', 193, NULL, NULL);
INSERT INTO `districts` VALUES (1829, 'Manantay', '250107', 193, NULL, NULL);
INSERT INTO `districts` VALUES (1830, 'Padre Abad', '250201', 194, NULL, NULL);
INSERT INTO `districts` VALUES (1831, 'Irazola', '250202', 194, NULL, NULL);
INSERT INTO `districts` VALUES (1832, 'Curimana', '250203', 194, NULL, NULL);
INSERT INTO `districts` VALUES (1833, 'Purus', '250401', 195, NULL, NULL);

-- ----------------------------
-- Table structure for document_types
-- ----------------------------
DROP TABLE IF EXISTS `document_types`;
CREATE TABLE `document_types`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sunat_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abbreviation` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of document_types
-- ----------------------------
INSERT INTO `document_types` VALUES (1, 'BOLETA DE VENTA', '03', 'BT', NULL, NULL);
INSERT INTO `document_types` VALUES (2, 'FACTURA', '01', 'FT', NULL, NULL);
INSERT INTO `document_types` VALUES (3, 'NOTA DE CRÉDITO', '07', 'NC', NULL, NULL);
INSERT INTO `document_types` VALUES (4, 'NOTA DE DÉBITO', '08', 'ND', NULL, NULL);
INSERT INTO `document_types` VALUES (5, 'NOTA DE RECEPCIÓN', '09', 'GR', NULL, NULL);
INSERT INTO `document_types` VALUES (6, 'NOTA DE VENTA', '00', 'NV', NULL, NULL);
INSERT INTO `document_types` VALUES (7, 'NOTA DE SEPARACIÓN', '00', 'NS', NULL, NULL);
INSERT INTO `document_types` VALUES (8, 'NOTA DE TRASLADO', '00', 'NT', NULL, NULL);
INSERT INTO `document_types` VALUES (9, 'NOTA DE INVENTARIO', '00', 'NIV', NULL, NULL);
INSERT INTO `document_types` VALUES (10, 'NOTA DE INGRESO', '00', 'NIG', NULL, NULL);
INSERT INTO `document_types` VALUES (11, 'GUÍA DE REMISIÓN', '09', 'GR', NULL, NULL);

-- ----------------------------
-- Table structure for drives
-- ----------------------------
DROP TABLE IF EXISTS `drives`;
CREATE TABLE `drives`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `codigo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `nro_documento` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `tipo_doc` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `nombres` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `apellido_paterno` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `apellido_materno` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `nacionalidad` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `nro_licencia` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `categoria_licencia` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `fecha_nacimiento` date NULL DEFAULT NULL,
  `telefono` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `correo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `nro_motor` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `nro_chasis` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `nro_placa` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `departamento` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `provincia` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `distrito` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `direccion_detalle` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `nombres_contacto` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `telefono_contacto` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `parentesco_contacto` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `user_register` bigint UNSIGNED NULL DEFAULT NULL,
  `user_update` bigint UNSIGNED NULL DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `drives_nro_documento_unique`(`nro_documento` ASC) USING BTREE,
  UNIQUE INDEX `drives_nro_motor_unique`(`nro_motor` ASC) USING BTREE,
  UNIQUE INDEX `drives_nro_chasis_unique`(`nro_chasis` ASC) USING BTREE,
  UNIQUE INDEX `drives_nro_placa_unique`(`nro_placa` ASC) USING BTREE,
  INDEX `drives_user_register_foreign`(`user_register` ASC) USING BTREE,
  INDEX `drives_user_update_foreign`(`user_update` ASC) USING BTREE,
  INDEX `drives_nombres_index`(`nombres` ASC) USING BTREE,
  CONSTRAINT `drives_user_register_foreign` FOREIGN KEY (`user_register`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `drives_user_update_foreign` FOREIGN KEY (`user_update`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of drives
-- ----------------------------
INSERT INTO `drives` VALUES (1, '0000001', '77290401', 'DNI', 'MARCELO', 'VELARDE', 'HUALLPA', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2025-06-21 12:40:30', '2025-06-21 12:40:30', 1, '2025-06-21 17:40:30', '2025-06-21 17:40:30');
INSERT INTO `drives` VALUES (2, '0000002', '77426200', 'DNI', 'BRENDY YOSELY', 'ZAPATA', 'Emer', NULL, NULL, NULL, '2006-01-02', '993321920', 'yarlequerodrigo9@gmail.com', NULL, '32432', '2134asd', '1234', 'Loreto', 'Mariscal Ramon Castilla', NULL, 'Paita 2 de mayo', 'emer', '993321920', 'svdacc', 1, 1, '2025-08-27 10:16:54', '2025-11-17 07:54:42', 1, '2025-08-27 15:16:54', '2025-11-17 12:54:42');
INSERT INTO `drives` VALUES (3, '0000003', '77423200', 'DNI', 'RENINGER', 'AMASIFUEN', 'CACHIQUE', NULL, NULL, NULL, '2002-01-17', '993 321 920', 'kibutsuji26muzan@gmail.com', NULL, '324323232', '2134asd23', '123432', 'Madre De Dios', 'Tahuamanu', 'Tahuamanu', 'dwsscs', 'emer', '993321920', 'svdacc', 1, NULL, '2025-11-20 18:37:56', '2025-11-20 18:37:56', 1, '2025-11-20 23:37:56', '2025-11-20 23:37:56');

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `failed_jobs_uuid_unique`(`uuid` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of failed_jobs
-- ----------------------------

-- ----------------------------
-- Table structure for garantines
-- ----------------------------
DROP TABLE IF EXISTS `garantines`;
CREATE TABLE `garantines`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `codigo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `nro_documento` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `nombres_apellidos` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `tipo_doc` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'dni',
  `marca` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `modelo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `anio` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `color` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `nro_chasis` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `nro_motor` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `user_register` bigint UNSIGNED NULL DEFAULT NULL,
  `user_update` bigint UNSIGNED NULL DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `fecha_registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `celular` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `kilometrajes` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `boleta_dua_pdfs` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `garantines_nro_motor_unique`(`nro_motor` ASC) USING BTREE,
  INDEX `garantines_user_register_foreign`(`user_register` ASC) USING BTREE,
  INDEX `garantines_user_update_foreign`(`user_update` ASC) USING BTREE,
  CONSTRAINT `garantines_user_register_foreign` FOREIGN KEY (`user_register`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `garantines_user_update_foreign` FOREIGN KEY (`user_update`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of garantines
-- ----------------------------
INSERT INTO `garantines` VALUES (11, '0000001', '72314107', 'YURI MARTIN MARROQUIN MEJIA', 'dni', 'Prueba', 'PRUADS', '2025', 'prueba', '10', '40', 1, NULL, 1, '2025-06-16 15:05:18', '2025-06-16 15:05:18', '213421', '2025-06-16 20:05:18', '2025-06-16 20:05:18', '500,2500', '[{\"original_name\":\"CV- Yuri Marroquin.pdf\",\"stored_path\":\"garantias\\/boleta_dua\\/boleta_dua_685078fe29da6.pdf\",\"url\":\"http:\\/\\/localhost\\/storage\\/garantias\\/boleta_dua\\/boleta_dua_685078fe29da6.pdf\"},{\"original_name\":\"Dni Yuri.pdf\",\"stored_path\":\"garantias\\/boleta_dua\\/boleta_dua_685078fe2a1d2.pdf\",\"url\":\"http:\\/\\/localhost\\/storage\\/garantias\\/boleta_dua\\/boleta_dua_685078fe2a1d2.pdf\"},{\"original_name\":\"Dni Alessandra.pdf\",\"stored_path\":\"garantias\\/boleta_dua\\/boleta_dua_685078fe2a426.pdf\",\"url\":\"http:\\/\\/localhost\\/storage\\/garantias\\/boleta_dua\\/boleta_dua_685078fe2a426.pdf\"}]');
INSERT INTO `garantines` VALUES (12, '0000002', '77290401', 'MARCELO VELARDE HUALLPA', 'dni', 'BAJAJ', 'PULSAR 180', '2025', 'ROJO', 'dcevrv8889', '7777777777', 1, NULL, 1, '2025-07-08 15:16:05', '2025-07-08 15:16:05', '955251825', '2025-07-08 20:16:05', '2025-07-08 20:16:05', NULL, '[]');
INSERT INTO `garantines` VALUES (13, '0000003', '77290401', 'MARCELO VELARDE HUALLPA', 'dni', 'BAJAJ', 'PULSAR 180', '2025', 'ROJO', 'SCSVS', '5y5756868', 1, NULL, 1, '2025-11-08 09:37:02', '2025-11-08 09:37:02', '955251825', '2025-11-08 15:37:02', '2025-11-08 15:37:02', NULL, '[]');
INSERT INTO `garantines` VALUES (14, '0000004', '77425200', 'EMER RODRIGO YARLEQUE ZAPATA', 'dni', 'TAURO', 'TD-12N', '2025', '43d', '2134asd', '32432', 1, NULL, 1, '2025-11-28 10:00:13', '2025-11-28 10:00:13', '993321920', '2025-11-28 15:00:13', '2025-11-28 15:00:13', NULL, '[{\"original_name\":\"PRODUCTOS (1).pdf\",\"stored_path\":\"garantias\\/boleta_dua\\/boleta_dua_6929b8fbc6fbb.pdf\",\"url\":\"http:\\/\\/biker-project.test\\/storage\\/garantias\\/boleta_dua\\/boleta_dua_6929b8fbc6fbb.pdf\"}]');
INSERT INTO `garantines` VALUES (15, '0000005', '77425200', 'EMER RODRIGO YARLEQUE ZAPATA', 'dni', 'fsdbbngdf', 'fgndgnfd', '2002', 'resd', '2134asddsf', '453543', 1, NULL, 1, '2025-11-28 10:07:20', '2025-11-28 10:07:20', '993321920', '2025-11-28 15:07:20', '2025-11-28 15:07:20', '0-5000', '[{\"original_name\":\"Constatacion_1_20251126 (8).pdf\",\"stored_path\":\"garantias\\/boleta_dua\\/boleta_dua_6929baa825a3e.pdf\",\"url\":\"http:\\/\\/biker-project.test\\/storage\\/garantias\\/boleta_dua\\/boleta_dua_6929baa825a3e.pdf\"}]');
INSERT INTO `garantines` VALUES (16, '0000006', '77425200', 'EMER RODRIGO YARLEQUE ZAPATA', 'dni', 'sfdvcdsf', 'bfdsbfdg', 'fdgbdfgbgf', 'fgdbbfd', '6546545', 'dfgbbgfdbgf', 1, NULL, 1, '2025-12-03 11:23:27', '2025-12-03 11:23:27', '993321920', '2025-12-03 16:23:27', '2025-12-03 16:23:27', '0-5000', '[]');

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 38 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '2014_10_12_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES (2, '2014_10_12_100000_create_password_reset_tokens_table', 1);
INSERT INTO `migrations` VALUES (3, '2019_08_19_000000_create_failed_jobs_table', 1);
INSERT INTO `migrations` VALUES (4, '2019_12_14_000001_create_personal_access_tokens_table', 1);
INSERT INTO `migrations` VALUES (5, '2025_00_26_094735_create_companies_table', 1);
INSERT INTO `migrations` VALUES (6, '2025_00_26_185137_create_payments_table', 1);
INSERT INTO `migrations` VALUES (7, '2025_02_01_041830_create_payment_methods_table', 1);
INSERT INTO `migrations` VALUES (8, '2025_02_04_202919_create_permission_tables', 1);
INSERT INTO `migrations` VALUES (9, '2025_02_05_124343_create_drives_table', 1);
INSERT INTO `migrations` VALUES (10, '2025_02_05_124346_create_cars_table', 1);
INSERT INTO `migrations` VALUES (11, '2025_02_05_201156_create_services_table', 1);
INSERT INTO `migrations` VALUES (12, '2025_02_06_035009_create_garantines_table', 1);
INSERT INTO `migrations` VALUES (13, '2025_02_14_210635_create_brands_table', 1);
INSERT INTO `migrations` VALUES (14, '2025_02_15_101023_create_warehouses_table', 1);
INSERT INTO `migrations` VALUES (15, '2025_02_17_210047_create_unit_types_table', 1);
INSERT INTO `migrations` VALUES (16, '2025_02_17_210049_create_units_table', 1);
INSERT INTO `migrations` VALUES (17, '2025_02_18_205703_create_products_table', 1);
INSERT INTO `migrations` VALUES (18, '2025_02_19_104106_create_product_prices_table', 1);
INSERT INTO `migrations` VALUES (19, '2025_02_22_210631_create_stocks_table', 1);
INSERT INTO `migrations` VALUES (20, '2025_02_26_151710_create_product_images_table', 1);
INSERT INTO `migrations` VALUES (21, '2025_02_31_205304_create_regions_table', 1);
INSERT INTO `migrations` VALUES (22, '2025_02_31_205305_create_provinces_table', 1);
INSERT INTO `migrations` VALUES (23, '2025_02_31_205306_create_districts_table', 1);
INSERT INTO `migrations` VALUES (24, '2025_03_00_142305_create_document_types_table', 1);
INSERT INTO `migrations` VALUES (25, '2025_03_00_210707_create_quotations_table', 1);
INSERT INTO `migrations` VALUES (26, '2025_03_00_212712_create_quotation_items_table', 1);
INSERT INTO `migrations` VALUES (27, '2025_03_01_035825_create_sales_table', 1);
INSERT INTO `migrations` VALUES (28, '2025_03_01_174653_create_services_sales_table', 1);
INSERT INTO `migrations` VALUES (29, '2025_03_02_041640_create_sale_items_table', 1);
INSERT INTO `migrations` VALUES (30, '2025_03_03_075924_create_sale_payment_method_table', 1);
INSERT INTO `migrations` VALUES (31, '2025_03_27_071408_create_sales_sunat_table', 1);
INSERT INTO `migrations` VALUES (32, '2025_03_31_033609_create_quotation_payment_method_table', 1);
INSERT INTO `migrations` VALUES (33, '2025_04_01_172845_create_wholesalers_table', 1);
INSERT INTO `migrations` VALUES (34, '2025_04_01_172933_create_wholesaler_items_table', 1);
INSERT INTO `migrations` VALUES (35, '2025_04_29_214015_create_buys_table', 1);
INSERT INTO `migrations` VALUES (36, '2025_04_30_210621_create_buy_items_table', 1);
INSERT INTO `migrations` VALUES (37, '2025_04_30_213837_create_buy_sunat_table', 1);

-- ----------------------------
-- Table structure for model_has_permissions
-- ----------------------------
DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE `model_has_permissions`  (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`, `model_id`, `model_type`) USING BTREE,
  INDEX `model_has_permissions_model_id_model_type_index`(`model_id` ASC, `model_type` ASC) USING BTREE,
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of model_has_permissions
-- ----------------------------

-- ----------------------------
-- Table structure for model_has_roles
-- ----------------------------
DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE `model_has_roles`  (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`role_id`, `model_id`, `model_type`) USING BTREE,
  INDEX `model_has_roles_model_id_model_type_index`(`model_id` ASC, `model_type` ASC) USING BTREE,
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of model_has_roles
-- ----------------------------
INSERT INTO `model_has_roles` VALUES (1, 'App\\Models\\User', 1);
INSERT INTO `model_has_roles` VALUES (3, 'App\\Models\\User', 2);
INSERT INTO `model_has_roles` VALUES (2, 'App\\Models\\User', 3);
INSERT INTO `model_has_roles` VALUES (2, 'App\\Models\\User', 4);
INSERT INTO `model_has_roles` VALUES (1, 'App\\Models\\User', 5);
INSERT INTO `model_has_roles` VALUES (2, 'App\\Models\\User', 5);

-- ----------------------------
-- Table structure for password_reset_tokens
-- ----------------------------
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens`  (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of password_reset_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for payment_methods
-- ----------------------------
DROP TABLE IF EXISTS `payment_methods`;
CREATE TABLE `payment_methods`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('cash','credit') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'cash',
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `payment_methods_name_unique`(`name` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 19 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of payment_methods
-- ----------------------------
INSERT INTO `payment_methods` VALUES (1, 'Efectivo', 'cash', 1, '2025-05-05 16:22:28', '2025-05-05 16:22:28');
INSERT INTO `payment_methods` VALUES (2, 'Tarjeta de Crédito', 'cash', 1, '2025-05-05 16:22:28', '2025-05-05 16:22:28');
INSERT INTO `payment_methods` VALUES (3, 'Tarjeta de Débito', 'cash', 1, '2025-05-05 16:22:28', '2025-05-05 16:22:28');
INSERT INTO `payment_methods` VALUES (4, 'Transferencia Bancaria', 'cash', 1, '2025-05-05 16:22:28', '2025-05-05 16:22:28');
INSERT INTO `payment_methods` VALUES (5, 'Yape', 'cash', 1, '2025-05-05 16:22:28', '2025-05-05 16:22:28');
INSERT INTO `payment_methods` VALUES (6, 'Plin', 'cash', 1, '2025-05-05 16:22:28', '2025-05-05 16:22:28');
INSERT INTO `payment_methods` VALUES (7, 'Paypal', 'cash', 1, '2025-05-05 16:22:28', '2025-05-05 16:22:28');
INSERT INTO `payment_methods` VALUES (8, 'Transferencia', 'cash', 1, NULL, NULL);
INSERT INTO `payment_methods` VALUES (9, 'Crédito 30 días', 'credit', 1, NULL, NULL);
INSERT INTO `payment_methods` VALUES (10, 'Crédito 60 días', 'credit', 1, NULL, NULL);
INSERT INTO `payment_methods` VALUES (11, 'Crédito 90 días', 'credit', 1, NULL, NULL);

-- ----------------------------
-- Table structure for payments
-- ----------------------------
DROP TABLE IF EXISTS `payments`;
CREATE TABLE `payments`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of payments
-- ----------------------------
INSERT INTO `payments` VALUES (1, 'contado', 1, '2025-05-05 16:22:29', '2025-05-05 16:22:29');
INSERT INTO `payments` VALUES (2, 'credito', 1, '2025-05-05 16:22:29', '2025-05-05 16:22:29');

-- ----------------------------
-- Table structure for pedido_items
-- ----------------------------
DROP TABLE IF EXISTS `pedido_items`;
CREATE TABLE `pedido_items`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `pedido_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `product_price_id` bigint UNSIGNED NULL DEFAULT NULL COMMENT 'ID del precio seleccionado',
  `quantity` int NOT NULL DEFAULT 1,
  `unit_price` decimal(10, 2) NOT NULL,
  `total` decimal(10, 2) NOT NULL,
  `notes` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'Notas del item',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `pedido_items_pedido_id_foreign`(`pedido_id` ASC) USING BTREE,
  INDEX `pedido_items_product_id_foreign`(`product_id` ASC) USING BTREE,
  INDEX `pedido_items_product_price_id_foreign`(`product_price_id` ASC) USING BTREE,
  CONSTRAINT `pedido_items_pedido_id_foreign` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `pedido_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `pedido_items_product_price_id_foreign` FOREIGN KEY (`product_price_id`) REFERENCES `product_prices` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of pedido_items
-- ----------------------------
INSERT INTO `pedido_items` VALUES (1, 1, 1, 24787, 1, 30.00, 30.00, NULL, '2025-11-21 13:51:02', '2025-11-21 13:51:02');
INSERT INTO `pedido_items` VALUES (2, 2, 1, 24788, 1, 70.00, 70.00, NULL, '2025-11-21 16:37:05', '2025-11-21 16:37:05');
INSERT INTO `pedido_items` VALUES (3, 3, 1, 24787, 1, 30.00, 30.00, NULL, '2025-11-22 01:07:29', '2025-11-22 01:07:29');
INSERT INTO `pedido_items` VALUES (5, 4, 1, 24787, 1, 30.00, 30.00, NULL, '2025-11-22 14:07:49', '2025-11-22 14:07:49');

-- ----------------------------
-- Table structure for pedido_services
-- ----------------------------
DROP TABLE IF EXISTS `pedido_services`;
CREATE TABLE `pedido_services`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `pedido_id` bigint UNSIGNED NOT NULL,
  `service_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(10, 2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `pedido_services_pedido_id_foreign`(`pedido_id` ASC) USING BTREE,
  CONSTRAINT `pedido_services_pedido_id_foreign` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of pedido_services
-- ----------------------------
INSERT INTO `pedido_services` VALUES (1, 1, 'fdghngfh', 543.00, '2025-11-21 13:51:02', '2025-11-21 13:51:02');

-- ----------------------------
-- Table structure for pedidos
-- ----------------------------
DROP TABLE IF EXISTS `pedidos`;
CREATE TABLE `pedidos`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'Código único del pedido (PED-0001)',
  `customer_dni` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'DNI/RUC del cliente',
  `customer_names_surnames` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'Nombre del cliente',
  `customer_phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'Teléfono del cliente',
  `customer_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'Dirección del cliente',
  `districts_id` bigint UNSIGNED NULL DEFAULT NULL COMMENT 'Distrito',
  `mechanics_id` bigint UNSIGNED NULL DEFAULT NULL COMMENT 'Mecánico asignado',
  `user_register` bigint UNSIGNED NULL DEFAULT NULL COMMENT 'Usuario que creó el pedido',
  `user_update` bigint UNSIGNED NULL DEFAULT NULL COMMENT 'Usuario que actualizó',
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pendiente' COMMENT 'pendiente, confirmado, convertido, cancelado',
  `priority` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'normal' COMMENT 'normal, urgente',
  `observation` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'Observaciones del pedido',
  `subtotal` decimal(10, 2) NOT NULL DEFAULT 0.00,
  `igv` decimal(10, 2) NOT NULL DEFAULT 0.00,
  `total` decimal(10, 2) NOT NULL DEFAULT 0.00,
  `sale_id` bigint UNSIGNED NULL DEFAULT NULL COMMENT 'ID de la venta cuando se convierte',
  `converted_at` timestamp NULL DEFAULT NULL COMMENT 'Fecha de conversión a venta',
  `expires_at` date NULL DEFAULT NULL COMMENT 'Fecha de expiración del pedido',
  `fecha_registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `pedidos_code_unique`(`code` ASC) USING BTREE,
  INDEX `pedidos_customer_dni_index`(`customer_dni` ASC) USING BTREE,
  INDEX `pedidos_status_index`(`status` ASC) USING BTREE,
  INDEX `pedidos_districts_id_foreign`(`districts_id` ASC) USING BTREE,
  INDEX `pedidos_mechanics_id_foreign`(`mechanics_id` ASC) USING BTREE,
  INDEX `pedidos_user_register_foreign`(`user_register` ASC) USING BTREE,
  INDEX `pedidos_user_update_foreign`(`user_update` ASC) USING BTREE,
  INDEX `pedidos_sale_id_foreign`(`sale_id` ASC) USING BTREE,
  INDEX `pedidos_status_fecha_index`(`status` ASC, `fecha_registro` ASC) USING BTREE,
  CONSTRAINT `pedidos_districts_id_foreign` FOREIGN KEY (`districts_id`) REFERENCES `districts` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT,
  CONSTRAINT `pedidos_mechanics_id_foreign` FOREIGN KEY (`mechanics_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT,
  CONSTRAINT `pedidos_sale_id_foreign` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT,
  CONSTRAINT `pedidos_user_register_foreign` FOREIGN KEY (`user_register`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT,
  CONSTRAINT `pedidos_user_update_foreign` FOREIGN KEY (`user_update`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of pedidos
-- ----------------------------
INSERT INTO `pedidos` VALUES (1, 'PED-000001', '77425200', 'YARLEQUE ZAPATA EMER RODRIGO', '993321920', 'fdgbngdfd', 1420, NULL, 1, 1, 'convertido', 'normal', 'fgdnbgfn', 469.86, 103.14, 573.00, 13, '2025-11-21 16:51:22', '2025-11-21', '2025-11-21 08:51:01', '2025-11-21 11:51:22', '2025-11-21 13:51:01', '2025-11-21 16:51:22');
INSERT INTO `pedidos` VALUES (2, 'PED-000002', '77425200', 'YARLEQUE ZAPATA EMER RODRIGO', NULL, NULL, NULL, NULL, 1, 1, 'convertido', 'urgente', NULL, 57.40, 12.60, 70.00, 14, '2025-11-21 16:55:22', NULL, '2025-11-21 11:37:05', '2025-11-21 11:55:22', '2025-11-21 16:37:05', '2025-11-21 16:55:22');
INSERT INTO `pedidos` VALUES (3, 'PED-000003', '77425200', 'YARLEQUE ZAPATA EMER RODRIGO', '993321920', NULL, NULL, NULL, 1, 1, 'confirmado', 'normal', NULL, 24.60, 5.40, 30.00, NULL, NULL, NULL, '2025-11-21 20:07:29', '2025-11-21 20:07:35', '2025-11-22 01:07:29', '2025-11-22 01:07:35');
INSERT INTO `pedidos` VALUES (4, 'PED-000004', '77425200', 'YARLEQUE ZAPATA EMER RODRIGO', NULL, NULL, NULL, NULL, 1, 1, 'pendiente', 'normal', NULL, 24.60, 5.40, 30.00, NULL, NULL, NULL, '2025-11-22 09:04:16', '2025-11-22 09:04:16', '2025-11-22 14:04:16', '2025-11-22 14:04:16');

-- ----------------------------
-- Table structure for permissions
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `permissions_name_guard_name_unique`(`name` ASC, `guard_name` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 44 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of permissions
-- ----------------------------
INSERT INTO `permissions` VALUES (1, 'ver-rol', 'web', '2025-05-05 16:22:28', '2025-05-05 16:22:28');
INSERT INTO `permissions` VALUES (2, 'crear-rol', 'web', '2025-05-05 16:22:28', '2025-05-05 16:22:28');
INSERT INTO `permissions` VALUES (3, 'actualizar-rol', 'web', '2025-05-05 16:22:28', '2025-05-05 16:22:28');
INSERT INTO `permissions` VALUES (4, 'eliminar-rol', 'web', '2025-05-05 16:22:28', '2025-05-05 16:22:28');
INSERT INTO `permissions` VALUES (5, 'ver-permisos', 'web', '2025-05-05 16:22:28', '2025-05-05 16:22:28');
INSERT INTO `permissions` VALUES (6, 'agregar-permisos', 'web', '2025-05-05 16:22:28', '2025-05-05 16:22:28');
INSERT INTO `permissions` VALUES (7, 'actualizar-permisos', 'web', '2025-05-05 16:22:28', '2025-05-05 16:22:28');
INSERT INTO `permissions` VALUES (8, 'eliminar-permisos', 'web', '2025-05-05 16:22:28', '2025-05-05 16:22:28');
INSERT INTO `permissions` VALUES (9, 'ver-trabajadores', 'web', '2025-05-05 16:22:28', '2025-05-05 16:22:28');
INSERT INTO `permissions` VALUES (10, 'actualizar-trabajadores', 'web', '2025-05-05 16:22:28', '2025-05-05 16:22:28');
INSERT INTO `permissions` VALUES (11, 'eliminar-trabajadores', 'web', '2025-05-05 16:22:28', '2025-05-05 16:22:28');
INSERT INTO `permissions` VALUES (12, 'agregar-trabajadores', 'web', '2025-05-05 16:22:28', '2025-05-05 16:22:28');
INSERT INTO `permissions` VALUES (13, 'buscar-trabajadores', 'web', '2025-05-05 16:22:28', '2025-05-05 16:22:28');
INSERT INTO `permissions` VALUES (14, 'ver-servicios', 'web', '2025-05-05 16:22:28', '2025-05-05 16:22:28');
INSERT INTO `permissions` VALUES (15, 'actualizar-mecanicos', 'web', '2025-05-05 16:22:28', '2025-05-05 16:22:28');
INSERT INTO `permissions` VALUES (16, 'eliminar-mecanicos', 'web', '2025-05-05 16:22:28', '2025-05-05 16:22:28');
INSERT INTO `permissions` VALUES (17, 'agregar-mecanicos', 'web', '2025-05-05 16:22:28', '2025-05-05 16:22:28');
INSERT INTO `permissions` VALUES (18, 'buscar-mecanicos', 'web', '2025-05-05 16:22:28', '2025-05-05 16:22:28');
INSERT INTO `permissions` VALUES (19, 'ver-mecanicos', 'web', '2025-05-05 16:22:28', '2025-05-05 16:22:28');
INSERT INTO `permissions` VALUES (20, 'ver-vehiculos', 'web', '2025-05-05 16:22:28', '2025-05-05 16:22:28');
INSERT INTO `permissions` VALUES (21, 'actualizar-vehiculos', 'web', '2025-05-05 16:22:28', '2025-05-05 16:22:28');
INSERT INTO `permissions` VALUES (22, 'eliminar-vehiculos', 'web', '2025-05-05 16:22:28', '2025-05-05 16:22:28');
INSERT INTO `permissions` VALUES (23, 'agregar-vehiculos', 'web', '2025-05-05 16:22:28', '2025-05-05 16:22:28');
INSERT INTO `permissions` VALUES (24, 'buscar-vehiculos', 'web', '2025-05-05 16:22:28', '2025-05-05 16:22:28');
INSERT INTO `permissions` VALUES (25, 'registro-conductores', 'web', '2025-05-05 16:22:28', '2025-05-05 16:22:28');
INSERT INTO `permissions` VALUES (26, 'actualizar-conductores', 'web', '2025-05-05 16:22:28', '2025-05-05 16:22:28');
INSERT INTO `permissions` VALUES (27, 'eliminar-conductores', 'web', '2025-05-05 16:22:28', '2025-05-05 16:22:28');
INSERT INTO `permissions` VALUES (28, 'agregar-conductores', 'web', '2025-05-05 16:22:28', '2025-05-05 16:22:28');
INSERT INTO `permissions` VALUES (29, 'buscar-conductores', 'web', '2025-05-05 16:22:28', '2025-05-05 16:22:28');
INSERT INTO `permissions` VALUES (30, 'ver-conductores', 'web', '2025-05-05 16:22:28', '2025-05-05 16:22:28');
INSERT INTO `permissions` VALUES (31, 'filtrar-por-trabajador-servicios', 'web', '2025-05-05 16:22:28', '2025-05-05 16:22:28');
INSERT INTO `permissions` VALUES (32, 'filtrar-por-estado-servicios', 'web', '2025-05-05 16:22:28', '2025-05-05 16:22:28');
INSERT INTO `permissions` VALUES (33, 'agregar-servicios', 'web', '2025-05-05 16:22:28', '2025-05-05 16:22:28');
INSERT INTO `permissions` VALUES (34, 'ver-garantias', 'web', '2025-05-05 16:22:28', '2025-05-05 16:22:28');
INSERT INTO `permissions` VALUES (35, 'actualizar-garantias', 'web', '2025-05-05 16:22:28', '2025-05-05 16:22:28');
INSERT INTO `permissions` VALUES (36, 'eliminar-garantias', 'web', '2025-05-05 16:22:28', '2025-05-05 16:22:28');
INSERT INTO `permissions` VALUES (37, 'agregar-garantias', 'web', '2025-05-05 16:22:28', '2025-05-05 16:22:28');
INSERT INTO `permissions` VALUES (38, 'buscar-garantias', 'web', '2025-05-05 16:22:28', '2025-05-05 16:22:28');
INSERT INTO `permissions` VALUES (39, 'ver-productos', 'web', '2025-05-05 16:22:28', '2025-05-05 16:22:28');
INSERT INTO `permissions` VALUES (40, 'agregar-productos', 'web', '2025-05-05 16:22:28', '2025-05-05 16:22:28');
INSERT INTO `permissions` VALUES (41, 'actualizar-productos', 'web', '2025-05-05 16:22:28', '2025-05-05 16:22:28');
INSERT INTO `permissions` VALUES (42, 'eliminar-productos', 'web', '2025-05-05 16:22:28', '2025-05-05 16:22:28');
INSERT INTO `permissions` VALUES (43, 'buscar-productos', 'web', '2025-05-05 16:22:28', '2025-05-05 16:22:28');

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
  UNIQUE INDEX `personal_access_tokens_token_unique`(`token` ASC) USING BTREE,
  INDEX `personal_access_tokens_tokenable_type_tokenable_id_index`(`tokenable_type` ASC, `tokenable_id` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of personal_access_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for product_images
-- ----------------------------
DROP TABLE IF EXISTS `product_images`;
CREATE TABLE `product_images`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` bigint UNSIGNED NOT NULL,
  `image_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `product_images_product_id_foreign`(`product_id` ASC) USING BTREE,
  CONSTRAINT `product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 23 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of product_images
-- ----------------------------
INSERT INTO `product_images` VALUES (4, 24756, 'images/products/1753849148_1604381.jpg', '2025-07-30 04:19:08', '2025-07-30 04:19:08');
INSERT INTO `product_images` VALUES (5, 24757, 'images/products/1753883854_nokia-c2-02-6782-g-alt.jpg', '2025-07-30 13:57:34', '2025-07-30 13:57:34');
INSERT INTO `product_images` VALUES (6, 24758, 'images/products/1753884674_images.jpg', '2025-07-30 14:11:14', '2025-07-30 14:11:14');
INSERT INTO `product_images` VALUES (7, 24759, 'images/products/1753885147_images (1).jpg', '2025-07-30 14:19:07', '2025-07-30 14:19:07');
INSERT INTO `product_images` VALUES (8, 24760, 'images/products/1753886603_51vXvJjy4cL._AC_SL1000_.jpg', '2025-07-30 14:43:23', '2025-07-30 14:43:23');
INSERT INTO `product_images` VALUES (9, 24757, 'images/products/1753906121_51vXvJjy4cL._AC_SL1000_.jpg', '2025-07-30 20:08:41', '2025-07-30 20:08:41');
INSERT INTO `product_images` VALUES (10, 24761, 'images/products/1753987404_Samsung A03.jpg', '2025-07-31 18:43:24', '2025-07-31 18:43:24');
INSERT INTO `product_images` VALUES (11, 24762, 'images/products/1753987877_images (2).jpg', '2025-07-31 18:51:17', '2025-07-31 18:51:17');
INSERT INTO `product_images` VALUES (19, 24766, 'images/products/1755044805_images.jpg', '2025-08-13 00:26:45', '2025-08-13 00:26:45');
INSERT INTO `product_images` VALUES (20, 1, 'images/products/1755044830_images (1).jpg', '2025-08-13 00:27:10', '2025-08-13 00:27:10');
INSERT INTO `product_images` VALUES (21, 1, 'images/products/1755044830_images.jpg', '2025-08-13 00:27:10', '2025-08-13 00:27:10');
INSERT INTO `product_images` VALUES (22, 1, 'images/products/1755044830_WhatsApp Image 2025-07-11 at 9.38.39 AM.jpeg', '2025-08-13 00:27:10', '2025-08-13 00:27:10');

-- ----------------------------
-- Table structure for product_price_histories
-- ----------------------------
DROP TABLE IF EXISTS `product_price_histories`;
CREATE TABLE `product_price_histories`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` bigint UNSIGNED NOT NULL,
  `buy_id` bigint UNSIGNED NULL DEFAULT NULL,
  `price` decimal(10, 2) NOT NULL,
  `type` enum('buy','sale','wholesale') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'buy',
  `user_register` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `product_price_histories_product_id_foreign`(`product_id` ASC) USING BTREE,
  INDEX `product_price_histories_buy_id_foreign`(`buy_id` ASC) USING BTREE,
  INDEX `product_price_histories_user_register_foreign`(`user_register` ASC) USING BTREE,
  INDEX `product_price_histories_product_id_type_index`(`product_id` ASC, `type` ASC) USING BTREE,
  CONSTRAINT `product_price_histories_buy_id_foreign` FOREIGN KEY (`buy_id`) REFERENCES `buys` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `product_price_histories_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `product_price_histories_user_register_foreign` FOREIGN KEY (`user_register`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of product_price_histories
-- ----------------------------
INSERT INTO `product_price_histories` VALUES (1, 24757, 8, 240.00, 'buy', 1, '2025-08-01 20:01:55', '2025-08-01 20:01:55');
INSERT INTO `product_price_histories` VALUES (2, 24757, 9, 130.00, 'buy', 1, '2025-08-01 23:11:01', '2025-08-01 23:11:01');

-- ----------------------------
-- Table structure for product_prices
-- ----------------------------
DROP TABLE IF EXISTS `product_prices`;
CREATE TABLE `product_prices`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` bigint UNSIGNED NOT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(10, 2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `product_prices_product_id_foreign`(`product_id` ASC) USING BTREE,
  CONSTRAINT `product_prices_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 24844 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of product_prices
-- ----------------------------
INSERT INTO `product_prices` VALUES (24707, 24751, 'buy', 12000.00, NULL, NULL);
INSERT INTO `product_prices` VALUES (24708, 24751, 'wholesale', 1000.00, NULL, NULL);
INSERT INTO `product_prices` VALUES (24709, 24751, 'sucursalA', 1300.00, NULL, NULL);
INSERT INTO `product_prices` VALUES (24710, 24751, 'sucursalB', 1350.00, NULL, NULL);
INSERT INTO `product_prices` VALUES (24727, 24756, 'buy', 12000.00, NULL, NULL);
INSERT INTO `product_prices` VALUES (24728, 24756, 'wholesale', 1000.00, NULL, NULL);
INSERT INTO `product_prices` VALUES (24729, 24756, 'sucursalA', 1300.00, NULL, NULL);
INSERT INTO `product_prices` VALUES (24730, 24756, 'sucursalB', 1350.00, NULL, NULL);
INSERT INTO `product_prices` VALUES (24743, 24760, 'buy', 500.00, NULL, NULL);
INSERT INTO `product_prices` VALUES (24744, 24760, 'wholesale', 560.00, NULL, NULL);
INSERT INTO `product_prices` VALUES (24745, 24760, 'sucursalA', 720.00, NULL, NULL);
INSERT INTO `product_prices` VALUES (24746, 24760, 'sucursalB', 800.00, NULL, NULL);
INSERT INTO `product_prices` VALUES (24751, 24757, 'buy', 200.00, NULL, NULL);
INSERT INTO `product_prices` VALUES (24752, 24757, 'wholesale', 230.00, NULL, NULL);
INSERT INTO `product_prices` VALUES (24753, 24757, 'sucursalA', 500.00, NULL, NULL);
INSERT INTO `product_prices` VALUES (24754, 24757, 'sucursalB', 458.00, NULL, NULL);
INSERT INTO `product_prices` VALUES (24755, 24761, 'buy', 180.00, NULL, NULL);
INSERT INTO `product_prices` VALUES (24756, 24761, 'wholesale', 160.00, NULL, NULL);
INSERT INTO `product_prices` VALUES (24757, 24761, 'sucursalA', 200.00, NULL, NULL);
INSERT INTO `product_prices` VALUES (24758, 24761, 'sucursalB', 220.00, NULL, NULL);
INSERT INTO `product_prices` VALUES (24759, 24762, 'buy', 5.00, NULL, NULL);
INSERT INTO `product_prices` VALUES (24760, 24762, 'wholesale', 6.00, NULL, NULL);
INSERT INTO `product_prices` VALUES (24761, 24762, 'sucursalA', 8.00, NULL, NULL);
INSERT INTO `product_prices` VALUES (24762, 24762, 'sucursalB', 10.00, NULL, NULL);
INSERT INTO `product_prices` VALUES (24771, 24763, 'buy', 96.80, NULL, NULL);
INSERT INTO `product_prices` VALUES (24772, 24763, 'wholesale', 130.00, NULL, NULL);
INSERT INTO `product_prices` VALUES (24773, 24763, 'sucursalA', 140.00, NULL, NULL);
INSERT INTO `product_prices` VALUES (24774, 24763, 'sucursalB', 140.00, NULL, NULL);
INSERT INTO `product_prices` VALUES (24779, 24759, 'buy', 12000.00, NULL, NULL);
INSERT INTO `product_prices` VALUES (24780, 24759, 'wholesale', 11000.00, NULL, NULL);
INSERT INTO `product_prices` VALUES (24781, 24759, 'sucursalA', 14000.00, NULL, NULL);
INSERT INTO `product_prices` VALUES (24782, 24759, 'sucursalB', 15000.00, NULL, NULL);
INSERT INTO `product_prices` VALUES (24783, 24766, 'buy', 20.00, NULL, NULL);
INSERT INTO `product_prices` VALUES (24784, 24766, 'wholesale', 21.00, NULL, NULL);
INSERT INTO `product_prices` VALUES (24785, 24766, 'sucursalA', 25.00, NULL, NULL);
INSERT INTO `product_prices` VALUES (24786, 24766, 'sucursalB', 25.00, NULL, NULL);
INSERT INTO `product_prices` VALUES (24787, 1, 'buy', 30.00, NULL, NULL);
INSERT INTO `product_prices` VALUES (24788, 1, 'wholesale', 70.00, NULL, NULL);
INSERT INTO `product_prices` VALUES (24789, 1, 'sucursalA', 110.00, NULL, NULL);
INSERT INTO `product_prices` VALUES (24790, 24768, 'buy', 30.00, '2025-10-10 00:12:26', '2025-10-10 00:12:26');
INSERT INTO `product_prices` VALUES (24791, 24768, 'sucursalA', 48.00, '2025-10-10 00:12:26', '2025-10-10 00:12:26');
INSERT INTO `product_prices` VALUES (24792, 24769, 'buy', 9.00, '2025-10-10 00:12:26', '2025-10-10 00:12:26');
INSERT INTO `product_prices` VALUES (24793, 24769, 'sucursalA', 10.00, '2025-10-10 00:12:26', '2025-10-10 00:12:26');
INSERT INTO `product_prices` VALUES (24794, 24770, 'buy', 15.00, '2025-10-10 00:12:26', '2025-10-10 00:12:26');
INSERT INTO `product_prices` VALUES (24795, 24770, 'sucursalA', 28.00, '2025-10-10 00:12:26', '2025-10-10 00:12:26');
INSERT INTO `product_prices` VALUES (24796, 24771, 'buy', 10.00, '2025-10-10 00:12:26', '2025-10-10 00:12:26');
INSERT INTO `product_prices` VALUES (24797, 24771, 'sucursalA', 22.00, '2025-10-10 00:12:26', '2025-10-10 00:12:26');
INSERT INTO `product_prices` VALUES (24798, 24772, 'buy', 37.00, '2025-10-10 00:12:26', '2025-10-10 00:12:26');
INSERT INTO `product_prices` VALUES (24799, 24772, 'sucursalA', 50.00, '2025-10-10 00:12:26', '2025-10-10 00:12:26');
INSERT INTO `product_prices` VALUES (24800, 24773, 'buy', 50.00, '2025-10-10 00:12:27', '2025-10-10 00:12:27');
INSERT INTO `product_prices` VALUES (24801, 24773, 'sucursalA', 80.00, '2025-10-10 00:12:27', '2025-10-10 00:12:27');
INSERT INTO `product_prices` VALUES (24814, 24780, 'buy', 50.00, '2025-11-07 15:51:33', '2025-11-07 15:51:33');
INSERT INTO `product_prices` VALUES (24815, 24780, 'sucursalB', 90.00, '2025-11-07 15:51:33', '2025-11-07 15:51:33');
INSERT INTO `product_prices` VALUES (24816, 24781, 'buy', 50.00, '2025-11-07 15:51:33', '2025-11-07 15:51:33');
INSERT INTO `product_prices` VALUES (24817, 24781, 'sucursalB', 90.00, '2025-11-07 15:51:33', '2025-11-07 15:51:33');
INSERT INTO `product_prices` VALUES (24818, 24782, 'buy', 6.00, '2025-11-07 15:51:33', '2025-11-07 15:51:33');
INSERT INTO `product_prices` VALUES (24819, 24782, 'sucursalA', 15.00, '2025-11-07 15:51:33', '2025-11-07 15:51:33');
INSERT INTO `product_prices` VALUES (24820, 24783, 'buy', 6.00, '2025-11-07 15:51:33', '2025-11-07 15:51:33');
INSERT INTO `product_prices` VALUES (24821, 24783, 'sucursalA', 15.00, '2025-11-07 15:51:33', '2025-11-07 15:51:33');
INSERT INTO `product_prices` VALUES (24822, 24784, 'buy', 6.00, '2025-11-07 15:51:33', '2025-11-07 15:51:33');
INSERT INTO `product_prices` VALUES (24823, 24784, 'sucursalA', 15.00, '2025-11-07 15:51:33', '2025-11-07 15:51:33');
INSERT INTO `product_prices` VALUES (24824, 24785, 'buy', 6.00, '2025-11-07 15:51:33', '2025-11-07 15:51:33');
INSERT INTO `product_prices` VALUES (24825, 24785, 'sucursalA', 15.00, '2025-11-07 15:51:33', '2025-11-07 15:51:33');
INSERT INTO `product_prices` VALUES (24826, 24786, 'buy', 50.00, '2025-11-07 15:55:58', '2025-11-07 15:55:58');
INSERT INTO `product_prices` VALUES (24827, 24786, 'sucursalB', 90.00, '2025-11-07 15:55:58', '2025-11-07 15:55:58');
INSERT INTO `product_prices` VALUES (24828, 24787, 'buy', 50.00, '2025-11-07 15:55:58', '2025-11-07 15:55:58');
INSERT INTO `product_prices` VALUES (24829, 24787, 'sucursalB', 90.00, '2025-11-07 15:55:58', '2025-11-07 15:55:58');
INSERT INTO `product_prices` VALUES (24832, 24789, 'buy', 6.00, '2025-11-07 15:55:58', '2025-11-07 15:55:58');
INSERT INTO `product_prices` VALUES (24833, 24789, 'sucursalA', 15.00, '2025-11-07 15:55:58', '2025-11-07 15:55:58');
INSERT INTO `product_prices` VALUES (24834, 24790, 'buy', 6.00, '2025-11-07 15:55:58', '2025-11-07 15:55:58');
INSERT INTO `product_prices` VALUES (24835, 24790, 'sucursalA', 15.00, '2025-11-07 15:55:58', '2025-11-07 15:55:58');
INSERT INTO `product_prices` VALUES (24836, 24791, 'buy', 6.00, '2025-11-07 15:55:58', '2025-11-07 15:55:58');
INSERT INTO `product_prices` VALUES (24837, 24791, 'sucursalA', 15.00, '2025-11-07 15:55:58', '2025-11-07 15:55:58');
INSERT INTO `product_prices` VALUES (24838, 24792, 'buy', 100.00, '2025-11-21 13:11:16', '2025-11-21 13:11:16');
INSERT INTO `product_prices` VALUES (24839, 24792, 'wholesale', 90.00, '2025-11-21 13:11:16', '2025-11-21 13:11:16');
INSERT INTO `product_prices` VALUES (24840, 24792, 'sucursalA', 110.00, '2025-11-21 13:11:16', '2025-11-21 13:11:16');
INSERT INTO `product_prices` VALUES (24841, 24792, 'sucursalB', 115.00, '2025-11-21 13:11:16', '2025-11-21 13:11:16');
INSERT INTO `product_prices` VALUES (24842, 24788, 'buy', 6.00, NULL, NULL);
INSERT INTO `product_prices` VALUES (24843, 24788, 'sucursalA', 15.00, NULL, NULL);

-- ----------------------------
-- Table structure for products
-- ----------------------------
DROP TABLE IF EXISTS `products`;
CREATE TABLE `products`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `code_bar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `code_sku` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `model` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `control_type` enum('codigo_unico','cantidad') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT 'cantidad',
  `user_register` bigint UNSIGNED NULL DEFAULT NULL,
  `user_update` bigint UNSIGNED NULL DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `tienda_id` bigint UNSIGNED NULL DEFAULT NULL,
  `brand_id` bigint UNSIGNED NOT NULL,
  `unit_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `unique_code_sku_bar`(`code_sku` ASC, `code_bar` ASC) USING BTREE,
  UNIQUE INDEX `products_code_unique`(`code` ASC) USING BTREE,
  INDEX `products_user_register_foreign`(`user_register` ASC) USING BTREE,
  INDEX `products_user_update_foreign`(`user_update` ASC) USING BTREE,
  INDEX `products_brand_id_foreign`(`brand_id` ASC) USING BTREE,
  INDEX `products_unit_id_foreign`(`unit_id` ASC) USING BTREE,
  INDEX `products_tienda_id_foreign`(`tienda_id` ASC) USING BTREE,
  CONSTRAINT `products_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `products_tienda_id_foreign` FOREIGN KEY (`tienda_id`) REFERENCES `tiendas` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT,
  CONSTRAINT `products_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `products_user_register_foreign` FOREIGN KEY (`user_register`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `products_user_update_foreign` FOREIGN KEY (`user_update`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 24793 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of products
-- ----------------------------
INSERT INTO `products` VALUES (1, '0000001', '15600123', 'DE151037', 'SISTEMA ARRASTRE', 'PULSAR 180', 'A-20', 0, 'cantidad', 1, 1, '2025-06-09 19:00:16', '2025-10-14 08:47:57', NULL, 1, 1, '2025-06-10 00:00:16', '2025-10-14 13:47:57');
INSERT INTO `products` VALUES (24751, '0000002', '6454545454', '00023', 'NUEVA PC', 'RYzem', 'Paita', 0, 'cantidad', 1, 1, '2025-07-29 22:23:15', '2025-10-07 12:15:09', NULL, 8, 5, '2025-07-30 03:23:15', '2025-10-07 17:15:09');
INSERT INTO `products` VALUES (24756, '0000003', '115144454', '00023541125', 'GIGABYTE PCQ', 'Gygabite', 'Paita', 0, 'cantidad', 1, 1, '2025-07-29 23:19:08', '2025-10-07 12:15:02', NULL, 12, 5, '2025-07-30 04:19:08', '2025-10-07 17:15:02');
INSERT INTO `products` VALUES (24757, '0000004', '45121411', '055141639', 'Nokia C2-02', 'C2-02', 'Paita', 0, 'cantidad', 1, 1, '2025-07-30 08:57:34', '2025-10-07 12:15:22', NULL, 13, 1, '2025-07-30 13:57:34', '2025-10-07 17:15:22');
INSERT INTO `products` VALUES (24758, '0000005', '0254122', '000022', 'Nokia C3', 'C3', NULL, 0, 'codigo_unico', 1, 1, '2025-07-30 09:11:14', '2025-10-07 12:15:17', NULL, 13, 1, '2025-07-30 14:11:14', '2025-10-07 17:15:17');
INSERT INTO `products` VALUES (24759, '0000006', '0555195', '000002010', 'Laptop AMD Ryzen', 'HP 15-fd0055la', 'Piura', 0, 'cantidad', 1, 1, '2025-07-30 09:19:07', '2025-10-07 12:15:41', NULL, 14, 1, '2025-07-30 14:19:07', '2025-10-07 17:15:41');
INSERT INTO `products` VALUES (24760, '0000007', '487845515', '0542110', 'Huawei P20 Lite 32GB 4GB Negro', 'P20 Lite 32GB 4GB Negro', 'Lima', 0, 'codigo_unico', 1, 1, '2025-07-30 09:43:23', '2025-10-07 12:15:37', NULL, 15, 1, '2025-07-30 14:43:23', '2025-10-07 17:15:37');
INSERT INTO `products` VALUES (24761, '0000008', '5451514', '164845127', 'Samsung Galaxy A03', 'Galaxy A03', 'Paita', 0, 'codigo_unico', 1, 1, '2025-07-31 13:43:24', '2025-10-07 12:15:46', NULL, 16, 1, '2025-07-31 18:43:24', '2025-10-07 17:15:46');
INSERT INTO `products` VALUES (24762, '0000009', '15451124', '0127874', 'Textura Mate, Piel de Durazno Antideslizante, Fina y Suave.', 'Carcasa', 'Piura', 0, 'cantidad', 1, 1, '2025-07-31 13:51:17', '2025-10-07 12:15:32', NULL, 15, 6, '2025-07-31 18:51:17', '2025-10-07 17:15:32');
INSERT INTO `products` VALUES (24763, '0000010', '36dk0036-1', '36DK0036', 'SISTEMA ARRASTRE', 'PULSAR 180', 'A-20', 0, 'cantidad', 1, 1, '2025-08-08 14:54:18', '2025-10-07 12:15:27', NULL, 1, 1, '2025-08-08 19:54:18', '2025-10-07 17:15:27');
INSERT INTO `products` VALUES (24766, '0000011', 'dk150138-1', 'DK151038', 'PASTILLA FRENO', 'PULSAR 180', 'A-20', 0, 'codigo_unico', 1, 1, '2025-08-09 08:43:42', '2025-10-14 08:47:12', NULL, 1, 1, '2025-08-09 13:43:42', '2025-10-14 13:47:12');
INSERT INTO `products` VALUES (24768, '0000012', '1160-006', '1160-006', 'SOPORTE MOTOR', 'FURGON 250', 'H-25', 0, 'cantidad', 1, 1, '2025-10-09 19:12:26', '2025-10-14 08:47:29', 3, 17, 1, '2025-10-10 00:12:26', '2025-10-14 13:47:29');
INSERT INTO `products` VALUES (24769, '0000013', '1402-SM-C250', '1402-SM-C250', 'SOPORTE MOTOR', 'CARGUERO 250', 'H-25', 0, 'cantidad', 1, 1, '2025-10-09 19:12:26', '2025-10-14 08:48:02', 3, 18, 1, '2025-10-10 00:12:26', '2025-10-14 13:48:02');
INSERT INTO `products` VALUES (24770, '0000014', '1402-SM-L', '1402-SM-L', 'SOPORTE MOTOR', 'LINEAL', 'H-25', 0, 'cantidad', 1, 1, '2025-10-09 19:12:26', '2025-10-14 08:47:34', 3, 18, 1, '2025-10-10 00:12:26', '2025-10-14 13:47:34');
INSERT INTO `products` VALUES (24771, '0000015', '42755-RES-MFG01', '42755-RES-MFG01', 'SOPORTE MOTOR', 'CARGUERO', 'E-25', 0, 'cantidad', 1, 1, '2025-10-09 19:12:26', '2025-10-14 08:47:19', 3, 19, 7, '2025-10-10 00:12:26', '2025-10-14 13:47:19');
INSERT INTO `products` VALUES (24772, '0000016', '510200-BUJ-KC', '510200-BUJ-KC', 'SOPORTE MOTOR', 'BUJE CARGUERO', 'E-25', 0, 'cantidad', 1, 1, '2025-10-09 19:12:26', '2025-10-14 08:47:53', 3, 19, 8, '2025-10-10 00:12:26', '2025-10-14 13:47:53');
INSERT INTO `products` VALUES (24773, '0000017', '1171', '1171', 'SOPORTE MOTOR', 'RESORTE C/BOCINA MTF', 'E-25', 0, 'cantidad', 1, 1, '2025-10-09 19:12:27', '2025-10-14 08:47:24', 3, 20, 1, '2025-10-10 00:12:27', '2025-10-14 13:47:24');
INSERT INTO `products` VALUES (24780, '0000018', '1402\'AL\'CGL125', '1402-AL-CGL125', 'ASIENTO LINEAL', 'CGL-125', 'H-1', 0, 'cantidad', 1, 1, '2025-11-07 09:51:33', '2025-11-07 09:52:22', 6, 18, 1, '2025-11-07 15:51:33', '2025-11-07 15:52:22');
INSERT INTO `products` VALUES (24781, '0000019', '77200\'krf\'890\'kc', '77200-KRF-890-KC', 'ASIENTO LINEAL', 'GL', 'H-1', 0, 'cantidad', 1, 1, '2025-11-07 09:51:33', '2025-11-07 09:52:29', 6, 19, 1, '2025-11-07 15:51:33', '2025-11-07 15:52:29');
INSERT INTO `products` VALUES (24782, '0000020', '06455\'sc\'3s', '06455-SC-3S', 'PASTILLA FRENO', 'ITALIKA CS125/SCOOTER', 'H-4', 0, 'cantidad', 1, 1, '2025-11-07 09:51:33', '2025-11-07 09:52:37', 7, 19, 10, '2025-11-07 15:51:33', '2025-11-07 15:52:37');
INSERT INTO `products` VALUES (24783, '0000021', '06435\'fz6\'3s', '06435-FZ6-3S', 'PASTILLA FRENO', 'FZ6 600', 'H-4', 0, 'cantidad', 1, 1, '2025-11-07 09:51:33', '2025-11-07 09:52:46', 7, 19, 10, '2025-11-07 15:51:33', '2025-11-07 15:52:46');
INSERT INTO `products` VALUES (24784, '0000022', '06455\'dy110\'02', '06455-DY110-02', 'PASTILLA FRENO', 'DY 110', 'H-4', 0, 'cantidad', 1, 1, '2025-11-07 09:51:33', '2025-11-07 09:52:41', 7, 19, 10, '2025-11-07 15:51:33', '2025-11-07 15:52:41');
INSERT INTO `products` VALUES (24785, '0000023', '06455\'wr500', '06455-WR500', 'PASTILLA FRENO', 'GS 150', 'H-4', 0, 'cantidad', 1, 1, '2025-11-07 09:51:33', '2025-11-07 09:52:33', 7, 19, 10, '2025-11-07 15:51:33', '2025-11-07 15:52:33');
INSERT INTO `products` VALUES (24786, '0000024', '1134\'027\'cv', '1134-027-CV', 'ASIENTO LINEAL', 'CGL-125', 'H-1', 1, 'cantidad', 1, NULL, '2025-11-07 09:55:58', '2025-11-07 09:55:58', 6, 18, 1, '2025-11-07 15:55:58', '2025-11-07 15:55:58');
INSERT INTO `products` VALUES (24787, '0000025', '1134\'025\'CV', '1134-025-CV', 'ASIENTO LINEAL', 'GL', 'H-1', 1, 'cantidad', 1, NULL, '2025-11-07 09:55:58', '2025-11-07 09:55:58', 6, 19, 1, '2025-11-07 15:55:58', '2025-11-07 15:55:58');
INSERT INTO `products` VALUES (24788, '0000026', '1134\'007\'CV', '1134-007-CV', 'PASTILLA FRENO', 'ITALIKA CS125/SCOOTER', 'H-4', 1, 'cantidad', 1, NULL, '2025-11-07 09:55:58', '2025-11-07 09:55:58', 7, 19, 1, '2025-11-07 15:55:58', '2025-11-07 15:55:58');
INSERT INTO `products` VALUES (24789, '0000027', '1134\'020\'cv', '1134-020-CV', 'PASTILLA FRENO', 'FZ6 600', 'H-4', 1, 'cantidad', 1, NULL, '2025-11-07 09:55:58', '2025-11-07 09:55:58', 7, 19, 1, '2025-11-07 15:55:58', '2025-11-07 15:55:58');
INSERT INTO `products` VALUES (24790, '0000028', '1134\'023\'cv', '1134-023-CV', 'PASTILLA FRENO', 'DY 110', 'H-4', 1, 'cantidad', 1, NULL, '2025-11-07 09:55:58', '2025-11-07 09:55:58', 7, 19, 1, '2025-11-07 15:55:58', '2025-11-07 15:55:58');
INSERT INTO `products` VALUES (24791, '0000029', '1134\'019\'CV', '1134-019-CV', 'PASTILLA FRENO', 'GS 150', 'H-4', 1, 'cantidad', 1, NULL, '2025-11-07 09:55:58', '2025-11-07 09:55:58', 7, 19, 1, '2025-11-07 15:55:58', '2025-11-07 15:55:58');
INSERT INTO `products` VALUES (24792, '0000030', '156001', 'P001', 'Shampoo Hidratante 500ml', 'XYZ-123', 'Pasillo 3, Estante 2', 1, 'cantidad', 1, NULL, '2025-11-21 08:11:16', '2025-11-21 08:11:16', 1, 1, 1, '2025-11-21 13:11:16', '2025-11-21 13:11:16');

-- ----------------------------
-- Table structure for provinces
-- ----------------------------
DROP TABLE IF EXISTS `provinces`;
CREATE TABLE `provinces`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `regions_id` bigint UNSIGNED NOT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `provinces_regions_id_foreign`(`regions_id` ASC) USING BTREE,
  CONSTRAINT `provinces_regions_id_foreign` FOREIGN KEY (`regions_id`) REFERENCES `regions` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 196 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of provinces
-- ----------------------------
INSERT INTO `provinces` VALUES (1, 'Bagua', 1, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (2, 'Bongara', 1, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (3, 'Chachapoyas', 1, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (4, 'Condorcanqui', 1, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (5, 'Luya', 1, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (6, 'Rodriguez De Mendoza', 1, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (7, 'Utcubamba', 1, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (8, 'Aija', 2, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (9, 'Antonio Raimondi', 2, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (10, 'Asuncion', 2, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (11, 'Bolognesi', 2, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (12, 'Carhuaz', 2, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (13, 'Carlos Fermin Fitzcarrald', 2, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (14, 'Casma', 2, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (15, 'Corongo', 2, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (16, 'Huaraz', 2, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (17, 'Huari', 2, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (18, 'Huarmey', 2, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (19, 'Huaylas', 2, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (20, 'Mariscal Luzuriaga', 2, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (21, 'Ocros', 2, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (22, 'Pallasca', 2, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (23, 'Pomabamba', 2, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (24, 'Recuay', 2, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (25, 'Santa', 2, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (26, 'Sihuas', 2, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (27, 'Yungay', 2, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (28, 'Abancay', 3, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (29, 'Andahuaylas', 3, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (30, 'Antabamba', 3, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (31, 'Aymaraes', 3, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (32, 'Chincheros', 3, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (33, 'Cotabambas', 3, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (34, 'Grau', 3, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (35, 'Arequipa', 4, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (36, 'Camana', 4, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (37, 'Caraveli', 4, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (38, 'Castilla', 4, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (39, 'Caylloma', 4, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (40, 'Condesuyos', 4, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (41, 'Islay', 4, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (42, 'La Union', 4, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (43, 'Cangallo', 5, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (44, 'Huamanga', 5, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (45, 'Huanca Sancos', 5, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (46, 'Huanta', 5, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (47, 'La Mar', 5, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (48, 'Lucanas', 5, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (49, 'Parinacochas', 5, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (50, 'Paucar Del Sara Sara', 5, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (51, 'Sucre', 5, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (52, 'Victor Fajardo', 5, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (53, 'Vilcas Huaman', 5, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (54, 'Cajabamba', 6, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (55, 'Cajamarca', 6, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (56, 'Celendin', 6, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (57, 'Chota', 6, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (58, 'Contumaza', 6, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (59, 'Cutervo', 6, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (60, 'Hualgayoc', 6, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (61, 'Jaen', 6, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (62, 'San Ignacio', 6, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (63, 'San Marcos', 6, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (64, 'San Miguel', 6, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (65, 'San Pablo', 6, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (66, 'Santa Cruz', 6, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (67, 'Callao', 7, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (68, 'Acomayo', 8, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (69, 'Anta', 8, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (70, 'Calca', 8, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (71, 'Canas', 8, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (72, 'Canchis', 8, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (73, 'Chumbivilcas', 8, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (74, 'Cusco', 8, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (75, 'Espinar', 8, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (76, 'La Convencion', 8, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (77, 'Paruro', 8, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (78, 'Paucartambo', 8, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (79, 'Quispicanchi', 8, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (80, 'Urubamba', 8, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (81, 'Acobamba', 9, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (82, 'Angaraes', 9, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (83, 'Castrovirreyna', 9, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (84, 'Churcampa', 9, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (85, 'Huancavelica', 9, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (86, 'Huaytara', 9, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (87, 'Tayacaja', 9, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (88, 'Ambo', 10, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (89, 'Dos De Mayo', 10, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (90, 'Huacaybamba', 10, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (91, 'Huamalies', 10, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (92, 'Huanuco', 10, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (93, 'Lauricocha', 10, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (94, 'Leoncio Prado', 10, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (95, 'Marañon', 10, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (96, 'Pachitea', 10, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (97, 'Puerto Inca', 10, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (98, 'Yarowilca', 10, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (99, 'Chincha', 11, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (100, 'Ica', 11, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (101, 'Nazca', 11, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (102, 'Palpa', 11, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (103, 'Pisco', 11, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (104, 'Chanchamayo', 12, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (105, 'Chupaca', 12, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (106, 'Concepcion', 12, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (107, 'Huancayo', 12, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (108, 'Jauja', 12, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (109, 'Junin', 12, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (110, 'Satipo', 12, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (111, 'Tarma', 12, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (112, 'Yauli', 12, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (113, 'Ascope', 13, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (114, 'Bolivar', 13, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (115, 'Chepen', 13, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (116, 'Gran Chimu', 13, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (117, 'Julcan', 13, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (118, 'Otuzco', 13, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (119, 'Pacasmayo', 13, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (120, 'Pataz', 13, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (121, 'Sanchez Carrion', 13, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (122, 'Santiago De Chuco', 13, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (123, 'Trujillo', 13, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (124, 'Viru', 13, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (125, 'Chiclayo', 14, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (126, 'Ferreñafe', 14, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (127, 'Lambayeque', 14, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (128, 'Barranca', 15, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (129, 'Cajatambo', 15, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (130, 'Cañete', 15, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (131, 'Canta', 15, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (132, 'Huaral', 15, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (133, 'Huarochiri', 15, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (134, 'Huaura', 15, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (135, 'Lima', 15, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (136, 'Oyon', 15, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (137, 'Yauyos', 15, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (138, 'Alto Amazonas', 16, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (139, 'Datem Del Marañon', 16, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (140, 'Loreto', 16, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (141, 'Mariscal Ramon Castilla', 16, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (142, 'Maynas', 16, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (143, 'Requena', 16, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (144, 'Ucayali', 16, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (145, 'Manu', 17, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (146, 'Tahuamanu', 17, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (147, 'Tambopata', 17, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (148, 'General Sanchez Cerro', 18, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (149, 'Ilo', 18, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (150, 'Mariscal Nieto', 18, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (151, 'Daniel Alcides Carrion', 19, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (152, 'Oxapampa', 19, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (153, 'Pasco', 19, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (154, 'Ayabaca', 20, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (155, 'Huancabamba', 20, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (156, 'Morropon', 20, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (157, 'Paita', 20, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (158, 'Piura', 20, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (159, 'Sechura', 20, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (160, 'Sullana', 20, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (161, 'Talara', 20, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (162, 'Azangaro', 21, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (163, 'Carabaya', 21, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (164, 'Chucuito', 21, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (165, 'El Collao', 21, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (166, 'Huancane', 21, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (167, 'Lampa', 21, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (168, 'Melgar', 21, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (169, 'Moho', 21, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (170, 'Puno', 21, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (171, 'San Antonio De Putina', 21, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (172, 'San Roman', 21, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (173, 'Sandia', 21, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (174, 'Yunguyo', 21, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (175, 'Bellavista', 22, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (176, 'El Dorado', 22, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (177, 'Huallaga', 22, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (178, 'Lamas', 22, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (179, 'Mariscal Caceres', 22, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (180, 'Moyobamba', 22, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (181, 'Picota', 22, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (182, 'Rioja', 22, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (183, 'San Martin', 22, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (184, 'Tocache', 22, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (185, 'Candarave', 23, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (186, 'Jorge Basadre', 23, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (187, 'Tacna', 23, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (188, 'Tarata', 23, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (189, 'Contralmirante Villar', 24, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (190, 'Tumbes', 24, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (191, 'Zarumilla', 24, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (192, 'Atalaya', 25, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (193, 'Coronel Portillo', 25, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (194, 'Padre Abad', 25, '1', NULL, NULL);
INSERT INTO `provinces` VALUES (195, 'Purus', 25, '1', NULL, NULL);

-- ----------------------------
-- Table structure for quotation_items
-- ----------------------------
DROP TABLE IF EXISTS `quotation_items`;
CREATE TABLE `quotation_items`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `quotation_id` bigint UNSIGNED NOT NULL,
  `item_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_id` bigint UNSIGNED NULL DEFAULT NULL,
  `quantity` int NULL DEFAULT NULL,
  `unit_price` decimal(10, 2) NOT NULL,
  `product_prices_id` bigint UNSIGNED NULL DEFAULT NULL,
  `mechanics_id` bigint UNSIGNED NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `quotation_items_quotation_id_foreign`(`quotation_id` ASC) USING BTREE,
  INDEX `quotation_items_product_prices_id_foreign`(`product_prices_id` ASC) USING BTREE,
  INDEX `quotation_items_mechanics_id_foreign`(`mechanics_id` ASC) USING BTREE,
  CONSTRAINT `quotation_items_mechanics_id_foreign` FOREIGN KEY (`mechanics_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `quotation_items_product_prices_id_foreign` FOREIGN KEY (`product_prices_id`) REFERENCES `product_prices` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `quotation_items_quotation_id_foreign` FOREIGN KEY (`quotation_id`) REFERENCES `quotations` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of quotation_items
-- ----------------------------
INSERT INTO `quotation_items` VALUES (3, 3, 'App\\Models\\Product', 1, 1, 30.00, 24787, NULL, '2025-11-19 14:12:22', '2025-11-19 14:12:22');
INSERT INTO `quotation_items` VALUES (4, 3, 'App\\Models\\ServiceSale', 1, 1, 60.00, NULL, 3, '2025-11-19 14:12:22', '2025-11-19 14:12:22');

-- ----------------------------
-- Table structure for quotation_payment_method
-- ----------------------------
DROP TABLE IF EXISTS `quotation_payment_method`;
CREATE TABLE `quotation_payment_method`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `quotation_id` bigint UNSIGNED NOT NULL,
  `payment_method_id` bigint UNSIGNED NOT NULL,
  `amount` decimal(10, 2) NOT NULL DEFAULT 0.00,
  `order` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `quotation_payment_method_quotation_id_foreign`(`quotation_id` ASC) USING BTREE,
  INDEX `quotation_payment_method_payment_method_id_foreign`(`payment_method_id` ASC) USING BTREE,
  CONSTRAINT `quotation_payment_method_payment_method_id_foreign` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `quotation_payment_method_quotation_id_foreign` FOREIGN KEY (`quotation_id`) REFERENCES `quotations` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of quotation_payment_method
-- ----------------------------
INSERT INTO `quotation_payment_method` VALUES (4, 3, 2, 212.00, 2, '2025-11-19 14:12:22', '2025-11-19 14:12:22');
INSERT INTO `quotation_payment_method` VALUES (5, 3, 3, -122.00, 1, '2025-11-19 14:12:22', '2025-11-19 14:12:22');

-- ----------------------------
-- Table structure for quotations
-- ----------------------------
DROP TABLE IF EXISTS `quotations`;
CREATE TABLE `quotations`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `customer_dni` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `customer_names_surnames` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `total_price` decimal(10, 2) NOT NULL,
  `igv` decimal(10, 2) NOT NULL,
  `observation` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `nro_dias` int NULL DEFAULT NULL,
  `customer_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `status_sale` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `document_type_id` bigint UNSIGNED NULL DEFAULT NULL,
  `districts_id` bigint UNSIGNED NULL DEFAULT NULL,
  `payments_id` bigint UNSIGNED NULL DEFAULT NULL,
  `companies_id` bigint UNSIGNED NULL DEFAULT NULL,
  `mechanics_id` bigint UNSIGNED NULL DEFAULT NULL,
  `user_register` bigint UNSIGNED NULL DEFAULT NULL,
  `user_update` bigint UNSIGNED NULL DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fecha_vencimiento` date NULL DEFAULT NULL,
  `fecha_actualizacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `quotations_code_unique`(`code` ASC) USING BTREE,
  INDEX `quotations_document_type_id_foreign`(`document_type_id` ASC) USING BTREE,
  INDEX `quotations_districts_id_foreign`(`districts_id` ASC) USING BTREE,
  INDEX `quotations_payments_id_foreign`(`payments_id` ASC) USING BTREE,
  INDEX `quotations_companies_id_foreign`(`companies_id` ASC) USING BTREE,
  INDEX `quotations_mechanics_id_foreign`(`mechanics_id` ASC) USING BTREE,
  INDEX `quotations_user_register_foreign`(`user_register` ASC) USING BTREE,
  INDEX `quotations_user_update_foreign`(`user_update` ASC) USING BTREE,
  CONSTRAINT `quotations_companies_id_foreign` FOREIGN KEY (`companies_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `quotations_districts_id_foreign` FOREIGN KEY (`districts_id`) REFERENCES `districts` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `quotations_document_type_id_foreign` FOREIGN KEY (`document_type_id`) REFERENCES `document_types` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `quotations_mechanics_id_foreign` FOREIGN KEY (`mechanics_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `quotations_payments_id_foreign` FOREIGN KEY (`payments_id`) REFERENCES `payments` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `quotations_user_register_foreign` FOREIGN KEY (`user_register`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `quotations_user_update_foreign` FOREIGN KEY (`user_update`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of quotations
-- ----------------------------
INSERT INTO `quotations` VALUES (3, '0000002', '77426200', 'ZAPATA TORRES BRENDY YOSELY', 90.00, 16.20, NULL, NULL, 'dwsscs', '0', '0', 1, 280, 1, 1, 3, 1, 1, '2025-11-19 09:48:44', NULL, '2025-11-19 09:48:44', '2025-11-19 14:12:22', '2025-11-19 14:48:44');

-- ----------------------------
-- Table structure for regions
-- ----------------------------
DROP TABLE IF EXISTS `regions`;
CREATE TABLE `regions`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `regions_name_unique`(`name` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 26 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of regions
-- ----------------------------
INSERT INTO `regions` VALUES (1, 'Amazonas', '1', NULL, NULL);
INSERT INTO `regions` VALUES (2, 'Ancash', '1', NULL, NULL);
INSERT INTO `regions` VALUES (3, 'Apurimac', '1', NULL, NULL);
INSERT INTO `regions` VALUES (4, 'Arequipa', '1', NULL, NULL);
INSERT INTO `regions` VALUES (5, 'Ayacucho', '1', NULL, NULL);
INSERT INTO `regions` VALUES (6, 'Cajamarca', '1', NULL, NULL);
INSERT INTO `regions` VALUES (7, 'Callao', '1', NULL, NULL);
INSERT INTO `regions` VALUES (8, 'Cusco', '1', NULL, NULL);
INSERT INTO `regions` VALUES (9, 'Huancavelica', '1', NULL, NULL);
INSERT INTO `regions` VALUES (10, 'Huanuco', '1', NULL, NULL);
INSERT INTO `regions` VALUES (11, 'Ica', '1', NULL, NULL);
INSERT INTO `regions` VALUES (12, 'Junin', '1', NULL, NULL);
INSERT INTO `regions` VALUES (13, 'La Libertad', '1', NULL, NULL);
INSERT INTO `regions` VALUES (14, 'Lambayeque', '1', NULL, NULL);
INSERT INTO `regions` VALUES (15, 'Lima', '1', NULL, NULL);
INSERT INTO `regions` VALUES (16, 'Loreto', '1', NULL, NULL);
INSERT INTO `regions` VALUES (17, 'Madre De Dios', '1', NULL, NULL);
INSERT INTO `regions` VALUES (18, 'Moquegua', '1', NULL, NULL);
INSERT INTO `regions` VALUES (19, 'Pasco', '1', NULL, NULL);
INSERT INTO `regions` VALUES (20, 'Piura', '1', NULL, NULL);
INSERT INTO `regions` VALUES (21, 'Puno', '1', NULL, NULL);
INSERT INTO `regions` VALUES (22, 'San Martin', '1', NULL, NULL);
INSERT INTO `regions` VALUES (23, 'Tacna', '1', NULL, NULL);
INSERT INTO `regions` VALUES (24, 'Tumbes', '1', NULL, NULL);
INSERT INTO `regions` VALUES (25, 'Ucayali', '1', NULL, NULL);

-- ----------------------------
-- Table structure for role_has_permissions
-- ----------------------------
DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE `role_has_permissions`  (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`, `role_id`) USING BTREE,
  INDEX `role_has_permissions_role_id_foreign`(`role_id` ASC) USING BTREE,
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of role_has_permissions
-- ----------------------------
INSERT INTO `role_has_permissions` VALUES (1, 1);
INSERT INTO `role_has_permissions` VALUES (2, 1);
INSERT INTO `role_has_permissions` VALUES (3, 1);
INSERT INTO `role_has_permissions` VALUES (4, 1);
INSERT INTO `role_has_permissions` VALUES (5, 1);
INSERT INTO `role_has_permissions` VALUES (6, 1);
INSERT INTO `role_has_permissions` VALUES (7, 1);
INSERT INTO `role_has_permissions` VALUES (8, 1);
INSERT INTO `role_has_permissions` VALUES (9, 1);
INSERT INTO `role_has_permissions` VALUES (10, 1);
INSERT INTO `role_has_permissions` VALUES (11, 1);
INSERT INTO `role_has_permissions` VALUES (12, 1);
INSERT INTO `role_has_permissions` VALUES (13, 1);
INSERT INTO `role_has_permissions` VALUES (14, 1);
INSERT INTO `role_has_permissions` VALUES (15, 1);
INSERT INTO `role_has_permissions` VALUES (16, 1);
INSERT INTO `role_has_permissions` VALUES (17, 1);
INSERT INTO `role_has_permissions` VALUES (18, 1);
INSERT INTO `role_has_permissions` VALUES (19, 1);
INSERT INTO `role_has_permissions` VALUES (20, 1);
INSERT INTO `role_has_permissions` VALUES (21, 1);
INSERT INTO `role_has_permissions` VALUES (22, 1);
INSERT INTO `role_has_permissions` VALUES (23, 1);
INSERT INTO `role_has_permissions` VALUES (24, 1);
INSERT INTO `role_has_permissions` VALUES (25, 1);
INSERT INTO `role_has_permissions` VALUES (26, 1);
INSERT INTO `role_has_permissions` VALUES (27, 1);
INSERT INTO `role_has_permissions` VALUES (28, 1);
INSERT INTO `role_has_permissions` VALUES (29, 1);
INSERT INTO `role_has_permissions` VALUES (30, 1);
INSERT INTO `role_has_permissions` VALUES (31, 1);
INSERT INTO `role_has_permissions` VALUES (32, 1);
INSERT INTO `role_has_permissions` VALUES (33, 1);
INSERT INTO `role_has_permissions` VALUES (34, 1);
INSERT INTO `role_has_permissions` VALUES (35, 1);
INSERT INTO `role_has_permissions` VALUES (36, 1);
INSERT INTO `role_has_permissions` VALUES (37, 1);
INSERT INTO `role_has_permissions` VALUES (38, 1);
INSERT INTO `role_has_permissions` VALUES (39, 1);
INSERT INTO `role_has_permissions` VALUES (40, 1);
INSERT INTO `role_has_permissions` VALUES (41, 1);
INSERT INTO `role_has_permissions` VALUES (42, 1);
INSERT INTO `role_has_permissions` VALUES (43, 1);
INSERT INTO `role_has_permissions` VALUES (14, 2);
INSERT INTO `role_has_permissions` VALUES (14, 3);
INSERT INTO `role_has_permissions` VALUES (15, 3);
INSERT INTO `role_has_permissions` VALUES (16, 3);
INSERT INTO `role_has_permissions` VALUES (17, 3);
INSERT INTO `role_has_permissions` VALUES (18, 3);
INSERT INTO `role_has_permissions` VALUES (19, 3);
INSERT INTO `role_has_permissions` VALUES (20, 3);
INSERT INTO `role_has_permissions` VALUES (21, 3);
INSERT INTO `role_has_permissions` VALUES (22, 3);
INSERT INTO `role_has_permissions` VALUES (23, 3);
INSERT INTO `role_has_permissions` VALUES (24, 3);
INSERT INTO `role_has_permissions` VALUES (25, 3);
INSERT INTO `role_has_permissions` VALUES (26, 3);
INSERT INTO `role_has_permissions` VALUES (27, 3);
INSERT INTO `role_has_permissions` VALUES (28, 3);
INSERT INTO `role_has_permissions` VALUES (29, 3);
INSERT INTO `role_has_permissions` VALUES (30, 3);
INSERT INTO `role_has_permissions` VALUES (31, 3);
INSERT INTO `role_has_permissions` VALUES (32, 3);
INSERT INTO `role_has_permissions` VALUES (33, 3);
INSERT INTO `role_has_permissions` VALUES (34, 3);
INSERT INTO `role_has_permissions` VALUES (35, 3);
INSERT INTO `role_has_permissions` VALUES (36, 3);
INSERT INTO `role_has_permissions` VALUES (37, 3);
INSERT INTO `role_has_permissions` VALUES (38, 3);
INSERT INTO `role_has_permissions` VALUES (39, 3);
INSERT INTO `role_has_permissions` VALUES (40, 3);
INSERT INTO `role_has_permissions` VALUES (41, 3);
INSERT INTO `role_has_permissions` VALUES (42, 3);
INSERT INTO `role_has_permissions` VALUES (43, 3);

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `roles_name_guard_name_unique`(`name` ASC, `guard_name` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES (1, 'administrador', 'web', '2025-05-05 16:22:28', '2025-11-18 21:26:04');
INSERT INTO `roles` VALUES (2, 'mecanico', 'web', '2025-05-05 16:22:28', '2025-05-05 16:22:28');
INSERT INTO `roles` VALUES (3, 'ventas', 'web', '2025-05-05 16:22:28', '2025-05-05 16:22:28');

-- ----------------------------
-- Table structure for sale_items
-- ----------------------------
DROP TABLE IF EXISTS `sale_items`;
CREATE TABLE `sale_items`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `sale_id` bigint UNSIGNED NOT NULL,
  `item_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_id` bigint UNSIGNED NULL DEFAULT NULL,
  `quantity` int NULL DEFAULT NULL,
  `unit_price` decimal(10, 2) NOT NULL,
  `mechanics_id` bigint UNSIGNED NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `sale_items_sale_id_foreign`(`sale_id` ASC) USING BTREE,
  INDEX `sale_items_mechanics_id_foreign`(`mechanics_id` ASC) USING BTREE,
  CONSTRAINT `sale_items_mechanics_id_foreign` FOREIGN KEY (`mechanics_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `sale_items_sale_id_foreign` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 40 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of sale_items
-- ----------------------------
INSERT INTO `sale_items` VALUES (4, 3, 'App\\Models\\Product', 24751, 1, 12000.00, NULL, '2025-08-21 23:05:30', '2025-08-21 23:05:30');
INSERT INTO `sale_items` VALUES (5, 3, 'App\\Models\\Product', 24760, 1, 720.00, NULL, '2025-08-21 23:05:30', '2025-08-21 23:05:30');
INSERT INTO `sale_items` VALUES (6, 4, 'App\\Models\\Product', 24789, 1, 6.00, NULL, '2025-11-07 16:00:00', '2025-11-07 16:00:00');
INSERT INTO `sale_items` VALUES (17, 9, 'App\\Models\\Product', 1, 1, 30.00, NULL, '2025-11-21 12:59:17', '2025-11-21 12:59:17');
INSERT INTO `sale_items` VALUES (18, 9, 'App\\Models\\ServiceSale', 1, 1, 60.00, NULL, '2025-11-21 12:59:17', '2025-11-21 12:59:17');
INSERT INTO `sale_items` VALUES (19, 10, 'App\\Models\\Product', 24751, 1, 12000.00, NULL, '2025-11-21 12:59:18', '2025-11-21 12:59:18');
INSERT INTO `sale_items` VALUES (20, 10, 'App\\Models\\ServiceSale', 1, 1, 60.00, NULL, '2025-11-21 12:59:18', '2025-11-21 12:59:18');
INSERT INTO `sale_items` VALUES (21, 11, 'App\\Models\\Product', 1, 1, 30.00, NULL, '2025-11-21 14:10:01', '2025-11-21 14:10:01');
INSERT INTO `sale_items` VALUES (22, 11, 'App\\Models\\ServiceSale', 1, 1, 60.00, NULL, '2025-11-21 14:10:01', '2025-11-21 14:10:01');
INSERT INTO `sale_items` VALUES (23, 12, 'App\\Models\\Product', 24756, 1, 12000.00, NULL, '2025-11-21 14:10:02', '2025-11-21 14:10:02');
INSERT INTO `sale_items` VALUES (24, 12, 'App\\Models\\ServiceSale', 1, 1, 60.00, NULL, '2025-11-21 14:10:02', '2025-11-21 14:10:02');
INSERT INTO `sale_items` VALUES (25, 13, 'App\\Models\\Product', 1, 1, 30.00, NULL, '2025-11-21 16:51:22', '2025-11-21 16:51:22');
INSERT INTO `sale_items` VALUES (26, 13, 'App\\Models\\ServiceSale', 2, 1, 543.00, NULL, '2025-11-21 16:51:22', '2025-11-21 16:51:22');
INSERT INTO `sale_items` VALUES (27, 14, 'App\\Models\\Product', 1, 1, 70.00, NULL, '2025-11-21 16:55:22', '2025-11-21 16:55:22');
INSERT INTO `sale_items` VALUES (28, 15, 'App\\Models\\Product', 1, 1, 30.00, NULL, '2025-11-22 01:06:24', '2025-11-22 01:06:24');
INSERT INTO `sale_items` VALUES (29, 15, 'App\\Models\\ServiceSale', 1, 1, 60.00, NULL, '2025-11-22 01:06:24', '2025-11-22 01:06:24');
INSERT INTO `sale_items` VALUES (30, 16, 'App\\Models\\Product', 1, 1, 30.00, NULL, '2025-11-26 11:56:37', '2025-11-26 11:56:37');
INSERT INTO `sale_items` VALUES (31, 17, 'App\\Models\\Product', 1, 1, 30.00, NULL, '2025-11-26 12:04:27', '2025-11-26 12:04:27');
INSERT INTO `sale_items` VALUES (32, 18, 'App\\Models\\Product', 1, 1, 30.00, NULL, '2025-11-26 12:10:31', '2025-11-26 12:10:31');
INSERT INTO `sale_items` VALUES (33, 21, 'App\\Models\\Product', 24759, 1, 14000.00, NULL, '2025-12-04 15:25:33', '2025-12-04 15:25:33');
INSERT INTO `sale_items` VALUES (34, 22, 'App\\Models\\Product', 24759, 1, 14000.00, NULL, '2025-12-04 15:34:12', '2025-12-04 15:34:12');
INSERT INTO `sale_items` VALUES (35, 23, 'App\\Models\\Product', 24751, 1, 12000.00, NULL, '2025-12-04 17:19:36', '2025-12-04 17:19:36');
INSERT INTO `sale_items` VALUES (36, 23, 'App\\Models\\ServiceSale', 1, 1, 60.00, 4, '2025-12-04 17:19:36', '2025-12-04 17:19:36');
INSERT INTO `sale_items` VALUES (37, 24, 'App\\Models\\Product', 24766, 1, 20.00, NULL, '2025-12-04 17:24:34', '2025-12-04 17:24:34');
INSERT INTO `sale_items` VALUES (38, 24, 'App\\Models\\ServiceSale', 1, 1, 60.00, 3, '2025-12-04 17:24:34', '2025-12-04 17:24:34');
INSERT INTO `sale_items` VALUES (39, 25, 'App\\Models\\Product', 24782, 1, 15.00, NULL, '2025-12-04 17:44:38', '2025-12-04 17:44:38');

-- ----------------------------
-- Table structure for sale_payment_method
-- ----------------------------
DROP TABLE IF EXISTS `sale_payment_method`;
CREATE TABLE `sale_payment_method`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `sale_id` bigint UNSIGNED NOT NULL,
  `payment_method_id` bigint UNSIGNED NOT NULL,
  `amount` decimal(10, 2) NOT NULL DEFAULT 0.00,
  `order` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `sale_payment_method_sale_id_foreign`(`sale_id` ASC) USING BTREE,
  INDEX `sale_payment_method_payment_method_id_foreign`(`payment_method_id` ASC) USING BTREE,
  CONSTRAINT `sale_payment_method_payment_method_id_foreign` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `sale_payment_method_sale_id_foreign` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 25 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of sale_payment_method
-- ----------------------------
INSERT INTO `sale_payment_method` VALUES (3, 3, 1, 12720.00, 1, '2025-08-21 23:05:30', '2025-08-21 23:05:30');
INSERT INTO `sale_payment_method` VALUES (4, 4, 1, 6.00, 1, '2025-11-07 16:00:00', '2025-11-07 16:00:00');
INSERT INTO `sale_payment_method` VALUES (10, 9, 4, 90.00, 1, '2025-11-21 12:59:17', '2025-11-21 12:59:17');
INSERT INTO `sale_payment_method` VALUES (11, 10, 4, 12060.00, 1, '2025-11-21 12:59:18', '2025-11-21 12:59:18');
INSERT INTO `sale_payment_method` VALUES (12, 11, 3, 90.00, 1, '2025-11-21 14:10:01', '2025-11-21 14:10:01');
INSERT INTO `sale_payment_method` VALUES (13, 12, 4, 12060.00, 1, '2025-11-21 14:10:02', '2025-11-21 14:10:02');
INSERT INTO `sale_payment_method` VALUES (14, 13, 2, 573.00, 1, '2025-11-21 16:51:22', '2025-11-21 16:51:22');
INSERT INTO `sale_payment_method` VALUES (15, 14, 3, 70.00, 1, '2025-11-21 16:55:22', '2025-11-21 16:55:22');
INSERT INTO `sale_payment_method` VALUES (16, 15, 2, 90.00, 1, '2025-11-22 01:06:24', '2025-11-22 01:06:24');
INSERT INTO `sale_payment_method` VALUES (17, 16, 3, 30.00, 1, '2025-11-26 11:56:37', '2025-11-26 11:56:37');
INSERT INTO `sale_payment_method` VALUES (18, 17, 1, 30.00, 1, '2025-11-26 12:04:27', '2025-11-26 12:04:27');
INSERT INTO `sale_payment_method` VALUES (19, 18, 7, 30.00, 1, '2025-11-26 12:10:31', '2025-11-26 12:10:31');
INSERT INTO `sale_payment_method` VALUES (20, 21, 5, 14000.00, 1, '2025-12-04 15:25:33', '2025-12-04 15:25:33');
INSERT INTO `sale_payment_method` VALUES (21, 22, 5, 14000.00, 1, '2025-12-04 15:34:12', '2025-12-04 15:34:12');
INSERT INTO `sale_payment_method` VALUES (22, 23, 3, 12060.00, 1, '2025-12-04 17:19:36', '2025-12-04 17:19:36');
INSERT INTO `sale_payment_method` VALUES (23, 24, 3, 80.00, 1, '2025-12-04 17:24:34', '2025-12-04 17:24:34');
INSERT INTO `sale_payment_method` VALUES (24, 25, 2, 15.00, 1, '2025-12-04 17:44:38', '2025-12-04 17:44:38');

-- ----------------------------
-- Table structure for sales
-- ----------------------------
DROP TABLE IF EXISTS `sales`;
CREATE TABLE `sales`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `customer_dni` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `customer_names_surnames` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `total_price` decimal(10, 2) NOT NULL,
  `igv` decimal(10, 2) NOT NULL,
  `serie` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `number` int UNSIGNED NOT NULL,
  `nro_dias` int NULL DEFAULT NULL,
  `observation` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `customer_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `motorcycle_model` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `seller_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'Nombre del vendedor',
  `tienda_id` bigint UNSIGNED NULL DEFAULT NULL COMMENT 'ID de la tienda',
  `quotation_id` bigint UNSIGNED NULL DEFAULT NULL,
  `districts_id` bigint UNSIGNED NULL DEFAULT NULL,
  `document_type_id` bigint UNSIGNED NULL DEFAULT NULL,
  `mechanics_id` bigint UNSIGNED NULL DEFAULT NULL,
  `payments_id` bigint UNSIGNED NOT NULL,
  `companies_id` bigint UNSIGNED NOT NULL,
  `user_register` bigint UNSIGNED NULL DEFAULT NULL,
  `user_update` bigint UNSIGNED NULL DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fecha_vencimiento` date NULL DEFAULT NULL,
  `fecha_actualizacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `status_sunat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `delivery_status` tinyint(1) NULL DEFAULT 0 COMMENT '0=pendiente, 1=entregado',
  `delivered_at` timestamp NULL DEFAULT NULL COMMENT 'Fecha y hora de entrega',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `sales_code_unique`(`code` ASC) USING BTREE,
  INDEX `sales_quotation_id_foreign`(`quotation_id` ASC) USING BTREE,
  INDEX `sales_districts_id_foreign`(`districts_id` ASC) USING BTREE,
  INDEX `sales_document_type_id_foreign`(`document_type_id` ASC) USING BTREE,
  INDEX `sales_mechanics_id_foreign`(`mechanics_id` ASC) USING BTREE,
  INDEX `sales_payments_id_foreign`(`payments_id` ASC) USING BTREE,
  INDEX `sales_companies_id_foreign`(`companies_id` ASC) USING BTREE,
  INDEX `sales_user_register_foreign`(`user_register` ASC) USING BTREE,
  INDEX `sales_user_update_foreign`(`user_update` ASC) USING BTREE,
  INDEX `idx_delivery_status`(`delivery_status` ASC) USING BTREE,
  INDEX `tienda_id`(`tienda_id` ASC) USING BTREE,
  CONSTRAINT `sales_companies_id_foreign` FOREIGN KEY (`companies_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `sales_districts_id_foreign` FOREIGN KEY (`districts_id`) REFERENCES `districts` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `sales_document_type_id_foreign` FOREIGN KEY (`document_type_id`) REFERENCES `document_types` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`tienda_id`) REFERENCES `tiendas` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT,
  CONSTRAINT `sales_mechanics_id_foreign` FOREIGN KEY (`mechanics_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `sales_payments_id_foreign` FOREIGN KEY (`payments_id`) REFERENCES `payments` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `sales_quotation_id_foreign` FOREIGN KEY (`quotation_id`) REFERENCES `quotations` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `sales_user_register_foreign` FOREIGN KEY (`user_register`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `sales_user_update_foreign` FOREIGN KEY (`user_update`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 26 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of sales
-- ----------------------------
INSERT INTO `sales` VALUES (3, '0000003', '77426200', 'ZAPATA TORRES BRENDY YOSELY', 12720.00, 2289.60, 'B001', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 286, 1, NULL, 1, 1, 1, 1, '2025-11-18 17:15:38', NULL, '2025-11-18 17:15:38', '1', '1', '2025-08-21 23:05:30', '2025-11-18 22:15:38', 0, NULL);
INSERT INTO `sales` VALUES (4, '0000004', '77290401', 'VELARDE HUALLPA MARCELO', 6.00, 1.08, 'NV01', 2, NULL, NULL, 'MAZUKO', NULL, NULL, NULL, NULL, NULL, 734, 6, NULL, 1, 1, 1, 1, '2025-11-07 10:00:20', NULL, '2025-11-07 10:00:20', '1', '1', '2025-11-07 16:00:00', '2025-11-07 16:00:20', 0, NULL);
INSERT INTO `sales` VALUES (9, '0000005', '77425200', 'YARLEQUE ZAPATA EMER RODRIGO', 90.00, 16.20, 'B001', 3, NULL, NULL, 'mi casa', NULL, NULL, NULL, NULL, NULL, 280, 1, NULL, 1, 1, 1, NULL, '2025-11-21 07:59:17', NULL, '2025-11-21 07:59:17', '1', '0', '2025-11-21 12:59:17', '2025-11-21 12:59:17', 0, NULL);
INSERT INTO `sales` VALUES (10, '0000006', '77426200', 'ZAPATA TORRES BRENDY YOSELY', 12060.00, 2170.80, 'B001', 4, NULL, NULL, 'nsadc', NULL, NULL, NULL, NULL, NULL, 1145, 1, NULL, 1, 1, 1, NULL, '2025-11-21 07:59:18', NULL, '2025-11-21 07:59:18', '1', '0', '2025-11-21 12:59:18', '2025-11-21 12:59:18', 0, NULL);
INSERT INTO `sales` VALUES (11, '0000007', '77425200', 'YARLEQUE ZAPATA EMER RODRIGO', 90.00, 16.20, 'B001', 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1470, 1, NULL, 1, 1, 1, NULL, '2025-11-21 09:10:01', NULL, '2025-11-21 09:10:01', '1', '0', '2025-11-21 14:10:01', '2025-11-21 14:10:01', 0, NULL);
INSERT INTO `sales` VALUES (12, '0000008', '77426200', 'ZAPATA TORRES BRENDY YOSELY', 12060.00, 2170.80, 'B001', 6, NULL, NULL, 'nsadc', NULL, NULL, NULL, NULL, NULL, 1254, 1, NULL, 1, 1, 1, NULL, '2025-11-21 09:10:02', NULL, '2025-11-21 09:10:02', '1', '0', '2025-11-21 14:10:02', '2025-11-21 14:10:02', 0, NULL);
INSERT INTO `sales` VALUES (13, '0000009', '77425200', 'YARLEQUE ZAPATA EMER RODRIGO', 573.00, 103.14, 'B001', 7, NULL, NULL, 'fdgbngdfd', NULL, NULL, NULL, NULL, NULL, 280, 1, NULL, 1, 1, 1, NULL, '2025-11-21 11:51:22', NULL, '2025-11-21 11:51:22', '1', '0', '2025-11-21 16:51:22', '2025-11-21 16:51:22', 0, NULL);
INSERT INTO `sales` VALUES (14, '0000010', '77425200', 'YARLEQUE ZAPATA EMER RODRIGO', 70.00, 12.60, 'B001', 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 100, 1, NULL, 1, 2, 1, 1, '2025-11-21 12:17:13', NULL, '2025-11-21 12:17:13', '1', '0', '2025-11-21 16:55:22', '2025-11-21 17:17:13', 1, '2025-11-21 17:17:13');
INSERT INTO `sales` VALUES (15, '0000011', '77425200', 'YARLEQUE ZAPATA EMER RODRIGO', 90.00, 16.20, 'B001', 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 1, 1, NULL, '2025-11-21 20:06:24', NULL, '2025-11-21 20:06:24', '1', '0', '2025-11-22 01:06:24', '2025-11-22 01:06:24', 0, NULL);
INSERT INTO `sales` VALUES (16, '0000012', NULL, NULL, 30.00, 5.40, 'NV01', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, 1, 1, 1, NULL, '2025-11-26 06:56:36', NULL, '2025-11-26 06:56:36', '1', '0', '2025-11-26 11:56:36', '2025-11-26 11:56:36', 0, NULL);
INSERT INTO `sales` VALUES (17, '0000013', NULL, '93HWRF8', 30.00, 5.40, 'NV01', 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, 1, 1, 1, NULL, '2025-11-26 07:04:27', NULL, '2025-11-26 07:04:27', '1', '0', '2025-11-26 12:04:27', '2025-11-26 12:04:27', 0, NULL);
INSERT INTO `sales` VALUES (18, '0000014', NULL, '497ABTO', 30.00, 5.40, 'NV01', 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, 1, 1, 1, NULL, '2025-11-26 07:10:31', NULL, '2025-11-26 07:10:31', '1', '0', '2025-11-26 12:10:31', '2025-11-26 12:10:31', 0, NULL);
INSERT INTO `sales` VALUES (19, '0000015', '77426200', 'ZAPATA TORRES BRENDY YOSELY', 25.00, 4.50, 'B001', 10, NULL, NULL, NULL, NULL, '993321920', NULL, NULL, NULL, 1427, 1, NULL, 1, 1, 1, NULL, '2025-12-04 10:17:30', NULL, '2025-12-04 10:17:30', '1', '0', '2025-12-04 15:17:30', '2025-12-04 15:17:30', 0, NULL);
INSERT INTO `sales` VALUES (20, '0000016', '77426200', 'ZAPATA TORRES BRENDY YOSELY', 25.00, 4.50, 'B001', 11, NULL, NULL, NULL, NULL, '993321920', NULL, NULL, NULL, 1427, 1, NULL, 1, 1, 1, NULL, '2025-12-04 10:17:39', NULL, '2025-12-04 10:17:39', '1', '0', '2025-12-04 15:17:39', '2025-12-04 15:17:39', 0, NULL);
INSERT INTO `sales` VALUES (21, '0000017', '77426200', 'ZAPATA TORRES BRENDY YOSELY', 14000.00, 2520.00, 'B001', 12, NULL, NULL, NULL, NULL, '993321920', NULL, NULL, NULL, 1305, 1, NULL, 1, 1, 1, NULL, '2025-12-04 10:25:33', NULL, '2025-12-04 10:25:33', '1', '0', '2025-12-04 15:25:33', '2025-12-04 15:25:33', 0, NULL);
INSERT INTO `sales` VALUES (22, '0000018', '77425200', 'YARLEQUE ZAPATA EMER RODRIGO', 14000.00, 2520.00, 'F001', 1, NULL, NULL, NULL, NULL, '993321920', NULL, NULL, NULL, 463, 2, NULL, 1, 1, 1, NULL, '2025-12-04 10:34:12', NULL, '2025-12-04 10:34:12', '1', '0', '2025-12-04 15:34:12', '2025-12-04 15:34:12', 0, NULL);
INSERT INTO `sales` VALUES (23, '0000019', '77425200', 'YARLEQUE ZAPATA EMER RODRIGO', 12060.00, 2170.80, 'B001', 13, NULL, NULL, NULL, '435634654', '993329202', NULL, NULL, NULL, NULL, 1, 4, 1, 1, 1, NULL, '2025-12-04 12:19:36', NULL, '2025-12-04 12:19:36', '1', '0', '2025-12-04 17:19:36', '2025-12-04 17:19:36', 0, NULL);
INSERT INTO `sales` VALUES (24, '0000020', '77425200', 'YARLEQUE ZAPATA EMER RODRIGO', 80.00, 14.40, 'B001', 14, NULL, NULL, NULL, 'dvcsdvsdfv', '993321920', NULL, NULL, NULL, NULL, 1, 3, 1, 1, 1, NULL, '2025-12-04 12:24:34', NULL, '2025-12-04 12:24:34', '1', '0', '2025-12-04 17:24:34', '2025-12-04 17:24:34', 0, NULL);
INSERT INTO `sales` VALUES (25, '0000021', '77426200', 'ZAPATA TORRES BRENDY YOSELY', 15.00, 2.70, 'TEMP', 0, NULL, NULL, NULL, NULL, '993321920', NULL, NULL, NULL, 99, 2, NULL, 1, 1, 1, NULL, '2025-12-04 12:44:38', NULL, '2025-12-04 12:44:38', '1', '0', '2025-12-04 17:44:38', '2025-12-04 17:44:38', 0, NULL);

-- ----------------------------
-- Table structure for sales_sunat
-- ----------------------------
DROP TABLE IF EXISTS `sales_sunat`;
CREATE TABLE `sales_sunat`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `sale_id` bigint UNSIGNED NOT NULL,
  `name_xml` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `qr_info` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `hash` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `sales_sunat_sale_id_foreign`(`sale_id` ASC) USING BTREE,
  CONSTRAINT `sales_sunat_sale_id_foreign` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of sales_sunat
-- ----------------------------
INSERT INTO `sales_sunat` VALUES (1, 4, '20123456789-01-NV01-2.xml', '20123456789|01|NV01-2|0.92|6.00|2025-11-07|1|77290401', 'Kv5bh8KBq4kgUWJZI05uHm85Miw=', '2025-11-07 16:00:20', '2025-11-07 16:00:20');
INSERT INTO `sales_sunat` VALUES (2, 3, '20123456789-03-B001-2.xml', '20123456789|03|B001-2|1940.34|12720.00|2025-08-21|1|77426200', 'LN5oKNaMZv4DFmuSx7tLV4HAoKY=', '2025-11-18 22:15:38', '2025-11-18 22:15:38');
INSERT INTO `sales_sunat` VALUES (3, 3, '20123456789-03-B001-2.xml', '20123456789|03|B001-2|1940.34|12720.00|2025-08-21|1|77426200', 'tdootn1Zl6iPwBoFcV9lUMNlWlM=', '2025-11-18 22:15:38', '2025-11-18 22:15:38');
INSERT INTO `sales_sunat` VALUES (4, 3, '20123456789-03-B001-2.xml', '20123456789|03|B001-2|1940.34|12720.00|2025-08-21|1|77426200', 'LN5oKNaMZv4DFmuSx7tLV4HAoKY=', '2025-11-18 22:15:38', '2025-11-18 22:15:38');

-- ----------------------------
-- Table structure for scanned_codes
-- ----------------------------
DROP TABLE IF EXISTS `scanned_codes`;
CREATE TABLE `scanned_codes`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `stock_id` bigint UNSIGNED NOT NULL,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `unique_code_stock`(`code` ASC, `stock_id` ASC) USING BTREE,
  INDEX `stock_id`(`stock_id` ASC) USING BTREE,
  CONSTRAINT `scanned_codes_ibfk_1` FOREIGN KEY (`stock_id`) REFERENCES `stocks` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 29 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of scanned_codes
-- ----------------------------
INSERT INTO `scanned_codes` VALUES (1, 13, '54654', '2025-07-30 04:19:08', '2025-07-30 04:19:08');
INSERT INTO `scanned_codes` VALUES (2, 13, '848412', '2025-07-30 04:19:08', '2025-07-30 04:19:08');
INSERT INTO `scanned_codes` VALUES (3, 13, '5011212', '2025-07-30 04:19:08', '2025-07-30 04:19:08');
INSERT INTO `scanned_codes` VALUES (5, 16, '44645127', '2025-07-30 14:43:23', '2025-07-30 14:43:23');
INSERT INTO `scanned_codes` VALUES (6, 16, '8511512', '2025-07-30 14:43:23', '2025-07-30 14:43:23');
INSERT INTO `scanned_codes` VALUES (10, 14, '2001', '2025-07-30 21:08:36', '2025-07-30 21:08:36');
INSERT INTO `scanned_codes` VALUES (11, 17, '6465654', '2025-07-31 18:43:24', '2025-07-31 18:43:24');
INSERT INTO `scanned_codes` VALUES (13, 14, '544454', '2025-07-31 21:59:40', '2025-07-31 21:59:40');
INSERT INTO `scanned_codes` VALUES (14, 14, '1122215', '2025-07-31 21:59:40', '2025-07-31 21:59:40');
INSERT INTO `scanned_codes` VALUES (15, 14, '744885', '2025-07-31 21:59:40', '2025-07-31 21:59:40');
INSERT INTO `scanned_codes` VALUES (16, 17, '777774714', '2025-08-01 15:15:32', '2025-08-01 15:15:32');
INSERT INTO `scanned_codes` VALUES (17, 20, '2000099', '2025-08-01 23:36:15', '2025-08-01 23:36:15');
INSERT INTO `scanned_codes` VALUES (18, 17, '4465564', '2025-08-02 15:35:24', '2025-08-02 15:35:24');
INSERT INTO `scanned_codes` VALUES (19, 20, '78787475360', '2025-08-02 21:37:43', '2025-08-02 21:37:43');
INSERT INTO `scanned_codes` VALUES (20, 17, '741852', '2025-08-02 21:53:47', '2025-08-02 21:53:47');
INSERT INTO `scanned_codes` VALUES (25, 25, 'dk151038\'1', '2025-08-09 13:43:42', '2025-08-09 13:43:42');
INSERT INTO `scanned_codes` VALUES (26, 25, 'DK151038-1', '2025-08-09 13:43:42', '2025-08-09 13:43:42');

-- ----------------------------
-- Table structure for services
-- ----------------------------
DROP TABLE IF EXISTS `services`;
CREATE TABLE `services`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `drives_id` bigint UNSIGNED NULL DEFAULT NULL,
  `cars_id` bigint UNSIGNED NULL DEFAULT NULL,
  `users_id` bigint UNSIGNED NULL DEFAULT NULL,
  `descripcion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `codigo` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `detalle_servicio` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `user_register` bigint UNSIGNED NULL DEFAULT NULL,
  `user_update` bigint UNSIGNED NULL DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `status_service` tinyint(1) NOT NULL DEFAULT 0,
  `fecha_registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `services_codigo_unique`(`codigo` ASC) USING BTREE,
  INDEX `services_drives_id_foreign`(`drives_id` ASC) USING BTREE,
  INDEX `services_cars_id_foreign`(`cars_id` ASC) USING BTREE,
  INDEX `services_users_id_foreign`(`users_id` ASC) USING BTREE,
  INDEX `services_user_register_foreign`(`user_register` ASC) USING BTREE,
  INDEX `services_user_update_foreign`(`user_update` ASC) USING BTREE,
  CONSTRAINT `services_cars_id_foreign` FOREIGN KEY (`cars_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `services_drives_id_foreign` FOREIGN KEY (`drives_id`) REFERENCES `drives` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `services_user_register_foreign` FOREIGN KEY (`user_register`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `services_user_update_foreign` FOREIGN KEY (`user_update`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `services_users_id_foreign` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of services
-- ----------------------------
INSERT INTO `services` VALUES (1, 2, 1, 3, 'asdcsd', '0000001', NULL, 1, NULL, 1, 0, '2025-08-27 10:20:54', '2025-08-27 10:20:54', '2025-08-27 15:20:54', '2025-08-27 15:20:54');
INSERT INTO `services` VALUES (2, 2, 1, 3, 'problema con el equipo', '0000002', NULL, 1, NULL, 1, 0, '2025-08-27 10:21:10', '2025-08-27 10:21:10', '2025-08-27 15:21:10', '2025-08-27 15:21:10');
INSERT INTO `services` VALUES (3, 2, 1, 3, 'NO PRENDE', '0000003', NULL, 1, NULL, 1, 0, '2025-10-07 12:42:50', '2025-10-07 12:42:50', '2025-10-07 17:42:50', '2025-10-07 17:42:50');

-- ----------------------------
-- Table structure for services_sales
-- ----------------------------
DROP TABLE IF EXISTS `services_sales`;
CREATE TABLE `services_sales`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `code_sku` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `default_price` decimal(10, 2) NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `services_sales_code_sku_unique`(`code_sku` ASC) USING BTREE,
  UNIQUE INDEX `services_sales_name_unique`(`name` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of services_sales
-- ----------------------------
INSERT INTO `services_sales` VALUES (1, '0000001', 'Taller', 60.00, '2025-05-12 15:30:22', '2025-05-12 15:30:22');
INSERT INTO `services_sales` VALUES (2, '0000002', 'Fdghngfh', 543.00, '2025-11-21 16:51:22', '2025-11-21 16:51:22');

-- ----------------------------
-- Table structure for sessions
-- ----------------------------
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions`  (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `user_id` bigint UNSIGNED NULL DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `sessions_user_id_index`(`user_id` ASC) USING BTREE,
  INDEX `sessions_last_activity_index`(`last_activity` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sessions
-- ----------------------------
INSERT INTO `sessions` VALUES ('40mkEIn7oV19thFhMY0FM01SO8qP2IUqFhi4El9B', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiRkM0T2FlVGRmV2xDakpXMXJBeUFaM0lMczIwNlVDaDlHY2NFdEdtUCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1763348194);
INSERT INTO `sessions` VALUES ('4rVjYf5hQHxAsYYSvelNwyifst5kVJvjyPasZcdv', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiOTdvQTNtbEd6d3VTcWNndGRuOXo5eFZtWTNaUnhPQzZkc3YwQXdZdSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1763348281);
INSERT INTO `sessions` VALUES ('aYzP1VkOfEiKVQqj9ywfJsCdkxvYs2Vxy1xmMBwI', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTlRteFNZelh2RWRMb2RweHZ1aXRPNlRGRkhlT1V1VzhpbEJscTlsRCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly9iaWtlci1wcm9qZWN0LnRlc3QvbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1763348239);
INSERT INTO `sessions` VALUES ('Fzzo8IYtLnqQpI1EXtOojzhwACzIuyHq9UtlE5G3', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSWpKeEhjSG9JM2Y4enpucnpLMDRoZHUxaFIxNDFBNFZNeXJoTHRKbyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly9iaWtlci1wcm9qZWN0LnRlc3QvbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1763348241);
INSERT INTO `sessions` VALUES ('IYVO973rQcYI3fUEceKB6V0y2MWUpis8jlHLqPmU', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUEljcXRNZ2hIUU81STREbk5YbVVsbDhaTE1kSnUybEVid1dZaXl4RyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly9iaWtlci1wcm9qZWN0LnRlc3QvbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1763348212);
INSERT INTO `sessions` VALUES ('jOVUU5e3vG6FbklhrbQZfp1ZEFCEdAHq4AqgcghW', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiZGxsOGw0RHRlNzEwbFNQMTluT3ROc2RITkl6dVVPSzJScVc3MWo3SyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1763348190);
INSERT INTO `sessions` VALUES ('KSxzl89XqXARrv46bO0CyWPyekAexqpISzm632JW', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiV2l2TXl1dFI0S0p0U1FtZEtQbEpKdUpWelhaeXhwdm55VmtYVmNQTiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHA6Ly9iaWtlci1wcm9qZWN0LnRlc3QiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1763348198);
INSERT INTO `sessions` VALUES ('M6y19X7HtXn4nDih1jKYeyOOToU3HX1coGlZnYWH', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoib0ozOWhySG03WTRNU3pTRjFxSFB2YXVNNTNaSWdiU1FCc2dldzlvQyI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozNToiaHR0cDovL2Jpa2VyLXByb2plY3QudGVzdC9kYXNoYm9hcmQiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czozNToiaHR0cDovL2Jpa2VyLXByb2plY3QudGVzdC9kYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1763348212);
INSERT INTO `sessions` VALUES ('sqAohblIyexlyb6zTudCSN5Zpk6LvFypiiyL31Qm', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiSVVzZW41Z0JwOVY4eFlUQm9iUnNObEFXZnlrcE1SM2xSQ3ZaVFpjVCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1763348223);
INSERT INTO `sessions` VALUES ('vPW0SwcPmMfNzx8Rhb5sxfWD9OcsojP84EyXbPbt', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiMzN6S2tLaUs5NWVvUVNHT0twWmZweEhBNUx4ekFqWjh6aEtURjN4NyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1763348256);
INSERT INTO `sessions` VALUES ('W8WKaUjX6OzE3DVgp9a1eKHpidoUSoXBJ3Odnlpk', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNGo5ZmhBVDF6VE55ajROcjVlc0N3WWVnTm5SUnA2emhRUkVHbjVwQiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHA6Ly9iaWtlci1wcm9qZWN0LnRlc3QiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1763348167);

-- ----------------------------
-- Table structure for stocks
-- ----------------------------
DROP TABLE IF EXISTS `stocks`;
CREATE TABLE `stocks`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` bigint UNSIGNED NOT NULL,
  `tienda_id` bigint UNSIGNED NULL DEFAULT NULL,
  `quantity` int NOT NULL DEFAULT 0,
  `minimum_stock` int NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `stocks_product_id_foreign`(`product_id` ASC) USING BTREE,
  INDEX `tienda_id`(`tienda_id` ASC) USING BTREE,
  CONSTRAINT `stocks_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `stocks_tienda_id_foreign` FOREIGN KEY (`tienda_id`) REFERENCES `tiendas` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 52 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of stocks
-- ----------------------------
INSERT INTO `stocks` VALUES (1, 1, NULL, 22, 10, '2025-06-10 00:00:16', '2025-11-26 12:10:31');
INSERT INTO `stocks` VALUES (8, 24751, NULL, 0, 1, '2025-07-30 03:23:15', '2025-12-04 17:19:36');
INSERT INTO `stocks` VALUES (13, 24756, NULL, 2, 2, '2025-07-30 04:19:08', '2025-11-21 14:10:02');
INSERT INTO `stocks` VALUES (14, 24758, 2, 4, 2, '2025-07-30 14:11:14', '2025-07-31 22:00:05');
INSERT INTO `stocks` VALUES (15, 24759, 1, 9, 2, '2025-07-30 14:19:07', '2025-12-04 15:34:12');
INSERT INTO `stocks` VALUES (16, 24760, NULL, 1, 3, '2025-07-30 14:43:23', '2025-08-21 23:05:30');
INSERT INTO `stocks` VALUES (17, 24761, 1, 4, 4, '2025-07-31 18:43:24', '2025-08-02 21:53:47');
INSERT INTO `stocks` VALUES (18, 24759, 2, 4, 0, '2025-07-31 20:23:12', '2025-08-02 21:37:43');
INSERT INTO `stocks` VALUES (19, 24757, 1, 2, 0, '2025-08-01 15:15:32', '2025-11-21 12:56:57');
INSERT INTO `stocks` VALUES (20, 24761, 2, 2, 0, '2025-08-01 23:36:15', '2025-08-02 21:37:43');
INSERT INTO `stocks` VALUES (21, 24757, 2, 4, 0, '2025-08-01 23:36:15', '2025-08-01 23:36:15');
INSERT INTO `stocks` VALUES (22, 24763, 2, 30, 30, '2025-08-08 19:54:18', '2025-08-08 19:54:18');
INSERT INTO `stocks` VALUES (25, 24766, 2, 1, 1, '2025-08-09 13:43:42', '2025-12-04 17:24:34');
INSERT INTO `stocks` VALUES (27, 24768, 3, 1, 1, '2025-10-10 00:12:26', '2025-10-10 00:12:26');
INSERT INTO `stocks` VALUES (28, 24769, 3, 1, 1, '2025-10-10 00:12:26', '2025-10-10 00:12:26');
INSERT INTO `stocks` VALUES (29, 24770, 3, 1, 1, '2025-10-10 00:12:26', '2025-10-10 00:12:26');
INSERT INTO `stocks` VALUES (30, 24771, 3, 5, 1, '2025-10-10 00:12:26', '2025-10-10 00:12:26');
INSERT INTO `stocks` VALUES (31, 24772, 3, 3, 1, '2025-10-10 00:12:26', '2025-10-10 00:12:26');
INSERT INTO `stocks` VALUES (32, 24773, 3, 6, 1, '2025-10-10 00:12:27', '2025-10-10 00:12:27');
INSERT INTO `stocks` VALUES (39, 24780, 6, 2, 1, '2025-11-07 15:51:33', '2025-11-07 15:51:33');
INSERT INTO `stocks` VALUES (40, 24781, 6, 2, 1, '2025-11-07 15:51:33', '2025-11-07 15:51:33');
INSERT INTO `stocks` VALUES (41, 24782, 7, 7, 1, '2025-11-07 15:51:33', '2025-12-04 17:44:38');
INSERT INTO `stocks` VALUES (42, 24783, 7, 2, 1, '2025-11-07 15:51:33', '2025-11-07 15:51:33');
INSERT INTO `stocks` VALUES (43, 24784, 7, 8, 1, '2025-11-07 15:51:33', '2025-11-07 15:51:33');
INSERT INTO `stocks` VALUES (44, 24785, 7, 8, 1, '2025-11-07 15:51:33', '2025-11-07 15:51:33');
INSERT INTO `stocks` VALUES (45, 24786, 6, 2, 1, '2025-11-07 15:55:58', '2025-11-07 15:55:58');
INSERT INTO `stocks` VALUES (46, 24787, 6, 2, 1, '2025-11-07 15:55:58', '2025-11-07 15:55:58');
INSERT INTO `stocks` VALUES (47, 24788, 7, 8, 1, '2025-11-07 15:55:58', '2025-11-21 12:57:17');
INSERT INTO `stocks` VALUES (48, 24789, 7, 1, 1, '2025-11-07 15:55:58', '2025-11-21 12:57:17');
INSERT INTO `stocks` VALUES (49, 24790, 7, 8, 1, '2025-11-07 15:55:58', '2025-11-21 12:57:17');
INSERT INTO `stocks` VALUES (50, 24791, 7, 8, 1, '2025-11-07 15:55:58', '2025-11-21 12:57:17');
INSERT INTO `stocks` VALUES (51, 24792, 1, 50, 10, '2025-11-21 13:11:16', '2025-11-21 13:11:16');

-- ----------------------------
-- Table structure for tiendas
-- ----------------------------
DROP TABLE IF EXISTS `tiendas`;
CREATE TABLE `tiendas`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `user_register` bigint UNSIGNED NOT NULL,
  `user_update` bigint UNSIGNED NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `tiendas_user_register_foreign`(`user_register` ASC) USING BTREE,
  INDEX `tiendas_user_update_foreign`(`user_update` ASC) USING BTREE,
  CONSTRAINT `tiendas_user_register_foreign` FOREIGN KEY (`user_register`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `tiendas_user_update_foreign` FOREIGN KEY (`user_update`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tiendas
-- ----------------------------
INSERT INTO `tiendas` VALUES (1, 'store21', 0, 1, 1, '2025-07-24 20:47:49', '2025-08-21 22:32:32');
INSERT INTO `tiendas` VALUES (2, 'fgvdsvbffd', 0, 1, 1, '2025-07-24 22:24:01', '2025-08-11 16:00:37');
INSERT INTO `tiendas` VALUES (3, 'COMPAÑIA FOOD RETAIL S.A.C.', 1, 1, NULL, '2025-08-11 16:00:46', '2025-08-11 16:00:46');
INSERT INTO `tiendas` VALUES (4, 'PETROLEOS DEL PERU PETROPERU SA', 0, 1, 1, '2025-08-11 16:03:07', '2025-10-14 13:46:09');
INSERT INTO `tiendas` VALUES (5, 'Tienda B', 0, 1, 1, '2025-08-21 22:32:42', '2025-10-14 13:46:05');
INSERT INTO `tiendas` VALUES (6, 'SUCURSAL MAZUKO', 1, 1, NULL, '2025-10-14 13:45:58', '2025-10-14 13:45:58');
INSERT INTO `tiendas` VALUES (7, 'SUCURSAL JUNIN', 1, 1, NULL, '2025-10-14 13:46:28', '2025-10-14 13:46:28');

-- ----------------------------
-- Table structure for unit_types
-- ----------------------------
DROP TABLE IF EXISTS `unit_types`;
CREATE TABLE `unit_types`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `unit_types_name_unique`(`name` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of unit_types
-- ----------------------------
INSERT INTO `unit_types` VALUES (1, 'Otro', '2025-06-10 00:00:16', '2025-06-10 00:00:16');

-- ----------------------------
-- Table structure for units
-- ----------------------------
DROP TABLE IF EXISTS `units`;
CREATE TABLE `units`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit_type_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `units_name_unique`(`name` ASC) USING BTREE,
  INDEX `units_unit_type_id_foreign`(`unit_type_id` ASC) USING BTREE,
  CONSTRAINT `units_unit_type_id_foreign` FOREIGN KEY (`unit_type_id`) REFERENCES `unit_types` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of units
-- ----------------------------
INSERT INTO `units` VALUES (1, 'Unidad', 1, '2025-06-10 00:00:16', '2025-06-10 00:00:16');
INSERT INTO `units` VALUES (2, '1', 1, '2025-06-16 17:08:36', '2025-06-16 17:08:36');
INSERT INTO `units` VALUES (5, 'Centímetros', 1, '2025-07-30 03:23:15', '2025-07-30 03:23:15');
INSERT INTO `units` VALUES (6, 'Cantidad', 1, '2025-07-31 18:51:17', '2025-07-31 18:51:17');
INSERT INTO `units` VALUES (7, '01 par', 1, '2025-10-10 00:12:26', '2025-10-10 00:12:26');
INSERT INTO `units` VALUES (8, '04 unid', 1, '2025-10-10 00:12:26', '2025-10-10 00:12:26');
INSERT INTO `units` VALUES (10, 'Kigcol', 1, '2025-11-07 15:51:33', '2025-11-07 15:51:33');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellidos` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dni` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `telefono` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `direccion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `correo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `tienda_id` bigint UNSIGNED NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_mechanic` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `codigo` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `user_register` bigint UNSIGNED NULL DEFAULT NULL,
  `user_update` bigint UNSIGNED NULL DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_email_unique`(`email` ASC) USING BTREE,
  UNIQUE INDEX `users_dni_unique`(`dni` ASC) USING BTREE,
  UNIQUE INDEX `users_correo_unique`(`correo` ASC) USING BTREE,
  UNIQUE INDEX `users_codigo_unique`(`codigo` ASC) USING BTREE,
  INDEX `users_user_register_foreign`(`user_register` ASC) USING BTREE,
  INDEX `users_user_update_foreign`(`user_update` ASC) USING BTREE,
  INDEX `users_tienda_id_foreign`(`tienda_id` ASC) USING BTREE,
  CONSTRAINT `users_tienda_id_foreign` FOREIGN KEY (`tienda_id`) REFERENCES `tiendas` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `users_user_register_foreign` FOREIGN KEY (`user_register`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `users_user_update_foreign` FOREIGN KEY (`user_update`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'administrador', NULL, 'administrador@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, '$2y$12$ujdkyXYs/S92IdLd09455uqZfwiE01JdnN8LiLv81ymykCH966O4C', '1', '1', NULL, NULL, 1, '2025-05-05 12:22:28', '2025-11-26 22:14:28', 'gJgYgKYp3Y383uDMAFKVtysfQA4ZqoJokPPInYKPgOcfOBdoa1jptIkXS8F1', '2025-05-05 16:22:28', '2025-05-05 16:22:28');
INSERT INTO `users` VALUES (2, 'BRIGYTT VIVIANA', 'Emer', 'brigytt.emer@empresa.com', '77427200', '993321920', 'Paita 2 de mayo', NULL, 'correo@gmail.com', 3, '$2y$12$fXRSOg7WcZY4CNxYUV2ZsOO0m04NCDK5L9dnF9IOf9Igud0azqTFO', '1', '1', '0000001', 1, NULL, '2025-08-11 11:02:56', '2025-08-11 11:02:56', NULL, '2025-08-11 16:02:56', '2025-08-11 16:02:56');
INSERT INTO `users` VALUES (3, 'VICTOR MANUEL', 'Emer', 'victor.emer@empresa.com', '77423400', '993321920', 'Paita 2 de mayo', NULL, 'rodrigoyarleque7@gmail.com', 3, '$2y$12$o2D.94cunqIaVBVVHS3f2u1IMhd69KPHdYoYxnIGYm3ukFQZTX4Se', '1', '1', '0000002', 1, NULL, '2025-08-27 10:18:16', '2025-08-27 10:18:16', NULL, '2025-08-27 15:18:16', '2025-08-27 15:18:16');
INSERT INTO `users` VALUES (4, 'ANTONELLA', 'MALDONADO BALESTRA', 'kiyotakahitori@gmail.com', '77456022', '+51 993 321 920', 'sdacsdc', NULL, 'kibutsuji26muzan@gmail.com', 3, '$2y$12$DObcX5tBVtXWzCfi8eI4y.OqnRDEUL/XvK7jllY5BNvKA6Lweyq7m', '1', '1', '0000003', 1, NULL, '2025-11-28 17:38:21', '2025-11-28 17:38:21', NULL, '2025-11-28 22:38:21', '2025-11-28 22:38:21');
INSERT INTO `users` VALUES (5, 'EMER RODRIGO', 'YARLEQUE ZAPATA', 'yarlequerodrigo9@gmail.com', '77425200', '+51 993 321 920', 'dwsscs', NULL, 'yarlequerodrigo9@gmail.com', NULL, '$2y$12$o5QjhcWRDzxk5t6d53tVWuT25nxJv1n3cTg5fghHiM871KLURBs7u', '1', '1', '0000004', 1, NULL, '2025-12-05 19:29:15', '2025-12-05 19:29:15', NULL, '2025-12-06 00:29:15', '2025-12-06 00:29:15');

-- ----------------------------
-- Table structure for warehouses
-- ----------------------------
DROP TABLE IF EXISTS `warehouses`;
CREATE TABLE `warehouses`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `code` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `address` varchar(500) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `type` enum('central','sucursal') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'central',
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `code`(`code` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of warehouses
-- ----------------------------
INSERT INTO `warehouses` VALUES (1, 'Almacén Central', 'ALM-CENTRAL', NULL, 'central', 1, NULL, NULL);

-- ----------------------------
-- Table structure for wholesaler_items
-- ----------------------------
DROP TABLE IF EXISTS `wholesaler_items`;
CREATE TABLE `wholesaler_items`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `wholesaler_id` bigint UNSIGNED NOT NULL,
  `item_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_id` bigint UNSIGNED NULL DEFAULT NULL,
  `quantity` int NULL DEFAULT NULL,
  `unit_price` decimal(10, 2) NOT NULL,
  `product_prices_id` bigint UNSIGNED NULL DEFAULT NULL,
  `mechanics_id` bigint UNSIGNED NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `wholesaler_items_wholesaler_id_foreign`(`wholesaler_id` ASC) USING BTREE,
  INDEX `wholesaler_items_product_prices_id_foreign`(`product_prices_id` ASC) USING BTREE,
  INDEX `wholesaler_items_mechanics_id_foreign`(`mechanics_id` ASC) USING BTREE,
  CONSTRAINT `wholesaler_items_mechanics_id_foreign` FOREIGN KEY (`mechanics_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `wholesaler_items_product_prices_id_foreign` FOREIGN KEY (`product_prices_id`) REFERENCES `product_prices` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `wholesaler_items_wholesaler_id_foreign` FOREIGN KEY (`wholesaler_id`) REFERENCES `wholesalers` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of wholesaler_items
-- ----------------------------

-- ----------------------------
-- Table structure for wholesalers
-- ----------------------------
DROP TABLE IF EXISTS `wholesalers`;
CREATE TABLE `wholesalers`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `customer_dni` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `customer_names_surnames` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `total_price` decimal(10, 2) NOT NULL,
  `igv` decimal(10, 2) NOT NULL,
  `observation` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `customer_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `status_sale` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `document_type_id` bigint UNSIGNED NULL DEFAULT NULL,
  `districts_id` bigint UNSIGNED NULL DEFAULT NULL,
  `mechanics_id` bigint UNSIGNED NULL DEFAULT NULL,
  `user_register` bigint UNSIGNED NULL DEFAULT NULL,
  `user_update` bigint UNSIGNED NULL DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `wholesalers_code_unique`(`code` ASC) USING BTREE,
  INDEX `wholesalers_districts_id_foreign`(`districts_id` ASC) USING BTREE,
  INDEX `wholesalers_mechanics_id_foreign`(`mechanics_id` ASC) USING BTREE,
  INDEX `wholesalers_user_register_foreign`(`user_register` ASC) USING BTREE,
  INDEX `wholesalers_user_update_foreign`(`user_update` ASC) USING BTREE,
  CONSTRAINT `wholesalers_districts_id_foreign` FOREIGN KEY (`districts_id`) REFERENCES `districts` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `wholesalers_mechanics_id_foreign` FOREIGN KEY (`mechanics_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `wholesalers_user_register_foreign` FOREIGN KEY (`user_register`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `wholesalers_user_update_foreign` FOREIGN KEY (`user_update`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of wholesalers
-- ----------------------------

SET FOREIGN_KEY_CHECKS = 1;
