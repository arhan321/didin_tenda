<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class OrderAddon extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'addon_id',
        'name',
        'detail',
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

    public function addon()
    {
        return $this->belongsTo(Addon::class);
    }
}
