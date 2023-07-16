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

        Permission::create(['name' => 'admin.products.edit'])->assignRole($roleAdmin);

        $admin = User::factory()->create()->assignRole('admin');

        $response = $this->actingAs($admin);
        
        $response = $this->get(route('products.show.imports'));

        $response->assertStatus(200);

        $response->assertInertia(
            fn (InertiaAssert $page) =>
                    $page->component('AdminPanel/Products/Import')
        );
    }
}

// public function testImportingProductsWithQueueSuccessfully()
// {
    //     // Configurar el estado de prueba
    //     Storage::fake('public');
    //     Excel::fake();

    //     $file = UploadedFile::fake()->create('products.csv');

    //     $response = $this->post('products/import', [
    //         'file' => $file,
    //     ]);

// $response->assertRedirect('products/import');
// $response->assertSessionHas('success', 'Products successfully imported');

//         Excel::assertQueued(new ProductsImport, function ($import) use ($file) {
//             return $import->getFile()->getPathname() === $file->getPathname();
//         });
//     }
// }
// public function testImportingProductsWithQueueSuccessfully()
// {
    //     $roleAdmin = Role::create(['name' => 'admin']);
    //     Permission::create(['name' => 'admin.products.edit'])->assignRole($roleAdmin);
    //     $admin = User::factory()->create()->assignRole('admin');

    //     Storage::fake('public');
    //     Excel::fake();

    //     $file = UploadedFile::fake()->create('products.xlsx');

    //     $this->actingAs($admin)
    //         ->post('products/imports', [
    //             'file' => $file,
    //         ]);

    //     Excel::assertQueued(function (PendingDispatch $pendingDispatch) use ($file) {
    //         return $pendingDispatch->getJob()->getFile()->getPathname() === $file->getPathname()
    //             && $pendingDispatch->getJob() instanceof ProcessImport;
    //     });
// }

//     public function testImportingProductsWithQueueSuccessfully()
//     {
//     $roleAdmin = Role::create(['name' => 'admin']);

//     Permission::create(['name' => 'admin.products.edit'])->assignRole($roleAdmin);

//     $admin = User::factory()->create()->assignRole('admin');

//     Storage::fake('public');
//     Excel::fake();

//     $file = UploadedFile::fake()->create('products.xlsx');

//     $response = $this->actingAs($admin)
//     ->post('products/imports', [
//         'file' => $file,
//     ]);

//     Excel::assertQueued('products.xlsx', 'file');

//     Excel::assertQueued(function (ProductsImport $import) {
//         return true;
//     });
// }

    //     Excel::assertQueuedImport(function (ProductsImport $import) {
    //         return true;
    //     });
// $file = UploadedFile::fake()->create('products.xlsx');

// $response = $this->post('products/imports', [
        //     'file' => $file,
// ]);

// $response->assertSessionHas('success', 'Products successfully imported');

// Excel::assertQueuedImport(new ProductsImport, function ($import) use ($file) {
        //     return true;
// return $import->getFile()->getPathname() === $file->getPathname();
// });
// }


// public function testAdminCanImportProductsWithExcel(): void
// {
//     $roleAdmin = Role::create(['name' => 'admin']);

//     Permission::create(['name' => 'admin.products.edit'])->assignRole($roleAdmin);

//     $admin = User::factory()->create()->assignRole('admin');

//     $response = $this->actingAs($admin);
        
//     Storage::fake('local');

//     $file = UploadedFile::fake()->create('products.xlsx');

//     $response = $this->post('/admin/products/import', [
//         'file' => $file,
//     ]);

//     $response->assertRedirect();
//     $response->assertSessionHasNoErrors();

//     Storage::disk('local')->assertExists('imports/' . $file->hashName());

//     $this->assertEquals(10, count($importedData));

//     $expectedData = [
//                 ['name' => 'Product 1', 'price' => 10.99],
//                 ['name' => 'Product 2', 'price' => 19.99],
//     ];

//     foreach ($expectedData as $index => $expected) {
//         $this->assertDatabaseHas('products', $expected, 'id', $importedData[$index]->id);
//     }
// }
// }
