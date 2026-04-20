<!-- Modal untuk Invoice -->
<div class="modal fade" id="invoiceModal" tabindex="-1" role="dialog" aria-labelledby="invoiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content" style="background-image: url('{{ asset('assets/background_dgpro.jpg') }}'); background-size: 900px; background-repeat: no-repeat; background-position: center;">
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
              <div class="paket-tulisan" style="margin-top: -20px;">
                <div style="display: flex; align-items: center;">
                  <div style="margin-right: 10px; margin-bottom: 19px;">
                    <img src="{{ asset('assets/dg_pro_universal.png') }}" alt="Logo" style="width: 150px; height: auto;">
                  </div>
                  <div>
                    <h2 style="color: #0033a0; margin: 0; font-size: 32px; margin-bottom: 65px; margin-top: 65px; font-family: 'Montserrat', sans-serif;">DG PRO UNIVERSAL</h2>
                    <p style="margin: 0; margin-left: -40px; margin-top: -40px; font-size: 15px; font-family: 'Montserrat', sans-serif;">
                      Jl. Pangeran Jayakarta Komplek 
                      46 Ruko No C2 Jakarta Pusat <br>
                      {{-- Kec. Pinang, Kota Tangerang, Banten 15145 --}}
                      <br>
                      {{-- <i class="fas fa-phone-alt"></i> Phone: +62 851-8351-9006<br> --}}
                      {{-- <i class="fas fa-envelope"></i> Email: Triastrapersada@gmail.com --}}
                    </p>
                  </div>
                </div>
              </div>
              <!-- Bagian Informasi Invoice -->
              <div style="text-align: right; margin-top: 130px;">
                <h3 style="color: black; font-weight: bold; margin: 0;">SURAT JALAN</h3>
                <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
                  <tr>
                    <td style="background-color: #d8d8d8; padding: 10px;"><strong>TANGGAL</strong></td>
                    <td style="background-color: #d8d8d8; padding: 10px;"><strong>NO. SURAT JALAN</strong></td>
                  </tr>
                  <tr>
                    <td style="padding: 5px;">
                        {{ \Carbon\Carbon::parse($dodgpro->tanggal_pengiriman)->format('d/m/Y') }}
                    </td>
                    <td style="padding: 5px; ">
                      {{ $dodgpro->id }}-{{ \Carbon\Carbon::parse($dodgpro->created_at)->format('m') }}-DGP-{{ \Carbon\Carbon::parse($dodgpro->created_at)->format('Y') }}
                    </td>
                </tr>
                </table>
              </div>
            </div>
  
            <!-- Informasi Bill To -->
            <div style="margin-top: 20px;">
              <div style="background-color: #4ec6fd; display: inline-block; padding: 10px; width: 150px;">
                  <strong>Kepada Yth. </strong>
              </div>
              <p style="padding-left: 10px; margin-top: 5px;">
                  <strong>{{ $dodgpro->client->nama_client ?? 'Unknown' }}</strong><br>
                  {{ $dodgpro->client->alamat_client ?? 'Alamat tidak tersedia' }}
              </p>
          </div>

          {{-- <div class="tulisan"
              style="text-align: center; font-weight: bold; font-size: 1rem; font-family: 'Arial', sans-serif;">
              <p>SURAT JALAN PERIODE
                  @php
                      $formattedDate = \Carbon\Carbon::parse($dodgpro->start)->format(' F Y');
                      $formattedDate = strtoupper($formattedDate);
                  @endphp
                  {{ $formattedDate }}
              </p>
          </div> --}}
  
            <!-- Tabel Deskripsi Produk -->
            <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
              <thead>
                  <tr style="background-color: #4ec6fd; color: black;">
                      <th style="padding: 10px; border: 1px solid black;">DESKRIPSI</th>
                      <th style="padding: 10px; border: 1px solid black;">QTY</th>
                  </tr>
              </thead>
              <tbody>
                  @php
                      $productDetails = isset($dodgpro->product_details)
                          ? $dodgpro->product_details
                          : [];
                  @endphp

                  @if (count($productDetails) > 0)
                      @foreach ($productDetails as $product)
                          @php
                              $qty = $product['qty'] ?? 1;
                              $nama_produk = $product['name'] ?? 'Produk tidak diketahui';
                          @endphp
                          <tr>
                              <td style="padding: 10px; border: 1px solid black; font-size: 15px;">
                                  {{ $nama_produk }}</td>
                              <td style="padding: 10px; border: 1px solid black; font-size: 15px;">
                                  {{ $qty }}</td>
                          </tr>
                      @endforeach
                  @else
                      <tr>
                          <td colspan="2"
                              style="padding: 10px; border: 1px solid black; font-size: 15px; text-align: center;">
                              Tidak ada produk yang tersedia</td>
                      </tr>
                  @endif
              </tbody>
          </table>
  
            <!-- Subtotal, Tax dan Total -->
            <div style="display: flex; justify-content: space-between; margin-top: 20px;">
              <!-- Catatan -->
              <div style="width: 50%; padding-right: 10px;">
                <h4 style="background-color: #4ec6fd; padding: 10px; font-size: 18px; font-weight: bold;">Catatan</h4>
                <p style="border: 1px solid black; padding: 10px;">
                  <strong>1. </strong>Harap periksa produk yang Anda terima dengan teliti.<br>
                  <strong>2. </strong>Jika ada ketidaksesuaian, harap segera hubungi kami.<br>
                  <strong>3. </strong>Surat Jalan ini adalah bukti pengiriman barang.
              </p>
              </div>
            </div>
            <div style="margin-top: 40px; display: flex; justify-content: space-between;">
              <div style="text-align: left;">
                  <h4 style="margin: 0;">Tanda Tangan Penerima</h4>
                  <p style="margin: 0;  margin-top:35%;">__________________________</p>
                  <p style="margin: 0; margin-top:5%;">Penerima</p>
              </div>
              <div style="text-align: left;">
                  <h4 style="margin: 0; ">Tanda Tangan Pengirim</h4>
                  <p style="margin: 0; margin-top:35%;">__________________________</p>
                  <p style="margin: 0; margin-top:5%;">Pengirim</p>
              </div>
          </div>
  
            <!-- Informasi Tambahan -->
            <p style="text-align: center; margin-top: 120px; font-style:initial; font:size: 180px;">
              Thank You For Your Business!<br>
              {{-- If you have any questions about this invoice, please contact<br> --}}
              {{-- SAHABAT TECH at +62 851-8351-9006 or email us at <a href="mailto:Triastrapersada@gmail.com">Triastrapersada@gmail.com</a> --}}
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

  const deliveryOrderData = {
            id: {{ $dodgpro->id }},
            createdAt: "{{ $dodgpro->created_at }}"
        };

        // Format nomor surat jalan di JavaScript
        const createdAtDate = new Date(deliveryOrderData.createdAt);
        const month = String(createdAtDate.getMonth() + 1).padStart(2, '0');
        const year = createdAtDate.getFullYear();
        const invoiceNumber = `${deliveryOrderData.id}-${month}-DGP-${year}`;

        // Output hasil
        console.log("SURAT JALAN:", invoiceNumber);

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
      pdf.save(`${invoiceNumber}.pdf`);
    }).catch(error => {
      console.error("Error while generating PDF: ", error);
    });
  };
}

</script>
