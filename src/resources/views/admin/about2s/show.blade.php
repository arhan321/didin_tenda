@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.about2.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.about2s.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.about2.fields.id') }}
                        </th>
                        <td>
                            {{ $about2->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.about2.fields.no') }}
                        </th>
                        <td>
                            {{ $about2->no }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.about2.fields.title_1') }}
                        </th>
                        <td>
                            {{ $about2->title_1 }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.about2.fields.title_row') }}
                        </th>
                        <td>
                            {{ $about2->title_row }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.about2s.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

@endsection
