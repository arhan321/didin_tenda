@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Edit Order Addon
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('admin.order-addons.update', [$orderAddon->id]) }}">
            @method('PUT')
            @csrf

            <div class="form-group">
                <label for="order_id">Order</label>
                <select class="form-control {{ $errors->has('order_id') ? 'is-invalid' : '' }}" name="order_id" id="order_id" required>
                    <option value="">Pilih Order</option>
                    @foreach($orders as $order)
                        <option value="{{ $order->id }}" {{ old('order_id', $orderAddon->order_id) == $order->id ? 'selected' : '' }}>
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
                <label for="addon_id">Addon</label>
                <select class="form-control {{ $errors->has('addon_id') ? 'is-invalid' : '' }}" name="addon_id" id="addon_id">
                    <option value="">Pilih Addon</option>
                    @foreach($addons as $addon)
                        <option
                            value="{{ $addon->id }}"
                            data-name="{{ $addon->name }}"
                            data-detail="{{ $addon->detail }}"
                            data-unit="{{ $addon->unit }}"
                            data-price="{{ $addon->price }}"
                            {{ old('addon_id', $orderAddon->addon_id) == $addon->id ? 'selected' : '' }}
                        >
                            {{ $addon->name }} - Rp {{ number_format($addon->price, 0, ',', '.') }}
                        </option>
                    @endforeach
                </select>
                @if($errors->has('addon_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('addon_id') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="name">Name</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $orderAddon->name) }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="detail">Detail</label>
                <input class="form-control {{ $errors->has('detail') ? 'is-invalid' : '' }}" type="text" name="detail" id="detail" value="{{ old('detail', $orderAddon->detail) }}">
                @if($errors->has('detail'))
                    <div class="invalid-feedback">
                        {{ $errors->first('detail') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="unit">Unit</label>
                <input class="form-control {{ $errors->has('unit') ? 'is-invalid' : '' }}" type="text" name="unit" id="unit" value="{{ old('unit', $orderAddon->unit) }}">
                @if($errors->has('unit'))
                    <div class="invalid-feedback">
                        {{ $errors->first('unit') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="quantity">Quantity</label>
                <input class="form-control {{ $errors->has('quantity') ? 'is-invalid' : '' }}" type="number" name="quantity" id="quantity" value="{{ old('quantity', $orderAddon->quantity) }}" min="1" required>
                @if($errors->has('quantity'))
                    <div class="invalid-feedback">
                        {{ $errors->first('quantity') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="price">Price</label>
                <input class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}" type="number" name="price" id="price" value="{{ old('price', $orderAddon->price) }}" min="0">
                @if($errors->has('price'))
                    <div class="invalid-feedback">
                        {{ $errors->first('price') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="total_price">Total Price</label>
                <input class="form-control {{ $errors->has('total_price') ? 'is-invalid' : '' }}" type="number" name="total_price" id="total_price" value="{{ old('total_price', $orderAddon->total_price) }}" min="0">
                @if($errors->has('total_price'))
                    <div class="invalid-feedback">
                        {{ $errors->first('total_price') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="snapshot">Snapshot JSON</label>
                <textarea class="form-control {{ $errors->has('snapshot') ? 'is-invalid' : '' }}" name="snapshot" id="snapshot" rows="5">{{ old('snapshot', $orderAddon->snapshot ? json_encode($orderAddon->snapshot, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : '') }}</textarea>
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

                <a class="btn btn-default" href="{{ route('admin.order-addons.index') }}">
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
        const addonSelect = document.getElementById('addon_id');

        addonSelect.addEventListener('change', function () {
            const selected = this.options[this.selectedIndex];

            if (selected.value) {
                document.getElementById('name').value = selected.dataset.name || '';
                document.getElementById('detail').value = selected.dataset.detail || '';
                document.getElementById('unit').value = selected.dataset.unit || '';
                document.getElementById('price').value = selected.dataset.price || 0;
                calculateTotalPrice();
            }
        });

        document.getElementById('quantity').addEventListener('input', calculateTotalPrice);
        document.getElementById('price').addEventListener('input', calculateTotalPrice);
    });
</script>
@endsection