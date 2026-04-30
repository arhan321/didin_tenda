<?php

namespace App\Models;

use App\Models\OrderAddon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Addon extends Model
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