<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice {{ $order->invoice_number }}</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #222;
            margin: 0;
            padding: 0;
            line-height: 1.5;
        }

        .invoice-wrapper {
            padding: 28px;
        }

        .header {
            width: 100%;
            border-bottom: 3px solid #2c7be5;
            padding-bottom: 16px;
            margin-bottom: 22px;
        }

        .brand {
            font-size: 22px;
            font-weight: bold;
            color: #2c7be5;
            margin-bottom: 4px;
        }

        .brand-sub {
            font-size: 12px;
            color: #555;
        }

        .invoice-title {
            text-align: right;
            font-size: 24px;
            font-weight: bold;
            color: #222;
        }

        .invoice-number {
            text-align: right;
            color: #666;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .header-table td {
            vertical-align: top;
        }

        .section {
            margin-bottom: 18px;
        }

        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #2c7be5;
            margin-bottom: 8px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 4px;
        }

        .info-table td {
            padding: 3px 0;
            vertical-align: top;
        }

        .info-label {
            width: 155px;
            color: #666;
        }

        .items-table {
            margin-top: 8px;
            border: 1px solid #ddd;
        }

        .items-table th {
            background: #2c7be5;
            color: white;
            padding: 8px;
            text-align: left;
            font-size: 11px;
        }

        .items-table td {
            padding: 8px;
            border-bottom: 1px solid #eee;
            vertical-align: top;
        }

        .text-right {
            text-align: right;
        }

        .summary-table {
            width: 45%;
            margin-left: auto;
            margin-top: 14px;
        }

        .summary-table td {
            padding: 6px 8px;
            border-bottom: 1px solid #eee;
        }

        .summary-total td {
            background: #2c7be5;
            color: white;
            font-weight: bold;
            font-size: 14px;
        }

        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: bold;
        }

        .badge-warning {
            background: #fff3cd;
            color: #856404;
        }

        .badge-success {
            background: #d4edda;
            color: #155724;
        }

        .badge-danger {
            background: #f8d7da;
            color: #721c24;
        }

        .badge-info {
            background: #d1ecf1;
            color: #0c5460;
        }

        .footer {
            margin-top: 30px;
            padding-top: 12px;
            border-top: 1px solid #ddd;
            font-size: 10px;
            color: #777;
            text-align: center;
        }

        .notes {
            background: #f8f9fa;
            border-left: 4px solid #2c7be5;
            padding: 10px;
            margin-top: 12px;
        }
    </style>
</head>
<body>
@php
    $statusLabel = match ($order->status) {
        'waiting_payment' => 'Menunggu Pembayaran',
        'confirmed' => 'Dikonfirmasi',
        'processing', 'processed' => 'Diproses',
        'ongoing' => 'Pelaksanaan',
        'completed' => 'Selesai',
        'cancelled' => 'Dibatalkan',
        default => ucfirst(str_replace('_', ' ', $order->status)),
    };

    $paymentLabel = match ($order->payment_status) {
        'unpaid' => 'Belum Dibayar',
        'pending' => 'Pending',
        'paid' => 'Lunas',
        'expired' => 'Expired',
        'failed' => 'Gagal',
        'cancelled' => 'Dibatalkan',
        'refunded' => 'Refund',
        default => ucfirst($order->payment_status),
    };

    $paymentBadge = match ($order->payment_status) {
        'paid' => 'badge-success',
        'failed', 'cancelled', 'expired' => 'badge-danger',
        'pending', 'unpaid' => 'badge-warning',
        default => 'badge-info',
    };
@endphp

<div class="invoice-wrapper">
    <div class="header">
        <table class="header-table">
            <tr>
                <td style="width: 55%;">
                    <div class="brand">PT. Didin Tenda Decoration</div>
                    <div class="brand-sub">
                        Jl. Ki Mas Laeng Kp. Katomas, Tigaraksa,<br>
                        Kab. Tangerang, Banten<br>
                        Telp/WA: 0882-8925-8764<br>
                        Email: info@didintenda.com
                    </div>
                </td>
                <td style="width: 45%;">
                    <div class="invoice-title">INVOICE</div>
                    <div class="invoice-number">{{ $order->invoice_number }}</div>
                    <div class="invoice-number">
                        Tanggal: {{ optional($order->created_at)->format('d/m/Y H:i') }}
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div class="section">
        <table>
            <tr>
                <td style="width: 50%; vertical-align: top; padding-right: 14px;">
                    <div class="section-title">Data Pelanggan</div>
                    <table class="info-table">
                        <tr>
                            <td class="info-label">Nama</td>
                            <td>: {{ $order->customer_name }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">No. WhatsApp</td>
                            <td>: {{ $order->customer_phone }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">Email</td>
                            <td>: {{ $order->customer_email ?? '-' }}</td>
                        </tr>
                    </table>
                </td>

                <td style="width: 50%; vertical-align: top;">
                    <div class="section-title">Status Pesanan</div>
                    <table class="info-table">
                        <tr>
                            <td class="info-label">Status Order</td>
                            <td>: {{ $statusLabel }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">Status Pembayaran</td>
                            <td>: <span class="badge {{ $paymentBadge }}">{{ $paymentLabel }}</span></td>
                        </tr>
                        <tr>
                            <td class="info-label">Deadline Bayar</td>
                            <td>: {{ $order->payment_deadline ? $order->payment_deadline->format('d/m/Y H:i') : '-' }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Detail Acara</div>
        <table class="info-table">
            <tr>
                <td class="info-label">Tanggal Acara</td>
                <td>: {{ optional($order->event_date)->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td class="info-label">Nama Lokasi</td>
                <td>: {{ $order->event_location_name ?? '-' }}</td>
            </tr>
            <tr>
                <td class="info-label">Alamat Acara</td>
                <td>: {{ $order->event_address ?? '-' }}</td>
            </tr>
            <tr>
                <td class="info-label">Jarak</td>
                <td>: {{ $order->distance_km ? number_format((float) $order->distance_km, 1, ',', '.') . ' km' : '-' }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Rincian Pesanan</div>

        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 42%;">Item</th>
                    <th style="width: 13%;">Qty</th>
                    <th style="width: 20%;" class="text-right">Harga</th>
                    <th style="width: 25%;" class="text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                    <tr>
                        <td>
                            <strong>{{ $item->name }}</strong><br>
                            <small>{{ ucfirst($item->item_type) }}</small>
                        </td>
                        <td>{{ $item->quantity }} {{ $item->unit }}</td>
                        <td class="text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        <td class="text-right">Rp {{ number_format($item->total_price, 0, ',', '.') }}</td>
                    </tr>
                @endforeach

                @foreach($order->addons as $addon)
                    <tr>
                        <td>
                            <strong>{{ $addon->name }}</strong><br>
                            <small>{{ $addon->detail ?? 'Add-on' }}</small>
                        </td>
                        <td>{{ $addon->quantity }} {{ $addon->unit ?? 'pcs' }}</td>
                        <td class="text-right">Rp {{ number_format($addon->price, 0, ',', '.') }}</td>
                        <td class="text-right">Rp {{ number_format($addon->total_price, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <table class="summary-table">
            <tr>
                <td>Subtotal Paket</td>
                <td class="text-right">Rp {{ number_format($order->subtotal_package, 0, ',', '.') }}</td>
            </tr>

            @if($order->subtotal_custom > 0)
                <tr>
                    <td>Subtotal Custom</td>
                    <td class="text-right">Rp {{ number_format($order->subtotal_custom, 0, ',', '.') }}</td>
                </tr>
            @endif

            <tr>
                <td>Subtotal Add-ons</td>
                <td class="text-right">Rp {{ number_format($order->subtotal_addons, 0, ',', '.') }}</td>
            </tr>

            <tr>
                <td>Biaya Pengiriman</td>
                <td class="text-right">
                    {{ $order->shipping_fee > 0 ? 'Rp ' . number_format($order->shipping_fee, 0, ',', '.') : 'GRATIS' }}
                </td>
            </tr>

            <tr class="summary-total">
                <td>Total</td>
                <td class="text-right">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>

    @if($order->notes)
        <div class="notes">
            <strong>Catatan:</strong><br>
            {{ $order->notes }}
        </div>
    @endif

    <div class="footer">
        Invoice ini dibuat otomatis oleh sistem Didin Tenda Decoration.<br>
        Terima kasih telah mempercayakan kebutuhan tenda dan dekorasi acara Anda kepada kami.
    </div>
</div>
</body>
</html>