@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card-admin border-primary">
            <div class="stat-icon-admin bg-primary-subtle">
                <i class="bi bi-calendar-check"></i>
            </div>
            <div>
                <div class="stat-label">Booking Hari Ini</div>
                <div class="stat-value">{{ $stats['total_today'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card-admin border-warning">
            <div class="stat-icon-admin bg-warning-subtle">
                <i class="bi bi-clock-history"></i>
            </div>
            <div>
                <div class="stat-label">Menunggu Verifikasi</div>
                <div class="stat-value">{{ $stats['waiting_verification'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card-admin border-success">
            <div class="stat-icon-admin bg-success-subtle">
                <i class="bi bi-cash-stack"></i>
            </div>
            <div>
                <div class="stat-label">Pendapatan Hari Ini</div>
                <div class="stat-value">Rp {{ number_format($stats['revenue_today'], 0, ',', '.') }}</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card-admin border-info">
            <div class="stat-icon-admin bg-info-subtle">
                <i class="bi bi-calendar-month"></i>
            </div>
            <div>
                <div class="stat-label">Booking Bulan Ini</div>
                <div class="stat-value">{{ $stats['total_month'] }}</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-4">
        <div class="stat-card-admin border-dark">
            <div class="stat-icon-admin bg-dark-subtle">
                <i class="bi bi-cash-coin"></i>
            </div>
            <div>
                <div class="stat-label">Pendapatan Bulan Ini</div>
                <div class="stat-value">Rp {{ number_format($stats['revenue_month'], 0, ',', '.') }}</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-4">
        <div class="stat-card-admin border-purple">
            <div class="stat-icon-admin bg-purple-subtle">
                <i class="bi bi-people"></i>
            </div>
            <div>
                <div class="stat-label">Total Customer</div>
                <div class="stat-value">{{ $stats['total_customers'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-4">
        <div class="stat-card-admin border-success">
            <div class="stat-icon-admin bg-success-subtle">
                <i class="bi bi-check-circle"></i>
            </div>
            <div>
                <div class="stat-label">Booking Selesai</div>
                <div class="stat-value">{{ $stats['completed'] }}</div>
            </div>
        </div>
    </div>
</div>

<div class="card-admin">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h6 class="mb-0" style="font-weight:600;">Booking Terbaru</h6>
        <a href="{{ route('admin.bookings.index') }}" class="btn btn-sm btn-admin btn-admin-primary" style="font-size:0.8125rem;">
            Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-admin mb-0">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Customer</th>
                        <th>Paket</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentBookings as $booking)
                        <tr>
                            <td><span style="font-family:'JetBrains Mono',monospace;font-weight:500;font-size:0.8125rem;">{{ $booking->booking_code }}</span></td>
                            <td>{{ $booking->customer_name }}</td>
                            <td>{{ $booking->package->name }}</td>
                            <td>{{ $booking->booking_date->format('d/m/Y') }}</td>
                            <td><span class="badge-status bg-{{ $booking->status_color }}">{{ $booking->status_label }}</span></td>
                            <td>
                                <a href="{{ route('admin.bookings.show', $booking) }}" class="btn btn-sm btn-outline-primary" style="border-radius:6px;">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted" style="padding:2rem;">Belum ada booking</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
