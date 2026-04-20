@extends('layouts.admin')
@section('content')

<div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12">
        <a class="btn btn-success" href="{{ route('admin.abouts.index') }}">
            {{ trans('global.back_to_list') }}
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.about.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.abouts.update", [$about->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf

            <!-- Field Title 1 -->
            <div class="form-group">
                <label class="required" for="title_1">{{ trans('cruds.about.fields.title_1') }}</label>
                <input class="form-control {{ $errors->has('title_1') ? 'is-invalid' : '' }}" 
                       type="text" 
                       name="title_1" 
                       id="title_1" 
                       value="{{ old('title_1', $about->title_1) }}" 
                       required>
                @if($errors->has('title_1'))
                    <div class="invalid-feedback">
                        {{ $errors->first('title_1') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.about.fields.title_1_helper') }}</span>
            </div>

            <!-- Field Title 2 -->
            <div class="form-group">
                <label class="required" for="title_2">{{ trans('cruds.about.fields.title_2') }}</label>
                <input class="form-control {{ $errors->has('title_2') ? 'is-invalid' : '' }}" 
                       type="text" 
                       name="title_2" 
                       id="title_2" 
                       value="{{ old('title_2', $about->title_2) }}" 
                       required>
                @if($errors->has('title_2'))
                    <div class="invalid-feedback">
                        {{ $errors->first('title_2') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.about.fields.title_2_helper') }}</span>
            </div>


              <!-- Field Title 2 -->
              <div class="form-group">
                <label class="required" for="title_row">{{ trans('cruds.about.fields.title_row') }}</label>
                <input class="form-control {{ $errors->has('title_row') ? 'is-invalid' : '' }}" 
                       type="text" 
                       name="title_row" 
                       id="title_row" 
                       value="{{ old('title_row', $about->title_row) }}" 
                       required>
                @if($errors->has('title_row'))
                    <div class="invalid-feedback">
                        {{ $errors->first('title_row') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.about.fields.title_row_helper') }}</span>
            </div>

            <!-- Submit Button -->
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
<script>
    $(document).ready(function () {
        function SimpleUploadAdapter(editor) {
            editor.plugins.get('FileRepository').createUploadAdapter = function(loader) {
                return {
                    upload: function() {
                        return loader.file.then(function (file) {
                            return new Promise(function(resolve, reject) {
                                var xhr = new XMLHttpRequest();
                                xhr.open('POST', '{{ route('admin.abouts.storeCKEditorImages') }}', true);
                                xhr.setRequestHeader('x-csrf-token', window._token);
                                xhr.setRequestHeader('Accept', 'application/json');
                                xhr.responseType = 'json';

                                var genericErrorText = `Couldn't upload file: ${ file.name }.`;
                                xhr.addEventListener('error', function() { reject(genericErrorText) });
                                xhr.addEventListener('abort', function() { reject() });
                                xhr.addEventListener('load', function() {
                                    var response = xhr.response;

                                    if (!response || xhr.status !== 201) {
                                        return reject(response && response.message ? `${genericErrorText}\n${xhr.status} ${response.message}` : `${genericErrorText}\n ${xhr.status} ${xhr.statusText}`);
                                    }

                                    $('form').append('<input type="hidden" name="ck-media[]" value="' + response.id + '">');

                                    resolve({ default: response.url });
                                });

                                if (xhr.upload) {
                                    xhr.upload.addEventListener('progress', function(e) {
                                        if (e.lengthComputable) {
                                            loader.uploadTotal = e.total;
                                            loader.uploaded = e.loaded;
                                        }
                                    });
                                }

                                var data = new FormData();
                                data.append('upload', file);
                                data.append('crud_id', '{{ $about->id ?? 0 }}');
                                xhr.send(data);
                            });
                        })
                    }
                };
            }
        }

        var allEditors = document.querySelectorAll('.ckeditor');
        for (var i = 0; i < allEditors.length; ++i) {
            ClassicEditor.create(
                allEditors[i], {
                    extraPlugins: [SimpleUploadAdapter]
                }
            );
        }
    });
</script>

<script>
    Dropzone.options.imageDropzone = {
        url: '{{ route('admin.abouts.storeMedia') }}',
        maxFilesize: 2, 
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
            $('form').find('input[name="image"]').remove();
            $('form').append('<input type="hidden" name="image" value="' + response.name + '">');
        },
        removedfile: function (file) {
            file.previewElement.remove();
            if (file.status !== 'error') {
                $('form').find('input[name="image"]').remove();
                this.options.maxFiles = this.options.maxFiles + 1;
            }
        },
        init: function () {
@if(isset($about) && $about->image)
            var file = {!! json_encode($about->image) !!};
                this.options.addedfile.call(this, file);
                this.options.thumbnail.call(this, file, file.preview ?? file.preview_url);
                file.previewElement.classList.add('dz-complete');
                $('form').append('<input type="hidden" name="image" value="' + file.file_name + '">');
                this.options.maxFiles = this.options.maxFiles - 1;
@endif
        },
        error: function (file, response) {
            var message = $.type(response) === 'string' ? response : response.errors.file;
            file.previewElement.classList.add('dz-error');
            var _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]');
            for (var _i = 0, _len = _ref.length; _i < _len; _i++) {
                _ref[_i].textContent = message;
            }
        }
    }
</script>
@endsection
