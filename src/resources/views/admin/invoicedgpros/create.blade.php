@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.invoicedgpro.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.invoicedgpros.store') }}">
                @csrf
                <div class="form-group">
                    <label for="client_id">{{ trans('cruds.invoicedgpro.fields.nama_pemesan') }}</label>
                    <select class="form-control {{ $errors->has('client_id') ? 'is-invalid' : '' }}" name="client_id"
                        id="client_id">
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
                    <label for="cabang_id">{{ trans('cruds.invoicedgpro.fields.cabang') }}</label>
                    <select class="form-control {{ $errors->has('cabang_id') ? 'is-invalid' : '' }}" name="cabang_id"
                        id="cabang_id">
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
                    <label for="alamat_id">{{ trans('cruds.invoicedgpro.fields.alamat') }}</label>
                    <select class="form-control {{ $errors->has('alamat_id') ? 'is-invalid' : '' }}" name="alamat_id"
                        id="alamat_id">
                        <option value="">{{ trans('global.pleaseSelect') }}</option>
                    </select>
                    @if ($errors->has('alamat_id'))
                        <div class="invalid-feedback">
                            {{ $errors->first('alamat_id') }}
                        </div>
                    @endif
                </div>


                <div class="form-group">
                    <label for="products">{{ trans('cruds.invoicedgpro.fields.product') }}</label>
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

                <div class="form-group">
                    <label for="start">{{ trans('cruds.invoicedgpro.fields.start') }}</label>
                    <input class="form-control {{ $errors->has('start') ? 'is-invalid' : '' }}" type="date"
                        name="start" id="start" value="{{ old('start', '') }}">
                    @if ($errors->has('start'))
                        <div class="invalid-feedback">
                            {{ $errors->first('start') }}
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="end">{{ trans('cruds.invoicedgpro.fields.end') }}</label>
                    <input class="form-control {{ $errors->has('end') ? 'is-invalid' : '' }}" type="date" name="end"
                        id="end" value="{{ old('end', '') }}">
                    @if ($errors->has('end'))
                        <div class="invalid-feedback">
                            {{ $errors->first('end') }}
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="tax">{{ trans('cruds.invoicedgpro.fields.tax') }}</label>
                    <input class="form-control {{ $errors->has('tax') ? 'is-invalid' : '' }}" type="number" step="0.01"
                        name="tax" id="tax" value="{{ old('tax', '') }}">
                    @if ($errors->has('tax'))
                        <div class="invalid-feedback">
                            {{ $errors->first('tax') }}
                        </div>
                    @endif
                </div>


                <div class="form-group">
                    <label for="price">{{ trans('cruds.invoicedgpro.fields.total_price') }}</label>
                    <input class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}" type="number"
                        name="price" id="price" value="{{ old('price', 0) }}" readonly>
                    @if ($errors->has('price'))
                        <div class="invalid-feedback">
                            {{ $errors->first('price') }}
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label class="required">{{ trans('cruds.invoicedgpro.fields.status_bayar') }}</label>
                    <select class="form-control {{ $errors->has('status_bayar') ? 'is-invalid' : '' }}" name="status_bayar"
                        id="status_bayar" required>
                        <option value disabled {{ old('status_bayar', null) === null ? 'selected' : '' }}>
                            {{ trans('global.pleaseSelect') }}</option>
                        @foreach ($statusBayarOptions as $key => $label)
                            <option value="{{ $key }}"
                                {{ old('status_bayar', $defaultStatusBayar) === (string) $key ? 'selected' : '' }}>
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

                <div class="form-group">
                    <label class="font-weight-bold">Metode Pembayaran</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="metode_pembayaran" id="metode_upload"
                            value="upload" checked>
                        <label class="form-check-label" for="metode_upload">
                            Upload Bukti Pembayaran
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="metode_pembayaran" id="metode_cash"
                            value="cash">
                        <label class="form-check-label" for="metode_cash">
                            Cash
                        </label>
                    </div>
                </div>

                <!-- Form untuk upload bukti pembayaran -->
                <div class="form-group" id="upload_bukti_pembayaran">
                    <label for="bukti_pembayaran_file" class="font-weight-bold">
                        <i class="fas fa-upload"></i> Upload Bukti Pembayaran (PDF)
                    </label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" name="bukti_pembayaran_file"
                            id="bukti_pembayaran_file" accept=".pdf">
                        <label class="custom-file-label" id="fileLabel" for="bukti_pembayaran_file">Pilih file
                            PDF...</label>
                    </div>
                </div>

                <!-- Hidden field untuk bukti_pembayaran -->
                <input type="hidden" name="bukti_pembayaran" id="bukti_pembayaran" value="">

                <!-- Tulisan jika pembayaran cash -->
                <div class="form-group" id="cash_info" style="display: none;">
                    <label class="font-weight-bold">Pembayaran:</label>
                    <p><strong>CASH</strong></p>
                </div>

                @if (isset($order) && $order->bukti_pembayaran)
                    <div class="form-group">
                        <label for="bukti_pembayaran">Bukti Pembayaran yang Diunggah:</label>
                        <a href="{{ Storage::url($order->bukti_pembayaran) }}" target="_blank">Lihat PDF</a>
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
    @parent
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const metodeUpload = document.getElementById('metode_upload');
            const metodeCash = document.getElementById('metode_cash');
            const uploadBuktiPembayaran = document.getElementById('upload_bukti_pembayaran');
            const cashInfo = document.getElementById('cash_info');
            const buktiPembayaranField = document.getElementById('bukti_pembayaran');
            const buktiPembayaranFile = document.getElementById('bukti_pembayaran_file');

            // Function to toggle visibility and set bukti_pembayaran field value
            function togglePaymentMethod() {
                if (metodeUpload.checked) {
                    uploadBuktiPembayaran.style.display = 'block';
                    cashInfo.style.display = 'none';
                    buktiPembayaranField.value = ''; // Kosongkan field jika pilih upload
                } else if (metodeCash.checked) {
                    uploadBuktiPembayaran.style.display = 'none';
                    cashInfo.style.display = 'block';
                    buktiPembayaranField.value = 'CASH'; // Set nilai "CASH" jika cash dipilih
                }
            }

            // Add event listeners to payment method radios
            metodeUpload.addEventListener('change', togglePaymentMethod);
            metodeCash.addEventListener('change', togglePaymentMethod);

            // Initialize on page load
            togglePaymentMethod();
        });

        document.addEventListener('DOMContentLoaded', function() {
            var fileInput = document.getElementById('bukti_pembayaran_file');
            var fileLabel = document.getElementById('fileLabel');

            // Update label ketika file dipilih
            fileInput.addEventListener('change', function(event) {
                var fileName = event.target.files[0]?.name || 'Pilih file PDF...'; // Nama file yang dipilih
                fileLabel.textContent = fileName; // Tampilkan nama file di dalam label
            });
        });
    </script>


    <script>
        $(document).ready(function() {
        const productPrices = @json($productPrices); // Prices from Productech model
        const productStocks = @json($productStocks); // Stocks from Productech model

        function updateProductQuantities() {
            let selectedProducts = $('#products').val();
            let productQuantitiesContainer = $('#product-quantities');
            productQuantitiesContainer.empty();

            selectedProducts.forEach(function(productId, index) {
                let productLabel = $('#products option[value="' + productId + '"]').text();
                let productPrice = productPrices[productId];
                let productStock = productStocks[productId]; // Get stock from Productech

                productQuantitiesContainer.append(`
                    <div class="form-group">
                        <label for="qty_${productId}">${productLabel} {{ trans('cruds.order.fields.qty') }}</label>
                        <input class="form-control product-qty" data-product-id="${productId}" type="number" name="product_qty[${productId}]" id="qty_${productId}" value="1" min="1">
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

            let tax = parseFloat($('#tax').val()) || 0; // Get the tax value, default to 0 if empty
            let totalWithTax = totalPrice + (totalPrice * (tax / 100)); // Calculate price with tax

            $('#price').val(totalWithTax.toFixed(2)); // Update the price input field with the new value
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

        $(function() {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            @can('sahabatechinvoice_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('admin.invoicedgpros.massDestroy') }}",
                    className: 'btn-danger',
                    action: function(e, dt, node, config) {
                        var ids = $.map(dt.rows({
                            selected: true
                        }).nodes(), function(entry) {
                            return $(entry).data('entry-id')
                        });

                        if (ids.length === 0) {
                            alert('{{ trans('global.datatables.zero_selected') }}')

                            return
                        }

                        if (confirm('{{ trans('global.areYouSure') }}')) {
                            $.ajax({
                                    headers: {
                                        'x-csrf-token': _token
                                    },
                                    method: 'POST',
                                    url: config.url,
                                    data: {
                                        ids: ids,
                                        _method: 'DELETE'
                                    }
                                })
                                .done(function() {
                                    location.reload()
                                })
                        }
                    }
                }
                dtButtons.push(deleteButton)
            @endcan

            $.extend(true, $.fn.dataTable.defaults, {
                orderCellsTop: true,
                order: [
                    [1, 'desc']
                ],
                pageLength: 100,
            });
            let table = $('.datatable-order:not(.ajaxTable)').DataTable({
                buttons: dtButtons
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
        })
    </script>

    <script>
        $(document).ready(function() {
            // Function to add 1 month to the start date and update end date
            function updateEndDate() {
                let start = $('#start').val();
                if (start) {
                    let startDate = new Date(start);
                    let endDate = new Date(startDate.setMonth(startDate.getMonth() + 1)); // Add 1 month
                    let formattedEndDate = endDate.toISOString().split('T')[0]; // Format to YYYY-MM-DD
                    $('#end').val(formattedEndDate);
                }
            }

            // Function to calculate the total price
            function calculateTotalPrice() {
                let totalPrice = 0;

                $('.product-qty').each(function() {
                    let productId = $(this).data('product-id');
                    let quantity = parseFloat($(this).val());
                    let price = parseFloat($('.product-price[data-product-id="' + productId + '"]').val());

                    // No need to multiply by monthsDiff since we are fixing the period to 1 month
                    totalPrice += quantity * price;
                });

                let tax = parseFloat($('#tax').val()) || 0; // Get the tax value, default to 0 if empty
                let totalWithTax = totalPrice + (totalPrice * (tax / 100)); // Calculate price with tax

                $('#price').val(totalWithTax.toFixed(2)); // Update the price input field with the new value
            }

            // Update the end date automatically when the start date changes
            $('#start').change(function() {
                updateEndDate();
                calculateTotalPrice();
            });

            // Recalculate price if product quantity changes
            $('#product-quantities').on('input', '.product-qty', function() {
                calculateTotalPrice();
            });

            // Recalculate price when tax changes
            $('#tax').on('input', function() {
                calculateTotalPrice();
            });

            // Initial calculation on page load
            updateEndDate(); // Ensure end date is set on load
            calculateTotalPrice(); // Calculate price on load
        });
    </script>
    {{-- <script>
        document.getElementById('start').addEventListener('change', function() {
            var startDate = new Date(this.value);
            var endDate = new Date(startDate);

            // Tambah satu bulan ke tanggal start
            endDate.setMonth(startDate.getMonth() + 1);

            // Format tanggal menjadi YYYY-MM-DD
            var formattedDate = endDate.toISOString().split('T')[0];

            // Set nilai field end menjadi satu bulan setelah start
            document.getElementById('end').value = formattedDate;
        });
    </script> --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var clientSelect = document.getElementById('client_id');
            var cabangSelect = document.getElementById('cabang_id');
            var alamatSelect = document.getElementById('alamat_id');
    
            // Data relasi cabang dan alamat dari controller, dalam bentuk objek JavaScript
            var clients = @json($clients->mapWithKeys(function ($client) {
                return [
                    $client->id => [
                        'branch' => $client->branch_client,
                        'alamat' => $client->alamat_client,
                    ]
                ];
            })->toArray());
    
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
