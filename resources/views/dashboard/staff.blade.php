@extends('layouts.staff')

@section('content')
<div class="header-card mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h3>Selamat datang, {{ Auth::user()->name }}</h3>
            <p class="mb-0">Pantau dan kelola stok dengan mudah dari dashboard ini.</p>
        </div>
        <div>
            <i class="bi bi-person-circle" style="font-size: 40px;"></i>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="card card-statistic bg-gradient-primary shadow-lg">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title text-white">Barang Masuk</h5>
                        <h2 class="mb-0 text-white">{{ $jumlahBarangMasuk }}</h2>
                    </div>
                    <div class="icon">
                        <i class="bi bi-box-arrow-in-down text-white" style="font-size: 2.5rem;"></i>
                    </div>
                </div>
                <div class="progress mt-3" style="height: 5px;">
                    <div class="progress-bar bg-white" role="progressbar" style="width: 75%"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-statistic bg-gradient-success shadow-lg">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title text-white">Barang Keluar</h5>
                        <h2 class="mb-0 text-white">{{ $jumlahBarangKeluar }}</h2>
                    </div>
                    <div class="icon">
                        <i class="bi bi-box-arrow-up text-white" style="font-size: 2.5rem;"></i>
                    </div>
                </div>
                <div class="progress mt-3" style="height: 5px;">
                    <div class="progress-bar bg-white" role="progressbar" style="width: 60%"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-statistic bg-gradient-info shadow-lg">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title text-white">Aktivitas</h5>
                        <h2 class="mb-0 text-white">{{ count($aktivitas) }}</h2>
                    </div>
                    <div class="icon">
                        <i class="bi bi-activity text-white" style="font-size: 2.5rem;"></i>
                    </div>
                </div>
                <div class="progress mt-3" style="height: 5px;">
                    <div class="progress-bar bg-white" role="progressbar" style="width: 45%"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Aktivitas Terakhir</h5>
            </div>
            <div class="card-body">
                <div class="list-group">
                    @forelse ($aktivitas as $item)
                        <div class="list-group-item border-0 d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-box-seam me-3 text-primary" style="font-size: 1.5rem;"></i>
                                <div>
                                    <h6 class="mb-0">{{ $item['judul'] }}</h6>
                                    <small class="text-muted">{{ $item['waktu'] }}</small>
                                </div>
                            </div>
                            <span class="badge bg-primary rounded-pill">{{ $item['status'] }}</span>
                        </div>
                    @empty
                        <p class="text-muted">Belum ada aktivitas.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">Stok Hampir Habis</h5>
            </div>
            <div class="card-body">
                @if($barangHampirHabis->count() > 0)
                    <div class="alert alert-warning d-flex align-items-center">
                        <i class="bi bi-exclamation-triangle-fill me-2" style="font-size: 1.5rem;"></i>
                        <div>
                            <strong>Perhatian!</strong> {{ $barangHampirHabis->count() }} item stok hampir habis.
                        </div>
                    </div>
                    <ul class="list-group">
                        @foreach($barangHampirHabis as $barang)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $barang->nama_barang }}
                                <span class="badge bg-warning rounded-pill">{{ $barang->jumlah }}</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted">Tidak ada barang dengan stok rendah.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    .header-card {
        background: linear-gradient(135deg, #3a7bd5 0%, #00d2ff 100%);
        color: white;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .card-statistic {
        border-radius: 10px;
        border: none;
        transition: all 0.3s ease;
    }

    .card-statistic:hover {
        transform: translateY(-5px);
    }

    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    }

    .bg-gradient-success {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%) !important;
    }

    .bg-gradient-info {
        background: linear-gradient(135deg, #4b6cb7 0%, #182848 100%) !important;
    }

    .shadow-lg {
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .shadow-sm {
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }
</style>
@endsection
