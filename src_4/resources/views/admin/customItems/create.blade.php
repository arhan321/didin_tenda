@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Tambah Custom Item
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('admin.custom-items.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="name">Nama Custom Item</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                @endif
            </div>

            <div class="form-group">
                <label for="slug">Slug</label>
                <input class="form-control {{ $errors->has('slug') ? 'is-invalid' : '' }}" type="text" name="slug" id="slug" value="{{ old('slug', '') }}" readonly>
                @if($errors->has('slug'))
                    <div class="invalid-feedback">{{ $errors->first('slug') }}</div>
                @endif
                <span class="help-block">Slug akan otomatis dibuat dari nama custom item.</span>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <input class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" type="text" name="description" id="description" value="{{ old('description', '') }}">
                @if($errors->has('description'))
                    <div class="invalid-feedback">{{ $errors->first('description') }}</div>
                @endif
            </div>

            <div class="form-group">
                <label for="price">Harga</label>
                <input class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}" type="number" name="price" id="price" value="{{ old('price', 0) }}" min="0">
                @if($errors->has('price'))
                    <div class="invalid-feedback">{{ $errors->first('price') }}</div>
                @endif
            </div>

            <div class="form-group">
                <label for="unit">Unit</label>
                <input class="form-control {{ $errors->has('unit') ? 'is-invalid' : '' }}" type="text" name="unit" id="unit" value="{{ old('unit', 'pcs') }}" placeholder="pcs / meter / set / titik">
                @if($errors->has('unit'))
                    <div class="invalid-feedback">{{ $errors->first('unit') }}</div>
                @endif
            </div>

            <div class="form-group">
                <label for="min_quantity">Min Quantity</label>
                <input class="form-control {{ $errors->has('min_quantity') ? 'is-invalid' : '' }}" type="number" name="min_quantity" id="min_quantity" value="{{ old('min_quantity', 0) }}" min="0">
                @if($errors->has('min_quantity'))
                    <div class="invalid-feedback">{{ $errors->first('min_quantity') }}</div>
                @endif
            </div>

            <div class="form-group">
                <label for="max_quantity">Max Quantity</label>
                <input class="form-control {{ $errors->has('max_quantity') ? 'is-invalid' : '' }}" type="number" name="max_quantity" id="max_quantity" value="{{ old('max_quantity', '') }}" min="0">
                @if($errors->has('max_quantity'))
                    <div class="invalid-feedback">{{ $errors->first('max_quantity') }}</div>
                @endif
                <span class="help-block">Kosongkan jika tidak ada batas maksimal.</span>
            </div>

            <div class="form-group">
                <label for="image">Image</label>
                <input class="form-control {{ $errors->has('image') ? 'is-invalid' : '' }}" type="file" name="image" id="image" accept="image/*">
                @if($errors->has('image'))
                    <div class="invalid-feedback d-block">{{ $errors->first('image') }}</div>
                @endif
            </div>

            <div class="form-group">
                <label for="icon">Icon</label>
                <input class="form-control {{ $errors->has('icon') ? 'is-invalid' : '' }}" type="text" name="icon" id="icon" value="{{ old('icon', '') }}" placeholder="Contoh: bi bi-plus-circle / fas fa-chair">
                @if($errors->has('icon'))
                    <div class="invalid-feedback">{{ $errors->first('icon') }}</div>
                @endif
                <span class="help-block">Opsional. Isi class icon jika ingin dipakai di frontend.</span>
            </div>

            <div class="form-group">
                <label for="sort_order">Sort Order</label>
                <input class="form-control {{ $errors->has('sort_order') ? 'is-invalid' : '' }}" type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', 0) }}" min="0">
                @if($errors->has('sort_order'))
                    <div class="invalid-feedback">{{ $errors->first('sort_order') }}</div>
                @endif
            </div>

            <div class="form-group">
                <div class="form-check">
                    <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" {{ old('is_active', 1) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">Active</label>
                </div>
            </div>

            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    Save
                </button>

                <a class="btn btn-default" href="{{ route('admin.custom-items.index') }}">
                    Back to list
                </a>
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