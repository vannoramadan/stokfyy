@extends('layouts.app')

@section('content')
<div class="card filter-card mb-4">
    <div class="card-body">
        <form action="{{ route('public.reports.activities') }}" method="GET">
            <div class="row">
                <div class="col-md-4">
                    <label class="form-label">User</label>
                    <select name="user_id" class="form-select">
                        <option value="">Semua User</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Tanggal</label>
                    <input type="date" name="date" value="{{ request('date') }}" class="form-control">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">Filter</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <h4>Laporan Aktivitas Sistem</h4>
        <p class="mb-0">Data aktual pengguna sistem</p>
    </div>
    <div class="card-body">
        @if($isEmpty)
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> Belum ada aktivitas yang tercatat.
                @auth
                    Lakukan beberapa aksi di sistem untuk melihat log aktivitas.
                @endauth
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Waktu</th>
                            <th>User</th>
                            <th>Aktivitas</th>
                            <th>Deskripsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($activities as $activity)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $activity->created_at->format('d/m/Y H:i') }}</td>
                            <td class="text-center">
                                <span class="badge rounded-pill bg-{{ $user->status ? 'success' : 'secondary' }}">
                                    <i class="fas fa-{{ $user->status ? 'check' : 'times' }} me-1"></i>
                                    {{ $user->status ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td>{{ ucfirst($activity->log_name) }}</td>
                            <td>{{ $activity->description }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $activities->links() }}
            </div>
        @endif
    </div>
</div>
<a href="{{ route('public.reports.stocks') }}" class="btn btn-outline-secondary me-md-2">
                                <i class="bi bi-arrow-left me-1"></i> Kembali
</a>
@endsection
