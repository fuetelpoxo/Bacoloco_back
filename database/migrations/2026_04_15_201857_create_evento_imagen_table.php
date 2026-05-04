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
        Schema::create('evento_imagen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('imagen_id')->constrained('imagenes')->cascadeOnDelete();
            $table->foreignId('evento_id')->constrained('eventos')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evento_imagen');
    }
};
