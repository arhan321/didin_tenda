<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Pesanan Saya - Didin Tenda Decoration</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pesanan.css') }}">
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
                    <a href="{{ route('frontend.cart') }}" class="user-menu-link" data-bs-toggle="tooltip" title="Keranjang Booking">
                        <i class="bi bi-cart3"></i>
                        <span class="menu-badge" id="cartCount">{{ $cartCount ?? 0 }}</span>
                    </a>

                    <a href="{{ route('frontend.pesanan') }}" class="user-menu-link active" data-bs-toggle="tooltip" title="Pesanan Saya">
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

    <!-- ==================== PESANAN SECTION ==================== -->
    <section class="pesanan-section">
        <div class="container">
            <!-- Header -->
            <div class="pesanan-header">
                <h1><i class="bi bi-receipt"></i> Pesanan Saya</h1>
                <p>Kelola dan lacak semua pesanan dekorasi acara Anda</p>
            </div>

            @if(session('success'))
                <div class="alert alert-success mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger mb-4">
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger mb-4">
                    <strong>Terjadi kesalahan:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Filter & Search -->
            <div class="filter-section">
                <div class="filter-buttons">
                    <button class="filter-btn active" data-filter="all">Semua</button>
                    <button class="filter-btn" data-filter="active">Aktif</button>
                    <button class="filter-btn" data-filter="completed">Selesai</button>
                    <button class="filter-btn" data-filter="cancelled">Dibatalkan</button>
                </div>

                <div class="search-box">
                    <i class="bi bi-search"></i>
                    <input type="text" id="searchInput" placeholder="Cari pesanan...">
                </div>
            </div>

            <!-- Real Data Alert -->
            <div class="demo-alert">
                <i class="bi bi-info-circle-fill"></i>
                <div>
                    <strong>Data Pesanan Real</strong><br>
                    <small>
                        Pesanan ditampilkan dari database sesuai akun yang sedang login.
                        Pembayaran menggunakan Midtrans Snap dan review bisa diberikan setelah pesanan selesai.
                    </small>
                </div>
            </div>

            <!-- Pesanan Container -->
            <div id="ordersContainer" class="orders-container">
                <!-- Akan diisi oleh JavaScript -->
            </div>

            <!-- Empty State -->
            <div id="emptyOrders" class="empty-orders" style="display: none;">
                <i class="bi bi-inbox"></i>
                <h3>Belum Ada Pesanan</h3>
                <p>Anda belum memiliki pesanan. Yuk booking dekorasi impian Anda!</p>
                <a href="{{ route('frontend.index') }}#paket" class="btn btn-primary">Lihat Paket</a>
            </div>
        </div>
    </section>

    <!-- ==================== MODAL DETAIL PESANAN ==================== -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-receipt"></i> Detail Pesanan
                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body" id="detailModalBody">
                    <!-- Akan diisi JavaScript -->
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- ==================== MODAL RATING ==================== -->
    <div class="modal fade" id="ratingModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-star-fill text-warning"></i> Beri Rating & Review
                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <p class="text-muted small mb-3">
                        Pilih rating dan tuliskan pengalaman Anda menggunakan layanan Didin Tenda Decoration.
                    </p>

                    <div class="rating-stars">
                        <i class="bi bi-star" data-rating="1"></i>
                        <i class="bi bi-star" data-rating="2"></i>
                        <i class="bi bi-star" data-rating="3"></i>
                        <i class="bi bi-star" data-rating="4"></i>
                        <i class="bi bi-star" data-rating="5"></i>
                    </div>

                    <textarea
                        id="reviewText"
                        class="form-control mt-3"
                        rows="4"
                        placeholder="Tulis review Anda..."
                    ></textarea>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="submitRatingBtn">
                        <i class="bi bi-send"></i> Kirim Rating
                    </button>
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

                    <p class="mt-3 small text-white-50">
                        <i class="bi bi-shield-check"></i>
                        Transaksi aman via Midtrans
                    </p>
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

    <!-- ==================== DATA DARI LARAVEL ==================== -->
    <script>
        window.DIDIN_ORDERS = @json($ordersForJs ?? []);

        window.DIDIN_PESANAN_ROUTES = {
            paketIndex: @json(route('frontend.index') . '#paket'),
            cart: @json(route('frontend.cart')),
            pesanan: @json(route('frontend.pesanan')),
            history: @json(route('frontend.history')),
        };

        window.DIDIN_MIDTRANS_CONFIG = {
            isProduction: @json((bool) config('midtrans.is_production', false)),
            clientKey: @json(config('midtrans.client_key')),
        };
    </script>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <!-- Midtrans Snap JS -->
    <script
        src="{{ config('midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}"
        data-client-key="{{ config('midtrans.client_key') }}">
    </script>

    <!-- Custom JS -->
    <script src="{{ asset('js/script.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/pesanan.js') }}?v={{ time() }}"></script>
</body>
</html>