<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;

class StokController extends Controller
{
    // Menampilkan halaman form pencarian stok
    public function form()
    {
        // default tampilan tanpa pencarian
        return view('dashboard.cek_stok', [
            'sisaStok' => null,
            'nama_barang' => null,
        ]);
    }

    // Menangani form pencarian dan menampilkan hasil
    public function cekStok(Request $request)
    {
        $nama_barang = $request->input('nama_barang');
        $sisaStok = null;

        if (!empty($nama_barang)) {
            $totalMasuk = BarangMasuk::where('nama_barang', $nama_barang)->sum('jumlah');
            $totalKeluar = BarangKeluar::where('nama_barang', $nama_barang)->sum('jumlah');
            $sisaStok = $totalMasuk - $totalKeluar;
        }

        return view('dashboard.cek_stok', [
            'sisaStok' => $sisaStok,
            'nama_barang' => $nama_barang,
        ]);
    }
}
