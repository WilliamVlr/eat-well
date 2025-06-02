<?php

namespace Database\Seeders;

use App\Models\CuisineType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CuisineTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // CuisineType::factory()->count(8)->create();
        $cuisines = [
            ['cuisineName' => 'Indonesian'],
            ['cuisineName' => 'Thai'],
            ['cuisineName' => 'Chinese'],
            ['cuisineName' => 'Japanese'],
            ['cuisineName' => 'Western'],
            ['cuisineName' => 'Indian'],
        ];

        foreach ($cuisines as $cuisine) {
            CuisineType::firstOrCreate($cuisine);
        }
    }
}
