@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Detail Order
    </div>

    <div class="card-body">
        <div class="form-group">
            <a class="btn btn-default" href="{{ route('admin.orders.index') }}">
                Back to list
            </a>
        </div>

        <table class="table table-bordered table-striped">
            <tbody>
                <tr><th>ID</th><td>{{ $order->id }}</td></tr>
                <tr><th>Invoice</th><td>{{ $order->invoice_number }}</td></tr>
                <tr><th>User</th><td>{{ $order->user->name ?? '-' }}</td></tr>
                <tr><th>Package</th><td>{{ $order->package->name ?? '-' }}</td></tr>
                <tr><th>Order Type</th><td>{{ ucfirst($order->order_type) }}</td></tr>

                <tr><th>Customer Name</th><td>{{ $order->customer_name }}</td></tr>
                <tr><th>Customer Phone</th><td>{{ $order->customer_phone }}</td></tr>
                <tr><th>Customer Email</th><td>{{ $order->customer_email }}</td></tr>

                <tr><th>Event Date</th><td>{{ $order->event_date ? $order->event_date->format('d-m-Y') : '' }}</td></tr>
                <tr><th>Location Name</th><td>{{ $order->event_location_name }}</td></tr>
                <tr><th>Address</th><td>{!! nl2br(e($order->event_address)) !!}</td></tr>
                <tr><th>Latitude</th><td>{{ $order->event_latitude }}</td></tr>
                <tr><th>Longitude</th><td>{{ $order->event_longitude }}</td></tr>
                <tr><th>Distance</th><td>{{ $order->distance_km }} KM</td></tr>
                <tr><th>Shipping Fee</th><td>Rp {{ number_format($order->shipping_fee ?? 0, 0, ',', '.') }}</td></tr>

                <tr><th>Subtotal Package</th><td>Rp {{ number_format($order->subtotal_package ?? 0, 0, ',', '.') }}</td></tr>
                <tr><th>Subtotal Custom</th><td>Rp {{ number_format($order->subtotal_custom ?? 0, 0, ',', '.') }}</td></tr>
                <tr><th>Subtotal Addons</th><td>Rp {{ number_format($order->subtotal_addons ?? 0, 0, ',', '.') }}</td></tr>
                <tr><th>Total Price</th><td><strong>Rp {{ number_format($order->total_price ?? 0, 0, ',', '.') }}</strong></td></tr>

                <tr><th>Status</th><td>{{ ucwords(str_replace('_', ' ', $order->status)) }}</td></tr>
                <tr><th>Payment Status</th><td>{{ ucwords(str_replace('_', ' ', $order->payment_status)) }}</td></tr>

                <tr><th>Payment Deadline</th><td>{{ $order->payment_deadline }}</td></tr>
                <tr><th>Paid At</th><td>{{ $order->paid_at }}</td></tr>
                <tr><th>Confirmed At</th><td>{{ $order->confirmed_at }}</td></tr>
                <tr><th>Invoice Sent At</th><td>{{ $order->invoice_sent_at }}</td></tr>
                <tr><th>Processed At</th><td>{{ $order->processed_at }}</td></tr>
                <tr><th>Completed At</th><td>{{ $order->completed_at }}</td></tr>
                <tr><th>Cancelled At</th><td>{{ $order->cancelled_at }}</td></tr>

                <tr><th>Cancelled Reason</th><td>{!! nl2br(e($order->cancelled_reason)) !!}</td></tr>
                <tr><th>Notes</th><td>{!! nl2br(e($order->notes)) !!}</td></tr>
            </tbody>
        </table>

        <div class="form-group">
            <a class="btn btn-default" href="{{ route('admin.orders.index') }}">
                Back to list
            </a>
        </div>
    </div>
</div>

@endsection