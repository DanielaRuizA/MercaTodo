<?php

namespace App\Jobs;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ProductExportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $headers = [
            'id',
            'name',
            'description',
            'status',
            'price',
            'quantity',
            'product_photo',
        ];

        $fileName = 'exports/products.csv';
        $this->createFile($fileName);
        $file = $this->openFile($fileName);
        fputcsv($file, $headers);

        Product::chunk(1000, function ($products) use ($file) {
            foreach ($products as $product) {
                fputcsv($file, [
                    'id' => $product->id,
                    'name' => $product->name,
                    'description' => $product->description,
                    'status' => $product->status,
                    'price' => $product->price,
                    'quantity' => $product->quantity,
                    'photo' => $product->product_photo,
                ]);
            }
        });

        fclose($file);
    }

    private function createFile(string $fileName): void
    {
        Storage::disk(config()->get('filesystem.default'))->put($fileName, '');
    }

    private function openFile(string $fileName)
    {
        return fopen(Storage::disk(config()->get('filesystem.default'))->path($fileName), 'w');
    }
}
