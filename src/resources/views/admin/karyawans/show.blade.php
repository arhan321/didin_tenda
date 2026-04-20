@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.karyawan.title_singular') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.karyawans.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped table-hover">
                <tbody>
                    <tr>
                        <th>{{ trans('cruds.karyawan.fields.id') }}</th>
                        <td>{{ $karyawan->id }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.karyawan.fields.image_karyawan') }}</th>
                        <td>
                            @if($karyawan->image)
                                <a href="{{ $karyawan->image->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $karyawan->image->getUrl('thumb') }}" alt="Karyawan Image" class="img-thumbnail">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.karyawan.fields.nama_karyawan') }}</th>
                        <td>{{ $karyawan->nama_karyawan }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.karyawan.fields.alamat') }}</th>
                        <td>{{ $karyawan->alamat }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.karyawan.fields.no_telp') }}</th>
                        <td>{{ $karyawan->no_telp }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.karyawan.fields.email') }}</th>
                        <td>{{ $karyawan->email }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.karyawan.fields.jenis_kelamin') }}</th>
                        <td>{{ $karyawan->jenis_kelamin }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.karyawan.fields.tanggal_lahir') }}</th>
                        <td>{{ $karyawan->tanggal_lahir }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.karyawan.fields.tempat_lahir') }}</th>
                        <td>{{ $karyawan->tempat_lahir }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.karyawan.fields.position_id') }}</th>
                        <td>{{ $karyawan->position->nama_posisi ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.karyawan.fields.gaji_id') }}</th>
                        <td>{{ $karyawan->gaji ? number_format($karyawan->gaji, 0, ',', '.') : '' }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.karyawan.fields.status') }}</th>
                        <td>
                            @if ($karyawan->status == 'Tidak Aktif')
                                <span class="status-tidak_aktif">{{ App\Models\Karyawan::STATUS_SELECT['Tidak Aktif'] ?? 'Tidak Aktif' }}</span>
                            @elseif($karyawan->status == 'Aktif')
                                <span class="status-aktif">{{ App\Models\Karyawan::STATUS_SELECT['Aktif'] ?? 'Aktif' }}</span>
                            @else
                                {{ App\Models\Karyawan::STATUS_SELECT[$karyawan->status] ?? '' }}
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.karyawans.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    .status-tidak_aktif {
        background-color: red;
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
        font-weight: bold;
        margin: 5px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        display: inline-block;
    }

    .status-aktif {
        background-color: green;
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
        font-weight: bold;
        margin: 5px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        display: inline-block;
    }
</style>

@endsection
