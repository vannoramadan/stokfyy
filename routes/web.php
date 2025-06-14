<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\AttributeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\DashboardController as StaffDashboardController;
use App\Http\Controllers\Manager\DashboardController as ManagerDashboardController;
use App\Http\Controllers\Manager\CategoryController as ManagerCategoryController;
use App\Http\Controllers\Manager\ProductController as ManagerProductController;
use App\Http\Controllers\Manager\StockTransactionController;
use App\Http\Controllers\Manager\StockOpnameController;
use App\Http\Controllers\Manager\SupplierController as ManagerSupplierController;
use App\Http\Controllers\Manager\ReportController as ManagerReportController;

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

// Middleware Auth
Route::middleware('auth')->group(function () {
    // Admin
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::resource('users', PenggunaController::class);
    Route::resource('suppliers', SupplierController::class);

    Route::prefix('products')->name('products.')->group(function() {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/', [ProductController::class, 'store'])->name('store');
        Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('edit');
        Route::put('/{product}', [ProductController::class, 'update'])->name('update');
        Route::delete('/{product}', [ProductController::class, 'destroy'])->name('destroy');

        Route::get('/export', [ProductController::class, 'export'])->name('export');
        Route::get('/export-template', [ProductController::class, 'exportTemplate'])->name('export-template');
        Route::post('/import', [ProductController::class, 'import'])->name('import');
        Route::get('/export-pdf', [ProductController::class, 'exportPDF'])->name('export.pdf');
    });

    Route::prefix('categories')->name('categories.')->group(function() {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::get('/create', [CategoryController::class, 'create'])->name('create');
        Route::post('/', [CategoryController::class, 'store'])->name('store');
        Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('edit');
        Route::put('/{category}', [CategoryController::class, 'update'])->name('update');
        Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('attributes')->name('attributes.')->group(function() {
        Route::get('/', [AttributeController::class, 'index'])->name('index');
        Route::get('/create', [AttributeController::class, 'create'])->name('create');
        Route::post('/', [AttributeController::class, 'store'])->name('store');
        Route::get('/{attribute}/edit', [AttributeController::class, 'edit'])->name('edit');
        Route::put('/{attribute}', [AttributeController::class, 'update'])->name('update');
        Route::delete('/{attribute}', [AttributeController::class, 'destroy'])->name('destroy');
    });

    Route::get('/stoks', [StockController::class, 'index'])->name('stoks.index');
    Route::get('/stoks/history', [StockController::class, 'history'])->name('stoks.history');
    Route::get('/stoks/opname', [StockController::class, 'opname'])->name('stocks.opname');
    Route::post('/stoks/opname', [StockController::class, 'processOpname'])->name('stocks.processOpname');
    Route::post('/stoks/update-minimum', [StockController::class, 'updateMinimumStock'])->name('stocks.update-minimum');
    Route::post('/stoks/adjust', [StockController::class, 'adjustStock'])->name('stocks.adjust');

    // Public Report Routes
    Route::prefix('reports')->group(function () {
        Route::get('/stocks', [ReportController::class, 'stockReport'])->name('public.reports.stocks');
        Route::get('/transations', [ReportController::class, 'transactionReport'])->name('public.reports.transations');
        Route::get('/user-activities', [ReportController::class, 'userActivityReport'])->name('public.reports.activities');
        Route::get('/download/{type}', [ReportController::class, 'downloadReport'])->name('public.reports.download');
    });

    Route::get('/reports/export/{type}', [ReportController::class, 'export'])->name('public.reports.export');

    // Manager Route
    Route::prefix('manager')->name('manager.')->group(function () {
        Route::get('/dashboard', [ManagerDashboardController::class, 'index'])->name('dashboard');

        Route::resource('categories', ManagerCategoryController::class);
        Route::resource('products', ManagerProductController::class);
        Route::resource('stock', StockTransactionController::class);

        Route::get('opname', [StockOpnameController::class, 'index'])->name('opname.index');
        Route::post('opname', [StockOpnameController::class, 'store'])->name('opname.store');

        Route::resource('suppliers', ManagerSupplierController::class);

        Route::get('reports', [ManagerReportController::class, 'index'])->name('reports.index');
        Route::get('report/stock', [ManagerReportController::class, 'stockReport'])->name('report.stock');
        Route::get('report/transaction', [ManagerReportController::class, 'transactionReport'])->name('report.transaction');
    });

    // Staff Route
    Route::prefix('staff')->group(function () {
        Route::get('/staff/dashboard', [StaffDashboardController::class, 'index']);

        Route::resource('/barang-masuk', BarangMasukController::class);
        Route::resource('/barang-keluar', BarangKeluarController::class);

        Route::get('/staff/cek-stok', [StokController::class, 'form'])->name('staff.cek-stok.form');
        Route::post('/staff/cek-stok', [StokController::class, 'cekStok'])->name('staff.cek-stok.result');
    });
});
