@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Riwayat Transaksi Stok</h3>
                    <div class="card-tools">
                        <form action="{{ route('stoks.history') }}" method="GET" class="form-inline">
                            <div class="input-group input-group-sm" style="width: 250px;">
                                <select name="type" class="form-select">
                                    <option value="">Semua Tipe</option>
                                    <option value="in" {{ request('type') == 'in' ? 'selected' : '' }}>Barang Masuk</option>
                                    <option value="out" {{ request('type') == 'out' ? 'selected' : '' }}>Barang Keluar</option>
                                </select>
                                <input type="date" name="date_from" value="{{ request('date_from') }}" class="form-control" placeholder="Dari">
                                <input type="date" name="date_to" value="{{ request('date_to') }}" class="form-control" placeholder="Sampai">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Tanggal</th>
                                    <th>Produk</th>
                                    <th>Tipe</th>
                                    <th>Jumlah</th>
                                    <th>Deskripsi</th>
                                    <th>User</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transactions as $transaction)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                                    <td>{{ $transaction->product->name }}</td>
                                    <td>
                                        @if($transaction->type == 'in')
                                            <span class="badge bg-success">Masuk</span>
                                        @else
                                            <span class="badge bg-danger">Keluar</span>
                                        @endif
                                    </td>
                                    <td>{{ $transaction->quantity }}</td>
                                    <td>{{ $transaction->description }}</td>
                                    <td>{{ $transaction->user->name }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center mt-3">
                        {{ $transactions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection