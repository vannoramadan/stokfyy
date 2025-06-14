<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $periodeAwal = $request->query('start', now()->startOfMonth());
        $periodeAkhir = $request->query('end', now()->endOfMonth());

        $jumlahProduk = Product::count();
        $jumlahTransaksiMasuk = Transaction::where('type', 'masuk')
            ->whereBetween('created_at', [$periodeAwal, $periodeAkhir])->count();
        $jumlahTransaksiKeluar = Transaction::where('type', 'keluar')
            ->whereBetween('created_at', [$periodeAwal, $periodeAkhir])->count();

        $dataStok = Product::select('name', 'stock')->get();

        $aktivitasPengguna = User::latest()->take(5)->get();
        $userCount = User::count();
        $supplierCount = Supplier::count();

        $stokMasuk = Transaction::select('product_id', DB::raw('SUM(quantity) as total'))
    ->where('type', 'masuk')
    ->groupBy('product_id')
    ->with('product')
    ->get();

$stokKeluar = Transaction::select('product_id', DB::raw('SUM(quantity) as total'))
    ->where('type', 'keluar')
    ->groupBy('product_id')
    ->with('product')
    ->get();

        return view('admin.dashboard', compact(
            'jumlahProduk',
            'jumlahTransaksiMasuk',
            'jumlahTransaksiKeluar',
            'dataStok',
            'aktivitasPengguna',
            'periodeAwal',
            'periodeAkhir',
            'userCount', 
            'supplierCount',
            'stokMasuk',
            'stokKeluar',
        ));
    }
}
