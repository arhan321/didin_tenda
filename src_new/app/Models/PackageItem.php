<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class PackageItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'package_id',
        'name',
        'quantity',
        'unit',
        'description',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'sort_order' => 'integer',
        'is_active' => 'boolean',
    ];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
