<?php

namespace Tests\Feature\Jobs;

use Tests\TestCase;
use App\Models\User;
use App\Jobs\ProductImportJob;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductImportJobTest extends TestCase
{
//     use RefreshDatabase;

//     public function testJobProductsImportFromFile()
//     {
//         Storage::fake();
//         Storage::put('import-file.csv', file_get_contents(__DIR__.'/../../imports/import-file.csv'));
//         storage\app\imports\3fczpn8GP2eMUsLQguYzkiGAp5YgGGzx7N4EGDOV.txt

//         $user = User::factory()->create();

//         (new ProductImportJob('import-file.csv', $user))->handle();

//         $this->assertDatabaseCount('posts', 10);
//         $this->assertDatabaseHas('posts', [
//             'id' => 3,
//             'name' => 'name from csv file.',
//             'description' => 'Body from csv file.',
//             'status' => 'Active',
//             'price' => 5000,
//             'quantity' => 5,
//             'product_photo' => 'images/icecream.jpg',
//         ]);
//     }
}
