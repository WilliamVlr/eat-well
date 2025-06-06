<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Package;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $start = $this->faker->dateTimeBetween("-1 month", "now");
        $end = (clone $start)->modify("+" . rand(1, 14) . "days");

        // Only pick vendors who have at least one package
        $vendorId = Package::query()
            ->inRandomOrder()
            ->first()
                ?->vendorId;

        return [
            'userId' => User::inRandomOrder()->first()?->userId,
            'vendorId' => $vendorId,
            'addressId' => Address::inRandomOrder()->first()?->addressId,
            'totalPrice' => 0,
            'startDate' => $start,
            'endDate' => $end,
            'isCancelled' => $this->faker->boolean(10),
        ];
    }
}
