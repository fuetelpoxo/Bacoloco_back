<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'id' => 1,
                'nombre' => 'Juan',
                'email' => 'juan@cantabria.com',
                'password' => Hash::make('123456'),
                'rol' => 'usuario',
                'avatar' => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 2,
                'nombre' => 'Ana',
                'email' => 'ana@cantabria.com',
                'password' => Hash::make('123456'),
                'rol' => 'admin',
                'avatar' => null,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
