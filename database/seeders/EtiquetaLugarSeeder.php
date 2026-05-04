<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EtiquetaLugarSeeder extends Seeder
{
    public function run()
    {
        DB::table('etiqueta_lugar')->insert([
            ['lugar_id' => 1, 'etiqueta_id' => 2],
            ['lugar_id' => 2, 'etiqueta_id' => 1],
        ]);
    }
}
