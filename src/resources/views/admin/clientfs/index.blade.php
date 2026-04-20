@extends('layouts.admin')
@section('content')

@can('clientf_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.clientfs.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.clientfs.title_singular') }}
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('cruds.clientfs.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Clientf">
                <thead>
                    <tr>
                        <th width="10"></th>
                        <th>{{ trans('cruds.clientfs.fields.id') }}</th>
                        <th>{{ trans('cruds.clientfs.fields.image') }}</th>
                        {{-- <th>{{ trans('cruds.clientfs.fields.stock_awal') }}</th> --}}
                        {{-- <th>{{ trans('cruds.clientfs.fields.stock_outstanding') }}</th>  --}}
                        {{-- <th>{{ trans('cruds.clientfs.fields.category') }}</th> --}}
                        {{-- <th>{{ trans('cruds.clientfs.fields.vendor') }}</th> <!-- Kolom Vendor --> --}}
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($clientfs as $key => $p)
                        <tr data-entry-id="{{ $p->id }}">
                            <td></td>
                            {{-- <td>{{ $clientfs->id ?? '' }}</td> --}}
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                @if($p->image)
                                    <a href="{{ $p->image->getUrl() }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $p->image->getUrl('thumb') }}">
                                    </a>
                                @endif
                            </td>
                            {{-- <td>{{ $clientfs->stock_awal ?? '' }}</td> --}}
                            {{-- <td>{{ $clientfs->stock_outstanding ?? '' }}</td> --}}
                            {{-- <td>{{ $clientfs->category->name ?? 'Data Belum diisi' }}</td> <!-- Kolom Category --> --}}
                            {{-- <td>{{ $clientfs->vendor->nama_vendor ?? 'Data Belum diisi' }}</td> <!-- Kolom Vendor --> --}}
                            <td>
                                @can('clientf_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.clientfs.show', $p->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('clientf_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.clientfs.edit', $p->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('clientf_delete')
                                    <form action="{{ route('admin.clientfs.destroy', $p->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
        @can('clientf_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.clientfs.massDestroy') }}",
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
        let table = $('.datatable-Clientf:not(.ajaxTable)').DataTable({ buttons: dtButtons })
        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
            $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
        });
    })
</script>
@endsection
