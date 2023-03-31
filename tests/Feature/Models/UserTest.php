<?php

namespace Tests\Feature\Models;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testCreateAdmin(): void
    {
        $user = User::factory()->create();
        $user->assignRole('admin');

        $this->actingAs($user)
            ->post('Admin/Users', [
                'name' => $this->faker->name(),
                'email' => $this->faker->email(),
                'password' => bcrypt($this->faker->password()),
            ]);
    }
}
