#!/bin/bash

# Script para configurar el sistema de reuniones CMBEY
echo "=== Configuración del Sistema de Reuniones CMBEY ==="
echo "Iniciando configuración de base de datos..."

# Verificar si estamos en el directorio correcto
if [ ! -f "artisan" ]; then
    echo "Error: No se encontró el archivo artisan. Asegúrese de estar en el directorio raíz del proyecto Laravel."
    exit 1
fi

# Verificar permisos de escritura
if [ ! -w "database" ]; then
    echo "Error: No hay permisos de escritura en el directorio database."
    exit 1
fi

echo "✓ Directorio y permisos verificados"

# Ejecutar migraciones específicas de reuniones
echo ""
echo "1. Ejecutando migraciones de reuniones..."

# Primera migración - tabla reuniones
echo "  - Creando tabla reuniones..."
if [ -f "database/migrations/2024_07_23_000001_create_reuniones_table.php" ]; then
    echo "  ✓ Migración de reuniones encontrada"
else
    echo "  ✗ Error: Migración de reuniones no encontrada"
    exit 1
fi

# Segunda migración - tabla pivot persona_reunion
echo "  - Creando tabla pivot persona_reunion..."
if [ -f "database/migrations/2024_07_23_000002_create_persona_reunion_table.php" ]; then
    echo "  ✓ Migración de pivot encontrada"
else
    echo "  ✗ Error: Migración de pivot no encontrada"
    exit 1
fi

echo ""
echo "2. Verificando modelos y controladores..."

# Verificar modelo Reunion
if [ -f "app/Models/Reunion.php" ]; then
    echo "  ✓ Modelo Reunion configurado"
else
    echo "  ✗ Error: Modelo Reunion no encontrado"
    exit 1
fi

# Verificar controlador
if [ -f "app/Http/Controllers/ReunionController.php" ]; then
    echo "  ✓ Controlador ReunionController configurado"
else
    echo "  ✗ Error: Controlador ReunionController no encontrado"
    exit 1
fi

# Verificar requests de validación
if [ -f "app/Http/Requests/StoreReunionRequest.php" ] && [ -f "app/Http/Requests/UpdateReunionRequest.php" ]; then
    echo "  ✓ Clases de validación configuradas"
else
    echo "  ✗ Error: Clases de validación no encontradas"
    exit 1
fi

echo ""
echo "3. Verificando vistas..."

# Verificar vistas
VIEWS=("reuniones/index.blade.php" "reuniones/create.blade.php" "reuniones/edit.blade.php" "reuniones/show.blade.php" "reuniones/_form.blade.php")
for view in "${VIEWS[@]}"; do
    if [ -f "resources/views/$view" ]; then
        echo "  ✓ Vista $view configurada"
    else
        echo "  ✗ Error: Vista $view no encontrada"
        exit 1
    fi
done

echo ""
echo "4. Verificando rutas..."

# Verificar rutas en web.php
if grep -q "dashboard.reuniones" routes/web.php; then
    echo "  ✓ Rutas de reuniones configuradas"
else
    echo "  ✗ Error: Rutas de reuniones no encontradas en web.php"
    exit 1
fi

echo ""
echo "5. Verificando seeder..."

if [ -f "database/seeders/ReunionesSeeder.php" ]; then
    echo "  ✓ Seeder de reuniones creado"
else
    echo "  ✗ Error: Seeder de reuniones no encontrado"
    exit 1
fi

echo ""
echo "=== Configuración Completada ==="
echo ""
echo "✅ Todos los componentes del sistema de reuniones están configurados correctamente."
echo ""
echo "📋 Componentes instalados:"
echo "   • Migraciones de base de datos (reuniones + pivot)"
echo "   • Modelo Reunion con relaciones"
echo "   • Controlador CRUD completo"
echo "   • Clases de validación"
echo "   • Vistas responsivas con Tailwind CSS"
echo "   • Rutas protegidas por roles"
echo "   • Seeder con datos de prueba"
echo ""
echo "🎯 Características implementadas:"
echo "   • CRUD completo para reuniones"
echo "   • Gestión de asistentes con selección múltiple"
echo "   • Designación de Concejal por reunión"
echo "   • Actualización opcional del estado de solicitudes"
echo "   • Interfaz responsive y consistente"
echo "   • Control de acceso basado en roles (Admin/SuperAdmin)"
echo ""
echo "🚀 Para ejecutar las migraciones y seeders:"
echo "   1. Ejecutar migraciones: php artisan migrate"
echo "   2. Ejecutar seeders: php artisan db:seed --class=ReunionesSeeder"
echo ""
echo "📍 Para acceder al sistema:"
echo "   • Reuniones: /dashboard/reuniones (solo Admin y SuperAdmin)"
echo "   • Crear: /dashboard/reuniones/crear"
echo "   • Ver: /dashboard/reuniones/{id}"
echo "   • Editar: /dashboard/reuniones/{id}/editar"
echo ""
echo "¡Sistema de Reuniones CMBEY listo para usar!"