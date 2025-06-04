<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use App\Models\ActivityLog;
use App\Models\Barang;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung total transaksi barang masuk dan keluar
        $jumlahBarangMasuk = BarangMasuk::count();
        $jumlahBarangKeluar = BarangKeluar::count();

        // Ambil 10 aktivitas terbaru
        $aktivitas = ActivityLog::latest()->take(10)->get()->map(function ($log) {
            return [
                'judul' => $log->activity ?? 'Aktivitas Tidak Diketahui',
                'status' => ucfirst($log->type ?? 'info'),
                'waktu' => Carbon::parse($log->created_at)->diffForHumans(),
            ];
        });

        // Ambil barang dengan stok rendah (≤ 5)
        $stokMinimal = 5;
        $barangHampirHabis = Barang::where('jumlah', '<=', $stokMinimal)->get();

        // Kirim data ke view
        return view('dashboard.staff', [
            'jumlahBarangMasuk' => $jumlahBarangMasuk,
            'jumlahBarangKeluar' => $jumlahBarangKeluar,
            'aktivitas' => $aktivitas,
            'barangHampirHabis' => $barangHampirHabis,
        ]);
    }
}
