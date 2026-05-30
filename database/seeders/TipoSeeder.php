<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoSeeder extends Seeder
{
    public function run()
    {
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        DB::table('tipos')->truncate();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        DB::table('tipos')->insert([
            ['id' => 1, 'nombre' => 'Discoteca'],
            ['id' => 2, 'nombre' => 'Bar'],
            ['id' => 3, 'nombre' => 'Verbena'],
        ]);
    }
}
