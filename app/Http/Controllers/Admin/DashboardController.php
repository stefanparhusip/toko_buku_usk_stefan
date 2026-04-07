<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\Order;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        // Show monitoring summary for authenticated admin users.
        $stats = [
            'users' => User::where('role', 'user')->count(),
            'categories' => Category::count(),
            'books' => Book::count(),
            'orders' => Order::count(),
            'pendingOrders' => Order::where('status', 'pending')->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
