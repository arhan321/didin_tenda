<!-- Modal untuk Invoice -->
<div class="modal fade" id="invoiceModal" tabindex="-1" role="dialog" aria-labelledby="invoiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="invoiceModalLabel">Invoice</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="invoiceContent">
                <!-- Konten Invoice -->
                <div style="font-family: Arial, sans-serif; font-size: 14px; padding: 20px;">
                    <div style="text-align: center;">
                        <img src="{{ asset('assets/logo2.png') }}" alt="Logo" style="width: 250px;">
                    </div>

                    <h3 style="text-align: center; margin-top: 10px; color: #f5a623;">TRI ASTRA PERSADA</h3>
                    <p style="text-align: center;">Meeting Your Business Needs</p>
                    <p style="text-align: center; margin-bottom:1%">Jl. Kalianyar 10 No.15 Tambora, Jakarta Barat</p>

                    <hr style="border-top: 2px solid black; margin-top:3%">

                    <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
                        <tr>
                            <td>
                                <strong>Invoice No:</strong> 
                                {{ 'INV' . str_pad($order->id, 3, '0', STR_PAD_LEFT) }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Date:</strong> {{ \Carbon\Carbon::parse($order->created_at)->format('d F Y') }}
                            </td>
                        </tr>
                    </table>

                    <div style="margin-top: 20px;">
                        <table style="width: 100%; border-collapse: collapse;">
                            <tr>
                                <td>
                                    <strong>Customer Name & Address</strong><br>
                                    {{ $order->client->nama_client ?? 'Unknown' }}<br>
                                    {{ $order->client->alamat_client ?? 'Alamat tidak tersedia' }}
                                </td>
                                <td style="text-align: right;">
                                    <strong>CV. Tri Astra Persada</strong><br>
                                    Jl. Kalianyar 10 No.15 Tambora<br>
                                    Jakarta Barat
                                </td>
                            </tr>
                        </table>
                    </div>

                    <!-- Rincian Produk dan Harga -->
                    <div style="margin-top: 20px;">
                        <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
                            <thead>
                                <tr style="background-color: #f5a623; color: black; border: 1px solid black;">
                                    <th style="padding: 10px; border: 1px solid black;">No</th>
                                    <th style="padding: 10px; border: 1px solid black;">Keterangan</th>
                                    <th style="padding: 10px; border: 1px solid black;">Harga Perunit</th>
                                    <th style="padding: 10px; border: 1px solid black;">Total Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total = 0;
                                    $no = 1;
                                    if (isset($order->product_details) && count($order->product_details) > 0) {
                                        $productDetails = $order->product_details;
                                    }
                                @endphp
                                
                                @if (isset($productDetails) && count($productDetails) > 0)
                                    @foreach($productDetails as $product)
                                        @php
                                            $harga_perunit = $product['price'] ?? 0;
                                            $qty = $product['qty'] ?? 1;
                                            $nama_produk = $product['name'] ?? 'Produk tidak diketahui';
                                            $total_harga = $qty * $harga_perunit;
                                            $total += $total_harga;
                                        @endphp
                                        <tr>
                                            <td style="padding: 10px; border: 1px solid black;">{{ $no++ }}</td>
                                            <td style="padding: 10px; border: 1px solid black;">
                                                {{ $nama_produk }} (Qty: {{ $qty }})
                                            </td>
                                            <td style="padding: 10px; border: 1px solid black;">Rp. {{ number_format($harga_perunit, 2, ',', '.') }}</td>
                                            <td style="padding: 10px; border: 1px solid black;">Rp. {{ number_format($total_harga, 2, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4" style="padding: 10px; border: 1px solid black; text-align: center;">
                                            Tidak ada produk yang tersedia
                                        </td>
                                    </tr>
                                @endif
                                <tr>
                                    <td style="padding: 10px; border: 1px solid black;" colspan="3" align="right">Grand Total</td>
                                    <td style="padding: 10px; border: 1px solid black; background-color: #f5a623; color: black;">Rp. {{ number_format($total, 2, ',', '.') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div style="margin-top: 20px;">
                        {{-- <p style="margin-bottom: 2%"><strong>Terbilang:</strong> {{ ucwords(Terbilang::make($total)) }} Rupiah</p> --}}
                        <hr style="border-top: 2px solid black;">

                        <p style="margin-top: 2%"><strong>Catatan:</strong><br>
                            Pembayaran berupa Bilyet Giro, Cheque atau Transfer a.n CV. TRI ASTRA PERSADA<br>
                            No Rek: 0353268152<br>
                            Bank: BCA <br>
                            Cabang: Sudirman<br>
                            Atas Nama: CV. TRI ASTRA PERSADA
                        </p>

                        <p style="margin-top: 80px;">Hormat Kami,<br>(Susilo)</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <!-- Tombol Download PDF -->
                <button class="btn btn-success" onclick="downloadPDF()">
                    <i class="fas fa-download"></i> Download PDF
                </button>
            </div>
        </div>
    </div>
</div>
