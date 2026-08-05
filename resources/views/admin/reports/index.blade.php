@extends('layouts.admin')

@section('title', 'Laporan')

@section('content')
<h4 class="mb-4">Laporan</h4>

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.reports.index') }}" class="row g-2">
            <div class="col-md-3">
                <select class="form-select" name="filter" id="filterType">
                    <option value="daily" {{ $filter == 'daily' ? 'selected' : '' }}>Harian</option>
                    <option value="weekly" {{ $filter == 'weekly' ? 'selected' : '' }}>Mingguan</option>
                    <option value="monthly" {{ $filter == 'monthly' ? 'selected' : '' }}>Bulanan</option>
                    <option value="custom" {{ $filter == 'custom' ? 'selected' : '' }}>Rentang Tanggal</option>
                </select>
            </div>
            <div class="col-md-3">
                <input type="date" class="form-control" name="start_date" id="startDate" value="{{ $startDate }}">
            </div>
            <div class="col-md-3" id="endDateGroup">
                <input type="date" class="form-control" name="end_date" id="endDate" value="{{ $endDate }}">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-filter"></i> Filter
                </button>
            </div>
        </form>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card shadow-sm stat-card">
            <div class="card-body text-center">
                <h3 class="text-primary">{{ $bookingReport['total'] }}</h3>
                <p class="mb-0 text-muted">Total Booking</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm stat-card">
            <div class="card-body text-center">
                <h3 class="text-success">{{ $bookingReport['completed'] }}</h3>
                <p class="mb-0 text-muted">Booking Selesai</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm stat-card">
            <div class="card-body text-center">
                <h3 class="text-danger">{{ $bookingReport['cancelled'] }}</h3>
                <p class="mb-0 text-muted">Booking Dibatalkan</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm stat-card">
            <div class="card-body text-center">
                <h3 class="text-warning">{{ $bookingReport['waiting_verification'] }}</h3>
                <p class="mb-0 text-muted">Menunggu Verifikasi</p>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card shadow-sm stat-card">
            <div class="card-body text-center">
                <h4 class="text-info">Rp {{ number_format($revenueReport['total_dp'], 0, ',', '.') }}</h4>
                <p class="mb-0 text-muted">Total DP</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm stat-card">
            <div class="card-body text-center">
                <h4 class="text-success">Rp {{ number_format($revenueReport['total_payment'], 0, ',', '.') }}</h4>
                <p class="mb-0 text-muted">Total Pelunasan</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm stat-card">
            <div class="card-body text-center">
                <h4 class="text-dark">Rp {{ number_format($revenueReport['total'], 0, ',', '.') }}</h4>
                <p class="mb-0 text-muted">Total Pendapatan</p>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0">Laporan Booking</h6>
                <div class="d-flex gap-1">
                    <a href="{{ route('admin.reports.booking.pdf', ['start_date' => $startDate, 'end_date' => $endDate]) }}" class="btn btn-sm btn-danger">
                        <i class="bi bi-file-pdf"></i> PDF
                    </a>
                    <a href="{{ route('admin.reports.booking.excel', ['start_date' => $startDate, 'end_date' => $endDate]) }}" class="btn btn-sm btn-success">
                        <i class="bi bi-file-excel"></i> Excel
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <tbody>
                            <tr><td>Total Booking</td><td class="text-end"><strong>{{ $bookingReport['total'] }}</strong></td></tr>
                            <tr><td>Booking Selesai</td><td class="text-end"><strong>{{ $bookingReport['completed'] }}</strong></td></tr>
                            <tr><td>Booking Dibatalkan</td><td class="text-end"><strong>{{ $bookingReport['cancelled'] }}</strong></td></tr>
                            <tr><td>Menunggu Verifikasi</td><td class="text-end"><strong>{{ $bookingReport['waiting_verification'] }}</strong></td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0">Laporan Pendapatan</h6>
                <div class="d-flex gap-1">
                    <a href="{{ route('admin.reports.payment.pdf', ['start_date' => $startDate, 'end_date' => $endDate]) }}" class="btn btn-sm btn-danger">
                        <i class="bi bi-file-pdf"></i> PDF
                    </a>
                    <a href="{{ route('admin.reports.payment.excel', ['start_date' => $startDate, 'end_date' => $endDate]) }}" class="btn btn-sm btn-success">
                        <i class="bi bi-file-excel"></i> Excel
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <tbody>
                            <tr><td>Total DP</td><td class="text-end"><strong>Rp {{ number_format($revenueReport['total_dp'], 0, ',', '.') }}</strong></td></tr>
                            <tr><td>Total Pelunasan</td><td class="text-end"><strong>Rp {{ number_format($revenueReport['total_payment'], 0, ',', '.') }}</strong></td></tr>
                            <tr><td>Total Pendapatan</td><td class="text-end"><strong>Rp {{ number_format($revenueReport['total'], 0, ',', '.') }}</strong></td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0">Laporan Paket</h6>
                <a href="{{ route('admin.reports.package.excel', ['start_date' => $startDate, 'end_date' => $endDate]) }}" class="btn btn-sm btn-success">
                    <i class="bi bi-file-excel"></i> Excel
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr><th>Paket</th><th class="text-end">Jumlah</th></tr>
                        </thead>
                        <tbody>
                            @foreach($packageReport as $pkg)
                                <tr>
                                    <td>{{ $pkg->name }}</td>
                                    <td class="text-end"><strong>{{ $pkg->bookings_count }}</strong></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0">Laporan Customer</h6>
                <a href="{{ route('admin.reports.customer.excel', ['start_date' => $startDate, 'end_date' => $endDate]) }}" class="btn btn-sm btn-success">
                    <i class="bi bi-file-excel"></i> Excel
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr><th>Customer</th><th class="text-end">Booking</th></tr>
                        </thead>
                        <tbody>
                            @foreach($customerReport as $cust)
                                <tr>
                                    <td>{{ $cust->customer_name }}</td>
                                    <td class="text-end"><strong>{{ $cust->total_bookings }}</strong></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var filter = document.getElementById('filterType');
    var startDate = document.getElementById('startDate');
    var endDate = document.getElementById('endDate');
    var endDateGroup = document.getElementById('endDateGroup');

    function updateDates() {
        var today = new Date();
        var start, end;

        if (filter.value === 'daily') {
            start = end = formatDate(today);
            endDateGroup.style.display = 'none';
        } else if (filter.value === 'weekly') {
            var first = new Date(today);
            first.setDate(today.getDate() - today.getDay() + 1);
            var last = new Date(first);
            last.setDate(first.getDate() + 6);
            start = formatDate(first);
            end = formatDate(last);
            endDateGroup.style.display = '';
        } else if (filter.value === 'monthly') {
            start = formatDate(new Date(today.getFullYear(), today.getMonth(), 1));
            end = formatDate(new Date(today.getFullYear(), today.getMonth() + 1, 0));
            endDateGroup.style.display = '';
        } else {
            endDateGroup.style.display = '';
            return;
        }

        startDate.value = start;
        endDate.value = end;
    }

    function formatDate(d) {
        return d.getFullYear() + '-' +
            String(d.getMonth() + 1).padStart(2, '0') + '-' +
            String(d.getDate()).padStart(2, '0');
    }

    filter.addEventListener('change', updateDates);
    updateDates();
});
</script>
@endpush
