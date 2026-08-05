<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Studio Foto Booking')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        .bg-purple { background-color: #6f42c1; }
        .text-purple { color: #6f42c1; }
        .sidebar { min-height: 100vh; background: #1a1a2e; }
        .sidebar .nav-link { color: #a0a0b0; padding: 0.75rem 1rem; border-radius: 0.5rem; margin: 0.125rem 0.5rem; }
        .sidebar .nav-link:hover { color: #fff; background: rgba(255,255,255,0.1); }
        .sidebar .nav-link.active { color: #fff; background: #6f42c1; }
        .sidebar .nav-link i { width: 24px; text-align: center; margin-right: 0.5rem; }
        .main-content { background: #f8f9fa; min-height: 100vh; }
        .stat-card { border: none; border-radius: 1rem; transition: transform 0.2s; }
        .stat-card:hover { transform: translateY(-2px); }
        .stat-icon { width: 48px; height: 48px; border-radius: 0.75rem; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; }
    </style>
    @stack('styles')
</head>
<body>
    <div class="d-flex">
        {{-- Sidebar --}}
        <nav class="sidebar d-flex flex-column p-3" style="width: 260px;">
            <a href="{{ route('admin.dashboard') }}" class="text-white text-decoration-none mb-4">
                <h5 class="mb-0"><i class="bi bi-camera"></i> Studio Booking</h5>
            </a>

            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.calendar.index') }}" class="nav-link {{ request()->routeIs('admin.calendar.*') ? 'active' : '' }}">
                        <i class="bi bi-calendar3"></i> Kalender
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.packages.index') }}" class="nav-link {{ request()->routeIs('admin.packages.*') ? 'active' : '' }}">
                        <i class="bi bi-box-seam"></i> Paket
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.bookings.index') }}" class="nav-link {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
                        <i class="bi bi-journal-text"></i> Booking
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.payments.index') }}" class="nav-link {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
                        <i class="bi bi-credit-card"></i> Pembayaran
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.studios.index') }}" class="nav-link {{ request()->routeIs('admin.studios.*') ? 'active' : '' }}">
                        <i class="bi bi-building"></i> Studio
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.queues.index') }}" class="nav-link {{ request()->routeIs('admin.queues.*') ? 'active' : '' }}">
                        <i class="bi bi-list-ol"></i> Antrian
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.customers.index') }}" class="nav-link {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
                        <i class="bi bi-people"></i> Customer
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.reports.index') }}" class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                        <i class="bi bi-graph-up"></i> Laporan
                    </a>
                </li>
            </ul>

            <div class="mt-auto">
                <div class="d-flex align-items-center text-white mb-2">
                    <div class="bg-purple rounded-circle d-flex align-items-center justify-content-center me-2" style="width:36px;height:36px;">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <div>
                        <small class="fw-bold">{{ auth()->user()->name }}</small><br>
                        <small class="text-muted">Admin</small>
                    </div>
                </div>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm w-100">
                        <i class="bi bi-box-arrow-left"></i> Logout
                    </button>
                </form>
            </div>
        </nav>

        {{-- Main Content --}}
        <div class="main-content flex-grow-1">
            <div class="p-4">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
