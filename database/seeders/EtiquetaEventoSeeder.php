<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class EtiquetaEventoSeeder extends Seeder
{
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('etiqueta_evento')->truncate();
        Schema::enableForeignKeyConstraints();

        $count = DB::table('eventos')->count();
        $relations = [];

        // Asignar entre 1 y 3 etiquetas aleatorias a cada evento
        for ($eventoId = 1; $eventoId <= $count; $eventoId++) {
            $tagIds = range(1, 28);
            shuffle($tagIds);
            $numTags = rand(1, 3);
            for ($k = 0; $k < $numTags; $k++) {
                $relations[] = [
                    'evento_id' => $eventoId,
                    'etiqueta_id' => array_pop($tagIds),
                ];
            }
        }

        // Insertar en bloques
        foreach (array_chunk($relations, 100) as $chunk) {
            DB::table('etiqueta_evento')->insert($chunk);
        }
    }
}
