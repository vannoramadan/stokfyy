<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductExport implements FromCollection, WithHeadings
{
    protected $isTemplate;

    public function __construct($isTemplate = false)
    {
        $this->isTemplate = $isTemplate;
    }

    public function collection()
    {
        if ($this->isTemplate) {
            return collect([]);
        }

        return Product::all()->map(function($product) {
            return [
                'name' => $product->name,
                'category' => $product->category->name,
                'price' => $product->price,
                'stock' => $product->stock,
                'description' => $product->description,
                'status' => $product->status ? 'Active' : 'Inactive',
                'attributes' => $product->attributes->map(function($attr) {
                    return $attr->name . ':' . $attr->pivot->value;
                })->implode('|'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Name',
            'Category',
            'Price',
            'Stock',
            'Description',
            'Status',
            'Attributes (format: attribute1:value1|attribute2:value2)',
        ];
    }
}