<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'item_type',
        'source_id',
        'name',
        'unit',
        'quantity',
        'price',
        'total_price',
        'snapshot',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'price' => 'integer',
        'total_price' => 'integer',
        'snapshot' => 'array',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
