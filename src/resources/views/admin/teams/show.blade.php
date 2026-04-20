@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.teams.title_singular') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.teams.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.teams.fields.id') }}
                        </th>
                        <td>
                            {{ $team->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.teams.fields.name') }}
                        </th>
                        <td>
                            {{ $team->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.teams.fields.description') }}
                        </th>
                        <td>
                            {{ $team->description }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.teams.fields.position') }}
                        </th>
                        <td>
                            {{ $team->position ?? 'Unknown' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.teams.fields.image') }}
                        </th>
                        <td>
                            @if($team->image)
                                <a href="{{ $team->image->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $team->image->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.teams.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

@endsection
