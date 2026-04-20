@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('cruds.deliveryordertech.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.deliveryordertech.update', [$deliveryordertech->id]) }}"
                enctype="multipart/form-data">
                @method('PUT')
                @csrf

                <!-- Field Pengantar -->
                <div class="form-group">
                    <label for="pengantar">{{ trans('cruds.deliveryordertech.fields.pengantar') }}</label>
                    <input class="form-control {{ $errors->has('pengantar') ? 'is-invalid' : '' }}" 
                           type="text" name="pengantar" id="pengantar" 
                           value="{{ old('pengantar', $deliveryordertech->pengantar) }}">
                    @if ($errors->has('pengantar'))
                        <div class="invalid-feedback">
                            {{ $errors->first('pengantar') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.deliveryordertech.fields.pengantar_helper') }}</span>
                </div>

                <!-- Field Tanggal Pengiriman -->
                <div class="form-group">
                    <label for="tanggal_pengiriman">{{ trans('cruds.deliveryordertech.fields.tanggal') }}</label>
                    <input class="form-control {{ $errors->has('tanggal_pengiriman') ? 'is-invalid' : '' }}" 
                           type="date" name="tanggal_pengiriman" id="tanggal_pengiriman" 
                           value="{{ old('tanggal_pengiriman', $deliveryordertech->tanggal_pengiriman) }}">
                    @if ($errors->has('tanggal_pengiriman'))
                        <div class="invalid-feedback">
                            {{ $errors->first('tanggal_pengiriman') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.deliveryordertech.fields.tanggal_helper') }}</span>
                </div>

                <!-- Dropdown Client -->
                <div class="form-group">
                    <label for="client_id">{{ trans('cruds.deliveryordertech.fields.nama_pemesan') }}</label>
                    <select class="form-control {{ $errors->has('client_id') ? 'is-invalid' : '' }}" 
                            name="client_id" id="client_id">
                        <option value="">{{ trans('global.pleaseSelect') }}</option>
                        @foreach ($clients as $client)
                            <option value="{{ $client->id }}"
                                {{ old('client_id', $deliveryordertech->client_id) == $client->id ? 'selected' : '' }}>
                                {{ $client->nama_client }}
                            </option>
                        @endforeach
                    </select>
                    @if ($errors->has('client_id'))
                        <div class="invalid-feedback">
                            {{ $errors->first('client_id') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.deliveryordertech.fields.nama_pemesan_helper') }}</span>
                </div>

                <!-- Dropdown Branch (Disabled; akan diisi oleh JavaScript) -->
                <div class="form-group">
                    <label for="branch_id">{{ trans('cruds.deliveryordertech.fields.cabang') }}</label>
                    <select class="form-control {{ $errors->has('branch_id') ? 'is-invalid' : '' }}" 
                            name="branch_id" id="branch_id" disabled>
                        <!-- Branches akan diupdate oleh JavaScript -->
                    </select>
                    @if ($errors->has('branch_id'))
                        <div class="invalid-feedback">
                            {{ $errors->first('branch_id') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.deliveryordertech.fields.cabang_helper') }}</span>
                </div>

                <!-- Dropdown Alamat (Disabled; akan diisi oleh JavaScript) -->
                <div class="form-group">
                    <label for="alamat_id">{{ trans('cruds.deliveryordertech.fields.alamat') }}</label>
                    <select class="form-control {{ $errors->has('alamat_id') ? 'is-invalid' : '' }}" 
                            name="alamat_id" id="alamat_id" disabled>
                        <!-- Addresses akan diupdate oleh JavaScript -->
                    </select>
                    @if ($errors->has('alamat_id'))
                        <div class="invalid-feedback">
                            {{ $errors->first('alamat_id') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.deliveryordertech.fields.alamat_helper') }}</span>
                </div>

                <!-- Dropdown Product -->
                <div class="form-group">
                    <label class="required" for="products">{{ trans('cruds.deliveryordertech.fields.product') }}</label>
                    <div style="padding-bottom: 4px">
                        <span class="btn btn-info btn-xs select-all" style="border-radius: 0">
                            {{ trans('global.select_all') }}
                        </span>
                        <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">
                            {{ trans('global.deselect_all') }}
                        </span>
                    </div>
                    <select class="form-control select2 {{ $errors->has('products') ? 'is-invalid' : '' }}"
                        name="products[]" id="products" multiple required>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}"
                                {{ in_array($product->id, old('products', [])) || collect($deliveryordertech->product_details ?? [])->pluck('id')->contains($product->id) ? 'selected' : '' }}>
                                {{ $product->name }}
                            </option>
                        @endforeach
                    </select>
                    @if ($errors->has('products'))
                        <div class="invalid-feedback">
                            {{ $errors->first('products') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.deliveryordertech.fields.product_helper') }}</span>
                </div>

                <!-- Dynamic Quantity Inputs -->
                <div id="product-quantities">
                    <!-- Tempat untuk input quantity produk yang dinamis -->
                </div>

                <!-- Dropdown Status -->
                <div class="form-group">
                    <label for="status" class="required">{{ trans('cruds.deliveryordertech.fields.status') }}</label>
                    <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" 
                            name="status" id="status">
                        <option value="pending" {{ old('status', $deliveryordertech->status) == 'pending' ? 'selected' : '' }}>
                            pending
                        </option>
                        <option value="delivered" {{ old('status', $deliveryordertech->status) == 'delivered' ? 'selected' : '' }}>
                            delivered
                        </option>
                        <option value="canceled" {{ old('status', $deliveryordertech->status) == 'canceled' ? 'selected' : '' }}>
                            canceled
                        </option>
                    </select>
                    @if ($errors->has('status'))
                        <div class="invalid-feedback">
                            {{ $errors->first('status') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.deliveryordertech.fields.status_helper') }}</span>
                </div>

                <div class="form-group">
                    <button class="btn btn-danger" type="submit">
                        {{ trans('global.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Mengambil harga produk dari Productech
            const productPrices = @json($productPrices);
            // Mengambil kuantitas lama, default diambil dari deliveryordertech->product_details (pluck qty berdasarkan id)
            const oldQuantities = @json(old('product_qty', $deliveryordertech->product_details->pluck('qty', 'id')->toArray()));

            function updateProductQuantities() {
                let selectedProducts = $('#products').val();
                let productQuantitiesContainer = $('#product-quantities');
                productQuantitiesContainer.empty();

                selectedProducts.forEach(function(productId) {
                    let productLabel = $('#products option[value="' + productId + '"]').text();
                    let productPrice = productPrices[productId];
                    let oldQuantity = oldQuantities[productId] || 1; // Default ke 1 jika tidak ada data lama

                    productQuantitiesContainer.append(`
                        <div class="form-group">
                            <label for="qty_${productId}">${productLabel} {{ trans('cruds.deliveryordertech.fields.qty') }}</label>
                            <input class="form-control product-qty" data-product-id="${productId}" type="number" name="product_qty[${productId}]" id="qty_${productId}" value="${oldQuantity}">
                            <input type="hidden" class="product-price" data-product-id="${productId}" value="${productPrice}">
                        </div>
                    `);
                });

                updateTotalPrice();
            }

            function updateTotalPrice() {
                let totalPrice = 0;
                $('.product-qty').each(function() {
                    let productId = $(this).data('product-id');
                    let quantity = parseFloat($(this).val());
                    let price = parseFloat($('.product-price[data-product-id="' + productId + '"]').val());
                    totalPrice += quantity * price;
                });
                $('#price').val(totalPrice.toFixed(2));
            }

            $('#products').change(function() {
                updateProductQuantities();
            });

            $('#product-quantities').on('input', '.product-qty', function() {
                updateTotalPrice();
            });

            // Inisialisasi kuantitas dan harga ketika halaman dimuat
            updateProductQuantities();
        });

        // Jika ada file input, update nama file (jika diperlukan)
        document.querySelector('.custom-file-input')?.addEventListener('change', function(e) {
            var fileName = document.getElementById("bukti_pembayaran")?.files[0]?.name;
            var nextSibling = e.target.nextElementSibling;
            if (nextSibling && fileName) {
                nextSibling.innerText = fileName;
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const clientSelect = document.getElementById('client_id');
            const branchSelect = document.getElementById('branch_id');
            const alamatSelect = document.getElementById('alamat_id');

            // Data clients dikirim dari controller
            const clients = @json($clients);
            const selectedClientId = "{{ old('client_id', $deliveryordertech->client_id) }}";
            const selectedBranchId = "{{ old('branch_id', $deliveryordertech->branch_id) }}";
            const selectedAlamatId = "{{ old('alamat_id', $deliveryordertech->alamat_id) }}";

            // Fungsi untuk menyinkronkan dropdown branch dan alamat
            function syncBranchAndAlamat(clientId) {
                branchSelect.innerHTML = '';
                alamatSelect.innerHTML = '';

                const selectedClient = clients.find(client => client.id == clientId);

                if (selectedClient) {
                    // Aktifkan dropdown branch dan alamat
                    branchSelect.disabled = false;
                    alamatSelect.disabled = false;

                    // Isi dropdown branch
                    const branchOption = document.createElement('option');
                    branchOption.value = selectedClient.branch_id;
                    branchOption.textContent = selectedClient.branch_client;
                    branchOption.selected = selectedBranchId == selectedClient.branch_id;
                    branchSelect.appendChild(branchOption);

                    // Isi dropdown alamat
                    selectedClient.addresses.forEach(function(address) {
                        const alamatOption = document.createElement('option');
                        alamatOption.value = address.id;
                        alamatOption.textContent = address.full_address;
                        alamatOption.selected = selectedAlamatId == address.id;
                        alamatSelect.appendChild(alamatOption);
                    });

                    // Jika selectedAlamatId tidak ditemukan dalam list, tambahkan opsi khusus
                    if (!Array.from(alamatSelect.options).some(option => option.value == selectedAlamatId)) {
                        const missingAlamatOption = document.createElement('option');
                        missingAlamatOption.value = selectedAlamatId;
                        missingAlamatOption.textContent = "Alamat yang dipilih tidak ditemukan";
                        missingAlamatOption.selected = true;
                        alamatSelect.appendChild(missingAlamatOption);
                    }

                } else {
                    branchSelect.disabled = true;
                    alamatSelect.disabled = true;
                }
            }

            // Sinkronisasi awal ketika halaman dimuat
            if (selectedClientId) {
                syncBranchAndAlamat(selectedClientId);
            }

            // Sinkronisasi ketika dropdown client berubah
            clientSelect.addEventListener('change', function() {
                syncBranchAndAlamat(clientSelect.value);
            });
        });
    </script>
@endsection
