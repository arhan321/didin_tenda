/**
 * PAKET.JS
 * Khusus halaman detail paket.
 *
 * Data paket dan add-ons berasal dari Blade/Laravel.
 * Tidak memakai paketDatabase.
 * Tidak memakai localStorage.
 *
 * Integrasi lokasi:
 * - User pilih titik lokasi di Leaflet map
 * - Bisa search lokasi dengan keyword
 * - Ambil latitude & longitude
 * - Reverse geocode titik map menjadi alamat otomatis
 * - Hitung jarak jalan pakai OSRM
 */

// ==================== GLOBAL STATE ====================
let locationPickerMap = null;
let locationPickerMarker = null;
let depotMarker = null;
let routePolyline = null;
let selectedEventLatLng = null;
let selectedEventAddressText = null;

// ==================== INIT ====================
document.addEventListener('DOMContentLoaded', function () {
    initPackageGallery();
    initAddonControls();
    initLocationPicker();
    initShippingCalculator();
    initBookingValidation();
    restoreSelectedLocationFromOldInput();
    updatePackageTotal();
});

// ==================== PACKAGE GALLERY ====================
function initPackageGallery() {
    const mainImage = document.getElementById('mainImage');
    const thumbs = document.querySelectorAll('.paket-thumb');

    if (!mainImage || thumbs.length === 0) return;

    thumbs.forEach(thumb => {
        thumb.addEventListener('click', function () {
            mainImage.src = this.dataset.image || this.src;

            thumbs.forEach(item => item.classList.remove('active'));
            this.classList.add('active');
        });
    });

    thumbs[0].classList.add('active');
}

// ==================== ADD-ONS ====================
function initAddonControls() {
    const addonCards = document.querySelectorAll('[data-addon-card]');

    addonCards.forEach(card => {
        const minusBtn = card.querySelector('[data-addon-minus]');
        const plusBtn = card.querySelector('[data-addon-plus]');

        if (minusBtn) {
            minusBtn.addEventListener('click', function () {
                changeAddonQuantity(card, -1);
            });
        }

        if (plusBtn) {
            plusBtn.addEventListener('click', function () {
                changeAddonQuantity(card, 1);
            });
        }

        updateAddonCard(card);
    });
}

function changeAddonQuantity(card, delta) {
    const input = card.querySelector('[data-addon-input]');
    if (!input) return;

    let qty = parseInt(input.value || '0', 10);
    const max = input.dataset.max ? parseInt(input.dataset.max, 10) : null;

    qty += delta;

    if (qty < 0) qty = 0;

    if (max !== null && !Number.isNaN(max) && qty > max) {
        qty = max;
        notifyPaket('Jumlah melebihi stok yang tersedia.', 'warning');
    }

    input.value = qty;

    updateAddonCard(card);
    updatePackageTotal();
}

function updateAddonCard(card) {
    const input = card.querySelector('[data-addon-input]');
    const qtyValue = card.querySelector('.qty-value');
    const qtyTotal = card.querySelector('.qty-total');

    if (!input) return;

    const qty = parseInt(input.value || '0', 10);
    const price = parseInt(input.dataset.price || '0', 10);
    const total = qty * price;

    if (qtyValue) {
        qtyValue.textContent = qty;
    }

    if (qtyTotal) {
        qtyTotal.textContent = qty > 0 ? formatRupiahPaket(total) : '';
    }

    card.classList.toggle('selected', qty > 0);
}

// ==================== TOTAL PRICE ====================
function updatePackageTotal() {
    const packagePrice = Number(window.didinPackagePrice || 0);
    const addonInputs = document.querySelectorAll('[data-addon-input]');
    const shippingFee = Number(document.getElementById('shippingFeeInput')?.value || 0);
    const distance = Number(document.getElementById('distanceKmInput')?.value || 0);

    let addonsTotal = 0;

    addonInputs.forEach(input => {
        const qty = parseInt(input.value || '0', 10);
        const price = parseInt(input.dataset.price || '0', 10);

        addonsTotal += qty * price;
    });

    setTextPaket('summaryAddons', formatRupiahPaket(addonsTotal));

    if (distance > 0 && shippingFee === 0) {
        setTextPaket('summaryShipping', 'GRATIS');
    } else {
        setTextPaket('summaryShipping', formatRupiahPaket(shippingFee));
    }

    setTextPaket('summaryTotal', formatRupiahPaket(packagePrice + addonsTotal + shippingFee));

    const shippingSummaryRow = document.getElementById('shippingSummaryRow');

    if (shippingSummaryRow) {
        shippingSummaryRow.style.display = distance > 0 ? 'flex' : 'none';
    }
}

// ==================== LOCATION PICKER MAP ====================
function initLocationPicker() {
    const openBtn = document.getElementById('openLocationPickerBtn');
    const useBtn = document.getElementById('useSelectedLocationBtn');
    const locateBtn = document.getElementById('locateMeBtn');

    if (openBtn) {
        openBtn.addEventListener('click', function () {
            openLocationPickerModal();
        });
    }

    if (useBtn) {
        useBtn.addEventListener('click', function () {
            useSelectedLocationPaket();
        });
    }

    if (locateBtn) {
        locateBtn.addEventListener('click', function () {
            locateUserPositionPaket();
        });
    }

    initLocationSearchPaket();
}

function initLocationSearchPaket() {
    const searchInput = document.getElementById('locationSearchInput');
    const searchBtn = document.getElementById('locationSearchBtn');

    if (!searchInput || !searchBtn) return;

    searchBtn.addEventListener('click', function () {
        performLocationSearchPaket();
    });

    searchInput.addEventListener('keydown', function (event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            performLocationSearchPaket();
        }
    });
}

async function performLocationSearchPaket() {
    const searchInput = document.getElementById('locationSearchInput');
    const searchBtn = document.getElementById('locationSearchBtn');
    const resultsContainer = document.getElementById('locationSearchResults');

    if (!searchInput || !resultsContainer) return;

    const keyword = searchInput.value.trim();

    if (!keyword) {
        notifyPaket('Masukkan nama lokasi yang ingin dicari.', 'warning');
        searchInput.focus();
        return;
    }

    const originalText = searchBtn ? searchBtn.innerHTML : '';

    if (searchBtn) {
        searchBtn.disabled = true;
        searchBtn.innerHTML = '<i class="bi bi-hourglass-split"></i>';
    }

    resultsContainer.style.display = 'block';
    resultsContainer.innerHTML = `
        <div class="list-group-item text-muted small">
            <i class="bi bi-hourglass-split"></i> Mencari lokasi...
        </div>
    `;

    try {
        const results = await searchLocationByKeywordPaket(keyword);

        if (!results || results.length === 0) {
            resultsContainer.innerHTML = `
                <div class="list-group-item text-muted small">
                    Lokasi tidak ditemukan. Coba gunakan kata kunci lain yang lebih umum.
                </div>
            `;
            return;
        }

        renderLocationSearchResultsPaket(results);
    } catch (error) {
        console.error('Gagal mencari lokasi:', error);

        resultsContainer.innerHTML = `
            <div class="list-group-item text-danger small">
                Gagal mencari lokasi. Coba ulangi beberapa saat lagi.
            </div>
        `;
    } finally {
        if (searchBtn) {
            searchBtn.disabled = false;
            searchBtn.innerHTML = originalText || 'Cari';
        }
    }
}

async function searchLocationByKeywordPaket(keyword) {
    const normalizedKeyword = keyword.toLowerCase().includes('indonesia')
        ? keyword
        : `${keyword}, Indonesia`;

    const url =
        'https://nominatim.openstreetmap.org/search' +
        '?format=jsonv2' +
        '&addressdetails=1' +
        '&limit=6' +
        '&countrycodes=id' +
        '&accept-language=id' +
        `&q=${encodeURIComponent(normalizedKeyword)}`;

    const response = await fetch(url, {
        method: 'GET',
        headers: {
            'Accept': 'application/json'
        }
    });

    if (!response.ok) {
        throw new Error('Search lokasi gagal');
    }

    const data = await response.json();

    if (!Array.isArray(data)) {
        return [];
    }

    return data.map(item => {
        return {
            lat: parseFloat(item.lat),
            lng: parseFloat(item.lon),
            displayName: item.display_name,
            type: item.type,
            category: item.category,
            importance: item.importance || 0,
        };
    });
}

function renderLocationSearchResultsPaket(results) {
    const resultsContainer = document.getElementById('locationSearchResults');

    if (!resultsContainer) return;

    let html = '';

    results.forEach((item, index) => {
        html += `
            <button
                type="button"
                class="list-group-item list-group-item-action location-search-result"
                data-index="${index}"
            >
                <div class="d-flex align-items-start gap-2">
                    <i class="bi bi-geo-alt-fill text-primary mt-1"></i>
                    <div>
                        <div class="fw-semibold">
                            ${escapeHtmlPaket(getShortLocationNamePaket(item.displayName))}
                        </div>
                        <small class="text-muted">
                            ${escapeHtmlPaket(item.displayName)}
                        </small>
                    </div>
                </div>
            </button>
        `;
    });

    resultsContainer.innerHTML = html;
    resultsContainer.style.display = 'block';

    const resultButtons = resultsContainer.querySelectorAll('.location-search-result');

    resultButtons.forEach(button => {
        button.addEventListener('click', function () {
            const index = parseInt(this.dataset.index || '0', 10);
            selectLocationSearchResultPaket(results[index]);
        });
    });
}

function selectLocationSearchResultPaket(item) {
    if (!item || !item.lat || !item.lng) {
        notifyPaket('Data lokasi tidak valid.', 'warning');
        return;
    }

    selectedEventAddressText = item.displayName;

    setSelectedLocationPaket(item.lat, item.lng, true);

    const resultsContainer = document.getElementById('locationSearchResults');
    const searchInput = document.getElementById('locationSearchInput');

    if (searchInput) {
        searchInput.value = getShortLocationNamePaket(item.displayName);
    }

    if (resultsContainer) {
        resultsContainer.style.display = 'none';
        resultsContainer.innerHTML = '';
    }

    notifyPaket('Lokasi ditemukan. Pin sudah diarahkan ke titik pilihan.', 'success');
}

function getShortLocationNamePaket(displayName) {
    if (!displayName) return 'Lokasi dipilih';

    const parts = String(displayName)
        .split(',')
        .map(item => item.trim())
        .filter(Boolean);

    return parts.slice(0, 3).join(', ');
}

function openLocationPickerModal() {
    const modalElement = document.getElementById('locationPickerModal');

    if (!modalElement) {
        notifyPaket('Modal map belum tersedia di halaman.', 'error');
        return;
    }

    if (typeof bootstrap === 'undefined') {
        notifyPaket('Bootstrap JS belum terbaca.', 'error');
        return;
    }

    const modal = bootstrap.Modal.getOrCreateInstance(modalElement);

    modalElement.addEventListener('shown.bs.modal', function () {
        buildLocationPickerMap();

        setTimeout(function () {
            if (locationPickerMap) {
                locationPickerMap.invalidateSize();
            }
        }, 250);
    }, { once: true });

    modal.show();
}

function buildLocationPickerMap() {
    if (typeof L === 'undefined') {
        notifyPaket('Leaflet map belum terbaca. Cek script Leaflet di paket.blade.php.', 'error');
        return;
    }

    const config = getRouteConfigPaket();

    if (locationPickerMap) {
        locationPickerMap.invalidateSize();

        if (selectedEventLatLng) {
            locationPickerMap.setView([selectedEventLatLng.lat, selectedEventLatLng.lng], 15);
        }

        return;
    }

    locationPickerMap = L.map('locationPickerMap').setView(
        [config.defaultCenter.lat, config.defaultCenter.lng],
        13
    );

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(locationPickerMap);

    depotMarker = L.marker([config.depot.lat, config.depot.lng], {
        draggable: false
    })
        .addTo(locationPickerMap)
        .bindPopup(config.depot.name || 'Lokasi Didin Tenda');

    locationPickerMap.on('click', function (event) {
        selectedEventAddressText = null;
        setSelectedLocationPaket(event.latlng.lat, event.latlng.lng, true);
    });

    const savedLat = Number(document.getElementById('eventLatitudeInput')?.value || 0);
    const savedLng = Number(document.getElementById('eventLongitudeInput')?.value || 0);

    if (savedLat && savedLng) {
        setSelectedLocationPaket(savedLat, savedLng, true);
        locationPickerMap.setView([savedLat, savedLng], 15);
    }
}

function setSelectedLocationPaket(lat, lng, moveMap = false) {
    selectedEventLatLng = {
        lat: Number(lat),
        lng: Number(lng)
    };

    if (!locationPickerMap) return;

    if (!locationPickerMarker) {
        locationPickerMarker = L.marker([selectedEventLatLng.lat, selectedEventLatLng.lng], {
            draggable: true
        }).addTo(locationPickerMap);

        locationPickerMarker.on('dragend', function () {
            const position = locationPickerMarker.getLatLng();

            selectedEventAddressText = null;

            setSelectedLocationPaket(position.lat, position.lng, false);
        });
    } else {
        locationPickerMarker.setLatLng([selectedEventLatLng.lat, selectedEventLatLng.lng]);
    }

    locationPickerMarker.bindPopup('Titik lokasi acara').openPopup();

    if (moveMap) {
        locationPickerMap.setView([selectedEventLatLng.lat, selectedEventLatLng.lng], 16);
    }

    updateMapCoordinateTextPaket(selectedEventLatLng.lat, selectedEventLatLng.lng);
}

function updateMapCoordinateTextPaket(lat, lng) {
    const text = document.getElementById('mapCoordinateText');

    if (text) {
        text.textContent = `Titik dipilih: ${Number(lat).toFixed(6)}, ${Number(lng).toFixed(6)}`;
    }
}

async function useSelectedLocationPaket() {
    if (!selectedEventLatLng) {
        notifyPaket('Silakan klik titik lokasi acara di map terlebih dahulu.', 'warning');
        return;
    }

    const latInput = document.getElementById('eventLatitudeInput');
    const lngInput = document.getElementById('eventLongitudeInput');
    const selectedText = document.getElementById('selectedLocationText');
    const addressInput = document.getElementById('eventFullAddress');

    if (latInput) {
        latInput.value = selectedEventLatLng.lat.toFixed(7);
    }

    if (lngInput) {
        lngInput.value = selectedEventLatLng.lng.toFixed(7);
    }

    if (selectedText) {
        selectedText.innerHTML = `
            <i class="bi bi-hourglass-split text-primary"></i>
            Titik lokasi dipilih. Mengambil alamat otomatis...
        `;
    }

    try {
        let address = selectedEventAddressText;

        if (!address) {
            address = await reverseGeocodePaket(
                selectedEventLatLng.lat,
                selectedEventLatLng.lng
            );
        }

        if (address && addressInput) {
            addressInput.value = address;
        }

        if (selectedText) {
            selectedText.innerHTML = `
                <i class="bi bi-check-circle text-success"></i>
                Titik lokasi sudah dipilih:
                ${selectedEventLatLng.lat.toFixed(6)}, ${selectedEventLatLng.lng.toFixed(6)}
            `;
        }

        notifyPaket('Titik lokasi dan alamat berhasil diambil.', 'success');
    } catch (error) {
        console.error('Gagal mengambil alamat:', error);

        if (selectedText) {
            selectedText.innerHTML = `
                <i class="bi bi-check-circle text-success"></i>
                Titik lokasi sudah dipilih:
                ${selectedEventLatLng.lat.toFixed(6)}, ${selectedEventLatLng.lng.toFixed(6)}
                <br>
                <span class="text-warning">
                    Alamat otomatis gagal diambil, silakan isi alamat manual.
                </span>
            `;
        }

        notifyPaket('Titik lokasi berhasil dipilih, tapi alamat otomatis gagal diambil.', 'warning');
    }

    resetShippingCalculation(false);

    const modalElement = document.getElementById('locationPickerModal');
    const modal = bootstrap.Modal.getInstance(modalElement);

    if (modal) {
        modal.hide();
    }
}

async function reverseGeocodePaket(lat, lng) {
    const url =
        'https://nominatim.openstreetmap.org/reverse' +
        '?format=jsonv2' +
        '&addressdetails=1' +
        '&accept-language=id' +
        '&zoom=18' +
        `&lat=${encodeURIComponent(lat)}` +
        `&lon=${encodeURIComponent(lng)}`;

    const response = await fetch(url, {
        method: 'GET',
        headers: {
            'Accept': 'application/json'
        }
    });

    if (!response.ok) {
        throw new Error('Reverse geocode gagal');
    }

    const data = await response.json();

    if (!data) {
        return null;
    }

    return buildReadableAddressPaket(data);
}

function buildReadableAddressPaket(data) {
    const address = data.address || {};

    const parts = [
        address.road,
        address.neighbourhood || address.suburb || address.hamlet || address.village,
        address.city_district || address.district || address.county,
        address.city || address.town || address.municipality,
        address.state,
        address.postcode,
        address.country,
    ];

    const cleaned = parts
        .filter(Boolean)
        .map(item => String(item).trim())
        .filter(item => item.length > 0);

    if (cleaned.length > 0) {
        return [...new Set(cleaned)].join(', ');
    }

    return data.display_name || null;
}

function locateUserPositionPaket() {
    if (!locationPickerMap) return;

    if (!navigator.geolocation) {
        notifyPaket('Browser tidak mendukung fitur lokasi.', 'warning');
        return;
    }

    notifyPaket('Mencari lokasi Anda...', 'info');

    navigator.geolocation.getCurrentPosition(
        function (position) {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;

            selectedEventAddressText = null;
            setSelectedLocationPaket(lat, lng, true);

            notifyPaket('Lokasi Anda berhasil ditemukan.', 'success');
        },
        function () {
            notifyPaket('Gagal mengambil lokasi. Pastikan izin lokasi browser aktif.', 'warning');
        },
        {
            enableHighAccuracy: true,
            timeout: 10000,
            maximumAge: 0
        }
    );
}

function restoreSelectedLocationFromOldInput() {
    const latInput = document.getElementById('eventLatitudeInput');
    const lngInput = document.getElementById('eventLongitudeInput');
    const selectedText = document.getElementById('selectedLocationText');

    const lat = Number(latInput?.value || 0);
    const lng = Number(lngInput?.value || 0);

    if (!lat || !lng) return;

    selectedEventLatLng = { lat, lng };

    if (selectedText) {
        selectedText.innerHTML = `
            <i class="bi bi-check-circle text-success"></i>
            Titik lokasi sudah dipilih:
            ${lat.toFixed(6)}, ${lng.toFixed(6)}
        `;
    }
}

// ==================== SHIPPING CALCULATOR ====================
function initShippingCalculator() {
    const button = document.getElementById('checkShippingBtn');
    const addressInput = document.getElementById('eventFullAddress');

    if (!button || !addressInput) return;

    button.addEventListener('click', async function () {
        const address = addressInput.value.trim();
        const latInput = document.getElementById('eventLatitudeInput');
        const lngInput = document.getElementById('eventLongitudeInput');

        const eventLat = Number(latInput?.value || 0);
        const eventLng = Number(lngInput?.value || 0);

        if (!address) {
            notifyPaket('Silakan isi alamat lengkap acara terlebih dahulu.', 'warning');
            addressInput.focus();
            return;
        }

        if (!eventLat || !eventLng) {
            notifyPaket('Silakan pilih titik lokasi acara di map dulu agar jarak akurat.', 'warning');
            openLocationPickerModal();
            return;
        }

        const originalText = button.innerHTML;

        button.disabled = true;
        button.innerHTML = '<i class="bi bi-hourglass-split"></i> Menghitung rute...';

        try {
            const config = getRouteConfigPaket();

            const routeResult = await getOsrmRoutePaket(
                config.depot.lat,
                config.depot.lng,
                eventLat,
                eventLng
            );

            let distance = routeResult ? routeResult.distanceKm : null;

            if (!distance || distance <= 0) {
                distance = calculateStraightDistancePaket(
                    config.depot.lat,
                    config.depot.lng,
                    eventLat,
                    eventLng
                ) * 1.25;
            }

            distance = Math.round(distance * 10) / 10;

            const shippingFee = calculateShippingFeePaket(distance);

            const distanceInput = document.getElementById('distanceKmInput');
            const shippingInput = document.getElementById('shippingFeeInput');

            if (distanceInput) {
                distanceInput.value = distance.toFixed(2);
            }

            if (shippingInput) {
                shippingInput.value = shippingFee;
            }

            setTextPaket('distanceValue', distance.toFixed(1));
            setTextPaket(
                'shippingFeeValue',
                shippingFee === 0 ? 'GRATIS' : formatRupiahPaket(shippingFee)
            );

            const shippingInfo = document.getElementById('shippingInfo');
            const note = document.getElementById('shippingNote');

            if (shippingInfo) {
                shippingInfo.style.display = 'block';
            }

            if (note) {
                if (shippingFee === 0) {
                    note.innerHTML = `
                        <i class="bi bi-check-circle"></i>
                        Jarak ${distance.toFixed(1)} km. Lokasi dalam radius 10 km, pengiriman GRATIS.
                    `;
                    note.className = 'shipping-note free';
                } else if (distance <= 30) {
                    const extraKm = Math.ceil(distance - 10);

                    note.innerHTML = `
                        <i class="bi bi-info-circle"></i>
                        Jarak ${distance.toFixed(1)} km.
                        Biaya setelah 10 km pertama:
                        ${extraKm} km x Rp 5.000 = ${formatRupiahPaket(shippingFee)}.
                    `;
                    note.className = 'shipping-note charge';
                } else {
                    const extraKm = Math.ceil(distance - 30);

                    note.innerHTML = `
                        <i class="bi bi-info-circle"></i>
                        Jarak ${distance.toFixed(1)} km.
                        Biaya pengiriman:
                        20 km pertama x Rp 5.000 + ${extraKm} km x Rp 10.000 =
                        ${formatRupiahPaket(shippingFee)}.
                    `;
                    note.className = 'shipping-note charge';
                }
            }

            if (routeResult && routeResult.geometry) {
                drawRouteOnMapPaket(routeResult.geometry);
            }

            updatePackageTotal();
            notifyPaket('Jarak dan ongkir berhasil dihitung.', 'success');
        } catch (error) {
            console.error('Gagal menghitung rute:', error);
            notifyPaket('Gagal menghitung rute. Coba ulangi atau pilih titik lokasi yang lebih dekat ke jalan.', 'error');
        } finally {
            button.disabled = false;
            button.innerHTML = originalText;
        }
    });

    addressInput.addEventListener('input', function () {
        resetShippingCalculation(false);
    });
}

async function getOsrmRoutePaket(originLat, originLng, destLat, destLng) {
    const config = getRouteConfigPaket();

    const url =
        `${config.osrmBaseUrl}/route/v1/driving/` +
        `${originLng},${originLat};${destLng},${destLat}` +
        `?overview=full&geometries=geojson`;

    const response = await fetch(url, {
        method: 'GET',
        headers: {
            'Accept': 'application/json'
        }
    });

    if (!response.ok) {
        return null;
    }

    const data = await response.json();

    if (!data.routes || !data.routes[0] || !data.routes[0].distance) {
        return null;
    }

    return {
        distanceKm: data.routes[0].distance / 1000,
        durationMin: data.routes[0].duration ? data.routes[0].duration / 60 : null,
        geometry: data.routes[0].geometry || null
    };
}

function drawRouteOnMapPaket(geometry) {
    if (!locationPickerMap || !geometry || !geometry.coordinates) {
        return;
    }

    const latLngs = geometry.coordinates.map(coord => {
        return [coord[1], coord[0]];
    });

    if (routePolyline) {
        locationPickerMap.removeLayer(routePolyline);
    }

    routePolyline = L.polyline(latLngs, {
        weight: 5,
        opacity: 0.8
    }).addTo(locationPickerMap);

    locationPickerMap.fitBounds(routePolyline.getBounds(), {
        padding: [30, 30]
    });
}

function calculateStraightDistancePaket(lat1, lon1, lat2, lon2) {
    const earthRadiusKm = 6371;

    const dLat = toRadiansPaket(lat2 - lat1);
    const dLon = toRadiansPaket(lon2 - lon1);

    const a =
        Math.sin(dLat / 2) * Math.sin(dLat / 2) +
        Math.cos(toRadiansPaket(lat1)) *
        Math.cos(toRadiansPaket(lat2)) *
        Math.sin(dLon / 2) *
        Math.sin(dLon / 2);

    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

    return earthRadiusKm * c;
}

function toRadiansPaket(degree) {
    return degree * Math.PI / 180;
}

function calculateShippingFeePaket(distanceKm) {
    const distance = Number(distanceKm || 0);

    if (distance <= 10) {
        return 0;
    }

    if (distance <= 30) {
        return Math.ceil(distance - 10) * 5000;
    }

    const first20KmFee = 20 * 5000;
    const extraKmFee = Math.ceil(distance - 30) * 10000;

    return first20KmFee + extraKmFee;
}

function resetShippingCalculation(resetCoordinate = false) {
    const distanceInput = document.getElementById('distanceKmInput');
    const shippingInput = document.getElementById('shippingFeeInput');

    if (distanceInput) {
        distanceInput.value = 0;
    }

    if (shippingInput) {
        shippingInput.value = 0;
    }

    if (resetCoordinate) {
        const latInput = document.getElementById('eventLatitudeInput');
        const lngInput = document.getElementById('eventLongitudeInput');

        if (latInput) latInput.value = '';
        if (lngInput) lngInput.value = '';

        selectedEventLatLng = null;
        selectedEventAddressText = null;
    }

    const shippingInfo = document.getElementById('shippingInfo');

    if (shippingInfo) {
        shippingInfo.style.display = 'none';
    }

    updatePackageTotal();
}

// ==================== FORM VALIDATION ====================
function initBookingValidation() {
    const form = document.getElementById('bookingForm');
    if (!form) return;

    form.addEventListener('submit', function (event) {
        const requiredFields = [
            ['eventDate', 'Tanggal acara wajib diisi.'],
            ['eventLocation', 'Nama lokasi acara wajib diisi.'],
            ['eventFullAddress', 'Alamat lengkap acara wajib diisi.'],
            ['customerName', 'Nama lengkap wajib diisi.'],
            ['customerPhone', 'Nomor WhatsApp wajib diisi.']
        ];

        for (const [id, message] of requiredFields) {
            const input = document.getElementById(id);

            if (!input || !input.value.trim()) {
                event.preventDefault();
                notifyPaket(message, 'warning');
                input?.focus();
                return;
            }
        }

        const latInput = document.getElementById('eventLatitudeInput');
        const lngInput = document.getElementById('eventLongitudeInput');

        if (!latInput?.value || !lngInput?.value) {
            event.preventDefault();
            notifyPaket('Silakan pilih titik lokasi acara di map terlebih dahulu.', 'warning');
            openLocationPickerModal();
            return;
        }
    });
}

// ==================== CONFIG ====================
function getRouteConfigPaket() {
    return window.didinRouteConfig || {
        depot: {
            lat: -6.262311,
            lng: 106.472969,
            name: 'Didin Tenda Decoration'
        },
        osrmBaseUrl: 'https://router.project-osrm.org',
        defaultCenter: {
            lat: -6.262311,
            lng: 106.472969
        }
    };
}

// ==================== HELPERS ====================
function setTextPaket(id, value) {
    const element = document.getElementById(id);

    if (element) {
        element.textContent = value;
    }
}

function formatRupiahPaket(number) {
    return 'Rp ' + new Intl.NumberFormat('id-ID').format(Number(number || 0));
}

function notifyPaket(message, type = 'info') {
    if (typeof showNotification === 'function') {
        showNotification(message, type);
        return;
    }

    alert(message);
}

function escapeHtmlPaket(value) {
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