<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Models\ProductBarang; 
use App\Models\DeliveryOrderBarang;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class DeliveryOrderBarangController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('deliveryorderbarang_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // Mengambil semua Delivery Order beserta relasi client
        $deliveryorderbarangs = DeliveryOrderBarang::with('client')->get();

        foreach ($deliveryorderbarangs as $deliveryorderbarang) {
            Log::info('Memproses delivery order ID: ' . $deliveryorderbarang->id);

            $productDetails = json_decode($deliveryorderbarang->product, true);
            Log::info('Detail produk yang terdekripsi: ', ['details' => $productDetails]);

            if (json_last_error() === JSON_ERROR_NONE && is_array($productDetails)) {
                $product_ids = array_column($productDetails, 'id');
                $product_names = ProductBarang::whereIn('id', $product_ids)->pluck('name', 'id')->toArray();
                Log::info('Nama produk: ', ['names' => $product_names]);

                foreach ($productDetails as &$product) {
                    if (is_array($product) && isset($product['id'])) {
                        $product['name'] = $product_names[$product['id']] ?? 'Unknown';
                    } else {
                        Log::warning('Format produk tidak valid: ', ['product' => $product]);
                        $product = ['name' => 'Unknown', 'id' => null, 'qty' => null];
                    }
                }

                $deliveryorderbarang->product_details = $productDetails;
            } else {
                $deliveryorderbarang->product_details = [];
                Log::warning('Gagal mendekode JSON atau bukan array untuk delivery order ID: ' . $deliveryorderbarang->id);
            }
        }

        return view('admin.deliveryorderbarang.index', compact('deliveryorderbarangs'));
    }

    public function create()
    {
        abort_if(Gate::denies('deliveryorderbarang_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // Mengambil data produk dan harga jual dari table ProductBarang
        $products = ProductBarang::all()->pluck('name', 'id');
        $productPrices = ProductBarang::all()->pluck('harga_jual', 'id');

        // Status default
        $statusOptions = ['pending', 'delivered', 'canceled'];

        // Mengambil daftar client dan stok produk dari table ProductBarang
        $clients = Client::all();
        $productStock = ProductBarang::all()->pluck('stock', 'id');

        return view('admin.deliveryorderbarang.create', compact(
            'products',
            'productPrices',
            'statusOptions',
            'clients',
            'productStock'
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
                $productBarang = ProductBarang::find($productId);
    
                if ($productBarang) {
                    // Tidak ada pengecekan atau update stok.
                    $linePrice = $qty * $productBarang->harga_jual;
                    $totalPrice += $linePrice;
    
                    $productDetails[] = [
                        'id'    => $productId,
                        'qty'   => $qty,
                        'price' => $productBarang->harga_jual
                    ];
                }
            }
    
            $requestData['product'] = json_encode($productDetails);
            $requestData['price'] = $totalPrice;
        }
    
        $deliveryorderbarang = DeliveryOrderBarang::create($requestData);
    
        return redirect()->route('admin.deliveryorderbarang.index')
                         ->with('success', 'Delivery Order telah berhasil dibuat.');
    }
    
    public function edit(DeliveryOrderBarang $deliveryorderbarang)
    {
        abort_if(Gate::denies('deliveryorderbarang_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $products = ProductBarang::all();
        $productPrices = ProductBarang::pluck('harga_jual', 'id');
        $productStock = ProductBarang::all()->pluck('stock', 'id');
        $clients = Client::all();

        $deliveryorderbarang->product_details = collect(json_decode($deliveryorderbarang->product, true) ?: []);

        $statusOptions = ['pending', 'delivered', 'canceled'];

        return view('admin.deliveryorderbarang.edit', compact(
            'deliveryorderbarang',
            'products',
            'productPrices',
            'productStock',
            'statusOptions',
            'clients'
        ));
    }

    public function update(Request $request, DeliveryOrderBarang $deliveryorderbarang)
    {
        $requestData = $request->all();
        // Mengabaikan detail produk lama karena stok tidak diupdate
        if ($request->hasFile('bukti_pembayaran')) {
            $pdfPath = $request->file('bukti_pembayaran')->store('pdfs', 'public');
            $requestData['bukti_pembayaran'] = $pdfPath;
        }
    
        if ($request->has('product_qty')) {
            $productDetails = [];
            $totalPrice = 0;
    
            foreach ($request->input('product_qty') as $productId => $newQty) {
                $productBarang = ProductBarang::find($productId);
    
                if ($productBarang) {
                    $linePrice = $newQty * $productBarang->harga_jual;
                    $totalPrice += $linePrice;
    
                    $productDetails[] = [
                        'id'    => $productId,
                        'qty'   => $newQty,
                        'price' => $productBarang->harga_jual
                    ];
                }
            }
    
            $requestData['product'] = json_encode($productDetails);
            $requestData['price'] = $totalPrice;
        }
    
        $deliveryorderbarang->update($requestData);
    
        return redirect()->route('admin.deliveryorderbarang.index')
                         ->with('success', 'Delivery Order telah berhasil diperbarui.');
    }
    
    public function show(DeliveryOrderBarang $deliveryorderbarang)
    {
        abort_if(Gate::denies('deliveryorderbarang_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        Log::info('Memproses delivery order ID: ' . $deliveryorderbarang->id);

        $productDetails = json_decode($deliveryorderbarang->product, true);
        Log::info('Detail produk yang terdekripsi: ', ['details' => $productDetails]);

        if (json_last_error() === JSON_ERROR_NONE && is_array($productDetails)) {
            $product_ids = array_column($productDetails, 'id');
            $product_names = ProductBarang::whereIn('id', $product_ids)->pluck('name', 'id')->toArray();
            Log::info('Nama produk: ', ['names' => $product_names]);

            foreach ($productDetails as &$product) {
                if (is_array($product) && isset($product['id'])) {
                    $product['name'] = $product_names[$product['id']] ?? 'Unknown';
                } else {
                    Log::warning('Format produk tidak valid: ', ['product' => $product]);
                    $product = ['name' => 'Unknown', 'id' => null, 'qty' => null];
                }
            }

            $deliveryorderbarang->product_details = $productDetails;
        } else {
            $deliveryorderbarang->product_details = [];
            Log::warning('Gagal mendekode JSON atau bukan array untuk delivery order ID: ' . $deliveryorderbarang->id);
        }

        return view('admin.deliveryorderbarang.show', compact('deliveryorderbarang'));
    }

    public function destroy(DeliveryOrderBarang $deliveryorderbarang)
    {
        abort_if(Gate::denies('deliveryorderbarang_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    
        // Tidak ada pengembalian stok, langsung hapus Delivery Order
        $deliveryorderbarang->delete();
    
        return back()->with('success', 'Delivery Order telah berhasil dihapus.');
    }
    
    public function massDestroy(Request $request)
    {
        $deliveryorderbarangs = DeliveryOrderBarang::find(request('ids'));
    
        foreach ($deliveryorderbarangs as $deliveryorderbarang) {
            $deliveryorderbarang->delete();
        }
    
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
