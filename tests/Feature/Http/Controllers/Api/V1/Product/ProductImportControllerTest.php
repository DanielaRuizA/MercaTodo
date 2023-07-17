<?php

namespace Tests\Feature\Http\Controllers\Api\V1\Product;

use App\Jobs\ProductImportJob;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ProductImportControllerTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    public function testCanImportProductsViaFile(): void
    {
        $user = User::factory()->create();

        Storage::fake();

        Bus::fake();

        Sanctum::actingAs($user);

        Queue::fake();

        $file = UploadedFile::fake()->create('import-file.csv');

        $response = $this->post(route('api.products.import'), [
            'file' => $file,
        ]);

        Bus::assertDispatched(ProductImportJob::class, function (ProductImportJob $job) {
            $job->handle();

            return true;
        });

        $response
            ->assertOk()
            ->assertJsonStructure(['message']);
    }

    public function testFileIsRequired(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->json('POST', 'api/v1/products/import', []);

        $response->assertStatus(400)
            ->assertJson(['message' => 'A file is required']);

    }
}
