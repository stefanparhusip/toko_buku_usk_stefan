<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::defaultView('vendor.pagination.bookstore');
        Paginator::defaultSimpleView('vendor.pagination.bookstore-simple');

        View::composer('admin.components.sidebar', function ($view): void {
            $unreadChatCount = 0;
            $user = Auth::user();

            if ($user && $user->role === 'admin' && Schema::hasTable('messages')) {
                $unreadChatCount = Message::query()
                    ->where('receiver_id', $user->id)
                    ->whereNull('read_at')
                    ->count();
            }

            $view->with('unreadChatCount', $unreadChatCount);
        });

        View::composer('user.layouts.app', function ($view): void {
            $headerCategories = collect();

            if (Schema::hasTable('categories')) {
                $headerCategories = Category::query()
                    ->orderBy('name')
                    ->get(['id', 'name']);
            }

            $view->with('headerCategories', $headerCategories);
        });
    }
}
