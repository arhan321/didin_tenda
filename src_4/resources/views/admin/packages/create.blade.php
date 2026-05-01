@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Tambah Package
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('admin.packages.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="name">Nama Package</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
            </div>

        <div class="form-group">
            <label for="slug">Slug</label>
            <input class="form-control {{ $errors->has('slug') ? 'is-invalid' : '' }}" type="text" name="slug" id="slug" value="{{ old('slug', '') }}" readonly>
            @if($errors->has('slug'))
                <div class="invalid-feedback">
                    {{ $errors->first('slug') }}
                </div>
            @endif
            <span class="help-block">Slug akan otomatis dibuat dari nama package.</span>
        </div>

            <div class="form-group">
                <label for="type">Type</label>
                <select class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" name="type" id="type" required>
                    <option value disabled {{ old('type', null) === null ? 'selected' : '' }}>Pilih Type</option>
                    <option value="fixed" {{ old('type', 'fixed') === 'fixed' ? 'selected' : '' }}>
                        Fixed
                    </option>
                    <option value="custom" {{ old('type') === 'custom' ? 'selected' : '' }}>
                        Custom
                    </option>
                </select>
                @if($errors->has('type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('type') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="short_description">Short Description</label>
                <input class="form-control {{ $errors->has('short_description') ? 'is-invalid' : '' }}" type="text" name="short_description" id="short_description" value="{{ old('short_description', '') }}">
                @if($errors->has('short_description'))
                    <div class="invalid-feedback">
                        {{ $errors->first('short_description') }}
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
                <label for="price">Harga</label>
                <input class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}" type="number" name="price" id="price" value="{{ old('price', 0) }}" min="0">
                @if($errors->has('price'))
                    <div class="invalid-feedback">
                        {{ $errors->first('price') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="price_unit">Price Unit</label>
                <input class="form-control {{ $errors->has('price_unit') ? 'is-invalid' : '' }}" type="text" name="price_unit" id="price_unit" value="{{ old('price_unit', 'paket') }}">
                @if($errors->has('price_unit'))
                    <div class="invalid-feedback">
                        {{ $errors->first('price_unit') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="main_image">Main Image</label>
                <input class="form-control {{ $errors->has('main_image') ? 'is-invalid' : '' }}" type="file" name="main_image" id="main_image" accept="image/*">
                @if($errors->has('main_image'))
                    <div class="invalid-feedback d-block">
                        {{ $errors->first('main_image') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="images">Gallery Images</label>
                <input class="form-control {{ $errors->has('images') ? 'is-invalid' : '' }}" type="file" name="images[]" id="images" accept="image/*" multiple>
                @if($errors->has('images'))
                    <div class="invalid-feedback d-block">
                        {{ $errors->first('images') }}
                    </div>
                @endif
                @if($errors->has('images.*'))
                    <div class="invalid-feedback d-block">
                        {{ $errors->first('images.*') }}
                    </div>
                @endif
            </div>


            <div class="form-group">
                <label for="badge">Badge</label>
                <input class="form-control {{ $errors->has('badge') ? 'is-invalid' : '' }}" type="text" name="badge" id="badge" value="{{ old('badge', '') }}" placeholder="Best Seller / Popular">
                @if($errors->has('badge'))
                    <div class="invalid-feedback">
                        {{ $errors->first('badge') }}
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
                    <input type="checkbox" name="is_popular" id="is_popular" class="form-check-input" value="1" {{ old('is_popular') ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_popular">
                        Popular
                    </label>
                </div>
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
            </div>
        </form>
    </div>
</div>

@endsection
@section('scripts')
@parent
<script>
    function makeSlug(text) {
        return text
            .toString()
            .toLowerCase()
            .trim()
            .replace(/[\s\_]+/g, '-')
            .replace(/[^\w\-]+/g, '')
            .replace(/\-\-+/g, '-')
            .replace(/^-+/, '')
            .replace(/-+$/, '');
    }

    document.addEventListener('DOMContentLoaded', function () {
        const nameInput = document.getElementById('name');
        const slugInput = document.getElementById('slug');

        if (nameInput && slugInput) {
            nameInput.addEventListener('keyup', function () {
                slugInput.value = makeSlug(this.value);
            });

            nameInput.addEventListener('change', function () {
                slugInput.value = makeSlug(this.value);
            });
        }
    });
</script>
@endsection