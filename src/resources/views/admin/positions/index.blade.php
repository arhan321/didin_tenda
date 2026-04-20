@extends('layouts.admin')
@section('content')
@can('position_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.positions.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.position.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.position.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover datatable datatable-Position">
                <thead>
                    <tr>
                        <th width="10"></th>
                        <th>{{ trans('cruds.position.fields.id') }}</th>
                        <th>{{ trans('cruds.position.fields.nama_posisi') }}</th>
                        {{-- <th>{{ trans('cruds.position.fields.deskripsi_posisi') }}</th> --}}
                        <th>{{ trans('cruds.position.fields.tugas_posisi') }}</th>
                        <th>{{ trans('cruds.position.fields.gaji_pokok') }}</th>
                        <th>{{ trans('cruds.position.fields.tunjangan_makan') }}</th>
                        <th>{{ trans('cruds.position.fields.tunjangan_transport') }}</th>
                        <th>{{ trans('cruds.position.fields.tunjangan_kesehatan') }}</th>
                        <th>{{ trans('cruds.position.fields.tunjangan_ketenagakerjaan') }}</th>
                        <th>{{ trans('cruds.position.fields.total_gaji') }}</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($positions as $key => $p)
                        <tr data-entry-id="{{ $p->id }}">
                            <td></td>
                            <td>{{ $p->id ?? '' }}</td>
                            <td>{{ $p->nama_posisi ?? '' }}</td>
                            {{-- <td>{{ $p->deskripsi_posisi ?? '' }}</td> --}}
                            <td>{!! $p->tugas_posisi ?? '' !!}</td>
                            <td>{{ 'Rp ' . number_format($p->gaji_pokok ?? 0, 0, ',', '.') }}</td>
                            <td>{{ 'Rp ' . number_format($p->tunjangan_makan ?? 0, 0, ',', '.') }}</td>
                            <td>{{ 'Rp ' . number_format($p->tunjangan_transport ?? 0, 0, ',', '.') }}</td>
                            <td>{{ 'Rp ' . number_format($p->tunjangan_kesehatan ?? 0, 0, ',', '.') }}</td>
                            <td>{{ 'Rp ' . number_format($p->tunjangan_ketenagakerjaan ?? 0, 0, ',', '.') }}</td>
                            <td>{{ 'Rp ' . number_format($p->total_gaji ?? 0, 0, ',', '.') }}</td>
                            <td>
                                @can('position_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.positions.show', $p->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('position_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.positions.edit', $p->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('position_delete')
                                    <form action="{{ route('admin.positions.destroy', $p->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@endsection

@section('scripts')
@parent
<script>
    $(function () {
        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
        @can('position_delete')
        let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
        let deleteButton = {
            text: deleteButtonTrans,
            url: "{{ route('admin.positions.massDestroy') }}",
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
        let table = $('.datatable-Position:not(.ajaxTable)').DataTable({ buttons: dtButtons })
        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });
    });
</script>
@endsection
