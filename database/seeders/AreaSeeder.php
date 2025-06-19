<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AreaSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 6; $i++) {
            DB::table('areas')->updateOrInsert(
                ['name' => "Area $i"],
                ['created_at' => now(), 'updated_at' => now()]
            );
        }
    }
}
