@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.monitoring.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('admin.monitorings.update', [$monitoring->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf

            <!-- Dropdown Product -->
            <div class="form-group">
                <label for="product_id">{{ trans('cruds.monitoring.fields.product') }}</label>
                <select class="form-control {{ $errors->has('product_id') ? 'is-invalid' : '' }}" name="product_id" id="product_id">
                    <option value="">{{ trans('global.pleaseSelect') }}</option>
                    @foreach ($products as $id => $name)
                        <option value="{{ $id }}" {{ old('product_id', $monitoring->product_id) == $id ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
                @if ($errors->has('product_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('product_id') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.monitoring.fields.product_helper') }}</span>
            </div>

            <!-- Dropdown Category -->
            <div class="form-group">
                <label for="category_id">{{ trans('cruds.monitoring.fields.category') }}</label>
                <select class="form-control {{ $errors->has('category_id') ? 'is-invalid' : '' }}" name="category_id" id="category_id">
                    <option value="">{{ trans('global.pleaseSelect') }}</option>
                    @foreach ($categories as $id => $name)
                        <option value="{{ $id }}" {{ old('category_id', $monitoring->category_id) == $id ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
                @if ($errors->has('category_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('category_id') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.monitoring.fields.category_helper') }}</span>
            </div>

            <!-- Dropdown Vendor -->
            <div class="form-group">
                <label for="vendor_id">{{ trans('cruds.monitoring.fields.vendor') }}</label>
                <select class="form-control {{ $errors->has('vendor_id') ? 'is-invalid' : '' }}" name="vendor_id" id="vendor_id">
                    <option value="">{{ trans('global.pleaseSelect') }}</option>
                    @foreach ($vendors as $id => $name)
                        <option value="{{ $id }}" {{ old('vendor_id', $monitoring->vendor_id) == $id ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
                @if ($errors->has('vendor_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('vendor_id') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.monitoring.fields.vendor_helper') }}</span>
            </div>

            <!-- Stock Awal -->
            <div class="form-group">
                <label for="stock_awal">{{ trans('cruds.monitoring.fields.stock_awal') }}</label>
                <input class="form-control {{ $errors->has('stock_awal') ? 'is-invalid' : '' }}" type="number" name="stock_awal" id="stock_awal" value="{{ old('stock_awal', $monitoring->stock_awal) }}">
                @if ($errors->has('stock_awal'))
                    <div class="invalid-feedback">
                        {{ $errors->first('stock_awal') }}
                    </div>
                @endif
            </div>

            {{-- <!-- Stock Outstanding -->
            <div class="form-group">
                <label for="stock_outstanding">{{ trans('cruds.monitoring.fields.stock_outstanding') }}</label>
                <input class="form-control {{ $errors->has('stock_outstanding') ? 'is-invalid' : '' }}" type="number" name="stock_outstanding" id="stock_outstanding" value="{{ old('stock_outstanding', $monitoring->stock_outstanding) }}">
                @if ($errors->has('stock_outstanding'))
                    <div class="invalid-feedback">
                        {{ $errors->first('stock_outstanding') }}
                    </div>
                @endif
            </div>

            <!-- Stock Outstanding -->
            <div class="form-group">
                <label for="stock_sisa">{{ trans('cruds.monitoring.fields.stock_sisa') }}</label>
                <input class="form-control {{ $errors->has('stock_sisa') ? 'is-invalid' : '' }}" type="number" name="stock_sisa" id="stock_sisa" value="{{ old('stock_sisa', $monitoring->stock_sisa) }}">
                @if ($errors->has('stock_sisa'))
                    <div class="invalid-feedback">
                        {{ $errors->first('stock_sisa') }}
                    </div>
                @endif
            </div> --}}

            <!-- Submit Button -->
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
    {{-- <script>
        document.addEventListener("DOMContentLoaded", function() {
            const stockAwalInput = document.getElementById('stock_awal');
            const stockOutstandingInput = document.getElementById('stock_outstanding');
            
            // Set stockOutstanding dengan nilai saat ini
            const initialStockOutstanding = parseFloat(stockOutstandingInput.value) || 0;
            const initialStockAwal = parseFloat(stockAwalInput.value) || 0;
            
            // Perbarui stockOutstanding saat stockAwal berubah
            stockAwalInput.addEventListener('input', function() {
                const newStockAwal = parseFloat(stockAwalInput.value) || 0;
                const updatedOutstanding = initialStockOutstanding + (newStockAwal - initialStockAwal);
                
                stockOutstandingInput.value = updatedOutstanding;
            });
        });
    </script> --}}
@endsection
