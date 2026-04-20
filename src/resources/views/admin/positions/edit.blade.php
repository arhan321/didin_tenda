@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.position.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.positions.update", [$position->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="nama_posisi">{{ trans('cruds.position.fields.nama_posisi') }}</label>
                <input class="form-control {{ $errors->has('nama_posisi') ? 'is-invalid' : '' }}" type="text" name="nama_posisi" id="nama_posisi" value="{{ old('nama_posisi', $position->nama_posisi) }}">
                @if($errors->has('nama_posisi'))
                    <div class="invalid-feedback">
                        {{ $errors->first('nama_posisi') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.position.fields.nama_posisi_helper') }}</span>
            </div>

            {{-- <div class="form-group">
                <label for="deskripsi_posisi">{{ trans('cruds.position.fields.deskripsi_posisi') }}</label>
                <textarea class="form-control {{ $errors->has('deskripsi_posisi') ? 'is-invalid' : '' }}" name="deskripsi_posisi" id="deskripsi_posisi">{{ old('deskripsi_posisi', $position->deskripsi_posisi) }}</textarea>
                @if($errors->has('deskripsi_posisi'))
                    <div class="invalid-feedback">
                        {{ $errors->first('deskripsi_posisi') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.position.fields.deskripsi_posisi_helper') }}</span>
            </div> --}}

            <div class="form-group">
                <label for="tugas_posisi">{{ trans('cruds.position.fields.tugas_posisi') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('tugas_posisi') ? 'is-invalid' : '' }}" name="tugas_posisi" id="tugas_posisi">{!! old('tugas_posisi', $position->tugas_posisi) !!}</textarea>
                @if($errors->has('tugas_posisi'))
                    <div class="invalid-feedback">
                        {{ $errors->first('tugas_posisi') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.position.fields.tugas_posisi_helper') }}</span>
            </div>

            <div class="form-group">
                <label for="gaji_pokok">{{ trans('cruds.position.fields.gaji_pokok') }}</label>
                <input class="form-control {{ $errors->has('gaji_pokok') ? 'is-invalid' : '' }}" type="number" name="gaji_pokok" id="gaji_pokok" value="{{ old('gaji_pokok', $position->gaji_pokok) }}">
                @if($errors->has('gaji_pokok'))
                    <div class="invalid-feedback">
                        {{ $errors->first('gaji_pokok') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.position.fields.gaji_pokok_helper') }}</span>
            </div>

            <div class="form-group">
                <label for="tunjangan_makan">{{ trans('cruds.position.fields.tunjangan_makan') }}</label>
                <input class="form-control {{ $errors->has('tunjangan_makan') ? 'is-invalid' : '' }}" type="number" name="tunjangan_makan" id="tunjangan_makan" value="{{ old('tunjangan_makan', $position->tunjangan_makan) }}">
                @if($errors->has('tunjangan_makan'))
                    <div class="invalid-feedback">
                        {{ $errors->first('tunjangan_makan') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.position.fields.tunjangan_makan_helper') }}</span>
            </div>

            <div class="form-group">
                <label for="tunjangan_transport">{{ trans('cruds.position.fields.tunjangan_transport') }}</label>
                <input class="form-control {{ $errors->has('tunjangan_transport') ? 'is-invalid' : '' }}" type="number" name="tunjangan_transport" id="tunjangan_transport" value="{{ old('tunjangan_transport', $position->tunjangan_transport) }}">
                @if($errors->has('tunjangan_transport'))
                    <div class="invalid-feedback">
                        {{ $errors->first('tunjangan_transport') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.position.fields.tunjangan_transport_helper') }}</span>
            </div>

            <div class="form-group">
                <label for="tunjangan_kesehatan">{{ trans('cruds.position.fields.tunjangan_kesehatan') }}</label>
                <input class="form-control {{ $errors->has('tunjangan_kesehatan') ? 'is-invalid' : '' }}" type="number" name="tunjangan_kesehatan" id="tunjangan_kesehatan" value="{{ old('tunjangan_kesehatan', $position->tunjangan_kesehatan) }}">
                @if($errors->has('tunjangan_kesehatan'))
                    <div class="invalid-feedback">
                        {{ $errors->first('tunjangan_kesehatan') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.position.fields.tunjangan_kesehatan_helper') }}</span>
            </div>

            <div class="form-group">
                <label for="tunjangan_ketenagakerjaan">{{ trans('cruds.position.fields.tunjangan_ketenagakerjaan') }}</label>
                <input class="form-control {{ $errors->has('tunjangan_ketenagakerjaan') ? 'is-invalid' : '' }}" type="number" name="tunjangan_ketenagakerjaan" id="tunjangan_ketenagakerjaan" value="{{ old('tunjangan_ketenagakerjaan', $position->tunjangan_ketenagakerjaan) }}">
                @if($errors->has('tunjangan_ketenagakerjaan'))
                    <div class="invalid-feedback">
                        {{ $errors->first('tunjangan_ketenagakerjaan') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.position.fields.tunjangan_ketenagakerjaan_helper') }}</span>
            </div>

            <div class="form-group">
                <label for="total_gaji">{{ trans('cruds.position.fields.total_gaji') }}</label>
                <input class="form-control {{ $errors->has('total_gaji') ? 'is-invalid' : '' }}" type="number" name="total_gaji" id="total_gaji" value="{{ old('total_gaji', $position->total_gaji) }}" readonly>
                @if($errors->has('total_gaji'))
                    <div class="invalid-feedback">
                        {{ $errors->first('total_gaji') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.position.fields.total_gaji_helper') }}</span>
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
    $(document).ready(function () {
  function SimpleUploadAdapter(editor) {
    editor.plugins.get('FileRepository').createUploadAdapter = function(loader) {
      return {
        upload: function() {
          return loader.file
            .then(function (file) {
              return new Promise(function(resolve, reject) {
                // Init request
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '{{ route('admin.positions.storeCKEditorImages') }}', true);
                xhr.setRequestHeader('x-csrf-token', window._token);
                xhr.setRequestHeader('Accept', 'application/json');
                xhr.responseType = 'json';

                // Init listeners
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

                // Send request
                var data = new FormData();
                data.append('upload', file);
                data.append('crud_id', '{{ $position->id ?? 0 }}');
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
    // Calculate total salary on input change
    function calculateTotalGaji() {
        let gajiPokok = parseFloat(document.getElementById('gaji_pokok').value) || 0;
        let tunjanganMakan = parseFloat(document.getElementById('tunjangan_makan').value) || 0;
        let tunjanganTransport = parseFloat(document.getElementById('tunjangan_transport').value) || 0;
        let tunjanganKesehatan = parseFloat(document.getElementById('tunjangan_kesehatan').value) || 0;
        let tunjanganKetenagakerjaan = parseFloat(document.getElementById('tunjangan_ketenagakerjaan').value) || 0;

        let totalGaji = gajiPokok + tunjanganMakan + tunjanganTransport + tunjanganKesehatan + tunjanganKetenagakerjaan;
        
        document.getElementById('total_gaji').value = totalGaji;
    }

    document.getElementById('gaji_pokok').addEventListener('input', calculateTotalGaji);
    document.getElementById('tunjangan_makan').addEventListener('input', calculateTotalGaji);
    document.getElementById('tunjangan_transport').addEventListener('input', calculateTotalGaji);
    document.getElementById('tunjangan_kesehatan').addEventListener('input', calculateTotalGaji);
    document.getElementById('tunjangan_ketenagakerjaan').addEventListener('input', calculateTotalGaji);
</script>
@endsection
