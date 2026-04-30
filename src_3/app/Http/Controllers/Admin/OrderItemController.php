<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class OrderItemController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('order_item_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $orders = Order::orderBy('id', 'desc')->get();

        $orderItems = OrderItem::with('order')
            ->when($request->filled('order_id'), function ($query) use ($request) {
                $query->where('order_id', $request->order_id);
            })
            ->when($request->filled('item_type'), function ($query) use ($request) {
                $query->where('item_type', $request->item_type);
            })
            ->orderBy('id', 'desc')
            ->get();

        $itemTypes = $this->itemTypes();

        return view('admin.orderItems.index', compact('orderItems', 'orders', 'itemTypes'));
    }

    public function create(Request $request)
    {
        abort_if(Gate::denies('order_item_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $orders = Order::orderBy('id', 'desc')->get();
        $itemTypes = $this->itemTypes();
        $selectedOrderId = $request->order_id;

        return view('admin.orderItems.create', compact('orders', 'itemTypes', 'selectedOrderId'));
    }

    public function store(Request $request)
    {
        abort_if(Gate::denies('order_item_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data = $request->validate([
            'order_id'    => ['required', 'exists:orders,id'],
            'item_type'   => ['required', 'string', 'max:255'],
            'source_id'   => ['nullable', 'integer', 'min:0'],
            'name'        => ['required', 'string', 'max:255'],
            'unit'        => ['nullable', 'string', 'max:255'],
            'quantity'    => ['required', 'integer', 'min:1'],
            'price'       => ['nullable', 'integer', 'min:0'],
            'total_price' => ['nullable', 'integer', 'min:0'],
            'snapshot'    => ['nullable', 'json'],
        ]);

        $data['source_id']   = $request->source_id ?: null;
        $data['price']       = $request->price ?? 0;
        $data['total_price'] = $request->filled('total_price')
            ? $request->total_price
            : ((int) $data['quantity'] * (int) $data['price']);

        $data['snapshot'] = $request->filled('snapshot')
            ? json_decode($request->snapshot, true)
            : null;

        OrderItem::create($data);

        return redirect()->route('admin.order-items.index');
    }

    public function show(OrderItem $orderItem)
    {
        abort_if(Gate::denies('order_item_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $orderItem->load('order');

        return view('admin.orderItems.show', compact('orderItem'));
    }

    public function edit(OrderItem $orderItem)
    {
        abort_if(Gate::denies('order_item_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $orders = Order::orderBy('id', 'desc')->get();
        $itemTypes = $this->itemTypes();

        return view('admin.orderItems.edit', compact('orderItem', 'orders', 'itemTypes'));
    }

    public function update(Request $request, OrderItem $orderItem)
    {
        abort_if(Gate::denies('order_item_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data = $request->validate([
            'order_id'    => ['required', 'exists:orders,id'],
            'item_type'   => ['required', 'string', 'max:255'],
            'source_id'   => ['nullable', 'integer', 'min:0'],
            'name'        => ['required', 'string', 'max:255'],
            'unit'        => ['nullable', 'string', 'max:255'],
            'quantity'    => ['required', 'integer', 'min:1'],
            'price'       => ['nullable', 'integer', 'min:0'],
            'total_price' => ['nullable', 'integer', 'min:0'],
            'snapshot'    => ['nullable', 'json'],
        ]);

        $data['source_id']   = $request->source_id ?: null;
        $data['price']       = $request->price ?? 0;
        $data['total_price'] = $request->filled('total_price')
            ? $request->total_price
            : ((int) $data['quantity'] * (int) $data['price']);

        $data['snapshot'] = $request->filled('snapshot')
            ? json_decode($request->snapshot, true)
            : null;

        $orderItem->update($data);

        return redirect()->route('admin.order-items.index');
    }

    public function destroy(OrderItem $orderItem)
    {
        abort_if(Gate::denies('order_item_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $orderItem->delete();

        return back();
    }

    public function massDestroy(Request $request)
    {
        abort_if(Gate::denies('order_item_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $request->validate([
            'ids'   => ['required', 'array'],
            'ids.*' => ['exists:order_items,id'],
        ]);

        OrderItem::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    private function itemTypes()
    {
        return [
            'package' => 'Package',
            'custom'  => 'Custom',
            'addon'   => 'Addon',
        ];
    }
}