<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'product_id',
        'status',
        'order_id',
        'price',
        'quantity'
    ];

    public function User(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function Product(): BelongsTo{
        return $this->belongsTo(Product::class);
    }
}
