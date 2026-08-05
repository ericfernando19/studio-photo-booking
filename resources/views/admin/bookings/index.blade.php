@extends('layouts.admin')

@section('title', 'Kelola Booking')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Kelola Booking</h4>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.bookings.index') }}" class="row g-2">
            <div class="col-md-3">
                <input type="text" class="form-control" name="search" placeholder="Cari nama, no HP, atau kode booking..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <select class="form-select" name="status">
                    <option value="">Semua Status</option>
                    <option value="waiting_verification" {{ request('status') == 'waiting_verification' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Dikonfirmasi</option>
                    <option value="customer_present" {{ request('status') == 'customer_present' ? 'selected' : '' }}>Customer Hadir</option>
                    <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Lunas</option>
                    <option value="waiting_queue" {{ request('status') == 'waiting_queue' ? 'selected' : '' }}>Menunggu Antrian</option>
                    <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>Sedang Foto</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
            </div>
            <div class="col-md-2">
                <input type="date" class="form-control" name="date" value="{{ request('date') }}">
            </div>
            <div class="col-md-2">
                <select class="form-select" name="sort">
                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                </select>
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-search"></i>
                </button>
            </div>
            <div class="col-md-12 mt-2">
                <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-x-circle"></i> Reset
                </a>
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
                        <th>Kode</th>
                        <th>Customer</th>
                        <th>Paket</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                        <tr>
                            <td><strong>{{ $booking->booking_code }}</strong></td>
                            <td>
                                {{ $booking->customer_name }}<br>
                                <small class="text-muted">{{ $booking->customer_phone }}</small>
                            </td>
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
                                <a href="{{ route('admin.bookings.edit', $booking) }}" class="btn btn-sm btn-outline-warning">
                                    <i class="bi bi-pencil"></i>
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
        {{ $bookings->links() }}
    </div>
</div>
@endsection
