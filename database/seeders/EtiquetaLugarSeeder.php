<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class EtiquetaLugarSeeder extends Seeder
{
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('etiqueta_lugar')->truncate();
        Schema::enableForeignKeyConstraints();

        $relations = [];
        // Tenemos 280 lugares en total en LugarSeeder (79 discotecas, 89 bares, 112 verbenas)
        // Le asignamos entre 3 y 6 etiquetas a cada uno
        for ($lugarId = 1; $lugarId <= 280; $lugarId++) {
            $tagIds = range(1, 28);
            shuffle($tagIds);
            $numTags = rand(1, 4);
            for ($k = 0; $k < $numTags; $k++) {
                $relations[] = [
                    'lugar_id' => $lugarId,
                    'etiqueta_id' => array_pop($tagIds),
                ];
            }
        }

        // Insertar en bloques
        foreach (array_chunk($relations, 100) as $chunk) {
            DB::table('etiqueta_lugar')->insert($chunk);
        }
    }
}
