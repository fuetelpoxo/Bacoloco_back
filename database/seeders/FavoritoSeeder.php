<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class FavoritoSeeder extends Seeder
{
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('favoritos')->truncate();
        Schema::enableForeignKeyConstraints();

        DB::table('favoritos')->insert([
            [
                'id' => 1,
                'user_id' => 4, // normal user
                'lugar_id' => 1, // Kroker/discoteca
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 2,
                'user_id' => 4,
                'lugar_id' => 51, // bar
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
