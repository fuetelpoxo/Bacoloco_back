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
            $table->index('municipio');
        });

        Schema::table('eventos', function (Blueprint $table) {
            $table->index('fecha_inicio');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lugares', function (Blueprint $table) {
            $table->dropIndex(['municipio']);
        });

        Schema::table('eventos', function (Blueprint $table) {
            $table->dropIndex(['fecha_inicio']);
        });
    }
};
