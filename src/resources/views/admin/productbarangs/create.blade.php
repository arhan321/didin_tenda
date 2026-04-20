@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.productbarang.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.productbarangs.store') }}">
                @csrf
                <!-- Nama Produk -->
                <div class="form-group">
                    <label for="name">{{ trans('cruds.productbarang.fields.name') }}</label>
                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name"
                        id="name" value="{{ old('name', '') }}">
                    @if ($errors->has('name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.productbarang.fields.name_helper') }}</span>
                </div>

                <!-- Harga Beli -->
                <div class="form-group">
                    <label for="harga_beli">{{ trans('cruds.productbarang.fields.harga_beli') }}</label>
                    <input class="form-control {{ $errors->has('harga_beli') ? 'is-invalid' : '' }}" type="text"
                        name="harga_beli" id="harga_beli" value="{{ old('harga_beli', '') }}" step="0.01">
                    @if ($errors->has('harga_beli'))
                        <div class="invalid-feedback">
                            {{ $errors->first('harga_beli') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.productbarang.fields.harga_beli_helper') }}</span>
                </div>

                <!-- Harga Jual -->
                <div class="form-group">
                    <label for="harga_jual">{{ trans('cruds.productbarang.fields.harga_jual') }}</label>
                    <input class="form-control {{ $errors->has('harga_jual') ? 'is-invalid' : '' }}" type="text"
                        name="harga_jual" id="harga_jual" value="{{ old('harga_jual', '') }}" step="0.01">
                    @if ($errors->has('harga_jual'))
                        <div class="invalid-feedback">
                            {{ $errors->first('harga_jual') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.productbarang.fields.harga_jual_helper') }}</span>
                </div>

                 <!-- Stock -->
                <div class="form-group">
                    <label for="stock">{{ trans('cruds.productbarang.fields.stock') }}</label>
                    <input class="form-control {{ $errors->has('stock') ? 'is-invalid' : '' }}" type="number"
                        name="stock" id="stock" value="{{ old('stock', '') }}" step="1"
                        oninput="updateStockOutstanding()">
                    @if ($errors->has('stock'))
                        <div class="invalid-feedback">
                            {{ $errors->first('stock') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.productbarang.fields.stock_helper') }}</span>
                </div>
                {{--
                <!-- Stock Outstanding -->
                <div class="form-group">
                    <label for="stock_outstanding">{{ trans('cruds.productbarang.fields.stock_outstanding') }}</label>
                    <input class="form-control {{ $errors->has('stock_outstanding') ? 'is-invalid' : '' }}" type="number"
                        name="stock_outstanding" id="stock_outstanding" value="{{ old('stock_outstanding', '') }}"
                        step="1" readonly>
                    @if ($errors->has('stock_outstanding'))
                        <div class="invalid-feedback">
                            {{ $errors->first('stock_outstanding') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.productbarang.fields.stock_outstanding_helper') }}</span>
                </div>

                <!-- Vendor -->
                <div class="form-group">
                    <label for="vendor_id">{{ trans('cruds.productbarang.fields.vendor') }}</label>
                    <select class="form-control {{ $errors->has('vendor_id') ? 'is-invalid' : '' }}" name="vendor_id"
                        id="vendor_id">
                        @foreach ($vendors as $id => $vendor)
                            <option value="{{ $id }}" {{ old('vendor_id') == $id ? 'selected' : '' }}>
                                {{ $vendor }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('vendor_id'))
                        <div class="invalid-feedback">
                            {{ $errors->first('vendor_id') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.productbarang.fields.vendor_helper') }}</span>
                </div>

                <!-- Category -->
                <div class="form-group">
                    <label for="category_id">{{ trans('cruds.productbarang.fields.category') }}</label>
                    <select class="form-control {{ $errors->has('category_id') ? 'is-invalid' : '' }}" name="category_id"
                        id="category_id">
                        @foreach ($categories as $id => $category)
                            <option value="{{ $id }}" {{ old('category_id') == $id ? 'selected' : '' }}>
                                {{ $category }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('category_id'))
                        <div class="invalid-feedback">
                            {{ $errors->first('category_id') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.productbarang.fields.category_helper') }}</span>
                </div> --}}

                <div class="form-group">
                    <button class="btn btn-danger" type="submit">
                        {{ trans('global.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
<script>
    function updateStockOutstanding() {
        var stockAwal = document.getElementById('stock_awal').value;
        document.getElementById('stock_outstanding').value = stockAwal;
    }
</script>
