<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Models\Client;
use App\Models\Productech;
use Illuminate\Http\Request;
use App\Models\DeliveryOrderTech;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class DeliveryOrderTechController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('deliveryordertech_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // Mengambil semua Delivery Order Tech beserta relasi client
        $deliveryordertechs = DeliveryOrderTech::with('client')->get();

        foreach ($deliveryordertechs as $deliveryordertech) {
            Log::info('Memproses delivery order ID: ' . $deliveryordertech->id);

            $productDetails = json_decode($deliveryordertech->product, true);
            Log::info('Detail produk yang terdekripsi: ', ['details' => $productDetails]);

            if (json_last_error() === JSON_ERROR_NONE && is_array($productDetails)) {
                $product_ids = array_column($productDetails, 'id');
                $product_names = Productech::whereIn('id', $product_ids)->pluck('name', 'id')->toArray();
                Log::info('Nama produk: ', ['names' => $product_names]);

                foreach ($productDetails as &$product) {
                    if (is_array($product) && isset($product['id'])) {
                        $product['name'] = $product_names[$product['id']] ?? 'Unknown';
                    } else {
                        Log::warning('Format produk tidak valid: ', ['product' => $product]);
                        $product = ['name' => 'Unknown', 'id' => null, 'qty' => null];
                    }
                }

                $deliveryordertech->product_details = $productDetails;
            } else {
                $deliveryordertech->product_details = [];
                Log::warning('Gagal mendekode JSON atau bukan array untuk delivery order ID: ' . $deliveryordertech->id);
            }
        }

        return view('admin.deliveryordertech.index', compact('deliveryordertechs'));
    }

    public function create()
    {
        abort_if(Gate::denies('deliveryordertech_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // Mengambil data produk dan harga jual dari table Productech
        $products = Productech::all()->pluck('name', 'id');
        $productPrices = Productech::all()->pluck('harga_jual', 'id');

        // Status default
        $statusOptions = ['pending', 'delivered', 'canceled'];

        // Mengambil daftar client dan stok produk dari table Productech
        $clients = Client::all();
        $productStock = Productech::all()->pluck('stock', 'id');

        return view('admin.deliveryordertech.create', compact(
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
                $productBarang = Productech::find($productId);
    
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
    
        $deliveryordertech = DeliveryOrderTech::create($requestData);
    
        return redirect()->route('admin.deliveryordertech.index')
                         ->with('success', 'Delivery Order telah berhasil dibuat.');
    }
    
    public function edit(DeliveryOrderTech $deliveryordertech)
    {
        abort_if(Gate::denies('deliveryordertech_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $products = Productech::all();
        $productPrices = Productech::pluck('harga_jual', 'id');
        $productStock = Productech::all()->pluck('stock', 'id');
        $clients = Client::all();

        $deliveryordertech->product_details = collect(json_decode($deliveryordertech->product, true) ?: []);

        $statusOptions = ['pending', 'delivered', 'canceled'];

        return view('admin.deliveryordertech.edit', compact(
            'deliveryordertech',
            'products',
            'productPrices',
            'productStock',
            'statusOptions',
            'clients'
        ));
    }

    public function update(Request $request, DeliveryOrderTech $deliveryordertech)
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
                $productBarang = Productech::find($productId);
    
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
    
        $deliveryordertech->update($requestData);
    
        return redirect()->route('admin.deliveryordertech.index')
                         ->with('success', 'Delivery Order telah berhasil diperbarui.');
    }
    
    public function show(DeliveryOrderTech $deliveryordertech)
    {
        abort_if(Gate::denies('deliveryordertech_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        Log::info('Memproses delivery order ID: ' . $deliveryordertech->id);

        $productDetails = json_decode($deliveryordertech->product, true);
        Log::info('Detail produk yang terdekripsi: ', ['details' => $productDetails]);

        if (json_last_error() === JSON_ERROR_NONE && is_array($productDetails)) {
            $product_ids = array_column($productDetails, 'id');
            $product_names = Productech::whereIn('id', $product_ids)->pluck('name', 'id')->toArray();
            Log::info('Nama produk: ', ['names' => $product_names]);

            foreach ($productDetails as &$product) {
                if (is_array($product) && isset($product['id'])) {
                    $product['name'] = $product_names[$product['id']] ?? 'Unknown';
                } else {
                    Log::warning('Format produk tidak valid: ', ['product' => $product]);
                    $product = ['name' => 'Unknown', 'id' => null, 'qty' => null];
                }
            }

            $deliveryordertech->product_details = $productDetails;
        } else {
            $deliveryordertech->product_details = [];
            Log::warning('Gagal mendekode JSON atau bukan array untuk delivery order ID: ' . $deliveryordertech->id);
        }

        return view('admin.deliveryordertech.show', compact('deliveryordertech'));
    }

    public function destroy(DeliveryOrderTech $deliveryordertech)
    {
        abort_if(Gate::denies('deliveryordertech_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    
        // Tidak ada pengembalian stok, langsung hapus Delivery Order
        $deliveryordertech->delete();
    
        return back()->with('success', 'Delivery Order telah berhasil dihapus.');
    }
    
    public function massDestroy(Request $request)
    {
        $deliveryordertechs = DeliveryOrderTech::find(request('ids'));
    
        foreach ($deliveryordertechs as $deliveryordertech) {
            $deliveryordertech->delete();
        }
    
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
