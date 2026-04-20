@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.laptop.title_singular') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <a class="btn btn-default" href="{{ route('admin.laptops.index') }}">
                {{ trans('global.back_to_list') }}
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>{{ trans('cruds.laptop.fields.id') }}</th>
                        <td>{{ $laptop->id }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.laptop.fields.nama_user') }}</th>
                        <td>{{ $laptop->nama_user }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.laptop.fields.type_laptop') }}</th>
                        <td>{{ $laptop->type_laptop }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.laptop.fields.sn_laptop') }}</th>
                        <td>{{ $laptop->sn_laptop }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.laptop.fields.tahun_laptop') }}</th>
                        <td>{{ $laptop->tahun_laptop }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.laptop.fields.garansi') }}</th>
                        <td>{{ $laptop->garansi }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.laptop.fields.charger') }}</th>
                        <td>{{ $laptop->charger }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.laptop.fields.tas') }}</th>
                        <td>{{ $laptop->tas }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.laptop.fields.cabang') }}</th>
                        <td>{{ $laptop->cabang }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.laptop.fields.bisnis_unit') }}</th>
                        <td>{{ $laptop->bisnis_unit }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="form-group" style="margin-top: 10px;">
            <a class="btn btn-default" href="{{ route('admin.laptops.index') }}">
                {{ trans('global.back_to_list') }}
            </a>
        </div>
    </div>
</div>

@endsection
