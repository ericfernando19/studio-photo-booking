@extends('layouts.admin')

@section('title', 'Kelola Booking')

@section('content')
<div class="card-admin mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.bookings.index') }}" class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label" style="font-size:0.8125rem;font-weight:500;color:#64748B;">Cari</label>
                <input type="text" class="form-control form-control-admin" name="search" placeholder="Nama, no HP, atau kode..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label" style="font-size:0.8125rem;font-weight:500;color:#64748B;">Status</label>
                <select class="form-select form-select-admin" name="status">
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
                <label class="form-label" style="font-size:0.8125rem;font-weight:500;color:#64748B;">Tanggal</label>
                <input type="date" class="form-control form-control-admin" name="date" value="{{ request('date') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label" style="font-size:0.8125rem;font-weight:500;color:#64748B;">Urutkan</label>
                <select class="form-select form-select-admin" name="sort">
                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                </select>
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-admin btn-admin-primary w-100">
                    <i class="bi bi-search"></i>
                </button>
            </div>
            <div class="col-md-12">
                <a href="{{ route('admin.bookings.index') }}" class="btn btn-sm" style="color:#64748B;">
                    <i class="bi bi-x-circle me-1"></i> Reset
                </a>
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
                            <td><span style="font-family:'JetBrains Mono',monospace;font-weight:500;font-size:0.8125rem;">{{ $booking->booking_code }}</span></td>
                            <td>
                                {{ $booking->customer_name }}<br>
                                <small style="color:#64748B;">{{ $booking->customer_phone }}</small>
                            </td>
                            <td>{{ $booking->package->name }}</td>
                            <td>{{ $booking->booking_date->format('d/m/Y') }}</td>
                            <td><span class="badge-status bg-{{ $booking->status_color }}">{{ $booking->status_label }}</span></td>
                            <td>
                                <a href="{{ route('admin.bookings.show', $booking) }}" class="btn btn-sm btn-outline-primary" style="border-radius:6px;">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.bookings.edit', $booking) }}" class="btn btn-sm btn-outline-warning" style="border-radius:6px;">
                                    <i class="bi bi-pencil"></i>
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
    @if($bookings->hasPages())
    <div class="card-footer bg-transparent border-0 pt-0 pb-3">
        {{ $bookings->links() }}
    </div>
    @endif
</div>
@endsection
