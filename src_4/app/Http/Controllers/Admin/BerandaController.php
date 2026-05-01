<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Models\Beranda;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class BerandaController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('beranda_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $berandas = Beranda::orderBy('id', 'desc')->get();

        return view('admin.berandas.index', compact('berandas'));
    }

    public function create()
    {
        abort_if(Gate::denies('beranda_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.berandas.create');
    }

    public function store(Request $request)
    {
        abort_if(Gate::denies('beranda_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data = $request->validate([
            'title_1'   => ['nullable', 'string', 'max:255'],
            'title_2'   => ['nullable', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string', 'max:255'],
            'image'     => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('berandas/images', 'public');
        }

        Beranda::create($data);

        return redirect()->route('admin.berandas.index');
    }

    public function show(Beranda $beranda)
    {
        abort_if(Gate::denies('beranda_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.berandas.show', compact('beranda'));
    }

    public function edit(Beranda $beranda)
    {
        abort_if(Gate::denies('beranda_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.berandas.edit', compact('beranda'));
    }

    public function update(Request $request, Beranda $beranda)
    {
        abort_if(Gate::denies('beranda_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data = $request->validate([
            'title_1'      => ['nullable', 'string', 'max:255'],
            'title_2'      => ['nullable', 'string', 'max:255'],
            'deskripsi'    => ['nullable', 'string', 'max:255'],
            'image'        => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:2048'],
            'remove_image' => ['nullable', 'boolean'],
        ]);

        unset($data['remove_image']);

        if ($request->boolean('remove_image') && $beranda->image) {
            Storage::disk('public')->delete($beranda->image);
            $data['image'] = null;
        }

        if ($request->hasFile('image')) {
            if ($beranda->image) {
                Storage::disk('public')->delete($beranda->image);
            }

            $data['image'] = $request->file('image')->store('berandas/images', 'public');
        }

        $beranda->update($data);

        return redirect()->route('admin.berandas.index');
    }

    public function destroy(Beranda $beranda)
    {
        abort_if(Gate::denies('beranda_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($beranda->image) {
            Storage::disk('public')->delete($beranda->image);
        }

        $beranda->delete();

        return back();
    }

    public function massDestroy(Request $request)
    {
        abort_if(Gate::denies('beranda_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $request->validate([
            'ids'   => ['required', 'array'],
            'ids.*' => ['exists:berandas,id'],
        ]);

        $berandas = Beranda::whereIn('id', request('ids'))->get();

        foreach ($berandas as $beranda) {
            if ($beranda->image) {
                Storage::disk('public')->delete($beranda->image);
            }

            $beranda->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}