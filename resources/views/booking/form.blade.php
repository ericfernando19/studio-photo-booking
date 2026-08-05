@extends('layouts.app')

@section('title', 'Form Booking')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h4 class="text-center mb-2"><i class="bi bi-camera"></i> Form Booking Studio Foto</h4>
                    <p class="text-center text-muted mb-4">Isi data di bawah ini untuk melakukan booking</p>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('booking.store') }}" enctype="multipart/form-data"
                        id="bookingForm">
                        @csrf

                        <h6 class="text-muted mb-3"><i class="bi bi-person"></i> Data Customer</h6>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="customer_name" class="form-label">Nama Lengkap <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('customer_name') is-invalid @enderror"
                                    id="customer_name" name="customer_name" value="{{ old('customer_name') }}" required>
                                @error('customer_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="customer_phone" class="form-label">Nomor HP <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('customer_phone') is-invalid @enderror"
                                    id="customer_phone" name="customer_phone" value="{{ old('customer_phone') }}"
                                    placeholder="08xxxxxxxxxx" required>
                                @error('customer_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr>

                        <h6 class="text-muted mb-3"><i class="bi bi-box-seam"></i> Data Booking</h6>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="package_id" class="form-label">Pilih Paket <span
                                        class="text-danger">*</span></label>
                                <select class="form-select @error('package_id') is-invalid @enderror" id="package_id"
                                    name="package_id" required>
                                    <option value="">-- Pilih Paket --</option>
                                    @foreach ($packages as $package)
                                        <option value="{{ $package->id }}" data-price="{{ $package->price }}"
                                            data-dp="{{ $package->min_dp }}"
                                            data-graduation="{{ $package->is_graduation ? '1' : '0' }}"
                                            {{ old('package_id') == $package->id ? 'selected' : '' }}>
                                            {{ $package->name }} - Rp
                                            {{ number_format($package->price, 0, ',', '.') }}{{ $package->is_graduation ? ' (Wisuda)' : '' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('package_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="booking_date" class="form-label">Hari & Tanggal Foto <span
                                        class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('booking_date') is-invalid @enderror"
                                    id="booking_date" name="booking_date" value="{{ old('booking_date') }}" required>
                                @error('booking_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div id="university-field" class="mb-3" style="display: none;">
                            <label for="university_name" class="form-label">Nama Universitas/Sekolah <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('university_name') is-invalid @enderror"
                                id="university_name" name="university_name" value="{{ old('university_name') }}">
                            @error('university_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr>

                        <h6 class="text-muted mb-3"><i class="bi bi-credit-card"></i> Pembayaran DP</h6>

                        <div id="dp-info" class="alert alert-info" style="display: none;">
                            <i class="bi bi-info-circle"></i> Minimal DP: <strong id="dp-amount">Rp 0</strong>
                            <hr class="my-2">
                            <p class="mb-1"><strong>Transfer ke:</strong></p>
                            <p class="mb-0">Bank BCA - <strong>1234567890</strong> (a.n. Studio Foto)</p>
                        </div>

                        <div class="mb-3">
                            <label for="dp_amount" class="form-label">Jumlah DP yang Dibayarkan <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('dp_amount') is-invalid @enderror" id="dp_amount" name="dp_amount" value="{{ old('dp_amount') }}" min="100000" placeholder="Minimal Rp 100.000" required>
                            @error('dp_amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="dp_proof" class="form-label">Upload Bukti Transfer DP <span
                                    class="text-danger">*</span></label>
                            <input type="file" class="form-control @error('dp_proof') is-invalid @enderror"
                                id="dp_proof" name="dp_proof" accept="image/jpeg,image/png,image/jpg,application/pdf"
                                required>
                            @error('dp_proof')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Format: JPG, PNG, PDF. Maksimal 5MB</small>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">
                                <i class="bi bi-send"></i> Kirim Booking
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var packageSelect = document.getElementById('package_id');
    var universityField = document.getElementById('university-field');
    var dpInfo = document.getElementById('dp-info');
    var dpAmount = document.getElementById('dp-amount');
    var bookingDate = document.getElementById('booking_date');

    // Set min date berdasarkan waktu device (besok)
    var tomorrow = new Date();
    tomorrow.setDate(tomorrow.getDate() + 1);
    var minDate = tomorrow.getFullYear() + '-' +
        String(tomorrow.getMonth() + 1).padStart(2, '0') + '-' +
        String(tomorrow.getDate()).padStart(2, '0');
    bookingDate.setAttribute('min', minDate);

    packageSelect.addEventListener('change', function() {
        var opt = this.options[this.selectedIndex];
        if (!opt || !opt.value) {
            universityField.style.display = 'none';
            dpInfo.style.display = 'none';
            return;
        }

        var isGrad = opt.getAttribute('data-graduation');
        var dp = opt.getAttribute('data-dp');

        universityField.style.display = isGrad === '1' ? 'block' : 'none';
        dpInfo.style.display = 'block';
        dpAmount.textContent = 'Rp ' + parseInt(dp || 0).toLocaleString('id-ID');
    });
});
</script>
@endpush
