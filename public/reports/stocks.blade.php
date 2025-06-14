@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white py-3">
                    <h4 class="mb-0"><i class="fas fa-filter me-2"></i>Filter Laporan</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('public.reports.stocks') }}" method="GET">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Kategori Produk</label>
                                <ul class="dropdown-menu">
                            <a class="dropdown-item" href="{{ route('products.index') }}">Semua Kategori</a>
                               @foreach($categories as $category)
                            <li>
                                <a class="dropdown-item" href="{{ route('products.index', ['category_id' => $category->id]) }}">
                                {{ $category->name }}
                                </a>
                            </li>
                                @endforeach
                            </ul>  <select name="category" class="form-select shadow-sm">
                                    <option value="">Semua Kategori</option>
                                    @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Status Stok</label>
                                <select name="stock_status" class="form-select shadow-sm">
                                    <option value="">Semua Status</option>
                                    <option value="low" {{ request('stock_status') == 'low' ? 'selected' : '' }}>Stok Rendah</option>
                                    <option value="out" {{ request('stock_status') == 'out' ? 'selected' : '' }}>Stok Habis</option>
                                </select>
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary me-2 shadow-sm">
                                    <i class="fas fa-search me-1"></i> Terapkan Filter
                                </button>
                                <a href="{{ route('public.reports.download', 'stocks') }}?{{ http_build_query(request()->all()) }}" 
                                   class="btn btn-success shadow-sm">
                                    <i class="fas fa-file-pdf me-1"></i> Unduh PDF
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
    <div class="card-header">
        <h4>Laporan Stok Barang</h4>
        <div>
                            <a href="{{ route('public.reports.activities') }}" class="btn btn-sm btn-outline-primary me-2">
                                <i class="fas fa-tasks me-1"></i> Aktifitas
                            </a>
                            <a href="{{ route('public.reports.transations') }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-exchange-alt me-1"></i> Transaksi
                            </a>
                        </div>
    </div>

    <div class="card-body">
        @if($isEmpty)
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> Tidak ada produk yang tercatat.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Produk</th>
                            <th>Kategori</th>
                            <th>Stok</th>
                            <th>Min. Stok</th>
                            <th>Masuk</th>
                            <th>Keluar</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr class="{{ $product->stock < $product->min_stock ? 'table-warning' : '' }}">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->category->name }}</td>
                            <td>{{ $product->stock }}</td>
                            <td>{{ $product->min_stock }}</td>
                            <td>{{ $product->total_in ?? 0 }}</td>
                            <td>{{ $product->total_out ?? 0 }}</td>
                            <td>
                                @if($product->stock < $product->min_stock)
                                    <span class="badge bg-warning">Rendah</span>
                                @elseif($product->stock == 0)
                                    <span class="badge bg-danger">Habis</span>
                                @else
                                    <span class="badge bg-success">Normal</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection