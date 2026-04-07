<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View|RedirectResponse
    {
        // Redirect users to the designed dashboard based on their role.
        if (auth()->user()?->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('books.index');
    }
}
