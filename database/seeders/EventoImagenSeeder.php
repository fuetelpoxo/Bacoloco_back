<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventoImagenSeeder extends Seeder
{
    public function run()
    {
        DB::table('evento_imagen')->insert([
            ['evento_id' => 1, 'imagen_id' => 1],
            ['evento_id' => 1, 'imagen_id' => 2],
        ]);
    }
}
