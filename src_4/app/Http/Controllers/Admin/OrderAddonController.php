<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Models\Addon;
use App\Models\Order;
use App\Models\OrderAddon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class OrderAddonController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('order_addon_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $orders = Order::orderBy('id', 'desc')->get();
        $addons = Addon::orderBy('name', 'asc')->get();

        $orderAddons = OrderAddon::with(['order', 'addon'])
            ->when($request->filled('order_id'), function ($query) use ($request) {
                $query->where('order_id', $request->order_id);
            })
            ->when($request->filled('addon_id'), function ($query) use ($request) {
                $query->where('addon_id', $request->addon_id);
            })
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.orderAddons.index', compact('orderAddons', 'orders', 'addons'));
    }

    public function create(Request $request)
    {
        abort_if(Gate::denies('order_addon_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $orders = Order::orderBy('id', 'desc')->get();
        $addons = Addon::orderBy('name', 'asc')->get();

        $selectedOrderId = $request->order_id;

        return view('admin.orderAddons.create', compact('orders', 'addons', 'selectedOrderId'));
    }

    public function store(Request $request)
    {
        abort_if(Gate::denies('order_addon_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data = $request->validate([
            'order_id'    => ['required', 'exists:orders,id'],
            'addon_id'    => ['nullable', 'exists:addons,id'],
            'name'        => ['required', 'string', 'max:255'],
            'detail'      => ['nullable', 'string', 'max:255'],
            'unit'        => ['nullable', 'string', 'max:255'],
            'quantity'    => ['required', 'integer', 'min:1'],
            'price'       => ['nullable', 'integer', 'min:0'],
            'total_price' => ['nullable', 'integer', 'min:0'],
            'snapshot'    => ['nullable', 'json'],
        ]);

        $data['addon_id']    = $request->addon_id ?: null;
        $data['price']       = $request->price ?? 0;
        $data['total_price'] = $request->filled('total_price')
            ? $request->total_price
            : ((int) $data['quantity'] * (int) $data['price']);

        $data['snapshot'] = $request->filled('snapshot')
            ? json_decode($request->snapshot, true)
            : null;

        OrderAddon::create($data);

        return redirect()->route('admin.order-addons.index');
    }

    public function show(OrderAddon $orderAddon)
    {
        abort_if(Gate::denies('order_addon_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $orderAddon->load(['order', 'addon']);

        return view('admin.orderAddons.show', compact('orderAddon'));
    }

    public function edit(OrderAddon $orderAddon)
    {
        abort_if(Gate::denies('order_addon_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $orders = Order::orderBy('id', 'desc')->get();
        $addons = Addon::orderBy('name', 'asc')->get();

        return view('admin.orderAddons.edit', compact('orderAddon', 'orders', 'addons'));
    }

    public function update(Request $request, OrderAddon $orderAddon)
    {
        abort_if(Gate::denies('order_addon_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data = $request->validate([
            'order_id'    => ['required', 'exists:orders,id'],
            'addon_id'    => ['nullable', 'exists:addons,id'],
            'name'        => ['required', 'string', 'max:255'],
            'detail'      => ['nullable', 'string', 'max:255'],
            'unit'        => ['nullable', 'string', 'max:255'],
            'quantity'    => ['required', 'integer', 'min:1'],
            'price'       => ['nullable', 'integer', 'min:0'],
            'total_price' => ['nullable', 'integer', 'min:0'],
            'snapshot'    => ['nullable', 'json'],
        ]);

        $data['addon_id']    = $request->addon_id ?: null;
        $data['price']       = $request->price ?? 0;
        $data['total_price'] = $request->filled('total_price')
            ? $request->total_price
            : ((int) $data['quantity'] * (int) $data['price']);

        $data['snapshot'] = $request->filled('snapshot')
            ? json_decode($request->snapshot, true)
            : null;

        $orderAddon->update($data);

        return redirect()->route('admin.order-addons.index');
    }

    public function destroy(OrderAddon $orderAddon)
    {
        abort_if(Gate::denies('order_addon_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $orderAddon->delete();

        return back();
    }

    public function massDestroy(Request $request)
    {
        abort_if(Gate::denies('order_addon_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $request->validate([
            'ids'   => ['required', 'array'],
            'ids.*' => ['exists:order_addons,id'],
        ]);

        OrderAddon::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}