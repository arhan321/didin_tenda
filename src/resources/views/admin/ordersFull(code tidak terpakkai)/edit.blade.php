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
                <div class="form-group">
                    <label for="client_id">{{ trans('cruds.order.fields.nama_pemesan') }}</label>
                    <select class="form-control {{ $errors->has('client_id') ? 'is-invalid' : '' }}" name="client_id" id="client_id">
                        <option value="">{{ trans('global.pleaseSelect') }}</option>
                        @foreach($clients as $id => $client)
                            <option value="{{ $id }}" {{ old('client_id', $order->client_id) == $id ? 'selected' : '' }}>{{ $client }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('client_id'))
                        <div class="invalid-feedback">
                            {{ $errors->first('client_id') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.order.fields.nama_pemesan_helper') }}</span>
                </div>

                <div class="form-group">
                    <label for="alamat_id">{{ trans('cruds.order.fields.alamat') }}</label>
                    <select class="form-control {{ $errors->has('alamat_id') ? 'is-invalid' : '' }}" name="alamat_id" id="alamat_id">
                        <option value="">{{ trans('global.pleaseSelect') }}</option>
                        @foreach($clients_address as $id => $client)
                            <option value="{{ $id }}" {{ old('alamat_id', $order->alamat_id) == $id ? 'selected' : '' }}>{{ $client }}</option>
                        @endforeach
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
     
                {{-- <div class="form-group">
                    <label class="required" for="jam_pesan">{{ trans('cruds.order.fields.jam_pesan') }}</label>
                    <input class="form-control {{ $errors->has('jam_pesan') ? 'is-invalid' : '' }}" type="time"
                        name="jam_pesan" id="jam_pesan" value="{{ old('jam_pesan', $order->jam_pesan) }}" required>
                    @if ($errors->has('jam_pesan'))
                        <div class="invalid-feedback">
                            {{ $errors->first('jam_pesan') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.order.fields.jam_pesan_helper') }}</span>
                </div> --}}

                <div class="form-group">
                    <label class="required" for="start">{{ trans('cruds.order.fields.start') }}</label>
                    <input class="form-control {{ $errors->has('start') ? 'is-invalid' : '' }}" type="date"
                        name="start" id="start" value="{{ old('start', $order->start) }}"
                        required>
                    @if ($errors->has('start'))
                        <div class="invalid-feedback">
                            {{ $errors->first('start') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.order.fields.start_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required" for="end">{{ trans('cruds.order.fields.end') }}</label>
                    <input class="form-control {{ $errors->has('end') ? 'is-invalid' : '' }}" type="date"
                        name="end" id="end" value="{{ old('end', $order->end) }}"
                        required>
                    @if ($errors->has('end'))
                        <div class="invalid-feedback">
                            {{ $errors->first('end') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.order.fields.end_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required">{{ trans('cruds.order.fields.status_bayar') }}</label>
                    <select class="form-control {{ $errors->has('status_bayar') ? 'is-invalid' : '' }}" name="status_bayar"
                        id="status_bayar" required>
                        <option value disabled {{ old('status_bayar', $order->status_bayar) === null ? 'selected' : '' }}>
                            {{ trans('global.pleaseSelect') }}</option>
                        @foreach (App\Models\Order::STATUS_SELECT as $key => $label)
                            <option value="{{ $key }}"
                                {{ old('status_bayar', $order->status_bayar) === (string) $key ? 'selected' : '' }}>{{ $label }}
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
                        @foreach (App\Models\Order::STATUS_SEWA_SELECT as $key => $label)
                            <option value="{{ $key }}"
                                {{ old('status_sewa', $order->status_sewa) === (string) $key ? 'selected' : '' }}>{{ $label }}
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

                {{-- @if (isset($order) && $order->bukti_pembayaran)
                    <div class="form-group">
                        <label for="bukti_pembayaran">Bukti Pembayaran yang Diunggah:</label>
                        <a href="{{ Storage::url($order->bukti_pembayaran) }}" target="_blank">Lihat PDF</a>

                        <!-- Tombol Hapus -->
                        <form action="{{ route('admin.orders.deletePdf', $order->id) }}" method="POST"
                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus bukti pembayaran ini?');"
                            style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Hapus Bukti Pembayaran</button>
                        </form>
                    </div>
                @endif --}}
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
    .custom-file-input ~ .custom-file-label::after {
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
        //     Dropzone.options.imageDropzone = {
        //     url: '{{ route('admin.orders.storeMedia') }}',
        //     maxFilesize: 2, // MB
        //     acceptedFiles: '.jpeg,.jpg,.png,.gif',
        //     maxFiles: 1,
        //     addRemoveLinks: true,
        //     headers: {
        //       'X-CSRF-TOKEN': "{{ csrf_token() }}"
        //     },
        //     params: {
        //       size: 2,
        //       width: 4096,
        //       height: 4096
        //     },
        //     success: function (file, response) {
        //       $('form').find('input[name="image"]').remove()
        //       $('form').append('<input type="hidden" name="image" value="' + response.name + '">')
        //     },
        //     removedfile: function (file) {
        //       file.previewElement.remove()
        //       if (file.status !== 'error') {
        //         $('form').find('input[name="image"]').remove()
        //         this.options.maxFiles = this.options.maxFiles + 1
        //       }
        //     },
        //     init: function () {
        // @if (isset($order) && $order->image)
        //       var file = {!! json_encode($order->image) !!}
        //           this.options.addedfile.call(this, file)
        //       this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
        //       file.previewElement.classList.add('dz-complete')
        //       $('form').append('<input type="hidden" name="image" value="' + file.file_name + '">')
        //       this.options.maxFiles = this.options.maxFiles - 1
        // @endif
        //     },
        //     error: function (file, response) {
        //         if ($.type(response) === 'string') {
        //             var message = response //dropzone sends it's own error messages in string
        //         } else {
        //             var message = response.errors.file
        //         }
        //         file.previewElement.classList.add('dz-error')
        //         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
        //         _results = []
        //         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
        //             node = _ref[_i]
        //             _results.push(node.textContent = message)
        //         }

        //         return _results
        //     }
        // }

        $(document).ready(function() {
            const productPrices = @json($productPrices);
            const oldQuantities = @json(old('product_qty', $order->product_details->pluck('qty', 'id')->toArray()));

            function updateProductQuantities() {
                let selectedProducts = $('#products').val();
                let productQuantitiesContainer = $('#product-quantities');
                productQuantitiesContainer.empty();

                selectedProducts.forEach(function(productId, index) {
                    let productLabel = $('#products option[value="' + productId + '"]').text();
                    let productPrice = productPrices[productId];
                    let oldQuantity = oldQuantities[productId] ||
                        1; // Default value to 1 if old quantity not available
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

            updateProductQuantities();
        });


        document.querySelector('.custom-file-input').addEventListener('change', function(e) {
        var fileName = document.getElementById("bukti_pembayaran").files[0].name;
        var nextSibling = e.target.nextElementSibling;
        nextSibling.innerText = fileName;
    });
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

        calculateTotalPrice(); // Initial calculation on page load
    });
</script>
@endsection
