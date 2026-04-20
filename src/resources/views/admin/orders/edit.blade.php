@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('cruds.order.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.orders.update', [$order->id]) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <!-- Dropdown Client -->
                <div class="form-group">
                    <label for="client_id">{{ trans('cruds.order.fields.nama_pemesan') }}</label>
                    <select class="form-control {{ $errors->has('client_id') ? 'is-invalid' : '' }}" name="client_id"
                        id="client_id">
                        <option value="">{{ trans('global.pleaseSelect') }}</option>
                        @foreach ($clients as $client)
                            <option value="{{ $client->id }}"
                                {{ old('client_id', $order->client_id) == $client->id ? 'selected' : '' }}>
                                {{ $client->nama_client }}
                            </option>
                        @endforeach
                    </select>
                    @if ($errors->has('client_id'))
                        <div class="invalid-feedback">
                            {{ $errors->first('client_id') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.order.fields.nama_pemesan_helper') }}</span>
                </div>

            <!-- Dropdown Branch -->
            <div class="form-group">
                <label for="branch_id">{{ trans('cruds.order.fields.cabang') }}</label>
                <select class="form-control {{ $errors->has('branch_id') ? 'is-invalid' : '' }}" name="branch_id"
                    id="branch_id" {{ old('client_id', $order->client_id) ? '' : 'disabled' }}>
                    <!-- Branches will be populated by JS without a "Please select" option -->
                </select>
                @if ($errors->has('branch_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('branch_id') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.order.fields.cabang_helper') }}</span>
            </div>

            <!-- Dropdown Alamat -->
            <div class="form-group">
                <label for="alamat_id">{{ trans('cruds.order.fields.alamat') }}</label>
                <select class="form-control {{ $errors->has('alamat_id') ? 'is-invalid' : '' }}" name="alamat_id"
                    id="alamat_id" {{ old('client_id', $order->client_id) ? '' : 'disabled' }}>
                    <!-- Alamat will be populated by JS without a "Please select" option -->
                </select>
                @if ($errors->has('alamat_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('alamat_id') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.order.fields.alamat_helper') }}</span>
            </div>

                <div class="form-group">
                    <label class="required" for="products">{{ trans('cruds.order.fields.product') }}</label>
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
                                {{ in_array($product->id, old('products', [])) ||collect($order->product_details ?? [])->pluck('id')->contains($product->id)? 'selected': '' }}>
                                {{ $product->name }}
                            </option>
                        @endforeach
                    </select>
                    @if ($errors->has('products'))
                        <div class="invalid-feedback">
                            {{ $errors->first('products') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.order.fields.product_helper') }}</span>
                </div>

                <!-- Dynamic Quantity Inputs -->
                <div id="product-quantities">
                    <!-- Placeholder for dynamic product quantities -->
                </div>

                <div class="form-group">
                    <label for="price">{{ trans('cruds.order.fields.price') }}</label>
                    <input class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}" type="number"
                        name="price" id="price" value="{{ old('price', $order->price) }}" step="0.01">
                    @if ($errors->has('price'))
                        <div class="invalid-feedback">
                            {{ $errors->first('price') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.order.fields.price_helper') }}</span>
                </div>


                <div class="form-group">
                    <label class="required" for="start">{{ trans('cruds.order.fields.start') }}</label>
                    <input class="form-control {{ $errors->has('start') ? 'is-invalid' : '' }}" type="date"
                        name="start" id="start" value="{{ old('start', $order->start) }}" required>
                    @if ($errors->has('start'))
                        <div class="invalid-feedback">
                            {{ $errors->first('start') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.order.fields.start_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required">{{ trans('cruds.order.fields.status_bayar') }}</label>
                    <select class="form-control {{ $errors->has('status_bayar') ? 'is-invalid' : '' }}" name="status_bayar"
                        id="status_bayar" required>
                        <option value disabled {{ old('status_bayar', $order->status_bayar) === null ? 'selected' : '' }}>
                            {{ trans('global.pleaseSelect') }}</option>
                        @foreach (App\Models\Order::STATUS_SELECT as $key => $label)
                            <option value="{{ $key }}"
                                {{ old('status_bayar', $order->status_bayar) === (string) $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @if ($errors->has('status_bayar'))
                        <div class="invalid-feedback">
                            {{ $errors->first('status_bayar') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.order.fields.status_bayar_helper') }}</span>
                </div>

                <div class="form-group">
                    <label for="bukti_pembayaran" class="font-weight-bold">
                        <i class="fas fa-upload"></i> Upload Bukti Pembayaran (PDF)
                    </label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" name="bukti_pembayaran" id="bukti_pembayaran"
                            accept=".pdf">
                        <label class="custom-file-label" for="bukti_pembayaran">Pilih file PDF...</label>
                    </div>
                </div>

                <div class="form-group">
                    <label class="required">{{ trans('cruds.order.fields.status_sewa') }}</label>
                    <select class="form-control {{ $errors->has('status_sewa') ? 'is-invalid' : '' }}" name="status_sewa"
                        id="status_sewa" required>
                        <option value disabled {{ old('status_sewa', $order->status_sewa) === null ? 'selected' : '' }}>
                            {{ trans('global.pleaseSelect') }}</option>
                        <option value="Belum Selesai"
                            {{ old('status_sewa', $order->status_sewa) === 'Belum Selesai' ? 'selected' : '' }}>Belum
                            Selesai</option>
                        <option value="Sudah Selesai"
                            {{ old('status_sewa', $order->status_sewa) === 'Sudah Selesai' ? 'selected' : '' }}>Sudah
                            Selesai</option>
                    </select>
                    @if ($errors->has('status_sewa'))
                        <div class="invalid-feedback">
                            {{ $errors->first('status_sewa') }}
                        </div>
                    @endif
                    @if (session('status_warning'))
                        <div class="alert alert-warning">
                            {{ session('status_warning') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.order.fields.status_sewa_helper') }}</span>
                </div>

                @if (isset($order) && $order->bukti_pembayaran)
                    <div class="form-group">
                        <label for="bukti_pembayaran" class="font-weight-bold">
                            <i class="fas fa-file-pdf text-danger"></i> Bukti Pembayaran yang Diunggah:
                        </label>
                        <div class="d-flex align-items-center mt-2">
                            <a href="{{ Storage::url($order->bukti_pembayaran) }}" target="_blank"
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
            const productPrices = @json($productPrices); // Prices from Product model
            const oldQuantities = @json(old('product_qty', $order->product_details->pluck('qty', 'id')->toArray())); // Get previous quantities

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
                    <label for="qty_${productId}">${productLabel} {{ trans('cruds.order.fields.qty') }}</label>
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
            var fileName = document.getElementById("bukti_pembayaran").files[0].name;
            var nextSibling = e.target.nextElementSibling;
            nextSibling.innerText = fileName;
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tanggal end dari order, pastikan value diambil dari variabel $order->end
            var endDate = "{{ $order->end }}";

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

        var clients = @json($clients);
        var selectedClientId = "{{ old('client_id', $order->client_id) }}";
        var selectedBranchId = "{{ old('branch_id', $order->branch_id) }}";
        var selectedAlamatId = "{{ old('alamat_id', $order->alamat_id) }}";

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
