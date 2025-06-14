@extends('layouts.app')

@section('title', 'Manajemen Produk')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Produk</h1>
        <div class="d-flex">
            <a href="{{ route('products.export-template') }}" class="btn btn-sm btn-outline-secondary me-2">
                <i class="fas fa-file-download me-1"></i> Template
            </a>
            <button class="btn btn-sm btn-success me-2" data-bs-toggle="modal" data-bs-target="#importModal">
                <i class="fas fa-file-import me-1"></i> Import
            </button>
            <a href="{{ route('products.export') }}" class="btn btn-sm btn-info me-2">
                <i class="fas fa-file-export me-1"></i> Export
            </a>
            <a href="{{ route('products.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus me-1"></i> Tambah Produk
            </a>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center bg-primary text-white">
            <h6 class="m-0 font-weight-bold">Daftar Produk</h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown">
                    <i class="fas fa-ellipsis-v"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow">
                    <li><a class="dropdown-item" href="{{ route('products.index') }}"><i class="fas fa-sync-alt me-2"></i>Refresh</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-filter me-2"></i>Filter</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                <a class="dropdown-item" href="{{ route('products.export.pdf', request()->query()) }}">
                    <i class="fas fa-file-pdf text-danger"></i> Eksport PDF
                </a>
            </li>
                </ul>
            </div>
        </div>
        <div class="card-body">
            <!-- Search and Filter -->
            <div class="row mb-3">
                <div class="col-md-6">
                <form method="GET" action="{{ route('products.index') }}">
    <div class="input-group">
        <input type="text" class="form-control" placeholder="Cari produk..." name="search" value="{{ request('search') }}">
        <button class="btn btn-outline-primary" type="submit">
            <i class="fas fa-search"></i>
        </button>
    </div>
</form>
                </div>
                <div class="col-md-6">
                    <div class="d-flex justify-content-end">
                        <div class="dropdown me-2">
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-filter me-1"></i> Kategori
                            </button>
                            <ul class="dropdown-menu">
                            <a class="dropdown-item" href="{{ route('products.index') }}">Semua Kategori</a>
                               @foreach($categories as $category)
                            <li>
                                <a class="dropdown-item" href="{{ route('products.index', ['category_id' => $category->id]) }}">
                                {{ $category->name }}
                                </a>
                            </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products Table -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th width="10%">Gambar</th>
                            <th class="text-center">Nama Produk</th>
                            <th>Kategori</th>
                            <th width="12%">Harga</th>
                            <th width="10%">Stok</th>
                            <th width="10%">Status</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                        <tr>
                            <td>{{ $loop->iteration + ($products->currentPage() - 1) * $products->perPage() }}</td>
                            <td class="text-center">
                                <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/50?text=No+Image' }}" 
                                     alt="{{ $product->name }}" 
                                     class="img-thumbnail" 
                                     width="50"
                                     onerror="this.src='https://via.placeholder.com/50?text=No+Image'">
                            </td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->category->name }}</td>
                            <td class="text-end">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                            <td class="text-center">
                                <span class="badge bg-{{ $product->stock > 10 ? 'success' : ($product->stock > 0 ? 'warning' : 'danger') }}">
                                    {{ $product->stock }}
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-{{ $product->status ? 'success' : 'secondary' }}">
                                    {{ $product->status ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('products.edit', $product->id) }}" 
                                       class="btn btn-sm btn-warning" 
                                       data-bs-toggle="tooltip" 
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-sm btn-danger" 
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')"
                                                data-bs-toggle="tooltip" 
                                                title="Hapus">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">Tidak ada data produk</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($products->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="text-muted">
                    Menampilkan {{ $products->firstItem() }} sampai {{ $products->lastItem() }} dari {{ $products->total() }} entri
                </div>
                <nav>
                    {{ $products->withQueryString()->links() }}
                </nav>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Import Modal -->
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="importModalLabel">Import Data Produk</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('products.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Pastikan file Excel mengikuti format template yang disediakan.
                    </div>
                    <div class="mb-3">
                        <label for="file" class="form-label">Pilih File Excel</label>
                        <input class="form-control" type="file" id="file" name="file" accept=".xlsx, .xls, .csv" required>
                        <small class="text-muted">Format yang didukung: .xlsx, .xls, .csv</small>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="overwrite" name="overwrite">
                        <label class="form-check-label" for="overwrite">
                            Timpa data yg sudah ada
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-upload me-1"></i> Import
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Enable tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endsection