<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice {{ $order->invoice_number }}</title>
</head>
<body style="font-family: Arial, sans-serif; color: #222; line-height: 1.6;">
    <h2>Pembayaran Berhasil</h2>

    <p>Halo {{ $order->customer_name }},</p>

    <p>
        Terima kasih, pembayaran Anda untuk pesanan
        <strong>{{ $order->invoice_number }}</strong> telah kami terima.
    </p>

    <table cellpadding="6" cellspacing="0" border="0">
        <tr>
            <td><strong>No. Invoice</strong></td>
            <td>: {{ $order->invoice_number }}</td>
        </tr>
        <tr>
            <td><strong>Nama Pelanggan</strong></td>
            <td>: {{ $order->customer_name }}</td>
        </tr>
        <tr>
            <td><strong>Tanggal Acara</strong></td>
            <td>: {{ optional($order->event_date)->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <td><strong>Lokasi</strong></td>
            <td>: {{ $order->event_location_name ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Status Pembayaran</strong></td>
            <td>: Lunas</td>
        </tr>
        <tr>
            <td><strong>Total</strong></td>
            <td>: Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
        </tr>
    </table>

    <p>
        Invoice PDF kami lampirkan pada email ini.
    </p>

    <p>
        Terima kasih,<br>
        <strong>Didin Tenda Decoration</strong>
    </p>
</body>
</html>