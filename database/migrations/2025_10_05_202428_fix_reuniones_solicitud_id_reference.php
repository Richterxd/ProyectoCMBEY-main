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
        Schema::table('reuniones', function (Blueprint $table) {
            // Eliminar la foreign key actual
            $table->dropForeign(['solicitud_id']);
            
            // Cambiar el tipo de columna de unsignedBigInteger a string
            $table->string('solicitud_id', 191)->change();
            
            // Crear la nueva foreign key que referencia solicitud_id en lugar de id
            $table->foreign('solicitud_id')->references('solicitud_id')->on('solicitudes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reuniones', function (Blueprint $table) {
            // Revertir cambios
            $table->dropForeign(['solicitud_id']);
            $table->unsignedBigInteger('solicitud_id')->change();
            $table->foreign('solicitud_id')->references('id')->on('solicitudes')->onDelete('cascade');
        });
    }
};
