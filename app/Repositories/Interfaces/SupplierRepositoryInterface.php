<?php

namespace App\Repositories\Interfaces;

interface SupplierRepositoryInterface
{
    public function getAll();
    public function findById($id);
}
