@extends('layouts.admin')

@section('title', 'Detail Customer')

@section('content')
<div class="page-header">
    <div></div>
    <a href="{{ route('admin.customers.index') }}" class="btn btn-admin" style="background:#F1F5F9;border:none;color:#64748B;">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card-admin">
            <div class="card-body text-center" style="padding:2rem;">
                <div style="width:72px;height:72px;border-radius:16px;background:linear-gradient(135deg,#4F46E5,#7C3AED);display:inline-flex;align-items:center;justify-content:center;color:#fff;font-size:1.75rem;margin-bottom:1rem;">
                    <i class="bi bi-person-fill"></i>
                </div>
                <h5 style="font-weight:600;margin-bottom:0.25rem;">{{ $customerName }}</h5>
                <p style="color:#64748B;font-size:0.875rem;margin-bottom:1.25rem;">{{ $phone }}</p>

                <div class="row text-center" style="border-top:1px solid #E2E8F0;padding-top:1.25rem;">
                    <div class="col-4">
                        <div style="font-family:'JetBrains Mono',monospace;font-weight:700;font-size:1.25rem;color:#1E293B;">{{ $bookings->count() }}</div>
                        <div style="font-size:0.6875rem;color:#64748B;font-weight:500;">Total Booking</div>
                    </div>
                    <div class="col-4">
                        <div style="font-family:'JetBrains Mono',monospace;font-weight:700;font-size:1.25rem;color:#059669;">{{ $bookings->where('status', 'completed')->count() }}</div>
                        <div style="font-size:0.6875rem;color:#64748B;font-weight:500;">Selesai</div>
                    </div>
                    <div class="col-4">
                        <div style="font-family:'JetBrains Mono',monospace;font-weight:700;font-size:1.25rem;color:#4F46E5;">Rp {{ number_format($totalSpent, 0, ',', '.') }}</div>
                        <div style="font-size:0.6875rem;color:#64748B;font-weight:500;">Total Pengeluaran</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card-admin">
            <div class="card-header">
                <h6 class="mb-0" style="font-weight:600;">Riwayat Booking</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-admin mb-0">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Paket</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Total Bayar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bookings as $booking)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.bookings.show', $booking) }}" style="font-family:'JetBrains Mono',monospace;font-weight:500;font-size:0.8125rem;color:#4F46E5;text-decoration:none;">
                                            {{ $booking->booking_code }}
                                        </a>
                                    </td>
                                    <td>{{ $booking->package->name }}</td>
                                    <td>{{ $booking->booking_date->format('d/m/Y') }}</td>
                                    <td><span class="badge-status bg-{{ $booking->status_color }}">{{ $booking->status_label }}</span></td>
                                    <td style="font-family:'JetBrains Mono',monospace;font-weight:500;">Rp {{ number_format($booking->payments->where('status', 'verified')->sum('amount'), 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted" style="padding:2rem;">Belum ada booking</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
