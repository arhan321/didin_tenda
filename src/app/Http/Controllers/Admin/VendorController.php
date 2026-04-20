<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Models\Vendor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class VendorController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {   
        abort_if(Gate::denies('vendor_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $vendors = Vendor::with(['media'])->get();

        return view('admin.vendors.index', compact('vendors'));
    }

    public function create()
    {
        abort_if(Gate::denies('vendor_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.vendors.create');
    }

    public function store(Request $request)
    {
        // Validasi manual di dalam controller
        $request->validate([
            'nama_vendor' => 'required|string|max:255',
            'alamat_vendor' => 'nullable|string|max:255',
        ]);

        // Proses penyimpanan vendor
        $vendor = Vendor::create($request->all());

        if ($request->input('image', false)) {
            $vendor->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $vendor->id]);
        }

        return redirect()->route('admin.vendors.index');
    }

    public function edit(Vendor $vendor)
    {
        abort_if(Gate::denies('vendor_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.vendors.edit', compact('vendor'));
    }

    public function update(Request $request, Vendor $vendor)
    {
        // Validasi manual di dalam controller
        $request->validate([
            'nama_vendor' => 'required|string|max:255',
            'alamat_vendor' => 'nullable|string|max:255',
        ]);

        // Proses update vendor
        $vendor->update($request->all());

        if ($request->input('image', false)) {
            if (! $vendor->image || $request->input('image') !== $vendor->image->file_name) {
                if ($vendor->image) {
                    $vendor->image->delete();
                }
                $vendor->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
            }
        } elseif ($vendor->image) {
            $vendor->image->delete();
        }

        return redirect()->route('admin.vendors.index');
    }

    public function show(Vendor $vendor)
    {
        abort_if(Gate::denies('vendor_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.vendors.show', compact('vendor'));
    }

    public function destroy(Vendor $vendor)
    {
        abort_if(Gate::denies('vendor_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $vendor->delete();

        return back();
    }

    public function massDestroy(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:vendors,id',
        ]);

        $vendors = Vendor::find($request->input('ids'));

        foreach ($vendors as $vendor) {
            $vendor->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
