@extends('layouts.auth-split')

@section('page_title', 'Daftar Akun 3bie')
@section('heading', 'Daftar Akun 3bie')

@section('auth_form')

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-3">
            <input id="email" type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Email" required autocomplete="username">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <input id="name" type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Nama Lengkap" required autofocus autocomplete="name">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <input id="password" type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Kata Sandi" required autocomplete="new-password">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <input id="password_confirmation" type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Konfirmasi Kata Sandi" required autocomplete="new-password">
            @error('password_confirmation')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <ul class="small text-muted mb-3 ps-3">
            <li>Minimum 8 karakter</li>
            <li>Sertakan huruf kapital dan non-kapital</li>
            <li>Sertakan angka dan simbol</li>
        </ul>

        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" id="terms" required>
            <label class="form-check-label" for="terms">
                Saya menyetujui syarat dan ketentuan kebijakan privasi.
            </label>
        </div>

        <button type="submit" class="btn btn-auth w-100">Daftar</button>

        <p class="text-center mt-4 mb-0">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="fw-semibold muted-link">Masuk</a>
        </p>
    </form>
@endsection
