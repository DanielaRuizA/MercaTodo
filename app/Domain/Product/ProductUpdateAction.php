<?php

namespace App\Domain\Product;

use App\Models\Product;
use App\Contracts\ActionInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class ProductUpdateAction implements ActionInterface
{
    // public static function execute(array $data, int $id = 0): Model|bool|array|Collection|null
    // {
    //     $product = Product::query()->find($id);
        
    //     if (!$product) {
    //         return null;
    //     }
        
    //     $product->fill($data);
    //     $product->save();
        
    //     return $product;
    // }
    public static function execute(array $data, int $id = 0): Model|bool|array|Collection|null
    {
        return Product::query()->find($id)->update($data);
    }
}



// <?php

// namespace App\Domain\Product;

// use App\Models\Product;
// use App\Contracts\ActionInterface;
// use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Collection;

// class ProductSaveAction implements ActionInterface
// {
//     public static function execute(array $data, int $id = 0): Model|bool|array|Collection|null
//     {
//         return Product::query()->create($data);
//     }
// }
