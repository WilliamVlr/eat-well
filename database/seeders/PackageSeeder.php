<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $packages = [
            [
                'categoryId' => 1,
                'vendorId' => 1,
                'name' => 'Healthy Veggie Breakfast',
                'menuPDFPath' => 'healthy-veggie-breakfast.pdf',
                'imgPath' => 'healthy-veggie-breakfast.png',
                'averageCalories' => 350,
                'breakfastPrice' => 45000.00,
                'lunchPrice' => 60000.00,
                'dinnerPrice' => 50000.00,
            ],
            [
                'categoryId' => 2,
                'vendorId' => 2,
                'name' => 'Gluten Free Lunch Special',
                'menuPDFPath' => 'gluten-free-lunch.pdf',
                'imgPath' => 'gluten-free-lunch.png',
                'averageCalories' => 500,
                'breakfastPrice' => 15000.00,
                'lunchPrice' => 60000.00,
                'dinnerPrice' => 45000.00,
            ],
        ];

        foreach ($packages as $package) {
            Package::firstOrCreate(['name' => $package['name']], $package);
        }
    }
}
