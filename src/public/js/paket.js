/**
 * PAKET.JS
 * Khusus halaman detail paket.
 * Data paket dan add-ons berasal dari Blade/Laravel.
 * Tidak memakai paketDatabase dan tidak memakai localStorage.
 */

document.addEventListener('DOMContentLoaded', function () {
    initPackageGallery();
    initAddonControls();
    initShippingCalculator();
    initBookingValidation();
    updatePackageTotal();
});

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

function updatePackageTotal() {
    const packagePrice = Number(window.didinPackagePrice || 0);
    const addonInputs = document.querySelectorAll('[data-addon-input]');
    const shippingFee = Number(document.getElementById('shippingFeeInput')?.value || 0);

    let addonsTotal = 0;

    addonInputs.forEach(input => {
        const qty = parseInt(input.value || '0', 10);
        const price = parseInt(input.dataset.price || '0', 10);

        addonsTotal += qty * price;
    });

    setTextPaket('summaryAddons', formatRupiahPaket(addonsTotal));
    setTextPaket('summaryShipping', shippingFee === 0 ? 'GRATIS' : formatRupiahPaket(shippingFee));
    setTextPaket('summaryTotal', formatRupiahPaket(packagePrice + addonsTotal + shippingFee));

    const shippingSummaryRow = document.getElementById('shippingSummaryRow');
    const distance = Number(document.getElementById('distanceKmInput')?.value || 0);

    if (shippingSummaryRow) {
        shippingSummaryRow.style.display = distance > 0 || shippingFee > 0 ? 'flex' : 'none';
    }
}

function initShippingCalculator() {
    const button = document.getElementById('checkShippingBtn');
    const addressInput = document.getElementById('eventFullAddress');

    if (!button || !addressInput) return;

    button.addEventListener('click', function () {
        const address = addressInput.value.trim();

        if (!address) {
            notifyPaket('Silakan isi alamat lengkap acara terlebih dahulu.', 'warning');
            addressInput.focus();
            return;
        }

        const distance = getConsistentDistanceFromAddressPaket(address);
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
        setTextPaket('shippingFeeValue', shippingFee === 0 ? 'GRATIS' : formatRupiahPaket(shippingFee));

        const shippingInfo = document.getElementById('shippingInfo');
        const note = document.getElementById('shippingNote');

        if (shippingInfo) {
            shippingInfo.style.display = 'block';
        }

        if (note) {
            if (shippingFee === 0) {
                note.innerHTML = '<i class="bi bi-check-circle"></i> Lokasi dalam radius 10 km, pengiriman GRATIS.';
                note.className = 'shipping-note free';
            } else if (distance <= 30) {
                note.innerHTML = `<i class="bi bi-info-circle"></i> Jarak ${distance.toFixed(1)} km. Biaya setelah 10 km pertama: ${formatRupiahPaket(shippingFee)}.`;
                note.className = 'shipping-note charge';
            } else {
                note.innerHTML = `<i class="bi bi-info-circle"></i> Jarak ${distance.toFixed(1)} km. Biaya pengiriman: ${formatRupiahPaket(shippingFee)}.`;
                note.className = 'shipping-note charge';
            }
        }

        updatePackageTotal();
        notifyPaket('Jarak dan ongkir berhasil dihitung.', 'success');
    });

    addressInput.addEventListener('input', function () {
        const distanceInput = document.getElementById('distanceKmInput');
        const shippingInput = document.getElementById('shippingFeeInput');

        if (distanceInput) {
            distanceInput.value = 0;
        }

        if (shippingInput) {
            shippingInput.value = 0;
        }

        const shippingInfo = document.getElementById('shippingInfo');

        if (shippingInfo) {
            shippingInfo.style.display = 'none';
        }

        updatePackageTotal();
    });
}

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
    });
}

function getConsistentDistanceFromAddressPaket(address) {
    if (!address || address.trim() === '') return 0;

    let hash = 0;
    const normalized = address.toLowerCase();

    for (let i = 0; i < normalized.length; i++) {
        hash = ((hash << 5) - hash) + normalized.charCodeAt(i);
        hash = hash & hash;
    }

    const distance = (Math.abs(hash) % 50) + 1;

    if (normalized.includes('jakarta') || normalized.includes('tangerang')) {
        return Math.min(distance, 15);
    }

    if (
        normalized.includes('bogor') ||
        normalized.includes('bekasi') ||
        normalized.includes('depok')
    ) {
        return Math.min(distance, 30);
    }

    return distance;
}

function calculateShippingFeePaket(distanceKm) {
    const distance = Number(distanceKm || 0);

    if (distance <= 10) return 0;

    if (distance <= 30) {
        return Math.ceil(distance - 10) * 5000;
    }

    return (20 * 5000) + (Math.ceil(distance - 30) * 10000);
}

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