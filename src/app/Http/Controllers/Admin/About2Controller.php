<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Models\About2;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class About2Controller extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('about2_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $about2s = About2::with(['media'])->get();

        return view('admin.about2s.index', compact('about2s'));
    }

    public function create()
    {
        abort_if(Gate::denies('about2_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.about2s.create');
    }

    public function store(Request $request)
    {
        $about2 = About2::create($request->all());

        if ($request->input('image', false)) {
            $about2->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $about2->id]);
        }

        return redirect()->route('admin.about2s.index');
    }

    public function edit(About2 $about2)
    {
        abort_if(Gate::denies('about2_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.about2s.edit', compact('about2'));
    }

    public function update(Request $request, About2 $about2)
    {
        $about2->update($request->all());

        if ($request->input('image', false)) {
            if (!$about2->image || $request->input('image') !== $about2->image->file_name) {
                if ($about2->image) {
                    $about2->image->delete();
                }
                $about2->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
            }
        } elseif ($about2->image) {
            $about2->image->delete();
        }

        return redirect()->route('admin.about2s.index');
    }

    public function show(About2 $about2)
    {
        abort_if(Gate::denies('about2_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.about2s.show', compact('about2'));
    }

    public function destroy(About2 $about2)
    {
        abort_if(Gate::denies('about2_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $about2->delete();

        return back();
    }

    public function massDestroy(Request $request)
    {
        $about2s = About2::whereIn('id', $request->input('ids'))->get();

        foreach ($about2s as $about2) {
            $about2->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('about2_create') && Gate::denies('about2_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new About2();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
