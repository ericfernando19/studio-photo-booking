<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Studio Foto Booking')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@500&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #4F46E5;
            --primary-dark: #3730A3;
            --primary-light: #EEF2FF;
            --sidebar-bg: #1E1B4B;
            --sidebar-hover: rgba(255,255,255,0.08);
            --sidebar-active: rgba(79,70,229,0.25);
            --surface: #FFFFFF;
            --background: #F8FAFC;
            --text-primary: #1E293B;
            --text-muted: #64748B;
            --border: #E2E8F0;
            --success: #059669;
            --warning: #D97706;
            --danger: #DC2626;
            --info: #0891B2;
            --sidebar-width: 280px;
            --sidebar-collapsed: 72px;
        }

        * { font-family: 'Inter', sans-serif; }

        body {
            background: var(--background);
            color: var(--text-primary);
            min-height: 100vh;
        }

        /* ===== SIDEBAR ===== */
        .admin-sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            background: linear-gradient(180deg, #1E1B4B 0%, #1E1B4B 100%);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1040;
            transition: width 0.3s ease, transform 0.3s ease;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .sidebar-brand {
            padding: 1.25rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }

        .sidebar-brand-icon {
            width: 40px;
            height: 40px;
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #4F46E5;
            font-size: 1.1rem;
            flex-shrink: 0;
            overflow: hidden;
        }

        .sidebar-brand-icon img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .sidebar-brand-text {
            color: #fff;
            font-weight: 700;
            font-size: 1rem;
            white-space: nowrap;
        }

        .sidebar-nav {
            flex: 1;
            padding: 0.75rem 0;
            overflow-y: auto;
            overflow-x: hidden;
        }

        .sidebar-nav .nav-group {
            margin-bottom: 0.125rem;
        }

        .sidebar-nav .nav-group-toggle {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            padding: 0.5rem 1.5rem;
            background: none;
            border: none;
            color: rgba(255,255,255,0.35);
            font-size: 0.6875rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            cursor: pointer;
            transition: color 0.15s;
        }

        .sidebar-nav .nav-group-toggle:hover {
            color: rgba(255,255,255,0.55);
        }

        .sidebar-nav .nav-group-toggle.active {
            color: rgba(255,255,255,0.55);
        }

        .sidebar-nav .nav-group-toggle i {
            font-size: 0.625rem;
            transition: transform 0.2s ease;
        }

        .sidebar-nav .nav-group-items {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.25s ease;
        }

        .sidebar-nav .nav-group-items.open {
            max-height: 500px;
        }

        .sidebar-nav .nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.625rem 1.5rem;
            color: rgba(255,255,255,0.6);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.15s ease;
            border-left: 3px solid transparent;
            margin: 1px 0;
            white-space: nowrap;
        }

        .sidebar-nav .nav-link:hover {
            color: #fff;
            background: var(--sidebar-hover);
        }

        .sidebar-nav .nav-link.active {
            color: #fff;
            background: var(--sidebar-active);
            border-left-color: var(--primary);
        }

        .sidebar-nav .nav-link i {
            width: 20px;
            text-align: center;
            font-size: 1.05rem;
            flex-shrink: 0;
        }

        .sidebar-footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid rgba(255,255,255,0.08);
            margin-top: auto;
            flex-shrink: 0;
        }

        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .sidebar-avatar {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 0.875rem;
            flex-shrink: 0;
        }

        .sidebar-user-info {
            flex: 1;
            min-width: 0;
        }

        .sidebar-user-name {
            color: #fff;
            font-size: 0.8125rem;
            font-weight: 600;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sidebar-user-role {
            color: rgba(255,255,255,0.45);
            font-size: 0.6875rem;
        }

        .sidebar-logout {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            width: 100%;
            padding: 0.625rem 1.5rem;
            color: rgba(255,255,255,0.5);
            background: none;
            border: none;
            cursor: pointer;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.15s;
            text-decoration: none;
            border-left: 3px solid transparent;
        }

        .sidebar-logout:hover {
            color: #fff;
            background: rgba(220,38,38,0.15);
        }

        .sidebar-logout i {
            width: 20px;
            text-align: center;
            font-size: 1.05rem;
        }

        /* ===== MAIN CONTENT ===== */
        .admin-main {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }

        /* ===== TOPBAR ===== */
        .admin-topbar {
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            padding: 0 1.5rem;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 1030;
        }

        .topbar-title {
            font-size: 1.125rem;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0;
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-toggle-sidebar {
            display: none;
            background: none;
            border: none;
            color: var(--text-primary);
            font-size: 1.25rem;
            padding: 0.375rem;
            border-radius: 8px;
            cursor: pointer;
        }

        .btn-toggle-sidebar:hover {
            background: var(--background);
        }

        /* ===== CONTENT AREA ===== */
        .admin-content {
            padding: 1.5rem;
        }

        /* ===== CARDS ===== */
        .card-admin {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            transition: box-shadow 0.2s ease;
        }

        .card-admin:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.04);
        }

        .card-admin .card-header {
            background: transparent;
            border-bottom: 1px solid var(--border);
            padding: 1rem 1.25rem;
            border-radius: 12px 12px 0 0 !important;
        }

        .card-admin .card-body {
            padding: 1.25rem;
        }

        /* ===== STAT CARDS ===== */
        .stat-card-admin {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 1.25rem;
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            transition: all 0.2s ease;
            border-left: 4px solid transparent;
        }

        .stat-card-admin:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.06);
            transform: translateY(-1px);
        }

        .stat-card-admin.border-primary { border-left-color: var(--primary); }
        .stat-card-admin.border-success { border-left-color: var(--success); }
        .stat-card-admin.border-warning { border-left-color: var(--warning); }
        .stat-card-admin.border-danger { border-left-color: var(--danger); }
        .stat-card-admin.border-info { border-left-color: var(--info); }
        .stat-card-admin.border-purple { border-left-color: #7C3AED; }
        .stat-card-admin.border-dark { border-left-color: var(--text-primary); }

        .stat-icon-admin {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            flex-shrink: 0;
        }

        .stat-icon-admin.bg-primary-subtle { background: var(--primary-light); color: var(--primary); }
        .stat-icon-admin.bg-success-subtle { background: #ECFDF5; color: var(--success); }
        .stat-icon-admin.bg-warning-subtle { background: #FFFBEB; color: var(--warning); }
        .stat-icon-admin.bg-danger-subtle { background: #FEF2F2; color: var(--danger); }
        .stat-icon-admin.bg-info-subtle { background: #ECFEFF; color: var(--info); }
        .stat-icon-admin.bg-purple-subtle { background: #F5F3FF; color: #7C3AED; }
        .stat-icon-admin.bg-dark-subtle { background: #F1F5F9; color: var(--text-primary); }

        .stat-label {
            font-size: 0.8125rem;
            color: var(--text-muted);
            font-weight: 500;
            margin-bottom: 0.25rem;
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-primary);
            line-height: 1.2;
            font-family: 'JetBrains Mono', monospace;
        }

        /* ===== TABLES ===== */
        .table-admin {
            margin: 0;
        }

        .table-admin thead th {
            background: var(--background);
            border-bottom: 1px solid var(--border);
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            color: var(--text-muted);
            padding: 0.75rem 1rem;
            white-space: nowrap;
        }

        .table-admin tbody td {
            padding: 0.875rem 1rem;
            border-bottom: 1px solid var(--border);
            font-size: 0.875rem;
            vertical-align: middle;
        }

        .table-admin tbody tr:last-child td {
            border-bottom: none;
        }

        .table-admin tbody tr:hover {
            background: rgba(79,70,229,0.02);
        }

        /* ===== BADGES ===== */
        .badge-status {
            font-size: 0.6875rem;
            font-weight: 600;
            padding: 0.35em 0.65em;
            border-radius: 6px;
            color: #fff;
        }

        .badge-status.bg-warning { color: #1E293B; }
        .badge-status.bg-light { color: #1E293B; }
        .badge-status.bg-purple { background: #7C3AED !important; }

        /* ===== BUTTONS ===== */
        .btn-admin {
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.875rem;
            padding: 0.5rem 1rem;
            transition: all 0.15s ease;
        }

        .btn-admin-primary {
            background: var(--primary);
            border-color: var(--primary);
            color: #fff;
        }

        .btn-admin-primary:hover {
            background: var(--primary-dark);
            border-color: var(--primary-dark);
            color: #fff;
        }

        /* ===== FORMS ===== */
        .form-control-admin, .form-select-admin {
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
            transition: border-color 0.15s, box-shadow 0.15s;
        }

        .form-control-admin:focus, .form-select-admin:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79,70,229,0.12);
        }

        /* ===== PAGE HEADER ===== */
        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }

        .page-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0;
        }

        /* ===== ALERTS ===== */
        .alert-admin {
            border: none;
            border-radius: 10px;
            padding: 0.875rem 1rem;
            font-size: 0.875rem;
            font-weight: 500;
        }

        /* ===== OFFCANVAS SIDEBAR (Mobile) ===== */
        .offcanvas-admin {
            background: var(--sidebar-bg);
            border: none;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 991.98px) {
            .admin-sidebar {
                transform: translateX(-100%);
            }

            .admin-sidebar.show {
                transform: translateX(0);
            }

            .admin-main {
                margin-left: 0;
            }

            .btn-toggle-sidebar {
                display: flex;
            }

            .sidebar-overlay {
                display: none;
                position: fixed;
                inset: 0;
                background: rgba(0,0,0,0.5);
                z-index: 1035;
            }

            .sidebar-overlay.show {
                display: block;
            }
        }

        @media (max-width: 575.98px) {
            .admin-content {
                padding: 1rem;
            }

            .stat-card-admin {
                padding: 1rem;
            }

            .stat-value {
                font-size: 1.25rem;
            }
        }

        /* ===== SCROLLBAR ===== */
        .admin-sidebar::-webkit-scrollbar,
        .sidebar-nav::-webkit-scrollbar {
            width: 4px;
        }

        .admin-sidebar::-webkit-scrollbar-track,
        .sidebar-nav::-webkit-scrollbar-track {
            background: transparent;
        }

        .admin-sidebar::-webkit-scrollbar-thumb,
        .sidebar-nav::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.15);
            border-radius: 4px;
        }

        /* ===== ANIMATIONS ===== */
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: 0.01ms !important;
                transition-duration: 0.01ms !important;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    {{-- Sidebar Overlay (Mobile) --}}
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    {{-- Sidebar --}}
    <nav class="admin-sidebar" id="adminSidebar">
        <div class="sidebar-brand">
            <div class="sidebar-brand-icon">
                @if($studioSettings['logo'])
                    <img src="{{ Storage::url($studioSettings['logo']) }}" alt="Logo">
                @else
                    <i class="bi bi-camera"></i>
                @endif
            </div>
            <span class="sidebar-brand-text">{{ $studioSettings['name'] }}</span>
        </div>

        <div class="sidebar-nav">
            <div class="nav-group">
                <button class="nav-group-toggle {{ collect(['admin.dashboard','admin.calendar.*'])->contains(fn($p) => request()->routeIs($p)) ? 'active' : '' }}" onclick="toggleGroup(this)">
                    <span>Menu</span>
                    <i class="bi bi-chevron-down"></i>
                </button>
                <div class="nav-group-items {{ collect(['admin.dashboard','admin.calendar.*'])->contains(fn($p) => request()->routeIs($p)) ? 'open' : '' }}">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-grid-1x2"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('admin.calendar.index') }}" class="nav-link {{ request()->routeIs('admin.calendar.*') ? 'active' : '' }}">
                        <i class="bi bi-calendar3"></i>
                        <span>Kalender</span>
                    </a>
                </div>
            </div>

            <div class="nav-group">
                <button class="nav-group-toggle {{ collect(['admin.packages.*','admin.bookings.*','admin.payments.*','admin.studios.*','admin.queues.*'])->contains(fn($p) => request()->routeIs($p)) ? 'active' : '' }}" onclick="toggleGroup(this)">
                    <span>Kelola</span>
                    <i class="bi bi-chevron-down"></i>
                </button>
                <div class="nav-group-items {{ collect(['admin.packages.*','admin.bookings.*','admin.payments.*','admin.studios.*','admin.queues.*'])->contains(fn($p) => request()->routeIs($p)) ? 'open' : '' }}">
                    <a href="{{ route('admin.packages.index') }}" class="nav-link {{ request()->routeIs('admin.packages.*') ? 'active' : '' }}">
                        <i class="bi bi-box-seam"></i>
                        <span>Paket</span>
                    </a>
                    <a href="{{ route('admin.bookings.index') }}" class="nav-link {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
                        <i class="bi bi-journal-text"></i>
                        <span>Booking</span>
                    </a>
                    <a href="{{ route('admin.payments.index') }}" class="nav-link {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
                        <i class="bi bi-credit-card"></i>
                        <span>Pembayaran</span>
                    </a>
                    <a href="{{ route('admin.studios.index') }}" class="nav-link {{ request()->routeIs('admin.studios.*') ? 'active' : '' }}">
                        <i class="bi bi-building"></i>
                        <span>Studio</span>
                    </a>
                    <a href="{{ route('admin.queues.index') }}" class="nav-link {{ request()->routeIs('admin.queues.*') ? 'active' : '' }}">
                        <i class="bi bi-list-ol"></i>
                        <span>Antrian</span>
                    </a>
                </div>
            </div>

            <div class="nav-group">
                <button class="nav-group-toggle {{ collect(['admin.customers.*','admin.reports.*','admin.settings.*'])->contains(fn($p) => request()->routeIs($p)) ? 'active' : '' }}" onclick="toggleGroup(this)">
                    <span>Lainnya</span>
                    <i class="bi bi-chevron-down"></i>
                </button>
                <div class="nav-group-items {{ collect(['admin.customers.*','admin.reports.*','admin.settings.*'])->contains(fn($p) => request()->routeIs($p)) ? 'open' : '' }}">
                    <a href="{{ route('admin.customers.index') }}" class="nav-link {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
                        <i class="bi bi-people"></i>
                        <span>Customer</span>
                    </a>
                    <a href="{{ route('admin.reports.index') }}" class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                        <i class="bi bi-graph-up"></i>
                        <span>Laporan</span>
                    </a>
                    <a href="{{ route('admin.settings.index') }}" class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                        <i class="bi bi-gear"></i>
                        <span>Pengaturan</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="sidebar-footer">
            <div class="sidebar-user mb-2">
                <div class="sidebar-avatar">
                    <i class="bi bi-person-fill"></i>
                </div>
                <div class="sidebar-user-info">
                    <div class="sidebar-user-name">{{ auth()->user()->name }}</div>
                    <div class="sidebar-user-role">Administrator</div>
                </div>
            </div>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="sidebar-logout">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </nav>

    {{-- Main Content --}}
    <div class="admin-main">
        {{-- Topbar --}}
        <header class="admin-topbar">
            <div class="d-flex align-items-center gap-3">
                <button class="btn-toggle-sidebar" onclick="toggleSidebar()">
                    <i class="bi bi-list"></i>
                </button>
                <h1 class="topbar-title">@yield('title', 'Dashboard')</h1>
            </div>
            <div class="topbar-actions">
                @yield('topbar-actions')
            </div>
        </header>

        {{-- Content --}}
        <div class="admin-content">
            @if(session('success'))
                <div class="alert alert-success alert-admin alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-1"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-admin alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-circle me-1"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            var sidebar = document.getElementById('adminSidebar');
            var overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
        }

        function toggleGroup(btn) {
            var items = btn.nextElementSibling;
            var isOpen = items.classList.contains('open');

            if (isOpen) {
                items.classList.remove('open');
                btn.classList.remove('active');
            } else {
                items.classList.add('open');
                btn.classList.add('active');
            }
        }
    </script>
    @stack('scripts')
</body>
</html>
