@extends('layouts.admin')
@section('content')
<!-- Link untuk memuat font Roboto dari Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
<!-- Link untuk Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
<!-- Link untuk Google Font Open Sans -->
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">

    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('cruds.orderbarangs.title_singular') }}
        </div>

        <div class="card-body">
            <div class="form-group">
                <!-- Link kembali ke daftar -->
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.orderbarangs.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <!-- Tombol Lihat Invoice -->
                <button class="btn btn-primary" style="margin-bottom: 1%" onclick="tampilkanInvoice()">
                    <i class="fas fa-file-invoice"></i> Lihat Invoice
                </button>
                <table class="table table-bordered table-striped">
                    <tbody>
                        <!-- Informasi Pesanan -->
                        <tr>
                            <th>
                                {{ trans('cruds.orderbarangs.fields.id') }}
                            </th>
                            <td>
                                {{ $orderbarang->id }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.orderbarangs.fields.nama_pemesan') }}
                            </th>
                            <td>
                                {{ $orderbarang->client->nama_client ?? 'Unknown' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.orderbarangs.fields.alamat') }}
                            </th>
                            <td>
                                {{ $orderbarang->client->alamat_client ?? 'Unknown' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.orderbarangs.fields.product') }}
                            </th>
                            <td>
                                @if (isset($orderbarang->product_details) && count($orderbarang->product_details) > 0)
                                    @php
                                        $productDetails = [];
                                        foreach ($orderbarang->product_details as $product) {
                                            $productDetails[] = $product['name'] . ' (Qty: ' . $product['qty'] . ')';
                                        }
                                        echo implode(', ', $productDetails);
                                    @endphp
                                @else
                                    <div>Tidak ada detail produk tersedia</div>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.orderbarangs.fields.price') }}
                            </th>
                            <td>
                                {{ 'Rp ' . number_format($orderbarang->price ?? 0, 2, ',', '.') }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.orderbarangs.fields.start_date') }}
                            </th>
                            <td>
                                {{ $orderbarang->start_date ? \Carbon\Carbon::parse($orderbarang->start_date)->format('d M Y') : '' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.orderbarangs.fields.end') }}
                            </th>
                            <td>
                                {{ $orderbarang->jatuh_tempo ? \Carbon\Carbon::parse($orderbarang->jatuh_tempo)->format('d M Y') : '' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.orderbarangs.fields.bukti_pembayaran') }}
                            </th>
                            <td>
                                @if ($orderbarang->bukti_pembayaran)
                                    <h5 style="margin-bottom: 10px;">Bukti Pembayaran:</h5>
                                    <iframe src="{{ Storage::url($orderbarang->bukti_pembayaran) }}" width="100%" height="600px"></iframe>
                                @else
                                    <h5 style="color: red; margin-bottom: 10px;">Bukti pembayaran belum diupload / belum dibayar</h5>
                                @endif
                                @if ($orderbarang->bukti_pembayaran)
                                    <div class="d-flex align-items-center mt-2">
                                        <a href="{{ Storage::url($orderbarang->bukti_pembayaran) }}" target="_blank"
                                           class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-eye"></i> Lihat PDF
                                        </a>
                                    </div>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.orderbarangs.fields.status_bayar') }}
                            </th>
                            <td>
                                @if ($orderbarang->status_bayar == 'Belum bayar')
                                    <span class="status-unpaid">{{ App\Models\OrdersBarang::STATUS_SELECT['Belum bayar'] ?? 'Belum bayar' }}</span>
                                @elseif($orderbarang->status_bayar == 'Sudah bayar')
                                    <span class="status-selesai">{{ App\Models\OrdersBarang::STATUS_SELECT['Sudah bayar'] ?? 'Sudah bayar' }}</span>
                                @else
                                    {{ $orderbarang->status_bayar }}
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- CSS untuk Status -->
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

    <!-- Menggunakan tampilan invoice -->
    @include('admin.orderbarangs.invoice')

@endsection
