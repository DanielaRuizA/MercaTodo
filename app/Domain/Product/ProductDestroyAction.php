<?php

namespace App\Domain\Product;

use App\Contracts\ActionInterface;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ProductDestroyAction implements ActionInterface
{
    public static function execute(array $data, int $id = 0): Model|bool|array|Collection|null
    {
        return Product::destroy($id);
    }
}
