<?php

namespace App\Models;

use App\Models\Order;
use App\Models\PackageItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'type',
        'short_description',
        'description',
        'price',
        'price_unit',
        'main_image',
        'images',
        'color',
        'badge',
        'is_popular',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'images' => 'array',
        'is_popular' => 'boolean',
        'is_active' => 'boolean',
        'price' => 'integer',
    ];

    public function items()
    {
        return $this->hasMany(PackageItem::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}