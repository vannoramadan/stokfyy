<?php

namespace App\Services;

use App\Repositories\Interfaces\StockTransactionRepositoryInterface;
use App\Models\StockTransaction;

class StockTransactionService
{
    protected $stockTransactionRepository; // ✅ Tambahkan properti ini

    public function __construct(StockTransactionRepositoryInterface $stockTransactionRepository)
    {
        $this->stockTransactionRepository = $stockTransactionRepository;
    }

    public function getAllTransactions()
    {
        return $this->stockTransactionRepository->getAll();
    }

    public function getById($id)
    {
        return $this->stockTransactionRepository->findById($id);
    }

    public function createTransaction(array $data)
    {
        return $this->stockTransactionRepository->create($data);
    }

    public function update($id, array $data)
    {
        return $this->stockTransactionRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->stockTransactionRepository->delete($id);
    }
}
