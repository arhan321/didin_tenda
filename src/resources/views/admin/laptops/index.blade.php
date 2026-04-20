@extends('layouts.admin')
@section('content')

@can('laptop_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.laptops.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.laptop.title_singular') }}
            </a>
        </div>
    </div>
@endcan


<div class="card">
    <div class="card-header">
        {{ trans('cruds.laptop.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Laptop">
                <thead>
                    <tr>
                        <th width="10"></th>
                        <th>{{ trans('cruds.laptop.fields.id') }}</th> <!-- Ganti menjadi nomor urut -->
                        <th>{{ trans('cruds.laptop.fields.nama_user') }}</th>
                        <th>{{ trans('cruds.laptop.fields.type_laptop') }}</th>
                        <th>{{ trans('cruds.laptop.fields.sn_laptop') }}</th>
                        <th>{{ trans('cruds.laptop.fields.tahun_laptop') }}</th>
                        <th>{{ trans('cruds.laptop.fields.garansi') }}</th>
                        <th>{{ trans('cruds.laptop.fields.charger') }}</th>
                        <th>{{ trans('cruds.laptop.fields.tas') }}</th>
                        <th>{{ trans('cruds.laptop.fields.cabang') }}</th>
                        <th>{{ trans('cruds.laptop.fields.bisnis_unit') }}</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($laptops as $key => $l)
                        <tr data-entry-id="{{ $l->id }}">
                            <td></td>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $l->nama_user }}</td>
                            <td>{{ $l->type_laptop }}</td>
                            <td>{{ $l->sn_laptop }}</td>
                            <td>{{ $l->tahun_laptop }}</td>
                            <td>{{ $l->garansi }}</td>
                            <td>{{ $l->charger }}</td>
                            <td>{{ $l->tas }}</td>
                            <td>{{ $l->cabang }}</td>
                            <td>{{ $l->bisnis_unit }}</td>
                            <td>
                                @can('laptop_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.laptops.show', $l->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('laptop_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.laptops.edit', $l->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('laptop_delete')
                                    <form action="{{ route('admin.laptops.destroy', $l->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
        @can('laptop_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.laptops.massDestroy') }}",
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
                        })
                        .done(function () { location.reload() })
                    }
                }
            }
            dtButtons.push(deleteButton)
        @endcan

        $.extend(true, $.fn.dataTable.defaults, {
            orderCellsTop: true,
            order: [[ 1, 'desc' ]], // Urutan tetap berdasarkan kolom pertama
            pageLength: 100,
        });
        let table = $('.datatable-Laptop:not(.ajaxTable)').DataTable({ buttons: dtButtons })
        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
            $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
        });
    })
</script>
@endsection
