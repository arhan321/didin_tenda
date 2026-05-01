<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>History Booking - Didin Tenda Decoration</title>

        <!-- Bootstrap 5 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />

        <!-- Bootstrap Icons -->
        <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
        />

        <!-- AOS Animation -->
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />

        <!-- Custom CSS -->
        <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
        <link rel="stylesheet" href="{{ asset('css/history.css') }}" />
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
                            class="user-menu-link active"
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

        <!-- ==================== HISTORY SECTION ==================== -->
        <section class="history-section">
            <div class="container">
                <!-- Header -->
                <div class="history-header">
                    <h1>
                        <i class="bi bi-clock-history"></i>
                        History Booking
                    </h1>
                    <p>Riwayat lengkap semua pesanan dekorasi acara Anda</p>
                </div>

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

                <!-- Filter & Search -->
                <div class="filter-section">
                    <div class="filter-buttons">
                        <button class="filter-btn active" data-filter="all">Semua</button>
                        <button class="filter-btn" data-filter="completed">Selesai</button>
                        <button class="filter-btn" data-filter="cancelled">Dibatalkan</button>
                    </div>

                    <div class="search-box">
                        <i class="bi bi-search"></i>
                        <input type="text" id="searchInput" placeholder="Cari history..." />
                    </div>
                </div>

                <!-- Statistik -->
                <div class="history-stats">
                    <div class="stat-card">
                        <i class="bi bi-check-circle-fill"></i>
                        <div>
                            <h3 id="totalCompleted">0</h3>
                            <p>Pesanan Selesai</p>
                        </div>
                    </div>

                    <div class="stat-card">
                        <i class="bi bi-x-circle-fill"></i>
                        <div>
                            <h3 id="totalCancelled">0</h3>
                            <p>Pesanan Dibatalkan</p>
                        </div>
                    </div>

                    <div class="stat-card">
                        <i class="bi bi-cash-stack"></i>
                        <div>
                            <h3 id="totalSpent">Rp 0</h3>
                            <p>Total Belanja</p>
                        </div>
                    </div>
                </div>

                <!-- History Container -->
                <div id="historyContainer" class="history-container">
                    <!-- Akan diisi oleh JavaScript -->
                </div>

                <!-- Empty State -->
                <div id="emptyHistory" class="empty-history" style="display: none">
                    <i class="bi bi-inbox"></i>
                    <h3>Belum Ada History</h3>
                    <p>Anda belum memiliki riwayat pesanan selesai atau dibatalkan.</p>
                    <a href="{{ route('frontend.index') }}#paket" class="btn btn-primary">Lihat Paket</a>
                </div>
            </div>
        </section>

        <!-- ==================== MODAL DETAIL HISTORY ==================== -->
        <div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="bi bi-clock-history"></i>
                            Detail History
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body" id="detailModalBody">
                        <!-- Akan diisi JavaScript -->
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-primary" id="invoiceFromDetailBtn">
                            <i class="bi bi-download"></i>
                            Invoice
                        </button>
                        <button type="button" class="btn btn-primary" id="reorderFromDetailBtn">
                            <i class="bi bi-arrow-repeat"></i>
                            Pesan Lagi
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
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
                                <a href="{{ route('frontend.pesanan') }}">Pesanan Aktif</a>
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

        <!-- BACK TO TOP -->
        <button id="backToTop" class="back-to-top" title="Kembali ke atas">
            <i class="bi bi-arrow-up"></i>
        </button>

        <script>
            window.DIDIN_HISTORY = @json($historyForJs ?? [])
            window.DIDIN_HISTORY_ROUTES = {
                paketIndex: @json(route('frontend.index') . '#paket'),
                paketDetail: @json(route('frontend.paket')),
                cart: @json(route('frontend.cart')),
                pesanan: @json(route('frontend.pesanan')),
                history: @json(route('frontend.history')),
            }
        </script>

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

        <!-- Custom JS -->
        <script src="{{ asset('js/script.js') }}?v={{ time() }}"></script>
        <script src="{{ asset('js/history.js') }}?v={{ time() }}"></script>
    </body>
</html>
