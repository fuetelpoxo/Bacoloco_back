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
        Schema::table('lugares', function (Blueprint $table) {
            $table->index('tipo_id');
        });

        Schema::table('favoritos', function (Blueprint $table) {
            $table->index('lugar_id'); // user_id ya está cubierto por el prefijo de la clave única compuesta
        });

        Schema::table('valoraciones', function (Blueprint $table) {
            $table->index('lugar_id'); // user_id ya está cubierto por el prefijo de la clave única compuesta
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lugares', function (Blueprint $table) {
            $table->dropIndex(['tipo_id']);
        });

        Schema::table('favoritos', function (Blueprint $table) {
            $table->dropIndex(['lugar_id']);
        });

        Schema::table('valoraciones', function (Blueprint $table) {
            $table->dropIndex(['lugar_id']);
        });
    }
};
