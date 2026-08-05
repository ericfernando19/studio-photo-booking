@extends('layouts.admin')

@section('title', 'Kwitansi')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Kwitansi Pembayaran</h4>
    <a href="{{ route('admin.payments.show', $payment) }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-6">
                <h5>Studio Foto Booking</h5>
                <p class="mb-0">Jl. Contoh Alamat No. 123</p>
                <p class="mb-0">Telp: 08123456789</p>
            </div>
            <div class="col-6 text-end">
                <h5>Kwitansi</h5>
                <p class="mb-0">No: {{ $payment->invoice_number ?? 'N/A' }}</p>
                <p class="mb-0">Tanggal: {{ $payment->created_at->format('d/m/Y') }}</p>
            </div>
        </div>

        <hr>

        <div class="row mb-3">
            <div class="col-md-6">
                <strong>Terima dari:</strong><br>
                {{ $payment->booking->customer_name }}
            </div>
            <div class="col-md-6">
                <strong>No. HP:</strong><br>
                {{ $payment->booking->customer_phone }}
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <strong>Kode Booking:</strong><br>
                {{ $payment->booking->booking_code }}
            </div>
            <div class="col-md-6">
                <strong>Tipe Pembayaran:</strong><br>
                {{ $payment->type_label }}
            </div>
        </div>

        <hr>

        <div class="text-center mb-4">
            <h3 class="text-success">Rp {{ number_format($payment->amount, 0, ',', '.') }}</h3>
            <p>{{ $payment->amount_in_words ?? '' }}</p>
        </div>

        <div class="row">
            <div class="col-md-6">
                <strong>Metode Pembayaran:</strong><br>
                {{ $payment->method_label }}
            </div>
            <div class="col-md-6">
                <strong>Status:</strong><br>
                <span class="badge bg-success">Lunas</span>
            </div>
        </div>

        <hr>

        <div class="row mt-4">
            <div class="col-6 text-center">
                <p>Penerima</p>
                <div style="border-top: 1px solid #000; width: 150px; margin: 40px auto 0;"></div>
            </div>
            <div class="col-6 text-center">
                <p>Admin</p>
                <div style="border-top: 1px solid #000; width: 150px; margin: 40px auto 0;"></div>
            </div>
        </div>
    </div>
</div>
@endsection
