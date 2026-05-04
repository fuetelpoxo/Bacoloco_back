<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImagenSeeder extends Seeder
{
    public function run()
    {
        DB::table('imagenes')->insert([
            [
                'id' => 1,
                'ruta' => 'santander.jpg',
                'tipo' => 'nose',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 2,
                'ruta' => 'festival.jpg',
                'tipo' => 'nose',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
