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
            {{ trans('global.show') }} {{ trans('cruds.sahabatechinvoice.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.invoicedgpros.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <!-- Tombol Lihat Invoice -->
                <button class="btn btn-primary" style="margin-bottom: 1%" onclick="tampilkanInvoice()">
                    <i class="fas fa-file-invoice"></i> Lihat Invoice
                </button>
                <table class="table table-bordered table-striped">
                    <tbody>
                        <!-- Informasi Invoice -->
                        <tr>
                            <th>
                                {{ trans('cruds.sahabatechinvoice.fields.id') }}
                            </th>
                            <td>
                                {{ $invoicedgpro->id }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.sahabatechinvoice.fields.nama_pemesan') }}
                            </th>
                            <td>
                                {{ $invoicedgpro->client->nama_client ?? 'Unknown' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.sahabatechinvoice.fields.alamat') }}
                            </th>
                            <td>
                                {{ $invoicedgpro->client->alamat_client ?? 'Unknown' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.sahabatechinvoice.fields.product') }}
                            </th>
                            <td>
                                @if (isset($invoicedgpro->product_details) && count($invoicedgpro->product_details) > 0)
                                    @php
                                        $productDetails = [];
                                        foreach ($invoicedgpro->product_details as $product) {
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
                                {{ trans('cruds.sahabatechinvoice.fields.total_price') }}
                            </th>
                            <td>
                                {{ 'Rp ' . number_format($invoicedgpro->price ?? 0, 2, ',', '.') }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.sahabatechinvoice.fields.start') }}
                            </th>
                            <td>
                                {{ $invoicedgpro->start ? \Carbon\Carbon::parse($invoicedgpro->start)->format('d M Y') : '' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.sahabatechinvoice.fields.bukti_pembayaran') }}
                            </th>
                            <td>
                                @if ($invoicedgpro->bukti_pembayaran === 'CASH')
                                    <!-- Kondisi untuk pembayaran tunai -->
                                    <h5 style="color: green; margin-bottom: 10px;">Pembayaran dilakukan dengan <strong>CASH</strong></h5>
                                @elseif ($invoicedgpro->bukti_pembayaran)
                                    <h5 style="margin-bottom: 10px;">Bukti Pembayaran:</h5>
                                    <iframe src="{{ Storage::url($invoicedgpro->bukti_pembayaran) }}" width="100%" height="600px"></iframe>
                        
                                    <div class="d-flex align-items-center mt-2">
                                        <a href="{{ Storage::url($invoicedgpro->bukti_pembayaran) }}" target="_blank"
                                            class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-eye"></i> Lihat PDF
                                        </a>
                                    </div>
                                @else
                                    <h5 style="color: red; margin-bottom: 10px;">Bukti pembayaran belum diupload / belum dibayar</h5>
                                @endif
                            </td>
                        </tr>
                        
                        <tr>
                            <th>
                                {{ trans('cruds.sahabatechinvoice.fields.status_bayar') }}
                            </th>
                            <td>
                                @if ($invoicedgpro->status_bayar == 'Belum bayar')
                                    <span class="status-unpaid">{{ App\Models\Invoice::STATUS_SELECT['Belum bayar'] ?? 'Belum bayar' }}</span>
                                @elseif($invoicedgpro->status_bayar == 'Sudah bayar')
                                    <span class="status-selesai">{{ App\Models\Invoice::STATUS_SELECT['Sudah bayar'] ?? 'Sudah bayar' }}</span>
                                @else
                                    {{ $invoicedgpro->status_bayar }}
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

@include('admin.invoicedgpros.invoice')

@endsection
