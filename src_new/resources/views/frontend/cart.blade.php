<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>Keranjang Booking - Didin Tenda Decoration</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
        <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
        />

        <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
        <link rel="stylesheet" href="{{ asset('css/cartt.css') }}" />
    </head>
    <body>
        <!-- ==================== NAVBAR DENGAN LOGO ==================== -->
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
                            <a class="nav-link" href="{{ route('frontend.index') }}#paket">Paket</a>
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
                            class="user-menu-link active"
                            data-bs-toggle="tooltip"
                            title="Keranjang Booking"
                        >
                            <i class="bi bi-cart3"></i>
                            <span
                                class="menu-badge"
                                id="cartCount"
                                data-server-cart-count="{{ $cartCount ?? count($cart ?? []) }}"
                            >
                                {{ $cartCount ?? count($cart ?? []) }}
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

        <!-- ==================== CART SECTION ==================== -->
        <section class="cart-section">
            <div class="container">
                <div class="cart-header">
                    <h1>
                        <i class="bi bi-cart3"></i>
                        Keranjang Booking
                    </h1>
                    <p>Review pesanan Anda sebelum melanjutkan ke pembayaran</p>
                </div>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="row g-4">
                    <!-- KOLOM KIRI: Daftar Item -->
                    <div class="col-lg-7">
                        <div
                            class="cart-items-container"
                            id="cartItemsContainer"
                            style="{{ count($cart ?? []) === 0 ? 'display: none;' : '' }}"
                        >
                            @foreach ($cart ?? [] as $key => $item)
                                @php
                                    $packageName = $item['package']['name'] ?? ($item['name'] ?? 'Paket');
                                    $eventDate = $item['event_date'] ?? ($item['date'] ?? null);
                                    $eventDateFormatted = $eventDate ? \Carbon\Carbon::parse($eventDate)->translatedFormat('d F Y') : 'Belum dipilih';
                                    $locationName = $item['event_location_name'] ?? ($item['location'] ?? 'Lokasi belum diisi');
                                    $distanceKm = (float) ($item['distance_km'] ?? ($item['distance'] ?? 0));
                                    $shippingFee = (int) ($item['shipping_fee'] ?? ($item['shippingFee'] ?? 0));
                                    $customerName = $item['customer_name'] ?? ($item['customerName'] ?? 'Nama belum diisi');
                                    $customerPhone = $item['customer_phone'] ?? ($item['customerPhone'] ?? 'No. WA belum diisi');
                                    $subtotalPackage = (int) ($item['subtotal_package'] ?? ($item['basePrice'] ?? ($item['price'] ?? 0)));
                                    $subtotalCustom = (int) ($item['subtotal_custom'] ?? 0);
                                    $subtotalAddons = (int) ($item['subtotal_addons'] ?? 0);
                                    $totalPrice = (int) ($item['total_price'] ?? ($item['price'] ?? 0));
                                    $addons = $item['addons'] ?? [];
                                    $customItems = $item['custom_items'] ?? ($item['customItems'] ?? []);
                                    $isCustom = ($item['order_type'] ?? '') === 'custom' || ($item['isCustom'] ?? false) === true;
                                @endphp

                                <div class="cart-item" data-index="{{ $loop->index }}">
                                    <div class="cart-item-info">
                                        <h4>
                                            {{ $packageName }}
                                            @if ($isCustom)
                                                <span class="badge-custom">Custom</span>
                                            @endif
                                        </h4>

                                        <!-- Detail tanggal dan lokasi -->
                                        <div class="cart-item-details">
                                            <div class="detail-row">
                                                <i class="bi bi-calendar"></i>
                                                <span>📅 {{ $eventDateFormatted }}</span>
                                            </div>
                                            <div class="detail-row">
                                                <i class="bi bi-geo-alt"></i>
                                                <span>📍 {{ $locationName }}</span>
                                            </div>
                                            <div class="detail-row">
                                                <i class="bi bi-truck"></i>
                                                <span>
                                                    🚚 Jarak: {{ number_format($distanceKm, 1) }} km | Ongkir:
                                                    {{ $shippingFee > 0 ? 'Rp ' . number_format($shippingFee, 0, ',', '.') : 'GRATIS' }}
                                                </span>
                                            </div>
                                            <div class="detail-row">
                                                <i class="bi bi-person"></i>
                                                <span>👤 {{ $customerName }}</span>
                                            </div>
                                            <div class="detail-row">
                                                <i class="bi bi-whatsapp"></i>
                                                <span>📱 {{ $customerPhone }}</span>
                                            </div>
                                        </div>

                                        <!-- Detail paket custom jika ada -->
                                        @if ($isCustom && count($customItems) > 0)
                                            <div class="cart-item-custom">
                                                <div class="custom-header">
                                                    <i class="bi bi-pencil-square"></i>
                                                    Item Pilihan (Custom):
                                                </div>
                                                <ul class="custom-list">
                                                    @foreach ($customItems as $custom)
                                                        @php
                                                            $customName = $custom['name'] ?? '-';
                                                            $customQty = $custom['quantity'] ?? 1;
                                                            $customUnit = $custom['unit'] ?? 'item';
                                                            $customTotal = (int) ($custom['total_price'] ?? ($custom['totalPrice'] ?? 0));
                                                        @endphp

                                                        <li>
                                                            <i class="bi bi-check-circle-fill text-primary"></i>
                                                            <span class="custom-name">{{ $customName }}</span>
                                                            <span class="custom-qty">
                                                                ({{ $customQty }} {{ $customUnit }})
                                                            </span>
                                                            <span class="custom-price">
                                                                Rp {{ number_format($customTotal, 0, ',', '.') }}
                                                            </span>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif

                                        <!-- Tampilkan add-ons -->
                                        @if (count($addons) > 0)
                                            <div class="cart-item-addons">
                                                <div class="addons-header">
                                                    <i class="bi bi-plus-circle"></i>
                                                    Add-ons yang dipilih:
                                                </div>
                                                <ul class="addons-list">
                                                    @foreach ($addons as $addon)
                                                        @php
                                                            $addonName = $addon['name'] ?? '-';
                                                            $addonQty = $addon['quantity'] ?? 1;
                                                            $addonUnit = $addon['unit'] ?? 'pcs';
                                                            $addonTotal = (int) ($addon['total_price'] ?? ($addon['totalPrice'] ?? ($addon['price'] ?? 0)));
                                                        @endphp

                                                        <li>
                                                            <i class="bi bi-check-circle-fill"></i>
                                                            <span>
                                                                {{ $addonName }}
                                                                @if ($addonQty > 1)
                                                                        ({{ $addonQty }} {{ $addonUnit }})
                                                                @endif
                                                            </span>
                                                            <span class="addon-price-cart">
                                                                Rp {{ number_format($addonTotal, 0, ',', '.') }}
                                                            </span>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif

                                        <!-- Tombol Aksi -->
                                        <div class="cart-item-actions">
                                            @if ($item['package']['slug'] ?? null)
                                                <a
                                                    class="btn-edit"
                                                    href="{{ route('frontend.paket', ['id' => $item['package']['slug']]) }}"
                                                >
                                                    <i class="bi bi-pencil"></i>
                                                    Edit
                                                </a>
                                            @endif

                                            <form
                                                action="{{ route('frontend.cart.remove', $key) }}"
                                                method="POST"
                                                class="d-inline"
                                            >
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    type="submit"
                                                    class="btn-remove"
                                                    onclick="return confirm('Hapus item ini dari keranjang?')"
                                                >
                                                    <i class="bi bi-trash"></i>
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="cart-item-price">
                                        <div class="price-detail">
                                            <span class="label">Harga Paket:</span>
                                            <span class="value">
                                                Rp {{ number_format($subtotalPackage, 0, ',', '.') }}
                                            </span>
                                        </div>

                                        @if ($isCustom && $subtotalCustom > 0)
                                            <div class="price-detail custom-price">
                                                <span class="label">+ Custom Item:</span>
                                                <span class="value">
                                                    Rp {{ number_format($subtotalCustom, 0, ',', '.') }}
                                                </span>
                                            </div>
                                        @endif

                                        @if ($subtotalAddons > 0)
                                            <div class="price-detail addons-price">
                                                <span class="label">+ Add-ons:</span>
                                                <span class="value">
                                                    Rp {{ number_format($subtotalAddons, 0, ',', '.') }}
                                                </span>
                                            </div>
                                        @endif

                                        @if ($shippingFee > 0)
                                            <div class="price-detail shipping-price">
                                                <span class="label">🚚 Ongkir:</span>
                                                <span class="value">
                                                    Rp {{ number_format($shippingFee, 0, ',', '.') }}
                                                </span>
                                            </div>
                                        @elseif ($distanceKm > 0)
                                            <div class="price-detail shipping-price">
                                                <span class="label">🚚 Ongkir:</span>
                                                <span class="value text-success">GRATIS</span>
                                            </div>
                                        @endif

                                        <div class="price-divider"></div>
                                        <div class="price-total">
                                            <span class="label">Total:</span>
                                            <span class="value">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div
                            class="empty-cart"
                            id="emptyCart"
                            style="{{ count($cart ?? []) > 0 ? 'display: none;' : '' }}"
                        >
                            <i class="bi bi-cart-x"></i>
                            <h3>Keranjang Kosong</h3>
                            <p>Belum ada paket yang dipilih. Yuk booking dekorasi impian Anda!</p>
                            <a href="{{ route('frontend.index') }}#paket" class="btn btn-primary">Lihat Paket</a>
                        </div>
                    </div>

                    <!-- KOLOM KANAN: Ringkasan -->
                    <div class="col-lg-5">
                        <div class="cart-summary">
                            <h4>
                                <i class="bi bi-receipt"></i>
                                Ringkasan Pesanan
                            </h4>

                            <div class="summary-row">
                                <span>Total Harga Paket</span>
                                <span id="totalPaket">
                                    Rp {{ number_format($totals['subtotal_package'] ?? 0, 0, ',', '.') }}
                                </span>
                            </div>

                            <div class="summary-row">
                                <span>Total Add-ons</span>
                                <span id="totalAddons">
                                    Rp {{ number_format($totals['subtotal_addons'] ?? 0, 0, ',', '.') }}
                                </span>
                            </div>

                            <!-- BARIS ONGKIR -->
                            <div
                                class="summary-row"
                                id="cartShippingRow"
                                style="{{ ($totals['shipping_fee'] ?? 0) > 0 ? '' : 'display: none;' }}"
                            >
                                <span>🚚 Biaya Pengiriman</span>
                                <span id="cartShippingFee">
                                    Rp {{ number_format($totals['shipping_fee'] ?? 0, 0, ',', '.') }}
                                </span>
                            </div>

                            <div class="summary-divider"></div>

                            <div class="summary-row total">
                                <span>Total Pembayaran</span>
                                <span id="grandTotal">
                                    Rp {{ number_format($totals['grand_total'] ?? 0, 0, ',', '.') }}
                                </span>
                            </div>

                            <div class="payment-note">
                                <i class="bi bi-shield-check"></i>
                                <small>Pembayaran 100% di awal via Midtrans (QRIS, Transfer Bank, E-Wallet)</small>
                            </div>

                            @if (count($cart ?? []) > 0)
                                <form action="{{ route('frontend.checkout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary mt-3 w-100">
                                        Lanjutkan ke Pembayaran
                                        <i class="bi bi-arrow-right"></i>
                                    </button>
                                </form>

                                <form action="{{ route('frontend.cart.clear') }}" method="POST" class="mt-2">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        type="submit"
                                        class="btn btn-link text-danger w-100"
                                        onclick="return confirm('Kosongkan semua isi keranjang?')"
                                    >
                                        Kosongkan Keranjang
                                    </button>
                                </form>
                            @else
                                <button type="button" class="btn btn-primary mt-3 w-100" disabled>
                                    Lanjutkan ke Pembayaran
                                    <i class="bi bi-arrow-right"></i>
                                </button>
                            @endif

                            <div class="mt-3 text-center">
                                <a href="{{ route('frontend.index') }}#paket" class="text-muted text-decoration-none">
                                    ← Kembali Belanja
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ==================== FOOTER DENGAN LOGO ==================== -->
        <footer class="footer-section footer-batik">
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

                        <div class="social-links">
                            <a href="#"><i class="bi bi-facebook"></i></a>
                            <a href="#"><i class="bi bi-instagram"></i></a>
                            <a href="#"><i class="bi bi-whatsapp"></i></a>
                            <a href="#"><i class="bi bi-youtube"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-6 mb-md-0 mb-4">
                        <h5>Menu Cepat</h5>
                        <ul class="footer-links">
                            <li><a href="{{ route('frontend.index') }}">Beranda</a></li>
                            <li><a href="{{ route('frontend.index') }}#paket">Paket</a></li>
                            <li><a href="{{ route('frontend.index') }}#galeri">Galeri</a></li>
                            <li><a href="{{ route('frontend.index') }}#testimoni">Testimoni</a></li>
                            <li><a href="{{ route('frontend.index') }}#kontak">Kontak</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-3 col-md-6 mb-md-0 mb-4">
                        <h5>Layanan</h5>
                        <ul class="footer-links">
                            <li><a href="{{ route('frontend.index') }}#paket">Sewa Tenda</a></li>
                            <li><a href="{{ route('frontend.index') }}#paket">Dekorasi Pernikahan</a></li>
                            <li><a href="{{ route('frontend.index') }}#paket">Sewa Kursi</a></li>
                            <li><a href="{{ route('frontend.index') }}#paket">Rigging & Lighting</a></li>
                            <li><a href="{{ route('frontend.paket-custom') }}">Paket Custom</a></li>
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
                                src="https://placehold.co/60x40/2c3e50/white?text=Mandiri"
                                alt="Mandiri"
                                class="payment-logo"
                            />
                            <img
                                src="https://placehold.co/60x40/2c3e50/white?text=BRI"
                                alt="BRI"
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

                        <!-- LOGO 2 DI FOOTER -->
                        <div class="mt-3 text-center">
                            <img 
                                src="{{ asset('img_logoo/logo2.png') }}" 
                                alt="Partner Logo" 
                                class="footer-logo-img"
                                style="height: 90px; width: auto;"
                                onerror="this.style.display='none'"
                            >
                        </div>
                    </div>
                </div>

                <hr class="footer-hr" />

                <div class="row align-items-center">
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

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('js/script.js') }}?v={{ time() }}"></script>
    </body>
</html>