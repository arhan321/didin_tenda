/**
 * SCRIPT.JS - Didin Tenda Decoration
 * Versi backend session cart Laravel.
 * File ini aman dipakai untuk index, paket, cart, profile, pesanan, dan history.
 */

document.addEventListener('DOMContentLoaded', function () {
    initAOS();
    initNavbarScroll();
    initBackToTop();
    initSmoothScroll();
    initMobileMenu();
    initTooltips();
    initAuthModal();
    initPasswordToggle();
    initQuickCheck();
    updateCartBadge();
});

function initAOS() {
    if (typeof AOS !== 'undefined' && window.innerWidth >= 768) {
        AOS.init({
            duration: 800,
            once: true,
            offset: 50,
            easing: 'ease-out',
            delay: 50
        });
    }
}

function initNavbarScroll() {
    const navbar = document.querySelector('.navbar');
    if (!navbar) return;

    window.addEventListener('scroll', function () {
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
            navbar.style.boxShadow = '0 2px 20px rgba(0,0,0,0.3)';
        } else {
            navbar.classList.remove('scrolled');
            navbar.style.boxShadow = '0 2px 20px rgba(0,0,0,0.1)';
        }
    });
}

function initBackToTop() {
    const backToTop = document.getElementById('backToTop');
    if (!backToTop) return;

    window.addEventListener('scroll', function () {
        if (window.scrollY > 250) {
            backToTop.classList.add('show');
            backToTop.style.display = 'flex';
        } else {
            backToTop.classList.remove('show');
            backToTop.style.display = 'none';
        }
    });

    backToTop.addEventListener('click', function (event) {
        event.preventDefault();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
}

function initSmoothScroll() {
    const links = document.querySelectorAll('a[href*="#"]');

    links.forEach(link => {
        link.addEventListener('click', function (event) {
            const href = this.getAttribute('href');
            if (!href || href === '#') return;

            let url;
            try {
                url = new URL(href, window.location.origin);
            } catch (error) {
                return;
            }

            if (!url.hash || url.pathname !== window.location.pathname) return;

            const targetElement = document.querySelector(url.hash);
            if (!targetElement) return;

            event.preventDefault();
            const navbarHeight = document.querySelector('.navbar')?.offsetHeight || 70;
            const targetPosition = targetElement.offsetTop - navbarHeight;

            window.scrollTo({ top: targetPosition, behavior: 'smooth' });
        });
    });
}

function initMobileMenu() {
    const navbarToggler = document.querySelector('.navbar-toggler');
    const navbarCollapse = document.querySelector('.navbar-collapse');
    const navLinks = document.querySelectorAll('.navbar-nav .nav-link');

    if (!navbarCollapse || !navbarToggler) return;

    navLinks.forEach(link => {
        link.addEventListener('click', function () {
            if (window.innerWidth < 992 && navbarCollapse.classList.contains('show')) {
                navbarToggler.click();
            }
        });
    });
}

function initTooltips() {
    if (typeof bootstrap === 'undefined' || !bootstrap.Tooltip) return;

    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(element => {
        new bootstrap.Tooltip(element, {
            placement: 'bottom',
            offset: [0, 10]
        });
    });
}

function initAuthModal() {
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');
    const tabButtons = document.querySelectorAll('.modal-tab-btn, .switch-to-register, .switch-to-login');

    if (!loginForm || !registerForm || tabButtons.length === 0) return;

    function activateTab(tab) {
        const isLogin = tab === 'login';

        loginForm.classList.toggle('d-none', !isLogin);
        registerForm.classList.toggle('d-none', isLogin);

        document.querySelectorAll('.modal-tab-btn').forEach(button => {
            button.classList.toggle('active', button.dataset.tab === tab);
        });
    }

    tabButtons.forEach(button => {
        button.addEventListener('click', function (event) {
            event.preventDefault();
            activateTab(this.dataset.tab || 'login');
        });
    });
}

function initPasswordToggle() {
    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function () {
            const input = this.closest('.input-group')?.querySelector('input');
            const icon = this.querySelector('i');
            if (!input) return;

            input.type = input.type === 'password' ? 'text' : 'password';

            if (icon) {
                icon.classList.toggle('bi-eye');
                icon.classList.toggle('bi-eye-slash');
            }
        });
    });
}

function initQuickCheck() {
    const quickCard = document.querySelector('.quick-check-card');
    const button = document.getElementById('quickCheckBtn');
    const dateInput = document.getElementById('quickEventDate');
    const packageSelect = document.getElementById('quickPackage');

    if (!quickCard || !button || !dateInput || !packageSelect) return;

    button.addEventListener('click', async function (event) {
        event.preventDefault();

        if (!dateInput.value) {
            showNotification('Silakan pilih tanggal acara terlebih dahulu.', 'warning');
            return;
        }

        if (!packageSelect.value) {
            showNotification('Silakan pilih paket dekorasi.', 'warning');
            return;
        }

        const originalText = button.innerHTML;
        button.innerHTML = 'Mengecek...';
        button.disabled = true;

        try {
            const response = await fetch(quickCard.dataset.quickCheckUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': getCsrfToken()
                },
                body: JSON.stringify({
                    event_date: dateInput.value,
                    package_id: packageSelect.value
                })
            });

            const data = await response.json();

            showNotification(data.message || 'Pengecekan selesai.', data.available ? 'success' : 'error');

            if (data.available && data.package && data.package.slug) {
                setTimeout(function () {
                    window.location.href = quickCard.dataset.paketUrl + '?id=' + encodeURIComponent(data.package.slug);
                }, 900);
            }
        } catch (error) {
            showNotification('Terjadi kesalahan saat mengecek ketersediaan.', 'error');
        } finally {
            button.innerHTML = originalText;
            button.disabled = false;
        }
    });
}

function updateCartBadge() {
    const badges = document.querySelectorAll('.menu-badge');

    badges.forEach(badge => {
        const serverCount = badge.dataset.serverCartCount;

        if (serverCount !== undefined) {
            const count = parseInt(serverCount || '0', 10);
            badge.textContent = count;
            badge.style.display = count > 0 ? 'flex' : 'none';
            return;
        }

        // fallback untuk halaman lama yang masih memakai localStorage
        const savedCart = localStorage.getItem('didinCart');
        const cart = savedCart ? JSON.parse(savedCart) : [];
        const count = Array.isArray(cart) ? cart.length : 0;
        badge.textContent = count;
        badge.style.display = count > 0 ? 'flex' : 'none';
    });
}

function getCsrfToken() {
    return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
}

function formatRupiah(number) {
    return 'Rp ' + new Intl.NumberFormat('id-ID').format(Number(number || 0));
}

function showNotification(message, type = 'info') {
    const existing = document.querySelector('.custom-notification');
    if (existing) existing.remove();

    const notification = document.createElement('div');
    notification.className = 'custom-notification';
    notification.style.cssText = `
        position: fixed;
        top: 95px;
        right: 20px;
        z-index: 9999;
        min-width: 280px;
        max-width: 420px;
        padding: 14px 18px;
        border-radius: 12px;
        color: white;
        box-shadow: 0 12px 30px rgba(0,0,0,.18);
        font-weight: 500;
    `;

    const colors = {
        success: '#198754',
        error: '#dc3545',
        warning: '#f59f00',
        info: '#0d6efd'
    };

    notification.style.background = colors[type] || colors.info;
    notification.textContent = message;

    document.body.appendChild(notification);

    setTimeout(function () {
        notification.remove();
    }, 3500);
}
