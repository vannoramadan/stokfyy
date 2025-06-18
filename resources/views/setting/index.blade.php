@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="mb-0"><i class="fas fa-cog me-2"></i>Pengaturan Umum Aplikasi</h3>
                <div class="badge bg-white text-primary p-2">
                    <i class="fas fa-info-circle me-1"></i> Konfigurasi Sistem
                </div>
            </div>
        </div>
        
        <form action="{{ route('setting.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="row">
                    <!-- Kolom Kiri - Pengaturan Dasar -->
                    <div class="col-md-6 border-end">
                        <h5 class="text-primary mb-4">
                            <i class="fas fa-info-circle me-2"></i>Informasi Dasar
                        </h5>
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold">Nama Aplikasi</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-signature text-primary"></i>
                                </span>
                                <input type="text" name="app_name" class="form-control" 
                                       value="{{ old('app_name', $app_name) }}" required
                                       placeholder="Masukkan nama aplikasi">
                            </div>
                            <small class="text-muted">Nama yang akan ditampilkan di header dan title</small>
                        </div>
 <!-- #region -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Mata Uang Default</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-money-bill-wave text-primary"></i>
                                </span>
                                <select name="currency" class="form-select" required>
                                    <option value="IDR" {{ $app_currency == 'IDR' ? 'selected' : '' }}>IDR (Rupiah Indonesia)</option>
                                    <option value="USD" {{ $app_currency == 'USD' ? 'selected' : '' }}>USD (Dollar Amerika)</option>
                                    <option value="EUR" {{ $app_currency == 'EUR' ? 'selected' : '' }}>EUR (Euro Eropa)</option>
                                </select>
                            </div>
                            <small class="text-muted">Mata uang yang digunakan untuk transaksi</small>
                        </div>
 <!-- #endregion -->


                        <div class="mb-4">
                            <label class="form-label fw-bold">Zona Waktu</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-clock text-primary"></i>
                                </span>
                                <select name="timezone" class="form-select" required>
                                    @foreach(timezone_identifiers_list() as $tz)
                                    <option value="{{ $tz }}" {{ $app_timezone == $tz ? 'selected' : '' }}>
                                        {{ $tz }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <small class="text-muted">Zona waktu untuk tampilan tanggal dan waktu</small>
                        </div>
                    </div>

                    <!-- Kolom Kanan - Logo dan Favicon -->
                    <div class="col-md-6">
                        <h5 class="text-primary mb-4">
                            <i class="fas fa-image me-2"></i>Tampilan & Branding
                        </h5>
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold">Logo Aplikasi</label>
                            <div class="card border-dashed p-3">
                                <input type="file" name="logo" class="form-control" accept="image/png,image/jpeg">
                                <small class="text-muted d-block mt-1">Format: PNG/JPG, Ukuran maksimal: 2MB</small>
                                
                                @if($app_logo)
                                    <div class="mt-3 p-2 border rounded text-center">
                                        <img src="{{ asset($app_logo) }}" alt="Logo Saat Ini" class="img-fluid" style="max-height: 80px">
                                        <small class="d-block text-muted mt-1">Logo saat ini</small>
                                    </div>
                                @endif
                            </div>
                        </div>                                                      

                        <div class="mb-4">
                            <label class="form-label fw-bold">Favicon</label>
                            <div class="card border-dashed p-3">
                                <input type="file" name="favicon" class="form-control" accept="image/png,image/x-icon">
                                <small class="text-muted d-block mt-1">Format: PNG/ICO, Ukuran: 32x32px</small>
                                
                                @if($app_favicon)
                                    <div class="mt-3 p-2 border rounded text-center">
                                        <img src="{{ asset($app_favicon) }}" alt="Favicon Saat Ini" style="height: 32px">
                                        <small class="d-block text-muted mt-1">Favicon saat ini</small>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer bg-light border-top">
                <div class="d-flex justify-content-between">
                    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-save me-2"></i>Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection