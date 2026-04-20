<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Models\Clientf;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ClientfController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('clientf_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $clientfs = Clientf::with(['media'])->get();

        return view('admin.clientfs.index', compact('clientfs'));
    }

    public function create()
    {
        abort_if(Gate::denies('clientf_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.clientfs.create');
    }

    public function store(Request $request)
    {
        $clientf = Clientf::create($request->all());

        if ($request->input('image', false)) {
            $clientf->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $clientf->id]);
        }

        return redirect()->route('admin.clientfs.index');
    }

    public function edit(Clientf $clientf)
    {
        abort_if(Gate::denies('clientf_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.clientfs.edit', compact('clientf'));
    }

    public function update(Request $request, Clientf $clientf)
    {
        $clientf->update($request->all());

        if ($request->input('image', false)) {
            if (!$clientf->image || $request->input('image') !== $clientf->image->file_name) {
                if ($clientf->image) {
                    $clientf->image->delete();
                }
                $clientf->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
            }
        } elseif ($clientf->image) {
            $clientf->image->delete();
        }

        return redirect()->route('admin.clientfs.index');
    }

    public function show(Clientf $clientf)
    {
        abort_if(Gate::denies('clientf_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.clientfs.show', compact('clientf'));
    }

    public function destroy(Clientf $clientf)
    {
        abort_if(Gate::denies('clientf_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $clientf->delete();

        return back();
    }

    public function massDestroy(Request $request)
    {
        $clientfs = Clientf::whereIn('id', $request->input('ids'))->get();

        foreach ($clientfs as $clientf) {
            $clientf->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('clientf_create') && Gate::denies('clientf_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Clientf();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
