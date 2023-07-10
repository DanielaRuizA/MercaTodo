<?php

namespace Tests\Feature\Http\Controllers\AdminPanel;

use Tests\TestCase;
use App\Models\User;
use App\Jobs\ProductExportJob;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Queue;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductExportControllerTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    public function testAdminAccessExportProductsRoute(): void
    {
        $roleAdmin = Role::create(['name' => 'admin']);

        Permission::create(['name' => 'admin.products.index'])->assignRole($roleAdmin);

        $admin = User::factory()->create()->assignRole('admin');

        $this->actingAs($admin)
            ->get('products/exports')
            ->assertRedirect('products/exports');
    }

    public function testAdminCanExportProductsEnqueueJob(): void
    {
        $roleAdmin = Role::create(['name' => 'admin']);

        Permission::create(['name' => 'admin.products.index'])->assignRole($roleAdmin);

        $admin = User::factory()->create()->assignRole('admin');

        Queue::fake();
        $this->actingAs($admin)
            ->get(route('products.export'))
            ->assertRedirect('products/exports');

        Queue::assertPushed(ProductExportJob::class);
    }

    public function testUserCantAccessExportProductsRoute(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('products/exports')
            ->assertStatus(403);
    }

    public function testUserCantExportProductsEnqueueJob(): void
    {
        $user = User::factory()->create();

        Queue::fake();
        $this->actingAs($user)
            ->get(route('products.export'))
            ->assertStatus(403);

        Queue::assertNothingPushed(ProductExportJob::class);
    }
}
