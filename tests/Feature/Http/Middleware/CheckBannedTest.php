<?php

namespace Tests\Feature\Http\Middleware;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Auth\Events\Login;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;

use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CheckBannedTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use WithFaker;
    use RefreshDatabase;

    public function testInactiveUserRedirectsToBannedPage()
    {
        $user = User::factory()->create(['status' => 'Inactive']);

        $this->actingAs($user)
        ->get('login')
        ->assertRedirect('user/banned');

        $this->assertFalse(Auth::check());
        $this->assertTrue(session()->has('error'));
        $this->assertEquals('Your Account is suspended, please contact Admin.', session('error'));
    }

    public function testActiveUserPassesThroughBannedMiddleware()
    {
        $user = User::factory()->create(['status' => 'Active']);

        $this->actingAs($user)
        ->get('login')
        ->assertRedirect('http://localhost');

        $this->assertTrue(Auth::check());
    }
}
