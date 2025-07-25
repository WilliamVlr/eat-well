<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DeliveryStatusSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('delivery_statuses')->insert([
            // Order #1
            [
                'orderId'      => 1,
                'deliveryDate' => Carbon::now()->toDateString(),
                'slot'         => 'breakfast',
                'status'       => 'Prepared',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'orderId'      => 1,
                'deliveryDate' => Carbon::now()->toDateString(),
                'slot'         => 'lunch',
                'status'       => 'Prepared',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],

            // Order #2
            [
                'orderId'      => 2,
                'deliveryDate' => Carbon::now()->subDay()->toDateString(),
                'slot'         => 'dinner',
                'status'       => 'Delivered',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],

            // Order #3
            [
                'orderId'      => 3,
                'deliveryDate' => Carbon::now()->addDays(2)->toDateString(),
                'slot'         => 'breakfast',
                'status'       => 'Prepared',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'orderId'      => 3,
                'deliveryDate' => Carbon::now()->addDays(2)->toDateString(),
                'slot'         => 'lunch',
                'status'       => 'Prepared',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
        ]);
    }
}
