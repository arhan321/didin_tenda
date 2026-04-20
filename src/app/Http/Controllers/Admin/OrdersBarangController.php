<?php

namespace App\Http\Controllers\Admin;

use Gate;
use Carbon\Carbon;
use App\Models\Client;
use App\Models\OrdersBarang;
use Illuminate\Http\Request;
use App\Models\ProductBarang;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class OrdersBarangController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('orderbarang_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // Mengambil semua data OrdersBarang
        $orderbarangs = OrdersBarang::with('client')->get();

        // Mem-parse field JSON 'product' dan menambahkan 'name' dari ProductBarang
        foreach ($orderbarangs as $orderbarang) {
            Log::info('Processing orderbarang ID: ' . $orderbarang->id);

            $productDetails = json_decode($orderbarang->product, true);
            Log::info('Decoded product details: ', ['details' => $productDetails]);

            if (json_last_error() === JSON_ERROR_NONE && is_array($productDetails)) {
                // Kumpulkan semua product_id
                $product_ids   = array_column($productDetails, 'id');
                // Ambil nama produk berdasarkan ID
                $product_names = ProductBarang::whereIn('id', $product_ids)
                    ->pluck('name', 'id')
                    ->toArray();

                Log::info('ProductBarang names: ', ['names' => $product_names]);

                foreach ($productDetails as &$product) {
                    if (is_array($product) && isset($product['id'])) {
                        $product['name'] = $product_names[$product['id']] ?? 'Unknown';
                    } else {
                        Log::warning('Invalid product format: ', ['product' => $product]);
                        $product = ['name' => 'Unknown', 'id' => null, 'qty' => null];
                    }
                }

                $orderbarang->product_details = $productDetails;
            } else {
                $orderbarang->product_details = [];
                Log::warning('Failed to decode JSON or not an array for orderbarang ID: ' . $orderbarang->id);
            }
        }

        return view('admin.orderbarangs.index', compact('orderbarangs'));
    }

        public function create()
        {
            abort_if(Gate::denies('orderbarang_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

            // Daftar nama produk
            $products      = ProductBarang::all()->pluck('name', 'id');
            // Harga jual dari tabel product_barangs
            $productPrices = ProductBarang::all()->pluck('harga_jual', 'id');

            $productStocks = ProductBarang::all()->pluck('stock', 'id'); // Ambil stok produk

            // Status pembayaran
            $statusBayarOptions   = OrdersBarang::STATUS_SELECT;
            $defaultStatusSewa    = 'Belum Selesai';
            $defaultStatusBayar   = 'Belum bayar';

            // Daftar klien
            $clients = Client::all();

            return view('admin.orderbarangs.create', compact(
                'products',
                'productPrices',
                'statusBayarOptions',
                'clients',
                'defaultStatusSewa',
                'defaultStatusBayar',
                'productStocks' // Kirim stok produk
            ));
        }

        public function store(Request $request)
        {
            $requestData = $request->all();
        
            // Jika Anda pakai "status_sewa"
            $requestData['status_sewa'] = $request->input('status_sewa', 'Belum Selesai');
        
            // Handle PDF Upload
            if ($request->hasFile('bukti_pembayaran')) {
                $pdfPath = $request->file('bukti_pembayaran')->store('pdfs', 'public');
                $requestData['bukti_pembayaran'] = $pdfPath;
            }
        
            // Menangani input product_qty agar disimpan sebagai JSON di kolom 'product'
            if ($request->has('product_qty')) {
                $productDetails = [];
                $totalPrice = 0;
                $initialStock = []; // Menyimpan stok awal
        
                foreach ($request->input('product_qty') as $productId => $qty) {
                    $product = ProductBarang::find($productId);
                    if ($product) {
                        // Simpan stok awal sebelum stok diubah
                        $initialStock[$productId] = $product->stock;
        
                        // Kurangi stok produk berdasarkan qty
                        $product->stock -= $qty;
                        $product->save();
        
                        $linePrice = $qty * $product->harga_jual;
                        $totalPrice += $linePrice;
        
                        $productDetails[] = [
                            'id'    => $productId,
                            'qty'   => $qty,
                            'price' => $product->harga_jual,
                        ];
                    }
                }
        
                // Simpan stok awal dalam bentuk JSON
                $requestData['initial_stock'] = json_encode($initialStock);
        
                $requestData['product'] = json_encode($productDetails);
                $requestData['price']   = $totalPrice;
            }
        
            // Simpan data
            $orderbarang = OrdersBarang::create($requestData);
        
            // Update bukti pembayaran jika ada
            if (isset($requestData['bukti_pembayaran'])) {
                $orderbarang->update(['bukti_pembayaran' => $requestData['bukti_pembayaran']]);
            }
        
            return redirect()->route('admin.orderbarangs.index')
                ->with('success', 'OrdersBarang has been created successfully.');
        }
        
        
    public function edit(OrdersBarang $orderbarang)
    {
        abort_if(Gate::denies('orderbarang_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // Daftar produk
        $products      = ProductBarang::all();
        $productPrices = ProductBarang::pluck('harga_jual', 'id');
        $clients       = Client::all();

        // Parse JSON
        $orderbarang->product_details = collect(json_decode($orderbarang->product, true) ?: []);
        $statusBayarOptions = OrdersBarang::STATUS_SELECT;

        return view('admin.orderbarangs.edit', compact(
            'orderbarang',
            'products',
            'productPrices',
            'statusBayarOptions',
            'clients'
        ));
    }

    public function update(Request $request, OrdersBarang $orderbarang)
{
    $requestData = $request->all();

    // Ambil status sewa lama
    $previousStatus = $orderbarang->status_sewa;
    $requestData['status_sewa'] = $request->input('status_sewa', $orderbarang->status_sewa);

    // Handle PDF Upload
    if ($request->hasFile('bukti_pembayaran')) {
        $pdfPath = $request->file('bukti_pembayaran')->store('pdfs', 'public');
        $requestData['bukti_pembayaran'] = $pdfPath;
    }

    // Tangani product_qty
    if ($request->has('product_qty')) {
        $productDetails = [];
        $totalPrice = 0;

        // Get previous product details
        $previousProductDetails = collect(json_decode($orderbarang->product, true));

        foreach ($request->input('product_qty') as $productId => $newQty) {
            $product = ProductBarang::find($productId);

            if ($product) {
                $linePrice = $product->harga_jual * $newQty;
                $totalPrice += $linePrice;

                // Dapatkan quantity sebelumnya
                $oldQty = $previousProductDetails->where('id', $productId)->first()['qty'] ?? 0;

                // Kurangi atau tambahkan stok sesuai perubahan quantity
                if ($newQty > $oldQty) {
                    $quantityToDecrease = $newQty - $oldQty;
                    if ($product->stock >= $quantityToDecrease) {
                        $product->stock -= $quantityToDecrease;
                        $product->save();
                    } else {
                        return redirect()->back()->with('error', 'Stok tidak cukup untuk produk: ' . $product->name);
                    }
                } elseif ($newQty < $oldQty) {
                    $quantityToIncrease = $oldQty - $newQty;
                    $product->stock += $quantityToIncrease;
                    $product->save();
                }

                $productDetails[] = [
                    'id'    => $productId,
                    'qty'   => $newQty,
                    'price' => $product->harga_jual,
                ];
            }
        }

        $requestData['product'] = json_encode($productDetails);
        $requestData['price']   = $totalPrice;
    }

    $orderbarang->update($requestData);

    return redirect()->route('admin.orderbarangs.index')
        ->with('success', 'OrdersBarang has been updated successfully.');
}

    public function show(OrdersBarang $orderbarang)
    {
        abort_if(Gate::denies('orderbarang_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        Log::info('Processing orderbarang ID: ' . $orderbarang->id);

        $productDetails = json_decode($orderbarang->product, true);
        Log::info('Decoded product details: ', ['details' => $productDetails]);

        if (json_last_error() === JSON_ERROR_NONE && is_array($productDetails)) {
            $product_ids   = array_column($productDetails, 'id');
            $product_names = ProductBarang::whereIn('id', $product_ids)
                ->pluck('name', 'id')
                ->toArray();
            Log::info('ProductBarang names: ', ['names' => $product_names]);

            foreach ($productDetails as &$product) {
                if (is_array($product) && isset($product['id'])) {
                    $product['name'] = $product_names[$product['id']] ?? 'Unknown';
                } else {
                    Log::warning('Invalid product format: ', ['product' => $product]);
                    $product = ['name' => 'Unknown', 'id' => null, 'qty' => null];
                }
            }

            $orderbarang->product_details = $productDetails;
        } else {
            $orderbarang->product_details = [];
            Log::warning('Failed to decode JSON or not an array for orderbarang ID: ' . $orderbarang->id);
        }

        return view('admin.orderbarangs.show', compact('orderbarang'));
    }

    public function destroy(OrdersBarang $orderbarang)
    {
        abort_if(Gate::denies('orderbarang_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    
        $productDetails = json_decode($orderbarang->product, true) ?? []; // Ambil detail produk dalam JSON
    
        foreach ($productDetails as $productDetail) {
            $product = ProductBarang::find($productDetail['id']); // Cari produk berdasarkan product_id
    
            if ($product) {
                // Kembalikan stock produk ke nilai sebelumnya
                $product->stock += $productDetail['qty']; // Tambahkan qty yang dihapus kembali ke stock
                $product->save(); // Simpan perubahan stok
            }
        }
    
        // Hapus order setelah stok dikembalikan
        $orderbarang->delete();
    
        return back()->with('success', 'OrdersBarang has been deleted successfully.');
    }
    
    public function massDestroy(Request $request)
    {
        $orderbarangs = OrdersBarang::find(request('ids')); // Ambil data order yang akan dihapus
    
        foreach ($orderbarangs as $orderbarang) {
            $productDetails = json_decode($orderbarang->product, true) ?? []; // Ambil detail produk dalam JSON
    
            foreach ($productDetails as $productDetail) {
                $product = ProductBarang::find($productDetail['id']); // Cari produk berdasarkan product_id
    
                if ($product) {
                    // Kembalikan stock produk ke nilai sebelumnya
                    $product->stock += $productDetail['qty']; // Tambahkan qty yang dihapus kembali ke stock
                    $product->save(); // Simpan perubahan stok
                }
            }
    
            // Hapus order setelah stok dikembalikan
            $orderbarang->delete();
        }
    
        return response(null, Response::HTTP_NO_CONTENT);
    }
    
}
