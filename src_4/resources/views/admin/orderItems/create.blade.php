@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Tambah Order Item
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('admin.order-items.store') }}">
            @csrf

            <div class="form-group">
                <label for="order_id">Order</label>
                <select class="form-control {{ $errors->has('order_id') ? 'is-invalid' : '' }}" name="order_id" id="order_id" required>
                    <option value="">Pilih Order</option>
                    @foreach($orders as $order)
                        <option value="{{ $order->id }}" {{ old('order_id', $selectedOrderId) == $order->id ? 'selected' : '' }}>
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
                        <option value="{{ $key }}" {{ old('item_type', 'package') === $key ? 'selected' : '' }}>
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
                <input class="form-control {{ $errors->has('source_id') ? 'is-invalid' : '' }}" type="number" name="source_id" id="source_id" value="{{ old('source_id', '') }}" min="0">
                @if($errors->has('source_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('source_id') }}
                    </div>
                @endif
                <span class="help-block">Opsional. Bisa diisi ID sumber item, misalnya package item atau custom item.</span>
            </div>

            <div class="form-group">
                <label for="name">Name</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="unit">Unit</label>
                <input class="form-control {{ $errors->has('unit') ? 'is-invalid' : '' }}" type="text" name="unit" id="unit" value="{{ old('unit', '') }}" placeholder="pcs / meter / set / item">
                @if($errors->has('unit'))
                    <div class="invalid-feedback">
                        {{ $errors->first('unit') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="quantity">Quantity</label>
                <input class="form-control {{ $errors->has('quantity') ? 'is-invalid' : '' }}" type="number" name="quantity" id="quantity" value="{{ old('quantity', 1) }}" min="1" required>
                @if($errors->has('quantity'))
                    <div class="invalid-feedback">
                        {{ $errors->first('quantity') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="price">Price</label>
                <input class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}" type="number" name="price" id="price" value="{{ old('price', 0) }}" min="0">
                @if($errors->has('price'))
                    <div class="invalid-feedback">
                        {{ $errors->first('price') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="total_price">Total Price</label>
                <input class="form-control {{ $errors->has('total_price') ? 'is-invalid' : '' }}" type="number" name="total_price" id="total_price" value="{{ old('total_price', 0) }}" min="0">
                @if($errors->has('total_price'))
                    <div class="invalid-feedback">
                        {{ $errors->first('total_price') }}
                    </div>
                @endif
                <span class="help-block">Total otomatis dihitung dari quantity x price.</span>
            </div>

            <div class="form-group">
                <label for="snapshot">Snapshot JSON</label>
                <textarea class="form-control {{ $errors->has('snapshot') ? 'is-invalid' : '' }}" name="snapshot" id="snapshot" rows="5">{{ old('snapshot', '') }}</textarea>
                @if($errors->has('snapshot'))
                    <div class="invalid-feedback">
                        {{ $errors->first('snapshot') }}
                    </div>
                @endif
                <span class="help-block">Opsional. Isi JSON valid jika diperlukan.</span>
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

        calculateTotalPrice();
    });
</script>
@endsection