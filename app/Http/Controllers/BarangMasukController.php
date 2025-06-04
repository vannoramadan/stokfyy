<?php
namespace App\Http\Controllers;

use App\Models\BarangMasuk;
use Illuminate\Http\Request;

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

        BarangMasuk::create($request->all());

        return redirect()->route('barang-masuk.index')->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $barang = BarangMasuk::findOrFail($id);
        return view('barang_masuk.edit', compact('barang'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'tanggal_masuk' => 'required|date',
        ]);

        $barang = BarangMasuk::findOrFail($id);
        $barang->update($request->all());

        return redirect()->route('barang-masuk.index')->with('success', 'Data berhasil diupdate.');
    }

    public function destroy($id)
    {
        BarangMasuk::destroy($id);
        return back()->with('success', 'Data berhasil dihapus.');
    }
}
