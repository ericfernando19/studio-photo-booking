@extends('layouts.admin')

@section('title', 'Kelola Studio')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Kelola Studio</h4>
    <a href="{{ route('admin.studios.create') }}" class="btn btn-primary">
        <i class="bi bi-plus"></i> Tambah Studio
    </a>
</div>

<div class="row g-3">
    @forelse($studios as $studio)
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h5 class="card-title">{{ $studio->name }}</h5>
                            <p class="text-muted mb-2">{{ $studio->description ?? 'Tidak ada deskripsi' }}</p>
                            <span class="badge bg-{{ $studio->is_active ? 'success' : 'danger' }}">
                                {{ $studio->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </div>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.studios.edit', $studio) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.studios.destroy', $studio) }}" class="d-inline" onsubmit="return confirm('Hapus studio ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
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
            <div class="card shadow-sm">
                <div class="card-body text-center text-muted">
                    Belum ada studio
                </div>
            </div>
        </div>
    @endforelse
</div>
@endsection
