-- Agregar campo lugar_provisional a la tabla cars
ALTER TABLE `cars` 
ADD COLUMN `lugar_provisional` VARCHAR(255) NULL AFTER `color` 
COMMENT 'Lugar provisional de la moto';
