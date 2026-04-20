@extends('layouts.admin')
@section('content')
    @can('monitoringlaptop_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.monitoringlaptops.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.asetlocation.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.asetlocation.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover datatable datatable-MonitoringLaptop">
                    <thead>
                        <tr>
                            <th width="10"></th>
                            <th>{{ trans('cruds.asetlocation.fields.id') }}</th>
                            <th>{{ trans('cruds.asetlocation.fields.nama_pemesan') }}</th>
                            <th>{{ trans('cruds.asetlocation.fields.cabang') }}</th>
                            <th>{{ trans('cruds.asetlocation.fields.alamat') }}</th>
                            <th>{{ trans('cruds.asetlocation.fields.product') }}</th>
                            {{-- <th>{{ trans('cruds.asetlocation.fields.tanggal') }}</th> --}}
                            <th>{{ trans('cruds.asetlocation.fields.jumlah_barang') }}</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $counter = 1; // Mulai counter dari 1
                        @endphp

                        @foreach ($monitoringlaptops as $monitoringlaptop)
                            <tr data-entry-id="{{ $monitoringlaptop->id }}">
                                <td></td>

                                <!-- Angka Berurutan Sesuai Urutan Data -->
                                <td>{{ $counter }}</td> <!-- Tampilkan counter -->

                                <!-- Nama Pemesan -->
                                <td>{{ $monitoringlaptop->client->nama_client ?? 'Unknown' }}</td>

                                <!-- Cabang -->
                                <td>{{ $monitoringlaptop->client->branch_client ?? 'Unknown' }}</td>

                                <!-- Alamat -->
                                <td>{{ $monitoringlaptop->client->alamat_client ?? 'Unknown' }}</td>

                                <!-- Produk yang Dipesan -->
                                <td>
                                    @if (isset($monitoringlaptop->product_details))
                                        <ul>
                                            @foreach ($monitoringlaptop->product_details as $product)
                                                <li>
                                                    <strong>{{ $product['name'] }}</strong>
                                                    <br>
                                                    {{-- <span class="text-muted">Quantity: {{ $product['qty'] }}</span> --}}
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </td>

                                <!-- Tanggal -->
                                {{-- <td>{{ \Carbon\Carbon::parse($monitoringlaptop->tanggal_pengiriman)->format('d / m / Y') }}</td> --}}

                                <!-- Jumlah barang -->
                                <td>{{ $monitoringlaptop->jumlah_barang ?? 'Unknown' }}</td>
                            
                                <!-- Aksi -->
                                <td>
                                    @can('monitoringlaptop_show')
                                        <a class="btn btn-xs btn-primary" href="{{ route('admin.monitoringlaptops.show', $monitoringlaptop->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan

                                    {{-- @can('monitoringlaptop_edit')
                                        <a class="btn btn-xs btn-info" href="{{ route('admin.monitoringlaptops.edit', $monitoringlaptop->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan --}}

                                    @can('monitoringlaptop_delete')
                                        <form action="{{ route('admin.monitoringlaptops.destroy', $monitoringlaptop->id) }}" method="POST" class="delete-form" style="display: inline-block;">
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
        /* Base style for all statuses */
        .status-pending, .status-delivered, .status-canceled, .status-unknown {
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: bold;
            margin: 5px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s, box-shadow 0.3s;
            display: inline-block;
        }
    
        /* Specific styles for each status */
        .status-pending {
            background-color: orange;
        }
    
        .status-pending:hover {
            background-color: darkorange;
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.2);
        }
    
        .status-delivered {
            background-color: green;
        }
    
        .status-delivered:hover {
            background-color: darkgreen;
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.2);
        }
    
        .status-canceled {
            background-color: red;
        }
    
        .status-canceled:hover {
            background-color: darkred;
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.2);
        }
    
        /* Style for unknown status, if applicable */
        .status-unknown {
            background-color: gray;
        }
    
        .status-unknown:hover {
            background-color: darkgray;
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
            @can('monitoringlaptop_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('admin.monitoringlaptops.massDestroy') }}",
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
                pageLength: 15, // Default ke 15 per halaman
                lengthMenu: [ [15, 25, 50, 100], [15, 25, 50, 100] ], // Opsi pilihan untuk pagination
            });

            let table = $('.datatable-MonitoringLaptop:not(.ajaxTable)').DataTable({
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
