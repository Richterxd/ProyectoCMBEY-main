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
            // Drop the existing foreign key constraint
            $table->dropForeign(['solicitud_id']);
            
            // Change the column type from unsignedBigInteger to string
            $table->string('solicitud_id')->change();
            
            // Add the foreign key constraint to reference the custom solicitud_id field
            $table->foreign('solicitud_id')->references('solicitud_id')->on('solicitudes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reuniones', function (Blueprint $table) {
            // Drop the foreign key constraint
            $table->dropForeign(['solicitud_id']);
            
            // Change back to unsignedBigInteger (this might cause data loss)
            $table->unsignedBigInteger('solicitud_id')->change();
            
            // Add back the original foreign key constraint
            $table->foreign('solicitud_id')->references('id')->on('solicitudes')->onDelete('cascade');
        });
    }
};