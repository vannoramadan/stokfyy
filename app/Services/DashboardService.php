<?php

namespace App\Services;

use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Repositories\Interfaces\StockTransactionRepositoryInterface;

class DashboardService
{
    protected $productRepo;
    protected $stockRepo;

    public function __construct(
        ProductRepositoryInterface $productRepo,
        StockTransactionRepositoryInterface $stockRepo
    ) {
        $this->productRepo = $productRepo;
        $this->stockRepo = $stockRepo;
    }

    public function getTotalProducts()
    {
        return $this->productRepo->countAll();
    }

    public function getLowStockCount()
    {
        return $this->productRepo->countLowStock();
    }

    public function getLowStockProducts()
    {
        return $this->productRepo->getLowStockProducts();
    }

    public function getIncomingToday()
    {
        return $this->stockRepo->countIncomingToday();
    }

    public function getOutgoingToday()
    {
        return $this->stockRepo->countOutgoingToday();
    }

    public function getRecentIncomingTransactions()
    {
        return $this->stockRepo->getRecentIncoming();
    }

    public function getRecentOutgoingTransactions()
    {
        return $this->stockRepo->getRecentOutgoing();
    }
}
