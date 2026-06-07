<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ImagenSeeder extends Seeder
{
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('imagenes')->truncate();
        Schema::enableForeignKeyConstraints();

        DB::table('imagenes')->insert([
            [
                'id' => 1,
                'ruta' => 'santander.jpg',
                'tipo' => 'nose',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'ruta' => 'festival.jpg',
                'tipo' => 'nose',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
