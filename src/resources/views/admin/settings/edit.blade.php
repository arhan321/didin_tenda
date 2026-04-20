@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('cruds.settings.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.settings.update', [$setting->id]) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf

                <div class="form-group">
                    <label for="address">{{ trans('cruds.settings.fields.address') }}</label>
                    <input class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" type="text"
                           name="address" id="address" value="{{ old('address', $setting->address) }}">
                    @if ($errors->has('address'))
                        <div class="invalid-feedback">
                            {{ $errors->first('address') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.settings.fields.address_helper') }}</span>
                </div>

                <div class="form-group">
                    <label for="company_name">{{ trans('cruds.settings.fields.company_name') }}</label>
                    <input class="form-control {{ $errors->has('company_name') ? 'is-invalid' : '' }}" type="text"
                           name="company_name" id="company_name" value="{{ old('company_name', $setting->company_name) }}">
                    @if ($errors->has('company_name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('company_name') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.settings.fields.company_name_helper') }}</span>
                </div>

                <div class="form-group">
                    <label for="phone">{{ trans('cruds.settings.fields.phone') }}</label>
                    <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" type="text"
                           name="phone" id="phone" value="{{ old('phone', $setting->phone) }}">
                    @if ($errors->has('phone'))
                        <div class="invalid-feedback">
                            {{ $errors->first('phone') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.settings.fields.phone_helper') }}</span>
                </div>

                <div class="form-group">
                    <label for="email">{{ trans('cruds.settings.fields.email') }}</label>
                    <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email"
                           name="email" id="email" value="{{ old('email', $setting->email) }}">
                    @if ($errors->has('email'))
                        <div class="invalid-feedback">
                            {{ $errors->first('email') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.settings.fields.email_helper') }}</span>
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
            @if(isset($setting) && $setting->image)
                var file = {!! json_encode($setting->image) !!};
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
