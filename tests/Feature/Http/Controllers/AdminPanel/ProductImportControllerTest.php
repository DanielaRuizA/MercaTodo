<?php

namespace Tests\Feature\Http\Controllers\AdminPanel;

use Tests\TestCase;
use App\Models\User;
use App\Imports\ProductsImport;
use Illuminate\Http\UploadedFile;
use Spatie\Permission\Models\Role;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;
use Maatwebsite\Excel\Jobs\PendingDispatch;
use Maatwebsite\Excel\Jobs\ProcessImport;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as InertiaAssert;

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
            fn (InertiaAssert $page) =>
                    $page->component('AdminPanel/Products/Import')
        );
    }

public function testImportingCVSProductSuccessfully()
{
    $roleAdmin = Role::create(['name' => 'admin']);

    Permission::create(['name' => 'admin.products.import'])->assignRole($roleAdmin);

    $admin = User::factory()->create()->assignRole('admin');

    $response = $this->actingAs($admin);
        
    Storage::fake('public');

    Excel::fake();

    $file = UploadedFile::fake()->create('products.csv');

    $response = $this->post('products/imports', [
        'file' => $file,
    ]);

    $response->assertRedirect()->assertSessionHas('success', 'Products successfully imported');

    $response->assertSessionMissing('import_errors');
}

public function testImportingXlsxProductsSuccessfully()
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

    $response->assertRedirect()->assertSessionHas('success', 'Products successfully imported');

    $response->assertSessionMissing('import_errors');
}

public function testImportingProductsFileDeniedFormats()
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

public function testImportingProductsFileUploadFailure()
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
