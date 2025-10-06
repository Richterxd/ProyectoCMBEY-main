-- Fix para el problema de solicitud_id en la tabla reuniones
-- Este script corrige el tipo de datos y las relaciones

-- Paso 1: Eliminar la clave foránea existente
ALTER TABLE `reuniones` DROP FOREIGN KEY `reuniones_solicitud_id_foreign`;

-- Paso 2: Cambiar el tipo de columna de BIGINT UNSIGNED a VARCHAR
ALTER TABLE `reuniones` MODIFY `solicitud_id` VARCHAR(255) NOT NULL;

-- Paso 3: Agregar la nueva clave foránea que apunte al campo solicitud_id (string) de la tabla solicitudes
ALTER TABLE `reuniones` ADD CONSTRAINT `reuniones_solicitud_id_foreign` 
    FOREIGN KEY (`solicitud_id`) REFERENCES `solicitudes`(`solicitud_id`) ON DELETE CASCADE;

-- Verificar la estructura actualizada
DESCRIBE `reuniones`;
DESCRIBE `solicitudes`;

-- Mostrar las claves foráneas
SELECT 
    TABLE_NAME,
    COLUMN_NAME,
    CONSTRAINT_NAME,
    REFERENCED_TABLE_NAME,
    REFERENCED_COLUMN_NAME
FROM 
    INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
WHERE 
    TABLE_SCHEMA = DATABASE() 
    AND TABLE_NAME = 'reuniones' 
    AND REFERENCED_TABLE_NAME IS NOT NULL;