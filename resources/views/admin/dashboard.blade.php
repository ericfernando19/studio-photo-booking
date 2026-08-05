@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<h4 class="mb-4">Dashboard</h4>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card stat-card shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-primary bg-opacity-10 text-primary me-3">
                        <i class="bi bi-calendar-check"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 text-muted">Booking Hari Ini</h6>
                        <h3 class="mb-0">{{ $stats['total_today'] }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-warning bg-opacity-10 text-warning me-3">
                        <i class="bi bi-clock-history"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 text-muted">Menunggu Verifikasi</h6>
                        <h3 class="mb-0">{{ $stats['waiting_verification'] }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-success bg-opacity-10 text-success me-3">
                        <i class="bi bi-cash-stack"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 text-muted">Pendapatan Hari Ini</h6>
                        <h3 class="mb-0">Rp {{ number_format($stats['revenue_today'], 0, ',', '.') }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-info bg-opacity-10 text-info me-3">
                        <i class="bi bi-calendar-month"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 text-muted">Booking Bulan Ini</h6>
                        <h3 class="mb-0">{{ $stats['total_month'] }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card stat-card shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-secondary bg-opacity-10 text-secondary me-3">
                        <i class="bi bi-cash-coin"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 text-muted">Pendapatan Bulan Ini</h6>
                        <h3 class="mb-0">Rp {{ number_format($stats['revenue_month'], 0, ',', '.') }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-purple bg-opacity-10 text-purple me-3">
                        <i class="bi bi-people"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 text-muted">Total Customer</h6>
                        <h3 class="mb-0">{{ $stats['total_customers'] }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-dark bg-opacity-10 text-dark me-3">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 text-muted">Booking Selesai</h6>
                        <h3 class="mb-0">{{ $stats['completed'] }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-white">
        <h6 class="mb-0">Booking Terbaru</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
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
                            <td><strong>{{ $booking->booking_code }}</strong></td>
                            <td>{{ $booking->customer_name }}</td>
                            <td>{{ $booking->package->name }}</td>
                            <td>{{ $booking->booking_date->format('d/m/Y') }}</td>
                            <td>
                                <span class="badge bg-{{ $booking->status_color }}">
                                    {{ $booking->status_label }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.bookings.show', $booking) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Belum ada booking</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
