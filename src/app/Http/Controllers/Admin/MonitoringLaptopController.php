<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Models\Client;
use App\Models\Product;
use App\Models\Monitoring;
use Illuminate\Http\Request; 
use App\Models\MonitoringLaptop;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class MonitoringLaptopController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('monitoringlaptop_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // Mengambil semua delivery orders dengan relasi client
        $monitoringlaptops = MonitoringLaptop::with('client')->get();

        foreach ($monitoringlaptops as $monitoringlaptop) {
            Log::info('Memproses delivery order ID: ' . $monitoringlaptop->id);

            $productDetails = json_decode($monitoringlaptop->product, true);
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

                $monitoringlaptop->product_details = $productDetails;
            } else {
                $monitoringlaptop->product_details = [];
                Log::warning('Gagal mendekode JSON atau bukan array untuk delivery order ID: ' . $monitoringlaptop->id);
            }
        }

        return view('admin.monitoringlaptops.index', compact('monitoringlaptops'));
    }

    public function create()
    {
        abort_if(Gate::denies('monitoringlaptop_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // Mengambil data produk dan harga sewa
        $products = Product::all()->pluck('name', 'id');
        $productPrices = Product::all()->pluck('harga_sewa', 'id');

        // Mengambil status default
        $statusOptions = ['pending', 'delivered', 'canceled'];

        // Mengambil daftar client dan stok dari monitoring berdasarkan product_id
        $clients = Client::all();
        $monitoringStock = Monitoring::all()->pluck('stock_outstanding', 'product_id');

        return view('admin.monitoringlaptops.create', compact(
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
    
        // Menangani unggahan PDF
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
                    // Kurangi stock_outstanding
                    $monitoring->decrement('stock_outstanding', $qty);
    
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
    
        // Menyimpan delivery order
        $monitoringlaptop = MonitoringLaptop::create($requestData);
    
        return redirect()->route('admin.monitoringlaptops.index')->with('success', 'Delivery Order telah berhasil dibuat.');
    }

    public function edit(MonitoringLaptop $monitoringlaptop)
    {
        abort_if(Gate::denies('monitoringlaptop_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $products = Product::all();
        $productPrices = Product::pluck('harga_sewa', 'id');
        $monitoringStock = Monitoring::all()->pluck('stock_outstanding', 'product_id');
        $clients = Client::all();

        $monitoringlaptop->product_details = collect(json_decode($monitoringlaptop->product, true) ?: []);

        $statusOptions = ['pending', 'delivered', 'canceled'];

        return view('admin.monitoringlaptops.edit', compact('monitoringlaptop', 'products', 'productPrices', 'monitoringStock', 'statusOptions', 'clients'));
    }

    public function update(Request $request, MonitoringLaptop $monitoringlaptop)
    {
        $requestData = $request->all();
        $oldProductDetails = json_decode($monitoringlaptop->product, true) ?? [];
    
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
                    // Sesuaikan stock_outstanding
                    $qtyDifference = $oldQty - $newQty;
                    $monitoring->increment('stock_outstanding', $qtyDifference);
    
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
    
        $monitoringlaptop->update($requestData);
    
        return redirect()->route('admin.monitoringlaptops.index')->with('success', 'Delivery Order telah berhasil diperbarui.');
    }

    public function show(MonitoringLaptop $monitoringlaptop)
    {
        abort_if(Gate::denies('monitoringlaptop_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        Log::info('Memproses delivery order ID: ' . $monitoringlaptop->id);

        $productDetails = json_decode($monitoringlaptop->product, true);
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

            $monitoringlaptop->product_details = $productDetails;
        } else {
            $monitoringlaptop->product_details = [];
            Log::warning('Gagal mendekode JSON atau bukan array untuk delivery order ID: ' . $monitoringlaptop->id);
        }

        return view('admin.monitoringlaptops.show', compact('monitoringlaptop'));
    }

    public function destroy(MonitoringLaptop $monitoringlaptop)
    {
        abort_if(Gate::denies('monitoringlaptop_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    
        // Langsung hapus delivery order tanpa memodifikasi stok
        $monitoringlaptop->delete();
    
        return back()->with('success', 'Monitoring Laptop telah berhasil dihapus.');
    }

    public function massDestroy(Request $request)
    {
        $monitoringlaptops = MonitoringLaptop::find(request('ids'));
    
        foreach ($monitoringlaptops as $monitoringlaptop) {
            // Langsung hapus delivery order tanpa memodifikasi stok
            $monitoringlaptop->delete();
        }
    
        return response(null, Response::HTTP_NO_CONTENT);
    }
    
}
