@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Detail Package
    </div>

    <div class="card-body">
        <div class="form-group">
            <a class="btn btn-default" href="{{ route('admin.packages.index') }}">
                Back to list
            </a>
        </div>

        <table class="table table-bordered table-striped">
            <tbody>
                <tr>
                    <th>ID</th>
                    <td>{{ $package->id }}</td>
                </tr>

                <tr>
                    <th>Main Image</th>
                    <td>
                        @if($package->main_image)
                            <a href="{{ asset('storage/' . $package->main_image) }}" target="_blank">
                                <img src="{{ asset('storage/' . $package->main_image) }}" width="180" style="border-radius: 8px;">
                            </a>
                        @endif
                    </td>
                </tr>

                <tr>
                    <th>Gallery Images</th>
                    <td>
                        @if($package->images)
                            <div class="row">
                                @foreach($package->images as $image)
                                    <div class="col-md-2 mb-3">
                                        <a href="{{ asset('storage/' . $image) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $image) }}" width="100%" style="border-radius: 8px;">
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </td>
                </tr>

                <tr>
                    <th>Name</th>
                    <td>{{ $package->name }}</td>
                </tr>

                <tr>
                    <th>Slug</th>
                    <td>{{ $package->slug }}</td>
                </tr>

                <tr>
                    <th>Type</th>
                    <td>{{ ucfirst($package->type) }}</td>
                </tr>

                <tr>
                    <th>Short Description</th>
                    <td>{{ $package->short_description }}</td>
                </tr>

                <tr>
                    <th>Description</th>
                    <td>{!! nl2br(e($package->description)) !!}</td>
                </tr>

                <tr>
                    <th>Price</th>
                    <td>Rp {{ number_format($package->price ?? 0, 0, ',', '.') }}</td>
                </tr>

                <tr>
                    <th>Price Unit</th>
                    <td>{{ $package->price_unit }}</td>
                </tr>

                {{-- <tr>
                    <th>Color</th>
                    <td>{{ $package->color }}</td>
                </tr> --}}

                <tr>
                    <th>Badge</th>
                    <td>
                        @if($package->badge)
                            <span class="badge badge-info">
                                {{ $package->badge }}
                            </span>
                        @endif
                    </td>
                </tr>

                <tr>
                    <th>Popular</th>
                    <td>
                        @if($package->is_popular)
                            <span class="badge badge-success">Ya</span>
                        @else
                            <span class="badge badge-secondary">Tidak</span>
                        @endif
                    </td>
                </tr>

                <tr>
                    <th>Active</th>
                    <td>
                        @if($package->is_active)
                            <span class="badge badge-primary">Aktif</span>
                        @else
                            <span class="badge badge-danger">Nonaktif</span>
                        @endif
                    </td>
                </tr>

                <tr>
                    <th>Sort Order</th>
                    <td>{{ $package->sort_order }}</td>
                </tr>
            </tbody>
        </table>
<div class="card mt-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Package Items</span>

        @can('package_item_create')
            <a class="btn btn-success btn-sm" href="{{ route('admin.package-items.create', ['package_id' => $package->id]) }}">
                Tambah Item
            </a>
        @endcan
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>Nama Item</th>
                        <th>Quantity</th>
                        <th>Unit</th>
                        <th>Description</th>
                        <th>Sort</th>
                        <th>Active</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($package->items as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ $item->unit }}</td>
                            <td>{{ Str::limit($item->description, 80) }}</td>
                            <td>{{ $item->sort_order }}</td>
                            <td>
                                @if($item->is_active)
                                    <span class="badge badge-primary">Aktif</span>
                                @else
                                    <span class="badge badge-danger">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                @can('package_item_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.package-items.show', $item->id) }}">
                                        View
                                    </a>
                                @endcan

                                @can('package_item_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.package-items.edit', $item->id) }}">
                                        Edit
                                    </a>
                                @endcan

                                @can('package_item_delete')
                                    <form action="{{ route('admin.package-items.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin?');" style="display: inline-block;">
                                        @method('DELETE')
                                        @csrf
                                        <input type="submit" class="btn btn-xs btn-danger" value="Delete">
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">
                                Belum ada item untuk package ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @can('package_item_access')
            <a class="btn btn-default btn-sm" href="{{ route('admin.package-items.index', ['package_id' => $package->id]) }}">
                Lihat semua item package ini
            </a>
        @endcan
    </div>
</div>
        <div class="form-group">
            <a class="btn btn-default" href="{{ route('admin.packages.index') }}">
                Back to list
            </a>
        </div>
    </div>
</div>

@endsection