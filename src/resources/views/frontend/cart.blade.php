<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Booking - Didin Tenda Decoration</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
</head>
<body>

    <!-- ==================== NAVBAR SEDERHANA ==================== -->
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
                    <a href="{{ route('frontend.cart') }}" class="user-menu-link active" data-bs-toggle="tooltip" title="Keranjang Booking">
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

    <!-- ==================== CART SECTION ==================== -->
    <section class="cart-section">
        <div class="container">
            <div class="cart-header">
                <h1><i class="bi bi-cart3"></i> Keranjang Booking</h1>
                <p>Review pesanan Anda sebelum melanjutkan ke pembayaran</p>
            </div>

            <div class="row g-4">
                <!-- KOLOM KIRI: Daftar Item -->
                <div class="col-lg-7">
                    <div class="cart-items-container" id="cartItemsContainer">
                        <!-- Item akan diisi oleh JavaScript -->
                    </div>

                    <div class="empty-cart" id="emptyCart" style="display: none;">
                        <i class="bi bi-cart-x"></i>
                        <h3>Keranjang Kosong</h3>
                        <p>Belum ada paket yang dipilih. Yuk booking dekorasi impian Anda!</p>
                        <a href="{{ route('frontend.index') }}#paket" class="btn btn-primary">Lihat Paket</a>
                    </div>
                </div>

                <!-- KOLOM KANAN: Ringkasan -->
                <div class="col-lg-5">
                    <div class="cart-summary">
                        <h4><i class="bi bi-receipt"></i> Ringkasan Pesanan</h4>
                        
                        <div class="summary-row">
                            <span>Total Harga Paket</span>
                            <span id="totalPaket">Rp 0</span>
                        </div>
                        
                        <div class="summary-row">
                            <span>Total Add-ons</span>
                            <span id="totalAddons">Rp 0</span>
                        </div>
                        
                        <!-- BARIS ONGKIR -->
                        <div class="summary-row" id="cartShippingRow" style="display: none;">
                            <span>🚚 Biaya Pengiriman</span>
                            <span id="cartShippingFee">Rp 0</span>
                        </div>
                        
                        <div class="summary-divider"></div>
                        
                        <div class="summary-row total">
                            <span>Total Pembayaran</span>
                            <span id="grandTotal">Rp 0</span>
                        </div>
                        
                        <div class="payment-note">
                            <i class="bi bi-shield-check"></i>
                            <small>Pembayaran 100% di awal via Midtrans (QRIS, Transfer Bank, E-Wallet)</small>
                        </div>
                        
                        <button class="btn-checkout w-100" id="checkoutBtn">
                            Lanjutkan ke Pembayaran <i class="bi bi-arrow-right"></i>
                        </button>
                        
                        <a href="{{ route('frontend.index') }}#paket" class="btn-back-shopping">
                            <i class="bi bi-arrow-left"></i> Kembali Belanja
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== MODAL ADD-ONS ==================== -->
    <div class="modal fade" id="addonsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-plus-circle"></i> Tambah Add-ons
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <p class="text-muted mb-3">Pilih perlengkapan tambahan untuk acara Anda</p>
                    
                    <div class="addons-option" data-addon-id="kursi" data-addon-name="Kursi Futura Tambahan" data-addon-price="500000">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="addon_kursi">
                            <label class="form-check-label" for="addon_kursi">
                                <div>
                                    <strong>Kursi Futura Tambahan</strong>
                                    <small class="d-block text-muted">+50 kursi futura</small>
                                </div>
                                <span class="addon-price">+Rp 500.000</span>
                            </label>
                        </div>
                    </div>
                    
                    <div class="addons-option" data-addon-id="lampu" data-addon-name="Lampu Hias" data-addon-price="200000">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="addon_lampu">
                            <label class="form-check-label" for="addon_lampu">
                                <div>
                                    <strong>Lampu Hias</strong>
                                    <small class="d-block text-muted">Dekorasi lampu hias 10 titik</small>
                                </div>
                                <span class="addon-price">+Rp 200.000</span>
                            </label>
                        </div>
                    </div>
                    
                    <div class="addons-option" data-addon-id="karpet" data-addon-name="Karpet Merah" data-addon-price="300000">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="addon_karpet">
                            <label class="form-check-label" for="addon_karpet">
                                <div>
                                    <strong>Karpet Merah</strong>
                                    <small class="d-block text-muted">Karpet merah premium 5x2 meter</small>
                                </div>
                                <span class="addon-price">+Rp 300.000</span>
                            </label>
                        </div>
                    </div>
                    
                    <div class="addons-option" data-addon-id="panggung" data-addon-name="Panggung" data-addon-price="800000">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="addon_panggung">
                            <label class="form-check-label" for="addon_panggung">
                                <div>
                                    <strong>Panggung</strong>
                                    <small class="d-block text-muted">Panggung ukuran 4x4 meter</small>
                                </div>
                                <span class="addon-price">+Rp 800.000</span>
                            </label>
                        </div>
                    </div>
                    
                    <div class="addons-option" data-addon-id="blower" data-addon-name="Kipas Blower" data-addon-price="150000">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="addon_blower">
                            <label class="form-check-label" for="addon_blower">
                                <div>
                                    <strong>Kipas Blower</strong>
                                    <small class="d-block text-muted">Pendingin udara outdoor</small>
                                </div>
                                <span class="addon-price">+Rp 150.000</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="saveAddonsBtn">Simpan Add-ons</button>
                </div>
            </div>
        </div>
    </div>

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

    <!-- BACK TO TOP BUTTON -->
    <button id="backToTop" class="back-to-top" title="Kembali ke atas">
        <i class="bi bi-arrow-up"></i>
    </button>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JS -->
    <script src="{{ asset('js/cart.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>