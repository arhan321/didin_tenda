<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Models\Client;
use App\Models\Productech;
use Illuminate\Http\Request;
use App\Models\DeliveryOrderDgpro;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class DeliveryOrderDgproController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('deliveryorderdgpro_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // Mengambil semua Delivery Order beserta relasi client
        $dodgpros = DeliveryOrderDgpro::with('client')->get();

        foreach ($dodgpros as $dodgpro) {
            Log::info('Memproses delivery order ID: ' . $dodgpro->id);

            $productDetails = json_decode($dodgpro->product, true);
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

                $dodgpro->product_details = $productDetails;
            } else {
                $dodgpro->product_details = [];
                Log::warning('Gagal mendekode JSON atau bukan array untuk delivery order ID: ' . $dodgpro->id);
            }
        }

        return view('admin.dodgpros.index', compact('dodgpros'));
    }

    public function create()
    {
        abort_if(Gate::denies('deliveryorderdgpro_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $products       = Productech::all()->pluck('name', 'id');
        $productPrices  = Productech::all()->pluck('harga_jual', 'id');
        $statusOptions  = ['pending', 'delivered', 'canceled'];
        $clients        = Client::all();
        $productStock   = Productech::all()->pluck('stock', 'id');

        return view('admin.dodgpros.create', compact(
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
                    $linePrice   = $qty * $productBarang->harga_jual;
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
    
        $dodgpro = DeliveryOrderDgpro::create($requestData);
    
        return redirect()->route('admin.dodgpros.index')
                         ->with('success', 'Delivery Order telah berhasil dibuat.');
    }
    
    public function edit(DeliveryOrderDgpro $dodgpro)
    {
        abort_if(Gate::denies('deliveryorderdgpro_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $products       = Productech::all();
        $productPrices  = Productech::pluck('harga_jual', 'id');
        $productStock   = Productech::all()->pluck('stock', 'id');
        $clients        = Client::all();

        // Decode product ke array/collection
        $dodgpro->product_details = collect(json_decode($dodgpro->product, true) ?: []);

        $statusOptions = ['pending', 'delivered', 'canceled'];

        return view('admin.dodgpros.edit', compact(
            'dodgpro',
            'products',
            'productPrices',
            'productStock',
            'statusOptions',
            'clients'
        ));
    }

    public function update(Request $request, DeliveryOrderDgpro $dodgpro)
    {
        $requestData = $request->all();

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
                    $linePrice   = $newQty * $productBarang->harga_jual;
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
    
        $dodgpro->update($requestData);
    
        return redirect()->route('admin.dodgpros.index')
                         ->with('success', 'Delivery Order telah berhasil diperbarui.');
    }
    
    public function show(DeliveryOrderDgpro $dodgpro)
    {
        abort_if(Gate::denies('deliveryorderdgpro_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        Log::info('Memproses delivery order ID: ' . $dodgpro->id);

        $productDetails = json_decode($dodgpro->product, true);
        Log::info('Detail produk yang terdekripsi: ', ['details' => $productDetails]);

        if (json_last_error() === JSON_ERROR_NONE && is_array($productDetails)) {
            $product_ids   = array_column($productDetails, 'id');
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

            $dodgpro->product_details = $productDetails;
        } else {
            $dodgpro->product_details = [];
            Log::warning('Gagal mendekode JSON atau bukan array untuk delivery order ID: ' . $dodgpro->id);
        }

        return view('admin.dodgpros.show', compact('dodgpro'));
    }

    public function destroy(DeliveryOrderDgpro $dodgpro)
    {
        abort_if(Gate::denies('deliveryorderdgpro_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    
        $dodgpro->delete();
    
        return back()->with('success', 'Delivery Order telah berhasil dihapus.');
    }
    
    public function massDestroy(Request $request)
    {
        $dodgpros = DeliveryOrderDgpro::find($request->input('ids'));
    
        foreach ($dodgpros as $dodgpro) {
            $dodgpro->delete();
        }
    
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
