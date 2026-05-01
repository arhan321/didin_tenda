@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Detail Order Item
    </div>

    <div class="card-body">
        <div class="form-group">
            <a class="btn btn-default" href="{{ route('admin.order-items.index') }}">
                Back to list
            </a>
        </div>

        <table class="table table-bordered table-striped">
            <tbody>
                <tr>
                    <th>ID</th>
                    <td>{{ $orderItem->id }}</td>
                </tr>

                <tr>
                    <th>Order</th>
                    <td>
                        {{ $orderItem->order->invoice_number ?? '' }}
                        -
                        {{ $orderItem->order->customer_name ?? '' }}
                    </td>
                </tr>

                <tr>
                    <th>Item Type</th>
                    <td>{{ ucfirst($orderItem->item_type) }}</td>
                </tr>

                <tr>
                    <th>Source ID</th>
                    <td>{{ $orderItem->source_id ?? '-' }}</td>
                </tr>

                <tr>
                    <th>Name</th>
                    <td>{{ $orderItem->name }}</td>
                </tr>

                <tr>
                    <th>Unit</th>
                    <td>{{ $orderItem->unit }}</td>
                </tr>

                <tr>
                    <th>Quantity</th>
                    <td>{{ $orderItem->quantity }}</td>
                </tr>

                <tr>
                    <th>Price</th>
                    <td>Rp {{ number_format($orderItem->price ?? 0, 0, ',', '.') }}</td>
                </tr>

                <tr>
                    <th>Total Price</th>
                    <td>Rp {{ number_format($orderItem->total_price ?? 0, 0, ',', '.') }}</td>
                </tr>

                <tr>
                    <th>Snapshot</th>
                    <td>
                        @if($orderItem->snapshot)
                            <pre>{{ json_encode($orderItem->snapshot, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="form-group">
            <a class="btn btn-default" href="{{ route('admin.order-items.index') }}">
                Back to list
            </a>
        </div>
    </div>
</div>

@endsection