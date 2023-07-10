<?php

namespace Tests\Feature\Jobs;

use Tests\TestCase;
use App\Models\Product;
use App\Jobs\ProductExportJob;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductExportJobTest extends TestCase
{
    use RefreshDatabase;

    public function testJobGenerateProductsExportFile(): void
    {
        Storage::fake(config()->get('filesystem.default'));
        (new ProductExportJob())->handle();
        Storage::disk(config()->get('filesystem.default'))->assertExists('exports/my-file-test.csv');
    }
}
