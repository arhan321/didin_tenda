@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.vendor.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.vendors.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="nama_vendor">{{ trans('cruds.vendor.fields.name') }}</label>
                <!-- Ganti nama_vendor="nama_vendor" menjadi name="nama_vendor" -->
                <input class="form-control {{ $errors->has('nama_vendor') ? 'is-invalid' : '' }}" type="text" name="nama_vendor" id="nama_vendor" value="{{ old('nama_vendor', '') }}">
                @if($errors->has('nama_vendor'))
                    <div class="invalid-feedback">
                        {{ $errors->first('nama_vendor') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.vendor.fields.name_helper') }}</span>
            </div>
            
            <div class="form-group">
                <label for="alamat_vendor">{{ trans('cruds.vendor.fields.alamat') }}</label>
                <!-- Ganti alamat_vendor="alamat_vendor" menjadi name="alamat_vendor" -->
                <input class="form-control {{ $errors->has('alamat_vendor') ? 'is-invalid' : '' }}" type="text" name="alamat_vendor" id="alamat_vendor" value="{{ old('alamat_vendor', '') }}">
                @if($errors->has('alamat_vendor'))
                    <div class="invalid-feedback">
                        {{ $errors->first('alamat_vendor') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.vendor.fields.alamat_helper') }}</span>
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
