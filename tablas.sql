CREATE TABLE `sessions` (
    `id` VARCHAR(255) NOT NULL,
    `user_id` BIGINT UNSIGNED NULL,
    `ip_address` VARCHAR(45) NULL,
    `user_agent` TEXT NULL,
    `payload` LONGTEXT NOT NULL,
    `last_activity` INT NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `sessions_user_id_index` (`user_id`),
    INDEX `sessions_last_activity_index` (`last_activity`)
)

-- coloca la consulta qui , ya sea un alter , etc 

-- ======================================================================================
-- FIX: Añadir la columna faltante 'warehouse_id' a la tabla 'products'
-- Esto soluciona el error 'Column not found' de forma permanente.
-- Copia y pega este bloque completo en tu gestor de base de datos.
-- ======================================================================================
ALTER TABLE `products` 
ADD COLUMN `warehouse_id` BIGINT UNSIGNED NULL DEFAULT NULL AFTER `fecha_actualizacion`,
ADD CONSTRAINT `products_warehouse_id_foreign` 
  FOREIGN KEY (`warehouse_id`) 
  REFERENCES `warehouses` (`id`) 
  ON DELETE CASCADE;

-- ======================================================================================
-- REFACTOR: Reemplazar Almacen (Warehouse) por Tienda
-- Ejecuta los siguientes 3 bloques de código en orden en tu gestor de base de datos.
-- ======================================================================================

-- Paso 1: Modificar la tabla 'products' para quitar la columna 'warehouse_id'.
-- NOTA: Si la llave foránea tiene un nombre diferente, ajústalo en la consulta.
ALTER TABLE `products`
  DROP FOREIGN KEY `products_warehouse_id_foreign`,
  DROP COLUMN `warehouse_id`;

-- Paso 2: Añadir la columna 'tienda_id' a la tabla 'products'.
ALTER TABLE `products`
ADD COLUMN `tienda_id` BIGINT UNSIGNED NULL DEFAULT NULL AFTER `fecha_actualizacion`,
ADD CONSTRAINT `products_tienda_id_foreign`
  FOREIGN KEY (`tienda_id`)
  REFERENCES `tiendas` (`id`)
  ON DELETE SET NULL;

-- Paso 3: Eliminar la tabla 'warehouses' que ya no es necesaria.
DROP TABLE IF EXISTS `warehouses`;



-- tablas de hoy hora 4 de la tarde dia 20 
-- Eliminar tablas si existen (para recrearlas)
DROP TABLE IF EXISTS devolucion_items;
DROP TABLE IF EXISTS devoluciones;

-- Tabla principal de devoluciones
CREATE TABLE IF NOT EXISTS devoluciones (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(20) NOT NULL,
    sale_id BIGINT UNSIGNED NOT NULL,
    total_amount DECIMAL(10,2) NOT NULL,
    reason TEXT NULL,
    user_register INT NOT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    FOREIGN KEY (sale_id) REFERENCES sales(id) ON DELETE CASCADE
);

-- Tabla de items devueltos
CREATE TABLE IF NOT EXISTS devolucion_items (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    devolucion_id BIGINT UNSIGNED NOT NULL,
    sale_item_id BIGINT UNSIGNED NOT NULL,
    quantity_returned INT NOT NULL,
    unit_price DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    FOREIGN KEY (devolucion_id) REFERENCES devoluciones(id) ON DELETE CASCADE,
    FOREIGN KEY (sale_item_id) REFERENCES sale_items(id) ON DELETE CASCADE
);


---- CAMBIOS ALEXANDER ----  -
CREATE TABLE `warehouses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `code` varchar(50) UNIQUE NOT NULL,
  `address` varchar(500) DEFAULT NULL,
  `type` enum('central','sucursal') NOT NULL DEFAULT 'central',
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
);

-- Insertar almacén central
INSERT INTO `warehouses` (`name`, `code`, `type`, `status`) 
VALUES ('Almacén Central', 'ALM-CENTRAL', 'central', 1);

USE clticomd_biker;
-- Agregar columna warehouse_id y quitar tienda_id de compras
ALTER TABLE `buys` ADD COLUMN `warehouse_id` bigint(20) unsigned NULL AFTER `supplier_id`;
ALTER TABLE `buys` ADD FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses`(`id`);

-- Las compras ya NO deben tener tienda_id, solo warehouse_id
-- ALTER TABLE `buys` DROP COLUMN `tienda_id`; -- Solo si quieres eliminarla completamente

-- Los items de compra también van al almacén, no a tienda específica
ALTER TABLE `buy_items` ADD COLUMN `warehouse_id` bigint(20) unsigned NULL AFTER `product_id`;
ALTER TABLE `buy_items` ADD FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses`(`id`);

-- ALTER TABLE `buy_items` DROP COLUMN `tienda_id`; -- Solo si quieres eliminarla

