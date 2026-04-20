<?php

namespace App\Models;

use DateTimeInterface;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Karyawan extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, HasFactory;

    public $table = 'karyawans';

    protected $appends = [
        'image',
    ];

    public const STATUS_SELECT = [
        'Aktif' => 'Aktif',
        'Tidak Aktif' => 'Tidak Aktif',
    ];

    public const JENIS_KELAMIN = [
        'Laki-Laki' => 'Laki-Laki',
        'Perempuan' => 'Perempuan',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'tanggal_lahir',
    ];

    protected $fillable = [
        'nama_karyawan',
        'alamat',
        'no_telp',
        'email',
        'jenis_kelamin',
        'tanggal_lahir',
        'tempat_lahir',
        'position_id',
        'gaji',
        'status',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function getImageAttribute()
    {
        $file = $this->getMedia('image')->last();
        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview   = $file->getUrl('preview');
        }

        return $file;
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    // public function gaji()
    // {
    //     return $this->belongsTo(Position::class, 'gaji_id');
    // }
}
