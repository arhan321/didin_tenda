/**
 * CART.JS - Halaman Keranjang Booking
 * Menampilkan item yang sudah ditambahkan dari halaman detail paket
 * Termasuk add-ons yang dipilih dan ongkir
 */

// Variabel global
let currentCart = [];

// ===== LOAD DATA DARI LOCALSTORAGE =====
function loadCartData() {
    const savedCart = localStorage.getItem('didinCart');
    if (savedCart) {
        currentCart = JSON.parse(savedCart);
    } else {
        currentCart = [];
    }
    updateCartBadge();
    renderCartItems();
}

// ===== RENDER SEMUA ITEM DI CART =====
function renderCartItems() {
    const container = document.getElementById('cartItemsContainer');
    const emptyCartDiv = document.getElementById('emptyCart');
    
    if (!container) return;
    
    if (currentCart.length === 0) {
        if (emptyCartDiv) emptyCartDiv.style.display = 'block';
        if (container) container.style.display = 'none';
        updateSummary();
        return;
    }
    
    if (emptyCartDiv) emptyCartDiv.style.display = 'none';
    if (container) container.style.display = 'block';
    
    let html = '';
    let totalShippingFee = 0;
    
    currentCart.forEach((item, index) => {
        // Format tanggal
        const formattedDate = item.date ? formatDate(item.date) : 'Belum dipilih';
        
        // Hitung total add-ons
        const totalAddons = item.addons && item.addons.length > 0 
            ? item.addons.reduce((sum, addon) => sum + addon.price, 0) 
            : 0;
        
        // Data ongkir
        const shippingFee = item.shippingFee || 0;
        const distance = item.distance || 0;
        totalShippingFee += shippingFee;
        
        // Tampilan ongkir per item
        const shippingDisplay = shippingFee === 0 ? 'GRATIS' : formatRupiah(shippingFee);
        const distanceDisplay = distance > 0 ? `${distance.toFixed(1)} km` : 'Belum dihitung';
        
        html += `
            <div class="cart-item" data-index="${index}">
                <div class="cart-item-info">
                    <h4>${item.name}</h4>
                    
                    <!-- Detail tanggal dan lokasi -->
                    <div class="cart-item-details">
                        <div class="detail-row">
                            <i class="bi bi-calendar"></i>
                            <span>📅 ${formattedDate}</span>
                        </div>
                        <div class="detail-row">
                            <i class="bi bi-geo-alt"></i>
                            <span>📍 ${item.location || 'Lokasi belum diisi'}</span>
                        </div>
                        <div class="detail-row">
                            <i class="bi bi-truck"></i>
                            <span>🚚 Jarak: ${distanceDisplay} | Ongkir: ${shippingDisplay}</span>
                        </div>
                        <div class="detail-row">
                            <i class="bi bi-person"></i>
                            <span>👤 ${item.customerName || 'Nama belum diisi'}</span>
                        </div>
                        <div class="detail-row">
                            <i class="bi bi-whatsapp"></i>
                            <span>📱 ${item.customerPhone || 'No. WA belum diisi'}</span>
                        </div>
                    </div>
                    
                    <!-- DAFTAR ADD-ONS -->
                    <div class="cart-item-addons">
                        <div class="addons-header">
                            <i class="bi bi-plus-circle"></i> Add-ons yang dipilih:
                        </div>
                        ${renderAddonsList(item.addons)}
                    </div>
                    
                    <!-- Tombol Aksi -->
                    <div class="cart-item-actions">
                        <button class="btn-edit" onclick="editCartItem(${index})">
                            <i class="bi bi-pencil"></i> Edit
                        </button>
                        <button class="btn-remove" onclick="removeCartItem(${index})">
                            <i class="bi bi-trash"></i> Hapus
                        </button>
                    </div>
                </div>
                
                <div class="cart-item-price">
                    <div class="price-detail">
                        <span class="label">Harga Paket:</span>
                        <span class="value">${formatRupiah(item.basePrice || item.price)}</span>
                    </div>
                    ${totalAddons > 0 ? `
                    <div class="price-detail addons-price">
                        <span class="label">+ Add-ons:</span>
                        <span class="value">${formatRupiah(totalAddons)}</span>
                    </div>
                    ` : ''}
                    ${shippingFee > 0 ? `
                    <div class="price-detail shipping-price">
                        <span class="label">🚚 Ongkir:</span>
                        <span class="value">${formatRupiah(shippingFee)}</span>
                    </div>
                    ` : shippingFee === 0 && distance > 0 ? `
                    <div class="price-detail shipping-price">
                        <span class="label">🚚 Ongkir:</span>
                        <span class="value text-success">GRATIS</span>
                    </div>
                    ` : ''}
                    <div class="price-divider"></div>
                    <div class="price-total">
                        <span class="label">Total:</span>
                        <span class="value">${formatRupiah(item.price)}</span>
                    </div>
                </div>
            </div>
        `;
    });
    
    container.innerHTML = html;
    updateSummary(totalShippingFee);
}

// ===== RENDER DAFTAR ADD-ONS =====
// ===== RENDER DAFTAR ADD-ONS DI CART =====
function renderAddonsList(addons) {
    if (!addons || addons.length === 0) {
        return '<div class="no-addons">Tidak ada add-ons yang dipilih</div>';
    }
    
    let html = '<ul class="addons-list">';
    addons.forEach(addon => {
        const qty = addon.quantity || 1;
        const qtyText = qty > 1 ? ` (${qty} pcs)` : '';
        const totalPrice = (addon.price || addon.totalPrice) || (addon.price * qty);
        html += `
            <li>
                <i class="bi bi-check-circle-fill"></i>
                <span>${addon.name}${qtyText}</span>
                <span class="addon-price-cart">${formatRupiah(totalPrice)}</span>
            </li>
        `;
    });
    html += '</ul>';
    return html;
}

// ===== UPDATE RINGKASAN TOTAL =====
function updateSummary(totalShippingFeeFromItems = null) {
    // Total harga paket (tanpa add-ons)
    const totalPaket = currentCart.reduce((sum, item) => sum + (item.basePrice || item.price), 0);
    
    // Total semua add-ons
    const totalAddons = currentCart.reduce((sum, item) => {
        if (item.addons && item.addons.length > 0) {
            return sum + item.addons.reduce((s, addon) => s + addon.price, 0);
        }
        return sum;
    }, 0);
    
    // Total ongkir
    let totalShipping = 0;
    if (totalShippingFeeFromItems !== null) {
        totalShipping = totalShippingFeeFromItems;
    } else {
        totalShipping = currentCart.reduce((sum, item) => sum + (item.shippingFee || 0), 0);
    }
    
    // Grand total
    const grandTotal = totalPaket + totalAddons + totalShipping;
    
    // Update elemen HTML
    const totalPaketEl = document.getElementById('totalPaket');
    const totalAddonsEl = document.getElementById('totalAddons');
    const cartShippingRow = document.getElementById('cartShippingRow');
    const cartShippingFeeEl = document.getElementById('cartShippingFee');
    const grandTotalEl = document.getElementById('grandTotal');
    
    if (totalPaketEl) totalPaketEl.innerHTML = formatRupiah(totalPaket);
    if (totalAddonsEl) totalAddonsEl.innerHTML = formatRupiah(totalAddons);
    
    if (cartShippingRow && cartShippingFeeEl) {
        if (totalShipping > 0) {
            cartShippingRow.style.display = 'flex';
            cartShippingFeeEl.innerHTML = formatRupiah(totalShipping);
        } else if (totalShipping === 0 && currentCart.some(item => item.distance > 0)) {
            cartShippingRow.style.display = 'flex';
            cartShippingFeeEl.innerHTML = '<span class="text-success">GRATIS</span>';
        } else {
            cartShippingRow.style.display = 'none';
        }
    }
    
    if (grandTotalEl) grandTotalEl.innerHTML = formatRupiah(grandTotal);
}

// ===== HAPUS ITEM DARI CART =====
function removeCartItem(index) {
    if (confirm('Hapus paket ini dari keranjang?')) {
        currentCart.splice(index, 1);
        localStorage.setItem('didinCart', JSON.stringify(currentCart));
        loadCartData();
        updateCartBadge();
        showNotification('✅ Paket dihapus dari keranjang', 'success');
    }
}

// ===== EDIT ITEM CART =====
function editCartItem(index) {
    const item = currentCart[index];
    if (item && item.id) {
        sessionStorage.setItem('editCartItem', JSON.stringify(item));
        sessionStorage.setItem('editCartIndex', index);
        window.location.href = `paket.html?id=${item.id}&edit=true`;
    } else {
        showNotification('⚠️ Gagal mengedit item', 'warning');
    }
}

// ===== GENERATE ORDER ID =====
function generateOrderId() {
    const date = new Date();
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    const random = Math.floor(Math.random() * 1000).toString().padStart(3, '0');
    return `INV/${year}/${month}${day}/${random}`;
}

// ===== CHECKOUT =====
function checkout() {
    if (currentCart.length === 0) {
        showNotification('⚠️ Keranjang kosong. Silakan pilih paket terlebih dahulu!', 'warning');
        return;
    }
    
    showNotification('🔄 Memproses pesanan...', 'info');
    
    let existingOrders = localStorage.getItem('didinOrders');
    existingOrders = existingOrders ? JSON.parse(existingOrders) : [];
    
    const newOrders = [];
    
    for (let i = 0; i < currentCart.length; i++) {
        const item = currentCart[i];
        const orderId = generateOrderId();
        
        newOrders.push({
            orderId: orderId,
            orderDate: new Date().toISOString(),
            status: "Menunggu Pembayaran",
            statusCode: "waiting_payment",
            items: [item],
            totalPrice: item.price,
            paymentDeadline: new Date(Date.now() + 24 * 60 * 60 * 1000).toISOString()
        });
    }
    
    const allOrders = [...newOrders, ...existingOrders];
    localStorage.setItem('didinOrders', JSON.stringify(allOrders));
    localStorage.removeItem('didinCart');
    currentCart = [];
    updateCartBadge();
    
    showNotification(`✅ ${newOrders.length} pesanan berhasil dibuat!`, 'success');
    
    setTimeout(() => {
        window.location.href = 'pesanan.html';
    }, 1500);
}

// ===== FORMAT TANGGAL =====
function formatDate(dateString) {
    if (!dateString) return 'Belum dipilih';
    const date = new Date(dateString);
    return date.toLocaleDateString('id-ID', {
        day: 'numeric',
        month: 'long',
        year: 'numeric'
    });
}

// ===== INITIALIZE =====
document.addEventListener('DOMContentLoaded', function() {
    loadCartData();
    
    const checkoutBtn = document.getElementById('checkoutBtn');
    if (checkoutBtn) {
        checkoutBtn.addEventListener('click', checkout);
    }
    
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