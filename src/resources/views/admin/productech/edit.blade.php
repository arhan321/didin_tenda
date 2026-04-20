@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('cruds.sahabatechbarang.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.productech.update', [$productech->id]) }}"
                enctype="multipart/form-data">
                @method('PUT')
                @csrf

                <!-- Nama Produk -->
                <div class="form-group">
                    <label for="name">{{ trans('cruds.sahabatechbarang.fields.name') }}</label>
                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name"
                        id="name" value="{{ old('name', $productech->name) }}">
                    @if ($errors->has('name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.sahabatechbarang.fields.name_helper') }}</span>
                </div>

                <!-- Jangka Waktu -->
                {{-- <div class="form-group">
                    <label for="jangka_waktu">{{ trans('cruds.sahabatechbarang.fields.jangka_waktu') }}</label>
                    <input class="form-control {{ $errors->has('jangka_waktu') ? 'is-invalid' : '' }}" type="text"
                        name="jangka_waktu" id="jangka_waktu" value="{{ old('jangka_waktu', $productech->jangka_waktu) }}">
                    @if ($errors->has('jangka_waktu'))
                        <div class="invalid-feedback">
                            {{ $errors->first('jangka_waktu') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.sahabatechbarang.fields.jangka_waktu_helper') }}</span>
                </div> --}}

                <!-- Harga Beli -->
                <div class="form-group">
                    <label for="harga_beli">{{ trans('cruds.sahabatechbarang.fields.harga_beli') }}</label>
                    <input class="form-control {{ $errors->has('harga_beli') ? 'is-invalid' : '' }}" type="number"
                        name="harga_beli" id="harga_beli" value="{{ old('harga_beli', $productech->harga_beli) }}"
                        step="0.01">
                    @if ($errors->has('harga_beli'))
                        <div class="invalid-feedback">
                            {{ $errors->first('harga_beli') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.sahabatechbarang.fields.harga_beli_helper') }}</span>
                </div>

                <!-- Harga Jual -->
                <div class="form-group">
                    <label for="harga_jual">{{ trans('cruds.sahabatechbarang.fields.harga_jual') }}</label>
                    <input class="form-control {{ $errors->has('harga_jual') ? 'is-invalid' : '' }}" type="number"
                        name="harga_jual" id="harga_jual" value="{{ old('harga_jual', $productech->harga_jual) }}"
                        step="0.01">
                    @if ($errors->has('harga_jual'))
                        <div class="invalid-feedback">
                            {{ $errors->first('harga_jual') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.sahabatechbarang.fields.harga_jual_helper') }}</span>
                </div>

                <!-- Stock Awal -->
                <div class="form-group">
                    <label for="stock_barang">{{ trans('cruds.sahabatechbarang.fields.stock_barang') }}</label>
                    <input class="form-control {{ $errors->has('stock_barang') ? 'is-invalid' : '' }}" type="number"
                        name="stock_barang" id="stock_barang" value="{{ old('stock_barang', $productech->stock_barang) }}"
                        step="1" oninput="updateStockOutstanding()">
                    @if ($errors->has('stock_barang'))
                        <div class="invalid-feedback">
                            {{ $errors->first('stock_barang') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.sahabatechbarang.fields.stock_barang_helper') }}</span>
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
{{-- <script>
    let initialStockAwal = {{ $productech->stock_awal ?? 0 }};
    let initialStockOutstanding = {{ $productech->stock_outstanding ?? 0 }};

    function updateStockOutstanding() {
        const stockAwalInput = document.getElementById('stock_awal');
        const stockOutstandingInput = document.getElementById('stock_outstanding');
        
        const currentStockAwal = parseInt(stockAwalInput.value) || 0;
        const stockDifference = currentStockAwal - initialStockAwal;

        // Update stock outstanding based on the difference
        stockOutstandingInput.value = initialStockOutstanding + stockDifference;
    }
</script> --}}
