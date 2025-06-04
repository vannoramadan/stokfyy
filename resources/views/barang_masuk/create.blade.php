{{-- resources/views/staff/barang-masuk/create.blade.php --}}
@extends('layouts.staff')

@section('content')
<div class="container py-4">
    <div class="card shadow-lg border-0 rounded-lg">
        <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">
                    <i class="bi bi-box-arrow-in-down me-2"></i>Tambah Barang Masuk
                </h4>
                <a href="{{ route('barang-masuk.index') }}" class="btn btn-light btn-sm">
                    <i class="bi bi-arrow-left me-1"></i>Kembali
                </a>
            </div>
        </div>
        
        <div class="card-body">
            <form action="{{ route('barang-masuk.store') }}" method="POST">
                @csrf
                
                <div class="row mb-4">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Nama Barang</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="bi bi-box-seam text-primary"></i>
                            </span>
                            <input type="text" name="nama_barang" class="form-control" required
                                   placeholder="Masukkan nama barang">
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Jumlah</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="bi bi-123 text-primary"></i>
                            </span>
                            <input type="number" name="jumlah" class="form-control" required
                                   placeholder="Masukkan jumlah">
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Tanggal Masuk</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="bi bi-calendar-date text-primary"></i>
                            </span>
                            <input type="date" name="tanggal_masuk" class="form-control" required>
                        </div>
                    </div>
                </div>
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                    <button type="reset" class="btn btn-outline-secondary me-md-2">
                        <i class="bi bi-arrow-counterclockwise me-1"></i>Reset
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save me-1"></i>Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
