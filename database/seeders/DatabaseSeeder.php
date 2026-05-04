<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run()
    {
        $this->call([
            TipoSeeder::class,
            EtiquetaSeeder::class,
            UserSeeder::class,
            LugarSeeder::class,
            EventoSeeder::class,
            ImagenSeeder::class,
            EventoImagenSeeder::class,
            FavoritoSeeder::class,
            ValoracionSeeder::class,
            EtiquetaLugarSeeder::class,
            EtiquetaEventoSeeder::class,
        ]);
    }
}
