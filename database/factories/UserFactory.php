<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = User::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'profilePath' => fake()->randomElement(['asset/profile/profil.jpg', 'asset/profile/user-profile.jpg', 'asset/profile/anya.jpg', 'asset/profile/anya-2.jpg']),
            'role' => 'Customer', // Default role
            'enabled2FA' => false,
            'remember_token' => Str::random(10),
            'dateOfBirth' => fake()->dateTimeBetween('-30 years', '-18 years'),
            'genderMale' => fake()->boolean(),
            'wellpay' => $this->faker->randomFloat(2, 0, 10000000),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function defaultAddress()
    {
        return $this->hasOne(\App\Models\Address::class, 'userId', 'userId')
            ->where('is_default', true);
    }
}
