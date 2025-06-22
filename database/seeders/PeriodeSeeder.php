<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Periode;

class PeriodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run(): void
    {
        Periode::create([
            'nama' => 'Periode 2025',
            'tahun' => 2025
        ]);
        
        Periode::create([
            'nama' => 'Periode 2026',
            'tahun' => 2026
        ]);
         Periode::create([
            'nama' => 'Periode 2027',
            'tahun' => 2027
        ]);
    }
}
