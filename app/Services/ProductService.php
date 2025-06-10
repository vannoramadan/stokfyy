<?php

namespace App\Services;

use App\Repositories\Interfaces\ProductRepositoryInterface;

class ProductService
{
    protected $productRepo;

    public function __construct(ProductRepositoryInterface $productRepo)
    {
        $this->productRepo = $productRepo;
    }

    public function getAllProducts()
    {
        return $this->productRepo->getAll();
    }

    public function getProductById($id)
    {
        return $this->productRepo->findById($id);
    }

    public function createProduct(array $data)
    {
        return $this->productRepo->create($data); // FIXED
    }

    public function updateProduct($id, array $data)
    {
        return $this->productRepo->update($id, $data); // FIXED
    }

    public function deleteProduct($id)
    {
        return $this->productRepo->delete($id); // FIXED
    }
}
