/**
 * PAKET-CUSTOM.JS
 *
 * Paket Custom sudah connect ke database Laravel:
 * - window.DIDIN_CUSTOM_ITEMS
 * - window.DIDIN_ADDONS
 * - window.DIDIN_CUSTOM_ROUTES
 * - window.DIDIN_SHIPPING_CONFIG
 *
 * Catatan penting:
 * - Tidak memakai localStorage.
 * - Tidak mengubah struktur styling add-ons lama.
 * - Add-ons tetap memakai class lama:
 *   addon-card, addon-card-inner, addon-image, addon-info,
 *   addon-name, addon-detail, addon-price-wrapper,
 *   addon-quantity, qty-btn, qty-value, qty-total.
 */

let customItems = [];
let addonsData = [];

let customQty = {};
let selectedAddonsCustom = [];

let selectedLocation = {
    lat: null,
    lng: null,
    address: null,
    distanceKm: 0,
    shippingFee: 0,
    routeFound: false,
};

let eventMap = null;
let baseMarker = null;
let eventMarker = null;
let routeLine = null;

document.addEventListener('DOMContentLoaded', function () {
    customItems = normalizeCustomItems(Array.isArray(window.DIDIN_CUSTOM_ITEMS) ? window.DIDIN_CUSTOM_ITEMS : []);

    // Fallback penting: kalau data window.DIDIN_CUSTOM_ITEMS belum terbaca,
    // item tetap bisa diambil dari atribut data-* di Blade.
    if (!customItems.length) {
        customItems = getCustomItemsFromDom();
    }

    addonsData = normalizeAddons(Array.isArray(window.DIDIN_ADDONS) ? window.DIDIN_ADDONS : []);

    initAosCustom();
    initMinDate();
    initCustomState();
    renderAddonsCustom();
    bindCustomEvents();
    updateAllTotals();
    updateCartBadge();

    if (!customItems.length) {
        console.warn('Data custom item kosong. Pastikan FrontendController mengirim $customItems ke view paket-custom.');
    }
});


function normalizeCustomItems(items) {
    return items
        .map(item => normalizeCustomItem(item))
        .filter(item => item.id !== null && item.id !== undefined && item.id !== '');
}

function normalizeCustomItem(item) {
    if (!item || typeof item !== 'object') {
        return {};
    }

    return {
        id: item.id,
        name: item.name || 'Item',
        slug: item.slug || null,
        description: item.description || null,
        unit: item.unit || 'pcs',
        price: toSafeNumber(item.price, 0),
        minQuantity: toSafeNumber(item.minQuantity ?? item.min_quantity, 0),
        maxQuantity: normalizeNullableNumber(item.maxQuantity ?? item.max_quantity),
        image: item.image || null,
        icon: item.icon || null,
    };
}

function normalizeAddons(items) {
    return items
        .map(addon => ({
            ...addon,
            price: toSafeNumber(addon.price, 0),
            stock: normalizeNullableNumber(addon.stock),
            maxQuantity: normalizeNullableNumber(addon.maxQuantity ?? addon.max_quantity),
        }))
        .filter(addon => addon.id !== null && addon.id !== undefined && addon.id !== '');
}

function getCustomItemsFromDom() {
    return Array.from(document.querySelectorAll('.custom-item-row[data-custom-id]'))
        .map(row => normalizeCustomItem({
            id: row.dataset.customId,
            name: row.dataset.name,
            slug: row.dataset.slug,
            description: row.dataset.description,
            price: row.dataset.price,
            unit: row.dataset.unit,
            minQuantity: row.dataset.minQuantity,
            maxQuantity: row.dataset.maxQuantity || null,
        }));
}

function getCustomItemFromDom(itemId) {
    const row = document.querySelector(`.custom-item-row[data-custom-id="${cssEscapeValue(itemId)}"]`);

    if (!row) {
        return null;
    }

    return normalizeCustomItem({
        id: row.dataset.customId,
        name: row.dataset.name,
        slug: row.dataset.slug,
        description: row.dataset.description,
        price: row.dataset.price,
        unit: row.dataset.unit,
        minQuantity: row.dataset.minQuantity,
        maxQuantity: row.dataset.maxQuantity || null,
    });
}

function bindCustomQtyEvents() {
    document.querySelectorAll('[data-custom-qty-button]').forEach(button => {
        if (button.dataset.bound === '1') return;

        button.dataset.bound = '1';

        button.addEventListener('click', function () {
            updateCustomQty(this.dataset.customId, Number(this.dataset.delta || 0));
        });
    });

    document.querySelectorAll('[data-custom-qty-input]').forEach(input => {
        if (input.dataset.bound === '1') return;

        input.dataset.bound = '1';

        input.addEventListener('change', function () {
            updateCustomQtyDirect(this.dataset.customId || String(this.id || '').replace('qty-custom-', ''));
        });
    });
}

function toSafeNumber(value, fallback = 0) {
    const number = Number(value);

    return Number.isFinite(number) ? number : fallback;
}

function normalizeNullableNumber(value) {
    if (value === null || value === undefined || value === '') {
        return null;
    }

    const number = Number(value);

    return Number.isFinite(number) ? number : null;
}

function cssEscapeValue(value) {
    if (window.CSS && typeof window.CSS.escape === 'function') {
        return window.CSS.escape(String(value));
    }

    return String(value).replaceAll('"', '\\"');
}

// ==================== INIT ====================

function initAosCustom() {
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 800,
            once: true,
        });
    }
}

function initMinDate() {
    const dateInput = document.getElementById('eventDate');

    if (!dateInput) return;

    const today = new Date();
    today.setHours(0, 0, 0, 0);

    const year = today.getFullYear();
    const month = String(today.getMonth() + 1).padStart(2, '0');
    const day = String(today.getDate()).padStart(2, '0');

    dateInput.setAttribute('min', `${year}-${month}-${day}`);
}

function initCustomState() {
    customItems.forEach(item => {
        const input = getCustomInput(item.id);
        customQty[getKey(item.id)] = Number(input?.value || 0);
    });
}

function bindCustomEvents() {
    bindCustomQtyEvents();

    const addToCartBtn = document.getElementById('addToCartBtn');
    const bookNowBtn = document.getElementById('bookNowBtn');
    const checkShippingBtn = document.getElementById('checkShippingBtn');

    if (addToCartBtn) {
        addToCartBtn.addEventListener('click', function () {
            submitCustomOrder(false, this);
        });
    }

    if (bookNowBtn) {
        bookNowBtn.addEventListener('click', function () {
            submitCustomOrder(true, this);
        });
    }

    if (checkShippingBtn) {
        checkShippingBtn.addEventListener('click', openLocationMapModal);
    }

    const backToTop = document.getElementById('backToTop');

    if (backToTop) {
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

    const mapSearchBtn = document.getElementById('mapSearchBtn');
    const mapSearchInput = document.getElementById('mapSearchInput');
    const useSelectedPointBtn = document.getElementById('useSelectedPointBtn');
    const useMyLocationBtn = document.getElementById('useMyLocationBtn');

    if (mapSearchBtn) {
        mapSearchBtn.addEventListener('click', searchLocationOnMap);
    }

    if (mapSearchInput) {
        mapSearchInput.addEventListener('keydown', function (event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                searchLocationOnMap();
            }
        });
    }

    if (useSelectedPointBtn) {
        useSelectedPointBtn.addEventListener('click', useSelectedPoint);
    }

    if (useMyLocationBtn) {
        useMyLocationBtn.addEventListener('click', useMyCurrentLocation);
    }

    ['eventFullAddress', 'eventLocation'].forEach(id => {
        const element = document.getElementById(id);

        if (!element) return;

        element.addEventListener('input', function () {
            resetShippingOnly();
        });
    });
}

// ==================== CUSTOM ITEMS ====================

window.updateCustomQty = function (itemId, delta) {
    const item = getCustomItem(itemId);
    const input = getCustomInput(itemId);

    if (!item || !input) return;

    const key = getKey(itemId);

    let currentQty = Number(input.value || 0);
    let newQty = currentQty + Number(delta || 0);

    newQty = normalizeCustomQuantity(item, newQty);

    input.value = newQty;
    customQty[key] = newQty;

    updateCustomTotalDisplay(itemId);
    updateAllTotals();
};

window.updateCustomQtyDirect = function (itemId) {
    const item = getCustomItem(itemId);
    const input = getCustomInput(itemId);

    if (!item || !input) return;

    const key = getKey(itemId);

    let newQty = Number(input.value || 0);
    newQty = normalizeCustomQuantity(item, newQty);

    input.value = newQty;
    customQty[key] = newQty;

    updateCustomTotalDisplay(itemId);
    updateAllTotals();
};

function normalizeCustomQuantity(item, qty) {
    let value = Math.floor(toSafeNumber(qty, 0));

    if (value < 0) {
        value = 0;
    }

    const minQty = toSafeNumber(item.minQuantity, 0);
    const maxQty = normalizeNullableNumber(item.maxQuantity);

    if (value > 0 && minQty > 0 && value < minQty) {
        value = minQty;
    }

    if (maxQty !== null && value > maxQty) {
        value = maxQty;
        showCustomNotification(`Jumlah ${item.name} maksimal ${maxQty} ${item.unit}.`, 'warning');
    }

    return value;
}

function updateCustomTotalDisplay(itemId) {
    const item = getCustomItem(itemId);

    if (!item) return;

    const key = getKey(itemId);
    const totalElement = document.getElementById(`total-custom-${itemId}`);
    const qty = Number(customQty[key] || 0);
    const total = qty * toSafeNumber(item.price, 0);

    if (totalElement) {
        totalElement.textContent = formatRupiah(total);
    }

    const row = document.querySelector(`.custom-item-row[data-custom-id="${cssEscapeValue(itemId)}"]`);

    if (row) {
        row.classList.toggle('selected', qty > 0);
    }
}

function getCustomInput(itemId) {
    return document.getElementById(`qty-custom-${itemId}`);
}

function getCustomItem(itemId) {
    let item = customItems.find(item => getKey(item.id) === getKey(itemId));

    if (item) {
        return item;
    }

    item = getCustomItemFromDom(itemId);

    if (item) {
        customItems.push(item);
        customQty[getKey(item.id)] = Number(getCustomInput(item.id)?.value || 0);

        return item;
    }

    console.warn('Custom item tidak ditemukan:', itemId);

    return null;
}

function getSelectedCustomItems() {
    return customItems
        .map(item => {
            const key = getKey(item.id);
            const quantity = Number(customQty[key] || 0);
            const price = toSafeNumber(item.price, 0);

            return {
                id: item.id,
                name: item.name,
                slug: item.slug,
                description: item.description,
                unit: item.unit || 'pcs',
                quantity: quantity,
                price: price,
                totalPrice: price * quantity,
                total_price: price * quantity,
            };
        })
        .filter(item => item.quantity > 0);
}

// ==================== ADD-ONS - STRUKTUR CLASS LAMA ====================

function renderAddonsCustom() {
    const container = document.getElementById('addonsContainer');

    if (!container) return;

    if (!addonsData.length) {
        container.innerHTML = `
            <div class="col-12">
                <p class="text-muted small mb-0">Belum ada add-ons tersedia.</p>
            </div>
        `;
        return;
    }

    let html = '';

    addonsData.forEach(addon => {
        const existingItem = selectedAddonsCustom.find(item => getKey(item.id) === getKey(addon.id));
        const quantity = existingItem ? Number(existingItem.quantity || 1) : 0;
        const isChecked = quantity > 0;
        const totalPrice = Number(addon.price || 0) * quantity;

        const imageUrl = addon.image || `https://placehold.co/80x80/2c3e50/white?text=${encodeURIComponent(shortLabel(addon.name || 'Add'))}`;
        const addonIcon = addon.icon || 'bi-plus-circle';
        const addonDetail = addon.detail || addon.description || '';
        const addonUnit = addon.unit || 'pcs';

        html += `
            <div class="col-md-6 col-lg-6 mb-3">
                <div class="addon-card ${isChecked ? 'selected' : ''}" data-addon-id="${escapeAttribute(addon.id)}">
                    <div class="addon-card-inner">
                        <div class="addon-image">
                            <img
                                src="${escapeAttribute(imageUrl)}"
                                alt="${escapeAttribute(addon.name || 'Add-on')}"
                                onerror="this.src='https://placehold.co/80x80/2c3e50/white?text=${encodeURIComponent(shortLabel(addon.name || 'Add'))}'"
                            >
                        </div>

                        <div class="addon-info">
                            <div class="addon-name">
                                <i class="bi ${escapeAttribute(addonIcon)}"></i>
                                <strong>${escapeHtml(addon.name || 'Add-on')}</strong>
                            </div>

                            <div class="addon-detail">
                                ${escapeHtml(addonDetail)}
                            </div>

                            <div class="addon-price-wrapper">
                                <span class="addon-price">${formatRupiah(addon.price)}</span>
                                <span class="addon-unit">/${escapeHtml(addonUnit)}</span>
                            </div>

                            <div class="custom-item-qty addon-qty-wrapper mt-2">
                                <button
                                    type="button"
                                    class="qty-btn-sm minus"
                                    onclick="event.stopPropagation(); updateAddonQuantity(${jsValue(addon.id)}, -1)"
                                >
                                    -
                                </button>

                                <input
                                    type="number"
                                    class="qty-input-sm"
                                    id="qty-addon-${escapeAttribute(addon.id)}"
                                    value="${escapeAttribute(quantity)}"
                                    min="0"
                                    ${addon.stock ? `max="${escapeAttribute(addon.stock)}"` : ''}
                                    onchange="updateAddonQuantityDirect(${jsValue(addon.id)})"
                                >

                                <button
                                    type="button"
                                    class="qty-btn-sm plus"
                                    onclick="event.stopPropagation(); updateAddonQuantity(${jsValue(addon.id)}, 1)"
                                >
                                    +
                                </button>

                                <span class="item-total-sm addon-total-sm" id="total-addon-${escapeAttribute(addon.id)}">
                                    ${quantity > 0 ? formatRupiah(totalPrice) : 'Rp 0'}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
    });

    container.innerHTML = html;
}

window.updateAddonQuantity = function (addonId, delta) {
    const addon = getAddon(addonId);

    if (!addon) return;

    const existingIndex = selectedAddonsCustom.findIndex(item => getKey(item.id) === getKey(addonId));
    const currentQty = existingIndex !== -1
        ? Number(selectedAddonsCustom[existingIndex].quantity || 1)
        : 0;

    let newQty = currentQty + Number(delta || 0);
    newQty = normalizeAddonQuantity(addon, newQty);

    if (newQty <= 0) {
        if (existingIndex !== -1) {
            selectedAddonsCustom.splice(existingIndex, 1);
        }
    } else {
        const newItem = {
            id: addon.id,
            name: addon.name,
            detail: addon.detail || addon.description || null,
            description: addon.description || addon.detail || null,
            price: Number(addon.price || 0),
            quantity: newQty,
            unit: addon.unit || 'pcs',
            totalPrice: Number(addon.price || 0) * newQty,
            total_price: Number(addon.price || 0) * newQty,
            image: addon.image || null,
            icon: addon.icon || null,
        };

        if (existingIndex !== -1) {
            selectedAddonsCustom[existingIndex] = newItem;
        } else {
            selectedAddonsCustom.push(newItem);
        }
    }

    renderAddonsCustom();
    updateAllTotals();
};
window.updateAddonQuantityDirect = function (addonId) {
    const addon = getAddon(addonId);
    const input = document.getElementById(`qty-addon-${addonId}`);

    if (!addon || !input) return;

    let newQty = Number(input.value || 0);
    newQty = normalizeAddonQuantity(addon, newQty);

    const existingIndex = selectedAddonsCustom.findIndex(item => getKey(item.id) === getKey(addonId));

    if (newQty <= 0) {
        if (existingIndex !== -1) {
            selectedAddonsCustom.splice(existingIndex, 1);
        }
    } else {
        const newItem = {
            id: addon.id,
            name: addon.name,
            detail: addon.detail || addon.description || null,
            description: addon.description || addon.detail || null,
            price: Number(addon.price || 0),
            quantity: newQty,
            unit: addon.unit || 'pcs',
            totalPrice: Number(addon.price || 0) * newQty,
            total_price: Number(addon.price || 0) * newQty,
            image: addon.image || null,
            icon: addon.icon || null,
        };

        if (existingIndex !== -1) {
            selectedAddonsCustom[existingIndex] = newItem;
        } else {
            selectedAddonsCustom.push(newItem);
        }
    }

    renderAddonsCustom();
    updateAllTotals();
};
function normalizeAddonQuantity(addon, qty) {
    let value = Number(qty || 0);

    if (value < 0) {
        value = 0;
    }

    const maxQty = addon.maxQuantity || addon.stock || null;

    if (maxQty && value > Number(maxQty)) {
        value = Number(maxQty);
        showCustomNotification(`Jumlah ${addon.name} maksimal ${maxQty} ${addon.unit || 'pcs'}.`, 'warning');
    }

    return value;
}

function getAddon(addonId) {
    return addonsData.find(addon => getKey(addon.id) === getKey(addonId));
}

function getSelectedAddons() {
    return selectedAddonsCustom.map(addon => ({
        id: addon.id,
        name: addon.name,
        detail: addon.detail || addon.description || null,
        unit: addon.unit || 'pcs',
        quantity: Number(addon.quantity || 1),
        price: Number(addon.price || 0),
        totalPrice: Number(addon.totalPrice || addon.total_price || 0),
        total_price: Number(addon.totalPrice || addon.total_price || 0),
    }));
}

// ==================== SUMMARY ====================

function updateAllTotals() {
    const selectedCustomItems = getSelectedCustomItems();
    const selectedAddons = getSelectedAddons();

    const subtotalCustom = selectedCustomItems.reduce((sum, item) => {
        return sum + Number(item.totalPrice || item.total_price || 0);
    }, 0);

    const totalAddons = selectedAddons.reduce((sum, addon) => {
        return sum + Number(addon.totalPrice || addon.total_price || 0);
    }, 0);

    const shippingFee = Number(selectedLocation.shippingFee || 0);
    const grandTotal = subtotalCustom + totalAddons + shippingFee;

    renderSummaryItems(selectedCustomItems);
    renderAddonsSummary(selectedAddons);
    renderShippingSummary();

    const subtotalItemEl = document.getElementById('subtotalItem');
    const totalCustomEl = document.getElementById('totalCustom');

    if (subtotalItemEl) {
        subtotalItemEl.textContent = formatRupiah(subtotalCustom);
    }

    if (totalCustomEl) {
        totalCustomEl.textContent = formatRupiah(grandTotal);
    }
}

function renderSummaryItems(selectedCustomItems) {
    const container = document.getElementById('summaryItems');

    if (!container) return;

    if (!selectedCustomItems.length) {
        container.innerHTML = `<p class="text-muted small">Belum ada item dipilih</p>`;
        return;
    }

    let html = '';

    selectedCustomItems.forEach(item => {
        html += `
            <div class="summary-item">
                <div>
                    <strong>${escapeHtml(item.name)}</strong>
                    <small>
                        ${escapeHtml(item.quantity)} ${escapeHtml(item.unit)}
                        x ${formatRupiah(item.price)}
                    </small>
                </div>

                <span>${formatRupiah(item.totalPrice || item.total_price)}</span>
            </div>
        `;
    });

    container.innerHTML = html;
}

function renderAddonsSummary(selectedAddons) {
    const container = document.getElementById('addonsSummaryCustom');

    if (!container) return;

    if (!selectedAddons.length) {
        container.innerHTML = '';
        return;
    }

    let html = `
        <hr>
        <h6 class="mb-2">
            <i class="bi bi-plus-circle"></i> Add-ons
        </h6>
    `;

    selectedAddons.forEach(addon => {
        html += `
            <div class="summary-row small">
                <span>
                    ${escapeHtml(addon.name)}
                    (${escapeHtml(addon.quantity)} ${escapeHtml(addon.unit || 'pcs')})
                </span>

                <span>${formatRupiah(addon.totalPrice || addon.total_price)}</span>
            </div>
        `;
    });

    container.innerHTML = html;
}

function renderShippingSummary() {
    const container = document.getElementById('shippingSummaryCustom');

    if (!container) return;

    const distance = Number(selectedLocation.distanceKm || 0);
    const fee = Number(selectedLocation.shippingFee || 0);

    if (!distance) {
        container.innerHTML = '';
        return;
    }

    container.innerHTML = `
        <div class="summary-row">
            <span>Biaya Pengiriman (${distance.toFixed(1)} km)</span>
            <span>${fee === 0 ? 'GRATIS' : formatRupiah(fee)}</span>
        </div>
    `;
}

// ==================== MAP & ONGKIR ====================

function openLocationMapModal() {
    const modalElement = document.getElementById('locationMapModal');

    if (!modalElement) return;

    const modal = new bootstrap.Modal(modalElement);
    modal.show();

    modalElement.addEventListener('shown.bs.modal', function () {
        initMap();

        setTimeout(function () {
            if (eventMap) {
                eventMap.invalidateSize();
            }
        }, 250);

        const mapSearchInput = document.getElementById('mapSearchInput');
        const locationName = getInputValue('eventLocation');
        const fullAddress = getInputValue('eventFullAddress');

        if (mapSearchInput && !mapSearchInput.value) {
            mapSearchInput.value = [locationName, fullAddress].filter(Boolean).join(', ');
        }
    }, { once: true });
}

function initMap() {
    if (typeof L === 'undefined') {
        showCustomNotification('Leaflet Map belum terbaca. Periksa koneksi CDN Leaflet.', 'error');
        return;
    }

    if (eventMap) return;

    const config = getShippingConfig();

    eventMap = L.map('eventMap').setView([config.baseLat, config.baseLng], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap contributors',
    }).addTo(eventMap);

    baseMarker = L.marker([config.baseLat, config.baseLng])
        .addTo(eventMap)
        .bindPopup(config.baseName || 'Didin Tenda Decoration');

    eventMap.on('click', async function (event) {
        await setSelectedPoint(event.latlng.lat, event.latlng.lng, true);
    });
}

async function searchLocationOnMap() {
    const input = document.getElementById('mapSearchInput');
    const resultsContainer = document.getElementById('mapSearchResults');

    if (!input || !resultsContainer) return;

    const keyword = input.value.trim();

    if (!keyword) {
        showCustomNotification('Masukkan kata kunci lokasi terlebih dahulu.', 'warning');
        return;
    }

    resultsContainer.style.display = 'block';
    resultsContainer.innerHTML = `
        <div class="list-group-item small text-muted">
            <i class="bi bi-hourglass-split"></i> Mencari lokasi...
        </div>
    `;

    try {
        const url = `https://nominatim.openstreetmap.org/search?format=json&limit=6&countrycodes=id&q=${encodeURIComponent(keyword)}`;
        const response = await fetch(url, {
            headers: {
                'Accept': 'application/json',
            },
        });

        const data = await response.json();

        if (!Array.isArray(data) || data.length === 0) {
            resultsContainer.innerHTML = `
                <div class="list-group-item small text-danger">
                    Lokasi tidak ditemukan. Coba masukkan alamat yang lebih lengkap.
                </div>
            `;
            return;
        }

        window.__didinMapSearchResults = data;

        resultsContainer.innerHTML = data.map((item, index) => {
            const title = item.display_name ? item.display_name.split(',')[0] : 'Lokasi';

            return `
                <button
                    type="button"
                    class="list-group-item list-group-item-action"
                    onclick="selectSearchResult(${index})"
                >
                    <strong>${escapeHtml(title)}</strong><br>
                    <small>${escapeHtml(item.display_name || '')}</small>
                </button>
            `;
        }).join('');
    } catch (error) {
        console.error(error);

        resultsContainer.innerHTML = `
            <div class="list-group-item small text-danger">
                Gagal mencari lokasi. Periksa koneksi internet Anda.
            </div>
        `;
    }
}

window.selectSearchResult = async function (index) {
    const results = window.__didinMapSearchResults || [];
    const selected = results[index];

    if (!selected) return;

    const lat = Number(selected.lat);
    const lng = Number(selected.lon);
    const address = selected.display_name || null;

    await setSelectedPoint(lat, lng, false, address);

    const resultsContainer = document.getElementById('mapSearchResults');

    if (resultsContainer) {
        resultsContainer.style.display = 'none';
        resultsContainer.innerHTML = '';
    }
};

async function setSelectedPoint(lat, lng, shouldReverseGeocode = true, knownAddress = null) {
    if (!eventMap) return;

    selectedLocation.lat = Number(lat);
    selectedLocation.lng = Number(lng);

    if (eventMarker) {
        eventMarker.setLatLng([selectedLocation.lat, selectedLocation.lng]);
    } else {
        eventMarker = L.marker([selectedLocation.lat, selectedLocation.lng], {
            draggable: true,
        }).addTo(eventMap);

        eventMarker.on('dragend', async function () {
            const position = eventMarker.getLatLng();
            await setSelectedPoint(position.lat, position.lng, true);
        });
    }

    eventMarker.bindPopup('Titik lokasi acara').openPopup();
    eventMap.setView([selectedLocation.lat, selectedLocation.lng], 15);

    let address = knownAddress;

    if (!address && shouldReverseGeocode) {
        address = await reverseGeocode(selectedLocation.lat, selectedLocation.lng);
    }

    if (address) {
        selectedLocation.address = address;
        setInputValue('eventFullAddress', address);

        const firstName = address.split(',')[0]?.trim();

        if (firstName && !getInputValue('eventLocation')) {
            setInputValue('eventLocation', firstName);
        }
    }

    setInputValue('eventLatitude', selectedLocation.lat.toFixed(7));
    setInputValue('eventLongitude', selectedLocation.lng.toFixed(7));

    updateSelectedPointText();

    await calculateDistanceAndShipping(selectedLocation.lat, selectedLocation.lng);
}

async function calculateDistanceAndShipping(lat, lng) {
    const config = getShippingConfig();

    let distanceKm = 0;
    let routeFound = false;

    try {
        const url = `https://router.project-osrm.org/route/v1/driving/${config.baseLng},${config.baseLat};${lng},${lat}?overview=full&geometries=geojson`;
        const response = await fetch(url, {
            headers: {
                'Accept': 'application/json',
            },
        });

        const data = await response.json();

        if (data && data.routes && data.routes[0]) {
            distanceKm = Number(data.routes[0].distance || 0) / 1000;
            routeFound = true;

            drawRouteLine(data.routes[0].geometry);
        }
    } catch (error) {
        console.warn('OSRM gagal, fallback ke haversine.', error);
    }

    if (!distanceKm) {
        distanceKm = haversineDistance(config.baseLat, config.baseLng, lat, lng) * 1.35;
        routeFound = false;
        drawFallbackLine(config.baseLat, config.baseLng, lat, lng);
    }

    selectedLocation.distanceKm = Number(distanceKm.toFixed(2));
    selectedLocation.shippingFee = calculateShippingFee(selectedLocation.distanceKm);
    selectedLocation.routeFound = routeFound;

    showShippingInfo();
    updateAllTotals();
}

function drawRouteLine(geometry) {
    if (!eventMap || !geometry || !geometry.coordinates) return;

    if (routeLine) {
        eventMap.removeLayer(routeLine);
    }

    const latLngs = geometry.coordinates.map(coord => [coord[1], coord[0]]);

    routeLine = L.polyline(latLngs, {
        weight: 4,
        opacity: 0.85,
    }).addTo(eventMap);

    eventMap.fitBounds(routeLine.getBounds(), {
        padding: [35, 35],
    });
}

function drawFallbackLine(baseLat, baseLng, lat, lng) {
    if (!eventMap) return;

    if (routeLine) {
        eventMap.removeLayer(routeLine);
    }

    routeLine = L.polyline([
        [baseLat, baseLng],
        [lat, lng],
    ], {
        weight: 3,
        opacity: 0.65,
        dashArray: '8, 8',
    }).addTo(eventMap);

    eventMap.fitBounds(routeLine.getBounds(), {
        padding: [35, 35],
    });
}

async function reverseGeocode(lat, lng) {
    try {
        const url = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`;
        const response = await fetch(url, {
            headers: {
                'Accept': 'application/json',
            },
        });

        const data = await response.json();

        return data.display_name || null;
    } catch (error) {
        console.warn(error);
        return null;
    }
}

function useSelectedPoint() {
    if (!selectedLocation.lat || !selectedLocation.lng) {
        showCustomNotification('Silakan pilih titik lokasi di map terlebih dahulu.', 'warning');
        return;
    }

    const modalElement = document.getElementById('locationMapModal');
    const modal = bootstrap.Modal.getInstance(modalElement);

    if (modal) {
        modal.hide();
    }

    showCustomNotification('Titik lokasi dan ongkir berhasil dihitung.', 'success');
}

function useMyCurrentLocation() {
    if (!navigator.geolocation) {
        showCustomNotification('Browser Anda tidak mendukung fitur lokasi.', 'warning');
        return;
    }

    showCustomNotification('Mengambil lokasi Anda...', 'info');

    navigator.geolocation.getCurrentPosition(
        async function (position) {
            await setSelectedPoint(position.coords.latitude, position.coords.longitude, true);
        },
        function () {
            showCustomNotification('Gagal mengambil lokasi. Izinkan akses lokasi pada browser.', 'error');
        },
        {
            enableHighAccuracy: true,
            timeout: 10000,
            maximumAge: 0,
        }
    );
}

function updateSelectedPointText() {
    const element = document.getElementById('selectedPointText');

    if (!element) return;

    if (!selectedLocation.lat || !selectedLocation.lng) {
        element.textContent = 'Titik belum dipilih.';
        return;
    }

    element.textContent = `Titik dipilih: ${selectedLocation.lat.toFixed(6)}, ${selectedLocation.lng.toFixed(6)}`;
}

function showShippingInfo() {
    const shippingInfo = document.getElementById('shippingInfo');
    const distanceValue = document.getElementById('distanceValue');
    const shippingFeeValue = document.getElementById('shippingFeeValue');
    const shippingNote = document.getElementById('shippingNote');

    const distance = Number(selectedLocation.distanceKm || 0);
    const fee = Number(selectedLocation.shippingFee || 0);
    const config = getShippingConfig();

    if (shippingInfo) {
        shippingInfo.style.display = 'block';
    }

    if (distanceValue) {
        distanceValue.textContent = distance.toFixed(1);
    }

    if (shippingFeeValue) {
        shippingFeeValue.textContent = fee === 0 ? 'GRATIS' : formatRupiah(fee);
    }

    if (shippingNote) {
        if (fee === 0) {
            shippingNote.innerHTML = `
                <i class="bi bi-info-circle"></i>
                Gratis ongkir untuk jarak hingga ${config.freeKm} km.
            `;
        } else {
            const chargeableKm = Math.max(0, distance - config.freeKm);

            shippingNote.innerHTML = `
                <i class="bi bi-info-circle"></i>
                Jarak ${distance.toFixed(1)} km.
                Biaya setelah ${config.freeKm} km pertama:
                ${chargeableKm.toFixed(1)} km x ${formatRupiah(config.ratePerKm)}.
                ${
                    selectedLocation.routeFound
                        ? ''
                        : '<br><small>Catatan: rute memakai estimasi fallback karena OSRM gagal.</small>'
                }
            `;
        }
    }
}

function resetShippingOnly() {
    selectedLocation.lat = null;
    selectedLocation.lng = null;
    selectedLocation.address = null;
    selectedLocation.distanceKm = 0;
    selectedLocation.shippingFee = 0;
    selectedLocation.routeFound = false;

    setInputValue('eventLatitude', '');
    setInputValue('eventLongitude', '');

    const shippingInfo = document.getElementById('shippingInfo');

    if (shippingInfo) {
        shippingInfo.style.display = 'none';
    }

    updateAllTotals();
}

function calculateShippingFee(distanceKm) {
    const config = getShippingConfig();
    const distance = Number(distanceKm || 0);

    if (distance <= config.freeKm) {
        return 0;
    }

    const chargeableDistance = distance - config.freeKm;
    const rawFee = chargeableDistance * config.ratePerKm;
    const roundTo = Number(config.roundTo || 1000);

    return Math.ceil(rawFee / roundTo) * roundTo;
}

function getShippingConfig() {
    return {
        baseLat: Number(window.DIDIN_SHIPPING_CONFIG?.baseLat || -6.269378),
        baseLng: Number(window.DIDIN_SHIPPING_CONFIG?.baseLng || 106.476574),
        baseName: window.DIDIN_SHIPPING_CONFIG?.baseName || 'Didin Tenda Decoration',
        freeKm: Number(window.DIDIN_SHIPPING_CONFIG?.freeKm || 10),
        ratePerKm: Number(window.DIDIN_SHIPPING_CONFIG?.ratePerKm || 5000),
        roundTo: Number(window.DIDIN_SHIPPING_CONFIG?.roundTo || 5000),
    };
}

function haversineDistance(lat1, lng1, lat2, lng2) {
    const earthRadiusKm = 6371;

    const dLat = toRad(lat2 - lat1);
    const dLng = toRad(lng2 - lng1);

    const a =
        Math.sin(dLat / 2) * Math.sin(dLat / 2) +
        Math.cos(toRad(lat1)) *
        Math.cos(toRad(lat2)) *
        Math.sin(dLng / 2) *
        Math.sin(dLng / 2);

    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

    return earthRadiusKm * c;
}

function toRad(value) {
    return value * Math.PI / 180;
}

// ==================== SUBMIT TO LARAVEL ====================

async function submitCustomOrder(checkoutNow = false, buttonElement = null) {
    const validation = validateCustomForm();

    if (!validation.valid) {
        showCustomNotification(validation.message, 'warning');
        return;
    }

    const payload = buildCustomPayload(checkoutNow);

    setButtonLoading(
        buttonElement,
        true,
        checkoutNow
            ? '<i class="bi bi-hourglass-split"></i> Memproses Booking...'
            : '<i class="bi bi-hourglass-split"></i> Menambahkan...'
    );

    try {
        const response = await fetch(window.DIDIN_CUSTOM_ROUTES?.addToCart || '/paket-custom/add-to-cart', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': getCsrfToken(),
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(payload),
        });

        const data = await safeReadJson(response);

        if (!response.ok || !data.status) {
            if (response.status === 401) {
                showCustomNotification(data.message || 'Silakan login terlebih dahulu.', 'warning');

                setTimeout(function () {
                    window.location.href = data.redirect_url || window.DIDIN_CUSTOM_ROUTES?.login || '/';
                }, 1000);

                return;
            }

            showCustomNotification(data.message || 'Gagal memproses paket custom.', 'error');
            return;
        }

        showCustomNotification(data.message || 'Paket custom berhasil diproses.', 'success');

        if (data.cart_count !== undefined) {
            updateCartBadge(data.cart_count);
        }

        setTimeout(function () {
            window.location.href = data.redirect_url || (
                checkoutNow
                    ? window.DIDIN_CUSTOM_ROUTES?.pesanan
                    : window.DIDIN_CUSTOM_ROUTES?.cart
            ) || '/cart';
        }, 900);
    } catch (error) {
        console.error(error);
        showCustomNotification('Terjadi kesalahan saat mengirim data paket custom.', 'error');
    } finally {
        setButtonLoading(buttonElement, false);
    }
}

function validateCustomForm() {
    const selectedCustom = getSelectedCustomItems();

    if (!getInputValue('customerName')) {
        return {
            valid: false,
            message: 'Nama lengkap wajib diisi.',
        };
    }

    if (!getInputValue('customerPhone')) {
        return {
            valid: false,
            message: 'Nomor WhatsApp wajib diisi.',
        };
    }

    if (!getInputValue('eventDate')) {
        return {
            valid: false,
            message: 'Tanggal acara wajib dipilih.',
        };
    }

    if (!getInputValue('eventLocation')) {
        return {
            valid: false,
            message: 'Nama lokasi acara wajib diisi.',
        };
    }

    if (!getInputValue('eventFullAddress')) {
        return {
            valid: false,
            message: 'Alamat lengkap acara wajib diisi.',
        };
    }

    if (!selectedCustom.length) {
        return {
            valid: false,
            message: 'Pilih minimal satu item dekorasi custom.',
        };
    }

    if (!selectedLocation.lat || !selectedLocation.lng || !selectedLocation.distanceKm) {
        return {
            valid: false,
            message: 'Silakan pilih titik lokasi dan cek ongkir terlebih dahulu.',
        };
    }

    return {
        valid: true,
        message: 'Valid',
    };
}

function buildCustomPayload(checkoutNow = false) {
    return {
        customer_name: getInputValue('customerName'),
        customer_phone: getInputValue('customerPhone'),
        customer_email: '',

        event_date: getInputValue('eventDate'),
        event_location_name: getInputValue('eventLocation'),
        event_address: getInputValue('eventFullAddress'),

        event_latitude: getInputValue('eventLatitude') || selectedLocation.lat,
        event_longitude: getInputValue('eventLongitude') || selectedLocation.lng,

        distance_km: selectedLocation.distanceKm,
        shipping_fee: selectedLocation.shippingFee,

        custom_items: getSelectedCustomItems().map(item => ({
            id: item.id,
            quantity: item.quantity,
        })),

        addons: getSelectedAddons().map(addon => ({
            id: addon.id,
            quantity: addon.quantity,
        })),

        checkout_now: checkoutNow ? 1 : 0,
    };
}

// ==================== HELPERS ====================

function updateCartBadge(value = null) {
    const badge = document.getElementById('cartCount');

    if (!badge) return;

    if (value !== null) {
        badge.textContent = value;
    }
}

function getInputValue(id) {
    const element = document.getElementById(id);

    return element ? element.value.trim() : '';
}

function setInputValue(id, value) {
    const element = document.getElementById(id);

    if (element) {
        element.value = value || '';
    }
}

function getCsrfToken() {
    return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
}

function formatRupiah(number) {
    return 'Rp ' + new Intl.NumberFormat('id-ID').format(Number(number || 0));
}

function shortLabel(text) {
    if (!text) return 'Add';

    const words = String(text).split(' ').filter(Boolean);

    if (words.length === 1) {
        return words[0].substring(0, 4);
    }

    return words
        .slice(0, 2)
        .map(word => word[0])
        .join('')
        .toUpperCase();
}

function getKey(value) {
    return String(value);
}

function jsValue(value) {
    return JSON.stringify(value);
}

function showCustomNotification(message, type = 'info') {
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
            message: 'Response server tidak valid. Kemungkinan Anda belum login atau route belum sesuai.',
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