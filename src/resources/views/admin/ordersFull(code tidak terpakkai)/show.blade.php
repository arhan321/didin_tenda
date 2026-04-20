@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('cruds.order.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.orders.index') }}">
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
                                {{ trans('cruds.order.fields.id') }}
                            </th>
                            <td>
                                {{ $order->id }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.order.fields.nama_pemesan') }}
                            </th>
                            <td>
                                {{ $order->client->nama_client ?? 'Unknown' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.order.fields.alamat') }}
                            </th>
                            <td>
                                {{ $order->client->alamat_client ?? 'Unknown' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.order.fields.product') }}
                            </th>
                            <td>
                                @if (isset($order->product_details) && count($order->product_details) > 0)
                                    @php
                                        $productDetails = [];
                                        foreach ($order->product_details as $product) {
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
                                {{ trans('cruds.order.fields.price') }}
                            </th>
                            <td>
                                {{ 'Rp ' . number_format($order->price ?? 0, 2, ',', '.') }}
                            </td>
                        </tr>
                        {{-- <tr>
                            <th>
                                {{ trans('cruds.order.fields.jam_pesan') }}
                            </th>
                            <td>
                                {{ $order->jam_pesan }}
                            </td>
                        </tr> --}}
                        <tr>
                            <th>
                                {{ trans('cruds.order.fields.start') }}
                            </th>
                            <td>
                                {{ $order->start ? \Carbon\Carbon::parse($order->start)->format('d M Y') : '' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.order.fields.end') }}
                            </th>
                            <td>
                                {{ $order->end ? \Carbon\Carbon::parse($order->end)->format('d M Y') : '' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.order.fields.bukti_pembayaran') }}
                            </th>
                            <td>
                                @if ($order->bukti_pembayaran)
                                    <h5 style="margin-bottom: 10px;">Bukti Pembayaran:</h5>
                                    <iframe src="{{ Storage::url($order->bukti_pembayaran) }}" width="100%" height="600px"></iframe>
                                @else
                                    <h5 style="color: red; margin-bottom: 10px;">Bukti pembayaran belum diupload / belum dibayar</h5>
                                @endif
                                @if ($order->bukti_pembayaran)
                                <div class="d-flex align-items-center mt-2">
                                    <a href="{{ Storage::url($order->bukti_pembayaran) }}" target="_blank"
                                        class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-eye"></i> Lihat PDF
                                    </a>
                                </div>
                            @endif
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.order.fields.status_bayar') }}
                            </th>
                            <td>
                                @if ($order->status_bayar == 'Belum bayar')
                                    <span class="status-unpaid">{{ App\Models\Order::STATUS_SELECT['Belum bayar'] ?? 'Belum bayar' }}</span>
                                @elseif($order->status_bayar == 'Sudah bayar')
                                    <span class="status-selesai">{{ App\Models\Order::STATUS_SELECT['Sudah bayar'] ?? 'Sudah bayar' }}</span>
                                @else
                                    {{ $order->status_bayar }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.order.fields.status_sewa') }}
                            </th>
                            <td>
                                @if ($order->status_sewa == 'Belum Selesai')
                                    <span class="status-unpaid">{{ App\Models\Order::STATUS_SEWA_SELECT['Belum Selesai'] ?? 'Belum Selesai' }}</span>
                                @elseif($order->status_sewa == 'Sudah Selesai')
                                    <span class="status-selesai">{{ App\Models\Order::STATUS_SEWA_SELECT['Sudah Selesai'] ?? 'Sudah Selesai' }}</span>
                                @else
                                    {{ $order->status_sewa }}
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
 /* order */
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

@include('admin.orders.invoice')

<!-- JavaScript untuk menampilkan modal dan membuat PDF -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script>
   function tampilkanInvoice() {
       $('#invoiceModal').modal('show');
   }

   function downloadPDF() {
    const { jsPDF } = window.jspdf;

    // Tampilkan pesan loading (opsional)
    alert('Sedang memproses PDF, harap tunggu...');

    html2canvas(document.getElementById("invoiceContent"), {
        scale: 2, // Meningkatkan skala untuk resolusi lebih tinggi
        useCORS: true, // Untuk menangani gambar lintas domain
        logging: true
    }).then(canvas => {
        const imgData = canvas.toDataURL("image/png");
        const pdf = new jsPDF('p', 'mm', 'a4');

        // Hitung proporsi halaman PDF untuk menyesuaikan ukuran gambar
        const imgWidth = 190; // Lebar halaman A4 (mm)
        const imgHeight = canvas.height * imgWidth / canvas.width;

        pdf.addImage(imgData, 'PNG', 10, 10, imgWidth, imgHeight, undefined, 'FAST'); // FAST untuk meningkatkan kualitas rendering
        pdf.save("invoice.pdf");
    }).catch(error => {
        console.error("Error while generating PDF: ", error);
    });
}

</script>
@endsection
