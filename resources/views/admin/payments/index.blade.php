@extends('layouts.admin')

@section('title', 'Pembayaran')

@section('content')
<div class="card-admin mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.payments.index') }}" class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label" style="font-size:0.8125rem;font-weight:500;color:#64748B;">Tipe</label>
                <select class="form-select form-select-admin" name="type">
                    <option value="">Semua Tipe</option>
                    <option value="dp" {{ request('type') == 'dp' ? 'selected' : '' }}>DP</option>
                    <option value="payment" {{ request('type') == 'payment' ? 'selected' : '' }}>Pelunasan</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label" style="font-size:0.8125rem;font-weight:500;color:#64748B;">Status</label>
                <select class="form-select form-select-admin" name="status">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>Terverifikasi</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-admin btn-admin-primary w-100">
                    <i class="bi bi-search me-1"></i> Filter
                </button>
            </div>
        </form>
    </div>
</div>

<div class="card-admin">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-admin mb-0">
                <thead>
                    <tr>
                        <th>Kode Booking</th>
                        <th>Tipe</th>
                        <th>Nominal</th>
                        <th>Metode</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                        <tr>
                            <td><span style="font-family:'JetBrains Mono',monospace;font-weight:500;font-size:0.8125rem;">{{ $payment->booking->booking_code }}</span></td>
                            <td>{{ $payment->type_label }}</td>
                            <td style="font-family:'JetBrains Mono',monospace;font-weight:500;">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                            <td>{{ $payment->method_label }}</td>
                            <td>
                                <span class="badge-status bg-{{ $payment->status == 'verified' ? 'success' : ($payment->status == 'rejected' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($payment->status) }}
                                </span>
                            </td>
                            <td>{{ $payment->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <a href="{{ route('admin.payments.show', $payment) }}" class="btn btn-sm btn-outline-primary" style="border-radius:6px;">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted" style="padding:2rem;">Belum ada pembayaran</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($payments->hasPages())
    <div class="card-footer bg-transparent border-0 pt-0 pb-3">
        {{ $payments->links() }}
    </div>
    @endif
</div>
@endsection
