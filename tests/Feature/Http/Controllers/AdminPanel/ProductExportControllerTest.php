<?php

namespace Tests\Feature\Http\Controllers\AdminPanel;

use App\Jobs\ProductExportJob;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Queue;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

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
            ->assertRedirect('products');
    }

    public function testAdminCanExportProductsEnqueueJob(): void
    {
        $roleAdmin = Role::create(['name' => 'admin']);

        Permission::create(['name' => 'admin.products.index'])->assignRole($roleAdmin);

        $admin = User::factory()->create()->assignRole('admin');

        Queue::fake();
        $this->actingAs($admin)
            ->get(route('products.export'))
            ->assertRedirect('products');

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
