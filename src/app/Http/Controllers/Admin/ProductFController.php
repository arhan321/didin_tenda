<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Models\ProductF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ProductFController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('productf_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $productfs = ProductF::with(['media'])->get();

        return view('admin.productfs.index', compact('productfs'));
    }

    public function create()
    {
        abort_if(Gate::denies('productf_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.productfs.create');
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'title_1' => 'nullable|string|max:255',
            'title_2' => 'nullable|string|max:255',
            'category' => 'nullable|string|in:laptop,komputer,mesin_fotocopy',
            // 'image' => 'nullable|image|max:2048', // Jika gambar wajib
        ]);

        // Buat produk
        $productf = ProductF::create($request->all());

        // Menambahkan gambar jika ada
        if ($request->input('image', false)) {
            $productf->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
        }

        // Memperbarui media yang telah dipilih
        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $productf->id]);
        }

        return redirect()->route('admin.productfs.index')->with('success', 'Product created successfully.');
    }

    public function edit(ProductF $productf)
    {
        abort_if(Gate::denies('productf_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.productfs.edit', compact('productf'));
    }

    public function update(Request $request, ProductF $productf)
    {
        // Validasi input
        $request->validate([
            'title_1' => 'nullable|string|max:255',
            'title_2' => 'nullable|string|max:255',
            'category' => 'nullable|string|in:laptop,komputer,mesin_fotocopy',
            // 'image' => 'nullable|image|max:2048', // Gambar mungkin tidak wajib
        ]);

        // Memperbarui produk
        $productf->update($request->all());

        // Menangani penggantian gambar
        if ($request->input('image', false)) {
            if (!$productf->image || $request->input('image') !== $productf->image->file_name) {
                if ($productf->image) {
                    $productf->image->delete();
                }
                $productf->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
            }
        } elseif ($productf->image) {
            $productf->image->delete();
        }

        return redirect()->route('admin.productfs.index')->with('success', 'Product updated successfully.');
    }

    public function show(ProductF $productf)
    {
        abort_if(Gate::denies('productf_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.productfs.show', compact('productf'));
    }

    public function destroy(ProductF $productf)
    {
        abort_if(Gate::denies('productf_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $productf->delete();

        return back()->with('success', 'Product deleted successfully.');
    }

    public function massDestroy(Request $request)
    {
        abort_if(Gate::denies('productf_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $productfs = ProductF::whereIn('id', $request->input('ids'))->get();

        foreach ($productfs as $productf) {
            $productf->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('productf_create') && Gate::denies('productf_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new ProductF();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
