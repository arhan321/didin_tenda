<?php

namespace App\Models;

use DateTimeInterface;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Client extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, HasFactory;

    public $table = 'clients';

    protected $appends = [
        'image',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'nama_client',
        'alamat_client',
        'branch_client',
        'nomor_telfon1_client',
        'nomor_telfon2_client',
        'faximile_client',
        'email_client',
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

    public function orders()
    {
        return $this->hasMany(Order::class, 'client_id', 'id');
    }

    // public function monitorings()
    // {
    //     return $this->hasMany(Monitoring::class);
    // }


    public function deliveryOrders()
    {
        return $this->hasMany(DeliveryOrder::class, 'client_id', 'id');
    }

    public function monitoringlaptop()
    {
        return $this->hasMany(MonitoringLaptop::class);
    }

    public function ordersbarang()
    {
        return $this->hasMany(OrdersBarang::class);
    }

    public function deliveryorderteches()
    {
        return $this->hasMany(DeliveryOrderTech::class);
    }

    public function invoicedgpro()
    {
        return $this->hasMany(invoicedgpro::class, 'client_id', 'id');
    }

    public function deliveryorderdgpros()
    {
        return $this->hasMany(DeliveryOrderDgpro::class, 'client_id', 'id');
    }
    
}
