@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('cruds.orderbarangs.title_singular') }}
        </div>

        <div class="card-body">
            {{-- Gunakan route('admin.orderbarangs.update', $orderbarang->id) --}}
            <form method="POST" action="{{ route('admin.orderbarangs.update', [$orderbarang->id]) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf

                <!-- Dropdown Client -->
                <div class="form-group">
                    <label for="client_id">{{ trans('cruds.orderbarangs.fields.nama_pemesan') }}</label>
                    <select class="form-control {{ $errors->has('client_id') ? 'is-invalid' : '' }}" name="client_id" id="client_id">
                        <option value="">{{ trans('global.pleaseSelect') }}</option>
                        @foreach ($clients as $client)
                            <option value="{{ $client->id }}"
                                {{ old('client_id', $orderbarang->client_id) == $client->id ? 'selected' : '' }}>
                                {{ $client->nama_client }}
                            </option>
                        @endforeach
                    </select>
                    @if ($errors->has('client_id'))
                        <div class="invalid-feedback">
                            {{ $errors->first('client_id') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.orderbarangs.fields.nama_pemesan_helper') }}</span>
                </div>

                <!-- Dropdown Cabang -->
                <div class="form-group">
                    <label for="cabang_id">{{ trans('cruds.orderbarangs.fields.cabang') }}</label>
                    <select class="form-control {{ $errors->has('cabang_id') ? 'is-invalid' : '' }}"
                            name="cabang_id" id="cabang_id">
                        <option value="">{{ trans('global.pleaseSelect') }}</option>
                        {{-- Akan diisi lewat JS --}}
                    </select>
                    @if ($errors->has('cabang_id'))
                        <div class="invalid-feedback">
                            {{ $errors->first('cabang_id') }}
                        </div>
                    @endif
                </div>

                <!-- Dropdown Alamat -->
                <div class="form-group">
                    <label for="alamat_id">{{ trans('cruds.orderbarangs.fields.alamat') }}</label>
                    <select class="form-control {{ $errors->has('alamat_id') ? 'is-invalid' : '' }}"
                            name="alamat_id" id="alamat_id">
                        <option value="">{{ trans('global.pleaseSelect') }}</option>
                        {{-- Akan diisi lewat JS --}}
                    </select>
                    @if ($errors->has('alamat_id'))
                        <div class="invalid-feedback">
                            {{ $errors->first('alamat_id') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.orderbarangs.fields.alamat_helper') }}</span>
                </div>

                <!-- Pilihan Produk (Multiple) -->
                <div class="form-group">
                    <label class="required" for="products">{{ trans('cruds.orderbarangs.fields.product') }}</label>
                    <div style="padding-bottom: 4px">
                        <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                        <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                    </div>
                    <select class="form-control select2 {{ $errors->has('products') ? 'is-invalid' : '' }}"
                            name="products[]" id="products" multiple required>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}"
                                {{-- Cek apakah produk terpilih di old() atau di $orderbarang->product_details --}}
                                @if(
                                    in_array($product->id, old('products', [])) ||
                                    collect($orderbarang->product_details ?? [])->pluck('id')->contains($product->id)
                                )
                                    selected
                                @endif
                            >
                                {{ $product->name }}
                            </option>
                        @endforeach
                    </select>
                    @if ($errors->has('products'))
                        <div class="invalid-feedback">
                            {{ $errors->first('products') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.orderbarangs.fields.product_helper') }}</span>
                </div>

                <!-- Dynamic Quantity Inputs -->
                <div id="product-quantities">
                    <!-- Placeholder for dynamic product quantities -->
                </div>

                <!-- Price -->
                <div class="form-group">
                    <label for="price">{{ trans('cruds.orderbarangs.fields.price') }}</label>
                    <input
                        class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}"
                        type="number"
                        name="price"
                        id="price"
                        value="{{ old('price', $orderbarang->price) }}"
                        step="0.01"
                    >
                    @if ($errors->has('price'))
                        <div class="invalid-feedback">
                            {{ $errors->first('price') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.orderbarangs.fields.price_helper') }}</span>
                </div>

                <div class="form-group">
                    <label for="start_date">{{ trans('cruds.orderbarangs.fields.start_date') }}</label>
                    <input
                        class="form-control {{ $errors->has('start_date') ? 'is-invalid' : '' }}"
                        type="date"
                        name="start_date"
                        id="start_date"
                        value="{{ old('start_date', $orderbarang->start_date) }}"
                    >
                    @if ($errors->has('start_date'))
                        <div class="invalid-feedback">
                            {{ $errors->first('start_date') }}
                        </div>
                    @endif
                </div>

                <!-- Contoh Tanggal Jatuh Tempo -->
                <div class="form-group">
                    <label for="jatuh_tempo">{{ trans('cruds.orderbarangs.fields.end') }}</label>
                    <input
                        class="form-control {{ $errors->has('jatuh_tempo') ? 'is-invalid' : '' }}"
                        type="date"
                        name="jatuh_tempo"
                        id="jatuh_tempo"
                        value="{{ old('jatuh_tempo', $orderbarang->jatuh_tempo) }}"
                    >
                    @if ($errors->has('jatuh_tempo'))
                        <div class="invalid-feedback">
                            {{ $errors->first('jatuh_tempo') }}
                        </div>
                    @endif
                </div>

                <!-- Status Bayar -->
                <div class="form-group">
                    <label class="required">{{ trans('cruds.orderbarangs.fields.status_bayar') }}</label>
                    <select
                        class="form-control {{ $errors->has('status_bayar') ? 'is-invalid' : '' }}"
                        name="status_bayar"
                        id="status_bayar"
                        required
                    >
                        <option value disabled {{ old('status_bayar', $orderbarang->status_bayar) === null ? 'selected' : '' }}>
                            {{ trans('global.pleaseSelect') }}
                        </option>
                        @foreach (App\Models\OrdersBarang::STATUS_SELECT as $key => $label)
                            <option value="{{ $key }}"
                                {{ old('status_bayar', $orderbarang->status_bayar) === (string) $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @if ($errors->has('status_bayar'))
                        <div class="invalid-feedback">
                            {{ $errors->first('status_bayar') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.orderbarangs.fields.status_bayar_helper') }}</span>
                </div>

                <!-- Upload Bukti Pembayaran -->
                <div class="form-group">
                    <label for="bukti_pembayaran" class="font-weight-bold">
                        <i class="fas fa-upload"></i> Upload Bukti Pembayaran (PDF)
                    </label>
                    <div class="custom-file">
                        <input
                            type="file"
                            class="custom-file-input"
                            name="bukti_pembayaran"
                            id="bukti_pembayaran"
                            accept=".pdf"
                        >
                        <label class="custom-file-label" for="bukti_pembayaran">Pilih file PDF...</label>
                    </div>
                </div>


                <!-- Jika sudah ada file bukti pembayaran yang diunggah -->
                @if (isset($orderbarang) && $orderbarang->bukti_pembayaran)
                    <div class="form-group">
                        <label class="font-weight-bold">
                            <i class="fas fa-file-pdf text-danger"></i> Bukti Pembayaran yang Diunggah:
                        </label>
                        <div class="d-flex align-items-center mt-2">
                            <a href="{{ Storage::url($orderbarang->bukti_pembayaran) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-eye"></i> Lihat PDF
                            </a>
                        </div>
                        <small class="form-text text-muted mt-1">
                            File PDF yang diunggah sebagai bukti pembayaran.
                        </small>
                    </div>
                @endif

                <!-- Tombol Simpan -->
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
            // Prices from Product model
            const productPrices = @json($productPrices);

            // Ambil data product_qty lama, jika ada
            const oldQuantities = @json(old('product_qty', $orderbarang->product_details->pluck('qty', 'id')->toArray()));

            function updateProductQuantities() {
                let selectedProducts = $('#products').val() || [];
                let productQuantitiesContainer = $('#product-quantities');
                productQuantitiesContainer.empty();

                selectedProducts.forEach(function(productId) {
                    let productLabel = $('#products option[value="' + productId + '"]').text();
                    let productPrice = productPrices[productId] || 0;
                    // Ambil qty lama, default 1
                    let oldQuantity = oldQuantities[productId] || 1;

                    productQuantitiesContainer.append(`
                        <div class="form-group">
                            <label for="qty_${productId}">${productLabel} {{ trans('cruds.orderbarangs.fields.qty') }}</label>
                            <input
                                class="form-control product-qty"
                                data-product-id="${productId}"
                                type="number"
                                name="product_qty[${productId}]"
                                id="qty_${productId}"
                                value="${oldQuantity}"
                                min="1"
                            >
                            <input
                                type="hidden"
                                class="product-price"
                                data-product-id="${productId}"
                                value="${productPrice}"
                            >
                        </div>
                    `);
                });

                updateTotalPrice();
            }

            function updateTotalPrice() {
                let totalPrice = 0;
                $('.product-qty').each(function() {
                    let productId = $(this).data('product-id');
                    let quantity = parseFloat($(this).val()) || 0;
                    let price = parseFloat($('.product-price[data-product-id="' + productId + '"]').val()) || 0;
                    totalPrice += quantity * price;
                });
                $('#price').val(totalPrice.toFixed(2));
            }

            $('#products').change(function() {
                updateProductQuantities();
            });

            // Perubahan qty -> update total
            $('#product-quantities').on('input', '.product-qty', function() {
                updateTotalPrice();
            });

            // Inisialisasi saat halaman load
            updateProductQuantities();
        });

        // Ganti label file saat memilih PDF
        document.querySelector('.custom-file-input').addEventListener('change', function(e) {
            var fileName = this.files[0]?.name || '';
            e.target.nextElementSibling.innerText = fileName;
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var clientSelect = document.getElementById('client_id');
            var cabangSelect = document.getElementById('cabang_id');
            var alamatSelect = document.getElementById('alamat_id');

            // Data relasi client -> branch, alamat
            var clients = @json($clients->mapWithKeys(function($client){
                return [
                    $client->id => [
                        'branch' => $client->branch_client,
                        'alamat' => $client->alamat_client
                    ]
                ];
            }));

            var selectedClientId  = "{{ old('client_id', $orderbarang->client_id) }}";
            var selectedCabangId  = "{{ old('cabang_id', $orderbarang->cabang_id) }}";
            var selectedAlamatId  = "{{ old('alamat_id', $orderbarang->alamat_id) }}";

            function syncBranchAndAlamat(clientId) {
                cabangSelect.innerHTML = '<option value="">{{ trans('global.pleaseSelect') }}</option>';
                alamatSelect.innerHTML = '<option value="">{{ trans('global.pleaseSelect') }}</option>';

                var data = clients[clientId];
                if (data) {
                    // Cabang
                    var branchOption = document.createElement('option');
                    branchOption.value = clientId;
                    branchOption.textContent = data.branch ?? 'Unknown';
                    // menandai 'selected' jika cocok
                    if (clientId == selectedCabangId) {
                        branchOption.selected = true;
                    }
                    cabangSelect.appendChild(branchOption);

                    // Alamat
                    var alamatOption = document.createElement('option');
                    alamatOption.value = clientId;
                    alamatOption.textContent = data.alamat ?? 'Unknown';
                    if (clientId == selectedAlamatId) {
                        alamatOption.selected = true;
                    }
                    alamatSelect.appendChild(alamatOption);
                }
            }

            // Inisialisasi
            if (selectedClientId) {
                syncBranchAndAlamat(selectedClientId);
            }

            // Event listener
            clientSelect.addEventListener('change', function() {
                syncBranchAndAlamat(clientSelect.value);
            });
        });
    </script>
@endsection
