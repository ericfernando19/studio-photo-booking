@extends('layouts.admin')

@section('title', 'Pengaturan')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css">
<style>
    .logo-upload-area {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        padding: 1.5rem;
        background: #F8FAFC;
        border: 1px solid #E2E8F0;
        border-radius: 12px;
        margin-bottom: 1rem;
    }
    .logo-preview-circle {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        overflow: hidden;
        border: 3px solid #E2E8F0;
        background: #fff;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .logo-preview-circle img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .logo-preview-circle .placeholder {
        color: #CBD5E1;
        font-size: 2.5rem;
    }
    .logo-info { flex: 1; }
    .logo-info p { color: #64748B; font-size: 0.8125rem; margin-bottom: 0.75rem; }
    .btn-upload { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.5rem 1rem; background: #4F46E5; color: #fff; border: none; border-radius: 8px; font-size: 0.8125rem; font-weight: 500; cursor: pointer; }
    .btn-upload:hover { background: #4338CA; }
    .btn-remove { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.5rem 1rem; background: #FEF2F2; color: #DC2626; border: 1px solid #FECACA; border-radius: 8px; font-size: 0.8125rem; font-weight: 500; cursor: pointer; margin-left: 0.5rem; }
    .btn-remove:hover { background: #FEE2E2; }

    .crop-modal .modal-content { border: none; border-radius: 16px; }
    .crop-modal .modal-header { border-bottom: 1px solid #E2E8F0; padding: 1rem 1.25rem; }
    .crop-modal .modal-body { padding: 1.25rem; }
    .crop-modal .modal-footer { border-top: 1px solid #E2E8F0; padding: 1rem 1.25rem; }
    .crop-area { max-height: 400px; background: #1E293B; border-radius: 8px; overflow: hidden; }
    .crop-area img { max-width: 100%; display: block; }
    .crop-preview-row { display: flex; gap: 1rem; margin-top: 1rem; align-items: center; }
    .crop-preview-box { width: 80px; height: 80px; border-radius: 50%; overflow: hidden; border: 2px solid #E2E8F0; background: #fff; flex-shrink: 0; }
    .crop-preview-box img { width: 100%; height: 100%; object-fit: cover; }
</style>
@endpush

@section('content')
<div class="card-admin" style="max-width:720px;">
    <div class="card-header">
        <h6 class="mb-0" style="font-weight:600;">Pengaturan Studio</h6>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" id="settingsForm">
            @csrf

            <div class="mb-4">
                <label class="form-label" style="font-size:0.8125rem;font-weight:500;color:#475569;">Logo Studio</label>
                <div class="logo-upload-area">
                    <div class="logo-preview-circle" id="logoPreview">
                        @if($settings['studio_logo'])
                            <img src="{{ Storage::url($settings['studio_logo']) }}" id="currentLogo" alt="Logo">
                        @else
                            <span class="placeholder"><i class="bi bi-camera"></i></span>
                        @endif
                    </div>
                    <div class="logo-info">
                        <p>Upload logo studio. Logo akan ditampilkan di halaman booking, invoice, dan kwitansi.</p>
                        <button type="button" class="btn-upload" onclick="document.getElementById('studio_logo').click()">
                            <i class="bi bi-upload"></i> Pilih Logo
                        </button>
                        @if($settings['studio_logo'])
                            <button type="button" class="btn-remove" onclick="removeLogo()">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        @endif
                        <input type="file" id="studio_logo" name="studio_logo" accept="image/*" style="display:none;" onchange="openCropModal(this)">
                    </div>
                </div>
                @error('studio_logo')
                    <div style="color:#DC2626;font-size:0.75rem;margin-top:0.25rem;">{{ $message }}</div>
                @enderror
                <small style="color:#64748B;">Format: JPG, PNG, SVG. Maks 2MB. Logo akan otomatis dipotong menjadi lingkaran.</small>
            </div>

            <input type="hidden" name="cropped_image" id="croppedImage">
            <input type="hidden" name="remove_logo" id="removeLogo" value="0">

            <div class="mb-3">
                <label for="studio_name" class="form-label" style="font-size:0.8125rem;font-weight:500;color:#475569;">Nama Studio</label>
                <input type="text" class="form-control form-control-admin @error('studio_name') is-invalid @enderror" id="studio_name" name="studio_name" value="{{ old('studio_name', $settings['studio_name']) }}" required>
                @error('studio_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="studio_address" class="form-label" style="font-size:0.8125rem;font-weight:500;color:#475569;">Alamat</label>
                <textarea class="form-control form-control-admin @error('studio_address') is-invalid @enderror" id="studio_address" name="studio_address" rows="3">{{ old('studio_address', $settings['studio_address']) }}</textarea>
                @error('studio_address')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <label for="studio_phone" class="form-label" style="font-size:0.8125rem;font-weight:500;color:#475569;">No. Telepon</label>
                    <input type="text" class="form-control form-control-admin @error('studio_phone') is-invalid @enderror" id="studio_phone" name="studio_phone" value="{{ old('studio_phone', $settings['studio_phone']) }}">
                    @error('studio_phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="studio_email" class="form-label" style="font-size:0.8125rem;font-weight:500;color:#475569;">Email</label>
                    <input type="email" class="form-control form-control-admin @error('studio_email') is-invalid @enderror" id="studio_email" name="studio_email" value="{{ old('studio_email', $settings['studio_email']) }}">
                    @error('studio_email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-admin btn-admin-primary">Simpan Pengaturan</button>
            </div>
        </form>
    </div>
</div>

{{-- Crop Modal --}}
<div class="modal fade crop-modal" id="cropModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="font-weight:600;">Potong Logo</h5>
            </div>
            <div class="modal-body">
                <p style="font-size:0.8125rem;color:#64748B;margin-bottom:0.75rem;">Geser dan zoom untuk menyesuaikan area yang ingin digunakan sebagai logo.</p>
                <div class="crop-area">
                    <img id="cropperImage" src="" alt="Crop">
                </div>
                <div class="crop-preview-row">
                    <div class="crop-preview-box" id="cropPreviewBox">
                        <img id="cropPreviewImg" src="" alt="Preview">
                    </div>
                    <div>
                        <small style="font-weight:600;color:#1E293B;">Preview Logo</small><br>
                        <small style="color:#64748B;">Ini akan tampil di sidebar & halaman booking</small>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-admin" style="background:#F1F5F9;border:none;color:#64748B;" onclick="cancelCrop()">Batal</button>
                <button type="button" class="btn btn-admin btn-admin-primary" onclick="applyCrop()">
                    <i class="bi bi-check-lg me-1"></i> Gunakan Logo Ini
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
<script>
    var cropper = null;
    var cropModal = document.getElementById('cropModal');
    var cropperImage = document.getElementById('cropperImage');
    var preview = document.getElementById('logoPreview');

    function openCropModal(input) {
        if (input.files && input.files[0]) {
            var file = input.files[0];
            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran file maksimal 2MB');
                input.value = '';
                return;
            }

            var reader = new FileReader();
            reader.onload = function(e) {
                cropperImage.src = e.target.result;
                document.getElementById('cropPreviewImg').src = e.target.result;

                var modal = new bootstrap.Modal(cropModal);
                modal.show();

                setTimeout(function() {
                    if (cropper) {
                        cropper.destroy();
                    }
                    cropper = new Cropper(cropperImage, {
                        aspectRatio: 1,
                        viewMode: 1,
                        autoCropArea: 1,
                        responsive: true,
                        background: false,
                        crop: function(event) {
                            var canvas = cropper.getCroppedCanvas({ width: 200, height: 200 });
                            document.getElementById('cropPreviewImg').src = canvas.toDataURL();
                        }
                    });
                }, 300);
            }
            reader.readAsDataURL(file);
        }
    }

    function applyCrop() {
        if (cropper) {
            var canvas = cropper.getCroppedCanvas({ width: 400, height: 400 });
            var dataUrl = canvas.toDataURL('image/png');
            document.getElementById('croppedImage').value = dataUrl;
            preview.innerHTML = '<img src="' + dataUrl + '" alt="Logo">';

            var modal = bootstrap.Modal.getInstance(cropModal);
            modal.hide();

            cropper.destroy();
            cropper = null;
        }
    }

    function cancelCrop() {
        var modal = bootstrap.Modal.getInstance(cropModal);
        modal.hide();
        document.getElementById('studio_logo').value = '';
        document.getElementById('croppedImage').value = '';

        if (cropper) {
            cropper.destroy();
            cropper = null;
        }
    }

    function removeLogo() {
        if (confirm('Yakin ingin menghapus logo?')) {
            document.getElementById('removeLogo').value = '1';
            preview.innerHTML = '<span class="placeholder"><i class="bi bi-camera"></i></span>';
            document.querySelector('.btn-remove').style.display = 'none';
        }
    }
</script>
@endpush
