<?php

namespace Tests\Feature\Http\Controllers\Api\V1\Product;

use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use App\Jobs\ProductImportJob;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductImportControllerTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    public function testCanImportProductsViaFile(): void
    {
        $user = User::factory()->create();

        // Storage::fake(config()->get('filesystem.default'));

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
}
