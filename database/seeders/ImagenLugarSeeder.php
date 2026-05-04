<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImagenLugarSeeder extends Seeder
{
    public function run()
    {
        DB::table('imagen_lugar')->insert([
            ['lugar_id' => 1, 'imagen_id' => 2],
            ['lugar_id' => 2, 'imagen_id' => 1],
        ]);
    }
}
