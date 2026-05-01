<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Beranda extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_1',
        'title_2',
        'deskripsi',
        'image',
    ];
}
