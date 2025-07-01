<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use Laravel\Socialite\Two\User as SocialiteUser;
use Laravel\Socialite\Facades\Socialite;

class registerTest extends TestCase
{
    /** @test */
    public function tc_reg_01_registration_page_displays_all_ui_elements()
    {
        $response = $this->get('/register');

        // Title
        $response->assertSee('Join EatWell');

        // Form fields and labels
        $response->assertSee('Name');
        $response->assertSee('Email');
        $response->assertSee('Password');
        $response->assertSee('Password Confirmation');

        // Register button
        $response->assertSee('Register');

        // Links/buttons for login and vendor registration
        $response->assertSee('Already has an account?');
        $response->assertSee('Login now!');
        $response->assertSee('Join Eatwell as a');
        $response->assertSee('vendor!');
    }

    /** @test */
    public function tc_reg_02_user_can_register_and_is_saved_in_database()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        // Assert user is redirected (adjust as needed)
        $response->assertRedirect('/customer-first-page'); // or wherever your app redirects after registration

        // Assert user is in the database
        $this->assertDatabaseHas('users', [
            'email' => 'testuser@example.com',
            'name' => 'Test User',
        ]);
    }

    
    /** @test */
    public function tc_reg_03_register_with_all_fields_empty_shows_validation_errors()
    {
        $response = $this->post('/register', [
            'name' => '',
            'email' => '',
            'password' => '',
            'password_confirmation' => '',
        ]);

        // The page should return with validation errors and not redirect
        $response->assertSessionHasErrors(['name', 'email', 'password']);

        // Optionally, check that the user is not created in the database
        $this->assertDatabaseMissing('users', [
            'email' => '',
        ]);
    }

    /** @test */
    public function tc_reg_04_register_with_empty_name_shows_validation_error()
    {
        $response = $this->post('/register', [
            'name' => '',
            'email' => 'validuser@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            // 'g-recaptcha-response' => 'test', // Uncomment if you have reCAPTCHA validation and can mock it
        ]);

        $response->assertSessionHasErrors(['name']);
    }

    /** @test */
    public function tc_reg_05_register_with_empty_email_shows_validation_error()
    {
        $response = $this->post('/register', [
            'name' => 'Valid User',
            'email' => '',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            // 'g-recaptcha-response' => 'test', // Uncomment if you have reCAPTCHA validation and can mock it
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    /** @test */
    public function tc_reg_06_register_with_empty_password_shows_validation_error()
    {
        $response = $this->post('/register', [
            'name' => 'Valid User',
            'email' => 'testuser@example.com',
            'password' => '',
            'password_confirmation' => '',
            
        ]);

        $response->assertSessionHasErrors(['password']);
    }

    /** @test */
    public function tc_reg_07_register_with_short_password_shows_validation_error()
    {
        $response = $this->post('/register', [
            'name' => 'Valid User',
            'email' => 'validuser@example.com',
            'password' => '12345', // less than 6 characters
            'password_confirmation' => '12345',
        ]);

        $response->assertSessionHasErrors(['password']);
    }

    /** @test */
    public function tc_reg_08_register_with_google_button_is_present()
    {
        $response = $this->get('/register');

        // Check for the "Register with Google" button or link
        $response->assertSee('Register with Google');
    }

    // /** @test */
    //  public function testHandleGoogleCallbackWithExistingUserLogsIn()
    // {
    //     $googleUser = (new SocialiteUser())->map([
    //         'id' => '102685465244758889282',
    //         'email' => 'dvbw23@gmail.com',
    //         'name' => 'Dv Bw',
    //         'nickname' => null,
    //         'avatar' => null,
    //     ]);
    //     $googleUser->setToken('ya29.testtoken');
    //     $googleUser->setRefreshToken(null);

    //     // Mock the Socialite driver and stateless() call
    //     $providerMock = \Mockery::mock(\Laravel\Socialite\Contracts\Provider::class);
    //     $providerMock->shouldReceive('stateless')
    //         ->andReturnSelf();
    //     $providerMock->shouldReceive('user')
    //         ->andReturn($googleUser);

    //     // Replace Socialite::driver() with the mocked provider
    //     Socialite::shouldReceive('driver')
    //         ->with('google')
    //         ->andReturn($providerMock);

    //     $response = $this->get('/auth/google/callback');

    //     $response->assertRedirect('/customer-first-page');

    //     $this->assertAuthenticated();
    // }

}