/**
 * PAKET-CUSTOM.JS - Halaman Paket Custom
 * Layout vertikal dengan gambar custom + add-ons (dengan quantity) + ongkir + edit mode
 */

// ===== DATA ADD-ONS (DENGAN FLAG isPerItem) =====
const addonsDatabaseCustom = [
    { 
        id: 'ac-blower',
        name: 'AC Blower indoor Honeywell',
        detail: 'Pendingin ruangan portable',
        price: 400000,
        image: 'assets/images/addons/ac-blower.png',
        icon: 'bi-wind',
        isPerItem: true  // bisa pilih jumlah
    },
    { 
        id: 'kipas-embun',
        name: 'Kipas embun',
        detail: 'Kipas pendingin outdoor + embun',
        price: 500000,
        image: 'assets/images/addons/kipas-embun.png',
        icon: 'bi-fan',
        isPerItem: true
    },
    { 
        id: 'kursi-futura-sarung',
        name: 'Kursi Futura plus sarung',
        detail: 'Kursi futura premium dengan sarung',
        price: 15000,
        image: 'assets/images/addons/kursi-futura-sarung.png',
        icon: 'bi-chair',
        isPerItem: true
    },
    { 
        id: 'kursi-plastik-cover',
        name: 'Kursi plastik plus cover',
        detail: 'Kursi plastik dengan cover',
        price: 9000,
        image: 'assets/images/addons/kursi-plastik-cover.png',
        icon: 'bi-chair',
        isPerItem: true
    },
    { 
        id: 'kursi-plastik',
        name: 'Kursi plastik',
        detail: 'Kursi plastik standar',
        price: 7000,
        image: 'assets/images/addons/kursi-plastik.png',
        icon: 'bi-chair',
        isPerItem: true
    },
    { 
        id: 'kursi-futura',
        name: 'Kursi Futura',
        detail: 'Kursi futura standar',
        price: 13000,
        image: 'assets/images/addons/kursi-futura.png',
        icon: 'bi-chair',
        isPerItem: true
    },
    { 
        id: 'kursi-stainless',
        name: 'Kursi stainless',
        detail: 'Kursi stainless steel mewah',
        price: 10000,
        image: 'assets/images/addons/kursi-stainless.png',
        icon: 'bi-brightness-alt-high',
        isPerItem: true
    }
];

// ===== DATA CUSTOM ITEMS =====
let customQty = {
    tenda: 0,
    panggung: 0,
    mejakotak: 0,
    mejabulat: 0,
    soundsystem: 0
};

const customPrices = {
    tenda: 65000,
    panggung: 50000,
    mejakotak: 30000,
    mejabulat: 50000,
    soundsystem: 3000000
};

const customNames = {
    tenda: 'Tenda Dekorasi',
    panggung: 'Panggung Rigging',
    mejakotak: 'Meja Kotak Hajatan',
    mejabulat: 'Meja Bulat',
    soundsystem: 'Sound System'
};

const customUnits = {
    tenda: 'meter',
    panggung: 'meter',
    mejakotak: 'meter',
    mejabulat: 'pcs',
    soundsystem: 'set'
};

// ===== VARIABEL GLOBAL =====
let selectedAddonsCustom = [];
let currentDistance = 0;
let currentShippingFee = 0;
let isEditMode = false;
let editIndex = -1;

// ===== CEK APAKAH MODE EDIT (DARI CART) =====
function checkEditMode() {
    const urlParams = new URLSearchParams(window.location.search);
    isEditMode = urlParams.get('edit') === 'true';
    
    if (isEditMode) {
        const savedItem = sessionStorage.getItem('editCartItem');
        const savedIndex = sessionStorage.getItem('editCartIndex');
        if (savedItem && savedIndex) {
            editIndex = parseInt(savedIndex);
            const item = JSON.parse(savedItem);
            
            setTimeout(() => {
                if (item.date) document.getElementById('eventDate').value = item.date;
                if (item.location) document.getElementById('eventLocation').value = item.location;
                if (item.fullAddress) document.getElementById('eventFullAddress').value = item.fullAddress;
                if (item.customerName) document.getElementById('customerName').value = item.customerName;
                if (item.customerPhone) document.getElementById('customerPhone').value = item.customerPhone;
                
                // Reset custom quantities
                for (let key in customQty) {
                    customQty[key] = 0;
                }
                
                // Isi custom items
                if (item.customItems && item.customItems.length > 0) {
                    item.customItems.forEach(custom => {
                        if (custom.id === 'custom-tenda' && custom.quantity) customQty.tenda = custom.quantity;
                        else if (custom.id === 'custom-panggung' && custom.quantity) customQty.panggung = custom.quantity;
                        else if (custom.id === 'custom-mejakotak' && custom.quantity) customQty.mejakotak = custom.quantity;
                        else if (custom.id === 'custom-mejabulat' && custom.quantity) customQty.mejabulat = custom.quantity;
                        else if (custom.id === 'custom-soundsystem' && custom.quantity) customQty.soundsystem = custom.quantity;
                    });
                    
                    for (let key in customQty) {
                        updateCustomTotalDisplay(key);
                        const inputField = document.getElementById(`qty-${key}`);
                        if (inputField) inputField.value = customQty[key];
                    }
                }
                
                // Isi add-ons dengan quantity
                if (item.addons && item.addons.length > 0) {
                    selectedAddonsCustom = item.addons.map(addon => ({
                        id: addon.id,
                        name: addon.name,
                        detail: addon.detail || addon.name,
                        price: addon.price,
                        quantity: addon.quantity || 1,
                        totalPrice: addon.totalPrice || (addon.price * (addon.quantity || 1)),
                        image: addon.image || `assets/images/addons/${addon.id}.png`,
                        icon: addon.icon || 'bi-plus-circle',
                        isPerItem: true
                    }));
                    renderAddonsCustom();
                }
                
                if (item.shippingFee) {
                    currentShippingFee = item.shippingFee;
                    currentDistance = item.distance || 0;
                    
                    const shippingInfo = document.getElementById('shippingInfo');
                    const distanceEl = document.getElementById('distanceValue');
                    const feeEl = document.getElementById('shippingFeeValue');
                    if (shippingInfo && currentDistance > 0) {
                        shippingInfo.style.display = 'block';
                        if (distanceEl) distanceEl.textContent = currentDistance.toFixed(1);
                        if (feeEl) feeEl.textContent = formatShippingFee(currentShippingFee);
                    }
                }
                
                updateAllTotals();
                showNotification('📝 Mode Edit: Silakan perbarui pesanan Anda', 'info');
            }, 100);
        }
    }
}

// ===== UPDATE QUANTITY CUSTOM ITEM =====
function updateCustomQty(itemId, delta) {
    let newQty = customQty[itemId] + delta;
    if (itemId === 'panggung' && newQty > 64) newQty = 64;
    if (newQty < 0) newQty = 0;
    
    customQty[itemId] = newQty;
    
    const inputField = document.getElementById(`qty-${itemId}`);
    if (inputField) inputField.value = newQty;
    
    updateCustomTotalDisplay(itemId);
    updateAllTotals();
}

function updateCustomQtyDirect(itemId) {
    const inputField = document.getElementById(`qty-${itemId}`);
    let newQty = parseInt(inputField.value) || 0;
    if (itemId === 'panggung' && newQty > 64) newQty = 64;
    if (newQty < 0) newQty = 0;
    
    customQty[itemId] = newQty;
    if (inputField) inputField.value = newQty;
    
    updateCustomTotalDisplay(itemId);
    updateAllTotals();
}

function updateCustomTotalDisplay(itemId) {
    const total = customQty[itemId] * customPrices[itemId];
    const totalSpan = document.getElementById(`total-${itemId}`);
    if (totalSpan) totalSpan.textContent = formatRupiah(total);
}

// ===== UPDATE SEMUA TOTAL =====
function updateAllTotals() {
    let subtotal = 0;
    for (let key in customQty) {
        subtotal += customQty[key] * customPrices[key];
    }
    
    const totalAddons = selectedAddonsCustom.reduce((sum, addon) => {
        return sum + (addon.totalPrice || (addon.price * (addon.quantity || 1)));
    }, 0);
    
    const grandTotal = subtotal + totalAddons + currentShippingFee;
    
    document.getElementById('subtotalItem').textContent = formatRupiah(subtotal);
    document.getElementById('totalCustom').textContent = formatRupiah(grandTotal);
    
    updateSummaryItems();
    updateAddonsSummary();
    
    const shippingSummary = document.getElementById('shippingSummaryCustom');
    if (shippingSummary) {
        if (currentShippingFee > 0) {
            shippingSummary.innerHTML = `<div class="summary-row"><span>🚚 Biaya Pengiriman</span><span>${formatRupiah(currentShippingFee)}</span></div>`;
        } else if (currentShippingFee === 0 && currentDistance > 0) {
            shippingSummary.innerHTML = `<div class="summary-row"><span>🚚 Biaya Pengiriman</span><span class="text-success">GRATIS</span></div>`;
        } else {
            shippingSummary.innerHTML = '';
        }
    }
}

// ===== UPDATE SUMMARY ITEMS DI RINGKASAN =====
function updateSummaryItems() {
    const container = document.getElementById('summaryItems');
    let hasItems = false;
    let html = '';
    
    for (let key in customQty) {
        if (customQty[key] > 0) {
            hasItems = true;
            const total = customQty[key] * customPrices[key];
            const unitText = customUnits[key] === 'pcs' ? `${customQty[key]} pcs` : `${customQty[key]} meter`;
            html += `
                <div class="summary-item-row">
                    <span class="summary-item-name">
                        ${customNames[key]} <small>(${unitText})</small>
                    </span>
                    <span class="summary-item-price">${formatRupiah(total)}</span>
                </div>
            `;
        }
    }
    
    if (!hasItems) {
        html = '<p class="text-muted small mb-0">Belum ada item dipilih</p>';
    }
    
    container.innerHTML = html;
}

// ===== RENDER ADD-ONS DENGAN QUANTITY (SEPERTI PAKET.HTML) =====
function renderAddonsCustom() {
    const container = document.getElementById('addonsContainer');
    if (!container) return;
    
    let html = '';
    
    addonsDatabaseCustom.forEach(addon => {
        const existingItem = selectedAddonsCustom.find(a => a.id === addon.id);
        const quantity = existingItem ? (existingItem.quantity || 1) : 0;
        const isChecked = quantity > 0;
        const totalPrice = addon.price * quantity;
        
        html += `
            <div class="col-md-6 col-lg-6 mb-3">
                <div class="addon-card ${isChecked ? 'selected' : ''}" data-addon-id="${addon.id}">
                    <div class="addon-card-inner">
                        <div class="addon-image">
                            <img src="${addon.image}" alt="${addon.name}" 
                                 onerror="this.src='https://placehold.co/60x60/2c7be5/white?text=${addon.name.substring(0, 3)}'">
                        </div>
                        <div class="addon-info">
                            <div class="addon-name">
                                <i class="bi ${addon.icon}"></i>
                                <strong>${addon.name}</strong>
                            </div>
                            <div class="addon-detail">${addon.detail}</div>
                            <div class="addon-price-wrapper">
                                <span class="addon-price">${formatRupiah(addon.price)}</span>
                                <span class="addon-unit">/item</span>
                            </div>
                            <div class="addon-quantity">
                                <button class="qty-btn-sm minus" onclick="event.stopPropagation(); updateAddonQuantityCustom('${addon.id}', -1)">
                                    <i class="bi bi-dash"></i>
                                </button>
                                <span class="qty-value">${quantity}</span>
                                <button class="qty-btn-sm plus" onclick="event.stopPropagation(); updateAddonQuantityCustom('${addon.id}', 1)">
                                    <i class="bi bi-plus"></i>
                                </button>
                                <span class="qty-total">${quantity > 0 ? formatRupiah(totalPrice) : ''}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
    });
    
    container.innerHTML = html;
}

// ===== UPDATE QUANTITY ADD-ON CUSTOM =====
function updateAddonQuantityCustom(addonId, delta) {
    const addon = addonsDatabaseCustom.find(a => a.id === addonId);
    if (!addon) return;
    
    let existingIndex = selectedAddonsCustom.findIndex(a => a.id === addonId);
    let currentQty = existingIndex !== -1 ? (selectedAddonsCustom[existingIndex].quantity || 1) : 0;
    let newQty = currentQty + delta;
    
    if (newQty <= 0) {
        if (existingIndex !== -1) {
            selectedAddonsCustom.splice(existingIndex, 1);
        }
    } else {
        const newItem = {
            id: addon.id,
            name: addon.name,
            detail: addon.detail,
            price: addon.price,
            quantity: newQty,
            totalPrice: addon.price * newQty,
            image: addon.image,
            icon: addon.icon,
            isPerItem: true
        };
        
        if (existingIndex !== -1) {
            selectedAddonsCustom[existingIndex] = newItem;
        } else {
            selectedAddonsCustom.push(newItem);
        }
    }
    
    renderAddonsCustom();
    updateAllTotals();
}

// ===== UPDATE ADD-ONS SUMMARY =====
function updateAddonsSummary() {
    const container = document.getElementById('addonsSummaryCustom');
    if (!container) return;
    
    if (selectedAddonsCustom.length === 0) {
        container.innerHTML = '';
        return;
    }
    
    let html = '<div class="addons-header"><i class="bi bi-plus-circle"></i> Add-ons:</div>';
    selectedAddonsCustom.forEach(addon => {
        const totalPrice = addon.totalPrice || (addon.price * (addon.quantity || 1));
        const qtyText = (addon.quantity > 1) ? ` (${addon.quantity} pcs)` : '';
        html += `
            <div class="addon-summary-row">
                <span>${addon.name}${qtyText}</span>
                <span class="addon-price">${formatRupiah(totalPrice)}</span>
            </div>
        `;
    });
    
    container.innerHTML = html;
}

// ===== CEK ONGKIR (KONSISTEN - TIDAK BERUBAH-UBAH) =====
async function checkShippingFeeCustom() {
    const address = document.getElementById('eventFullAddress').value;
    const shippingInfo = document.getElementById('shippingInfo');
    const distanceEl = document.getElementById('distanceValue');
    const feeEl = document.getElementById('shippingFeeValue');
    const noteEl = document.getElementById('shippingNote');
    const checkBtn = document.getElementById('checkShippingBtn');
    
    if (!address) {
        showNotification('⚠️ Silakan masukkan alamat lengkap acara terlebih dahulu!', 'warning');
        return;
    }
    
    const originalText = checkBtn.innerHTML;
    checkBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Menghitung jarak...';
    checkBtn.disabled = true;
    
    setTimeout(() => {
        let hash = 0;
        for (let i = 0; i < address.length; i++) {
            hash = ((hash << 5) - hash) + address.charCodeAt(i);
            hash = hash & hash;
        }
        
        let distance = (Math.abs(hash) % 60) + 1;
        
        if (address.toLowerCase().includes('jakarta') || address.toLowerCase().includes('tangerang')) {
            distance = Math.min(distance, 15);
        } else if (address.toLowerCase().includes('bogor') || address.toLowerCase().includes('bekasi') || address.toLowerCase().includes('depok')) {
            distance = Math.min(distance, 35);
        } else if (address.toLowerCase().includes('esa unggul') || address.toLowerCase().includes('citra')) {
            distance = 11;
        }
        
        currentDistance = distance;
        currentShippingFee = calculateShippingFee(currentDistance);
        
        distanceEl.textContent = currentDistance.toFixed(1);
        feeEl.textContent = formatShippingFee(currentShippingFee);
        
        if (currentShippingFee === 0) {
            noteEl.innerHTML = `<i class="bi bi-check-circle"></i> ✅ Lokasi dalam radius 10km (${currentDistance.toFixed(1)}km). Pengiriman GRATIS!`;
            noteEl.className = 'shipping-note free';
        } else if (currentDistance <= 30) {
            const extraKm = currentDistance - 10;
            noteEl.innerHTML = `<i class="bi bi-info-circle"></i> 📍 Jarak ${currentDistance.toFixed(1)}km dari lokasi kami.<br>🚚 Biaya pengiriman: ${extraKm.toFixed(1)}km x Rp5.000 = ${formatRupiah(currentShippingFee)}`;
            noteEl.className = 'shipping-note charge';
        } else {
            const extraKm = currentDistance - 30;
            noteEl.innerHTML = `<i class="bi bi-info-circle"></i> 📍 Jarak ${currentDistance.toFixed(1)}km dari lokasi kami.<br>🚚 Biaya pengiriman: 20km pertama x Rp5.000 + ${extraKm.toFixed(1)}km x Rp10.000 = ${formatRupiah(currentShippingFee)}`;
            noteEl.className = 'shipping-note charge';
        }
        
        shippingInfo.style.display = 'block';
        updateAllTotals();
        
        checkBtn.innerHTML = originalText;
        checkBtn.disabled = false;
        
        showNotification(`📍 Jarak: ${currentDistance.toFixed(1)} km | Ongkir: ${formatShippingFee(currentShippingFee)}`, 'info');
    }, 1000);
}

// ===== VALIDASI FORM =====
function validateFormCustom() {
    const name = document.getElementById('customerName').value;
    const phone = document.getElementById('customerPhone').value;
    const date = document.getElementById('eventDate').value;
    const location = document.getElementById('eventLocation').value;
    const fullAddress = document.getElementById('eventFullAddress').value;
    
    let hasItem = false;
    for (let key in customQty) {
        if (customQty[key] > 0) hasItem = true;
    }
    
    if (!hasItem && selectedAddonsCustom.length === 0) {
        showNotification('⚠️ Silakan pilih minimal satu item dekorasi atau add-on!', 'warning');
        return false;
    }
    if (!name) { showNotification('⚠️ Silakan isi nama lengkap!', 'warning'); return false; }
    if (!phone) { showNotification('⚠️ Silakan isi nomor WhatsApp!', 'warning'); return false; }
    if (!date) { showNotification('⚠️ Silakan pilih tanggal acara!', 'warning'); return false; }
    if (!location) { showNotification('⚠️ Silakan isi nama lokasi acara!', 'warning'); return false; }
    if (!fullAddress) { showNotification('⚠️ Silakan isi alamat lengkap acara!', 'warning'); return false; }
    
    return true;
}

// ===== TAMBAH KE KERANJANG (DENGAN EDIT MODE) =====
function addToCartCustom() {
    if (!validateFormCustom()) return;
    
    const customerName = document.getElementById('customerName').value;
    const customerPhone = document.getElementById('customerPhone').value;
    const eventDate = document.getElementById('eventDate').value;
    const eventLocation = document.getElementById('eventLocation').value;
    const eventFullAddress = document.getElementById('eventFullAddress').value;
    
    let customItemsList = [];
    let subtotal = 0;
    
    for (let key in customQty) {
        if (customQty[key] > 0) {
            const total = customQty[key] * customPrices[key];
            subtotal += total;
            customItemsList.push({
                id: `custom-${key}`,
                name: customNames[key],
                quantity: customQty[key],
                unit: customUnits[key],
                pricePerUnit: customPrices[key],
                price: customPrices[key],
                totalPrice: total
            });
        }
    }
    
    let addonsList = selectedAddonsCustom.map(addon => ({
        id: addon.id,
        name: addon.name,
        price: addon.price,
        quantity: addon.quantity || 1,
        totalPrice: addon.totalPrice || (addon.price * (addon.quantity || 1))
    }));
    
    const totalAddons = selectedAddonsCustom.reduce((sum, a) => sum + (a.totalPrice || (a.price * (a.quantity || 1))), 0);
    const totalPrice = subtotal + totalAddons + currentShippingFee;
    
    const cartItem = {
        id: 'paket-custom',
        name: 'Paket Custom',
        price: totalPrice,
        basePrice: subtotal,
        date: eventDate,
        location: eventLocation,
        fullAddress: eventFullAddress,
        customerName: customerName,
        customerPhone: customerPhone,
        customItems: customItemsList,
        addons: addonsList,
        shippingFee: currentShippingFee,
        distance: currentDistance,
        isCustom: true,
        addedAt: new Date().toISOString()
    };
    
    let cart = localStorage.getItem('didinCart');
    cart = cart ? JSON.parse(cart) : [];
    
    if (isEditMode && editIndex >= 0 && editIndex < cart.length) {
        cart[editIndex] = cartItem;
        sessionStorage.removeItem('editCartItem');
        sessionStorage.removeItem('editCartIndex');
        showNotification(`✅ Paket Custom berhasil diperbarui!`, 'success');
    } else {
        cart.push(cartItem);
        showNotification(`✅ Paket Custom ditambahkan ke keranjang!`, 'success');
    }
    
    localStorage.setItem('didinCart', JSON.stringify(cart));
    updateCartBadge();
    
    setTimeout(() => {
        window.location.href = 'cart.html';
    }, 1000);
}

function bookNowCustom() {
    if (!validateFormCustom()) return;
    addToCartCustom();
}

function setMinDate() {
    const today = new Date().toISOString().split('T')[0];
    const dateInput = document.getElementById('eventDate');
    if (dateInput) dateInput.setAttribute('min', today);
}

// ===== INITIALIZE =====
document.addEventListener('DOMContentLoaded', function() {
    setMinDate();
    renderAddonsCustom();
    updateAllTotals();
    checkEditMode();
    
    const addToCartBtn = document.getElementById('addToCartBtn');
    const bookNowBtn = document.getElementById('bookNowBtn');
    const checkShippingBtn = document.getElementById('checkShippingBtn');
    
    if (addToCartBtn) addToCartBtn.addEventListener('click', addToCartCustom);
    if (bookNowBtn) bookNowBtn.addEventListener('click', bookNowCustom);
    if (checkShippingBtn) checkShippingBtn.addEventListener('click', checkShippingFeeCustom);
    
    const backToTop = document.getElementById('backToTop');
    if (backToTop) {
        window.addEventListener('scroll', () => {
            backToTop.classList.toggle('show', window.scrollY > 300);
        });
        backToTop.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }
    
    if (typeof AOS !== 'undefined') AOS.init({ duration: 800, once: true });
    updateCartBadge();
});

// Fungsi global untuk dipanggil dari HTML onclick
function updateCustomQtyGlobal(itemId, delta) {
    updateCustomQty(itemId, delta);
}

function updateCustomQtyDirectGlobal(itemId) {
    updateCustomQtyDirect(itemId);
}