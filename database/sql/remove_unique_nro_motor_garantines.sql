-- Eliminar índice único de nro_motor en garantines
-- Esto permite registrar múltiples garantías con el mismo número de motor
-- cuando las anteriores están desactivadas (status = 0)
-- La validación de unicidad se maneja en el código de Laravel

ALTER TABLE garantines DROP INDEX IF EXISTS garantines_nro_motor_unique;

-- Opcional: Crear un índice normal (no único) para mejorar búsquedas
CREATE INDEX idx_garantines_nro_motor ON garantines(nro_motor);


