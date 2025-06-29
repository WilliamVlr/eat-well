<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DeliveryStatus>
 */
class DeliveryStatusFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'orderId' => Order::factory(),
            'deliveryDate' => fake()->dateTime(),
            'slot' => fake()->randomElement(['Morning', 'Afternoon', 'Evening']),
            'status' => 'Prepared',
        ];
    }
}
