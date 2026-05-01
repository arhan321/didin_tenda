@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Detail Beranda
    </div>

    <div class="card-body">
        <div class="form-group">
            <a class="btn btn-default" href="{{ route('admin.berandas.index') }}">
                Back to list
            </a>
        </div>

        <table class="table table-bordered table-striped">
            <tbody>
                <tr>
                    <th>ID</th>
                    <td>{{ $beranda->id }}</td>
                </tr>

                <tr>
                    <th>Title 1</th>
                    <td>{{ $beranda->title_1 }}</td>
                </tr>

                <tr>
                    <th>Title 2</th>
                    <td>{{ $beranda->title_2 }}</td>
                </tr>

                <tr>
                    <th>Deskripsi</th>
                    <td>{!! nl2br(e($beranda->deskripsi)) !!}</td>
                </tr>

                <tr>
                    <th>Image</th>
                    <td>
                        @if($beranda->image)
                            <a href="{{ asset('storage/' . $beranda->image) }}" target="_blank">
                                <img src="{{ asset('storage/' . $beranda->image) }}" width="220" style="border-radius: 8px;">
                            </a>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="form-group">
            <a class="btn btn-default" href="{{ route('admin.berandas.index') }}">
                Back to list
            </a>
        </div>
    </div>
</div>

@endsection