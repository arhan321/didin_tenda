@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.settings.title_singular') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <a class="btn btn-default" href="{{ route('admin.settings.index') }}">
                {{ trans('global.back_to_list') }}
            </a>
        </div>
        
        <table class="table table-bordered table-striped">
            <tbody>
                <tr>
                    <th>
                        {{ trans('cruds.settings.fields.id') }}
                    </th>
                    <td>
                        {{ $setting->id }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('cruds.settings.fields.address') }}
                    </th>
                    <td>
                        {{ $setting->address }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('cruds.settings.fields.company_name') }}
                    </th>
                    <td>
                        {{ $setting->company_name }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('cruds.settings.fields.phone') }}
                    </th>
                    <td>
                        {{ $setting->phone }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('cruds.settings.fields.email') }}
                    </th>
                    <td>
                        {{ $setting->email }}
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="form-group">
            <a class="btn btn-default" href="{{ route('admin.settings.index') }}">
                {{ trans('global.back_to_list') }}
            </a>
        </div>
    </div>
</div>

@endsection
