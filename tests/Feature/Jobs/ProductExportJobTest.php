<?php

namespace Tests\Feature\Jobs;

use App\Jobs\ProductExportJob;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductExportJobTest extends TestCase
{
    use RefreshDatabase;

    public function testJobGenerateProductsExportFile(): void
    {
        Storage::fake(config()->get('filesystem.default'));
        (new ProductExportJob())->handle();
        Storage::disk(config()->get('filesystem.default'))->assertExists('exports/products.csv');
    }
}
