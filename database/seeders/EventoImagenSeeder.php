<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class EventoImagenSeeder extends Seeder
{
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('evento_imagen')->truncate();
        Schema::enableForeignKeyConstraints();

        $count = DB::table('eventos')->count();
        $relations = [];

        // Asignar a cada evento una imagen aleatoria (id 1 o 2)
        for ($eventoId = 1; $eventoId <= $count; $eventoId++) {
            $relations[] = [
                'evento_id' => $eventoId,
                'imagen_id' => rand(1, 2),
            ];
        }

        DB::table('evento_imagen')->insert($relations);
    }
}
