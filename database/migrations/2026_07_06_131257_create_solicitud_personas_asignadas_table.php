<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('solicitud_personas_asignadas', function (Blueprint $table) {
            
            // 1. CORRECCIÓN DEL ERROR 1171: QUITAMOS ->nullable() de solicitud_id.
            // 2. Quitamos ->primary() de aquí para definirla como clave compuesta al final.
            $table->string('solicitud_id'); 
            
            // 3. QUITAMOS ->nullable() de persona_cedula por si acaso, debe ser NOT NULL.
            $table->unsignedBigInteger('persona_cedula'); 
            
            $table->date('fecha_asignacion')->nullable();
            $table->text('nota')->nullable();
            $table->timestamps();

            // CLAVE PRIMARIA COMPUESTA: Usamos las dos columnas como clave primaria.
            $table->primary(['solicitud_id', 'persona_cedula']); 

            // CLAVES FORÁNEAS
            $table->foreign('solicitud_id')->references('solicitud_id')->on('solicitudes')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('persona_cedula')->references('cedula')->on('personas')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitud_personas_asignadas');
    }
};