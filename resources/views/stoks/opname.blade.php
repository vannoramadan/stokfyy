@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Stock Opname</h3>
                </div>
                <form action="{{ route('stocks.processOpname') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> Silahkan input stok aktual untuk setiap produk
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Produk</th>
                                        <th>Stok Sistem</th>
                                        <th>Stok Aktual</th>
                                        <th>Selisih</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                    <tr>
                                        <td>
                                            {{ $product->name }}
                                            <input type="hidden" name="product_id[]" value="{{ $product->id }}">
                                        </td>
                                        <td>{{ $product->stock }}</td>
                                        <td>
                                            <input type="number" name="actual_stock[]" value="{{ $product->stock }}" 
                                                class="form-control actual-stock" 
                                                data-product-id="{{ $product->id }}"
                                                min="0" required>
                                        </td>
                                        <td class="difference" id="diff-{{ $product->id }}">0</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Hasil Opname
                        </button>
                        <a href="{{ route('stoks.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('.actual-stock').on('input', function() {
            const productId = $(this).data('product-id');
            const systemStock = parseInt($(this).closest('tr').find('td:eq(1)').text());
            const actualStock = parseInt($(this).val()) || 0;
            const difference = actualStock - systemStock;
            
            const diffCell = $('#diff-' + productId);
            diffCell.text(difference);
            
            if (difference > 0) {
                diffCell.removeClass('text-danger').addClass('text-success');
            } else if (difference < 0) {
                diffCell.removeClass('text-success').addClass('text-danger');
            } else {
                diffCell.removeClass('text-success text-danger');
            }
        });
    });
</script>
@endpush