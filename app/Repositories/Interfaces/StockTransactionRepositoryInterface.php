<?php

namespace App\Repositories\Interfaces;

interface StockTransactionRepositoryInterface
{
    public function getAll();
    public function findById($id);
    public function create(array $data);
    public function update($id, array $data); // ✅
    public function delete($id);              // ✅
    public function countTodayIncoming();
    public function countTodayOutgoing();
    public function countIncomingToday();
    public function countOutgoingToday();
    public function getRecentIncoming($limit = 5);
    public function getRecentOutgoing($limit = 5);

    public function getStockReport($startDate, $endDate);

}

