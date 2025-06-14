@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container-fluid px-4">
    <!-- Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard Admin</h1>
        <div class="d-flex">
            <button class="btn btn-primary shadow-sm">
                <i class="bi-download me-1"></i> Export Laporan
            </button>
        </div>
    </div>

    <!-- Statistik Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col me-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Produk</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlahProduk }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi-box-seam fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col me-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Transaksi Masuk (Bulan Ini)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlahTransaksiMasuk }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi-arrow-down-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col me-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Transaksi Keluar (Bulan Ini)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlahTransaksiKeluar }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi-arrow-up-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col me-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Produk Hampir Habis</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">3</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi-exclamation-triangle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik dan Aktivitas -->
    <div class="row">
        <!-- Grafik Stok -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <i class="bi bi-graph-up"></i>
                    <h6 class="m-0 font-weight-bold text-primary">Grafik Stok Barang</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi-three-dots-vertical text-gray-400"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow">
                            <li><a class="dropdown-item" href="{{ route('products.index') }}">Lihat Detail</a></li>
                            <li><a class="dropdown-item" href="#">Export Data</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                <div class="chart-area mb-4">
    <canvas id="stokMasukKeluarChart" height="250"></canvas>
</div>

                    <div class="mt-4 text-center small">
                        <span class="me-2">
                            <i class="bi-square-fill text-primary"></i> Stok Tersedia
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Aktivitas Terbaru -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <i class="bi bi-person-fill"></i>
                    <h6 class="m-0 font-weight-bold text-primary">Aktivitas Pengguna Terbaru</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi-three-dots-vertical text-gray-400"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow">
                            <li><a class="dropdown-item" href="{{ route('users.index') }}">Lihat Semua</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Refresh</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        @foreach ($aktivitasPengguna as $user)
                        <div class="list-group-item list-group-item-action d-flex align-items-center py-3">
                            <div class="me-3">
                                <img class="rounded-circle" src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random" width="40" height="40" alt="User">
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">{{ $user->name }}</h6>
                                    <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                                </div>
                                <p class="mb-1 text-muted small">{{ $user->email }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <a href="#" class="btn btn-light btn-block mt-3">
                        <i class="bi-arrow-right me-1"></i> Lihat Semua Aktivitas
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Produk Stok Rendah -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-danger">Produk dengan Stok Rendah</h6>
                    <a href="{{ route('products.index') }}" class="btn btn-sm btn-danger">Kelola Produk</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Nama Produk</th>
                                    <th>Kategori</th>
                                    <th>Stok Tersedia</th>
                                    <th>Stok Minimum</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Buku Tulis</td>
                                    <td>Alat Tulis</td>
                                    <td>5</td>
                                    <td>20</td>
                                    <td><span class="badge bg-danger">Stok Rendah</span></td>
                                </tr>
                                <tr>
                                    <td>Pulpen Standard</td>
                                    <td>Alat Tulis</td>
                                    <td>8</td>
                                    <td>30</td>
                                    <td><span class="badge bg-danger">Stok Rendah</span></td>
                                </tr>
                                <tr>
                                    <td>Kertas A4</td>
                                    <td>Kertas</td>
                                    <td>3</td>
                                    <td>15</td>
                                    <td><span class="badge bg-danger">Stok Rendah</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const labels = {!! json_encode($stokMasuk->pluck('product.name')->merge($stokKeluar->pluck('product.name'))->unique()->values()) !!};

    const dataMasuk = labels.map(label => {
        let data = {!! json_encode($stokMasuk->mapWithKeys(fn($s) => [$s->product->name => $s->total])) !!};
        return data[label] ?? 0;
    });

    const dataKeluar = labels.map(label => {
        let data = {!! json_encode($stokKeluar->mapWithKeys(fn($s) => [$s->product->name => $s->total])) !!};
        return data[label] ?? 0;
    });

    const ctx = document.getElementById('stokMasukKeluarChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Stok Masuk',
                    data: dataMasuk,
                    backgroundColor: 'rgba(75, 192, 192, 0.6)'
                },
                {
                    label: 'Stok Keluar',
                    data: dataKeluar,
                    backgroundColor: 'rgba(255, 99, 132, 0.6)'
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });
</script>
@endpush

