<!-- Modal untuk Invoice -->
<div class="modal fade" id="invoiceModal" tabindex="-1" role="dialog" aria-labelledby="invoiceModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" style="background-image: url('{{ asset('assets/gradient-transformed.png') }}'); background-size: 900px; background-repeat: no-repeat; background-position: center;">
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
                <div style="margin-right: 10px; margin-bottom: 19px;">
                  <img src="{{ asset('assets/logo.png') }}" alt="Logo" style="width: 35px; height: auto;">
                </div>
                <div>
                  <h2
                    style="color: #0033a0; margin: 0; font-size: 32px; margin-bottom: 65px; margin-top: 65px; font-family: 'Montserrat', sans-serif;">
                    TRI ASTRA PERSADA</h2>
                  <p
                    style="margin: 0; margin-left: -40px; margin-top: -40px; font-size: 15px; font-family: 'Montserrat', sans-serif;">
                    Jalan Kalianyar X No.15 Kel.Kalianyar Kec.Tambora<br>
                    Jakarta Barat, Jakarta 11310<br>
                    <i class="fas fa-phone-alt"></i> Phone: +62 851-8351-9006<br>
                    <i class="fas fa-envelope"></i> Email: Triastrapersada@gmail.com
                  </p>
                </div>
              </div>
            </div>

            <!-- Bagian Informasi Invoice -->
            <div style="text-align: right; margin-top: 130px;">
              <h3 style="color: black; font-weight: bold; margin: 0;">INVOICE</h3>
              <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
                <tr>
                  {{-- <td style="background-color: #ffffff; padding: 10px;"><strong>TANGGAL</strong></td> --}}
                  <td style="background-color: #ffffff; padding: 10px;"><strong>TANGGAL</strong></td>
                  <td style="background-color: #ffffff; padding: 10px;"><strong>JATUH TEMPO</strong></td>
                  <td style="background-color: #ffffff; padding: 10px;"><strong>NO. INVOICE</strong></td>
                </tr>
                <tr>
                  {{-- <td style="padding: 5px;">{{ \Carbon\Carbon::parse($orderbarang->start)->format('d/m/Y') }}</td> --}}
                  <td style="padding: 5px;">{{ \Carbon\Carbon::parse($orderbarang->start_date)->format('d/m/Y') }}</td>
                  <td style="padding: 5px;">{{ \Carbon\Carbon::parse($orderbarang->jatuh_tempo)->format('d/m/Y') }}</td>
                  <td style="padding: 5px;">
                    @php
                      $monthsInRoman = [
                          1 => 'I',
                          2 => 'II',
                          3 => 'III',
                          4 => 'IV',
                          5 => 'V',
                          6 => 'VI',
                          7 => 'VII',
                          8 => 'VIII',
                          9 => 'IX',
                          10 => 'X',
                          11 => 'XI',
                          12 => 'XII',
                      ];

                      // Ambil nomor bulan dalam format 2 digit
                      $monthNumber = \Carbon\Carbon::parse($orderbarang->created_at)->format('m');

                      // Ambil bulan dalam angka Romawi
                      $monthInRoman = $monthsInRoman[\Carbon\Carbon::parse($orderbarang->created_at)->format('n')];
                    @endphp

                    {{ str_pad($monthNumber, 3, '0', STR_PAD_LEFT) }}-{{ $monthInRoman }}-TAP-{{ str_pad($orderbarang->id, 4, '0', STR_PAD_LEFT) }}
                  </td>
                </tr>
              </table>
            </div>
          </div>

          <!-- Informasi Bill To dengan warna yang lebih pendek -->
          <div style="margin-top: 20px;">
            <div style="background-color: #FFD700; display: inline-block; padding: 10px; width: 150px;">
              <strong>BILL TO</strong>
            </div>
            <p style="padding-left: 10px; margin-top: 5px;">
              <strong>{{ $orderbarang->client->nama_client ?? 'Unknown' }}</strong><br>
              {{ $orderbarang->client->alamat_client ?? 'Alamat tidak tersedia' }}
            </p>
          </div>

          {{-- <div class="tulisan" style="text-align: center; font-weight: bold; font-size: 1rem; font-family: 'Arial', sans-serif;">
            <p>TAGIHAN PENYEWAAN PERIODE
                @php
                    // Format tanggal, bulan (uppercase), dan tahun dari field 'start'
                    $formattedDate = \Carbon\Carbon::parse($orderbarang->start)->format(' F Y');
                    $formattedDate = strtoupper($formattedDate); // Mengubah bulan menjadi uppercase
                @endphp
                {{ $formattedDate }}
            </p>
        </div> --}}

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
                if (isset($orderbarang->product_details) && count($orderbarang->product_details) > 0) {
                    $productDetails = $orderbarang->product_details;
                }
              @endphp

              @if (isset($productDetails) && count($productDetails) > 0)
                @foreach ($productDetails as $product)
                  @php
                    $harga_perunit = $product['price'] ?? 0;
                    $qty = $product['qty'] ?? 1;
                    $nama_produk = $product['name'] ?? 'Produk tidak diketahui';
                    $total_harga = $qty * $harga_perunit;
                    $total += $total_harga;
                  @endphp
                  <tr>
                    <td style="padding: 10px; border: 1px solid black; font-size: 15px;">{{ $nama_produk }}</td>
                    <td style="padding: 10px; border: 1px solid black; font-size: 15px;">Rp.
                      {{ number_format($harga_perunit, 2, ',', '.') }}</td>
                    <td style="padding: 10px; border: 1px solid black; font-size: 15px;">{{ $qty }}</td>
                    <td style="padding: 10px; border: 1px solid black; font-size: 15px;">-</td>
                    <td style="padding: 10px; border: 1px solid black; font-size: 15px;">Rp.
                      {{ number_format($total_harga, 2, ',', '.') }}</td>
                  </tr>
                @endforeach
              @else
                <tr>
                  <td colspan="5"
                    style="padding: 10px; border: 1px solid black; font-size: 15px; text-align: center;">Tidak ada
                    produk yang tersedia</td>
                </tr>
              @endif
            </tbody>
          </table>

          <!-- Subtotal, Tax dan Total -->
          <div style="display: flex; justify-content: space-between; margin-top: 20px;">
            <!-- Catatan -->
            <div style="width: 50%; padding-right: 10px;">
              <h4 style="background-color: #FFD700; padding: 10px; font-size: 18px; font-weight: bold;">Catatan</h4>
              <p style="border: 1px solid black; padding: 10px; line-height: 1.6;">
                Pembayaran berupa Bilyet Giro, Cheque atau Transfer a.n CV. TRI ASTRA PERSADA<br>
                <span style="display: inline-block; width: 100px;">No Rek</span>: 0353268152<br>
                <span style="display: inline-block; width: 100px;">Bank</span>: BCA<br>
                <span style="display: inline-block; width: 100px;">Cabang</span>: Sudirman<br>
                <span style="display: inline-block; width: 100px;">Nama</span>: CV. TRI ASTRA PERSADA
              </p>
            </div>
            <!-- Kalkulasi Total -->
            <div style="width: 50%; padding-left: 10px; margin-bottom: 150px;">
              <table style="width: 100%; border-collapse: collapse;">
                <tr>
                  <td style="padding: 10px; font-size: 18px; border: 1px solid black;">Subtotal</td>
                  <td style="padding: 10px; font-size: 18px; border: 1px solid black; text-align: right;">Rp.
                    {{ number_format($total, 2, ',', '.') }}</td>
                </tr>
                {{-- <tr>
                                    <td style="padding: 10px; font-size: 18px; border: 1px solid black;">Taxable</td>
                                    <td style="padding: 10px; font-size: 18px; border: 1px solid black; text-align: right;">-</td>
                                </tr> --}}
                <tr>
                  <td style="padding: 10px; font-size: 18px; border: 1px solid black;">Tax rate</td>
                  <td style="padding: 10px; font-size: 18px; border: 1px solid black; text-align: right;">0.00%</td>
                </tr>
                {{-- <tr>
                                    <td style="padding: 10px; font-size: 18px; border: 1px solid black;">Tax due</td>
                                    <td style="padding: 10px; font-size: 18px; border: 1px solid black; text-align: right;">-</td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px; font-size: 18px; border: 1px solid black;">Other</td>
                                    <td style="padding: 10px; font-size: 18px; border: 1px solid black; text-align: right;">-</td>
                                </tr> --}}
                <tr>
                  <td style="padding: 10px; font-size: 18px; border: 1px solid black; background-color: #FFD700;">TOTAL
                  </td>
                  <td
                    style="padding: 10px; font-size: 18px; border: 1px solid black; background-color: #FFD700; text-align: right;">
                    Rp. {{ number_format($total, 2, ',', '.') }}</td>
                </tr>
              </table>
              <p style="text-align: right; margin-top: 10px;">Make all checks payable to <strong>CV TRI ASTRA
                  PERSADA</strong></p>
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

  const invoiceNumber = 
    "{{ str_pad(\Carbon\Carbon::parse($orderbarang->created_at)->format('m'), 3, '0', STR_PAD_LEFT) }}-{{ $monthsInRoman[\Carbon\Carbon::parse($orderbarang->created_at)->format('n')] }}-TAP-{{ str_pad($orderbarang->id, 4, '0', STR_PAD_LEFT) }}";

  // Load the background image first
  const backgroundImg = new Image();
  backgroundImg.src = '{{ asset('assets/gradient-transformed.png') }}'; // Set background image path

  backgroundImg.onload = function() {
    html2canvas(document.getElementById("invoiceContent"), {
      scale: 3,
      useCORS: true,
      logging: true,
      backgroundColor: null // Ensures background is transparent to capture image background
    }).then(canvas => {
      const imgData = canvas.toDataURL("image/png");
      const pdf = new jsPDF('p', 'mm', 'a4');

      // Ukuran halaman A4
      const pageWidth = 210;
      const pageHeight = 297;

      // Draw the background image (full page A4 size)
      pdf.addImage(backgroundImg, 'PNG', 0, 0, pageWidth, pageHeight);

      // Konversi kanvas menjadi gambar untuk konten
      const imgWidth = pageWidth - 20; // Memberi margin 10mm di kiri dan kanan
      const imgHeight = canvas.height * imgWidth / canvas.width;

      // Draw the content image over the background
      pdf.addImage(imgData, 'PNG', 10, 10, imgWidth, imgHeight, undefined, 'FAST');
      
      // Save the PDF
      pdf.save(`invoice_${invoiceNumber}.pdf`);
    }).catch(error => {
      console.error("Error while generating PDF: ", error);
    });
  };
}

</script>
