<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EtiquetaSeeder extends Seeder
{
    public function run()
    {
        DB::table('etiquetas')->insert([
            ['id' => 1, 'nombre' => '+18'],
            ['id' => 2, 'nombre' => 'Tardeo'],
            ['id' => 3, 'nombre' => 'Halloween'],
            ['id' => 4, 'nombre' => 'Noche Vieja'],
        ]);
    }
}
