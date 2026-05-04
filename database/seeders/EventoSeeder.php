<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventoSeeder extends Seeder
{
    public function run()
    {
        DB::table('eventos')->insert([
            [
                'id' => 1,
                'lugar_id' => 1,
                'user_id' => 2,
                'nombre' => 'fiesta hallowen',
                'descripcion' => 'Festa',
                'fecha_inicio' => '2025-07-20',
                'fecha_fin' => '2025-07-22',
                'precio' => 50,
                'activo' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
