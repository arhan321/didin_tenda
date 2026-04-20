@extends('layouts.admin')
@section('content')
    @can('dgpro_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.invoicedgpros.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.invoicedgpro.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.invoicedgpro.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover datatable datatable-invoice">
                    <thead>
                        <tr>
                            <th width="10"></th>
                            <th>{{ trans('cruds.invoicedgpro.fields.id') }}</th>
                            <th>Kode Invoice</th>
                            <th>{{ trans('cruds.invoicedgpro.fields.nama_pemesan') }}</th>
                            <th>{{ trans('cruds.invoicedgpro.fields.cabang') }}</th>
                            <th>{{ trans('cruds.invoicedgpro.fields.alamat') }}</th>
                            <th>{{ trans('cruds.invoicedgpro.fields.product') }}</th>
                            <th>{{ trans('cruds.invoicedgpro.fields.total_price') }}</th>
                            <th>{{ trans('cruds.invoicedgpro.fields.tax') }}</th>
                            <th>{{ trans('cruds.invoicedgpro.fields.start') }}</th>
                            <th>{{ trans('cruds.invoicedgpro.fields.status_bayar') }}</th>
                            <th>{{ trans('cruds.invoicedgpro.fields.bukti_pembayaran') }}</th>
                            {{-- <th>{{ trans('cruds.invoicedgpro.fields.status_sewa') }}</th> --}}
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $counter = 1; // Mulai counter dari 1
                        @endphp

                        @foreach ($invoicedgpros as $invoice)
                            <tr data-entry-id="{{ $invoice->id }}">
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
                                        $monthNumber = \Carbon\Carbon::parse($invoice->created_at)->format('m');

                                        // Ambil bulan dalam angka Romawi
                                        $monthInRoman = $monthsInRoman[\Carbon\Carbon::parse($invoice->created_at)->format('n')];
                                    @endphp

                                    {{ str_pad($monthNumber, 2, '0', STR_PAD_LEFT) }}-{{ $monthInRoman }}-DG-PRO-UNIVERSIAL-{{ str_pad($invoice->id, 4, '0', STR_PAD_LEFT) }}
                                </td>

                                <!-- Nama Pemesan -->
                                <td>{{ $invoice->client->nama_client ?? 'Unknown' }}</td>

                                <!-- Cabang -->
                                <td>{{ $invoice->client->branch_client ?? 'Unknown' }}</td>

                                <!-- Alamat -->
                                <td>{{ $invoice->client->alamat_client ?? 'Unknown' }}</td>

                                <!-- Produk yang Dipesan -->
                                <td>
                                    @if (isset($invoice->product_details))
                                        <ul>
                                            @foreach ($invoice->product_details as $product)
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
                                <td>{{ 'Rp ' . number_format($invoice->price ?? 0, 2, ',', '.') }}</td>

                                <!-- Pajak -->
                                <td>{{ floor($invoice->tax) == $invoice->tax ? number_format($invoice->tax, 0) : number_format($invoice->tax, 2) }}%</td>

                                <!-- Tanggal Mulai -->
                                <td class="text-center">{{ $invoice->start ?? '' }}</td>

                                <!-- Status Bayar -->
                                <td>
                                    @if ($invoice->status_bayar == 'Belum bayar')
                                        <span class="status-unpaid">{{ App\Models\Order::STATUS_SELECT['Belum bayar'] ?? 'Belum bayar' }}</span>
                                    @elseif($invoice->status_bayar == 'Sudah bayar')
                                        <span class="status-selesai">{{ App\Models\Order::STATUS_SELECT['Sudah bayar'] ?? 'Sudah bayar' }}</span>
                                    @else
                                        {{ App\Models\Order::STATUS_SELECT[$invoice->status_bayar] ?? '' }}
                                    @endif
                                </td>

                                <!-- Bukti Pembayaran -->
                                <td>
                                    @if ($invoice->bukti_pembayaran === 'CASH')
                                        <span><strong>CASH</strong></span>
                                    @elseif ($invoice->bukti_pembayaran && Str::endsWith($invoice->bukti_pembayaran, '.pdf'))
                                        <a href="{{ Storage::url($invoice->bukti_pembayaran) }}" target="_blank">
                                            Lihat PDF
                                        </a>
                                    @else
                                        Tidak ada bukti pembayaran
                                    @endif
                                </td>

                                <!-- Aksi -->
                                <td>
                                    @can('dgpro_show')
                                        <a class="btn btn-xs btn-primary" href="{{ route('admin.invoicedgpros.show', $invoice->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan

                                    @can('dgpro_edit')
                                        <a class="btn btn-xs btn-info" href="{{ route('admin.invoicedgpros.edit', $invoice->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan

                                    @can('dgpro_delete')
                                        <form action="{{ route('admin.invoicedgpros.destroy', $invoice->id) }}" method="POST" class="delete-form" style="display: inline-block;">
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
        @can('dgpro_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.invoicedgpros.massDestroy') }}",
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
                [1, 'desc'] // Mengatur kolom kedua (ID) menjadi descending
            ],
            pageLength: 15, // Default ke 15 per halaman
            lengthMenu: [[15, 25, 50, 100], [15, 25, 50, 100]], // Opsi pilihan untuk pagination
        });

        let table = $('.datatable-invoice:not(.ajaxTable)').DataTable({
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
