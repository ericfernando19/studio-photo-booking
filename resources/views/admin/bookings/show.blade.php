@extends('layouts.admin')

@section('title', 'Detail Booking ' . $booking->booking_code)

@section('content')
<div class="page-header">
    <div></div>
    <a href="{{ route('admin.bookings.index') }}" class="btn btn-admin" style="background:#F1F5F9;border:none;color:#64748B;">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card-admin mb-4">
            <div class="card-header">
                <h6 class="mb-0" style="font-weight:600;">Informasi Booking</h6>
            </div>
            <div class="card-body">
                <div class="row g-3 mb-3">
                    <div class="col-sm-6">
                        <div style="font-size:0.75rem;font-weight:600;color:#64748B;text-transform:uppercase;letter-spacing:0.03em;margin-bottom:0.375rem;">Kode Booking</div>
                        <span style="font-family:'JetBrains Mono',monospace;font-weight:600;font-size:0.9375rem;background:#F1F5F9;padding:0.375rem 0.75rem;border-radius:6px;">{{ $booking->booking_code }}</span>
                    </div>
                    <div class="col-sm-6">
                        <div style="font-size:0.75rem;font-weight:600;color:#64748B;text-transform:uppercase;letter-spacing:0.03em;margin-bottom:0.375rem;">Status</div>
                        <span class="badge-status bg-{{ $booking->status_color }}" style="font-size:0.8125rem;padding:0.4em 0.75em;">{{ $booking->status_label }}</span>
                    </div>
                </div>

                <hr style="border-color:#E2E8F0;margin:1rem 0;">

                <div class="row g-3 mb-3">
                    <div class="col-sm-6">
                        <div style="font-size:0.75rem;font-weight:600;color:#64748B;text-transform:uppercase;letter-spacing:0.03em;margin-bottom:0.375rem;">Nama Customer</div>
                        <div style="font-weight:500;">{{ $booking->customer_name }}</div>
                    </div>
                    <div class="col-sm-6">
                        <div style="font-size:0.75rem;font-weight:600;color:#64748B;text-transform:uppercase;letter-spacing:0.03em;margin-bottom:0.375rem;">Nomor HP</div>
                        <div style="font-weight:500;">{{ $booking->customer_phone }}</div>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-sm-6">
                        <div style="font-size:0.75rem;font-weight:600;color:#64748B;text-transform:uppercase;letter-spacing:0.03em;margin-bottom:0.375rem;">Paket</div>
                        <div style="font-weight:500;">{{ $booking->package->name }}</div>
                    </div>
                    <div class="col-sm-6">
                        <div style="font-size:0.75rem;font-weight:600;color:#64748B;text-transform:uppercase;letter-spacing:0.03em;margin-bottom:0.375rem;">Harga Paket</div>
                        <div style="font-weight:500;font-family:'JetBrains Mono',monospace;">Rp {{ number_format($booking->package->price, 0, ',', '.') }}</div>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-sm-6">
                        <div style="font-size:0.75rem;font-weight:600;color:#64748B;text-transform:uppercase;letter-spacing:0.03em;margin-bottom:0.375rem;">Tanggal Booking</div>
                        <div style="font-weight:500;">{{ $booking->booking_date->format('d F Y') }}</div>
                    </div>
                    <div class="col-sm-6">
                        <div style="font-size:0.75rem;font-weight:600;color:#64748B;text-transform:uppercase;letter-spacing:0.03em;margin-bottom:0.375rem;">Studio</div>
                        <div style="font-weight:500;">{{ $booking->studio?->name ?? '-' }}</div>
                    </div>
                </div>

                @if($booking->university_name)
                    <div class="mb-3">
                        <div style="font-size:0.75rem;font-weight:600;color:#64748B;text-transform:uppercase;letter-spacing:0.03em;margin-bottom:0.375rem;">Universitas/Sekolah</div>
                        <div style="font-weight:500;">{{ $booking->university_name }}</div>
                    </div>
                @endif

                @if($booking->queue_number)
                    <div class="mb-3">
                        <div style="font-size:0.75rem;font-weight:600;color:#64748B;text-transform:uppercase;letter-spacing:0.03em;margin-bottom:0.375rem;">Nomor Antrian</div>
                        <span style="font-family:'JetBrains Mono',monospace;font-weight:600;font-size:1.25rem;color:#4F46E5;">{{ $booking->queue_number }}</span>
                    </div>
                @endif

                @if($booking->invoice_number)
                    <div class="mb-3">
                        <div style="font-size:0.75rem;font-weight:600;color:#64748B;text-transform:uppercase;letter-spacing:0.03em;margin-bottom:0.375rem;">Nomor Invoice</div>
                        <div class="d-flex align-items-center gap-2">
                            <span style="font-family:'JetBrains Mono',monospace;font-weight:500;font-size:0.875rem;background:#ECFDF5;padding:0.375rem 0.75rem;border-radius:6px;color:#059669;">{{ $booking->invoice_number }}</span>
                            <a href="{{ route('admin.payments.invoice', $booking) }}" class="btn btn-sm btn-outline-success" style="border-radius:6px;">
                                <i class="bi bi-download"></i>
                            </a>
                        </div>
                    </div>
                @endif

                @if($booking->notes)
                    <div class="mb-0">
                        <div style="font-size:0.75rem;font-weight:600;color:#64748B;text-transform:uppercase;letter-spacing:0.03em;margin-bottom:0.375rem;">Catatan</div>
                        <div style="font-weight:500;color:#475569;">{{ $booking->notes }}</div>
                    </div>
                @endif
            </div>
        </div>

        <div class="card-admin">
            <div class="card-header">
                <h6 class="mb-0" style="font-weight:600;">Riwayat Pembayaran</h6>
            </div>
            <div class="card-body p-0">
                @if($booking->payments->count())
                    <div class="table-responsive">
                        <table class="table table-admin mb-0">
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
                                        <td style="font-family:'JetBrains Mono',monospace;font-weight:500;">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                                        <td>{{ $payment->method_label }}</td>
                                        <td>
                                            <span class="badge-status bg-{{ $payment->status == 'verified' ? 'success' : ($payment->status == 'rejected' ? 'danger' : 'warning') }}">
                                                {{ ucfirst($payment->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $payment->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="p-3" style="background:#F8FAFC;border-top:1px solid #E2E8F0;">
                        <div class="d-flex justify-content-between">
                            <span style="font-weight:600;">Total Dibayar</span>
                            <span style="font-family:'JetBrains Mono',monospace;font-weight:700;color:#059669;">Rp {{ number_format($booking->total_paid, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mt-1">
                            <span style="font-weight:500;color:#64748B;">Sisa Pembayaran</span>
                            <span style="font-family:'JetBrains Mono',monospace;font-weight:600;color:{{ $booking->remaining_amount > 0 ? '#D97706' : '#059669' }};">Rp {{ number_format($booking->remaining_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                @else
                    <div class="text-center text-muted" style="padding:2rem;">Belum ada pembayaran</div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card-admin mb-4">
            <div class="card-header">
                <h6 class="mb-0" style="font-weight:600;">Kelola Status</h6>
            </div>
            <div class="card-body">
                @if($booking->status === 'waiting_verification')
                    <form method="POST" action="{{ route('admin.bookings.verify', $booking) }}" class="mb-2">
                        @csrf
                        <button type="submit" class="btn btn-admin w-100" style="background:#059669;border:none;color:#fff;">
                            <i class="bi bi-check-circle me-1"></i> Verifikasi Booking
                        </button>
                    </form>
                    <form method="POST" action="{{ route('admin.bookings.reject', $booking) }}">
                        @csrf
                        <button type="submit" class="btn btn-admin w-100" style="background:#FEF2F2;border:1px solid #FECACA;color:#DC2626;" onclick="return confirm('Tolak booking ini?')">
                            <i class="bi bi-x-circle me-1"></i> Tolak Booking
                        </button>
                    </form>
                @elseif($booking->status !== 'cancelled' && $booking->status !== 'completed')
                    <form method="POST" action="{{ route('admin.bookings.status', $booking) }}">
                        @csrf
                        <div class="mb-3">
                            <select name="status" class="form-select form-select-admin">
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
                        <button type="submit" class="btn btn-admin btn-admin-primary w-100">
                            <i class="bi bi-check2-all me-1"></i> Update Status
                        </button>
                    </form>

                    @if($booking->status === 'customer_present' && !$booking->isFullyPaid())
                        <hr style="border-color:#E2E8F0;margin:1.25rem 0;">
                        <div style="font-weight:600;font-size:0.875rem;margin-bottom:0.75rem;">Pelunasan</div>
                        <form method="POST" action="{{ route('admin.payments.process', $booking) }}">
                            @csrf
                            <div class="mb-2">
                                <label class="form-label" style="font-size:0.8125rem;">Sisa: <span style="font-family:'JetBrains Mono',monospace;font-weight:600;">Rp {{ number_format($booking->remaining_amount, 0, ',', '.') }}</span></label>
                                <input type="number" class="form-control form-control-admin" name="amount" value="{{ $booking->remaining_amount }}" min="0" required>
                            </div>
                            <input type="hidden" name="method" value="transfer">
                            <button type="submit" class="btn btn-admin w-100" style="background:#059669;border:none;color:#fff;" onclick="return confirm('Proses pelunasan?')">
                                <i class="bi bi-cash me-1"></i> Proses Pelunasan
                            </button>
                        </form>
                    @endif

                    @if($booking->status === 'paid' || $booking->status === 'waiting_queue' || $booking->status === 'in_progress')
                        <hr style="border-color:#E2E8F0;margin:1.25rem 0;">
                        <div style="font-weight:600;font-size:0.875rem;margin-bottom:0.75rem;">Tugaskan Studio</div>
                        <form method="POST" action="{{ route('admin.queues.assign', $booking) }}">
                            @csrf
                            <div class="mb-2">
                                <select name="studio_id" class="form-select form-select-admin" required>
                                    <option value="">Pilih Studio</option>
                                    @foreach(\App\Models\Studio::where('is_active', true)->get() as $studio)
                                        <option value="{{ $studio->id }}">{{ $studio->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-admin w-100" style="background:#0891B2;border:none;color:#fff;">
                                <i class="bi bi-building me-1"></i> Tugaskan Studio
                            </button>
                        </form>
                    @endif

                    @if($booking->status === 'paid')
                        <form method="POST" action="{{ route('admin.bookings.status', $booking) }}" class="mt-2">
                            @csrf
                            <input type="hidden" name="status" value="waiting_queue">
                            <button type="submit" class="btn btn-admin w-100" style="background:#F1F5F9;border:none;color:#475569;">
                                <i class="bi bi-list-ol me-1"></i> Masuk Antrian
                            </button>
                        </form>
                    @endif

                    @if($booking->status === 'waiting_queue')
                        <form method="POST" action="{{ route('admin.bookings.status', $booking) }}" class="mt-2">
                            @csrf
                            <input type="hidden" name="status" value="in_progress">
                            <button type="submit" class="btn btn-admin w-100" style="background:#7C3AED;border:none;color:#fff;">
                                <i class="bi bi-camera me-1"></i> Mulai Foto
                            </button>
                        </form>
                    @endif

                    @if($booking->status === 'in_progress')
                        <form method="POST" action="{{ route('admin.bookings.status', $booking) }}" class="mt-2">
                            @csrf
                            <input type="hidden" name="status" value="completed">
                            <button type="submit" class="btn btn-admin w-100" style="background:#1E293B;border:none;color:#fff;">
                                <i class="bi bi-check-all me-1"></i> Selesai
                            </button>
                        </form>
                    @endif

                    <form method="POST" action="{{ route('admin.bookings.cancel', $booking) }}" class="mt-3">
                        @csrf
                        <button type="submit" class="btn btn-admin w-100" style="background:#fff;border:1px solid #FECACA;color:#DC2626;" onclick="return confirm('Batalkan booking ini?')">
                            <i class="bi bi-x-lg me-1"></i> Batalkan
                        </button>
                    </form>
                @else
                    <div class="text-center py-3">
                        <i class="bi bi-{{ $booking->status === 'cancelled' ? 'x-circle' : 'check-circle' }}" style="font-size:2.5rem;color:{{ $booking->status === 'cancelled' ? '#DC2626' : '#059669' }};"></i>
                        <div style="font-weight:600;margin-top:0.75rem;color:{{ $booking->status === 'cancelled' ? '#DC2626' : '#059669' }};">{{ $booking->status_label }}</div>
                    </div>
                @endif
            </div>
        </div>

        @if($booking->dpPayment)
            <div class="card-admin">
                <div class="card-header">
                    <h6 class="mb-0" style="font-weight:600;">Bukti Transfer DP</h6>
                </div>
                <div class="card-body text-center">
                    @if(str_contains($booking->dpPayment->proof_file, '.pdf'))
                        <a href="{{ Storage::url($booking->dpPayment->proof_file) }}" target="_blank" class="btn btn-admin" style="background:#F1F5F9;border:none;color:#4F46E5;">
                            <i class="bi bi-file-pdf me-1"></i> Lihat PDF
                        </a>
                    @else
                        <img src="{{ Storage::url($booking->dpPayment->proof_file) }}" class="img-fluid" style="border-radius:8px;max-height:200px;" alt="Bukti DP">
                    @endif

                    <div class="mt-2">
                        <span class="badge-status bg-{{ $booking->dpPayment->status == 'verified' ? 'success' : ($booking->dpPayment->status == 'rejected' ? 'danger' : 'warning') }}">
                            {{ ucfirst($booking->dpPayment->status) }}
                        </span>
                    </div>

                    @if($booking->dpPayment->status === 'pending')
                        <div class="d-flex gap-2 mt-3">
                            <form method="POST" action="{{ route('admin.payments.verify', $booking->dpPayment) }}" class="flex-grow-1">
                                @csrf
                                <button type="submit" class="btn btn-admin w-100" style="background:#059669;border:none;color:#fff;font-size:0.8125rem;">Verifikasi</button>
                            </form>
                            <form method="POST" action="{{ route('admin.payments.reject', $booking->dpPayment) }}" class="flex-grow-1">
                                @csrf
                                <button type="submit" class="btn btn-admin w-100" style="background:#FEF2F2;border:1px solid #FECACA;color:#DC2626;font-size:0.8125rem;" onclick="return confirm('Tolak pembayaran ini?')">Tolak</button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
