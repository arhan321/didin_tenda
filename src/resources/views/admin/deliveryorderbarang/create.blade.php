@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.deliveryorder.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.deliveryorderbarang.store') }}">
                @csrf

                <div class="form-group">
                    <label for="pengantar">{{ trans('cruds.deliveryorder.fields.pengantar') }}</label>
                    <input class="form-control {{ $errors->has('pengantar') ? 'is-invalid' : '' }}" type="text" name="pengantar" id="pengantar" value="{{ old('pengantar', '') }}">
                    @if($errors->has('pengantar'))
                        <div class="invalid-feedback">
                            {{ $errors->first('pengantar') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.deliveryorder.fields.pengantar_helper') }}</span>
                </div>

                <div class="form-group">
                    <label for="tanggal_pengiriman">{{ trans('cruds.deliveryorder.fields.tanggal') }}</label>
                    <input class="form-control {{ $errors->has('tanggal_pengiriman') ? 'is-invalid' : '' }}" type="date"
                        name="tanggal_pengiriman" id="tanggal_pengiriman" value="{{ old('tanggal_pengiriman') }}">
                    @if ($errors->has('tanggal_pengiriman'))
                        <div class="invalid-feedback">
                            {{ $errors->first('tanggal_pengiriman') }}
                        </div>
                    @endif  
                </div>

                <div class="form-group">
                    <label for="client_id">{{ trans('cruds.deliveryorder.fields.nama_pemesan') }}</label>
                    <select class="form-control {{ $errors->has('client_id') ? 'is-invalid' : '' }}" name="client_id" id="client_id">
                        <option value="">{{ trans('global.pleaseSelect') }}</option>
                        @foreach ($clients as $client)
                            <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
                                {{ $client->nama_client }}
                            </option>
                        @endforeach
                    </select>
                    @if ($errors->has('client_id'))
                        <div class="invalid-feedback">
                            {{ $errors->first('client_id') }}
                        </div>
                    @endif
                </div>

                <!-- Dropdown Cabang -->
                <div class="form-group">
                    <label for="cabang_id">{{ trans('cruds.deliveryorder.fields.cabang') }}</label>
                    <select class="form-control {{ $errors->has('cabang_id') ? 'is-invalid' : '' }}" name="cabang_id" id="cabang_id">
                        <option value="">{{ trans('global.pleaseSelect') }}</option>
                    </select>
                    @if ($errors->has('cabang_id'))
                        <div class="invalid-feedback">
                            {{ $errors->first('cabang_id') }}
                        </div>
                    @endif
                </div>

                <!-- Dropdown Alamat -->
                <div class="form-group">
                    <label for="alamat_id">{{ trans('cruds.deliveryorder.fields.alamat') }}</label>
                    <select class="form-control {{ $errors->has('alamat_id') ? 'is-invalid' : '' }}" name="alamat_id" id="alamat_id">
                        <option value="">{{ trans('global.pleaseSelect') }}</option>
                    </select>
                    @if ($errors->has('alamat_id'))
                        <div class="invalid-feedback">
                            {{ $errors->first('alamat_id') }}
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="products">{{ trans('cruds.deliveryorder.fields.product') }}</label>
                    <select class="form-control select2 {{ $errors->has('products') ? 'is-invalid' : '' }}"
                        name="products[]" id="products" multiple>
                        @foreach ($products as $id => $product)
                            <option value="{{ $id }}"
                                {{ in_array($id, old('products', [])) ? 'selected' : '' }}>{{ $product }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('products'))
                        <div class="invalid-feedback">
                            {{ $errors->first('products') }}
                        </div>
                    @endif
                </div>

                <div id="product-quantities">
                    <!-- Placeholder for dynamic product quantities -->
                </div>

                <!-- Status Default to Pending -->
                <div class="form-group">
                    <label for="status">{{ trans('cruds.deliveryorder.fields.status') }}</label>
                    <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status" readonly>
                        <option value="pending" {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="delivered" {{ old('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="canceled" {{ old('status') == 'canceled' ? 'selected' : '' }}>Canceled</option>
                    </select>
                    @if ($errors->has('status'))
                        <div class="invalid-feedback">
                            {{ $errors->first('status') }}
                        </div>
                    @endif
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
    @parent
    <script>
        $(document).ready(function() {
            const productPrices = @json($productPrices); // Harga dari ProductBarang
            const productStock = @json($productStock); // Data stok dari ProductBarang

            function updateProductQuantities() {
                let selectedProducts = $('#products').val();
                let productQuantitiesContainer = $('#product-quantities');
                productQuantitiesContainer.empty();

                selectedProducts.forEach(function(productId) {
                    let productLabel = $('#products option[value="' + productId + '"]').text();
                    let productPrice = productPrices[productId];
                    let stock = productStock[productId]; // Ambil data stok

                    if (stock === undefined || stock <= 0) {
                        // Tampilkan peringatan jika stok tidak tersedia atau kosong
                        productQuantitiesContainer.append(`
                            <div class="form-group">
                                <label for="qty_${productId}">${productLabel} {{ trans('cruds.deliveryorder.fields.qty') }}
                                    <span style="color: red;">(Stock tidak tersedia)</span>
                                </label>
                                <input class="form-control product-qty" type="number" name="product_qty[${productId}]" id="qty_${productId}" disabled placeholder="Stok habis">
                                <input type="hidden" class="product-price" data-product-id="${productId}" value="${productPrice}">
                            </div>
                        `);
                    } else {
                        productQuantitiesContainer.append(`
                            <div class="form-group">
                                <label for="qty_${productId}">${productLabel} {{ trans('cruds.deliveryorder.fields.qty') }} (Stock: ${stock})</label>
                                <input class="form-control product-qty" data-product-id="${productId}" type="number" name="product_qty[${productId}]" id="qty_${productId}" value="1" min="1" max="${stock}">
                                <input type="hidden" class="product-price" data-product-id="${productId}" value="${productPrice}">
                            </div>
                        `);
                    }
                });

                updateTotalPrice();
            }

            function updateTotalPrice() {
                let totalPrice = 0;
                $('.product-qty').each(function() {
                    let productId = $(this).data('product-id');
                    let quantity = parseFloat($(this).val()) || 0;
                    let price = parseFloat($('.product-price[data-product-id="' + productId + '"]').val());
                    totalPrice += quantity * price;
                });

                let tax = parseFloat($('#tax').val()) || 0; // Jika ada input tax (default 0)
                let totalWithTax = totalPrice + (totalPrice * (tax / 100)); // Menghitung total dengan pajak

                $('#price').val(totalWithTax.toFixed(2)); // Update field harga jika diperlukan
            }

            $('#products').change(function() {
                updateProductQuantities();
            });

            $('#product-quantities').on('input', '.product-qty', function() {
                updateTotalPrice();
            });

            $('#tax').on('input', function() {
                updateTotalPrice();
            });

            updateProductQuantities();
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var clientSelect = document.getElementById('client_id');
            var cabangSelect = document.getElementById('cabang_id');
            var alamatSelect = document.getElementById('alamat_id');

            // Data relasi cabang dan alamat dari controller, dalam bentuk objek JavaScript
            var clients = @json(
                $clients->mapWithKeys(function ($client) {
                    return [
                        $client->id => [
                            'branch' => $client->branch_client,
                            'alamat' => $client->alamat_client
                        ]
                    ];
                })
            );

            // Ketika client dipilih
            clientSelect.addEventListener('change', function() {
                var clientId = clientSelect.value;

                // Kosongkan dropdown cabang dan alamat sebelum menambahkan data baru
                cabangSelect.innerHTML = '<option value="">{{ trans('global.pleaseSelect') }}</option>';
                alamatSelect.innerHTML = '<option value="">{{ trans('global.pleaseSelect') }}</option>';

                // Jika ada client yang dipilih, sesuaikan cabang dan alamatnya
                if (clientId && clients[clientId]) {
                    // Isi dropdown cabang
                    var cabangOption = document.createElement('option');
                    cabangOption.value = clientId;
                    cabangOption.textContent = clients[clientId]['branch']; // Cabang sesuai client
                    cabangSelect.appendChild(cabangOption);

                    // Isi dropdown alamat
                    var alamatOption = document.createElement('option');
                    alamatOption.value = clientId;
                    alamatOption.textContent = clients[clientId]['alamat']; // Alamat sesuai client
                    alamatSelect.appendChild(alamatOption);
                }
            });
        });
    </script>
@endsection
