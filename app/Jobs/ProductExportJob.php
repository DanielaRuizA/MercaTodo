<?php

namespace App\Jobs;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

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
            'name',
            'description',
            'status',
            'price',
            'quantity',
            'product_photo',
        ];
        
        //  $fileName = sprintf("exports/%s.csv", Str::uuid()->serialize());
        $fileName = 'exports/my-file-test.csv';
        $this->createFile($fileName);
        $file = $this->openFile($fileName);
        fputcsv($file, $headers);

        Product::chunk(10, function ($products) use ($file) {
            foreach ($products as $product) {
                fputcsv($file, [
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
        Storage::disk(config()->get('filesystem.default'))->put($fileName, "");
    }

    private function openFile(string $fileName)
    {
        return fopen(Storage::disk(config()->get('filesystem.default'))->path($fileName), "w");
    }
}
