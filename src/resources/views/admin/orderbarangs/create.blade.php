@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.orderbarangs.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.orderbarangs.store') }}">
                @csrf
                <div class="form-group">
                    <label for="client_id">{{ trans('cruds.orderbarangs.fields.nama_pemesan') }}</label>
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
                    <label for="cabang_id">{{ trans('cruds.orderbarangs.fields.cabang') }}</label>
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
                <label for="alamat_id">{{ trans('cruds.orderbarangs.fields.alamat') }}</label>
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
                    <label for="products">{{ trans('cruds.orderbarangs.fields.product') }}</label>
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
                    <label for="start_date">{{ trans('cruds.orderbarangs.fields.start_date') }}</label>
                    <input class="form-control {{ $errors->has('start_date') ? 'is-invalid' : '' }}" type="date"
                        name="start_date" id="start_date" value="{{ old('start_date', '') }}">
                    @if ($errors->has('start_date'))
                        <div class="invalid-feedback">
                            {{ $errors->first('start_date') }}
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="jatuh_tempo">{{ trans('cruds.orderbarangs.fields.end') }}</label>
                    <input class="form-control {{ $errors->has('jatuh_tempo') ? 'is-invalid' : '' }}" type="date"
                        name="jatuh_tempo" id="jatuh_tempo" value="{{ old('jatuh_tempo', '') }}">
                    @if ($errors->has('jatuh_tempo'))
                        <div class="invalid-feedback">
                            {{ $errors->first('jatuh_tempo') }}
                        </div>
                    @endif
                </div>


                <div class="form-group">
                    <label for="price">{{ trans('cruds.orderbarangs.fields.price') }}</label>
                    <input class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}" type="number"
                        name="price" id="price" value="{{ old('price', 0) }}" readonly>
                    @if ($errors->has('price'))
                        <div class="invalid-feedback">
                            {{ $errors->first('price') }}
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label class="required">{{ trans('cruds.orderbarangs.fields.status_bayar') }}</label>
                    <select class="form-control {{ $errors->has('status_bayar') ? 'is-invalid' : '' }}" name="status_bayar"
                        id="status_bayar" required>
                        <option value disabled {{ old('status_bayar', null) === null ? 'selected' : '' }}>
                            {{ trans('global.pleaseSelect') }}</option>
                        @foreach (App\Models\OrdersBarang::STATUS_SELECT as $key => $label)
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
                    <span class="help-block">{{ trans('cruds.orderbarangs.fields.status_bayar_helper') }}</span>
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

                @if (isset($orderbarangs) && $orderbarangs->bukti_pembayaran)
                    <div class="form-group">
                        <label for="bukti_pembayaran">Bukti Pembayaran yang Diunggah:</label>
                        <a href="{{ Storage::url($orderbarangs->bukti_pembayaran) }}" target="_blank">Lihat PDF</a>
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
$(document).ready(function() {
    const productPrices = @json($productPrices); // Prices from Product model
    const productStocks = @json($productStocks); // Stok produk

    // Fungsi untuk memperbarui input quantity dan menampilkan stok
    function updateProductQuantities() {
        let selectedProducts = $('#products').val();
        let productQuantitiesContainer = $('#product-quantities');
        productQuantitiesContainer.empty();

        selectedProducts.forEach(function(productId) {
            let productLabel = $('#products option[value="' + productId + '"]').text();
            let productPrice = productPrices[productId];
            let stock = productStocks[productId]; // Ambil stok produk

            // Periksa apakah stok valid
            if (stock === undefined) {
                stock = 'Tidak diketahui'; // Jika stok tidak tersedia
            }

            productQuantitiesContainer.append(`
                <div class="form-group">
                    <label for="qty_${productId}">${productLabel} (Stok: ${stock})</label>
                    <input class="form-control product-qty" data-product-id="${productId}" type="number" name="product_qty[${productId}]" id="qty_${productId}" value="1" min="1" max="${stock}">
                    <div id="qty-error-${productId}" class="text-danger" style="display: none;">Jumlah melebihi stok yang tersedia.</div>
                    <input type="hidden" class="product-price" data-product-id="${productId}" value="${productPrice}">
                </div>
            `);
        });

        updateTotalPrice();
    }

    // Fungsi untuk memperbarui total harga
    function updateTotalPrice() {
        let totalPrice = 0;
        let valid = true;

        $('.product-qty').each(function() {
            let productId = $(this).data('product-id');
            let quantity = parseFloat($(this).val());
            let stock = productStocks[productId]; // Ambil stok produk
            let price = parseFloat($('.product-price[data-product-id="' + productId + '"]').val());

            // Validasi jumlah stok
            if (quantity > stock) {
                $('#qty-error-' + productId).show();
                valid = false;
            } else {
                $('#qty-error-' + productId).hide();
            }

            totalPrice += quantity * price;
        });

        if (valid) {
            $('#price').val(totalPrice.toFixed(2)); // Update the price input field with the new value
        }
    }

    // Event ketika produk dipilih
    $('#products').change(function() {
        updateProductQuantities();
    });

    // Event ketika quantity input diubah
    $('#product-quantities').on('input', '.product-qty', function() {
        updateTotalPrice();
    });

    // Inisialisasi saat pertama kali halaman dimuat
    updateProductQuantities(); // Initialize quantities and price when page loads
});



        $(function() {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            @can('orderditempat_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('admin.orderbarangs.massDestroy') }}",
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
            // function updateEndDate() {
            //     let start = $('#start').val();
            //     if (start) {
            //         let startDate = new Date(start);
            //         let endDate = new Date(startDate.setMonth(startDate.getMonth() + 1)); // Add 1 month
            //         let formattedEndDate = endDate.toISOString().split('T')[0]; // Format to YYYY-MM-DD
            //         $('#end').val(formattedEndDate);
            //     }
            // }

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
            alamatOption.textContent = clients[clientId]['alamat']; // Alamat sesuai cabang
            alamatSelect.appendChild(alamatOption);
        }
    });
});
    </script>
@endsection
