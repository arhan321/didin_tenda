<?php

namespace App\Models;

use App\Models\User;
use App\Models\Review;
use App\Models\Package;
use App\Models\Payment;
use App\Models\OrderItem;
use App\Models\OrderAddon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'user_id',
        'package_id',
        'order_type',
        'customer_name',
        'customer_phone',
        'customer_email',
        'event_date',
        'event_location_name',
        'event_address',
        'distance_km',
        'shipping_fee',
        'subtotal_package',
        'subtotal_custom',
        'subtotal_addons',
        'total_price',
        'status',
        'payment_status',
        'payment_deadline',
        'paid_at',
        'confirmed_at',
        'processed_at',
        'completed_at',
        'cancelled_at',
        'cancelled_reason',
        'notes',
    ];

    protected $casts = [
        'event_date' => 'date',
        'distance_km' => 'decimal:2',
        'shipping_fee' => 'integer',
        'subtotal_package' => 'integer',
        'subtotal_custom' => 'integer',
        'subtotal_addons' => 'integer',
        'total_price' => 'integer',
        'payment_deadline' => 'datetime',
        'paid_at' => 'datetime',
        'confirmed_at' => 'datetime',
        'processed_at' => 'datetime',
        'completed_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function addons()
    {
        return $this->hasMany(OrderAddon::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }
}