<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',

        // Gateway pembayaran
        'payment_gateway',

        // Data utama Midtrans
        'midtrans_order_id',
        'transaction_id',
        'snap_token',
        'redirect_url',

        // Nominal pembayaran
        'gross_amount',
        'currency',

        // Metode pembayaran
        'payment_type',
        'bank',
        'va_number',

        // Data tambahan Midtrans
        'permata_va_number',
        'bill_key',
        'biller_code',
        'pdf_url',

        // Status dari Midtrans
        'transaction_status',
        'fraud_status',
        'status_code',
        'status_message',

        // Status internal sistem
        'payment_status',

        // Waktu penting
        'paid_at',
        'expired_at',
        'cancelled_at',

        // Response asli Midtrans
        'raw_response',
    ];

    protected $casts = [
        'gross_amount' => 'integer',
        'paid_at' => 'datetime',
        'expired_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'raw_response' => 'array',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
