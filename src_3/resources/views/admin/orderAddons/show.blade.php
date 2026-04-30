@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Detail Order Addon
    </div>

    <div class="card-body">
        <div class="form-group">
            <a class="btn btn-default" href="{{ route('admin.order-addons.index') }}">
                Back to list
            </a>
        </div>

        <table class="table table-bordered table-striped">
            <tbody>
                <tr>
                    <th>ID</th>
                    <td>{{ $orderAddon->id }}</td>
                </tr>

                <tr>
                    <th>Order</th>
                    <td>
                        {{ $orderAddon->order->invoice_number ?? '' }}
                        -
                        {{ $orderAddon->order->customer_name ?? '' }}
                    </td>
                </tr>

                <tr>
                    <th>Addon</th>
                    <td>{{ $orderAddon->addon->name ?? '-' }}</td>
                </tr>

                <tr>
                    <th>Name</th>
                    <td>{{ $orderAddon->name }}</td>
                </tr>

                <tr>
                    <th>Detail</th>
                    <td>{{ $orderAddon->detail }}</td>
                </tr>

                <tr>
                    <th>Unit</th>
                    <td>{{ $orderAddon->unit }}</td>
                </tr>

                <tr>
                    <th>Quantity</th>
                    <td>{{ $orderAddon->quantity }}</td>
                </tr>

                <tr>
                    <th>Price</th>
                    <td>Rp {{ number_format($orderAddon->price ?? 0, 0, ',', '.') }}</td>
                </tr>

                <tr>
                    <th>Total Price</th>
                    <td>Rp {{ number_format($orderAddon->total_price ?? 0, 0, ',', '.') }}</td>
                </tr>

                <tr>
                    <th>Snapshot</th>
                    <td>
                        @if($orderAddon->snapshot)
                            <pre>{{ json_encode($orderAddon->snapshot, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="form-group">
            <a class="btn btn-default" href="{{ route('admin.order-addons.index') }}">
                Back to list
            </a>
        </div>
    </div>
</div>

@endsection