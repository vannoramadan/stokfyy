<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        .title { font-size: 18px; font-weight: bold; }
        .subtitle { font-size: 14px; color: #555; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background-color: #f2f2f2; text-align: left; }
        .footer { margin-top: 20px; font-size: 12px; text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">{{ $title }}</div>
        <div class="subtitle">{{ config('app.name') }}</div>
    </div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Produk</th>
                <th>Kategori</th>
                <th>Stok</th>
                <th>Min. Stok</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->category->name }}</td>
                <td>{{ $product->stock }}</td>
                <td>{{ $product->min_stock }}</td>
                <td>
                    @if($product->stock < $product->min_stock)
                        Stok Rendah
                    @elseif($product->stock == 0)
                        Habis
                    @else
                        Normal
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('public.reports.activities') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus me-1"></i> Lihat Aktifitas
    </a>
    <div class="footer">
        Dicetak pada: {{ now()->format('d/m/Y H:i:s') }}
    </div>
</body>
</html>