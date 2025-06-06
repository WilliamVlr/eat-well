<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Order::factory()
            ->count(20)
            ->create()
            ->each(function ($order) {
                $items = OrderItem::factory()
                    ->count(rand(1, 3))
                    ->forVendor($order->vendorId)
                    ->make(['orderId' => $order->orderId]);

                // Group by packageId and packageTimeSlot, sum quantities
                $grouped = [];
                foreach ($items as $item) {
                    // Always use the enum's value
                    $slot = $item->packageTimeSlot->value;
                    $key = $item->packageId . '-' . $slot;
                    if (!isset($grouped[$key])) {
                        $grouped[$key] = $item;
                    } else {
                        $grouped[$key]->quantity += $item->quantity;
                    }
                }

                $order->orderItems()->saveMany($grouped);

                // Calculate total price
                $total = $order->orderItems->sum(function ($item) {
                    return $item->price * $item->quantity;
                });

                $order->totalPrice = $total;
                $order->save();
            });
    }
}
