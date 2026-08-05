@extends('layouts.admin')

@section('title', 'Detail Booking ' . $booking->booking_code)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Detail Booking {{ $booking->booking_code }}</h4>
    <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="row g-4">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h6 class="mb-0">Informasi Booking</h6>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Kode Booking</strong><br>
                        <span class="badge bg-dark fs-6">{{ $booking->booking_code }}</span>
                    </div>
                    <div class="col-md-6">
                        <strong>Status</strong><br>
                        <span class="badge bg-{{ $booking->status_color }} fs-6">{{ $booking->status_label }}</span>
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

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Tanggal Booking</strong><br>
                        {{ $booking->booking_date->format('d F Y') }}
                    </div>
                    <div class="col-md-6">
                        <strong>Studio</strong><br>
                        {{ $booking->studio?->name ?? '-' }}
                    </div>
                </div>

                @if($booking->university_name)
                    <div class="mb-3">
                        <strong>Universitas/Sekolah</strong><br>
                        {{ $booking->university_name }}
                    </div>
                @endif

                @if($booking->queue_number)
                    <div class="mb-3">
                        <strong>Nomor Antrian</strong><br>
                        <span class="badge bg-purple fs-6">{{ $booking->queue_number }}</span>
                    </div>
                @endif

                @if($booking->invoice_number)
                    <div class="mb-3">
                        <strong>Nomor Invoice</strong><br>
                        <span class="badge bg-success fs-6">{{ $booking->invoice_number }}</span>
                        <a href="{{ route('admin.payments.invoice', $booking) }}" class="btn btn-sm btn-outline-success ms-2">
                            <i class="bi bi-download"></i> Invoice
                        </a>
                    </div>
                @endif

                @if($booking->notes)
                    <div class="mb-3">
                        <strong>Catatan</strong><br>
                        {{ $booking->notes }}
                    </div>
                @endif
            </div>
        </div>

        {{-- Payments --}}
        <div class="card shadow-sm mt-4">
            <div class="card-header bg-white">
                <h6 class="mb-0">Riwayat Pembayaran</h6>
            </div>
            <div class="card-body">
                @if($booking->payments->count())
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Tipe</th>
                                    <th>Nominal</th>
                                    <th>Metode</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($booking->payments as $payment)
                                    <tr>
                                        <td>{{ $payment->type_label }}</td>
                                        <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                                        <td>{{ $payment->method_label }}</td>
                                        <td>
                                            <span class="badge bg-{{ $payment->status == 'verified' ? 'success' : ($payment->status == 'rejected' ? 'danger' : 'warning') }}">
                                                {{ ucfirst($payment->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $payment->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-end">
                        <strong>Total Dibayar: Rp {{ number_format($booking->total_paid, 0, ',', '.') }}</strong><br>
                        <strong>Sisa: Rp {{ number_format($booking->remaining_amount, 0, ',', '.') }}</strong>
                    </div>
                @else
                    <p class="text-muted mb-0">Belum ada pembayaran</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        {{-- Status Management --}}
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h6 class="mb-0">Kelola Status</h6>
            </div>
            <div class="card-body">
                @if($booking->status === 'waiting_verification')
                    <form method="POST" action="{{ route('admin.bookings.verify', $booking) }}" class="mb-2">
                        @csrf
                        <button type="submit" class="btn btn-success w-100">
                            <i class="bi bi-check-circle"></i> Verifikasi Booking
                        </button>
                    </form>
                    <form method="POST" action="{{ route('admin.bookings.reject', $booking) }}">
                        @csrf
                        <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Tolak booking ini?')">
                            <i class="bi bi-x-circle"></i> Tolak Booking
                        </button>
                    </form>
                @elseif($booking->status !== 'cancelled' && $booking->status !== 'completed')
                    <form method="POST" action="{{ route('admin.bookings.status', $booking) }}">
                        @csrf
                        <div class="mb-3">
                            <select name="status" class="form-select">
                                <option value="waiting_verification" {{ $booking->status === 'waiting_verification' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                                <option value="confirmed" {{ $booking->status === 'confirmed' ? 'selected' : '' }}>Dikonfirmasi</option>
                                <option value="customer_present" {{ $booking->status === 'customer_present' ? 'selected' : '' }}>Customer Hadir</option>
                                <option value="paid" {{ $booking->status === 'paid' ? 'selected' : '' }}>Lunas</option>
                                <option value="waiting_queue" {{ $booking->status === 'waiting_queue' ? 'selected' : '' }}>Menunggu Antrian</option>
                                <option value="in_progress" {{ $booking->status === 'in_progress' ? 'selected' : '' }}>Sedang Foto</option>
                                <option value="completed" {{ $booking->status === 'completed' ? 'selected' : '' }}>Selesai</option>
                                <option value="cancelled" {{ $booking->status === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-check2-all"></i> Update Status
                        </button>
                    </form>

                    @if($booking->status === 'customer_present' && !$booking->isFullyPaid())
                        <hr>
                        <h6>Pelunasan</h6>
                        <form method="POST" action="{{ route('admin.payments.process', $booking) }}">
                            @csrf
                            <div class="mb-2">
                                <label class="form-label">Sisa Pembayaran: <strong>Rp {{ number_format($booking->remaining_amount, 0, ',', '.') }}</strong></label>
                                <input type="number" class="form-control" name="amount" value="{{ $booking->remaining_amount }}" min="0" required>
                            </div>
                            <input type="hidden" name="method" value="transfer">
                            <button type="submit" class="btn btn-success w-100" onclick="return confirm('Proses pelunasan?')">
                                <i class="bi bi-cash"></i> Proses Pelunasan
                            </button>
                        </form>
                    @endif

                    @if($booking->status === 'paid' || $booking->status === 'waiting_queue' || $booking->status === 'in_progress')
                        <hr>
                        <h6>Tugaskan Studio</h6>
                        <form method="POST" action="{{ route('admin.queues.assign', $booking) }}">
                            @csrf
                            <div class="mb-2">
                                <select name="studio_id" class="form-select" required>
                                    <option value="">Pilih Studio</option>
                                    @foreach(\App\Models\Studio::where('is_active', true)->get() as $studio)
                                        <option value="{{ $studio->id }}">{{ $studio->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-info w-100">
                                <i class="bi bi-building"></i> Tugaskan Studio
                            </button>
                        </form>
                    @endif

                    @if($booking->status === 'paid')
                        <form method="POST" action="{{ route('admin.bookings.status', $booking) }}" class="mt-2">
                            @csrf
                            <input type="hidden" name="status" value="waiting_queue">
                            <button type="submit" class="btn btn-secondary w-100">
                                <i class="bi bi-list-ol"></i> Masuk Antrian
                            </button>
                        </form>
                    @endif

                    @if($booking->status === 'waiting_queue')
                        <form method="POST" action="{{ route('admin.bookings.status', $booking) }}" class="mt-2">
                            @csrf
                            <input type="hidden" name="status" value="in_progress">
                            <button type="submit" class="btn btn-purple w-100">
                                <i class="bi bi-camera"></i> Mulai Foto
                            </button>
                        </form>
                    @endif

                    @if($booking->status === 'in_progress')
                        <form method="POST" action="{{ route('admin.bookings.status', $booking) }}" class="mt-2">
                            @csrf
                            <input type="hidden" name="status" value="completed">
                            <button type="submit" class="btn btn-dark w-100">
                                <i class="bi bi-check-all"></i> Selesai
                            </button>
                        </form>
                    @endif

                    <form method="POST" action="{{ route('admin.bookings.cancel', $booking) }}" class="mt-2">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger w-100" onclick="return confirm('Batalkan booking ini?')">
                            <i class="bi bi-x-lg"></i> Batalkan
                        </button>
                    </form>
                @else
                    <div class="alert alert-{{ $booking->status === 'cancelled' ? 'danger' : 'success' }} mb-0">
                        {{ $booking->status_label }}
                    </div>
                @endif
            </div>
        </div>

        {{-- DP Proof --}}
        @if($booking->dpPayment)
            <div class="card shadow-sm mt-4">
                <div class="card-header bg-white">
                    <h6 class="mb-0">Bukti Transfer DP</h6>
                </div>
                <div class="card-body text-center">
                    @if(str_contains($booking->dpPayment->proof_file, '.pdf'))
                        <a href="{{ Storage::url($booking->dpPayment->proof_file) }}" target="_blank" class="btn btn-outline-primary">
                            <i class="bi bi-file-pdf"></i> Lihat PDF
                        </a>
                    @else
                        <img src="{{ Storage::url($booking->dpPayment->proof_file) }}" class="img-fluid rounded" alt="Bukti DP">
                    @endif

                    <div class="mt-2">
                        <span class="badge bg-{{ $booking->dpPayment->status == 'verified' ? 'success' : ($booking->dpPayment->status == 'rejected' ? 'danger' : 'warning') }}">
                            {{ ucfirst($booking->dpPayment->status) }}
                        </span>
                    </div>

                    @if($booking->dpPayment->status === 'pending')
                        <div class="d-flex gap-2 mt-2">
                            <form method="POST" action="{{ route('admin.payments.verify', $booking->dpPayment) }}" class="flex-grow-1">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm w-100">Verifikasi</button>
                            </form>
                            <form method="POST" action="{{ route('admin.payments.reject', $booking->dpPayment) }}" class="flex-grow-1">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm w-100" onclick="return confirm('Tolak pembayaran ini?')">Tolak</button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
