@extends('layouts.admin')

@section('title', 'Edit Paket ' . $package->name)

@section('content')
<div class="page-header">
    <div></div>
    <a href="{{ route('admin.packages.index') }}" class="btn btn-admin" style="background:#F1F5F9;border:none;color:#64748B;">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="card-admin" style="max-width:720px;">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.packages.update', $package) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label" style="font-size:0.8125rem;font-weight:500;color:#475569;">Nama Paket</label>
                <input type="text" class="form-control form-control-admin @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $package->name) }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label" style="font-size:0.8125rem;font-weight:500;color:#475569;">Deskripsi</label>
                <textarea class="form-control form-control-admin @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $package->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <label for="price" class="form-label" style="font-size:0.8125rem;font-weight:500;color:#475569;">Harga</label>
                    <input type="number" class="form-control form-control-admin @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price', $package->price) }}" min="0" required>
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="min_dp" class="form-label" style="font-size:0.8125rem;font-weight:500;color:#475569;">Minimal DP</label>
                    <input type="number" class="form-control form-control-admin @error('min_dp') is-invalid @enderror" id="min_dp" name="min_dp" value="{{ old('min_dp', $package->min_dp) }}" min="0" required>
                    @error('min_dp')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row g-3 mt-1">
                <div class="col-md-6">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="is_graduation" name="is_graduation" value="1" {{ old('is_graduation', $package->is_graduation) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_graduation">Paket Graduation</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $package->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Aktif</label>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-admin btn-admin-primary">Simpan Perubahan</button>
                <a href="{{ route('admin.packages.index') }}" class="btn btn-admin" style="background:#F1F5F9;border:none;color:#64748B;">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
