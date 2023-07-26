<?php

namespace App\Jobs;

use App\Models\Product;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class ProductImportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private const HEADERS = [
        'id' => 0,
        'name' => 1,
        'description' => 2,
        'status' => 3,
        'price' => 4,
        'quantity' => 5,
        'product_photo' => 6,
    ];

    public function __construct(private string $pathFile, private User $user)
    {
        //
    }

    public function handle(): void
    {
        try {
            if (!File::exists($this->pathFile)) {
                throw new \Exception('File not found.');
            }

            $file = fopen($this->pathFile, 'r');

            if (!$file) {
                throw new \Exception('Error opening file.');
            }

            fgetcsv($file);

            while (($row = fgetcsv($file)) !== false) {
                $this->processRow($row);
            }

            fclose($file);
        } catch (\Exception $exception) {
            Log::warning('Error when importing file', [
                'message' => $exception->getMessage(),
                'trace' => $exception->getTrace(),
            ]);
        }
    }

    private function processRow(array $row): void
    {
        Product::query()->updateOrCreate([
            'id' => $row[self::HEADERS['id']],
        ], [
            'id' => $row[self::HEADERS['id']],
            'name' => $row[self::HEADERS['name']],
            'description' => $row[self::HEADERS['description']],
            'status' => $row[self::HEADERS['status']],
            'price' => $row[self::HEADERS['price']],
            'quantity' => $row[self::HEADERS['quantity']],
            'product_photo' => $row[self::HEADERS['product_photo']],
        ]);
    }
}


// namespace App\Jobs;

// use App\Models\Product;
// use App\Models\User;
// use Illuminate\Bus\Queueable;
// use Illuminate\Contracts\Queue\ShouldQueue;
// use Illuminate\Foundation\Bus\Dispatchable;
// use Illuminate\Queue\InteractsWithQueue;
// use Illuminate\Queue\SerializesModels;
// use Illuminate\Support\Facades\Storage;

// class ProductImportJob implements ShouldQueue
// {
//     use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

//     private const HEADERS = [
//         'id' => 0,
//         'name' => 1,
//         'description' => 2,
//         'status' => 3,
//         'price' => 4,
//         'quantity' => 5,
//         'product_photo' => 6,
//     ];

//     public function __construct(private readonly string $pathFile, private readonly User $user)
//     {
//         //
//     }

//     /**
//      * Execute the job.
//      */
//     public function handle(): void
//     {
//         try {
//             if (($file = fopen(Storage::path($this->pathFile), 'r')) !== false) {
//                 fgetcsv($file);

//                 while (($row = fgetcsv($file)) !== false) {
//                     $this->processRow($row);
//                 }

//                 fclose($file);
//             }
//         } catch (\Exception $exception) {
//             logger()->warning('error when import file', [
//                 'message' => $exception->getMessage(),
//                 'trace' => $exception->getTrace(),
//             ]);
//         }
//     }

//     private function processRow(array $row): void
//     {
//         Product::query()->updateOrCreate([
//             'id' => $row[self::HEADERS['id']],
//         ], [
//             'id' => $row[self::HEADERS['id']],
//             'name' => $row[self::HEADERS['name']],
//             'description' => $row[self::HEADERS['description']],
//             'status' => $row[self::HEADERS['status']],
//             'price' => $row[self::HEADERS['price']],
//             'quantity' => $row[self::HEADERS['quantity']],
//             'product_photo' => $row[self::HEADERS['product_photo']],
//         ]);
//     }
// }
