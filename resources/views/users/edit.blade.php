@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="bi bi-person-plus me-2"></i>Tambah Pengguna Baru</h4>
                </div>
                
                <div class="card-body">
                    <form action="{{ route('users.update', $user) }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name') }}" required placeholder="Masukkan nama lengkap">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Alamat Email</label>
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" 
                                   value="{{ old('email') }}" required placeholder="Masukkan alamat email">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" 
                                       id="status" name="status" value="1" checked>
                                <label class="form-check-label" for="status">Aktif</label>
                            </div>
                        <div class="alert alert-info mt-4">
                            <h5 class="alert-heading"><i class="bi bi-info-circle-fill me-2"></i>Informasi Password</h5>
                            <p class="mb-0">Password default untuk pengguna baru adalah: <strong>password</strong>. 
                            Pengguna dapat mengubah password mereka setelah login.</p>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <a href="{{ route('users.index') }}" class="btn btn-outline-secondary me-md-2">
                                <i class="bi bi-arrow-left me-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i> Update Pengguna
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection