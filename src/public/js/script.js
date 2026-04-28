/**
 * SCRIPT.JS - Didin Tenda Decoration
 * Versi Laravel Login/Register
 */

document.addEventListener('DOMContentLoaded', function () {
    console.log('✅ Landing Page Didin Tenda siap!');

    const isMobile = window.innerWidth < 768;

    if (isMobile) {
        forceShowContent();
        initNavbarScroll();
        initBackToTop();
        initSmoothScroll();
        initMobileMenu();
        initFormInteractions();
        console.log('📱 Mode mobile: animasi dinonaktifkan');
    } else {
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

    initLazyLoading();
    initUserMenuTooltips();
    initAuthModal();
    ensureStatsVisible();
    updateCartBadge();
});

function ensureStatsVisible() {
    const stats = document.querySelectorAll('.stat-item');
    const wave = document.querySelector('.hero-wave');

    stats.forEach(stat => {
        stat.style.backgroundColor = '#ffffff';
        stat.style.backdropFilter = 'none';
        stat.style.position = 'relative';
        stat.style.zIndex = '35';
    });

    if (wave) {
        wave.style.zIndex = '5';
    }

    console.log('✅ Stats visibility fixed');
}

function forceShowContent() {
    const sections = document.querySelectorAll('section');

    sections.forEach(section => {
        section.style.display = 'block';
        section.style.visibility = 'visible';
        section.style.opacity = '1';
        section.style.transform = 'none';
    });

    const aosElements = document.querySelectorAll('[data-aos]');

    aosElements.forEach(el => {
        el.removeAttribute('data-aos');
        el.removeAttribute('data-aos-delay');
        el.removeAttribute('data-aos-duration');
        el.removeAttribute('data-aos-easing');
    });

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
            disable: function () {
                return window.innerWidth < 768;
            }
        });

        console.log('✅ AOS initialized untuk desktop');
    }
}

function initNavbarScroll() {
    const navbar = document.querySelector('.navbar');

    if (!navbar) {
        return;
    }

    window.addEventListener('scroll', function () {
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

function initBackToTop() {
    const backToTop = document.getElementById('backToTop');

    if (!backToTop) {
        return;
    }

    window.addEventListener('scroll', function () {
        const scrollThreshold = window.innerWidth < 768 ? 200 : 300;

        if (window.scrollY > scrollThreshold) {
            backToTop.classList.add('show');
            backToTop.style.display = 'flex';
        } else {
            backToTop.classList.remove('show');
            backToTop.style.display = 'none';
        }
    });

    backToTop.addEventListener('click', function (e) {
        e.preventDefault();

        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });

    console.log('✅ Back to top button siap');
}

function initSmoothScroll() {
    const links = document.querySelectorAll('a[href*="#"]');

    links.forEach(link => {
        link.addEventListener('click', function (e) {
            const href = this.getAttribute('href');

            if (!href || href === '#') {
                return;
            }

            let url;

            try {
                url = new URL(href, window.location.origin);
            } catch (error) {
                return;
            }

            const hash = url.hash;

            if (!hash) {
                return;
            }

            const samePage = url.pathname === window.location.pathname;

            if (!samePage) {
                return;
            }

            const targetElement = document.querySelector(hash);

            if (targetElement) {
                e.preventDefault();

                const navbarHeight = document.querySelector('.navbar')?.offsetHeight || 70;
                const targetPosition = targetElement.offsetTop - navbarHeight;

                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });

                updateActiveNavLink(hash);
            }
        });
    });

    console.log('✅ Smooth scroll aktif');
}

function updateActiveNavLink(targetId) {
    const navLinks = document.querySelectorAll('.navbar-nav .nav-link');

    navLinks.forEach(link => {
        link.classList.remove('active');

        const href = link.getAttribute('href') || '';
        const linkHash = href.includes('#') ? '#' + href.split('#')[1] : '';

        if (linkHash === targetId) {
            link.classList.add('active');
        }
    });
}

function initMobileMenu() {
    const navbarToggler = document.querySelector('.navbar-toggler');
    const navbarCollapse = document.querySelector('.navbar-collapse');
    const navLinks = document.querySelectorAll('.navbar-nav .nav-link');

    if (!navbarCollapse || !navbarToggler) {
        return;
    }

    navLinks.forEach(link => {
        link.addEventListener('click', function () {
            if (window.innerWidth < 992 && navbarCollapse.classList.contains('show')) {
                navbarToggler.click();
            }
        });
    });

    let scrollTimeout;

    window.addEventListener('scroll', function () {
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

function initFormInteractions() {
    const quickCheckBtn = document.querySelector('.quick-check-card .btn-primary');
    const dateInput = document.querySelector('.quick-check-card input[type="date"]');
    const paketSelect = document.querySelector('.quick-check-card select');

    if (quickCheckBtn) {
        quickCheckBtn.addEventListener('click', function (e) {
            e.preventDefault();

            const selectedDate = dateInput ? dateInput.value : null;
            const selectedPaket = paketSelect ? paketSelect.value : null;

            if (!selectedDate) {
                showNotification('Silakan pilih tanggal acara terlebih dahulu', 'warning');
                return;
            }

            if (!selectedPaket || selectedPaket === '-- Pilih Paket --') {
                showNotification('Silakan pilih paket dekorasi', 'warning');
                return;
            }

            const originalText = this.innerHTML;

            this.innerHTML = '⏳ Mengecek...';
            this.disabled = true;

            setTimeout(() => {
                const isAvailable = Math.random() > 0.3;

                if (isAvailable) {
                    showNotification('Tanggal tersedia! Silakan lanjut booking', 'success');
                    highlightPaket(selectedPaket);
                } else {
                    showNotification('Maaf, tanggal sudah dibooking. Silakan pilih tanggal lain', 'error');
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

    if (stats.length === 0) {
        return;
    }

    const countUp = (element, target) => {
        let current = 0;
        const targetNumber = parseInt(target.replace(/[^0-9]/g, ''));

        if (isNaN(targetNumber)) {
            return;
        }

        const increment = targetNumber / 50;

        const timer = setInterval(() => {
            current += increment;

            if (current >= targetNumber) {
                element.textContent = targetNumber.toLocaleString('id-ID') + '+';
                clearInterval(timer);
            } else {
                element.textContent = Math.floor(current).toLocaleString('id-ID') + '+';
            }
        }, 30);
    };

    const heroStats = document.querySelector('.hero-stats');

    if (!heroStats) {
        return;
    }

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

    observer.observe(heroStats);

    console.log('✅ Count up animation siap');
}

function initTooltips() {
    if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip && window.innerWidth >= 768) {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));

        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        console.log('✅ Tooltips siap');
    }
}

function initLazyLoading() {
    const images = document.querySelectorAll('img[data-src]');

    if (images.length === 0) {
        return;
    }

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

function initActiveNavOnScroll() {
    if (window.innerWidth < 768) {
        return;
    }

    const sections = document.querySelectorAll('section[id]');
    const navLinks = document.querySelectorAll('.navbar-nav .nav-link');

    if (sections.length === 0 || navLinks.length === 0) {
        return;
    }

    window.addEventListener('scroll', function () {
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

            const href = link.getAttribute('href') || '';
            const linkHash = href.includes('#') ? href.split('#')[1] : '';

            if (linkHash === current) {
                link.classList.add('active');
            }
        });
    });

    console.log('✅ Active nav on scroll siap');
}

function initPaketHover() {
    if (window.innerWidth >= 768) {
        const paketCards = document.querySelectorAll('.paket-card');

        paketCards.forEach(card => {
            card.addEventListener('mouseenter', function () {
                this.style.transform = 'translateY(-15px)';
            });

            card.addEventListener('mouseleave', function () {
                this.style.transform = '';
            });
        });

        console.log('✅ Paket hover effect siap');
    }
}

window.addEventListener('resize', function () {
    clearTimeout(window.resizeTimer);

    window.resizeTimer = setTimeout(function () {
        const isMobile = window.innerWidth < 768;

        if (isMobile) {
            forceShowContent();
        } else {
            if (typeof AOS !== 'undefined') {
                AOS.refresh();
            }
        }

        ensureStatsVisible();
    }, 250);
});

function initUserMenuTooltips() {
    if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));

        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl, {
                placement: 'bottom',
                offset: [0, 10]
            });
        });
    }
}

const DIDIN_LOCATION = {
    lat: -6.262311,
    lng: 106.472969,
    name: 'PT Didin Tenda Decoration'
};

function calculateDistance(lat1, lon1, lat2, lon2) {
    const R = 6371;
    const dLat = (lat2 - lat1) * Math.PI / 180;
    const dLon = (lon2 - lon1) * Math.PI / 180;

    const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
        Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
        Math.sin(dLon / 2) * Math.sin(dLon / 2);

    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    const distance = R * c;

    return Math.round(distance * 10) / 10;
}

function calculateShippingFee(distance) {
    if (distance <= 10) {
        return 0;
    } else if (distance <= 30) {
        const extraKm = distance - 10;
        return Math.ceil(extraKm * 5000);
    } else {
        const first20Km = 20 * 5000;
        const extraKm = distance - 30;
        return Math.ceil(first20Km + (extraKm * 10000));
    }
}

function formatShippingFee(fee) {
    if (fee === 0) {
        return 'GRATIS';
    }

    return formatRupiah(fee);
}

function geocodeAddress(address, callback) {
    const randomDistance = Math.floor(Math.random() * 60) + 1;
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

function getDistanceFromDidin(lat, lng) {
    return calculateDistance(DIDIN_LOCATION.lat, DIDIN_LOCATION.lng, lat, lng);
}

function formatRupiah(angka) {
    if (isNaN(angka) || angka === undefined || angka === null) {
        return 'Rp 0';
    }

    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    }).format(angka);
}

function updateCartBadge() {
    const cart = localStorage.getItem('didinCart');
    const items = cart ? JSON.parse(cart) : [];
    const badges = document.querySelectorAll('.menu-badge');

    badges.forEach(badge => {
        const count = items.length;

        badge.textContent = count;
        badge.style.display = count > 0 ? 'flex' : 'none';
    });

    console.log('🛒 Badge updated:', items.length);
}

function showNotification(message, type = 'info') {
    const oldNotif = document.querySelector('.custom-notification');

    if (oldNotif) {
        oldNotif.remove();
    }

    const notification = document.createElement('div');

    notification.className = 'custom-notification';

    let icon = '';
    let borderColor = '';

    switch (type) {
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
        z-index: 99999;
        font-weight: 500;
        font-size: 14px;
        border-left: 5px solid ${borderColor};
        animation: slideIn 0.3s ease;
        max-width: 90%;
    `;

    document.body.appendChild(notification);

    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

function addToCartDirect(paketId, paketName, paketPrice) {
    let cart = localStorage.getItem('didinCart');

    cart = cart ? JSON.parse(cart) : [];

    const existing = cart.find(item => item.id === paketId);

    if (existing) {
        showNotification(`${paketName} sudah ada di keranjang!`, 'warning');
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

    updateCartBadge();
    showNotification(`${paketName} ditambahkan ke keranjang!`, 'success');
}

function initAuthModal() {
    const modal = document.getElementById('loginRegisterModal');

    if (!modal) {
        console.log('Modal login register tidak ditemukan');
        return;
    }

    console.log('✅ Auth modal aktif');

    const tabBtns = document.querySelectorAll('.modal-tab-btn');
    const loginFormWrapper = document.getElementById('loginForm');
    const registerFormWrapper = document.getElementById('registerForm');

    tabBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            const tab = this.getAttribute('data-tab');

            tabBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            if (tab === 'login') {
                loginFormWrapper.classList.remove('d-none');
                registerFormWrapper.classList.add('d-none');
            } else {
                loginFormWrapper.classList.add('d-none');
                registerFormWrapper.classList.remove('d-none');
            }
        });
    });

    const switchToRegister = document.querySelector('.switch-to-register');

    if (switchToRegister) {
        switchToRegister.addEventListener('click', function (e) {
            e.preventDefault();

            const registerTab = document.querySelector('.modal-tab-btn[data-tab="register"]');

            if (registerTab) {
                registerTab.click();
            }
        });
    }

    const switchToLogin = document.querySelector('.switch-to-login');

    if (switchToLogin) {
        switchToLogin.addEventListener('click', function (e) {
            e.preventDefault();

            const loginTab = document.querySelector('.modal-tab-btn[data-tab="login"]');

            if (loginTab) {
                loginTab.click();
            }
        });
    }

    const togglePasswordBtns = document.querySelectorAll('.toggle-password');

    togglePasswordBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            const input = this.closest('.input-group').querySelector('input');
            const icon = this.querySelector('i');

            if (!input || !icon) {
                return;
            }

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

    async function submitAjaxForm(form, loadingText) {
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn ? submitBtn.innerHTML : '';
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = loadingText;
        }

        showNotification('Memproses request...', 'info');

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken || ''
                },
                credentials: 'same-origin'
            });

            const data = await response.json().catch(() => null);

            console.log('AUTH RESPONSE:', response.status, data);

            if (!response.ok) {
                let message = 'Terjadi kesalahan. Silakan coba lagi.';

                if (data && data.message) {
                    message = data.message;
                }

                if (data && data.errors) {
                    const firstErrorKey = Object.keys(data.errors)[0];

                    if (firstErrorKey && data.errors[firstErrorKey][0]) {
                        message = data.errors[firstErrorKey][0];
                    }
                }

                showNotification(message, 'error');
                return;
            }

            showNotification(data?.message || 'Berhasil.', 'success');

            setTimeout(() => {
                if (data && data.redirect) {
                    window.location.href = data.redirect;
                } else {
                    window.location.reload();
                }
            }, 800);

        } catch (error) {
            console.error('AUTH ERROR:', error);
            showNotification('Gagal terhubung ke server. Cek route atau koneksi.', 'error');
        } finally {
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            }
        }
    }

    const formLogin = document.getElementById('formLogin');

    if (formLogin) {
        formLogin.addEventListener('submit', function (e) {
            e.preventDefault();

            console.log('Login button clicked');

            const email = this.querySelector('input[name="email"]')?.value;
            const password = this.querySelector('input[name="password"]')?.value;

            if (!email || !password) {
                showNotification('Harap isi email dan password!', 'warning');
                return;
            }

            submitAjaxForm(this, 'Memproses...');
        });
    } else {
        console.log('Form login dengan id formLogin tidak ditemukan');
    }

    const formRegister = document.getElementById('formRegister');

    if (formRegister) {
        formRegister.addEventListener('submit', function (e) {
            e.preventDefault();

            console.log('Register button clicked');

            const name = this.querySelector('input[name="name"]')?.value;
            const email = this.querySelector('input[name="email"]')?.value;
            const phone = this.querySelector('input[name="phone"]')?.value;
            const password = this.querySelector('input[name="password"]')?.value;
            const confirmPassword = this.querySelector('input[name="password_confirmation"]')?.value;
            const terms = this.querySelector('input[name="terms"]')?.checked;

            console.log({
                name,
                email,
                phone,
                password,
                confirmPassword,
                terms
            });

            if (!name || !email || !password || !confirmPassword) {
                showNotification('Harap isi semua field wajib!', 'warning');
                return;
            }

            if (password !== confirmPassword) {
                showNotification('Password tidak cocok!', 'error');
                return;
            }

            if (password.length < 6) {
                showNotification('Password minimal 6 karakter!', 'warning');
                return;
            }

            if (!terms) {
                showNotification('Harap setuju dengan Syarat & Ketentuan!', 'warning');
                return;
            }

            submitAjaxForm(this, 'Mendaftarkan...');
        });
    } else {
        console.log('Form register dengan id formRegister tidak ditemukan');
    }

    const formForgotPassword = document.getElementById('formForgotPassword');

    if (formForgotPassword) {
        formForgotPassword.addEventListener('submit', function (e) {
            e.preventDefault();

            const email = this.querySelector('input[name="email"]')?.value;

            if (!email) {
                showNotification('Masukkan email Anda!', 'warning');
                return;
            }

            submitAjaxForm(this, 'Mengirim...');
        });
    }
}

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
`;

document.head.appendChild(style);