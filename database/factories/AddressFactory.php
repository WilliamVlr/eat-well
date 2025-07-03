<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

     protected $model = Address::class;

    public function definition(): array
    {
        return [
            'provinsi' => fake()->state(),
            'kota' => fake()->city(),
            'kabupaten' => fake()->city(),
            'kecamatan' => fake()->streetName(),
            'kelurahan' => fake()->streetName(),
            'kode_pos' => fake()->postcode(),
            'jalan' => fake()->streetAddress(),
            'recipient_name' => fake()->name(),
            'recipient_phone' => fake()->phoneNumber(),
            'is_default' => fake()->boolean(),
            'userId' => User::factory(),
        ];
    }
}
