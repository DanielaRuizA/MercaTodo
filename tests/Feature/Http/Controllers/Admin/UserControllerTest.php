<?php

namespace Tests\Feature\Http\Controllers\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_index_empty()
    {
        $user = User::factory()->create()->assignRole('admin');
        $this->actingAs($user);
        
        $this
            ->get('users')
            ->assertStatus(200)
            ->assertSee('No hay Usuarios registrados');
    }
}
