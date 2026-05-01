<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Models\CustomItem;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class CustomItemController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('custom_item_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $customItems = CustomItem::orderBy('sort_order', 'asc')
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.customItems.index', compact('customItems'));
    }

    public function create()
    {
        abort_if(Gate::denies('custom_item_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.customItems.create');
    }

    public function store(Request $request)
    {
        abort_if(Gate::denies('custom_item_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data = $request->validate([
            'name'         => ['required', 'string', 'max:255'],
            'slug'         => ['nullable', 'string', 'max:255'],
            'description'  => ['nullable', 'string', 'max:255'],
            'price'        => ['nullable', 'integer', 'min:0'],
            'unit'         => ['nullable', 'string', 'max:255'],
            'min_quantity' => ['nullable', 'integer', 'min:0'],
            'max_quantity' => ['nullable', 'integer', 'min:0'],
            'image'        => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:2048'],
            'icon'         => ['nullable', 'string', 'max:255'],
            'is_active'    => ['nullable', 'boolean'],
            'sort_order'   => ['nullable', 'integer', 'min:0'],
        ]);

        $data['slug']         = $this->generateUniqueSlug($request->name);
        $data['price']        = $request->price ?? 0;
        $data['unit']         = $request->unit ?? 'pcs';
        $data['min_quantity'] = $request->min_quantity ?? 0;
        $data['max_quantity'] = $request->max_quantity ?: null;
        $data['is_active']    = $request->has('is_active');
        $data['sort_order']   = $request->sort_order ?? 0;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('custom-items/images', 'public');
        }

        CustomItem::create($data);

        return redirect()->route('admin.custom-items.index');
    }

    public function show(CustomItem $customItem)
    {
        abort_if(Gate::denies('custom_item_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.customItems.show', compact('customItem'));
    }

    public function edit(CustomItem $customItem)
    {
        abort_if(Gate::denies('custom_item_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.customItems.edit', compact('customItem'));
    }

    public function update(Request $request, CustomItem $customItem)
    {
        abort_if(Gate::denies('custom_item_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data = $request->validate([
            'name'         => ['required', 'string', 'max:255'],
            'slug'         => ['nullable', 'string', 'max:255'],
            'description'  => ['nullable', 'string', 'max:255'],
            'price'        => ['nullable', 'integer', 'min:0'],
            'unit'         => ['nullable', 'string', 'max:255'],
            'min_quantity' => ['nullable', 'integer', 'min:0'],
            'max_quantity' => ['nullable', 'integer', 'min:0'],
            'image'        => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:2048'],
            'remove_image' => ['nullable', 'boolean'],
            'icon'         => ['nullable', 'string', 'max:255'],
            'is_active'    => ['nullable', 'boolean'],
            'sort_order'   => ['nullable', 'integer', 'min:0'],
        ]);

        unset($data['remove_image']);

        $data['slug']         = $this->generateUniqueSlug($request->name, $customItem->id);
        $data['price']        = $request->price ?? 0;
        $data['unit']         = $request->unit ?? 'pcs';
        $data['min_quantity'] = $request->min_quantity ?? 0;
        $data['max_quantity'] = $request->max_quantity ?: null;
        $data['is_active']    = $request->has('is_active');
        $data['sort_order']   = $request->sort_order ?? 0;

        if ($request->boolean('remove_image') && $customItem->image) {
            Storage::disk('public')->delete($customItem->image);
            $data['image'] = null;
        }

        if ($request->hasFile('image')) {
            if ($customItem->image) {
                Storage::disk('public')->delete($customItem->image);
            }

            $data['image'] = $request->file('image')->store('custom-items/images', 'public');
        }

        $customItem->update($data);

        return redirect()->route('admin.custom-items.index');
    }

    public function destroy(CustomItem $customItem)
    {
        abort_if(Gate::denies('custom_item_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($customItem->image) {
            Storage::disk('public')->delete($customItem->image);
        }

        $customItem->delete();

        return back();
    }

    public function massDestroy(Request $request)
    {
        abort_if(Gate::denies('custom_item_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $request->validate([
            'ids'   => ['required', 'array'],
            'ids.*' => ['exists:custom_items,id'],
        ]);

        $customItems = CustomItem::whereIn('id', request('ids'))->get();

        foreach ($customItems as $customItem) {
            if ($customItem->image) {
                Storage::disk('public')->delete($customItem->image);
            }

            $customItem->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    private function generateUniqueSlug($name, $ignoreId = null)
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $counter = 1;

        while (
            CustomItem::where('slug', $slug)
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