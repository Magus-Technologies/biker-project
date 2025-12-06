-- Agregar campo delivery_status a la tabla sales
-- 0 = pendiente, 1 = entregado

ALTER TABLE sales ADD COLUMN delivery_status TINYINT(1) DEFAULT 0 COMMENT '0=pendiente, 1=entregado';
ALTER TABLE sales ADD COLUMN delivered_at TIMESTAMP NULL COMMENT 'Fecha y hora de entrega';

-- Índice para filtrar por estado de entrega
ALTER TABLE sales ADD INDEX idx_delivery_status (delivery_status);
