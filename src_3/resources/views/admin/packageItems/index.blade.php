@extends('layouts.admin')
@section('content')

@can('package_item_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.package-items.create', request()->filled('package_id') ? ['package_id' => request('package_id')] : []) }}">
                Tambah Package Item
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        Package Item List
    </div>

    <div class="card-body">
        <form method="GET" action="{{ route('admin.package-items.index') }}" class="mb-3">
            <div class="row">
                <div class="col-md-4">
                    <select name="package_id" class="form-control">
                        <option value="">Semua Package</option>
                        @foreach($packages as $package)
                            <option value="{{ $package->id }}" {{ request('package_id') == $package->id ? 'selected' : '' }}>
                                {{ $package->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">
                        Filter
                    </button>

                    <a href="{{ route('admin.package-items.index') }}" class="btn btn-default">
                        Reset
                    </a>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover datatable datatable-PackageItem">
                <thead>
                    <tr>
                        <th width="10"></th>
                        <th>ID</th>
                        <th>Package</th>
                        <th>Nama Item</th>
                        <th>Quantity</th>
                        <th>Unit</th>
                        <th>Description</th>
                        <th>Sort</th>
                        <th>Active</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($packageItems as $key => $packageItem)
                        <tr data-entry-id="{{ $packageItem->id }}">
                            <td></td>

                            <td>
                                {{ $packageItem->id ?? '' }}
                            </td>

                            <td>
                                {{ $packageItem->package->name ?? '' }}
                            </td>

                            <td>
                                {{ $packageItem->name ?? '' }}
                            </td>

                            <td>
                                {{ $packageItem->quantity ?? '' }}
                            </td>

                            <td>
                                {{ $packageItem->unit ?? '' }}
                            </td>

                            <td>
                                {{ Str::limit($packageItem->description, 80) }}
                            </td>

                            <td>
                                {{ $packageItem->sort_order ?? 0 }}
                            </td>

                            <td>
                                @if($packageItem->is_active)
                                    <span class="badge badge-primary">Aktif</span>
                                @else
                                    <span class="badge badge-danger">Nonaktif</span>
                                @endif
                            </td>

                            <td>
                                @can('package_item_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.package-items.show', $packageItem->id) }}">
                                        View
                                    </a>
                                @endcan

                                @can('package_item_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.package-items.edit', $packageItem->id) }}">
                                        Edit
                                    </a>
                                @endcan

                                @can('package_item_delete')
                                    <form action="{{ route('admin.package-items.destroy', $packageItem->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin?');" style="display: inline-block;">
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

        @can('package_item_delete')
            let deleteButton = {
                text: 'Delete selected',
                url: "{{ route('admin.package-items.massDestroy') }}",
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

        let table = $('.datatable-PackageItem:not(.ajaxTable)').DataTable({
            buttons: dtButtons
        });

        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
            $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
        });
    })
</script>
@endsection