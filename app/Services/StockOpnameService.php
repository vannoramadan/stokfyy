<?php

namespace App\Services;

use App\Models\StockOpname;

class StockOpnameService
{
    public function getAll()
    {
        return StockOpname::with(['product', 'user'])->latest()->get();
    }

    public function findById($id)
    {
        return StockOpname::findOrFail($id);
    }

    public function create(array $data)
    {
        return StockOpname::create($data);
    }
    public function store(array $data)
    {
        return StockOpname::create($data);
    }
}
