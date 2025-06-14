<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\StockAdjustmen;
use App\Models\StockTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    public function index()
    {
        $products = Product::with('category')
            ->orderBy('stock', 'asc')
            ->paginate(10);

        return view('stoks.index', compact('products'));
    }

    public function history(Request $request)
    {
        $transactions = StockTransaction::with(['product', 'user'])
            ->when($request->type, function($query) use ($request) {
                return $query->where('type', $request->type);
            })
            ->when($request->date_from, function($query) use ($request) {
                return $query->where('created_at', '>=', $request->date_from);
            })
            ->when($request->date_to, function($query) use ($request) {
                return $query->where('created_at', '<=', $request->date_to . ' 23:59:59');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('stoks.history', compact('transactions'));
    }

    public function opname()
    {
        $products = Product::orderBy('name')->get();
        return view('stoks.opname', compact('products'));
    }

    public function processOpname(Request $request)
    {
        $request->validate([
            'product_id' => 'required|array',
            'actual_stock' => 'required|array',
        ]);

        DB::beginTransaction();
        try {
            foreach ($request->product_id as $key => $productId) {
                $product = Product::findOrFail($productId);
                $actualStock = (int)$request->actual_stock[$key];

                if ($product->stock != $actualStock) {
                    // Catat penyesuaian stok
                    StockAdjustmen::create([
                        'product_id' => $productId,
                        'before_stock' => $product->stock,
                        'after_stock' => $actualStock,
                        'adjustment' => $actualStock - $product->stock,
                        'reason' => 'Stock Opname',
                        'user_id' => auth()->id()
                    ]);

                    // Update stok produk
                    $product->update(['stock' => $actualStock]);

                    // Catat transaksi
                    $type = $actualStock > $product->stock ? 'in' : 'out';
                    StockTransaction::create([
                        'product_id' => $productId,
                        'type' => $type,
                        'quantity' => abs($actualStock - $product->stock),
                        'description' => 'Stock Opname Adjustment',
                        'user_id' => auth()->id()
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('stoks.index')->with('success', 'Stock opname berhasil diproses');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function updateMinimumStock(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'min_stock' => 'required|integer|min:0'
        ]);

        $product = Product::find($request->product_id);
        $product->update(['min_stock' => $request->min_stock]);

        return back()->with('success', 'Stok minimum berhasil diperbarui');
    }

    public function adjustStock(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'adjustment_type' => 'required|in:in,out',
            'quantity' => 'required|integer|min:1',
            'reason' => 'required|string|max:255'
        ]);

        DB::beginTransaction();
        try {
            $product = Product::find($request->product_id);
            $newStock = $request->adjustment_type === 'in' 
                ? $product->stock + $request->quantity
                : $product->stock - $request->quantity;

            // Catat penyesuaian
            StockAdjustmen::create([
                'product_id' => $product->id,
                'before_stock' => $product->stock,
                'after_stock' => $newStock,
                'adjustment' => $request->adjustment_type === 'in' ? $request->quantity : -$request->quantity,
                'reason' => $request->reason,
                'user_id' => auth()->id()
            ]);

            // Update stok
            $product->update(['stock' => $newStock]);

            // Catat transaksi
            StockTransaction::create([
                'product_id' => $product->id,
                'type' => $request->adjustment_type,
                'quantity' => $request->quantity,
                'description' => $request->reason,
                'user_id' => auth()->id()
            ]);

            DB::commit();
            return back()->with('success', 'Stok berhasil disesuaikan');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

}
