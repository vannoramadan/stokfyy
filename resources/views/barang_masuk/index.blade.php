@extends('layouts.staff')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">📦 Daftar Barang Masuk</h3>
        <a href="{{ route('barang-masuk.create') }}" class="btn btn-primary shadow-sm">+ Tambah</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Barang</th>
                            <th>Jumlah</th>
                            <th>Tanggal Masuk</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($barangMasuk as $barang)
                            <tr>
                                <td>{{ $barang->nama_barang ?? '-' }}</td>
                                <td>{{ $barang->jumlah }}</td>
                                <td>{{ \Carbon\Carbon::parse($barang->tanggal_masuk)->translatedFormat('d M Y') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('barang-masuk.edit', $barang->id) }}" class="btn btn-sm btn-outline-warning me-1">Edit</a>
                                    <form action="{{ route('barang-masuk.destroy', $barang->id) }}" method="POST" style="display:inline-block">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus data ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-3">Belum ada data barang masuk.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Tambahkan pengecekan agar tidak error saat bukan paginator --}}
    @if(method_exists($barangMasuk, 'hasPages') && $barangMasuk->hasPages())
        <div class="mt-3">
            {{ $barangMasuk->links() }}
        </div>
    @endif
</div>
@endsection
