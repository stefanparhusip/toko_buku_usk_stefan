<header class="admin-topbar">
    <div>
        <h1 class="page-title mb-0">{{ $title ?? 'Admin Dashboard' }}</h1>
        <p class="page-subtitle mb-0">Panel manajemen BookStore dengan tema navy elegan.</p>
    </div>

    <div class="profile-chip">
        <span class="avatar-circle">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}</span>
        <div>
            <div class="profile-name">{{ auth()->user()->name ?? 'Administrator' }}</div>
            <div class="profile-role">{{ ucfirst(auth()->user()->role ?? 'admin') }}</div>
        </div>
    </div>
</header>
