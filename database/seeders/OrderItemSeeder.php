<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('order_items')->insert([
            // Order #1 pakai paket id 1 untuk sarapan dan paket id 2 untuk makan siang
            [
                'orderId' => 1,
                'packageId' => 1,
                'packageTimeSlot' => 'breakfast',
                'price' => 45000.00,
                'quantity' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'orderId' => 1,
                'packageId' => 2,
                'packageTimeSlot' => 'lunch',
                'price' => 60000.00,
                'quantity' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Order #2 pakai paket id 2 untuk makan malam
            [
                'orderId' => 2,
                'packageId' => 2,
                'packageTimeSlot' => 'dinner',
                'price' => 45000.00,
                'quantity' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Order #3 pakai paket id 1 untuk sarapan
            [
                'orderId' => 3,
                'packageId' => 1,
                'packageTimeSlot' => 'breakfast',
                'price' => 45000.00,
                'quantity' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
