@extends('layouts.admin')

@section('title', 'Laporan')

@section('content')
<div class="card-admin mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.reports.index') }}" class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label" style="font-size:0.8125rem;font-weight:500;color:#64748B;">Periode</label>
                <select class="form-select form-select-admin" name="filter" id="filterType">
                    <option value="daily" {{ $filter == 'daily' ? 'selected' : '' }}>Harian</option>
                    <option value="weekly" {{ $filter == 'weekly' ? 'selected' : '' }}>Mingguan</option>
                    <option value="monthly" {{ $filter == 'monthly' ? 'selected' : '' }}>Bulanan</option>
                    <option value="custom" {{ $filter == 'custom' ? 'selected' : '' }}>Rentang Tanggal</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label" style="font-size:0.8125rem;font-weight:500;color:#64748B;">Tanggal Mulai</label>
                <input type="date" class="form-control form-control-admin" name="start_date" id="startDate" value="{{ $startDate }}">
            </div>
            <div class="col-md-3" id="endDateGroup">
                <label class="form-label" style="font-size:0.8125rem;font-weight:500;color:#64748B;">Tanggal Akhir</label>
                <input type="date" class="form-control form-control-admin" name="end_date" id="endDate" value="{{ $endDate }}">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-admin btn-admin-primary w-100">
                    <i class="bi bi-funnel me-1"></i> Filter
                </button>
            </div>
        </form>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card-admin border-primary">
            <div class="stat-icon-admin bg-primary-subtle"><i class="bi bi-journal-text"></i></div>
            <div>
                <div class="stat-label">Total Booking</div>
                <div class="stat-value">{{ $bookingReport['total'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card-admin border-success">
            <div class="stat-icon-admin bg-success-subtle"><i class="bi bi-check-circle"></i></div>
            <div>
                <div class="stat-label">Booking Selesai</div>
                <div class="stat-value">{{ $bookingReport['completed'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card-admin border-danger">
            <div class="stat-icon-admin bg-danger-subtle"><i class="bi bi-x-circle"></i></div>
            <div>
                <div class="stat-label">Dibatalkan</div>
                <div class="stat-value">{{ $bookingReport['cancelled'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card-admin border-warning">
            <div class="stat-icon-admin bg-warning-subtle"><i class="bi bi-clock"></i></div>
            <div>
                <div class="stat-label">Menunggu Verifikasi</div>
                <div class="stat-value">{{ $bookingReport['waiting_verification'] }}</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="stat-card-admin border-info">
            <div class="stat-icon-admin bg-info-subtle"><i class="bi bi-wallet2"></i></div>
            <div>
                <div class="stat-label">Total DP</div>
                <div class="stat-value" style="font-size:1.125rem;">Rp {{ number_format($revenueReport['total_dp'], 0, ',', '.') }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card-admin border-success">
            <div class="stat-icon-admin bg-success-subtle"><i class="bi bi-cash"></i></div>
            <div>
                <div class="stat-label">Total Pelunasan</div>
                <div class="stat-value" style="font-size:1.125rem;">Rp {{ number_format($revenueReport['total_payment'], 0, ',', '.') }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card-admin border-dark">
            <div class="stat-icon-admin bg-dark-subtle"><i class="bi bi-bank"></i></div>
            <div>
                <div class="stat-label">Total Pendapatan</div>
                <div class="stat-value" style="font-size:1.125rem;">Rp {{ number_format($revenueReport['total'], 0, ',', '.') }}</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-6">
        <div class="card-admin h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0" style="font-weight:600;">Laporan Booking</h6>
                <div class="d-flex gap-1">
                    <a href="{{ route('admin.reports.booking.pdf', ['start_date' => $startDate, 'end_date' => $endDate]) }}" class="btn btn-sm" style="background:#FEF2F2;color:#DC2626;border:none;">
                        <i class="bi bi-file-pdf"></i> PDF
                    </a>
                    <a href="{{ route('admin.reports.booking.excel', ['start_date' => $startDate, 'end_date' => $endDate]) }}" class="btn btn-sm" style="background:#ECFDF5;color:#059669;border:none;">
                        <i class="bi bi-file-excel"></i> Excel
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <table class="table table-admin mb-0">
                    <tbody>
                        <tr><td>Total Booking</td><td class="text-end" style="font-family:'JetBrains Mono',monospace;font-weight:600;">{{ $bookingReport['total'] }}</td></tr>
                        <tr><td>Booking Selesai</td><td class="text-end" style="font-family:'JetBrains Mono',monospace;font-weight:600;">{{ $bookingReport['completed'] }}</td></tr>
                        <tr><td>Booking Dibatalkan</td><td class="text-end" style="font-family:'JetBrains Mono',monospace;font-weight:600;">{{ $bookingReport['cancelled'] }}</td></tr>
                        <tr><td>Menunggu Verifikasi</td><td class="text-end" style="font-family:'JetBrains Mono',monospace;font-weight:600;">{{ $bookingReport['waiting_verification'] }}</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card-admin h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0" style="font-weight:600;">Laporan Pendapatan</h6>
                <div class="d-flex gap-1">
                    <a href="{{ route('admin.reports.payment.pdf', ['start_date' => $startDate, 'end_date' => $endDate]) }}" class="btn btn-sm" style="background:#FEF2F2;color:#DC2626;border:none;">
                        <i class="bi bi-file-pdf"></i> PDF
                    </a>
                    <a href="{{ route('admin.reports.payment.excel', ['start_date' => $startDate, 'end_date' => $endDate]) }}" class="btn btn-sm" style="background:#ECFDF5;color:#059669;border:none;">
                        <i class="bi bi-file-excel"></i> Excel
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <table class="table table-admin mb-0">
                    <tbody>
                        <tr><td>Total DP</td><td class="text-end" style="font-family:'JetBrains Mono',monospace;font-weight:600;">Rp {{ number_format($revenueReport['total_dp'], 0, ',', '.') }}</td></tr>
                        <tr><td>Total Pelunasan</td><td class="text-end" style="font-family:'JetBrains Mono',monospace;font-weight:600;">Rp {{ number_format($revenueReport['total_payment'], 0, ',', '.') }}</td></tr>
                        <tr><td>Total Pendapatan</td><td class="text-end" style="font-family:'JetBrains Mono',monospace;font-weight:600;">Rp {{ number_format($revenueReport['total'], 0, ',', '.') }}</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card-admin h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0" style="font-weight:600;">Laporan Paket</h6>
                <a href="{{ route('admin.reports.package.excel', ['start_date' => $startDate, 'end_date' => $endDate]) }}" class="btn btn-sm" style="background:#ECFDF5;color:#059669;border:none;">
                    <i class="bi bi-file-excel"></i> Excel
                </a>
            </div>
            <div class="card-body p-0">
                <table class="table table-admin mb-0">
                    <thead>
                        <tr><th>Paket</th><th class="text-end">Jumlah</th></tr>
                    </thead>
                    <tbody>
                        @foreach($packageReport as $pkg)
                            <tr>
                                <td>{{ $pkg->name }}</td>
                                <td class="text-end" style="font-family:'JetBrains Mono',monospace;font-weight:600;">{{ $pkg->bookings_count }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card-admin h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0" style="font-weight:600;">Laporan Customer</h6>
                <a href="{{ route('admin.reports.customer.excel', ['start_date' => $startDate, 'end_date' => $endDate]) }}" class="btn btn-sm" style="background:#ECFDF5;color:#059669;border:none;">
                    <i class="bi bi-file-excel"></i> Excel
                </a>
            </div>
            <div class="card-body p-0">
                <table class="table table-admin mb-0">
                    <thead>
                        <tr><th>Customer</th><th class="text-end">Booking</th></tr>
                    </thead>
                    <tbody>
                        @foreach($customerReport as $cust)
                            <tr>
                                <td>{{ $cust->customer_name }}</td>
                                <td class="text-end" style="font-family:'JetBrains Mono',monospace;font-weight:600;">{{ $cust->total_bookings }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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
