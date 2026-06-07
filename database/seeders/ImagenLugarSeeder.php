<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ImagenLugarSeeder extends Seeder
{
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('imagen_lugar')->truncate();
        Schema::enableForeignKeyConstraints();

        $relations = [];
        // Asignar a cada uno de los 115 lugares una imagen aleatoria (id 1 o 2)
        for ($lugarId = 1; $lugarId <= 115; $lugarId++) {
            $relations[] = [
                'lugar_id' => $lugarId,
                'imagen_id' => rand(1, 2),
            ];
        }

        DB::table('imagen_lugar')->insert($relations);
    }
}
