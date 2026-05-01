/**
 * SCRIPT.JS - Didin Tenda Decoration
 * Versi backend session cart Laravel.
 * File ini aman dipakai untuk index, paket, cart, profile, pesanan, dan history.
 *
 * Fitur tambahan:
 * - Login/Register modal tab
 * - Auto buka modal ketika login/register/forgot/reset gagal
 * - Toggle password
 * - Quick check paket
 * - Cart badge dari backend session
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
    initAutoOpenModals();
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

    if (!navbar) {
        return;
    }

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

    if (!backToTop) {
        return;
    }

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

        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
}

function initSmoothScroll() {
    const links = document.querySelectorAll('a[href*="#"]');

    links.forEach(function (link) {
        link.addEventListener('click', function (event) {
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

            if (!url.hash || url.pathname !== window.location.pathname) {
                return;
            }

            const targetElement = document.querySelector(url.hash);

            if (!targetElement) {
                return;
            }

            event.preventDefault();

            const navbarHeight = document.querySelector('.navbar')?.offsetHeight || 70;
            const targetPosition = targetElement.offsetTop - navbarHeight;

            window.scrollTo({
                top: targetPosition,
                behavior: 'smooth'
            });
        });
    });
}

function initMobileMenu() {
    const navbarToggler = document.querySelector('.navbar-toggler');
    const navbarCollapse = document.querySelector('.navbar-collapse');
    const navLinks = document.querySelectorAll('.navbar-nav .nav-link');

    if (!navbarCollapse || !navbarToggler) {
        return;
    }

    navLinks.forEach(function (link) {
        link.addEventListener('click', function () {
            if (window.innerWidth < 992 && navbarCollapse.classList.contains('show')) {
                navbarToggler.click();
            }
        });
    });
}

function initTooltips() {
    if (typeof bootstrap === 'undefined' || !bootstrap.Tooltip) {
        return;
    }

    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(function (element) {
        new bootstrap.Tooltip(element, {
            placement: 'bottom',
            offset: [0, 10]
        });
    });
}

/**
 * ====================
 * AUTH MODAL
 * ====================
 */
function initAuthModal() {
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');

    if (!loginForm || !registerForm) {
        return;
    }

    const tabButtons = document.querySelectorAll(
        '.modal-tab-btn, .switch-to-register, .switch-to-login, [data-auth-tab]'
    );

    function activateTab(tab) {
        const isRegister = tab === 'register';

        loginForm.classList.toggle('d-none', isRegister);
        registerForm.classList.toggle('d-none', !isRegister);

        document.querySelectorAll('.modal-tab-btn').forEach(function (button) {
            button.classList.toggle('active', button.dataset.tab === tab);
        });
    }

    tabButtons.forEach(function (button) {
        button.addEventListener('click', function (event) {
            const tab = this.dataset.tab || this.dataset.authTab || 'login';

            event.preventDefault();

            activateTab(tab);

            const authModalElement = document.getElementById('loginRegisterModal');

            if (authModalElement && typeof bootstrap !== 'undefined') {
                new bootstrap.Modal(authModalElement).show();
            }
        });
    });

    window.didinActivateAuthTab = activateTab;
}

/**
 * Auto open modal dari Blade.
 *
 * Supaya ini jalan, di index.blade.php pastikan ada script seperti:
 *
 * <script>
 *     window.DIDIN_AUTH_MODAL = @json(session('open_auth_modal'));
 *     window.DIDIN_HAS_RESET_TOKEN = @json(request()->filled('reset_token'));
 * </script>
 */
function initAutoOpenModals() {
    if (typeof bootstrap === 'undefined') {
        return;
    }

    const openAuthModal = window.DIDIN_AUTH_MODAL || null;
    const hasResetToken = Boolean(window.DIDIN_HAS_RESET_TOKEN);

    if (hasResetToken) {
        const resetModalElement = document.getElementById('resetPasswordModal');

        if (resetModalElement) {
            new bootstrap.Modal(resetModalElement).show();
        }

        return;
    }

    if (openAuthModal === 'login' || openAuthModal === 'register') {
        const authModalElement = document.getElementById('loginRegisterModal');

        if (typeof window.didinActivateAuthTab === 'function') {
            window.didinActivateAuthTab(openAuthModal);
        }

        if (authModalElement) {
            new bootstrap.Modal(authModalElement).show();
        }

        return;
    }

    if (openAuthModal === 'forgot') {
        const forgotModalElement = document.getElementById('forgotPasswordModal');

        if (forgotModalElement) {
            new bootstrap.Modal(forgotModalElement).show();
        }
    }
}

function initPasswordToggle() {
    document.querySelectorAll('.toggle-password').forEach(function (button) {
        button.addEventListener('click', function () {
            const input = this.closest('.input-group')?.querySelector('input');
            const icon = this.querySelector('i');

            if (!input) {
                return;
            }

            input.type = input.type === 'password' ? 'text' : 'password';

            if (icon) {
                icon.classList.toggle('bi-eye');
                icon.classList.toggle('bi-eye-slash');
            }
        });
    });
}

/**
 * ====================
 * QUICK CHECK
 * ====================
 */
function initQuickCheck() {
    const quickCard = document.querySelector('.quick-check-card');
    const button = document.getElementById('quickCheckBtn');
    const dateInput = document.getElementById('quickEventDate');
    const packageSelect = document.getElementById('quickPackage');

    if (!quickCard || !button || !dateInput || !packageSelect) {
        return;
    }

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

            showNotification(
                data.message || 'Pengecekan selesai.',
                data.available ? 'success' : 'error'
            );

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

/**
 * ====================
 * CART BADGE
 * ====================
 */
function updateCartBadge() {
    const badges = document.querySelectorAll('.menu-badge');

    badges.forEach(function (badge) {
        const serverCount = badge.dataset.serverCartCount;

        if (serverCount !== undefined) {
            const count = parseInt(serverCount || '0', 10);

            badge.textContent = count;
            badge.style.display = count > 0 ? 'flex' : 'none';

            return;
        }

        const savedCart = localStorage.getItem('didinCart');
        const cart = savedCart ? JSON.parse(savedCart) : [];
        const count = Array.isArray(cart) ? cart.length : 0;

        badge.textContent = count;
        badge.style.display = count > 0 ? 'flex' : 'none';
    });
}

/**
 * ====================
 * HELPERS
 * ====================
 */
function getCsrfToken() {
    return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
}

function formatRupiah(number) {
    return 'Rp ' + new Intl.NumberFormat('id-ID').format(Number(number || 0));
}

function showNotification(message, type = 'info') {
    const existing = document.querySelector('.custom-notification');

    if (existing) {
        existing.remove();
    }

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