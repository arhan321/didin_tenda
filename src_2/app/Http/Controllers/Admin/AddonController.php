<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Models\Addon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class AddonController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('addon_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $addons = Addon::orderBy('sort_order', 'asc')
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.addons.index', compact('addons'));
    }

    public function create()
    {
        abort_if(Gate::denies('addon_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.addons.create');
    }

    public function store(Request $request)
    {
        abort_if(Gate::denies('addon_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data = $request->validate([
            'name'              => ['required', 'string', 'max:255'],
            'slug'              => ['nullable', 'string', 'max:255'],
            'detail'            => ['nullable', 'string', 'max:255'],
            'price'             => ['nullable', 'integer', 'min:0'],
            'unit'              => ['nullable', 'string', 'max:255'],
            'is_quantity_based' => ['nullable', 'boolean'],
            'stock'             => ['nullable', 'integer', 'min:0'],
            'image'             => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:2048'],
            'icon'              => ['nullable', 'string', 'max:255'],
            'is_active'         => ['nullable', 'boolean'],
            'sort_order'        => ['nullable', 'integer', 'min:0'],
        ]);

        $data['slug']              = $this->generateUniqueSlug($request->name);
        $data['price']             = $request->price ?? 0;
        $data['unit']              = $request->unit ?? 'pcs';
        $data['stock']             = $request->stock ?: null;
        $data['is_quantity_based'] = $request->has('is_quantity_based');
        $data['is_active']         = $request->has('is_active');
        $data['sort_order']        = $request->sort_order ?? 0;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('addons/images', 'public');
        }

        Addon::create($data);

        return redirect()->route('admin.addons.index');
    }

    public function show(Addon $addon)
    {
        abort_if(Gate::denies('addon_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.addons.show', compact('addon'));
    }

    public function edit(Addon $addon)
    {
        abort_if(Gate::denies('addon_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.addons.edit', compact('addon'));
    }

    public function update(Request $request, Addon $addon)
    {
        abort_if(Gate::denies('addon_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data = $request->validate([
            'name'              => ['required', 'string', 'max:255'],
            'slug'              => ['nullable', 'string', 'max:255'],
            'detail'            => ['nullable', 'string', 'max:255'],
            'price'             => ['nullable', 'integer', 'min:0'],
            'unit'              => ['nullable', 'string', 'max:255'],
            'is_quantity_based' => ['nullable', 'boolean'],
            'stock'             => ['nullable', 'integer', 'min:0'],
            'image'             => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:2048'],
            'remove_image'      => ['nullable', 'boolean'],
            'icon'              => ['nullable', 'string', 'max:255'],
            'is_active'         => ['nullable', 'boolean'],
            'sort_order'        => ['nullable', 'integer', 'min:0'],
        ]);

        $data['slug']              = $this->generateUniqueSlug($request->name, $addon->id);
        $data['price']             = $request->price ?? 0;
        $data['unit']              = $request->unit ?? 'pcs';
        $data['stock']             = $request->stock ?: null;
        $data['is_quantity_based'] = $request->has('is_quantity_based');
        $data['is_active']         = $request->has('is_active');
        $data['sort_order']        = $request->sort_order ?? 0;

        if ($request->boolean('remove_image') && $addon->image) {
            Storage::disk('public')->delete($addon->image);
            $data['image'] = null;
        }

        if ($request->hasFile('image')) {
            if ($addon->image) {
                Storage::disk('public')->delete($addon->image);
            }

            $data['image'] = $request->file('image')->store('addons/images', 'public');
        }

        $addon->update($data);

        return redirect()->route('admin.addons.index');
    }

    public function destroy(Addon $addon)
    {
        abort_if(Gate::denies('addon_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($addon->image) {
            Storage::disk('public')->delete($addon->image);
        }

        $addon->delete();

        return back();
    }

    public function massDestroy(Request $request)
    {
        abort_if(Gate::denies('addon_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $request->validate([
            'ids'   => ['required', 'array'],
            'ids.*' => ['exists:addons,id'],
        ]);

        $addons = Addon::whereIn('id', request('ids'))->get();

        foreach ($addons as $addon) {
            if ($addon->image) {
                Storage::disk('public')->delete($addon->image);
            }

            $addon->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    private function generateUniqueSlug($name, $ignoreId = null)
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $counter = 1;

        while (
            Addon::where('slug', $slug)
                ->when($ignoreId, function ($query) use ($ignoreId) {
                    return $query->where('id', '!=', $ignoreId);
                })
                ->exists()
        ) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}