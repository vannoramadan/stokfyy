@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="fas fa-users me-2"></i>Manajemen Pengguna</h4>
            <a href="{{ route('users.create') }}" class="btn btn-light">
                <i class="fas fa-plus me-1"></i> Tambah Pengguna
            </a>
        </div>

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th width="10%">Foto</th>
                            <th width="25%">Nama Lengkap</th>
                            <th width="25%">Email</th>
                            <th width="15%" class="text-center">Status</th>
                            <th width="15%">Tanggal Dibuat</th>
                            <th width="20%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                        <tr>
                        <td class="text-center">
                                <img src="{{ $user->image ? asset('storage/' . $user->image) : 'https://via.placeholder.com/50?text=User' }}"
                                 alt="{{ $user->name }}"
                                 class="rounded-circle"
                                 width="50"
                                 height="50"
                                 style="object-fit: cover;"
                                 onerror="this.src='https://via.placeholder.com/50?text=User'">
                        </td>

                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td class="text-center">
                                <span class="badge rounded-pill bg-{{ $user->status ? 'success' : 'secondary' }}">
                                    <i class="fas fa-{{ $user->status ? 'check' : 'times' }} me-1"></i>
                                    {{ $user->status ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td>{{ $user->created_at->isoFormat('D MMMM Y') }}</td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                    <a href="#" class="btn btn-sm btn-info" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                <i class="fas fa-user-slash fa-2x mb-3"></i>
                                <p>Tidak ada data pengguna</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($users->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="text-muted">
                    Menampilkan <strong>{{ $users->firstItem() }}</strong> sampai <strong>{{ $users->lastItem() }}</strong> dari <strong>{{ $users->total() }}</strong> pengguna
                </div>
                <nav>
                    {{ $users->links('pagination::bootstrap-5') }}
                </nav>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('css')
<style>
    .table th {
        font-weight: 600;
    }
    .btn-group .btn {
        padding: 0.25rem 0.5rem;
    }
    .badge {
        padding: 0.35em 0.65em;
        font-size: 0.85em;
    }
</style>
@endsection