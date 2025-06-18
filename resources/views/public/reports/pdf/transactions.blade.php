<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        .header, .footer { text-align: center; }
        .logo { width: 80px; }
        .signature { margin-top: 60px; text-align: right; padding-right: 50px; }
    </style>
</head>
<body>

    <div class="header">
        <img src="{{ public_path('images/v.jpg') }}" class="logo" alt="Logo">
        <h2>{{ $title }}</h2>
        <p>Periode: {{ $period }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Produk</th>
                <th>Jumlah</th>
                <th>Keterangan</th>
                <th>User</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $trx)
            <tr>
                <td>{{ $trx->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $trx->product->name ?? '-' }}</td>
                <td>{{ $trx->quantity }}</td>
                <td>{{ ucfirst($trx->type) }}</td>
                <td>{{ $trx->user->name ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="signature">
        <p>{{ now()->format('d F Y') }}</p>
        <br><br><br>
        <p><strong>____________________</strong><br>Petugas Gudang</p>
    </div>

</body>
</html>
