@extends('layouts.admin')

@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.monitoring.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.monitorings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.monitoring.fields.id') }}
                        </th>
                        <td>
                            {{ $monitoring->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.monitoring.fields.product') }}
                        </th>
                        <td>
                            {{ $monitoring->product->name ?? 'N/A' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.monitoring.fields.category') }}
                        </th>
                        <td>
                            {{ $monitoring->category->name ?? 'N/A' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.monitoring.fields.vendor') }}
                        </th>
                        <td>
                            {{ $monitoring->vendor->nama_vendor ?? 'N/A' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.monitoring.fields.stock_awal') }}
                        </th>
                        <td>
                            {{ $monitoring->stock_awal }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.monitoring.fields.stock_outstanding') }}
                        </th>
                        <td>
                            {{ $monitoring->stock_outstanding }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.monitorings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

@endsection
