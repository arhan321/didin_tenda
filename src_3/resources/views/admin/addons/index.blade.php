@extends('layouts.admin')
@section('content')

@can('addon_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.addons.create') }}">
                Tambah Addon
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        Addon List
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover datatable datatable-Addon">
                <thead>
                    <tr>
                        <th width="10"></th>
                        <th>ID</th>
                        <th>Gambar</th>
                        <th>Nama</th>
                        <th>Slug</th>
                        <th>Detail</th>
                        <th>Harga</th>
                        <th>Unit</th>
                        <th>Qty Based</th>
                        <th>Stock</th>
                        <th>Icon</th>
                        <th>Active</th>
                        <th>Sort</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($addons as $key => $addon)
                        <tr data-entry-id="{{ $addon->id }}">
                            <td></td>

                            <td>
                                {{ $addon->id ?? '' }}
                            </td>

                            <td>
                                @if($addon->image)
                                    <a href="{{ asset('storage/' . $addon->image) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $addon->image) }}" width="80" style="border-radius: 6px;">
                                    </a>
                                @endif
                            </td>

                            <td>
                                {{ $addon->name ?? '' }}
                            </td>

                            <td>
                                {{ $addon->slug ?? '' }}
                            </td>

                            <td>
                                {{ Str::limit($addon->detail, 60) }}
                            </td>

                            <td>
                                Rp {{ number_format($addon->price ?? 0, 0, ',', '.') }}
                            </td>

                            <td>
                                {{ $addon->unit ?? '' }}
                            </td>

                            <td>
                                @if($addon->is_quantity_based)
                                    <span class="badge badge-success">Ya</span>
                                @else
                                    <span class="badge badge-secondary">Tidak</span>
                                @endif
                            </td>

                            <td>
                                {{ $addon->stock ?? '-' }}
                            </td>

                            <td>
                                @if($addon->icon)
                                    <i class="{{ $addon->icon }}"></i>
                                    <small>{{ $addon->icon }}</small>
                                @endif
                            </td>

                            <td>
                                @if($addon->is_active)
                                    <span class="badge badge-primary">Aktif</span>
                                @else
                                    <span class="badge badge-danger">Nonaktif</span>
                                @endif
                            </td>

                            <td>
                                {{ $addon->sort_order ?? 0 }}
                            </td>

                            <td>
                                @can('addon_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.addons.show', $addon->id) }}">
                                        View
                                    </a>
                                @endcan

                                @can('addon_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.addons.edit', $addon->id) }}">
                                        Edit
                                    </a>
                                @endcan

                                @can('addon_delete')
                                    <form action="{{ route('admin.addons.destroy', $addon->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin?');" style="display: inline-block;">
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

        @can('addon_delete')
            let deleteButton = {
                text: 'Delete selected',
                url: "{{ route('admin.addons.massDestroy') }}",
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

        let table = $('.datatable-Addon:not(.ajaxTable)').DataTable({
            buttons: dtButtons
        });

        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
            $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
        });
    })
</script>
@endsection