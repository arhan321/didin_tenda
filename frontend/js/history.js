/**
 * HISTORY.JS - Halaman History Booking
 * Menampilkan riwayat pesanan yang sudah selesai atau dibatalkan
 * Data diambil dari localStorage "didinOrders" dengan filter status completed/cancelled
 */

// Variabel global
let allHistory = [];
let currentFilter = 'all';
let currentSearch = '';

// ===== LOAD DATA HISTORY DARI LOCALSTORAGE =====
function loadHistory() {
    const savedOrders = localStorage.getItem('didinOrders');
    
    console.log('📦 History: Memuat data dari localStorage...');
    
    if (savedOrders && savedOrders !== '[]') {
        const allOrders = JSON.parse(savedOrders);
        // Filter hanya pesanan yang sudah selesai (completed) atau dibatalkan (cancelled)
        allHistory = allOrders.filter(order => 
            order.statusCode === 'completed' || order.statusCode === 'cancelled'
        );
        console.log(`✅ Memuat ${allHistory.length} riwayat pesanan`);
    } else {
        // Jika tidak ada data, buat data demo
        console.log('⚠️ Tidak ada data, membuat data demo...');
        allHistory = getDemoHistory();
        // Simpan juga ke didinOrders agar konsisten
        const existingOrders = localStorage.getItem('didinOrders');
        const existing = existingOrders ? JSON.parse(existingOrders) : [];
        const allOrders = [...allHistory, ...existing];
        localStorage.setItem('didinOrders', JSON.stringify(allOrders));
    }
    
    updateStats();
    renderHistory();
}

// ===== DATA DEMO UNTUK HISTORY =====
function getDemoHistory() {
    const today = new Date();
    const lastMonth = new Date(today);
    lastMonth.setMonth(today.getMonth() - 1);
    const twoMonthsAgo = new Date(today);
    twoMonthsAgo.setMonth(today.getMonth() - 2);
    
    return [
        {
            orderId: "INV/2025/001",
            orderDate: lastMonth.toISOString(),
            status: "Selesai",
            statusCode: "completed",
            items: [{
                id: "paket-hemat",
                name: "Paket Hemat",
                price: 3200000,
                basePrice: 2500000,
                date: lastMonth.toISOString().split('T')[0],
                location: "Gedung Serbaguna, Jakarta",
                customerName: "Ahmad Fauzi",
                customerPhone: "08123456789",
                addons: [
                    { id: "kursi", name: "Kursi Futura Tambahan (50 pcs)", price: 500000 },
                    { id: "lampu", name: "Lampu Hias (5 titik)", price: 200000 }
                ]
            }],
            totalPrice: 3200000,
            rating: 5,
            review: "Pelayanan sangat memuaskan! Dekorasi sesuai pesanan, tim tepat waktu. Terima kasih Didin Tenda!"
        },
        {
            orderId: "INV/2025/002",
            orderDate: twoMonthsAgo.toISOString(),
            status: "Selesai",
            statusCode: "completed",
            items: [{
                id: "paket-silver",
                name: "Paket Silver",
                price: 4500000,
                basePrice: 4500000,
                date: twoMonthsAgo.toISOString().split('T')[0],
                location: "Balai Kartini, Jakarta Selatan",
                customerName: "Siti Nurhaliza",
                customerPhone: "081298765432",
                addons: []
            }],
            totalPrice: 4500000,
            rating: 4,
            review: "Dekorasi bagus, tapi sedikit terlambat. Secara keseluruhan ok!"
        },
        {
            orderId: "INV/2025/003",
            orderDate: lastMonth.toISOString(),
            status: "Dibatalkan",
            statusCode: "cancelled",
            items: [{
                id: "paket-gold",
                name: "Paket Gold",
                price: 7500000,
                basePrice: 7500000,
                date: lastMonth.toISOString().split('T')[0],
                location: "Kemang, Jakarta Selatan",
                customerName: "Budi Santoso",
                customerPhone: "08135557788",
                addons: [
                    { id: "panggung", name: "Panggung Portable", price: 800000 }
                ]
            }],
            totalPrice: 8300000,
            cancelledReason: "Perubahan jadwal acara"
        }
    ];
}

// ===== UPDATE STATISTIK =====
function updateStats() {
    const completed = allHistory.filter(h => h.statusCode === 'completed').length;
    const cancelled = allHistory.filter(h => h.statusCode === 'cancelled').length;
    const totalSpent = allHistory
        .filter(h => h.statusCode === 'completed')
        .reduce((sum, h) => sum + h.totalPrice, 0);
    
    document.getElementById('totalCompleted').textContent = completed;
    document.getElementById('totalCancelled').textContent = cancelled;
    document.getElementById('totalSpent').textContent = formatRupiah(totalSpent);
}

// ===== RENDER HISTORY =====
function renderHistory() {
    const container = document.getElementById('historyContainer');
    const emptyContainer = document.getElementById('emptyHistory');
    
    if (!container) return;
    
    // Filter berdasarkan status
    let filteredHistory = [...allHistory];
    
    if (currentFilter !== 'all') {
        filteredHistory = filteredHistory.filter(h => 
            h.statusCode === currentFilter
        );
    }
    
    // Search
    if (currentSearch) {
        const searchLower = currentSearch.toLowerCase();
        filteredHistory = filteredHistory.filter(order => {
            const item = order.items[0];
            return order.orderId.toLowerCase().includes(searchLower) ||
                   item.name.toLowerCase().includes(searchLower) ||
                   (item.location && item.location.toLowerCase().includes(searchLower));
        });
    }
    
    if (filteredHistory.length === 0) {
        if (container) container.style.display = 'none';
        if (emptyContainer) emptyContainer.style.display = 'block';
        return;
    }
    
    if (container) {
        container.style.display = 'block';
        container.innerHTML = '';
    }
    if (emptyContainer) emptyContainer.style.display = 'none';
    
    let html = '';
    filteredHistory.forEach(order => {
        html += renderHistoryCard(order);
    });
    
    container.innerHTML = html;
    
    // Update badge keranjang
    updateCartBadge();
}

// ===== RENDER SATU CARD HISTORY =====
function renderHistoryCard(order) {
    const item = order.items[0];
    if (!item) return '';
    
    const eventDate = item.date ? formatDate(item.date) : 'Belum ditentukan';
    const orderDate = formatDate(order.orderDate);
    const statusClass = order.statusCode === 'completed' ? 'status-completed' : 'status-cancelled';
    const statusColor = order.statusCode === 'completed' ? '#28a745' : '#dc3545';
    
    // Hitung total add-ons
    const totalAddons = item.addons && item.addons.length > 0 
        ? item.addons.reduce((sum, a) => sum + a.price, 0) 
        : 0;
    
    // Render add-ons list
// Di dalam renderHistoryCard(), cari bagian addonsHtml
let addonsHtml = '';
if (item.addons && item.addons.length > 0) {
    addonsHtml = `
        <div class="history-addons">
            <div class="addons-header">
                <i class="bi bi-plus-circle"></i> Add-ons:
            </div>
            <ul class="addons-list">
                ${item.addons.map(addon => {
                    const qty = addon.quantity || 1;
                    const qtyText = qty > 1 ? ` (${qty} pcs)` : '';
                    const totalPrice = (addon.totalPrice) || (addon.price * qty);
                    return `
                        <li>
                            <span>${addon.name}${qtyText}</span>
                            <span class="addon-price">${formatRupiah(totalPrice)}</span>
                        </li>
                    `;
                }).join('')}
            </ul>
        </div>
    `;
}
    
    // Render rating jika ada
    let ratingHtml = '';
    if (order.rating) {
        let stars = '';
        for (let i = 1; i <= 5; i++) {
            stars += `<i class="bi ${i <= order.rating ? 'bi-star-fill' : 'bi-star'}"></i>`;
        }
        ratingHtml = `
            <div class="rating-display">
                <div class="rating-stars-display">${stars}</div>
                <div class="rating-text">${order.review || 'Tidak ada komentar'}</div>
            </div>
        `;
    }
    
    // Render cancelled reason jika ada
    let cancelledHtml = '';
    if (order.statusCode === 'cancelled' && order.cancelledReason) {
        cancelledHtml = `
            <div class="history-addons" style="background: rgba(220, 53, 69, 0.05); border-left: 3px solid #dc3545;">
                <div class="addons-header" style="color: #dc3545;">
                    <i class="bi bi-info-circle"></i> Alasan Pembatalan:
                </div>
                <div style="font-size: 0.85rem; color: var(--gray-700);">${order.cancelledReason}</div>
            </div>
        `;
    }
    
    return `
        <div class="history-card" style="--status-color: ${statusColor}">
            <div class="history-status ${statusClass}">${order.status}</div>
            
            <div class="history-header-card">
                <div class="history-title">
                    <h3>${item.name}</h3>
                    <div class="history-order-id">
                        <i class="bi bi-upc-scan"></i> ${order.orderId}
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
                    <span>📍 ${item.location || 'Lokasi tidak tersedia'}</span>
                </div>
                <div class="detail-item">
                    <i class="bi bi-person"></i>
                    <span>👤 ${item.customerName || 'Nama tidak tersedia'}</span>
                </div>
                <div class="detail-item">
                    <i class="bi bi-calendar-check"></i>
                    <span>📆 Pesan: ${orderDate}</span>
                </div>
            </div>
            
            ${addonsHtml}
            ${cancelledHtml}
            ${ratingHtml}
            
            <div class="history-price">
                <div class="price-total">
                    💰 Total: ${formatRupiah(order.totalPrice)}
                    ${totalAddons > 0 ? '<span>(termasuk add-ons)</span>' : ''}
                </div>
            </div>
            
            <div class="history-actions">
                <button class="action-btn action-btn-outline" onclick="viewHistoryDetail('${order.orderId}')">
                    <i class="bi bi-eye"></i> Detail
                </button>
                ${order.statusCode === 'completed' ? `
                <button class="action-btn action-btn-primary" onclick="reorderHistory('${order.orderId}')">
                    <i class="bi bi-arrow-repeat"></i> Pesan Lagi
                </button>
                ` : ''}
            </div>
        </div>
    `;
}

// ===== LIHAT DETAIL HISTORY (MODAL) =====
function viewHistoryDetail(orderId) {
    const order = allHistory.find(o => o.orderId === orderId);
    if (!order) return;
    
    const item = order.items[0];
    const modalBody = document.getElementById('detailModalBody');
    
    let addonsHtml = '';
    if (item.addons && item.addons.length > 0) {
        addonsHtml = `
            <h6 class="mt-3"><i class="bi bi-plus-circle"></i> Add-ons:</h6>
            <ul class="list-unstyled">
                ${item.addons.map(addon => `
                    <li class="d-flex justify-content-between mb-2">
                        <span>${addon.name}</span>
                        <span class="text-primary">${formatRupiah(addon.price)}</span>
                    </li>
                `).join('')}
            </ul>
        `;
    }
    
    let ratingHtml = '';
    if (order.rating) {
        let stars = '';
        for (let i = 1; i <= 5; i++) {
            stars += `<i class="bi ${i <= order.rating ? 'bi-star-fill' : 'bi-star'} text-warning"></i>`;
        }
        ratingHtml = `
            <hr>
            <h6><i class="bi bi-star-fill text-warning"></i> Rating & Review:</h6>
            <div class="mb-2">${stars}</div>
            <p class="text-muted">${order.review || 'Tidak ada komentar'}</p>
        `;
    }
    
    modalBody.innerHTML = `
        <div class="row">
            <div class="col-md-6">
                <p><strong><i class="bi bi-upc-scan"></i> Order ID</strong><br>${order.orderId}</p>
                <p><strong><i class="bi bi-tag"></i> Paket</strong><br>${item.name}</p>
                <p><strong><i class="bi bi-calendar"></i> Tanggal Acara</strong><br>${formatDate(item.date)}</p>
                <p><strong><i class="bi bi-geo-alt"></i> Lokasi</strong><br>${item.location || 'Belum diisi'}</p>
            </div>
            <div class="col-md-6">
                <p><strong><i class="bi bi-person"></i> Nama</strong><br>${item.customerName || 'Belum diisi'}</p>
                <p><strong><i class="bi bi-whatsapp"></i> WhatsApp</strong><br>${item.customerPhone || 'Belum diisi'}</p>
                <p><strong><i class="bi bi-clock-history"></i> Status</strong><br>
                    <span class="badge ${order.statusCode === 'completed' ? 'bg-success' : 'bg-danger'}">${order.status}</span>
                </p>
                <p><strong><i class="bi bi-cash-stack"></i> Total</strong><br>
                    <span class="text-primary fw-bold">${formatRupiah(order.totalPrice)}</span>
                </p>
            </div>
        </div>
        ${addonsHtml}
        ${ratingHtml}
        ${order.cancelledReason ? `<hr><p><strong><i class="bi bi-info-circle text-danger"></i> Alasan Pembatalan:</strong><br>${order.cancelledReason}</p>` : ''}
    `;
    
    // Set tombol reorder di modal
    const reorderBtn = document.getElementById('reorderFromDetailBtn');
    if (reorderBtn) {
        reorderBtn.onclick = () => reorderHistory(orderId);
    }
    
    const modal = new bootstrap.Modal(document.getElementById('detailModal'));
    modal.show();
}

// ===== PESAN LAGI DARI HISTORY =====
function reorderHistory(orderId) {
    const order = allHistory.find(o => o.orderId === orderId);
    if (order) {
        const item = order.items[0];
        window.location.href = `paket.html?id=${item.id}`;
    }
}

// ===== FORMAT TANGGAL =====
function formatDate(dateString) {
    if (!dateString) return 'Belum ditentukan';
    const date = new Date(dateString);
    return date.toLocaleDateString('id-ID', {
        day: 'numeric',
        month: 'long',
        year: 'numeric'
    });
}

// ===== FILTER & SEARCH =====
function initFilters() {
    const filterBtns = document.querySelectorAll('.filter-btn');
    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            filterBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            currentFilter = this.getAttribute('data-filter');
            renderHistory();
        });
    });
    
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            currentSearch = this.value;
            renderHistory();
        });
    }
}

// ===== INITIALIZE =====
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 Halaman History dimuat...');
    loadHistory();
    initFilters();
    
    // Back to top
    const backToTop = document.getElementById('backToTop');
    if (backToTop) {
        window.addEventListener('scroll', () => {
            backToTop.classList.toggle('show', window.scrollY > 300);
        });
        backToTop.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }
});