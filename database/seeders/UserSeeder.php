<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class UserSeeder extends Seeder
{
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('users')->truncate();
        Schema::enableForeignKeyConstraints();

        // 1. Admin
        DB::table('users')->insert([
            'id' => 1,
            'nombre' => 'Admin Bacoloco',
            'email' => 'admin@bacoloco.com',
            'password' => Hash::make('123456'), // Solo se encripta una vez
            'rol' => 'admin',
            'avatar' => null,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // 2. 2 Organizadores
        DB::table('users')->insert([
            [
                'id' => 2,
                'nombre' => 'Organizador Uno',
                'email' => 'organizador1@bacoloco.com',
                'password' => Hash::make('123456'),
                'rol' => 'organizador',
                'avatar' => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 3,
                'nombre' => 'Organizador Dos',
                'email' => 'organizador2@bacoloco.com',
                'password' => Hash::make('123456'),
                'rol' => 'organizador',
                'avatar' => null,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        // 3. 97 Usuarios Normales
        $faker = \Faker\Factory::create('es_ES');
        $users = [];

        // Optimizamos encriptando la contraseña una sola vez y usándola para todos los usuarios
        $defaultPassword = Hash::make('123456');

        for ($i = 4; $i <= 100; $i++) {
            $users[] = [
                'id' => $i,
                'nombre' => $faker->firstName . ' ' . $faker->lastName,
                'email' => "user{$i}@bacoloco.com",
                'password' => $defaultPassword,
                'rol' => 'usuario',
                'avatar' => null,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        // Insertar en bloques para mayor eficiencia
        foreach (array_chunk($users, 50) as $chunk) {
            DB::table('users')->insert($chunk);
        }
    }
}
