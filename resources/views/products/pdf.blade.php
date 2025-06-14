<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Produk</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        .title { font-size: 18px; font-weight: bold; }
        .subtitle { font-size: 14px; color: #555; }
        .filter-info { margin-bottom: 15px; font-size: 13px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .footer { margin-top: 20px; font-size: 12px; text-align: right; }
        .badge { padding: 3px 6px; border-radius: 3px; font-size: 12px; }
        .success { background-color: #d4edda; color: #155724; }
        .warning { background-color: #fff3cd; color: #856404; }
        .danger { background-color: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">Laporan Data Produk</div>
        <div class="subtitle">{{ config('app.name') }}</div>
    </div>

    <div class="filter-info">
        <strong>Filter:</strong>
        Kategori: {{ $filter['category'] }} | 
        Status Stok: {{ $filter['stock_status'] }}
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th class="text-center">Harga</th>
                <th class="text-center">Stok</th>
                <th class="text-center">Min. Stok</th>
                <th class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->category->name }}</td>
                <td class="text-right">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                <td class="text-center">{{ $product->stock }}</td>
                <td class="text-center">{{ $product->min_stock }}</td>
                <td class="text-center">
                    @if($product->stock < $product->min_stock)
                        <span class="badge warning">Rendah</span>
                    @elseif($product->stock == 0)
                        <span class="badge danger">Habis</span>
                    @else
                        <span class="badge success">Normal</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ now()->format('d/m/Y H:i:s') }}
    </div>
</body>
</html>