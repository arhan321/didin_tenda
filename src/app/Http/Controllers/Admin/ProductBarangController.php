<?php

namespace App\Http\Controllers\Admin;

use Gate;
use Illuminate\Http\Request;
use App\Models\ProductBarang;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ProductBarangController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('productbarang_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    
        // Mengambil semua data
        $productbarangs = ProductBarang::with(['media'])->get();
    
        return view('admin.productbarangs.index', compact('productbarangs'));
    }

    public function create()
    {
        abort_if(Gate::denies('productbarang_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    
        return view('admin.productbarangs.create');
    }

    public function store(Request $request)
    {
        abort_if(Gate::denies('productbarang_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        // Validasi langsung di Controller
        $validatedData = $request->validate([
            'name'       => 'required|string|max:255',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'stock'      => 'required|integer', 
            'image'      => 'nullable',
        ]);

        // Buat product baru
        $productbarang = ProductBarang::create($validatedData);

        // Jika ada gambar yang diupload
        if ($request->input('image', false)) {
            $productbarang
                ->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))
                ->toMediaCollection('image');
        }

        // Jika ada CKEditor media yang diupload
        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $productbarang->id]);
        }

        return redirect()->route('admin.productbarangs.index')
            ->with('success', 'Product successfully created!');
    }

    public function edit(ProductBarang $productbarang)
    {
        abort_if(Gate::denies('productbarang_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    
        return view('admin.productbarangs.edit', compact('productbarang'));
    }

    public function update(Request $request, ProductBarang $productbarang)
    {
        abort_if(Gate::denies('productbarang_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // Validasi di dalam Controller
        $validatedData = $request->validate([
            'name'       => 'required|string|max:255',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'stock'      => 'required|integer',
            'image'      => 'nullable',
        ]);

        // Update data product
        $productbarang->update($validatedData);

        // Cek apakah ada file image baru
        if ($request->input('image', false)) {
            // Jika file gambar berbeda dengan yang sudah tersimpan, hapus yang lama
            if (!$productbarang->image || $request->input('image') !== $productbarang->image->file_name) {
                if ($productbarang->image) {
                    $productbarang->image->delete();
                }
                $productbarang
                    ->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))
                    ->toMediaCollection('image');
            }
        } elseif ($productbarang->image) {
            // Jika user mengosongkan image, hapus image lama
            $productbarang->image->delete();
        }

        return redirect()->route('admin.productbarangs.index')
            ->with('success', 'Product successfully updated!');
    }

    public function show(ProductBarang $productbarang)
    {
        abort_if(Gate::denies('productbarang_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.productbarangs.show', compact('productbarang'));
    }

    public function destroy(ProductBarang $productbarang)
    {
        abort_if(Gate::denies('productbarang_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $productbarang->delete();

        return back()->with('success', 'Product successfully deleted!');
    }

    public function massDestroy(Request $request)
    {
        abort_if(Gate::denies('productbarang_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // Validasi ID yang dikirim (array)
        $validatedData = $request->validate([
            'ids'   => 'required|array',
            'ids.*' => 'exists:product_barangs,id',
        ]);

        // Hapus semuanya
        $productbarangs = ProductBarang::whereIn('id', $validatedData['ids'])->get();
        foreach ($productbarangs as $productbarang) {
            $productbarang->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(
            Gate::denies('productbarang_create') && Gate::denies('productbarang_edit'),
            Response::HTTP_FORBIDDEN,
            '403 Forbidden'
        );

        $productbarang         = new ProductBarang();
        $productbarang->id     = $request->input('crud_id', 0);
        $productbarang->exists = true;

        $media = $productbarang
            ->addMediaFromRequest('upload')
            ->toMediaCollection('ck-media');

        return response()->json([
            'id'  => $media->id,
            'url' => $media->getUrl()
        ], Response::HTTP_CREATED);
    }
}
