<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Services\StockOpnameService;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\StockOpname;

class StockOpnameController extends Controller
{
    protected $opnameService;

    public function __construct(StockOpnameService $opnameService)
    {
        $this->opnameService = $opnameService;
    }

    public function index()
    {
        $products = Product::all();
        $opnames = StockOpname::with('product')->latest()->get();

        return view('manager.opname.index', compact('products', 'opnames'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'system_stock' => 'required|integer|min:0',
            'physical_stock' => 'required|integer|min:0',
            'note' => 'nullable|string',
            // kamu bisa juga tambahkan 'opname_date' => 'nullable|date' jika ingin input manual
        ]);

        $this->opnameService->store($validated);

        return back()->with('success', 'Stock opname berhasil dicatat');
    }

}
