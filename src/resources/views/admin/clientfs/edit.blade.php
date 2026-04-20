@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('cruds.productfs.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.productfs.update', [$productf->id]) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf

                <!-- Nama Produk -->
                <div class="form-group">
                    <label for="title_1">{{ trans('cruds.productfs.fields.title_1') }}</label>
                    <input class="form-control {{ $errors->has('title_1') ? 'is-invalid' : '' }}" type="text"
                        name="title_1" id="title_1" value="{{ old('title_1', $productf->title_1) }}">
                    @if ($errors->has('title_1'))
                        <div class="invalid-feedback">
                            {{ $errors->first('title_1') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.productfs.fields.title_1_helper') }}</span>
                </div>

                <!-- Harga Keterangan Product -->
                <div class="form-group">
                    <label for="title_2">{{ trans('cruds.productfs.fields.title_2') }}</label>
                    <input class="form-control {{ $errors->has('title_2') ? 'is-invalid' : '' }}" type="text"
                        name="title_2" id="title_2" value="{{ old('title_2', $productf->title_2) }}">
                    @if ($errors->has('title_2'))
                        <div class="invalid-feedback">
                            {{ $errors->first('title_2') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.productfs.fields.title_2_helper') }}</span>
                </div>

                <div class="form-group">
                    <label>{{ trans('cruds.productfs.fields.category') }}</label>
                    <select class="form-control {{ $errors->has('category') ? 'is-invalid' : '' }}" name="category" id="category">
                        <option value disabled {{ old('category', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                        <option value="laptop" {{ old('category', $productf->category) === 'laptop' ? 'selected' : '' }}>laptop</option>
                        <option value="komputer" {{ old('category', $productf->category) === 'komputer' ? 'selected' : '' }}>komputer</option>
                        <option value="mesin_fotocopy" {{ old('category', $productf->category) === 'mesin_fotocopy' ? 'selected' : '' }}>mesin_fotocopy</option>
                    </select>
                    @if($errors->has('category'))
                        <div class="invalid-feedback">
                            {{ $errors->first('category') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.productfs.fields.category_helper') }}</span>
                </div>

                <!-- Foto Product -->
                <div class="form-group">
                    <label class="required" for="image">{{ trans('cruds.productfs.fields.image') }}</label>
                    <div class="needsclick dropzone {{ $errors->has('image') ? 'is-invalid' : '' }}" id="image-dropzone">
                    </div>
                    @if($errors->has('image'))
                        <div class="invalid-feedback">
                            {{ $errors->first('image') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.productfs.fields.image_helper') }}</span>
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
@parent
<script>
    Dropzone.options.imageDropzone = {
        url: '{{ route('admin.homes.storeMedia') }}',
        maxFilesize: 2, // MB
        acceptedFiles: '.jpeg,.jpg,.png,.gif',
        maxFiles: 1,
        addRemoveLinks: true,
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        params: {
            size: 2,
            width: 4096,
            height: 4096
        },
        success: function (file, response) {
            $('form').find('input[name="image"]').remove()
            $('form').append('<input type="hidden" name="image" value="' + response.name + '">')
        },
        removedfile: function (file) {
            file.previewElement.remove()
            if (file.status !== 'error') {
                $('form').find('input[name="image"]').remove()
                this.options.maxFiles = this.options.maxFiles + 1
            }
        },
        init: function () {
@if(isset($productf) && $productf->image)
            var file = {!! json_encode($productf->image) !!};
            this.options.addedfile.call(this, file);
            this.options.thumbnail.call(this, file, file.preview ?? file.preview_url);
            file.previewElement.classList.add('dz-complete');
            $('form').append('<input type="hidden" name="image" value="' + file.file_name + '">');
            this.options.maxFiles = this.options.maxFiles - 1;
@endif
        },
        error: function (file, response) {
            if ($.type(response) === 'string') {
                var message = response; // dropzone sends its own error messages in string
            } else {
                var message = response.errors.file;
            }
            file.previewElement.classList.add('dz-error');
            var _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]');
            for (var _i = 0; _i < _ref.length; _i++) {
                var node = _ref[_i];
                node.textContent = message;
            }
        }
    }
</script>
@endsection
