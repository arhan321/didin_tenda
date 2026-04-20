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
            {{ trans('global.show') }} {{ trans('cruds.reimburs.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.reimburs.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <!-- Tombol Lihat Invoice -->
                {{-- <button class="btn btn-primary" style="margin-bottom: 1%" onclick="tampilkanInvoice()">
                    <i class="fas fa-file-invoice"></i> Lihat Invoice
                </button> --}}
                <table class="table table-bordered table-striped">
                    <tbody>
                        <!-- Informasi Pesanan -->
                        <tr>
                            <th>
                                {{ trans('cruds.reimburs.fields.id') }}
                            </th>
                            <td>
                                {{ $reimbur->id }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.reimburs.fields.nama_client') }}
                            </th>
                            <td>
                                {{ $reimbur->client->nama_client ?? 'Unknown' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.reimburs.fields.alamat') }}
                            </th>
                            <td>
                                {{ $reimbur->client->alamat_client ?? 'Unknown' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.reimburs.fields.product') }}
                            </th>
                            <td>
                                @if (isset($reimbur->product_details) && count($reimbur->product_details) > 0)
                                    @php
                                        $productDetails = [];
                                        foreach ($reimbur->product_details as $product) {
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
                                {{ trans('cruds.reimburs.fields.jarak_antar') }}
                            </th>
                            <td>
                                {{ $reimbur->jarak_antar ?? 'Unknown' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.reimburs.fields.tanggal') }}
                            </th>
                            <td>
                                {{ $reimbur->tanggal ? \Carbon\Carbon::parse($reimbur->tanggal)->format('d M Y') : '' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.reimburs.fields.bukti_struk') }}
                            </th>
                            <td>
                                @if ($reimbur->bukti_struk)
                                    <h5 style="margin-bottom: 10px;">Bukti struk:</h5>
                                    <iframe src="{{ Storage::url($reimbur->bukti_struk) }}" width="100%" height="600px"></iframe>
                                @else
                                    <h5 style="color: red; margin-bottom: 10px;">Bukti struk belum diupload / belum dibayar</h5>
                                @endif
                                @if ($reimbur->bukti_struk)
                                <div class="d-flex align-items-center mt-2">
                                    <a href="{{ Storage::url($reimbur->bukti_struk) }}" target="_blank"
                                        class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-eye"></i> Lihat PDF / gambar
                                    </a>
                                </div>
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
 /* reimbur */
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

{{-- @include('admin.orders.invoice') --}}

@endsection
