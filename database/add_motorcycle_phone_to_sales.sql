-- Agregar campos motorcycle_model, phone y seller_name a la tabla sales
-- Fecha: 2025-12-03
-- Actualizado: 2025-12-04

ALTER TABLE `sales`
ADD COLUMN `motorcycle_model` VARCHAR(255) NULL AFTER `customer_address`,
ADD COLUMN `phone` VARCHAR(20) NULL AFTER `motorcycle_model`,
ADD COLUMN `seller_name` VARCHAR(255) NULL COMMENT 'Nombre del vendedor' AFTER `phone`,
ADD COLUMN `tienda_id` BIGINT UNSIGNED NULL COMMENT 'ID de la tienda' AFTER `seller_name`,
ADD FOREIGN KEY (`tienda_id`) REFERENCES `tiendas`(`id`) ON DELETE SET NULL;
