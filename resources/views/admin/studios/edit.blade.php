@extends('layouts.admin')

@section('title', 'Edit Studio ' . $studio->name)

@section('content')
<div class="page-header">
    <div></div>
    <a href="{{ route('admin.studios.index') }}" class="btn btn-admin" style="background:#F1F5F9;border:none;color:#64748B;">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="card-admin" style="max-width:560px;">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.studios.update', $studio) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label" style="font-size:0.8125rem;font-weight:500;color:#475569;">Nama Studio</label>
                <input type="text" class="form-control form-control-admin @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $studio->name) }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label" style="font-size:0.8125rem;font-weight:500;color:#475569;">Deskripsi</label>
                <textarea class="form-control form-control-admin @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $studio->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $studio->is_active) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">Aktif</label>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-admin btn-admin-primary">Simpan Perubahan</button>
                <a href="{{ route('admin.studios.index') }}" class="btn btn-admin" style="background:#F1F5F9;border:none;color:#64748B;">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
