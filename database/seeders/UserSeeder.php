<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Role admin dan area1–area6
        Role::firstOrCreate(['name' => 'admin']);
        for ($i = 1; $i <= 6; $i++) {
            Role::firstOrCreate(['name' => "area$i"]);
        }

        // Admin user
        $admin = User::updateOrCreate(
            ['email' => 'admin@zi.com'],
            [
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'area' => null,
            ]
        );
        $admin->assignRole('admin');

        // Manager area 1–6
        for ($i = 1; $i <= 6; $i++) {
            $areaCode = "area$i";
            $user = User::updateOrCreate(
                ['email' => "$areaCode@zi.com"],
                [
                    'password' => Hash::make($areaCode),
                    'role' => 'manager',
                    'area' => $areaCode,
                ]
            );
            $user->assignRole($areaCode);
        }
    }
}
