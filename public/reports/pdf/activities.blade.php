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
        <img src="{{ public_path('images/logo.png') }}" class="logo" alt="Logo">
        <h2>{{ $title }}</h2>
        @if(request('user_id'))
            <p>Pengguna: {{ \App\Models\User::find(request('user_id'))->name ?? '-' }}</p>
        @endif
        @if(request('date'))
            <p>Tanggal: {{ \Carbon\Carbon::parse(request('date'))->format('d F Y') }}</p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Pengguna</th>
                <th>Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($activities as $act)
            <tr>
                <td>{{ \Carbon\Carbon::parse($act->created_at)->format('d/m/Y H:i') }}</td>
                <td>{{ $act->causer->name ?? '-' }}</td>
                <td>{{ $act->description }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="signature">
        <p>{{ now()->format('d F Y') }}</p>
        <br><br><br>
        <p><strong>____________________</strong><br>Petugas IT</p>
    </div>

</body>
</html>
