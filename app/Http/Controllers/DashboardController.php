<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlahBarangMasuk = BarangMasuk::count();
        $jumlahBarangKeluar = BarangKeluar::count();
        $aktivitas = collect([
            [
                'judul' => 'Barang masuk baru',
                'waktu' => now()->subMinutes(5)->diffForHumans(),
                'status' => 'Baru'
            ],
            [
                'judul' => 'Pengiriman barang keluar',
                'waktu' => now()->subHours(1)->diffForHumans(),
                'status' => 'Selesai'
            ],
            [
                'judul' => 'Stok hampir habis',
                'waktu' => now()->subHours(3)->diffForHumans(),
                'status' => 'Peringatan'
            ]
        ]);

        // Simulasi stok hampir habis berdasarkan jumlah di BarangMasuk
        $barangHampirHabis = BarangMasuk::where('jumlah', '<=', 5)->get();

        return view('dashboard.staff', compact(
            'jumlahBarangMasuk',
            'jumlahBarangKeluar',
            'aktivitas',
            'barangHampirHabis'
        ));
    }
}
