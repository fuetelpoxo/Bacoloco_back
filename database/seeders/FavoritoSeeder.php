<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FavoritoSeeder extends Seeder
{
    public function run()
    {
        DB::table('favoritos')->insert([
            [
                'id' => 1,
                'user_id' => 1,
                'lugar_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
