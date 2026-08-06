<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Studio Foto</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; margin: 0; padding: 0; box-sizing: border-box; }

        body {
            min-height: 100vh;
            display: flex;
            background: #F8FAFC;
        }

        .login-left {
            flex: 1;
            background: linear-gradient(135deg, #1E1B4B 0%, #312E81 50%, #4338CA 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 3rem;
            position: relative;
            overflow: hidden;
        }

        .login-left::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(79,70,229,0.15) 0%, transparent 60%);
        }

        .login-brand {
            position: relative;
            z-index: 1;
            text-align: center;
            color: #fff;
        }

        .login-brand-icon {
            width: 80px;
            height: 80px;
            background: rgba(255,255,255,0.1);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin: 0 auto 1.5rem;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.15);
        }

        .login-brand h1 {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .login-brand p {
            font-size: 0.9375rem;
            color: rgba(255,255,255,0.65);
            max-width: 280px;
        }

        .login-features {
            position: relative;
            z-index: 1;
            margin-top: 3rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .login-feature {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: rgba(255,255,255,0.75);
            font-size: 0.875rem;
        }

        .login-feature i {
            width: 32px;
            height: 32px;
            background: rgba(255,255,255,0.1);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.875rem;
        }

        .login-right {
            width: 480px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem;
        }

        .login-form-wrapper {
            width: 100%;
            max-width: 380px;
        }

        .login-form-header {
            margin-bottom: 2rem;
        }

        .login-form-header h2 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1E293B;
            margin-bottom: 0.375rem;
        }

        .login-form-header p {
            color: #64748B;
            font-size: 0.9375rem;
        }

        .form-floating-custom {
            position: relative;
            margin-bottom: 1rem;
        }

        .form-floating-custom label {
            position: absolute;
            top: 50%;
            left: 0.875rem;
            transform: translateY(-50%);
            color: #64748B;
            font-size: 0.875rem;
            pointer-events: none;
            transition: all 0.2s;
            background: #fff;
            padding: 0 0.25rem;
        }

        .form-floating-custom input:focus ~ label,
        .form-floating-custom input:not(:placeholder-shown) ~ label {
            top: 0;
            font-size: 0.75rem;
            color: #4F46E5;
        }

        .form-floating-custom input {
            width: 100%;
            height: 52px;
            border: 1px solid #E2E8F0;
            border-radius: 10px;
            padding: 0 0.875rem;
            font-size: 0.9375rem;
            color: #1E293B;
            background: #fff;
            transition: border-color 0.15s, box-shadow 0.15s;
        }

        .form-floating-custom input:focus {
            outline: none;
            border-color: #4F46E5;
            box-shadow: 0 0 0 3px rgba(79,70,229,0.1);
        }

        .form-floating-custom input.is-invalid {
            border-color: #DC2626;
        }

        .form-floating-custom input.is-invalid:focus {
            box-shadow: 0 0 0 3px rgba(220,38,38,0.1);
        }

        .invalid-feedback-custom {
            color: #DC2626;
            font-size: 0.75rem;
            margin-top: 0.375rem;
            display: block;
        }

        .btn-login {
            width: 100%;
            height: 52px;
            background: #4F46E5;
            border: none;
            border-radius: 10px;
            color: #fff;
            font-size: 0.9375rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.15s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-login:hover {
            background: #4338CA;
        }

        .btn-login:active {
            transform: scale(0.98);
        }

        .login-back {
            display: block;
            text-align: center;
            margin-top: 1.5rem;
            color: #64748B;
            text-decoration: none;
            font-size: 0.875rem;
            transition: color 0.15s;
        }

        .login-back:hover {
            color: #4F46E5;
        }

        .alert-login {
            border: none;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
            margin-bottom: 1.25rem;
        }

        @media (max-width: 991.98px) {
            .login-left { display: none; }
            .login-right { width: 100%; }
        }

        @media (max-width: 575.98px) {
            .login-right { padding: 1.5rem; }
        }
    </style>
</head>
<body>
    <div class="login-left">
        <div class="login-brand">
            <div class="login-brand-icon">
                <i class="bi bi-camera"></i>
            </div>
            <h1>Studio Booking</h1>
            <p>Kelola booking, pembayaran, dan jadwal foto dalam satu platform</p>
        </div>
        <div class="login-features">
            <div class="login-feature">
                <i class="bi bi-calendar-check"></i>
                <span>Kelola jadwal booking harian</span>
            </div>
            <div class="login-feature">
                <i class="bi bi-credit-card"></i>
                <span>Verifikasi pembayaran DP & pelunasan</span>
            </div>
            <div class="login-feature">
                <i class="bi bi-people"></i>
                <span>Pantau data customer & riwayat</span>
            </div>
        </div>
    </div>

    <div class="login-right">
        <div class="login-form-wrapper">
            <div class="login-form-header">
                <h2>Masuk ke Admin</h2>
                <p>Masukkan kredensial Anda untuk melanjutkan</p>
            </div>

            @if(session('error'))
                <div class="alert alert-danger alert-login">
                    <i class="bi bi-exclamation-circle me-1"></i>
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.submit') }}">
                @csrf

                <div class="form-floating-custom">
                    <input type="email" id="email" name="email" placeholder=" " value="{{ old('email') }}" required autofocus class="{{ @error('email') ? 'is-invalid' : '' }}">
                    <label for="email">Alamat Email</label>
                    @error('email')
                        <span class="invalid-feedback-custom">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-floating-custom">
                    <input type="password" id="password" name="password" placeholder=" " required class="{{ @error('password') ? 'is-invalid' : '' }}">
                    <label for="password">Password</label>
                    @error('password')
                        <span class="invalid-feedback-custom">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn-login">
                    <i class="bi bi-box-arrow-in-right"></i>
                    Masuk
                </button>
            </form>

            <a href="{{ route('booking.form') }}" class="login-back">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Beranda
            </a>
        </div>
    </div>
</body>
</html>
