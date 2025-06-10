<?php

namespace App\Repositories\Interfaces;


interface ProductRepositoryInterface
{
    public function getAll();
    public function findById($id);
    public function countAll();
    public function getLowStockProducts($threshold = 10);
    public function countLowStock($threshold = 10);

    // Tambahkan method CRUD
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);

}
