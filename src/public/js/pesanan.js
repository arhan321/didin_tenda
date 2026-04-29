/**
 * PESANAN.JS - Halaman Pesanan Saya
 *
 * Data pesanan berasal dari Laravel database lewat:
 * window.DIDIN_ORDERS
 *
 * Tidak memakai localStorage.
 * Tidak membuat data demo.
 */

let allOrders = [];
let currentFilter = 'all';
let currentSearch = '';
let currentRatingOrderId = null;

document.addEventListener('DOMContentLoaded', function () {
    loadOrders();
    initFilters();
    initSearch();
    initRatingStars();
});

// ==================== LOAD DATA ====================
function loadOrders() {
    allOrders = Array.isArray(window.DIDIN_ORDERS) ? window.DIDIN_ORDERS : [];
    renderOrders();
}

// ==================== RENDER ORDERS ====================
function renderOrders() {
    const container = document.getElementById('ordersContainer');
    const emptyContainer = document.getElementById('emptyOrders');

    if (!container) return;

    let filteredOrders = [...allOrders];

    if (currentFilter !== 'all') {
        if (currentFilter === 'active') {
            filteredOrders = filteredOrders.filter(order =>
                order.statusCode !== 'completed' &&
                order.statusCode !== 'cancelled'
            );
        }

        if (currentFilter === 'completed') {
            filteredOrders = filteredOrders.filter(order => order.statusCode === 'completed');
        }

        if (currentFilter === 'cancelled') {
            filteredOrders = filteredOrders.filter(order => order.statusCode === 'cancelled');
        }
    }

    if (currentSearch) {
        const keyword = currentSearch.toLowerCase();

        filteredOrders = filteredOrders.filter(order => {
            const item = getFirstOrderItem(order);

            return String(order.orderId || '').toLowerCase().includes(keyword) ||
                String(order.status || '').toLowerCase().includes(keyword) ||
                String(order.paymentStatus || '').toLowerCase().includes(keyword) ||
                String(item.name || '').toLowerCase().includes(keyword) ||
                String(item.location || '').toLowerCase().includes(keyword) ||
                String(item.fullAddress || '').toLowerCase().includes(keyword) ||
                String(item.customerName || '').toLowerCase().includes(keyword) ||
                String(item.customerPhone || '').toLowerCase().includes(keyword);
        });
    }

    if (filteredOrders.length === 0) {
        container.style.display = 'none';

        if (emptyContainer) {
            emptyContainer.style.display = 'block';
        }

        return;
    }

    container.style.display = 'block';
    container.innerHTML = filteredOrders.map(order => renderOrderCard(order)).join('');

    if (emptyContainer) {
        emptyContainer.style.display = 'none';
    }
}

function renderOrderCard(order) {
    const item = getFirstOrderItem(order);

    if (!item) return '';

    const eventDate = item.date ? formatDate(item.date) : 'Belum ditentukan';
    const orderDate = order.orderDate ? formatDate(order.orderDate) : '-';
    const statusInfo = getStatusInfo(order.statusCode);

    const shippingFee = Number(item.shippingFee || order.shippingFee || 0);
    const distance = Number(item.distance || 0);
    const addons = Array.isArray(item.addons) ? item.addons : [];
    const totalAddons = Number(order.subtotalAddons || 0);

    return `
        <div class="order-card" style="--status-color: ${statusInfo.color}">
            <div class="order-status ${statusInfo.class}">
                ${escapeHtml(order.status || 'Menunggu Pembayaran')}
            </div>

            <div class="order-header">
                <div class="order-title">
                    <h3>${escapeHtml(item.name || 'Paket')}</h3>
                    <div class="order-id">
                        <i class="bi bi-upc-scan"></i> ${escapeHtml(order.orderId || '-')}
                    </div>
                </div>
            </div>

            <div class="order-details">
                <div class="detail-item">
                    <i class="bi bi-calendar"></i>
                    <span>📅 ${eventDate}</span>
                </div>

                <div class="detail-item">
                    <i class="bi bi-geo-alt"></i>
                    <span>📍 ${escapeHtml(item.location || 'Lokasi belum diisi')}</span>
                </div>

                <div class="detail-item">
                    <i class="bi bi-truck"></i>
                    <span>
                        🚚 Jarak:
                        ${distance > 0 ? distance.toFixed(1) + ' km' : 'Belum dihitung'}
                        |
                        Ongkir:
                        ${shippingFee === 0 ? 'GRATIS' : formatRupiah(shippingFee)}
                    </span>
                </div>

                <div class="detail-item">
                    <i class="bi bi-person"></i>
                    <span>👤 ${escapeHtml(item.customerName || 'Nama belum diisi')}</span>
                </div>

                <div class="detail-item">
                    <i class="bi bi-whatsapp"></i>
                    <span>📱 ${escapeHtml(item.customerPhone || 'No. WA belum diisi')}</span>
                </div>

                <div class="detail-item">
                    <i class="bi bi-calendar-check"></i>
                    <span>📆 Pesan: ${orderDate}</span>
                </div>
            </div>

            ${renderAddonsHtml(addons)}

            <div class="order-price">
                <div class="price-total">
                    💰 Total: ${formatRupiah(order.totalPrice || 0)}
                    ${totalAddons > 0 ? '<span>(sudah termasuk add-ons)</span>' : ''}
                </div>

                ${shippingFee > 0 ? `
                    <div class="price-shipping">
                        <small>✓ Sudah termasuk biaya pengiriman</small>
                    </div>
                ` : ''}
            </div>

            <div class="order-actions">
                <button class="action-btn action-btn-outline" onclick="viewOrderDetail('${escapeAttribute(order.orderId)}')">
                    <i class="bi bi-eye"></i> Detail
                </button>

                ${renderActionButtons(order)}
            </div>
        </div>
    `;
}

function renderAddonsHtml(addons) {
    if (!addons || addons.length === 0) return '';

    return `
        <div class="order-items">
            <div class="order-items-header">
                <i class="bi bi-plus-circle"></i> Add-ons yang dipilih:
            </div>

            <ul class="order-addons-list">
                ${addons.map(addon => {
                    const quantity = Number(addon.quantity || 1);
                    const unit = addon.unit || 'pcs';
                    const qtyText = quantity > 1 ? ` (${quantity} ${unit})` : '';
                    const totalPrice = Number(addon.totalPrice || addon.total_price || addon.price || 0);

                    return `
                        <li>
                            <span>${escapeHtml(addon.name || 'Add-on')}${escapeHtml(qtyText)}</span>
                            <span class="addon-price">${formatRupiah(totalPrice)}</span>
                        </li>
                    `;
                }).join('')}
            </ul>
        </div>
    `;
}

function renderActionButtons(order) {
    const orderId = escapeAttribute(order.orderId);

    if (order.statusCode === 'waiting_payment') {
        return `
            <button class="action-btn action-btn-success" onclick="showPaymentInfo('${orderId}')">
                <i class="bi bi-credit-card"></i> Lanjut Bayar
            </button>

            <button class="action-btn action-btn-outline" onclick="viewInvoice('${orderId}')">
                <i class="bi bi-download"></i> Invoice
            </button>

            <button class="action-btn action-btn-warning" onclick="contactAdmin('${orderId}')">
                <i class="bi bi-whatsapp"></i> Hubungi Admin
            </button>
        `;
    }

    if (
        order.statusCode === 'confirmed' ||
        order.statusCode === 'processing' ||
        order.statusCode === 'ongoing'
    ) {
        return `
            <button class="action-btn action-btn-outline" onclick="viewInvoice('${orderId}')">
                <i class="bi bi-download"></i> Invoice
            </button>

            <button class="action-btn action-btn-warning" onclick="contactAdmin('${orderId}')">
                <i class="bi bi-whatsapp"></i> Hubungi Admin
            </button>
        `;
    }

    if (order.statusCode === 'completed') {
        return `
            <button class="action-btn action-btn-outline" onclick="viewInvoice('${orderId}')">
                <i class="bi bi-download"></i> Invoice
            </button>

            <button class="action-btn action-btn-outline" onclick="openRatingModal('${orderId}')">
                <i class="bi bi-star-fill"></i> Beri Rating
            </button>

            <button class="action-btn action-btn-warning" onclick="contactAdmin('${orderId}')">
                <i class="bi bi-whatsapp"></i> Hubungi Admin
            </button>
        `;
    }

    if (order.statusCode === 'cancelled') {
        return `
            <button class="action-btn action-btn-outline" onclick="reorder('${orderId}')">
                <i class="bi bi-arrow-repeat"></i> Pesan Lagi
            </button>
        `;
    }

    return '';
}

// ==================== DETAIL MODAL ====================
function viewOrderDetail(orderId) {
    const order = allOrders.find(item => item.orderId === orderId);

    if (!order) return;

    const item = getFirstOrderItem(order);
    const modalBody = document.getElementById('detailModalBody');

    if (!item || !modalBody) return;

    const shippingFee = Number(item.shippingFee || order.shippingFee || 0);
    const distance = Number(item.distance || 0);
    const addons = Array.isArray(item.addons) ? item.addons : [];
    const statusInfo = getStatusInfo(order.statusCode);

    const addonsHtml = addons.length > 0
        ? `
            <h6 class="mt-3"><i class="bi bi-plus-circle"></i> Add-ons:</h6>
            <ul class="list-unstyled">
                ${addons.map(addon => {
                    const quantity = Number(addon.quantity || 1);
                    const unit = addon.unit || 'pcs';
                    const totalPrice = Number(addon.totalPrice || addon.total_price || addon.price || 0);

                    return `
                        <li class="d-flex justify-content-between mb-2">
                            <span>
                                ${escapeHtml(addon.name || 'Add-on')}
                                ${quantity > 1 ? `(${quantity} ${escapeHtml(unit)})` : ''}
                            </span>
                            <span class="text-primary">${formatRupiah(totalPrice)}</span>
                        </li>
                    `;
                }).join('')}
            </ul>
        `
        : '';

    modalBody.innerHTML = `
        <div class="row">
            <div class="col-md-6">
                <p>
                    <strong><i class="bi bi-upc-scan"></i> Invoice</strong><br>
                    ${escapeHtml(order.orderId || '-')}
                </p>

                <p>
                    <strong><i class="bi bi-tag"></i> Paket</strong><br>
                    ${escapeHtml(item.name || 'Paket')}
                </p>

                <p>
                    <strong><i class="bi bi-calendar"></i> Tanggal Acara</strong><br>
                    ${formatDate(item.date)}
                </p>

                <p>
                    <strong><i class="bi bi-geo-alt"></i> Lokasi</strong><br>
                    ${escapeHtml(item.location || 'Belum diisi')}
                </p>

                <p>
                    <strong><i class="bi bi-map"></i> Alamat Lengkap</strong><br>
                    ${escapeHtml(item.fullAddress || 'Belum diisi')}
                </p>

                <p>
                    <strong><i class="bi bi-truck"></i> Biaya Pengiriman</strong><br>
                    ${shippingFee === 0 ? 'GRATIS' : formatRupiah(shippingFee)}
                    ${distance > 0 ? `(Jarak: ${distance.toFixed(1)} km)` : ''}
                </p>
            </div>

            <div class="col-md-6">
                <p>
                    <strong><i class="bi bi-person"></i> Nama</strong><br>
                    ${escapeHtml(item.customerName || 'Belum diisi')}
                </p>

                <p>
                    <strong><i class="bi bi-whatsapp"></i> WhatsApp</strong><br>
                    ${escapeHtml(item.customerPhone || 'Belum diisi')}
                </p>

                <p>
                    <strong><i class="bi bi-envelope"></i> Email</strong><br>
                    ${escapeHtml(item.customerEmail || '-')}
                </p>

                <p>
                    <strong><i class="bi bi-clock-history"></i> Status</strong><br>
                    <span class="badge ${statusInfo.class}">
                        ${escapeHtml(order.status || '-')}
                    </span>
                </p>

                <p>
                    <strong><i class="bi bi-credit-card"></i> Status Pembayaran</strong><br>
                    ${escapeHtml(order.paymentStatus || '-')}
                </p>

                <p>
                    <strong><i class="bi bi-cash-stack"></i> Total</strong><br>
                    <span class="text-primary fw-bold">${formatRupiah(order.totalPrice || 0)}</span>
                </p>
            </div>
        </div>

        ${addonsHtml}

        ${order.notes ? `<hr><p><strong>Catatan:</strong><br>${escapeHtml(order.notes)}</p>` : ''}
        ${order.review ? `<hr><p><strong><i class="bi bi-star-fill text-warning"></i> Review:</strong><br>${escapeHtml(order.review)}</p>` : ''}
    `;

    const modal = new bootstrap.Modal(document.getElementById('detailModal'));
    modal.show();
}

// ==================== ACTIONS ====================
function contactAdmin(orderId) {
    const order = allOrders.find(item => item.orderId === orderId);

    if (!order) return;

    const item = getFirstOrderItem(order);

    const message =
        `Halo Admin Didin Tenda, saya ingin menanyakan pesanan saya:\n\n` +
        `Invoice: ${order.orderId || '-'}\n` +
        `Paket: ${item?.name || '-'}\n` +
        `Tanggal Acara: ${item?.date || '-'}\n` +
        `Lokasi: ${item?.location || '-'}\n\n` +
        `Terima kasih.`;

    window.open(`https://wa.me/6288289258764?text=${encodeURIComponent(message)}`, '_blank');
}

function showPaymentInfo(orderId) {
    const order = allOrders.find(item => item.orderId === orderId);

    if (!order) return;

    notifyPesanan(
        `Invoice ${order.orderId} masih menunggu pembayaran. Integrasi Midtrans bisa disambungkan di tahap berikutnya.`,
        'info'
    );
}

function viewInvoice(orderId) {
    const order = allOrders.find(item => item.orderId === orderId);

    if (!order) return;

    if (!order.invoiceUrl) {
        notifyPesanan('Link invoice belum tersedia.', 'warning');
        return;
    }

    window.open(order.invoiceUrl, '_blank');
}

function reorder(orderId) {
    const order = allOrders.find(item => item.orderId === orderId);
    const item = getFirstOrderItem(order);

    if (item?.id) {
        window.location.href = `/paket?id=${encodeURIComponent(item.id)}`;
        return;
    }

    window.location.href = window.DIDIN_PESANAN_ROUTES?.paketIndex || '/#paket';
}

// ==================== RATING ====================
function openRatingModal(orderId) {
    currentRatingOrderId = orderId;

    document.querySelectorAll('#ratingModal .rating-stars i').forEach(star => {
        star.classList.remove('active');
        star.classList.remove('bi-star-fill');
        star.classList.add('bi-star');
    });

    const textarea = document.querySelector('#ratingModal textarea');

    if (textarea) {
        textarea.value = '';
    }

    const modal = new bootstrap.Modal(document.getElementById('ratingModal'));
    modal.show();
}

function submitRating() {
    if (!currentRatingOrderId) return;

    const stars = document.querySelectorAll('#ratingModal .rating-stars i.active');
    const rating = stars.length;

    if (rating === 0) {
        notifyPesanan('Silakan pilih rating bintang terlebih dahulu.', 'warning');
        return;
    }

    notifyPesanan('Fitur simpan rating ke database akan disambungkan di tahap berikutnya.', 'info');

    const modal = bootstrap.Modal.getInstance(document.getElementById('ratingModal'));

    if (modal) {
        modal.hide();
    }
}

function initRatingStars() {
    const stars = document.querySelectorAll('#ratingModal .rating-stars i');

    stars.forEach(star => {
        star.addEventListener('click', function () {
            const rating = Number(this.dataset.rating || 0);

            stars.forEach((item, index) => {
                const active = index < rating;

                item.classList.toggle('active', active);
                item.classList.toggle('bi-star-fill', active);
                item.classList.toggle('bi-star', !active);
            });
        });
    });

    const submitBtn = document.getElementById('submitRatingBtn');

    if (submitBtn) {
        submitBtn.addEventListener('click', submitRating);
    }
}

// ==================== FILTER & SEARCH ====================
function initFilters() {
    const filterButtons = document.querySelectorAll('.filter-btn');

    filterButtons.forEach(button => {
        button.addEventListener('click', function () {
            filterButtons.forEach(item => item.classList.remove('active'));

            this.classList.add('active');
            currentFilter = this.dataset.filter || 'all';

            renderOrders();
        });
    });
}

function initSearch() {
    const searchInput = document.getElementById('searchInput');

    if (!searchInput) return;

    searchInput.addEventListener('input', function () {
        currentSearch = this.value.trim();
        renderOrders();
    });
}

// ==================== HELPERS ====================
function getFirstOrderItem(order) {
    if (!order || !Array.isArray(order.items) || order.items.length === 0) {
        return null;
    }

    return order.items[0];
}

function getStatusInfo(statusCode) {
    const statusMap = {
        waiting_payment: {
            color: '#ffc107',
            class: 'status-warning',
        },
        confirmed: {
            color: '#17a2b8',
            class: 'status-info',
        },
        processing: {
            color: '#2c7be5',
            class: 'status-primary',
        },
        ongoing: {
            color: '#28a745',
            class: 'status-success',
        },
        completed: {
            color: '#6c757d',
            class: 'status-secondary',
        },
        cancelled: {
            color: '#dc3545',
            class: 'status-danger',
        },
    };

    return statusMap[statusCode] || statusMap.waiting_payment;
}

function formatDate(dateString) {
    if (!dateString) return 'Belum ditentukan';

    const date = new Date(dateString);

    if (Number.isNaN(date.getTime())) {
        return dateString;
    }

    return date.toLocaleDateString('id-ID', {
        day: '2-digit',
        month: 'long',
        year: 'numeric',
    });
}

function formatRupiah(number) {
    return 'Rp ' + new Intl.NumberFormat('id-ID').format(Number(number || 0));
}

function escapeHtml(value) {
    if (value === null || value === undefined) {
        return '';
    }

    return String(value)
        .replaceAll('&', '&amp;')
        .replaceAll('<', '&lt;')
        .replaceAll('>', '&gt;')
        .replaceAll('"', '&quot;')
        .replaceAll("'", '&#039;');
}

function escapeAttribute(value) {
    return escapeHtml(value).replaceAll('`', '&#096;');
}

function notifyPesanan(message, type = 'info') {
    if (typeof window.showNotification === 'function') {
        window.showNotification(message, type);
        return;
    }

    alert(message);
}