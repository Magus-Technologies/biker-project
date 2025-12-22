-- ========================================
-- LIMPIAR VENTAS PENDIENTES VACÍAS
-- ========================================
-- Este script elimina registros de ventas_pendientes que no tienen datos reales
-- (sin cliente, sin productos, sin servicios)

-- 1. Ver cuántos registros vacíos hay
SELECT 
    COUNT(*) as total_vacios
FROM ventas_pendientes
WHERE 
    (JSON_EXTRACT(datos, '$.ventas[0].customer_dni') = '' OR JSON_EXTRACT(datos, '$.ventas[0].customer_dni') IS NULL)
    AND (JSON_EXTRACT(datos, '$.ventas[0].customer_names') = '' OR JSON_EXTRACT(datos, '$.ventas[0].customer_names') IS NULL)
    AND (JSON_EXTRACT(datos, '$.ventas[0].phone') = '' OR JSON_EXTRACT(datos, '$.ventas[0].phone') IS NULL)
    AND (JSON_LENGTH(datos, '$.ventas[0].products') = 0 OR JSON_LENGTH(datos, '$.ventas[0].products') IS NULL)
    AND (JSON_LENGTH(datos, '$.ventas[0].services') = 0 OR JSON_LENGTH(datos, '$.ventas[0].services') IS NULL);

-- 2. Ver detalles de los registros vacíos
SELECT 
    id,
    user_id,
    tipo,
    JSON_EXTRACT(datos, '$.ventas[0].customer_dni') as dni,
    JSON_EXTRACT(datos, '$.ventas[0].customer_names') as nombre,
    JSON_LENGTH(datos, '$.ventas[0].products') as num_productos,
    JSON_LENGTH(datos, '$.ventas[0].services') as num_servicios,
    fecha_guardado
FROM ventas_pendientes
WHERE 
    (JSON_EXTRACT(datos, '$.ventas[0].customer_dni') = '' OR JSON_EXTRACT(datos, '$.ventas[0].customer_dni') IS NULL)
    AND (JSON_EXTRACT(datos, '$.ventas[0].customer_names') = '' OR JSON_EXTRACT(datos, '$.ventas[0].customer_names') IS NULL)
    AND (JSON_EXTRACT(datos, '$.ventas[0].phone') = '' OR JSON_EXTRACT(datos, '$.ventas[0].phone') IS NULL)
    AND (JSON_LENGTH(datos, '$.ventas[0].products') = 0 OR JSON_LENGTH(datos, '$.ventas[0].products') IS NULL)
    AND (JSON_LENGTH(datos, '$.ventas[0].services') = 0 OR JSON_LENGTH(datos, '$.ventas[0].services') IS NULL);

-- 3. ELIMINAR registros vacíos (EJECUTAR CON CUIDADO)
DELETE FROM ventas_pendientes
WHERE 
    (JSON_EXTRACT(datos, '$.ventas[0].customer_dni') = '' OR JSON_EXTRACT(datos, '$.ventas[0].customer_dni') IS NULL)
    AND (JSON_EXTRACT(datos, '$.ventas[0].customer_names') = '' OR JSON_EXTRACT(datos, '$.ventas[0].customer_names') IS NULL)
    AND (JSON_EXTRACT(datos, '$.ventas[0].phone') = '' OR JSON_EXTRACT(datos, '$.ventas[0].phone') IS NULL)
    AND (JSON_LENGTH(datos, '$.ventas[0].products') = 0 OR JSON_LENGTH(datos, '$.ventas[0].products') IS NULL)
    AND (JSON_LENGTH(datos, '$.ventas[0].services') = 0 OR JSON_LENGTH(datos, '$.ventas[0].services') IS NULL);

-- 4. Verificar que se eliminaron
SELECT COUNT(*) as total_registros FROM ventas_pendientes;

-- 5. Ver registros restantes (con datos reales)
SELECT 
    id,
    user_id,
    tipo,
    JSON_EXTRACT(datos, '$.ventas[0].customer_names') as cliente,
    JSON_LENGTH(datos, '$.ventas[0].products') as productos,
    fecha_guardado
FROM ventas_pendientes;
