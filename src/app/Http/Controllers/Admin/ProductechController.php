<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Models\Productech;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ProductechController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('sahabatechproduct_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    
        $producteches = Productech::with(['media'])->get();
    
        return view('admin.productech.index', compact('producteches'));
    }

    public function create()
    {
        abort_if(Gate::denies('sahabatechproduct_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    
        return view('admin.productech.create');
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'nullable|string|max:255',
            'harga_beli' => 'nullable|numeric|min:0',
            'harga_jual' => 'nullable|numeric|min:0',
            'jangka_waktu' => 'nullable|string|max:255',
            'stock_barang' => 'nullable|string|max:255',
            'image' => 'nullable|file|mimes:jpg,jpeg,png',
        ]);
    
        // Create the product record in the database
        $productech = Productech::create($request->only([
            'name',
            'harga_beli',
            'harga_jual',
            'jangka_waktu',
            'stock_barang'
        ]));
    
        // If an image is uploaded, attach it to the product
        if ($request->hasFile('image')) {
            $productech->addMedia($request->file('image'))->toMediaCollection('image');
        }
    
        // If CKEditor media is uploaded, associate it with the product
        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $productech->id]);
        }
    
        // Redirect back with a success message
        return redirect()->route('admin.productech.index')->with('success', 'Productech successfully created!');
    }

    public function edit(Productech $productech)
    {
        abort_if(Gate::denies('sahabatechproduct_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    
        return view('admin.productech.edit', compact('productech'));
    }

    public function update(Request $request, Productech $productech)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'nullable|string|max:255',
            'harga_beli' => 'nullable|numeric|min:0',
            'harga_jual' => 'nullable|numeric|min:0',
            'jangka_waktu' => 'nullable|string|max:255',
            'stock_barang' => 'nullable|string|max:255',
            'image' => 'nullable|file|mimes:jpg,jpeg,png',
        ]);
    
        // Update the product record in the database
        $productech->update($request->only([
            'name',
            'harga_beli',
            'harga_jual',
            'jangka_waktu',
            'stock_barang'
        ]));
    
        // If an image is uploaded, attach it to the product
        if ($request->input('image', false)) {
            if (! $productech->image || $request->input('image') !== $productech->image->file_name) {
                if ($productech->image) {
                    $productech->image->delete();
                }
                $productech->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
            }
        } elseif ($productech->image) {
            $productech->image->delete();
        }
    
        return redirect()->route('admin.productech.index')->with('success', 'Productech successfully updated!');
    }

    public function show(Productech $productech)
    {
        abort_if(Gate::denies('sahabatechproduct_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        // Tambahkan log untuk mengecek data
        Log::info('Data productech: ', ['productech' => $productech]);
    
        return view('admin.productech.show', compact('productech'));
    }

    public function destroy(Productech $productech)
    {
        abort_if(Gate::denies('sahabatechproduct_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    
        // Perform hard delete (completely remove the product)
        $productech->forceDelete();
    
        return back()->with('success', 'Product successfully deleted.');
    }

    public function massDestroy(Request $request)
    {
        $producteches = Productech::find(request('ids'));

        foreach ($producteches as $productech) {
            $productech->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('sahabatechproduct_create') && Gate::denies('sahabatechproduct_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model = new Productech();
        $model->id = $request->input('crud_id', 0);
        $model->exists = true;
        $media = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
