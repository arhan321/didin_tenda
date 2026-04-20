@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.laptop.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.laptops.store') }}">
                @csrf

                <!-- Nama User -->
                <div class="form-group">
                    <label for="nama_user">{{ trans('cruds.laptop.fields.nama_user') }}</label>
                    <input class="form-control {{ $errors->has('nama_user') ? 'is-invalid' : '' }}" type="text" name="nama_user" id="nama_user" value="{{ old('nama_user', '') }}">
                    @if ($errors->has('nama_user'))
                        <div class="invalid-feedback">
                            {{ $errors->first('nama_user') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.laptop.fields.nama_user_helper') }}</span>
                </div>

                <!-- Type Laptop -->
                <div class="form-group">
                    <label for="type_laptop">{{ trans('cruds.laptop.fields.type_laptop') }}</label>
                    <input class="form-control {{ $errors->has('type_laptop') ? 'is-invalid' : '' }}" type="text" name="type_laptop" id="type_laptop" value="{{ old('type_laptop', '') }}">
                    @if ($errors->has('type_laptop'))
                        <div class="invalid-feedback">
                            {{ $errors->first('type_laptop') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.laptop.fields.type_laptop_helper') }}</span>
                </div>

                <!-- SN LAPTOP -->
                <div class="form-group">
                    <label for="sn_laptop">{{ trans('cruds.laptop.fields.sn_laptop') }}</label>
                    <input class="form-control {{ $errors->has('sn_laptop') ? 'is-invalid' : '' }}" type="text" name="sn_laptop" id="sn_laptop" value="{{ old('sn_laptop', '') }}">
                    @if ($errors->has('sn_laptop'))
                        <div class="invalid-feedback">
                            {{ $errors->first('sn_laptop') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.laptop.fields.sn_laptop_helper') }}</span>
                </div>

                <!-- Tahun Laptop -->
                <div class="form-group">
                    <label for="tahun_laptop">{{ trans('cruds.laptop.fields.tahun_laptop') }}</label>
                    <input class="form-control {{ $errors->has('tahun_laptop') ? 'is-invalid' : '' }}" type="text" name="tahun_laptop" id="tahun_laptop" value="{{ old('tahun_laptop', '') }}">
                    @if ($errors->has('tahun_laptop'))
                        <div class="invalid-feedback">
                            {{ $errors->first('tahun_laptop') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.laptop.fields.tahun_laptop_helper') }}</span>
                </div>

                <!-- Garansi -->
                <div class="form-group">
                    <label for="garansi">{{ trans('cruds.laptop.fields.garansi') }}</label>
                    <input class="form-control {{ $errors->has('garansi') ? 'is-invalid' : '' }}" type="text" name="garansi" id="garansi" value="{{ old('garansi', '') }}">
                    @if ($errors->has('garansi'))
                        <div class="invalid-feedback">
                            {{ $errors->first('garansi') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.laptop.fields.garansi_helper') }}</span>
                </div>

                <!-- Charger -->
                <div class="form-group">
                    <label for="charger">{{ trans('cruds.laptop.fields.charger') }}</label>
                    <input class="form-control {{ $errors->has('charger') ? 'is-invalid' : '' }}" type="text" name="charger" id="charger" value="{{ old('charger', '') }}">
                    @if ($errors->has('charger'))
                        <div class="invalid-feedback">
                            {{ $errors->first('charger') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.laptop.fields.charger_helper') }}</span>
                </div>

                <!-- Tas -->
                <div class="form-group">
                    <label for="tas">{{ trans('cruds.laptop.fields.tas') }}</label>
                    <input class="form-control {{ $errors->has('tas') ? 'is-invalid' : '' }}" type="text" name="tas" id="tas" value="{{ old('tas', '') }}">
                    @if ($errors->has('tas'))
                        <div class="invalid-feedback">
                            {{ $errors->first('tas') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.laptop.fields.tas_helper') }}</span>
                </div>

                <!-- Cabang -->
                <div class="form-group">
                    <label for="cabang">{{ trans('cruds.laptop.fields.cabang') }}</label>
                    <input class="form-control {{ $errors->has('cabang') ? 'is-invalid' : '' }}" type="text" name="cabang" id="cabang" value="{{ old('cabang', '') }}">
                    @if ($errors->has('cabang'))
                        <div class="invalid-feedback">
                            {{ $errors->first('cabang') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.laptop.fields.cabang_helper') }}</span>
                </div>

                <!-- Bisnis Unit -->
                <div class="form-group">
                    <label for="bisnis_unit">{{ trans('cruds.laptop.fields.bisnis_unit') }}</label>
                    <input class="form-control {{ $errors->has('bisnis_unit') ? 'is-invalid' : '' }}" type="text" name="bisnis_unit" id="bisnis_unit" value="{{ old('bisnis_unit', '') }}">
                    @if ($errors->has('bisnis_unit'))
                        <div class="invalid-feedback">
                            {{ $errors->first('bisnis_unit') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.laptop.fields.bisnis_unit_helper') }}</span>
                </div>

                <!-- Save Button -->
                <div class="form-group">
                    <button class="btn btn-danger" type="submit">
                        {{ trans('global.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
