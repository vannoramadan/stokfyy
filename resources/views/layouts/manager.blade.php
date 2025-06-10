<!-- resources/views/layouts/manager.blade.php -->
<!DOCTYPE html>
<html lang="en" class="dark"> <!-- Sudah benar -->

<head>
    <meta charset="UTF-8">
    <title>Stockify Manager</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
</head>

<body class="bg-slate-900 text-white"> {{-- Ubah dari bg-gray-100 text-gray-800 --}}
    {{-- Sidebar --}}
    @include('partials.sidebar')

    {{-- Main Content --}}
    <div class="ml-64 min-h-screen p-6">
        @yield('content')
    </div>
</body>

</html>
