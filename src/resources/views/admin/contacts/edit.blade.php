@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('cruds.contacts.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.contacts.update', [$contact->id]) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf

                <div class="form-group">
                    <label for="full_name">{{ trans('cruds.contacts.fields.full_name') }}</label>
                    <input class="form-control {{ $errors->has('full_name') ? 'is-invalid' : '' }}" type="text"
                           full_name="full_name" id="full_name" value="{{ old('full_name', $contact->full_name) }}">
                    @if ($errors->has('full_name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('full_name') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.contacts.fields.full_name_helper') }}</span>
                </div>

                <div class="form-group">
                    <label for="email">{{ trans('cruds.contacts.fields.email') }}</label>
                    <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="text"
                           name="email" id="email" value="{{ old('email', $contact->email) }}">
                    @if ($errors->has('email'))
                        <div class="invalid-feedback">
                            {{ $errors->first('email') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.contacts.fields.email_helper') }}</span>
                </div>

                <div class="form-group">
                    <label for="subject">{{ trans('cruds.contacts.fields.subject') }}</label>
                    <input class="form-control {{ $errors->has('subject') ? 'is-invalid' : '' }}" type="text"
                           name="subject" id="subject" value="{{ old('subject', $contact->subject) }}">
                    @if ($errors->has('subject'))
                        <div class="invalid-feedback">
                            {{ $errors->first('subject') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.contacts.fields.subject_helper') }}</span>
                </div>

                 <div class="form-group">
                    <label for="message">{{ trans('cruds.contacts.fields.message') }}</label>
                    <textarea class="form-control {{ $errors->has('message') ? 'is-invalid' : '' }}"
                        name="message" id="message">{{ old('message', $contact->message) }}</textarea>
                    @if ($errors->has('message'))
                        <div class="invalid-feedback">
                            {{ $errors->first('message') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.contacts.fields.message_helper') }}</span>
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
            @if(isset($contact) && $contact->image)
                var file = {!! json_encode($contact->image) !!};
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
