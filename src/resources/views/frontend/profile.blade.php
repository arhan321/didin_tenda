<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - Didin Tenda Decoration</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- AOS Animation CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    
    <!-- Profile CSS -->
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
</head>
<body>

@php
    $user = auth()->user();
@endphp

<!-- ==================== NAVBAR DENGAN MOTIF BATIK ==================== -->
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
            
            <!-- User Menu -->
            <div class="navbar-user-menu d-flex align-items-center ms-lg-3">
                <a href="{{ route('frontend.cart') }}" class="user-menu-link" data-bs-toggle="tooltip" title="Keranjang Booking">
                    <i class="bi bi-cart3"></i>
                    <span class="menu-badge">0</span>
                </a>

                <a href="{{ route('frontend.pesanan') }}" class="user-menu-link" data-bs-toggle="tooltip" title="Pesanan Saya">
                    <i class="bi bi-receipt"></i>
                </a>

                <a href="{{ route('frontend.history') }}" class="user-menu-link" data-bs-toggle="tooltip" title="History Booking">
                    <i class="bi bi-clock-history"></i>
                </a>

                <a href="{{ route('frontend.profile') }}" class="user-menu-link active" data-bs-toggle="tooltip" title="Akun Saya">
                    <i class="bi bi-person-circle"></i>
                </a>

                <span class="menu-divider"></span>

                @auth
                    <form action="{{ route('frontend.logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-light btn-sm" id="logoutBtn">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('frontend.index') }}" class="btn btn-outline-light btn-sm">
                        Login
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>
<!-- ==================== NAVBAR END ==================== -->

<!-- ==================== PROFILE SECTION START ==================== -->
<section class="profile-section">
    <div class="container">
        <div class="row">
            <!-- Sidebar Menu -->
            <div class="col-lg-4 mb-4" data-aos="fade-right">
                <div class="profile-sidebar">
                    <div class="profile-avatar">
                        <div class="avatar-circle">
                            <i class="bi bi-person-fill"></i>
                        </div>

                        <h3>{{ $user->name }}</h3>
                        <p class="text-muted">{{ $user->email }}</p>

                        <span class="badge bg-primary">
                            Member Sejak {{ $user->created_at ? $user->created_at->format('Y') : '-' }}
                        </span>
                    </div>

                    <div class="profile-menu">
                        <a href="{{ route('frontend.profile') }}" class="profile-menu-item active">
                            <i class="bi bi-person"></i>
                            <span>Data Diri</span>
                        </a>

                        <a href="{{ route('frontend.pesanan') }}" class="profile-menu-item">
                            <i class="bi bi-receipt"></i>
                            <span>Pesanan Saya</span>
                            <i class="bi bi-chevron-right ms-auto"></i>
                        </a>

                        <a href="{{ route('frontend.history') }}" class="profile-menu-item">
                            <i class="bi bi-clock-history"></i>
                            <span>History Booking</span>
                            <i class="bi bi-chevron-right ms-auto"></i>
                        </a>

                        <a href="{{ route('frontend.cart') }}" class="profile-menu-item">
                            <i class="bi bi-cart3"></i>
                            <span>Keranjang Booking</span>
                            <i class="bi bi-chevron-right ms-auto"></i>
                        </a>

                        <a href="#" class="profile-menu-item" onclick="showNotification('🔧 Pengaturan akun akan segera hadir!', 'info')">
                            <i class="bi bi-gear"></i>
                            <span>Pengaturan Akun</span>
                            <i class="bi bi-chevron-right ms-auto"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Main Content - Data Diri -->
            <div class="col-lg-8" data-aos="fade-left">
                <div class="profile-content">
                    <div class="profile-header">
                        <h2>Data Diri</h2>
                        <p>Kelola informasi akun Anda</p>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <form id="profileForm" class="profile-form" method="POST" action="{{ route('frontend.profile.update') }}">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-person"></i>
                                    </span>
                                    <input 
                                        type="text" 
                                        name="name" 
                                        class="form-control" 
                                        value="{{ old('name', $user->name) }}" 
                                        required
                                    >
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-envelope"></i>
                                    </span>
                                    <input 
                                        type="email" 
                                        name="email" 
                                        class="form-control" 
                                        value="{{ old('email', $user->email) }}" 
                                        required
                                    >
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nomor WhatsApp</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-whatsapp"></i>
                                    </span>
                                    <input 
                                        type="tel" 
                                        name="whatsapp" 
                                        class="form-control" 
                                        value="{{ old('whatsapp', $user->whatsapp) }}"
                                        placeholder="Contoh: 0821-1234-5678"
                                    >
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">No. Telepon</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-telephone"></i>
                                    </span>
                                    <input 
                                        type="tel" 
                                        name="phone" 
                                        class="form-control" 
                                        value="{{ old('phone', $user->phone) }}"
                                        placeholder="Contoh: 021-12345678"
                                    >
                                </div>
                            </div>
                            
                            <div class="col-12 mb-3">
                                <label class="form-label">Alamat Lengkap</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-geo-alt"></i>
                                    </span>
                                    <textarea 
                                        name="alamat" 
                                        class="form-control" 
                                        rows="3" 
                                        placeholder="Masukkan alamat lengkap"
                                    >{{ old('alamat', $user->alamat) }}</textarea>
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kota/Kabupaten</label>
                                <input 
                                    type="text" 
                                    name="kota" 
                                    class="form-control" 
                                    value="{{ old('kota', $user->kota) }}"
                                    placeholder="Contoh: Tangerang"
                                >
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kode Pos</label>
                                <input 
                                    type="text" 
                                    name="kode_pos" 
                                    class="form-control" 
                                    value="{{ old('kode_pos', $user->kode_pos) }}"
                                    placeholder="Contoh: 15720"
                                >
                            </div>
                            
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary px-4">
                                    Simpan Perubahan
                                </button>

                                <a href="{{ route('frontend.profile') }}" class="btn btn-outline-secondary ms-2">
                                    Batal
                                </a>
                            </div>
                        </div>
                    </form>
                    
                    <!-- Ubah Password Section -->
                    <div class="change-password-section mt-5 pt-3">
                        <h4>Ubah Password</h4>
                        <p class="text-muted small">Ganti password akun Anda secara berkala untuk keamanan</p>
                        
                        <form id="changePasswordForm" method="POST" action="{{ route('frontend.profile.updatePassword') }}">
                            @csrf

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Password Lama</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-lock"></i>
                                        </span>
                                        <input 
                                            type="password" 
                                            name="current_password" 
                                            class="form-control" 
                                            placeholder="Masukkan password lama"
                                        >
                                        <button class="btn btn-outline-secondary toggle-password" type="button">
                                            <i class="bi bi-eye-slash"></i>
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Password Baru</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-key"></i>
                                        </span>
                                        <input 
                                            type="password" 
                                            name="password" 
                                            class="form-control" 
                                            placeholder="Minimal 6 karakter"
                                        >
                                        <button class="btn btn-outline-secondary toggle-password" type="button">
                                            <i class="bi bi-eye-slash"></i>
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Konfirmasi Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-shield-lock"></i>
                                        </span>
                                        <input 
                                            type="password" 
                                            name="password_confirmation" 
                                            class="form-control" 
                                            placeholder="Ulangi password baru"
                                        >
                                        <button class="btn btn-outline-secondary toggle-password" type="button">
                                            <i class="bi bi-eye-slash"></i>
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="col-12">
                                    <button type="submit" class="btn btn-outline-primary">
                                        Ubah Password
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- Ubah Password Section End -->
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ==================== PROFILE SECTION END ==================== -->

<!-- ==================== FOOTER DENGAN MOTIF BATIK ==================== -->
<footer id="kontak" class="footer-section footer-batik">
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

                <div class="social-links">
                    <a href="#" target="_blank"><i class="bi bi-facebook"></i></a>
                    <a href="#" target="_blank"><i class="bi bi-instagram"></i></a>
                    <a href="https://wa.me/6288289258764" target="_blank"><i class="bi bi-whatsapp"></i></a>
                    <a href="#" target="_blank"><i class="bi bi-youtube"></i></a>
                </div>
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
                        <a href="{{ route('frontend.index') }}#testimoni">Testimoni</a>
                    </li>
                    <li>
                        <a href="{{ route('frontend.index') }}#kontak">Kontak</a>
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
                        <a href="{{ route('frontend.index') }}#paket">Perlengkapan Acara</a>
                    </li>
                </ul>
            </div>

            <div class="col-lg-3">
                <h5>Metode Pembayaran</h5>

                <div class="payment-methods">
                    <img src="https://placehold.co/60x40/2c3e50/white?text=BCA" alt="BCA" class="payment-logo">
                    <img src="https://placehold.co/60x40/2c3e50/white?text=Mandiri" alt="Mandiri" class="payment-logo">
                    <img src="https://placehold.co/60x40/2c3e50/white?text=BRI" alt="BRI" class="payment-logo">
                    <img src="https://placehold.co/60x40/2c3e50/white?text=QRIS" alt="QRIS" class="payment-logo">
                    <img src="https://placehold.co/60x40/2c3e50/white?text=GoPay" alt="GoPay" class="payment-logo">
                    <img src="https://placehold.co/60x40/2c3e50/white?text=OVO" alt="OVO" class="payment-logo">
                </div>

                <p class="mt-3 small text-white-50">
                    <i class="bi bi-shield-check"></i> Transaksi 100% aman via Midtrans
                </p>
            </div>
        </div>

        <hr class="footer-hr">

        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start">
                <p class="copyright">© 2026 Didin Tenda Decoration. All rights reserved.</p>
            </div>

            <div class="col-md-6 text-center text-md-end">
                <p class="developer">Developed for Tugas Akhir - Muhamad Darlan (20220803005)</p>
            </div>
        </div>
    </div>
</footer>
<!-- ==================== FOOTER END ==================== -->

<!-- BACK TO TOP BUTTON -->
<button id="backToTop" class="back-to-top" title="Kembali ke atas">
    <i class="bi bi-arrow-up"></i>
</button>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- AOS Animation JS -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<!-- Custom JS -->
<script src="{{ asset('js/script.js') }}"></script>
</body>
</html>