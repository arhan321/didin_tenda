<?php

namespace App\Models;

use App\Models\Addon;
use App\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderAddon extends Model
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