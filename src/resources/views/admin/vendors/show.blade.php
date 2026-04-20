@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.vendor.title_singular') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <a class="btn btn-default" href="{{ route('admin.vendors.index') }}">
                {{ trans('global.back_to_list') }}
            </a>
        </div>
        <table class="table table-bordered table-striped">
            <tbody>
                <tr>
                    <th>
                        {{ trans('cruds.vendor.fields.id') }}
                    </th>
                    <td>
                        {{ $vendor->id }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('cruds.vendor.fields.name') }}
                    </th>
                    <td>
                        {{ $vendor->nama_vendor }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('cruds.vendor.fields.alamat') }}
                    </th>
                    <td>
                        {{ $vendor->alamat_vendor }}
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="form-group">
            <a class="btn btn-default" href="{{ route('admin.vendors.index') }}">
                {{ trans('global.back_to_list') }}
            </a>
        </div>
    </div>
</div>

@endsection
