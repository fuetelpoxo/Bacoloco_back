<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EtiquetaEventoSeeder extends Seeder
{
    public function run()
    {
        DB::table('etiqueta_evento')->insert([
            ['evento_id' => 1, 'etiqueta_id' => 2],
        ]);
    }
}
