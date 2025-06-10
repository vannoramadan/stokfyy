<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Services\StockTransactionService;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;

class StockTransactionController extends Controller
{
    protected $stockTransactionService;

    public function __construct(StockTransactionService $stockTransactionService)
    {
        $this->stockTransactionService = $stockTransactionService;
    }

    // Tampilkan daftar transaksi
    public function index()
    {
        $transactions = $this->stockTransactionService->getAllTransactions();
        return view('manager.stock.index', compact('transactions'));
    }

    // Form tambah transaksi
    public function create()
    {
        $products = Product::all();
        $suppliers = Supplier::all();
        return view('manager.stock.create', compact('products', 'suppliers'));
    }

    // Simpan transaksi baru
    public function store(Request $request)
    {
        $this->stockTransactionService->createTransaction($request->all());
        return redirect()->route('manager.stock.index')->with('success', 'Transaksi berhasil ditambahkan');
    }

    // Form edit transaksi
    public function edit($id)
    {
        $transaction = $this->stockTransactionService->getById($id);
        $products = Product::all();
        $suppliers = Supplier::all();
        return view('manager.stock.edit', compact('transaction', 'products', 'suppliers'));
    }

    // Update transaksi
    public function update(Request $request, $id)
    {
        $this->stockTransactionService->update($id, $request->all());
        return redirect()->route('manager.stock.index')->with('success', 'Transaksi berhasil diperbarui.');
    }

    // Hapus transaksi
    public function destroy($id)
    {
        $this->stockTransactionService->delete($id);
        return redirect()->route('manager.stock.index')->with('success', 'Transaksi berhasil dihapus.');
    }
}
