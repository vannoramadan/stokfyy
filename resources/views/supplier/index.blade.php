@extends('layouts.app')

@section('title', 'Manajemen Supplier')

@section('content')
<div class="container-fluid py-4">
    <div class="card border-0 shadow-lg">
        <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-truck me-2"></i>Data Supplier
                </h5>
                <a href="{{ route('suppliers.create') }}" class="btn btn-light btn-sm">
                    <i class="fas fa-plus-circle me-1"></i> Tambah Supplier
                </a>
            </div>
        </div>

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th width="20%">Nama Supplier</th>
                            <th width="20%">Email</th>
                            <th width="15%">Telepon</th>
                            <th width="30%">Alamat</th>
                            <th width="15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($suppliers as $supplier)
                        <tr>
                            <td class="align-middle">{{ $supplier->name }}</td>
                            <td class="align-middle">{{ $supplier->email ?? '-' }}</td>
                            <td class="align-middle">{{ $supplier->phone ?? '-' }}</td>
                            <td class="align-middle">{{ $supplier->address ?? '-' }}</td>
                            <td class="text-center align-middle">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('suppliers.edit', $supplier) }}" 
                                       class="btn btn-sm btn-warning" 
                                       data-bs-toggle="tooltip" 
                                       title="Edit Supplier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('suppliers.destroy', $supplier) }}" 
                                          method="POST" 
                                          class="d-inline" 
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus supplier ini?')">
                                        @csrf 
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-sm btn-danger" 
                                                data-bs-toggle="tooltip" 
                                                title="Hapus Supplier">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="fas fa-box-open fa-2x mb-3"></i>
                                    <p>Tidak ada data supplier tersedia</p>
                                    <a href="{{ route('suppliers.create') }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-plus me-1"></i> Tambah Supplier Pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($suppliers->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="text-muted">
                    Menampilkan <strong>{{ $suppliers->firstItem() }}</strong> sampai <strong>{{ $suppliers->lastItem() }}</strong> dari <strong>{{ $suppliers->total() }}</strong> supplier
                </div>
                <nav aria-label="Page navigation">
                    {{ $suppliers->links('vendor.pagination.bootstrap-5') }}
                </nav>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Inisialisasi tooltip
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    })
</script>
@endpush