<?php

namespace Tests\Feature;

use App\Models\DeliveryStatus;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Package;
use App\Models\PackageCategory;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\User;
use App\Models\Vendor;
use Carbon\Carbon;
use Database\Seeders\AddressSeeder;
use Database\Seeders\CuisineTypeSeeder;
use Database\Seeders\PackageCategorySeeder;
use Database\Seeders\PaymentMethodSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class VendorHomePageTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate:fresh');

        $this->seed([
            AddressSeeder::class,
            CuisineTypeSeeder::class,
            PackageCategorySeeder::class,
            PaymentMethodSeeder::class
        ]);
    }

    /**
     * Summary of tc1_display_welcome_and_delivery_schedule
     * @test
     */
    public function tc1_display_welcome_and_delivery_schedule()
    {
        /**
         * @var User | Authenticatable $user
         */
        $user = User::factory()->create([
            'email' => 'vendor1@mail.com',
            'name' => 'Green Catering',
            'role' => 'Vendor',
        ]);

        $vendor = Vendor::factory()->create([
            'userId' => $user->userId,
            'name' => 'Green Catering',
            'breakfast_delivery' => '06:30-07:30',
            'lunch_delivery' => '11:30-12:30',
            'dinner_delivery' => '17:30-18:30',
        ]);

        $response = $this->actingAs($user)->get('/cateringHomePage');

        $response->assertStatus(200);
        $response->assertSeeText('Welcome, Green Catering');
        $response->assertSeeText('Served from 06:30-07:30');
        $response->assertSeeText('Served from 11:30-12:30');
        $response->assertSeeText('Served from 17:30-18:30');
    }

    /**
     * @test
     */
    public function tc2_list_orders_per_slot()
    {
        $this->withoutExceptionHandling();

        // Get current week's Monday to Sunday
        $startOfWeek = now()->startOfWeek(Carbon::MONDAY);
        $endOfWeek = now()->endOfWeek(Carbon::SUNDAY);

        // 1. Create user
        /**
         * @var User | Authenticatable $user
         */
        $user = User::factory()->create([
            'email' => 'vendor1@mail.com',
            'name' => 'Green Catering',
            'role' => 'Vendor',
        ]);

        // 2. Create vendor
        $vendor = Vendor::factory()->create([
            'userId' => $user->userId,
            'name' => 'Green Catering',
            'breakfast_delivery' => '06:30-07:30',
            'lunch_delivery' => '11:30-12:30',
            'dinner_delivery' => '17:30-18:30',
        ]);

        // 3. Create 3 packages for different slots
        $breakfastPackage = Package::factory()->create([
            'vendorId' => $vendor->vendorId,
            'name' => 'Protein Pack A',
            'breakfastPrice' => 50000,
            'lunchPrice' => null,
            'dinnerPrice' => null,
        ]);

        $lunchPackage = Package::factory()->create([
            'vendorId' => $vendor->vendorId,
            'name' => 'Vegan Delight',
            'breakfastPrice' => null,
            'lunchPrice' => 60000,
            'dinnerPrice' => null,
        ]);

        $dinnerPackage = Package::factory()->create([
            'vendorId' => $vendor->vendorId,
            'name' => 'Energy Bowl',
            'breakfastPrice' => null,
            'lunchPrice' => null,
            'dinnerPrice' => 70000,
        ]);

        // 4. Create order
        $order = Order::factory()->create([
            'vendorId' => $vendor->vendorId,
            'startDate' => $startOfWeek,
            'endDate' => $endOfWeek,
        ]);

        // 5. Create order items
        $orderItems = collect([
            OrderItem::factory()->make([
                'orderId' => $order->orderId,
                'packageId' => $breakfastPackage->packageId,
                'packageTimeSlot' => 'Morning',
                'price' => $breakfastPackage->breakfastPrice,
                'quantity' => 2,
            ]),
            OrderItem::factory()->make([
                'orderId' => $order->orderId,
                'packageId' => $lunchPackage->packageId,
                'packageTimeSlot' => 'Afternoon',
                'price' => $lunchPackage->lunchPrice,
                'quantity' => 1,
            ]),
            OrderItem::factory()->make([
                'orderId' => $order->orderId,
                'packageId' => $dinnerPackage->packageId,
                'packageTimeSlot' => 'Evening',
                'price' => $dinnerPackage->dinnerPrice,
                'quantity' => 3,
            ]),
        ]);

        $order->orderItems()->saveMany($orderItems);

        // 6. Recalculate total price for order
        $order->update([
            'totalPrice' => $orderItems->sum(fn($item) => $item->price * $item->quantity),
        ]);

        // 7. Create payment
        Payment::factory()->create([
            'orderId' => $order->orderId,
            'paid_at' => now()->subDay(),
        ]);

        // 8. Create delivery statuses per slot per day in current week
        $slots = ['Morning', 'Afternoon', 'Evening'];
        foreach ($slots as $slot) {
            for ($i = 0; $i < 7; $i++) {
                DeliveryStatus::factory()->create([
                    'orderId' => $order->orderId,
                    'deliveryDate' => $startOfWeek->copy()->addDays($i),
                    'slot' => $slot,
                ]);
            }
        }

        // 9. Assert response and visible content
        $this->actingAs($user)
            ->get('/cateringHomePage')
            ->assertSee('2 × ' . $breakfastPackage->name)
            ->assertSee('1 × ' . $lunchPackage->name)
            ->assertSee('3 × ' . $dinnerPackage->name);
    }

    /**
     * @test
     */
    public function tc3_no_orders_show_placeholder()
    {
        $this->withoutExceptionHandling();

        // 1. Create user
        /**
         * @var User | Authenticatable $user
         */
        $user = User::factory()->create([
            'email' => 'vendor1@mail.com',
            'name' => 'Green Catering',
            'role' => 'Vendor',
        ]);

        // 2. Create vendor with defined delivery slots
        $vendor = Vendor::factory()->create([
            'userId' => $user->userId,
            'name' => 'Green Catering',
            'breakfast_delivery' => '06:30-07:30',
            'lunch_delivery' => '11:30-12:30',
            'dinner_delivery' => '17:30-18:30',
        ]);

        // 3. Assert placeholder is shown when there's no order
        $this->actingAs($user)
            ->get('/cateringHomePage')
            ->assertSee('No orders yet')
            ->assertSee('Served from 06:30-07:30')
            ->assertSee('Served from 11:30-12:30')
            ->assertSee('Served from 17:30-18:30');
    }

    /**
     * @test
     */
    public function tc4_sales_chart_displayed_correctly()
    {
        $this->withoutExceptionHandling();

        // 1. Create user
        /**
         * @var User | Authenticatable $user
         */
        $user = User::factory()->create([
            'email' => 'vendor1@mail.com',
            'role' => 'Vendor',
        ]);

        // 2. Create vendor
        $vendor = Vendor::factory()->create(['userId' => $user->userId]);

        // 3. Define 4 weekly starting dates in this month
        $weekStarts = collect(range(0, 3))->map(fn($i) => now()->startOfMonth()->addWeeks($i));
        $amounts = [100000, 200000, 0, 400000];

        foreach ($weekStarts as $i => $start) {
            // 4. Create order
            $order = Order::factory()->create([
                'vendorId' => $vendor->vendorId,
                'startDate' => $start,
                'endDate' => $start->copy()->endOfWeek(Carbon::SUNDAY),
            ]);

            // 5. Create one package and order item
            $package = Package::factory()->create([
                'vendorId' => $vendor->vendorId,
                'lunchPrice' => $amounts[$i],
            ]);

            OrderItem::factory()->create([
                'orderId' => $order->orderId,
                'packageId' => $package->packageId,
                'packageTimeSlot' => 'Afternoon',
                'price' => $amounts[$i],
                'quantity' => 1,
            ]);

            // 6. Update total price
            $order->update(['totalPrice' => $amounts[$i]]);

            // 7. Create payment
            Payment::factory()->create([
                'orderId' => $order->orderId,
                'paid_at' => $start->copy()->addDay(),
            ]);
        }

        // 8. Assert sales shown with 5% fee applied
        $this->actingAs($user)->get('/cateringHomePage')
            ->assertSee('const chartData = [95000,190000,0,380000]', false);
    }

    /**
     * @test
     */
    public function tc5_sales_chart_shows_zero_when_no_payment()
    {
        $this->withoutExceptionHandling();

        // 1. Create user
        /**
         * @var User | Authenticatable $user
         */
        $user = User::factory()->create([
            'email' => 'vendor1@mail.com',
            'role' => 'Vendor',
        ]);

        // 2. Create vendor
        $vendor = Vendor::factory()->create(['userId' => $user->userId]);

        // 3. Create unpaid orders
        Order::factory()->count(3)->create([
            'vendorId' => $vendor->vendorId,
            'startDate' => now()->startOfWeek(),
            'endDate' => now()->endOfWeek(),
        ]);

        // 4. Assert chart shows Rp0 for all weeks
        $this->actingAs($user)
            ->get('/cateringHomePage')
            ->assertSee(['0', '0', '0', '0'], false);
    }

    /**
     * @test
     */
    public function tc6_restrict_access_for_non_vendor_and_guest()
    {
        // 1. Create a Customer user
        /**
         * @var User | Authenticatable $customer
         */
        $customer = User::factory()->create([
            'email' => 'customer@mail.com',
            'name' => 'Test Customer',
            'role' => 'Customer',
        ]);

        // 2. Try accessing as Guest (not logged in)
        $this->get('/cateringHomePage')
            ->assertRedirect('/login');

        // 3. Try accessing vendor dashboard as a Customer
        $this->actingAs($customer)
            ->get('/cateringHomePage')
            ->assertRedirect('/home');

    }

    /**
     * @test
     */
    public function tc7_redirect_vendor_without_catering_data()
    {
        $this->withoutExceptionHandling();
        // 1. Register new Vendor user
        /**
         * @var User | Authenticatable $user
         */
        $user = User::factory()->create([
            'email' => 'vendorNoData@mail.com',
            'name' => 'No Catering Yet',
            'password' => bcrypt('Test@1234'),
            'role' => 'Vendor',
        ]);

        // 2. Do not create vendor/catering data

        // 3. Login and access Catering Home Page
        $this->actingAs($user)
            ->get('/cateringHomePage')
            ->assertRedirect('/vendor-first-page');
    }

}
