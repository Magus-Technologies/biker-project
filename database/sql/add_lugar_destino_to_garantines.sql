-- Agregar campo lugar_destino_final a la tabla garantines
ALTER TABLE garantines ADD COLUMN lugar_destino_final VARCHAR(255) NULL AFTER boleta_dua_pdfs;
