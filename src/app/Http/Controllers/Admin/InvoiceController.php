<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\Productech;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class invoiceController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('sahabatechinvoice_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $invoices = Invoice::with(['client', 'alamat', 'cabang'])->get();  // Include 'client', 'alamat', and 'cabang' relationships

        foreach ($invoices as $invoice) {
            Log::info('Processing invoice ID: ' . $invoice->id);

            $productDetails = json_decode($invoice->product, true);
            Log::info('Decoded product details: ', ['details' => $productDetails]);

            if (json_last_error() === JSON_ERROR_NONE && is_array($productDetails)) {
                $product_ids = array_column($productDetails, 'id');
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

                $invoice->product_details = $productDetails;
            } else {
                $invoice->product_details = [];
                Log::warning('Failed to decode JSON or not an array for invoice ID: ' . $invoice->id);
            }
        }

        return view('admin.invoices.index', compact('invoices'));
    }

    public function create()
    {
        abort_if(Gate::denies('sahabatechinvoice_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    
        $products = Productech::all()->pluck('name', 'id');
        $productPrices = Productech::all()->pluck('harga_jual', 'id');
        $productStocks = Productech::all()->pluck('stock_barang', 'id'); // Ambil stock_barang dari Productech
        $clients = Client::all();  // Ambil semua data clients
        $statusBayarOptions = Invoice::STATUS_SELECT; // Ambil opsi status bayar
        $defaultStatusBayar = 'Belum bayar'; // Default status bayar
    
        return view('admin.invoices.create', compact('products', 'productPrices', 'productStocks', 'clients', 'statusBayarOptions', 'defaultStatusBayar'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'alamat_id' => 'nullable|exists:clients,id',
            'cabang_id' => 'nullable|exists:clients,id',
            'status_bayar' => 'required|string|in:Belum bayar,Sudah bayar',
            'product_qty.*' => 'required|integer|min:1',
            'bukti_pembayaran_file' => 'nullable|file|mimes:pdf|max:2048', // Untuk file PDF upload
            'start' => 'nullable|date',
            'end' => 'nullable|date|after_or_equal:start',
            'tax' => 'nullable|numeric|min:0|max:100',
        ]);
    
        $requestData = $request->all();
    
        // Menangani metode pembayaran
        if ($request->input('metode_pembayaran') == 'upload' && $request->hasFile('bukti_pembayaran_file')) {
            // Jika metode pembayaran upload dan file diunggah
            $pdfPath = $request->file('bukti_pembayaran_file')->store('pdfs', 'public');
            $requestData['bukti_pembayaran'] = $pdfPath; // Simpan path PDF ke bukti_pembayaran
        } elseif ($request->input('metode_pembayaran') == 'cash') {
            // Jika metode pembayaran cash, set nilai "CASH"
            $requestData['bukti_pembayaran'] = 'CASH';
        }
    
        // Menangani produk dan menghitung harga total
        $productDetails = [];
        $totalPrice = 0;
    
        foreach ($request->input('product_qty') as $productId => $qty) {
            $product = Productech::find($productId);
    
            if ($product) {
                // Cek jika stok cukup untuk memenuhi pesanan
                if ($product->stock_barang >= $qty) {
                    $linePrice = $qty * $product->harga_jual;
                    $totalPrice += $linePrice;
    
                    $productDetails[] = [
                        'id' => $productId,
                        'qty' => $qty,
                        'price' => $product->harga_jual
                    ];
    
                    // Kurangi stok barang setelah pesanan berhasil
                    $product->stock_barang -= $qty;
                    $product->save();
                } else {
                    // Jika stok tidak mencukupi, lempar error atau lakukan penanganan lain
                    return redirect()->back()->withErrors(['msg' => 'Stok produk ' . $product->nama_produk . ' tidak mencukupi.']);
                }
            }
        }
    
        // Hitung total harga termasuk pajak
        $requestData['product'] = json_encode($productDetails);
        $totalWithTax = $totalPrice + ($totalPrice * ($request->input('tax', 0) / 100));
        $requestData['price'] = $totalWithTax;
    
        // Simpan data invoice
        Invoice::create($requestData);
    
        return redirect()->route('admin.invoices.index')->with('success', 'Invoice successfully created.');
    }
    

    public function edit(Invoice $invoice)
    {
        abort_if(Gate::denies('sahabatechinvoice_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    
        // Ambil semua produk dari tabel Productech
        $products = Productech::all();
    
        // Ambil harga jual dari produk
        $productPrices = Productech::pluck('harga_jual', 'id');
    
        // Ambil clients dari tabel Client
        $clients = Client::all();
    
        // Ambil stok dari field `stock_barang` di tabel Productech
        $stockProduct = Productech::pluck('stock_barang', 'id');
    
        // Ambil detail produk yang disimpan dalam bentuk JSON
        $invoice->product_details = collect(json_decode($invoice->product, true) ?: []);
    
        // Ambil status bayar dari Invoice model
        $statusBayarOptions = Invoice::STATUS_SELECT;
    
        return view('admin.invoices.edit', compact('invoice', 'products', 'productPrices', 'stockProduct', 'clients', 'statusBayarOptions'));
    }
    
    public function update(Request $request, Invoice $invoice)
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
            if ($invoice->bukti_pembayaran && Storage::exists($invoice->bukti_pembayaran)) {
                Storage::delete($invoice->bukti_pembayaran);
            }
            $pdfPath = $request->file('bukti_pembayaran')->store('pdfs', 'public');
            $requestData['bukti_pembayaran'] = $pdfPath;
            $requestData['status_bayar'] = 'Belum bayar';
        } elseif ($request->metode_pembayaran == 'cash') {
            $requestData['bukti_pembayaran'] = 'CASH';
            $requestData['status_bayar'] = 'Sudah bayar';
        } else {
            $requestData['status_bayar'] = $request->input('status_bayar');
        }
    
        // Menangani produk dan menghitung harga total
        $productDetails = [];
        $totalPrice = 0;
    
        // Menyimpan produk dan kuantitas dari invoice sebelum diupdate
        $oldProductDetails = json_decode($invoice->product, true);
    
        if ($request->has('product_qty')) {
            foreach ($request->input('product_qty') as $productId => $newQty) {
                $product = Productech::find($productId);
    
                if ($product) {
                    // Mencari kuantitas produk lama dari invoice sebelum diupdate
                    $oldQty = isset($oldProductDetails[$productId]) ? $oldProductDetails[$productId]['qty'] : 0;
    
                    // Hitung selisih kuantitas
                    $difference = $newQty - $oldQty;
    
                    // Jika ada perubahan kuantitas, sesuaikan stok
                    if ($difference != 0) {
                        // Debugging untuk melihat nilai yang dihitung
                        \Log::info("Product ID: $productId, Old Qty: $oldQty, New Qty: $newQty, Difference: $difference, Available Stock: {$product->stock_barang}");
    
                        // Jika kuantitas baru lebih besar
                        if ($difference > 0) {
                            // Cek jika stok mencukupi
                            if ($product->stock_barang >= $difference) {
                                $product->stock_barang -= $difference; // Kurangi stock_barang
                            } else {
                                return redirect()->back()->withErrors(['msg' => 'Stok produk ' . $product->nama_produk . ' tidak mencukupi.']);
                            }
                        } else {
                            // Jika kuantitas baru lebih kecil, kembalikan stok
                            $product->stock_barang += abs($difference); // Tambah stock_barang
                        }
    
                        // Simpan perubahan stok
                        $product->save();
                    }
    
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
        $invoice->update($requestData);
    
        return redirect()->route('admin.invoices.index')->with('success', 'Invoice berhasil diupdate.');
    }
    
    public function show(Invoice $invoice)
    {
        abort_if(Gate::denies('sahabatechinvoice_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        Log::info('Processing invoice ID: ' . $invoice->id);

        $productDetails = json_decode($invoice->product, true);
        Log::info('Decoded product details: ', ['details' => $productDetails]);

        if (json_last_error() === JSON_ERROR_NONE && is_array($productDetails)) {
            $product_ids = array_column($productDetails, 'id');
            $product_names = Productech::whereIn('id', $product_ids)->pluck('name', 'id')->toArray();

            foreach ($productDetails as &$product) {
                $product['name'] = $product_names[$product['id']] ?? 'Unknown';
            }

            $invoice->product_details = $productDetails;
        } else {
            $invoice->product_details = [];
            Log::warning('Failed to decode JSON or not an array for invoice ID: ' . $invoice->id);
        }

        return view('admin.invoices.show', compact('invoice'));
    }

    public function destroy(Invoice $invoice)
    {
        abort_if(Gate::denies('sahabatechinvoice_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    
        // Ambil detail produk dari invoice
        $productDetails = json_decode($invoice->product, true);
    
        // Kembalikan stok barang sesuai dengan kuantitas yang ada di invoice
        foreach ($productDetails as $productDetail) {
            $product = Productech::find($productDetail['id']);
            if ($product) {
                // Kembalikan stok barang
                $product->stock_barang += $productDetail['qty'];
                $product->save();
            }
        }
    
        // Hapus invoice
        $invoice->delete();
    
        return back()->with('success', 'Invoice has been deleted successfully.');
    }

    public function massDestroy(Request $request)
    {
        $invoices = Invoice::find(request('ids'));
    
        foreach ($invoices as $invoice) {
            // Ambil detail produk dari invoice
            $productDetails = json_decode($invoice->product, true);
    
            // Kembalikan stok barang sesuai dengan kuantitas yang ada di invoice
            foreach ($productDetails as $productDetail) {
                $product = Productech::find($productDetail['id']);
                if ($product) {
                    // Kembalikan stok barang
                    $product->stock_barang += $productDetail['qty'];
                    $product->save();
                }
            }
    
            // Hapus invoice
            $invoice->delete();
        }
    
        return response(null, Response::HTTP_NO_CONTENT);
    }
    
}
