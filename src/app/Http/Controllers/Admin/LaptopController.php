<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Models\Laptop;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class LaptopController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('laptop_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $laptops = Laptop::with(['media'])->get();

        return view('admin.laptops.index', compact('laptops'));
    }

    public function create()
    {
        abort_if(Gate::denies('laptop_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.laptops.create');
    }

    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'nama_user'    => 'nullable|string',
            'type_laptop'  => 'nullable|string',
            'sn_laptop'    => 'nullable|string',
            'tahun_laptop' => 'nullable|string',
            'garansi'      => 'nullable|string',
            'charger'      => 'nullable|string',
            'tas'          => 'nullable|string',
            'cabang'       => 'nullable|string',
            'bisnis_unit'  => 'nullable|string',
        ]);

        // Store the laptop
        $laptop = Laptop::create($request->all());

        if ($request->input('image', false)) {
            $laptop->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $laptop->id]);
        }

        return redirect()->route('admin.laptops.index');
    }

    public function edit(Laptop $laptop)
    {
        abort_if(Gate::denies('laptop_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.laptops.edit', compact('laptop'));
    }

    public function update(Request $request, Laptop $laptop)
    {
        // Validation
        $request->validate([
            'nama_user'    => 'nullable|string',
            'type_laptop'  => 'nullable|string',
            'sn_laptop'    => 'nullable|string',
            'tahun_laptop' => 'nullable|string',
            'garansi'      => 'nullable|string',
            'charger'      => 'nullable|string',
            'tas'          => 'nullable|string',
            'cabang'       => 'nullable|string',
            'bisnis_unit'  => 'nullable|string',
        ]);

        // Update the laptop
        $laptop->update($request->all());

        if ($request->input('image', false)) {
            if (!$laptop->image || $request->input('image') !== $laptop->image->file_name) {
                if ($laptop->image) {
                    $laptop->image->delete();
                }
                $laptop->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
            }
        } elseif ($laptop->image) {
            $laptop->image->delete();
        }

        return redirect()->route('admin.laptops.index');
    }

    public function show(Laptop $laptop)
    {
        abort_if(Gate::denies('laptop_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.laptops.show', compact('laptop'));
    }

    public function destroy(Laptop $laptop)
    {
        abort_if(Gate::denies('laptop_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $laptop->delete();

        return back();
    }

    public function massDestroy(Request $request)
    {
        $request->validate(['ids' => 'required|array']);
        $laptops = Laptop::find($request->input('ids'));

        foreach ($laptops as $laptop) {
            $laptop->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('laptop_create') && Gate::denies('laptop_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Laptop();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
