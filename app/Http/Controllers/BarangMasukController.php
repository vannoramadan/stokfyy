<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangMasuk;
use App\Models\ActivityLog;

class BarangMasukController extends Controller
{
    public function index()
    {
        $barangMasuk = BarangMasuk::latest()->get();
        return view('barang_masuk.index', compact('barangMasuk'));
    }

    public function create()
    {
        return view('barang_masuk.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'tanggal_masuk' => 'required|date',
        ]);

        $barang = BarangMasuk::create([
            'nama_barang' => $request->nama_barang,
            'jumlah' => $request->jumlah,
            'tanggal_masuk' => $request->tanggal_masuk,
        ]);

        ActivityLog::create([
            'activity' => 'barang masuk: ' . $request->nama_barang,
            'type' => 'masuk',
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('barang-masuk.index')->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $barangMasuk = \App\Models\BarangMasuk::findOrFail($id);
        return view('barang_masuk.edit', compact('barangMasuk'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'tanggal_masuk' => 'required|date',
        ]);

        $barang = BarangMasuk::findOrFail($id);
        $barang->update([
            'nama_barang' => $request->nama_barang,
            'jumlah' => $request->jumlah,
            'tanggal_masuk' => $request->tanggal_masuk,
        ]);

        ActivityLog::create([
            'activity' => 'Barang masuk diupdate: ' . $request->nama_barang,
            'type' => 'masuk',
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('barang-masuk.index')->with('success', 'Data berhasil diupdate.');
    }

    public function destroy($id)
    {
        $barang = BarangMasuk::findOrFail($id);
        $namaBarang = $barang->nama_barang;
        $barang->delete();

        ActivityLog::create([
            'activity' => 'Barang masuk dihapus: ' . $namaBarang,
            'type' => 'masuk',
            'user_id' => auth()->id(),
        ]);

        return back()->with('success', 'Data berhasil dihapus.');
    }
}
