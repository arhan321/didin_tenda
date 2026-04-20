@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.sahabatechbarang.title_singular') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.productech.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.sahabatechbarang.fields.id') }}
                        </th>
                        <td>
                            {{ $productech->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.sahabatechbarang.fields.name') }}
                        </th>
                        <td>
                            {{ $productech->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.sahabatechbarang.fields.harga_beli') }}
                        </th>
                        <td>
                            {{ 'Rp ' . number_format($productech->harga_beli, 2, ',', '.') }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.sahabatechbarang.fields.harga_jual') }}
                        </th>
                        <td>
                            {{ 'Rp ' . number_format($productech->harga_jual, 2, ',', '.') }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.sahabatechbarang.fields.stock_barang') }}
                        </th>
                        <td>
                            {{ $productech->stock_barang }}
                        </td>
                    </tr>
                    {{-- <tr>
                        <th>
                            {{ trans('cruds.sahabatechbarang.fields.jangka_waktu') }}
                        </th>
                        <td>
                            {{ $productech->jangka_waktu }}
                        </td>
                    </tr> --}}
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.productech.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

@endsection
