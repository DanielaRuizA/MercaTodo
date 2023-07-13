<?php

namespace Tests\Feature\Http\Controllers\Api\V1\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanLogin(): void
    {
        $user = User::factory()->create();

        $response = $this->post(route('api.login'), [
            'email' => $user->email,
            'password' => 'password',
        ], ['accept' => 'application/json']);

        $response->assertStatus(200);
        $response->assertJsonMissingValidationErrors(['email', 'password']);
        $response->assertJsonStructure([
            'access_token',
        ]);
    }

    public function testWrongPasswordForLogin(): void
    {
        $user = User::factory()->create();

        $response = $this->post(route('api.login'), [
            'email' => $user->email,
            'password' => 'passwordwrong',
        ], ['accept' => 'application/json']);

        $response->assertStatus(422);
        $response->assertJsonFragment([
            'message' => trans('auth.failed'),
        ]);
    }

    public function testValidatedLogin(): void
    {
        $response = $this->post(route('api.login'), [
            'email' => 'email@',
            'password' => '',
        ], ['accept' => 'application/json']);

        $response->assertStatus(422);
    }
}
