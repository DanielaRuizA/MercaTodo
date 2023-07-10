<?php

namespace Tests\Feature\Http\Controllers\AdminPanel;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as InertiaAssert;

class ProductImportControllerTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;


    // public function testAdminCanAccessTheImportView(): void
    // {
    //     $roleAdmin = Role::create(['name' => 'admin']);

    //     Permission::create(['name' => 'admin.products.edit'])->assignRole($roleAdmin);

    //     $admin = User::factory()->create()->assignRole('admin');

    //     $response = $this->actingAs($admin);
        
    //     $response = $this->get(route('products.show.imports'));

    //     $response->assertStatus(200);

    //     $response->assertInertia(
    //         fn (InertiaAssert $page) =>
    //                 $page->component('AdminPanel/Products/Import')
    //     );
    // }
}

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

// $this->assertEquals(10, count($importedData));

// $expectedData = [
        //     ['name' => 'Product 1', 'price' => 10.99],
        //     ['name' => 'Product 2', 'price' => 19.99],
// ];

// foreach ($expectedData as $index => $expected) {
        //     $this->assertDatabaseHas('products', $expected, 'id', $importedData[$index]->id);
//     }
// }
