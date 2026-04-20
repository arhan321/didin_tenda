@extends('layouts.admin')
@section('content')
    @can('order_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.orders.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.order.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.order.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover datatable datatable-Order">
                    <thead>
                        <tr>
                            <th width="10"></th>
                            <th>{{ trans('cruds.order.fields.id') }}</th>
                            <th>{{ trans('cruds.order.fields.nama_pemesan') }}</th>
                            <th>{{ trans('cruds.order.fields.alamat') }}</th>
                            <th>{{ trans('cruds.order.fields.product') }}</th>
                            <th>{{ trans('cruds.order.fields.price') }}</th>
                            {{-- <th>{{ trans('cruds.order.fields.jam_pesan') }}</th> --}}
                            <th>{{ trans('cruds.order.fields.start') }}</th>
                            <th>{{ trans('cruds.order.fields.end') }}</th>
                            <th>{{ trans('cruds.order.fields.status_bayar') }}</th>
                            <th>{{ trans('cruds.order.fields.bukti_pembayaran') }}</th>
                            <th>{{ trans('cruds.order.fields.status_sewa') }}</th>
                            {{-- <th>{{ trans('cruds.order.fields.bukti_pembayaran_foto') }}</th> --}}
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $key => $order)
                            <tr data-entry-id="{{ $order->id }}">
                                <td></td>
                                <td>{{ $order->id ?? '' }}</td>
                                <td>{{ $order->client->nama_client ?? 'Unknown' }}</td>
                                <td>{{ $order->client->alamat_client ?? 'Unknown' }}</td>
                                {{-- <td>
                                    @if (isset($order->product_details))
                                        <div class="row">
                                            @foreach ($order->product_details as $product)
                                                <div class="col-12 mb-2">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <h5 class="card-title">{{ $product['name'] }}</h5>
                                                            <p class="card-text">
                                                                <strong>Quantity:</strong> {{ $product['qty'] }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </td> --}}
                                <td>
                                    @if (isset($order->product_details))
                                        <ul>
                                            @foreach ($order->product_details as $product)
                                                <li>
                                                    <strong>{{ $product['name'] }}</strong> 
                                                    <br>
                                                    <span class="text-muted">Quantity: {{ $product['qty'] }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </td>
                                <td>{{ 'Rp ' . number_format($order->price ?? 0, 2, ',', '.') }}</td>
                                {{-- <td>{{ $order->jam_pesan ?? '' }}</td> --}}
                                {{-- <td class="text-center">
                                    {{ $order->start ? \Carbon\Carbon::parse($order->start)->format('d M Y') : '' }}
                                </td>
                                <td class="text-center">
                                    {{ $order->end ? \Carbon\Carbon::parse($order->end)->format('d M Y') : '' }}
                                </td> --}}
                                <td class="text-center">
                                    {{ $order->start ?? '' }}
                                </td>
                                <td class="text-center">
                                    {{ $order->end ?? '' }}
                                </td>
                                <td>
                                    @if ($order->status_bayar == 'Belum bayar')
                                        <span
                                            class="status-unpaid">{{ App\Models\Order::STATUS_SELECT['Belum_bayar'] ?? 'Belum bayar' }}</span>
                                    @elseif($order->status_bayar == 'Sudah bayar')
                                        <span
                                            class="status-selesai">{{ App\Models\Order::STATUS_SELECT['Sudah_bayar'] ?? 'Sudah bayar' }}</span>
                                    @else
                                        {{ App\Models\Order::STATUS_SELECT[$order->status_bayar] ?? '' }}
                                    @endif
                                </td>
                                <td>
                                    @if ($order->bukti_pembayaran)
                                        <a href="{{ Storage::url($order->bukti_pembayaran) }}" target="_blank">
                                            Lihat PDF
                                        </a>
                                    @else
                                        Tidak ada bukti pembayaran
                                    @endif
                                </td>
                                @php
                                $now = Carbon\Carbon::now();
                                $end = Carbon\Carbon::parse($order->end);
                            
                                // Set status based on the current date
                                if ($now->gt($end)) {
                                    $statusSewa = 'Sudah Selesai';
                                } else {
                                    $statusSewa = 'Belum Selesai';
                                }
                            @endphp
                            
                            <td>
                                @if ($statusSewa == 'Belum Selesai')
                                    <span class="status-unpaid">{{ App\Models\Order::STATUS_SEWA_SELECT['Belum Selesai'] ?? 'Belum Selesai' }}</span>
                                @elseif ($statusSewa == 'Sudah Selesai')
                                    <span class="status-selesai">{{ App\Models\Order::STATUS_SEWA_SELECT['Sudah Selesai'] ?? 'Sudah Selesai' }}</span>
                                @endif
                            </td>
                            
                                {{-- <td>
                                @if ($order->image)
                                    <a href="{{ $order->image->getUrl() }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $order->image->getUrl('thumb') }}">
                                    </a>
                                @endif
                            </td> --}}
                                <td>
                                    @can('order_show')
                                        <a class="btn btn-xs btn-primary" href="{{ route('admin.orders.show', $order->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan

                                    @can('order_edit')
                                        <a class="btn btn-xs btn-info" href="{{ route('admin.orders.edit', $order->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan

                                    @can('order_delete')
                                        <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST"
                                            class="delete-form" style="display: inline-block;">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="submit" class="btn btn-xs btn-danger delete-button"
                                                value="{{ trans('global.delete') }}">
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

    <style>
        .status-unpaid {
            background-color: red;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: bold;
            margin: 5px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s, box-shadow 0.3s;
            display: inline-block;
        }

        .status-unpaid:hover {
            background-color: darkred;
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.2);
        }

        .status-selesai {
            background-color: green;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: bold;
            margin: 5px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s, box-shadow 0.3s;
            display: inline-block;
        }

        .status-selesai:hover {
            background-color: darkgreen;
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.2);
        }
    </style>
@endsection
@section('scripts')
    @parent
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(function() {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            @can('order_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('admin.orders.massDestroy') }}",
                    className: 'btn-danger',
                    action: function(e, dt, node, config) {
                        var ids = $.map(dt.rows({
                            selected: true
                        }).nodes(), function(entry) {
                            return $(entry).data('entry-id')
                        });

                        if (ids.length === 0) {
                            alert('{{ trans('global.datatables.zero_selected') }}')

                            return
                        }

                        Swal.fire({
                            title: '{{ trans('global.areYouSure') }}',
                            text: '{{ trans('global.areYouSureDelete') }}',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: '{{ trans('global.delete') }}',
                            cancelButtonText: '{{ trans('global.cancel') }}'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                        headers: {
                                            'x-csrf-token': _token
                                        },
                                        method: 'POST',
                                        url: config.url,
                                        data: {
                                            ids: ids,
                                            _method: 'DELETE'
                                        }
                                    })
                                    .done(function() {
                                        location.reload()
                                    })
                            }
                        })
                    }
                }
                dtButtons.push(deleteButton)
            @endcan

            $.extend(true, $.fn.dataTable.defaults, {
                orderCellsTop: true,
                order: [
                    [1, 'desc']
                ],
                pageLength: 100,
            });
            let table = $('.datatable-Order:not(.ajaxTable)').DataTable({
                buttons: dtButtons
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
        })

        $('.delete-button').on('click', function(e) {
            e.preventDefault();
            var form = $(this).closest('form');

            Swal.fire({
                title: '{{ trans('global.areYouSure') }}',
                text: '{{ trans('global.areYouSureDelete') }}',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: '{{ trans('global.delete') }}',
                cancelButtonText: '{{ trans('global.cancel') }}'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    </script>
@endsection
