@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('cruds.socialmedias.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.socialmedias.update', [$socialmedia->id]) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf

                <div class="form-group">
                    <label for="name">{{ trans('cruds.socialmedias.fields.name') }}</label>
                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text"
                           name="name" id="name" value="{{ old('name', $socialmedia->name) }}">
                    @if ($errors->has('name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.socialmedias.fields.name_helper') }}</span>
                </div>

                <div class="form-group">
                    <label for="icon">{{ trans('cruds.socialmedias.fields.icon') }}</label>
                    <input class="form-control {{ $errors->has('icon') ? 'is-invalid' : '' }}" type="text"
                           name="icon" id="icon" value="{{ old('icon', $socialmedia->icon) }}">
                    @if ($errors->has('icon'))
                        <div class="invalid-feedback">
                            {{ $errors->first('icon') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.socialmedias.fields.icon_helper') }}</span>
                </div>

                <div class="form-group">
                    <label for="link">{{ trans('cruds.socialmedias.fields.link') }}</label>
                    <input class="form-control {{ $errors->has('link') ? 'is-invalid' : '' }}" type="text"
                           name="link" id="link" value="{{ old('link', $socialmedia->link) }}">
                    @if ($errors->has('link'))
                        <div class="invalid-feedback">
                            {{ $errors->first('link') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.socialmedias.fields.link_helper') }}</span>
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
            @if(isset($socialmedia) && $socialmedia->image)
                var file = {!! json_encode($socialmedia->image) !!};
                this.options.addedfile.call(this, file);
                this.options.thumbnail.call(this, file, file.preview ?? file.preview_url);
                file.previewElement.classList.add('dz-complete');
                $('form').append('<input type="hidden" name="image" value="' + file.file_name + '">');
                this.options.maxFiles = this.options.maxFiles - 1;
            @endif
        },
        error: function (file, response) {
            let message;
            if ($.type(response) === 'string') {
                message = response; // dropzone sends its own error messages in string
            } else {
                message = response.errors.file;
            }
            file.previewElement.classList.add('dz-error');
            let _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]');
            for (let i = 0; i < _ref.length; i++) {
                let node = _ref[i];
                node.textContent = message;
            }
        }
    }
</script>
@endsection
