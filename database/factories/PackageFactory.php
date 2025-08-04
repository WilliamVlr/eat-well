<?php

namespace Database\Factories;

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
            'menuPDFPath' => fake()->randomElement(['vegetarian-package-menu.pdf', 'meal_package_1.pdf', 'meal_package_2.pdf', 'meal_package_3.pdf']),
            'imgPath' => fake()->randomElement(['logo-packages.png', 'meat logo.png', 'other logo.png', 'vegetarian logo.png']),
            'averageCalories' => fake()->randomFloat(2, 100, 1000), // Contoh: 150.00
            'breakfastPrice' => fake()->randomElement([fake()->randomFloat(2, 100000, 1000000), null]),
            'lunchPrice' => fake()->randomElement([fake()->randomFloat(2, 100000, 1000000), null]),
            'dinnerPrice' => fake()->randomElement([fake()->randomFloat(2, 100000, 1000000), null]),
        ];
    }

     public function configure()
    {
        return $this->afterMaking(function (Package $package) {
            $breakfastPrice = $package->breakfastPrice;
            $lunchPrice = $package->lunchPrice;
            $dinnerPrice = $package->dinnerPrice;

            if (is_null($breakfastPrice) && is_null($lunchPrice) && is_null($dinnerPrice)) {
                $options = ['breakfastPrice', 'lunchPrice', 'dinnerPrice'];
                $chosenPrice = $this->faker->randomElement($options);

                $package->{$chosenPrice} = $this->faker->randomFloat(2, 100000, 1000000);
            }
        });
    }
}
