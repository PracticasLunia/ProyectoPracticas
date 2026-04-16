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
        Schema::table('genero_libro', function (Blueprint $table) {

            //Eliminar foreign keys
            $table->dropForeign(['genero_id']);
            $table->dropForeign(['libro_id']);

            //Volver a crearlas con NO ACTION Y CASCADE
            $table->foreign('genero_id')
                  ->references('id')
                  ->on('generos')
                  ->onDelete('no action');

            $table->foreign('libro_id')
                  ->references('id')
                  ->on('libros')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('genero_libro', function (Blueprint $table) {

        $table->dropForeign(['genero_id']);
        $table->dropForeign(['libro_id']);

        // Volver a cascade (rollback)
        $table->foreign('genero_id')
                ->references('id')
                ->on('generos')
                ->onDelete('cascade');

            $table->foreign('libro_id')
                ->references('id')
                ->on('libros')
                ->onDelete('cascade');
        });
    }
};
