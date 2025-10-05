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
        Schema::create('solicitudes', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->string('solicitud_id')->unique(); // Custom ID: YYYYMMDD + hash
            
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            
            // Enhanced status management
            $table->string('estado_detallado')->default('Pendiente'); // Pendiente, Aprobada, Rechazada, Asignada
            $table->text('observaciones_admin')->nullable();

            //timestamps
            $table->timestamp('fecha_actualizacion_usuario')->nullable();
            $table->timestamp('fecha_actualizacion_super_admin')->nullable();
            $table->timestamp('fecha_creacion')->useCurrent();

            // otros datos
            $table->unsignedBigInteger('persona_cedula');
            $table->unsignedBigInteger('ambito_id');
            $table->boolean('derecho_palabra')->default(false);
            
            // New fields for enhanced solicitud system
            $table->string('categoria')->nullable(); // servicios, social, sucesos naturales
            $table->string('subcategoria')->nullable(); // agua, electricidad, etc.
            $table->enum('tipo_solicitud', ['individual', 'colectivo_institucional'])->default('individual');
            $table->string('nombre_rif_institucion')->nullable();
            
            // Enhanced address fields
            $table->string('pais')->default('Venezuela');
            $table->string('estado_region')->default('Yaracuy');
            $table->string('municipio')->default('Bruzual');
            $table->string('parroquia')->nullable();
            $table->string('comunidad')->nullable();
            $table->text('direccion_detallada')->nullable();
            
            //foreign keys
            // Add foreign key for assigned visitor
            $table->foreign('persona_cedula')->references('cedula')->on('personas')->onDelete('cascade');
            $table->foreign('ambito_id')->references('ambito_id')->on('ambitos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('solicitudes', function (Blueprint $table) {
            $table->dropForeign(['visitador_asignado']); // Revisa esta línea, no veo 'visitador_asignado' en up()
            $table->dropForeign(['persona_cedula']);
            $table->dropForeign(['ambito_id']);
            Schema::dropIfExists('solicitudes'); // Es mejor usar dropIfExists si estás en down()
        });
    }
};