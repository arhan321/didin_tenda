<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Models\SocialMedia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class SocialMediaController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('socialmedia_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $socialmedias = SocialMedia::with(['media'])->get();

        return view('admin.socialmedias.index', compact('socialmedias'));
    }

    public function create()
    {
        abort_if(Gate::denies('socialmedia_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.socialmedias.create');
    }

    public function store(Request $request)
    {
        $socialmedia = SocialMedia::create($request->all());

        if ($request->input('image', false)) {
            $socialmedia->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $socialmedia->id]);
        }

        return redirect()->route('admin.socialmedias.index');
    }

    public function edit(SocialMedia $socialmedia)
    {
        abort_if(Gate::denies('socialmedia_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.socialmedias.edit', compact('socialmedia'));
    }

    public function update(Request $request, SocialMedia $socialmedia)
    {
        $socialmedia->update($request->all());

        if ($request->input('image', false)) {
            if (!$socialmedia->image || $request->input('image') !== $socialmedia->image->file_name) {
                if ($socialmedia->image) {
                    $socialmedia->image->delete();
                }
                $socialmedia->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
            }
        } elseif ($socialmedia->image) {
            $socialmedia->image->delete();
        }

        return redirect()->route('admin.socialmedias.index');
    }

    public function show(SocialMedia $socialmedia)
    {
        abort_if(Gate::denies('socialmedia_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.socialmedias.show', compact('socialmedia'));
    }

    public function destroy(SocialMedia $socialmedia)
    {
        abort_if(Gate::denies('socialmedia_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $socialmedia->delete();

        return back();
    }

    public function massDestroy(Request $request)
    {
        $socialmedias = SocialMedia::whereIn('id', $request->input('ids'))->get();

        foreach ($socialmedias as $socialmedia) {
            $socialmedia->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('socialmedia_create') && Gate::denies('socialmedia_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new SocialMedia();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
