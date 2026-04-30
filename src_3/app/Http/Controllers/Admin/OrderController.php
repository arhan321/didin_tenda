<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Models\User;
use App\Models\Order;
use App\Models\Package;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('order_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $orders = Order::with(['user', 'package'])
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.orders.index', compact('orders'));
    }

    public function create()
    {
        abort_if(Gate::denies('order_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::orderBy('name')->get();
        $packages = Package::orderBy('name')->get();

        $orderTypes = $this->orderTypes();
        $statusOptions = $this->statusOptions();
        $paymentStatusOptions = $this->paymentStatusOptions();

        return view('admin.orders.create', compact(
            'users',
            'packages',
            'orderTypes',
            'statusOptions',
            'paymentStatusOptions'
        ));
    }

    public function store(Request $request)
    {
        abort_if(Gate::denies('order_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data = $request->validate([
            'invoice_number'       => ['nullable', 'string', 'max:255', 'unique:orders,invoice_number'],
            'user_id'              => ['nullable', 'exists:users,id'],
            'package_id'           => ['nullable', 'exists:packages,id'],
            'order_type'           => ['required', 'in:package,custom'],

            'customer_name'        => ['required', 'string', 'max:255'],
            'customer_phone'       => ['required', 'string', 'max:255'],
            'customer_email'       => ['nullable', 'email', 'max:255'],

            'event_date'           => ['required', 'date'],
            'event_location_name'  => ['nullable', 'string', 'max:255'],
            'event_address'        => ['nullable', 'string'],
            'event_latitude'       => ['nullable', 'numeric'],
            'event_longitude'      => ['nullable', 'numeric'],
            'distance_km'          => ['nullable', 'numeric'],
            'shipping_fee'         => ['nullable', 'integer', 'min:0'],

            'subtotal_package'     => ['nullable', 'integer', 'min:0'],
            'subtotal_custom'      => ['nullable', 'integer', 'min:0'],
            'subtotal_addons'      => ['nullable', 'integer', 'min:0'],
            'total_price'          => ['nullable', 'integer', 'min:0'],

            'status'               => ['required', 'string', 'max:255'],
            'payment_status'       => ['required', 'in:unpaid,pending,paid,expired,failed,cancelled,refunded'],

            'payment_deadline'     => ['nullable', 'date'],
            'paid_at'              => ['nullable', 'date'],
            'confirmed_at'         => ['nullable', 'date'],
            'invoice_sent_at'      => ['nullable', 'date'],
            'processed_at'         => ['nullable', 'date'],
            'completed_at'         => ['nullable', 'date'],
            'cancelled_at'         => ['nullable', 'date'],

            'cancelled_reason'     => ['nullable', 'string'],
            'notes'                => ['nullable', 'string'],
        ]);

        $data['invoice_number']   = $request->invoice_number ?: $this->generateInvoiceNumber();
        $data['user_id']          = $request->user_id ?: null;
        $data['package_id']       = $request->package_id ?: null;
        $data['shipping_fee']     = $request->shipping_fee ?? 0;
        $data['subtotal_package'] = $request->subtotal_package ?? 0;
        $data['subtotal_custom']  = $request->subtotal_custom ?? 0;
        $data['subtotal_addons']  = $request->subtotal_addons ?? 0;
        $data['total_price']      = $request->total_price ?? 0;

        Order::create($data);

        return redirect()->route('admin.orders.index');
    }

    public function show(Order $order)
    {
        abort_if(Gate::denies('order_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $order->load(['user', 'package', 'items', 'addons', 'payment', 'review']);

        return view('admin.orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        abort_if(Gate::denies('order_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::orderBy('name')->get();
        $packages = Package::orderBy('name')->get();

        $orderTypes = $this->orderTypes();
        $statusOptions = $this->statusOptions();
        $paymentStatusOptions = $this->paymentStatusOptions();

        return view('admin.orders.edit', compact(
            'order',
            'users',
            'packages',
            'orderTypes',
            'statusOptions',
            'paymentStatusOptions'
        ));
    }

    public function update(Request $request, Order $order)
    {
        abort_if(Gate::denies('order_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data = $request->validate([
            'invoice_number'       => ['required', 'string', 'max:255', 'unique:orders,invoice_number,' . $order->id],
            'user_id'              => ['nullable', 'exists:users,id'],
            'package_id'           => ['nullable', 'exists:packages,id'],
            'order_type'           => ['required', 'in:package,custom'],

            'customer_name'        => ['required', 'string', 'max:255'],
            'customer_phone'       => ['required', 'string', 'max:255'],
            'customer_email'       => ['nullable', 'email', 'max:255'],

            'event_date'           => ['required', 'date'],
            'event_location_name'  => ['nullable', 'string', 'max:255'],
            'event_address'        => ['nullable', 'string'],
            'event_latitude'       => ['nullable', 'numeric'],
            'event_longitude'      => ['nullable', 'numeric'],
            'distance_km'          => ['nullable', 'numeric'],
            'shipping_fee'         => ['nullable', 'integer', 'min:0'],

            'subtotal_package'     => ['nullable', 'integer', 'min:0'],
            'subtotal_custom'      => ['nullable', 'integer', 'min:0'],
            'subtotal_addons'      => ['nullable', 'integer', 'min:0'],
            'total_price'          => ['nullable', 'integer', 'min:0'],

            'status'               => ['required', 'string', 'max:255'],
            'payment_status'       => ['required', 'in:unpaid,pending,paid,expired,failed,cancelled,refunded'],

            'payment_deadline'     => ['nullable', 'date'],
            'paid_at'              => ['nullable', 'date'],
            'confirmed_at'         => ['nullable', 'date'],
            'invoice_sent_at'      => ['nullable', 'date'],
            'processed_at'         => ['nullable', 'date'],
            'completed_at'         => ['nullable', 'date'],
            'cancelled_at'         => ['nullable', 'date'],

            'cancelled_reason'     => ['nullable', 'string'],
            'notes'                => ['nullable', 'string'],
        ]);

        $data['user_id']          = $request->user_id ?: null;
        $data['package_id']       = $request->package_id ?: null;
        $data['shipping_fee']     = $request->shipping_fee ?? 0;
        $data['subtotal_package'] = $request->subtotal_package ?? 0;
        $data['subtotal_custom']  = $request->subtotal_custom ?? 0;
        $data['subtotal_addons']  = $request->subtotal_addons ?? 0;
        $data['total_price']      = $request->total_price ?? 0;

        $order->update($data);

        return redirect()->route('admin.orders.index');
    }

    public function destroy(Order $order)
    {
        abort_if(Gate::denies('order_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $order->delete();

        return back();
    }

    public function massDestroy(Request $request)
    {
        abort_if(Gate::denies('order_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $request->validate([
            'ids'   => ['required', 'array'],
            'ids.*' => ['exists:orders,id'],
        ]);

        Order::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    private function generateInvoiceNumber()
    {
        $prefix = 'INV-' . now()->format('Ymd') . '-';
        $number = Order::whereDate('created_at', now()->toDateString())->count() + 1;

        do {
            $invoiceNumber = $prefix . str_pad($number, 4, '0', STR_PAD_LEFT);
            $number++;
        } while (Order::where('invoice_number', $invoiceNumber)->exists());

        return $invoiceNumber;
    }

    private function orderTypes()
    {
        return [
            'package' => 'Package',
            'custom'  => 'Custom',
        ];
    }

    private function statusOptions()
    {
        return [
            'waiting_payment' => 'Waiting Payment',
            'confirmed'       => 'Confirmed',
            'processed'       => 'Processed',
            'completed'       => 'Completed',
            'cancelled'       => 'Cancelled',
        ];
    }

    private function paymentStatusOptions()
    {
        return [
            'unpaid'    => 'Unpaid',
            'pending'   => 'Pending',
            'paid'      => 'Paid',
            'expired'   => 'Expired',
            'failed'    => 'Failed',
            'cancelled' => 'Cancelled',
            'refunded'  => 'Refunded',
        ];
    }
}