@extends('layouts.app')

@section('title', 'Detail Booking ' . $booking->booking_code)

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-body p-4">
                <div class="text-center mb-4">
                    <h4>Detail Booking</h4>
                    <span class="badge bg-{{ $booking->status_color }} fs-5">{{ $booking->status_label }}</span>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Kode Booking</strong><br>
                        <h5 class="text-primary">{{ $booking->booking_code }}</h5>
                    </div>
                    <div class="col-md-6">
                        <strong>Tanggal Booking</strong><br>
                        {{ $booking->booking_date->format('d F Y') }}
                    </div>
                </div>

                <hr>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Nama Customer</strong><br>
                        {{ $booking->customer_name }}
                    </div>
                    <div class="col-md-6">
                        <strong>Nomor HP</strong><br>
                        {{ $booking->customer_phone }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Paket</strong><br>
                        {{ $booking->package->name }}
                    </div>
                    <div class="col-md-6">
                        <strong>Harga Paket</strong><br>
                        Rp {{ number_format($booking->package->price, 0, ',', '.') }}
                    </div>
                </div>

                @if($booking->university_name)
                    <div class="mb-3">
                        <strong>Universitas/Sekolah</strong><br>
                        {{ $booking->university_name }}
                    </div>
                @endif

                @if($booking->studio)
                    <div class="mb-3">
                        <strong>Studio</strong><br>
                        {{ $booking->studio->name }}
                    </div>
                @endif

                @if($booking->queue_number)
                    <div class="mb-3">
                        <strong>Nomor Antrian</strong><br>
                        <span class="badge bg-purple fs-5">{{ $booking->queue_number }}</span>
                    </div>
                @endif

                @if($booking->invoice_number)
                    <div class="mb-3">
                        <strong>Nomor Invoice</strong><br>
                        {{ $booking->invoice_number }}
                    </div>
                @endif

                <hr>

                <h6>Riwayat Pembayaran</h6>
                @if($booking->payments->count())
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Tipe</th>
                                    <th>Nominal</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($booking->payments as $payment)
                                    <tr>
                                        <td>{{ $payment->type_label }}</td>
                                        <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                                        <td>
                                            <span class="badge bg-{{ $payment->status == 'verified' ? 'success' : ($payment->status == 'rejected' ? 'danger' : 'warning') }}">
                                                {{ ucfirst($payment->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted">Belum ada pembayaran</p>
                @endif

                <div class="text-center mt-4">
                    <a href="{{ route('booking.form') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Booking Baru
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
