@extends('layouts.admin')

@section('title', 'Detail Customer')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Detail Customer: {{ $customerName }}</h4>
    <a href="{{ route('admin.customers.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                <div class="bg-purple text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width:80px;height:80px;font-size:2rem;">
                    <i class="bi bi-person-fill"></i>
                </div>
                <h5>{{ $customerName }}</h5>
                <p class="text-muted">{{ $phone }}</p>
                <hr>
                <div class="row text-center">
                    <div class="col-4">
                        <h4 class="mb-0">{{ $bookings->count() }}</h4>
                        <small class="text-muted">Total Booking</small>
                    </div>
                    <div class="col-4">
                        <h4 class="mb-0">{{ $bookings->where('status', 'completed')->count() }}</h4>
                        <small class="text-muted">Selesai</small>
                    </div>
                    <div class="col-4">
                        <h4 class="mb-0">Rp {{ number_format($totalSpent, 0, ',', '.') }}</h4>
                        <small class="text-muted">Total Pengeluaran</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h6 class="mb-0">Riwayat Booking</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
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
                                        <a href="{{ route('admin.bookings.show', $booking) }}">
                                            {{ $booking->booking_code }}
                                        </a>
                                    </td>
                                    <td>{{ $booking->package->name }}</td>
                                    <td>{{ $booking->booking_date->format('d/m/Y') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $booking->status_color }}">
                                            {{ $booking->status_label }}
                                        </span>
                                    </td>
                                    <td>Rp {{ number_format($booking->payments->where('status', 'verified')->sum('amount'), 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Belum ada booking</td>
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
