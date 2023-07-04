<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel, WithHeadingRow, WithUpserts
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Product([
            'id'                => $row['id'],
            'name'              => $row['name'],
            'description'       => $row['description'],
            'price'             => $row['price'],
            'quantity'          => $row['quantity'],
            'product_photo'     => $row['product_photo'],
        ]);
    }
    public function uniqueBy()
    {
        return 'id';
    }
}


    //     // Verificar si el registro ya existe en la base de datos
    //     $existingProduct = Product::where('id', $row['id'])->first();

    //     // Solo se creará un nuevo registro si no existe en la base de datos
    //     if (!$existingProduct) {
    //         return new Product([
    //             'id'                => $row['id'],
    //             'name'              => $row['name'],
    //             'description'       => $row['description'],
    //             'price'             => $row['price'],
    //             'quantity'          => $row['quantity'],
    //             'product_photo'     => $row['product_photo'],
    //         ]);
    //     }

    //     return null;
// }
// }



// }


// class ProductsImport implements ToModel, WithHeadingRow
// {
//     /**
//      * @param array $row
//      *
//      * @return \Illuminate\Database\Eloquent\Model|null
//      */
//     public function model(array $row)
//     {
//         return new Product([
//             'id'                => $row['id'],
//             'name'              => $row['name'],
//             'description'       => $row['description' ],
//             'price'             => $row['price'],
//             'quantity'          => $row['quantity'],
//             'product_photo'     => $row['product_photo' ],
//         ]);
//     }
// }


// return new Product([
        //     // 'id'            => $row[0],
        //     'name'          => $row[0],
        //     'description'   => $row[1],
        //     'status'        => $row[2],
        //     'price'         => $row[3],
        //     'quantity'      => $row[4],
        //     'photo'         => $row[5],
// ]);

// return new Product([
        //     // 'id'             => $row[0],
        //     'name'              => $row[0],
        //     'description'       => $row[1],
        //     // 'status'         => $row[3],
        //     'price'             => $row[2],
        //     'quantity'          => $row[3],
        //     'product_photo'     => $row[4],
// ]);

// return new Product([
        //     'id'            => $row['id'],
        //     'name'          => $row['name'],
        //     'description'   => $row['description'],
        //     'status'        => $row['status'],
        //     'price'         => $row['price'],
        //     'quantity'      => $row['quantity'],
        //     'photo'         => $row['photo'],
// ]);
// }
// }
