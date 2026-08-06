@extends('layouts.admin')

@section('title', 'Kelola Studio')

@section('content')
<div class="page-header">
    <div></div>
    <a href="{{ route('admin.studios.create') }}" class="btn btn-admin btn-admin-primary">
        <i class="bi bi-plus-lg me-1"></i> Tambah Studio
    </a>
</div>

<div class="row g-3">
    @forelse($studios as $studio)
        <div class="col-md-6 col-xl-4">
            <div class="card-admin h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <h5 style="font-weight:600;margin-bottom:0.25rem;">{{ $studio->name }}</h5>
                            <p style="color:#64748B;font-size:0.875rem;margin-bottom:0.5rem;">{{ $studio->description ?? 'Tidak ada deskripsi' }}</p>
                            @if($studio->is_active)
                                <span class="badge-status" style="background:#ECFDF5;color:#059669;">Aktif</span>
                            @else
                                <span class="badge-status" style="background:#FEF2F2;color:#DC2626;">Nonaktif</span>
                            @endif
                        </div>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.studios.edit', $studio) }}" class="btn btn-sm btn-outline-warning" style="border-radius:6px;">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.studios.destroy', $studio) }}" class="d-inline" onsubmit="return confirm('Hapus studio ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" style="border-radius:6px;">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="card-admin">
                <div class="card-body text-center text-muted" style="padding:2rem;">
                    <i class="bi bi-building" style="font-size:2rem;color:#CBD5E1;"></i>
                    <div style="margin-top:0.75rem;">Belum ada studio</div>
                </div>
            </div>
        </div>
    @endforelse
</div>
@endsection
