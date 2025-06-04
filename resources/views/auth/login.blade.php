<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Stok Gudang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #f8f9fc;
            --accent-color: #2e59d9;
        }

        body {
            background: linear-gradient(135deg, #f8f9fc 0%, #e9ecef 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .login-card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .login-card:hover {
            transform: translateY(-5px);
        }

        .card-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%);
            color: white;
            text-align: center;
            padding: 2rem;
            border-bottom: none;
        }

        .logo {
            width: 150px;
            height: 150px;
            object-fit: contain;
            margin-bottom: 1rem;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
        }

        .form-control {
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            border: 1px solid #d1d3e2;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.25);
        }

        .btn-login {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%);
            border: none;
            border-radius: 0.5rem;
            padding: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        .input-group-text {
            background-color:rgba(107, 118, 174, 0.46);
            border-right: none;
        }

        .form-floating>label {
            padding: 0.75rem 1rem;
        }

        .role-icon {
            width: 20px;
            height: 20px;
            margin-right: 8px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="login-card card">
                    <div class="card-header">
                        <img src="{{ asset('images/stok.jpg') }}" alt="Logo Gudang" class="logo">
                        <h3 class="mb-0">Manajemen Stok Barang</h3>
                        <p class="mb-0 mt-2">Aplikasi menejemen stok barang</p>
                    </div>
                    <div class="card-body p-4">
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                {{ $errors->first() }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}" class="mt-3">
                            @csrf

                            <div class="form-floating mb-4">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-envelope-fill"></i>
                                    </span>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           placeholder="name@example.com" required>
                                    <label for="email">Alamat Email</label>
                                </div>
                            </div>

                            <div class="form-floating mb-4">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-lock-fill"></i>
                                    </span>
                                    <input type="password" class="form-control" id="password" name="password" 
                                           placeholder="Password" required>
                                    <label for="password">Kata Sandi</label>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="role" class="form-label fw-bold mb-3">
                                    <i class="bi bi-person-badge-fill me-2"></i>Peran Pengguna
                                </label>
                                <select class="form-select py-3" name="role" id="role" required>
                                    <option value="" disabled selected>-- Pilih Peran Anda --</option>
                                    <option value="admin">Admin</option>
                                    <option value="manajer">Manajer Gudang</option>
                                    <option value="staff">Staf Gudang</option>
                                </select>
                            </div>

                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-login btn-primary">
                                    <i class="bi bi-box-arrow-in-right me-2"></i>Masuk ke Sistem
                                </button>
                            </div>

                            <div class="text-center mt-4">
                                <a href="#" class="text-decoration-none">
                                    <i class="bi bi-question-circle me-1"></i>Lupa kata sandi?
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
