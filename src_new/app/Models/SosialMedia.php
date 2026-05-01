<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SosialMedia extends Model
{
    use HasFactory;

    protected $table = 'sosial_media';

    protected $fillable = [
        'icon',
        'link',
    ];
}