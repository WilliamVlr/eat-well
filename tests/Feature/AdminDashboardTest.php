<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    /**
     * Seed all required data before each test.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate:fresh');
        $this->seed();
    }

    /**
     * Authenticate as an Admin user.
     */
    protected function authenticateAsAdmin()
    {
        $admin = User::where('role', 'admin')->first();
        $this->actingAs($admin);
    }

    /**
     * TC 1 - Preview on Profit is correctly displayed
     * @test
     */
    public function tc1_preview_on_profit_is_correctly_displayed()
    {
        $this->authenticateAsAdmin();

        $totalSalesThisMonth = DB::table('orders')
            ->join('payments', 'orders.orderId', '=', 'payments.orderId')
            ->whereNotNull('payments.paid_at')
            ->whereMonth('payments.paid_at', now()->month)
            ->sum('orders.totalPrice');

        $expectedProfit = round($totalSalesThisMonth * 0.05, 2);
        dump($expectedProfit);

        $response = $this->get('/admin-dashboard');
        $response->assertStatus(200);
        $response->assertSee((string) number_format($expectedProfit, 0, ',', '.'));
    }

    /**
     * TC 2 - Preview on Total Sales is correctly displayed
     * @test
     */
    public function tc2_preview_on_total_sales_is_correctly_displayed()
    {
        $this->authenticateAsAdmin();

        $totalSales = DB::table('orders')
            ->join('payments', 'orders.orderId', '=', 'payments.orderId')
            ->whereNotNull('payments.paid_at')
            ->sum('orders.totalPrice');

        $response = $this->get('/admin-dashboard');
        $response->assertStatus(200);
        $response->assertSee((string) number_format($totalSales, 0, ',', '.'));
    }

    /**
     * TC 3 - Preview on percentage of profit
     * @test
     */
    public function tc3_preview_on_percentage_of_profit()
    {
        $this->authenticateAsAdmin();

        $currentProfit = DB::table('orders')
            ->join('payments', 'orders.orderId', '=', 'payments.orderId')
            ->whereNotNull('payments.paid_at')
            ->whereMonth('payments.paid_at', now()->month)
            ->sum('orders.totalPrice');

        $currentProfit *= 0.05;

        $lastMonthProfit = DB::table('orders')
            ->join('payments', 'orders.orderId', '=', 'payments.orderId')
            ->whereNotNull('payments.paid_at')
            ->whereMonth('payments.paid_at', now()->subMonth()->month)
            ->sum('orders.totalPrice');

        $lastMonthProfit *= 0.05;

        $expectedChange = $lastMonthProfit == 0
            ? 100
            : round((($currentProfit - $lastMonthProfit) / $lastMonthProfit) * 100, 2);

        $response = $this->get('/admin-dashboard');
        $response->assertStatus(200);
        $response->assertSee($expectedChange >= 0 ? 'Increased' : 'Decreased' );
        $response->assertSee((string) number_format(abs($expectedChange), 2));
    }

    /**
     * TC 4 - Preview on percentage of total sales
     * @test
     */
    public function tc4_preview_on_percentage_of_total_sales()
    {
        $this->authenticateAsAdmin();

        $currentSales = DB::table('orders')
            ->join('payments', 'orders.orderId', '=', 'payments.orderId')
            ->whereNotNull('payments.paid_at')
            ->whereMonth('payments.paid_at', now()->month)
            ->sum('orders.totalPrice');

        $lastMonthSales = DB::table('orders')
            ->join('payments', 'orders.orderId', '=', 'payments.orderId')
            ->whereNotNull('payments.paid_at')
            ->whereMonth('payments.paid_at', now()->subMonth()->month)
            ->sum('orders.totalPrice');


        $expectedChange = $lastMonthSales == 0
            ? 100
            : round((($currentSales - $lastMonthSales) / $lastMonthSales) * 100, 2);

        $response = $this->get('/admin-dashboard');
        $response->assertStatus(200);
        $response->assertSee($expectedChange >= 0 ? 'Increased' : 'Decreased' );
        $response->assertSee((string) number_format(abs($expectedChange), 2));
    }
}
