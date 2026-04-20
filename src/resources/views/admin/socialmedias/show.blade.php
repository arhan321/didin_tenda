@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.socialmedias.title_singular') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <a class="btn btn-default" href="{{ route('admin.socialmedias.index') }}">
                {{ trans('global.back_to_list') }}
            </a>
        </div>
        
        <table class="table table-bordered table-striped">
            <tbody>
                <tr>
                    <th>
                        {{ trans('cruds.socialmedias.fields.id') }}
                    </th>
                    <td>
                        {{ $socialmedia->id }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('cruds.socialmedias.fields.name') }}
                    </th>
                    <td>
                        {{ $socialmedia->name }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('cruds.socialmedias.fields.icon') }}
                    </th>
                    <td>
                        {{ $socialmedia->icon }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('cruds.socialmedias.fields.link') }}
                    </th>
                    <td>
                        {{ $socialmedia->link }}
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="form-group">
            <a class="btn btn-default" href="{{ route('admin.socialmedias.index') }}">
                {{ trans('global.back_to_list') }}
            </a>
        </div>
    </div>
</div>

@endsection
