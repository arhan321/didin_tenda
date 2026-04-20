<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Models\Client;
use App\Models\Product;
use App\Models\Monitoring;
use Illuminate\Http\Request; 
use App\Models\DeliveryOrder;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class DeliveryOrderController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('deliveryorder_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // Mengambil semua delivery orders dengan relasi client
        $deliveryorders = DeliveryOrder::with('client')->get();

        foreach ($deliveryorders as $deliveryorder) {
            Log::info('Memproses delivery order ID: ' . $deliveryorder->id);

            $productDetails = json_decode($deliveryorder->product, true);
            Log::info('Detail produk yang terdekripsi: ', ['details' => $productDetails]);

            if (json_last_error() === JSON_ERROR_NONE && is_array($productDetails)) {
                $product_ids = array_column($productDetails, 'id');
                $product_names = Product::whereIn('id', $product_ids)->pluck('name', 'id')->toArray();
                Log::info('Nama produk: ', ['names' => $product_names]);

                foreach ($productDetails as &$product) {
                    if (is_array($product) && isset($product['id'])) {
                        $product['name'] = $product_names[$product['id']] ?? 'Unknown';
                    } else {
                        Log::warning('Format produk tidak valid: ', ['product' => $product]);
                        $product = ['name' => 'Unknown', 'id' => null, 'qty' => null];
                    }
                }

                $deliveryorder->product_details = $productDetails;
            } else {
                $deliveryorder->product_details = [];
                Log::warning('Gagal mendekode JSON atau bukan array untuk delivery order ID: ' . $deliveryorder->id);
            }
        }

        return view('admin.deliveryorders.index', compact('deliveryorders'));
    }

    public function create()
    {
        abort_if(Gate::denies('deliveryorder_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // Mengambil data produk dan harga sewa
        $products = Product::all()->pluck('name', 'id');
        $productPrices = Product::all()->pluck('harga_sewa', 'id');

        // Mengambil status default
        $statusOptions = ['pending', 'delivered', 'canceled'];

        // Mengambil daftar client dan stok dari monitoring berdasarkan product_id
        $clients = Client::all();
        $monitoringStock = Monitoring::all()->pluck('stock_awal', 'product_id');

        return view('admin.deliveryorders.create', compact(
            'products',
            'productPrices',
            'statusOptions',
            'clients',
            'monitoringStock'
        ));
    }

    public function store(Request $request)
    {
        $requestData = $request->all();
        
        if ($request->hasFile('bukti_pembayaran')) {
            $pdfPath = $request->file('bukti_pembayaran')->store('pdfs', 'public');
            $requestData['bukti_pembayaran'] = $pdfPath;
        }
    
        if ($request->has('product_qty')) {
            $productDetails = [];
            $totalPrice = 0;
    
            foreach ($request->input('product_qty') as $productId => $qty) {
                $product = Product::find($productId);
                $monitoring = Monitoring::where('product_id', $productId)->first();
    
                if ($product && $monitoring) {
                    // Hitung stock_sisa baru setelah penambahan qty
                    $newStockOutstanding = $monitoring->stock_outstanding + $qty;
                    $newStockSisa = $monitoring->stock_awal - $newStockOutstanding;
    
                    // Cek jika stock_sisa melebihi stock_awal
                    if ($newStockSisa < 0) {
                        return redirect()->back()->withErrors([
                            'error' => 'Tidak dapat membuat Delivery Order untuk produk "' . $product->name . '". 
                                        sisa stock tidak tercukupi, Stok awal: ' . $monitoring->stock_awal . ',
                                        sisa stock: ' . $monitoring->stock_sisa . '.'
                        ]);
                    }
    
                    // Tambahkan qty ke stock_outstanding
                    $monitoring->increment('stock_outstanding', $qty);
    
                    // Hitung stock_sisa berdasarkan stock_awal - stock_outstanding
                    $monitoring->stock_sisa = $monitoring->stock_awal - $monitoring->stock_outstanding;
                    $monitoring->save();
    
                    $linePrice = $qty * $product->harga_sewa;
                    $totalPrice += $linePrice;
    
                    $productDetails[] = [
                        'id' => $productId,
                        'qty' => $qty,
                        'price' => $product->harga_sewa
                    ];
                }
            }
    
            $requestData['product'] = json_encode($productDetails);
            $requestData['price'] = $totalPrice;
        }
    
        $deliveryorder = DeliveryOrder::create($requestData);
    
        return redirect()->route('admin.deliveryorders.index')->with('success', 'Delivery Order telah berhasil dibuat.');
    }
    
    public function edit(DeliveryOrder $deliveryorder)
    {
        abort_if(Gate::denies('deliveryorder_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $products = Product::all();
        $productPrices = Product::pluck('harga_sewa', 'id');
        $monitoringStock = Monitoring::all()->pluck('stock_outstanding', 'product_id');
        $clients = Client::all();

        $deliveryorder->product_details = collect(json_decode($deliveryorder->product, true) ?: []);

        $statusOptions = ['pending', 'delivered', 'canceled'];

        return view('admin.deliveryorders.edit', compact('deliveryorder', 'products', 'productPrices', 'monitoringStock', 'statusOptions', 'clients'));
    }

    public function update(Request $request, DeliveryOrder $deliveryorder)
    {
        $requestData = $request->all();
        $oldProductDetails = json_decode($deliveryorder->product, true) ?? [];
    
        if ($request->hasFile('bukti_pembayaran')) {
            $pdfPath = $request->file('bukti_pembayaran')->store('pdfs', 'public');
            $requestData['bukti_pembayaran'] = $pdfPath;
        }
    
        if ($request->has('product_qty')) {
            $productDetails = [];
            $totalPrice = 0;
    
            foreach ($request->input('product_qty') as $productId => $newQty) {
                $product = Product::find($productId);
                $monitoring = Monitoring::where('product_id', $productId)->first();
                $oldQty = collect($oldProductDetails)->firstWhere('id', $productId)['qty'] ?? 0;
    
                if ($product && $monitoring) {
                    // Hitung perbedaan kuantitas
                    $qtyDifference = $newQty - $oldQty;
    
                    // Cek jika stock_outstanding mencukupi untuk perubahan
                    if ($monitoring->stock_outstanding < max(0, $qtyDifference)) {
                        return redirect()->back()->withErrors(['error' => 'Stok untuk produk ID ' . $productId . ' tidak mencukupi untuk pembaruan.']);
                    }
    
                    // Sesuaikan stock_outstanding
                    $monitoring->decrement('stock_outstanding', $qtyDifference);
    
                    $linePrice = $newQty * $product->harga_sewa;
                    $totalPrice += $linePrice;
    
                    $productDetails[] = [
                        'id' => $productId,
                        'qty' => $newQty,
                        'price' => $product->harga_sewa
                    ];
                }
            }
    
            $requestData['product'] = json_encode($productDetails);
            $requestData['price'] = $totalPrice;
        }
    
        $deliveryorder->update($requestData);
    
        return redirect()->route('admin.deliveryorders.index')->with('success', 'Delivery Order telah berhasil diperbarui.');
    }
    
    public function show(DeliveryOrder $deliveryorder)
    {
        abort_if(Gate::denies('deliveryorder_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        Log::info('Memproses delivery order ID: ' . $deliveryorder->id);

        $productDetails = json_decode($deliveryorder->product, true);
        Log::info('Detail produk yang terdekripsi: ', ['details' => $productDetails]);

        if (json_last_error() === JSON_ERROR_NONE && is_array($productDetails)) {
            $product_ids = array_column($productDetails, 'id');
            $product_names = Product::whereIn('id', $product_ids)->pluck('name', 'id')->toArray();
            Log::info('Nama produk: ', ['names' => $product_names]);

            foreach ($productDetails as &$product) {
                if (is_array($product) && isset($product['id'])) {
                    $product['name'] = $product_names[$product['id']] ?? 'Unknown';
                } else {
                    Log::warning('Format produk tidak valid: ', ['product' => $product]);
                    $product = ['name' => 'Unknown', 'id' => null, 'qty' => null];
                }
            }

            $deliveryorder->product_details = $productDetails;
        } else {
            $deliveryorder->product_details = [];
            Log::warning('Gagal mendekode JSON atau bukan array untuk delivery order ID: ' . $deliveryorder->id);
        }

        return view('admin.deliveryorders.show', compact('deliveryorder'));
    }

    public function destroy(DeliveryOrder $deliveryorder)
    {
        abort_if(Gate::denies('deliveryorder_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    
        $productDetails = json_decode($deliveryorder->product, true) ?? [];
    
        foreach ($productDetails as $productDetail) {
            $monitoring = Monitoring::where('product_id', $productDetail['id'])->first();
    
            if ($monitoring) {
                // Kembalikan qty ke stock_outstanding
                $monitoring->stock_outstanding -= $productDetail['qty']; // Kurangi stock_outstanding dengan qty yang dihapus
                
                // Hitung stock_sisa berdasarkan stock_awal - stock_outstanding yang baru
                $monitoring->stock_sisa = $monitoring->stock_awal - $monitoring->stock_outstanding; // Reset stock_sisa sesuai dengan stock_awal
    
                $monitoring->save();
            }
        }
    
        $deliveryorder->delete();
    
        return back()->with('success', 'Delivery Order telah berhasil dihapus.');
    }
    
    public function massDestroy(Request $request)
    {
        $deliveryorders = DeliveryOrder::find(request('ids'));
    
        foreach ($deliveryorders as $deliveryorder) {
            $productDetails = json_decode($deliveryorder->product, true) ?? [];
    
            foreach ($productDetails as $productDetail) {
                $monitoring = Monitoring::where('product_id', $productDetail['id'])->first();
    
                if ($monitoring) {
                    // Kembalikan qty ke stock_outstanding
                    $monitoring->stock_outstanding -= $productDetail['qty']; // Kurangi stock_outstanding dengan qty yang dihapus
                    
                    // Hitung stock_sisa berdasarkan stock_awal - stock_outstanding yang baru
                    $monitoring->stock_sisa = $monitoring->stock_awal - $monitoring->stock_outstanding; // Reset stock_sisa sesuai dengan stock_awal
    
                    $monitoring->save();
                }
            }
    
            // Hapus delivery order
            $deliveryorder->delete();
        }
    
        return response(null, Response::HTTP_NO_CONTENT);
    }
    
}
