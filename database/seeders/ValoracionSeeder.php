<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ValoracionSeeder extends Seeder
{
    public function run()
    {
        DB::table('valoraciones')->insert([
            [
                'id' => 1,
                'user_id' => 1,
                'lugar_id' => 1,
                'puntuacion' => 5,
                'comentario' => 'Muy bonito',
                'reportado' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
