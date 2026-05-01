@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Edit Addon
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('admin.addons.update', [$addon->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf

            <div class="form-group">
                <label for="name">Nama Addon</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $addon->name) }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="slug">Slug</label>
                <input class="form-control {{ $errors->has('slug') ? 'is-invalid' : '' }}" type="text" name="slug" id="slug" value="{{ old('slug', $addon->slug) }}" readonly>
                @if($errors->has('slug'))
                    <div class="invalid-feedback">
                        {{ $errors->first('slug') }}
                    </div>
                @endif
                <span class="help-block">Slug akan otomatis mengikuti nama addon.</span>
            </div>

            <div class="form-group">
                <label for="detail">Detail</label>
                <textarea class="form-control {{ $errors->has('detail') ? 'is-invalid' : '' }}" name="detail" id="detail" rows="4">{{ old('detail', $addon->detail) }}</textarea>
                @if($errors->has('detail'))
                    <div class="invalid-feedback">
                        {{ $errors->first('detail') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="price">Harga</label>
                <input class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}" type="number" name="price" id="price" value="{{ old('price', $addon->price) }}" min="0">
                @if($errors->has('price'))
                    <div class="invalid-feedback">
                        {{ $errors->first('price') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="unit">Unit</label>
                <input class="form-control {{ $errors->has('unit') ? 'is-invalid' : '' }}" type="text" name="unit" id="unit" value="{{ old('unit', $addon->unit) }}" placeholder="pcs / meter / set / titik">
                @if($errors->has('unit'))
                    <div class="invalid-feedback">
                        {{ $errors->first('unit') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="stock">Stock</label>
                <input class="form-control {{ $errors->has('stock') ? 'is-invalid' : '' }}" type="number" name="stock" id="stock" value="{{ old('stock', $addon->stock) }}" min="0">
                @if($errors->has('stock'))
                    <div class="invalid-feedback">
                        {{ $errors->first('stock') }}
                    </div>
                @endif
                <span class="help-block">Kosongkan jika tidak ingin memakai batas stock.</span>
            </div>

            <div class="form-group">
                <label for="image">Image</label>

                @if($addon->image)
                    <div class="mb-2">
                        <a href="{{ asset('storage/' . $addon->image) }}" target="_blank">
                            <img src="{{ asset('storage/' . $addon->image) }}" width="150" style="border-radius: 8px;">
                        </a>

                        <div class="form-check mt-2">
                            <input type="checkbox" name="remove_image" id="remove_image" class="form-check-input" value="1">
                            <label class="form-check-label" for="remove_image">
                                Hapus image
                            </label>
                        </div>
                    </div>
                @endif

                <input class="form-control {{ $errors->has('image') ? 'is-invalid' : '' }}" type="file" name="image" id="image" accept="image/*">

                @if($errors->has('image'))
                    <div class="invalid-feedback d-block">
                        {{ $errors->first('image') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="icon">Icon</label>
                <input class="form-control {{ $errors->has('icon') ? 'is-invalid' : '' }}" type="text" name="icon" id="icon" value="{{ old('icon', $addon->icon) }}" placeholder="Contoh: bi bi-plus-circle / fas fa-plus">
                @if($errors->has('icon'))
                    <div class="invalid-feedback">
                        {{ $errors->first('icon') }}
                    </div>
                @endif
                <span class="help-block">Opsional. Isi class icon jika ingin dipakai di frontend.</span>
            </div>

            <div class="form-group">
                <label for="sort_order">Sort Order</label>
                <input class="form-control {{ $errors->has('sort_order') ? 'is-invalid' : '' }}" type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $addon->sort_order) }}" min="0">
                @if($errors->has('sort_order'))
                    <div class="invalid-feedback">
                        {{ $errors->first('sort_order') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <div class="form-check">
                    <input type="checkbox" name="is_quantity_based" id="is_quantity_based" class="form-check-input" value="1" {{ old('is_quantity_based', $addon->is_quantity_based) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_quantity_based">
                        Quantity Based
                    </label>
                </div>
                <span class="help-block">Centang jika addon bisa dipesan berdasarkan jumlah.</span>
            </div>

            <div class="form-group">
                <div class="form-check">
                    <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" {{ old('is_active', $addon->is_active) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">
                        Active
                    </label>
                </div>
            </div>

            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    Save
                </button>

                <a class="btn btn-default" href="{{ route('admin.addons.index') }}">
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