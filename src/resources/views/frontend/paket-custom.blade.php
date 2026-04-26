<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paket Custom - Didin Tenda Decoration</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/paket-custom.css') }}">
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

            <div class="row g-4">
                <!-- KOLOM KIRI: Form Custom Items -->
                <div class="col-lg-7" data-aos="fade-right">
                    <div class="custom-form">
                        <h3><i class="bi bi-pencil-square"></i> Buat Paket Custom</h3>
                        <p class="text-muted mb-4">Pilih item dekorasi sesuai kebutuhan acara Anda</p>
                        
                        <!-- ===== DATA DIRI SECTION ===== -->
                        <div class="form-section">
                            <h5><i class="bi bi-person"></i> Data Diri</h5>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="customerName" placeholder="Nama lengkap Anda">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Nomor WhatsApp <span class="text-danger">*</span></label>
                                    <input type="tel" class="form-control" id="customerPhone" placeholder="0812-3456-7890">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Tanggal Acara <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="eventDate" min="">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Nama Lokasi Acara <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="eventLocation" placeholder="Contoh: Gedung Serbaguna">
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Alamat Lengkap Acara <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="eventFullAddress" rows="2" placeholder="Masukkan alamat lengkap acara (Jalan, RT/RW, Kelurahan, Kecamatan, Kota)"></textarea>
                                    <small class="text-muted">Alamat akan digunakan untuk menghitung biaya pengiriman</small>
                                </div>
                            </div>
                        </div>

                        <!-- ===== ITEM CUSTOM ===== -->
                        <div class="form-section">
                            <h5><i class="bi bi-grid"></i> Pilih Item Dekorasi</h5>
                            
                            <!-- Item 1: Tenda Dekorasi -->
                            <div class="custom-item-row">
                                <div class="custom-item-img">
                                    <img 
                                        src="{{ asset('assets/images/custom/tenda.png') }}" 
                                        alt="Tenda Dekorasi"
                                        onerror="this.src='https://placehold.co/60x60/2c7be5/white?text=Tenda'"
                                    >
                                </div>

                                <div class="custom-item-detail">
                                    <h6>Tenda Dekorasi</h6>
                                    <p class="price">Rp 65.000 / meter</p>
                                </div>

                                <div class="custom-item-qty">
                                    <button type="button" class="qty-btn-sm minus" onclick="updateCustomQty('tenda', -1)">-</button>
                                    <input type="number" id="qty-tenda" class="qty-input-sm" value="0" min="0" step="1" onchange="updateCustomQtyDirect('tenda')">
                                    <button type="button" class="qty-btn-sm plus" onclick="updateCustomQty('tenda', 1)">+</button>
                                    <span class="item-total-sm" id="total-tenda">Rp 0</span>
                                </div>
                            </div>

                            <!-- Item 2: Panggung Rigging -->
                            <div class="custom-item-row">
                                <div class="custom-item-img">
                                    <img 
                                        src="{{ asset('assets/images/custom/panggung.png') }}" 
                                        alt="Panggung Rigging"
                                        onerror="this.src='https://placehold.co/60x60/e67e22/white?text=Panggung'"
                                    >
                                </div>

                                <div class="custom-item-detail">
                                    <h6>Panggung Rigging</h6>
                                    <p class="price">Rp 50.000 / meter (maks. 64m)</p>
                                </div>

                                <div class="custom-item-qty">
                                    <button type="button" class="qty-btn-sm minus" onclick="updateCustomQty('panggung', -1)">-</button>
                                    <input type="number" id="qty-panggung" class="qty-input-sm" value="0" min="0" max="64" step="1" onchange="updateCustomQtyDirect('panggung')">
                                    <button type="button" class="qty-btn-sm plus" onclick="updateCustomQty('panggung', 1)">+</button>
                                    <span class="item-total-sm" id="total-panggung">Rp 0</span>
                                </div>
                            </div>

                            <!-- Item 3: Meja Kotak Hajatan -->
                            <div class="custom-item-row">
                                <div class="custom-item-img">
                                    <img 
                                        src="{{ asset('assets/images/custom/meja-kotak.png') }}" 
                                        alt="Meja Kotak Hajatan"
                                        onerror="this.src='https://placehold.co/60x60/27ae60/white?text=Meja+Kotak'"
                                    >
                                </div>

                                <div class="custom-item-detail">
                                    <h6>Meja Kotak Hajatan</h6>
                                    <p class="price">Rp 30.000 / meter</p>
                                </div>

                                <div class="custom-item-qty">
                                    <button type="button" class="qty-btn-sm minus" onclick="updateCustomQty('mejakotak', -1)">-</button>
                                    <input type="number" id="qty-mejakotak" class="qty-input-sm" value="0" min="0" step="1" onchange="updateCustomQtyDirect('mejakotak')">
                                    <button type="button" class="qty-btn-sm plus" onclick="updateCustomQty('mejakotak', 1)">+</button>
                                    <span class="item-total-sm" id="total-mejakotak">Rp 0</span>
                                </div>
                            </div>

                            <!-- Item 4: Meja Bulat -->
                            <div class="custom-item-row">
                                <div class="custom-item-img">
                                    <img 
                                        src="{{ asset('assets/images/custom/meja-bulat.png') }}" 
                                        alt="Meja Bulat"
                                        onerror="this.src='https://placehold.co/60x60/8e44ad/white?text=Meja+Bulat'"
                                    >
                                </div>

                                <div class="custom-item-detail">
                                    <h6>Meja Bulat</h6>
                                    <p class="price">Rp 50.000 / pcs</p>
                                </div>

                                <div class="custom-item-qty">
                                    <button type="button" class="qty-btn-sm minus" onclick="updateCustomQty('mejabulat', -1)">-</button>
                                    <input type="number" id="qty-mejabulat" class="qty-input-sm" value="0" min="0" step="1" onchange="updateCustomQtyDirect('mejabulat')">
                                    <button type="button" class="qty-btn-sm plus" onclick="updateCustomQty('mejabulat', 1)">+</button>
                                    <span class="item-total-sm" id="total-mejabulat">Rp 0</span>
                                </div>
                            </div>

                            <!-- Item 5: Sound System -->
                            <div class="custom-item-row">
                                <div class="custom-item-img">
                                    <img 
                                        src="{{ asset('assets/images/custom/soundsystem.png') }}" 
                                        alt="Sound System"
                                        onerror="this.src='https://placehold.co/60x60/c0392b/white?text=Sound'"
                                    >
                                </div>

                                <div class="custom-item-detail">
                                    <h6>Sound System</h6>
                                    <p class="price">Rp 3.000.000 / set</p>
                                </div>

                                <div class="custom-item-qty">
                                    <button type="button" class="qty-btn-sm minus" onclick="updateCustomQty('soundsystem', -1)">-</button>
                                    <input type="number" id="qty-soundsystem" class="qty-input-sm" value="0" min="0" step="1" onchange="updateCustomQtyDirect('soundsystem')">
                                    <button type="button" class="qty-btn-sm plus" onclick="updateCustomQty('soundsystem', 1)">+</button>
                                    <span class="item-total-sm" id="total-soundsystem">Rp 0</span>
                                </div>
                            </div>
                        </div>

                        <!-- ===== ADD-ONS SECTION ===== -->
                        <div class="form-section">
                            <h5><i class="bi bi-plus-circle"></i> Tambahan (Add-ons)</h5>
                            <div class="row g-2" id="addonsContainer">
                                <!-- Add-ons akan diisi JS -->
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

                <!-- KOLOM KANAN: Ringkasan & Ongkir -->
                <div class="col-lg-5" data-aos="fade-left">
                    <div class="custom-summary">
                        <h4><i class="bi bi-receipt"></i> Ringkasan Pesanan</h4>
                        
                        <!-- Daftar Item Custom -->
                        <div class="summary-items" id="summaryItems">
                            <p class="text-muted small">Belum ada item dipilih</p>
                        </div>

                        <!-- Add-ons Summary -->
                        <div id="addonsSummaryCustom" class="summary-addons"></div>

                        <!-- Shipping Info -->
                        <div class="shipping-section">
                            <div class="shipping-info-custom" id="shippingInfo" style="display: none;">
                                <div class="shipping-card">
                                    <div class="shipping-distance">
                                        <i class="bi bi-geo-alt"></i>
                                        <span>Jarak: <strong id="distanceValue">0</strong> km</span>
                                    </div>

                                    <div class="shipping-fee">
                                        <i class="bi bi-truck"></i>
                                        <span>Ongkir: <strong id="shippingFeeValue">Rp 0</strong></span>
                                    </div>

                                    <div class="shipping-note" id="shippingNote"></div>
                                </div>
                            </div>

                            <button type="button" class="btn btn-outline-primary w-100 mt-3" id="checkShippingBtn">
                                <i class="bi bi-geo-alt"></i> Cek Jarak & Ongkir
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
    <script src="{{ asset('js/paket-custom.js') }}"></script>
</body>
</html>