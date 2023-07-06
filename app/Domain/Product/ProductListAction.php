<?php

namespace App\Domain\Product;

use App\Models\Product;
use App\Contracts\ActionInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class ProductListAction implements ActionInterface
{
    public static function execute(array $data, int $id = 0): Model|bool|array|Collection|null
    {
        return Product::all();
    }
}
