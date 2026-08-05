@extends('layouts.app')

@section('title', 'Booking Berhasil')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-body p-4 text-center">
                <div class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width:80px;height:80px;">
                    <i class="bi bi-check-lg" style="font-size:2.5rem;"></i>
                </div>

                <h4 class="mb-3">Booking Berhasil!</h4>
                <p class="text-muted">Data booking Anda telah berhasil dikirim. Silakan simpan kode booking di bawah ini.</p>

                <div class="bg-light p-3 rounded mb-4">
                    <small class="text-muted">Kode Booking Anda</small>
                    <h2 class="text-primary mb-0">{{ $booking->booking_code }}</h2>
                </div>

                <div class="text-start mb-4">
                    <div class="row mb-2">
                        <div class="col-5 text-muted">Nama</div>
                        <div class="col-7"><strong>{{ $booking->customer_name }}</strong></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 text-muted">Paket</div>
                        <div class="col-7">{{ $booking->package->name }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 text-muted">Tanggal Foto</div>
                        <div class="col-7">{{ $booking->booking_date->format('d F Y') }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 text-muted">Status</div>
                        <div class="col-7">
                            <span class="badge bg-warning">Menunggu Verifikasi</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-5 text-muted">DP Dibayar</div>
                        <div class="col-7"><strong>Rp {{ number_format($booking->payments->first()->amount ?? 0, 0, ',', '.') }}</strong></div>
                    </div>
                </div>

                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i>
                    Admin akan memverifikasi booking Anda. Mohon tunggu konfirmasi.
                </div>

                <a href="{{ route('booking.form') }}" class="btn btn-primary w-100">
                    <i class="bi bi-plus-circle"></i> Booking Lagi
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
