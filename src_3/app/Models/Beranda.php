<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Beranda extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_1',
        'title_2',
        'deskripsi',
        'image',
    ];
}