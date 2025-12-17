-- Agregar campos a la tabla garantines
ALTER TABLE garantines 
ADD COLUMN IF NOT EXISTS celular VARCHAR(20) NULL AFTER nombres_apellidos,
ADD COLUMN IF NOT EXISTS kilometrajes VARCHAR(50) NULL AFTER celular,
ADD COLUMN IF NOT EXISTS boleta_dua_pdfs TEXT NULL AFTER kilometrajes,
ADD COLUMN IF NOT EXISTS lugar_destino_final VARCHAR(255) NULL AFTER boleta_dua_pdfs;
