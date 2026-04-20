<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Models\Client;
use App\Models\Productech;
use App\Models\Invoicedgpro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class InvoicedgproController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('dgpro_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // Mengambil semua data Invoicedgpro beserta relasi
        $invoicedgpros = Invoicedgpro::with(['client', 'alamat', 'cabang'])->get();

        // Loop setiap invoicedgpro untuk decode product JSON & tambahkan nama produk
        foreach ($invoicedgpros as $invoicedgpro) {
            Log::info('Processing invoicedgpro ID: ' . $invoicedgpro->id);

            $productDetails = json_decode($invoicedgpro->product, true);
            Log::info('Decoded product details: ', ['details' => $productDetails]);

            if (json_last_error() === JSON_ERROR_NONE && is_array($productDetails)) {
                $product_ids   = array_column($productDetails, 'id');
                $product_names = Productech::whereIn('id', $product_ids)->pluck('name', 'id')->toArray();
                Log::info('Product names: ', ['names' => $product_names]);

                foreach ($productDetails as &$product) {
                    if (is_array($product) && isset($product['id'])) {
                        $product['name'] = $product_names[$product['id']] ?? 'Unknown';
                    } else {
                        Log::warning('Invalid product format: ', ['product' => $product]);
                        $product = ['name' => 'Unknown', 'id' => null, 'qty' => null];
                    }
                }

                $invoicedgpro->product_details = $productDetails;
            } else {
                $invoicedgpro->product_details = [];
                Log::warning('Failed to decode JSON or not an array for invoicedgpro ID: ' . $invoicedgpro->id);
            }
        }

        return view('admin.invoicedgpros.index', compact('invoicedgpros'));
    }

    public function create()
    {
        abort_if(Gate::denies('dgpro_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    
        $products           = Productech::all()->pluck('name', 'id');
        $productPrices      = Productech::all()->pluck('harga_jual', 'id');
        $productStocks      = Productech::all()->pluck('stock_barang', 'id');
        $clients            = Client::all();
        $statusBayarOptions = Invoicedgpro::STATUS_SELECT;
        $defaultStatusBayar = 'Belum bayar';
    
        return view('admin.invoicedgpros.create', compact(
            'products',
            'productPrices',
            'productStocks',
            'clients',
            'statusBayarOptions',
            'defaultStatusBayar'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_id'             => 'required|exists:clients,id',
            'alamat_id'             => 'nullable|exists:clients,id',
            'cabang_id'             => 'nullable|exists:clients,id',
            'status_bayar'          => 'required|string|in:Belum bayar,Sudah bayar',
            'product_qty.*'         => 'required|integer|min:1',
            'bukti_pembayaran_file' => 'nullable|file|mimes:pdf|max:2048',
            'start'                 => 'nullable|date',
            'end'                   => 'nullable|date|after_or_equal:start',
            'tax'                   => 'nullable|numeric|min:0|max:100',
        ]);
    
        $requestData = $request->all();
    
        // Metode pembayaran
        if ($request->input('metode_pembayaran') === 'upload' && $request->hasFile('bukti_pembayaran_file')) {
            $pdfPath = $request->file('bukti_pembayaran_file')->store('pdfs', 'public');
            $requestData['bukti_pembayaran'] = $pdfPath;
        } elseif ($request->input('metode_pembayaran') === 'cash') {
            $requestData['bukti_pembayaran'] = 'CASH';
        }
    
        // Hitung total & simpan produk tanpa mengubah stok
        $productDetails = [];
        $totalPrice     = 0;
    
        foreach ($request->input('product_qty') as $productId => $qty) {
            $product = Productech::find($productId);
    
            if ($product) {
                $linePrice   = $qty * $product->harga_jual;
                $totalPrice += $linePrice;
    
                $productDetails[] = [
                    'id'    => $productId,
                    'qty'   => $qty,
                    'price' => $product->harga_jual
                ];
            }
        }
    
        // Masukkan JSON product & total harga + pajak
        $requestData['product'] = json_encode($productDetails);
        $totalWithTax           = $totalPrice + ($totalPrice * ($request->input('tax', 0) / 100));
        $requestData['price']   = $totalWithTax;
    
        // Simpan invoicedgpro baru tanpa mempengaruhi stok produk
        Invoicedgpro::create($requestData);
    
        return redirect()->route('admin.invoicedgpros.index')->with('success', 'Invoice successfully created.');
    }
    
    public function edit(Invoicedgpro $invoicedgpro)
    {
        abort_if(Gate::denies('dgpro_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    
        // Ambil semua produk dari tabel Productech
        $products = Productech::all();
    
        // Ambil harga jual dari produk
        $productPrices = Productech::pluck('harga_jual', 'id');
    
        // Ambil clients dari tabel Client
        $clients = Client::all();
    
        // Ambil stok dari field `stock_barang` di tabel Productech
        $stockProduct = Productech::pluck('stock_barang', 'id');
    
        // Ambil detail produk yang disimpan dalam bentuk JSON
        $invoicedgpro->product_details = collect(json_decode($invoicedgpro->product, true) ?: []);
    
        // Ambil status bayar dari Invoice model
        $statusBayarOptions = Invoicedgpro::STATUS_SELECT;
    
        return view('admin.invoicedgpros.edit', compact('invoicedgpro', 'products', 'productPrices', 'stockProduct', 'clients', 'statusBayarOptions'));
    }
    
    public function update(Request $request, Invoicedgpro $invoicedgpro)
    {
        // Validasi input
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'product_qty.*' => 'required|integer|min:1',
            'status_bayar' => 'required|string|in:Belum bayar,Sudah bayar',
            'bukti_pembayaran' => $request->metode_pembayaran == 'upload' ? 'nullable|file|mimes:pdf|max:2048' : 'nullable',
            'start' => 'nullable|date',
            'end' => 'nullable|date|after_or_equal:start',
            'tax' => 'nullable|numeric|min:0|max:100',
        ]);
    
        $requestData = $request->all();
    
        // Proses upload PDF jika metode pembayaran adalah upload
        if ($request->metode_pembayaran == 'upload' && $request->hasFile('bukti_pembayaran')) {
            if ($invoicedgpro->bukti_pembayaran && Storage::exists($invoicedgpro->bukti_pembayaran)) {
                Storage::delete($invoicedgpro->bukti_pembayaran);
            }
            $pdfPath = $request->file('bukti_pembayaran')->store('pdfs', 'public');
            $requestData['bukti_pembayaran'] = $pdfPath;
            $requestData['status_bayar'] = 'Sudah bayar'; // Set status bayar menjadi sudah bayar setelah upload bukti
        } elseif ($request->metode_pembayaran == 'cash') {
            $requestData['bukti_pembayaran'] = 'CASH';
            $requestData['status_bayar'] = 'Sudah bayar'; // Jika menggunakan cash, status bayar tetap sudah bayar
        } else {
            // Jika bukti pembayaran tidak ada dan metode pembayaran bukan cash, status tetap "Belum bayar"
            $requestData['status_bayar'] = $request->input('status_bayar');
        }
    
        // Menangani produk dan menghitung harga total
        $productDetails = [];
        $totalPrice = 0;
    
        // Menyimpan produk dan kuantitas dari invoicedgpro sebelum diupdate
        $oldProductDetails = json_decode($invoicedgpro->product, true);
    
        if ($request->has('product_qty')) {
            foreach ($request->input('product_qty') as $productId => $newQty) {
                $product = Productech::find($productId);
    
                if ($product) {
                    // Mencari kuantitas produk lama dari invoicedgpro sebelum diupdate
                    $oldQty = isset($oldProductDetails[$productId]) ? $oldProductDetails[$productId]['qty'] : 0;
    
                    // Hitung selisih kuantitas (tetap lakukan perubahan kuantitas tanpa mempengaruhi stok)
                    $difference = $newQty - $oldQty;
    
                    // Menghitung harga per baris
                    $linePrice = $newQty * $product->harga_jual;
                    $totalPrice += $linePrice;
    
                    $productDetails[] = [
                        'id' => $productId,
                        'qty' => $newQty,
                        'price' => $product->harga_jual
                    ];
                }
            }
        }
    
        // Hitung total harga termasuk pajak
        $requestData['product'] = json_encode($productDetails); // Convert to JSON string
        $totalWithTax = $totalPrice + ($totalPrice * ($request->input('tax', 0) / 100));
        $requestData['price'] = $totalWithTax;
    
        // Update invoice
        $invoicedgpro->update($requestData);
    
        return redirect()->route('admin.invoicedgpros.index')->with('success', 'Invoice berhasil diupdate.');
    }
    
    
    
    public function show(Invoicedgpro $invoicedgpro)
    {
        abort_if(Gate::denies('dgpro_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    
        // Log the invoice ID being processed
        Log::info('Processing invoicedgpro ID: ' . $invoicedgpro->id);
    
        // Decode the product details from the stored JSON data
        $productDetails = json_decode($invoicedgpro->product, true);
        Log::info('Decoded product details: ', ['details' => $productDetails]);
    
        // If the decoding is successful and returns an array
        if (json_last_error() === JSON_ERROR_NONE && is_array($productDetails)) {
            // Retrieve product names based on the IDs from the product details
            $product_ids   = array_column($productDetails, 'id');
            $product_names = Productech::whereIn('id', $product_ids)->pluck('name', 'id')->toArray();
            Log::info('Product names: ', ['names' => $product_names]);
    
            // Add the product names to the product details
            foreach ($productDetails as &$product) {
                if (is_array($product) && isset($product['id'])) {
                    $product['name'] = $product_names[$product['id']] ?? 'Unknown';
                } else {
                    Log::warning('Invalid product format: ', ['product' => $product]);
                    $product = ['name' => 'Unknown', 'id' => null, 'qty' => null];
                }
            }
    
            $invoicedgpro->product_details = $productDetails;
        } else {
            // In case the JSON decoding failed or is not an array
            $invoicedgpro->product_details = [];
            Log::warning('Failed to decode JSON or not an array for invoicedgpro ID: ' . $invoicedgpro->id);
        }
    
        // Return the view with the invoicedgpro and its product details
        return view('admin.invoicedgpros.show', compact('invoicedgpro'));
    }
    

    public function destroy(Invoicedgpro $invoicedgpro)
    {
        abort_if(Gate::denies('dgpro_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // Hapus invoice tanpa mempengaruhi stok produk
        $invoicedgpro->delete();
    
        return back()->with('success', 'Invoice has been deleted successfully.');
    }

    public function massDestroy(Request $request)
    {
        abort_if(Gate::denies('dgpro_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $invoicedgpros = Invoicedgpro::find($request->input('ids', []));
        foreach ($invoicedgpros as $invoicedgpro) {
            // Hapus invoice tanpa mempengaruhi stok produk
            $invoicedgpro->delete();
        }
    
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
