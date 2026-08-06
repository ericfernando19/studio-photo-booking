@extends('layouts.admin')

@section('title', 'Kelola Paket')

@section('content')
<div class="page-header">
    <div></div>
    <a href="{{ route('admin.packages.create') }}" class="btn btn-admin btn-admin-primary">
        <i class="bi bi-plus-lg me-1"></i> Tambah Paket
    </a>
</div>

<div class="card-admin">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-admin mb-0">
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
                            <td style="color:#64748B;">{{ $loop->iteration }}</td>
                            <td><span style="font-weight:600;">{{ $package->name }}</span></td>
                            <td style="font-family:'JetBrains Mono',monospace;font-weight:500;">Rp {{ number_format($package->price, 0, ',', '.') }}</td>
                            <td style="font-family:'JetBrains Mono',monospace;">Rp {{ number_format($package->min_dp, 0, ',', '.') }}</td>
                            <td>
                                @if($package->is_graduation)
                                    <span class="badge-status" style="background:#ECFEFF;color:#0891B2;">Ya</span>
                                @else
                                    <span class="badge-status" style="background:#F1F5F9;color:#64748B;">Tidak</span>
                                @endif
                            </td>
                            <td>
                                @if($package->is_active)
                                    <span class="badge-status" style="background:#ECFDF5;color:#059669;">Aktif</span>
                                @else
                                    <span class="badge-status" style="background:#FEF2F2;color:#DC2626;">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.packages.edit', $package) }}" class="btn btn-sm btn-outline-warning" style="border-radius:6px;">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.packages.destroy', $package) }}" class="d-inline" onsubmit="return confirm('Hapus paket ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" style="border-radius:6px;">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted" style="padding:2rem;">Belum ada paket</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
