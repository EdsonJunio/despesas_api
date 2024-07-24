<?php

namespace Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;

    public function testRegistrationWithValidData()
    {
        $data = [
            'name' => 'Test User',
            'email' => 'testgge@gmail.com',
            'password' => 'password',
        ];

        $response = $this->json('POST', '/api/register', $data);

        $response->assertStatus(201);

        $response->assertJsonStructure([
            'user' => [
                'name',
                'email',
                'updated_at',
                'created_at',
                'id'
            ],
            'token'
        ]);

        $this->assertTrue(Hash::check($data['password'], User::first()->password));
    }

    public function testLoginWithValidCredentials()
    {
        $user = User::factory()->create([
            'email' => 'testgge@gmail.com',
            'password' => Hash::make('password'),
        ]);

        $data = [
            'email' => 'testgge@gmail.com',
            'password' => 'password',
        ];

        $response = $this->json('POST', '/api/login', $data);

        $response->assertStatus(201);

        $response->assertJsonStructure([
            'user' => [
                'name',
                'email',
                'updated_at',
                'created_at',
                'id',
            ],
            'token',
        ]);

        $this->assertNotNull($response['token']);
    }

    public function testRegistrationWithInvalidData()
    {
        $data = [
            'name' => 'Test User',
            'email' => 'not_an_email',
            'password' => 'pass',
        ];

        $response = $this->json('POST', '/api/register', $data);

        $response->assertStatus(422);
    }
}
