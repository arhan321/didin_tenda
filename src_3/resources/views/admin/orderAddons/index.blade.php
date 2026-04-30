@extends('layouts.admin')
@section('content')

@can('order_addon_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.order-addons.create') }}">
                Tambah Order Addon
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        Order Addon List
    </div>

    <div class="card-body">
        <form method="GET" action="{{ route('admin.order-addons.index') }}" class="mb-3">
            <div class="row">
                <div class="col-md-4">
                    <select name="order_id" class="form-control">
                        <option value="">Semua Order</option>
                        @foreach($orders as $order)
                            <option value="{{ $order->id }}" {{ request('order_id') == $order->id ? 'selected' : '' }}>
                                {{ $order->invoice_number }} - {{ $order->customer_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <select name="addon_id" class="form-control">
                        <option value="">Semua Addon</option>
                        @foreach($addons as $addon)
                            <option value="{{ $addon->id }}" {{ request('addon_id') == $addon->id ? 'selected' : '' }}>
                                {{ $addon->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">
                        Filter
                    </button>

                    <a href="{{ route('admin.order-addons.index') }}" class="btn btn-default">
                        Reset
                    </a>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-order-addon">
                <thead>
                    <tr>
                        <th width="10"></th>
                        <th>ID</th>
                        <th>Invoice</th>
                        <th>Customer</th>
                        <th>Addon</th>
                        <th>Name</th>
                        <th>Unit</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Total</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orderAddons as $key => $orderAddon)
                        <tr data-entry-id="{{ $orderAddon->id }}">
                            <td></td>

                            <td>
                                {{ $orderAddon->id ?? '' }}
                            </td>

                            <td>
                                {{ $orderAddon->order->invoice_number ?? '' }}
                            </td>

                            <td>
                                {{ $orderAddon->order->customer_name ?? '' }}
                            </td>

                            <td>
                                {{ $orderAddon->addon->name ?? '-' }}
                            </td>

                            <td>
                                {{ $orderAddon->name ?? '' }}
                            </td>

                            <td>
                                {{ $orderAddon->unit ?? '' }}
                            </td>

                            <td>
                                {{ $orderAddon->quantity ?? 0 }}
                            </td>

                            <td>
                                Rp {{ number_format($orderAddon->price ?? 0, 0, ',', '.') }}
                            </td>

                            <td>
                                Rp {{ number_format($orderAddon->total_price ?? 0, 0, ',', '.') }}
                            </td>

                            <td>
                                @can('order_addon_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.order-addons.show', $orderAddon->id) }}">
                                        View
                                    </a>
                                @endcan

                                @can('order_addon_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.order-addons.edit', $orderAddon->id) }}">
                                        Edit
                                    </a>
                                @endcan

                                @can('order_addon_delete')
                                    <form action="{{ route('admin.order-addons.destroy', $orderAddon->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin?');" style="display: inline-block;">
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

        @can('order_addon_delete')
            let deleteButton = {
                text: 'Delete selected',
                url: "{{ route('admin.order-addons.massDestroy') }}",
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

        let table = $('.datatable-order-addon:not(.ajaxTable)').DataTable({
            buttons: dtButtons
        })

        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });
    })
</script>
@endsection