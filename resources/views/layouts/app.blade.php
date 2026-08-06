<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', $studioSettings['name'])</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; color: #0F172A; -webkit-font-smoothing: antialiased; }
        .bg-purple { background-color: #6f42c1; }

        /* ===== NAVBAR ===== */
        .site-navbar {
            background: #fff;
            border-bottom: 1px solid #E2E8F0;
            padding: 0.75rem 0;
            position: sticky;
            top: 0;
            z-index: 1020;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        }

        .navbar-inner {
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .navbar-brand-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
        }

        .navbar-logo {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            overflow: hidden;
            border: 2px solid #E2E8F0;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #EEF2FF;
            color: #4F46E5;
            font-size: 1rem;
        }

        .navbar-logo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .navbar-text {
            display: flex;
            flex-direction: column;
        }

        .navbar-name {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 1rem;
            color: #0F172A;
            line-height: 1.2;
        }

        .navbar-tagline {
            font-size: 0.75rem;
            color: #64748B;
            line-height: 1.2;
        }

        .navbar-cta {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1.25rem;
            background: linear-gradient(135deg, #4F46E5, #7C3AED);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 0.8125rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s;
            box-shadow: 0 2px 8px rgba(79,70,229,0.25);
        }

        .navbar-cta:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(79,70,229,0.35);
            color: #fff;
        }

        @media (max-width: 576px) {
            .navbar-tagline { display: none; }
            .navbar-cta span { display: none; }
            .navbar-cta { padding: 0.5rem 0.75rem; }
        }

        /* ===== FOOTER ===== */
        .site-footer {
            background: #0F172A;
            color: #CBD5E1;
            padding: 3rem 0 0;
            margin-top: 4rem;
        }

        .footer-inner {
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .footer-top {
            display: grid;
            grid-template-columns: 1.5fr 1fr 1fr;
            gap: 2rem;
            padding-bottom: 2rem;
            border-bottom: 1px solid #1E293B;
        }

        .footer-brand {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .footer-brand-row {
            display: flex;
            align-items: center;
            gap: 0.625rem;
        }

        .footer-logo {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            overflow: hidden;
            border: 2px solid #334155;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #1E293B;
            color: #818CF8;
            font-size: 0.875rem;
        }

        .footer-logo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .footer-brand-name {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 1rem;
            color: #F1F5F9;
        }

        .footer-brand-desc {
            font-size: 0.8125rem;
            color: #94A3B8;
            line-height: 1.6;
            max-width: 320px;
        }

        .footer-col-title {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 0.8125rem;
            color: #F1F5F9;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 1rem;
        }

        .footer-contact-item {
            display: flex;
            align-items: flex-start;
            gap: 0.625rem;
            margin-bottom: 0.75rem;
            font-size: 0.8125rem;
        }

        .footer-contact-item i {
            color: #818CF8;
            margin-top: 0.125rem;
            font-size: 0.875rem;
            flex-shrink: 0;
        }

        .footer-contact-item a {
            color: #CBD5E1;
            text-decoration: none;
            transition: color 0.2s;
        }

        .footer-contact-item a:hover {
            color: #fff;
        }

        .footer-bottom {
            padding: 1.25rem 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.75rem;
            color: #64748B;
        }

        .footer-bottom a {
            color: #94A3B8;
            text-decoration: none;
            transition: color 0.2s;
        }

        .footer-bottom a:hover {
            color: #fff;
        }

        @media (max-width: 768px) {
            .footer-top {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }
            .footer-bottom {
                flex-direction: column;
                gap: 0.5rem;
                text-align: center;
            }
        }
    </style>
    @stack('styles')
</head>
<body style="background:#F1F5F9;">

    {{-- Navbar --}}
    <nav class="site-navbar">
        <div class="navbar-inner">
            <a class="navbar-brand-link" href="{{ route('booking.form') }}">
                <div class="navbar-logo">
                    @if($studioSettings['logo'])
                        <img src="{{ Storage::url($studioSettings['logo']) }}" alt="Logo">
                    @else
                        <i class="bi bi-camera"></i>
                    @endif
                </div>
                <div class="navbar-text">
                    <span class="navbar-name">{{ $studioSettings['name'] }}</span>
                    <span class="navbar-tagline">Studio Foto Profesional</span>
                </div>
            </a>
            <a href="{{ route('booking.form') }}" class="navbar-cta">
                <i class="bi bi-calendar-plus"></i>
                <span>Booking Sekarang</span>
            </a>
        </div>
    </nav>

    {{-- Flash Messages --}}
    <div style="max-width:1100px;margin:0 auto;padding:1rem 1rem 0;">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius:12px;border:none;background:#ECFDF5;color:#065F46;">
                <i class="bi bi-check-circle-fill me-1"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" style="color:#065F46;"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius:12px;border:none;background:#FEF2F2;color:#991B1B;">
                <i class="bi bi-exclamation-circle-fill me-1"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" style="color:#991B1B;"></button>
            </div>
        @endif
    </div>

    @yield('content')

    {{-- Footer --}}
    <footer class="site-footer">
        <div class="footer-inner">
            <div class="footer-top">
                <div class="footer-brand">
                    <div class="footer-brand-row">
                        <div class="footer-logo">
                            @if($studioSettings['logo'])
                                <img src="{{ Storage::url($studioSettings['logo']) }}" alt="Logo">
                            @else
                                <i class="bi bi-camera"></i>
                            @endif
                        </div>
                        <span class="footer-brand-name">{{ $studioSettings['name'] }}</span>
                    </div>
                    <p class="footer-brand-desc">Mengabadikan momen berharga Anda dengan hasil foto terbaik dan pelayanan profesional.</p>
                </div>

                <div>
                    <div class="footer-col-title">Kontak</div>
                    @if($studioSettings['address'])
                        <div class="footer-contact-item">
                            <i class="bi bi-geo-alt"></i>
                            <span>{{ $studioSettings['address'] }}</span>
                        </div>
                    @endif
                    @if($studioSettings['phone'])
                        <div class="footer-contact-item">
                            <i class="bi bi-telephone"></i>
                            <a href="tel:{{ $studioSettings['phone'] }}">{{ $studioSettings['phone'] }}</a>
                        </div>
                    @endif
                    @if($studioSettings['email'])
                        <div class="footer-contact-item">
                            <i class="bi bi-envelope"></i>
                            <a href="mailto:{{ $studioSettings['email'] }}">{{ $studioSettings['email'] }}</a>
                        </div>
                    @endif
                </div>

                <div>
                    <div class="footer-col-title">Jam Operasional</div>
                    <div class="footer-contact-item">
                        <i class="bi bi-clock"></i>
                        <span>Senin — Sabtu</span>
                    </div>
                    <div class="footer-contact-item">
                        <i class="bi bi-clock-history"></i>
                        <span>09:00 — 17:00 WIB</span>
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <span>&copy; {{ date('Y') }} {{ $studioSettings['name'] }}. Hak cipta dilindungi.</span>
                <span>Dibuat dengan <i class="bi bi-heart-fill" style="color:#EF4444;font-size:0.625rem;"></i> untuk Anda</span>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
