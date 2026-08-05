@extends('layouts.admin')

@section('title', 'Kelola Paket')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Kelola Paket</h4>
    <a href="{{ route('admin.packages.create') }}" class="btn btn-primary">
        <i class="bi bi-plus"></i> Tambah Paket
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Paket</th>
                        <th>Harga</th>
                        <th>Minimal DP</th>
                        <th>Graduation</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($packages as $package)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><strong>{{ $package->name }}</strong></td>
                            <td>Rp {{ number_format($package->price, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($package->min_dp, 0, ',', '.') }}</td>
                            <td>
                                @if($package->is_graduation)
                                    <span class="badge bg-info">Ya</span>
                                @else
                                    <span class="badge bg-secondary">Tidak</span>
                                @endif
                            </td>
                            <td>
                                @if($package->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-danger">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.packages.edit', $package) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.packages.destroy', $package) }}" class="d-inline" onsubmit="return confirm('Hapus paket ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Belum ada paket</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
