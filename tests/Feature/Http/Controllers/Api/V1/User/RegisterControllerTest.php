<?php

namespace Tests\Feature\Http\Controllers\Api\V1\User;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testUserCanRegister(): void
    {
        $data = [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => $this->faker->password(),
        ];

        $response = $this->postJson(route('api.register'), $data);
        $response->assertJsonMissingValidationErrors();
        $response->assertStatus(201);

        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseHas('users', [
            'name' => $data['name'],
            'email' => $data['email'],
        ]);
    }

    public function testCanValidatedWhenRegisterAnUser(): void
    {
        $user = User::factory()->create();

        $data = [
            'name' => '',
            'email' => $user->email,
            'password' => '',
        ];

        $response = $this->postJson(route('api.register'), $data);
        $response->assertJsonValidationErrors(['name', 'email', 'password']);
        $response->assertStatus(422);
    }
}
