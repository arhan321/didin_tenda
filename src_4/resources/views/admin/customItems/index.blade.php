@extends('layouts.admin')
@section('content')

@can('custom_item_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.custom-items.create') }}">
                Tambah Custom Item
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        Custom Item List
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-custom-item">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            ID
                        </th>
                        <th>
                            Gambar
                        </th>
                        <th>
                            Nama
                        </th>
                        <th>
                            Slug
                        </th>
                        <th>
                            Description
                        </th>
                        <th>
                            Harga
                        </th>
                        <th>
                            Unit
                        </th>
                        <th>
                            Min Qty
                        </th>
                        <th>
                            Max Qty
                        </th>
                        <th>
                            Icon
                        </th>
                        <th>
                            Active
                        </th>
                        <th>
                            Sort
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($customItems as $key => $customItem)
                        <tr data-entry-id="{{ $customItem->id }}">
                            <td>

                            </td>

                            <td>
                                {{ $customItem->id ?? '' }}
                            </td>

                            <td>
                                @if($customItem->image)
                                    <a href="{{ asset('storage/' . $customItem->image) }}" target="_blank" style="display: inline-block;">
                                        <img src="{{ asset('storage/' . $customItem->image) }}" width="80" style="border-radius: 6px;">
                                    </a>
                                @else
                                    -
                                @endif
                            </td>

                            <td>
                                {{ $customItem->name ?? '' }}
                            </td>

                            <td>
                                {{ $customItem->slug ?? '' }}
                            </td>

                            <td>
                                {{ \Illuminate\Support\Str::limit($customItem->description, 80) }}
                            </td>

                            <td>
                                Rp {{ number_format($customItem->price ?? 0, 0, ',', '.') }}
                            </td>

                            <td>
                                {{ $customItem->unit ?? '' }}
                            </td>

                            <td>
                                {{ $customItem->min_quantity ?? 0 }}
                            </td>

                            <td>
                                {{ $customItem->max_quantity ?? '-' }}
                            </td>

                            <td>
                                @if($customItem->icon)
                                    <i class="{{ $customItem->icon }}"></i>
                                    {{ $customItem->icon }}
                                @else
                                    -
                                @endif
                            </td>

                            <td>
                                @if($customItem->is_active)
                                    <span class="badge badge-primary">
                                        Aktif
                                    </span>
                                @else
                                    <span class="badge badge-danger">
                                        Nonaktif
                                    </span>
                                @endif
                            </td>

                            <td>
                                {{ $customItem->sort_order ?? 0 }}
                            </td>

                            <td>
                                @can('custom_item_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.custom-items.show', $customItem->id) }}">
                                        View
                                    </a>
                                @endcan

                                @can('custom_item_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.custom-items.edit', $customItem->id) }}">
                                        Edit
                                    </a>
                                @endcan

                                @can('custom_item_delete')
                                    <form action="{{ route('admin.custom-items.destroy', $customItem->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin?');" style="display: inline-block;">
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

        @can('custom_item_delete')
            let deleteButtonTrans = 'Delete selected'
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.custom-items.massDestroy') }}",
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

        let table = $('.datatable-custom-item:not(.ajaxTable)').DataTable({
            buttons: dtButtons
        })

        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });
    })
</script>
@endsection