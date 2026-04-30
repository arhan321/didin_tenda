@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Tambah Package Item
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('admin.package-items.store') }}">
            @csrf

            <div class="form-group">
                <label for="package_id">Package</label>
                <select class="form-control {{ $errors->has('package_id') ? 'is-invalid' : '' }}" name="package_id" id="package_id" required>
                    <option value disabled {{ old('package_id', $selectedPackageId) === null ? 'selected' : '' }}>
                        Pilih Package
                    </option>

                    @foreach($packages as $package)
                        <option value="{{ $package->id }}" {{ old('package_id', $selectedPackageId) == $package->id ? 'selected' : '' }}>
                            {{ $package->name }}
                        </option>
                    @endforeach
                </select>

                @if($errors->has('package_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('package_id') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="name">Nama Item</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>

                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="quantity">Quantity</label>
                <input class="form-control {{ $errors->has('quantity') ? 'is-invalid' : '' }}" type="number" name="quantity" id="quantity" value="{{ old('quantity', '') }}" min="0">

                @if($errors->has('quantity'))
                    <div class="invalid-feedback">
                        {{ $errors->first('quantity') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="unit">Unit</label>
                <input class="form-control {{ $errors->has('unit') ? 'is-invalid' : '' }}" type="text" name="unit" id="unit" value="{{ old('unit', '') }}" placeholder="pcs / set / titik / meter">

                @if($errors->has('unit'))
                    <div class="invalid-feedback">
                        {{ $errors->first('unit') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description" rows="5">{{ old('description', '') }}</textarea>

                @if($errors->has('description'))
                    <div class="invalid-feedback">
                        {{ $errors->first('description') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="sort_order">Sort Order</label>
                <input class="form-control {{ $errors->has('sort_order') ? 'is-invalid' : '' }}" type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', 0) }}" min="0">

                @if($errors->has('sort_order'))
                    <div class="invalid-feedback">
                        {{ $errors->first('sort_order') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <div class="form-check">
                    <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" {{ old('is_active', 1) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">
                        Active
                    </label>
                </div>
            </div>

            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    Save
                </button>

                <a class="btn btn-default" href="{{ route('admin.package-items.index') }}">
                    Back to list
                </a>
            </div>
        </form>
    </div>
</div>

@endsection