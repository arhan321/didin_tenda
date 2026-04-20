@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('cruds.product.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.products.update', [$product->id]) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf

                <!-- Nama Produk -->
                <div class="form-group">
                    <label for="name">{{ trans('cruds.product.fields.name') }}</label>
                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name"
                        id="name" value="{{ old('name', $product->name) }}">
                    @if ($errors->has('name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.product.fields.name_helper') }}</span>
                </div>

                <!-- Jangka Waktu -->
                <div class="form-group">
                    <label for="jangka_waktu">{{ trans('cruds.product.fields.jangka_waktu') }}</label>
                    <input class="form-control {{ $errors->has('jangka_waktu') ? 'is-invalid' : '' }}" type="text"
                        name="jangka_waktu" id="jangka_waktu" value="{{ old('jangka_waktu', $product->jangka_waktu) }}">
                    @if ($errors->has('jangka_waktu'))
                        <div class="invalid-feedback">
                            {{ $errors->first('jangka_waktu') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.product.fields.jangka_waktu_helper') }}</span>
                </div>

                <!-- Harga Beli -->
                <div class="form-group">
                    <label for="harga_beli">{{ trans('cruds.product.fields.harga_beli') }}</label>
                    <input class="form-control {{ $errors->has('harga_beli') ? 'is-invalid' : '' }}" type="number"
                        name="harga_beli" id="harga_beli" value="{{ old('harga_beli', $product->harga_beli) }}"
                        step="0.01">
                    @if ($errors->has('harga_beli'))
                        <div class="invalid-feedback">
                            {{ $errors->first('harga_beli') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.product.fields.harga_beli_helper') }}</span>
                </div>

                <!-- Harga Jual -->
                <div class="form-group">
                    <label for="harga_sewa">{{ trans('cruds.product.fields.harga_sewa') }}</label>
                    <input class="form-control {{ $errors->has('harga_sewa') ? 'is-invalid' : '' }}" type="number"
                        name="harga_sewa" id="harga_sewa" value="{{ old('harga_sewa', $product->harga_sewa) }}"
                        step="0.01">
                    @if ($errors->has('harga_sewa'))
                        <div class="invalid-feedback">
                            {{ $errors->first('harga_sewa') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.product.fields.harga_sewa_helper') }}</span>
                </div>

                {{-- <!-- Stock Awal -->
                <div class="form-group">
                    <label for="stock_awal">{{ trans('cruds.product.fields.stock_awal') }}</label>
                    <input class="form-control {{ $errors->has('stock_awal') ? 'is-invalid' : '' }}" type="number"
                        name="stock_awal" id="stock_awal" value="{{ old('stock_awal', $product->stock_awal) }}"
                        step="1" oninput="updateStockOutstanding()">
                    @if ($errors->has('stock_awal'))
                        <div class="invalid-feedback">
                            {{ $errors->first('stock_awal') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.product.fields.stock_awal_helper') }}</span>
                </div>

                <!-- Stock Outstanding -->
                <div class="form-group">
                    <label for="stock_outstanding">{{ trans('cruds.product.fields.stock_outstanding') }}</label>
                    <input class="form-control {{ $errors->has('stock_outstanding') ? 'is-invalid' : '' }}" type="number"
                        name="stock_outstanding" id="stock_outstanding"
                        value="{{ old('stock_outstanding', $product->stock_outstanding) }}" step="1" >
                    @if ($errors->has('stock_outstanding'))
                        <div class="invalid-feedback">
                            {{ $errors->first('stock_outstanding') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.product.fields.stock_outstanding_helper') }}</span>
                </div>

                <!-- Vendor -->
                <div class="form-group">
                    <label for="vendor_id">{{ trans('cruds.product.fields.vendor') }}</label>
                    <select class="form-control {{ $errors->has('vendor_id') ? 'is-invalid' : '' }}" name="vendor_id"
                        id="vendor_id">
                        @foreach ($vendors as $id => $vendor)
                            <option value="{{ $id }}"
                                {{ old('vendor_id', $product->vendor_id) == $id ? 'selected' : '' }}>{{ $vendor }}
                            </option>
                        @endforeach
                    </select>
                    @if ($errors->has('vendor_id'))
                        <div class="invalid-feedback">
                            {{ $errors->first('vendor_id') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.product.fields.vendor_helper') }}</span>
                </div>

                <!-- Category -->
                <div class="form-group">
                    <label for="category_id">{{ trans('cruds.product.fields.category') }}</label>
                    <select class="form-control {{ $errors->has('category_id') ? 'is-invalid' : '' }}" name="category_id"
                        id="category_id">
                        @foreach ($categories as $id => $category)
                            <option value="{{ $id }}"
                                {{ old('category_id', $product->category_id) == $id ? 'selected' : '' }}>
                                {{ $category }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('category_id'))
                        <div class="invalid-feedback">
                            {{ $errors->first('category_id') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.product.fields.category_helper') }}</span>
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
    let initialStockAwal = {{ $product->stock_awal ?? 0 }};
    let initialStockOutstanding = {{ $product->stock_outstanding ?? 0 }};

    function updateStockOutstanding() {
        const stockAwalInput = document.getElementById('stock_awal');
        const stockOutstandingInput = document.getElementById('stock_outstanding');
        
        const currentStockAwal = parseInt(stockAwalInput.value) || 0;
        const stockDifference = currentStockAwal - initialStockAwal;

        // Update stock outstanding based on the difference
        stockOutstandingInput.value = initialStockOutstanding + stockDifference;
    }
</script>