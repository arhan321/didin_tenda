<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Addon extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'detail',
        'price',
        'unit',
        'is_quantity_based',
        'stock',
        'image',
        'icon',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'price' => 'integer',
        'stock' => 'integer',
        'is_quantity_based' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function orderAddons()
    {
        return $this->hasMany(OrderAddon::class);
    }
}
