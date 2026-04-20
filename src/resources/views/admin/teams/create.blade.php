@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.teams.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.teams.store') }}">
                @csrf

                <!-- name -->
                <div class="form-group">
                    <label for="name">{{ trans('cruds.teams.fields.name') }}</label>
                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text"
                        name="name" id="name" value="{{ old('name', '') }}" >
                    @if ($errors->has('name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.teams.fields.name_helper') }}</span>
                </div>

                    <!-- Kategori Tim -->
                    <div class="form-group">
                        <label>{{ trans('cruds.teams.fields.position') }}</label>
                        <select class="form-control {{ $errors->has('position') ? 'is-invalid' : '' }}" name="position" id="position">
                            <option value disabled selected>{{ trans('global.pleaseSelect') }}</option>
                            <option value="manager" {{ old('position') === 'manager' ? 'selected' : '' }}>Manager</option>
                            <option value="staff" {{ old('position') === 'staff' ? 'selected' : '' }}>Staff</option>
                            <option value="admin" {{ old('position') === 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="direktur" {{ old('position') === 'direktur' ? 'selected' : '' }}>Direktur</option>
                            <option value="cto" {{ old('position') === 'cto' ? 'selected' : '' }}>CTO</option>
                            <option value="owner" {{ old('position') === 'owner' ? 'selected' : '' }}>Owner</option>
                            <option value="it_support" {{ old('position') === 'it_support' ? 'selected' : '' }}>IT Support</option>
                        </select>
                        @if($errors->has('position'))
                            <div class="invalid-feedback">
                                {{ $errors->first('position') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.teams.fields.position_helper') }}</span>
                    </div>
                    


                <!-- position -->
                <div class="form-group">
                    <label for="description">{{ trans('cruds.teams.fields.description') }}</label>
                    <input class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" type="text"
                        name="description" id="description" value="{{ old('description', '') }}" step="0.01">
                    @if ($errors->has('description'))
                        <div class="invalid-feedback">
                            {{ $errors->first('description') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.teams.fields.description_helper') }}</span>
                </div>

                <!-- foto  -->
                <div class="form-group">
                    <label class="required" for="image">{{ trans('cruds.teams.fields.image') }}</label>
                    <div class="needsclick dropzone {{ $errors->has('image') ? 'is-invalid' : '' }}" id="image-dropzone">
                    </div>
                    @if($errors->has('image'))
                        <div class="invalid-feedback">
                            {{ $errors->first('image') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.teams.fields.image_helper') }}</span>
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
@if(isset($teams) && $teams->image)
      var file = {!! json_encode($teams->image) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="image" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
@endif
    },
    error: function (file, response) {
        if ($.type(response) === 'string') {
            var message = response //dropzone sends it's own error messages in string
        } else {
            var message = response.errors.file
        }
        file.previewElement.classList.add('dz-error')
        _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
        _results = []
        for (_i = 0, _len = _ref.length; _i < _len; _i++) {
            node = _ref[_i]
            _results.push(node.textContent = message)
        }

        return _results
    }
}

</script>

@endsection
