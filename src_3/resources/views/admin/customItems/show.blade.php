@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Detail Custom Item
    </div>

    <div class="card-body">
        <div class="form-group">
            <a class="btn btn-default" href="{{ route('admin.custom-items.index') }}">
                Back to list
            </a>
        </div>

        <table class="table table-bordered table-striped">
            <tbody>
                <tr>
                    <th>ID</th>
                    <td>{{ $customItem->id }}</td>
                </tr>

                <tr>
                    <th>Image</th>
                    <td>
                        @if($customItem->image)
                            <a href="{{ asset('storage/' . $customItem->image) }}" target="_blank">
                                <img src="{{ asset('storage/' . $customItem->image) }}" width="180" style="border-radius: 8px;">
                            </a>
                        @endif
                    </td>
                </tr>

                <tr>
                    <th>Name</th>
                    <td>{{ $customItem->name }}</td>
                </tr>

                <tr>
                    <th>Slug</th>
                    <td>{{ $customItem->slug }}</td>
                </tr>

                <tr>
                    <th>Description</th>
                    <td>{{ $customItem->description }}</td>
                </tr>

                <tr>
                    <th>Price</th>
                    <td>Rp {{ number_format($customItem->price ?? 0, 0, ',', '.') }}</td>
                </tr>

                <tr>
                    <th>Unit</th>
                    <td>{{ $customItem->unit }}</td>
                </tr>

                <tr>
                    <th>Min Quantity</th>
                    <td>{{ $customItem->min_quantity }}</td>
                </tr>

                <tr>
                    <th>Max Quantity</th>
                    <td>{{ $customItem->max_quantity ?? '-' }}</td>
                </tr>

                <tr>
                    <th>Icon</th>
                    <td>
                        @if($customItem->icon)
                            <i class="{{ $customItem->icon }}"></i>
                            {{ $customItem->icon }}
                        @endif
                    </td>
                </tr>

                <tr>
                    <th>Active</th>
                    <td>
                        @if($customItem->is_active)
                            <span class="badge badge-primary">Aktif</span>
                        @else
                            <span class="badge badge-danger">Nonaktif</span>
                        @endif
                    </td>
                </tr>

                <tr>
                    <th>Sort Order</th>
                    <td>{{ $customItem->sort_order }}</td>
                </tr>
            </tbody>
        </table>

        <div class="form-group">
            <a class="btn btn-default" href="{{ route('admin.custom-items.index') }}">
                Back to list
            </a>
        </div>
    </div>
</div>

@endsection