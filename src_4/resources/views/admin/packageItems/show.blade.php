@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Detail Package Item
    </div>

    <div class="card-body">
        <div class="form-group">
            <a class="btn btn-default" href="{{ route('admin.package-items.index') }}">
                Back to list
            </a>
        </div>

        <table class="table table-bordered table-striped">
            <tbody>
                <tr>
                    <th>ID</th>
                    <td>{{ $packageItem->id }}</td>
                </tr>

                <tr>
                    <th>Package</th>
                    <td>{{ $packageItem->package->name ?? '' }}</td>
                </tr>

                <tr>
                    <th>Nama Item</th>
                    <td>{{ $packageItem->name }}</td>
                </tr>

                <tr>
                    <th>Quantity</th>
                    <td>{{ $packageItem->quantity }}</td>
                </tr>

                <tr>
                    <th>Unit</th>
                    <td>{{ $packageItem->unit }}</td>
                </tr>

                <tr>
                    <th>Description</th>
                    <td>{!! nl2br(e($packageItem->description)) !!}</td>
                </tr>

                <tr>
                    <th>Sort Order</th>
                    <td>{{ $packageItem->sort_order }}</td>
                </tr>

                <tr>
                    <th>Active</th>
                    <td>
                        @if($packageItem->is_active)
                            <span class="badge badge-primary">Aktif</span>
                        @else
                            <span class="badge badge-danger">Nonaktif</span>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="form-group">
            <a class="btn btn-default" href="{{ route('admin.package-items.index') }}">
                Back to list
            </a>
        </div>
    </div>
</div>

@endsection