<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\Product;
use App\Mail\ImportMail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

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



    public function __construct(private readonly string $pathFile, private readonly User $user)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            if (($file = fopen(Storage::path($this->pathFile), 'r')) !== false) {
                fgetcsv($file);

                while (($row = fgetcsv($file)) !== false) {
                    $this->processRow($row);
                }

                fclose($file);

                // Mail::to($this->user)
                //     ->send((new ImportMail('Import post successful'))->subject('Import posts successful'));
            }
        } catch (\Exception $exception) {
            // Mail::to($this->user)->send((new ImportMail('Failed import posts'))->subject('Failed import posts'));

            logger()->warning('error when import file', [
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
