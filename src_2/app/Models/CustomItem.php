<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'unit',
        'min_quantity',
        'max_quantity',
        'image',
        'icon',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'price' => 'integer',
        'min_quantity' => 'integer',
        'max_quantity' => 'integer',
        'is_active' => 'boolean',
    ];
}