<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Category;
use App\Models\Attribute;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $category = Category::firstOrCreate(['name' => $row['category']]);
            
            $product = Product::create([
                'name' => $row['name'],
                'category_id' => $category->id,
                'price' => $row['price'],
                'stock' => $row['stock'],
                'description' => $row['description'],
                'status' => strtolower($row['status']) === 'active',
            ]);

            if (!empty($row['attributes'])) {
                $attributes = [];
                $pairs = explode('|', $row['attributes']);
                foreach ($pairs as $pair) {
                    list($attrName, $value) = explode(':', $pair);
                    $attribute = Attribute::firstOrCreate(['name' => trim($attrName)]);
                    $attributes[$attribute->id] = ['value' => trim($value)];
                }
                $product->attributes()->sync($attributes);
            }
        }
    }
}