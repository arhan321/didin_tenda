<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Didin Tenda Decoration - Sewa Tenda & Dekorasi Event Tangerang</title>
    <meta name="description" content="Booking online 24/7, cek ketersediaan real-time, pembayaran aman via Midtrans. 5000+ acara terselenggara sejak 1996.">

    <meta property="og:title" content="Didin Tenda Decoration - Sewa Tenda & Dekorasi Event Tangerang" />
    <meta property="og:description" content="✅ Booking online 24/7 | ✅ Cek ketersediaan real-time | ✅ Pembayaran aman via Midtrans | 5000+ acara terselenggara sejak 1996" />
    <meta property="og:image" content="{{ asset('assets/images/OGIMAGE.png') }}" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="630" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="Didin Tenda Decoration" />
    <meta property="og:locale" content="id_ID" />
    <meta name="twitter:card" content="summary_large_image" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
</head>
<body>

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
                <li class="nav-item"><a class="nav-link active" href="{{ route('frontend.index') }}#beranda">Beranda</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('frontend.index') }}#paket">Paket</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('frontend.index') }}#galeri">Galeri</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('frontend.index') }}#testimoni">Testimoni</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('frontend.index') }}#faq">FAQ</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('frontend.index') }}#kontak">Kontak</a></li>
            </ul>

            <div class="navbar-user-menu d-flex align-items-center ms-lg-3">
                <a href="{{ route('frontend.cart') }}" class="user-menu-link" data-bs-toggle="tooltip" title="Keranjang Booking">
                    <i class="bi bi-cart3"></i>
                    <span class="menu-badge" data-server-cart-count="{{ $cartCount ?? 0 }}">{{ $cartCount ?? 0 }}</span>
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

                <span class="menu-divider"></span>

                @guest
                    <div class="d-flex">
                        <a href="#" class="btn btn-outline-light me-2 btn-sm" data-bs-toggle="modal" data-bs-target="#loginRegisterModal">Login</a>
                        <a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#loginRegisterModal">Daftar</a>
                    </div>
                @endguest

                @auth
                    <div class="d-flex align-items-center gap-2">
                        <span class="text-white small">{{ auth()->user()->name }}</span>
                        <form action="{{ route('frontend.logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-light btn-sm">Logout</button>
                        </form>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>

@if(session('success'))
    <div class="alert alert-success position-fixed top-0 start-50 translate-middle-x mt-5 z-3 shadow" style="margin-top: 90px !important;">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger position-fixed top-0 start-50 translate-middle-x mt-5 z-3 shadow" style="margin-top: 90px !important;">
        {{ session('error') }}
    </div>
@endif

<section id="beranda" class="hero-section">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-lg-6" data-aos="fade-right">
                <h5 class="hero-subtitle">Sejak 1996 • Terpercaya</h5>
                <h1 class="hero-title">Sewakan Tenda & Dekorasi <span class="text-primary">Impian</span> untuk Acara Istimewa Anda</h1>
                <p class="hero-description">Booking online 24/7, cek ketersediaan real-time, dan pembayaran aman via berbagai metode. Wujudkan acara impian bersama Didin Tenda Decoration.</p>
                <div class="hero-buttons">
                    <a href="{{ route('frontend.index') }}#paket" class="btn btn-primary btn-lg me-3">Lihat Paket</a>
                    <a href="{{ route('frontend.index') }}#kontak" class="btn btn-outline-dark btn-lg">Hubungi Kami</a>
                </div>

                <div class="hero-stats-wrapper">
                    <div class="hero-stats mt-5">
                        <div class="row g-2">
                            <div class="col-4"><div class="stat-item"><div class="stat-number">28+</div><div class="stat-label">Tahun Pengalaman</div></div></div>
                            <div class="col-4"><div class="stat-item"><div class="stat-number">5.000+</div><div class="stat-label">Acara Terselenggara</div></div></div>
                            <div class="col-4"><div class="stat-item"><div class="stat-number">385+</div><div class="stat-label">Transaksi/Tahun</div></div></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6" data-aos="fade-left">
                <div class="hero-image-wrapper">
                    <img src="{{ asset('assets/images/AWAL.png') }}" alt="Dekorasi Tenda" class="img-fluid hero-image">
                    <div class="hero-card">
                        <i class="bi bi-shield-check text-primary"></i>
                        <div>
                            <strong>Pembayaran Aman</strong>
                            <small>100% Lunas di Awal</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="hero-wave">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 155">
            <path fill="#ffffff" fill-opacity="1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,154.7C960,171,1056,181,1152,170.7C1248,160,1344,128,1392,112L1440,96L1440,320L0,320Z"></path>
        </svg>
    </div>
</section>

<section id="quick-check" class="quick-check-section">
    <div class="container">
        <div class="quick-check-card" data-aos="zoom-in" data-quick-check-url="{{ route('frontend.quick-check') }}" data-paket-url="{{ route('frontend.paket') }}">
            <h3 class="text-center mb-4">Cek Ketersediaan & Harga</h3>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Tanggal Acara</label>
                    <input type="date" class="form-control form-control-lg" id="quickEventDate" min="{{ now()->toDateString() }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Pilih Paket</label>
                    <select class="form-select form-select-lg" id="quickPackage">
                        <option selected value="">-- Pilih Paket --</option>
                        @foreach($packages as $package)
                            <option value="{{ $package->id }}">{{ $package->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">&nbsp;</label>
                    <button class="btn btn-primary btn-lg w-100" id="quickCheckBtn">Cek Ketersediaan</button>
                </div>
            </div>
            <p class="text-center mt-3 text-muted small">
                <i class="bi bi-info-circle"></i> Hasil akan ditampilkan secara real-time
            </p>
        </div>
    </div>
</section>

<section id="paket" class="paket-section">
    <div class="container">
        <div class="section-header text-center" data-aos="fade-up">
            <h5 class="section-subtitle">Layanan Kami</h5>
            <h2 class="section-title">Paket Dekorasi <span class="text-primary">Terlengkap</span></h2>
            <p class="section-description">Pilih paket yang sesuai dengan kebutuhan acara Anda</p>
        </div>

        @if($packages->count() === 0)
            <div class="alert alert-warning text-center">
                Data paket belum tersedia. Silakan isi tabel <strong>packages</strong> dan <strong>package_items</strong> terlebih dahulu.
            </div>
        @endif

        <div class="row g-4">
            @foreach($packages as $index => $package)
                @php
                    $image = $package->main_image ?: 'https://placehold.co/400x250/3498db/white?text=' . urlencode($package->name);
                    $imageUrl = str_starts_with($image, 'http') ? $image : asset($image);
                @endphp

                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="{{ ($index + 1) * 100 }}">
                    <div class="paket-card">
                        @if($package->badge)
                            <div class="paket-badge">{{ $package->badge }}</div>
                        @elseif($package->is_popular)
                            <div class="paket-badge">Best Seller</div>
                        @endif

                        <img src="{{ $imageUrl }}" alt="{{ $package->name }}" class="img-fluid">

                        <div class="paket-content">
                            <h3>{{ $package->name }}</h3>
                            <p class="paket-desc">{{ $package->short_description }}</p>

                            <div class="paket-features">
                                @foreach($package->items->take(4) as $item)
                                    <p>
                                        <i class="bi bi-check-circle-fill text-primary"></i>
                                        {{ $item->name }}
                                        @if($item->quantity)
                                            {{ $item->quantity }} {{ $item->unit }}
                                        @endif
                                    </p>
                                @endforeach
                            </div>

                            <div class="paket-price">
                                <h4>Rp {{ number_format($package->price, 0, ',', '.') }}</h4>
                                <small>/{{ $package->price_unit }}</small>
                            </div>

                            <a href="{{ route('frontend.paket', ['id' => $package->slug]) }}" class="btn btn-outline-primary w-100 mt-2">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="500">
                <div class="paket-card">
                    <div class="paket-badge" style="background: linear-gradient(135deg, #f39c12, #e67e22);">Custom</div>
                    <img src="https://placehold.co/400x250/e67e22/white?text=Paket+Custom" alt="Paket Custom" class="img-fluid">
                    <div class="paket-content">
                        <h3>Paket Custom</h3>
                        <p class="paket-desc">Sesuaikan dekorasi dengan kebutuhan acara Anda</p>
                        <div class="paket-features">
                            <p><i class="bi bi-check-circle-fill text-primary"></i> Pilih sesuai kebutuhan</p>
                            <p><i class="bi bi-check-circle-fill text-primary"></i> Tenda per meter</p>
                            <p><i class="bi bi-check-circle-fill text-primary"></i> Panggung rigging</p>
                            <p><i class="bi bi-check-circle-fill text-primary"></i> Meja & Sound system</p>
                        </div>
                        <div class="paket-price">
                            <h4>Mulai Rp 65.000</h4>
                            <small>/item</small>
                        </div>
                        <a href="{{ route('frontend.paket-custom') }}" class="btn btn-primary w-100">
                            <i class="bi bi-pencil-square"></i> Buat Paket Custom
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="keunggulan" class="keunggulan-section">
    <div class="container">
        <div class="section-header text-center" data-aos="fade-up">
            <h5 class="section-subtitle">Mengapa Memilih Kami</h5>
            <h2 class="section-title">Keunggulan <span class="text-primary">Didin Tenda</span></h2>
        </div>
        <div class="row g-4">
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100"><div class="keunggulan-card"><div class="keunggulan-icon"><i class="bi bi-clock-history"></i></div><h3>Booking 24/7</h3><p>Akses layanan kapan saja, di mana saja tanpa batasan waktu operasional</p></div></div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200"><div class="keunggulan-card"><div class="keunggulan-icon"><i class="bi bi-shield-lock"></i></div><h3>Pembayaran Aman</h3><p>Terintegrasi Payment Gateway Midtrans dengan enkripsi keamanan tingkat tinggi</p></div></div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300"><div class="keunggulan-card"><div class="keunggulan-icon"><i class="bi bi-calendar-check"></i></div><h3>Anti Double Booking</h3><p>Sistem kalender real-time yang mencegah pemesanan ganda di tanggal yang sama</p></div></div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400"><div class="keunggulan-card"><div class="keunggulan-icon"><i class="bi bi-calculator"></i></div><h3>Simulasi Harga</h3><p>Hitung biaya secara instan sebelum melakukan booking dan pembayaran</p></div></div>
        </div>
    </div>
</section>

<section id="cara-booking" class="cara-booking-section">
    <div class="container">
        <div class="section-header text-center" data-aos="fade-up">
            <h5 class="section-subtitle">Mudah & Cepat</h5>
            <h2 class="section-title">Cara <span class="text-primary">Booking</span></h2>
            <p class="section-description">Hanya 4 langkah mudah untuk mewujudkan acara impian Anda</p>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100"><div class="step-card"><div class="step-number">1</div><div class="step-icon"><i class="bi bi-search"></i></div><h3>Pilih Paket</h3><p>Browse katalog dan pilih paket dekorasi yang sesuai kebutuhan</p></div></div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200"><div class="step-card"><div class="step-number">2</div><div class="step-icon"><i class="bi bi-calendar-week"></i></div><h3>Cek Tanggal</h3><p>Pastikan tanggal acara Anda tersedia di kalender</p></div></div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300"><div class="step-card"><div class="step-number">3</div><div class="step-icon"><i class="bi bi-credit-card"></i></div><h3>Bayar Lunas</h3><p>Lakukan pembayaran 100% via transfer/QRIS/e-wallet</p></div></div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400"><div class="step-card"><div class="step-number">4</div><div class="step-icon"><i class="bi bi-check-circle"></i></div><h3>Konfirmasi</h3><p>Terima notifikasi instan dan booking Anda siap</p></div></div>
        </div>
    </div>
</section>

<section id="galeri" class="galeri-section">
    <div class="container">
        <div class="section-header text-center" data-aos="fade-up">
            <h5 class="section-subtitle">Portofolio</h5>
            <h2 class="section-title">Galeri <span class="text-primary">Dekorasi</span></h2>
            <p class="section-description">Beberapa hasil karya terbaik kami</p>
        </div>
        <div class="row g-3">
            @foreach([
                ['Pelaminan Mewah','Pernikahan - 2025','3498db','white'],
                ['Tenda Akbar','Acara Kantor - 2025','e74c3c','white'],
                ['Dekorasi Ulang Tahun','Birthday Party - 2025','2ecc71','white'],
                ['Rigging & Lighting','Konser - 2024','f1c40f','black'],
                ['Kursi Futura Set','Resepsi - 2025','9b59b6','white'],
                ['Tenda Kerucut','Outdoor Event - 2025','34495e','white'],
            ] as $gallery)
                <div class="col-lg-4 col-md-6" data-aos="zoom-in">
                    <div class="galeri-item">
                        <img src="https://placehold.co/600x400/{{ $gallery[2] }}/{{ $gallery[3] }}?text={{ urlencode($gallery[0]) }}" alt="{{ $gallery[0] }}" class="img-fluid">
                        <div class="galeri-overlay"><h4>{{ $gallery[0] }}</h4><p>{{ $gallery[1] }}</p></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section id="testimoni" class="testimoni-section">
    <div class="container">
        <div class="section-header text-center" data-aos="fade-up">
            <h5 class="section-subtitle">Testimoni</h5>
            <h2 class="section-title">Apa Kata <span class="text-primary">Pelanggan</span></h2>
        </div>
        <div class="row">
            @foreach([
                ['Ahmad Fauzi','Pernikahan - 12 Des 2025','Pelayanan sangat memuaskan! Proses booking cepat dan mudah melalui website.'],
                ['Siti Nurhaliza','Acara Kantor - 5 Mar 2025','Sangat merekomendasikan! Sistem pembayarannya aman dan transparan.'],
                ['Budi Santoso','Khitanan - 20 Jun 2025','Tim profesional, peralatan berkualitas, harga bersaing dengan kualitas terbaik.'],
            ] as $testi)
                <div class="col-lg-4 col-md-6" data-aos="fade-up">
                    <div class="testimoni-card">
                        <div class="testimoni-rating"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i></div>
                        <p class="testimoni-text">"{{ $testi[2] }}"</p>
                        <div class="testimoni-user"><img src="https://placehold.co/60x60/2c3e50/white?text={{ substr($testi[0], 0, 1) }}" alt="User" class="rounded-circle"><div><h5>{{ $testi[0] }}</h5><p>{{ $testi[1] }}</p></div></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section id="faq" class="faq-section">
    <div class="container">
        <div class="section-header text-center" data-aos="fade-up">
            <h5 class="section-subtitle">FAQ</h5>
            <h2 class="section-title">Pertanyaan <span class="text-primary">Umum</span></h2>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="accordion" id="accordionFAQ">
                    <div class="accordion-item" data-aos="fade-up"><h2 class="accordion-header"><button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">Bagaimana cara cek ketersediaan tenda?</button></h2><div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#accordionFAQ"><div class="accordion-body">Anda bisa cek ketersediaan langsung melalui fitur Cek Ketersediaan dengan memilih tanggal acara dan paket.</div></div></div>
                    <div class="accordion-item" data-aos="fade-up"><h2 class="accordion-header"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">Apakah bisa booking tanpa DP?</button></h2><div id="faq2" class="accordion-collapse collapse" data-bs-parent="#accordionFAQ"><div class="accordion-body">Untuk mengamankan jadwal dan menghindari risiko gagal bayar, sistem menerapkan pembayaran lunas 100% di awal.</div></div></div>
                    <div class="accordion-item" data-aos="fade-up"><h2 class="accordion-header"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">Metode pembayaran apa saja yang diterima?</button></h2><div id="faq3" class="accordion-collapse collapse" data-bs-parent="#accordionFAQ"><div class="accordion-body">Transfer bank, QRIS, dan e-wallet melalui payment gateway.</div></div></div>
                    <div class="accordion-item" data-aos="fade-up"><h2 class="accordion-header"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">Berapa lama proses booking sampai konfirmasi?</button></h2><div id="faq4" class="accordion-collapse collapse" data-bs-parent="#accordionFAQ"><div class="accordion-body">Setelah pembayaran berhasil, sistem akan mengirimkan konfirmasi booking secara otomatis.</div></div></div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="cta-section">
    <div class="container">
        <div class="cta-card" data-aos="zoom-in">
            <div class="row align-items-center">
                <div class="col-lg-8"><h2>Siap Mewujudkan Acara Impian Anda?</h2><p class="mb-lg-0">Booking sekarang dan dapatkan kemudahan layanan 24/7 dengan pembayaran aman.</p></div>
                <div class="col-lg-4 text-lg-end"><a href="{{ route('frontend.index') }}#paket" class="btn btn-light btn-lg">Booking Sekarang</a></div>
            </div>
        </div>
    </div>
</section>

<footer id="kontak" class="footer-section footer-batik">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 mb-4 mb-lg-0">
                <h4>Didin Tenda Decoration</h4>
                <p class="footer-address"><i class="bi bi-geo-alt-fill"></i> Jl. Ki Mas Laeng Kp. Katomas, Tigaraksa, Kab. Tangerang, Banten</p>
                <p><i class="bi bi-telephone-fill"></i> <a href="tel:088289258764">0882-8925-8764</a></p>
                <p><i class="bi bi-envelope-fill"></i> <a href="mailto:info@didintenda.com">info@didintenda.com</a></p>
                <div class="social-links"><a href="#"><i class="bi bi-facebook"></i></a><a href="#"><i class="bi bi-instagram"></i></a><a href="#"><i class="bi bi-whatsapp"></i></a><a href="#"><i class="bi bi-youtube"></i></a></div>
            </div>
            <div class="col-lg-2 col-md-6 mb-4 mb-md-0"><h5>Menu Cepat</h5><ul class="footer-links"><li><a href="{{ route('frontend.index') }}">Beranda</a></li><li><a href="{{ route('frontend.index') }}#paket">Paket</a></li><li><a href="{{ route('frontend.index') }}#galeri">Galeri</a></li><li><a href="{{ route('frontend.index') }}#testimoni">Testimoni</a></li><li><a href="{{ route('frontend.index') }}#kontak">Kontak</a></li></ul></div>
            <div class="col-lg-3 col-md-6 mb-4 mb-md-0"><h5>Layanan</h5><ul class="footer-links"><li><a href="{{ route('frontend.index') }}#paket">Sewa Tenda</a></li><li><a href="{{ route('frontend.index') }}#paket">Dekorasi Pernikahan</a></li><li><a href="{{ route('frontend.index') }}#paket">Sewa Kursi</a></li><li><a href="{{ route('frontend.index') }}#paket">Rigging & Lighting</a></li><li><a href="{{ route('frontend.paket-custom') }}">Paket Custom</a></li></ul></div>
            <div class="col-lg-3"><h5>Metode Pembayaran</h5><div class="payment-methods"><img src="https://placehold.co/60x40/2c3e50/white?text=BCA" alt="BCA" class="payment-logo"><img src="https://placehold.co/60x40/2c3e50/white?text=Mandiri" alt="Mandiri" class="payment-logo"><img src="https://placehold.co/60x40/2c3e50/white?text=BRI" alt="BRI" class="payment-logo"><img src="https://placehold.co/60x40/2c3e50/white?text=QRIS" alt="QRIS" class="payment-logo"><img src="https://placehold.co/60x40/2c3e50/white?text=GoPay" alt="GoPay" class="payment-logo"></div><p class="mt-3 small text-white-50"><i class="bi bi-shield-check"></i> Transaksi 100% aman via Midtrans</p></div>
        </div>
        <hr class="footer-hr">
        <div class="row align-items-center"><div class="col-md-6 text-center text-md-start"><p class="copyright">© 2026 Didin Tenda Decoration. All rights reserved.</p></div><div class="col-md-6 text-center text-md-end"><p class="developer">Developed for Tugas Akhir - Muhamad Darlan (20220803005)</p></div></div>
    </div>
</footer>

<button id="backToTop" class="back-to-top" title="Kembali ke atas"><i class="bi bi-arrow-up"></i></button>

@guest
<div class="modal fade" id="loginRegisterModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <div class="modal-tabs w-100">
                    <button type="button" class="modal-tab-btn active" data-tab="login">Login</button>
                    <button type="button" class="modal-tab-btn" data-tab="register">Daftar</button>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 pt-3" id="loginForm">
                <form id="formLogin" method="POST" action="{{ route('frontend.login') }}">
                    @csrf
                    <div class="mb-4"><label class="form-label">Email</label><div class="input-group"><span class="input-group-text"><i class="bi bi-envelope"></i></span><input type="email" name="email" class="form-control" placeholder="contoh@email.com" required></div></div>
                    <div class="mb-3"><label class="form-label">Password</label><div class="input-group"><span class="input-group-text"><i class="bi bi-lock"></i></span><input type="password" name="password" class="form-control" placeholder="Masukkan password" required><button class="btn btn-outline-secondary toggle-password" type="button"><i class="bi bi-eye-slash"></i></button></div></div>
                    <div class="d-flex justify-content-between align-items-center mb-4"><div class="form-check"><input class="form-check-input" type="checkbox" name="remember" id="rememberMe"><label class="form-check-label" for="rememberMe">Ingat saya</label></div><a href="#" class="forgot-password" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#forgotPasswordModal">Lupa password?</a></div>
                    <button type="submit" class="btn btn-primary w-100 py-2 mb-3">Login Sekarang</button>
                    <div class="text-center text-muted"><small>Belum punya akun? <a href="#" class="switch-to-register" data-tab="register">Daftar di sini</a></small></div>
                </form>
            </div>
            <div class="modal-body p-4 pt-3 d-none" id="registerForm">
                <form id="formRegister" method="POST" action="{{ route('frontend.register') }}">
                    @csrf
                    <div class="mb-3"><label class="form-label">Nama Lengkap</label><div class="input-group"><span class="input-group-text"><i class="bi bi-person"></i></span><input type="text" name="name" class="form-control" placeholder="Masukkan nama lengkap" required></div></div>
                    <div class="mb-3"><label class="form-label">Email</label><div class="input-group"><span class="input-group-text"><i class="bi bi-envelope"></i></span><input type="email" name="email" class="form-control" placeholder="contoh@email.com" required></div></div>
                    <div class="mb-3"><label class="form-label">Nomor WhatsApp</label><div class="input-group"><span class="input-group-text"><i class="bi bi-whatsapp"></i></span><input type="tel" name="phone" class="form-control" placeholder="0812-3456-7890"></div></div>
                    <div class="mb-3"><label class="form-label">Password</label><div class="input-group"><span class="input-group-text"><i class="bi bi-lock"></i></span><input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required><button class="btn btn-outline-secondary toggle-password" type="button"><i class="bi bi-eye-slash"></i></button></div></div>
                    <div class="mb-3"><label class="form-label">Konfirmasi Password</label><div class="input-group"><span class="input-group-text"><i class="bi bi-shield-lock"></i></span><input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password" required><button class="btn btn-outline-secondary toggle-password" type="button"><i class="bi bi-eye-slash"></i></button></div></div>
                    <div class="mb-4"><div class="form-check"><input class="form-check-input" type="checkbox" name="terms" value="1" id="termsCheck" required><label class="form-check-label" for="termsCheck">Saya setuju dengan <a href="#">Syarat & Ketentuan</a> dan <a href="#">Kebijakan Privasi</a></label></div></div>
                    <button type="submit" class="btn btn-primary w-100 py-2 mb-3">Daftar Sekarang</button>
                    <div class="text-center text-muted"><small>Sudah punya akun? <a href="#" class="switch-to-login" data-tab="login">Login di sini</a></small></div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="forgotPasswordModal" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0"><h5 class="modal-title">Lupa Password</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
            <div class="modal-body p-4 pt-3">
                <p class="text-muted small mb-3">Masukkan email Anda, kami akan mengirimkan link reset password.</p>
                <form id="formForgotPassword" method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="mb-3"><label class="form-label">Email</label><input type="email" name="email" class="form-control" placeholder="contoh@email.com" required></div>
                    <button type="submit" class="btn btn-primary w-100 py-2">Kirim Link Reset</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endguest

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="{{ asset('js/script.js') }}?v={{ time() }}"></script>
</body>
</html>
