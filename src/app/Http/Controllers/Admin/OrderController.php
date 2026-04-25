<?php

namespace App\Http\Controllers\Admin;

use Gate;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Client;
use App\Models\Product;
use App\Models\Monitoring;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('order_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $orders = Order::with('client')->get();

        foreach ($orders as $order) {
            Log::info('Processing order ID: ' . $order->id);

            $productDetails = json_decode($order->product, true);
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

                $order->product_details = $productDetails;
            } else {
                $order->product_details = [];
                Log::warning('Failed to decode JSON or not an array for order ID: ' . $order->id);
            }
        }

        return view('admin.orders.index', compact('orders'));
    }

    public function create()
    {
        abort_if(Gate::denies('order_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // Ambil nama produk dan harga sewa dari tabel produk
        $products = Product::all()->pluck('name', 'id');
        $productPrices = Product::all()->pluck('harga_sewa', 'id'); // Tetap ambil harga sewa dari product

        // Ambil status pembayaran
        $statusBayarOptions = Order::STATUS_SELECT;

        // Default status_sewa dan status_bayar
        $defaultStatusSewa = 'Belum Selesai';
        $defaultStatusBayar = 'Belum bayar';

        // Ambil daftar clients sebagai objek lengkap, bukan pluck
        // $clients = Client::all();  // Ambil data lengkap client

        // Ambil data stock outstanding dari monitoring
        // $monitoringStock = Monitoring::all()->pluck('stock_outstanding', 'product_id'); // Mengambil stock dari monitoring berdasarkan product_id

        return view('admin.orders.create', compact(
            'products',
            'productPrices',
            'statusBayarOptions',
            'clients',
            'defaultStatusSewa',
            'defaultStatusBayar',
            'monitoringStock' // Kirim monitoring stock ke view
        ));
    }


    public function store(Request $request)
    {
        $requestData = $request->all();

        // Admin will set the status manually, so we keep the input from the request
        $requestData['status_sewa'] = $request->input('status_sewa', 'Belum Selesai');

        // Handle PDF Upload
        if ($request->hasFile('bukti_pembayaran')) {
            $pdfPath = $request->file('bukti_pembayaran')->store('pdfs', 'public');
            $requestData['bukti_pembayaran'] = $pdfPath;
        }

        // Handle Product Quantity without Stock Reduction
        if ($request->has('product_qty')) {
            $productDetails = [];
            $totalPrice = 0; // Variable to store total price

            foreach ($request->input('product_qty') as $productId => $qty) {
                $product = Product::find($productId); // Fetch the product
                $monitoring = Monitoring::where('product_id', $productId)->first(); // Fetch monitoring data based on product ID

                if ($product && $monitoring) {
                    // We are removing the stock reduction logic, no stock adjustment happens here

                    // Calculate the total price (quantity * harga_sewa from Product)
                    $linePrice = $qty * $product->harga_sewa;
                    $totalPrice += $linePrice;

                    $productDetails[] = [
                        'id' => $productId,
                        'qty' => $qty,
                        'price' => $product->harga_sewa // Storing harga_sewa from Product as price
                    ];
                }
            }

            $requestData['product'] = json_encode($productDetails);
            $requestData['price'] = $totalPrice; // Set the total price in request data
        }

        // Save the order to the database
        $order = Order::create($requestData);

        if (isset($requestData['bukti_pembayaran'])) {
            $order->update(['bukti_pembayaran' => $requestData['bukti_pembayaran']]);
        }

        return redirect()->route('admin.orders.index')->with('success', 'Order has been created successfully.');
    }



    public function edit(Order $order)
    {
        abort_if(Gate::denies('order_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $products = Product::all();
        $productPrices = Product::pluck('harga_sewa', 'id');

        // Ambil stok dari Monitoring, bukan dari Product
        $monitoringStock = Monitoring::all()->pluck('stock_outstanding', 'product_id'); // Ambil stok dari monitoring berdasarkan product_id

        // Ambil daftar clients lengkap dengan branch dan alamat
        $clients = Client::all();

        // Jika produk pada order disimpan sebagai JSON
        $order->product_details = collect(json_decode($order->product, true) ?: []);

        // Status pembayaran
        $statusBayarOptions = Order::STATUS_SELECT;

        return view('admin.orders.edit', compact('order', 'products', 'productPrices', 'monitoringStock', 'statusBayarOptions', 'clients'));
    }


    public function update(Request $request, Order $order)
    {
        $requestData = $request->all();

        // Ambil status sewa lama sebelum diupdate
        $previousStatus = $order->status_sewa;

        // Admin will set the status manually
        $requestData['status_sewa'] = $request->input('status_sewa', $order->status_sewa);

        // Cek apakah status sewa diubah menjadi 'Sudah Selesai' sebelum tanggal end
        $endDate = new \DateTime($order->end);
        $currentDate = new \DateTime();

        if ($requestData['status_sewa'] == 'Sudah Selesai' && $currentDate < $endDate) {
            return redirect()->back()->with('status_warning', 'Status sewa tidak dapat diubah menjadi "Sudah Selesai" karena belum mencapai tanggal selesai.');
        }

        // Handle PDF Upload
        if ($request->hasFile('bukti_pembayaran')) {
            $pdfPath = $request->file('bukti_pembayaran')->store('pdfs', 'public');
            $requestData['bukti_pembayaran'] = $pdfPath;
        }

        // Handle Product Quantity without Stock Update
        if ($request->has('product_qty')) {
            $productDetails = [];
            $totalPrice = 0;

            // Ambil produk dari order sebelumnya
            $previousProductDetails = collect(json_decode($order->product, true));

            foreach ($request->input('product_qty') as $productId => $newQty) {
                $product = Product::find($productId);
                $monitoring = Monitoring::where('product_id', $productId)->first(); // Ambil data monitoring berdasarkan product_id

                if ($product && $monitoring) {
                    // Kita tidak akan memperbarui stok di sini
                    // Update harga total berdasarkan jumlah produk
                    $totalPrice += $product->harga_sewa * $newQty; // Menggunakan 'harga_sewa' dari Product

                    $productDetails[] = [
                        'id' => $productId,
                        'qty' => $newQty,
                        'price' => $product->harga_sewa // Simpan harga sewa dari Product
                    ];
                }
            }

            $requestData['product'] = json_encode($productDetails);
            $requestData['price'] = $totalPrice; // Pastikan total harga dihitung dan diisi dengan benar
        }

        // Update the order
        $order->update($requestData);

        return redirect()->route('admin.orders.index')->with('success', 'Order has been updated successfully.');
    }

    public function show(Order $order)
    {
        abort_if(Gate::denies('order_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        Log::info('Processing order ID: ' . $order->id);

        $productDetails = json_decode($order->product, true);
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

            $order->product_details = $productDetails;
        } else {
            $order->product_details = [];
            Log::warning('Failed to decode JSON or not an array for order ID: ' . $order->id);
        }

        return view('admin.orders.show', compact('order'));
    }

    public function destroy(Order $order)
    {
        abort_if(Gate::denies('order_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    
        $order->delete();
    
        return back()->with('success', 'Order has been deleted successfully.');
    }

    public function massDestroy(Request $request)
    {
        $orders = Order::find(request('ids'));

        foreach ($orders as $order) {
            $order->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
