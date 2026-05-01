@extends('layouts.admin')
@section('content')

@can('package_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.packages.create') }}">
                Tambah Package
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        Package List
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover datatable datatable-Package">
                <thead>
                    <tr>
                        <th width="10"></th>
                        <th>ID</th>
                        <th>Gambar</th>
                        <th>Nama</th>
                        <th>Slug</th>
                        <th>Type</th>
                        <th>Harga</th>
                        <th>Unit</th>
                        <th>Badge</th>
                        <th>Popular</th>
                        <th>Active</th>
                        <th>Sort</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($packages as $key => $package)
                        <tr data-entry-id="{{ $package->id }}">
                            <td></td>

                            <td>
                                {{ $package->id ?? '' }}
                            </td>

                            <td>
                                @if($package->main_image)
                                    <a href="{{ asset('storage/' . $package->main_image) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $package->main_image) }}" width="80" style="border-radius: 6px;">
                                    </a>
                                @endif
                            </td>

                            <td>
                                {{ $package->name ?? '' }}
                            </td>

                            <td>
                                {{ $package->slug ?? '' }}
                            </td>

                            <td>
                                {{ ucfirst($package->type) }}
                            </td>

                            <td>
                                Rp {{ number_format($package->price ?? 0, 0, ',', '.') }}
                            </td>

                            <td>
                                {{ $package->price_unit ?? '' }}
                            </td>

                            <td>
                                @if($package->badge)
                                    <span class="badge badge-info">
                                        {{ $package->badge }}
                                    </span>
                                @endif
                            </td>

                            <td>
                                @if($package->is_popular)
                                    <span class="badge badge-success">Ya</span>
                                @else
                                    <span class="badge badge-secondary">Tidak</span>
                                @endif
                            </td>

                            <td>
                                @if($package->is_active)
                                    <span class="badge badge-primary">Aktif</span>
                                @else
                                    <span class="badge badge-danger">Nonaktif</span>
                                @endif
                            </td>

                            <td>
                                {{ $package->sort_order ?? 0 }}
                            </td>

                            <td>
                                @can('package_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.packages.show', $package->id) }}">
                                        View
                                    </a>
                                @endcan

                                @can('package_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.packages.edit', $package->id) }}">
                                        Edit
                                    </a>
                                @endcan

                                @can('package_delete')
                                    <form action="{{ route('admin.packages.destroy', $package->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin?');" style="display: inline-block;">
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

        @can('package_delete')
            let deleteButton = {
                text: 'Delete selected',
                url: "{{ route('admin.packages.massDestroy') }}",
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

        let table = $('.datatable-Package:not(.ajaxTable)').DataTable({
            buttons: dtButtons
        });

        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
            $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
        });
    })
</script>
@endsection