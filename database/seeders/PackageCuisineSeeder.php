<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PackageCuisineSeeder extends Seeder
{
    public function run(): void
    {
        $packageCuisines = [
            ['packageId' => 1, 'cuisineId' => 1],
            ['packageId' => 1, 'cuisineId' => 6],
            ['packageId' => 2, 'cuisineId' => 3],
        ];

        foreach ($packageCuisines as $pc) {
            DB::table('package_cuisine')->updateOrInsert($pc);
        }
    }
}
