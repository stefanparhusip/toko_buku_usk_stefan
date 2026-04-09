@extends('user.layouts.app', ['title' => 'Akun Saya'])

@section('content')
    <style>
        .account-shell {
            background: #f5f7fa;
            border-radius: 18px;
            padding: 1rem;
        }

        .account-sidebar,
        .account-card {
            background: #fff;
            border: 1px solid #dbe4f3;
            border-radius: 16px;
            box-shadow: 0 10px 26px rgba(15, 23, 42, 0.08);
        }

        .account-sidebar {
            padding: 1.1rem;
            position: sticky;
            top: 102px;
        }

        .avatar-badge {
            width: 82px;
            height: 82px;
            border-radius: 50%;
            background: linear-gradient(145deg, #0f172a, #1f2e52);
            color: #fff;
            font-size: 1.8rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 12px 20px rgba(15, 23, 42, 0.2);
        }

        .account-name {
            font-size: 1.04rem;
            font-weight: 700;
            color: #0f172a;
            margin-top: 0.7rem;
            margin-bottom: 0.15rem;
        }

        .account-email {
            color: #60708c;
            font-size: 0.86rem;
            margin-bottom: 0.35rem;
            word-break: break-word;
        }

        .account-joined {
            color: #7c8da9;
            font-size: 0.8rem;
            margin-bottom: 0.9rem;
        }

        .account-menu {
            display: grid;
            gap: 0.42rem;
        }

        .account-menu-link {
            border: 1px solid #d4dff1;
            border-radius: 11px;
            padding: 0.52rem 0.65rem;
            text-decoration: none;
            color: #1c2b47;
            font-size: 0.92rem;
            font-weight: 500;
            transition: all 0.2s ease;
            background: #f8fbff;
        }

        .account-menu-link:hover,
        .account-menu-link.is-active {
            border-color: #0f172a;
            background: #eef3ff;
            color: #0f172a;
        }

        .account-card {
            padding: 1.2rem;
            margin-bottom: 1rem;
        }

        .account-card-title {
            font-size: 1.03rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 0.2rem;
        }

        .account-card-sub {
            color: #64748b;
            font-size: 0.88rem;
            margin-bottom: 1rem;
        }

        .account-label {
            font-size: 0.8rem;
            font-weight: 600;
            color: #4c607f;
            margin-bottom: 0.32rem;
        }

        .account-input-wrap {
            position: relative;
        }

        .account-input {
            border-radius: 11px;
            border: 1px solid #cfdcf2;
            min-height: 46px;
            padding: 0.55rem 0.75rem;
        }

        .account-input:focus {
            border-color: #0f172a;
            box-shadow: 0 0 0 0.2rem rgba(15, 23, 42, 0.12);
        }

        .toggle-password {
            position: absolute;
            right: 0.52rem;
            top: 50%;
            transform: translateY(-50%);
            border: 0;
            background: transparent;
            color: #5f6f8b;
            padding: 0.2rem 0.4rem;
            font-size: 0.82rem;
            font-weight: 600;
        }

        .profile-chip {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            border: 1px solid #dae3f2;
            border-radius: 999px;
            padding: 0.38rem 0.65rem;
            background: #f9fbff;
            color: #1f3252;
            font-size: 0.82rem;
            margin-bottom: 0.9rem;
        }

        .status-toast {
            border: 1px solid #b5e3c4;
            background: #ecfaf1;
            color: #19653a;
            border-radius: 11px;
            padding: 0.52rem 0.72rem;
            font-size: 0.86rem;
            margin-bottom: 0.85rem;
        }

        @media (max-width: 991px) {
            .account-shell {
                padding: 0.65rem;
            }

            .account-sidebar {
                position: static;
                margin-bottom: 0.95rem;
            }

            .account-card {
                padding: 0.95rem;
            }

            .account-actions .btn {
                width: 100%;
            }
        }
    </style>

    @php
        $avatarInitial = strtoupper(mb_substr($user->name ?? 'U', 0, 1));
    @endphp

    <div class="account-shell">
        <div class="row g-3">
            <div class="col-lg-3">
                <aside class="account-sidebar h-100">
                    <div class="text-center mb-2">
                        <span class="avatar-badge">{{ $avatarInitial }}</span>
                        <div class="account-name">{{ $user->name }}</div>
                        <div class="account-email">{{ $user->email }}</div>
                        <div class="account-joined">Terdaftar sejak: {{ optional($user->created_at)->translatedFormat('d M Y') }}</div>
                    </div>

                    <nav class="account-menu">
                        <a href="{{ route('profile.edit') }}" class="account-menu-link is-active">👤 Profile</a>
                        <a href="{{ route('orders.index') }}" class="account-menu-link">🛒 Orders</a>
                        <a href="{{ route('orders.history') }}" class="account-menu-link">📜 History</a>
                        <a href="{{ route('chat.index') }}" class="account-menu-link">💬 Chat Admin</a>
                        <form method="POST" action="{{ route('logout') }}" class="mt-1">
                            @csrf
                            <button type="submit" class="btn btn-outline-secondary w-100 text-start">↩ Logout</button>
                        </form>
                    </nav>
                </aside>
            </div>

            <div class="col-lg-9">
                <div class="account-card">
                    <h3 class="account-card-title">Profile Information</h3>
                    <p class="account-card-sub">Update informasi akun dan email Anda.</p>

                    <div class="profile-chip">ℹ️ Kelola profil Anda agar informasi pesanan selalu akurat.</div>

                    @if (session('status') === 'profile-updated')
                        <div class="status-toast">Profile berhasil diperbarui.</div>
                    @endif

                    <form id="send-verification" method="POST" action="{{ route('verification.send') }}">
                        @csrf
                    </form>

                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PATCH')

                        <div class="mb-3">
                            <label for="name" class="account-label">Nama</label>
                            <input id="name" name="name" type="text" class="form-control account-input @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="account-label">Email</label>
                            <input id="email" name="email" type="email" class="form-control account-input @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required autocomplete="username">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                <div class="small mt-2 text-muted">
                                    Email Anda belum terverifikasi.
                                    <button form="send-verification" class="btn btn-link p-0 align-baseline">Kirim ulang verifikasi</button>
                                </div>

                                @if (session('status') === 'verification-link-sent')
                                    <div class="small text-success mt-1">Link verifikasi baru sudah dikirim ke email Anda.</div>
                                @endif
                            @endif
                        </div>

                        <div class="account-actions d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Edit Profile</button>
                        </div>
                    </form>
                </div>

                <div class="account-card">
                    <h3 class="account-card-title">🔒 Keamanan Akun</h3>
                    <p class="account-card-sub">Pastikan password Anda kuat dan tidak mudah ditebak.</p>

                    @if (session('status') === 'password-updated')
                        <div class="status-toast">Password berhasil diperbarui.</div>
                    @endif

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="update_password_current_password" class="account-label">Password Lama</label>
                            <div class="account-input-wrap">
                                <input id="update_password_current_password" name="current_password" type="password" class="form-control account-input @error('current_password', 'updatePassword') is-invalid @enderror" autocomplete="current-password">
                                <button type="button" class="toggle-password" data-password-toggle="update_password_current_password">Lihat</button>
                            </div>
                            @error('current_password', 'updatePassword')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="update_password_password" class="account-label">Password Baru</label>
                            <div class="account-input-wrap">
                                <input id="update_password_password" name="password" type="password" class="form-control account-input @error('password', 'updatePassword') is-invalid @enderror" autocomplete="new-password">
                                <button type="button" class="toggle-password" data-password-toggle="update_password_password">Lihat</button>
                            </div>
                            @error('password', 'updatePassword')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="update_password_password_confirmation" class="account-label">Konfirmasi Password Baru</label>
                            <div class="account-input-wrap">
                                <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-control account-input @error('password_confirmation', 'updatePassword') is-invalid @enderror" autocomplete="new-password">
                                <button type="button" class="toggle-password" data-password-toggle="update_password_password_confirmation">Lihat</button>
                            </div>
                            @error('password_confirmation', 'updatePassword')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="account-actions d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Simpan Password</button>
                        </div>
                    </form>
                </div>

                <div class="account-card">
                    <h3 class="account-card-title text-danger">Hapus Akun</h3>
                    <p class="account-card-sub mb-3">Aksi ini bersifat permanen dan akan menghapus semua data akun Anda.</p>

                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteAccountModal">
                        Hapus Akun
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="confirmDeleteAccountModal" tabindex="-1" aria-labelledby="confirmDeleteAccountLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0" style="border-radius: 16px; overflow: hidden;">
                <div class="modal-header" style="background:#0f172a; color:#fff;">
                    <h5 class="modal-title" id="confirmDeleteAccountLabel">Konfirmasi Hapus Akun</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('DELETE')

                    <div class="modal-body">
                        <p class="mb-3">Apakah Anda yakin ingin menghapus akun? Tindakan ini tidak dapat dibatalkan.</p>

                        <label for="delete_password" class="account-label">Masukkan Password</label>
                        <div class="account-input-wrap">
                            <input id="delete_password" name="password" type="password" class="form-control account-input @error('password', 'userDeletion') is-invalid @enderror" placeholder="Password Anda">
                            <button type="button" class="toggle-password" data-password-toggle="delete_password">Lihat</button>
                        </div>
                        @error('password', 'userDeletion')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus Permanen</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('[data-password-toggle]').forEach(function (button) {
            button.addEventListener('click', function () {
                const targetId = button.getAttribute('data-password-toggle');
                const input = document.getElementById(targetId);

                if (!input) {
                    return;
                }

                const isPassword = input.getAttribute('type') === 'password';
                input.setAttribute('type', isPassword ? 'text' : 'password');
                button.textContent = isPassword ? 'Sembunyi' : 'Lihat';
            });
        });

        @if ($errors->userDeletion->isNotEmpty())
            window.addEventListener('DOMContentLoaded', function () {
                const modalElement = document.getElementById('confirmDeleteAccountModal');
                if (modalElement && window.bootstrap) {
                    const modal = new window.bootstrap.Modal(modalElement);
                    modal.show();
                }
            });
        @endif
    </script>
@endsection
