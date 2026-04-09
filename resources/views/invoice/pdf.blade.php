<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice {{ $order->order_code ?? ('#' . $order->id) }}</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 24px;
            font-family: DejaVu Sans, sans-serif;
            color: #111827;
            font-size: 12px;
            line-height: 1.5;
            background: #ffffff;
        }

        .invoice {
            width: 100%;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            overflow: hidden;
        }

        .header {
            padding: 16px 18px;
            border-bottom: 1px solid #d1d5db;
        }

        .title {
            font-size: 22px;
            margin: 0 0 6px;
            font-weight: 700;
        }

        .meta {
            color: #4b5563;
        }

        .content {
            padding: 18px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 14px;
        }

        .info-table td {
            padding: 4px 0;
            vertical-align: top;
        }

        .label {
            width: 170px;
            color: #6b7280;
        }

        .items {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }

        .items th,
        .items td {
            border: 1px solid #e5e7eb;
            padding: 8px;
            text-align: left;
        }

        .items th {
            background: #f9fafb;
            color: #374151;
            font-weight: 700;
        }

        .text-right {
            text-align: right;
        }

        .summary {
            margin-top: 14px;
            width: 46%;
            margin-left: auto;
            border-collapse: collapse;
        }

        .summary td {
            border: 1px solid #e5e7eb;
            padding: 8px;
        }

        .summary .total td {
            font-weight: 700;
            background: #f9fafb;
        }
    </style>
</head>
<body>
    @php
        use App\Models\Order;
    @endphp

    <div class="invoice">
        <div class="header">
            <h1 class="title">INVOICE 3bieStore</h1>
            <div class="meta">ID Order: #{{ $order->id }} | Tanggal: {{ $order->created_at?->format('d M Y H:i') }}</div>
        </div>

        <div class="content">
            <table class="info-table">
                <tr>
                    <td class="label">Nama Pembeli</td>
                    <td>{{ $order->user?->name ?? $order->nama_penerima }}</td>
                </tr>
                <tr>
                    <td class="label">Nomor HP</td>
                    <td>{{ $order->phone }}</td>
                </tr>
                <tr>
                    <td class="label">Alamat</td>
                    <td>{{ $order->address }}, {{ $order->city }} {{ $order->postal_code }}</td>
                </tr>
                <tr>
                    <td class="label">Tanggal Pesanan</td>
                    <td>{{ $order->created_at?->format('d M Y H:i') }}</td>
                </tr>
            </table>

            <table class="items">
                <thead>
                    <tr>
                        <th>Daftar Buku</th>
                        <th class="text-right">Harga / Item</th>
                        <th class="text-right">Jumlah</th>
                        <th class="text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($order->orderDetails as $detail)
                        <tr>
                            <td>{{ $detail->book?->title ?? '-' }}</td>
                            <td class="text-right">Rp {{ number_format((int) $detail->price, 0, ',', '.') }}</td>
                            <td class="text-right">{{ $detail->quantity }}</td>
                            <td class="text-right">Rp {{ number_format((int) $detail->subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">Tidak ada detail item untuk order ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <table class="summary">
                <tr class="total">
                    <td>Total Harga</td>
                    <td class="text-right">Rp {{ number_format((int) $order->display_total, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Metode Pembayaran</td>
                    <td class="text-right">{{ $order->payment_method_label }}</td>
                </tr>
                <tr>
                    <td>Status Pembayaran</td>
                    <td class="text-right">{{ $order->payment_status_label }}</td>
                </tr>
                <tr>
                    <td>Nomor Kwitansi</td>
                    <td class="text-right">{{ $order->receipt_number ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Status Pesanan</td>
                    <td class="text-right">{{ $order->status_label }}</td>
                </tr>
            </table>

            @if ($order->payment_status === Order::PAYMENT_STATUS_PAID)
                <div style="margin-top:10px; padding:8px 10px; border:1px solid #86efac; background:#f0fdf4; color:#14532d; font-weight:700;">
                    Pembayaran telah diterima
                </div>
            @endif
        </div>
    </div>
</body>
</html>
