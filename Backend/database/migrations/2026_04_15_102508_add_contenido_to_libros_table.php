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
        Schema::table('libros', function (Blueprint $table) {
            $table->string('contenido_path')->nullable();
            $table->string('contenido_nombre')->nullable();
            $table->unsignedBigInteger('contenido_tamano')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('libros', function (Blueprint $table) {
            $table->dropColumn(['contenido_path', 'contenido_nombre', 'contenido_tamano']);
        });
    }
};
