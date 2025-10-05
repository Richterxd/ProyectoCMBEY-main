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
        Schema::create('ambitos', function (Blueprint $table) {
            // CÓDIGO CORREGIDO: Usar $table->id() es el estándar de Laravel.
            // Esto crea 'ambito_id' como BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
            // que resuelve el error 1171 de MySQL.
            $table->id('ambito_id'); 
            
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ambitos');
    }
};