<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str as str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vendor>
 */
class VendorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Vendor::class;

    public function definition(): array
    {
        // $startBreakfast = fake()->dateTimeBetween('07:00', '08:00');
        // $endBreakfast = fake()->dateTimeBetween($startBreakfast->format('H:i'), '09:30');

        // $startLunch = fake()->dateTimeBetween('11:00', '11:30');
        // $endLunch = fake()->dateTimeBetween($startLunch->format('H:i'), '13:00');

        // $startDinner = fake()->dateTimeBetween('17:30', '18:00');
        // $endDinner = fake()->dateTimeBetween($startDinner->format('H:i'), '19:00');

        // Logika untuk Breakfast Delivery
        $breakfastDelivery = null;
        if (fake()->boolean(60)) { // 60% kemungkinan akan ada waktu pengiriman sarapan
            $startBreakfast = fake()->dateTimeBetween('07:00', '08:00');
            $endBreakfast = fake()->dateTimeBetween($startBreakfast->format('H:i'), '09:30');
            $breakfastDelivery = $startBreakfast->format('H:i') . ' - ' . $endBreakfast->format('H:i');
        }

        // Logika untuk Lunch Delivery
        $lunchDelivery = null;
        if (fake()->boolean(90)) { // 90% kemungkinan akan ada waktu pengiriman makan siang
            $startLunch = fake()->dateTimeBetween('11:00', '11:30');
            $endLunch = fake()->dateTimeBetween($startLunch->format('H:i'), '13:00');
            $lunchDelivery = $startLunch->format('H:i') . ' - ' . $endLunch->format('H:i');
        }

        // Logika untuk Dinner Delivery
        $dinnerDelivery = null;
        if (fake()->boolean(70)) { // 60% kemungkinan akan ada waktu pengiriman makan malam
            $startDinner = fake()->dateTimeBetween('17:30', '18:00');
            $endDinner = fake()->dateTimeBetween($startDinner->format('H:i'), '19:00');
            $dinnerDelivery = $startDinner->format('H:i') . ' - ' . $endDinner->format('H:i');
        }

        return [
            'userId' => User::inRandomOrder()->first()->userId,
            'addressId' => Address::inRandomOrder()->first()->addressId,
            'name' => Str::words(fake()->company(), 2, ''),
            // 'breakfast_delivery' => $startBreakfast->format('H:i') . ' - ' . $endBreakfast->format('H:i'),
            // 'lunch_delivery' => $startLunch->format('H:i') . ' - ' . $endLunch->format('H:i'),
            // 'dinner_delivery' => $startDinner->format('H:i') . ' - ' . $endDinner->format('H:i'),
            'breakfast_delivery' => $breakfastDelivery, // Gunakan variabel yang sudah dikondisikan
            'lunch_delivery' => $lunchDelivery,         // Gunakan variabel yang sudah dikondisikan
            'dinner_delivery' => $dinnerDelivery,       // Gunakan variabel yang sudah dikondisikan
            'logo' => fake()->imageUrl(640, 480, 'food', true, 'vendor'),
            'phone_number' => fake()->phoneNumber(),
            'rating' => fake()->randomFloat(1, 1, 5), // Rating between 1.0 and 5.0
        ];
    }
}
