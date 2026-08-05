@extends('layouts.admin')

@section('title', 'Tambah Paket')

@section('content')
<h4 class="mb-4">Tambah Paket</h4>

<div class="card shadow-sm">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.packages.store') }}">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Nama Paket</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="price" class="form-label">Harga</label>
                    <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price') }}" min="0" required>
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="min_dp" class="form-label">Minimal DP</label>
                    <input type="number" class="form-control @error('min_dp') is-invalid @enderror" id="min_dp" name="min_dp" value="{{ old('min_dp') }}" min="0" required>
                    @error('min_dp')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="is_graduation" name="is_graduation" value="1" {{ old('is_graduation') ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_graduation">Paket Graduation</label>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Aktif</label>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.packages.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
