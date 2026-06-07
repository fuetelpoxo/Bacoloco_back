<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TipoSeeder extends Seeder
{
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('tipos')->truncate();
        Schema::enableForeignKeyConstraints();

        DB::table('tipos')->insert([
            ['id' => 1, 'nombre' => 'Discoteca'],
            ['id' => 2, 'nombre' => 'Bar'],
            ['id' => 3, 'nombre' => 'Verbena'],
        ]);
    }
}
