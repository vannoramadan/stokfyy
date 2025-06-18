@extends('layouts.app')

@section('title', 'Laporan Transaksi Stok')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Laporan Transaksi Stok</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Laporan Transaksi</li>
            </ol>
        </nav>
    </div>

    <!-- Filter Card -->
    <div class="card shadow mb-4 border-left-primary">
        <div class="card-header py-3 bg-white">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-filter me-2"></i>Filter Laporan
            </h6>
        </div>
        <div class="card-body">
            <form action="{{ route('public.reports.transations') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Dari Tanggal</label>
                        <input type="date" name="start_date" value="{{ $startDate }}" 
                               class="form-control form-control-sm">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Sampai Tanggal</label>
                        <input type="date" name="end_date" value="{{ $endDate }}" 
                               class="form-control form-control-sm">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Tipe Transaksi</label>
                        <select name="type" class="form-select form-select-sm">
                            <option value="">Semua Tipe</option>
                            <option value="in" {{ request('type') == 'in' ? 'selected' : '' }}>Barang Masuk</option>
                            <option value="out" {{ request('type') == 'out' ? 'selected' : '' }}>Barang Keluar</option>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary btn-sm me-2">
                            <i class="fas fa-search me-1"></i> Filter
                        </button>
                        <a href="{{ route('public.reports.download', 'transactions') }}?{{ http_build_query(request()->all()) }}" 
                           class="btn btn-success btn-sm">
                            <i class="fas fa-file-pdf me-1"></i> PDF
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Report Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
            <div>
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-table me-2"></i>Data Transaksi
                </h6>
                <small class="text-muted">
                    Periode: {{ \Carbon\Carbon::parse($startDate)->translatedFormat('d F Y') }} - 
                    {{ \Carbon\Carbon::parse($endDate)->translatedFormat('d F Y') }}
                </small>
            </div>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                    <i class="fas fa-ellipsis-v text-gray-400"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow">
                    <li><a class="dropdown-item" href="{{ route('public.reports.transations') }}"><i class="fas fa-sync-alt me-2"></i>Refresh</a></li>
                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#exportModal">
                        <i class="fas fa-download me-2"></i>Export Data
                    </a></li>
                </ul>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-sm" width="100%" cellspacing="0">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th width="15%">Tanggal/Waktu</th>
                            <th>Produk</th>
                            <th width="10%">Tipe</th>
                            <th width="10%">Jumlah</th>
                            <th>Keterangan</th>
                            <th width="15%">User</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $transaction)
                        <tr>
                            <td class="text-center">{{ $loop->iteration + ($transactions->currentPage() - 1) * $transactions->perPage() }}</td>
                            <td>{{ $transaction->created_at->translatedFormat('d/m/Y H:i') }}</td>
                            <td>{{ $transaction->product->name }}</td>
                            <td class="text-center">
                                @if($transaction->type == 'in')
                                    <span class="badge bg-success bg-opacity-10 text-success">
                                        <i class="fas fa-arrow-down me-1"></i> Masuk
                                    </span>
                                @else
                                    <span class="badge bg-danger bg-opacity-10 text-danger">
                                        <i class="fas fa-arrow-up me-1"></i> Keluar
                                    </span>
                                @endif
                            </td>
                            <td class="text-end">{{ number_format($transaction->quantity, 0) }}</td>
                            <td>{{ $transaction->description ?: '-' }}</td>
                            <td>{{ $transaction->user->name }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">Tidak ada data transaksi ditemukan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($transactions->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="text-muted small">
                    Menampilkan {{ $transactions->firstItem() }} sampai {{ $transactions->lastItem() }} dari {{ $transactions->total() }} entri
                </div>
                <div>
                    {{ $transactions->withQueryString()->links() }}
                </div>h
            </div>
            @endif
        </div>
        <div class="card-footer text-muted small">
            <i class="fas fa-clock me-1"></i> Dicetak pada: {{ now()->translatedFormat('l, d F Y H:i:s') }}
        </div>
    </div>
</div>
<a href="{{ route('public.reports.stocks') }}" class="btn btn-outline-secondary me-md-2">
                                <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>

<!-- Export Modal -->
<div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="exportModalLabel"><i class="fas fa-download me-2"></i>Export Data</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('public.reports.export', 'transactions') }}?type=excel&{{ http_build_query(request()->all()) }}" 
                       class="btn btn-success">
                        <i class="fas fa-file-excel me-2"></i>Excel
                    </a>
                    <a href="{{ route('public.reports.export', 'transactions') }}?type=csv&{{ http_build_query(request()->all()) }}" 
                       class="btn btn-info">
                        <i class="fas fa-file-csv me-2"></i>CSV
                    </a>
                    <a href="{{ route('public.reports.download', 'transactions') }}?{{ http_build_query(request()->all()) }}" 
                       class="btn btn-danger">
                        <i class="fas fa-file-pdf me-2"></i>PDF
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .table-sm td, .table-sm th {
        padding: 0.5rem;
    }
    .bg-opacity-10 {
        background-color: rgba(var(--bs-primary-rgb), 0.1) !important;
    }
</style>
@endpush