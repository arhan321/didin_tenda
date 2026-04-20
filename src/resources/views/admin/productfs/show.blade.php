@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.productfs.title_singular') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.productfs.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.productfs.fields.id') }}
                        </th>
                        <td>
                            {{ $productf->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.productfs.fields.title_1') }}
                        </th>
                        <td>
                            {{ $productf->title_1 }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.productfs.fields.title_2') }}
                        </th>
                        <td>
                            {{ $productf->title_2 }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.productfs.fields.category') }}
                        </th>
                        <td>
                            {{ $productf->category ?? 'Unknown' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.productfs.fields.image') }}
                        </th>
                        <td>
                            @if($productf->image)
                                <a href="{{ $productf->image->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $productf->image->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.productfs.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

@endsection
