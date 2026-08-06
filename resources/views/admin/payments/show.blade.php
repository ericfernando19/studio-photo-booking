@extends('layouts.admin')

@section('title', 'Detail Pembayaran')

@section('content')
<div class="page-header">
    <div></div>
    <a href="{{ route('admin.payments.index') }}" class="btn btn-admin" style="background:#F1F5F9;border:none;color:#64748B;">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card-admin">
            <div class="card-body">
                <div class="row g-3 mb-3">
                    <div class="col-sm-6">
                        <div style="font-size:0.75rem;font-weight:600;color:#64748B;text-transform:uppercase;letter-spacing:0.03em;margin-bottom:0.375rem;">Kode Booking</div>
                        <a href="{{ route('admin.bookings.show', $payment->booking) }}" style="font-family:'JetBrains Mono',monospace;font-weight:500;color:#4F46E5;text-decoration:none;">{{ $payment->booking->booking_code }}</a>
                    </div>
                    <div class="col-sm-6">
                        <div style="font-size:0.75rem;font-weight:600;color:#64748B;text-transform:uppercase;letter-spacing:0.03em;margin-bottom:0.375rem;">Tipe</div>
                        <div style="font-weight:500;">{{ $payment->type_label }}</div>
                    </div>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-sm-6">
                        <div style="font-size:0.75rem;font-weight:600;color:#64748B;text-transform:uppercase;letter-spacing:0.03em;margin-bottom:0.375rem;">Nominal</div>
                        <div style="font-family:'JetBrains Mono',monospace;font-weight:600;font-size:1.125rem;">Rp {{ number_format($payment->amount, 0, ',', '.') }}</div>
                    </div>
                    <div class="col-sm-6">
                        <div style="font-size:0.75rem;font-weight:600;color:#64748B;text-transform:uppercase;letter-spacing:0.03em;margin-bottom:0.375rem;">Metode</div>
                        <div style="font-weight:500;">{{ $payment->method_label }}</div>
                    </div>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-sm-6">
                        <div style="font-size:0.75rem;font-weight:600;color:#64748B;text-transform:uppercase;letter-spacing:0.03em;margin-bottom:0.375rem;">Invoice</div>
                        <div style="font-weight:500;">{{ $payment->invoice_number ?? '-' }}</div>
                    </div>
                    <div class="col-sm-6">
                        <div style="font-size:0.75rem;font-weight:600;color:#64748B;text-transform:uppercase;letter-spacing:0.03em;margin-bottom:0.375rem;">Status</div>
                        <span class="badge-status bg-{{ $payment->status == 'verified' ? 'success' : ($payment->status == 'rejected' ? 'danger' : 'warning') }}">
                            {{ ucfirst($payment->status) }}
                        </span>
                    </div>
                </div>
                <div>
                    <div style="font-size:0.75rem;font-weight:600;color:#64748B;text-transform:uppercase;letter-spacing:0.03em;margin-bottom:0.375rem;">Tanggal</div>
                    <div style="font-weight:500;">{{ $payment->created_at->format('d F Y H:i') }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        @if($payment->proof_file)
            <div class="card-admin mb-3">
                <div class="card-header">
                    <h6 class="mb-0" style="font-weight:600;">Bukti Transfer</h6>
                </div>
                <div class="card-body text-center">
                    @if(str_contains($payment->proof_file, '.pdf'))
                        <a href="{{ Storage::url($payment->proof_file) }}" target="_blank" class="btn btn-admin" style="background:#F1F5F9;border:none;color:#4F46E5;">
                            <i class="bi bi-file-pdf me-1"></i> Lihat PDF
                        </a>
                    @else
                        <img src="{{ Storage::url($payment->proof_file) }}" class="img-fluid" style="border-radius:8px;" alt="Bukti Transfer">
                    @endif
                </div>
            </div>
        @endif

        @if($payment->status === 'verified')
            <div class="card-admin">
                <div class="card-body">
                    <a href="{{ route('admin.payments.receipt', $payment) }}" class="btn btn-admin w-100" style="background:#059669;border:none;color:#fff;">
                        <i class="bi bi-download me-1"></i> Cetak Kwitansi PDF
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
