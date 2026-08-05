@extends('layouts.admin')

@section('title', 'Riwayat Customer')

@section('content')
<h4 class="mb-4">Riwayat Customer</h4>

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.customers.index') }}" class="row g-2">
            <div class="col-md-8">
                <input type="text" class="form-control" name="search" placeholder="Cari nama atau nomor HP..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-search"></i> Cari
                </button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-secondary w-100">
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
                            <td>{{ $loop->iteration }}</td>
                            <td><strong>{{ $customer->customer_name }}</strong></td>
                            <td>{{ $customer->customer_phone }}</td>
                            <td>{{ $customer->total_bookings }}</td>
                            <td>
                                <a href="{{ route('admin.customers.show', $customer->customer_name) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Belum ada customer</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $customers->links() }}
    </div>
</div>
@endsection
