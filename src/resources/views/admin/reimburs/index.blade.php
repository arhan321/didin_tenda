@extends('layouts.admin')
@section('content')
    @can('reimburs_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.reimburs.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.reimburs.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.reimburs.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover datatable datatable-Order">
                    <thead>
                        <tr>
                            <th width="10"></th>
                            <th>{{ trans('cruds.reimburs.fields.id') }}</th>
                            <th>{{ trans('cruds.reimburs.fields.nama_client') }}</th>
                            <th>{{ trans('cruds.reimburs.fields.cabang') }}</th>
                            <th>{{ trans('cruds.reimburs.fields.alamat') }}</th>
                            <th>{{ trans('cruds.reimburs.fields.product') }}</th>
                            <th>{{ trans('cruds.reimburs.fields.jarak_antar') }}</th>
                            <th>{{ trans('cruds.reimburs.fields.tanggal') }}</th>
                            <th>{{ trans('cruds.reimburs.fields.bukti_struk') }}</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $counter = 1; // Mulai counter dari 1
                        @endphp

                        @foreach ($reimburs as $reimbur)
                            <tr data-entry-id="{{ $reimbur->id }}">
                                <td></td>
                                <!-- Angka Berurutan Sesuai Urutan Data -->
                                <td>{{ $counter }}</td> <!-- Tampilkan counter -->
                                
                                <!-- Nama Pemesan -->
                                <td>{{ $reimbur->client->nama_client ?? 'Unknown' }}</td>

                                <!-- Cabang -->
                                <td>{{ $reimbur->client->branch_client ?? 'Unknown' }}</td>

                                <!-- Alamat -->
                                <td>{{ $reimbur->client->alamat_client ?? 'Unknown' }}</td>

                                <!-- Produk yang Dipesan -->
                                <td>
                                    @if (isset($reimbur->product_details))
                                        <ul>
                                            @foreach ($reimbur->product_details as $product)
                                                <li>
                                                    <strong>{{ $product['name'] }}</strong>
                                                    <br>
                                                    <span class="text-muted">Quantity: {{ $product['qty'] }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </td>

                                <!-- jarak antar -->
                                <td class="text-center">{{ $reimbur->jarak_antar ?? '' }}</td>

                                <!-- Tanggal -->
                                <td class="text-center">{{ $reimbur->tanggal ?? '' }}</td>

                                <!-- Bukti struk -->
                                <td>
                                    @if ($reimbur->bukti_struk)
                                        <a href="{{ Storage::url($reimbur->bukti_struk) }}" target="_blank">
                                            Lihat PDF / GAMBAR
                                        </a>
                                    @else
                                        Tidak ada bukti struk
                                    @endif
                                </td>

                                <!-- Aksi -->
                                <td>
                                    @can('reimburs_show')
                                        <a class="btn btn-xs btn-primary" href="{{ route('admin.reimburs.show', $reimbur->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan

                                    @can('reimburs_edit')
                                        <a class="btn btn-xs btn-info" href="{{ route('admin.reimburs.edit', $reimbur->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan

                                    @can('reimburs_delete')
                                        <form action="{{ route('admin.reimburs.destroy', $reimbur->id) }}" method="POST" class="delete-form" style="display: inline-block;">
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

    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Set zoom ke 85%
            document.body.style.zoom = "85%";
    
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
    </script> --}}

<script>
    $(function() {
        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
        @can('reimburs_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.reimburs.massDestroy') }}",
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
