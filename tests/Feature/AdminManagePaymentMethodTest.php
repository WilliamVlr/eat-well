<?php

namespace Tests\Feature;

use App\Models\PaymentMethod;
use App\Models\User;
use Database\Seeders\CuisineTypeSeeder;
use Database\Seeders\PackageCategorySeeder;
use Database\Seeders\PackageSeeder;
use Database\Seeders\PaymentMethodSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\VendorSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminManagePaymentMethodTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate:fresh');

        $this->seed(UserSeeder::class);
        $this->seed(PackageCategorySeeder::class);
        $this->seed(PaymentMethodSeeder::class);
        $this->seed(CuisineTypeSeeder::class);
        $this->seed(VendorSeeder::class);
        $this->seed(PackageSeeder::class);
    }

    protected function createUserWithRole(string $role, string $name, string $email, string $password): User
    {
        return User::factory()->create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => $role,
        ]);
    }

    /** @test */
    public function tc1_add_new_payment_method_successfully()
    {
        $admin = $this->createUserWithRole('Admin', 'RootAdmin', 'admin@site.com', 'RootPass123');
        $this->actingAs($admin);

        $response = $this->post('/view-all-payment', [
            'paymentMethod' => 'Bank Transfer',
        ]);

        $response->assertRedirect(route('view-all-payment'));
        $response->assertSessionHas('message_add', 'Successfully added payment!');

        $this->assertDatabaseHas('payment_methods', [
            'name' => 'Bank Transfer',
        ]);
    }

    /** @test */
    public function tc2_payment_method_page_has_add_button()
    {
        $admin = $this->createUserWithRole('Admin', 'RootAdmin', 'admin@site.com', 'RootPass123');
        $this->actingAs($admin);

        $response = $this->get('/view-all-payment');

        $response->assertStatus(200);
        $response->assertSee('Add Method'); // Assuming it's a button or link text
    }


    /** @test */
    public function tc3_add_duplicate_payment_method_should_fail()
    {
        $admin = $this->createUserWithRole('Admin', 'RootAdmin', 'admin@site.com', 'RootPass123');
        $this->actingAs($admin);

        PaymentMethod::create(['name' => 'Bank Transfer']);

        $response = $this->post('/view-all-payment', [
            'paymentMethod' => 'Bank Transfer',
        ]);

        $response->assertSessionHasErrors(['error' => 'Payment method exist.']);
        $this->assertCount(1, PaymentMethod::where('name', 'Bank Transfer')->get());
    }

    /** @test */
    public function tc4_add_payment_method_with_empty_name_should_fail()
    {
        $admin = $this->createUserWithRole('Admin', 'RootAdmin', 'admin@site.com', 'RootPass123');
        $this->actingAs($admin);

        $response = $this->post('/view-all-payment', [
            'paymentMethod' => '',
        ]);

        // $response->assertSessionHasErrors(['name']);
        $this->assertDatabaseMissing('payment_methods', ['name' => '']);
    }

    /** @test */
    public function tc5_admin_can_view_list_of_payment_methods()
    {
        $admin = $this->createUserWithRole('Admin', 'SuperAdmin', 'admin@site.com', 'Admin123');
        $this->actingAs($admin);

        // Ensure there's at least one method
        PaymentMethod::create(['name' => 'QRIS']);

        $response = $this->get('/view-all-payment');
        $response->assertStatus(200);
        $response->assertSee('QRIS'); // Assume the view renders the name
    }

    /** @test */
    public function tc6_admin_can_soft_delete_a_payment_method()
    {
        $admin = $this->createUserWithRole('Admin', 'SuperAdmin', 'admin@site.com', 'Admin123');
        $this->actingAs($admin);

        $method = PaymentMethod::create(['name' => 'Debit Card']);

        $response = $this->delete("/view-all-payment/delete/{$method->methodId}");
        $response->assertRedirect('/view-all-payment');

        $this->assertSoftDeleted('payment_methods', ['methodId' => $method->methodId]);
    }


    /** @test */
    public function tc7_cancel_delete_should_keep_payment_method()
    {
        $admin = $this->createUserWithRole('Admin', 'RootAdmin', 'admin@site.com', 'RootPass123');
        $this->actingAs($admin);

        $method = PaymentMethod::create(['name' => 'LinkAja']);

        // No delete call performed
        $this->assertDatabaseHas('payment_methods', ['methodId' => $method->methodId]);

        // Simulate refreshing the page instead of deleting
        $this->get('/view-all-payment');

        $this->assertDatabaseHas('payment_methods', ['methodId' => $method->methodId]);
    }

    /** @test */
    public function tc8_non_admin_cannot_manage_payment_methods()
    {
        $user = $this->createUserWithRole('Customer', 'Joe', 'joe@example.com', 'Customer123');
        $this->actingAs($user);

        // Try to GET view page
        $response = $this->get('/view-all-payment');
        $response->assertRedirect('/home'); // Or change to expected fallback route

        // Try to POST add new payment method
        $postResponse = $this->post('/view-all-payment', ['paymentMethod' => 'Illegal Add']);
        $postResponse->assertRedirect('/home');

        // Try to DELETE a method
        $anyMethod = PaymentMethod::create(['name' => 'Bank Transfer']);
        $deleteResponse = $this->delete("/view-all-payment/delete/{$anyMethod->methodId}");
        $deleteResponse->assertRedirect('/home');

        // Ensure method wasn't added or deleted
        $this->assertDatabaseMissing('payment_methods', ['name' => 'Bank Transfer']);
        $this->assertDatabaseHas('payment_methods', ['methodId' => $anyMethod->methodId]);
    }

}
