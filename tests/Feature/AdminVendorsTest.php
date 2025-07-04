<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Vendor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminVendorsTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;
    /** @test */
    protected function loginAsAdmin()
    {
        /**
         * @var User|\Illuminate\Contracts\Auth\Authenticatable $admin
         */
        $admin = User::factory()->create([
            'role' => 'Admin'
        ]);
        $this->actingAs($admin);
    }
    /** @test */
    protected function loginAsCustomer()
    {
        /**
         * @var User|\Illuminate\Contracts\Auth\Authenticatable $user
         */
        $user = User::factory()->create(
            ['role' => 'Customer']
        );
        $this->actingAs($user);
    }
    /** @test */
    public function tc1_check_access_for_admin(): void
    {
        $this->loginAsAdmin();

        $response = $this->get('/view-all-vendors');

        $response->assertStatus(200);
        $response->assertSee('All Vendors');
    }
    /** @test */
    public function tc2_check_no_vendor_exist()
    {
        $this->loginAsAdmin();

        $response = $this->get('/view-all-vendors');

        $response->assertStatus(200);
        $response->assertSee('No vendors available');
    }

    /** @test */
    public function tc4_check_correct_vendor_data()
    {
        $this->loginAsAdmin();

        $vendor = Vendor::factory()->create([
            'name' => 'Test Vendor A'
        ]);

        $response = $this->get('/view-all-vendors');

        $response->assertStatus(200);
        $response->assertSee('Test Vendor A');
    }

    /** @test */
    public function tc5_handle_special_character_vendor_name_rendered()
    {
        $this->loginAsAdmin();

        $vendor = Vendor::factory()->create([
            'name' => '@Mega&Co.™ "<Test>VeryLongNameThatKeepsGoingAndGoing...rawrrrrrrrrrrrrrrrrrrrrrrrrr'
        ]);

        $response = $this->get('/view-all-vendors');

        $response->assertStatus(200);
        $response->assertSee(e($vendor->name));
    }

    /** @test */
    public function tc6_non_admin_cannot_access()
    {
        $this->loginAsCustomer();
        
        $response = $this->get('/view-all-vendors');
        $response->assertRedirect('/home');
    }
}
