@extends('user.layouts.app', ['title' => 'Checkout'])

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="section-title mb-1">Checkout</h2>
            <p class="text-muted mb-0">Lengkapi data penerima dan pilih metode pembayaran.</p>
        </div>
        <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary">Kembali ke Cart</a>
    </div>

    <form method="POST" action="{{ route('checkout.process') }}">
        @csrf
        <div class="row g-4 align-items-start">
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4">
                        <h5 class="mb-3">Data Penerima</h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="nama_penerima" class="form-label">Nama Penerima</label>
                                <input type="text" id="nama_penerima" name="nama_penerima" value="{{ old('nama_penerima', auth()->user()->name) }}" class="form-control @error('nama_penerima') is-invalid @enderror" required>
                                @error('nama_penerima')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label">No. HP</label>
                                <input type="text" id="phone" name="phone" value="{{ old('phone') }}" class="form-control @error('phone') is-invalid @enderror" placeholder="08xxxxxxxxxx" required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label for="address" class="form-label">Alamat Lengkap</label>
                                <textarea id="address" name="address" rows="3" class="form-control @error('address') is-invalid @enderror" required>{{ old('address') }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-8">
                                <label for="city" class="form-label">Kota</label>
                                <input type="text" id="city" name="city" value="{{ old('city') }}" class="form-control @error('city') is-invalid @enderror" required>
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="postal_code" class="form-label">Kode Pos</label>
                                <input type="text" id="postal_code" name="postal_code" value="{{ old('postal_code') }}" class="form-control @error('postal_code') is-invalid @enderror" required>
                                @error('postal_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead>
                                <tr>
                                    <th>Buku</th>
                                    <th>Quantity</th>
                                    <th>Harga</th>
                                    <th>Subtotal</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($cartItems as $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <img src="{{ $item->book?->image_source ?: 'https://placehold.co/80x80?text=No+Image' }}" alt="{{ $item->book?->title }}" class="rounded" style="width: 56px; height: 56px; object-fit: cover;">
                                                <span>{{ $item->book?->title ?? '-' }}</span>
                                            </div>
                                        </td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>Rp {{ number_format($item->book?->price ?? 0, 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($item->total_price, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 1.5rem;">
                    <div class="card-body">
                        <h5 class="mb-3">Pembayaran</h5>

                        <div class="border rounded-3 p-3 mb-2">
                            <div class="form-check m-0">
                                <input class="form-check-input" type="radio" name="payment_method" id="pm_cod" value="COD" @checked(old('payment_method', 'COD') === 'COD')>
                                <label class="form-check-label fw-semibold" for="pm_cod">COD (Bayar di Tempat)</label>
                                <div class="small text-muted">Wajib isi alamat lengkap agar kurir bisa antar.</div>
                            </div>
                        </div>

                        <div class="border rounded-3 p-3 mb-3">
                            <div class="form-check m-0">
                                <input class="form-check-input" type="radio" name="payment_method" id="pm_transfer" value="BANK_TRANSFER" @checked(old('payment_method') === 'BANK_TRANSFER')>
                                <label class="form-check-label fw-semibold" for="pm_transfer">Transfer Bank</label>
                                <div class="small text-muted">Transfer manual, lalu klik tombol "Saya sudah transfer".</div>
                            </div>
                        </div>
                        @error('payment_method')
                            <div class="text-danger small mb-3">{{ $message }}</div>
                        @enderror

                        <div id="transfer_bank_info" class="alert alert-warning small mb-3 {{ old('payment_method') === 'BANK_TRANSFER' ? '' : 'd-none' }}">
                            <div class="fw-semibold mb-2">Rekening Tujuan (Demo)</div>
                            <div>BCA: 1234567890 a.n. BookStore Nusantara</div>
                            <div>BRI: 9876543210 a.n. BookStore Nusantara</div>
                            <div>Mandiri: 1122334455 a.n. BookStore Nusantara</div>
                        </div>

                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Total Pembayaran</span>
                            <strong class="text-primary">Rp {{ number_format($totalPayment, 0, ',', '.') }}</strong>
                        </div>

                        <button type="submit" class="btn btn-navy w-100">Buat Pesanan</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const codInput = document.getElementById('pm_cod');
            const transferInput = document.getElementById('pm_transfer');
            const bankInfo = document.getElementById('transfer_bank_info');

            const syncTransferPanel = () => {
                if (!bankInfo || !transferInput) {
                    return;
                }

                bankInfo.classList.toggle('d-none', !transferInput.checked);
            };

            codInput?.addEventListener('change', syncTransferPanel);
            transferInput?.addEventListener('change', syncTransferPanel);
            syncTransferPanel();
        });
    </script>
@endsection
