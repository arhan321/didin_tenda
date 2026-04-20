<!-- Modal -->
<div class="modal fade" id="invoiceModal" tabindex="-1" role="dialog" aria-labelledby="invoiceModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content"
            style="background-image: url('{{ asset('assets/sahabatech5.png') }}'); background-size: 900px; background-repeat: no-repeat; background-position: center;">
            <div class="modal-header">
                <h5 class="modal-title" id="invoiceModalLabel">Invoice </h5> <!-- Nomor invoice -->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="invoiceContent" style="padding: 30px; font-size: 14px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10%;">
                    <img src="{{ asset('assets/image_sahabatech_new.png') }}" alt="Sahabat Tech Logo"
                        style="width: 150px; height: auto;">
                    <div style="text-align: right;">
                        <strong>SAHABAT TECH</strong><br>
                        Jl. KH. Mas Mansyur No.28, RT.PinangRT.005/RW.003,<br>
                        Sudimara Pinang, Kec. Pinang, Kota Tangerang, Banten 15145<br>
                        Indonesia<br><br>
                        <strong>{{ $invoice->client->nama_client ?? 'Unknown' }}</strong><br>
                        {{ $invoice->client->branch_client ?? 'Unknown' }}<br>
                        {{ $invoice->client->alamat_client ?? 'Unknown' }}<br>
                    </div>
                </div>
                <hr style="margin-bottom: 3%">
                <h3 class="text-center" style="color: #0085c5; margin-bottom: 2%;">Invoice
                    @php
                        // Ambil tahun dari tanggal pembuatan invoice
                        $year = \Carbon\Carbon::parse($invoice->created_at)->format('Y');

                        // Ambil nomor bulan dalam format 2 digit
                        $monthNumber = \Carbon\Carbon::parse($invoice->created_at)->format('m');
                    @endphp

                    {{ str_pad($monthNumber, 2, '0', STR_PAD_LEFT) }}-{{ $year }}-SAHABATECH-{{ str_pad($invoice->id, 4, '0', STR_PAD_LEFT) }}
                </h3>
                <div style="display: flex; justify-content: space-between; margin-bottom: 3%;">
                    <div>
                        <p><strong>Invoice Date:</strong> {{ \Carbon\Carbon::parse($invoice->start)->format('d/m/Y') }}
                        </p>
                    </div>
                    <div>
                        <p><strong>Due Date:</strong> {{ \Carbon\Carbon::parse($invoice->end)->format('d/m/Y') }}</p>
                    </div>
                </div>

                <table class="table table-bordered">
                    <thead>
                        <tr style="background-color: #f2f2f2;">
                            <th>Description</th>
                            <th class="text-center">Unit Price</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-right">Taxes</th>
                            <th class="text-right">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $total = 0; // Inisialisasi total harga
                        @endphp

                        @if (isset($invoice->product_details) && count($invoice->product_details) > 0)
                            @foreach ($invoice->product_details as $product)
                                @php
                                    $harga_perunit = $product['price'] ?? 0;
                                    $qty = $product['qty'] ?? 1;
                                    $nama_produk = $product['name'] ?? 'Produk tidak diketahui';
                                    $total_harga = $qty * $harga_perunit;
                                    $total += $total_harga;
                                @endphp
                                <tr>
                                    <td style="padding: 10px;">{{ $nama_produk }}</td>
                                    <td class="text-right" style="padding: 10px;">Rp
                                        {{ number_format($harga_perunit, 2, ',', '.') }}</td>
                                    <td class="text-center" style="padding: 10px;">{{ $qty }}</td>
                                    <td class="text-right" style="padding: 10px;">Rp
                                        {{ number_format(($harga_perunit * $invoice->tax) / 100, 2, ',', '.') }}</td>
                                    <td class="text-right" style="padding: 10px;">Rp
                                        {{ number_format($total_harga + ($total_harga * $invoice->tax) / 100, 2, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" style="padding: 10px; text-align: center;">Tidak ada produk yang
                                    tersedia</td>
                            </tr>
                        @endif
                    </tbody>
                </table>

                <div style="display: flex; justify-content: space-between; margin-top: 20px; margin-bottom: 60%;">
                    <div>
                        <p><strong>Payment terms:</strong> Immediate Payment</p>
                        @if ($invoice->bukti_pembayaran !== 'CASH')
                            <p><strong>Payment Communication:</strong> 5930772714 BCA a/n Arinda</p>
                        @else
                            <p><strong>Payment Communication:</strong> CASH</p>
                        @endif
                    </div>
                    <div>
                        <h4>Total: Rp {{ number_format($total + ($total * $invoice->tax) / 100, 2, ',', '.') }}</h4>
                    </div>
                </div>


                <div style="text-align: center; margin-top: 50px; font-size: 12px;">
                    Sahabat Tech Pc Service, Web & Application Creation
                </div>

                <!-- Footer Section -->
                <div style="border-top: 1px solid #000; padding-top: 10px; margin-top: 40px;">
                    <div style="display: flex; justify-content: space-between; font-size: 12px;">
                        <div>
                            Sahabat Tech Pc Service, Web &<br>
                            Aplication Creation
                        </div>
                        <div style="text-align: center;">
                            SAHABAT TECH<br>
                            Jl. KH. Mas Mansyur No.28,<br>
                            RT.PinangRT.005/RW.003, Sudimara Pinang,<br>
                            Kec. Pinang, Kota Tangerang, Banten 15145 Indonesia
                        </div>
                        <div style="text-align: right;">
                            Sahabat Tech Pc Service, Web &<br>
                            Aplication Creation
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" onclick="downloadPDF()">Download PDF</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script>
    function tampilkanInvoice() {
        $('#invoiceModal').modal('show');
    }

    function downloadPDF() {
        const {
            jsPDF
        } = window.jspdf;
        alert('Sedang memproses PDF, harap tunggu...');

        // Menetapkan nomor invoice statis
        // Mengambil data dinamis dari PHP (Laravel Blade)
        const createdAt =
            "{{ \Carbon\Carbon::parse($invoice->created_at)->format('Y-m-d') }}"; // Tanggal dinamis dari server-side
        const invoiceId = "{{ str_pad($invoice->id, 4, '0', STR_PAD_LEFT) }}"; // ID invoice dinamis dari server-side

        // Mengambil bulan dalam format 2 digit
        const monthNumber = String(new Date(createdAt).getMonth() + 1).padStart(2, '0');

        // Mengambil tahun dari tanggal pembuatan invoice
        const year = new Date(createdAt).getFullYear();

        // Membuat format invoiceNumber sesuai instruksi Anda
        const invoiceNumber = `${monthNumber}-${year}-SAHABATECH-${invoiceId}`;

        // Cetak invoiceNumber (nomor invoice dinamis)
        console.log(invoiceNumber);


        // Muat gambar latar belakang
        const backgroundImg = new Image();
        backgroundImg.src = '{{ asset('assets/sahabatech5.png') }}';

        backgroundImg.onload = function() {
            // Gunakan html2canvas untuk menangkap elemen HTML
            html2canvas(document.getElementById("invoiceContent"), {
                scale: 5,
                useCORS: true,
                logging: true,
                backgroundColor: null // Ikuti latar belakang dari HTML
            }).then(canvas => {
                const imgData = canvas.toDataURL("image/png"); // Konversi elemen ke gambar PNG
                const pdf = new jsPDF('p', 'mm', 'a4'); // Membuat PDF ukuran A4 potret

                // Ukuran halaman A4
                const pageWidth = 210;
                const pageHeight = 297;

                // Tambahkan gambar latar belakang (seluruh halaman)
                pdf.addImage(backgroundImg, 'PNG', 0, 0, pageWidth, pageHeight);

                // Tentukan dimensi gambar dari konten
                const imgWidth = pageWidth - 20; // Memberikan margin 10mm di sisi kiri dan kanan
                const imgHeight = canvas.height * imgWidth / canvas.width;

                // Tambahkan konten di atas latar belakang
                pdf.addImage(imgData, 'PNG', 10, 10, imgWidth, imgHeight, undefined, 'FAST');

                // Simpan PDF dengan nama file yang sesuai
                pdf.save(`invoice_${invoiceNumber}.pdf`);
            }).catch(error => {
                console.error("Error while generating PDF: ", error);
                alert('Error generating PDF. Please try again.');
            });
        };

        backgroundImg.onerror = function() {
            alert('Gagal memuat gambar latar belakang. Periksa path gambar.');
        };
    }
</script>
