@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Edit Order Item
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('admin.order-items.update', [$orderItem->id]) }}">
            @method('PUT')
            @csrf

            <div class="form-group">
                <label for="order_id">Order</label>
                <select class="form-control {{ $errors->has('order_id') ? 'is-invalid' : '' }}" name="order_id" id="order_id" required>
                    <option value="">Pilih Order</option>
                    @foreach($orders as $order)
                        <option value="{{ $order->id }}" {{ old('order_id', $orderItem->order_id) == $order->id ? 'selected' : '' }}>
                            {{ $order->invoice_number }} - {{ $order->customer_name }}
                        </option>
                    @endforeach
                </select>
                @if($errors->has('order_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('order_id') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="item_type">Item Type</label>
                <select class="form-control {{ $errors->has('item_type') ? 'is-invalid' : '' }}" name="item_type" id="item_type" required>
                    @foreach($itemTypes as $key => $label)
                        <option value="{{ $key }}" {{ old('item_type', $orderItem->item_type) === $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                @if($errors->has('item_type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('item_type') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="source_id">Source ID</label>
                <input class="form-control {{ $errors->has('source_id') ? 'is-invalid' : '' }}" type="number" name="source_id" id="source_id" value="{{ old('source_id', $orderItem->source_id) }}" min="0">
                @if($errors->has('source_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('source_id') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="name">Name</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $orderItem->name) }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="unit">Unit</label>
                <input class="form-control {{ $errors->has('unit') ? 'is-invalid' : '' }}" type="text" name="unit" id="unit" value="{{ old('unit', $orderItem->unit) }}" placeholder="pcs / meter / set / item">
                @if($errors->has('unit'))
                    <div class="invalid-feedback">
                        {{ $errors->first('unit') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="quantity">Quantity</label>
                <input class="form-control {{ $errors->has('quantity') ? 'is-invalid' : '' }}" type="number" name="quantity" id="quantity" value="{{ old('quantity', $orderItem->quantity) }}" min="1" required>
                @if($errors->has('quantity'))
                    <div class="invalid-feedback">
                        {{ $errors->first('quantity') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="price">Price</label>
                <input class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}" type="number" name="price" id="price" value="{{ old('price', $orderItem->price) }}" min="0">
                @if($errors->has('price'))
                    <div class="invalid-feedback">
                        {{ $errors->first('price') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="total_price">Total Price</label>
                <input class="form-control {{ $errors->has('total_price') ? 'is-invalid' : '' }}" type="number" name="total_price" id="total_price" value="{{ old('total_price', $orderItem->total_price) }}" min="0">
                @if($errors->has('total_price'))
                    <div class="invalid-feedback">
                        {{ $errors->first('total_price') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="snapshot">Snapshot JSON</label>
                <textarea class="form-control {{ $errors->has('snapshot') ? 'is-invalid' : '' }}" name="snapshot" id="snapshot" rows="5">{{ old('snapshot', $orderItem->snapshot ? json_encode($orderItem->snapshot, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : '') }}</textarea>
                @if($errors->has('snapshot'))
                    <div class="invalid-feedback">
                        {{ $errors->first('snapshot') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    Save
                </button>

                <a class="btn btn-default" href="{{ route('admin.order-items.index') }}">
                    Back to list
                </a>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
@parent
<script>
    function calculateTotalPrice() {
        let quantity = parseInt(document.getElementById('quantity').value || 0);
        let price = parseInt(document.getElementById('price').value || 0);

        document.getElementById('total_price').value = quantity * price;
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('quantity').addEventListener('input', calculateTotalPrice);
        document.getElementById('price').addEventListener('input', calculateTotalPrice);
    });
</script>
@endsection