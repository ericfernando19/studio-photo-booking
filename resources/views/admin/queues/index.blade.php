@extends('layouts.admin')

@section('title', 'Antrian')

@section('content')
<div class="row g-4">
    @forelse($studios as $studio)
        <div class="col-md-6 col-xl-4">
            <div class="card-admin h-100">
                <div class="card-header" style="background:linear-gradient(135deg,#1E1B4B,#312E81);border-bottom:none;border-radius:12px 12px 0 0;">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0" style="color:#fff;font-weight:600;">{{ $studio->name }}</h6>
                        <span style="font-family:'JetBrains Mono',monospace;font-size:0.75rem;font-weight:600;background:rgba(255,255,255,0.15);color:#fff;padding:0.25rem 0.625rem;border-radius:6px;">{{ $studio->bookings->count() }} antrian</span>
                    </div>
                </div>
                <div class="card-body">
                    @if($studio->bookings->count())
                        <div style="display:flex;flex-direction:column;gap:0.5rem;">
                            @foreach($studio->bookings as $booking)
                                <div style="display:flex;justify-content:space-between;align-items:center;padding:0.625rem 0.75rem;border-radius:8px;background:{{ $booking->status === 'in_progress' ? '#ECFDF5' : '#F8FAFC' }};border:1px solid {{ $booking->status === 'in_progress' ? '#A7F3D0' : '#E2E8F0' }};">
                                    <span style="font-weight:500;font-size:0.875rem;">{{ $booking->customer_name }}</span>
                                    <span class="badge-status bg-{{ $booking->status_color }}">{{ $booking->status_label }}</span>
                                </div>
                            @endforeach
                        </div>

                        @if($studio->bookings->where('status', 'waiting_queue')->count())
                            <form method="POST" action="{{ route('admin.queues.call-next', $studio) }}" class="mt-3">
                                @csrf
                                <button type="submit" class="btn btn-admin w-100" style="background:#4F46E5;border:none;color:#fff;">
                                    <i class="bi bi-megaphone me-1"></i> Panggil Berikutnya
                                </button>
                            </form>
                        @endif
                    @else
                        <div class="text-center text-muted" style="padding:1.5rem;">
                            <i class="bi bi-inbox" style="font-size:1.5rem;color:#CBD5E1;"></i>
                            <div style="margin-top:0.5rem;font-size:0.875rem;">Tidak ada antrian</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="card-admin">
                <div class="card-body text-center text-muted" style="padding:2rem;">
                    <i class="bi bi-building" style="font-size:2rem;color:#CBD5E1;"></i>
                    <div style="margin-top:0.75rem;">Belum ada studio aktif</div>
                </div>
            </div>
        </div>
    @endforelse
</div>
@endsection
