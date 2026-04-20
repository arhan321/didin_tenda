/**
 * PAKET.JS - Halaman detail paket
 * Mengelola tampilan paket berdasarkan parameter URL
 * 
 * CATATAN: Fungsi showNotification(), updateCartBadge(), formatRupiah(),
 *          calculateShippingFee(), formatShippingFee()
 *          sudah didefinisikan di script.js (global)
 */

// ===== DATA PAKET (Simulasi Database) =====
const paketDatabase = {
    'paket-hemat': {
        id: 'paket-hemat',
        name: 'Paket Hemat',
        price: 2500000,
        description: 'Paket ekonomis untuk acara sederhana seperti syukuran, arisan, atau pertemuan keluarga. Dengan pilihan dekorasi yang elegan namun sederhana.',
        features: [
            'Tenda ukuran 3x3 meter',
            'Kursi Futura 50 pcs',
            'Dekorasi pelaminan sederhana',
            'Lampu hias 5 titik',
            'Karpet merah 3x2 meter',
            'Free konsultasi dekorasi'
        ],
        images: [
            'https://placehold.co/600x400/3498db/white?text=Paket+Hemat+1',
            'https://placehold.co/600x400/3498db/white?text=Paket+Hemat+2',
            'https://placehold.co/600x400/3498db/white?text=Paket+Hemat+3'
        ]
    },
    'paket-silver': {
        id: 'paket-silver',
        name: 'Paket Silver',
        price: 4500000,
        description: 'Paket semi-formal untuk acara lamaran, tunangan, atau gathering kantor. Dekorasi lebih lengkap dengan pilihan warna yang bisa disesuaikan.',
        features: [
            'Tenda ukuran 4x4 meter',
            'Kursi Futura 100 pcs',
            'Pelaminan standar dengan backdrop',
            'Lampu hias 10 titik',
            'Karpet merah 5x3 meter',
            'Hiasan bunga segar',
            'Free dokumentasi'
        ],
        images: [
            'https://placehold.co/600x400/e74c3c/white?text=Paket+Silver+1',
            'https://placehold.co/600x400/e74c3c/white?text=Paket+Silver+2',
            'https://placehold.co/600x400/e74c3c/white?text=Paket+Silver+3'
        ]
    },
    'paket-gold': {
        id: 'paket-gold',
        name: 'Paket Gold',
        price: 7500000,
        description: 'Paket premium untuk pernikahan, resmi, atau acara besar lainnya. Dekorasi mewah dengan sentuhan artistik dan peralatan lengkap.',
        features: [
            'Tenda ukuran 6x6 meter',
            'Kursi Futura 200 pcs',
            'Pelaminan mewah dengan ornamen',
            'Rigging & lampu dekorasi 15 titik',
            'Karpet merah premium',
            'Hiasan bunga segar mewah',
            'Backdrop photobooth',
            'MC & dokumentasi'
        ],
        images: [
            'https://placehold.co/600x400/f1c40f/black?text=Paket+Gold+1',
            'https://placehold.co/600x400/f1c40f/black?text=Paket+Gold+2',
            'https://placehold.co/600x400/f1c40f/black?text=Paket+Gold+3'
        ]
    },
    'paket-platinum': {
        id: 'paket-platinum',
        name: 'Paket Platinum',
        price: 12500000,
        description: 'Paket exclusive untuk acara besar seperti pernikahan mewah, konser, atau event corporate. Dengan dekorasi terbaik dan tim profesional.',
        features: [
            'Tenda ukuran 8x8 meter',
            'Kursi Futura 300 pcs',
            'Pelaminan exclusive custom',
            'Lighting profesional + blower',
            'Karpet merah premium lebar',
            'Hiasan bunga segar import',
            'Photobooth + props',
            'MC profesional',
            'Dokumentasi video + foto',
            'Sound system'
        ],
        images: [
            'https://placehold.co/600x400/9b59b6/white?text=Paket+Platinum+1',
            'https://placehold.co/600x400/9b59b6/white?text=Paket+Platinum+2',
            'https://placehold.co/600x400/9b59b6/white?text=Paket+Platinum+3'
        ]
    }
};

// ===== DATA ADD-ONS BARU DENGAN NAMA YANG BENAR =====
const addonsDatabase = [
    { 
        id: 'ac-blower',
        name: 'AC Blower indoor Honeywell',
        detail: 'Pendingin ruangan portable, dingin maksimal',
        price: 400000,
        image: 'assets/images/addons/ac-blower.png',
        icon: 'bi-wind',
        unit: 'unit'
    },
    { 
        id: 'kipas-embun',
        name: 'Kipas embun',
        detail: 'Kipas pendingin outdoor + embun segar',
        price: 500000,
        image: 'assets/images/addons/kipas-embun.png',
        icon: 'bi-fan',
        unit: '1 pcs'
    },
    { 
        id: 'kursi-futura-sarung',
        name: 'Kursi Futura plus sarung',
        detail: 'Kursi futura premium dengan sarung elegan',
        price: 15000,
        image: 'assets/images/addons/kursi-futura-sarung.png',
        icon: 'bi-chair',
        unit: 'per pcs',
        isPerItem: true
    },
    { 
        id: 'kursi-plastik-cover',
        name: 'Kursi plastik plus cover',
        detail: 'Kursi plastik dengan cover rapi',
        price: 9000,
        image: 'assets/images/addons/kursi-plastik-cover.png',
        icon: 'bi-chair',
        unit: 'per pcs',
        isPerItem: true
    },
    { 
        id: 'kursi-plastik',
        name: 'Kursi plastik',
        detail: 'Kursi plastik standar kokoh',
        price: 7000,
        image: 'assets/images/addons/kursi-plastik.png',
        icon: 'bi-chair',
        unit: 'per pcs',
        isPerItem: true
    },
    { 
        id: 'kursi-futura',
        name: 'Kursi Futura',
        detail: 'Kursi futura standar nyaman',
        price: 13000,
        image: 'assets/images/addons/kursi-futura.png',
        icon: 'bi-chair',
        unit: 'per pcs',
        isPerItem: true
    },
    { 
        id: 'kursi-stainless',
        name: 'Kursi stainless',
        detail: 'Kursi stainless steel mewah anti karat',
        price: 10000,
        image: 'assets/images/addons/kursi-stainless.png',
        icon: 'bi-brightness-alt-high',
        unit: 'per pcs',
        isPerItem: true
    }
];

// Variabel global
let currentPaket = null;
let selectedAddons = [];
let isEditMode = false;
let editIndex = -1;
let currentDistance = 0;
let currentShippingFee = 0;

// ===== FUNGSI UNTUK MENDAPATKAN JARAK KONSISTEN =====
function getConsistentDistanceFromAddress(address) {
    if (!address || address.trim() === '') {
        return 0;
    }
    
    let hash = 0;
    for (let i = 0; i < address.length; i++) {
        hash = ((hash << 5) - hash) + address.charCodeAt(i);
        hash = hash & hash;
    }
    
    const distance = (Math.abs(hash) % 50) + 1;
    
    if (address.toLowerCase().includes('jakarta') || address.toLowerCase().includes('tangerang')) {
        return Math.min(distance, 15);
    }
    
    if (address.toLowerCase().includes('bogor') || address.toLowerCase().includes('bekasi') || address.toLowerCase().includes('depok')) {
        return Math.min(distance, 30);
    }
    
    return distance;
}

// ===== AMBIL PARAMETER URL =====
function getPaketIdFromURL() {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get('id');
}

// ===== CEK APAKAH MODE EDIT =====
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
                if (item.addons && item.addons.length > 0) {
                    selectedAddons = item.addons;
                }
                if (item.shippingFee !== undefined) {
                    currentShippingFee = item.shippingFee;
                    currentDistance = item.distance || 0;
                    updatePriceSummaryWithShipping();
                    
                    const shippingInfo = document.getElementById('shippingInfo');
                    const distanceEl = document.getElementById('distanceValue');
                    const feeEl = document.getElementById('shippingFeeValue');
                    if (shippingInfo && currentDistance > 0) {
                        shippingInfo.style.display = 'block';
                        if (distanceEl) distanceEl.textContent = currentDistance.toFixed(1);
                        if (feeEl) feeEl.textContent = formatShippingFee(currentShippingFee);
                        
                        const noteEl = document.getElementById('shippingNote');
                        if (noteEl) {
                            if (currentShippingFee === 0) {
                                noteEl.innerHTML = '<i class="bi bi-check-circle"></i> Lokasi dalam radius 10km, pengiriman GRATIS!';
                                noteEl.className = 'shipping-note free';
                            } else if (currentDistance <= 30) {
                                noteEl.innerHTML = `<i class="bi bi-info-circle"></i> Jarak ${currentDistance.toFixed(1)}km (${(currentDistance - 10).toFixed(1)}km x Rp5.000) = ${formatRupiah(currentShippingFee)}`;
                                noteEl.className = 'shipping-note charge';
                            } else {
                                noteEl.innerHTML = `<i class="bi bi-info-circle"></i> Jarak ${currentDistance.toFixed(1)}km (20km pertama x Rp5.000 + ${(currentDistance - 30).toFixed(1)}km x Rp10.000) = ${formatRupiah(currentShippingFee)}`;
                                noteEl.className = 'shipping-note charge';
                            }
                        }
                    }
                }
                renderAddons();
                updatePriceSummary();
            }, 100);
        }
    }
}

// ===== LOAD DATA PAKET =====
function loadPaketData() {
    const paketId = getPaketIdFromURL();
    
    if (!paketId || !paketDatabase[paketId]) {
        window.location.href = 'index.html';
        return;
    }
    
    currentPaket = paketDatabase[paketId];
    renderPaketPage();
    checkEditMode();
}

// ===== RENDER HALAMAN =====
function renderPaketPage() {
    if (!currentPaket) return;
    
    const breadcrumbEl = document.getElementById('paketNameBreadcrumb');
    if (breadcrumbEl) breadcrumbEl.textContent = currentPaket.name;
    
    const titleEl = document.getElementById('paketTitle');
    if (titleEl) titleEl.textContent = currentPaket.name;
    document.title = `${currentPaket.name} - Didin Tenda Decoration`;
    
    const priceEl = document.getElementById('paketPrice');
    const summaryPaketEl = document.getElementById('summaryPaketPrice');
    if (priceEl) priceEl.textContent = formatRupiah(currentPaket.price);
    if (summaryPaketEl) summaryPaketEl.textContent = formatRupiah(currentPaket.price);
    
    const descEl = document.getElementById('paketDesc');
    if (descEl) descEl.textContent = currentPaket.description;
    
    const featuresContainer = document.getElementById('paketFeatures');
    if (featuresContainer) {
        let featuresHtml = '<h6><i class="bi bi-check-circle-fill text-primary"></i> Fasilitas Paket:</h6>';
        currentPaket.features.forEach(feature => {
            featuresHtml += `<div class="feature-item">
                <i class="bi bi-check-circle-fill text-primary"></i>
                <span>${feature}</span>
            </div>`;
        });
        featuresContainer.innerHTML = featuresHtml;
    }
    
    const mainImage = document.getElementById('mainImage');
    if (mainImage) {
        mainImage.src = currentPaket.images[0];
        mainImage.alt = currentPaket.name;
    }
    
    const thumbsContainer = document.getElementById('galleryThumbs');
    if (thumbsContainer) {
        let thumbsHtml = '';
        currentPaket.images.forEach((img, index) => {
            thumbsHtml += `<img src="${img}" alt="Thumb ${index + 1}" onclick="changeMainImage(${index})">`;
        });
        thumbsContainer.innerHTML = thumbsHtml;
    }
    
    renderAddons();
    
    const today = new Date().toISOString().split('T')[0];
    const dateInput = document.getElementById('eventDate');
    if (dateInput) dateInput.setAttribute('min', today);
    
    const checkShippingBtn = document.getElementById('checkShippingBtn');
    if (checkShippingBtn) {
        const newBtn = checkShippingBtn.cloneNode(true);
        checkShippingBtn.parentNode.replaceChild(newBtn, checkShippingBtn);
        newBtn.addEventListener('click', checkShippingFee);
    }
    
    const addressInput = document.getElementById('eventFullAddress');
    if (addressInput) {
        addressInput.addEventListener('input', function() {
            if (currentDistance !== 0) {
                resetShipping();
            }
        });
    }
}

// ===== RENDER ADD-ONS DENGAN GAMBAR & QUANTITY =====
function renderAddons() {
    const container = document.getElementById('addonsContainer');
    if (!container) return;
    
    let html = '';
    
    addonsDatabase.forEach(addon => {
        const existingItem = selectedAddons.find(a => a.id === addon.id);
        const quantity = existingItem ? (existingItem.quantity || 1) : 0;
        const isChecked = quantity > 0;
        const totalPrice = addon.price * quantity;
        
        const imageUrl = addon.image;
        
        html += `
            <div class="col-md-6 col-lg-6 mb-3">
                <div class="addon-card ${isChecked ? 'selected' : ''}" data-addon-id="${addon.id}">
                    <div class="addon-card-inner">
                        <div class="addon-image">
                            <img src="${imageUrl}" alt="${addon.name}" 
                                 onerror="this.src='https://placehold.co/80x80/2c3e50/white?text=${addon.name.substring(0, 3)}'">
                        </div>
                        <div class="addon-info">
                            <div class="addon-name">
                                <i class="bi ${addon.icon}"></i>
                                <strong>${addon.name}</strong>
                            </div>
                            <div class="addon-detail">${addon.detail}</div>
                            <div class="addon-price-wrapper">
                                <span class="addon-price">${formatRupiah(addon.price)}</span>
                                <span class="addon-unit">/${addon.unit || 'item'}</span>
                            </div>
                            ${addon.isPerItem ? `
                            <div class="addon-quantity">
                                <button class="qty-btn minus" onclick="event.stopPropagation(); updateAddonQuantity('${addon.id}', -1)">
                                    <i class="bi bi-dash"></i>
                                </button>
                                <span class="qty-value">${quantity}</span>
                                <button class="qty-btn plus" onclick="event.stopPropagation(); updateAddonQuantity('${addon.id}', 1)">
                                    <i class="bi bi-plus"></i>
                                </button>
                                <span class="qty-total">${quantity > 0 ? formatRupiah(totalPrice) : ''}</span>
                            </div>
                            ` : `
                            <div class="addon-check">
                                <div class="custom-checkbox ${isChecked ? 'checked' : ''}" onclick="event.stopPropagation(); toggleSimpleAddon('${addon.id}')">
                                    ${isChecked ? '<i class="bi bi-check-lg"></i>' : ''}
                                </div>
                            </div>
                            `}
                        </div>
                    </div>
                </div>
            </div>
        `;
    });
    
    container.innerHTML = html;
}

// ===== UPDATE QUANTITY ADD-ON =====
function updateAddonQuantity(addonId, delta) {
    const addon = addonsDatabase.find(a => a.id === addonId);
    if (!addon) return;
    
    let existingIndex = selectedAddons.findIndex(a => a.id === addonId);
    let currentQty = existingIndex !== -1 ? (selectedAddons[existingIndex].quantity || 1) : 0;
    let newQty = currentQty + delta;
    
    if (newQty <= 0) {
        if (existingIndex !== -1) {
            selectedAddons.splice(existingIndex, 1);
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
            unit: addon.unit,
            isPerItem: addon.isPerItem
        };
        
        if (existingIndex !== -1) {
            selectedAddons[existingIndex] = newItem;
        } else {
            selectedAddons.push(newItem);
        }
    }
    
    renderAddons();
    updatePriceSummaryWithShipping();
}

// ===== TOGGLE SIMPLE ADD-ON =====
function toggleSimpleAddon(addonId) {
    const addon = addonsDatabase.find(a => a.id === addonId);
    if (!addon) return;
    
    const index = selectedAddons.findIndex(a => a.id === addonId);
    if (index === -1) {
        selectedAddons.push({
            id: addon.id,
            name: addon.name,
            detail: addon.detail,
            price: addon.price,
            quantity: 1,
            totalPrice: addon.price,
            image: addon.image,
            icon: addon.icon,
            unit: addon.unit
        });
    } else {
        selectedAddons.splice(index, 1);
    }
    
    renderAddons();
    updatePriceSummaryWithShipping();
}

// ===== UPDATE HARGA TOTAL DENGAN ONGKIR =====
function updatePriceSummaryWithShipping() {
    const totalAddons = selectedAddons.reduce((sum, addon) => {
        const itemPrice = addon.totalPrice || (addon.price * (addon.quantity || 1));
        return sum + itemPrice;
    }, 0);
    
    const grandTotal = currentPaket.price + totalAddons + currentShippingFee;
    
    const addonsSummary = document.getElementById('addonsSummary');
    if (addonsSummary) {
        if (selectedAddons.length > 0) {
            let addonsHtml = '';
            selectedAddons.forEach(addon => {
                const itemTotal = addon.totalPrice || (addon.price * (addon.quantity || 1));
                const qtyText = (addon.quantity && addon.quantity > 1) ? ` (${addon.quantity} pcs)` : '';
                addonsHtml += `
                    <div class="summary-row">
                        <span>+ ${addon.name}${qtyText}</span>
                        <span>${formatRupiah(itemTotal)}</span>
                    </div>
                `;
            });
            addonsSummary.innerHTML = addonsHtml;
        } else {
            addonsSummary.innerHTML = '<div class="summary-row"><span>Tidak ada add-ons</span><span>Rp 0</span></div>';
        }
    }
    
    const shippingSummary = document.getElementById('shippingSummary');
    if (shippingSummary) {
        if (currentShippingFee > 0) {
            shippingSummary.innerHTML = `
                <div class="summary-row">
                    <span>🚚 Biaya Pengiriman</span>
                    <span>${formatRupiah(currentShippingFee)}</span>
                </div>
            `;
        } else if (currentShippingFee === 0 && currentDistance > 0) {
            shippingSummary.innerHTML = `
                <div class="summary-row">
                    <span>🚚 Biaya Pengiriman</span>
                    <span class="text-success">GRATIS</span>
                </div>
            `;
        } else {
            shippingSummary.innerHTML = '';
        }
    }
    
    const summaryTotal = document.getElementById('summaryTotal');
    if (summaryTotal) summaryTotal.textContent = formatRupiah(grandTotal);
}

// ===== UPDATE HARGA TOTAL (TANPA ONGKIR) =====
function updatePriceSummary() {
    const totalAddons = selectedAddons.reduce((sum, addon) => {
        const itemPrice = addon.totalPrice || (addon.price * (addon.quantity || 1));
        return sum + itemPrice;
    }, 0);
    const grandTotal = currentPaket.price + totalAddons;
    
    const addonsSummary = document.getElementById('addonsSummary');
    if (addonsSummary) {
        if (selectedAddons.length > 0) {
            let addonsHtml = '';
            selectedAddons.forEach(addon => {
                const itemTotal = addon.totalPrice || (addon.price * (addon.quantity || 1));
                const qtyText = (addon.quantity && addon.quantity > 1) ? ` (${addon.quantity} pcs)` : '';
                addonsHtml += `
                    <div class="summary-row">
                        <span>+ ${addon.name}${qtyText}</span>
                        <span>${formatRupiah(itemTotal)}</span>
                    </div>
                `;
            });
            addonsSummary.innerHTML = addonsHtml;
        } else {
            addonsSummary.innerHTML = '<div class="summary-row"><span>Tidak ada add-ons</span><span>Rp 0</span></div>';
        }
    }
    
    const summaryTotal = document.getElementById('summaryTotal');
    if (summaryTotal) summaryTotal.textContent = formatRupiah(grandTotal);
}

// ===== CEK ONGKIR =====
function checkShippingFee() {
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
        currentDistance = getConsistentDistanceFromAddress(address);
        currentShippingFee = calculateShippingFee(currentDistance);
        
        distanceEl.textContent = currentDistance.toFixed(1);
        feeEl.textContent = formatShippingFee(currentShippingFee);
        
        if (currentShippingFee === 0) {
            noteEl.innerHTML = `<i class="bi bi-check-circle"></i> ✅ Lokasi dalam radius 10km (${currentDistance.toFixed(1)}km). Pengiriman GRATIS!<br><small class="text-muted">📍 Alamat: ${address.substring(0, 60)}${address.length > 60 ? '...' : ''}</small>`;
            noteEl.className = 'shipping-note free';
        } else if (currentDistance <= 30) {
            const extraKm = currentDistance - 10;
            noteEl.innerHTML = `<i class="bi bi-info-circle"></i> 📍 Jarak ${currentDistance.toFixed(1)}km dari lokasi kami.<br>🚚 Biaya pengiriman: ${(currentDistance - 10).toFixed(1)}km x Rp5.000 = ${formatRupiah(currentShippingFee)}<br><small class="text-muted">Alamat: ${address.substring(0, 60)}${address.length > 60 ? '...' : ''}</small>`;
            noteEl.className = 'shipping-note charge';
        } else {
            const extraKm = currentDistance - 30;
            noteEl.innerHTML = `<i class="bi bi-info-circle"></i> 📍 Jarak ${currentDistance.toFixed(1)}km dari lokasi kami.<br>🚚 Biaya pengiriman: 20km pertama x Rp5.000 + ${extraKm.toFixed(1)}km x Rp10.000 = ${formatRupiah(currentShippingFee)}<br><small class="text-muted">Alamat: ${address.substring(0, 60)}${address.length > 60 ? '...' : ''}</small>`;
            noteEl.className = 'shipping-note charge';
        }
        
        shippingInfo.style.display = 'block';
        updatePriceSummaryWithShipping();
        
        checkBtn.innerHTML = originalText;
        checkBtn.disabled = false;
        
        showNotification(`📍 Jarak: ${currentDistance.toFixed(1)} km | Ongkir: ${formatShippingFee(currentShippingFee)}`, 'info');
    }, 1000);
}

// ===== RESET ONGKIR =====
function resetShipping() {
    currentDistance = 0;
    currentShippingFee = 0;
    const shippingInfo = document.getElementById('shippingInfo');
    if (shippingInfo) shippingInfo.style.display = 'none';
    updatePriceSummaryWithShipping();
}

// ===== CHANGE MAIN IMAGE =====
function changeMainImage(index) {
    if (currentPaket && currentPaket.images[index]) {
        const mainImage = document.getElementById('mainImage');
        if (mainImage) mainImage.src = currentPaket.images[index];
    }
}

// ===== VALIDASI FORM =====
function validateForm() {
    const date = document.getElementById('eventDate').value;
    const location = document.getElementById('eventLocation').value;
    const fullAddress = document.getElementById('eventFullAddress').value;
    const name = document.getElementById('customerName').value;
    const phone = document.getElementById('customerPhone').value;
    
    if (!date) {
        showNotification('⚠️ Silakan pilih tanggal acara!', 'warning');
        return false;
    }
    if (!location) {
        showNotification('⚠️ Silakan isi nama lokasi acara!', 'warning');
        return false;
    }
    if (!fullAddress) {
        showNotification('⚠️ Silakan isi alamat lengkap acara!', 'warning');
        return false;
    }
    if (!name) {
        showNotification('⚠️ Silakan isi nama lengkap!', 'warning');
        return false;
    }
    if (!phone) {
        showNotification('⚠️ Silakan isi nomor WhatsApp!', 'warning');
        return false;
    }
    
    return true;
}

// ===== TAMBAH KE KERANJANG =====
function addToCart() {
    if (!validateForm()) return;
    
    const eventDate = document.getElementById('eventDate').value;
    const eventLocation = document.getElementById('eventLocation').value;
    const eventFullAddress = document.getElementById('eventFullAddress').value;
    const customerName = document.getElementById('customerName').value;
    const customerPhone = document.getElementById('customerPhone').value;
    
    const totalAddons = selectedAddons.reduce((sum, addon) => {
        const itemPrice = addon.totalPrice || (addon.price * (addon.quantity || 1));
        return sum + itemPrice;
    }, 0);
    const totalPrice = currentPaket.price + totalAddons + currentShippingFee;
    
    const cartItem = {
        id: currentPaket.id,
        name: currentPaket.name,
        price: totalPrice,
        basePrice: currentPaket.price,
        date: eventDate,
        location: eventLocation,
        fullAddress: eventFullAddress,
        customerName: customerName,
        customerPhone: customerPhone,
        addons: selectedAddons.map(addon => ({
            id: addon.id,
            name: addon.name,
            detail: addon.detail,
            price: addon.price,
            quantity: addon.quantity || 1,
            totalPrice: addon.totalPrice || (addon.price * (addon.quantity || 1))
        })),
        shippingFee: currentShippingFee,
        distance: currentDistance,
        addedAt: new Date().toISOString()
    };
    
    let cart = localStorage.getItem('didinCart');
    cart = cart ? JSON.parse(cart) : [];
    
    if (isEditMode && editIndex >= 0 && editIndex < cart.length) {
        cart[editIndex] = cartItem;
        sessionStorage.removeItem('editCartItem');
        sessionStorage.removeItem('editCartIndex');
        showNotification(`✅ ${currentPaket.name} berhasil diperbarui!`, 'success');
    } else {
        cart.push(cartItem);
        showNotification(`✅ ${currentPaket.name} ditambahkan ke keranjang!`, 'success');
    }
    
    localStorage.setItem('didinCart', JSON.stringify(cart));
    updateCartBadge();
    
    setTimeout(() => {
        window.location.href = 'cart.html';
    }, 1000);
}

// ===== BOOKING & BAYAR LANGSUNG =====
function bookNow() {
    if (!validateForm()) return;
    addToCart();
}

// ===== INITIALIZE =====
document.addEventListener('DOMContentLoaded', function() {
    loadPaketData();
    
    const addToCartBtn = document.getElementById('addToCartBtn');
    const bookNowBtn = document.getElementById('bookNowBtn');
    
    if (addToCartBtn) addToCartBtn.addEventListener('click', addToCart);
    if (bookNowBtn) bookNowBtn.addEventListener('click', bookNow);
    
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