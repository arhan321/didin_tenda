/**
 * SCRIPT.JS - Fungsi untuk Landing Page Didin Tenda Decoration
 * Versi Responsif - Fix untuk stats di semua ukuran layar
 * 
 * CATATAN: File ini berisi fungsi GLOBAL yang digunakan di semua halaman
 *          - updateCartBadge() untuk update badge keranjang
 *          - showNotification() untuk notifikasi popup
 *          - formatRupiah() untuk format mata uang
 *          - calculateDistance() untuk hitung jarak (Haversine Formula)
 *          - calculateShippingFee() untuk hitung ongkir
 *          - Dan semua fungsi animasi & interaksi landing page
 */

// ===== TUNGGU DOKUMEN SIAP =====
document.addEventListener('DOMContentLoaded', function() {
    console.log('✅ Landing Page Didin Tenda siap!');
    
    // CEK UKURAN LAYAR SAAT PERTAMA KALI BUKA
    const isMobile = window.innerWidth < 768;
    
    if (isMobile) {
        // MOBILE: Paksa semua konten muncul tanpa animasi
        forceShowContent();
        // Inisialisasi fungsi dasar saja (tanpa animasi)
        initNavbarScroll();
        initBackToTop();
        initSmoothScroll();
        initMobileMenu();
        initFormInteractions();
        console.log('📱 Mode mobile: animasi dinonaktifkan');
    } else {
        // DESKTOP: Inisialisasi semua fungsi termasuk animasi
        initAOS();
        initNavbarScroll();
        initBackToTop();
        initSmoothScroll();
        initMobileMenu();
        initFormInteractions();
        initCountUp();
        initTooltips();
        initActiveNavOnScroll();
        initPaketHover();
        console.log('💻 Mode desktop: semua animasi aktif');
    }
    
    // Inisialisasi fungsi yang jalan di semua device
    initLazyLoading();
    initUserMenuTooltips();
    initAuthModal();
    
    // Pastikan stats terlihat
    ensureStatsVisible();
    
    // Update badge keranjang dari localStorage
    updateCartBadge();
});

// ===== FUNGSI UNTUK PASTIKAN STATS TERLIHAT =====
function ensureStatsVisible() {
    const stats = document.querySelectorAll('.stat-item');
    const wave = document.querySelector('.hero-wave');
    
    // Pastikan stats punya background putih solid
    stats.forEach(stat => {
        stat.style.backgroundColor = '#ffffff';
        stat.style.backdropFilter = 'none';
        stat.style.position = 'relative';
        stat.style.zIndex = '35';
    });
    
    // Pastikan wave di bawah
    if (wave) {
        wave.style.zIndex = '5';
    }
    
    console.log('✅ Stats visibility fixed');
}

// ===== FUNGSI UNTUK PAKSA KONTEN MUNCUL DI MOBILE =====
function forceShowContent() {
    // Semua section dipaksa tampil
    const sections = document.querySelectorAll('section');
    sections.forEach(section => {
        section.style.display = 'block';
        section.style.visibility = 'visible';
        section.style.opacity = '1';
        section.style.transform = 'none';
    });
    
    // Nonaktifkan semua atribut AOS
    const aosElements = document.querySelectorAll('[data-aos]');
    aosElements.forEach(el => {
        el.removeAttribute('data-aos');
        el.removeAttribute('data-aos-delay');
        el.removeAttribute('data-aos-duration');
        el.removeAttribute('data-aos-easing');
    });
    
    // Hero card di mobile tidak perlu animasi
    const heroCard = document.querySelector('.hero-card');
    if (heroCard) {
        heroCard.style.animation = 'none';
        heroCard.style.position = 'relative';
        heroCard.style.bottom = 'auto';
        heroCard.style.left = 'auto';
        heroCard.style.margin = '20px auto 0';
        heroCard.style.width = 'fit-content';
    }
    
    console.log('📱 Konten dipaksa tampil untuk mobile');
}

// ===== 1. INISIALISASI AOS (ANIMATION ON SCROLL) =====
function initAOS() {
    if (window.innerWidth < 768) {
        return;
    }
    
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 800,
            once: true,
            offset: 50,
            easing: 'ease-out',
            delay: 50,
            disable: function() {
                return window.innerWidth < 768;
            }
        });
        console.log('✅ AOS initialized untuk desktop');
    } else {
        console.warn('⚠️ AOS library not loaded');
    }
}

// ===== 2. NAVBAR SCROLL EFFECT =====
function initNavbarScroll() {
    const navbar = document.querySelector('.navbar');
    
    if (!navbar) {
        console.warn('⚠️ Navbar tidak ditemukan');
        return;
    }
    
    window.addEventListener('scroll', function() {
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
            navbar.style.padding = window.innerWidth < 768 ? '8px 0' : '10px 0';
            navbar.style.boxShadow = '0 2px 20px rgba(0,0,0,0.3)';
        } else {
            navbar.classList.remove('scrolled');
            navbar.style.padding = window.innerWidth < 768 ? '12px 0' : '15px 0';
            navbar.style.boxShadow = '0 2px 20px rgba(0,0,0,0.1)';
        }
    });
    
    console.log('✅ Navbar scroll effect aktif');
}

// ===== 3. BACK TO TOP BUTTON =====
function initBackToTop() {
    const backToTop = document.getElementById('backToTop');
    
    if (!backToTop) {
        console.warn('⚠️ Back to top button tidak ditemukan');
        return;
    }
    
    window.addEventListener('scroll', function() {
        const scrollThreshold = window.innerWidth < 768 ? 200 : 300;
        
        if (window.scrollY > scrollThreshold) {
            backToTop.classList.add('show');
            backToTop.style.display = 'flex';
        } else {
            backToTop.classList.remove('show');
            backToTop.style.display = 'none';
        }
    });
    
    backToTop.addEventListener('click', function(e) {
        e.preventDefault();
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
    
    console.log('✅ Back to top button siap');
}

// ===== 4. SMOOTH SCROLL UNTUK ANCHOR LINKS =====
function initSmoothScroll() {
    const links = document.querySelectorAll('a[href^="#"]');
    
    links.forEach(link => {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            
            if (href === '#' || href === '') return;
            
            const targetElement = document.querySelector(href);
            
            if (targetElement) {
                e.preventDefault();
                
                const navbarHeight = document.querySelector('.navbar')?.offsetHeight || 70;
                const targetPosition = targetElement.offsetTop - navbarHeight;
                
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
                
                updateActiveNavLink(href);
            }
        });
    });
    
    console.log('✅ Smooth scroll aktif');
}

// Update active class di navbar
function updateActiveNavLink(targetId) {
    const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
    
    navLinks.forEach(link => {
        link.classList.remove('active');
        const linkHref = link.getAttribute('href');
        
        if (linkHref === targetId) {
            link.classList.add('active');
        }
    });
}

// ===== 5. MOBILE MENU AUTO CLOSE =====
function initMobileMenu() {
    const navbarToggler = document.querySelector('.navbar-toggler');
    const navbarCollapse = document.querySelector('.navbar-collapse');
    const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
    
    if (!navbarCollapse || !navbarToggler) return;
    
    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            if (window.innerWidth < 992) {
                if (navbarCollapse.classList.contains('show')) {
                    navbarToggler.click();
                }
            }
        });
    });
    
    let scrollTimeout;
    window.addEventListener('scroll', function() {
        if (window.innerWidth < 992) {
            clearTimeout(scrollTimeout);
            scrollTimeout = setTimeout(() => {
                if (navbarCollapse.classList.contains('show')) {
                    navbarToggler.click();
                }
            }, 300);
        }
    });
    
    console.log('✅ Mobile menu handler siap');
}

// ===== 6. FORM INTERACTIONS (Quick Check) =====
function initFormInteractions() {
    const quickCheckBtn = document.querySelector('.quick-check-card .btn-primary');
    const dateInput = document.querySelector('input[type="date"]');
    const paketSelect = document.querySelector('select');
    
    if (quickCheckBtn) {
        quickCheckBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            const selectedDate = dateInput ? dateInput.value : null;
            const selectedPaket = paketSelect ? paketSelect.value : null;
            
            if (!selectedDate) {
                showNotification('⚠️ Silakan pilih tanggal acara terlebih dahulu', 'warning');
                return;
            }
            
            if (!selectedPaket || selectedPaket === '-- Pilih Paket --') {
                showNotification('⚠️ Silakan pilih paket dekorasi', 'warning');
                return;
            }
            
            const originalText = this.innerHTML;
            this.innerHTML = '⏳ Mengecek...';
            this.disabled = true;
            
            setTimeout(() => {
                const isAvailable = Math.random() > 0.3;
                
                if (isAvailable) {
                    showNotification('✅ Tanggal tersedia! Silakan lanjut booking', 'success');
                    highlightPaket(selectedPaket);
                } else {
                    showNotification('❌ Maaf, tanggal sudah dibooking. Silakan pilih tanggal lain', 'error');
                }
                
                this.innerHTML = originalText;
                this.disabled = false;
            }, 1500);
        });
    }
    
    if (dateInput) {
        const today = new Date().toISOString().split('T')[0];
        dateInput.setAttribute('min', today);
    }
    
    console.log('✅ Form interactions siap');
}

// ===== 7. HIGHLIGHT PAKET CARD =====
function highlightPaket(paketName) {
    const paketCards = document.querySelectorAll('.paket-card');
    
    paketCards.forEach(card => {
        const title = card.querySelector('h3')?.textContent || '';
        
        if (title.includes(paketName) || paketName.includes(title)) {
            card.style.transition = 'all 0.3s ease';
            card.style.transform = window.innerWidth < 768 ? 'scale(1.02)' : 'scale(1.05)';
            card.style.boxShadow = '0 20px 40px rgba(44, 123, 229, 0.3)';
            card.style.border = '3px solid #2c7be5';
            
            setTimeout(() => {
                card.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            }, 500);
            
            setTimeout(() => {
                card.style.transform = '';
                card.style.boxShadow = '';
                card.style.border = '';
            }, 3000);
        }
    });
}

// ===== 8. COUNT UP ANIMATION =====
function initCountUp() {
    if (window.innerWidth < 768) {
        const stats = document.querySelectorAll('.stat-number');
        const statValues = ['28+', '5.000+', '385+'];
        stats.forEach((stat, index) => {
            if (statValues[index]) {
                stat.textContent = statValues[index];
            }
        });
        return;
    }
    
    const stats = document.querySelectorAll('.stat-number');
    if (stats.length === 0) return;
    
    const countUp = (element, target) => {
        let current = 0;
        const targetNumber = parseInt(target.replace(/[^0-9]/g, ''));
        if (isNaN(targetNumber)) return;
        
        const increment = targetNumber / 50;
        const timer = setInterval(() => {
            current += increment;
            if (current >= targetNumber) {
                element.textContent = targetNumber.toLocaleString() + '+';
                clearInterval(timer);
            } else {
                element.textContent = Math.floor(current).toLocaleString() + '+';
            }
        }, 30);
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const statValues = ['28+', '5000+', '385+'];
                
                stats.forEach((stat, index) => {
                    if (statValues[index]) {
                        countUp(stat, statValues[index]);
                    }
                });
                
                observer.disconnect();
            }
        });
    }, { threshold: 0.3 });
    
    observer.observe(document.querySelector('.hero-stats'));
    
    console.log('✅ Count up animation siap');
}

// ===== 9. TOOLTIP INITIALIZATION =====
function initTooltips() {
    if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip && window.innerWidth >= 768) {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        console.log('✅ Tooltips siap');
    }
}

// ===== 10. LAZY LOADING GAMBAR =====
function initLazyLoading() {
    const images = document.querySelectorAll('img[data-src]');
    
    if (images.length === 0) return;
    
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.classList.add('loaded');
                observer.unobserve(img);
            }
        });
    }, {
        rootMargin: '50px'
    });
    
    images.forEach(img => imageObserver.observe(img));
    
    console.log('✅ Lazy loading images siap');
}

// ===== 11. ACTIVE NAVBAR ON SCROLL =====
function initActiveNavOnScroll() {
    if (window.innerWidth < 768) return;
    
    const sections = document.querySelectorAll('section[id]');
    const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
    
    if (sections.length === 0 || navLinks.length === 0) return;
    
    window.addEventListener('scroll', function() {
        let current = '';
        const scrollPosition = window.scrollY + 100;
        
        sections.forEach(section => {
            const sectionTop = section.offsetTop;
            const sectionHeight = section.offsetHeight;
            const sectionId = section.getAttribute('id');
            
            if (scrollPosition >= sectionTop && scrollPosition < sectionTop + sectionHeight) {
                current = sectionId;
            }
        });
        
        navLinks.forEach(link => {
            link.classList.remove('active');
            const href = link.getAttribute('href').replace('#', '');
            if (href === current) {
                link.classList.add('active');
            }
        });
    });
    
    console.log('✅ Active nav on scroll siap');
}

// ===== 12. PAKET CARD HOVER EFFECT =====
function initPaketHover() {
    if (window.innerWidth >= 768) {
        const paketCards = document.querySelectorAll('.paket-card');
        
        paketCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-15px)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = '';
            });
        });
        
        console.log('✅ Paket hover effect siap');
    }
}

// ===== 13. HANDLE RESIZE =====
window.addEventListener('resize', function() {
    clearTimeout(window.resizeTimer);
    window.resizeTimer = setTimeout(function() {
        const isMobile = window.innerWidth < 768;
        
        if (isMobile) {
            forceShowContent();
        } else {
            if (typeof AOS !== 'undefined') {
                AOS.refresh();
            }
        }
        
        ensureStatsVisible();
        
        console.log('📱💻 Resize detected:', window.innerWidth + 'px');
    }, 250);
});

// ===== 14. INIT USER MENU TOOLTIPS =====
function initUserMenuTooltips() {
    if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl, {
                placement: 'bottom',
                offset: [0, 10]
            });
        });
    }
}

// ==================== FUNGSI ONGKIR (HAVERSINE FORMULA) ====================

// Koordinat PT Didin Tenda (Tigaraksa, Tangerang)
const DIDIN_LOCATION = {
    lat: -6.262311,
    lng: 106.472969,
    name: "PT Didin Tenda Decoration"
};

// ===== HITUNG JARAK MENGGUNAKAN HAVERSINE FORMULA =====
function calculateDistance(lat1, lon1, lat2, lon2) {
    const R = 6371; // Radius bumi dalam kilometer
    const dLat = (lat2 - lat1) * Math.PI / 180;
    const dLon = (lon2 - lon1) * Math.PI / 180;
    const a = Math.sin(dLat/2) * Math.sin(dLat/2) +
              Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
              Math.sin(dLon/2) * Math.sin(dLon/2);
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
    const distance = R * c;
    return Math.round(distance * 10) / 10; // Dibulatkan 1 desimal
}

// ===== HITUNG BIAYA ONGKIR =====
function calculateShippingFee(distance) {
    if (distance <= 10) {
        return 0; // GRATIS
    } else if (distance <= 30) {
        // Rp 5.000 per km untuk jarak 10-30km
        const extraKm = distance - 10;
        return Math.ceil(extraKm * 5000);
    } else {
        // Rp 10.000 per km untuk jarak >30km
        const first20Km = 20 * 5000; // 20km pertama (10-30km) = 100.000
        const extraKm = distance - 30;
        return Math.ceil(first20Km + (extraKm * 10000));
    }
}

// ===== FORMAT BIAYA ONGKIR =====
function formatShippingFee(fee) {
    if (fee === 0) return "GRATIS";
    return formatRupiah(fee);
}

// ===== KONVERSI ALAMAT KE KOORDINAT (GEOCODING SIMULASI) =====
// NOTE: Untuk production, gunakan Google Maps Geocoding API
function geocodeAddress(address, callback) {
    // Simulasi: Untuk demo, kita generate jarak random antara 1-60 km
    // Di production, ini akan diganti dengan API Google Maps Distance Matrix
    const randomDistance = Math.floor(Math.random() * 60) + 1;
    
    // Generate koordinat berdasarkan jarak random dari lokasi Didin
    const earthRadius = 6371;
    const randomAngle = Math.random() * 2 * Math.PI;
    const dLat = (randomDistance / earthRadius) * (180 / Math.PI);
    const dLon = dLat / Math.cos(DIDIN_LOCATION.lat * Math.PI / 180);
    
    const targetLat = DIDIN_LOCATION.lat + dLat * Math.cos(randomAngle);
    const targetLng = DIDIN_LOCATION.lng + dLon * Math.sin(randomAngle);
    
    callback({
        lat: targetLat,
        lng: targetLng,
        address: address,
        distance: randomDistance
    });
}

// ===== CEK JARAK DARI LOKASI DIDIN =====
function getDistanceFromDidin(lat, lng) {
    return calculateDistance(DIDIN_LOCATION.lat, DIDIN_LOCATION.lng, lat, lng);
}

// ==================== FUNGSI GLOBAL UNTUK CART ====================

// ===== FORMAT RUPIAH (GLOBAL) =====
function formatRupiah(angka) {
    if (isNaN(angka) || angka === undefined || angka === null) return 'Rp 0';
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    }).format(angka);
}

// ===== UPDATE BADGE KERANJANG DI NAVBAR =====
function updateCartBadge() {
    // Ambil data cart dari localStorage
    const cart = localStorage.getItem('didinCart');
    const items = cart ? JSON.parse(cart) : [];
    
    // Cari semua badge dengan class .menu-badge
    const badges = document.querySelectorAll('.menu-badge');
    
    badges.forEach(badge => {
        const count = items.length;
        badge.textContent = count;
        badge.style.display = count > 0 ? 'flex' : 'none';
    });
    
    console.log('🛒 Badge updated:', items.length);
}

// ===== SHOW NOTIFICATION (POPUP NOTIF) =====
function showNotification(message, type = 'info') {
    // Hapus notifikasi lama jika ada
    const oldNotif = document.querySelector('.custom-notification');
    if (oldNotif) oldNotif.remove();
    
    const notification = document.createElement('div');
    notification.className = 'custom-notification';
    
    let icon = '';
    let borderColor = '';
    
    switch(type) {
        case 'success': 
            icon = '✅'; 
            borderColor = '#28a745';
            break;
        case 'error': 
            icon = '❌'; 
            borderColor = '#dc3545';
            break;
        case 'warning': 
            icon = '⚠️'; 
            borderColor = '#ffc107';
            break;
        default: 
            icon = 'ℹ️'; 
            borderColor = '#2c7be5';
    }
    
    notification.innerHTML = `${icon} ${message}`;
    notification.style.cssText = `
        position: fixed;
        top: 100px;
        right: 20px;
        background: white;
        padding: 15px 25px;
        border-radius: 10px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.2);
        z-index: 9999;
        font-weight: 500;
        font-size: 14px;
        border-left: 5px solid ${borderColor};
        animation: slideIn 0.3s ease;
    `;
    
    document.body.appendChild(notification);
    
    // Auto hilang setelah 3 detik
    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// ===== TAMBAH KE KERANJANG LANGSUNG (untuk index.html) =====
function addToCartDirect(paketId, paketName, paketPrice) {
    let cart = localStorage.getItem('didinCart');
    cart = cart ? JSON.parse(cart) : [];
    
    // Cek apakah sudah ada di cart
    const existing = cart.find(item => item.id === paketId);
    if (existing) {
        showNotification(`⚠️ ${paketName} sudah ada di keranjang!`, 'warning');
        return;
    }
    
    const newItem = {
        id: paketId,
        name: paketName,
        price: paketPrice,
        basePrice: paketPrice,
        date: '',
        location: '',
        customerName: '',
        customerPhone: '',
        addons: [],
        addedAt: new Date().toISOString()
    };
    
    cart.push(newItem);
    localStorage.setItem('didinCart', JSON.stringify(cart));
    
    // Update badge di semua halaman
    updateCartBadge();
    
    showNotification(`✅ ${paketName} ditambahkan ke keranjang!`, 'success');
}

// ==================== MODAL LOGIN & REGISTER FUNCTIONS ====================

// Inisialisasi Modal
function initAuthModal() {
    const modal = document.getElementById('loginRegisterModal');
    if (!modal) return;
    
    // Tab switching
    const tabBtns = document.querySelectorAll('.modal-tab-btn');
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');
    
    tabBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const tab = this.getAttribute('data-tab');
            
            // Update active class on tabs
            tabBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            // Show/hide forms
            if (tab === 'login') {
                loginForm.classList.remove('d-none');
                registerForm.classList.add('d-none');
            } else {
                loginForm.classList.add('d-none');
                registerForm.classList.remove('d-none');
            }
        });
    });
    
    // Switch from login to register via link
    const switchToRegister = document.querySelector('.switch-to-register');
    if (switchToRegister) {
        switchToRegister.addEventListener('click', function(e) {
            e.preventDefault();
            const registerTab = document.querySelector('.modal-tab-btn[data-tab="register"]');
            if (registerTab) registerTab.click();
        });
    }
    
    // Switch from register to login via link
    const switchToLogin = document.querySelector('.switch-to-login');
    if (switchToLogin) {
        switchToLogin.addEventListener('click', function(e) {
            e.preventDefault();
            const loginTab = document.querySelector('.modal-tab-btn[data-tab="login"]');
            if (loginTab) loginTab.click();
        });
    }
    
    // Toggle password visibility
    const togglePasswordBtns = document.querySelectorAll('.toggle-password');
    togglePasswordBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const input = this.closest('.input-group').querySelector('input');
            const icon = this.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            } else {
                input.type = 'password';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            }
        });
    });
    
    // Form Login Submit (Simulasi)
    const formLogin = document.getElementById('formLogin');
    if (formLogin) {
        formLogin.addEventListener('submit', function(e) {
            e.preventDefault();
            const email = this.querySelector('input[type="email"]').value;
            const password = this.querySelector('input[type="password"]').value;
            
            if (!email || !password) {
                showNotification('⚠️ Harap isi email dan password!', 'warning');
                return;
            }
            
            showNotification('🔄 Memproses login...', 'info');
            
            setTimeout(() => {
                showNotification('✅ Login berhasil! Selamat datang kembali!', 'success');
                const modalEl = document.getElementById('loginRegisterModal');
                const modalInstance = bootstrap.Modal.getInstance(modalEl);
                if (modalInstance) modalInstance.hide();
                formLogin.reset();
            }, 1500);
        });
    }
    
    // Form Register Submit (Simulasi)
    const formRegister = document.getElementById('formRegister');
    if (formRegister) {
        formRegister.addEventListener('submit', function(e) {
            e.preventDefault();
            const name = this.querySelector('input[placeholder*="nama"]').value;
            const email = this.querySelector('input[type="email"]').value;
            const password = this.querySelectorAll('input[type="password"]')[0].value;
            const confirmPassword = this.querySelectorAll('input[type="password"]')[1].value;
            const terms = this.querySelector('#termsCheck').checked;
            
            if (!name || !email || !password || !confirmPassword) {
                showNotification('⚠️ Harap isi semua field!', 'warning');
                return;
            }
            
            if (password !== confirmPassword) {
                showNotification('❌ Password tidak cocok!', 'error');
                return;
            }
            
            if (password.length < 6) {
                showNotification('⚠️ Password minimal 6 karakter!', 'warning');
                return;
            }
            
            if (!terms) {
                showNotification('⚠️ Harap setuju dengan Syarat & Ketentuan!', 'warning');
                return;
            }
            
            showNotification('🔄 Mendaftarkan akun...', 'info');
            
            setTimeout(() => {
                showNotification('✅ Pendaftaran berhasil! Silakan login.', 'success');
                const loginTab = document.querySelector('.modal-tab-btn[data-tab="login"]');
                if (loginTab) loginTab.click();
                formRegister.reset();
            }, 1500);
        });
    }
    
    // Forgot Password Form
    const formForgotPassword = document.getElementById('formForgotPassword');
    if (formForgotPassword) {
        formForgotPassword.addEventListener('submit', function(e) {
            e.preventDefault();
            const email = this.querySelector('input[type="email"]').value;
            
            if (!email) {
                showNotification('⚠️ Masukkan email Anda!', 'warning');
                return;
            }
            
            showNotification('📧 Mengirim link reset password...', 'info');
            
            setTimeout(() => {
                showNotification('✅ Link reset password telah dikirim ke email Anda!', 'success');
                const modalEl = document.getElementById('forgotPasswordModal');
                const modalInstance = bootstrap.Modal.getInstance(modalEl);
                if (modalInstance) modalInstance.hide();
                formForgotPassword.reset();
            }, 1500);
        });
    }
}

// ===== TAMBAHKAN ANIMASI KEYFRAMES =====
(function addAnimationStyles() {
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        @keyframes slideOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        .notification {
            animation: slideIn 0.3s ease;
            z-index: 9999;
        }
        
        .custom-notification {
            animation: slideIn 0.3s ease;
        }
        
        .paket-card {
            transition: all 0.3s ease;
        }
        
        .paket-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(44, 123, 229, 0.15);
        }
        
        .btn-loading {
            position: relative;
            pointer-events: none;
            opacity: 0.7;
        }
        
        .btn-loading::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            border: 2px solid white;
            border-top-color: transparent;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
            right: 10px;
            top: calc(50% - 10px);
        }
        
        @media (max-width: 767px) {
            .paket-card:hover {
                transform: none;
            }
            
            [data-aos] {
                opacity: 1 !important;
                transform: none !important;
            }
        }
    `;
    document.head.appendChild(style);
})();

console.log('🎉 Semua fungsi script.js siap!');