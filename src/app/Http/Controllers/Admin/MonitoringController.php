<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Models\Client;
use App\Models\Vendor;
use App\Models\Product;
use App\Models\Monitoring;
use Illuminate\Http\Request;
use App\Models\CategoryProduct;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MonitoringController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {   
        abort_if(Gate::denies('monitoring_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // Mengambil semua monitoring data dengan relasi media
        $monitoring = Monitoring::with(['product', 'category', 'vendor'])->get();

        return view('admin.monitorings.index', compact('monitoring'));
    }

    public function create()
    {
        abort_if(Gate::denies('monitoring_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    
        // Mengambil semua data produk, clients, kategori produk, dan vendor
        $products = Product::all(); // Jangan gunakan pluck agar tetap objek
        // $clients = Client::all();   // Ambil semua clients sebagai objek, bukan pluck
        $categories = CategoryProduct::all(); // Jangan gunakan pluck
        $vendors = Vendor::all();   // Jangan gunakan pluck
    
        return view('admin.monitorings.create', compact('products','categories', 'vendors'));
    }

    public function store(Request $request)
    {
        abort_if(Gate::denies('monitoring_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // Validasi data yang masuk
        $request->validate([
            'product_id' => 'required|exists:products,id',
            // 'nama_client' => 'required|exists:clients,id',
            // 'branch_client' => 'required|exists:clients,id',
            // 'alamat_client' => 'required|exists:clients,id',
            'category_id' => 'nullable|exists:category_products,id',
            'vendor_id' => 'nullable|exists:vendors,id',
            'stock_awal' => 'nullable|numeric',
            'stock_outstanding' => 'nullable|numeric',
        ]);

        // Simpan monitoring baru
        $monitoring = Monitoring::create($request->all());

        // Penanganan media untuk gambar
        if ($request->input('image', false)) {
            $monitoring->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $monitoring->id]);
        }

        return redirect()->route('admin.monitorings.index');
    }

    public function edit(Monitoring $monitoring)
    {
        abort_if(Gate::denies('monitoring_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $products = Product::all()->pluck('name', 'id');
        // $clients = Client::all();
        $categories = CategoryProduct::all()->pluck('name', 'id');
        $vendors = Vendor::all()->pluck('nama_vendor', 'id');

        return view('admin.monitorings.edit', compact('monitoring', 'products', 'categories', 'vendors'));
    }

    public function update(Request $request, Monitoring $monitoring)
    {
        abort_if(Gate::denies('monitoring_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // Validasi data yang masuk
        $request->validate([
            'product_id' => 'required|exists:products,id',
            // 'nama_client' => 'nullable|exists:clients,id',
            // 'branch_client' => 'nullable|exists:clients,id',
            // 'alamat_client' => 'nullable|exists:clients,id',
            'category_id' => 'nullable|exists:category_products,id',
            'vendor_id' => 'nullable|exists:vendors,id',
            'stock_awal' => 'nullable|numeric',
            'stock_outstanding' => 'nullable|numeric',
        ]);

        // Update data monitoring
        $monitoring->update($request->all());

        // Penanganan media untuk gambar
        if ($request->input('image', false)) {
            if (! $monitoring->image || $request->input('image') !== $monitoring->image->file_name) {
                if ($monitoring->image) {
                    $monitoring->image->delete();
                }
                $monitoring->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
            }
        } elseif ($monitoring->image) {
            $monitoring->image->delete();
        }

        return redirect()->route('admin.monitorings.index');
    }

    public function show(Monitoring $monitoring)
    {
        abort_if(Gate::denies('monitoring_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // Mengambil data monitoring beserta relasi
        $monitoring = $monitoring->load(['product', 'category', 'vendor']);

        return view('admin.monitorings.show', compact('monitoring'));
    }

    public function destroy(Monitoring $monitoring)
    {
        abort_if(Gate::denies('monitoring_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $monitoring->delete();

        return back();
    }

    public function massDestroy(Request $request)
    {
        $monitorings = Monitoring::find(request('ids'));

        foreach ($monitorings as $monitoring) {
            $monitoring->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('monitoring_create') && Gate::denies('monitoring_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model = new Monitoring();
        $model->id = $request->input('crud_id', 0);
        $model->exists = true;
        $media = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
