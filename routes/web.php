<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;

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
        case 'staff': // pakai 'staff' konsisten
            return redirect('/staff/dashboard');
        default:
            abort(403, 'Role tidak dikenali.');
    }
})->middleware('auth');

// Dashboard khusus per role
Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('dashboard.admin');
    });

    Route::get('/manajer/dashboard', function () {
        return view('dashboard.manajer');
    });

    Route::get('/staff/dashboard', function () {
        return view('dashboard.staff');
    });
});
