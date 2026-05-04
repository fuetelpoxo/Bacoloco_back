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
        Schema::create('etiqueta_evento', function (Blueprint $table) {
            $table->foreignId('evento_id')->constrained('eventos')->cascadeOnDelete();
            $table->foreignId('etiqueta_id')->constrained('etiquetas')->cascadeOnDelete();
            $table->primary(['evento_id', 'etiqueta_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('etiqueta_evento');
    }
};
