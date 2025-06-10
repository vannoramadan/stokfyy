<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\Interfaces\StockTransactionRepositoryInterface;

class ReportService
{
    protected $stockRepo;

    public function __construct(StockTransactionRepositoryInterface $stockRepo)
    {
        $this->stockRepo = $stockRepo;
    }

    public function getStockReport($startDate, $endDate)
    {
        $products = Product::with('category')->get();

        $report = $products->map(function ($product) use ($startDate, $endDate) {
            $totalIn = $product->stockTransactions()
                ->where('type', 'in')
                ->whereBetween('transaction_date', [$startDate, $endDate])
                ->sum('quantity');

            $totalOut = $product->stockTransactions()
                ->where('type', 'out')
                ->whereBetween('transaction_date', [$startDate, $endDate])
                ->sum('quantity');

            // Asumsikan $product->stock adalah stok awal produk yg tersimpan di database
            $stokAwal = $product->stock ?? 0;

            // Hitung stok sekarang dengan menambah stok awal + total in - total out
            $stokSekarang = $stokAwal + $totalIn - $totalOut;

            return (object) [
                'name' => $product->name,
                'category' => $product->category,
                'stock' => $stokSekarang,
                'total_incoming' => $totalIn,
                'total_outgoing' => $totalOut,
            ];
        });

        return $report;
    }

    public function getTransactionReport(array $filters = [])
    {
        $startDate = $filters['start_date'] ?? '2000-01-01';
        $endDate = $filters['end_date'] ?? now()->toDateString();

        $products = Product::with('category')->get();

        $products = $products->map(function ($product) use ($startDate, $endDate) {
            $totalIn = $product->stockTransactions()
                ->where('type', 'in')
                ->whereBetween('transaction_date', [$startDate, $endDate])
                ->sum('quantity');

            $totalOut = $product->stockTransactions()
                ->where('type', 'out')
                ->whereBetween('transaction_date', [$startDate, $endDate])
                ->sum('quantity');

            $stokMasuk = $product->stockTransactions()->where('type', 'in')->sum('quantity');
            $stokKeluar = $product->stockTransactions()->where('type', 'out')->sum('quantity');
            $stokSekarang = $stokMasuk - $stokKeluar;

            $product->total_incoming = $totalIn;
            $product->total_outgoing = $totalOut;
            $product->stock = $stokSekarang;

            return $product;
        });

        return $products;
    }
}
