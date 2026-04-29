/**
 * HISTORY.JS - Halaman History Booking
 *
 * Data history berasal dari Laravel database lewat:
 * window.DIDIN_HISTORY
 *
 * Tidak memakai localStorage.
 * Tidak membuat data demo.
 */

let allHistory = [];
let currentFilter = 'all';
let currentSearch = '';

// ==================== INIT ====================
document.addEventListener('DOMContentLoaded', function () {
    loadHistory();
    initFilters();
    initBackToTop();
});

// ==================== LOAD DATA ====================
function loadHistory() {
    allHistory = Array.isArray(window.DIDIN_HISTORY) ? window.DIDIN_HISTORY : [];

    updateStats();
    renderHistory();
}

// ==================== UPDATE STATISTIK ====================
function updateStats() {
    const completed = allHistory.filter(item => item.statusCode === 'completed').length;
    const cancelled = allHistory.filter(item => item.statusCode === 'cancelled').length;

    const totalSpent = allHistory
        .filter(item => item.statusCode === 'completed')
        .reduce((sum, item) => sum + Number(item.totalPrice || 0), 0);

    setText('totalCompleted', completed);
    setText('totalCancelled', cancelled);
    setText('totalSpent', formatRupiah(totalSpent));
}

// ==================== RENDER HISTORY ====================
function renderHistory() {
    const container = document.getElementById('historyContainer');
    const emptyContainer = document.getElementById('emptyHistory');

    if (!container) return;

    let filteredHistory = [...allHistory];

    if (currentFilter !== 'all') {
        filteredHistory = filteredHistory.filter(item => item.statusCode === currentFilter);
    }

    if (currentSearch) {
        const keyword = currentSearch.toLowerCase();

        filteredHistory = filteredHistory.filter(order => {
            const item = getFirstHistoryItem(order);

            return String(order.orderId || '').toLowerCase().includes(keyword) ||
                String(order.status || '').toLowerCase().includes(keyword) ||
                String(order.paymentStatus || '').toLowerCase().includes(keyword) ||
                String(item?.name || '').toLowerCase().includes(keyword) ||
                String(item?.location || '').toLowerCase().includes(keyword) ||
                String(item?.fullAddress || '').toLowerCase().includes(keyword) ||
                String(item?.customerName || '').toLowerCase().includes(keyword) ||
                String(item?.customerPhone || '').toLowerCase().includes(keyword);
        });
    }

    if (filteredHistory.length === 0) {
        container.style.display = 'none';

        if (emptyContainer) {
            emptyContainer.style.display = 'block';
        }

        return;
    }

    container.style.display = 'block';
    container.innerHTML = filteredHistory.map(order => renderHistoryCard(order)).join('');

    if (emptyContainer) {
        emptyContainer.style.display = 'none';
    }
}

// ==================== RENDER CARD ====================
function renderHistoryCard(order) {
    const item = getFirstHistoryItem(order);

    if (!item) return '';

    const eventDate = item.date ? formatDate(item.date) : 'Belum ditentukan';
    const orderDate = order.orderDate ? formatDate(order.orderDate) : '-';

    const isCompleted = order.statusCode === 'completed';
    const statusClass = isCompleted ? 'status-completed' : 'status-cancelled';
    const statusColor = isCompleted ? '#28a745' : '#dc3545';

    const addons = Array.isArray(item.addons) ? item.addons : [];
    const totalAddons = Number(order.subtotalAddons || 0);
    const shippingFee = Number(item.shippingFee || order.shippingFee || 0);
    const distance = Number(item.distance || 0);

    return `
        <div class="history-card" style="--status-color: ${statusColor}">
            <div class="history-status ${statusClass}">
                ${escapeHtml(order.status || (isCompleted ? 'Selesai' : 'Dibatalkan'))}
            </div>
            
            <div class="history-header-card">
                <div class="history-title">
                    <h3>${escapeHtml(item.name || 'Paket')}</h3>
                    <div class="history-order-id">
                        <i class="bi bi-upc-scan"></i> ${escapeHtml(order.orderId || '-')}
                    </div>
                </div>
            </div>
            
            <div class="history-details">
                <div class="detail-item">
                    <i class="bi bi-calendar"></i>
                    <span>📅 ${eventDate}</span>
                </div>

                <div class="detail-item">
                    <i class="bi bi-geo-alt"></i>
                    <span>📍 ${escapeHtml(item.location || 'Lokasi tidak tersedia')}</span>
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
                    <span>👤 ${escapeHtml(item.customerName || 'Nama tidak tersedia')}</span>
                </div>

                <div class="detail-item">
                    <i class="bi bi-calendar-check"></i>
                    <span>📆 Pesan: ${orderDate}</span>
                </div>

                <div class="detail-item">
                    <i class="bi bi-credit-card"></i>
                    <span>💳 Pembayaran: ${escapeHtml(paymentStatusLabel(order.paymentStatus))}</span>
                </div>
            </div>
            
            ${renderAddonsHtml(addons)}
            ${renderCancelledReason(order)}
            ${renderRatingHtml(order)}
            
            <div class="history-price">
                <div class="price-total">
                    💰 Total: ${formatRupiah(order.totalPrice || 0)}
                    ${totalAddons > 0 ? '<span>(termasuk add-ons)</span>' : ''}
                </div>

                ${shippingFee > 0 ? `
                    <div class="price-shipping">
                        <small>✓ Sudah termasuk biaya pengiriman</small>
                    </div>
                ` : ''}
            </div>
            
            <div class="history-actions">
                <button class="action-btn action-btn-outline" onclick="viewHistoryDetail('${escapeAttribute(order.orderId)}')">
                    <i class="bi bi-eye"></i> Detail
                </button>

                <button class="action-btn action-btn-outline" onclick="viewInvoice('${escapeAttribute(order.orderId)}')">
                    <i class="bi bi-download"></i> Invoice
                </button>

                ${isCompleted ? `
                    <button class="action-btn action-btn-primary" onclick="reorderHistory('${escapeAttribute(order.orderId)}')">
                        <i class="bi bi-arrow-repeat"></i> Pesan Lagi
                    </button>
                ` : ''}
            </div>
        </div>
    `;
}

function renderAddonsHtml(addons) {
    if (!addons || addons.length === 0) return '';

    return `
        <div class="history-addons">
            <div class="addons-header">
                <i class="bi bi-plus-circle"></i> Add-ons:
            </div>

            <ul class="addons-list">
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

function renderRatingHtml(order) {
    if (!order.rating) return '';

    return `
        <div class="rating-display">
            <div class="rating-stars-display">
                ${renderStarsHtml(order.rating)}
            </div>
            <div class="rating-text">
                ${escapeHtml(order.review || 'Tidak ada komentar')}
            </div>
        </div>
    `;
}

function renderCancelledReason(order) {
    if (order.statusCode !== 'cancelled' || !order.cancelledReason) return '';

    return `
        <div class="history-addons" style="background: rgba(220, 53, 69, 0.05); border-left: 3px solid #dc3545;">
            <div class="addons-header" style="color: #dc3545;">
                <i class="bi bi-info-circle"></i> Alasan Pembatalan:
            </div>
            <div style="font-size: 0.85rem; color: var(--gray-700);">
                ${escapeHtml(order.cancelledReason)}
            </div>
        </div>
    `;
}

// ==================== DETAIL MODAL ====================
function viewHistoryDetail(orderId) {
    const order = allHistory.find(item => item.orderId === orderId);

    if (!order) return;

    const item = getFirstHistoryItem(order);
    const modalBody = document.getElementById('detailModalBody');

    if (!item || !modalBody) return;

    const addons = Array.isArray(item.addons) ? item.addons : [];
    const shippingFee = Number(item.shippingFee || order.shippingFee || 0);
    const distance = Number(item.distance || 0);
    const isCompleted = order.statusCode === 'completed';

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

    const ratingHtml = order.rating
        ? `
            <hr>
            <h6><i class="bi bi-star-fill text-warning"></i> Rating & Review:</h6>
            <div class="mb-2">${renderStarsHtml(order.rating)}</div>
            <p class="text-muted">${escapeHtml(order.review || 'Tidak ada komentar')}</p>
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
                    <span class="badge ${isCompleted ? 'bg-success' : 'bg-danger'}">
                        ${escapeHtml(order.status || (isCompleted ? 'Selesai' : 'Dibatalkan'))}
                    </span>
                </p>

                <p>
                    <strong><i class="bi bi-credit-card"></i> Status Pembayaran</strong><br>
                    ${escapeHtml(paymentStatusLabel(order.paymentStatus))}
                </p>

                <p>
                    <strong><i class="bi bi-cash-stack"></i> Total</strong><br>
                    <span class="text-primary fw-bold">${formatRupiah(order.totalPrice || 0)}</span>
                </p>
            </div>
        </div>

        ${addonsHtml}
        ${ratingHtml}

        ${order.cancelledReason ? `
            <hr>
            <p>
                <strong><i class="bi bi-info-circle text-danger"></i> Alasan Pembatalan:</strong><br>
                ${escapeHtml(order.cancelledReason)}
            </p>
        ` : ''}

        ${order.notes ? `
            <hr>
            <p>
                <strong>Catatan:</strong><br>
                ${escapeHtml(order.notes)}
            </p>
        ` : ''}
    `;

    const reorderBtn = document.getElementById('reorderFromDetailBtn');
    const invoiceBtn = document.getElementById('invoiceFromDetailBtn');

    if (reorderBtn) {
        reorderBtn.style.display = isCompleted ? 'inline-block' : 'none';
        reorderBtn.onclick = function () {
            reorderHistory(orderId);
        };
    }

    if (invoiceBtn) {
        invoiceBtn.onclick = function () {
            viewInvoice(orderId);
        };
    }

    const modal = new bootstrap.Modal(document.getElementById('detailModal'));
    modal.show();
}

// ==================== ACTIONS ====================
function viewInvoice(orderId) {
    const order = allHistory.find(item => item.orderId === orderId);

    if (!order) return;

    if (!order.invoiceUrl) {
        notifyHistory('Link invoice belum tersedia.', 'warning');
        return;
    }

    window.open(order.invoiceUrl, '_blank');
}

function reorderHistory(orderId) {
    const order = allHistory.find(item => item.orderId === orderId);
    const item = getFirstHistoryItem(order);

    if (item?.id) {
        window.location.href = `${window.DIDIN_HISTORY_ROUTES?.paketDetail || '/paket'}?id=${encodeURIComponent(item.id)}`;
        return;
    }

    window.location.href = window.DIDIN_HISTORY_ROUTES?.paketIndex || '/#paket';
}

// ==================== FILTER & SEARCH ====================
function initFilters() {
    const filterButtons = document.querySelectorAll('.filter-btn');

    filterButtons.forEach(button => {
        button.addEventListener('click', function () {
            filterButtons.forEach(item => item.classList.remove('active'));

            this.classList.add('active');
            currentFilter = this.dataset.filter || 'all';

            renderHistory();
        });
    });

    const searchInput = document.getElementById('searchInput');

    if (searchInput) {
        searchInput.addEventListener('input', function () {
            currentSearch = this.value.trim();
            renderHistory();
        });
    }
}

// ==================== BACK TO TOP ====================
function initBackToTop() {
    const backToTop = document.getElementById('backToTop');

    if (!backToTop) return;

    window.addEventListener('scroll', function () {
        backToTop.classList.toggle('show', window.scrollY > 300);
    });

    backToTop.addEventListener('click', function () {
        window.scrollTo({
            top: 0,
            behavior: 'smooth',
        });
    });
}

// ==================== HELPERS ====================
function getFirstHistoryItem(order) {
    if (!order || !Array.isArray(order.items) || order.items.length === 0) {
        return null;
    }

    return order.items[0];
}

function setText(id, value) {
    const element = document.getElementById(id);

    if (element) {
        element.textContent = value;
    }
}

function paymentStatusLabel(paymentStatus) {
    const status = String(paymentStatus || '').toLowerCase();

    const labels = {
        unpaid: 'Belum Dibayar',
        pending: 'Pending',
        paid: 'Lunas',
        expired: 'Expired',
        failed: 'Gagal',
        cancelled: 'Dibatalkan',
        refunded: 'Refund',
    };

    return labels[status] || paymentStatus || '-';
}

function renderStarsHtml(rating) {
    const value = Number(rating || 0);
    let html = '';

    for (let i = 1; i <= 5; i++) {
        html += `<i class="bi ${i <= value ? 'bi-star-fill' : 'bi-star'}"></i>`;
    }

    return html;
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

function notifyHistory(message, type = 'info') {
    if (typeof window.showNotification === 'function') {
        window.showNotification(message, type);
        return;
    }

    alert(message);
}