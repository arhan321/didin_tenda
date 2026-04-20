@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.position.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.positions.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.position.fields.id') }}
                        </th>
                        <td>
                            {{ $position->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.position.fields.nama_posisi') }}
                        </th>
                        <td>
                            {{ $position->nama_posisi }}
                        </td>
                    </tr>
                    {{-- <tr>
                        <th>
                            {{ trans('cruds.position.fields.deskripsi_posisi') }}
                        </th>
                        <td>
                            {{ $position->deskripsi_posisi }}
                        </td>
                    </tr> --}}
                    <tr>
                        <th>
                            {{ trans('cruds.position.fields.tugas_posisi') }}
                        </th>
                        <td>
                            {!! $position->tugas_posisi !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.position.fields.gaji_pokok') }}
                        </th>
                        <td>
                            {{ number_format($position->gaji_pokok, 0, ',', '.') }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.position.fields.tunjangan_makan') }}
                        </th>
                        <td>
                            {{ number_format($position->tunjangan_makan, 0, ',', '.') }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.position.fields.tunjangan_transport') }}
                        </th>
                        <td>
                            {{ number_format($position->tunjangan_transport, 0, ',', '.') }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.position.fields.tunjangan_kesehatan') }}
                        </th>
                        <td>
                            {{ number_format($position->tunjangan_kesehatan, 0, ',', '.') }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.position.fields.tunjangan_ketenagakerjaan') }}
                        </th>
                        <td>
                            {{ number_format($position->tunjangan_ketenagakerjaan, 0, ',', '.') }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.position.fields.total_gaji') }}
                        </th>
                        <td>
                            {{ number_format($position->total_gaji, 0, ',', '.') }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.positions.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

@endsection
