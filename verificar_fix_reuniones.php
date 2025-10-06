<?php

/**
 * Script de verificación para el fix de reuniones
 * Ejecutar con: php verificar_fix_reuniones.php
 */

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

// Cargar configuración de Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "🔍 VERIFICACIÓN DEL FIX DE REUNIONES\n";
echo "=====================================\n\n";

try {
    // 1. Verificar estructura de tabla reuniones
    echo "1. Verificando estructura de tabla 'reuniones'...\n";
    
    $reunionesColumns = DB::select("DESCRIBE reuniones");
    $solicitudIdColumn = null;
    
    foreach ($reunionesColumns as $column) {
        if ($column->Field === 'solicitud_id') {
            $solicitudIdColumn = $column;
            break;
        }
    }
    
    if ($solicitudIdColumn) {
        $type = strtoupper($solicitudIdColumn->Type);
        if (strpos($type, 'VARCHAR') !== false || strpos($type, 'CHAR') !== false) {
            echo "   ✅ Campo 'solicitud_id' es tipo STRING ($type)\n";
        } else {
            echo "   ❌ Campo 'solicitud_id' sigue siendo tipo numérico ($type)\n";
            echo "   🔧 SOLUCIÓN: Ejecutar el script SQL de fix\n";
        }
    } else {
        echo "   ❌ Campo 'solicitud_id' no encontrado\n";
    }
    
    // 2. Verificar estructura de tabla solicitudes  
    echo "\n2. Verificando estructura de tabla 'solicitudes'...\n";
    
    $solicitudesColumns = DB::select("DESCRIBE solicitudes");
    $solicitudIdSolicitudes = null;
    
    foreach ($solicitudesColumns as $column) {
        if ($column->Field === 'solicitud_id') {
            $solicitudIdSolicitudes = $column;
            break;
        }
    }
    
    if ($solicitudIdSolicitudes) {
        echo "   ✅ Campo 'solicitud_id' en solicitudes: {$solicitudIdSolicitudes->Type}\n";
    }
    
    // 3. Verificar claves foráneas
    echo "\n3. Verificando claves foráneas...\n";
    
    $foreignKeys = DB::select("
        SELECT 
            COLUMN_NAME,
            CONSTRAINT_NAME,
            REFERENCED_TABLE_NAME,
            REFERENCED_COLUMN_NAME
        FROM 
            INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
        WHERE 
            TABLE_SCHEMA = DATABASE() 
            AND TABLE_NAME = 'reuniones' 
            AND REFERENCED_TABLE_NAME IS NOT NULL
    ");
    
    $correctForeignKey = false;
    foreach ($foreignKeys as $fk) {
        if ($fk->COLUMN_NAME === 'solicitud_id') {
            if ($fk->REFERENCED_COLUMN_NAME === 'solicitud_id') {
                echo "   ✅ Clave foránea correcta: reuniones.solicitud_id -> solicitudes.solicitud_id\n";
                $correctForeignKey = true;
            } else {
                echo "   ❌ Clave foránea incorrecta: reuniones.solicitud_id -> solicitudes.{$fk->REFERENCED_COLUMN_NAME}\n";
            }
        }
    }
    
    if (!$correctForeignKey) {
        echo "   ❌ No se encontró clave foránea para solicitud_id\n";
    }
    
    // 4. Probar consulta de relación
    echo "\n4. Probando relación entre tablas...\n";
    
    $testQuery = DB::select("
        SELECT 
            r.id as reunion_id,
            r.titulo as reunion_titulo,
            s.solicitud_id,
            s.titulo as solicitud_titulo
        FROM reuniones r 
        LEFT JOIN solicitudes s ON r.solicitud_id = s.solicitud_id 
        LIMIT 3
    ");
    
    if (count($testQuery) > 0) {
        echo "   ✅ Relación funcionando correctamente\n";
        foreach ($testQuery as $row) {
            echo "      - Reunión: {$row->reunion_titulo} -> Solicitud: {$row->solicitud_id}\n";
        }
    } else {
        echo "   ⚠️  No hay datos de prueba, pero la consulta funciona\n";
    }
    
    // 5. Verificar modelos de Eloquent
    echo "\n5. Verificando modelos de Laravel...\n";
    
    if (class_exists('App\Models\Reunion')) {
        echo "   ✅ Modelo Reunion existe\n";
    }
    
    if (class_exists('App\Models\Solicitud')) {
        echo "   ✅ Modelo Solicitud existe\n";
    }
    
    // Resumen final
    echo "\n📊 RESUMEN:\n";
    echo "=========\n";
    
    if ($solicitudIdColumn && (strpos(strtoupper($solicitudIdColumn->Type), 'VARCHAR') !== false || strpos(strtoupper($solicitudIdColumn->Type), 'CHAR') !== false) && $correctForeignKey) {
        echo "🎉 ¡FIX APLICADO CORRECTAMENTE!\n";
        echo "   ✅ Tipo de datos corregido\n";
        echo "   ✅ Clave foránea configurada\n";
        echo "   ✅ Relaciones funcionando\n";
        echo "\n💡 Ahora puedes crear reuniones sin problemas\n";
    } else {
        echo "⚠️  FIX INCOMPLETO - Pasos pendientes:\n";
        
        if (!$solicitudIdColumn || strpos(strtoupper($solicitudIdColumn->Type), 'VARCHAR') === false) {
            echo "   🔧 Cambiar tipo de datos de solicitud_id a VARCHAR\n";
        }
        
        if (!$correctForeignKey) {
            echo "   🔧 Actualizar clave foránea\n";
        }
        
        echo "\n📋 Ejecuta el script SQL proporcionado en fix_reuniones_database.sql\n";
    }

} catch (Exception $e) {
    echo "❌ Error al verificar: " . $e->getMessage() . "\n";
    echo "\n💡 Asegúrate de que:\n";
    echo "   - La base de datos esté configurada correctamente\n";
    echo "   - Las credenciales en .env sean correctas\n";
    echo "   - La aplicación Laravel esté configurada\n";
}

echo "\n";
?>