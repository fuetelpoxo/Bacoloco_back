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
        Schema::create('etiqueta_lugar', function (Blueprint $table) {
            $table->foreignId('lugar_id')->constrained('lugares')->cascadeOnDelete();
            $table->foreignId('etiqueta_id')->constrained('etiquetas')->cascadeOnDelete();
            $table->primary(['lugar_id', 'etiqueta_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('etiqueta_lugar');
    }
};
