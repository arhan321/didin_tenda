<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Galery extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'deskripsi',
        'image',
    ];
}
