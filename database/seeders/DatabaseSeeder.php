<?php

namespace Database\Seeders;

use App\Models\CuisineType;
use App\Models\Package;
use App\Models\PackageCategory;
use App\Models\PackageCuisine;
use App\Models\PaymentMethod;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            UserSeeder::class,
            AddressSeeder::class,
            PackageCategorySeeder::class,
            CuisineTypeSeeder::class,
            PaymentMethodSeeder::class,
            VendorSeeder::class,
            PackageSeeder::class,
            PackageCuisineSeeder::class,
            OrderSeeder::class,
            OrderItemSeeder::class
        ]);

    }
}
