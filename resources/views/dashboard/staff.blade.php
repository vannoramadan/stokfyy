@extends('layouts.staff')

@section('content')
<div class="container-fluid py-4">
    <!-- Welcome Card -->
    <div class="card bg-primary text-white mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="card-title mb-1">Selamat Datang, {{ Auth::user()->name }}</h3>
                    <p class="card-text opacity-75 mb-0">Kelola stok dengan mudah dari dashboard ini.</p>
                </div>
                <div class="bg-white bg-opacity-25 p-3 rounded-circle">
                    <i class="bi bi-person-circle fs-2"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <!-- Barang Masuk -->
        <div class="col-md-4">
            <div class="card bg-gradient-indigo text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title opacity-75">Barang Masuk</h5>
                            <h2 class="card-text fw-bold">{{ $jumlahBarangMasuk }}</h2>
                        </div>
                        <div class="bg-white bg-opacity-25 p-3 rounded-circle">
                            <i class="bi bi-box-arrow-in-down fs-2"></i>
                        </div>
                    </div>
                    <div class="progress mt-3 bg-white bg-opacity-25" style="height: 5px;">
                        <div class="progress-bar bg-white" style="width: 75%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Barang Keluar -->
        <div class="col-md-4">
            <div class="card bg-gradient-teal text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title opacity-75">Barang Keluar</h5>
                            <h2 class="card-text fw-bold">{{ $jumlahBarangKeluar }}</h2>
                        </div>
                        <div class="bg-white bg-opacity-25 p-3 rounded-circle">
                            <i class="bi bi-box-arrow-up fs-2"></i>
                        </div>
                    </div>
                    <div class="progress mt-3 bg-white bg-opacity-25" style="height: 5px;">
                        <div class="progress-bar bg-white" style="width: 60%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Aktivitas -->
        <div class="col-md-4">
            <div class="card bg-gradient-blue text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title opacity-75">Aktivitas</h5>
                            <h2 class="card-text fw-bold">{{ count($aktivitas) }}</h2>
                        </div>
                        <div class="bg-white bg-opacity-25 p-3 rounded-circle">
                            <i class="bi bi-activity fs-2"></i>
                        </div>
                    </div>
                    <div class="progress mt-3 bg-white bg-opacity-25" style="height: 5px;">
                        <div class="progress-bar bg-white" style="width: 45%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row g-4">
        <!-- Aktivitas Terakhir -->
        <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Aktivitas Terakhir</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse ($aktivitas as $item)
                            @php
                                $status = $item['status'];
                                $badgeClass = match($status) {
                                    'Keluar' => 'bg-danger bg-opacity-10 text-danger',
                                    'Masuk' => 'bg-primary bg-opacity-10 text-primary',
                                    default => 'bg-secondary bg-opacity-10 text-secondary',
                                };
                            @endphp
                            <div class="list-group-item border-0 py-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary bg-opacity-10 p-2 rounded-circle me-3">
                                            <i class="bi bi-box-seam text-primary"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1">{{ $item['judul'] }}</h6>
                                            <small class="text-muted">{{ $item['waktu'] }}</small>
                                        </div>
                                    </div>
                                    <span class="badge rounded-pill {{ $badgeClass }}">{{ $status }}</span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1"></i>
                                <p class="mt-2">Belum ada aktivitas</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Barang Hampir Habis -->
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Barang Hampir Habis</h5>
                </div>
                <div class="card-body">
                    @if($barangHampirHabis && $barangHampirHabis->count())
                        <div class="alert alert-warning d-flex align-items-center">
                            <i class="bi bi-exclamation-triangle-fill fs-4 me-2"></i>
                            <div>
                                <strong>Perhatian!</strong> Terdapat {{ $barangHampirHabis->count() }} item dengan stok hampir habis!
                            </div>
                        </div>
                        <div class="list-group">
                            @foreach($barangHampirHabis as $barang)
                                <div class="list-group-item border-0 py-2">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-danger bg-opacity-10 p-2 rounded-circle me-3">
                                            <i class="bi bi-exclamation-circle-fill text-danger"></i>
                                        </div>
                                        <div>
                                            <p class="mb-0 fw-bold">{{ $barang->nama_barang }}</p>
                                            <small class="text-muted">Stok: {{ $barang->stok }}</small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="bi bi-check-circle-fill fs-1 text-success"></i>
                            <p class="mt-2">Tidak ada barang dengan stok rendah</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom gradients */
    .bg-gradient-indigo {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .bg-gradient-teal {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    }
    
    .bg-gradient-blue {
        background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
    }
    
    /* Card hover effects */
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: none;
        border-radius: 12px;
        overflow: hidden;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    
    /* List group items */
    .list-group-item {
        transition: background-color 0.2s ease;
    }
    
    .list-group-item:hover {
        background-color: #f8f9fa;
    }
    
    /* Progress bars */
    .progress {
        border-radius: 100px;
    }
    
    .progress-bar {
        border-radius: 100px;
    }
</style>
@endsection