@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Tambah Beranda
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('admin.berandas.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="title_1">Title 1</label>
                <input class="form-control {{ $errors->has('title_1') ? 'is-invalid' : '' }}" type="text" name="title_1" id="title_1" value="{{ old('title_1', '') }}">
                @if($errors->has('title_1'))
                    <div class="invalid-feedback">
                        {{ $errors->first('title_1') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="title_2">Title 2</label>
                <input class="form-control {{ $errors->has('title_2') ? 'is-invalid' : '' }}" type="text" name="title_2" id="title_2" value="{{ old('title_2', '') }}">
                @if($errors->has('title_2'))
                    <div class="invalid-feedback">
                        {{ $errors->first('title_2') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <textarea class="form-control {{ $errors->has('deskripsi') ? 'is-invalid' : '' }}" name="deskripsi" id="deskripsi" rows="4">{{ old('deskripsi', '') }}</textarea>
                @if($errors->has('deskripsi'))
                    <div class="invalid-feedback">
                        {{ $errors->first('deskripsi') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="image">Image</label>
                <input class="form-control {{ $errors->has('image') ? 'is-invalid' : '' }}" type="file" name="image" id="image" accept="image/*">
                @if($errors->has('image'))
                    <div class="invalid-feedback d-block">
                        {{ $errors->first('image') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    Save
                </button>

                <a class="btn btn-default" href="{{ route('admin.berandas.index') }}">
                    Back to list
                </a>
            </div>
        </form>
    </div>
</div>

@endsection