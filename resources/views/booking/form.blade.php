@extends('layouts.app')

@section('title', 'Form Booking')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">
<style>
    *, *::before, *::after { box-sizing: border-box; }

    body {
        font-family: 'Inter', sans-serif;
        background: #F1F5F9;
        color: #0F172A;
        -webkit-font-smoothing: antialiased;
    }

    /* ===== PAGE WRAPPER ===== */
    .booking-page {
        min-height: calc(100vh - 140px);
        padding: 2rem 0 3rem;
    }

    /* ===== HEADER ===== */
    .booking-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .booking-logo {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        overflow: hidden;
        border: 3px solid #E2E8F0;
        margin: 0 auto 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fff;
        box-shadow: 0 4px 16px rgba(0,0,0,0.06);
    }

    .booking-logo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .booking-logo .logo-placeholder {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 1.75rem;
    }

    .booking-header h1 {
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        font-size: 1.625rem;
        color: #0F172A;
        margin-bottom: 0.375rem;
        letter-spacing: -0.01em;
    }

    .booking-header p {
        color: #64748B;
        font-size: 0.9375rem;
        max-width: 420px;
        margin: 0 auto;
        line-height: 1.5;
    }

    /* ===== STEP INDICATOR ===== */
    .step-indicator {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0;
        margin-bottom: 2rem;
        padding: 0 1rem;
    }

    .step-dot {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: #E2E8F0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        font-weight: 600;
        color: #94A3B8;
        position: relative;
        z-index: 1;
        transition: all 0.3s ease;
    }

    .step-dot.active {
        background: linear-gradient(135deg, #4F46E5, #7C3AED);
        color: #fff;
        box-shadow: 0 2px 10px rgba(79,70,229,0.35);
    }

    .step-dot .step-icon {
        font-size: 0.875rem;
    }

    .step-line {
        width: 60px;
        height: 2px;
        background: #E2E8F0;
        position: relative;
        top: 0;
    }

    .step-line.active {
        background: linear-gradient(90deg, #4F46E5, #7C3AED);
    }

    .step-label {
        position: absolute;
        top: calc(100% + 6px);
        left: 50%;
        transform: translateX(-50%);
        font-size: 0.6875rem;
        font-weight: 500;
        color: #94A3B8;
        white-space: nowrap;
    }

    .step-dot.active .step-label {
        color: #4F46E5;
    }

    /* ===== FORM CARD ===== */
    .booking-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid #E2E8F0;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 4px 16px rgba(0,0,0,0.02);
        overflow: hidden;
    }

    .booking-card-body {
        padding: 2rem;
    }

    /* ===== SECTION ===== */
    .form-section {
        margin-bottom: 2rem;
        padding-bottom: 2rem;
        border-bottom: 1px solid #F1F5F9;
    }

    .form-section:last-of-type {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }

    .form-section-header {
        display: flex;
        align-items: center;
        gap: 0.625rem;
        margin-bottom: 1.25rem;
    }

    .form-section-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.875rem;
        flex-shrink: 0;
    }

    .form-section-icon.indigo {
        background: #EEF2FF;
        color: #4F46E5;
    }

    .form-section-icon.violet {
        background: #F5F3FF;
        color: #7C3AED;
    }

    .form-section-icon.amber {
        background: #FFFBEB;
        color: #D97706;
    }

    .form-section-title {
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        font-size: 0.9375rem;
        color: #0F172A;
    }

    /* ===== FLOATING INPUT ===== */
    .float-group {
        position: relative;
        margin-bottom: 1rem;
    }

    .float-group input,
    .float-group textarea {
        width: 100%;
        padding: 0.875rem 1rem 0.5rem 2.75rem;
        border: 1.5px solid #E2E8F0;
        border-radius: 10px;
        font-size: 0.9375rem;
        color: #0F172A;
        background: #fff;
        transition: border-color 0.2s, box-shadow 0.2s;
        outline: none;
        font-family: 'Inter', sans-serif;
    }

    /* Select — no floating label, regular padding */
    .float-group select {
        width: 100%;
        padding: 0.625rem 2.5rem 0.625rem 2.75rem;
        border: 1.5px solid #E2E8F0;
        border-radius: 10px;
        font-size: 0.9375rem;
        color: #0F172A;
        background: #fff;
        transition: border-color 0.2s, box-shadow 0.2s;
        outline: none;
        font-family: 'Inter', sans-serif;
        appearance: none;
        -webkit-appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%2364748B' viewBox='0 0 16 16'%3E%3Cpath d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
    }

    .float-group select option[value=""][disabled] {
        color: #94A3B8;
    }

    .float-group input:focus,
    .float-group textarea:focus {
        border-color: #4F46E5;
        box-shadow: 0 0 0 3px rgba(79,70,229,0.1);
    }

    .float-group select:focus {
        border-color: #4F46E5;
        box-shadow: 0 0 0 3px rgba(79,70,229,0.1);
    }

    .float-group.is-invalid input,
    .float-group.is-invalid select,
    .float-group.is-invalid textarea {
        border-color: #DC2626;
    }

    .float-group.is-invalid input:focus,
    .float-group.is-invalid select:focus,
    .float-group.is-invalid textarea:focus {
        box-shadow: 0 0 0 3px rgba(220,38,38,0.1);
    }

    .float-group .input-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #94A3B8;
        font-size: 1rem;
        pointer-events: none;
        transition: color 0.2s;
        z-index: 2;
    }

    .float-group input:focus ~ .input-icon,
    .float-group select:focus ~ .input-icon,
    .float-group textarea:focus ~ .input-icon {
        color: #4F46E5;
    }

    .float-group .float-label {
        position: absolute;
        left: 2.75rem;
        top: 50%;
        transform: translateY(-50%);
        color: #94A3B8;
        font-size: 0.9375rem;
        pointer-events: none;
        transition: all 0.2s ease;
        background: #fff;
        padding: 0 0.25rem;
    }

    .float-group input:focus ~ .float-label,
    .float-group input:not(:placeholder-shown) ~ .float-label,
    .float-group textarea:focus ~ .float-label,
    .float-group textarea:not(:placeholder-shown) ~ .float-label {
        top: 0;
        left: 2rem;
        font-size: 0.75rem;
        font-weight: 500;
        color: #4F46E5;
    }

    /* Select label — always above the input */
    .float-group select ~ .float-label {
        top: 0;
        left: 2rem;
        font-size: 0.75rem;
        font-weight: 500;
        color: #64748B;
    }

    .float-group textarea ~ .float-label {
        top: 1rem;
        transform: none;
    }

    .float-group textarea:focus ~ .float-label,
    .float-group textarea:not(:placeholder-shown) ~ .float-label {
        top: -0.375rem;
    }

    .field-error {
        display: flex;
        align-items: center;
        gap: 0.375rem;
        margin-top: 0.375rem;
        font-size: 0.8125rem;
        color: #DC2626;
    }

    .field-error i {
        font-size: 0.875rem;
    }

    /* ===== TRANSFER INFO ===== */
    .transfer-info {
        background: linear-gradient(135deg, #EEF2FF 0%, #F5F3FF 100%);
        border: 1px solid #C7D2FE;
        border-radius: 12px;
        padding: 1rem 1.25rem;
        margin-bottom: 1rem;
        display: none;
    }

    .transfer-info.show { display: block; }

    .transfer-info .transfer-row {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .transfer-info .transfer-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: #4F46E5;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        flex-shrink: 0;
    }

    .transfer-info .transfer-label {
        font-size: 0.8125rem;
        color: #64748B;
    }

    .transfer-info .transfer-amount {
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        font-size: 1.125rem;
        color: #4F46E5;
    }

    .transfer-info .transfer-bank {
        margin-top: 0.75rem;
        padding-top: 0.75rem;
        border-top: 1px solid #C7D2FE;
        font-size: 0.8125rem;
        color: #475569;
    }

    .transfer-info .transfer-bank strong {
        color: #0F172A;
    }

    /* ===== UPLOAD ZONE ===== */
    .upload-zone {
        border: 2px dashed #CBD5E1;
        border-radius: 12px;
        padding: 2rem 1.5rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s;
        background: #F8FAFC;
        position: relative;
    }

    .upload-zone:hover {
        border-color: #4F46E5;
        background: #EEF2FF;
    }

    .upload-zone.dragover {
        border-color: #4F46E5;
        background: #EEF2FF;
        box-shadow: 0 0 0 3px rgba(79,70,229,0.1);
    }

    .upload-zone.has-file {
        border-color: #059669;
        background: #ECFDF5;
        border-style: solid;
    }

    .upload-zone .upload-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: #E2E8F0;
        color: #64748B;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        margin-bottom: 0.75rem;
        transition: all 0.2s;
    }

    .upload-zone:hover .upload-icon {
        background: #4F46E5;
        color: #fff;
    }

    .upload-zone.has-file .upload-icon {
        background: #059669;
        color: #fff;
    }

    .upload-zone .upload-text {
        font-size: 0.875rem;
        color: #64748B;
        margin-bottom: 0.25rem;
    }

    .upload-zone .upload-text strong {
        color: #4F46E5;
    }

    .upload-zone .upload-hint {
        font-size: 0.75rem;
        color: #94A3B8;
    }

    .upload-zone .upload-filename {
        font-size: 0.875rem;
        font-weight: 500;
        color: #059669;
        margin-top: 0.5rem;
        display: none;
    }

    .upload-zone.has-file .upload-filename {
        display: block;
    }

    .upload-zone.has-file .upload-text,
    .upload-zone.has-file .upload-hint {
        display: none;
    }

    .upload-zone input[type="file"] {
        position: absolute;
        inset: 0;
        opacity: 0;
        cursor: pointer;
    }

    /* ===== BOOKING SUMMARY ===== */
    .booking-summary {
        background: #F8FAFC;
        border: 1px solid #E2E8F0;
        border-radius: 12px;
        padding: 1.25rem;
        margin-top: 1.5rem;
    }

    .summary-title {
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        font-size: 0.875rem;
        color: #0F172A;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #E2E8F0;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.5rem 0;
    }

    .summary-row + .summary-row {
        border-top: 1px solid #F1F5F9;
    }

    .summary-label {
        font-size: 0.8125rem;
        color: #64748B;
    }

    .summary-value {
        font-size: 0.875rem;
        font-weight: 500;
        color: #0F172A;
        text-align: right;
    }

    .summary-value.price {
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        color: #4F46E5;
    }

    .summary-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        background: #FEF3C7;
        color: #92400E;
        font-size: 0.75rem;
        font-weight: 500;
        padding: 0.25rem 0.625rem;
        border-radius: 6px;
    }

    /* ===== SUBMIT BUTTON ===== */
    .submit-section {
        margin-top: 1.5rem;
    }

    .btn-submit {
        width: 100%;
        padding: 1rem;
        background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
        color: #fff;
        border: none;
        border-radius: 12px;
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        transition: all 0.2s;
        box-shadow: 0 4px 14px rgba(79,70,229,0.3);
        position: relative;
        overflow: hidden;
    }

    .btn-submit:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(79,70,229,0.4);
    }

    .btn-submit:active {
        transform: translateY(0);
    }

    .btn-submit:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }

    .btn-submit .spinner {
        display: none;
        width: 20px;
        height: 20px;
        border: 2px solid rgba(255,255,255,0.3);
        border-top-color: #fff;
        border-radius: 50%;
        animation: spin 0.6s linear infinite;
    }

    .btn-submit.loading .spinner { display: block; }
    .btn-submit.loading .btn-text { display: none; }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    /* ===== GLOBAL ALERT ===== */
    .booking-alert {
        background: #FEF2F2;
        border: 1px solid #FECACA;
        border-radius: 12px;
        padding: 1rem 1.25rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
    }

    .booking-alert .alert-icon {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background: #DC2626;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        flex-shrink: 0;
        margin-top: 0.125rem;
    }

    .booking-alert .alert-body {
        flex: 1;
    }

    .booking-alert .alert-title {
        font-weight: 600;
        font-size: 0.875rem;
        color: #991B1B;
        margin-bottom: 0.25rem;
    }

    .booking-alert .alert-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .booking-alert .alert-list li {
        font-size: 0.8125rem;
        color: #B91C1C;
        padding: 0.125rem 0;
    }

    /* ===== GRID ===== */
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    /* ===== ANIMATIONS ===== */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(12px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .booking-header { animation: fadeInUp 0.4s ease both; }
    .step-indicator { animation: fadeInUp 0.4s ease 0.1s both; }
    .booking-card { animation: fadeInUp 0.4s ease 0.2s both; }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .booking-page { padding: 1.25rem 0 2rem; }
        .booking-header h1 { font-size: 1.375rem; }
        .booking-card-body { padding: 1.25rem; }
        .form-row { grid-template-columns: 1fr; }
        .step-line { width: 32px; }
        .step-dot { width: 32px; height: 32px; font-size: 0.6875rem; }
        .step-label { display: none; }
    }

    @media (max-width: 480px) {
        .booking-card-body { padding: 1rem; }
        .form-section { margin-bottom: 1.5rem; padding-bottom: 1.5rem; }
    }

    /* ===== FOCUS VISIBLE ===== */
    :focus-visible {
        outline: 2px solid #4F46E5;
        outline-offset: 2px;
    }

    input:focus-visible,
    select:focus-visible,
    textarea:focus-visible {
        outline: none;
    }

    /* ===== REDUCED MOTION ===== */
    @media (prefers-reduced-motion: reduce) {
        *, *::before, *::after {
            animation-duration: 0.01ms !important;
            transition-duration: 0.01ms !important;
        }
    }
</style>
@endpush

@section('content')
<div class="booking-page">
    <div style="max-width:720px;margin:0 auto;padding:0 1rem;">

        {{-- Header --}}
        <div class="booking-header">
            <div class="booking-logo">
                @if($studioSettings['logo'])
                    <img src="{{ Storage::url($studioSettings['logo']) }}" alt="{{ $studioSettings['name'] }}">
                @else
                    <div class="logo-placeholder"><i class="bi bi-camera"></i></div>
                @endif
            </div>
            <h1>Form Booking Studio Foto</h1>
            <p>Lengkapi data di bawah untuk melakukan reservasi sesi foto Anda.</p>
        </div>

        {{-- Step Indicator --}}
        <div class="step-indicator">
            <div class="step-dot active" id="step1">
                <i class="bi bi-person step-icon"></i>
                <span class="step-label">Data Diri</span>
            </div>
            <div class="step-line" id="line1"></div>
            <div class="step-dot" id="step2">
                <i class="bi bi-image step-icon"></i>
                <span class="step-label">Paket & Jadwal</span>
            </div>
            <div class="step-line" id="line2"></div>
            <div class="step-dot" id="step3">
                <i class="bi bi-credit-card step-icon"></i>
                <span class="step-label">Pembayaran</span>
            </div>
        </div>

        {{-- Error Alert --}}
        @if ($errors->any())
            <div class="booking-alert">
                <div class="alert-icon"><i class="bi bi-exclamation"></i></div>
                <div class="alert-body">
                    <div class="alert-title">Terdapat kesalahan pada form</div>
                    <ul class="alert-list">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        {{-- Form Card --}}
        <div class="booking-card">
            <div class="booking-card-body">
                <form method="POST" action="{{ route('booking.store') }}" enctype="multipart/form-data" id="bookingForm">
                    @csrf

                    {{-- Section: Data Diri --}}
                    <div class="form-section" id="section1">
                        <div class="form-section-header">
                            <div class="form-section-icon indigo">
                                <i class="bi bi-person"></i>
                            </div>
                            <div class="form-section-title">Data Diri</div>
                        </div>

                        <div class="form-row">
                            <div class="float-group @error('customer_name') is-invalid @enderror">
                                <input type="text" id="customer_name" name="customer_name" value="{{ old('customer_name') }}" placeholder=" " required>
                                <label class="float-label" for="customer_name">Nama Lengkap</label>
                                <i class="bi bi-person input-icon"></i>
                                @error('customer_name')
                                    <div class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>

                            <div class="float-group @error('customer_phone') is-invalid @enderror">
                                <input type="text" id="customer_phone" name="customer_phone" value="{{ old('customer_phone') }}" placeholder=" " required>
                                <label class="float-label" for="customer_phone">Nomor HP</label>
                                <i class="bi bi-phone input-icon"></i>
                                @error('customer_phone')
                                    <div class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Section: Paket & Jadwal --}}
                    <div class="form-section" id="section2">
                        <div class="form-section-header">
                            <div class="form-section-icon violet">
                                <i class="bi bi-image"></i>
                            </div>
                            <div class="form-section-title">Paket & Jadwal</div>
                        </div>

                        <div class="form-row">
                            <div class="float-group @error('package_id') is-invalid @enderror">
                                <select id="package_id" name="package_id" required>
                                    <option value="" disabled selected>Pilih paket foto</option>
                                    @foreach ($packages as $package)
                                        <option value="{{ $package->id }}" data-price="{{ $package->price }}" data-dp="{{ $package->min_dp }}" data-graduation="{{ $package->is_graduation ? '1' : '0' }}" {{ old('package_id') == $package->id ? 'selected' : '' }}>
                                            {{ $package->name }}{{ $package->is_graduation ? ' (Wisuda)' : '' }} — Rp {{ number_format($package->price, 0, ',', '.') }}
                                        </option>
                                    @endforeach
                                </select>
                                <label class="float-label" for="package_id">Pilih Paket</label>
                                <i class="bi bi-box-seam input-icon"></i>
                                @error('package_id')
                                    <div class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>

                            <div class="float-group @error('booking_date') is-invalid @enderror">
                                <input type="date" id="booking_date" name="booking_date" value="{{ old('booking_date') }}" required>
                                <label class="float-label" for="booking_date">Tanggal Foto</label>
                                <i class="bi bi-calendar3 input-icon"></i>
                                @error('booking_date')
                                    <div class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div id="university-field" style="display: none;">
                            <div class="float-group @error('university_name') is-invalid @enderror">
                                <input type="text" id="university_name" name="university_name" value="{{ old('university_name') }}" placeholder=" ">
                                <label class="float-label" for="university_name">Nama Universitas / Sekolah</label>
                                <i class="bi bi-building input-icon"></i>
                                @error('university_name')
                                    <div class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Section: Pembayaran DP --}}
                    <div class="form-section" id="section3">
                        <div class="form-section-header">
                            <div class="form-section-icon amber">
                                <i class="bi bi-credit-card"></i>
                            </div>
                            <div class="form-section-title">Pembayaran DP</div>
                        </div>

                        <div id="dp-info" class="transfer-info">
                            <div class="transfer-row">
                                <div class="transfer-icon"><i class="bi bi-bank"></i></div>
                                <div>
                                    <div class="transfer-label">Transfer ke rekening</div>
                                    <div class="transfer-amount" id="dp-amount">Rp 0</div>
                                </div>
                            </div>
                            <div class="transfer-bank">
                                <strong>BCA</strong> — 1234567890 a.n. {{ $studioSettings['name'] }}
                            </div>
                        </div>

                        <div class="float-group @error('dp_amount') is-invalid @enderror">
                            <input type="number" id="dp_amount" name="dp_amount" value="{{ old('dp_amount') }}" min="100000" placeholder=" " required>
                            <label class="float-label" for="dp_amount">Jumlah DP yang Dibayarkan</label>
                            <i class="bi bi-cash input-icon"></i>
                            @error('dp_amount')
                                <div class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        <div class="float-group @error('dp_proof') is-invalid @enderror" style="margin-bottom:0;">
                            <div class="upload-zone" id="uploadZone">
                                <input type="file" id="dp_proof" name="dp_proof" accept="image/jpeg,image/png,image/jpg,application/pdf" required>
                                <div class="upload-icon"><i class="bi bi-cloud-arrow-up"></i></div>
                                <div class="upload-text"><strong>Klik untuk upload</strong> atau seret file ke sini</div>
                                <div class="upload-hint">JPG, PNG, PDF — Maks. 5MB</div>
                                <div class="upload-filename" id="uploadFilename"></div>
                            </div>
                            @error('dp_proof')
                                <div class="field-error" style="margin-top:0.5rem;"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Booking Summary --}}
                    <div class="booking-summary" id="bookingSummary">
                        <div class="summary-title">
                            <i class="bi bi-receipt"></i> Ringkasan Booking
                        </div>
                        <div class="summary-row">
                            <span class="summary-label">Paket</span>
                            <span class="summary-value" id="summaryPackage">—</span>
                        </div>
                        <div class="summary-row">
                            <span class="summary-label">Tanggal</span>
                            <span class="summary-value" id="summaryDate">—</span>
                        </div>
                        <div class="summary-row">
                            <span class="summary-label">Harga Paket</span>
                            <span class="summary-value price" id="summaryPrice">—</span>
                        </div>
                        <div class="summary-row">
                            <span class="summary-label">Status</span>
                            <span class="summary-badge"><i class="bi bi-clock"></i> Menunggu Verifikasi</span>
                        </div>
                    </div>

                    {{-- Submit --}}
                    <div class="submit-section">
                        <button type="submit" class="btn-submit" id="submitBtn">
                            <span class="btn-text"><i class="bi bi-send"></i> Kirim Booking</span>
                            <span class="spinner"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var packageSelect = document.getElementById('package_id');
    var universityField = document.getElementById('university-field');
    var dpInfo = document.getElementById('dp-info');
    var dpAmount = document.getElementById('dp-amount');
    var bookingDate = document.getElementById('booking_date');
    var uploadZone = document.getElementById('uploadZone');
    var uploadInput = document.getElementById('dp_proof');
    var uploadFilename = document.getElementById('uploadFilename');
    var submitBtn = document.getElementById('submitBtn');
    var summaryPackage = document.getElementById('summaryPackage');
    var summaryDate = document.getElementById('summaryDate');
    var summaryPrice = document.getElementById('summaryPrice');

    // Set min date (besok)
    var tomorrow = new Date();
    tomorrow.setDate(tomorrow.getDate() + 1);
    var minDate = tomorrow.getFullYear() + '-' +
        String(tomorrow.getMonth() + 1).padStart(2, '0') + '-' +
        String(tomorrow.getDate()).padStart(2, '0');
    bookingDate.setAttribute('min', minDate);

    // Package change
    packageSelect.addEventListener('change', function() {
        var opt = this.options[this.selectedIndex];
        if (!opt || !opt.value) {
            universityField.style.display = 'none';
            dpInfo.classList.remove('show');
            summaryPackage.textContent = '—';
            summaryPrice.textContent = '—';
            return;
        }

        var isGrad = opt.getAttribute('data-graduation');
        var dp = opt.getAttribute('data-dp');
        var price = opt.getAttribute('data-price');

        universityField.style.display = isGrad === '1' ? 'block' : 'none';
        dpInfo.classList.add('show');
        dpAmount.textContent = 'Rp ' + parseInt(dp || 0).toLocaleString('id-ID');

        summaryPackage.textContent = opt.textContent.split('—')[0].trim();
        summaryPrice.textContent = 'Rp ' + parseInt(price || 0).toLocaleString('id-ID');
    });

    // Date change
    bookingDate.addEventListener('change', function() {
        if (this.value) {
            var d = new Date(this.value);
            var days = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
            var months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
            summaryDate.textContent = days[d.getDay()] + ', ' + d.getDate() + ' ' + months[d.getMonth()] + ' ' + d.getFullYear();
        }
    });

    // Upload zone
    uploadInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            var file = this.files[0];
            if (file.size > 5 * 1024 * 1024) {
                alert('Ukuran file maksimal 5MB');
                this.value = '';
                return;
            }
            uploadZone.classList.add('has-file');
            uploadFilename.textContent = file.name;
        }
    });

    // Drag & drop
    uploadZone.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.classList.add('dragover');
    });
    uploadZone.addEventListener('dragleave', function() {
        this.classList.remove('dragover');
    });
    uploadZone.addEventListener('drop', function(e) {
        e.preventDefault();
        this.classList.remove('dragover');
        if (e.dataTransfer.files.length) {
            uploadInput.files = e.dataTransfer.files;
            uploadInput.dispatchEvent(new Event('change'));
        }
    });

    // Submit loading
    document.getElementById('bookingForm').addEventListener('submit', function() {
        submitBtn.classList.add('loading');
        submitBtn.disabled = true;
    });

    // Step indicator scroll tracking
    var sections = [
        document.getElementById('section1'),
        document.getElementById('section2'),
        document.getElementById('section3')
    ];
    var dots = [
        document.getElementById('step1'),
        document.getElementById('step2'),
        document.getElementById('step3')
    ];
    var lines = [
        document.getElementById('line1'),
        document.getElementById('line2')
    ];

    function updateSteps() {
        var scrollPos = window.scrollY + window.innerHeight / 3;
        var activeIdx = 0;

        sections.forEach(function(sec, i) {
            if (sec && sec.offsetTop <= scrollPos) {
                activeIdx = i;
            }
        });

        dots.forEach(function(dot, i) {
            dot.classList.toggle('active', i <= activeIdx);
        });
        lines.forEach(function(line, i) {
            line.classList.toggle('active', i < activeIdx);
        });
    }

    window.addEventListener('scroll', updateSteps, { passive: true });
    updateSteps();
});
</script>
@endpush
