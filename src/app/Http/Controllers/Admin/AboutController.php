<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Models\About;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class AboutController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('about_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $abouts = About::with(['media'])->get();

        return view('admin.abouts.index', compact('abouts'));
    }

    public function create()
    {
        abort_if(Gate::denies('about_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.abouts.create');
    }

    public function store(Request $request)
    {
        $about = About::create($request->all());

        if ($request->input('image', false)) {
            $about->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $about->id]);
        }

        return redirect()->route('admin.abouts.index');
    }

    public function edit(About $about)
    {
        abort_if(Gate::denies('about_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.abouts.edit', compact('about'));
    }

    public function update(Request $request, About $about)
    {
        $about->update($request->all());

        if ($request->input('image', false)) {
            if (!$about->image || $request->input('image') !== $about->image->file_name) {
                if ($about->image) {
                    $about->image->delete();
                }
                $about->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
            }
        } elseif ($about->image) {
            $about->image->delete();
        }

        return redirect()->route('admin.abouts.index');
    }

    public function show(About $about)
    {
        abort_if(Gate::denies('about_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.abouts.show', compact('about'));
    }

    public function destroy(About $about)
    {
        abort_if(Gate::denies('about_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $about->delete();

        return back();
    }

    public function massDestroy(Request $request)
    {
        $abouts = About::whereIn('id', $request->input('ids'))->get();

        foreach ($abouts as $about) {
            $about->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('about_create') && Gate::denies('about_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new About();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
