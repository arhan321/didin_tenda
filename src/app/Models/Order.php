<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'orders';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const STATUS_SELECT = [
        'Belum bayar' => 'Belum bayar',
        'Sudah bayar' => 'Sudah bayar',
    ];

    protected $fillable = [
        'client_id',
        'cabang_id',
        'alamat_id',
        'product',
        'price',
        'start',
        'end',
        'status_bayar',
        'status_sewa',
        'bukti_pembayaran',
        'tax',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }


}
