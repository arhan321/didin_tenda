@extends('layouts.admin')
@section('content')

@can('productf_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.productfs.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.productfs.title_singular') }}
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('cruds.productfs.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Product">
                <thead>
                    <tr>
                        <th width="10"></th>
                        <th>{{ trans('cruds.productfs.fields.id') }}</th>
                        <th>{{ trans('cruds.productfs.fields.title_1') }}</th>
                        <th>{{ trans('cruds.productfs.fields.title_2') }}</th>
                        <th>{{ trans('cruds.productfs.fields.category') }}</th>
                        <th>{{ trans('cruds.productfs.fields.image') }}</th>
                        {{-- <th>{{ trans('cruds.productfs.fields.stock_awal') }}</th> --}}
                        {{-- <th>{{ trans('cruds.productfs.fields.stock_outstanding') }}</th>  --}}
                        {{-- <th>{{ trans('cruds.productfs.fields.category') }}</th> --}}
                        {{-- <th>{{ trans('cruds.productfs.fields.vendor') }}</th> <!-- Kolom Vendor --> --}}
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($productfs as $key => $p)
                        <tr data-entry-id="{{ $p->id }}">
                            <td></td>
                            {{-- <td>{{ $productfs->id ?? '' }}</td> --}}
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $p->title_1 ?? '' }}</td>
                            <td>{{ $p->title_2 ?? '' }}</td>
                            <td>
                               {{$p->category ?? ''}}
                            </td>
                            <td>
                                @if($p->image)
                                    <a href="{{ $p->image->getUrl() }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $p->image->getUrl('thumb') }}">
                                    </a>
                                @endif
                            </td>
                            {{-- <td>{{ $productfs->stock_awal ?? '' }}</td> --}}
                            {{-- <td>{{ $productfs->stock_outstanding ?? '' }}</td> --}}
                            {{-- <td>{{ $productfs->category->name ?? 'Data Belum diisi' }}</td> <!-- Kolom Category --> --}}
                            {{-- <td>{{ $productfs->vendor->nama_vendor ?? 'Data Belum diisi' }}</td> <!-- Kolom Vendor --> --}}
                            <td>
                                @can('productf_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.productfs.show', $p->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('productf_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.productfs.edit', $p->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('productf_delete')
                                    <form action="{{ route('admin.productfs.destroy', $p->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
        @can('productf_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.productfs.massDestroy') }}",
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
        let table = $('.datatable-Product:not(.ajaxTable)').DataTable({ buttons: dtButtons })
        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
            $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
        });
    })
</script>
@endsection
