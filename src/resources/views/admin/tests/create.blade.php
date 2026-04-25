@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} Test
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('admin.tests.store') }}">
            @csrf

            <div class="form-group">
                <label for="nama">Nama</label>
                <input class="form-control {{ $errors->has('nama') ? 'is-invalid' : '' }}"
                       type="text"
                       name="nama"
                       id="nama"
                       value="{{ old('nama', '') }}">

                @if($errors->has('nama'))
                    <div class="invalid-feedback">
                        {{ $errors->first('nama') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="umur">Umur</label>
                <input class="form-control {{ $errors->has('umur') ? 'is-invalid' : '' }}"
                       type="number"
                       name="umur"
                       id="umur"
                       value="{{ old('umur', '') }}">

                @if($errors->has('umur'))
                    <div class="invalid-feedback">
                        {{ $errors->first('umur') }}
                    </div>
                @endif
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