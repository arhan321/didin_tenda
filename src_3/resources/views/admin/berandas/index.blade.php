@extends('layouts.admin')
@section('content')

@can('beranda_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.berandas.create') }}">
                Tambah Beranda
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        Beranda List
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-beranda">
                <thead>
                    <tr>
                        <th width="10"></th>
                        <th>ID</th>
                        <th>Title 1</th>
                        <th>Title 2</th>
                        <th>Deskripsi</th>
                        <th>Image</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($berandas as $key => $beranda)
                        <tr data-entry-id="{{ $beranda->id }}">
                            <td></td>

                            <td>
                                {{ $beranda->id ?? '' }}
                            </td>

                            <td>
                                {{ $beranda->title_1 ?? '' }}
                            </td>

                            <td>
                                {{ $beranda->title_2 ?? '' }}
                            </td>

                            <td>
                                {{ \Illuminate\Support\Str::limit($beranda->deskripsi, 80) }}
                            </td>

                            <td>
                                @if($beranda->image)
                                    <a href="{{ asset('storage/' . $beranda->image) }}" target="_blank" style="display: inline-block;">
                                        <img src="{{ asset('storage/' . $beranda->image) }}" width="100" style="border-radius: 6px;">
                                    </a>
                                @endif
                            </td>

                            <td>
                                @can('beranda_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.berandas.show', $beranda->id) }}">
                                        View
                                    </a>
                                @endcan

                                @can('beranda_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.berandas.edit', $beranda->id) }}">
                                        Edit
                                    </a>
                                @endcan

                                @can('beranda_delete')
                                    <form action="{{ route('admin.berandas.destroy', $beranda->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin?');" style="display: inline-block;">
                                        @method('DELETE')
                                        @csrf
                                        <input type="submit" class="btn btn-xs btn-danger" value="Delete">
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

        @can('beranda_delete')
            let deleteButton = {
                text: 'Delete selected',
                url: "{{ route('admin.berandas.massDestroy') }}",
                className: 'btn-danger',
                action: function (e, dt, node, config) {
                    var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
                        return $(entry).data('entry-id')
                    });

                    if (ids.length === 0) {
                        alert('Tidak ada data yang dipilih')
                        return
                    }

                    if (confirm('Apakah Anda yakin?')) {
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

        let table = $('.datatable-beranda:not(.ajaxTable)').DataTable({
            buttons: dtButtons
        })

        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });
    })
</script>
@endsection