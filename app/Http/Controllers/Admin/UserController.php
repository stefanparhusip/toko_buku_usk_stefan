<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display a listing of registered users for admin monitoring.
     */
    public function index(): View
    {
        $users = User::where('role', 'user')
            ->latest()
            ->paginate(12);

        return view('admin.users.index', compact('users'));
    }
}
