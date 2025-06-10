<?php

namespace App\Repositories\Eloquent;

use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    protected $model;

    public function __construct(Product $product)
    {
        $this->model = $product;
    }

    public function getAll()
    {
        return $this->model->with('category')->latest()->get();
    }

    public function findById($id)
    {
        return $this->model->with('category')->findOrFail($id);
    }

    public function countAll()
    {
        return Product::count();
    }


    public function getLowStockProducts($threshold = 10)
    {
        return $this->model->where('stock', '<', $threshold)->get();
    }

    public function countLowStock($threshold = 10)
    {
        return $this->model->where('stock', '<=', $threshold)->count();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }


    // ProductRepository.php
    public function update($id, array $data)
    {
        $product = Product::findOrFail($id);
        $product->update($data);
        return $product;
    }


    public function delete($id)
    {
        $product = Product::findOrFail($id);
        return $product->delete();
    }

}
