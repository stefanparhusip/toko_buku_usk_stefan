<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $order->order_code ?? ('#' . $order->id) }}</title>
    <style>
        :root {
            color-scheme: light;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 24px;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            color: #111827;
            background: #ffffff;
            line-height: 1.5;
        }

        .invoice {
            max-width: 900px;
            margin: 0 auto;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            background: #ffffff;
            overflow: hidden;
        }

        .invoice-header {
            padding: 20px 24px;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .title {
            margin: 0;
            font-size: 28px;
            letter-spacing: 0.8px;
            font-weight: 700;
        }

        .invoice-meta {
            text-align: right;
            color: #4b5563;
            font-size: 14px;
        }

        .invoice-body {
            padding: 24px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px 24px;
            margin-bottom: 22px;
        }

        .label {
            font-size: 12px;
            color: #6b7280;
            margin-bottom: 3px;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }

        .value {
            font-weight: 600;
            color: #111827;
            word-break: break-word;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }

        thead th {
            text-align: left;
            font-size: 12px;
            color: #6b7280;
            padding: 10px 8px;
            border-bottom: 1px solid #e5e7eb;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        tbody td {
            padding: 10px 8px;
            border-bottom: 1px solid #f3f4f6;
            font-size: 14px;
            vertical-align: top;
        }

        .text-right {
            text-align: right;
        }

        .summary {
            margin-top: 20px;
            margin-left: auto;
            width: min(360px, 100%);
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            overflow: hidden;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            padding: 10px 14px;
            border-bottom: 1px solid #f3f4f6;
            font-size: 14px;
        }

        .summary-row:last-child {
            border-bottom: 0;
        }

        .summary-row.total {
            font-weight: 700;
            font-size: 16px;
            background: #f9fafb;
        }

        .actions {
            display: flex;
            justify-content: flex-end;
            gap: 8px;
            margin-top: 18px;
        }

        .btn {
            display: inline-block;
            text-decoration: none;
            border: 1px solid #d1d5db;
            color: #111827;
            border-radius: 6px;
            font-size: 14px;
            padding: 8px 14px;
            background: #ffffff;
        }

        .btn-print {
            background: #111827;
            color: #ffffff;
            border-color: #111827;
        }

        .muted {
            color: #6b7280;
            font-size: 13px;
        }

        @media (max-width: 768px) {
            body {
                padding: 12px;
            }

            .invoice-header,
            .invoice-body {
                padding: 16px;
            }

            .invoice-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .invoice-meta {
                text-align: left;
            }

            .grid {
                grid-template-columns: 1fr;
                gap: 12px;
            }
        }

        @media print {
            body {
                padding: 0;
                background: #fff;
            }

            body * {
                visibility: hidden;
            }

            .invoice,
            .invoice * {
                visibility: visible;
            }

            .invoice {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                border: 0;
                border-radius: 0;
                max-width: none;
            }

            .navbar,
            .actions {
                display: none;
            }

            .btn {
                display: none !important;
            }
        }
    </style>
</head>
<body>
    @php
        use App\Models\Order;
    @endphp

    <div class="invoice">
        <div class="invoice-header">
            <h1 class="title">INVOICE 3bieStore</h1>
            <div class="invoice-meta">
                <div><strong>ID Order:</strong> #{{ $order->id }}</div>
                <div>{{ $order->created_at?->format('d M Y H:i') }}</div>
            </div>
        </div>

        <div class="invoice-body">
            <div class="grid">
                <div>
                    <div class="label">Nama Pembeli</div>
                    <div class="value">{{ $order->user?->name ?? $order->nama_penerima }}</div>
                </div>
                <div>
                    <div class="label">Nomor HP</div>
                    <div class="value">{{ $order->phone }}</div>
                </div>
                <div>
                    <div class="label">Alamat</div>
                    <div class="value">{{ $order->address }}, {{ $order->city }} {{ $order->postal_code }}</div>
                </div>
                <div>
                    <div class="label">Tanggal Pesanan</div>
                    <div class="value">{{ $order->created_at?->format('d M Y H:i') }}</div>
                </div>
            </div>

            <table>
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
                            <td colspan="4" class="muted">Tidak ada detail item untuk order ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="summary">
                <div class="summary-row total">
                    <span>Total Harga</span>
                    <span>Rp {{ number_format((int) $order->display_total, 0, ',', '.') }}</span>
                </div>
                <div class="summary-row">
                    <span>Metode Pembayaran</span>
                    <span>{{ $order->payment_method_label }}</span>
                </div>
                <div class="summary-row">
                    <span>Status Pembayaran</span>
                    <span>{{ $order->payment_status_label }}</span>
                </div>
                <div class="summary-row">
                    <span>Nomor Kwitansi</span>
                    <span>{{ $order->receipt_number ?? '-' }}</span>
                </div>
                <div class="summary-row">
                    <span>Status Pesanan</span>
                    <span>{{ $order->status_label }}</span>
                </div>
            </div>

            @if ($order->payment_status === Order::PAYMENT_STATUS_PAID)
                <div style="margin-top:12px; padding:10px 12px; border:1px solid #bbf7d0; background:#f0fdf4; color:#166534; border-radius:8px; font-weight:600;">
                    Pembayaran telah diterima
                </div>
            @endif

            <div class="actions">
                <a href="{{ route('invoice.download', $order->id) }}" class="btn">Download PDF</a>
                <button type="button" class="btn btn-print" onclick="window.print()">Cetak Invoice</button>
                <a
                    href="{{ auth()->user()?->role === 'admin' ? route('admin.orders.show', $order) : route('orders.history') }}"
                    class="btn"
                >Kembali</a>
            </div>
        </div>
    </div>
</body>
</html>
