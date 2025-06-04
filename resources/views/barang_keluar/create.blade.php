@extends('layouts.staff')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-box-open me-2"></i> Tambah Barang Keluar
                        </h5>
                        <a href="{{ url()->previous() }}" class="btn btn-light btn-sm">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </div>

                <div class="card-body p-4">
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                <div>
                                    <h6 class="mb-1"><strong>Error!</strong> Terdapat kesalahan dalam input data:</h6>
                                    <ul class="mb-0 ps-3">
                                        @foreach($errors->all() as $err)
                                            <li>{{ $err }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('barang-keluar.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        
                        <div class="mb-4">
                            <label for="nama_barang" class="form-label fw-semibold">Nama Barang</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-box text-primary"></i></span>
                                <input type="text" name="nama_barang" class="form-control" required placeholder="Masukkan nama barang">
                                <div class="invalid-feedback">
                                    Harap isi nama barang
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="jumlah" class="form-label fw-semibold">Jumlah</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-hashtag text-primary"></i></span>
                                <input type="number" name="jumlah" class="form-control" required placeholder="Masukkan jumlah barang" min="1">
                                <div class="invalid-feedback">
                                    Harap isi jumlah yang valid (minimal 1)
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="tanggal_keluar" class="form-label fw-semibold">Tanggal Keluar</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-calendar-alt text-primary"></i></span>
                                <input type="date" name="tanggal_keluar" class="form-control" required>
                                <div class="invalid-feedback">
                                    Harap pilih tanggal keluar
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="catatan" class="form-label fw-semibold">Catatan <span class="text-muted">(Opsional)</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-sticky-note text-primary"></i></span>
                                <textarea name="catatan" class="form-control" rows="3" placeholder="Tambahkan catatan (opsional)"></textarea>
                            </div>
                        </div>
                        
                        <div class="d-grid pt-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save me-2"></i> Simpan Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style>
    .card {
        border-radius: 0.5rem;
        overflow: hidden;
    }
    .card-header {
        border-bottom: none;
    }
    .form-control, .input-group-text {
        border-radius: 0.375rem;
    }
    .input-group-text {
        min-width: 45px;
        justify-content: center;
    }
    .btn-lg {
        padding: 0.5rem 1.5rem;
        font-size: 1.1rem;
    }
    .invalid-feedback {
        display: none;
        width: 100%;
        margin-top: 0.25rem;
        font-size: 0.875em;
        color: #dc3545;
    }
    .was-validated .form-control:invalid ~ .invalid-feedback,
    .form-control.is-invalid ~ .invalid-feedback {
        display: block;
    }
</style>
@endsection

@section('scripts')
<script>
// Bootstrap 5 form validation
(function () {
    'use strict'
    
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.querySelectorAll('.needs-validation')
    
    // Loop over them and prevent submission
    Array.prototype.slice.call(forms)
        .forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                
                form.classList.add('was-validated')
            }, false)
        })
})()
</script>
@endsection