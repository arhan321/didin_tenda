<?php

namespace App\Http\Controllers\Admin;

use Gate;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Client;
use App\Models\Product;
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
    
        // Ambil produk dan harga produk
        $products = Product::all()->pluck('name', 'id');
        $productPrices = Product::all()->pluck('price', 'id');
    
        // Ambil opsi status bayar dari array di model Order
        $statusBayarOptions = Order::STATUS_SELECT;
    
        // Default status_sewa dan status_bayar
        $defaultStatusSewa = 'Belum Selesai';  // Menggunakan enum untuk status_sewa
        $defaultStatusBayar = 'Belum bayar';   // Diambil dari array status_bayar
    
        // Ambil daftar clients dan alamat mereka
        $clients = Client::all()->pluck('nama_client', 'id');
        $clients_address = Client::all()->pluck('alamat_client', 'id');
    
        return view('admin.orders.create', compact('products', 'productPrices', 'statusBayarOptions', 'clients', 'clients_address', 'defaultStatusSewa', 'defaultStatusBayar'));
    }
    
    
    public function store(Request $request)
    {
        $requestData = $request->all();
    
        // Default status_sewa dan status_bayar
        $requestData['status_sewa'] = $request->input('status_sewa', 'Belum Selesai'); // Enum untuk status sewa
        $requestData['status_bayar'] = $request->input('status_bayar', 'Belum bayar'); // Status bayar diambil dari input atau default
    
        // Handle PDF Upload
        if ($request->hasFile('bukti_pembayaran')) {
            $pdfPath = $request->file('bukti_pembayaran')->store('pdfs', 'public');
            $requestData['bukti_pembayaran'] = $pdfPath;
        }
    
        // Handle Product Quantity and Stock Reduction
        if ($request->has('product_qty')) {
            $productDetails = [];
            $totalPrice = 0;
    
            $start = Carbon::parse($request->input('start'));
            $end = Carbon::parse($request->input('end'));
            $rentalDuration = $start->diffInMonths($end) + 1; // Calculate duration in months
    
            foreach ($request->input('product_qty') as $productId => $qty) {
                $product = Product::find($productId);
                if ($product) {
                    // Check if product has sufficient stock
                    if ($product->stock < $qty) {
                        // If stock is less than requested qty, show an error message
                        return redirect()->back()->withErrors([
                            'product_qty' => 'Stock for ' . $product->name . ' is insufficient. Available stock: ' . $product->stock . '. You requested: ' . $qty . '.'
                        ]);
                    }
    
                    // Calculate total price for the rental period
                    $productPrice = $product->price * $rentalDuration * $qty;
                    $totalPrice += $productPrice;
    
                    // Reduce stock by the quantity ordered
                    $product->stock -= $qty;
                    $product->save();
    
                    $productDetails[] = [
                        'id' => $productId,
                        'qty' => $qty,
                        'price' => $productPrice // Store calculated price for reference
                    ];
                }
            }
    
            // Store the product details and total price in the request data
            $requestData['product'] = json_encode($productDetails);
            $requestData['price'] = $totalPrice; // Store the total price in the order
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
        $productPrices = Product::pluck('price', 'id');
        
        // Ambil daftar clients
        $clients = Client::all()->pluck('nama_client', 'id');
        $clients_address = Client::all()->pluck('alamat_client', 'id');
        
        $order->product_details = collect(json_decode($order->product, true) ?: []);
        $statusBayarOptions = Order::STATUS_SELECT;
        
        return view('admin.orders.edit', compact('order', 'products', 'productPrices', 'statusBayarOptions', 'clients', 'clients_address' ));
    }

    public function update(Request $request, Order $order)
    {
        $requestData = $request->all();
    
        $now = Carbon::now();
        $end = Carbon::parse($order->end);
    
        // Set status_sewa based on the current date and end date
        if ($now->gt($end)) {
            $requestData['status_sewa'] = 'Sudah Selesai';
        } else {
            $requestData['status_sewa'] = 'Belum Selesai';
        }
    
        // Set status_bayar from the form input or keep the previous value
        $requestData['status_bayar'] = $request->input('status_bayar', $order->status_bayar);
    
        // Handle PDF Upload
        if ($request->hasFile('bukti_pembayaran')) {
            $pdfPath = $request->file('bukti_pembayaran')->store('pdfs', 'public');
            $requestData['bukti_pembayaran'] = $pdfPath;
        }
    
        // Handle Product Quantity and Stock
        if ($request->has('product_qty')) {
            $productDetails = [];
            $totalPrice = 0;
    
            $start = Carbon::parse($request->input('start'));
            $end = Carbon::parse($request->input('end'));
            $rentalDuration = $start->diffInMonths($end) + 1; // Calculate duration in months
    
            foreach ($request->input('product_qty') as $productId => $qty) {
                $product = Product::find($productId);
                if ($product) {
                    // If status_sewa was updated to 'Sudah Selesai' previously, return the stock to the product
                    if ($order->status_sewa != 'Sudah Selesai' && $requestData['status_sewa'] == 'Sudah Selesai') {
                        $product->stock += $qty;  // Return the stock
                    }
    
                    // Calculate total price for the rental period
                    $productPrice = $product->price * $rentalDuration * $qty;
                    $totalPrice += $productPrice;
    
                    // Reduce stock
                    $product->stock -= $qty;
                    $product->save();
    
                    $productDetails[] = [
                        'id' => $productId,
                        'qty' => $qty,
                        'price' => $productPrice // Store calculated price for reference
                    ];
                }
            }
    
            $requestData['product'] = json_encode($productDetails);
            $requestData['price'] = $totalPrice; // Store the total price in the order
        }
    
        // Check if status_sewa is changing to 'Sudah Selesai' and the previous state was not 'Sudah Selesai'
        if ($requestData['status_sewa'] == 'Sudah Selesai' && $order->status_sewa != 'Sudah Selesai') {
            // Return the stock to the product
            $productDetails = json_decode($order->product, true);
            foreach ($productDetails as $productDetail) {
                $product = Product::find($productDetail['id']);
                if ($product) {
                    $product->stock += $productDetail['qty'];  // Return the stock
                    $product->save();
                }
            }
        }
    
        // Update the order with the modified data
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
    
        // Restore the product stock when order is deleted
        $productDetails = json_decode($order->product, true);
        foreach ($productDetails as $productDetail) {
            $product = Product::find($productDetail['id']);
            if ($product) {
                $product->stock += $productDetail['qty'];  // Return the stock
                $product->save();
            }
        }
    
        // Delete the order
        $order->delete();
    
        return back()->with('success', 'Order has been deleted and stock has been restored.');
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