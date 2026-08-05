@extends('layouts.admin')

@section('title', 'Detail Pembayaran')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Detail Pembayaran</h4>
    <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="row g-4">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Kode Booking</strong><br>
                        <a href="{{ route('admin.bookings.show', $payment->booking) }}">{{ $payment->booking->booking_code }}</a>
                    </div>
                    <div class="col-md-6">
                        <strong>Tipe</strong><br>
                        {{ $payment->type_label }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Nominal</strong><br>
                        Rp {{ number_format($payment->amount, 0, ',', '.') }}
                    </div>
                    <div class="col-md-6">
                        <strong>Metode</strong><br>
                        {{ $payment->method_label }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Invoice</strong><br>
                        {{ $payment->invoice_number ?? '-' }}
                    </div>
                    <div class="col-md-6">
                        <strong>Status</strong><br>
                        <span class="badge bg-{{ $payment->status == 'verified' ? 'success' : ($payment->status == 'rejected' ? 'danger' : 'warning') }}">
                            {{ ucfirst($payment->status) }}
                        </span>
                    </div>
                </div>

                <div class="mb-3">
                    <strong>Tanggal</strong><br>
                    {{ $payment->created_at->format('d F Y H:i') }}
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        @if($payment->proof_file)
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h6 class="mb-0">Bukti Transfer</h6>
                </div>
                <div class="card-body text-center">
                    @if(str_contains($payment->proof_file, '.pdf'))
                        <a href="{{ Storage::url($payment->proof_file) }}" target="_blank" class="btn btn-outline-primary">
                            <i class="bi bi-file-pdf"></i> Lihat PDF
                        </a>
                    @else
                        <img src="{{ Storage::url($payment->proof_file) }}" class="img-fluid rounded" alt="Bukti Transfer">
                    @endif
                </div>
            </div>
        @endif

        @if($payment->status === 'verified')
            <div class="card shadow-sm mt-3">
                <div class="card-body">
                    <a href="{{ route('admin.payments.receipt', $payment) }}" class="btn btn-success w-100">
                        <i class="bi bi-download"></i> Cetak Kwitansi PDF
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
