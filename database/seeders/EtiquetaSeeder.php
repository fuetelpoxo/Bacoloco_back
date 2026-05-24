<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class EtiquetaSeeder extends Seeder
{
    public function run()
    {
        // Desactivamos restricciones de llaves foráneas para poder limpiar la tabla tranquilamente
        Schema::disableForeignKeyConstraints();
        DB::table('etiquetas')->truncate();

        DB::table('etiquetas')->insert([
            // Edad y Filtros de acceso
            ['id' => 1, 'nombre' => '+18'],
            ['id' => 2, 'nombre' => '+16'],
            ['id' => 3, 'nombre' => '+21'],
            ['id' => 4, 'nombre' => 'Alcohol Free'],
            ['id' => 5, 'nombre' => 'Todo Público'],

            // Estilos de Música / Entretenimiento
            ['id' => 6, 'nombre' => 'Reggaeton'],
            ['id' => 7, 'nombre' => 'Techno'],
            ['id' => 8, 'nombre' => 'Rock / Indie'],
            ['id' => 9, 'nombre' => 'Música Comercial'],
            ['id' => 10, 'nombre' => 'Música 80s / 90s'],
            ['id' => 11, 'nombre' => 'Música en Vivo'],
            ['id' => 12, 'nombre' => 'DJ Set'],
            ['id' => 13, 'nombre' => 'Karaoke'],

            // Temáticas de Fiestas y Eventos
            ['id' => 14, 'nombre' => 'Halloween'],
            ['id' => 15, 'nombre' => 'Nochevieja'],
            ['id' => 16, 'nombre' => 'Carnaval'],
            ['id' => 17, 'nombre' => 'Fiesta Universitaria'],
            ['id' => 18, 'nombre' => 'San Patricio'],
            ['id' => 19, 'nombre' => 'Tardeo'],
            ['id' => 20, 'nombre' => 'Fiesta de la Espuma'],

            // Servicios y Características del local
            ['id' => 21, 'nombre' => 'Terraza'],
            ['id' => 22, 'nombre' => 'Zona VIP'],
            ['id' => 23, 'nombre' => 'Barra Libre'],
            ['id' => 24, 'nombre' => 'Cocktails'],
            ['id' => 25, 'nombre' => 'Futbolín / Billar'],
            ['id' => 26, 'nombre' => 'Pet Friendly'],
            ['id' => 27, 'nombre' => 'Guardarropa'],
            ['id' => 28, 'nombre' => 'Climatizado'],
        ]);

        // Volvemos a activar las restricciones de llaves foráneas
        Schema::enableForeignKeyConstraints();
    }
}
