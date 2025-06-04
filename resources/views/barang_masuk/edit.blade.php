@extends('layouts.staff')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0 rounded-lg">
        <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">
                    <i class="bi bi-pencil-square me-2"></i>Edit Barang Masuk
                </h4>
                <a href="{{ route('barang-masuk.index') }}" class="btn btn-light btn-sm">
                    <i class="bi bi-arrow-left me-1"></i>Kembali ke Daftar
                </a>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('barang-masuk.update', $barangMasuk->id) }}" method="POST">
                @csrf 
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="nama_barang" 
                                   name="nama_barang" value="{{ $barangMasuk->nama_barang }}" 
                                   placeholder="Nama Barang" required>
                            <label for="nama_barang" class="fw-semibold">
                                <i class="bi bi-box-seam me-1"></i>Nama Barang
                            </label>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" id="jumlah" 
                                   name="jumlah" value="{{ $barangMasuk->jumlah }}" 
                                   placeholder="Jumlah" required>
                            <label for="jumlah" class="fw-semibold">
                                <i class="bi bi-123 me-1"></i>Jumlah
                            </label>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <input type="date" class="form-control" id="tanggal_masuk" 
                                   name="tanggal_masuk" value="{{ $barangMasuk->tanggal_masuk }}" 
                                   required>
                            <label for="tanggal_masuk" class="fw-semibold">
                                <i class="bi bi-calendar-date me-1"></i>Tanggal Masuk
                            </label>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="keterangan" 
                                   name="keterangan" value="{{ $barangMasuk->keterangan ?? '' }}" 
                                   placeholder="Keterangan">
                            <label for="keterangan" class="fw-semibold">
                                <i class="bi bi-info-circle me-1"></i>Keterangan (Opsional)
                            </label>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" 
                            data-bs-target="#deleteModal">
                        <i class="bi bi-trash me-1"></i>Hapus Data
                    </button>

                    <div>
                        <a href="{{ route('barang-masuk.index') }}" class="btn btn-secondary me-2">
                            <i class="bi bi-x-circle me-1"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-1"></i>Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="bi bi-exclamation-triangle me-2"></i>Konfirmasi Penghapusan
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus data barang masuk ini?</p>
                <p class="fw-bold">Nama Barang: {{ $barangMasuk->nama_barang ?? 'Barang tidak ditemukan' }}</p>
                <p class="text-muted">Data yang dihapus tidak dapat dikembalikan.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg me-1"></i>Batal
                </button>
                <form action="{{ route('barang-masuk.destroy', $barangMasuk->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-1"></i>Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        border: none;
        transition: all 0.3s ease;
    }

    .form-floating label {
        color: #495057;
    }

    .form-control:focus {
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        border-color: #86b7fe;
    }

    .btn-primary {
        background-color: #0d6efd;
        border: none;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #0b5ed7;
        transform: translateY(-1px);
    }

    .btn-outline-danger {
        transition: all 0.3s ease;
    }

    .btn-outline-danger:hover {
        background-color: #dc3545;
        color: white;
    }
</style>
@endsection
