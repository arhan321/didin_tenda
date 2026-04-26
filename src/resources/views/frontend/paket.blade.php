<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Paket - Didin Tenda Decoration</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/paket.css') }}">
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

            <div class="collapse navbar-collapse" id="navbarNav">
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
                    <a href="{{ route('frontend.cart') }}" class="user-menu-link" data-bs-toggle="tooltip" title="Keranjang Booking">
                        <i class="bi bi-cart3"></i>
                        <span class="menu-badge" id="cartCount">0</span>
                    </a>

                    <a href="{{ route('frontend.pesanan') }}" class="user-menu-link" data-bs-toggle="tooltip" title="Pesanan Saya">
                        <i class="bi bi-receipt"></i>
                    </a>

                    <a href="{{ route('frontend.history') }}" class="user-menu-link" data-bs-toggle="tooltip" title="History Booking">
                        <i class="bi bi-clock-history"></i>
                    </a>

                    <a href="{{ route('frontend.profile') }}" class="user-menu-link" data-bs-toggle="tooltip" title="Akun Saya">
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
                    <li class="breadcrumb-item active" id="paketNameBreadcrumb">Paket</li>
                </ol>
            </nav>

            <div class="row g-4">
                <!-- KOLOM KIRI: Gambar & Galeri -->
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="paket-gallery">
                        <img src="" alt="Main Image" class="img-fluid main-image" id="mainImage">

                        <div class="gallery-thumbs mt-3" id="galleryThumbs">
                            <!-- Thumbnail akan diisi JS -->
                        </div>
                    </div>
                </div>

                <!-- KOLOM KANAN: Info Paket & Form Booking -->
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="paket-info">
                        <h1 id="paketTitle">Paket Hemat</h1>

                        <div class="paket-rating">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <span class="ms-2">(128 ulasan)</span>
                        </div>

                        <div class="paket-price-large" id="paketPrice">Rp 2.500.000</div>

                        <p class="paket-description" id="paketDesc"></p>

                        <!-- Fitur Paket -->
                        <div class="paket-features-list" id="paketFeatures">
                            <!-- Fitur akan diisi JS -->
                        </div>

                        <!-- Form Booking -->
                        <div class="booking-form">
                            <h5><i class="bi bi-calendar-check"></i> Atur Booking</h5>
                            
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label">
                                        Tanggal Acara <span class="text-danger">*</span>
                                    </label>
                                    <input type="date" class="form-control" id="eventDate" min="">
                                    <small class="text-muted">Pilih tanggal acara Anda</small>
                                </div>
                                
                                <div class="col-12">
                                    <label class="form-label">
                                        Nama Lokasi Acara <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" id="eventLocation" placeholder="Contoh: Gedung Serbaguna, Jakarta">
                                </div>
                                
                                <!-- ========== TAMBAHAN ALAMAT LENGKAP & ONGKIR ========== -->
                                <div class="col-12">
                                    <label class="form-label">
                                        Alamat Lengkap Acara <span class="text-danger">*</span>
                                    </label>
                                    <textarea class="form-control" id="eventFullAddress" rows="2" placeholder="Masukkan alamat lengkap acara (Jalan, RT/RW, Kelurahan, Kecamatan, Kota)"></textarea>
                                    <small class="text-muted">Alamat akan digunakan untuk menghitung biaya pengiriman</small>
                                </div>

                                <!-- Tampilan Jarak & Ongkir -->
                                <div class="shipping-info mt-2" id="shippingInfo" style="display: none;">
                                    <div class="shipping-card">
                                        <div class="shipping-distance">
                                            <i class="bi bi-geo-alt"></i>
                                            <span>Jarak dari Lokasi Kami: <strong id="distanceValue">0</strong> km</span>
                                        </div>

                                        <div class="shipping-fee">
                                            <i class="bi bi-truck"></i>
                                            <span>Biaya Pengiriman: <strong id="shippingFeeValue">Rp 0</strong></span>
                                        </div>

                                        <div class="shipping-note" id="shippingNote"></div>
                                    </div>
                                </div>

                                <!-- Tombol Cek Ongkir -->
                                <div class="col-12">
                                    <button type="button" class="btn btn-outline-primary w-100" id="checkShippingBtn">
                                        <i class="bi bi-geo-alt"></i> Cek Jarak & Ongkir
                                    </button>
                                </div>
                                <!-- ========== END ONGKIR ========== -->
                                
                                <div class="col-12">
                                    <label class="form-label">
                                        Nama Lengkap <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" id="customerName" placeholder="Nama lengkap Anda">
                                </div>
                                
                                <div class="col-12">
                                    <label class="form-label">
                                        Nomor WhatsApp <span class="text-danger">*</span>
                                    </label>
                                    <input type="tel" class="form-control" id="customerPhone" placeholder="0812-3456-7890">
                                </div>
                            </div>

                            <!-- Add-ons Section -->
                            <div class="addons-section mt-4">
                                <h5><i class="bi bi-plus-circle"></i> Tambahan (Add-ons)</h5>
                                <div class="row g-2" id="addonsContainer">
                                    <!-- Add-ons akan diisi JS -->
                                </div>
                            </div>

                            <!-- Ringkasan Harga -->
                            <div class="price-summary">
                                <div class="summary-row">
                                    <span>Harga Paket</span>
                                    <span id="summaryPaketPrice">Rp 2.500.000</span>
                                </div>

                                <div id="addonsSummary">
                                    <!-- Add-ons akan muncul di sini -->
                                </div>

                                <div id="shippingSummary">
                                    <!-- Ongkir akan muncul di sini -->
                                </div>

                                <div class="summary-row total">
                                    <span>Total Pembayaran</span>
                                    <span id="summaryTotal">Rp 2.500.000</span>
                                </div>

                                <div class="payment-note">
                                    <i class="bi bi-shield-check"></i>
                                    <small>Pembayaran 100% di awal via Midtrans (QRIS, Transfer Bank, E-Wallet)</small>
                                </div>
                            </div>

                            <!-- Tombol Aksi -->
                            <div class="action-buttons">
                                <button type="button" class="btn btn-primary btn-lg w-100" id="addToCartBtn">
                                    <i class="bi bi-cart-plus"></i> Tambah ke Keranjang
                                </button>

                                <button type="button" class="btn btn-outline-primary w-100 mt-2" id="bookNowBtn">
                                    <i class="bi bi-credit-card"></i> Booking & Bayar Langsung
                                </button>
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
                <div class="col-lg-4 mb-4 mb-lg-0">
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

                <div class="col-lg-2 col-md-6 mb-4 mb-md-0">
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

                <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
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
                        <img src="https://placehold.co/60x40/2c3e50/white?text=BCA" alt="BCA" class="payment-logo">
                        <img src="https://placehold.co/60x40/2c3e50/white?text=QRIS" alt="QRIS" class="payment-logo">
                        <img src="https://placehold.co/60x40/2c3e50/white?text=GoPay" alt="GoPay" class="payment-logo">
                    </div>
                </div>
            </div>

            <hr class="footer-hr">

            <div class="row">
                <div class="col-md-6 text-center text-md-start">
                    <p class="copyright">© 2026 Didin Tenda Decoration. All rights reserved.</p>
                </div>

                <div class="col-md-6 text-center text-md-end">
                    <p class="developer">Developed for Tugas Akhir - Muhamad Darlan (20220803005)</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- BACK TO TOP -->
    <button id="backToTop" class="back-to-top" title="Kembali ke atas">
        <i class="bi bi-arrow-up"></i>
    </button>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- AOS Animation JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <!-- Custom JS -->
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('js/paket.js') }}"></script>
</body>
</html>