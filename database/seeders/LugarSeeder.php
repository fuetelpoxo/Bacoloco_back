<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LugarSeeder extends Seeder
{
    public function run()
    {
        DB::table('lugares')->insert([
            [
                'id' => 1,
                'nombre' => 'Kroker',
                'tipo_id' => 3,
                'user_id' => 1,
                'latitud' => 43.4623,
                'longitud' => -3.8099,
                'descripcion' => 'Discoteca de Cantabria',
                'activo' => 1,
                'municipio' => 'Torrelavega',
                'direccion' => 'Centro',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 2,
                'nombre' => 'Nasdak',
                'tipo_id' => 2,
                'user_id' => 1,
                'latitud' => 43.3522,
                'longitud' => -3.8196,
                'descripcion' => 'lo lolo lo lo',
                'activo' => 1,
                'municipio' => 'Penagos',
                'direccion' => 'Cabárceno',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
