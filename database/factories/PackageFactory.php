<?php

namespace Database\Factories;

use App\Models\CuisineType;
use App\Models\Package;
use App\Models\PackageCategory;
use App\Models\Vendor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Package>
 */
class PackageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'categoryId' => PackageCategory::inRandomOrder()->first()->categoryId,
            'vendorId' => Vendor::inRandomOrder()->first()->vendorId,
            'name' => fake()->words(rand(1, 3), true),
            // 'menuPDFPath' => fake()->filePath('public', 'pdfs', false),
            // 'imgPath' => fake()->filePath('public', 'images', false),
            'menuPDFPath' => 'menus/' . fake()->slug() . '.pdf',
            'imgPath' => 'images/' . fake()->slug() . '.jpg',
            'averageCalories' => fake()->randomFloat(2, 100, 1000), // Contoh: 150.00
            'breakfastPrice' => fake()->randomFloat(2, 100000, 1000000),
            'lunchPrice' => fake()->randomFloat(2, 100000, 1000000),
            'dinnerPrice' => fake()->randomFloat(2, 100000, 1000000),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Package $package) {
            // Ambil semua ID cuisine yang sudah ada (dari CuisineTypeSeeder)
            $cuisineIds = CuisineType::pluck('cuisineId')->toArray();

            // Fallback jika tidak ada cuisine (hanya untuk mencegah error di development)
            if (empty($cuisineIds)) {
                 // Ini akan membuat 1 cuisine jika tidak ada,
                 // untuk memungkinkan factory Package tetap berjalan.
                 $cuisineIds = [CuisineType::factory()->create()->cuisineId];
            }

            // Pilih jumlah cuisine yang akan dikaitkan (1 hingga 3)
            $numCuisinesToAttach = $this->faker->numberBetween(1, min(3, count($cuisineIds)));

            // Ambil cuisine IDs secara acak tanpa duplikasi
            $randomCuisineIds = collect($cuisineIds)
                ->shuffle()
                ->take($numCuisinesToAttach)
                ->toArray();

            // Attach cuisine(s) to the package using sync()
            $package->cuisineTypes()->sync($randomCuisineIds);
        });
    }
}
