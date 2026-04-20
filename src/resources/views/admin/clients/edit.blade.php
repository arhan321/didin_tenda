@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.client.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('admin.clients.update', [$client->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="image">{{ trans('cruds.client.fields.image') }}</label>
                <div class="needsclick dropzone {{ $errors->has('image') ? 'is-invalid' : '' }}" id="image-dropzone"></div>
                @if($errors->has('image'))
                    <div class="invalid-feedback">
                        {{ $errors->first('image') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.client.fields.image_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="nama_client">{{ trans('cruds.client.fields.name') }}</label>
                <input class="form-control {{ $errors->has('nama_client') ? 'is-invalid' : '' }}" type="text" name="nama_client" id="nama_client" value="{{ old('nama_client', $client->nama_client) }}">
                @if($errors->has('nama_client'))
                    <div class="invalid-feedback">
                        {{ $errors->first('nama_client') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.client.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="alamat_client">{{ trans('cruds.client.fields.address') }}</label>
                <input class="form-control {{ $errors->has('alamat_client') ? 'is-invalid' : '' }}" type="text" name="alamat_client" id="alamat_client" value="{{ old('alamat_client', $client->alamat_client) }}">
                @if($errors->has('alamat_client'))
                    <div class="invalid-feedback">
                        {{ $errors->first('alamat_client') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.client.fields.address_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="branch_client">{{ trans('cruds.client.fields.cabang') }}</label>
                <input class="form-control {{ $errors->has('branch_client') ? 'is-invalid' : '' }}" type="text" name="branch_client" id="branch_client" value="{{ old('branch_client', $client->branch_client) }}">
                @if($errors->has('branch_client'))
                    <div class="invalid-feedback">
                        {{ $errors->first('branch_client') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.client.fields.cabang_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="nomor_telfon1_client">{{ trans('cruds.client.fields.phone') }}</label>
                <input class="form-control {{ $errors->has('nomor_telfon1_client') ? 'is-invalid' : '' }}" type="text" name="nomor_telfon1_client" id="nomor_telfon1_client" value="{{ old('nomor_telfon1_client', $client->nomor_telfon1_client) }}">
                @if($errors->has('nomor_telfon1_client'))
                    <div class="invalid-feedback">
                        {{ $errors->first('nomor_telfon1_client') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.client.fields.phone_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="nomor_telfon2_client">{{ trans('cruds.client.fields.secondary_phone') }}</label>
                <input class="form-control {{ $errors->has('nomor_telfon2_client') ? 'is-invalid' : '' }}" type="text" name="nomor_telfon2_client" id="nomor_telfon2_client" value="{{ old('nomor_telfon2_client', $client->nomor_telfon2_client) }}">
                @if($errors->has('nomor_telfon2_client'))
                    <div class="invalid-feedback">
                        {{ $errors->first('nomor_telfon2_client') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.client.fields.secondary_phone_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="faximile_client">{{ trans('cruds.client.fields.faximile') }}</label>
                <input class="form-control {{ $errors->has('faximile_client') ? 'is-invalid' : '' }}" type="text" name="faximile_client" id="faximile_client" value="{{ old('faximile_client', $client->faximile_client) }}">
                @if($errors->has('faximile_client'))
                    <div class="invalid-feedback">
                        {{ $errors->first('faximile_client') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.client.fields.faximile_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="email_client">{{ trans('cruds.client.fields.email') }}</label>
                <input class="form-control {{ $errors->has('email_client') ? 'is-invalid' : '' }}" type="email" name="email_client" id="email_client" value="{{ old('email_client', $client->email_client) }}">
                @if($errors->has('email_client'))
                    <div class="invalid-feedback">
                        {{ $errors->first('email_client') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.client.fields.email_helper') }}</span>
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
<script>
    Dropzone.options.imageDropzone = {
        url: '{{ route('admin.clients.storeMedia') }}',
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
@if(isset($client) && $client->image)
            var file = {!! json_encode($client->image) !!};
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
            _ref.forEach(function (node) {
                node.textContent = message;
            });
        }
    }
</script>
@endsection
