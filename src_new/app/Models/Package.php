<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Package extends Model
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
