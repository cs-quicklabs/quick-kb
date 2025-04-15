<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class SignupTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_signup_page_can_be_rendered(): void
    {
        $response = $this->get('/signup');  // Adjust route as needed
        $response->assertStatus(200);
        $response->assertViewIs('firstrun.signup');  // Adjust view path as needed
    }


    public function test_user_can_signup_with_valid_data(): void
    {
        $userData = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->post('/signup', $userData);

        // Get the last created user
        $user = User::where('email', 'test@example.com')->first();
        
        // Assert redirect to recovery code page with encrypted user ID
        $response->assertRedirect(route('recovery-code', ['userId' => encrypt($user->id)]));
        
        // Assert user was created in database
        // $this->assertDatabaseHas('users', [
        //     'name' => 'Test User',
        //     'email' => 'test@example.com'
        // ]);
        
        // Assert user is not authenticated yet (since they need to login)
        $this->assertGuest();
    }
    
} 