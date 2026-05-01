@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Detail Addon
    </div>

    <div class="card-body">
        <div class="form-group">
            <a class="btn btn-default" href="{{ route('admin.addons.index') }}">
                Back to list
            </a>
        </div>

        <table class="table table-bordered table-striped">
            <tbody>
                <tr>
                    <th>ID</th>
                    <td>{{ $addon->id }}</td>
                </tr>

                <tr>
                    <th>Image</th>
                    <td>
                        @if($addon->image)
                            <a href="{{ asset('storage/' . $addon->image) }}" target="_blank">
                                <img src="{{ asset('storage/' . $addon->image) }}" width="180" style="border-radius: 8px;">
                            </a>
                        @endif
                    </td>
                </tr>

                <tr>
                    <th>Name</th>
                    <td>{{ $addon->name }}</td>
                </tr>

                <tr>
                    <th>Slug</th>
                    <td>{{ $addon->slug }}</td>
                </tr>

                <tr>
                    <th>Detail</th>
                    <td>{!! nl2br(e($addon->detail)) !!}</td>
                </tr>

                <tr>
                    <th>Price</th>
                    <td>Rp {{ number_format($addon->price ?? 0, 0, ',', '.') }}</td>
                </tr>

                <tr>
                    <th>Unit</th>
                    <td>{{ $addon->unit }}</td>
                </tr>

                <tr>
                    <th>Quantity Based</th>
                    <td>
                        @if($addon->is_quantity_based)
                            <span class="badge badge-success">Ya</span>
                        @else
                            <span class="badge badge-secondary">Tidak</span>
                        @endif
                    </td>
                </tr>

                <tr>
                    <th>Stock</th>
                    <td>{{ $addon->stock ?? '-' }}</td>
                </tr>

                <tr>
                    <th>Icon</th>
                    <td>
                        @if($addon->icon)
                            <i class="{{ $addon->icon }}"></i>
                            {{ $addon->icon }}
                        @endif
                    </td>
                </tr>

                <tr>
                    <th>Active</th>
                    <td>
                        @if($addon->is_active)
                            <span class="badge badge-primary">Aktif</span>
                        @else
                            <span class="badge badge-danger">Nonaktif</span>
                        @endif
                    </td>
                </tr>

                <tr>
                    <th>Sort Order</th>
                    <td>{{ $addon->sort_order }}</td>
                </tr>
            </tbody>
        </table>

        <div class="form-group">
            <a class="btn btn-default" href="{{ route('admin.addons.index') }}">
                Back to list
            </a>
        </div>
    </div>
</div>

@endsection