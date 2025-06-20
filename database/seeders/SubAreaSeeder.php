<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SubArea;
use App\Models\Area;

class SubAreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subAreas = [['area_id' => 1, 'name' => 'MANAJEMEN PERUBAHAN'], ['area_id' => 2, 'name' => 'PENATAAN TATALAKSANA'], ['area_id' => 3, 'name' => 'PENATAAN SISTEM MANAJEMEN SDM APARATUR'], ['area_id' => 4, 'name' => 'PENGUATAN AKUNTABILITAS'], ['area_id' => 5, 'name' => 'PENGUATAN PENGAWASAN'], ['area_id' => 6, 'name' => 'PENINGKATAN KUALITAS PELAYANAN PUBLIK']];

        foreach ($subAreas as $subArea) {
            SubArea::create($subArea);
        }
    }
}
