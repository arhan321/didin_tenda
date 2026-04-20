<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Monitoring extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'product_id',
        'stock_awal',
        'stock_outstanding',
        // 'nama_client',
        // 'branch_client',
        // 'alamat_client',
        'category_id',
        'vendor_id',
        'stock_sisa'
    ];

    // Relasi ke Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relasi ke Client (Nama Client)
    // public function clientName()
    // {
    //     return $this->belongsTo(Client::class, 'nama_client');
    // }

    // // Relasi ke Client (Branch Client)
    // public function clientBranch()
    // {
    //     return $this->belongsTo(Client::class, 'branch_client');
    // }

    // // Relasi ke Client (Alamat Client)
    // public function clientAddress()
    // {
    //     return $this->belongsTo(Client::class, 'alamat_client');
    // }

    // Relasi ke CategoryProduct
    public function category()
    {
        return $this->belongsTo(CategoryProduct::class, 'category_id');
    }

    // Relasi ke Vendor
    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    // Relasi ke MonitoringLaptop
    public function monitoringLaptop()
    {
        return $this->hasMany(MonitoringLaptop::class);
    }
}





