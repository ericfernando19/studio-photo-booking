@extends('layouts.admin')

@section('title', 'Edit Booking ' . $booking->booking_code)

@section('content')
<div class="page-header">
    <div></div>
    <a href="{{ route('admin.bookings.show', $booking) }}" class="btn btn-admin" style="background:#F1F5F9;border:none;color:#64748B;">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="card-admin" style="max-width:720px;">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.bookings.update', $booking) }}">
            @csrf
            @method('PUT')

            <div class="row g-3">
                <div class="col-md-6">
                    <label for="customer_name" class="form-label" style="font-size:0.8125rem;font-weight:500;color:#475569;">Nama Customer</label>
                    <input type="text" class="form-control form-control-admin @error('customer_name') is-invalid @enderror" id="customer_name" name="customer_name" value="{{ old('customer_name', $booking->customer_name) }}" required>
                    @error('customer_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="customer_phone" class="form-label" style="font-size:0.8125rem;font-weight:500;color:#475569;">Nomor HP</label>
                    <input type="text" class="form-control form-control-admin @error('customer_phone') is-invalid @enderror" id="customer_phone" name="customer_phone" value="{{ old('customer_phone', $booking->customer_phone) }}" required>
                    @error('customer_phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row g-3 mt-1">
                <div class="col-md-6">
                    <label for="package_id" class="form-label" style="font-size:0.8125rem;font-weight:500;color:#475569;">Paket</label>
                    <select class="form-select form-select-admin @error('package_id') is-invalid @enderror" id="package_id" name="package_id" required>
                        @foreach($packages as $package)
                            <option value="{{ $package->id }}" {{ old('package_id', $booking->package_id) == $package->id ? 'selected' : '' }}>
                                {{ $package->name }} - Rp {{ number_format($package->price, 0, ',', '.') }}
                            </option>
                        @endforeach
                    </select>
                    @error('package_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="booking_date" class="form-label" style="font-size:0.8125rem;font-weight:500;color:#475569;">Tanggal Booking</label>
                    <input type="date" class="form-control form-control-admin @error('booking_date') is-invalid @enderror" id="booking_date" name="booking_date" value="{{ old('booking_date', $booking->booking_date->format('Y-m-d')) }}" required>
                    @error('booking_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mt-3">
                <label for="university_name" class="form-label" style="font-size:0.8125rem;font-weight:500;color:#475569;">Universitas/Sekolah</label>
                <input type="text" class="form-control form-control-admin @error('university_name') is-invalid @enderror" id="university_name" name="university_name" value="{{ old('university_name', $booking->university_name) }}">
                @error('university_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mt-3">
                <label for="notes" class="form-label" style="font-size:0.8125rem;font-weight:500;color:#475569;">Catatan</label>
                <textarea class="form-control form-control-admin @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3">{{ old('notes', $booking->notes) }}</textarea>
                @error('notes')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-admin btn-admin-primary">Simpan Perubahan</button>
                <a href="{{ route('admin.bookings.show', $booking) }}" class="btn btn-admin" style="background:#F1F5F9;border:none;color:#64748B;">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
