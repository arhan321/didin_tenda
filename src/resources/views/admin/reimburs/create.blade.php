@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.reimburs.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.reimburs.store') }}">
                @csrf
                <div class="form-group">
                    <label for="client_id">{{ trans('cruds.reimburs.fields.nama_client') }}</label>
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
                    <label for="cabang_id">{{ trans('cruds.reimburs.fields.cabang') }}</label>
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
                <label for="alamat_id">{{ trans('cruds.reimburs.fields.alamat') }}</label>
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
                    <label for="jarak_antar">{{ trans('cruds.reimburs.fields.jarak_antar') }}</label>
                    <input class="form-control {{ $errors->has('jarak_antar') ? 'is-invalid' : '' }}" type="string"
                        name="jarak_antar" id="jarak_antar" value="{{ old('jarak_antar', '') }}">
                    @if ($errors->has('jarak_antar'))
                        <div class="invalid-feedback">
                            {{ $errors->first('jarak_antar') }}
                        </div>
                    @endif
                </div>


                <div class="form-group">
                    <label for="products">{{ trans('cruds.reimburs.fields.product') }}</label>
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
                    <label for="tanggal">{{ trans('cruds.reimburs.fields.tanggal') }}</label>
                    <input class="form-control {{ $errors->has('tanggal') ? 'is-invalid' : '' }}" type="date"
                        name="tanggal" id="tanggal" value="{{ old('tanggal', '') }}">
                    @if ($errors->has('tanggal'))
                        <div class="invalid-feedback">
                            {{ $errors->first('tanggal') }}
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="bukti_struk" class="font-weight-bold">
                        <i class="fas fa-upload"></i> Upload Bukti Pembayaran (Gambar atau PDF)
                    </label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" name="bukti_struk" id="bukti_struk"
                            accept=".pdf, .jpg, .jpeg, .png">
                        <label class="custom-file-label" for="bukti_struk">Pilih file...</label>
                    </div>
                    @if ($errors->has('bukti_struk'))
                        <div class="invalid-feedback">
                            {{ $errors->first('bukti_struk') }}
                        </div>
                    @endif
                </div>

                @if (isset($reimburs) && $reimburs->bukti_struk)
                <div class="form-group">
                    <label for="bukti_struk">Bukti Pembayaran yang Diunggah:</label>
                    @if (in_array(pathinfo($reimburs->bukti_struk, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png']))
                        <!-- Menampilkan Gambar -->
                        <img src="{{ url('storage/simpan/' . basename($reimburs->bukti_struk)) }}" alt="Bukti Pembayaran" style="max-width: 100%; height: auto;">
                    @else
                        <!-- Menampilkan PDF -->
                        <a href="{{ url('storage/simpan/' . basename($reimburs->bukti_struk)) }}" target="_blank">Lihat PDF</a>
                    @endif
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
    const monitoringStocks = @json($monitoringStock); // Stocks from Monitoring model

    function updateProductQuantities() {
        let selectedProducts = $('#products').val();
        let productQuantitiesContainer = $('#product-quantities');
        productQuantitiesContainer.empty();

        selectedProducts.forEach(function(productId, index) {
            let productLabel = $('#products option[value="' + productId + '"]').text();
            let productPrice = productPrices[productId];
            let productStock = monitoringStocks[productId]; // Get stock from Monitoring

            // Handle undefined stock
            if (productStock === undefined) {
                productStock = 'Stock tidak tersedia'; // Jika stok undefined, tampilkan pesan default
            }

            // Append form field without enforcing max attribute on qty
            productQuantitiesContainer.append(`
                <div class="form-group">
                    <label for="qty_${productId}">${productLabel} {{ trans('cruds.reimburs.fields.qty') }} (Stock: ${productStock})</label>
                    <input class="form-control product-qty" data-product-id="${productId}" type="number" name="product_qty[${productId}]" id="qty_${productId}" value="1" min="0">
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
            let quantity = parseFloat($(this).val()) || 0; // Default to 0 if the input is empty
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
            @can('orderditempat_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('admin.reimburs.massDestroy') }}",
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
                reimburs: [
                    [1, 'desc']
                ],
                pageLength: 100,
            });
            let table = $('.datatable-reimburs:not(.ajaxTable)').DataTable({
                buttons: dtButtons
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
        })

        document.querySelector('.custom-file-input').addEventListener('change', function(e) {
            var fileName = document.getElementById("bukti_struk").files[0].name;
            var nextSibling = e.target.nextElementSibling;
            nextSibling.innerText = fileName;
        });
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
