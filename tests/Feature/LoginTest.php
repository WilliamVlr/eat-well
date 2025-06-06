<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
// use Tests\TestCase;
use Tests\TestCase;
use App\Models\User;
// use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function tc1_login_with_valid_credentials()
    {
        $user = User::factory()->create([
            'password' => bcrypt('password123')
        ]);

        $response = $this->post('/login-register', [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function tc2_login_with_invalid_credentials()
    {
        $user = User::factory()->create();

        $response = $this->post('/login-register', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    /** @test */
    public function tc3_login_with_empty_fields()
    {
        $response = $this->post('/login-register', [
            'email' => '',
            'password' => '',
        ]);

        $response->assertSessionHasErrors(['email', 'password']);
        $this->assertGuest();
    }

    /** @test */
    public function tc4_password_field_is_hidden_on_login_page()
    {
        $response = $this->get('/login-register');
        $response->assertSee('<input type="password"', false);
    }

    /** @test */
    public function tc6_forgot_password_link_exists()
    {
        $response = $this->get('/login-register');
        $response->assertSee('Forgot Your Password?');
    }

    /** @test */
    public function tc7_remember_me_functionality()
    {
        $user = User::factory()->create([
            'password' => bcrypt('password123')
        ]);

        $response = $this->post('/login-register', [
            'email' => $user->email,
            'password' => 'password123',
            'remember' => 'on',
        ]);

        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($user);
        // Note: Laravel does not simulate "closing the browser" in tests
    }

    /** @test */
    // public function tc8_google_login_button_exists()
    // {
    //     $response = $this->get('/login-register');
    //     $response->assertSee('Login with Google');
    // }

    /** @test */
    public function tc9_register_link_exists()
    {
        $response = $this->get('/login-register');
        $response->assertSee("Register now!");
    }
}

