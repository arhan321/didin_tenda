@extends('layouts.admin')
@section('content')

@can('monitoring_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.monitorings.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.monitoring.title_singular') }}
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('cruds.monitoring.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover datatable datatable-Monitoring">
                <thead>
                    <tr>
                        <th width="10"></th>
                        <th>{{ trans('cruds.monitoring.fields.id') }}</th>
                        <th>{{ trans('cruds.monitoring.fields.product') }}</th>
                        {{-- <th>{{ trans('cruds.monitoring.fields.nama_client') }}</th> --}}
                        {{-- <th>{{ trans('cruds.monitoring.fields.branch_client') }}</th> --}}
                        {{-- <th>{{ trans('cruds.monitoring.fields.alamat_client') }}</th> --}}
                        <th>{{ trans('cruds.monitoring.fields.category') }}</th>
                        <th>{{ trans('cruds.monitoring.fields.vendor') }}</th>
                        <th>{{ trans('cruds.monitoring.fields.stock_awal') }}</th>
                        <th>{{ trans('cruds.monitoring.fields.stock_outstanding') }}</th>
                        <th>{{ trans('cruds.monitoring.fields.stock_sisa') }}</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($monitoring as $monitoring)
                        <tr data-entry-id="{{ $monitoring->id }}">
                            <td></td>
                            {{-- <td>{{ $monitoring->id ?? '' }}</td> --}}
                            <td>{{ $loop->iteration ?? '' }}</td>

                            <!-- Menampilkan Produk -->
                            <td>{{ $monitoring->product->name ?? 'Produk tidak tersedia' }}</td>

                            <!-- Menampilkan Nama Client -->
                            {{-- <td>{{ $monitoring->clientName->nama_client ?? 'Client tidak tersedia' }}</td> --}}

                            <!-- Menampilkan Branch Client -->
                            {{-- <td>{{ $monitoring->clientBranch->branch_client ?? 'Cabang tidak tersedia' }}</td> --}}

                            <!-- Menampilkan Alamat Client -->
                            {{-- <td>{{ $monitoring->clientAddress->alamat_client ?? 'Alamat tidak tersedia' }}</td> --}}

                            <!-- Menampilkan Kategori Produk -->
                            <td>{{ $monitoring->category->name ?? 'Kategori tidak tersedia' }}</td>

                            <!-- Menampilkan Vendor -->
                            <td>{{ $monitoring->vendor->nama_vendor ?? 'Vendor tidak tersedia' }}</td>

                            <!-- Menampilkan Stock Awal -->
                            <td>{{ $monitoring->stock_awal ?? '' }}</td>

                            <!-- Menampilkan Stock Outstanding -->
                            <td>{{ $monitoring->stock_outstanding ?? '' }}</td>

                             <!-- Menampilkan Stock sisa -->
                             <td>{{ $monitoring->stock_sisa ?? '' }}</td>
                            
                            <td>
                                @can('monitoring_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.monitorings.show', $monitoring->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('monitoring_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.monitorings.edit', $monitoring->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('monitoring_delete')
                                    <form action="{{ route('admin.monitorings.destroy', $monitoring->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
        @can('monitoring_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.monitorings.massDestroy') }}",
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
            order: [[ 1, 'desc' ]],
            pageLength: 100,
        });
        let table = $('.datatable-Monitoring:not(.ajaxTable)').DataTable({ buttons: dtButtons })
        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
            $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
        });
    })
</script>
@endsection
