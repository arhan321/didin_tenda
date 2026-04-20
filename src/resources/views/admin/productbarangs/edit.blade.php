@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('cruds.productbarang.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.productbarangs.update', $productbarang->id) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf

                <!-- Nama Produk -->
                <div class="form-group">
                    <label for="name">{{ trans('cruds.productbarang.fields.name') }}</label>
                    <input
                        class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                        type="text"
                        name="name"
                        id="name"
                        value="{{ old('name', $productbarang->name) }}"
                    >
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
                    <input
                        class="form-control {{ $errors->has('harga_beli') ? 'is-invalid' : '' }}"
                        type="number"
                        name="harga_beli"
                        id="harga_beli"
                        value="{{ old('harga_beli', $productbarang->harga_beli) }}"
                        step="0.01"
                    >
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
                    <input
                        class="form-control {{ $errors->has('harga_jual') ? 'is-invalid' : '' }}"
                        type="number"
                        name="harga_jual"
                        id="harga_jual"
                        value="{{ old('harga_jual', $productbarang->harga_jual) }}"
                        step="0.01"
                    >
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
                    <input
                        class="form-control {{ $errors->has('stock') ? 'is-invalid' : '' }}"
                        type="number"
                        name="stock"
                        id="stock"
                        value="{{ old('stock', $productbarang->stock) }}"
                        step="1"
                    >
                    @if ($errors->has('stock'))
                        <div class="invalid-feedback">
                            {{ $errors->first('stock') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.productbarang.fields.stock_helper') }}</span>
                </div>

                <div class="form-group">
                    <button class="btn btn-danger" type="submit">
                        {{ trans('global.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
