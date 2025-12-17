-- Tabla para marcas de motos
CREATE TABLE IF NOT EXISTS `brands_motos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `color_from` varchar(7) NOT NULL DEFAULT '#3b82f6' COMMENT 'Color inicial del gradiente (hex)',
  `color_to` varchar(7) NOT NULL DEFAULT '#1e40af' COMMENT 'Color final del gradiente (hex)',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=activo, 0=inactivo',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `brands_motos_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insertar las marcas iniciales
INSERT INTO `brands_motos` (`name`, `slug`, `color_from`, `color_to`, `status`, `created_at`, `updated_at`) VALUES
('PULSAR', 'pulsar', '#3b82f6', '#1e40af', 1, NOW(), NOW()),
('NS/RS/N', 'nsrsn', '#ef4444', '#b91c1c', 1, NOW(), NOW()),
('DOMINAR', 'dominar', '#10b981', '#047857', 1, NOW(), NOW()),
('DISCOVER', 'discover', '#06b6d4', '#0891b2', 1, NOW(), NOW()),
('BOXER/CT', 'boxer', '#f97316', '#ea580c', 1, NOW(), NOW()),
('CHINAS', 'chinas', '#eab308', '#ca8a04', 1, NOW(), NOW());
