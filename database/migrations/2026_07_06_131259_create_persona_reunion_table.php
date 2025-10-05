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
        Schema::create('persona_reunion', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('persona_cedula'); // Changed to cedula since Personas uses cedula as primary key
            $table->unsignedBigInteger('reunion_id');
            $table->boolean('es_concejal')->default(false); // New field to mark Concejal
            $table->timestamps();

            $table->foreign('persona_cedula')->references('cedula')->on('personas')->onDelete('cascade');
            $table->foreign('reunion_id')->references('id')->on('reuniones')->onDelete('cascade');

            $table->unique(['persona_cedula', 'reunion_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('persona_reunion');
    }
};