@extends('layouts.admin')
@section('content')

@can('test_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.tests.create') }}">
                {{ trans('global.add') }} Test
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        Test {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover datatable datatable-Test">
                <thead>
                    <tr>
                        <th width="10"></th>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Umur</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tests as $key => $test)
                        <tr data-entry-id="{{ $test->id }}">
                            <td></td>
                            <td>{{ $test->id ?? '' }}</td>
                            <td>{{ $test->nama ?? '' }}</td>
                            <td>{{ $test->umur ?? '' }}</td>
                            <td>
                                @can('test_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.tests.show', $test->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('test_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.tests.edit', $test->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('test_delete')
                                    <form action="{{ route('admin.tests.destroy', $test->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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

        @can('test_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.tests.massDestroy') }}",
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
                            data: {
                                ids: ids,
                                _method: 'DELETE'
                            }
                        }).done(function () {
                            location.reload()
                        })
                    }
                }
            }

            dtButtons.push(deleteButton)
        @endcan

        $.extend(true, $.fn.dataTable.defaults, {
            orderCellsTop: true,
            order: [[1, 'desc']],
            pageLength: 100,
        });

        let table = $('.datatable-Test:not(.ajaxTable)').DataTable({
            buttons: dtButtons
        })

        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
            $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
        });
    })
</script>
@endsection