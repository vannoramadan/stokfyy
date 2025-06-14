@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Supplier Baru</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                
                <li class="breadcrumb-item"><a href="{{ route('suppliers.index') }}">Supplier</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah Baru</li>
            </ol>
        </nav>
    </div>

    <!-- Form Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-primary text-white">
            <h6 class="m-0 font-weight-bold">Form Data Supplier</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('suppliers.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <!-- Kolom Kiri -->
                    <div class="col-md-6">
                        <div class="mb-4">
                            <label for="name" class="form-label fw-bold">Nama Supplier <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="email" class="form-label fw-bold">Email</label>
                            <input type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Kolom Kanan -->
                    <div class="col-md-6">
                        <div class="mb-4">
                            <label for="phone" class="form-label fw-bold">Nomor Telepon</label>
                            <input type="text" class="form-control form-control-lg @error('phone') is-invalid @enderror" 
                                   id="phone" name="phone" value="{{ old('phone') }}"
                                   placeholder="Contoh: 081234567890">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="mb-4">
                    <label for="address" class="form-label fw-bold">Alamat Lengkap</label>
                    <textarea class="form-control @error('address') is-invalid @enderror" 
                              id="address" name="address" rows="3">{{ old('address') }}</textarea>
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- Informasi Tambahan -->
                <div class="mb-4 border-top pt-3">
                    <h6 class="fw-bold">
                        <i class="fas fa-info-circle me-2"></i>Informasi Tambahan
                        <small class="text-muted fs-6">(Opsional)</small>
                    </h6>
                    
                    <div class="row mt-2">
                        <div class="col-md-4">
                            <label for="pic_name" class="form-label">Nama PIC</label>
                            <input type="text" class="form-control" id="pic_name" name="pic_name" 
                                   value="{{ old('pic_name') }}" placeholder="Nama Penanggung Jawab">
                        </div>
                        <div class="col-md-4">
                            <label for="pic_phone" class="form-label">Telepon PIC</label>
                            <input type="text" class="form-control" id="pic_phone" name="pic_phone" 
                                   value="{{ old('pic_phone') }}" placeholder="Nomor Telepon PIC">
                        </div>
                        <div class="col-md-4">
                            <label for="bank_account" class="form-label">Rekening Bank</label>
                            <input type="text" class="form-control" id="bank_account" name="bank_account" 
                                   value="{{ old('bank_account') }}" placeholder="Nomor Rekening">
                        </div>
                    </div>
                </div>
                
                <!-- Tombol Aksi -->
                <div class="d-flex justify-content-between border-top pt-4">
                    <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Simpan Supplier
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .form-control-lg {
        padding: 0.75rem 1rem;
        font-size: 1rem;
    }
    .card-header {
        border-radius: 0.35rem 0.35rem 0 0 !important;
    }
</style>
@endpush