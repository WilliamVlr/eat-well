<?php

namespace Database\Factories;

use App\Models\Package;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $package = Package::inRandomOrder()->first();

        // Collect avail time slots and their prices
        if ($package?->breakfastPrice !== null)
            $timeSlots['Morning'] = $package->breakfastPrice;
        if ($package->lunchPrice !== null)
            $timeSlots['Afternoon'] = $package->breakfastPrice;
        if ($package->dinnerPrice !== null)
            $timeSlots['Evening'] = $package->dinnerPrice;

        // Pick a random avail time slot
        $slot = $this->faker->randomElement(array_keys($timeSlots));
        $price = $timeSlots[$slot];

        return [
            'packageId' => $package?->packageId,
            'packageTimeSlot' => $slot,
            'price' => $price,
            'quantity' => $this->faker->numberBetween(1, 5),
        ];
    }

    public function forVendor($vendorId)
    {
        return $this->state(function (array $attributes) use ($vendorId) {
            $package = Package::where('vendorId', $vendorId)->inRandomOrder()->first();

            // If vendor has no package, handle gracefully
            if (!$package) {
                throw new \Exception("Vendor $vendorId has no packages.");
            }

            $timeSlots = [];
            if ($package?->breakfastPrice !== null)
                $timeSlots['Morning'] = $package->breakfastPrice;
            if ($package?->lunchPrice !== null)
                $timeSlots['Afternoon'] = $package->lunchPrice;
            if ($package?->dinnerPrice !== null)
                $timeSlots['Evening'] = $package->dinnerPrice;

            $slot = $this->faker->randomElement(array_keys($timeSlots));
            $price = $timeSlots[$slot];

            return [
                'packageId' => $package?->packageId,
                'packageTimeSlot' => $slot,
                'price' => $price,
                'quantity' => $this->faker->numberBetween(1, 5),
            ];
        });
    }
}
