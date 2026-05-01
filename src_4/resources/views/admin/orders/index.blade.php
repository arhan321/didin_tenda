@extends('layouts.admin')
@section('content')

@can('order_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.orders.create') }}">
                Tambah Order
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        Order List
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-order">
                <thead>
                    <tr>
                        <th width="10"></th>
                        <th>ID</th>
                        <th>Invoice</th>
                        <th>Customer</th>
                        <th>Phone</th>
                        <th>User</th>
                        <th>Package</th>
                        <th>Type</th>
                        <th>Event Date</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Payment</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $key => $order)
                        <tr data-entry-id="{{ $order->id }}">
                            <td></td>

                            <td>{{ $order->id ?? '' }}</td>

                            <td>{{ $order->invoice_number ?? '' }}</td>

                            <td>{{ $order->customer_name ?? '' }}</td>

                            <td>{{ $order->customer_phone ?? '' }}</td>

                            <td>{{ $order->user->name ?? '-' }}</td>

                            <td>{{ $order->package->name ?? '-' }}</td>

                            <td>{{ ucfirst($order->order_type) }}</td>

                            <td>
                                {{ $order->event_date ? $order->event_date->format('d-m-Y') : '' }}
                            </td>

                            <td>
                                Rp {{ number_format($order->total_price ?? 0, 0, ',', '.') }}
                            </td>

                            <td>
                                @if($order->status === 'waiting_payment')
                                    <span class="badge badge-warning">Waiting Payment</span>
                                @elseif($order->status === 'confirmed')
                                    <span class="badge badge-info">Confirmed</span>
                                @elseif($order->status === 'processed')
                                    <span class="badge badge-primary">Processed</span>
                                @elseif($order->status === 'completed')
                                    <span class="badge badge-success">Completed</span>
                                @elseif($order->status === 'cancelled')
                                    <span class="badge badge-danger">Cancelled</span>
                                @else
                                    <span class="badge badge-secondary">{{ $order->status }}</span>
                                @endif
                            </td>

                            <td>
                                @if($order->payment_status === 'paid')
                                    <span class="badge badge-success">Paid</span>
                                @elseif($order->payment_status === 'pending')
                                    <span class="badge badge-warning">Pending</span>
                                @elseif($order->payment_status === 'unpaid')
                                    <span class="badge badge-secondary">Unpaid</span>
                                @elseif($order->payment_status === 'failed')
                                    <span class="badge badge-danger">Failed</span>
                                @elseif($order->payment_status === 'expired')
                                    <span class="badge badge-dark">Expired</span>
                                @elseif($order->payment_status === 'cancelled')
                                    <span class="badge badge-danger">Cancelled</span>
                                @elseif($order->payment_status === 'refunded')
                                    <span class="badge badge-info">Refunded</span>
                                @else
                                    <span class="badge badge-secondary">{{ $order->payment_status }}</span>
                                @endif
                            </td>

                            <td>
                                @can('order_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.orders.show', $order->id) }}">
                                        View
                                    </a>
                                @endcan

                                @can('order_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.orders.edit', $order->id) }}">
                                        Edit
                                    </a>
                                @endcan

                                @can('order_delete')
                                    <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin?');" style="display: inline-block;">
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

        @can('order_delete')
            let deleteButton = {
                text: 'Delete selected',
                url: "{{ route('admin.orders.massDestroy') }}",
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

        let table = $('.datatable-order:not(.ajaxTable)').DataTable({
            buttons: dtButtons
        })

        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
            $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
        });
    })
</script>
@endsection