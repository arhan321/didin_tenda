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
            {{ trans('global.show') }} {{ trans('cruds.asetlocation.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.monitoringlaptops.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody>
                        <!-- Informasi Pesanan -->
                        {{-- <tr>
                            <th>
                                {{ trans('cruds.asetlocation.fields.tanggal') }}
                            </th>
                            <td>
                                {{ \Carbon\Carbon::parse($monitoringlaptop->tanggal_pengiriman)->format('d / m / Y') }}
                            </td>
                        </tr> --}}
                        <tr>
                            <th>
                                {{ trans('cruds.asetlocation.fields.id') }}
                            </th>
                            <td>
                                {{ $monitoringlaptop->id }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.asetlocation.fields.nama_pemesan') }}
                            </th>
                            <td>
                                {{ $monitoringlaptop->client->nama_client ?? 'Unknown' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.asetlocation.fields.alamat') }}
                            </th>
                            <td>
                                {{ $monitoringlaptop->client->alamat_client ?? 'Unknown' }}
                            </td>
                        </tr>
                        {{-- <tr>
                            <th>
                                {{ trans('cruds.asetlocation.fields.product') }}
                            </th>
                            <td>
                                @if (isset($monitoringlaptop->product_details) && count($monitoringlaptop->product_details) > 0)
                                    @php
                                        $productDetails = [];
                                        foreach ($monitoringlaptop->product_details as $product) {
                                            $productDetails[] = $product['name'] . ' (Qty: ' . $product['qty'] . ')';
                                        }
                                        echo implode(', ', $productDetails);
                                    @endphp
                                @else
                                    <div>Tidak ada detail produk tersedia</div>
                                @endif
                            </td>
                        </tr> --}}
                        <tr>
                            <th>
                                {{ trans('cruds.asetlocation.fields.product') }}
                            </th>
                            <td>
                                @if (isset($monitoringlaptop->product_details) && count($monitoringlaptop->product_details) > 0)
                                    @php
                                        $productDetails = [];
                                        foreach ($monitoringlaptop->product_details as $product) {
                                            $productDetails[] = $product['name'];  // Hanya menambahkan nama produk tanpa qty
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
                                {{ trans('cruds.asetlocation.fields.jumlah_barang') }}
                            </th>
                            <td>
                                {{ $monitoringlaptop->jumlah_barang ?? 'Unknown' }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


   <!-- CSS untuk Status -->
   <style>
    /* monitoringlaptop */
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

    .status-in-progress {
        background-color: orange;
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
        font-weight: bold;
        margin: 5px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: background-color 0.3s, box-shadow 0.3s;
        display: inline-block;
    }

    .status-in-progress:hover {
        background-color: darkorange;
        box-shadow: 0 6px 8px rgba(0, 0, 0, 0.2);
    }

    .status-completed {
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

    .status-completed:hover {
        background-color: darkgreen;
        box-shadow: 0 6px 8px rgba(0, 0, 0, 0.2);
    }
</style>


{{-- @include('admin.deliveryorders.surat') --}}

@endsection
