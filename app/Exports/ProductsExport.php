<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsExport implements FromQuery, WithHeadings
{
    use Exportable;

    public function headings(): array
    {
        return [
            'id',
            'name',
            'description',
            'status',
            'price',
            'quantity',
            'product_photo',
        ];
    }


    public function query()
    {
        return Product::query()->select([
            'id',
            'name',
            'description',
            'status',
            'price',
            'quantity',
            'product_photo',
        ]);
    }
}
