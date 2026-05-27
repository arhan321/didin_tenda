<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <title>{{ $package->name }} - Didin Tenda Decoration</title>

        <!-- Bootstrap 5 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />

        <!-- Bootstrap Icons -->
        <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
        />

        <!-- Leaflet Map CSS -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

        <!-- AOS Animation -->
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />

        <!-- Custom CSS -->
        <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
        <link rel="stylesheet" href="{{ asset('css/paket.css') }}" />
    </head>
    <body>
        @php
            $safeAddons = $addons ?? collect();

            $makeImageUrl = function ($image, $placeholderText = 'Image', $width = 600, $height = 400) {
                if (! $image) {
                    return 'https://placehold.co/' . $width . 'x' . $height . '/3498db/white?text=' . urlencode($placeholderText);
                }

                $image = ltrim($image, '/');

                if (str_starts_with($image, 'http://') || str_starts_with($image, 'https://')) {
                    return $image;
                }

                if (str_starts_with($image, 'storage/')) {
                    return asset($image);
                }

                if (str_starts_with($image, 'assets/')) {
                    return asset($image);
                }

                return asset('storage/' . $image);
            };

            $images = $package->images ?? [];

            if (is_string($images)) {
                $decodedImages = json_decode($images, true);
                $images = is_array($decodedImages) ? $decodedImages : [];
            }

            $galleryImages = [];

            if ($package->main_image) {
                $galleryImages[] = $package->main_image;
            }

            foreach ($images as $image) {
                if ($image) {
                    $galleryImages[] = $image;
                }
            }

            $galleryImages = array_values(array_unique($galleryImages));

            if (count($galleryImages) === 0) {
                $galleryImages[] = null;
            }

            $mainImage = $galleryImages[0] ?? null;
            $mainImageUrl = $makeImageUrl($mainImage, $package->name);

            $userName = '';
            $userPhone = '';
            $userEmail = '';

            if (auth()->check()) {
                $user = auth()->user();

                $userName = $user->name ?? '';
                $userEmail = $user->email ?? '';
                $userPhone = $user->phone ?? ($user->whatsapp ?? ($user->no_hp ?? ''));
            }
        @endphp

        <!-- ==================== NAVBAR ==================== -->
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top navbar-batik">
            <div class="container">
<a class="navbar-brand" href="{{ route('frontend.index') }}">
                <img 
                    src="{{ asset('img_logoo/logo1.png') }}" 
                    alt="Didin Tenda Decoration Logo" 
                    class="navbar-logo-img"
                    onerror="this.style.display='none'"
                >
                <div class="brand-text-container">
                    <span class="brand-text">Didin Tenda</span>
                    <span class="brand-sub">Decoration</span>
                </div>
            </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="navbar-collapse collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('frontend.index') }}#beranda">Beranda</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('frontend.index') }}#paket">Paket</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('frontend.index') }}#galeri">Galeri</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('frontend.index') }}#testimoni">Testimoni</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('frontend.index') }}#kontak">Kontak</a>
                        </li>
                    </ul>

                    <div class="d-flex ms-lg-3">
                        <a
                            href="{{ route('frontend.cart') }}"
                            class="user-menu-link"
                            data-bs-toggle="tooltip"
                            title="Keranjang Booking"
                        >
                            <i class="bi bi-cart3"></i>
                            <span class="menu-badge" id="cartCount" data-server-cart-count="{{ $cartCount ?? 0 }}">
                                {{ $cartCount ?? 0 }}
                            </span>
                        </a>

                        <a
                            href="{{ route('frontend.pesanan') }}"
                            class="user-menu-link"
                            data-bs-toggle="tooltip"
                            title="Pesanan Saya"
                        >
                            <i class="bi bi-receipt"></i>
                        </a>

                        <a
                            href="{{ route('frontend.history') }}"
                            class="user-menu-link"
                            data-bs-toggle="tooltip"
                            title="History Booking"
                        >
                            <i class="bi bi-clock-history"></i>
                        </a>

                        <a
                            href="{{ route('frontend.profile') }}"
                            class="user-menu-link"
                            data-bs-toggle="tooltip"
                            title="Akun Saya"
                        >
                            <i class="bi bi-person-circle"></i>
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- ==================== DETAIL PAKET SECTION ==================== -->
        <section class="paket-detail-section">
            <div class="container">
                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('frontend.index') }}">Beranda</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('frontend.index') }}#paket">Paket</a>
                        </li>
                        <li class="breadcrumb-item active" id="paketNameBreadcrumb">
                            {{ $package->name }}
                        </li>
                    </ol>
                </nav>

                @if (session('success'))
                    <div class="alert alert-success mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger mb-4">
                        <strong>Terjadi kesalahan:</strong>
                        <ul class="mt-2 mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('frontend.cart.add') }}" method="POST" id="bookingForm">
                    @csrf

                    <input type="hidden" name="package_id" value="{{ $package->id }}" />
                    <input type="hidden" name="customer_email" value="{{ old('customer_email', $userEmail) }}" />
                    <input type="hidden" name="distance_km" id="distanceKmInput" value="{{ old('distance_km', 0) }}" />
                    <input
                        type="hidden"
                        name="shipping_fee"
                        id="shippingFeeInput"
                        value="{{ old('shipping_fee', 0) }}"
                    />

                    {{-- Koordinat lokasi acara dari map --}}
                    <input
                        type="hidden"
                        name="event_latitude"
                        id="eventLatitudeInput"
                        value="{{ old('event_latitude') }}"
                    />
                    <input
                        type="hidden"
                        name="event_longitude"
                        id="eventLongitudeInput"
                        value="{{ old('event_longitude') }}"
                    />

                    <div class="row g-4">
                        <!-- KOLOM KIRI: Gambar & Galeri -->
                        <div class="col-lg-6" data-aos="fade-right">
                            <div class="paket-gallery">
                                <img
                                    src="{{ $mainImageUrl }}"
                                    alt="{{ $package->name }}"
                                    class="img-fluid main-image"
                                    id="mainImage"
                                    onerror="
                                        this.src =
                                            'https://placehold.co/600x400/3498db/white?text={{ urlencode($package->name) }}'
                                    "
                                />

                                <div class="gallery-thumbs mt-3" id="galleryThumbs">
                                    @foreach ($galleryImages as $index => $image)
                                        @php
                                            $thumbUrl = $makeImageUrl($image, $package->name . ' ' . ($index + 1), 120, 90);
                                        @endphp

                                        <img
                                            src="{{ $thumbUrl }}"
                                            alt="Thumb {{ $index + 1 }}"
                                            class="paket-thumb {{ $index === 0 ? 'active' : '' }}"
                                            data-image="{{ $thumbUrl }}"
                                            onerror="this.src = 'https://placehold.co/120x90/3498db/white?text=Image'"
                                        />
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- KOLOM KANAN: Info Paket & Form Booking -->
                        <div class="col-lg-6" data-aos="fade-left">
                            <div class="paket-info">
                                <h1 id="paketTitle">{{ $package->name }}</h1>

                                <div class="paket-rating">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <span class="ms-2">(128 ulasan)</span>
                                </div>

                                <div class="paket-price-large" id="paketPrice">
                                    Rp {{ number_format($package->price, 0, ',', '.') }}
                                </div>

                                <p class="paket-description" id="paketDesc">
                                    {{ $package->description }}
                                </p>

                                <!-- Fitur Paket -->
                                <div class="paket-features-list" id="paketFeatures">
                                    <h6>
                                        <i class="bi bi-check-circle-fill text-primary"></i>
                                        Fasilitas Paket:
                                    </h6>

                                    @forelse ($package->items as $item)
                                        <div class="feature-item">
                                            <i class="bi bi-check-circle-fill text-primary"></i>
                                            <span>
                                                {{ $item->name }}
                                                @if ($item->quantity)
                                                        {{ $item->quantity }} {{ $item->unit }}
                                                @endif
                                            </span>
                                        </div>
                                    @empty
                                        <div class="feature-item">
                                            <i class="bi bi-info-circle text-primary"></i>
                                            <span>Belum ada item paket.</span>
                                        </div>
                                    @endforelse
                                </div>

                                <!-- Form Booking -->
                                <div class="booking-form">
                                    <h5>
                                        <i class="bi bi-calendar-check"></i>
                                        Atur Booking
                                    </h5>

                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label class="form-label">
                                                Tanggal Acara
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input
                                                type="date"
                                                class="form-control"
                                                id="eventDate"
                                                name="event_date"
                                                min="{{ now()->toDateString() }}"
                                                value="{{ old('event_date') }}"
                                                required
                                            />
                                            <small class="text-muted">Pilih tanggal acara Anda</small>
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label">
                                                Nama Lokasi Acara
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="eventLocation"
                                                name="event_location_name"
                                                value="{{ old('event_location_name') }}"
                                                placeholder="Contoh: Gedung Serbaguna, Jakarta"
                                                required
                                            />
                                        </div>

                                        <!-- Alamat Lengkap -->
                                        <div class="col-12">
                                            <label class="form-label">
                                                Alamat Lengkap Acara
                                                <span class="text-danger">*</span>
                                            </label>
                                            <textarea
                                                class="form-control"
                                                id="eventFullAddress"
                                                name="event_address"
                                                rows="2"
                                                placeholder="Masukkan alamat lengkap acara (Jalan, RT/RW, Kelurahan, Kecamatan, Kota)"
                                                required
                                            >
                                            {{ old('event_address') }}</textarea
                                            >
                                            <small class="text-muted">
                                                Alamat akan digunakan sebagai keterangan lokasi acara
                                            </small>
                                        </div>

                                        <!-- Pilih Titik Lokasi Map -->
                                        <div class="col-12">
                                            <button
                                                type="button"
                                                class="btn btn-outline-primary w-100"
                                                id="openLocationPickerBtn"
                                            >
                                                <i class="bi bi-geo-alt-fill"></i>
                                                Pilih Titik Lokasi di Map
                                            </button>

                                            <small class="text-muted d-block mt-2" id="selectedLocationText">
                                                Titik lokasi belum dipilih. Pilih titik lokasi agar jarak lebih akurat.
                                            </small>
                                        </div>

                                        <!-- Tampilan Jarak & Ongkir -->
                                        <div class="shipping-info mt-2" id="shippingInfo" style="display: none">
                                            <div class="shipping-card">
                                                <div class="shipping-distance">
                                                    <i class="bi bi-geo-alt"></i>
                                                    <span>
                                                        Jarak dari Lokasi Kami:
                                                        <strong id="distanceValue">0</strong>
                                                        km
                                                    </span>
                                                </div>

                                                <div class="shipping-fee">
                                                    <i class="bi bi-truck"></i>
                                                    <span>
                                                        Biaya Pengiriman:
                                                        <strong id="shippingFeeValue">Rp 0</strong>
                                                    </span>
                                                </div>

                                                <div class="shipping-note" id="shippingNote"></div>
                                            </div>
                                        </div>

                                        <!-- Tombol Cek Ongkir -->
                                        <div class="col-12">
                                            <button
                                                type="button"
                                                class="btn btn-outline-primary w-100"
                                                id="checkShippingBtn"
                                            >
                                                <i class="bi bi-geo-alt"></i>
                                                Cek Jarak & Ongkir
                                            </button>
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label">
                                                Nama Lengkap
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="customerName"
                                                name="customer_name"
                                                value="{{ old('customer_name', $userName) }}"
                                                placeholder="Nama lengkap Anda"
                                                required
                                            />
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label">
                                                Nomor WhatsApp
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input
                                                type="tel"
                                                class="form-control"
                                                id="customerPhone"
                                                name="customer_phone"
                                                value="{{ old('customer_phone', $userPhone) }}"
                                                placeholder="0812-3456-7890"
                                                required
                                            />
                                        </div>
                                    </div>

                                    <!-- Add-ons Section -->
                                    <div class="addons-section mt-4">
                                        <h5>
                                            <i class="bi bi-plus-circle"></i>
                                            Tambahan (Add-ons)
                                        </h5>

                                        <div class="row g-2" id="addonsContainer">
                                            @forelse ($safeAddons as $addon)
                                                @php
                                                    $addonImageUrl = $makeImageUrl($addon->image, substr($addon->name, 0, 3), 80, 80);
                                                @endphp

                                                <div class="col-md-6 col-lg-6 mb-3">
                                                    <div
                                                        class="addon-card"
                                                        data-addon-card
                                                        data-addon-id="{{ $addon->id }}"
                                                        data-addon-price="{{ (int) $addon->price }}"
                                                    >
                                                        <div class="addon-card-inner">
                                                            <div class="addon-image">
                                                                <img
                                                                    src="{{ $addonImageUrl }}"
                                                                    alt="{{ $addon->name }}"
                                                                    onerror="
                                                                        this.src =
                                                                            'https://placehold.co/80x80/2c3e50/white?text={{ urlencode(substr($addon->name, 0, 3)) }}'
                                                                    "
                                                                />
                                                            </div>

                                                            <div class="addon-info">
                                                                <div class="addon-name">
                                                                    <i
                                                                        class="bi {{ $addon->icon ?: 'bi-plus-circle' }}"
                                                                    ></i>
                                                                    <strong>{{ $addon->name }}</strong>
                                                                </div>

                                                                <div class="addon-detail">
                                                                    {{ $addon->detail }}
                                                                </div>

                                                                <div class="addon-price-wrapper">
                                                                    <span class="addon-price">
                                                                        Rp
                                                                        {{ number_format($addon->price, 0, ',', '.') }}
                                                                    </span>
                                                                    <span class="addon-unit">
                                                                        /{{ $addon->unit ?: 'item' }}
                                                                    </span>
                                                                </div>

                                                                <div class="addon-quantity">
                                                                    <button
                                                                        type="button"
                                                                        class="qty-btn minus"
                                                                        data-addon-minus
                                                                    >
                                                                        <i class="bi bi-dash"></i>
                                                                    </button>

                                                                    <span class="qty-value">0</span>

                                                                    <button
                                                                        type="button"
                                                                        class="qty-btn plus"
                                                                        data-addon-plus
                                                                    >
                                                                        <i class="bi bi-plus"></i>
                                                                    </button>

                                                                    <span class="qty-total"></span>

                                                                    <input
                                                                        type="hidden"
                                                                        name="addons[{{ $addon->id }}][quantity]"
                                                                        value="0"
                                                                        data-addon-input
                                                                        data-price="{{ (int) $addon->price }}"
                                                                        data-max="{{ $addon->stock ?? '' }}"
                                                                    />
                                                                </div>

                                                                @if (! is_null($addon->stock))
                                                                    <small class="text-muted d-block mt-1">
                                                                        Stok: {{ $addon->stock }}
                                                                    </small>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @empty
                                                <div class="col-12">
                                                    <div class="alert alert-info mb-0">Add-ons belum tersedia.</div>
                                                </div>
                                            @endforelse
                                        </div>
                                    </div>

                                    <!-- Ringkasan Harga -->
                                    <div class="price-summary">
                                        <div class="summary-row">
                                            <span>Harga Paket</span>
                                            <span id="summaryPaketPrice">
                                                Rp {{ number_format($package->price, 0, ',', '.') }}
                                            </span>
                                        </div>

                                        <div class="summary-row">
                                            <span>Total Add-ons</span>
                                            <span id="summaryAddons">Rp 0</span>
                                        </div>

                                        <div class="summary-row" id="shippingSummaryRow" style="display: none">
                                            <span>🚚 Biaya Pengiriman</span>
                                            <span id="summaryShipping">Rp 0</span>
                                        </div>

                                        <div class="summary-row total">
                                            <span>Total Pembayaran</span>
                                            <span id="summaryTotal">
                                                Rp {{ number_format($package->price, 0, ',', '.') }}
                                            </span>
                                        </div>

                                        <div class="payment-note">
                                            <i class="bi bi-shield-check"></i>
                                            <small>
                                                Pembayaran 100% di awal via Midtrans (QRIS, Transfer Bank, E-Wallet)
                                            </small>
                                        </div>
                                    </div>

                                    <!-- Tombol Aksi -->
                                    <div class="action-buttons">
                                        <button type="submit" class="btn btn-primary btn-lg w-100" id="addToCartBtn">
                                            <i class="bi bi-cart-plus"></i>
                                            Tambah ke Keranjang
                                        </button>

                                        <button
                                            type="submit"
                                            name="checkout_now"
                                            value="1"
                                            class="btn btn-outline-primary mt-2 w-100"
                                            id="bookNowBtn"
                                        >
                                            <i class="bi bi-credit-card"></i>
                                            Booking & Bayar Langsung
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>

        <!-- ==================== MODAL PILIH LOKASI MAP ==================== -->
        <div class="modal fade" id="locationPickerModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content location-picker-modal">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="bi bi-geo-alt-fill text-primary"></i>
                            Pilih Titik Lokasi Acara
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="alert alert-info small mb-3">
                            Cari lokasi acara melalui kolom pencarian, lalu pilih hasilnya. Anda juga tetap bisa klik
                            atau geser pin di map.
                        </div>

                        <div class="location-search-wrapper mb-3">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-search"></i>
                                </span>

                                <input
                                    type="text"
                                    class="form-control"
                                    id="locationSearchInput"
                                    placeholder="Cari lokasi, contoh: Esa Unggul, Citra Raya, Balai Kartini"
                                />

                                <button type="button" class="btn btn-primary" id="locationSearchBtn">Cari</button>
                            </div>

                            <div id="locationSearchResults" class="list-group mt-2" style="display: none"></div>
                        </div>

                        <div id="locationPickerMap" style="height: 420px; border-radius: 14px; overflow: hidden"></div>

                        <div class="small text-muted mt-3" id="mapCoordinateText">Belum ada titik dipilih.</div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" id="locateMeBtn">
                            <i class="bi bi-crosshair"></i>
                            Gunakan Lokasi Saya
                        </button>

                        <button type="button" class="btn btn-primary" id="useSelectedLocationBtn">
                            <i class="bi bi-check-circle"></i>
                            Gunakan Titik Ini
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- ==================== FOOTER ==================== -->
        <footer id="kontak" class="footer-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 mb-lg-0 mb-4">
                        <h4>Didin Tenda Decoration</h4>

                        <p class="footer-address">
                            <i class="bi bi-geo-alt-fill"></i>
                            Jl. Ki Mas Laeng Kp. Katomas, Tigaraksa, Kab. Tangerang, Banten
                        </p>

                        <p>
                            <i class="bi bi-telephone-fill"></i>
                            <a href="tel:088289258764">0882-8925-8764</a>
                        </p>

                        <p>
                            <i class="bi bi-envelope-fill"></i>
                            <a href="mailto:info@didintenda.com">info@didintenda.com</a>
                        </p>
                    </div>

                    <div class="col-lg-2 col-md-6 mb-md-0 mb-4">
                        <h5>Menu Cepat</h5>
                        <ul class="footer-links">
                            <li>
                                <a href="{{ route('frontend.index') }}#beranda">Beranda</a>
                            </li>
                            <li>
                                <a href="{{ route('frontend.index') }}#paket">Paket</a>
                            </li>
                            <li>
                                <a href="{{ route('frontend.index') }}#galeri">Galeri</a>
                            </li>
                            <li>
                                <a href="{{ route('frontend.index') }}#kontak">Kontak</a>
                            </li>
                            <li>
                                <a href="{{ route('frontend.cart') }}">Keranjang</a>
                            </li>
                            <li>
                                <a href="{{ route('frontend.pesanan') }}">Pesanan</a>
                            </li>
                            <li>
                                <a href="{{ route('frontend.history') }}">History</a>
                            </li>
                        </ul>
                    </div>

                    <div class="col-lg-3 col-md-6 mb-md-0 mb-4">
                        <h5>Layanan</h5>
                        <ul class="footer-links">
                            <li>
                                <a href="{{ route('frontend.index') }}#paket">Sewa Tenda</a>
                            </li>
                            <li>
                                <a href="{{ route('frontend.index') }}#paket">Dekorasi Pernikahan</a>
                            </li>
                            <li>
                                <a href="{{ route('frontend.index') }}#paket">Sewa Kursi</a>
                            </li>
                            <li>
                                <a href="{{ route('frontend.index') }}#paket">Rigging & Lighting</a>
                            </li>
                            <li>
                                <a href="{{ route('frontend.paket-custom') }}">Paket Custom</a>
                            </li>
                        </ul>
                    </div>

                    <div class="col-lg-3">
                        <h5>Metode Pembayaran</h5>

                        <div class="payment-methods">
                            <img
                                src="https://placehold.co/60x40/2c3e50/white?text=BCA"
                                alt="BCA"
                                class="payment-logo"
                            />
                            <img
                                src="https://placehold.co/60x40/2c3e50/white?text=QRIS"
                                alt="QRIS"
                                class="payment-logo"
                            />
                            <img
                                src="https://placehold.co/60x40/2c3e50/white?text=GoPay"
                                alt="GoPay"
                                class="payment-logo"
                            />
                        </div>
                                                <p class="small text-white-50 mt-3">
                            <i class="bi bi-shield-check"></i>
                            Transaksi 100% aman via Midtrans
                        </p>
                        <div class="mt-3 text-center">
                        <img 
                            src="{{ asset('img_logoo/logo2.png') }}" 
                            alt="Partner Logo" 
                            style="height: 90px; width: auto;"
                            onerror="this.style.display='none'"
                        >
                    </div>
                </div>

                <hr class="footer-hr" />

                <div class="row">
                    <div class="col-md-6 text-md-start text-center">
                        <p class="copyright">© 2026 Didin Tenda Decoration. All rights reserved.</p>
                    </div>

                    <div class="col-md-6 text-md-end text-center">
                        <p class="developer">Developed for Tugas Akhir - Muhamad Darlan (20220803005)</p>
                    </div>
                </div>
            </div>
        </footer>

        <!-- BACK TO TOP -->
        <button id="backToTop" class="back-to-top" title="Kembali ke atas">
            <i class="bi bi-arrow-up"></i>
        </button>

        <script>
            window.didinPackagePrice = {{ (int) $package->price }}

            window.didinRouteConfig = {
                depot: {
                    lat: {{ (float) config('didin.depot_lat', -6.262311) }},
                    lng: {{ (float) config('didin.depot_lng', 106.472969) }},
                    name: @json(config('didin.depot_name', 'Didin Tenda Decoration')),
                },
                osrmBaseUrl: @json(config('didin.osrm_base_url', 'https://router.project-osrm.org')),
                defaultCenter: {
                    lat: {{ (float) config('didin.depot_lat', -6.262311) }},
                    lng: {{ (float) config('didin.depot_lng', 106.472969) }},
                },
            }
        </script>

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

        <!-- Leaflet Map JS -->
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

        <!-- JS umum untuk index/layout -->
        <script src="{{ asset('js/script.js') }}?v={{ time() }}"></script>

        <!-- JS khusus halaman paket -->
        <script src="{{ asset('js/paket.js') }}?v={{ time() }}"></script>
    </body>
</html>
