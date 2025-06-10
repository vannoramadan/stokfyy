<?php

namespace App\Services;

use App\Repositories\Interfaces\SupplierRepositoryInterface;

class SupplierService
{
    protected $supplierRepository;

    public function __construct(SupplierRepositoryInterface $supplierRepository)
    {
        $this->supplierRepository = $supplierRepository;
    }

    public function getAll()
    {
        return $this->supplierRepository->getAll();
    }

    public function getById($id)
    {
        return $this->supplierRepository->findById($id);
    }
}
