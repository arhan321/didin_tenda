/**
 * PESANAN.JS - Halaman Pesanan Saya
 *
 * Data pesanan berasal dari Laravel database lewat:
 * window.DIDIN_ORDERS
 *
 * Fitur:
 * - Render pesanan dari database
 * - Filter dan search pesanan
 * - Detail pesanan
 * - Invoice PDF
 * - Midtrans Snap popup
 * - Check Status pembayaran via POST ke Laravel
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
                String(item?.name || '').toLowerCase().includes(keyword) ||
                String(item?.location || '').toLowerCase().includes(keyword) ||
                String(item?.fullAddress || '').toLowerCase().includes(keyword) ||
                String(item?.customerName || '').toLowerCase().includes(keyword) ||
                String(item?.customerPhone || '').toLowerCase().includes(keyword);
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
                ${escapeHtml(order.status || statusLabelFromCode(order.statusCode))}
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

                <div class="detail-item">
                    <i class="bi bi-credit-card"></i>
                    <span>💳 Pembayaran: ${escapeHtml(paymentStatusLabel(order.paymentStatus))}</span>
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
    const paymentStatus = String(order.paymentStatus || '').toLowerCase();
    const isPaid = paymentStatus === 'paid';
    const isCancelled = order.statusCode === 'cancelled';
    const isCompleted = order.statusCode === 'completed';

    if (!isPaid && !isCancelled && !isCompleted) {
        return `
            <button class="action-btn action-btn-success" onclick="showPaymentInfo('${orderId}', this)">
                <i class="bi bi-credit-card"></i> Lanjut Bayar
            </button>

            <button class="action-btn action-btn-outline" onclick="checkPaymentStatus('${orderId}', false, this)">
                <i class="bi bi-arrow-repeat"></i> Check Status
            </button>

            <button class="action-btn action-btn-outline" onclick="viewInvoice('${orderId}')">
                <i class="bi bi-download"></i> Invoice
            </button>

            <button class="action-btn action-btn-warning" onclick="contactAdmin('${orderId}')">
                <i class="bi bi-whatsapp"></i> Hubungi Admin
            </button>
        `;
    }

    if (isPaid && !isCancelled && !isCompleted) {
        return `
            <button class="action-btn action-btn-outline" onclick="viewInvoice('${orderId}')">
                <i class="bi bi-download"></i> Invoice
            </button>

            <button class="action-btn action-btn-outline" onclick="checkPaymentStatus('${orderId}', false, this)">
                <i class="bi bi-arrow-repeat"></i> Check Status
            </button>

            <button class="action-btn action-btn-warning" onclick="contactAdmin('${orderId}')">
                <i class="bi bi-whatsapp"></i> Hubungi Admin
            </button>
        `;
    }

    if (isCompleted) {
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

    if (isCancelled) {
        return `
            <button class="action-btn action-btn-outline" onclick="viewInvoice('${orderId}')">
                <i class="bi bi-download"></i> Invoice
            </button>

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
                    <strong><i class="bi bi-clock-history"></i> Status Pesanan</strong><br>
                    <span class="badge ${statusInfo.class}">
                        ${escapeHtml(order.status || statusLabelFromCode(order.statusCode))}
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

        ${order.notes ? `<hr><p><strong>Catatan:</strong><br>${escapeHtml(order.notes)}</p>` : ''}
        ${order.review ? `<hr><p><strong><i class="bi bi-star-fill text-warning"></i> Review:</strong><br>${escapeHtml(order.review)}</p>` : ''}
    `;

    const modal = new bootstrap.Modal(document.getElementById('detailModal'));
    modal.show();
}

// ==================== MIDTRANS PAYMENT ====================
async function showPaymentInfo(orderId, buttonElement = null) {
    const order = allOrders.find(item => item.orderId === orderId);

    if (!order) return;

    if (!order.paymentUrl) {
        notifyPesanan('URL pembayaran belum tersedia. Pastikan paymentUrl sudah dikirim dari FrontendController.', 'warning');
        return;
    }

    if (String(order.paymentStatus || '').toLowerCase() === 'paid') {
        notifyPesanan('Pesanan ini sudah lunas.', 'success');
        return;
    }

    setButtonLoading(buttonElement, true, '<i class="bi bi-hourglass-split"></i> Menyiapkan...');

    try {
        notifyPesanan('Mempersiapkan pembayaran Midtrans...', 'info');

        const response = await fetch(order.paymentUrl, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': getCsrfTokenPesanan(),
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({}),
        });

        const data = await safeReadJson(response);

        if (!response.ok || !data.status) {
            notifyPesanan(data.message || 'Gagal membuat pembayaran.', 'error');
            return;
        }

        if (data.already_paid) {
            notifyPesanan('Pesanan ini sudah lunas.', 'success');
            setTimeout(function () {
                window.location.reload();
            }, 800);
            return;
        }

        if (!data.snap_token) {
            notifyPesanan('Snap token tidak ditemukan dari server.', 'error');
            return;
        }

        if (typeof window.snap === 'undefined') {
            notifyPesanan('Snap Midtrans belum terbaca. Cek script Snap JS dan Client Key.', 'error');
            return;
        }

        window.snap.pay(data.snap_token, {
            onSuccess: function () {
                notifyPesanan('Pembayaran berhasil. Mengecek status pembayaran...', 'success');
                checkPaymentStatus(orderId, true);
            },

            onPending: function () {
                notifyPesanan('Pembayaran masih pending. Klik Check Status setelah menyelesaikan pembayaran.', 'info');
                checkPaymentStatus(orderId, false);
            },

            onError: function () {
                notifyPesanan('Pembayaran gagal diproses. Mengecek status terakhir...', 'error');
                checkPaymentStatus(orderId, false);
            },

            onClose: function () {
                notifyPesanan('Popup pembayaran ditutup. Anda bisa klik Lanjut Bayar lagi atau Check Status.', 'info');
            },
        });
    } catch (error) {
        console.error(error);
        notifyPesanan('Terjadi kesalahan saat membuka pembayaran.', 'error');
    } finally {
        setButtonLoading(buttonElement, false);
    }
}

async function checkPaymentStatus(orderId, reloadIfPaid = false, buttonElement = null) {
    const order = allOrders.find(item => item.orderId === orderId);

    if (!order) return;

    if (!order.paymentCheckUrl) {
        notifyPesanan('URL check status belum tersedia. Pastikan paymentCheckUrl sudah dikirim dari FrontendController.', 'warning');
        return;
    }

    setButtonLoading(buttonElement, true, '<i class="bi bi-hourglass-split"></i> Mengecek...');

    try {
        notifyPesanan('Mengecek status pembayaran...', 'info');

        const response = await fetch(order.paymentCheckUrl, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': getCsrfTokenPesanan(),
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({}),
        });

        const data = await safeReadJson(response);

        if (!response.ok || !data.status) {
            notifyPesanan(data.message || 'Gagal mengecek status pembayaran.', 'error');
            return;
        }

        syncOrderStatusFromCheckResponse(orderId, data);

        if (data.payment_status === 'paid') {
            notifyPesanan('Pembayaran sudah lunas. Status pesanan diperbarui.', 'success');

            setTimeout(function () {
                window.location.reload();
            }, reloadIfPaid ? 500 : 900);

            return;
        }

        if (data.payment_status === 'pending') {
            notifyPesanan('Pembayaran masih pending. Selesaikan pembayaran lalu klik Check Status lagi.', 'info');

            setTimeout(function () {
                window.location.reload();
            }, 900);

            return;
        }

        if (data.payment_status === 'expired') {
            notifyPesanan('Pembayaran sudah expired. Silakan hubungi admin atau booking ulang.', 'warning');

            setTimeout(function () {
                window.location.reload();
            }, 900);

            return;
        }

        if (data.payment_status === 'failed' || data.payment_status === 'cancelled') {
            notifyPesanan('Pembayaran gagal atau dibatalkan.', 'error');

            setTimeout(function () {
                window.location.reload();
            }, 900);

            return;
        }

        notifyPesanan(`Status pembayaran saat ini: ${paymentStatusLabel(data.payment_status || 'pending')}.`, 'info');

        setTimeout(function () {
            window.location.reload();
        }, 900);
    } catch (error) {
        console.error(error);
        notifyPesanan('Terjadi kesalahan saat mengecek status pembayaran.', 'error');
    } finally {
        setButtonLoading(buttonElement, false);
    }
}

function syncOrderStatusFromCheckResponse(orderId, data) {
    const index = allOrders.findIndex(item => item.orderId === orderId);

    if (index === -1) return;

    const paymentStatus = data.payment_status || allOrders[index].paymentStatus;
    const orderStatusRaw = data.order_status || allOrders[index].statusCode;

    allOrders[index].paymentStatus = paymentStatus;
    allOrders[index].statusCode = normalizeStatusCodeFromBackend(orderStatusRaw, paymentStatus);
    allOrders[index].status = statusLabelFromCode(allOrders[index].statusCode);

    renderOrders();
}

function getCsrfTokenPesanan() {
    return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
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
        `Lokasi: ${item?.location || '-'}\n` +
        `Status Pembayaran: ${paymentStatusLabel(order.paymentStatus)}\n\n` +
        `Terima kasih.`;

    window.open(`https://wa.me/6288289258764?text=${encodeURIComponent(message)}`, '_blank');
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
        expired: {
            color: '#dc3545',
            class: 'status-danger',
        },
    };

    return statusMap[statusCode] || statusMap.waiting_payment;
}

function normalizeStatusCodeFromBackend(orderStatus, paymentStatus) {
    const status = String(orderStatus || '').toLowerCase();
    const payment = String(paymentStatus || '').toLowerCase();

    if (status === 'cancelled' || payment === 'cancelled') {
        return 'cancelled';
    }

    if (status === 'expired' || payment === 'expired') {
        return 'cancelled';
    }

    if (status === 'completed') {
        return 'completed';
    }

    if (status === 'ongoing') {
        return 'ongoing';
    }

    if (status === 'processing' || status === 'processed') {
        return 'processing';
    }

    if (status === 'confirmed' || payment === 'paid') {
        return 'confirmed';
    }

    return 'waiting_payment';
}

function statusLabelFromCode(statusCode) {
    const labels = {
        waiting_payment: 'Menunggu Pembayaran',
        confirmed: 'Dikonfirmasi',
        processing: 'Pesanan Diproses',
        ongoing: 'Pelaksanaan Acara',
        completed: 'Selesai',
        cancelled: 'Dibatalkan',
        expired: 'Expired',
    };

    return labels[statusCode] || 'Menunggu Pembayaran';
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

async function safeReadJson(response) {
    try {
        return await response.json();
    } catch (error) {
        return {
            status: false,
            message: 'Response server tidak valid.',
        };
    }
}

function setButtonLoading(buttonElement, isLoading, loadingHtml = null) {
    if (!buttonElement) return;

    if (isLoading) {
        buttonElement.dataset.originalHtml = buttonElement.innerHTML;
        buttonElement.disabled = true;

        if (loadingHtml) {
            buttonElement.innerHTML = loadingHtml;
        }

        return;
    }

    buttonElement.disabled = false;

    if (buttonElement.dataset.originalHtml) {
        buttonElement.innerHTML = buttonElement.dataset.originalHtml;
        delete buttonElement.dataset.originalHtml;
    }
}