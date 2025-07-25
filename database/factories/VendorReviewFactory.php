<?php

namespace Database\Factories;

use App\Models\VendorReview;
use App\Models\Vendor;
use App\Models\User;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VendorReview>
 */
class VendorReviewFactory extends Factory
{
    /**
     * The name of the corresponding model.
     *
     * @var string
     */
    protected $model = VendorReview::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $vendor = Vendor::inRandomOrder()->first();
        $user = User::inRandomOrder()->first();
        $order = Order::inRandomOrder()->first();

        // if (!$vendor) {
        //     throw new \Exception("Tidak ada vendor ditemukan. Jalankan VendorSeeder terlebih dahulu.");
        // }
        // if (!$user) {
        //     throw new \Exception("Tidak ada user ditemukan. Jalankan UserSeeder terlebih dahulu.");
        // }
        // if (!$order) {
        //     throw new \Exception("Tidak ada order ditemukan. Jalankan OrderSeeder terlebih dahulu.");
        // }

        return [
            'vendorId' => $vendor->vendorId,
            'userId' => $user->userId,
            'orderId' => $order->orderId,
            'rating' => fake()->randomFloat(0, 1, 5),
            'review' => fake()->optional(0.8)->paragraph(),
        ];
    }

    /**
     * Metode untuk mengaitkan review dengan Order, User, dan Vendor tertentu.
     * Digunakan secara eksplisit di seeder untuk memastikan relasi yang tepat.
     *
     * @param \App\Models\Order $order
     * @param \App\Models\User $user
     * @param \App\Models\Vendor $vendor
     * @return static
     */
    public function forOrderAndUser(Order $order, User $user, Vendor $vendor): static
    {
        return $this->state(function (array $attributes) use ($order, $user, $vendor) {
            return [
                'vendorId' => $vendor->vendorId,
                'userId' => $user->userId,
                'orderId' => $order->orderId,
            ];
        });
    }
}