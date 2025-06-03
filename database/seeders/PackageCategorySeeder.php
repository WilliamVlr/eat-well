<?php

namespace Database\Seeders;

use App\Models\PackageCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PackageCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // PackageCategory::factory()->count(7)->create();
        $categories = [
            ['categoryName' => 'Vegetarian'],
            ['categoryName' => 'Gluten Free'],
            ['categoryName' => 'Halal'],
            ['categoryName' => 'Low Carb'],
            ['categoryName' => 'Low Calorie'],
            ['categoryName' => 'Organic'],
        ];

        foreach ($categories as $category) {
            PackageCategory::firstOrCreate($category);
        }
    }
}
