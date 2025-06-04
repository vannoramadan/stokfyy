<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StokController;


// Login & Logout
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Redirect otomatis setelah login berdasarkan role
Route::get('/dashboard', function () {
    $user = Auth::user();

    switch ($user->role) {
        case 'admin':
            return redirect('/admin/dashboard');
        case 'manajer':
            return redirect('/manajer/dashboard');
        case 'staff':
            return redirect('/staff/dashboard');
        default:
            abort(403, 'Role tidak dikenali.');
    }
})->middleware('auth');

// Route khusus berdasarkan role
Route::middleware('auth')->group(function () {

    // Admin
    Route::get('/admin/dashboard', function () {
        return view('dashboard.admin');
    });

    // Manajer
    Route::get('/manajer/dashboard', function () {
        return view('dashboard.manajer');
    });

    // Staf Gudang
    Route::prefix('staff')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index']); // ⬅ diubah dari view ke controller
        Route::resource('/barang-masuk', BarangMasukController::class);
        Route::resource('/barang-keluar', BarangKeluarController::class);
        Route::get('/staff/cek-stok', [StokController::class, 'form'])->name('staff.cek-stok.form');
        Route::post('/staff/cek-stok', [StokController::class, 'cekStok'])->name('staff.cek-stok.result');

    });
});
