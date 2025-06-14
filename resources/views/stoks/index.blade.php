@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Daftar Stok Produk</h3>
                    <div>
                        <a href="{{ route('stoks.history') }}" class="btn btn-info btn-sm">
                            <i class="fas fa-history"></i> Riwayat Transaksi
                        </a>
                        <a href="{{ route('stocks.opname') }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-clipboard-check"></i> Stock Opname
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Produk</th>
                                    <th>Kategori</th>
                                    <th>Stok Tersedia</th>
                                    <th>Stok Minimum</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                <tr class="@if($product->stock < $product->min_stock) table-danger @endif">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->category->name }}</td>
                                    <td>{{ $product->stock }}</td>
                                    <td>
                                        <form action="{{ route('stocks.update-minimum') }}" method="POST" class="form-inline d-inline">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <div class="input-group input-group-sm">
                                                <input type="number" name="min_stock" value="{{ $product->min_stock }}" class="form-control" style="width: 70px;">
                                                <div class="input-group-append">
                                                    <button type="submit" class="btn btn-success btn-sm">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </td>
                                    <td>
                                        @if($product->stock < $product->min_stock)
                                            <span class="badge bg-danger">Stok Rendah</span>
                                        @elseif($product->stock == 0)
                                            <span class="badge bg-dark">Habis</span>
                                        @else
                                            <span class="badge bg-success">Normal</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#adjustModal{{ $product->id }}">
                                            <i class="fas fa-edit"></i> Sesuaikan
                                        </button>
                                    </td>
                                </tr>

                                <!-- Adjustment Modal -->
                                <div class="modal fade" id="adjustModal{{ $product->id }}" tabindex="-1" aria-labelledby="adjustModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="adjustModalLabel">Sesuaikan Stok - {{ $product->name }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('stocks.adjust') }}" method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                    <div class="mb-3">
                                                        <label class="form-label">Tipe Penyesuaian</label>
                                                        <select name="adjustment_type" class="form-select" required>
                                                            <option value="in">Barang Masuk (+)</option>
                                                            <option value="out">Barang Keluar (-)</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Jumlah</label>
                                                        <input type="number" name="quantity" class="form-control" min="1" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Alasan</label>
                                                        <textarea name="reason" class="form-control" rows="3" required></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center mt-3">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection