<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CheckoutControllerTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    public function testUserCanAccessToCheckoutView(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('checkout')
            ->assertStatus(200);
    }

    public function testCanAccessToCheckoutLoggedUsers(): void
    {
        $this->get('checkout')
            ->assertRedirect('login');
    }

    public function testUserCantCheckoutWithAEmptyCart(): void
    {
        $user = User::factory()->create();

        $this
            ->actingAs($user)
            ->get('checkout')
            ->assertStatus(200)
            ->assertSee(0);
    }
}
