<?php

namespace Database\Seeders;

use App\Models\VendorReview;
use App\Models\Vendor;
use App\Models\User;
use App\Models\Order;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VendorReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vendors = Vendor::all();

        foreach ($vendors as $vendor) {
            // Pastikan setiap vendor memiliki setidaknya 3 review
            for ($i = 0; $i < 3; $i++) {
                // Cari order yang terkait dengan vendor ini. Review hanya bisa diberikan jika ada order.
                $order = Order::where('vendorId', $vendor->vendorId)->inRandomOrder()->first();

                // Jika tidak ada order untuk vendor ini, kita tidak bisa membuat review terkait.
                // Anda mungkin perlu memastikan OrderSeeder membuat cukup order untuk setiap vendor.
                if (!$order) {
                    // Opsional: Buat satu order dummy jika tidak ada, agar bisa di-review
                    // Atau lewati saja jika memang tidak ada order untuk vendor ini.
                    // Jika Anda ingin memastikan setiap vendor punya order sebelum review,
                    // Anda harus modifikasi OrderSeeder juga.
                    continue; // Lewati vendor ini jika tidak ada order
                }

                $user = User::find($order->userId);

                if ($user) {
                    VendorReview::factory()
                                ->forOrderAndUser($order, $user, $vendor) // Gunakan state/method helper
                                ->create([
                                    'rating' => fake()->randomFloat(0, 2.0, 5.0), // Rating yang lebih realistis untuk review
                                    'review' => fake()->realText(150), // Review yang lebih panjang
                                ]);
                }
            }
        }

        // Buat beberapa review acak tambahan. Ini akan mengambil vendor, user, dan order secara acak dari yang sudah ada.
        VendorReview::factory()->count(30)->create();
    }
}