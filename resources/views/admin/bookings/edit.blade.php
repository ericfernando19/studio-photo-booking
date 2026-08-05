@extends('layouts.admin')

@section('title', 'Edit Booking ' . $booking->booking_code)

@section('content')
<h4 class="mb-4">Edit Booking {{ $booking->booking_code }}</h4>

<div class="card shadow-sm">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.bookings.update', $booking) }}">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="customer_name" class="form-label">Nama Customer</label>
                    <input type="text" class="form-control @error('customer_name') is-invalid @enderror" id="customer_name" name="customer_name" value="{{ old('customer_name', $booking->customer_name) }}" required>
                    @error('customer_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="customer_phone" class="form-label">Nomor HP</label>
                    <input type="text" class="form-control @error('customer_phone') is-invalid @enderror" id="customer_phone" name="customer_phone" value="{{ old('customer_phone', $booking->customer_phone) }}" required>
                    @error('customer_phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="package_id" class="form-label">Paket</label>
                    <select class="form-select @error('package_id') is-invalid @enderror" id="package_id" name="package_id" required>
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

                <div class="col-md-6 mb-3">
                    <label for="booking_date" class="form-label">Tanggal Booking</label>
                    <input type="date" class="form-control @error('booking_date') is-invalid @enderror" id="booking_date" name="booking_date" value="{{ old('booking_date', $booking->booking_date->format('Y-m-d')) }}" required>
                    @error('booking_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="university_name" class="form-label">Universitas/Sekolah</label>
                <input type="text" class="form-control @error('university_name') is-invalid @enderror" id="university_name" name="university_name" value="{{ old('university_name', $booking->university_name) }}">
                @error('university_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="notes" class="form-label">Catatan</label>
                <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3">{{ old('notes', $booking->notes) }}</textarea>
                @error('notes')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.bookings.show', $booking) }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
