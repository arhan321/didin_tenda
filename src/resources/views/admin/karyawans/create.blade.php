@extends('layouts.admin')
@section('content')

@can('karyawan_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.karyawans.index') }}">
                {{ trans('global.back_to_list') }}
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.karyawan.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('admin.karyawans.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="image">{{ trans('cruds.karyawan.fields.image_karyawan') }}</label>
                <div class="needsclick dropzone {{ $errors->has('image') ? 'is-invalid' : '' }}" id="image-dropzone">
                </div>
                @if($errors->has('image'))
                    <div class="invalid-feedback">
                        {{ $errors->first('image') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.karyawan.fields.image_karyawan_helper') }}</span>
            </div>

            <div class="form-group">
                <label for="nama_karyawan">{{ trans('cruds.karyawan.fields.nama_karyawan') }}</label>
                <input class="form-control {{ $errors->has('nama_karyawan') ? 'is-invalid' : '' }}" type="text" name="nama_karyawan" id="nama_karyawan" value="{{ old('nama_karyawan', '') }}">
                @if($errors->has('nama_karyawan'))
                    <div class="invalid-feedback">
                        {{ $errors->first('nama_karyawan') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.karyawan.fields.nama_karyawan_helper') }}</span>
            </div>

            <div class="form-group">
                <label for="alamat">{{ trans('cruds.karyawan.fields.alamat') }}</label>
                <textarea class="form-control {{ $errors->has('alamat') ? 'is-invalid' : '' }}" name="alamat" id="alamat">{{ old('alamat', '') }}</textarea>
                @if($errors->has('alamat'))
                    <div class="invalid-feedback">
                        {{ $errors->first('alamat') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.karyawan.fields.alamat_helper') }}</span>
            </div>

            <div class="form-group">
                <label for="no_telp">{{ trans('cruds.karyawan.fields.no_telp') }}</label>
                <input class="form-control {{ $errors->has('no_telp') ? 'is-invalid' : '' }}" type="text" name="no_telp" id="no_telp" value="{{ old('no_telp', '') }}">
                @if($errors->has('no_telp'))
                    <div class="invalid-feedback">
                        {{ $errors->first('no_telp') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.karyawan.fields.no_telp_helper') }}</span>
            </div>

            <div class="form-group">
                <label for="email">{{ trans('cruds.karyawan.fields.email') }}</label>
                <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email" id="email" value="{{ old('email', '') }}">
                @if($errors->has('email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.karyawan.fields.email_helper') }}</span>
            </div>

            <div class="form-group">
                <label for="jenis_kelamin">{{ trans('cruds.karyawan.fields.jenis_kelamin') }}</label>
                <select class="form-control {{ $errors->has('jenis_kelamin') ? 'is-invalid' : '' }}" name="jenis_kelamin" id="jenis_kelamin">
                    <option value="" disabled selected>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Karyawan::JENIS_KELAMIN as $key => $label)
                        <option value="{{ $key }}" {{ old('jenis_kelamin') == $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('jenis_kelamin'))
                    <div class="invalid-feedback">
                        {{ $errors->first('jenis_kelamin') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.karyawan.fields.jenis_kelamin_helper') }}</span>
            </div>

            <div class="form-group">
                <label for="tanggal_lahir">{{ trans('cruds.karyawan.fields.tanggal_lahir') }}</label>
                <input class="form-control date {{ $errors->has('tanggal_lahir') ? 'is-invalid' : '' }}" type="text" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir', '') }}">
                @if($errors->has('tanggal_lahir'))
                    <div class="invalid-feedback">
                        {{ $errors->first('tanggal_lahir') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.karyawan.fields.tanggal_lahir_helper') }}</span>
            </div>

            <div class="form-group">
                <label for="tempat_lahir">{{ trans('cruds.karyawan.fields.tempat_lahir') }}</label>
                <input class="form-control {{ $errors->has('tempat_lahir') ? 'is-invalid' : '' }}" type="text" name="tempat_lahir" id="tempat_lahir" value="{{ old('tempat_lahir', '') }}">
                @if($errors->has('tempat_lahir'))
                    <div class="invalid-feedback">
                        {{ $errors->first('tempat_lahir') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.karyawan.fields.tempat_lahir_helper') }}</span>
            </div>

            @php
            $positionsJson = $positionsWithSalaries->toJson();
        @endphp
        
        <div class="form-group">
            <label for="position_id">{{ trans('cruds.karyawan.fields.position_id') }}</label>
            <select class="form-control select2 {{ $errors->has('position_id') ? 'is-invalid' : '' }}" name="position_id" id="position_id" onchange="updateTotalGaji()">
                @foreach($positions as $id => $position)
                    <option value="{{ $id }}" {{ old('position_id') == $id ? 'selected' : '' }}>
                        {{ $position }}
                    </option>
                @endforeach
            </select>
            @if($errors->has('position_id'))
                <div class="invalid-feedback">
                    {{ $errors->first('position_id') }}
                </div>
            @endif
        </div>
        
        
        <div class="form-group">
            <label for="gaji">{{ trans('cruds.karyawan.fields.gaji_id') }}</label>
            <input class="form-control {{ $errors->has('gaji') ? 'is-invalid' : '' }}" type="text" name="gaji" id="gaji" value="{{ old('gaji', '') }}" readonly>
            @if($errors->has('gaji'))
                <div class="invalid-feedback">
                    {{ $errors->first('gaji') }}
                </div>
            @endif
        </div>

        <div class="form-group">
            <label for="status">{{ trans('cruds.karyawan.fields.status') }}</label>
            <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status" required>
                <option value="" disabled {{ old('status', null) === null ? 'selected' : '' }}>
                    {{ trans('global.pleaseSelect') }}
                </option>
                @foreach(App\Models\Karyawan::STATUS_SELECT as $key => $label)
                    <option value="{{ $key }}" {{ old('status') == $key ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
            @if($errors->has('status'))
                <div class="invalid-feedback">
                    {{ $errors->first('status') }}
                </div>
            @endif
            <span class="help-block">{{ trans('cruds.karyawan.fields.status_helper') }}</span>
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
        url: '{{ route('admin.karyawans.storeMedia') }}',
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
@if(isset($karyawan) && $karyawan->image)
          var file = {!! json_encode($karyawan->image) !!}
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

// Data dari controller untuk total_gaji berdasarkan id posisi
const positionsWithSalaries = {!! $positionsJson !!};

function updateTotalGaji() {
    const positionId = document.getElementById('position_id').value;

    // Ambil total_gaji berdasarkan id posisi
    const totalGaji = positionsWithSalaries[positionId] || 0;

    // Format angka ke format uang
    const formattedGaji = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(totalGaji);

    // Update field gaji
    document.getElementById('gaji').value = formattedGaji;
}

</script>

@endsection
