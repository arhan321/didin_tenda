<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Models\Package;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class PackagesController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('package_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $packages = Package::orderBy('sort_order', 'asc')
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.packages.index', compact('packages'));
    }

    public function create()
    {
        abort_if(Gate::denies('package_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.packages.create');
    }

    public function store(Request $request)
    {
        abort_if(Gate::denies('package_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data = $request->validate([
            'name'              => ['required', 'string', 'max:255'],
            'slug'              => ['required', 'string', 'max:255', 'unique:packages,slug'],
            'type'              => ['required', 'in:fixed,custom'],
            'short_description' => ['nullable', 'string', 'max:255'],
            'description'       => ['nullable', 'string'],
            'price'             => ['nullable', 'integer', 'min:0'],
            'price_unit'        => ['nullable', 'string', 'max:255'],
            'main_image'        => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:2048'],
            'images'            => ['nullable', 'array'],
            'images.*'          => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:2048'],
            'color'             => ['nullable', 'string', 'max:255'],
            'badge'             => ['nullable', 'string', 'max:255'],
            'is_popular'        => ['nullable', 'boolean'],
            'is_active'         => ['nullable', 'boolean'],
            'sort_order'        => ['nullable', 'integer', 'min:0'],
        ]);

        $data['slug']       = Str::slug($request->slug);
        $data['price']      = $request->price ?? 0;
        $data['price_unit'] = $request->price_unit ?? 'paket';
        $data['sort_order'] = $request->sort_order ?? 0;
        $data['is_popular'] = $request->has('is_popular');
        $data['is_active']  = $request->has('is_active');

        if ($request->hasFile('main_image')) {
            $data['main_image'] = $request->file('main_image')->store('packages/main-images', 'public');
        }

        $images = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $images[] = $image->store('packages/images', 'public');
            }
        }

        $data['images'] = count($images) ? $images : null;

        Package::create($data);

        return redirect()->route('admin.packages.index');
    }

    public function edit(Package $package)
    {
        abort_if(Gate::denies('package_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.packages.edit', compact('package'));
    }

    public function update(Request $request, Package $package)
    {
        abort_if(Gate::denies('package_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data = $request->validate([
            'name'              => ['required', 'string', 'max:255'],
            'slug'              => [
                'required',
                'string',
                'max:255',
                Rule::unique('packages', 'slug')->ignore($package->id),
            ],
            'type'              => ['required', 'in:fixed,custom'],
            'short_description' => ['nullable', 'string', 'max:255'],
            'description'       => ['nullable', 'string'],
            'price'             => ['nullable', 'integer', 'min:0'],
            'price_unit'        => ['nullable', 'string', 'max:255'],
            'main_image'        => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:2048'],
            'images'            => ['nullable', 'array'],
            'images.*'          => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:2048'],
            'remove_main_image' => ['nullable', 'boolean'],
            'remove_images'     => ['nullable', 'array'],
            'remove_images.*'   => ['nullable', 'string'],
            'color'             => ['nullable', 'string', 'max:255'],
            'badge'             => ['nullable', 'string', 'max:255'],
            'is_popular'        => ['nullable', 'boolean'],
            'is_active'         => ['nullable', 'boolean'],
            'sort_order'        => ['nullable', 'integer', 'min:0'],
        ]);

        $data['slug']       = Str::slug($request->slug);
        $data['price']      = $request->price ?? 0;
        $data['price_unit'] = $request->price_unit ?? 'paket';
        $data['sort_order'] = $request->sort_order ?? 0;
        $data['is_popular'] = $request->has('is_popular');
        $data['is_active']  = $request->has('is_active');

        if ($request->boolean('remove_main_image') && $package->main_image) {
            Storage::disk('public')->delete($package->main_image);
            $data['main_image'] = null;
        }

        if ($request->hasFile('main_image')) {
            if ($package->main_image) {
                Storage::disk('public')->delete($package->main_image);
            }

            $data['main_image'] = $request->file('main_image')->store('packages/main-images', 'public');
        }

        $images = $package->images ?? [];

        if ($request->filled('remove_images')) {
            foreach ($request->remove_images as $removeImage) {
                Storage::disk('public')->delete($removeImage);
            }

            $images = array_values(array_diff($images, $request->remove_images));
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $images[] = $image->store('packages/images', 'public');
            }
        }

        $data['images'] = count($images) ? $images : null;

        $package->update($data);

        return redirect()->route('admin.packages.index');
    }

    public function show(Package $package)
    {
        abort_if(Gate::denies('package_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $package->load([
            'items' => function ($query) {
                $query->orderBy('sort_order', 'asc')->orderBy('id', 'asc');
            }
        ]);

        return view('admin.packages.show', compact('package'));
    }

    public function destroy(Package $package)
    {
        abort_if(Gate::denies('package_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($package->main_image) {
            Storage::disk('public')->delete($package->main_image);
        }

        if ($package->images) {
            foreach ($package->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $package->delete();

        return back();
    }

    public function massDestroy(Request $request)
    {
        abort_if(Gate::denies('package_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $request->validate([
            'ids'   => ['required', 'array'],
            'ids.*' => ['exists:packages,id'],
        ]);

        $packages = Package::whereIn('id', request('ids'))->get();

        foreach ($packages as $package) {
            if ($package->main_image) {
                Storage::disk('public')->delete($package->main_image);
            }

            if ($package->images) {
                foreach ($package->images as $image) {
                    Storage::disk('public')->delete($image);
                }
            }

            $package->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}