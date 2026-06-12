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
        Schema::create('libro_fragmentos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId("libro_id");
            $table->integer("pagina");
            $table->integer("orden");
            $table->text("texto");
            $table->text("embedding");
            $table->string("origen");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('libro_fragmentos');
    }
};
