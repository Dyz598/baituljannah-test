<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

/**
 * @author  Aldi Arief <aldiarief598@gmail.com>
 */
class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function testSuccess(): void
    {
        User::factory()->create([
            'email'    => 'sample@example.com',
            'password' => Hash::make('password'),
        ]);

        $response = $this->postJson('/api/login', [
            'email'    => 'sample@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200);

        $this->assertNotNull($response->json('token'));
    }

    public function testFail(): void
    {
        $response = $this->postJson('/api/login', [
            'email'    => 'sample@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(401);
    }
}
