<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        // Render login page.
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Ensure any stale authenticated state is removed before re-login.
        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        // Authenticate user credentials.
        $request->authenticate();

        // Prevent session fixation after login.
        $request->session()->regenerate();

        // Redirect users strictly based on role.
        $user = auth()->user();

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard')
                ->with('success', 'Login berhasil. Selamat datang kembali, Admin.');
        }

        return redirect()->route('landing')
            ->with('success', 'Login berhasil. Selamat datang kembali!');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Log out current user from web guard.
        Auth::guard('web')->logout();

        // Invalidate and rotate session security tokens.
        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/')
            ->with('success', 'Anda berhasil logout dari akun.');
    }
}
