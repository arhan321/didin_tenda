@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('cruds.reimburs.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.reimburs.update', [$reimbur->id]) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <!-- Dropdown Client -->
                <div class="form-group">
                    <label for="client_id">{{ trans('cruds.reimburs.fields.nama_client') }}</label>
                    <select class="form-control {{ $errors->has('client_id') ? 'is-invalid' : '' }}" name="client_id"
                        id="client_id">
                        <option value="">{{ trans('global.pleaseSelect') }}</option>
                        @foreach ($clients as $client)
                            <option value="{{ $client->id }}"
                                {{ old('client_id', $reimbur->client_id) == $client->id ? 'selected' : '' }}>
                                {{ $client->nama_client }}
                            </option>
                        @endforeach
                    </select>
                    @if ($errors->has('client_id'))
                        <div class="invalid-feedback">
                            {{ $errors->first('client_id') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.reimburs.fields.nama_client_helper') }}</span>
                </div>

            <!-- Dropdown Branch -->
            <div class="form-group">
                <label for="branch_id">{{ trans('cruds.reimburs.fields.cabang') }}</label>
                <select class="form-control {{ $errors->has('branch_id') ? 'is-invalid' : '' }}" name="branch_id"
                    id="branch_id" {{ old('client_id', $reimbur->client_id) ? '' : 'disabled' }}>
                    <!-- Branches will be populated by JS without a "Please select" option -->
                </select>
                @if ($errors->has('branch_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('branch_id') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.reimburs.fields.cabang_helper') }}</span>
            </div>

            <!-- Dropdown Alamat -->
            <div class="form-group">
                <label for="alamat_id">{{ trans('cruds.reimburs.fields.alamat') }}</label>
                <select class="form-control {{ $errors->has('alamat_id') ? 'is-invalid' : '' }}" name="alamat_id"
                    id="alamat_id" {{ old('client_id', $reimbur->client_id) ? '' : 'disabled' }}>
                    <!-- Alamat will be populated by JS without a "Please select" option -->
                </select>
                @if ($errors->has('alamat_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('alamat_id') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.reimburs.fields.alamat_helper') }}</span>
            </div>

            <div class="form-group">
                <label class="required" for="jarak_antar">{{ trans('cruds.reimburs.fields.jarak_antar') }}</label>
                <input class="form-control {{ $errors->has('jarak_antar') ? 'is-invalid' : '' }}" type="string"
                    name="jarak_antar" id="jarak_antar" value="{{ old('jarak_antar', $reimbur->jarak_antar) }}" required>
                @if ($errors->has('jarak_antar'))
                    <div class="invalid-feedback">
                        {{ $errors->first('jarak_antar') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.reimburs.fields.jarak_antar_helper') }}</span>
            </div>

                <div class="form-group">
                    <label class="required" for="products">{{ trans('cruds.reimburs.fields.product') }}</label>
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
                                {{ in_array($product->id, old('products', [])) ||collect($reimbur->product_details ?? [])->pluck('id')->contains($product->id)? 'selected': '' }}>
                                {{ $product->name }}
                            </option>
                        @endforeach
                    </select>
                    @if ($errors->has('products'))
                        <div class="invalid-feedback">
                            {{ $errors->first('products') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.reimburs.fields.product_helper') }}</span>
                </div>

                <!-- Dynamic Quantity Inputs -->
                <div id="product-quantities">
                    <!-- Placeholder for dynamic product quantities -->
                </div>

                <div class="form-group">
                    <label class="required" for="tanggal">{{ trans('cruds.reimburs.fields.tanggal') }}</label>
                    <input class="form-control {{ $errors->has('tanggal') ? 'is-invalid' : '' }}" type="date"
                        name="tanggal" id="tanggal" value="{{ old('tanggal', $reimbur->tanggal) }}" required>
                    @if ($errors->has('tanggal'))
                        <div class="invalid-feedback">
                            {{ $errors->first('tanggal') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.reimburs.fields.tanggal_helper') }}</span>
                </div>

                <div class="form-group">
                    <label for="bukti_struk" class="font-weight-bold">
                        <i class="fas fa-upload"></i> Upload Bukti (PDF / Gambar)
                    </label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" name="bukti_struk" id="bukti_struk"
                            accept=".pdf, .jpg, .jpeg, .png">
                        <label class="custom-file-label" for="bukti_struk">Pilih file PDF atau gambar...</label>
                    </div>
                </div>
                
                @if (isset($reimbur) && $reimbur->bukti_struk)
                    <div class="form-group">
                        <label for="bukti_struk" class="font-weight-bold">
                            <i class="fas fa-file-alt text-primary"></i> Bukti yang Diunggah:
                        </label>
                        <div class="d-flex align-items-center mt-2">
                            @php
                                $filePath = Storage::url($reimbur->bukti_struk);
                                $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);
                            @endphp
                            
                            @if (in_array($fileExtension, ['jpg', 'jpeg', 'png']))
                                <img src="{{ $filePath }}" alt="Bukti Gambar" class="img-thumbnail" style="max-width: 150px; max-height: 150px;">
                            @elseif ($fileExtension == 'pdf')
                                <a href="{{ $filePath }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-eye"></i> Lihat File PDF
                                </a>
                            @endif
                        </div>
                        <small class="form-text text-muted mt-1">
                            File yang diunggah dapat berupa gambar (JPG, PNG) atau dokumen PDF.
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
            const productPrices = @json($productPrices); // Prices from Product model
            const oldQuantities = @json(old('product_qty', $reimbur->product_details->pluck('qty', 'id')->toArray())); // Get previous quantities

            function updateProductQuantities() {
                let selectedProducts = $('#products').val();
                let productQuantitiesContainer = $('#product-quantities');
                productQuantitiesContainer.empty();

                selectedProducts.forEach(function(productId, index) {
                    let productLabel = $('#products option[value="' + productId + '"]').text();
                    let productPrice = productPrices[productId];
                    let oldQuantity = oldQuantities[productId] || 1; // Default to 1 if no previous quantity

                    productQuantitiesContainer.append(`
                <div class="form-group">
                    <label for="qty_${productId}">${productLabel} Qty</label>
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

            // Initialize quantities and price when page loads
            updateProductQuantities();
        });

        document.querySelector('.custom-file-input').addEventListener('change', function(e) {
            var fileName = document.getElementById("bukti_struk").files[0].name;
            var nextSibling = e.target.nextElementSibling;
            nextSibling.innerText = fileName;
        });
    </script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var clientSelect = document.getElementById('client_id');
        var branchSelect = document.getElementById('branch_id');
        var alamatSelect = document.getElementById('alamat_id');

        var clients = @json($clients);
        var selectedClientId = "{{ old('client_id', $reimbur->client_id) }}";
        var selectedBranchId = "{{ old('branch_id', $reimbur->branch_id) }}";
        var selectedAlamatId = "{{ old('alamat_id', $reimbur->alamat_id) }}";

        function syncBranchAndAlamat(clientId) {
            branchSelect.innerHTML = '';
            alamatSelect.innerHTML = '';

            var selectedClient = clients.find(function(client) {
                return client.id == clientId;
            });

            if (selectedClient) {
                branchSelect.disabled = false;
                alamatSelect.disabled = false;

                var branchOption = document.createElement('option');
                branchOption.value = selectedClient.id;
                branchOption.textContent = selectedClient.branch_client;
                branchOption.selected = selectedClient.id == selectedBranchId;
                branchSelect.appendChild(branchOption);

                var alamatOption = document.createElement('option');
                alamatOption.value = selectedClient.id;
                alamatOption.textContent = selectedClient.alamat_client;
                alamatOption.selected = selectedClient.id == selectedAlamatId;
                alamatSelect.appendChild(alamatOption);
            } else {
                branchSelect.disabled = true;
                alamatSelect.disabled = true;
            }
        }

        if (selectedClientId) {
            syncBranchAndAlamat(selectedClientId);
        }

        clientSelect.addEventListener('change', function() {
            syncBranchAndAlamat(clientSelect.value);
        });
    });
</script>



@endsection
