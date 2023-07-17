<?php

namespace Tests\Feature\Http\Middleware;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class CheckBannedTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use WithFaker;

    use RefreshDatabase;

    public function testInactiveUserRedirectsToBannedPage(): void
    {
        $user = User::factory()->create(['status' => 'Inactive']);

        $this->actingAs($user)
            ->get('login')
            ->assertRedirect('user/banned');

        $this->assertTrue(session()->has('error'));
        $this->assertEquals('Your Account is suspended, please contact Admin.', session('error'));
    }

    public function testActiveUserPassesThroughBannedMiddleware(): void
    {
        $user = User::factory()->create(['status' => 'Active']);

        $this->actingAs($user)
            ->get('login')
            ->assertRedirect('http://localhost');

        $this->assertTrue(Auth::check());
    }
}
