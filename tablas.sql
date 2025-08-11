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
