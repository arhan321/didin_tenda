@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('cruds.invoicedgpro.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.invoicedgpros.update', [$invoicedgpro->id]) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <!-- Dropdown Client -->
                <div class="form-group">
                    <label for="client_id">{{ trans('cruds.invoicedgpro.fields.nama_pemesan') }}</label>
                    <select class="form-control {{ $errors->has('client_id') ? 'is-invalid' : '' }}" name="client_id"
                        id="client_id">
                        <option value="">{{ trans('global.pleaseSelect') }}</option>
                        @foreach ($clients as $client)
                            <option value="{{ $client->id }}"
                                {{ old('client_id', $invoicedgpro->client_id) == $client->id ? 'selected' : '' }}>
                                {{ $client->nama_client }}
                            </option>
                        @endforeach
                    </select>
                    @if ($errors->has('client_id'))
                        <div class="invalid-feedback">
                            {{ $errors->first('client_id') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.sahabatechinvoice.fields.nama_pemesan_helper') }}</span>
                </div>

                <!-- Dropdown Branch -->
                <div class="form-group">
                    <label for="branch_id">{{ trans('cruds.invoicedgpro.fields.cabang') }}</label>
                    <select class="form-control {{ $errors->has('branch_id') ? 'is-invalid' : '' }}" name="branch_id"
                        id="branch_id" disabled>
                        <option value="">{{ trans('global.pleaseSelect') }}</option>
                        <!-- Branch options will be populated by JavaScript -->
                    </select>
                    @if ($errors->has('branch_id'))
                        <div class="invalid-feedback">
                            {{ $errors->first('branch_id') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.invoicedgpro.fields.cabang_helper') }}</span>
                </div>

                <!-- Dropdown Alamat -->
                <div class="form-group">
                    <label for="alamat_id">{{ trans('cruds.invoicedgpro.fields.alamat') }}</label>
                    <select class="form-control {{ $errors->has('alamat_id') ? 'is-invalid' : '' }}" name="alamat_id"
                        id="alamat_id" disabled>
                        <option value="">{{ trans('global.pleaseSelect') }}</option>
                        <!-- Alamat akan diupdate oleh JS -->
                    </select>
                    @if ($errors->has('alamat_id'))
                        <div class="invalid-feedback">
                            {{ $errors->first('alamat_id') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.invoicedgpro.fields.alamat_helper') }}</span>
                </div>



                <div class="form-group">
                    <label class="required" for="products">{{ trans('cruds.invoicedgpro.fields.product') }}</label>
                    <div style="padding-bottom: 4px">
                        <span class="btn btn-info btn-xs select-all"
                            style="border-radius: 0">{{ trans('global.select_all') }}</span>
                        <span class="btn btn-info btn-xs deselect-all"
                            style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                    </div>
                    <select class="form-control select2 {{ $errors->has('products') ? 'is-invalid' : '' }}"
                        name="products[]" id="products" multiple required>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}"
                                {{ in_array($product->id, old('products', $invoicedgpro->product_details->pluck('id')->toArray())) ? 'selected' : '' }}>
                                {{ $product->name }} 
                            </option>
                        @endforeach
                    </select>
                    @if ($errors->has('products'))
                        <div class="invalid-feedback">
                            {{ $errors->first('products') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.invoicedgpro.fields.product_helper') }}</span>
                </div>

                <!-- Dynamic Quantity Inputs -->
                <div id="product-quantities">
                    <!-- Placeholder for dynamic product quantities -->
                </div>

                <div class="form-group">
                    <label for="price">{{ trans('cruds.invoicedgpro.fields.total_price') }}</label>
                    <input class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}" type="number"
                        name="price" id="price" value="{{ old('price', $invoicedgpro->price) }}" step="0.01">
                    @if ($errors->has('price'))
                        <div class="invalid-feedback">
                            {{ $errors->first('price') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.invoicedgpro.fields.total_price_helper') }}</span>
                </div>


                <div class="form-group">
                    <label class="required" for="start">{{ trans('cruds.invoicedgpro.fields.start') }}</label>
                    <input class="form-control {{ $errors->has('start') ? 'is-invalid' : '' }}" type="date"
                        name="start" id="start" value="{{ old('start', $invoicedgpro->start) }}" required>
                    @if ($errors->has('start'))
                        <div class="invalid-feedback">
                            {{ $errors->first('start') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.invoicedgpro.fields.start_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required">{{ trans('cruds.invoicedgpro.fields.status_bayar') }}</label>
                    <select class="form-control {{ $errors->has('status_bayar') ? 'is-invalid' : '' }}" name="status_bayar"
                        id="status_bayar" required>
                        <option value disabled
                            {{ old('status_bayar', $invoicedgpro->status_bayar) === null ? 'selected' : '' }}>
                            {{ trans('global.pleaseSelect') }}</option>
                        @foreach (App\Models\Order::STATUS_SELECT as $key => $label)
                            <option value="{{ $key }}"
                                {{ old('status_bayar', $invoicedgpro->status_bayar) === (string) $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @if ($errors->has('status_bayar'))
                        <div class="invalid-feedback">
                            {{ $errors->first('status_bayar') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.invoicedgpro.fields.status_bayar_helper') }}</span>
                </div>

                <!-- Input metode pembayaran -->
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="metode_pembayaran" id="metode_upload"
                        value="upload"
                        {{ old('metode_pembayaran', $invoicedgpro->metode_pembayaran) == 'upload' ? 'checked' : '' }}>
                    <label class="form-check-label" for="metode_upload">
                        Upload Bukti Pembayaran
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="metode_pembayaran" id="metode_cash" value="cash"
                        {{ old('metode_pembayaran', $invoicedgpro->metode_pembayaran) == 'cash' ? 'checked' : '' }}>
                    <label class="form-check-label" for="metode_cash">
                        Cash
                    </label>
                </div>

                <!-- Form untuk upload bukti pembayaran -->
                <div class="form-group" id="upload_bukti_pembayaran" style="display: none;">
                    <label for="bukti_pembayaran_file" class="font-weight-bold">
                        <i class="fas fa-upload"></i> Upload Bukti Pembayaran (PDF)
                    </label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" name="bukti_pembayaran" id="bukti_pembayaran_file" accept=".pdf">
                        <label class="custom-file-label" id="fileLabel" for="bukti_pembayaran_file">
                            <!-- Tampilkan nama file lama jika ada -->
                            {{ old('bukti_pembayaran', $invoicedgpro->bukti_pembayaran ? basename($invoicedgpro->bukti_pembayaran) : 'Pilih file PDF...') }}
                        </label>
                    </div>
                </div>

                <!-- Hidden field untuk bukti_pembayaran -->
                <input type="hidden" name="bukti_pembayaran" id="bukti_pembayaran" value="">

                <!-- Tulisan jika pembayaran cash -->
                <div class="form-group" id="cash_info" style="display: none;">
                    <label class="font-weight-bold">Pembayaran:</label>
                    <p><strong>CASH</strong></p>
                </div>

                <!-- Tampilkan jika ada bukti pembayaran yang diunggah sebelumnya -->
                @if (isset($invoicedgpro) && $invoicedgpro->bukti_pembayaran && $invoicedgpro->bukti_pembayaran !== 'CASH')
                    <div class="form-group">
                        <label for="bukti_pembayaran" class="font-weight-bold">
                            <i class="fas fa-file-pdf text-danger"></i> Bukti Pembayaran yang Diunggah:
                        </label>
                        <div class="d-flex align-items-center mt-2">
                            <a href="{{ Storage::url($invoicedgpro->bukti_pembayaran) }}" target="_blank"
                                class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-eye"></i> Lihat PDF
                            </a>
                        </div>
                        <small class="form-text text-muted mt-1">
                            File PDF yang diunggah sebagai bukti pembayaran.
                        </small>
                    </div>
                @endif



                <div class="form-group">
                    <button class="btn btn-danger" type="submit">
                        {{ trans('global.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

<style>
    .custom-file-input~.custom-file-label::after {
        content: "Pilih File";
        background-color: #007bff;
        color: white;
        border-left: 1px solid #ced4da;
        padding: 0.375rem 0.75rem;
        cursor: pointer;
    }

    .custom-file-label {
        background-color: #f8f9fa;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        padding: 0.375rem 0.75rem;
    }

    .custom-file-input {
        cursor: pointer;
    }
</style>

@section('scripts')
    <script>
$(document).ready(function() {
    const productPrices = @json($productPrices);
    const oldQuantities = @json(old('product_qty', $invoicedgpro->product_details->pluck('qty', 'id')->toArray()));
    const stockData = @json($stockProduct);

    function updateProductQuantities() {
        let selectedProducts = $('#products').val();
        let productQuantitiesContainer = $('#product-quantities');
        productQuantitiesContainer.empty();

        selectedProducts.forEach(function(productId) {
            let productLabel = $('#products option[value="' + productId + '"]').text();
            let productPrice = productPrices[productId] || 0; // Default to 0 if undefined
            let oldQuantity = oldQuantities[productId] || 1;

            productQuantitiesContainer.append(`
                <div class="form-group">
                    <label for="qty_${productId}">${productLabel} {{ trans('cruds.invoicedgpro.fields.qty') }}</label>
                    <input class="form-control product-qty" data-product-id="${productId}" type="number" name="product_qty[${productId}]" id="qty_${productId}" value="${oldQuantity}" min="1">
                    <input type="hidden" class="product-price" data-product-id="${productId}" value="${productPrice}">
                    <span class="stock-info" id="stock_${productId}">Stok tersedia: ${stockData[productId]}</span>
                </div>
            `);
        });

        updateTotalPrice();
    }

    function updateTotalPrice() {
        let totalPrice = 0;
        let isStockSufficient = true;

        $('.product-qty').each(function() {
            let productId = $(this).data('product-id');
            let quantity = parseFloat($(this).val()) || 0; // Default to 0 if NaN
            let price = parseFloat($('.product-price[data-product-id="' + productId + '"]').val()) || 0; // Default to 0 if NaN
            let availableStock = stockData[productId] || 0; // Default to 0 if undefined
            
            let oldQuantity = oldQuantities[productId] || 1;
            let difference = quantity - oldQuantity;

            totalPrice += quantity * price;

            // Jika kuantitas baru lebih tinggi dari kuantitas lama
            if (difference > 0) {
                if (difference > availableStock) {
                    isStockSufficient = false;
                    $(this).addClass('is-invalid');
                    $(this).siblings('.stock-warning').remove();
                    $(this).after(`<div class="text-danger stock-warning">Stok tidak mencukupi untuk produk ${productId}!</div>`);
                } else {
                    $(this).removeClass('is-invalid');
                    $(this).siblings('.stock-warning').remove();
                }
            } else {
                // Jika kuantitas baru kurang dari atau sama dengan kuantitas lama, tidak perlu peringatan
                $(this).removeClass('is-invalid');
                $(this).siblings('.stock-warning').remove();
            }
        });

        $('#price').val(totalPrice.toFixed(2));
        $('#price').toggleClass('is-invalid', !isStockSufficient);
    }

    $('#products').change(function() {
        updateProductQuantities();
    });

    $('#product-quantities').on('input', '.product-qty', function() {
        updateTotalPrice();
    });

    updateProductQuantities();
});


        // document.querySelector('.custom-file-input').addEventListener('change', function(e) {
        //     var fileName = document.getElementById("bukti_pembayaran").files[0].name;
        //     var nextSibling = e.target.nextElementSibling;
        //     nextSibling.innerText = fileName;
        // });

        document.addEventListener('DOMContentLoaded', function() {
        var fileInput = document.getElementById('bukti_pembayaran_file');
        var fileLabel = document.getElementById('fileLabel');

        // Update label ketika file dipilih
        fileInput.addEventListener('change', function(event) {
            var fileName = event.target.files[0]?.name || 'Pilih file PDF...'; // Nama file yang dipilih
            fileLabel.textContent = fileName; // Tampilkan nama file di label
        });
    });
    </script>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tanggal end dari invoicedgpro, pastikan value diambil dari variabel $invoicedgpro->end
            var endDate = "{{ $invoicedgpro->end }}";

            if (endDate) {
                var currentDate = new Date(); // Tanggal hari ini
                var endDateObject = new Date(endDate); // Mengubah endDate menjadi objek Date

                // Jika tanggal saat ini sudah melebihi atau sama dengan tanggal end
                if (currentDate >= endDateObject) {
                    // Set dropdown ke "Sudah Selesai"
                    document.getElementById('status_sewa').value = 'Sudah Selesai';
                }
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var clientSelect = document.getElementById('client_id');
            var branchSelect = document.getElementById('branch_id');
            var alamatSelect = document.getElementById('alamat_id');

            // Data clients dari controller dalam bentuk JSON
            var clients = @json($clients);
            var selectedClientId =
            "{{ old('client_id', $invoicedgpro->client_id) }}"; // Ambil client_id yang sudah disimpan sebelumnya
            var selectedBranchId =
            "{{ old('branch_id', $invoicedgpro->cabang_id) }}"; // Ambil branch_id yang sudah disimpan sebelumnya
            var selectedAlamatId =
            "{{ old('alamat_id', $invoicedgpro->alamat_id) }}"; // Ambil alamat_id yang sudah disimpan sebelumnya

            // Fungsi untuk sinkronisasi dropdown branch dan alamat
            function syncBranchAndAlamat(clientId) {
                // Reset dropdown branch dan alamat
                branchSelect.innerHTML = '<option value="">{{ trans('global.pleaseSelect') }}</option>';
                alamatSelect.innerHTML = '<option value="">{{ trans('global.pleaseSelect') }}</option>';

                // Cari client yang sesuai berdasarkan client_id
                var selectedClient = clients.find(function(client) {
                    return client.id == clientId;
                });

                // Jika client ditemukan, sinkronkan branch dan alamat
                if (selectedClient) {
                    branchSelect.disabled = false;
                    alamatSelect.disabled = false;

                    // Tambahkan opsi untuk branch
                    var branchOption = document.createElement('option');
                    branchOption.value = selectedClient.id;
                    branchOption.textContent = selectedClient
                    .branch_client; // Misalkan ini adalah nama branch dari client
                    branchOption.selected = selectedClient.id == selectedBranchId; // Tetapkan selected option
                    branchSelect.appendChild(branchOption);

                    // Tambahkan opsi untuk alamat
                    var alamatOption = document.createElement('option');
                    alamatOption.value = selectedClient.id;
                    alamatOption.textContent = selectedClient
                    .alamat_client; // Misalkan ini adalah alamat dari client
                    alamatOption.selected = selectedClient.id == selectedAlamatId; // Tetapkan selected option
                    alamatSelect.appendChild(alamatOption);
                } else {
                    branchSelect.disabled = true;
                    alamatSelect.disabled = true;
                }
            }

            // Panggil sinkronisasi saat pertama kali halaman dimuat
            if (selectedClientId) {
                syncBranchAndAlamat(selectedClientId);
            }

            // Saat dropdown client diubah, sinkronkan branch dan alamat
            clientSelect.addEventListener('change', function() {
                var clientId = clientSelect.value;
                syncBranchAndAlamat(clientId);
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const metodeUpload = document.getElementById('metode_upload');
            const metodeCash = document.getElementById('metode_cash');
            const uploadBuktiPembayaran = document.getElementById('upload_bukti_pembayaran');
            const cashInfo = document.getElementById('cash_info');
            const buktiPembayaranField = document.getElementById('bukti_pembayaran');
            const existingBuktiPembayaran = "{{ $invoicedgpro->bukti_pembayaran }}"; // Ambil data dari PHP

            // Function to toggle visibility and set bukti_pembayaran field value
            function togglePaymentMethod() {
                if (metodeUpload.checked) {
                    uploadBuktiPembayaran.style.display = 'block';
                    cashInfo.style.display = 'none';
                } else if (metodeCash.checked) {
                    uploadBuktiPembayaran.style.display = 'none';
                    cashInfo.style.display = 'block';
                }

                // Handle the visibility of "Lihat PDF" based on payment method
                if (existingBuktiPembayaran === 'CASH') {
                    document.querySelector('.btn-outline-primary').style.display = 'none'; // Hide "Lihat PDF" link
                }
            }

            // Add event listeners to payment method radios
            metodeUpload.addEventListener('change', togglePaymentMethod);
            metodeCash.addEventListener('change', togglePaymentMethod);

            // Initialize on page load
            togglePaymentMethod();
        });
    </script>
@endsection
