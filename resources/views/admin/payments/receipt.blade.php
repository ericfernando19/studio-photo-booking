@extends('layouts.admin')

@section('title', 'Kwitansi')

@section('content')
<div class="page-header">
    <div></div>
    <a href="{{ route('admin.payments.show', $payment) }}" class="btn btn-admin" style="background:#F1F5F9;border:none;color:#64748B;">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="card-admin">
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-6">
                <div class="d-flex align-items-center gap-2 mb-2">
                    @if($studioSettings['logo'])
                        <img src="{{ Storage::url($studioSettings['logo']) }}" style="height:40px;border-radius:6px;" alt="Logo">
                    @endif
                    <h5 class="mb-0" style="font-weight:600;">{{ $studioSettings['name'] }}</h5>
                </div>
                @if($studioSettings['address'])
                    <p class="mb-0" style="color:#64748B;">{{ $studioSettings['address'] }}</p>
                @endif
                @if($studioSettings['phone'])
                    <p class="mb-0" style="color:#64748B;">Telp: {{ $studioSettings['phone'] }}</p>
                @endif
            </div>
            <div class="col-6 text-end">
                <h5 style="font-weight:600;">Kwitansi</h5>
                <p class="mb-0" style="color:#64748B;">No: {{ $payment->invoice_number ?? 'N/A' }}</p>
                <p class="mb-0" style="color:#64748B;">Tanggal: {{ $payment->created_at->format('d/m/Y') }}</p>
            </div>
        </div>

        <hr style="border-color:#E2E8F0;">

        <div class="row mb-3">
            <div class="col-md-6">
                <div style="font-size:0.75rem;font-weight:600;color:#64748B;text-transform:uppercase;letter-spacing:0.03em;margin-bottom:0.25rem;">Terima dari</div>
                <div style="font-weight:500;">{{ $payment->booking->customer_name }}</div>
            </div>
            <div class="col-md-6">
                <div style="font-size:0.75rem;font-weight:600;color:#64748B;text-transform:uppercase;letter-spacing:0.03em;margin-bottom:0.25rem;">No. HP</div>
                <div style="font-weight:500;">{{ $payment->booking->customer_phone }}</div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <div style="font-size:0.75rem;font-weight:600;color:#64748B;text-transform:uppercase;letter-spacing:0.03em;margin-bottom:0.25rem;">Kode Booking</div>
                <div style="font-family:'JetBrains Mono',monospace;font-weight:500;">{{ $payment->booking->booking_code }}</div>
            </div>
            <div class="col-md-6">
                <div style="font-size:0.75rem;font-weight:600;color:#64748B;text-transform:uppercase;letter-spacing:0.03em;margin-bottom:0.25rem;">Tipe Pembayaran</div>
                <div style="font-weight:500;">{{ $payment->type_label }}</div>
            </div>
        </div>

        <hr style="border-color:#E2E8F0;">

        <div class="text-center mb-4">
            <h3 style="font-family:'JetBrains Mono',monospace;font-weight:700;color:#059669;">Rp {{ number_format($payment->amount, 0, ',', '.') }}</h3>
            <p style="color:#64748B;">{{ $payment->amount_in_words ?? '' }}</p>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div style="font-size:0.75rem;font-weight:600;color:#64748B;text-transform:uppercase;letter-spacing:0.03em;margin-bottom:0.25rem;">Metode Pembayaran</div>
                <div style="font-weight:500;">{{ $payment->method_label }}</div>
            </div>
            <div class="col-md-6">
                <div style="font-size:0.75rem;font-weight:600;color:#64748B;text-transform:uppercase;letter-spacing:0.03em;margin-bottom:0.25rem;">Status</div>
                <span class="badge-status" style="background:#ECFDF5;color:#059669;">Lunas</span>
            </div>
        </div>

        <hr style="border-color:#E2E8F0;">

        <div class="row mt-4">
            <div class="col-6 text-center">
                <p style="color:#64748B;">Penerima</p>
                <div style="border-top: 1px solid #1E293B; width: 150px; margin: 40px auto 0;"></div>
            </div>
            <div class="col-6 text-center">
                <p style="color:#64748B;">Admin</p>
                <div style="border-top: 1px solid #1E293B; width: 150px; margin: 40px auto 0;"></div>
            </div>
        </div>
    </div>
</div>
@endsection
