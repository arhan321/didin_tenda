@extends('layouts.admin')
@section('content')

@can('contact_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.contacts.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.contacts.title_singular') }}
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('cruds.contacts.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover datatable datatable-contacts">
                <thead>
                    <tr>
                        <th width="10"></th>
                        <th>{{ trans('cruds.contacts.fields.id') }}</th>
                        <th>{{ trans('cruds.contacts.fields.full_name') }}</th>
                        <th>{{ trans('cruds.contacts.fields.email') }}</th>
                        <th>{{ trans('cruds.contacts.fields.subject') }}</th>
                        <th>{{ trans('cruds.contacts.fields.message') }}</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($contacts as $key => $p)
                        <tr data-entry-id="{{ $p->id }}">
                            <td></td>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $p->full_name ?? '' }}</td>
                            <td>{{ $p->email ?? '' }}</td>
                            <td>{{ $p->subject ?? '' }}</td>
                            <td>{{ $p->message ?? '' }}</td>
                            <td>
                                @can('contact_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.contacts.show', $p->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('contact_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.contacts.edit', $p->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('contact_delete')
                                    <form action="{{ route('admin.contacts.destroy', $p->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
        @can('contact_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.contacts.massDestroy') }}",
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
        let table = $('.datatable-contacts:not(.ajaxTable)').DataTable({ buttons: dtButtons })
        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
            $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
        });
    })
</script>
@endsection
