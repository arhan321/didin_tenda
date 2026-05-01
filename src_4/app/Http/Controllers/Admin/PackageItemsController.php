<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Models\Package;
use App\Models\PackageItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class PackageItemsController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('package_item_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $packages = Package::orderBy('name', 'asc')->get();

        $packageItems = PackageItem::with('package')
            ->when($request->filled('package_id'), function ($query) use ($request) {
                $query->where('package_id', $request->package_id);
            })
            ->orderBy('package_id', 'asc')
            ->orderBy('sort_order', 'asc')
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.packageItems.index', compact('packageItems', 'packages'));
    }

    public function create(Request $request)
    {
        abort_if(Gate::denies('package_item_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $packages = Package::orderBy('name', 'asc')->get();
        $selectedPackageId = $request->package_id;

        return view('admin.packageItems.create', compact('packages', 'selectedPackageId'));
    }

    public function store(Request $request)
    {
        abort_if(Gate::denies('package_item_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data = $request->validate([
            'package_id'  => ['required', 'exists:packages,id'],
            'name'        => ['required', 'string', 'max:255'],
            'quantity'    => ['nullable', 'integer', 'min:0'],
            'unit'        => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'sort_order'  => ['nullable', 'integer', 'min:0'],
            'is_active'   => ['nullable', 'boolean'],
        ]);

        $data['quantity']   = $request->quantity ?: null;
        $data['sort_order'] = $request->sort_order ?? 0;
        $data['is_active']  = $request->has('is_active');

        PackageItem::create($data);

        return redirect()->route('admin.package-items.index');
    }

    public function show(PackageItem $packageItem)
    {
        abort_if(Gate::denies('package_item_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $packageItem->load('package');

        return view('admin.packageItems.show', compact('packageItem'));
    }

    public function edit(PackageItem $packageItem)
    {
        abort_if(Gate::denies('package_item_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $packages = Package::orderBy('name', 'asc')->get();

        return view('admin.packageItems.edit', compact('packageItem', 'packages'));
    }

    public function update(Request $request, PackageItem $packageItem)
    {
        abort_if(Gate::denies('package_item_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data = $request->validate([
            'package_id'  => ['required', 'exists:packages,id'],
            'name'        => ['required', 'string', 'max:255'],
            'quantity'    => ['nullable', 'integer', 'min:0'],
            'unit'        => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'sort_order'  => ['nullable', 'integer', 'min:0'],
            'is_active'   => ['nullable', 'boolean'],
        ]);

        $data['quantity']   = $request->quantity ?: null;
        $data['sort_order'] = $request->sort_order ?? 0;
        $data['is_active']  = $request->has('is_active');

        $packageItem->update($data);

        return redirect()->route('admin.package-items.index');
    }

    public function destroy(PackageItem $packageItem)
    {
        abort_if(Gate::denies('package_item_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $packageItem->delete();

        return back();
    }

    public function massDestroy(Request $request)
    {
        abort_if(Gate::denies('package_item_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $request->validate([
            'ids'   => ['required', 'array'],
            'ids.*' => ['exists:package_items,id'],
        ]);

        PackageItem::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}