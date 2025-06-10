<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\DashboardController as StaffDashboardController;
use App\Http\Controllers\Manager\DashboardController as ManagerDashboardController;
use App\Http\Controllers\Manager\CategoryController;
use App\Http\Controllers\Manager\ProductController;
use App\Http\Controllers\Manager\StockTransactionController;
use App\Http\Controllers\Manager\StockOpnameController;
use App\Http\Controllers\Manager\SupplierController;
use App\Http\Controllers\Manager\ReportController;



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


Route::prefix('manager')->name('manager.')->group(function () {
    Route::get('/dashboard', [ManagerDashboardController::class, 'index'])->name('dashboard'); // untuk manager

    // hasilnya: manager.dashboard ✅

    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('stock', StockTransactionController::class);

    Route::get('opname', [StockOpnameController::class, 'index'])->name('opname.index');
    Route::post('opname', [StockOpnameController::class, 'store'])->name('opname.store');

    Route::resource('suppliers', SupplierController::class);

    Route::get('reports', [ReportController::class, 'index'])->name('reports.index'); // <- Ini penting

    Route::get('report/stock', [ReportController::class, 'stockReport'])->name('report.stock');
    Route::get('report/transaction', [ReportController::class, 'transactionReport'])->name('report.transaction');
});

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
        Route::get('/staff/dashboard', [StaffDashboardController::class, 'index']); // untuk staff
// ⬅ diubah dari view ke controller
        Route::resource('/barang-masuk', BarangMasukController::class);
        Route::resource('/barang-keluar', BarangKeluarController::class);
        Route::get('/staff/cek-stok', [StokController::class, 'form'])->name('staff.cek-stok.form');
        Route::post('/staff/cek-stok', [StokController::class, 'cekStok'])->name('staff.cek-stok.result');

    });
});


// Jika ada controller lain juga tambahkan:
// ...dan lainnya

