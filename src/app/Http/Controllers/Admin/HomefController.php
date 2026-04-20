<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Models\Homef;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class HomefController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('home_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $homes = Homef::with(['media'])->get();

        return view('admin.homes.index', compact('homes'));
    }

    public function create()
    {
        abort_if(Gate::denies('home_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.homes.create');
    }

    public function store(Request $request)
    {
        $home = Homef::create($request->all());

        if ($request->input('image', false)) {
            $home->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $home->id]);
        }

        return redirect()->route('admin.homes.index');
    }

    public function edit(Homef $home)
    {
        abort_if(Gate::denies('home_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.homes.edit', compact('home'));
    }

    public function update(Request $request, Homef $home)
    {
        $home->update($request->all());

        if ($request->input('image', false)) {
            if (!$home->image || $request->input('image') !== $home->image->file_name) {
                if ($home->image) {
                    $home->image->delete();
                }
                $home->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
            }
        } elseif ($home->image) {
            $home->image->delete();
        }

        return redirect()->route('admin.homes.index');
    }

    public function show(Homef $home)
    {
        abort_if(Gate::denies('home_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.homes.show', compact('home'));
    }

    public function destroy(Homef $home)
    {
        abort_if(Gate::denies('home_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $home->delete();

        return back();
    }

    public function massDestroy(Request $request)
    {
        $homes = Homef::whereIn('id', $request->input('ids'))->get();

        foreach ($homes as $home) {
            $home->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('home_create') && Gate::denies('home_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Homef();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
