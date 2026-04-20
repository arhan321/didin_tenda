@extends('layouts.admin')
@section('content')

@can('sahabatechproduct_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.productech.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.sahabatechbarang.title_singular') }}
            </a>
        </div>
    </div>
@endcan


<div class="card">
    <div class="card-header">
        {{ trans('cruds.sahabatechbarang.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Product">
                <thead>
                    <tr>
                        <th width="10"></th>
                        <th>{{ trans('cruds.sahabatechbarang.fields.id') }}</th> <!-- Ganti menjadi nomor urut -->
                        <th>{{ trans('cruds.sahabatechbarang.fields.name') }}</th>
                        <th>{{ trans('cruds.sahabatechbarang.fields.harga_beli') }}</th>
                        <th>{{ trans('cruds.sahabatechbarang.fields.harga_jual') }}</th>
                        <th>{{ trans('cruds.sahabatechbarang.fields.stock_barang') }}</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($producteches as $key => $barang)
                        <tr data-entry-id="{{ $barang->id }}">
                            <td></td>
                            <td>{{ $loop->iteration }}</td> <!-- Nomor Urut Berjalan -->
                            <td>{{ $barang->name ?? '' }}</td>
                            <td>{{ 'Rp ' . number_format($barang->harga_beli ?? 0, 2, ',', '.') }}</td>
                            <td>{{ 'Rp ' . number_format($barang->harga_jual ?? 0, 2, ',', '.') }}</td>
                            <td>{{ $barang->stock_barang ?? '' }}</td>
                            <td>
                                @can('sahabatechproduct_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.productech.show', $barang->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('sahabatechproduct_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.productech.edit', $barang->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('sahabatechproduct_delete')
                                    <form action="{{ route('admin.productech.destroy', $barang->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
        @can('sahabatechproduct_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.productech.massDestroy') }}",
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
        let table = $('.datatable-Product:not(.ajaxTable)').DataTable({ buttons: dtButtons })
        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
            $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
        });
    })
</script>
@endsection
