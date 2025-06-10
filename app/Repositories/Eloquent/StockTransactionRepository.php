<?php

namespace App\Repositories\Eloquent;

use App\Models\StockTransaction;
use App\Models\Product;
use App\Repositories\Interfaces\StockTransactionRepositoryInterface;
use Carbon\Carbon;

class StockTransactionRepository implements StockTransactionRepositoryInterface
{
    public function getAll()
    {
        return StockTransaction::with(['product', 'supplier'])->latest()->get();
    }

    public function findById($id)
    {
        return StockTransaction::with(['product', 'supplier'])->findOrFail($id);
    }
    public function getStockReport($startDate, $endDate)
    {
        return Product::with('category')
        ->withCount([
            'stockTransactions as total_incoming' => function ($query) use ($startDate, $endDate) {
                $query->where('type', 'masuk')
                ->whereBetween('created_at', [$startDate, $endDate]);
            },
            'stockTransactions as total_outgoing' => function ($query) use ($startDate, $endDate) {
                $query->where('type', 'keluar')
                ->whereBetween('created_at', [$startDate, $endDate]);
            }
        ])
            ->get();
    }


    public function create(array $data)
    {
        return StockTransaction::create($data);
    }

    public function update($id, array $data)
    {
        $transaction = $this->findById($id);
        $transaction->update($data);
        return $transaction;
    }

    public function delete($id)
    {
        return StockTransaction::destroy($id);
    }

    public function countTodayIncoming()
    {
        return StockTransaction::whereDate('date', now())->where('type', 'in')->count();
    }

    public function countTodayOutgoing()
    {
        return StockTransaction::whereDate('date', now())->where('type', 'out')->count();
    }


    public function countIncomingToday()
    {
        return StockTransaction::where('type', 'in') // atau 'masuk' jika itu yang benar
            ->whereDate('created_at', Carbon::today())
            ->count();
    }



    public function countOutgoingToday()
    {
        return StockTransaction::where('type', 'out')
        ->whereDate('created_at', Carbon::today())
            ->count();
    }



    public function getRecentIncoming($limit = 5)
    {
        return StockTransaction::with('product')
        ->where('type', 'in')
        ->latest()
            ->take($limit)
            ->get();
    }
    public function getRecentOutgoing($limit = 5)
    {
        return StockTransaction::with('product')
            ->where('type', 'out')
            ->latest()
            ->take($limit)
            ->get();
    }

}
