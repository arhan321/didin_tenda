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

                    <!-- Header Logo dan Informasi Perusahaan -->
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <!-- Bagian Logo dan Teks Perusahaan -->
                    <div class="paket-tulisan" style="margin-top: -20px;">
                        <div style="display: flex; align-items: center;">
                          <div style="margin-right: 15px; margin-bottom: 60px;">
                             <img src="{{ asset('assets/logo.png') }}" alt="Logo" style="width: 50px; height: auto;">
                        </div>
                            <div>
                            <h2 style="color: #0033a0; margin: 0; font-size: 25px; margin-bottom: 50px; margin-top: 50px;">TRI ASTRA PERSADA</h2>
                              <p style="margin: 0; margin-left: -60px; margin-top: -40px;">Jalan Kalianyar X No.15 Kel.Kalianyar Kec.Tambora<br>
                                Jakarta Barat, Jakarta 11310<br>
                                Phone: <br>
                                Email : Triastrapersada@gmail.com
                              </p>
                            </div>
                        </div>
                    </div>

                        <!-- Bagian Informasi Invoice -->
                        <div style="text-align: right;">
                            <h3 style="color: black; font-weight: bold; margin: 0;">INVOICE</h3>
                            <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
                                <tr>
                                    <td style="background-color: #F0F0F0; padding: 5px;"><strong>TANGGAL</strong></td>
                                    <td style="background-color: #F0F0F0; padding: 5px;"><strong>JATUH TEMPO</strong></td>
                                    <td style="background-color: #F0F0F0; padding: 5px;"><strong>NO. INVOICE</strong></td>
                                </tr>
                                <tr>
                                    <td style="padding: 5px;">{{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y') }}</td>
                                    <td style="padding: 5px;">{{ \Carbon\Carbon::parse($order->end)->format('d/m/Y') }}</td>
                                    <td style="padding: 5px;">003-VIII-TAP-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Informasi Bill To dengan warna yang lebih pendek -->
                    <div style="margin-top: 20px;">
                        <div style="background-color: #FFD700; display: inline-block; padding: 5px; width: 150px;">
                            <strong>BILL TO</strong>
                        </div>
                        <p style="padding-left: 10px; margin-top: 5px;">
                            <strong>{{ $order->client->nama_client ?? 'Unknown' }}</strong><br>
                            {{ $order->client->alamat_client ?? 'Alamat tidak tersedia' }}
                        </p>
                    </div>

                    <!-- Tabel Deskripsi Produk -->
                    <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
                        <thead>
                            <tr style="background-color: #FFD700; color: black;">
                                <th style="padding: 10px; border: 1px solid black;">DESCRIPTION</th>
                                <th style="padding: 10px; border: 1px solid black;">UNIT PRICE</th>
                                <th style="padding: 10px; border: 1px solid black;">QTY</th>
                                <th style="padding: 10px; border: 1px solid black;">TAXED</th>
                                <th style="padding: 10px; border: 1px solid black;">AMOUNT</th>
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
                                        <td style="padding: 10px; border: 1px solid black;">{{ $nama_produk }}</td>
                                        <td style="padding: 10px; border: 1px solid black;">Rp. {{ number_format($harga_perunit, 2, ',', '.') }}</td>
                                        <td style="padding: 10px; border: 1px solid black;">{{ $qty }}</td>
                                        <td style="padding: 10px; border: 1px solid black;">-</td>
                                        <td style="padding: 10px; border: 1px solid black;">Rp. {{ number_format($total_harga, 2, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" style="padding: 10px; border: 1px solid black; text-align: center;">Tidak ada produk yang tersedia</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                    <!-- Subtotal, Tax dan Total -->
                    <div style="display: flex; justify-content: space-between; margin-top: 20px;">
                        <!-- Catatan -->
                        <div style="width: 50%; padding-right: 10px;">
                            <h4 style="background-color: #FFD700; padding: 5px;">Catatan</h4>
                            <p style="border: 1px solid black; padding: 10px;">
                                Pembayaran berupa Bilyet Giro, Cheque atau Transfer a.n CV. TRI ASTRA PERSADA<br>
                                No Rek: 0353268152 - Bank: BCA, Cabang: Sudirman, Nama: CV. TRI ASTRA PERSADA
                            </p>
                        </div>

                        <!-- Kalkulasi Total -->
                        <div style="width: 50%; padding-left: 10px;">
                            <table style="width: 100%; border-collapse: collapse;">
                                <tr>
                                    <td style="padding: 5px; border: 1px solid black;">Subtotal</td>
                                    <td style="padding: 5px; border: 1px solid black; text-align: right;">Rp. {{ number_format($total, 2, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 5px; border: 1px solid black;">Taxable</td>
                                    <td style="padding: 5px; border: 1px solid black; text-align: right;">-</td>
                                </tr>
                                <tr>
                                    <td style="padding: 5px; border: 1px solid black;">Tax rate</td>
                                    <td style="padding: 5px; border: 1px solid black; text-align: right;">0.00%</td>
                                </tr>
                                <tr>
                                    <td style="padding: 5px; border: 1px solid black;">Tax due</td>
                                    <td style="padding: 5px; border: 1px solid black; text-align: right;">-</td>
                                </tr>
                                <tr>
                                    <td style="padding: 5px; border: 1px solid black;">Other</td>
                                    <td style="padding: 5px; border: 1px solid black; text-align: right;">-</td>
                                </tr>
                                <tr>
                                    <td style="padding: 5px; border: 1px solid black; background-color: #FFD700;">TOTAL</td>
                                    <td style="padding: 5px; border: 1px solid black; background-color: #FFD700; text-align: right;">Rp. {{ number_format($total, 2, ',', '.') }}</td>
                                </tr>
                            </table>
                            <p style="text-align: right; margin-top: 10px;">Make all checks payable to <strong>CV TRI ASTRA PERSADA</strong></p>
                        </div>
                    </div>

                    <!-- Informasi Tambahan -->
                    <p style="text-align: center; margin-top: 40px;">
                        Thank You For Your Business!<br>
                        If you have any questions about this invoice, please contact<br>
                        CV TRI ASTRA PERSADA - Triastrapersada@gmail.com
                    </p>

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

<!-- JavaScript untuk menampilkan modal dan membuat PDF -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script>
function tampilkanInvoice() {
    $('#invoiceModal').modal('show');
}
function downloadPDF() {
    const { jsPDF } = window.jspdf;
    alert('Sedang memproses PDF, harap tunggu...');
    html2canvas(document.getElementById("invoiceContent"), {
        scale: 5, 
        useCORS: true, 
        logging: true
    }).then(canvas => {
        const imgData = canvas.toDataURL("image/png");
        const pdf = new jsPDF('p', 'mm', 'a4');

        const imgWidth = 190; 
        const imgHeight = canvas.height * imgWidth / canvas.width;

        pdf.addImage(imgData, 'PNG', 10, 10, imgWidth, imgHeight, undefined, 'FAST');
        pdf.save("invoice.pdf");
    }).catch(error => {
        console.error("Error while generating PDF: ", error);
    });
}

</script>