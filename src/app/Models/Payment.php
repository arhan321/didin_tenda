<?php

namespace App\Models;

use App\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'midtrans_order_id',
        'snap_token',
        'redirect_url',
        'transaction_id',
        'payment_type',
        'bank',
        'va_number',
        'status',
        'gross_amount',
        'paid_at',
        'expired_at',
        'raw_response',
    ];

    protected $casts = [
        'gross_amount' => 'integer',
        'paid_at' => 'datetime',
        'expired_at' => 'datetime',
        'raw_response' => 'array',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}