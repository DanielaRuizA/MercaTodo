<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_id',
        'url',
        'amount',
        'currency',
        'status',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'order_id' => 'integer',
        'url' => 'string',
        'amount' => 'integer',
        'currency' => 'string',
        'status' => 'string',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity');
    }
    
    public function completed(): void
    {
        $this->update([
            'status' => 'COMPLETED'
        ]);
    }

    public function canceled(): void
    {
        $this->update([
            'status' => 'CANCELED'
        ]);
    }
}
