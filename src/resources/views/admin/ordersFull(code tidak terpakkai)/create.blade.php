@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.order.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.orders.store') }}">
                @csrf
                <div class="form-group">
                    <label for="client_id">{{ trans('cruds.order.fields.nama_pemesan') }}</label>
                    <select class="form-control {{ $errors->has('client_id') ? 'is-invalid' : '' }}" name="client_id"
                        id="client_id">
                        <option value="">{{ trans('global.pleaseSelect') }}</option>
                        @foreach ($clients as $id => $client)
                            <option value="{{ $id }}" {{ old('client_id') == $id ? 'selected' : '' }}>
                                {{ $client }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('client_id'))
                        <div class="invalid-feedback">
                            {{ $errors->first('client_id') }}
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="alamat_id">{{ trans('cruds.order.fields.alamat') }}</label>
                    <select class="form-control {{ $errors->has('alamat_id') ? 'is-invalid' : '' }}" name="alamat_id"
                        id="alamat_id">
                        <option value="">{{ trans('global.pleaseSelect') }}</option>
                        @foreach ($clients_address as $id => $client)
                            <option value="{{ $id }}" {{ old('alamat_id') == $id ? 'selected' : '' }}>
                                {{ $client }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('alamat_id'))
                        <div class="invalid-feedback">
                            {{ $errors->first('alamat_id') }}
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="products">{{ trans('cruds.order.fields.product') }}</label>
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
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- <div class="form-group">
                    <label for="jam_pesan">{{ trans('cruds.order.fields.jam_pesan') }}</label>
                    <input class="form-control {{ $errors->has('jam_pesan') ? 'is-invalid' : '' }}" type="time"
                        name="jam_pesan" id="jam_pesan" value="{{ old('jam_pesan', '') }}">
                    @if ($errors->has('jam_pesan'))
                        <div class="invalid-feedback">
                            {{ $errors->first('jam_pesan') }}
                        </div>
                    @endif
                </div> --}}

                <div class="form-group">
                    <label for="start">{{ trans('cruds.order.fields.start') }}</label>
                    <input class="form-control {{ $errors->has('start') ? 'is-invalid' : '' }}" type="date" name="start" id="start" value="{{ old('start', '') }}">
                    @if ($errors->has('start'))
                        <div class="invalid-feedback">
                            {{ $errors->first('start') }}
                        </div>
                    @endif
                </div>
                
                <div class="form-group">
                    <label for="end">{{ trans('cruds.order.fields.end') }}</label>
                    <input class="form-control {{ $errors->has('end') ? 'is-invalid' : '' }}" type="date" name="end" id="end" value="{{ old('end', '') }}">
                    @if ($errors->has('end'))
                        <div class="invalid-feedback">
                            {{ $errors->first('end') }}
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="price">{{ trans('cruds.order.fields.price') }}</label>
                    <input class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}" type="number"
                        name="price" id="price" value="{{ old('price', '') }}" readonly>
                    @if ($errors->has('price'))
                        <div class="invalid-feedback">
                            {{ $errors->first('price') }}
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label class="required">{{ trans('cruds.order.fields.status_bayar') }}</label>
                    <select class="form-control {{ $errors->has('status_bayar') ? 'is-invalid' : '' }}" name="status_bayar"
                        id="status_bayar" required>
                        <option value disabled {{ old('status_bayar', null) === null ? 'selected' : '' }}>
                            {{ trans('global.pleaseSelect') }}</option>
                        @foreach (App\Models\Order::STATUS_SELECT as $key => $label)
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
                    <span class="help-block">{{ trans('cruds.order.fields.status_bayar_helper') }}</span>
                </div>


                <div class="form-group">
                    <label class="required">{{ trans('cruds.order.fields.status_sewa') }}</label>
                    <select class="form-control {{ $errors->has('status_sewa') ? 'is-invalid' : '' }}" name="status_sewa"
                        id="status_sewa" required>
                        <option value disabled {{ old('status_sewa', null) === null ? 'selected' : '' }}>
                            {{ trans('global.pleaseSelect') }}</option>
                        @foreach (App\Models\Order::STATUS_SEWA_SELECT as $key => $label)
                            <option value="{{ $key }}"
                                {{ old('status_sewa', $defaultStatusSewa) === (string) $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @if ($errors->has('status_sewa'))
                        <div class="invalid-feedback">
                            {{ $errors->first('status_sewa') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.order.fields.status_sewa_helper') }}</span>
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

                @if (isset($order) && $order->bukti_pembayaran)
                    <div class="form-group">
                        <label for="bukti_pembayaran">Bukti Pembayaran yang Diunggah:</label>
                        <a href="{{ Storage::url($order->bukti_pembayaran) }}" target="_blank">Lihat PDF</a>
                    </div>
                @endif

                {{-- <div class="form-group">
                    <label for="image">{{ trans('cruds.order.fields.bukti_pembayaran_foto') }}</label>
                    <div class="needsclick dropzone {{ $errors->has('image') ? 'is-invalid' : '' }}" id="image-dropzone">
                    </div>
                    @if ($errors->has('image'))
                        <div class="invalid-feedback">
                            {{ $errors->first('image') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.order.fields.bukti_pembayaran_foto_helper') }}</span>
                </div> --}}

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
            const productPrices = @json($productPrices);

            function updateProductQuantities() {
                let selectedProducts = $('#products').val();
                let productQuantitiesContainer = $('#product-quantities');
                productQuantitiesContainer.empty();

                selectedProducts.forEach(function(productId, index) {
                    let productLabel = $('#products option[value="' + productId + '"]').text();
                    let productPrice = productPrices[productId];
                    productQuantitiesContainer.append(`
                    <div class="form-group">
                        <label for="qty_${productId}">${productLabel} {{ trans('cruds.order.fields.qty') }}</label>
                        <input class="form-control product-qty" data-product-id="${productId}" type="number" name="product_qty[${productId}]" id="qty_${productId}" value="1">
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

            updateProductQuantities();
        });

        $(function() {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            @can('orderditempat_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('admin.orders.massDestroy') }}",
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
            function calculateTotalPrice() {
                let start = $('#start').val();
                let end = $('#end').val();
                let totalPrice = 0;

                if (start && end) {
                    let startDate = new Date(start);
                    let endDate = new Date(end);

                    let monthsDiff = (endDate.getFullYear() - startDate.getFullYear()) * 12 + (endDate.getMonth() -
                        startDate.getMonth()) + 1;

                    $('.product-qty').each(function() {
                        let productId = $(this).data('product-id');
                        let quantity = parseFloat($(this).val());
                        let price = parseFloat($('.product-price[data-product-id="' + productId + '"]')
                        .val());

                        totalPrice += quantity * price * monthsDiff;
                    });

                    $('#price').val(totalPrice.toFixed(2));
                }
            }

            $('#start, #end').change(function() {
                calculateTotalPrice();
            });

            $('#product-quantities').on('input', '.product-qty', function() {
                calculateTotalPrice();
            });

            calculateTotalPrice();
        });
    </script>
    <script>
            document.getElementById('start').addEventListener('change', function() {
                var startDate = new Date(this.value);
                var endDate = new Date(startDate);
                endDate.setMonth(startDate.getMonth() + 1);
                var formattedDate = endDate.toISOString().split('T')[0];
                document.getElementById('end').value = formattedDate;
            });
    </script>
@endsection
