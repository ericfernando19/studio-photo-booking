@extends('layouts.admin')

@section('title', 'Pembayaran')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Riwayat Pembayaran</h4>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.payments.index') }}" class="row g-2">
            <div class="col-md-3">
                <select class="form-select" name="type">
                    <option value="">Semua Tipe</option>
                    <option value="dp" {{ request('type') == 'dp' ? 'selected' : '' }}>DP</option>
                    <option value="payment" {{ request('type') == 'payment' ? 'selected' : '' }}>Pelunasan</option>
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-select" name="status">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>Terverifikasi</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-search"></i> Filter
                </button>
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
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
                            <td><strong>{{ $payment->booking->booking_code }}</strong></td>
                            <td>{{ $payment->type_label }}</td>
                            <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                            <td>{{ $payment->method_label }}</td>
                            <td>
                                <span class="badge bg-{{ $payment->status == 'verified' ? 'success' : ($payment->status == 'rejected' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($payment->status) }}
                                </span>
                            </td>
                            <td>{{ $payment->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <a href="{{ route('admin.payments.show', $payment) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Belum ada pembayaran</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $payments->links() }}
    </div>
</div>
@endsection
