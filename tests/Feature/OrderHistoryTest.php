<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use App\Models\Vendor;
use App\Models\Package;
use App\Models\OrderItem;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderHistoryTest extends TestCase
{
    /** @test */
    public function test_orders_are_displayed_in_order_history()
    {
        $user = User::query()->where('role', 'like', 'Customer')->first();
        $vendor = Vendor::factory()->create();
        $orders = Order::factory()->count(2)->create([
            'userId' => $user->userId,
            'vendorId' => $vendor->vendorId,
        ]);
    
        $response = $this->actingAs($user)->get('/orders');
    
        foreach ($orders as $order) {
            // $response->assertSee($order->order);
            $response->assertSee($order->vendor->name);
        }
        
    }

    /** @test */
    public function filter_orders_by_status(){
        $user = User::query()->where('role', 'like', 'Customer')->first();
        $vendorActive = Vendor::factory()->create(['name'=> 'Active Vendor']);
        $vendorFinished = Vendor::factory()->create(['name' => 'Finished Vendor']);
        $vendorCancelled = Vendor::factory()->create(['name' => 'Cancelled Vendor']);

        $activeOrder = Order::factory()->create([
        'userId' => $user->userId,
        'vendorId' => $vendorActive->vendorId,
        'isCancelled' => 0,
        'startDate' => now()->subDays(2),
        'endDate' => now()->addDays(2),
    ]);
    $finishedOrder = Order::factory()->create([
        'userId' => $user->userId,
        'vendorId' => $vendorFinished->vendorId,
        'isCancelled' => 0,
        'startDate' => now()->subDays(10),
        'endDate' => now()->subDays(1),
    ]);
    $cancelledOrder = Order::factory()->create([
        'userId' => $user->userId,
        'vendorId' => $vendorCancelled->vendorId,
        'isCancelled' => 1,
        'startDate' => now()->subDays(5),
        'endDate' => now()->addDays(5),
    ]);

    // Active tab
    $response = $this->actingAs($user)->get('/orders?status=active');
    $response->assertSee((string)$activeOrder->vendor->name);
    $response->assertDontSee((string)$finishedOrder->vendor->name);
    $response->assertDontSee((string)$cancelledOrder->vendor->name);

    // Finished tab
    $response = $this->actingAs($user)->get('/orders?status=finished');
    $response->assertSee((string)$finishedOrder->vendor->name);
    $response->assertDontSee((string)$activeOrder->vendor->name);
    $response->assertDontSee((string)$cancelledOrder->vendor->name);

    // Cancelled tab
    $response = $this->actingAs($user)->get('/orders?status=cancelled');
    $response->assertSee((string)$cancelledOrder->vendor->name);
    $response->assertDontSee((string)$activeOrder->vendor->name);
    $response->assertDontSee((string)$finishedOrder->vendor->name);
    }

   /** @test */
    public function test_order_history_page_shows_orders_or_empty_message()
    {
        $user = User::query()->where('role', 'like', 'Customer')->first();

        // Check if user has any orders
        $hasOrders = Order::where('userId', $user->userId)->exists();

        if ($hasOrders) {
            // Pick one order to check detail page
            $order = Order::where('userId', $user->userId)->first();
            $response = $this->actingAs($user)->get("/orders/{$order->orderId}");
            $response->assertSee($order->vendor->name);
            // Assert all order item/package names are shown
            foreach ($order->orderItems as $item) {
                $response->assertSee($item->name);
            }
        } else {
            // Check empty message for each status
            $statuses = [
                'active' => 'You have no active orders.',
                'finished' => 'You have no finished orders.',
                'cancelled' => 'You have no cancelled orders.',
                'all' => "You haven't ordered anything yet.",
            ];

            foreach ($statuses as $status => $message) {
                $response = $this->actingAs($user)->get("/orders?status={$status}");
                $response->assertSee('No orders found');
                $response->assertSee($message);
            }
        }
    }

    /** @test */
    public function test_search_orders_by_vendor_name_or_id()
    {
        $user = User::query()->where('role', 'like', 'Customer')->first();

        // Create vendors
        $vendorA = Vendor::factory()->create(['name' => 'Alpha Catering']);
        $vendorB = Vendor::factory()->create(['name' => 'Beta Catering']);

        // Create orders for the user with different vendors
        $orderA = Order::factory()->create([
            'userId' => $user->userId,
            'vendorId' => $vendorA->vendorId,
        ]);
        $orderB = Order::factory()->create([
            'userId' => $user->userId,
            'vendorId' => $vendorB->vendorId,
        ]);

        $packageA = Package::factory()->create(['name' => 'Special Lunch']);
        $packageB = Package::factory()->create(['name' => 'Deluxe Dinner']);

        // Create order items with all required fields
        OrderItem::create([
            'orderId' => $orderA->orderId,
            'packageId' => $packageA->packageId, // <-- use packageId, not id
            'name' => 'Special Lunch',
            'packageTimeSlot' => 'Afternoon',
            'price' => 30000,
            'quantity' => 3,
        ]);
        OrderItem::create([
            'orderId' => $orderB->orderId,
            'packageId' => $packageB->packageId, // <-- use packageId, not id
            'name' => 'Deluxe Dinner',
            'packageTimeSlot' => 'Evening',
            'price' => 50000,
            'quantity' => 4,
        ]);
        // Search by vendor name
        $response = $this->actingAs($user)->get('/orders?query=Alpha');
        $response->assertSee('Alpha Catering');
        $response->assertDontSee('Beta Catering');

        // Search by order item/package name
        $response = $this->actingAs($user)->get('/orders?query=Deluxe');
        $response->assertSee('Beta Catering');
        $response->assertSee('Deluxe Dinner');
        $response->assertDontSee('Alpha Catering');
        $response->assertDontSee('Special Lunch');

        // Search with a keyword that matches nothing
        $response = $this->actingAs($user)->get('/orders?query=NotExist');
        $response->assertSee('No orders found');
    }
}
