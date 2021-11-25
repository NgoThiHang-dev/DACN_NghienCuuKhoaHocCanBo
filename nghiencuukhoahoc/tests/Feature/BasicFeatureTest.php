<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Testing\TestResponse;

use function PHPUnit\Framework\assertTrue;

class BasicFeatureTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('Login');
    }
    
    // public function testCanLogin()
    // {
    //     $this->assertGuest();
    //     $user = User::factory()->create([
    //         'password'=>bcrypt('P@ssw0rd'),
    //     ]);

    //     $this->post('/login', [
    //         'email' => $user->email,
    //         'password' => '$2y$10$x12IjhBvTyaBOYfRY9p/AeaKghK0RxsU.Ms6F3pSBk6sCM.rUD0WO',
    //     ])
    //         ->assertStatus(302)
    //         ->assertRedirect('/admin');
    //     $this->assertAuthenticatedAs($user);
    // }
}
