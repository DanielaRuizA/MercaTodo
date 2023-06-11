<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property string $id
 * @property string $email
 * @property string $tokens
 * @property string $product_id
 * @property mixed $status
 * @property string $product_photo
 * @method static Product find(...$parameters)
 * @method static Product create(...$parameters)
 * @method static Product latest(...$parameters)
 * @method static Product where(...$parameters)
 */


class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'status',
        'price',
        'quantity',
        'product_photo',
    ];

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class);
    }
}
