<?php

namespace App\Repositories\Eloquent;

use App\Models\Product;
use App\Models\StockTransaction;
use App\Repositories\Interfaces\ReportRepositoryInterface;

class ReportRepository implements ReportRepositoryInterface
{
    public function getStockReport(array $filters)
    {
        $query = Product::with('category');

        if (isset($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        return $query->get();
    }

    public function getIncomingReport(array $filters)
    {
        return $this->filterTransactions('in', $filters);
    }

    public function getOutgoingReport(array $filters)
    {
        return $this->filterTransactions('out', $filters);
    }

    private function filterTransactions($type, $filters)
    {
        $query = StockTransaction::with(['product', 'supplier'])->where('type', $type);

        if (isset($filters['start_date']) && isset($filters['end_date'])) {
            $query->whereBetween('transaction_date', [$filters['start_date'], $filters['end_date']]);
        }

        return $query->get();
    }
}
