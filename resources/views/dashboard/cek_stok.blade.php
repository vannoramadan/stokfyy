@extends('layouts.staff')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm animate__animated animate__fadeIn">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0"><i class="bi bi-box-seam me-2"></i>Cek Stok Barang</h3>
                </div>
                
                <div class="card-body">
                    <form action="{{ route('staff.cek-stok.result') }}" method="POST" class="mb-4">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="text" 
                                   name="nama_barang" 
                                   class="form-control form-control-lg border-primary" 
                                   placeholder="Masukkan nama barang..." 
                                   value="{{ old('nama_barang', $nama_barang) }}" 
                                   required>
                            <button class="btn btn-primary btn-lg" type="submit">
                                <i class="bi bi-search me-1"></i> Cek Stok
                            </button>
                        </div>
                    </form>

                    @if(!is_null($sisaStok))
                        <div class="alert alert-success animate__animated animate__fadeInUp">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-check-circle-fill me-3 fs-3"></i>
                                <div>
                                    <h5 class="alert-heading">Informasi Stok Barang</h5>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p class="mb-2"><strong>Nama Barang:</strong></p>
                                            <p class="mb-3 fs-5">{{ $nama_barang }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="mb-2"><strong>Sisa Stok:</strong></p>
                                            <p class="mb-0 fs-5 fw-bold text-primary">{{ $sisaStok }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @elseif(request()->isMethod('post'))
                        <div class="alert alert-warning animate__animated animate__shakeX">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-exclamation-triangle-fill me-3 fs-3"></i>
                                <div>
                                    <h5 class="alert-heading">Barang Tidak Ditemukan</h5>
                                    <p class="mb-0">Data untuk barang <strong>"{{ $nama_barang }}"</strong> tidak ditemukan dalam sistem.</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                
                <div class="card-footer bg-light">
                    <small class="text-muted">
                        <i class="bi bi-info-circle me-1"></i> Terakhir diperbarui: {{ now()->format('d F Y H:i') }}
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection