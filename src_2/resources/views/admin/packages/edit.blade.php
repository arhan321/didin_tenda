@extends('layouts.admin')
@section('content')

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="card">
    <div class="card-header">
        Edit Package
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('admin.packages.update', [$package->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf

            <div class="form-group">
                <label for="name">Nama Package</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $package->name) }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="slug">Slug</label>
                <input class="form-control {{ $errors->has('slug') ? 'is-invalid' : '' }}" type="text" name="slug" id="slug" value="{{ old('slug', $package->slug) }}" readonly>
                @if($errors->has('slug'))
                    <div class="invalid-feedback">
                        {{ $errors->first('slug') }}
                    </div>
                @endif
                <span class="help-block">Slug akan otomatis mengikuti nama package.</span>
            </div>

            <div class="form-group">
                <label for="type">Type</label>
                <select class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" name="type" id="type" required>
                    <option value disabled>Pilih Type</option>
                    <option value="fixed" {{ old('type', $package->type) === 'fixed' ? 'selected' : '' }}>
                        Fixed
                    </option>
                    <option value="custom" {{ old('type', $package->type) === 'custom' ? 'selected' : '' }}>
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
                <input class="form-control {{ $errors->has('short_description') ? 'is-invalid' : '' }}" type="text" name="short_description" id="short_description" value="{{ old('short_description', $package->short_description) }}">
                @if($errors->has('short_description'))
                    <div class="invalid-feedback">
                        {{ $errors->first('short_description') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description" rows="5">{{ old('description', $package->description) }}</textarea>
                @if($errors->has('description'))
                    <div class="invalid-feedback">
                        {{ $errors->first('description') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="price">Harga</label>
                <input class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}" type="number" name="price" id="price" value="{{ old('price', $package->price) }}" min="0">
                @if($errors->has('price'))
                    <div class="invalid-feedback">
                        {{ $errors->first('price') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="price_unit">Price Unit</label>
                <input class="form-control {{ $errors->has('price_unit') ? 'is-invalid' : '' }}" type="text" name="price_unit" id="price_unit" value="{{ old('price_unit', $package->price_unit) }}">
                @if($errors->has('price_unit'))
                    <div class="invalid-feedback">
                        {{ $errors->first('price_unit') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="main_image">Main Image</label>

                @if($package->main_image)
                    <div class="mb-2">
                        <a href="{{ asset('storage/' . $package->main_image) }}" target="_blank">
                            <img src="{{ asset('storage/' . $package->main_image) }}" width="150" style="border-radius: 8px;">
                        </a>

                        <div class="form-check mt-2">
                            <input type="checkbox" name="remove_main_image" id="remove_main_image" class="form-check-input" value="1">
                            <label class="form-check-label" for="remove_main_image">
                                Hapus main image
                            </label>
                        </div>
                    </div>
                @endif

                <input class="form-control {{ $errors->has('main_image') ? 'is-invalid' : '' }}" type="file" name="main_image" id="main_image" accept="image/*">
                @if($errors->has('main_image'))
                    <div class="invalid-feedback d-block">
                        {{ $errors->first('main_image') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label>Gallery Images</label>

                @if($package->images && count($package->images))
                    <div class="row mb-3">
                        @foreach($package->images as $image)
                            <div class="col-md-2 mb-3">
                                <div class="gallery-preview-card">
                                    <a href="{{ asset('storage/' . $image) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $image) }}" width="100%" style="border-radius: 8px;">
                                    </a>

                                    <div class="form-check mt-2">
                                        <input type="checkbox" name="remove_images[]" value="{{ $image }}" class="form-check-input" id="remove_image_{{ $loop->index }}">
                                        <label class="form-check-label" for="remove_image_{{ $loop->index }}">
                                            Hapus
                                        </label>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-info">
                        Belum ada gallery image.
                    </div>
                @endif

                <div id="gallery-input-wrapper">
                    <div class="gallery-input-item mb-2">
                        <div class="input-group">
                            <input class="form-control gallery-image-input {{ $errors->has('images') ? 'is-invalid' : '' }}" type="file" name="images[]" accept="image/*">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-danger remove-gallery-input" style="display: none;">
                                    Hapus
                                </button>
                            </div>
                        </div>

                        <small class="text-muted">
                            Pilih gambar, nanti form gallery baru akan muncul otomatis.
                        </small>
                    </div>
                </div>

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

            {{-- <div class="form-group">
                <label for="color">Color</label>
                <input class="form-control {{ $errors->has('color') ? 'is-invalid' : '' }}" type="text" name="color" id="color" value="{{ old('color', $package->color) }}">
                @if($errors->has('color'))
                    <div class="invalid-feedback">
                        {{ $errors->first('color') }}
                    </div>
                @endif
            </div> --}}

            <div class="form-group">
                <label for="badge">Badge</label>
                <input class="form-control {{ $errors->has('badge') ? 'is-invalid' : '' }}" type="text" name="badge" id="badge" value="{{ old('badge', $package->badge) }}">
                @if($errors->has('badge'))
                    <div class="invalid-feedback">
                        {{ $errors->first('badge') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="sort_order">Sort Order</label>
                <input class="form-control {{ $errors->has('sort_order') ? 'is-invalid' : '' }}" type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $package->sort_order) }}" min="0">
                @if($errors->has('sort_order'))
                    <div class="invalid-feedback">
                        {{ $errors->first('sort_order') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <div class="form-check">
                    <input type="checkbox" name="is_popular" id="is_popular" class="form-check-input" value="1" {{ old('is_popular', $package->is_popular) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_popular">
                        Popular
                    </label>
                </div>
            </div>

            <div class="form-group">
                <div class="form-check">
                    <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" {{ old('is_active', $package->is_active) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">
                        Active
                    </label>
                </div>
            </div>

            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    Save
                </button>

                <a href="{{ route('admin.packages.index') }}" class="btn btn-default">
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

    function createGalleryInput() {
        return `
            <div class="gallery-input-item mb-2">
                <div class="input-group">
                    <input class="form-control gallery-image-input" type="file" name="images[]" accept="image/*">
                    <div class="input-group-append">
                        <button type="button" class="btn btn-danger remove-gallery-input">
                            Hapus
                        </button>
                    </div>
                </div>

                <small class="text-muted">
                    Pilih gambar, nanti form gallery baru akan muncul otomatis.
                </small>
            </div>
        `;
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

        const galleryWrapper = document.getElementById('gallery-input-wrapper');

        if (galleryWrapper) {
            galleryWrapper.addEventListener('change', function (event) {
                if (event.target.classList.contains('gallery-image-input')) {
                    const currentInput = event.target;

                    if (currentInput.files.length > 0) {
                        const allInputs = galleryWrapper.querySelectorAll('.gallery-image-input');
                        const lastInput = allInputs[allInputs.length - 1];

                        if (currentInput === lastInput) {
                            galleryWrapper.insertAdjacentHTML('beforeend', createGalleryInput());
                        }

                        const currentRemoveButton = currentInput.closest('.gallery-input-item').querySelector('.remove-gallery-input');

                        if (currentRemoveButton) {
                            currentRemoveButton.style.display = 'inline-block';
                        }
                    }
                }
            });

            galleryWrapper.addEventListener('click', function (event) {
                if (event.target.classList.contains('remove-gallery-input')) {
                    event.target.closest('.gallery-input-item').remove();
                }
            });
        }
    });
</script>
@endsection