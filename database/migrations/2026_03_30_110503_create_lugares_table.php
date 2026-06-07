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
        Schema::create('lugares', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipo_id')->constrained('tipos');
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->decimal('latitud', 10, 7); // decimal necesario para coordenadas precisas
            $table->decimal('longitud', 10, 7);
            $table->string('municipio');
            $table->string('direccion')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lugares');
    }
};
