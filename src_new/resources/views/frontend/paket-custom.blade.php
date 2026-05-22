<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <title>Paket Custom - Didin Tenda Decoration</title>

        <!-- Bootstrap 5 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />

        <!-- Bootstrap Icons -->
        <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
        />

        <!-- AOS Animation -->
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />

        <!-- Leaflet Map CSS -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

        <!-- Custom CSS -->
        <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
        <link rel="stylesheet" href="{{ asset('css/paket-custom.css') }}" />


        {{--
            Helper khusus halaman ini:
            - Menjadikan path gambar dari Filament disk public otomatis menjadi /storage/...
            - Tetap support URL eksternal, path storage/, path assets/, dan path public/...
            - CSS tambahan sengaja disatukan di Blade sesuai request agar tidak perlu edit file CSS terpisah.
        --}}
        @php
            $resolveImageUrl = function (?string $path, ?string $fallback = null): ?string {
                if (! $path) {
                    return $fallback;
                }

                $path = trim($path);

                if ($path === '') {
                    return $fallback;
                }

                $path = ltrim($path, '/');

                if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
                    return $path;
                }

                if (str_starts_with($path, 'storage/') || str_starts_with($path, 'assets/')) {
                    return asset($path);
                }

                if (str_starts_with($path, 'public/')) {
                    return asset('storage/' . substr($path, strlen('public/')));
                }

                return asset('storage/' . $path);
            };

            $customItemFallbackImage = 'https://placehold.co/120x120/f3f4f6/9ca3af?text=Item';
            $addonFallbackImage = 'https://placehold.co/120x120/f3f4f6/9ca3af?text=Add-on';
        @endphp

        <style>
            /* ==================== IMAGE CUSTOM ITEM & ADD-ONS ==================== */
            .custom-item-row {
                gap: 16px;
            }

            .custom-item-img,
            .addon-image {
                width: 76px;
                height: 76px;
                min-width: 76px;
                border-radius: 18px;
                overflow: hidden;
                background: #f3f4f6;
                border: 1px solid rgba(148, 163, 184, 0.28);
                display: flex;
                align-items: center;
                justify-content: center;
                box-shadow: 0 8px 22px rgba(15, 23, 42, 0.06);
            }

            .custom-item-img img,
            .addon-image img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                display: block;
            }

            .addon-card-inner {
                display: flex;
                align-items: flex-start;
                gap: 14px;
            }

            .addon-info {
                flex: 1;
                min-width: 0;
            }

            .addon-detail,
            .custom-item-detail small {
                line-height: 1.5;
            }

            @media (max-width: 575.98px) {
                .custom-item-row {
                    align-items: flex-start;
                    gap: 12px;
                }

                .custom-item-img,
                .addon-image {
                    width: 64px;
                    height: 64px;
                    min-width: 64px;
                    border-radius: 16px;
                }

                .addon-card-inner {
                    gap: 12px;
                }
            }
        </style>
    </head>
    <body>
        <!-- ==================== NAVBAR ==================== -->
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top navbar-batik">
            <div class="container">
                <a class="navbar-brand" href="{{ route('frontend.index') }}">
                    <span class="brand-text">Didin Tenda</span>
                    <span class="brand-sub">Decoration</span>
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

                    <div class="d-flex ms-lg-3 align-items-center">
                        <a
                            href="{{ route('frontend.cart') }}"
                            class="user-menu-link"
                            data-bs-toggle="tooltip"
                            title="Keranjang Booking"
                        >
                            <i class="bi bi-cart3"></i>
                            <span class="menu-badge" id="cartCount">{{ $cartCount ?? 0 }}</span>
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

                        @auth
                            <span class="small d-none d-lg-inline ms-2 text-white">
                                {{ auth()->user()->name }}
                            </span>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- ==================== PAKET CUSTOM SECTION ==================== -->
        <section class="paket-custom-section">
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

                        <li class="breadcrumb-item active">Paket Custom</li>
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

                <div class="row g-4">
                    <!-- KOLOM KIRI: Form Custom Items -->
                    <div class="col-lg-7" data-aos="fade-right">
                        <div class="custom-form">
                            <h3>
                                <i class="bi bi-pencil-square"></i>
                                Buat Paket Custom
                            </h3>
                            <p class="text-muted mb-4">Pilih item dekorasi sesuai kebutuhan acara Anda</p>

                            <!-- ===== DATA DIRI SECTION ===== -->
                            <div class="form-section">
                                <h5>
                                    <i class="bi bi-person"></i>
                                    Data Diri
                                </h5>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">
                                            Nama Lengkap
                                            <span class="text-danger">*</span>
                                        </label>

                                        <input
                                            type="text"
                                            class="form-control"
                                            id="customerName"
                                            placeholder="Nama lengkap Anda"
                                            value="{{ optional(auth()->user())->name ?? '' }}"
                                        />
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">
                                            Nomor WhatsApp
                                            <span class="text-danger">*</span>
                                        </label>

                                        <input
                                            type="tel"
                                            class="form-control"
                                            id="customerPhone"
                                            placeholder="0812-3456-7890"
                                            value="{{ optional(auth()->user())->phone ?? '' }}"
                                        />
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">
                                            Tanggal Acara
                                            <span class="text-danger">*</span>
                                        </label>

                                        <input type="date" class="form-control" id="eventDate" />
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">
                                            Nama Lokasi Acara
                                            <span class="text-danger">*</span>
                                        </label>

                                        <input
                                            type="text"
                                            class="form-control"
                                            id="eventLocation"
                                            placeholder="Contoh: Gedung Serbaguna"
                                        />
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label">
                                            Alamat Lengkap Acara
                                            <span class="text-danger">*</span>
                                        </label>

                                        <textarea
                                            class="form-control"
                                            id="eventFullAddress"
                                            rows="2"
                                            placeholder="Masukkan alamat lengkap acara (Jalan, RT/RW, Kelurahan, Kecamatan, Kota)"
                                        ></textarea>

                                        <small class="text-muted">
                                            Alamat akan digunakan untuk menghitung biaya pengiriman
                                        </small>
                                    </div>

                                    <input type="hidden" id="eventLatitude" />
                                    <input type="hidden" id="eventLongitude" />
                                </div>
                            </div>

                            <!-- ===== ITEM CUSTOM ===== -->
                            <div class="form-section">
                                <h5>
                                    <i class="bi bi-grid"></i>
                                    Pilih Item Dekorasi
                                </h5>

                                @forelse ($customItems ?? [] as $item)
                                    @php
                                        $itemImageUrl = $resolveImageUrl($item->image, $customItemFallbackImage);
                                    @endphp

                                    <div
                                        class="custom-item-row"
                                        data-custom-id="{{ $item->id }}"
                                        data-name="{{ $item->name }}"
                                        data-slug="{{ $item->slug }}"
                                        data-description="{{ $item->description }}"
                                        data-price="{{ (int) $item->price }}"
                                        data-unit="{{ $item->unit }}"
                                        data-min-quantity="{{ (int) $item->min_quantity }}"
                                        data-max-quantity="{{ $item->max_quantity ? (int) $item->max_quantity : '' }}"
                                        data-image="{{ $itemImageUrl }}"
                                    >
                                        <div class="custom-item-img">
                                            <img
                                                src="{{ $itemImageUrl }}"
                                                alt="{{ $item->name }}"
                                                loading="lazy"
                                                onerror="this.onerror = null; this.src = '{{ $customItemFallbackImage }}';"
                                            />
                                        </div>

                                        <div class="custom-item-detail">
                                            <h6>{{ $item->name }}</h6>

                                            <p class="price">
                                                Rp {{ number_format((int) $item->price, 0, ',', '.') }} /
                                                {{ $item->unit }}
                                            </p>

                                            @if ($item->description)
                                                <small class="text-muted d-block">
                                                    {{ $item->description }}
                                                </small>
                                            @endif

                                            @if ($item->max_quantity)
                                                <small class="text-muted d-block">
                                                    Maks. {{ $item->max_quantity }} {{ $item->unit }}
                                                </small>
                                            @endif
                                        </div>

                                        <div class="custom-item-qty">
                                            <button
                                                type="button"
                                                class="qty-btn-sm minus"
                                                data-custom-qty-button
                                                data-custom-id="{{ $item->id }}"
                                                data-delta="-1"
                                            >
                                                -
                                            </button>

                                            <input
                                                type="number"
                                                id="qty-custom-{{ $item->id }}"
                                                class="qty-input-sm"
                                                value="0"
                                                min="0"
                                                @if($item->max_quantity) max="{{ $item->max_quantity }}" @endif
                                                step="1"
                                                data-custom-qty-input
                                                data-custom-id="{{ $item->id }}"
                                            />

                                            <button
                                                type="button"
                                                class="qty-btn-sm plus"
                                                data-custom-qty-button
                                                data-custom-id="{{ $item->id }}"
                                                data-delta="1"
                                            >
                                                +
                                            </button>

                                            <span class="item-total-sm" id="total-custom-{{ $item->id }}">Rp 0</span>
                                        </div>
                                    </div>
                                @empty
                                    <div class="alert alert-warning mb-0">
                                        Item custom belum tersedia. Silakan tambahkan data di tabel
                                        <strong>custom_items</strong>
                                        .
                                    </div>
                                @endforelse
                            </div>

                            <!-- ===== ADD-ONS SECTION ===== -->
                            <div class="form-section">
                                <h5>
                                    <i class="bi bi-plus-circle"></i>
                                    Tambahan (Add-ons)
                                </h5>

                                <div class="row g-2" id="addonsContainer">
                                    <!-- Add-ons akan diisi oleh JavaScript -->
                                </div>
                            </div>

                            <!-- Tombol Aksi -->
                            <div class="action-buttons">
                                <button type="button" class="btn btn-primary btn-lg w-100" id="addToCartBtn">
                                    <i class="bi bi-cart-plus"></i>
                                    Tambah ke Keranjang
                                </button>

                                <button type="button" class="btn btn-outline-primary mt-2 w-100" id="bookNowBtn">
                                    <i class="bi bi-credit-card"></i>
                                    Booking & Bayar Langsung
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- KOLOM KANAN: Ringkasan & Ongkir -->
                    <div class="col-lg-5" data-aos="fade-left">
                        <div class="custom-summary">
                            <h4>
                                <i class="bi bi-receipt"></i>
                                Ringkasan Pesanan
                            </h4>

                            <!-- Daftar Item Custom -->
                            <div class="summary-items" id="summaryItems">
                                <p class="text-muted small">Belum ada item dipilih</p>
                            </div>

                            <!-- Add-ons Summary -->
                            <div id="addonsSummaryCustom" class="summary-addons"></div>

                            <!-- Shipping Info -->
                            <div class="shipping-section">
                                <div class="shipping-info-custom" id="shippingInfo" style="display: none">
                                    <div class="shipping-card">
                                        <div class="shipping-distance">
                                            <i class="bi bi-geo-alt"></i>
                                            <span>
                                                Jarak:
                                                <strong id="distanceValue">0</strong>
                                                km
                                            </span>
                                        </div>

                                        <div class="shipping-fee">
                                            <i class="bi bi-truck"></i>
                                            <span>
                                                Ongkir:
                                                <strong id="shippingFeeValue">Rp 0</strong>
                                            </span>
                                        </div>

                                        <div class="shipping-note" id="shippingNote"></div>
                                    </div>
                                </div>

                                <button type="button" class="btn btn-outline-primary mt-3 w-100" id="checkShippingBtn">
                                    <i class="bi bi-geo-alt"></i>
                                    Pilih Titik Lokasi & Cek Ongkir
                                </button>
                            </div>

                            <!-- Total Harga -->
                            <div class="price-summary-custom">
                                <div class="summary-row">
                                    <span>Subtotal Item</span>
                                    <span id="subtotalItem">Rp 0</span>
                                </div>

                                <div id="shippingSummaryCustom"></div>

                                <div class="summary-row total">
                                    <span>Total Pembayaran</span>
                                    <span id="totalCustom">Rp 0</span>
                                </div>

                                <div class="payment-note">
                                    <i class="bi bi-shield-check"></i>
                                    <small>Pembayaran 100% di awal via Midtrans</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

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

        <!-- ==================== MODAL PILIH TITIK LOKASI ==================== -->
        <div class="modal fade" id="locationMapModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content location-map-modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="bi bi-geo-alt-fill text-primary"></i>
                            Pilih Titik Lokasi Acara
                        </h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="alert alert-info small mb-3">
                            Cari alamat atau klik titik lokasi acara pada map. Setelah titik dipilih, alamat akan
                            otomatis masuk ke form.
                        </div>

                        <div class="input-group mb-3">
                            <input
                                type="text"
                                class="form-control"
                                id="mapSearchInput"
                                placeholder="Cari lokasi, contoh: Universitas Esa Unggul Tangerang"
                            />

                            <button class="btn btn-primary" type="button" id="mapSearchBtn">
                                <i class="bi bi-search"></i>
                                Cari
                            </button>
                        </div>

                        <div id="mapSearchResults" class="list-group mb-3" style="display: none"></div>

                        <div id="eventMap" style="height: 420px; border-radius: 14px; overflow: hidden"></div>

                        <p class="text-muted small mt-2 mb-0" id="selectedPointText">Titik belum dipilih.</p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" id="useMyLocationBtn">
                            <i class="bi bi-crosshair"></i>
                            Gunakan Lokasi Saya
                        </button>

                        <button type="button" class="btn btn-primary" id="useSelectedPointBtn">
                            <i class="bi bi-check-circle"></i>
                            Gunakan Titik Ini
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- BACK TO TOP -->
        <button id="backToTop" class="back-to-top" title="Kembali ke atas">
            <i class="bi bi-arrow-up"></i>
        </button>

        <!-- ==================== DATA DARI LARAVEL ==================== -->
        @php
            $customItemsForJs = collect($customItems ?? [])
                ->map(function ($item) use ($resolveImageUrl) {
                    return [
                        'id' => $item->id,
                        'name' => $item->name,
                        'slug' => $item->slug,
                        'description' => $item->description,
                        'price' => (int) $item->price,
                        'unit' => $item->unit,
                        'minQuantity' => (int) $item->min_quantity,
                        'maxQuantity' => $item->max_quantity ? (int) $item->max_quantity : null,
                        'image' => $resolveImageUrl($item->image, null),
                        'icon' => $item->icon,
                    ];
                })
                ->values();

            $addonsForJs = collect($addons ?? [])
                ->map(function ($addon) use ($resolveImageUrl) {
                    return [
                        'id' => $addon->id,
                        'name' => $addon->name,
                        'slug' => $addon->slug ?? null,
                        'description' => $addon->description ?? ($addon->detail ?? null),
                        'detail' => $addon->detail ?? ($addon->description ?? null),
                        'price' => (int) $addon->price,
                        'unit' => $addon->unit ?? 'pcs',
                        'stock' => isset($addon->stock) ? (int) $addon->stock : null,
                        'maxQuantity' => isset($addon->max_quantity) && $addon->max_quantity ? (int) $addon->max_quantity : null,
                        'image' => $resolveImageUrl($addon->image ?? null, null),
                        'icon' => $addon->icon ?? null,
                    ];
                })
                ->values();

            $customRoutesForJs = [
                'addToCart' => route('frontend.custom.add-to-cart'),
                'cart' => route('frontend.cart'),
                'pesanan' => route('frontend.pesanan'),
                'login' => route('frontend.index'),
            ];

            $shippingConfigForJs = [
                'baseLat' => -6.269378,
                'baseLng' => 106.476574,
                'baseName' => 'Didin Tenda Decoration',
                'freeKm' => 10,
                'ratePerKm' => 5000,
                'roundTo' => 5000,
            ];
        @endphp

        <script>
            window.DIDIN_CUSTOM_ITEMS = @json($customItemsForJs);
            window.DIDIN_ADDONS = @json($addonsForJs);
            window.DIDIN_CUSTOM_ROUTES = @json($customRoutesForJs);
            window.DIDIN_SHIPPING_CONFIG = @json($shippingConfigForJs);
        </script>

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

        <!-- AOS Animation JS -->
        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

        <!-- Leaflet Map JS -->
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

        <!-- Custom JS -->
        <script src="{{ asset('js/script.js') }}?v={{ time() }}"></script>
        <script src="{{ asset('js/paket-custom.js') }}?v={{ time() }}"></script>
    </body>
</html>
