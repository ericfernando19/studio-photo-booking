@extends('layouts.admin')

@section('title', 'Riwayat Customer')

@section('content')
<div class="card-admin mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.customers.index') }}" class="row g-2 align-items-end">
            <div class="col-md-8">
                <label class="form-label" style="font-size:0.8125rem;font-weight:500;color:#64748B;">Cari</label>
                <input type="text" class="form-control form-control-admin" name="search" placeholder="Cari nama atau nomor HP..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-admin btn-admin-primary w-100">
                    <i class="bi bi-search me-1"></i> Cari
                </button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('admin.customers.index') }}" class="btn btn-admin w-100" style="background:#F1F5F9;border:none;color:#64748B;">
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
                        <th>No</th>
                        <th>Nama</th>
                        <th>No. HP</th>
                        <th>Total Booking</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $customer)
                        <tr>
                            <td style="color:#64748B;">{{ $loop->iteration }}</td>
                            <td><span style="font-weight:600;">{{ $customer->customer_name }}</span></td>
                            <td>{{ $customer->customer_phone }}</td>
                            <td><span style="font-family:'JetBrains Mono',monospace;font-weight:500;">{{ $customer->total_bookings }}</span></td>
                            <td>
                                <a href="{{ route('admin.customers.show', $customer->customer_name) }}" class="btn btn-sm btn-outline-primary" style="border-radius:6px;">
                                    <i class="bi bi-eye me-1"></i> Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted" style="padding:2rem;">Belum ada customer</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($customers->hasPages())
    <div class="card-footer bg-transparent border-0 pt-0 pb-3">
        {{ $customers->links() }}
    </div>
    @endif
</div>
@endsection
