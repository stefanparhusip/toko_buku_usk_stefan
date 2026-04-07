<aside class="admin-sidebar">
    <a href="{{ route('admin.dashboard') }}" class="brand-link text-decoration-none">
        <span class="brand-logo-box">
            <img src="{{ asset('img/logo 3bie.png') }}" alt="3bieStore Logo" class="brand-logo-mini">
        </span>
        <span class="brand-text-side">3bieStore Admin</span>
    </a>

    <nav class="nav flex-column sidebar-nav mt-4">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fa-solid fa-chart-line"></i>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('admin.categories.index') }}" class="sidebar-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
            <i class="fa-solid fa-list"></i>
            <span>Categories</span>
        </a>
        <a href="{{ route('admin.books.index') }}" class="sidebar-link {{ request()->routeIs('admin.books.*') ? 'active' : '' }}">
            <i class="fa-solid fa-book"></i>
            <span>Books</span>
        </a>
        <a href="{{ route('admin.promos.index') }}" class="sidebar-link {{ request()->routeIs('admin.promos.*') ? 'active' : '' }}">
            <i class="fa-solid fa-tags"></i>
            <span>Promos</span>
        </a>
        <a href="{{ route('admin.orders.index') }}" class="sidebar-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
            <i class="fa-solid fa-basket-shopping"></i>
            <span>Orders</span>
        </a>
        <a href="{{ route('admin.contacts.index') }}" class="sidebar-link {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}">
            <i class="fa-solid fa-envelope"></i>
            <span>Messages</span>
        </a>
        <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <i class="fa-solid fa-users"></i>
            <span>Users</span>
        </a>
        <a href="{{ route('admin.homepage-slots.index') }}" class="sidebar-link {{ request()->routeIs('admin.homepage-slots.*') ? 'active' : '' }}">
            <i class="fa-solid fa-grip"></i>
            <span>Homepage Slots</span>
        </a>
    </nav>

    <form method="POST" action="{{ route('logout') }}" class="logout-form mt-auto">
        @csrf
        <button type="submit" class="btn btn-logout w-100">
            <i class="fa-solid fa-right-from-bracket"></i>
            <span>Logout</span>
        </button>
    </form>
</aside>
