-- =============================================
-- MIGRACIÓN PARA MÓDULO DE PEDIDOS
-- Compatible con la estructura de la base de datos existente
-- =============================================

-- Tabla principal de pedidos
CREATE TABLE `pedidos` (
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
    CONSTRAINT `pedidos_districts_id_foreign` FOREIGN KEY (`districts_id`) REFERENCES `districts` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT,
    CONSTRAINT `pedidos_mechanics_id_foreign` FOREIGN KEY (`mechanics_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT,
    CONSTRAINT `pedidos_user_register_foreign` FOREIGN KEY (`user_register`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT,
    CONSTRAINT `pedidos_user_update_foreign` FOREIGN KEY (`user_update`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT,
    CONSTRAINT `pedidos_sale_id_foreign` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- Tabla de items/productos del pedido
CREATE TABLE `pedido_items` (
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
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- Tabla de servicios del pedido
CREATE TABLE `pedido_services` (
    `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
    `pedido_id` bigint UNSIGNED NOT NULL,
    `service_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `price` decimal(10, 2) NOT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`) USING BTREE,
    INDEX `pedido_services_pedido_id_foreign`(`pedido_id` ASC) USING BTREE,
    CONSTRAINT `pedido_services_pedido_id_foreign` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- =============================================
-- ÍNDICES ADICIONALES PARA MEJOR RENDIMIENTO
-- =============================================
ALTER TABLE `pedidos` ADD INDEX `pedidos_status_fecha_index` (`status`, `fecha_registro`);
