<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Staf Gudang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <style>
        :root {
            --sidebar-bg: #2c3e50;
            --sidebar-active: #3498db;
            --header-gradient: linear-gradient(135deg, #3498db, #2c3e50);
        }

        body {
            background-color: #f8f9fa;
            overflow-x: hidden;
        }

        .sidebar {
            min-height: 100vh;
            background-color: var(--sidebar-bg);
            color: white;
            padding: 0;
            width: 280px;
            transition: all 0.3s ease;
            position: fixed;
            box-shadow: 4px 0 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            animation: fadeInDown 0.5s ease;
        }

        .sidebar-menu {
            padding: 1rem 0;
        }

        .sidebar-menu a {
            color: rgba(255, 255, 255, 0.8);
            display: flex;
            align-items: center;
            padding: 0.75rem 1.5rem;
            margin: 0.25rem 0;
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
            animation: fadeInLeft 0.5s ease;
        }

        .sidebar-menu a:hover {
            color: white;
            background-color: rgba(255, 255, 255, 0.05);
            border-left: 3px solid var(--sidebar-active);
            transform: translateX(5px);
        }

        .sidebar-menu a.active {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
            border-left: 3px solid var(--sidebar-active);
        }

        .sidebar-menu a i {
            margin-right: 12px;
            font-size: 1.1rem;
            transition: transform 0.3s ease;
        }

        .sidebar-menu a:hover i {
            transform: scale(1.1);
        }

        .main-content {
            margin-left: 280px;
            padding: 2rem;
            width: calc(100% - 280px);
            transition: all 0.3s ease;
            animation: fadeIn 0.5s ease;
        }

        .header-card {
            background: var(--header-gradient);
            color: white;
            border-radius: 10px;
            padding: 1.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
            transition: transform 0.3s ease;
        }

        .header-card:hover {
            transform: translateY(-3px);
        }

        .logout-btn {
            position: absolute;
            bottom: 20px;
            left: 20px;
            right: 20px;
            animation: fadeInUp 0.5s ease;
        }

        .logout-btn button {
            transition: all 0.3s ease;
        }

        .logout-btn button:hover {
            transform: scale(1.02);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 80px;
                overflow: hidden;
            }

            .sidebar-header h4,
            .sidebar-menu a span {
                display: none;
            }

            .sidebar-menu a {
                justify-content: center;
                padding: 0.75rem;
            }

            .sidebar-menu a i {
                margin-right: 0;
                font-size: 1.3rem;
            }

            .main-content {
                margin-left: 80px;
                width: calc(100% - 80px);
            }
        }

        /* Custom animations */
        @keyframes pulseIcon {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }

        .pulse-animation {
            animation: pulseIcon 2s infinite;
        }
    </style>
</head>
<body>
<div class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h4 class="d-flex align-items-center">
                <i class="bi bi-box-seam me-2 pulse-animation"></i>
                <span>Staf Gudang</span>
            </h4>
        </div>

        <div class="sidebar-menu">
            <a href="/staff/dashboard" class="{{ request()->is('staff/dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('barang-masuk.index') }}" class="{{ request()->routeIs('barang-masuk.index') ? 'active' : '' }}">
                <i class="bi bi-box-arrow-in-down"></i>
                <span>Barang Masuk</span>
            </a>
            <a href="{{ route('barang-keluar.index') }}" class="{{ request()->routeIs('barang-keluar.index') ? 'active' : '' }}">
                <i class="bi bi-box-arrow-up"></i>
                <span>Barang Keluar</span>
            </a>
            <a href="{{ route('staff.cek-stok.form') }}" class="{{ request()->routeIs('staff.cek-stok.form') ? 'active' : '' }}">
                <i class="bi bi-search"></i>
                <span>Stok</span>
            </a>
        </div>

        <div class="logout-btn">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm w-100 d-flex align-items-center justify-content-center">
                    <i class="bi bi-box-arrow-left me-1"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Tambahan jika ingin mendeteksi aktif tanpa Blade:
    document.addEventListener('DOMContentLoaded', function() {
        const currentUrl = window.location.pathname;
        const menuItems = document.querySelectorAll('.sidebar-menu a');
        
        menuItems.forEach(item => {
            if (item.getAttribute('href') === currentUrl) {
                item.classList.add('active');
                const icon = item.querySelector('i');
                if (icon) icon.classList.add('pulse-animation');
            } else {
                item.classList.remove('active');
            }
        });
    });
</script>
</body>
</html>
