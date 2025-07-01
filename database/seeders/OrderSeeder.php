<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Contoh data dummy, pastikan userId dan vendorId ini memang ada di tabel users & vendors
        DB::table('orders')->insert([
            [
                'userId' => 1,
                'vendorId' => 1,
                'totalPrice' => 150000.00,
                'startDate' => Carbon::now(),
                'endDate' => Carbon::now()->addDays(6),
                'isCancelled' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'userId' => 2,
                'vendorId' => 2,
                'totalPrice' => 45000.00,
                'startDate' => Carbon::now(),
                'endDate' => Carbon::now()->addDays(6),
                'isCancelled' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'userId' => 1,
                'vendorId' => 3,
                'totalPrice' => 90000.00,
                'startDate' => Carbon::now(),
                'endDate' => Carbon::now()->addDays(6),
                'isCancelled' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
