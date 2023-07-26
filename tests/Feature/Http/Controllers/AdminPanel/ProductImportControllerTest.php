<?php

namespace Tests\Feature\Http\Controllers\AdminPanel;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Inertia\Testing\AssertableInertia as InertiaAssert;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ProductImportControllerTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    public function testAdminCanAccessTheImportView(): void
    {
        $roleAdmin = Role::create(['name' => 'admin']);

        Permission::create(['name' => 'admin.products.import'])->assignRole($roleAdmin);

        $admin = User::factory()->create()->assignRole('admin');

        $response = $this->actingAs($admin);

        $response = $this->get(route('products.show.imports'));

        $response->assertStatus(200);

        $response->assertInertia(
            fn (InertiaAssert $page) => $page->component('AdminPanel/Products/Import')
        );
    }

public function testImportingXlsxProductsSuccessfully(): void
{
    $roleAdmin = Role::create(['name' => 'admin']);

    Permission::create(['name' => 'admin.products.import'])->assignRole($roleAdmin);

    $admin = User::factory()->create()->assignRole('admin');

    Storage::fake('public');

    Excel::fake();

    $response = $this->actingAs($admin);

    $file = UploadedFile::fake()->create('products.xlsx');

    $response = $this->post('products/imports', [
        'file' => $file,
    ]);

    $response->assertRedirect()->assertSessionHas('success', 'Products Was Successfully Imported');

    $response->assertSessionMissing('import_errors');
}

public function testImportingProductsFileDeniedFormats(): void
{
    $roleAdmin = Role::create(['name' => 'admin']);

    Permission::create(['name' => 'admin.products.import'])->assignRole($roleAdmin);

    $admin = User::factory()->create()->assignRole('admin');

    Storage::fake('public');

    Excel::fake();

    $response = $this->actingAs($admin);

    $file = UploadedFile::fake()->create('products.pdf');

    $response = $this->post('products/imports', [
        'file' => $file,
    ]);

    $response->assertSessionHasErrors();
}

public function testImportingProductsFileUploadFailure(): void
{
    $roleAdmin = Role::create(['name' => 'admin']);

    Permission::create(['name' => 'admin.products.import'])->assignRole($roleAdmin);

    $admin = User::factory()->create()->assignRole('admin');

    Storage::fake('public');

    Excel::fake();

    $response = $this->actingAs($admin);

    $file = UploadedFile::fake()->create('products.pdf');

    $response = $this->post('products/imports', [
        'file' => $file,
    ]);

    $response->assertRedirect();

    $importErrors = session('import_errors');

    $response->assertSessionHasErrors($importErrors);

    $this->assertFalse(Storage::disk('local')->exists($file->hashName()));
}
}
