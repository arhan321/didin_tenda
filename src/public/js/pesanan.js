/**
 * PESANAN.JS - Halaman Pesanan Saya
 * Mengelola tampilan pesanan, status, filter, dan aksi-aksi pesanan
 * 
 * Data pesanan disimpan di localStorage dengan key "didinOrders"
 */

// Variabel global
let allOrders = [];
let currentFilter = 'all';
let currentSearch = '';

// ===== LOAD DATA PESANAN DARI LOCALSTORAGE =====
function loadOrders() {
    const savedOrders = localStorage.getItem('didinOrders');
    
    console.log('📦 Data dari localStorage didinOrders:', savedOrders); // Debug
    
    if (savedOrders && savedOrders !== '[]') {
        allOrders = JSON.parse(savedOrders);
        console.log('✅ Memuat data pesanan dari localStorage:', allOrders.length, 'pesanan');
    } else {
        // Jika tidak ada data, buat data demo untuk testing
        console.log('⚠️ Tidak ada data pesanan, membuat data demo...');
        allOrders = getDemoOrders();
        localStorage.setItem('didinOrders', JSON.stringify(allOrders));
    }
    
    renderOrders();
}

// ===== DATA DEMO UNTUK TESTING (Jika belum ada pesanan) =====
function getDemoOrders() {
    const today = new Date();
    const nextWeek = new Date(today);
    nextWeek.setDate(today.getDate() + 7);
    const lastWeek = new Date(today);
    lastWeek.setDate(today.getDate() - 7);
    
    return [
        {
            orderId: "INV/2025/001",
            orderDate: new Date().toISOString(),
            status: "Menunggu Pembayaran",
            statusCode: "waiting_payment",
            items: [{
                id: "paket-hemat",
                name: "Paket Hemat",
                price: 3200000,
                basePrice: 2500000,
                date: nextWeek.toISOString().split('T')[0],
                location: "Gedung Serbaguna, Jakarta",
                fullAddress: "Jl. Sudirman No. 123, Jakarta",
                customerName: "Ahmad Fauzi",
                customerPhone: "08123456789",
                shippingFee: 0,
                distance: 5.5,
                addons: [
                    { id: "kursi", name: "Kursi Futura Tambahan (50 pcs)", price: 500000 },
                    { id: "lampu", name: "Lampu Hias (5 titik)", price: 200000 }
                ]
            }],
            totalPrice: 3200000,
            paymentDeadline: new Date(Date.now() + 24 * 60 * 60 * 1000).toISOString()
        },
        {
            orderId: "INV/2025/002",
            orderDate: lastWeek.toISOString(),
            status: "Selesai",
            statusCode: "completed",
            items: [{
                id: "paket-silver",
                name: "Paket Silver",
                price: 4500000,
                basePrice: 4500000,
                date: lastWeek.toISOString().split('T')[0],
                location: "Balai Kartini, Jakarta Selatan",
                fullAddress: "Jl. Gatot Subroto No. 45, Jakarta Selatan",
                customerName: "Siti Nurhaliza",
                customerPhone: "081298765432",
                shippingFee: 50000,
                distance: 15.5,
                addons: []
            }],
            totalPrice: 4500000,
            rating: 5,
            review: "Pelayanan sangat baik, dekorasi sesuai pesanan!"
        }
    ];
}

// ===== RENDER SEMUA PESANAN =====
function renderOrders() {
    const container = document.getElementById('ordersContainer');
    const emptyContainer = document.getElementById('emptyOrders');
    
    if (!container) {
        console.error('❌ Container ordersContainer tidak ditemukan!');
        return;
    }
    
    console.log('📊 Merender pesanan, total:', allOrders.length);
    
    // Update status berdasarkan tanggal terlebih dahulu
    allOrders = updateOrdersStatusByDate(allOrders);
    
    // Filter berdasarkan status
    let filteredOrders = [...allOrders];
    
    if (currentFilter !== 'all') {
        if (currentFilter === 'active') {
            filteredOrders = filteredOrders.filter(order => 
                order.statusCode !== 'completed' && order.statusCode !== 'cancelled'
            );
        } else if (currentFilter === 'completed') {
            filteredOrders = filteredOrders.filter(order => 
                order.statusCode === 'completed'
            );
        } else if (currentFilter === 'cancelled') {
            filteredOrders = filteredOrders.filter(order => 
                order.statusCode === 'cancelled'
            );
        }
    }
    
    // Search
    if (currentSearch) {
        const searchLower = currentSearch.toLowerCase();
        filteredOrders = filteredOrders.filter(order => {
            const item = order.items[0];
            return order.orderId.toLowerCase().includes(searchLower) ||
                   item.name.toLowerCase().includes(searchLower) ||
                   (item.location && item.location.toLowerCase().includes(searchLower));
        });
    }
    
    if (filteredOrders.length === 0) {
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
    filteredOrders.forEach(order => {
        html += renderOrderCard(order);
    });
    
    container.innerHTML = html;
    
    // Update badge di navbar
    updateCartBadge();
}

// ===== UPDATE STATUS BERDASARKAN TANGGAL (OTOMATIS) =====
function updateOrdersStatusByDate(orders) {
    const today = new Date();
    today.setHours(0, 0, 0, 0);
    
    return orders.map(order => {
        // Jika sudah dibatalkan atau selesai, lewati
        if (order.statusCode === 'cancelled' || order.statusCode === 'completed') {
            return order;
        }
        
        // Ambil tanggal acara dari item pertama
        const item = order.items[0];
        if (!item || !item.date) return order;
        
        const eventDate = new Date(item.date);
        eventDate.setHours(0, 0, 0, 0);
        
        // Update status berdasarkan statusCode saat ini dan tanggal
        if (order.statusCode === 'waiting_payment') {
            // Cek deadline pembayaran (1x24 jam)
            const deadline = new Date(order.paymentDeadline);
            if (new Date() > deadline) {
                order.status = "Dibatalkan";
                order.statusCode = "cancelled";
            }
        } else if (order.statusCode === 'confirmed') {
            if (eventDate < today) {
                order.status = "Selesai";
                order.statusCode = "completed";
            } else if (eventDate.getTime() === today.getTime()) {
                order.status = "Pelaksanaan Acara";
                order.statusCode = "ongoing";
            }
        } else if (order.statusCode === 'processing') {
            if (eventDate < today) {
                order.status = "Selesai";
                order.statusCode = "completed";
            } else if (eventDate.getTime() === today.getTime()) {
                order.status = "Pelaksanaan Acara";
                order.statusCode = "ongoing";
            }
        } else if (order.statusCode === 'ongoing') {
            if (eventDate < today) {
                order.status = "Selesai";
                order.statusCode = "completed";
            }
        }
        
        return order;
    });
}

// ===== RENDER SATU CARD PESANAN =====
function renderOrderCard(order) {
    const item = order.items[0];
    if (!item) return '';
    
    const eventDate = item.date ? formatDate(item.date) : 'Belum ditentukan';
    const orderDate = formatDate(order.orderDate);
    const statusInfo = getStatusInfo(order.statusCode, order.status);
    
    // Hitung total add-ons
    const totalAddons = item.addons && item.addons.length > 0 
        ? item.addons.reduce((sum, a) => sum + a.price, 0) 
        : 0;
    
    // Data ongkir
    const shippingFee = item.shippingFee || 0;
    const distance = item.distance || 0;
    
    // Render add-ons list
// Di dalam renderOrderCard(), cari bagian addonsHtml
let addonsHtml = '';
if (item.addons && item.addons.length > 0) {
    addonsHtml = `
        <div class="order-items">
            <div class="order-items-header">
                <i class="bi bi-plus-circle"></i> Add-ons yang dipilih:
            </div>
            <ul class="order-addons-list">
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
    
    // Render action buttons berdasarkan status
    let actionButtons = '';
    
    if (order.statusCode === 'waiting_payment') {
        actionButtons = `
            <button class="action-btn action-btn-success" onclick="simulatePayment('${order.orderId}')">
                <i class="bi bi-credit-card"></i> Simulasi Bayar
            </button>
            <button class="action-btn action-btn-danger" onclick="cancelOrder('${order.orderId}')">
                <i class="bi bi-x-circle"></i> Batalkan
            </button>
        `;
    } else if (order.statusCode === 'confirmed') {
        actionButtons = `
            <button class="action-btn action-btn-primary" onclick="simulateProcess('${order.orderId}')">
                <i class="bi bi-box-seam"></i> Simulasi Proses
            </button>
            <button class="action-btn action-btn-warning" onclick="contactAdmin('${order.orderId}')">
                <i class="bi bi-whatsapp"></i> Hubungi Admin
            </button>
        `;
    } else if (order.statusCode === 'processing') {
        actionButtons = `
            <button class="action-btn action-btn-warning" onclick="contactAdmin('${order.orderId}')">
                <i class="bi bi-whatsapp"></i> Hubungi Admin
            </button>
        `;
    } else if (order.statusCode === 'ongoing') {
        actionButtons = `
            <button class="action-btn action-btn-success" onclick="markAsCompleted('${order.orderId}')">
                <i class="bi bi-check-circle"></i> Tandai Selesai
            </button>
            <button class="action-btn action-btn-warning" onclick="contactAdmin('${order.orderId}')">
                <i class="bi bi-whatsapp"></i> Hubungi Tim
            </button>
        `;
    } else if (order.statusCode === 'completed') {
        actionButtons = `
            <button class="action-btn action-btn-outline" onclick="viewInvoice('${order.orderId}')">
                <i class="bi bi-download"></i> Invoice
            </button>
            <button class="action-btn action-btn-outline" onclick="openRatingModal('${order.orderId}')">
                <i class="bi bi-star-fill"></i> Beri Rating
            </button>
            <button class="action-btn action-btn-warning" onclick="contactAdmin('${order.orderId}')">
                <i class="bi bi-whatsapp"></i> Hubungi Admin
            </button>
        `;
    } else if (order.statusCode === 'cancelled') {
        actionButtons = `
            <button class="action-btn action-btn-outline" onclick="reorder('${order.orderId}')">
                <i class="bi bi-arrow-repeat"></i> Pesan Lagi
            </button>
        `;
    }
    
    return `
        <div class="order-card" style="--status-color: ${statusInfo.color}">
            <div class="order-status ${statusInfo.class}">${order.status}</div>
            
            <div class="order-header">
                <div class="order-title">
                    <h3>${item.name}</h3>
                    <div class="order-id">
                        <i class="bi bi-upc-scan"></i> ${order.orderId}
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
                    <span>📍 ${item.location || 'Lokasi belum diisi'}</span>
                </div>
                <div class="detail-item">
                    <i class="bi bi-truck"></i>
                    <span>🚚 Jarak: ${distance > 0 ? distance.toFixed(1) + ' km' : 'Belum dihitung'} | Ongkir: ${shippingFee === 0 ? 'GRATIS' : formatRupiah(shippingFee)}</span>
                </div>
                <div class="detail-item">
                    <i class="bi bi-person"></i>
                    <span>👤 ${item.customerName || 'Nama belum diisi'}</span>
                </div>
                <div class="detail-item">
                    <i class="bi bi-whatsapp"></i>
                    <span>📱 ${item.customerPhone || 'No. WA belum diisi'}</span>
                </div>
                <div class="detail-item">
                    <i class="bi bi-calendar-check"></i>
                    <span>📆 Pesan: ${orderDate}</span>
                </div>
            </div>
            
            ${addonsHtml}
            
            <div class="order-price">
                <div class="price-total">
                    💰 Total: ${formatRupiah(order.totalPrice)}
                    ${totalAddons > 0 ? '<span>(sudah termasuk add-ons)</span>' : ''}
                </div>
                ${shippingFee > 0 ? `<div class="price-shipping"><small>✓ Sudah termasuk biaya pengiriman</small></div>` : ''}
            </div>
            
            <div class="order-actions">
                <button class="action-btn action-btn-outline" onclick="viewOrderDetail('${order.orderId}')">
                    <i class="bi bi-eye"></i> Detail
                </button>
                ${actionButtons}
            </div>
        </div>
    `;
}

// ===== TANDAI PESANAN SELESAI =====
function markAsCompleted(orderId) {
    if (confirm('Tandai pesanan ini sebagai selesai? Pesanan akan masuk ke history.')) {
        const orderIndex = allOrders.findIndex(o => o.orderId === orderId);
        if (orderIndex !== -1 && allOrders[orderIndex].statusCode === 'ongoing') {
            allOrders[orderIndex].status = "Selesai";
            allOrders[orderIndex].statusCode = "completed";
            localStorage.setItem('didinOrders', JSON.stringify(allOrders));
            renderOrders();
            showNotification('✅ Pesanan ditandai selesai! Masuk ke history.', 'success');
        } else {
            showNotification('⚠️ Hanya pesanan dengan status "Pelaksanaan Acara" yang bisa ditandai selesai!', 'warning');
        }
    }
}

// ===== GET STATUS INFO (WARNA & CLASS) =====
function getStatusInfo(statusCode, status) {
    const statusMap = {
        'waiting_payment': { color: '#ffc107', class: 'status-warning' },
        'confirmed': { color: '#17a2b8', class: 'status-info' },
        'processing': { color: '#2c7be5', class: 'status-primary' },
        'ongoing': { color: '#28a745', class: 'status-success' },
        'completed': { color: '#6c757d', class: 'status-secondary' },
        'cancelled': { color: '#dc3545', class: 'status-danger' }
    };
    return statusMap[statusCode] || { color: '#6c757d', class: 'status-secondary' };
}

// ===== SIMULASI PEMBAYARAN =====
function simulatePayment(orderId) {
    const orderIndex = allOrders.findIndex(o => o.orderId === orderId);
    if (orderIndex !== -1 && allOrders[orderIndex].statusCode === 'waiting_payment') {
        allOrders[orderIndex].status = "Dikonfirmasi";
        allOrders[orderIndex].statusCode = "confirmed";
        localStorage.setItem('didinOrders', JSON.stringify(allOrders));
        renderOrders();
        showNotification('✅ Simulasi: Pembayaran berhasil dikonfirmasi!', 'success');
    }
}

// ===== SIMULASI PROSES PESANAN =====
function simulateProcess(orderId) {
    const orderIndex = allOrders.findIndex(o => o.orderId === orderId);
    if (orderIndex !== -1 && allOrders[orderIndex].statusCode === 'confirmed') {
        allOrders[orderIndex].status = "Pesanan Diproses";
        allOrders[orderIndex].statusCode = "processing";
        localStorage.setItem('didinOrders', JSON.stringify(allOrders));
        renderOrders();
        showNotification('✅ Simulasi: Pesanan sedang diproses oleh tim kami!', 'success');
    }
}

// ===== BATALKAN PESANAN =====
function cancelOrder(orderId) {
    if (confirm('Yakin ingin membatalkan pesanan ini?')) {
        const orderIndex = allOrders.findIndex(o => o.orderId === orderId);
        if (orderIndex !== -1 && allOrders[orderIndex].statusCode === 'waiting_payment') {
            allOrders[orderIndex].status = "Dibatalkan";
            allOrders[orderIndex].statusCode = "cancelled";
            localStorage.setItem('didinOrders', JSON.stringify(allOrders));
            renderOrders();
            showNotification('✅ Pesanan berhasil dibatalkan', 'success');
        } else {
            showNotification('⚠️ Pesanan tidak dapat dibatalkan karena sudah diproses!', 'warning');
        }
    }
}

// ===== HUBUNGI ADMIN VIA WHATSAPP =====
function contactAdmin(orderId) {
    const order = allOrders.find(o => o.orderId === orderId);
    if (order) {
        const item = order.items[0];
        const message = `Halo Admin Didin Tenda, saya ingin menanyakan tentang pesanan saya:\n\nOrder ID: ${order.orderId}\nPaket: ${item.name}\nTanggal Acara: ${item.date}\nLokasi: ${item.location}\n\nTerima kasih.`;
        window.open(`https://wa.me/6288289258764?text=${encodeURIComponent(message)}`, '_blank');
    }
}

// ===== LIHAT INVOICE (SIMULASI) =====
function viewInvoice(orderId) {
    const order = allOrders.find(o => o.orderId === orderId);
    if (order) {
        showNotification(`📄 Invoice ${order.orderId} akan didownload (simulasi)`, 'info');
    }
}

// ===== PESAN LAGI =====
function reorder(orderId) {
    const order = allOrders.find(o => o.orderId === orderId);
    if (order) {
        const item = order.items[0];
        window.location.href = `paket.html?id=${item.id}`;
    }
}

// ===== LIHAT DETAIL PESANAN (MODAL) =====
function viewOrderDetail(orderId) {
    const order = allOrders.find(o => o.orderId === orderId);
    if (!order) return;
    
    const item = order.items[0];
    const modalBody = document.getElementById('detailModalBody');
    const shippingFee = item.shippingFee || 0;
    const distance = item.distance || 0;
    
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
    
    modalBody.innerHTML = `
        <div class="row">
            <div class="col-md-6">
                <p><strong><i class="bi bi-upc-scan"></i> Order ID</strong><br>${order.orderId}</p>
                <p><strong><i class="bi bi-tag"></i> Paket</strong><br>${item.name}</p>
                <p><strong><i class="bi bi-calendar"></i> Tanggal Acara</strong><br>${formatDate(item.date)}</p>
                <p><strong><i class="bi bi-geo-alt"></i> Lokasi</strong><br>${item.location || 'Belum diisi'}</p>
                <p><strong><i class="bi bi-truck"></i> Biaya Pengiriman</strong><br>${shippingFee === 0 ? 'GRATIS' : formatRupiah(shippingFee)} ${distance > 0 ? `(Jarak: ${distance.toFixed(1)} km)` : ''}</p>
            </div>
            <div class="col-md-6">
                <p><strong><i class="bi bi-person"></i> Nama</strong><br>${item.customerName || 'Belum diisi'}</p>
                <p><strong><i class="bi bi-whatsapp"></i> WhatsApp</strong><br>${item.customerPhone || 'Belum diisi'}</p>
                <p><strong><i class="bi bi-clock-history"></i> Status</strong><br>
                    <span class="badge ${getStatusInfo(order.statusCode, order.status).class}">${order.status}</span>
                </p>
                <p><strong><i class="bi bi-cash-stack"></i> Total</strong><br>
                    <span class="text-primary fw-bold">${formatRupiah(order.totalPrice)}</span>
                </p>
            </div>
        </div>
        ${addonsHtml}
        ${order.review ? `<hr><p><strong><i class="bi bi-star-fill text-warning"></i> Review:</strong><br>${order.review}</p>` : ''}
    `;
    
    const modal = new bootstrap.Modal(document.getElementById('detailModal'));
    modal.show();
}

// ===== OPEN RATING MODAL =====
let currentRatingOrderId = null;

function openRatingModal(orderId) {
    currentRatingOrderId = orderId;
    const modal = new bootstrap.Modal(document.getElementById('ratingModal'));
    modal.show();
    
    // Reset stars dan textarea
    document.querySelectorAll('#ratingModal .rating-stars i').forEach(star => {
        star.classList.remove('active');
    });
    document.querySelector('#ratingModal textarea').value = '';
}

// ===== SUBMIT RATING =====
function submitRating() {
    if (!currentRatingOrderId) return;
    
    const stars = document.querySelectorAll('#ratingModal .rating-stars i.active');
    const rating = stars.length;
    const review = document.querySelector('#ratingModal textarea').value;
    
    if (rating === 0) {
        showNotification('⚠️ Silakan pilih rating bintang!', 'warning');
        return;
    }
    
    const orderIndex = allOrders.findIndex(o => o.orderId === currentRatingOrderId);
    if (orderIndex !== -1) {
        allOrders[orderIndex].rating = rating;
        allOrders[orderIndex].review = review;
        localStorage.setItem('didinOrders', JSON.stringify(allOrders));
        showNotification('✅ Terima kasih atas rating dan review Anda!', 'success');
        
        // Tutup modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('ratingModal'));
        modal.hide();
        
        renderOrders();
    }
}

// ===== INIT RATING STARS =====
function initRatingStars() {
    const stars = document.querySelectorAll('#ratingModal .rating-stars i');
    stars.forEach(star => {
        star.addEventListener('click', function() {
            const rating = parseInt(this.getAttribute('data-rating'));
            stars.forEach((s, index) => {
                if (index < rating) {
                    s.classList.add('active');
                } else {
                    s.classList.remove('active');
                }
            });
        });
    });
    
    const submitBtn = document.getElementById('submitRatingBtn');
    if (submitBtn) {
        submitBtn.addEventListener('click', submitRating);
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
            renderOrders();
        });
    });
    
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            currentSearch = this.value;
            renderOrders();
        });
    }
}

// ===== INITIALIZE =====
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 Halaman Pesanan dimuat...');
    loadOrders();
    initFilters();
    initRatingStars();
    
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