<?php

namespace App\Observers;

use App\Models\DeliveryOrder;
use App\Models\MonitoringLaptop;
use Illuminate\Support\Facades\Log;

class DeliveryOrderObserver
{
    public function created(DeliveryOrder $deliveryOrder)
    {
        Log::info('DeliveryOrder Observer triggered');
    
        $productDetails = json_decode($deliveryOrder->product, true);
    
        // Pastikan data produk ter-decode dengan benar
        Log::info('Detail produk yang terdekripsi: ' . json_encode($productDetails));

        // Loop untuk setiap produk di dalam DeliveryOrder
        foreach ($productDetails as $productDetail) {
            // Pastikan 'id' dan 'qty' ada di dalam array $productDetail
            if (isset($productDetail['id']) && isset($productDetail['qty'])) {
                Log::info('Memproses produk: ' . json_encode($productDetail));

                // Cek apakah sudah ada data untuk client_id, cabang_id, dan produk yang sama
                $existingMonitoring = MonitoringLaptop::where('client_id', $deliveryOrder->client_id)
                    ->where('cabang_id', $deliveryOrder->cabang_id)
                    // Menggunakan whereJsonContains untuk mencocokkan produk berdasarkan id dalam JSON
                    ->whereJsonContains('product', ['id' => $productDetail['id']])
                    ->first();
                
                if ($existingMonitoring) {
                    Log::info('Data sudah ada, menambah jumlah barang. ID Monitoring: ' . $existingMonitoring->id);
                    // Jika data sudah ada, update jumlah_barang dengan menambah qty baru
                    $existingMonitoring->increment('jumlah_barang', $productDetail['qty']);
                } else {
                    Log::info('Data tidak ditemukan, membuat entri baru untuk produk: ' . json_encode($productDetail));
                    // Jika data tidak ada, langsung buat record baru
                    try {
                        MonitoringLaptop::create([
                            'client_id' => $deliveryOrder->client_id,
                            'alamat_id' => null,
                            'cabang_id' => $deliveryOrder->cabang_id,
                            // Simpan produk dalam array [{...}]
                            'product' => json_encode([ $productDetail ]), // Menggunakan format array di sini
                            'tanggal_pengiriman' => $deliveryOrder->tanggal_pengiriman,
                            'jumlah_barang' => $productDetail['qty'],
                        ]);
                        Log::info('Entri MonitoringLaptop berhasil dibuat untuk produk: ' . $productDetail['id']);
                    } catch (\Exception $e) {
                        Log::error('Gagal membuat entri MonitoringLaptop: ' . $e->getMessage());
                    }
                }
            } else {
                Log::warning('Product atau qty tidak ditemukan untuk produk: ' . json_encode($productDetail));
            }
        }
    }
}
