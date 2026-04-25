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
                            <th>Kode Invoice</th>
                            <th>{{ trans('cruds.order.fields.nama_pemesan') }}</th>
                            <th>{{ trans('cruds.order.fields.cabang') }}</th>
                            <th>{{ trans('cruds.order.fields.alamat') }}</th>
                            <th>{{ trans('cruds.order.fields.product') }}</th>
                            <th>{{ trans('cruds.order.fields.price') }}</th>
                            <th>{{ trans('cruds.order.fields.tax') }}</th>
                            <th>{{ trans('cruds.order.fields.start') }}</th>
                            <th>{{ trans('cruds.order.fields.status_bayar') }}</th>
                            <th>{{ trans('cruds.order.fields.bukti_pembayaran') }}</th>
                            <th>{{ trans('cruds.order.fields.status_sewa') }}</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $counter = 1; // Mulai counter dari 1
                        @endphp

                        @foreach ($orders as $order)
                            <tr data-entry-id="{{ $order->id }}">
                                <td></td>

                                <!-- Angka Berurutan Sesuai Urutan Data -->
                                <td>{{ $counter }}</td> <!-- Tampilkan counter -->
                                
                                <!-- Kode Invoice -->
                                <td>
                                    @php
                                        $monthsInRoman = [
                                            1 => 'I',
                                            2 => 'II',
                                            3 => 'III',
                                            4 => 'IV',
                                            5 => 'V',
                                            6 => 'VI',
                                            7 => 'VII',
                                            8 => 'VIII',
                                            9 => 'IX',
                                            10 => 'X',
                                            11 => 'XI',
                                            12 => 'XII',
                                        ];

                                        // Ambil nomor bulan dalam format 2 digit
                                        $monthNumber = \Carbon\Carbon::parse($order->created_at)->format('m');

                                        // Ambil bulan dalam angka Romawi
                                        $monthInRoman = $monthsInRoman[\Carbon\Carbon::parse($order->created_at)->format('n')];
                                    @endphp

                                    {{ str_pad($monthNumber, 2, '0', STR_PAD_LEFT) }}-{{ $monthInRoman }}-TAP-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}
                                </td>

                                <!-- Nama Pemesan -->
                                <td>{{ $order->client->nama_client ?? 'Unknown' }}</td>

                                <!-- Cabang -->
                                <td>{{ $order->client->branch_client ?? 'Unknown' }}</td>

                                <!-- Alamat -->
                                <td>{{ $order->client->alamat_client ?? 'Unknown' }}</td>

                                <!-- Produk yang Dipesan -->
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

                                <!-- Harga -->
                                <td>{{ 'Rp ' . number_format($order->price ?? 0, 2, ',', '.') }}</td>

                                <!-- Pajak -->
                                <td>{{ floor($order->tax) == $order->tax ? number_format($order->tax, 0) : number_format($order->tax, 2) }}%</td>

                                <!-- Tanggal Mulai -->
                                <td class="text-center">{{ $order->start ?? '' }}</td>

                                <!-- Status Bayar -->
                                <td>
                                    @if ($order->status_bayar == 'Belum bayar')
                                        <span class="status-unpaid">{{ App\Models\Order::STATUS_SELECT['Belum bayar'] ?? 'Belum bayar' }}</span>
                                    @elseif($order->status_bayar == 'Sudah bayar')
                                        <span class="status-selesai">{{ App\Models\Order::STATUS_SELECT['Sudah bayar'] ?? 'Sudah bayar' }}</span>
                                    @else
                                        {{ App\Models\Order::STATUS_SELECT[$order->status_bayar] ?? '' }}
                                    @endif
                                </td>

                                <!-- Bukti Pembayaran -->
                                <td>
                                    @if ($order->bukti_pembayaran)
                                        <a href="{{ Storage::url($order->bukti_pembayaran) }}" target="_blank">
                                            Lihat PDF
                                        </a>
                                    @else
                                        Tidak ada bukti pembayaran
                                    @endif
                                </td>

                                <!-- Status Sewa -->
                                <td>
                                    @php
                                        $now = Carbon\Carbon::now();
                                        $end = Carbon\Carbon::parse($order->end);
                                        $statusSewa = $now->gt($end) ? 'Sudah Selesai' : 'Belum Selesai';
                                    @endphp

                                    @if ($statusSewa == 'Belum Selesai')
                                        <span class="status-unpaid">Belum Selesai</span>
                                    @else
                                        <span class="status-selesai">Sudah Selesai</span>
                                    @endif
                                </td>

                                <!-- Aksi -->
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
                                        <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" class="delete-form" style="display: inline-block;">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="submit" class="btn btn-xs btn-danger delete-button" value="{{ trans('global.delete') }}">
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                            @php
                                $counter++; // Increment counter setiap kali ada data
                            @endphp
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
        document.addEventListener('DOMContentLoaded', function() {
            // Set zoom ke 85%
           // document.body.style.zoom = "85%";
    
            // Nonaktifkan deteksi bahasa otomatis dengan menetapkan bahasa secara manual
            document.documentElement.lang = "en"; // Atur bahasa menjadi bahasa Inggris (atau bahasa lain yang diinginkan)
    
            // Menonaktifkan fitur auto-detect bahasa pada input (misalnya form) di halaman ini
            let inputs = document.querySelectorAll('input, textarea');
            inputs.forEach(input => {
                input.setAttribute('autocomplete', 'off');  // Nonaktifkan autocomplete (yang kadang mengubah input bahasa)
                input.setAttribute('autocorrect', 'off');   // Nonaktifkan autocorrect (untuk input bahasa yang berbeda)
                input.setAttribute('spellcheck', 'false');  // Nonaktifkan spellcheck
            });
        });
    </script>

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

        // Pengaturan default DataTables
        $.extend(true, $.fn.dataTable.defaults, {
            orderCellsTop: true,
            order: [
                [1, 'desc']
            ],
            pageLength: 10, // Tampilkan 5 data per halaman
            lengthMenu: [ [5, 10, 15, 25, 50], [5, 10, 15, 25, 50] ], // Pilihan untuk pagination
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
