@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.monitoring.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.monitorings.store') }}" enctype="multipart/form-data">
                @csrf

                <!-- Dropdown Product -->
                <div class="form-group">
                    <label for="product_id">{{ trans('cruds.monitoring.fields.product') }}</label>
                    <select class="form-control {{ $errors->has('product_id') ? 'is-invalid' : '' }}" name="product_id"
                        id="product_id">
                        <option value="">{{ trans('global.pleaseSelect') }}</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                {{ $product->name }}</option>
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
                    <select class="form-control {{ $errors->has('category_id') ? 'is-invalid' : '' }}" name="category_id"
                        id="category_id">
                        <option value="">{{ trans('global.pleaseSelect') }}</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('category_id'))
                        <div class="invalid-feedback">
                            {{ $errors->first('category_id') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.monitoring.fields.category_helper') }}</span>
                </div>

                <div class="form-group">
                    <label for="vendor_id">{{ trans('cruds.monitoring.fields.vendor') }}</label>
                    <select class="form-control {{ $errors->has('vendor_id') ? 'is-invalid' : '' }}" name="vendor_id"
                        id="vendor_id">
                        <option value="">{{ trans('global.pleaseSelect') }}</option>
                        @foreach ($vendors as $vendor)
                            <option value="{{ $vendor->id }}" {{ old('vendor_id') == $vendor->id ? 'selected' : '' }}>
                                {{ $vendor->nama_vendor }}
                            </option>
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
                    <input class="form-control {{ $errors->has('stock_awal') ? 'is-invalid' : '' }}" type="number"
                        name="stock_awal" id="stock_awal" value="{{ old('stock_awal') }}">
                    @if ($errors->has('stock_awal'))
                        <div class="invalid-feedback">
                            {{ $errors->first('stock_awal') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.monitoring.fields.stock_awal_helper') }}</span>
                </div>

                <!-- Stock Outstanding -->
                <div class="form-group">
                    <label for="stock_outstanding">{{ trans('cruds.monitoring.fields.stock_outstanding') }}</label>
                    <input class="form-control {{ $errors->has('stock_outstanding') ? 'is-invalid' : '' }}" type="number"
                        name="stock_outstanding" id="stock_outstanding" value="{{ old('stock_outstanding', 0) }}" readonly>
                    @if ($errors->has('stock_outstanding'))
                        <div class="invalid-feedback">
                            {{ $errors->first('stock_outstanding') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.monitoring.fields.stock_outstanding_helper') }}</span>
                </div>

                <!-- Stock Sisa -->
                <div class="form-group">
                    <label for="stock_sisa">{{ trans('cruds.monitoring.fields.stock_sisa') }}</label>
                    <input class="form-control {{ $errors->has('stock_sisa') ? 'is-invalid' : '' }}" type="number"
                        name="stock_sisa" id="stock_sisa" value="{{ old('stock_sisa', 0) }}" readonly>
                    @if ($errors->has('stock_sisa'))
                        <div class="invalid-feedback">
                            {{ $errors->first('stock_sisa') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.monitoring.fields.stock_sisa_helper') }}</span>
                </div>

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
        // Saat halaman dimuat atau input stock_awal berubah, sinkronkan nilai stock_outstanding
        document.addEventListener("DOMContentLoaded", function() {
            const stockAwalInput = document.getElementById('stock_awal');
            const stockOutstandingInput = document.getElementById('stock_outstanding');

            // Set nilai awal stock_outstanding sesuai dengan stock_awal
            stockOutstandingInput.value = stockAwalInput.value;

            // Sinkronkan nilai stock_outstanding setiap kali stock_awal berubah
            stockAwalInput.addEventListener('input', function() {
                stockOutstandingInput.value = stockAwalInput.value;
            });

            // Set stock_outstanding sebagai readonly
            stockOutstandingInput.setAttribute('readonly', 'readonly');
        });
    </script> --}}
@endsection
