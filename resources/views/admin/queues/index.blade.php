@extends('layouts.admin')

@section('title', 'Antrian')

@section('content')
<h4 class="mb-4">Sistem Antrian</h4>

<div class="row g-4">
    @forelse($studios as $studio)
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">{{ $studio->name }}</h6>
                        <span class="badge bg-light text-dark">{{ $studio->bookings->count() }} antrian</span>
                    </div>
                </div>
                <div class="card-body">
                    @if($studio->bookings->count())
                        <ul class="list-group list-group-flush">
                            @foreach($studio->bookings as $booking)
                                <li class="list-group-item d-flex justify-content-between align-items-center {{ $booking->status === 'in_progress' ? 'list-group-item-success' : '' }}">
                                    <div>
                                        <strong>{{ $booking->customer_name }}</strong>
                                    </div>
                                    <span class="badge bg-{{ $booking->status_color }}">
                                        {{ $booking->status_label }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>

                        @if($studio->bookings->where('status', 'waiting_queue')->count())
                            <form method="POST" action="{{ route('admin.queues.call-next', $studio) }}" class="mt-3">
                                @csrf
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bi bi-megaphone"></i> Panggil Berikutnya
                                </button>
                            </form>
                        @endif
                    @else
                        <p class="text-muted text-center mb-0">Tidak ada antrian</p>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body text-center text-muted">
                    Belum ada studio aktif
                </div>
            </div>
        </div>
    @endforelse
</div>
@endsection
