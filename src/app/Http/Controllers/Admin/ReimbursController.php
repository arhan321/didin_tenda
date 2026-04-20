<?php

namespace App\Http\Controllers\Admin;

use Gate;
use Carbon\Carbon;
use App\Models\Client;
use App\Models\Product;
use App\Models\Reimburs;
use App\Models\Monitoring;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class ReimbursController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('reimburs_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $reimburs = Reimburs::with('client')->get();

        foreach ($reimburs as $reimbur) {
            Log::info('Processing reimbur ID: ' . $reimbur->id);

            $productDetails = json_decode($reimbur->product, true);
            Log::info('Decoded product details: ', ['details' => $productDetails]);

            if (json_last_error() === JSON_ERROR_NONE && is_array($productDetails)) {
                $product_ids = array_column($productDetails, 'id');
                $product_names = Product::whereIn('id', $product_ids)->pluck('name', 'id')->toArray();
                Log::info('Product names: ', ['names' => $product_names]);

                foreach ($productDetails as &$product) {
                    if (is_array($product) && isset($product['id'])) {
                        $product['name'] = $product_names[$product['id']] ?? 'Unknown';
                    } else {
                        Log::warning('Invalid product format: ', ['product' => $product]);
                        $product = ['name' => 'Unknown', 'id' => null, 'qty' => null];
                    }
                }

                $reimbur->product_details = $productDetails;
            } else {
                $reimbur->product_details = [];
                Log::warning('Failed to decode JSON or not an array for reimbur ID: ' . $reimbur->id);
            }
        }

        return view('admin.reimburs.index', compact('reimburs'));
    }

    public function create()
    {
        abort_if(Gate::denies('reimburs_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // Ambil nama produk dan harga sewa dari tabel produk
        $products = Product::all()->pluck('name', 'id');
        $productPrices = Product::all()->pluck('harga_sewa', 'id'); // Tetap ambil harga sewa dari product

        // Ambil status pembayaran
        // $statusBayarOptions = Reimburs::STATUS_SELECT;

        // Default status_sewa dan status_bayar
        // $defaultStatusSewa = 'Belum Selesai';
        // $defaultStatusBayar = 'Belum bayar';

        // Ambil daftar clients sebagai objek lengkap, bukan pluck
        $clients = Client::all();  // Ambil data lengkap client

        // Ambil data stock outstanding dari monitoring
        $monitoringStock = Monitoring::all()->pluck('stock_outstanding', 'product_id'); // Mengambil stock dari monitoring berdasarkan product_id

        return view('admin.reimburs.create', compact(
            'products',
            'productPrices',
            // 'statusBayarOptions',
            'clients',
            // 'defaultStatusSewa',
            // 'defaultStatusBayar',
            'monitoringStock' 
        ));
   }
   public function store(Request $request)
   {
       $requestData = $request->all();
      
       // Default nilai untuk status_sewa jika tidak ada input
       $requestData['status_sewa'] = $request->input('status_sewa', 'Belum Selesai');
      
       // Handle File Upload (PDF/Gambar)
       if ($request->hasFile('bukti_struk')) {
           $file = $request->file('bukti_struk');
      
           // Cek ekstensi file untuk memastikan hanya PDF dan gambar
           $allowedExtensions = ['pdf', 'jpg', 'jpeg', 'png'];
           if (in_array($file->getClientOriginalExtension(), $allowedExtensions)) {
               // Simpan file di storage/app/simpan
               $filePath = $file->store('simpan', 'public'); // Simpan di folder "storage/app/simpan"
               $requestData['bukti_struk'] = $filePath;
           } else {
               return redirect()->back()->with('error', 'File harus berupa PDF atau gambar (jpg, jpeg, png).');
           }
       }
      
       // Handle Product Quantity dan Hitung Total Harga
       if ($request->has('product_qty')) {
           $productDetails = [];
           $totalPrice = 0;
      
           foreach ($request->input('product_qty') as $productId => $qty) {
               $product = Product::find($productId);
      
               if ($product) {
                   $linePrice = $qty * $product->harga_sewa; // Hitung harga total per produk
                   $totalPrice += $linePrice;
      
                   $productDetails[] = [
                       'id' => $productId,
                       'qty' => $qty, // Ambil kuantitas langsung dari input
                       'price' => $product->harga_sewa,
                   ];
               }
           }
      
           $requestData['product'] = json_encode($productDetails);
           $requestData['price'] = $totalPrice; // Simpan total harga
       }
      
       // Simpan ke database
       $reimbur = Reimburs::create($requestData);
      
       // Update jika ada bukti_struk
       if (isset($requestData['bukti_struk'])) {
           $reimbur->update(['bukti_struk' => $requestData['bukti_struk']]);
       }
      
       return redirect()->route('admin.reimburs.index')->with('success', 'Reimburs telah berhasil dibuat.');
   }
   
    public function edit(Reimburs $reimbur)
    {
        abort_if(Gate::denies('reimburs_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $products = Product::all();
        $productPrices = Product::pluck('harga_sewa', 'id');

        // Ambil stok dari Monitoring, bukan dari Product
        $monitoringStock = Monitoring::all()->pluck('stock_outstanding', 'product_id'); // Ambil stok dari monitoring berdasarkan product_id

        // Ambil daftar clients lengkap dengan branch dan alamat
        $clients = Client::all();

        // Jika produk pada reimbur disimpan sebagai JSON
        $reimbur->product_details = collect(json_decode($reimbur->product, true) ?: []);

        // Status pembayaran
        // $statusBayarOptions = Reimburs::STATUS_SELECT;

        return view('admin.reimburs.edit', compact('reimbur', 'products', 'productPrices', 'monitoringStock', 'clients'));
    }


    public function update(Request $request, Reimburs $reimbur)
    {
    $requestData = $request->all();

    // Admin will set the status manually
    $requestData['status_sewa'] = $request->input('status_sewa', $reimbur->status_sewa);

    // Handle PDF Upload
    if ($request->hasFile('bukti_struk')) {
        $pdfPath = $request->file('bukti_struk')->store('simpan', 'public');
        $requestData['bukti_struk'] = $pdfPath;
    }

    // Handle Product Quantity
    if ($request->has('product_qty')) {
        $productDetails = [];
        $totalPrice = 0;

        foreach ($request->input('product_qty') as $productId => $newQty) {
            $product = Product::find($productId);

            if ($product) {
                // Menghitung total harga tanpa memperbarui stok di Monitoring
                $totalPrice += $product->harga_sewa * $newQty;

                $productDetails[] = [
                    'id' => $productId,
                    'qty' => $newQty, // Terima qty langsung tanpa validasi stok
                    'price' => $product->harga_sewa // Simpan harga sewa dari Product
                ];
            }
        }

        $requestData['product'] = json_encode($productDetails);
        $requestData['price'] = $totalPrice; // Pastikan total harga dihitung dan diisi dengan benar
    }

    // Update the reimbur
    $reimbur->update($requestData);

    return redirect()->route('admin.reimburs.index')->with('success', 'Reimburs has been updated successfully.');
    }


    public function show(Reimburs $reimbur)
    {
        abort_if(Gate::denies('reimburs_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        Log::info('Processing reimbur ID: ' . $reimbur->id);

        $productDetails = json_decode($reimbur->product, true);
        Log::info('Decoded product details: ', ['details' => $productDetails]);

        if (json_last_error() === JSON_ERROR_NONE && is_array($productDetails)) {
            $product_ids = array_column($productDetails, 'id');
            $product_names = Product::whereIn('id', $product_ids)->pluck('name', 'id')->toArray();
            Log::info('Product names: ', ['names' => $product_names]);

            foreach ($productDetails as &$product) {
                if (is_array($product) && isset($product['id'])) {
                    $product['name'] = $product_names[$product['id']] ?? 'Unknown';
                } else {
                    Log::warning('Invalid product format: ', ['product' => $product]);
                    $product = ['name' => 'Unknown', 'id' => null, 'qty' => null];
                }
            }

            $reimbur->product_details = $productDetails;
        } else {
            $reimbur->product_details = [];
            Log::warning('Failed to decode JSON or not an array for reimbur ID: ' . $reimbur->id);
        }

        return view('admin.reimburs.show', compact('reimbur'));
    }

    public function destroy(Reimburs $reimbur)
    {
        abort_if(Gate::denies('reimburs_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    
        $reimbur->delete();
    
        return back()->with('success', 'Reimburs has been deleted successfully.');
    }

    public function massDestroy(Request $request)
    {
        $reimburs = Reimburs::find(request('ids'));

        foreach ($reimburs as $reimbur) {
            $reimbur->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
