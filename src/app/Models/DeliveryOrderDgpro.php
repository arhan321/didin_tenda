<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DeliveryOrderDgpro extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'delivery_order_dgpros';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'client_id',
        'alamat_id',
        'cabang_id',
        'product',
        'status',
        'pengantar',
        'tanggal_pengiriman',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function alamat()
    {
        return $this->belongsTo(Client::class, 'alamat_id');
    }

    public function cabang()
    {
        return $this->belongsTo(Client::class, 'cabang_id');
    }


}
