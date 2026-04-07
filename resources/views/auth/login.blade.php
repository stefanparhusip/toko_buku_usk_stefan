@extends('layouts.auth-split')

@section('page_title', 'Masuk Akun 3bie')
@section('heading', 'Masuk Akun 3bie')

@section('auth_form')
    <style>
        .password-wrap {
            position: relative;
        }

        .password-wrap .form-control {
            padding-right: 3rem;
        }

        .password-toggle {
            position: absolute;
            top: 50%;
            right: 0.75rem;
            transform: translateY(-50%);
            border: 0;
            background: transparent;
            color: #5a6477;
            width: 2rem;
            height: 2rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            cursor: pointer;
        }

        .password-toggle:hover {
            color: #0A1F44;
        }

        .password-toggle:focus-visible {
            outline: 2px solid rgba(10, 31, 68, 0.25);
            border-radius: 6px;
        }

        .password-toggle .eye-off {
            display: none;
        }

        .password-toggle.is-visible .eye-on {
            display: none;
        }

        .password-toggle.is-visible .eye-off {
            display: inline;
        }
    </style>

    <form id="loginForm" method="POST" action="{{ route('login') }}" novalidate>
        @csrf

        <div class="mb-3">
            <input id="email" type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Email" autofocus autocomplete="username">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <div class="password-wrap">
                <input id="password" type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Kata Sandi" autocomplete="current-password">
                <button id="passwordToggle" type="button" class="password-toggle" aria-label="Tampilkan password" aria-pressed="false">
                    <svg class="eye-on" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 16 16" fill="currentColor">
                        <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zm-8 4a4 4 0 1 1 0-8 4 4 0 0 1 0 8z"/>
                        <path d="M8 5a3 3 0 1 0 0 6 3 3 0 0 0 0-6z"/>
                    </svg>
                    <svg class="eye-off" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 16 16" fill="currentColor">
                        <path d="M13.359 11.238C14.39 10.233 15.07 9.104 15.53 8c-.835-2-2.43-3.568-4.574-4.345l-.77.771A6.69 6.69 0 0 1 14.16 8a11.7 11.7 0 0 1-1.52 2.307l.719.931zM11.297 13.3l-.802-.802A7.04 7.04 0 0 1 8 13c-3.5 0-5.67-2.46-6.64-4a12.32 12.32 0 0 1 2.54-2.92l-.73-.73A13.133 13.133 0 0 0 .47 8C1.44 10.04 3.88 13.5 8 13.5c1.104 0 2.164-.2 3.157-.57l.14.37z"/>
                        <path d="M11.354 8.646A3.5 3.5 0 0 0 7.354 4.646l1.1 1.1a2 2 0 0 1 2 2l.9.9zM5.4 6.107l1.514 1.514a1.5 1.5 0 0 0 1.465 1.465l1.514 1.514A3.5 3.5 0 0 1 5.4 6.107z"/>
                        <path d="M13.646 14.354a.5.5 0 0 1-.707 0l-12-12a.5.5 0 1 1 .707-.708l12 12a.5.5 0 0 1 0 .708z"/>
                    </svg>
                </button>
            </div>
            @error('password')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-check mb-3">
            <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
            <label class="form-check-label" for="remember_me">Remember me</label>
        </div>

        <div class="text-end mb-3">
            @if (Route::has('password.request'))
                <a class="small muted-link" href="{{ route('password.request') }}">
                    Lupa Kata Sandi
                </a>
            @endif
        </div>

        <button id="submitLogin" type="submit" class="btn btn-auth w-100" disabled>Masuk</button>

        <p class="text-center mt-4 mb-0">
            Belum punya akun?
            <a href="{{ route('register') }}" class="fw-semibold muted-link">Daftar</a>
        </p>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            const submitButton = document.getElementById('submitLogin');
            const passwordToggle = document.getElementById('passwordToggle');

            const syncButtonState = function () {
                const email = emailInput.value.trim();
                const password = passwordInput.value.trim();
                const isComplete = email !== '' && password !== '';

                submitButton.disabled = !isComplete;
            };

            emailInput.addEventListener('input', syncButtonState);
            passwordInput.addEventListener('input', syncButtonState);

            passwordToggle.addEventListener('click', function () {
                const showPassword = passwordInput.type === 'password';
                passwordInput.type = showPassword ? 'text' : 'password';
                passwordToggle.classList.toggle('is-visible', showPassword);
                passwordToggle.setAttribute('aria-pressed', showPassword ? 'true' : 'false');
                passwordToggle.setAttribute('aria-label', showPassword ? 'Sembunyikan password' : 'Tampilkan password');
            });

            syncButtonState();
        });
    </script>
@endsection
