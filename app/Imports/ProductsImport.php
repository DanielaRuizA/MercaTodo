<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;

class ProductsImport implements ToModel, WithHeadingRow, WithUpserts, WithChunkReading, ShouldQueue
{
    /**
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Product([
            'id' => $row['id'],
            'name' => $row['name'],
            'description' => $row['description'],
            'status' => $row['status'],
            'price' => $row['price'],
            'quantity' => $row['quantity'],
            'product_photo' => $row['product_photo'],
        ]);
    }

    public function uniqueBy(): string|array
    {
        return 'id';
    }

    public function chunkSize(): int
    {
        return 500;
    }
}
