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
        // CAMBIO CLAVE: 'reuniones' -> 'reunions'
        Schema::create('reunions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('solicitud_id');
            $table->unsignedBigInteger('institucion_id');
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->dateTime('fecha_reunion');
            $table->string('ubicacion')->nullable();
            $table->timestamps();

            $table->foreign('solicitud_id')->references('id')->on('solicitudes')->onDelete('cascade');
            $table->foreign('institucion_id')->references('id')->on('instituciones')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // CAMBIO CLAVE: 'reuniones' -> 'reunions'
        Schema::dropIfExists('reunions');
    }
};