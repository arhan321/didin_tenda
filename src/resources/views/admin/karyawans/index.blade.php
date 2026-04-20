@extends('layouts.admin')
@section('content')
@can('karyawan_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.karyawans.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.karyawan.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.karyawan.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Karyawan">
                <thead>
                    <tr>
                        <th width="10"></th>
                        <th>{{ trans('cruds.karyawan.fields.id') }}</th>
                        <th>{{ trans('cruds.karyawan.fields.image_karyawan') }}</th>
                        <th>{{ trans('cruds.karyawan.fields.nama_karyawan') }}</th>
                        <th>{{ trans('cruds.karyawan.fields.alamat') }}</th>
                        <th>{{ trans('cruds.karyawan.fields.no_telp') }}</th>
                        <th>{{ trans('cruds.karyawan.fields.email') }}</th>
                        <th>{{ trans('cruds.karyawan.fields.jenis_kelamin') }}</th>
                        <th>{{ trans('cruds.karyawan.fields.tanggal_lahir') }}</th>
                        <th>{{ trans('cruds.karyawan.fields.tempat_lahir') }}</th>
                        <th>{{ trans('cruds.karyawan.fields.position_id') }}</th>
                        <th>{{ trans('cruds.karyawan.fields.gaji_id') }}</th>
                        <th>{{ trans('cruds.karyawan.fields.status') }}</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($karyawans as $key => $karyawan)
                        <tr data-entry-id="{{ $karyawan->id }}">
                            <td></td>
                            <td>{{ $karyawan->id ?? '' }}</td>
                            <td>
                                @if($karyawan->image)
                                    <a href="{{ $karyawan->image->getUrl() }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $karyawan->image->getUrl('thumb') }}">
                                    </a>
                                @endif
                            </td>
                            <td>{{ $karyawan->nama_karyawan ?? '' }}</td>
                            <td>{{ $karyawan->alamat ?? '' }}</td>
                            <td>{{ $karyawan->no_telp ?? '' }}</td>
                            <td>{{ $karyawan->email ?? '' }}</td>
                            <td>{{ $karyawan->jenis_kelamin ?? '' }}</td>
                            <td>{{ $karyawan->tanggal_lahir ?? '' }}</td>
                            <td>{{ $karyawan->tempat_lahir ?? '' }}</td>
                            <td>{{ $karyawan->position->nama_posisi ?? '' }}</td>
                            <td>{{ $karyawan->gaji ? number_format($karyawan->gaji, 0, ',', '.') : '' }}</td>
                            <td>
                                @if ($karyawan->status == 'Tidak Aktif')
                                    <span
                                        class="status-tidak_aktif">{{ App\Models\Karyawan::STATUS_SELECT['Tidak_Aktif'] ?? 'Tidak Aktif' }}</span>
                                @elseif($karyawan->status == 'Aktif')
                                    <span
                                        class="status-aktif">{{ App\Models\Karyawan::STATUS_SELECT['Aktif'] ?? 'Aktif' }}</span>
                                @else
                                    {{ App\Models\Karyawan::STATUS_SELECT[$karyawan->status] ?? '' }}
                                @endif
                            </td>
                            <td>
                                @can('karyawan_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.karyawans.show', $karyawan->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan
                                @can('karyawan_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.karyawans.edit', $karyawan->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan
                                @can('karyawan_delete')
                                    <form action="{{ route('admin.karyawans.destroy', $karyawan->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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
        transition: background-color 0.3s, box-shadow 0.3s;
        display: inline-block;
    }

    .status-tidak_aktif:hover {
        background-color: darkred;
        box-shadow: 0 6px 8px rgba(0, 0, 0, 0.2);
    }

    .status-aktif {
        background-color: green;
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
        font-weight: bold;
        margin: 5px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: background-color 0.3s, box-shadow 0.3s;
        display: inline-block;
    }

    .status-aktif:hover {
        background-color: darkgreen;
        box-shadow: 0 6px 8px rgba(0, 0, 0, 0.2);
    }
</style>
@endsection

@section('scripts')
@parent
<script>
    $(function () {
        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
        @can('karyawan_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.karyawans.massDestroy') }}",
                className: 'btn-danger',
                action: function (e, dt, node, config) {
                    var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
                        return $(entry).data('entry-id')
                    });

                    if (ids.length === 0) {
                        alert('{{ trans('global.datatables.zero_selected') }}')
                        return
                    }

                    if (confirm('{{ trans('global.areYouSure') }}')) {
                        $.ajax({
                            headers: {'x-csrf-token': _token},
                            method: 'POST',
                            url: config.url,
                            data: { ids: ids, _method: 'DELETE' }
                        }).done(function () { location.reload() })
                    }
                }
            }
            dtButtons.push(deleteButton)
        @endcan

        $.extend(true, $.fn.dataTable.defaults, {
            orderCellsTop: true,
            order: [[ 1, 'desc' ]],
            pageLength: 100,
        });
        let table = $('.datatable-Karyawan:not(.ajaxTable)').DataTable({ buttons: dtButtons })
        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });
    })
</script>
@endsection
