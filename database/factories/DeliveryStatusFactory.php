<?php

namespace Database\Factories;

use App\Enums\DeliveryStatuses;
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
            'deliveryDate' => fake()->dateTimeBetween('-1 month', 'now'),
            'slot' => fake()->randomElement(['Morning', 'Afternoon', 'Evening']),
            'status' => DeliveryStatuses::Prepared,
        ];
    }
}
